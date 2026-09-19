<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Patient;
use App\Models\PatientCoupon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PatientCouponController extends Controller
{
    /**
     * Display coupons available to the patient.
     */
    public function index(): View|RedirectResponse
    {
        $patientId = session('patient_id');
        if (! $patientId) {
            return redirect('/');
        }

        $profile = Patient::find($patientId);
        if (! $profile) {
            return redirect('/');
        }

        $this->assignWelcomeCoupons($patientId);

        $myCoupons = PatientCoupon::with('coupon')
            ->where('patient_id', $patientId)
            ->latest()
            ->get();

        $publicCoupons = Coupon::where('is_active', true)
            ->where('coupon_type', '!=', 'welcome')
            ->latest()
            ->get();

        return view('patient.pages.coupons', compact('profile', 'myCoupons', 'publicCoupons'));
    }

    /**
     * Auto-assign active welcome coupons to the patient.
     */
    public function assignWelcomeCoupons(int $patientId): void
    {
        $welcomeCoupons = Coupon::where('coupon_type', 'welcome')
            ->where('is_active', true)
            ->get();

        foreach ($welcomeCoupons as $coupon) {
            PatientCoupon::firstOrCreate([
                'patient_id' => $patientId,
                'coupon_id' => $coupon->id,
            ]);
        }
    }

    /**
     * Validate and calculate discount for a promo coupon.
     */
    public function applyCoupon(Request $request): JsonResponse
    {
        $code = strtoupper(trim($request->input('code', '')));
        $cartTotal = (float) $request->input('cart_total', 0);
        $patientId = session('patient_id');

        if (! $code) {
            return response()->json(['success' => false, 'message' => 'Please enter a coupon code.']);
        }

        if ($cartTotal <= 0) {
            return response()->json(['success' => false, 'message' => 'Please add tests or packages to your cart first.']);
        }

        $coupon = Coupon::where('code', $code)->first();

        if (! $coupon || ! $coupon->is_active) {
            return response()->json(['success' => false, 'message' => 'Invalid or inactive coupon code.']);
        }

        // Validity dates check
        if ($coupon->valid_from && now()->startOfDay()->lt($coupon->valid_from)) {
            return response()->json(['success' => false, 'message' => 'This coupon offer has not started yet.']);
        }
        if ($coupon->valid_until && now()->endOfDay()->gt($coupon->valid_until->endOfDay())) {
            return response()->json(['success' => false, 'message' => 'This coupon offer has expired.']);
        }

        // Check global coupon usage limit
        if ($coupon->usage_limit && $coupon->usage_count >= $coupon->usage_limit) {
            return response()->json(['success' => false, 'message' => 'This coupon has reached its maximum global usage limit.']);
        }

        // Check user coupon usage limit (for logged-in patients)
        if ($patientId) {
            $timesUsed = PatientCoupon::where('patient_id', $patientId)
                ->where('coupon_id', $coupon->id)
                ->where('is_used', true)
                ->count();

            $allowedLimit = $coupon->usage_limit_per_user ?? ($coupon->coupon_type === 'welcome' ? 1 : 1);
            if ($timesUsed >= $allowedLimit) {
                return response()->json(['success' => false, 'message' => 'You have already reached the usage limit for this coupon.']);
            }
        } elseif ($coupon->coupon_type === 'welcome') {
            return response()->json(['success' => false, 'message' => 'Please login to use your welcome coupon.']);
        }

        // Minimum order spend check (for banner/threshold coupons)
        if ($coupon->min_order_amount > 0 && $cartTotal < $coupon->min_order_amount) {
            $diff = $coupon->min_order_amount - $cartTotal;

            return response()->json([
                'success' => false,
                'message' => 'This coupon requires a minimum cart amount of ₹'.number_format($coupon->min_order_amount, 2).'. Add ₹'.number_format($diff, 2).' more worth of tests to apply.',
            ]);
        }

        // Calculate discount
        $discount = $coupon->calculateDiscount($cartTotal);
        $finalTotal = max(0, $cartTotal - $discount);

        $discountText = $coupon->discount_type === 'percentage'
            ? "{$coupon->discount_value}% OFF (-₹".number_format($discount, 2).')'
            : '₹'.number_format($discount, 2).' Flat OFF';

        return response()->json([
            'success' => true,
            'coupon_code' => $coupon->code,
            'coupon_title' => $coupon->title,
            'discount_type' => $coupon->discount_type,
            'discount_value' => $coupon->discount_value,
            'discount_amount' => $discount,
            'final_total' => $finalTotal,
            'message' => "Success! Coupon '{$coupon->code}' applied: {$discountText} deducted.",
        ]);
    }
}
