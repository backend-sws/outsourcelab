@extends('frontend.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 bg-gray-50/50 min-h-screen">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar -->
        @include('patient.layouts.sidebar')

        <!-- Main Content -->
        <div class="w-full md:w-2/3 lg:w-3/4 space-y-8">

            <!-- Golden Health Coins Wallet Hero -->
            <div class="rounded-3xl bg-gradient-to-br from-amber-500 via-amber-600 to-yellow-600 text-white p-6 sm:p-8 shadow-2xl relative overflow-hidden border border-amber-400/40">
                <div class="absolute -right-16 -bottom-16 w-64 h-64 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>
                <div class="absolute right-6 top-6 text-white/10 text-9xl font-black select-none pointer-events-none">
                    <i class="fas fa-coins"></i>
                </div>

                <div class="relative z-10">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md border border-white/20 text-white text-xs font-black uppercase tracking-wider mb-4">
                        <i class="fas fa-coins text-yellow-200"></i> Wellcare Health Coins Loyalty
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-baseline justify-between gap-4">
                        <div>
                            <span class="text-xs uppercase tracking-wider font-extrabold text-amber-100 block mb-1">Available Coin Balance</span>
                            <div class="flex items-baseline gap-3">
                                <h1 class="text-4xl sm:text-5xl font-black tracking-tight text-white flex items-center gap-2">
                                    <span>{{ number_format($coinBalance) }}</span>
                                    <span class="text-2xl sm:text-3xl text-yellow-200">🪙</span>
                                </h1>
                                <span class="text-base sm:text-lg font-bold text-amber-100">
                                    ≈ ₹{{ number_format($inrEquivalent, 2) }}
                                </span>
                            </div>
                            <p class="text-xs text-amber-100/90 font-medium mt-2 max-w-lg">
                                Use your Health Coins during checkout to instantly reduce your booking total. 1 Health Coin = ₹{{ number_format($coinValue, 2) }}.
                            </p>
                        </div>

                        <div class="bg-black/15 backdrop-blur-md border border-white/20 rounded-2xl p-4 sm:p-5 flex items-center gap-6">
                            <div class="text-center">
                                <span class="text-[10px] uppercase tracking-wider font-extrabold text-amber-200 block">Total Earned</span>
                                <span class="text-lg font-black text-white">+{{ number_format($totalEarned) }}</span>
                            </div>
                            <div class="w-px h-8 bg-white/20"></div>
                            <div class="text-center">
                                <span class="text-[10px] uppercase tracking-wider font-extrabold text-amber-200 block">Total Redeemed</span>
                                <span class="text-lg font-black text-white">-{{ number_format($totalRedeemed) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Rule Pills Bar -->
                    <div class="mt-6 pt-5 border-t border-white/20 flex flex-wrap items-center gap-3 text-xs font-semibold text-white/95">
                        <div class="inline-flex items-center gap-1.5 bg-black/10 px-3 py-1.5 rounded-xl border border-white/10">
                            <i class="fas fa-gift text-yellow-200"></i>
                            <span>Earn Rate: <strong>{{ $earnType === 'percentage' ? $earnValue . '% of booking' : $earnValue . ' Flat Coins' }}</strong></span>
                        </div>
                        <div class="inline-flex items-center gap-1.5 bg-black/10 px-3 py-1.5 rounded-xl border border-white/10">
                            <i class="fas fa-tag text-yellow-200"></i>
                            <span>Max Redeem: <strong>{{ $maxRedeemType === 'percentage' ? $maxRedeemValue . '% of bill' : $maxRedeemValue . ' Coins' }}</strong></span>
                        </div>
                        <div class="inline-flex items-center gap-1.5 bg-black/10 px-3 py-1.5 rounded-xl border border-white/10">
                            <i class="fas fa-shopping-bag text-yellow-200"></i>
                            <span>Min Cart to Redeem: <strong>₹{{ number_format($minOrderToRedeem) }}</strong></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- How It Works Section -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6">
                <div>
                    <h2 class="text-lg font-black text-slate-900 flex items-center gap-2">
                        <i class="fas fa-circle-question text-amber-500"></i>
                        <span>How Health Coins Work</span>
                    </h2>
                    <p class="text-xs text-slate-500 mt-1">Earn coins on every diagnostic test booking and redeem them seamlessly on future checkups.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Step 1 -->
                    <div class="p-5 rounded-2xl bg-amber-50/50 border border-amber-100 flex flex-col justify-between">
                        <div>
                            <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center font-black text-base mb-3">
                                1
                            </div>
                            <h3 class="font-black text-slate-900 text-sm mb-1">Book Diagnostic Tests</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Whenever you book lab tests or packages for ₹{{ number_format($minOrderToEarn) }} or more, you automatically qualify for Health Coins.
                            </p>
                        </div>
                        <div class="mt-3 text-[11px] font-bold text-amber-700">
                            Earn: {{ $earnType === 'percentage' ? $earnValue . '%' : $earnValue . ' Coins' }}
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="p-5 rounded-2xl bg-teal-50/50 border border-teal-100 flex flex-col justify-between">
                        <div>
                            <div class="w-10 h-10 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center font-black text-base mb-3">
                                2
                            </div>
                            <h3 class="font-black text-slate-900 text-sm mb-1">Coins Credited Instantly</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Coins are credited straight to your digital health wallet upon successful booking. Watch your balance grow over time.
                            </p>
                        </div>
                        <div class="mt-3 text-[11px] font-bold text-teal-700">
                            Value: 1 Coin = ₹{{ number_format($coinValue, 2) }}
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="p-5 rounded-2xl bg-indigo-50/50 border border-indigo-100 flex flex-col justify-between">
                        <div>
                            <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center font-black text-base mb-3">
                                3
                            </div>
                            <h3 class="font-black text-slate-900 text-sm mb-1">Redeem at Checkout</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Apply your coins during checkout with a single click. Reduce your payable cash amount up to {{ $maxRedeemType === 'percentage' ? $maxRedeemValue . '%' : $maxRedeemValue . ' Coins' }}.
                            </p>
                        </div>
                        <div class="mt-3 text-[11px] font-bold text-indigo-700">
                            Instant Cash Deduction
                        </div>
                    </div>
                </div>

                <!-- Call to Action -->
                <div class="p-4 rounded-2xl bg-gradient-to-r from-teal-800 to-brand-dark text-white flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-amber-300 text-xl font-bold">
                            <i class="fas fa-flask"></i>
                        </div>
                        <div>
                            <h4 class="font-black text-sm">Need a blood test or health checkup?</h4>
                            <p class="text-xs text-teal-100/90 font-medium">Book now, earn coins, and protect your family's health.</p>
                        </div>
                    </div>
                    <a href="{{ route('explore.tests') }}" class="px-5 py-2.5 rounded-xl bg-white text-teal-900 hover:bg-teal-50 font-black text-xs transition shadow-sm whitespace-nowrap">
                        Browse Tests
                    </a>
                </div>
            </div>

            <!-- Transaction Ledger Table -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-black text-slate-900 flex items-center gap-2">
                            <i class="fas fa-list-check text-teal-600"></i>
                            <span>Coins Activity History</span>
                        </h2>
                        <p class="text-xs text-slate-500 mt-0.5">All coin credits, debits, and balance changes.</p>
                    </div>
                    <span class="text-xs font-bold text-slate-400">{{ $transactions->total() }} Total Events</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-slate-100 bg-slate-50/75 text-slate-400 uppercase font-black tracking-wider text-[10px]">
                                <th class="py-3 px-5">Type</th>
                                <th class="py-3 px-5">Coins</th>
                                <th class="py-3 px-5">Amount Equivalent</th>
                                <th class="py-3 px-5">Description</th>
                                <th class="py-3 px-5">Balance After</th>
                                <th class="py-3 px-5">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($transactions as $tx)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <!-- Type -->
                                    <td class="py-3.5 px-5">
                                        @if($tx->type === 'credit')
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                <i class="fas fa-arrow-down-left mr-1"></i> Earned
                                            </span>
                                        @elseif($tx->type === 'debit')
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-rose-50 text-rose-700 border border-rose-200">
                                                <i class="fas fa-arrow-up-right mr-1"></i> Redeemed
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-blue-50 text-blue-700 border border-blue-200">
                                                <i class="fas fa-sliders mr-1"></i> Adjusted
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Coins -->
                                    <td class="py-3.5 px-5">
                                        <span class="font-black text-sm {{ $tx->coins > 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                                            {{ $tx->coins > 0 ? '+' : '' }}{{ number_format($tx->coins) }} 🪙
                                        </span>
                                    </td>

                                    <!-- Equivalent -->
                                    <td class="py-3.5 px-5 font-bold text-slate-700">
                                        ₹{{ number_format($tx->amount_equivalent, 2) }}
                                    </td>

                                    <!-- Description & Booking Ref -->
                                    <td class="py-3.5 px-5">
                                        <div class="font-semibold text-slate-800">{{ $tx->description }}</div>
                                        @if($tx->booking)
                                            <div class="text-[10px] text-teal-600 font-bold mt-0.5">
                                                Ref: {{ $tx->booking->booking_reference }}
                                            </div>
                                        @endif
                                    </td>

                                    <!-- Balance After -->
                                    <td class="py-3.5 px-5 font-mono font-black text-slate-900">
                                        {{ number_format($tx->balance_after) }} 🪙
                                    </td>

                                    <!-- Date -->
                                    <td class="py-3.5 px-5 text-slate-400 font-medium whitespace-nowrap">
                                        {{ $tx->created_at->format('d M Y, h:i A') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-12 text-center text-slate-400">
                                        <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center text-xl mx-auto mb-3">
                                            <i class="fas fa-coins"></i>
                                        </div>
                                        <h4 class="font-bold text-slate-700 text-sm">No Health Coins Yet</h4>
                                        <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">
                                            Book your first diagnostic test to start earning Health Coins today!
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($transactions->hasPages())
                    <div class="p-4 border-t border-slate-100">
                        {{ $transactions->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection
