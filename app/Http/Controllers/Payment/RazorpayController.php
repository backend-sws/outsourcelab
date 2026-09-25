<?php

namespace App\Http\Controllers\Payment;

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
use App\Models\PaymentTransaction;
use App\Models\Setting;
use App\Models\Test;
use App\Services\NotificationService;
use App\Services\PathologyApiService;
use App\Services\RazorpayService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RazorpayController extends Controller
{
    /**
     * Create a Razorpay order for a diagnostic test booking during checkout.
     */
    public function createBookingOrder(Request $request, RazorpayService $razorpay): JsonResponse
    {
        $patientId = session('patient_id');
        if (! $patientId) {
            return response()->json(['success' => false, 'message' => 'Please login to proceed with payment.'], 401);
        }

        $patient = Patient::find($patientId);
        if (! $patient) {
            return response()->json(['success' => false, 'message' => 'Patient account not found.'], 404);
        }

        if (! $razorpay->isConfigured()) {
            return response()->json([
                'success' => false,
                'message' => 'Online payment gateway is currently undergoing maintenance. Please choose "Pay on Collection" or try again later.',
            ], 422);
        }

        $rawCart = $request->input('cart', []);
        $collectionType = $request->input('collection_type', 'Home Collection');
        $bookingDate = $request->input('booking_date', now()->toDateTimeString());
        $collectionSlot = $request->input('collection_slot', null);
        $addressId = $request->input('address_id', null);
        $familyMemberId = $request->input('family_member_id', null);
        $couponCode = strtoupper(trim($request->input('coupon_code', '')));
        $membershipPlanId = $request->input('membership_plan_id', null);

        if (empty($rawCart) || ! is_array($rawCart)) {
            return response()->json(['success' => false, 'message' => 'Your cart is empty.'], 400);
        }

        // Server-side price recalculation (Prevents price manipulation)
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

        // Check VIP Membership
        $purchasedPlan = $membershipPlanId ? MembershipPlan::where('is_active', true)->find($membershipPlanId) : null;
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

        // Coupon calculation
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
                $limit = $coupon->usage_limit_per_user ?? 1;

                if ($isValidDates && ($timesUsed < $limit) && ! ($coupon->min_order_amount > 0 && $subtotalAfterVip < $coupon->min_order_amount)) {
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

        // Health Coins
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
            if (($patientBalance >= $minCoinsToRedeem) && ($subtotalAfterVip >= $minOrderToRedeem)) {
                $subtotalAfterCoupon = max(0, $subtotalAfterVip - $discountAmount);
                $maxCoinsAllowed = ($maxRedeemType === 'percentage')
                    ? (int) floor((($subtotalAfterCoupon * $maxRedeemValue) / 100) / $coinValue)
                    : (int) $maxRedeemValue;

                $maxCoinsCap = min($patientBalance, $maxCoinsAllowed, (int) floor($subtotalAfterCoupon / $coinValue));
                $coinsRedeemed = min($coinsToRedeemInput, max(0, $maxCoinsCap));
                $coinsDiscount = round($coinsRedeemed * $coinValue, 2);
            }
        }

        $totalDiscount = $vipDiscountAmount + $discountAmount + $coinsDiscount;
        $finalAmount = max(1, round($subtotal - $totalDiscount + $membershipPrice, 2)); // Minimum 1 INR for payment gateway

        $coinsEarned = 0;
        if ($rewardEnabled && $finalAmount >= $minOrderToEarn) {
            $coinsEarned = ($earnType === 'percentage')
                ? (int) round(($finalAmount * $earnValue) / 100)
                : (int) round($earnValue);
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

        // Validate address and family member
        if ($addressId && ! Address::where('id', $addressId)->where('patient_id', $patientId)->exists()) {
            $addressId = null;
        }
        if (! $addressId) {
            $addressId = Address::where('patient_id', $patientId)->latest()->value('id');
        }

        if (! $addressId) {
            return response()->json([
                'success' => false,
                'message' => 'Sample collection address is required. Please add or select an address before booking.',
            ], 422);
        }

        // Create Pending Booking
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
            'payment_method' => 'Online',
            'payment_status' => 'Pending',
            'status' => 'Booked',
            'booking_date' => $bookingDate,
        ]);

        // Create Payment Transaction log in 'created' status
        $txn = PaymentTransaction::create([
            'transaction_reference' => PaymentTransaction::generateReference(),
            'patient_id' => $patientId,
            'booking_id' => $booking->id,
            'type' => 'booking',
            'amount' => $finalAmount,
            'currency' => 'INR',
            'gateway' => 'razorpay',
            'status' => 'created',
            'request_payload' => [
                'cart_count' => count($sanitizedCart),
                'discount' => $totalDiscount,
                'purchased_plan_id' => $membershipPlanId,
            ],
        ]);

        // Call Razorpay Order API
        $razorpayOrder = $razorpay->createOrder($finalAmount, $booking->booking_reference, [
            'booking_id' => (string) $booking->id,
            'booking_reference' => $booking->booking_reference,
            'patient_id' => (string) $patientId,
            'patient_name' => substr($patient->name ?? 'Patient', 0, 40),
            'transaction_id' => (string) $txn->id,
        ]);

        if (! $razorpayOrder['success']) {
            $txn->update([
                'status' => 'failed',
                'error_description' => $razorpayOrder['message'] ?? 'Failed to initialize order with Razorpay',
            ]);

            return response()->json([
                'success' => false,
                'message' => $razorpayOrder['message'] ?? 'Could not initialize online payment. Please try again.',
            ], 500);
        }

        $orderId = $razorpayOrder['order_id'];

        // Save order_id to booking and transaction
        $booking->update(['razorpay_order_id' => $orderId]);
        $txn->update([
            'razorpay_order_id' => $orderId,
            'response_payload' => $razorpayOrder['raw'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'key' => $razorpay->getKeyId(),
            'order_id' => $orderId,
            'amount' => $razorpayOrder['amount'], // in paise
            'amount_in_rupees' => $finalAmount,
            'currency' => 'INR',
            'name' => Setting::get('app_name', 'Av Wellcare Diagnostics'),
            'description' => "Lab Tests Booking #{$booking->booking_reference}",
            'booking_id' => $booking->id,
            'booking_reference' => $booking->booking_reference,
            'transaction_id' => $txn->id,
            'prefill' => [
                'name' => $patient->name ?? '',
                'email' => $patient->email ?? '',
                'contact' => preg_replace('/[^0-9]/', '', $patient->mobile ?? ''),
            ],
            'theme' => [
                'color' => '#0d9488', // Brand Teal
            ],
        ]);
    }

    /**
     * Verify payment signature returned from Razorpay Checkout modal for a booking.
     */
    public function verifyBookingPayment(Request $request, RazorpayService $razorpay): JsonResponse
    {
        $patientId = session('patient_id');
        if (! $patientId) {
            return response()->json(['success' => false, 'message' => 'Unauthorized session.'], 401);
        }

        $orderId = $request->input('razorpay_order_id');
        $paymentId = $request->input('razorpay_payment_id');
        $signature = $request->input('razorpay_signature');
        $bookingId = $request->input('booking_id');

        if (empty($orderId) || empty($paymentId) || empty($signature)) {
            return response()->json(['success' => false, 'message' => 'Incomplete payment authorization parameters.'], 422);
        }

        $booking = Booking::where('id', $bookingId)
            ->where('patient_id', $patientId)
            ->first();

        if (! $booking) {
            $booking = Booking::where('razorpay_order_id', $orderId)
                ->where('patient_id', $patientId)
                ->first();
        }

        if (! $booking) {
            return response()->json(['success' => false, 'message' => 'Booking not found.'], 404);
        }

        $txn = PaymentTransaction::where('razorpay_order_id', $orderId)->latest()->first();

        // Signature verification
        $isValid = $razorpay->verifyPaymentSignature($orderId, $paymentId, $signature);

        if (! $isValid) {
            if ($txn) {
                $txn->update([
                    'status' => 'failed',
                    'razorpay_payment_id' => $paymentId,
                    'razorpay_signature' => $signature,
                    'error_code' => 'SIGNATURE_VERIFICATION_FAILED',
                    'error_description' => 'Calculated signature did not match Razorpay provided signature.',
                ]);
            }

            Log::error('Razorpay signature mismatch', [
                'order_id' => $orderId,
                'payment_id' => $paymentId,
                'booking_id' => $booking->id,
            ]);

            try {
                $booking->load('patient');
                app(NotificationService::class)->paymentFailed($booking);
            } catch (\Throwable $e) {
                Log::warning('Razorpay paymentFailed notification failed: '.$e->getMessage());
            }

            return response()->json(['success' => false, 'message' => 'Payment signature verification failed. Please contact support.'], 400);
        }

        // Fetch payment details from Razorpay to retrieve exact payment mode (UPI, card, etc.)
        $paymentDetails = $razorpay->fetchPayment($paymentId);
        $method = $paymentDetails['method'] ?? 'online';
        $vpa = $paymentDetails['vpa'] ?? null;
        $bank = $paymentDetails['bank'] ?? null;
        $wallet = $paymentDetails['wallet'] ?? null;

        DB::transaction(function () use ($booking, $txn, $orderId, $paymentId, $signature, $method, $vpa, $bank, $wallet, $paymentDetails) {
            // Update Booking
            $booking->update([
                'payment_status' => 'Paid',
                'payment_method' => 'Online',
                'razorpay_order_id' => $orderId,
                'razorpay_payment_id' => $paymentId,
                'razorpay_signature' => $signature,
            ]);

            // Update Transaction
            if ($txn) {
                $txn->update([
                    'status' => 'captured',
                    'razorpay_payment_id' => $paymentId,
                    'razorpay_signature' => $signature,
                    'payment_method' => $method,
                    'vpa' => $vpa,
                    'bank' => $bank,
                    'wallet' => $wallet,
                    'paid_at' => now(),
                    'response_payload' => $paymentDetails,
                ]);
            }

            $patient = $booking->patient;
            if ($patient) {
                // Reward coins processing
                $coinValue = (float) Setting::get('reward_coin_value', '1.00');
                if ($booking->coins_redeemed > 0) {
                    $patient->debitCoins($booking->coins_redeemed, "Redeemed on booking #{$booking->booking_reference}", $booking->id, $booking->coins_discount);
                }
                if ($booking->coins_earned > 0) {
                    $patient->creditCoins($booking->coins_earned, "Earned from booking #{$booking->booking_reference}", $booking->id, round($booking->coins_earned * $coinValue, 2));
                }

                // If VIP Plan was included in booking
                if (is_array($booking->test_details)) {
                    foreach ($booking->test_details as $item) {
                        if (($item['type'] ?? '') === 'membership' && ! empty($item['id'])) {
                            $plan = MembershipPlan::find($item['id']);
                            if ($plan) {
                                PatientMembership::create([
                                    'patient_id' => $patient->id,
                                    'membership_plan_id' => $plan->id,
                                    'plan_name_snapshot' => $plan->name,
                                    'discount_percentage' => $plan->discount_percentage,
                                    'price_paid' => $plan->price,
                                    'started_at' => now(),
                                    'expires_at' => now()->addMonths($plan->duration_in_months),
                                    'status' => 'active',
                                    'booking_id' => $booking->id,
                                ]);
                            }
                        }
                    }
                }

                // Record coupon usage
                if ($booking->coupon_code && $booking->coupon_code !== 'VIP-MEMBER') {
                    $coupon = Coupon::where('code', $booking->coupon_code)->first();
                    if ($coupon) {
                        $userCoupon = PatientCoupon::firstOrCreate([
                            'patient_id' => $patient->id,
                            'coupon_id' => $coupon->id,
                        ]);
                        $userCoupon->update([
                            'is_used' => true,
                            'used_at' => now(),
                            'booking_id' => $booking->id,
                        ]);
                        $coupon->increment('usage_count');
                    }
                }

                // Clear patient cart
                $patient->update(['cart' => []]);
            }
        });

        // Push verified booking to Pathology SaaS LIS API
        try {
            $apiService = app(PathologyApiService::class);
            if ($apiService->isConfigured() && empty($booking->lis_booking_reference)) {
                $lisItems = [];
                if (is_array($booking->test_details)) {
                    foreach ($booking->test_details as $cartItem) {
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
                }

                if (! empty($lisItems)) {
                    $patient = $booking->patient;
                    $targetMember = $booking->familyMember;
                    $targetAddress = $booking->address;

                    $lisPayload = [
                        'patient_name' => $targetMember?->name ?: ($patient?->name ?? 'Patient'),
                        'patient_phone' => $patient?->mobile ?? '',
                        'patient_email' => $patient?->email,
                        'patient_gender' => strtolower($targetMember?->gender ?: ($patient?->gender ?: 'other')),
                        'patient_age' => (int) ($targetMember?->age ?: ($patient?->age ?: 30)),
                        'patient_age_unit' => 'years',
                        'collection_type' => str_contains(strtolower($booking->collection_type), 'home') ? 'home_collection' : 'lab_visit',
                        'collection_address' => $targetAddress?->full_address ?? 'Not provided',
                        'preferred_date' => $booking->booking_date ? $booking->booking_date->toDateString() : now()->toDateString(),
                        'preferred_time_slot' => $booking->collection_slot ?: '08:00 AM - 10:00 AM',
                        'branch_id' => (int) config('pathology.default_branch_id', 1),
                        'notes' => "Website Order (Paid Online): #{$booking->booking_reference}",
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
            Log::warning('Pathology LIS push failed in Razorpay verify: '.$lisErr->getMessage());
        }

        // Dispatch notifications

        try {
            $booking->load(['patient', 'address', 'familyMember']);
            app(NotificationService::class)->bookingPlaced($booking);
            app(NotificationService::class)->paymentSuccess($booking);
        } catch (\Throwable $e) {
            Log::warning('Razorpay payment notifications dispatch failed: '.$e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Payment verified successfully! Your diagnostic tests are booked.',
            'booking_reference' => $booking->booking_reference,
            'booking_id' => $booking->id,
            'redirect_url' => route('patient.bookings'),
        ]);
    }

    /**
     * Create a Razorpay order for standalone VIP Membership plan purchase.
     */
    public function createMembershipOrder(Request $request, RazorpayService $razorpay): JsonResponse
    {
        $patientId = session('patient_id');
        if (! $patientId) {
            return response()->json(['success' => false, 'message' => 'Please login to purchase a VIP membership.'], 401);
        }

        $patient = Patient::find($patientId);
        if (! $patient) {
            return response()->json(['success' => false, 'message' => 'Patient account not found.'], 404);
        }

        if (! $razorpay->isConfigured()) {
            return response()->json([
                'success' => false,
                'message' => 'Payment gateway is not configured. Please contact administrator.',
            ], 422);
        }

        $planId = $request->input('plan_id');
        $plan = MembershipPlan::where('is_active', true)->find($planId);
        if (! $plan) {
            return response()->json(['success' => false, 'message' => 'Selected membership plan is not available.'], 404);
        }

        $amount = (float) $plan->price;
        $receipt = 'MEM-'.strtoupper(substr(uniqid(), -6));

        // Create transaction record
        $txn = PaymentTransaction::create([
            'transaction_reference' => PaymentTransaction::generateReference(),
            'patient_id' => $patientId,
            'type' => 'membership',
            'amount' => $amount,
            'currency' => 'INR',
            'gateway' => 'razorpay',
            'status' => 'created',
            'request_payload' => [
                'plan_id' => $plan->id,
                'plan_name' => $plan->name,
            ],
        ]);

        $razorpayOrder = $razorpay->createOrder($amount, $receipt, [
            'type' => 'membership',
            'plan_id' => (string) $plan->id,
            'plan_name' => $plan->name,
            'patient_id' => (string) $patientId,
            'transaction_id' => (string) $txn->id,
        ]);

        if (! $razorpayOrder['success']) {
            $txn->update([
                'status' => 'failed',
                'error_description' => $razorpayOrder['message'] ?? 'Failed to initialize order with Razorpay',
            ]);

            return response()->json([
                'success' => false,
                'message' => $razorpayOrder['message'] ?? 'Could not initialize membership payment.',
            ], 500);
        }

        $txn->update([
            'razorpay_order_id' => $razorpayOrder['order_id'],
            'response_payload' => $razorpayOrder['raw'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'key' => $razorpay->getKeyId(),
            'order_id' => $razorpayOrder['order_id'],
            'amount' => $razorpayOrder['amount'],
            'amount_in_rupees' => $amount,
            'currency' => 'INR',
            'name' => Setting::get('app_name', 'Av Wellcare Diagnostics'),
            'description' => "VIP Membership - {$plan->name} ({$plan->formatted_duration})",
            'plan_id' => $plan->id,
            'transaction_id' => $txn->id,
            'prefill' => [
                'name' => $patient->name ?? '',
                'email' => $patient->email ?? '',
                'contact' => preg_replace('/[^0-9]/', '', $patient->mobile ?? ''),
            ],
            'theme' => [
                'color' => '#d97706', // Gold / Amber
            ],
        ]);
    }

    /**
     * Verify payment signature for standalone VIP Membership plan purchase.
     */
    public function verifyMembershipPayment(Request $request, RazorpayService $razorpay): JsonResponse
    {
        $patientId = session('patient_id');
        if (! $patientId) {
            return response()->json(['success' => false, 'message' => 'Unauthorized session.'], 401);
        }

        $orderId = $request->input('razorpay_order_id');
        $paymentId = $request->input('razorpay_payment_id');
        $signature = $request->input('razorpay_signature');
        $planId = $request->input('plan_id');

        if (empty($orderId) || empty($paymentId) || empty($signature)) {
            return response()->json(['success' => false, 'message' => 'Missing payment parameters.'], 422);
        }

        $plan = MembershipPlan::findOrFail($planId);
        $txn = PaymentTransaction::where('razorpay_order_id', $orderId)->latest()->first();

        $isValid = $razorpay->verifyPaymentSignature($orderId, $paymentId, $signature);
        if (! $isValid) {
            if ($txn) {
                $txn->update([
                    'status' => 'failed',
                    'razorpay_payment_id' => $paymentId,
                    'razorpay_signature' => $signature,
                    'error_code' => 'SIGNATURE_VERIFICATION_FAILED',
                ]);
            }

            return response()->json(['success' => false, 'message' => 'Membership payment verification failed.'], 400);
        }

        $paymentDetails = $razorpay->fetchPayment($paymentId);
        $method = $paymentDetails['method'] ?? 'online';

        DB::transaction(function () use ($patientId, $plan, $txn, $paymentId, $signature, $method, $paymentDetails) {
            $membership = PatientMembership::create([
                'patient_id' => $patientId,
                'membership_plan_id' => $plan->id,
                'plan_name_snapshot' => $plan->name,
                'discount_percentage' => $plan->discount_percentage,
                'price_paid' => $plan->price,
                'started_at' => now(),
                'expires_at' => now()->addMonths($plan->duration_in_months),
                'status' => 'active',
            ]);

            if ($txn) {
                $txn->update([
                    'status' => 'captured',
                    'patient_membership_id' => $membership->id,
                    'razorpay_payment_id' => $paymentId,
                    'razorpay_signature' => $signature,
                    'payment_method' => $method,
                    'paid_at' => now(),
                    'response_payload' => $paymentDetails,
                ]);
            }
        });

        return response()->json([
            'success' => true,
            'message' => "Welcome to the VIP Club! Your {$plan->name} is active now.",
            'redirect_url' => route('patient.membership'),
        ]);
    }

    /**
     * Retry online payment for an existing unpaid booking.
     */
    public function retryBookingPayment(Request $request, int $id, RazorpayService $razorpay): JsonResponse
    {
        $patientId = session('patient_id');
        if (! $patientId) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 401);
        }

        $booking = Booking::where('id', $id)->where('patient_id', $patientId)->firstOrFail();
        if ($booking->payment_status === 'Paid') {
            return response()->json(['success' => false, 'message' => 'This booking is already paid.'], 400);
        }

        $patient = $booking->patient;
        $amount = (float) $booking->amount;

        $txn = PaymentTransaction::create([
            'transaction_reference' => PaymentTransaction::generateReference(),
            'patient_id' => $patientId,
            'booking_id' => $booking->id,
            'type' => 'booking',
            'amount' => $amount,
            'currency' => 'INR',
            'gateway' => 'razorpay',
            'status' => 'created',
            'request_payload' => ['retry' => true],
        ]);

        $razorpayOrder = $razorpay->createOrder($amount, $booking->booking_reference, [
            'booking_id' => (string) $booking->id,
            'booking_reference' => $booking->booking_reference,
            'patient_id' => (string) $patientId,
            'retry' => 'true',
        ]);

        if (! $razorpayOrder['success']) {
            return response()->json(['success' => false, 'message' => $razorpayOrder['message']], 500);
        }

        $orderId = $razorpayOrder['order_id'];
        $booking->update(['razorpay_order_id' => $orderId]);
        $txn->update(['razorpay_order_id' => $orderId]);

        return response()->json([
            'success' => true,
            'key' => $razorpay->getKeyId(),
            'order_id' => $orderId,
            'amount' => $razorpayOrder['amount'],
            'amount_in_rupees' => $amount,
            'currency' => 'INR',
            'name' => Setting::get('app_name', 'Av Wellcare Diagnostics'),
            'description' => "Complete Payment for #{$booking->booking_reference}",
            'booking_id' => $booking->id,
            'booking_reference' => $booking->booking_reference,
            'prefill' => [
                'name' => $patient->name ?? '',
                'email' => $patient->email ?? '',
                'contact' => preg_replace('/[^0-9]/', '', $patient->mobile ?? ''),
            ],
            'theme' => ['color' => '#0d9488'],
        ]);
    }

    /**
     * Create a Razorpay order for additional tests on an already paid booking.
     */
    public function createModifyOrder(Request $request, int $id, RazorpayService $razorpay): JsonResponse
    {
        $patientId = session('patient_id');
        if (! $patientId) {
            return response()->json(['success' => false, 'message' => 'Please login to proceed.'], 401);
        }

        $booking = Booking::where('id', $id)->where('patient_id', $patientId)->first();
        if (! $booking) {
            return response()->json(['success' => false, 'message' => 'Booking not found.'], 404);
        }

        $rawTests = $request->input('tests', []);
        $originalTests = is_array($booking->test_details) ? $booking->test_details : (json_decode($booking->test_details, true) ?: []);

        $originalMap = [];
        foreach ($originalTests as $t) {
            $k = ($t['type'] ?? 'test').'_'.($t['id'] ?? 0);
            $originalMap[$k] = $t;
        }

        // Calculate additional amount for newly added tests
        $additionalAmount = 0.0;
        foreach ($rawTests as $item) {
            $k = ($item['type'] ?? 'test').'_'.($item['id'] ?? 0);
            if (! isset($originalMap[$k])) {
                $type = $item['type'] ?? 'test';
                $itemId = $item['id'] ?? null;
                if ($type === 'package') {
                    $pkg = Package::find($itemId);
                    if ($pkg && $pkg->is_active) {
                        $additionalAmount += (float) $pkg->price;
                    }
                } else {
                    $test = Test::find($itemId);
                    if ($test && $test->is_active) {
                        $additionalAmount += (float) $test->price;
                    }
                }
            }
        }

        if ($additionalAmount <= 0) {
            return response()->json(['success' => false, 'message' => 'No additional payment required.'], 400);
        }

        $txn = PaymentTransaction::create([
            'transaction_reference' => PaymentTransaction::generateReference(),
            'patient_id' => $patientId,
            'booking_id' => $booking->id,
            'type' => 'booking_addon',
            'amount' => $additionalAmount,
            'currency' => 'INR',
            'gateway' => 'razorpay',
            'status' => 'created',
            'request_payload' => [
                'addon_tests' => $rawTests,
                'address_id' => $request->input('address_id'),
                'booking_date' => $request->input('booking_date'),
                'collection_slot' => $request->input('collection_slot'),
                'family_member_id' => $request->input('family_member_id'),
            ],
        ]);

        $razorpayOrder = $razorpay->createOrder($additionalAmount, $booking->booking_reference.'-ADD', [
            'booking_id' => (string) $booking->id,
            'patient_id' => (string) $patientId,
            'type' => 'booking_addon',
        ]);

        if (! $razorpayOrder['success']) {
            $txn->update(['status' => 'failed', 'error_code' => 'GATEWAY_ERROR']);

            return response()->json(['success' => false, 'message' => $razorpayOrder['message'] ?? 'Could not initiate payment gateway.'], 500);
        }

        $orderId = $razorpayOrder['order_id'];
        $txn->update(['razorpay_order_id' => $orderId]);

        return response()->json([
            'success' => true,
            'key' => $razorpay->getKeyId(),
            'order_id' => $orderId,
            'amount' => $razorpayOrder['amount'],
            'amount_in_rupees' => $additionalAmount,
            'currency' => 'INR',
            'name' => Setting::get('app_name', 'AV Wellcare Diagnostics'),
            'description' => "Additional Tests for #{$booking->booking_reference}",
            'booking_id' => $booking->id,
            'booking_reference' => $booking->booking_reference,
            'prefill' => [
                'name' => $booking->patient->name ?? '',
                'email' => $booking->patient->email ?? '',
                'contact' => preg_replace('/[^0-9]/', '', $booking->patient->mobile ?? ''),
            ],
            'theme' => ['color' => '#0d9488'],
        ]);
    }

    /**
     * Verify payment for additional tests on an already paid booking and commit modifications.
     */
    public function verifyModifyPayment(Request $request, int $id, RazorpayService $razorpay): JsonResponse
    {
        $patientId = session('patient_id');
        if (! $patientId) {
            return response()->json(['success' => false, 'message' => 'Please login.'], 401);
        }

        $booking = Booking::where('id', $id)->where('patient_id', $patientId)->first();
        if (! $booking) {
            return response()->json(['success' => false, 'message' => 'Booking not found.'], 404);
        }

        $orderId = $request->input('razorpay_order_id');
        $paymentId = $request->input('razorpay_payment_id');
        $signature = $request->input('razorpay_signature');
        $rawTests = $request->input('tests', []);

        if (empty($orderId) || empty($paymentId) || empty($signature)) {
            return response()->json(['success' => false, 'message' => 'Missing payment parameters.'], 422);
        }

        $isValid = $razorpay->verifyPaymentSignature($orderId, $paymentId, $signature);
        if (! $isValid) {
            return response()->json(['success' => false, 'message' => 'Payment signature verification failed.'], 400);
        }

        $originalTests = is_array($booking->test_details) ? $booking->test_details : (json_decode($booking->test_details, true) ?: []);
        $originalMap = [];
        foreach ($originalTests as $t) {
            $k = ($t['type'] ?? 'test').'_'.($t['id'] ?? 0);
            $originalMap[$k] = $t;
        }

        $newTestsToAdd = [];
        $additionalAmount = 0.0;
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

        $allFinalTests = array_merge($originalTests, $newTestsToAdd);

        $booking->test_details = $allFinalTests;
        $booking->amount = (float) $booking->amount + $additionalAmount;
        $booking->payment_status = 'Paid';

        if ($request->filled('address_id')) {
            $booking->address_id = $request->input('address_id');
        }
        if ($request->filled('booking_date')) {
            $booking->booking_date = $request->input('booking_date');
        }
        if ($request->filled('collection_slot')) {
            $booking->collection_slot = $request->input('collection_slot');
        }
        if ($request->has('family_member_id')) {
            $booking->family_member_id = $request->input('family_member_id') ?: null;
        }

        $booking->save();

        PaymentTransaction::where('razorpay_order_id', $orderId)->update([
            'status' => 'captured',
            'razorpay_payment_id' => $paymentId,
            'razorpay_signature' => $signature,
            'paid_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Additional tests added and payment of ₹'.number_format($additionalAmount, 0).' verified successfully!',
            'redirect_url' => route('patient.bookings'),
        ]);
    }
}
