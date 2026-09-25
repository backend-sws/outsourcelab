<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Booking;
use App\Models\Coupon;
use App\Models\FamilyMember;
use App\Models\MembershipPlan;
use App\Models\Package;
use App\Models\Patient;
use App\Models\PatientCoupon;
use App\Models\PatientMembership;
use App\Models\Setting;
use App\Models\Test;
use App\Services\NotificationService;
use App\Services\PathologyApiService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PatientBookingController extends Controller
{
    /**
     * Display bookings made by the patient.
     */
    public function index(): View|RedirectResponse
    {
        $patientId = session('patient_id');
        if (! $patientId) {
            return redirect('/');
        }

        $profile = Patient::with(['bookings.agent', 'bookings.familyMember', 'bookings.address'])->find($patientId);
        if (! $profile) {
            return redirect('/');
        }

        return view('patient.pages.bookings', compact('profile'));
    }

    /**
     * Place a new booking with robust server-side price recalculation.
     */
    public function placeBooking(Request $request): JsonResponse
    {
        $patientId = session('patient_id');
        if (! $patientId) {
            return response()->json(['success' => false, 'message' => 'Not logged in'], 401);
        }

        $patient = Patient::find($patientId);
        if (! $patient) {
            return response()->json(['success' => false, 'message' => 'Patient account not found'], 404);
        }

        $rawCart = $request->input('cart', []);
        $paymentMethod = $request->input('payment_method', 'Cash');
        $collectionType = $request->input('collection_type', 'Home Collection');
        $bookingDate = $request->input('booking_date', now()->toDateTimeString());
        $collectionSlot = $request->input('collection_slot', null);
        $addressId = $request->input('address_id', null);
        $familyMemberId = $request->input('family_member_id', null);
        $couponCode = strtoupper(trim($request->input('coupon_code', '')));
        $membershipPlanId = $request->input('membership_plan_id', null);

        if (empty($rawCart) || ! is_array($rawCart)) {
            return response()->json(['success' => false, 'message' => 'Cart is empty'], 400);
        }

        // Server-side price recalculation to eliminate price tampering
        $sanitizedCart = [];
        $subtotal = 0;

        foreach ($rawCart as $item) {
            $type = $item['type'] ?? 'test';
            $id = $item['id'] ?? null;

            if (! $id) {
                continue;
            }

            if ($type === 'package') {
                $package = Package::find($id);
                if ($package && $package->is_active) {
                    $itemPrice = (float) $package->price;
                    $sanitizedCart[] = [
                        'id' => $package->id,
                        'name' => $package->name,
                        'title' => $package->name,
                        'type' => 'package',
                        'price' => $itemPrice,
                        'parameters_count' => is_array($package->parameters) ? count($package->parameters) : 0,
                    ];
                    $subtotal += $itemPrice;
                }
            } else {
                $test = Test::find($id);
                if ($test && $test->is_active) {
                    $itemPrice = (float) $test->price;
                    $sanitizedCart[] = [
                        'id' => $test->id,
                        'name' => $test->name,
                        'title' => $test->name,
                        'type' => 'test',
                        'price' => $itemPrice,
                        'sample_type' => $test->sample_type ?? null,
                    ];
                    $subtotal += $itemPrice;
                }
            }
        }

        if (empty($sanitizedCart)) {
            return response()->json(['success' => false, 'message' => 'None of the items in your cart are currently available.'], 400);
        }

        // Check if patient purchased a VIP Membership during checkout
        $purchasedPlan = null;
        if ($membershipPlanId) {
            $purchasedPlan = MembershipPlan::where('is_active', true)->find($membershipPlanId);
        }

        // Check if patient is already an active VIP
        $activeVip = $patient->activeMembership();
        $vipDiscountRate = 0;

        if ($purchasedPlan) {
            $vipDiscountRate = $purchasedPlan->discount_percentage;
        } elseif ($activeVip) {
            $vipDiscountRate = $activeVip->discount_percentage;
        }

        $vipDiscountAmount = 0;
        if ($vipDiscountRate > 0 && $subtotal > 0) {
            $vipDiscountAmount = round(($subtotal * $vipDiscountRate) / 100, 2);
        }

        $subtotalAfterVip = max(0, $subtotal - $vipDiscountAmount);

        // Server-side coupon verification and recalculation
        $discountAmount = 0;
        $appliedCoupon = null;

        if ($couponCode) {
            $coupon = Coupon::where('code', $couponCode)->where('is_active', true)->first();
            if ($coupon) {
                $isValidDates = (! $coupon->valid_from || now()->startOfDay()->gte($coupon->valid_from))
                    && (! $coupon->valid_until || now()->endOfDay()->lte($coupon->valid_until->endOfDay()));

                $timesUsed = PatientCoupon::where('patient_id', $patientId)
                    ->where('coupon_id', $coupon->id)
                    ->where('is_used', true)
                    ->count();
                $limit = $coupon->usage_limit_per_user ?? ($coupon->coupon_type === 'welcome' ? 1 : 1);
                $isWithinLimit = $timesUsed < $limit;
                $meetsMinSpend = ! ($coupon->min_order_amount > 0 && $subtotalAfterVip < $coupon->min_order_amount);

                if ($isValidDates && $isWithinLimit && $meetsMinSpend) {
                    $discountAmount = $coupon->calculateDiscount($subtotalAfterVip);
                    $appliedCoupon = $coupon;
                }
            }
        }

        $membershipPrice = $purchasedPlan ? (float) $purchasedPlan->price : 0;
        if ($purchasedPlan) {
            $sanitizedCart[] = [
                'id' => $purchasedPlan->id,
                'name' => $purchasedPlan->name.' ('.$purchasedPlan->formatted_duration.' VIP Pass)',
                'title' => $purchasedPlan->name,
                'type' => 'membership',
                'price' => $membershipPrice,
            ];
        }

        // Health Coins Redemption Validation
        $coinsToRedeemInput = max(0, (int) $request->input('coins_to_redeem', 0));
        $rewardEnabled = Setting::get('reward_enabled', '1') == '1';
        $coinValue = (float) Setting::get('reward_coin_value', '1.00');
        $earnType = Setting::get('reward_earn_type', 'percentage');
        $earnValue = (float) Setting::get('reward_earn_value', '5');
        $minOrderToEarn = (float) Setting::get('reward_min_order_to_earn', '100');
        $maxRedeemType = Setting::get('reward_max_redeem_type', 'percentage');
        $maxRedeemValue = (float) Setting::get('reward_max_redeem_value', '20');
        $minOrderToRedeem = (float) Setting::get('reward_min_order_to_redeem', '200');
        $minCoinsToRedeem = (int) Setting::get('reward_min_coins_to_redeem', '10');

        $coinsRedeemed = 0;
        $coinsDiscount = 0;

        if ($rewardEnabled && $coinsToRedeemInput > 0) {
            $patientBalance = (int) $patient->reward_coins;
            $meetsRedeemConditions = ($patientBalance >= $minCoinsToRedeem) && ($subtotalAfterVip >= $minOrderToRedeem);

            if ($meetsRedeemConditions) {
                $subtotalAfterCoupon = max(0, $subtotalAfterVip - $discountAmount);

                if ($maxRedeemType === 'percentage') {
                    $maxDiscountAllowed = ($subtotalAfterCoupon * $maxRedeemValue) / 100;
                    $maxCoinsAllowed = (int) floor($maxDiscountAllowed / $coinValue);
                } else {
                    $maxCoinsAllowed = (int) $maxRedeemValue;
                }

                $maxCoinsCap = min($patientBalance, $maxCoinsAllowed, (int) floor($subtotalAfterCoupon / $coinValue));
                $coinsRedeemed = min($coinsToRedeemInput, max(0, $maxCoinsCap));
                $coinsDiscount = round($coinsRedeemed * $coinValue, 2);
            }
        }

        $totalDiscount = $vipDiscountAmount + $discountAmount + $coinsDiscount;
        $finalAmount = max(0, $subtotal - $totalDiscount + $membershipPrice);

        // Calculate earned coins on this booking
        $coinsEarned = 0;
        if ($rewardEnabled && $finalAmount >= $minOrderToEarn) {
            if ($earnType === 'percentage') {
                $coinsEarned = (int) round(($finalAmount * $earnValue) / 100);
            } else {
                $coinsEarned = (int) round($earnValue);
            }
        }

        // Validate beneficiary / patient name (User cannot book without name)
        $beneficiaryName = null;
        if ($familyMemberId) {
            $member = FamilyMember::where('id', $familyMemberId)->where('patient_id', $patientId)->first();
            if (! $member) {
                $familyMemberId = null;
                $beneficiaryName = $patient->name;
            } else {
                $beneficiaryName = $member->name;
            }
        } else {
            $beneficiaryName = $patient->name;
        }

        if (empty(trim((string) $beneficiaryName)) || strtolower(trim((string) $beneficiaryName)) === 'self') {
            return response()->json([
                'success' => false,
                'message' => 'Patient name is required. Please provide a valid patient name before booking.',
            ], 422);
        }

        // Address verification and fallback
        if ($addressId) {
            $addressExists = Address::where('id', $addressId)->where('patient_id', $patientId)->exists();
            if (! $addressExists) {
                $addressId = null;
            }
        }
        if (! $addressId) {
            // Fallback to latest address if exists
            $addressId = Address::where('patient_id', $patientId)->latest()->value('id');
        }

        if (! $addressId) {
            return response()->json([
                'success' => false,
                'message' => 'Sample collection address is required. Please add or select an address before booking.',
            ], 422);
        }

        // Generate unique booking reference
        $ref = 'BK-'.strtoupper(substr(uniqid(), -6));

        $booking = Booking::create([
            'booking_reference' => $ref,
            'patient_id' => $patientId,
            'family_member_id' => $familyMemberId,
            'address_id' => $addressId,
            'test_details' => $sanitizedCart,
            'collection_type' => $collectionType,
            'collection_slot' => $collectionSlot,
            'amount' => $finalAmount,
            'coupon_code' => $appliedCoupon ? $appliedCoupon->code : ($vipDiscountAmount > 0 ? 'VIP-MEMBER' : null),
            'discount_amount' => $totalDiscount,
            'coins_redeemed' => $coinsRedeemed,
            'coins_discount' => $coinsDiscount,
            'coins_earned' => $coinsEarned,
            'payment_method' => $paymentMethod,
            'payment_status' => $paymentMethod === 'Cash' ? 'Pending' : 'Paid',
            'status' => 'Booked',
            'booking_date' => $bookingDate,
        ]);

        // Debit redeemed coins from patient
        if ($coinsRedeemed > 0) {
            $patient->debitCoins($coinsRedeemed, "Redeemed on booking #{$ref}", $booking->id, $coinsDiscount);
        }

        // Credit earned coins to patient
        if ($coinsEarned > 0) {
            $patient->creditCoins($coinsEarned, "Earned from booking #{$ref}", $booking->id, round($coinsEarned * $coinValue, 2));
        }

        // If VIP Membership was purchased, activate membership record
        if ($purchasedPlan) {
            PatientMembership::create([
                'patient_id' => $patientId,
                'membership_plan_id' => $purchasedPlan->id,
                'plan_name_snapshot' => $purchasedPlan->name,
                'discount_percentage' => $purchasedPlan->discount_percentage,
                'price_paid' => $purchasedPlan->price,
                'started_at' => now(),
                'expires_at' => now()->addMonths($purchasedPlan->duration_in_months),
                'status' => 'active',
                'booking_id' => $booking->id,
            ]);
        }

        // If coupon applied, record usage
        if ($appliedCoupon) {
            $userCoupon = PatientCoupon::firstOrCreate([
                'patient_id' => $patientId,
                'coupon_id' => $appliedCoupon->id,
            ]);
            $userCoupon->update([
                'is_used' => true,
                'used_at' => now(),
                'booking_id' => $booking->id,
            ]);
            $appliedCoupon->increment('usage_count');
        }

        // Clear patient cart in DB
        $patient->update(['cart' => []]);

        // Push order to Pathology SaaS LIS API
        try {
            $apiService = app(PathologyApiService::class);
            if ($apiService->isConfigured()) {
                $lisItems = [];
                foreach ($sanitizedCart as $cartItem) {
                    $itemType = $cartItem['type'] ?? 'test';
                    $localId = $cartItem['id'] ?? null;

                    if ($itemType === 'test') {
                        $testModel = Test::find($localId);
                        $targetId = $testModel?->lis_test_id ?: $localId;
                        $lisItems[] = ['type' => 'test', 'id' => (int) $targetId];
                    } elseif ($itemType === 'package') {
                        $pkgModel = Package::find($localId);
                        $targetId = $pkgModel?->lis_package_id ?: $localId;
                        $lisItems[] = ['type' => 'package', 'id' => (int) $targetId];
                    }
                }

                if (! empty($lisItems)) {
                    $targetAddress = $addressId ? Address::find($addressId) : null;
                    $targetMember = $familyMemberId ? FamilyMember::find($familyMemberId) : null;

                    $lisPayload = [
                        'patient_name' => $targetMember?->name ?: $patient->name,
                        'patient_phone' => $patient->mobile,
                        'patient_email' => $patient->email,
                        'patient_gender' => strtolower($targetMember?->gender ?: ($patient->gender ?: 'other')),
                        'patient_age' => (int) ($targetMember?->age ?: ($patient->age ?: 30)),
                        'patient_age_unit' => 'years',
                        'collection_type' => str_contains(strtolower($collectionType), 'home') ? 'home_collection' : 'lab_visit',
                        'collection_address' => $targetAddress?->full_address ?? 'Not provided',
                        'preferred_date' => date('Y-m-d', strtotime($bookingDate)),
                        'preferred_time_slot' => $collectionSlot ?: '08:00 AM - 10:00 AM',
                        'branch_id' => (int) config('pathology.default_branch_id', 1),
                        'notes' => "Website Order: #{$booking->booking_reference}",
                        'items' => $lisItems,
                    ];

                    $lisResult = $apiService->createBooking($lisPayload);
                    if ($lisResult && ! empty($lisResult['booking_reference'])) {
                        $booking->lis_booking_reference = $lisResult['booking_reference'];
                        $booking->lis_status = $lisResult['status'] ?? 'pending';
                        $booking->lis_synced_at = now();
                        $booking->save();
                    }
                }
            }
        } catch (\Throwable $lisErr) {
            Log::warning('Pathology LIS push failed for booking #'.$booking->id.': '.$lisErr->getMessage());
        }

        // Dispatch notification (Email, SMS, WhatsApp)
        try {
            app(NotificationService::class)->bookingPlaced($booking);
        } catch (\Throwable $e) {
            Log::warning('Booking placed notification failed: '.$e->getMessage());
        }

        return response()->json([
            'success' => true,
            'booking_id' => $booking->id,
            'booking_reference' => $booking->booking_reference,
            'final_amount' => $finalAmount,
            'coins_redeemed' => $coinsRedeemed,
            'coins_earned' => $coinsEarned,
        ]);
    }

    /**
     * Synchronize client cart items with the database.
     */
    /**
     * Get booking details and options for modification.
     */
    public function getBookingModifyData(int $id): JsonResponse
    {
        $patientId = session('patient_id');
        if (! $patientId) {
            return response()->json(['success' => false, 'message' => 'Please login to modify booking.'], 401);
        }

        $booking = Booking::with(['patient', 'familyMember', 'address'])
            ->where('id', $id)
            ->where('patient_id', $patientId)
            ->first();

        if (! $booking) {
            return response()->json(['success' => false, 'message' => 'Booking not found.'], 404);
        }

        $isModifiable = ! in_array($booking->status, ['Sample Collected', 'In Process', 'Processing', 'Report Ready', 'Completed', 'Cancelled'])
            && $booking->sample_status !== 'Sample Collected';

        if (! $isModifiable) {
            return response()->json([
                'success' => false,
                'message' => 'This booking cannot be modified because sample has already been collected or processed.',
            ], 422);
        }

        $patient = Patient::with(['addresses', 'familyMembers'])->find($patientId);

        $availableTests = Test::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'price', 'original_price', 'sample_type'])
            ->map(fn ($t) => [
                'id' => $t->id,
                'name' => $t->name,
                'price' => (float) $t->price,
                'original_price' => (float) ($t->original_price ?: $t->price),
                'type' => 'test',
            ]);

        $availablePackages = Package::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'price', 'original_price', 'sample_type'])
            ->map(fn ($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'price' => (float) $p->price,
                'original_price' => (float) ($p->original_price ?: $p->price),
                'type' => 'package',
            ]);

        $testDetails = is_array($booking->test_details) ? $booking->test_details : (json_decode($booking->test_details, true) ?: []);

        return response()->json([
            'success' => true,
            'is_paid' => $booking->payment_status === 'Paid',
            'is_modifiable' => $isModifiable,
            'booking' => [
                'id' => $booking->id,
                'reference' => $booking->booking_reference,
                'amount' => (float) $booking->amount,
                'payment_status' => $booking->payment_status,
                'payment_method' => $booking->payment_method,
                'status' => $booking->status,
                'booking_date' => $booking->booking_date ? $booking->booking_date->format('Y-m-d') : now()->format('Y-m-d'),
                'collection_slot' => $booking->collection_slot,
                'collection_type' => $booking->collection_type,
                'address_id' => $booking->address_id,
                'family_member_id' => $booking->family_member_id,
                'tests' => $testDetails,
            ],
            'addresses' => $patient ? $patient->addresses->map(fn ($a) => [
                'id' => $a->id,
                'title' => $a->title ?: 'Home',
                'full_address' => $a->full_address,
                'pincode' => $a->pincode,
            ]) : [],
            'family_members' => $patient ? $patient->familyMembers->map(fn ($m) => [
                'id' => $m->id,
                'name' => $m->name,
                'relation' => $m->relation,
            ]) : [],
            'patient_name' => $patient?->name ?? 'Self',
            'catalog' => [
                'tests' => $availableTests,
                'packages' => $availablePackages,
            ],
        ]);
    }

    /**
     * Submit modifications for a booking (tests, details, address).
     */
    public function modifyBooking(Request $request, int $id): JsonResponse
    {
        $patientId = session('patient_id');
        if (! $patientId) {
            return response()->json(['success' => false, 'message' => 'Please login.'], 401);
        }

        $booking = Booking::where('id', $id)->where('patient_id', $patientId)->first();
        if (! $booking) {
            return response()->json(['success' => false, 'message' => 'Booking not found.'], 404);
        }

        $isModifiable = ! in_array($booking->status, ['Sample Collected', 'In Process', 'Processing', 'Report Ready', 'Completed', 'Cancelled'])
            && $booking->sample_status !== 'Sample Collected';

        if (! $isModifiable) {
            return response()->json(['success' => false, 'message' => 'This booking cannot be modified at this stage.'], 422);
        }

        $isPaid = ($booking->payment_status === 'Paid');
        $rawTests = $request->input('tests', []);
        $addressId = $request->input('address_id');
        $bookingDate = $request->input('booking_date');
        $collectionSlot = $request->input('collection_slot');
        $familyMemberId = $request->input('family_member_id');
        $paymentMethodForDiff = $request->input('payment_method_for_diff', 'Cash');

        // Address validation
        if ($addressId) {
            $addrValid = Address::where('id', $addressId)->where('patient_id', $patientId)->exists();
            if (! $addrValid) {
                return response()->json(['success' => false, 'message' => 'Invalid collection address selected.'], 422);
            }
        }

        // Family member validation
        if ($familyMemberId) {
            $memValid = FamilyMember::where('id', $familyMemberId)->where('patient_id', $patientId)->exists();
            if (! $memValid) {
                $familyMemberId = null;
            }
        }

        if (empty($rawTests) || ! is_array($rawTests)) {
            return response()->json(['success' => false, 'message' => 'At least one diagnostic test is required.'], 422);
        }

        $originalTests = is_array($booking->test_details) ? $booking->test_details : (json_decode($booking->test_details, true) ?: []);

        // Build original test keys
        $originalMap = [];
        foreach ($originalTests as $t) {
            $k = ($t['type'] ?? 'test').'_'.($t['id'] ?? 0);
            $originalMap[$k] = $t;
        }

        if ($isPaid) {
            // RULE: If already paid, ONLY ADD tests option. Existing tests cannot be removed!
            $submittedKeys = [];
            foreach ($rawTests as $st) {
                $k = ($st['type'] ?? 'test').'_'.($st['id'] ?? 0);
                $submittedKeys[$k] = true;
            }

            foreach ($originalMap as $origKey => $origItem) {
                if (! isset($submittedKeys[$origKey])) {
                    return response()->json([
                        'success' => false,
                        'message' => 'This booking is already paid. Existing paid tests cannot be removed; you can only add new tests.',
                    ], 422);
                }
            }

            // Identify newly added tests and verify prices from DB
            $newTestsToAdd = [];
            $additionalAmount = 0.0;
            $allFinalTests = $originalTests;

            foreach ($rawTests as $item) {
                $k = ($item['type'] ?? 'test').'_'.($item['id'] ?? 0);
                if (! isset($originalMap[$k])) {
                    $type = $item['type'] ?? 'test';
                    $itemId = $item['id'] ?? null;
                    if ($type === 'package') {
                        $pkg = Package::find($itemId);
                        if ($pkg && $pkg->is_active) {
                            $price = (float) $pkg->price;
                            $newTestsToAdd[] = [
                                'id' => $pkg->id,
                                'name' => $pkg->name,
                                'title' => $pkg->name,
                                'type' => 'package',
                                'price' => $price,
                                'parameters_count' => is_array($pkg->parameters) ? count($pkg->parameters) : 0,
                            ];
                            $additionalAmount += $price;
                        }
                    } else {
                        $test = Test::find($itemId);
                        if ($test && $test->is_active) {
                            $price = (float) $test->price;
                            $newTestsToAdd[] = [
                                'id' => $test->id,
                                'name' => $test->name,
                                'title' => $test->name,
                                'type' => 'test',
                                'price' => $price,
                            ];
                            $additionalAmount += $price;
                        }
                    }
                }
            }

            $allFinalTests = array_merge($allFinalTests, $newTestsToAdd);

            $booking->test_details = $allFinalTests;
            if ($additionalAmount > 0) {
                $booking->amount = (float) $booking->amount + $additionalAmount;
                if ($paymentMethodForDiff === 'Cash') {
                    $booking->payment_method = 'Partial Online / Cash on Collection';
                }
            }
        } else {
            // UNPAID BOOKING: Can add and remove tests freely
            $sanitizedCart = [];
            $subtotal = 0.0;

            foreach ($rawTests as $item) {
                $type = $item['type'] ?? 'test';
                $id = $item['id'] ?? null;
                if (! $id) {
                    continue;
                }

                if ($type === 'package') {
                    $pkg = Package::find($id);
                    if ($pkg && $pkg->is_active) {
                        $price = (float) $pkg->price;
                        $sanitizedCart[] = [
                            'id' => $pkg->id,
                            'name' => $pkg->name,
                            'title' => $pkg->name,
                            'type' => 'package',
                            'price' => $price,
                            'parameters_count' => is_array($pkg->parameters) ? count($pkg->parameters) : 0,
                        ];
                        $subtotal += $price;
                    }
                } else {
                    $test = Test::find($id);
                    if ($test && $test->is_active) {
                        $price = (float) $test->price;
                        $sanitizedCart[] = [
                            'id' => $test->id,
                            'name' => $test->name,
                            'title' => $test->name,
                            'type' => 'test',
                            'price' => $price,
                        ];
                        $subtotal += $price;
                    }
                }
            }

            if (empty($sanitizedCart)) {
                return response()->json(['success' => false, 'message' => 'Please select at least one valid diagnostic test.'], 422);
            }

            $coinsDiscount = (float) ($booking->coins_discount ?? 0);
            $existingDiscount = (float) ($booking->discount_amount ?? 0);
            $finalAmount = max(0, $subtotal - $existingDiscount - $coinsDiscount);

            $booking->test_details = $sanitizedCart;
            $booking->amount = $finalAmount;
        }

        if ($addressId) {
            $booking->address_id = $addressId;
        }
        if ($bookingDate) {
            $booking->booking_date = $bookingDate;
        }
        if ($collectionSlot) {
            $booking->collection_slot = $collectionSlot;
        }
        $booking->family_member_id = $familyMemberId ?: null;

        $booking->save();

        return response()->json([
            'success' => true,
            'message' => 'Booking #'.$booking->booking_reference.' has been modified successfully!',
            'booking' => $booking,
        ]);
    }

    /**
     * Synchronize client cart items with the database.
     */
    public function syncCart(Request $request): JsonResponse
    {
        $patientId = session('patient_id');
        if (! $patientId) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $cart = $request->input('cart', []);
        $patient = Patient::find($patientId);
        if ($patient) {
            $patient->update(['cart' => is_array($cart) ? $cart : []]);

            return response()->json(['success' => true, 'cart' => $patient->cart]);
        }

        return response()->json(['success' => false, 'message' => 'Patient not found'], 404);
    }
}
