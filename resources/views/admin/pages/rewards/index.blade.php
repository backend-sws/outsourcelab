@extends('admin.layouts.app')

@section('title', 'Health Coins & Rewards Loyalty System')

@section('content')
<div class="space-y-6">

    <!-- Top Header & Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-amber-500 to-yellow-400 text-white flex items-center justify-center font-bold text-lg shadow-md shadow-amber-500/20">
                    <i class="fas fa-coins"></i>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white">Health Coins & Rewards System</h1>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Flexible reward points engine: configure booking earn rates, coin valuation, and checkout redemption limitations.</p>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3 flex-wrap">
            <button onclick="openAdjustmentModal()" class="px-4 py-2.5 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-600 text-slate-950 transition flex items-center gap-2 shadow-sm shadow-amber-500/30">
                <i class="fas fa-hand-holding-dollar"></i>
                <span>Manual Coin Adjustment</span>
            </button>
        </div>
    </div>

    <!-- Metric Counters -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- 1. Total Distributed -->
        <div class="p-5 rounded-2xl bg-white dark:bg-white/[0.02] border border-slate-200/80 dark:border-white/[0.05] shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400">Total Coins Distributed</span>
                <h3 class="text-2xl font-black text-slate-900 dark:text-white mt-1">{{ number_format($totalCoinsDistributed) }}</h3>
                <span class="text-[11px] text-emerald-500 font-bold mt-1 inline-block">≈ ₹{{ number_format($totalCoinsDistributed * $settings['reward_coin_value'], 2) }}</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-amber-500/10 text-amber-500 flex items-center justify-center text-xl">
                <i class="fas fa-gift"></i>
            </div>
        </div>

        <!-- 2. Total Redeemed -->
        <div class="p-5 rounded-2xl bg-white dark:bg-white/[0.02] border border-slate-200/80 dark:border-white/[0.05] shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400">Total Coins Redeemed</span>
                <h3 class="text-2xl font-black text-slate-900 dark:text-white mt-1">{{ number_format($totalCoinsRedeemed) }}</h3>
                <span class="text-[11px] text-rose-500 font-bold mt-1 inline-block">≈ ₹{{ number_format($totalCoinsRedeemed * $settings['reward_coin_value'], 2) }} Used</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-rose-50 dark:bg-rose-500/10 text-rose-500 flex items-center justify-center text-xl">
                <i class="fas fa-receipt"></i>
            </div>
        </div>

        <!-- 3. Total Circulating in Wallets -->
        <div class="p-5 rounded-2xl bg-white dark:bg-white/[0.02] border border-slate-200/80 dark:border-white/[0.05] shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400">Circulating Coins</span>
                <h3 class="text-2xl font-black text-slate-900 dark:text-white mt-1">{{ number_format($totalCirculatingCoins) }}</h3>
                <span class="text-[11px] text-teal-600 font-bold mt-1 inline-block">≈ ₹{{ number_format($totalCirculatingCoins * $settings['reward_coin_value'], 2) }} Liability</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-teal-50 dark:bg-teal-500/10 text-teal-600 flex items-center justify-center text-xl">
                <i class="fas fa-wallet"></i>
            </div>
        </div>

        <!-- 4. Active Patient Wallets -->
        <div class="p-5 rounded-2xl bg-white dark:bg-white/[0.02] border border-slate-200/80 dark:border-white/[0.05] shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400">Active Coin Wallets</span>
                <h3 class="text-2xl font-black text-slate-900 dark:text-white mt-1">{{ number_format($totalActiveWallets) }}</h3>
                <span class="text-[11px] text-slate-400 font-bold mt-1 inline-block">Patients holding coins</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-500/10 text-indigo-500 flex items-center justify-center text-xl">
                <i class="fas fa-users-gear"></i>
            </div>
        </div>
    </div>

    <!-- Reward Rules Engine Form -->
    <form action="{{ route('admin.rewards.update') }}" method="POST" class="space-y-6">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- Card 1: Earning Rules -->
            <div class="bg-white dark:bg-white/[0.02] border border-slate-200/80 dark:border-white/[0.05] rounded-2xl p-6 shadow-sm">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-white/[0.05] mb-5">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 flex items-center justify-center text-sm font-black">
                            <i class="fas fa-arrow-down-left"></i>
                        </div>
                        <div>
                            <h3 class="font-black text-slate-900 dark:text-white text-base">Booking Earn Rules</h3>
                            <p class="text-xs text-slate-500">Configure how many Health Coins patients earn upon booking.</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="reward_enabled" value="1" class="sr-only peer" {{ $settings['reward_enabled'] == '1' ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                        <span class="ml-2 text-xs font-black text-slate-700 dark:text-slate-300">Active</span>
                    </label>
                </div>

                <div class="space-y-4">
                    <!-- Coin Display Name -->
                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                            Reward Coin Name
                        </label>
                        <input type="text" name="reward_coin_name" value="{{ old('reward_coin_name', $settings['reward_coin_name']) }}" required
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-white/[0.08] bg-slate-50 dark:bg-white/[0.02] text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500 font-bold">
                    </div>

                    <!-- 1 Coin Cash Valuation -->
                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                            Coin Valuation (₹ in Cash)
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 font-black text-slate-400 text-sm">1 Coin = ₹</span>
                            <input type="number" step="0.01" min="0.01" name="reward_coin_value" value="{{ old('reward_coin_value', $settings['reward_coin_value']) }}" required
                                class="w-full pl-24 pr-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-white/[0.08] bg-slate-50 dark:bg-white/[0.02] text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500 font-bold">
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">E.g., 1.00 means 1 Coin equals ₹1 discount during redemption.</p>
                    </div>

                    <!-- Earning Mode (Percentage vs Flat) -->
                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                            Earning Calculation Mode
                        </label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="flex items-center gap-2 p-3 rounded-xl border border-slate-200 dark:border-white/[0.08] bg-slate-50 dark:bg-white/[0.02] cursor-pointer has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50/20">
                                <input type="radio" name="reward_earn_type" value="percentage" {{ $settings['reward_earn_type'] === 'percentage' ? 'checked' : '' }} class="accent-emerald-600">
                                <div>
                                    <span class="text-xs font-bold text-slate-900 dark:text-white block">Percentage (%)</span>
                                    <span class="text-[10px] text-slate-400 block">% of booking amount</span>
                                </div>
                            </label>

                            <label class="flex items-center gap-2 p-3 rounded-xl border border-slate-200 dark:border-white/[0.08] bg-slate-50 dark:bg-white/[0.02] cursor-pointer has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50/20">
                                <input type="radio" name="reward_earn_type" value="flat" {{ $settings['reward_earn_type'] === 'flat' ? 'checked' : '' }} class="accent-emerald-600">
                                <div>
                                    <span class="text-xs font-bold text-slate-900 dark:text-white block">Flat Coins</span>
                                    <span class="text-[10px] text-slate-400 block">Fixed coins per order</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Earning Value -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                                Earn Rate Value
                            </label>
                            <input type="number" step="0.1" min="0" name="reward_earn_value" value="{{ old('reward_earn_value', $settings['reward_earn_value']) }}" required
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-white/[0.08] bg-slate-50 dark:bg-white/[0.02] text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500 font-bold">
                            <p class="text-[10px] text-slate-400 mt-1">If Percentage: e.g. 5 means 5% of order. If Flat: 50 means 50 Coins.</p>
                        </div>

                        <!-- Minimum Order to Earn -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                                Min Cart Value to Earn (₹)
                            </label>
                            <input type="number" step="1" min="0" name="reward_min_order_to_earn" value="{{ old('reward_min_order_to_earn', $settings['reward_min_order_to_earn']) }}" required
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-white/[0.08] bg-slate-50 dark:bg-white/[0.02] text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500 font-bold">
                            <p class="text-[10px] text-slate-400 mt-1">Orders below this amount won't earn coins.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Redemption Limitations Engine -->
            <div class="bg-white dark:bg-white/[0.02] border border-slate-200/80 dark:border-white/[0.05] rounded-2xl p-6 shadow-sm">
                <div class="flex items-center gap-2.5 pb-4 border-b border-slate-100 dark:border-white/[0.05] mb-5">
                    <div class="w-8 h-8 rounded-lg bg-amber-50 dark:bg-amber-500/10 text-amber-600 flex items-center justify-center text-sm font-black">
                        <i class="fas fa-hand-holding-dollar"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-slate-900 dark:text-white text-base">Redemption Limitations</h3>
                        <p class="text-xs text-slate-500">Configure how and how much patients can redeem on checkout.</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <!-- Max Redemption Mode (Percentage vs Flat) -->
                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                            Maximum Redemption Limitation Mode
                        </label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="flex items-center gap-2 p-3 rounded-xl border border-slate-200 dark:border-white/[0.08] bg-slate-50 dark:bg-white/[0.02] cursor-pointer has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50/20">
                                <input type="radio" name="reward_max_redeem_type" value="percentage" {{ $settings['reward_max_redeem_type'] === 'percentage' ? 'checked' : '' }} class="accent-amber-600">
                                <div>
                                    <span class="text-xs font-bold text-slate-900 dark:text-white block">Max % of Order Bill</span>
                                    <span class="text-[10px] text-slate-400 block">Cap discount as % of payable</span>
                                </div>
                            </label>

                            <label class="flex items-center gap-2 p-3 rounded-xl border border-slate-200 dark:border-white/[0.08] bg-slate-50 dark:bg-white/[0.02] cursor-pointer has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50/20">
                                <input type="radio" name="reward_max_redeem_type" value="flat" {{ $settings['reward_max_redeem_type'] === 'flat' ? 'checked' : '' }} class="accent-amber-600">
                                <div>
                                    <span class="text-xs font-bold text-slate-900 dark:text-white block">Flat Max Coins</span>
                                    <span class="text-[10px] text-slate-400 block">Cap at maximum X coins</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Max Redemption Limit Value -->
                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                            Max Redemption Limit Value
                        </label>
                        <input type="number" step="0.5" min="0" name="reward_max_redeem_value" value="{{ old('reward_max_redeem_value', $settings['reward_max_redeem_value']) }}" required
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-white/[0.08] bg-slate-50 dark:bg-white/[0.02] text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500 font-bold">
                        <p class="text-[10px] text-slate-400 mt-1">E.g. If % mode: 20 means patient can pay max 20% of order with coins. If flat: 100 means max 100 coins per order.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Minimum Order to Redeem -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                                Min Order Value to Redeem (₹)
                            </label>
                            <input type="number" step="1" min="0" name="reward_min_order_to_redeem" value="{{ old('reward_min_order_to_redeem', $settings['reward_min_order_to_redeem']) }}" required
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-white/[0.08] bg-slate-50 dark:bg-white/[0.02] text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500 font-bold">
                            <p class="text-[10px] text-slate-400 mt-1">E.g., Cart must be at least ₹200 to unlock coin redemption.</p>
                        </div>

                        <!-- Minimum Coin Balance to Unlock -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                                Min Coins to Unlock Redemption
                            </label>
                            <input type="number" step="1" min="0" name="reward_min_coins_to_redeem" value="{{ old('reward_min_coins_to_redeem', $settings['reward_min_coins_to_redeem']) }}" required
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-white/[0.08] bg-slate-50 dark:bg-white/[0.02] text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500 font-bold">
                            <p class="text-[10px] text-slate-400 mt-1">Patient must hold at least this many coins.</p>
                        </div>
                    </div>

                    <!-- Live Rule Summary Preview Callout -->
                    <div class="p-3.5 rounded-xl bg-amber-50 dark:bg-amber-500/10 border border-amber-200 dark:border-amber-500/20 text-amber-900 dark:text-amber-300 text-xs">
                        <div class="font-black flex items-center gap-1.5 mb-1">
                            <i class="fas fa-circle-info"></i>
                            <span>Current Policy in Effect:</span>
                        </div>
                        <ul class="list-disc list-inside space-y-0.5 text-[11px] font-medium text-amber-800 dark:text-amber-200">
                            <li>Patient earns <strong>{{ $settings['reward_earn_type'] === 'percentage' ? $settings['reward_earn_value'] . '%' : $settings['reward_earn_value'] . ' Flat Coins' }}</strong> on bookings ≥ ₹{{ number_format($settings['reward_min_order_to_earn']) }}.</li>
                            <li>Can redeem max <strong>{{ $settings['reward_max_redeem_type'] === 'percentage' ? $settings['reward_max_redeem_value'] . '% of order' : $settings['reward_max_redeem_value'] . ' coins' }}</strong> on orders ≥ ₹{{ number_format($settings['reward_min_order_to_redeem']) }}.</li>
                            <li>1 Coin = <strong>₹{{ number_format($settings['reward_coin_value'], 2) }}</strong> discount.</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>

        <!-- Save Button -->
        <div class="flex justify-end">
            <button type="submit" class="px-6 py-3 rounded-xl text-xs font-black bg-emerald-600 hover:bg-emerald-700 text-white transition flex items-center gap-2 shadow-md shadow-emerald-600/20">
                <i class="fas fa-floppy-disk"></i>
                <span>Save Reward Rules & Limitations</span>
            </button>
        </div>
    </form>

    <!-- Reward Transactions Ledger -->
    <div class="bg-white dark:bg-white/[0.02] border border-slate-200/80 dark:border-white/[0.05] rounded-2xl overflow-hidden shadow-sm">
        
        <!-- Table Header & Search -->
        <div class="p-5 border-b border-slate-100 dark:border-white/[0.05] flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="font-black text-slate-900 dark:text-white text-base">Health Coins Transaction Ledger</h3>
                <p class="text-xs text-slate-500">Real-time audit log of all coin credits, checkout redemptions, and admin adjustments.</p>
            </div>

            <!-- Filters -->
            <form method="GET" action="{{ route('admin.rewards.index') }}" class="flex items-center gap-2.5 flex-wrap">
                <select name="type" onchange="this.form.submit()" class="px-3 py-2 rounded-xl text-xs font-bold border border-slate-200 dark:border-white/[0.08] bg-slate-50 dark:bg-white/[0.02] text-slate-700 dark:text-slate-300">
                    <option value="">All Types</option>
                    <option value="credit" {{ request('type') === 'credit' ? 'selected' : '' }}>Credits (+)</option>
                    <option value="debit" {{ request('type') === 'debit' ? 'selected' : '' }}>Debits / Redemptions (-)</option>
                    <option value="adjustment" {{ request('type') === 'adjustment' ? 'selected' : '' }}>Adjustments</option>
                </select>

                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search patient, ref, desc..."
                        class="pl-8 pr-3 py-2 rounded-xl text-xs border border-slate-200 dark:border-white/[0.08] bg-slate-50 dark:bg-white/[0.02] text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                    <i class="fas fa-search absolute left-2.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                </div>

                <button type="submit" class="px-3 py-2 rounded-xl text-xs font-bold bg-slate-900 dark:bg-white/10 text-white hover:bg-slate-800 transition">Filter</button>
                @if(request()->hasAny(['type', 'search']))
                    <a href="{{ route('admin.rewards.index') }}" class="px-2 py-2 text-xs text-slate-400 hover:text-slate-600 font-bold">Reset</a>
                @endif
            </form>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="border-b border-slate-100 dark:border-white/[0.05] bg-slate-50/50 dark:bg-white/[0.01] text-slate-400 uppercase font-black tracking-wider text-[10px]">
                        <th class="py-3 px-4">Patient</th>
                        <th class="py-3 px-4">Type</th>
                        <th class="py-3 px-4">Coins</th>
                        <th class="py-3 px-4">Equivalent (₹)</th>
                        <th class="py-3 px-4">Description / Booking</th>
                        <th class="py-3 px-4">Balance After</th>
                        <th class="py-3 px-4">Timestamp</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-white/[0.05]">
                    @forelse($transactions as $tx)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-white/[0.01] transition">
                            <!-- Patient -->
                            <td class="py-3 px-4">
                                @if($tx->patient)
                                    <div class="font-bold text-slate-900 dark:text-white">{{ $tx->patient->name }}</div>
                                    <div class="text-[11px] text-slate-400 font-mono">{{ $tx->patient->mobile }}</div>
                                @else
                                    <span class="text-slate-400">Deleted Patient</span>
                                @endif
                            </td>

                            <!-- Type Badge -->
                            <td class="py-3 px-4">
                                @if($tx->type === 'credit')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20">
                                        Credit
                                    </span>
                                @elseif($tx->type === 'debit')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-rose-50 text-rose-600 dark:bg-rose-500/10 dark:text-rose-400 border border-rose-200 dark:border-rose-500/20">
                                        Debit / Redeem
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400 border border-blue-200 dark:border-blue-500/20">
                                        Adjustment
                                    </span>
                                @endif
                            </td>

                            <!-- Coins -->
                            <td class="py-3 px-4">
                                <span class="font-black text-sm {{ $tx->coins > 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                    {{ $tx->coins > 0 ? '+' : '' }}{{ number_format($tx->coins) }} 🪙
                                </span>
                            </td>

                            <!-- Equivalent Cash -->
                            <td class="py-3 px-4 font-bold text-slate-700 dark:text-slate-300">
                                ₹{{ number_format($tx->amount_equivalent, 2) }}
                            </td>

                            <!-- Description / Booking -->
                            <td class="py-3 px-4">
                                <div class="text-slate-800 dark:text-slate-200 font-medium">{{ $tx->description }}</div>
                                @if($tx->booking)
                                    <div class="text-[10px] font-mono text-teal-600 font-bold mt-0.5">
                                        Ref: {{ $tx->booking->booking_reference }}
                                    </div>
                                @endif
                            </td>

                            <!-- Balance After -->
                            <td class="py-3 px-4 font-mono font-black text-slate-900 dark:text-white">
                                {{ number_format($tx->balance_after) }} 🪙
                            </td>

                            <!-- Date -->
                            <td class="py-3 px-4 text-slate-400 font-medium whitespace-nowrap">
                                {{ $tx->created_at->format('d M Y, h:i A') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400">
                                <i class="fas fa-coins text-2xl text-slate-300 mb-2 block"></i>
                                No reward transactions found yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($transactions->hasPages())
            <div class="p-4 border-t border-slate-100 dark:border-white/[0.05]">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Manual Adjustment Modal -->
<div id="adjustmentModal" class="hidden fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-white/[0.1] rounded-2xl w-full max-w-md p-6 shadow-2xl space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-white/[0.05]">
            <h3 class="font-black text-slate-900 dark:text-white text-base flex items-center gap-2">
                <i class="fas fa-coins text-amber-500"></i>
                <span>Manual Coin Adjustment</span>
            </h3>
            <button onclick="closeAdjustmentModal()" class="w-7 h-7 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form action="{{ route('admin.rewards.adjust') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Patient Dropdown -->
            <div>
                <label class="block text-xs font-black uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Select Patient
                </label>
                <select name="patient_id" required class="w-full px-3 py-2.5 rounded-xl border border-slate-200 dark:border-white/[0.08] bg-slate-50 dark:bg-white/[0.02] text-xs font-bold text-slate-900 dark:text-white">
                    <option value="">-- Choose Patient --</option>
                    @foreach($patients as $p)
                        <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->mobile }}) - Current: {{ $p->reward_coins }} Coins</option>
                    @endforeach
                </select>
            </div>

            <!-- Action -->
            <div>
                <label class="block text-xs font-black uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Action Type
                </label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="flex items-center gap-2 p-2.5 rounded-xl border border-slate-200 dark:border-white/[0.08] cursor-pointer has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50/20">
                        <input type="radio" name="action" value="credit" checked class="accent-emerald-600">
                        <span class="text-xs font-bold text-emerald-600">+ Credit Coins</span>
                    </label>
                    <label class="flex items-center gap-2 p-2.5 rounded-xl border border-slate-200 dark:border-white/[0.08] cursor-pointer has-[:checked]:border-rose-500 has-[:checked]:bg-rose-50/20">
                        <input type="radio" name="action" value="debit" class="accent-rose-600">
                        <span class="text-xs font-bold text-rose-600">- Debit Coins</span>
                    </label>
                </div>
            </div>

            <!-- Coins Amount -->
            <div>
                <label class="block text-xs font-black uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Number of Coins
                </label>
                <input type="number" step="1" min="1" name="coins" placeholder="e.g. 50" required
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-white/[0.08] bg-slate-50 dark:bg-white/[0.02] text-sm text-slate-900 dark:text-white font-bold">
            </div>

            <!-- Reason / Description -->
            <div>
                <label class="block text-xs font-black uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Reason / Note
                </label>
                <input type="text" name="description" placeholder="e.g. Goodwill gesture / Festival bonus" required
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-white/[0.08] bg-slate-50 dark:bg-white/[0.02] text-xs text-slate-900 dark:text-white">
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="closeAdjustmentModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-500 hover:bg-slate-100">Cancel</button>
                <button type="submit" class="px-5 py-2 rounded-xl text-xs font-black bg-amber-500 hover:bg-amber-600 text-slate-950 shadow-sm">Submit Adjustment</button>
            </div>
        </form>
    </div>
</div>

<script>
function openAdjustmentModal() {
    document.getElementById('adjustmentModal').classList.remove('hidden');
}
function closeAdjustmentModal() {
    document.getElementById('adjustmentModal').classList.add('hidden');
}
</script>
@endsection
