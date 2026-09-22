<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PatientRewardController extends Controller
{
    /**
     * Display the patient's Health Coins wallet, ledger, and benefits.
     */
    public function index(): View|RedirectResponse
    {
        $patientId = session('patient_id');
        if (! $patientId) {
            return redirect('/');
        }

        $patient = Patient::find($patientId);
        if (! $patient) {
            return redirect('/');
        }

        $coinName = Setting::get('reward_coin_name', 'Health Coins');
        $coinValue = (float) Setting::get('reward_coin_value', '1.00');
        $earnType = Setting::get('reward_earn_type', 'percentage');
        $earnValue = (float) Setting::get('reward_earn_value', '5');
        $minOrderToEarn = (float) Setting::get('reward_min_order_to_earn', '100');
        $maxRedeemType = Setting::get('reward_max_redeem_type', 'percentage');
        $maxRedeemValue = (float) Setting::get('reward_max_redeem_value', '20');
        $minOrderToRedeem = (float) Setting::get('reward_min_order_to_redeem', '200');
        $minCoinsToRedeem = (int) Setting::get('reward_min_coins_to_redeem', '10');

        $coinBalance = (int) $patient->reward_coins;
        $inrEquivalent = round($coinBalance * $coinValue, 2);

        $transactions = $patient->rewardTransactions()
            ->with('booking')
            ->latest()
            ->paginate(15);

        $totalEarned = (int) $patient->rewardTransactions()->where('type', 'credit')->sum('coins');
        $totalRedeemed = abs((int) $patient->rewardTransactions()->where('type', 'debit')->sum('coins'));
        $profile = $patient;

        return view('patient.pages.rewards', compact(
            'profile',
            'patient',
            'coinName',
            'coinValue',
            'coinBalance',
            'inrEquivalent',
            'earnType',
            'earnValue',
            'minOrderToEarn',
            'maxRedeemType',
            'maxRedeemValue',
            'minOrderToRedeem',
            'minCoinsToRedeem',
            'transactions',
            'totalEarned',
            'totalRedeemed'
        ));
    }
}
