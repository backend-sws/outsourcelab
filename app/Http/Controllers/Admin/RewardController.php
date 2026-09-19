<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\RewardTransaction;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RewardController extends Controller
{
    /**
     * Display rewards settings, high-level metrics, and transactions ledger.
     */
    public function index(Request $request): View
    {
        // High-level statistics
        $totalCoinsDistributed = (int) RewardTransaction::where('type', 'credit')->sum('coins');
        $totalCoinsRedeemed = abs((int) RewardTransaction::where('type', 'debit')->sum('coins'));
        $totalCirculatingCoins = (int) Patient::sum('reward_coins');
        $totalActiveWallets = Patient::where('reward_coins', '>', 0)->count();

        // Current Reward Settings
        $settings = [
            'reward_enabled' => Setting::get('reward_enabled', '1'),
            'reward_coin_name' => Setting::get('reward_coin_name', 'Health Coins'),
            'reward_coin_value' => (float) Setting::get('reward_coin_value', '1.00'),
            'reward_earn_type' => Setting::get('reward_earn_type', 'percentage'),
            'reward_earn_value' => (float) Setting::get('reward_earn_value', '5'),
            'reward_min_order_to_earn' => (float) Setting::get('reward_min_order_to_earn', '100'),
            'reward_max_redeem_type' => Setting::get('reward_max_redeem_type', 'percentage'),
            'reward_max_redeem_value' => (float) Setting::get('reward_max_redeem_value', '20'),
            'reward_min_order_to_redeem' => (float) Setting::get('reward_min_order_to_redeem', '200'),
            'reward_min_coins_to_redeem' => (int) Setting::get('reward_min_coins_to_redeem', '10'),
        ];

        // Transactions Query
        $txQuery = RewardTransaction::with(['patient', 'booking']);

        if ($request->filled('type')) {
            $txQuery->where('type', $request->type);
        }

        if ($request->filled('search')) {
            $search = trim($request->search);
            $txQuery->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhereHas('patient', function ($pq) use ($search) {
                        $pq->where('name', 'like', "%{$search}%")
                            ->orWhere('mobile', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('booking', function ($bq) use ($search) {
                        $bq->where('booking_reference', 'like', "%{$search}%");
                    });
            });
        }

        $transactions = $txQuery->latest()->paginate(15)->withQueryString();

        // Patients list for manual adjustment modal
        $patients = Patient::select('id', 'name', 'mobile', 'reward_coins')->orderBy('name')->get();

        return view('admin.pages.rewards.index', compact(
            'totalCoinsDistributed',
            'totalCoinsRedeemed',
            'totalCirculatingCoins',
            'totalActiveWallets',
            'settings',
            'transactions',
            'patients'
        ));
    }

    /**
     * Update reward system configuration rules.
     */
    public function updateSettings(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'reward_enabled' => 'nullable',
            'reward_coin_name' => 'required|string|max:50',
            'reward_coin_value' => 'required|numeric|min:0.01',
            'reward_earn_type' => 'required|in:percentage,flat',
            'reward_earn_value' => 'required|numeric|min:0',
            'reward_min_order_to_earn' => 'required|numeric|min:0',
            'reward_max_redeem_type' => 'required|in:percentage,flat',
            'reward_max_redeem_value' => 'required|numeric|min:0',
            'reward_min_order_to_redeem' => 'required|numeric|min:0',
            'reward_min_coins_to_redeem' => 'required|integer|min:0',
        ]);

        $enabled = $request->has('reward_enabled') ? '1' : '0';
        Setting::set('reward_enabled', $enabled, 'rewards', 'boolean');

        Setting::set('reward_coin_name', trim($validated['reward_coin_name']), 'rewards', 'text');
        Setting::set('reward_coin_value', (string) $validated['reward_coin_value'], 'rewards', 'number');
        Setting::set('reward_earn_type', $validated['reward_earn_type'], 'rewards', 'text');
        Setting::set('reward_earn_value', (string) $validated['reward_earn_value'], 'rewards', 'number');
        Setting::set('reward_min_order_to_earn', (string) $validated['reward_min_order_to_earn'], 'rewards', 'number');
        Setting::set('reward_max_redeem_type', $validated['reward_max_redeem_type'], 'rewards', 'text');
        Setting::set('reward_max_redeem_value', (string) $validated['reward_max_redeem_value'], 'rewards', 'number');
        Setting::set('reward_min_order_to_redeem', (string) $validated['reward_min_order_to_redeem'], 'rewards', 'number');
        Setting::set('reward_min_coins_to_redeem', (string) $validated['reward_min_coins_to_redeem'], 'rewards', 'number');

        Setting::clearSettingCache();

        return back()->with('success', 'Health Coins reward rules and limitations updated successfully.');
    }

    /**
     * Perform a manual coin credit or debit for a patient.
     */
    public function manualAdjustment(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'action' => 'required|in:credit,debit',
            'coins' => 'required|integer|min:1',
            'description' => 'required|string|max:255',
        ]);

        $patient = Patient::findOrFail($validated['patient_id']);
        $coinVal = (float) Setting::get('reward_coin_value', '1.00');
        $amountEquivalent = $validated['coins'] * $coinVal;

        if ($validated['action'] === 'credit') {
            $patient->creditCoins(
                $validated['coins'],
                $validated['description'].' (Admin Adjustment)',
                null,
                $amountEquivalent
            );
            $msg = "Successfully credited {$validated['coins']} coins to {$patient->name}.";
        } else {
            if ($patient->reward_coins < $validated['coins']) {
                return back()->with('error', "Cannot debit {$validated['coins']} coins. Patient only has {$patient->reward_coins} coins.");
            }
            $patient->debitCoins(
                $validated['coins'],
                $validated['description'].' (Admin Adjustment)',
                null,
                $amountEquivalent
            );
            $msg = "Successfully debited {$validated['coins']} coins from {$patient->name}.";
        }

        return back()->with('success', $msg);
    }
}
