<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CollectionSlot;
use App\Models\Coupon;
use App\Models\MembershipPlan;
use App\Models\Patient;
use App\Models\PatientCoupon;
use App\Models\Setting;
use App\Models\Test;
use App\Services\AutoAssignPhlebotomistService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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

        $collectionSlots = CollectionSlot::active()
            ->ordered()
            ->get()
            ->groupBy('period');

        $collectionFeeSettings = [
            'enabled' => Setting::get('collection_fee_enabled', '1') == '1',
            'fee' => (float) Setting::get('home_collection_fee', '100'),
            'threshold' => (float) Setting::get('free_collection_threshold', '500'),
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
            'rewardSettings',
            'collectionSlots',
            'collectionFeeSettings'
        ));
    }

    /**
     * Check collection slot availability based on area pincode and selected date.
     * Evaluates phlebotomist assignments, leaves/weekly offs, and slot capacity.
     */
    public function checkSlots(Request $request): JsonResponse
    {
        $pincode = trim((string) $request->input('pincode', ''));
        $date = trim((string) $request->input('date', ''));

        if (empty($pincode)) {
            return response()->json([
                'serviceable' => false,
                'message' => 'Please provide a valid pincode.',
                'slots' => [],
            ], 422);
        }

        if (empty($date) || ! strtotime($date)) {
            $date = now()->format('Y-m-d');
        } else {
            $date = date('Y-m-d', strtotime($date));
        }

        $service = app(AutoAssignPhlebotomistService::class);
        $result = $service->checkSlotAvailabilityForPincode($pincode, $date);

        return response()->json($result);
    }
}
