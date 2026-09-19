<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\MembershipPlan;
use App\Models\Patient;
use App\Models\PatientCoupon;
use App\Models\Setting;
use App\Models\Test;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CheckoutController extends Controller
{
    /**
     * Display the booking checkout interface for logged-in patients.
     */
    public function index(): View|RedirectResponse
    {
        $patientId = session('patient_id');
        if (! $patientId) {
            return redirect('/');
        }

        $patient = Patient::with(['addresses', 'familyMembers'])->find($patientId);
        if (! $patient) {
            return redirect('/');
        }

        // Auto-assign active welcome coupons if not yet attached
        $welcomeCoupons = Coupon::where('coupon_type', 'welcome')
            ->where('is_active', true)
            ->get();

        foreach ($welcomeCoupons as $coupon) {
            PatientCoupon::firstOrCreate([
                'patient_id' => $patientId,
                'coupon_id' => $coupon->id,
            ]);
        }

        $myCoupons = PatientCoupon::with('coupon')
            ->where('patient_id', $patientId)
            ->where('is_used', false)
            ->get()
            ->filter(fn ($pc) => $pc->coupon && $pc->coupon->is_active);

        $bannerCoupons = Coupon::where('is_active', true)
            ->where('coupon_type', 'banner')
            ->get();

        $suggestedTests = Test::where('is_active', true)
            ->with('category')
            ->take(6)
            ->get();

        $vipPlans = MembershipPlan::where('is_active', true)->get();
        $patientVip = $patient->activeMembership();

        $patientVipData = $patientVip ? [
            'id' => $patientVip->id,
            'plan_name' => $patientVip->plan_name_snapshot,
            'discount_percentage' => (int) $patientVip->discount_percentage,
        ] : null;

        $allVipPlansData = $vipPlans->map(function ($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'formatted_duration' => $p->formatted_duration,
                'price' => (float) $p->price,
                'discount_percentage' => (int) $p->discount_percentage,
                'is_popular' => (bool) $p->is_popular,
            ];
        })->values()->toArray();

        $rewardSettings = [
            'enabled' => Setting::get('reward_enabled', '1') == '1',
            'coin_name' => Setting::get('reward_coin_name', 'Health Coins'),
            'coin_value' => (float) Setting::get('reward_coin_value', '1.00'),
            'earn_type' => Setting::get('reward_earn_type', 'percentage'),
            'earn_value' => (float) Setting::get('reward_earn_value', '5'),
            'min_order_to_earn' => (float) Setting::get('reward_min_order_to_earn', '100'),
            'max_redeem_type' => Setting::get('reward_max_redeem_type', 'percentage'),
            'max_redeem_value' => (float) Setting::get('reward_max_redeem_value', '20'),
            'min_order_to_redeem' => (float) Setting::get('reward_min_order_to_redeem', '200'),
            'min_coins_to_redeem' => (int) Setting::get('reward_min_coins_to_redeem', '10'),
            'patient_coins' => (int) $patient->reward_coins,
        ];

        return view('frontend.pages.checkout', compact(
            'patient',
            'myCoupons',
            'bannerCoupons',
            'suggestedTests',
            'vipPlans',
            'patientVip',
            'patientVipData',
            'allVipPlansData',
            'rewardSettings'
        ));
    }
}
