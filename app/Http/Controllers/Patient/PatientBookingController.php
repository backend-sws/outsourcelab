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
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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

        // Family member verification
        if ($familyMemberId) {
            $memberExists = FamilyMember::where('id', $familyMemberId)->where('patient_id', $patientId)->exists();
            if (! $memberExists) {
                $familyMemberId = null;
            }
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
