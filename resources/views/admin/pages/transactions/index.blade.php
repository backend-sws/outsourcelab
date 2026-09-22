@extends('admin.layouts.app')

@section('content')
<div class="space-y-6">

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-emerald-500 to-teal-400 flex items-center justify-center text-white shadow-md shadow-emerald-500/20">
                    <i class="fas fa-receipt text-lg"></i>
                </div>
                <span>Payment Transactions & Gateway Logs</span>
            </h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Real-time Razorpay gateway transactions, webhook event audit trails, and customer payment histories.</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.settings.index') }}#razorpay" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-white/10 hover:bg-slate-200 dark:hover:bg-white/15 text-slate-700 dark:text-white text-xs font-bold transition">
                <i class="fas fa-sliders text-emerald-500"></i>
                <span>Gateway Settings</span>
            </a>
            <button onclick="window.location.reload()" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-black shadow-md shadow-emerald-600/20 transition">
                <i class="fas fa-arrows-rotate"></i>
                <span>Refresh Logs</span>
            </button>
        </div>
    </div>

    <!-- KPI Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Revenue Collected -->
        <div class="glass-card rounded-2xl p-5 border border-slate-200/80 dark:border-white/10 relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Total Online Revenue</span>
                    <h3 class="text-2xl font-black text-slate-900 dark:text-white">₹{{ number_format($totalVolume, 2) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xl font-black">
                    <i class="fas fa-wallet"></i>
                </div>
            </div>
            <div class="mt-3 flex items-center gap-1.5 text-[11px] font-bold text-emerald-600 dark:text-emerald-400">
                <i class="fas fa-shield-halved text-xs"></i>
                <span>Captured via Razorpay</span>
            </div>
        </div>

        <!-- Successful Payments -->
        <div class="glass-card rounded-2xl p-5 border border-slate-200/80 dark:border-white/10 relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Successful Payments</span>
                    <h3 class="text-2xl font-black text-slate-900 dark:text-white">{{ number_format($successfulCount) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-xl font-black">
                    <i class="fas fa-circle-check"></i>
                </div>
            </div>
            <div class="mt-3 flex items-center gap-1.5 text-[11px] font-bold text-indigo-600 dark:text-indigo-400">
                <i class="fas fa-bolt text-xs"></i>
                <span>Instant Auto-Captured</span>
            </div>
        </div>

        <!-- Today's Collection -->
        <div class="glass-card rounded-2xl p-5 border border-slate-200/80 dark:border-white/10 relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Today's Collections</span>
                    <h3 class="text-2xl font-black text-amber-600 dark:text-amber-400">₹{{ number_format($todayCollection, 2) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center text-xl font-black">
                    <i class="fas fa-calendar-day"></i>
                </div>
            </div>
            <div class="mt-3 flex items-center gap-1.5 text-[11px] font-bold text-slate-500 dark:text-slate-400">
                <i class="far fa-clock text-xs"></i>
                <span>Since Midnight</span>
            </div>
        </div>

        <!-- Failed Attempts -->
        <div class="glass-card rounded-2xl p-5 border border-slate-200/80 dark:border-white/10 relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Failed / Aborted</span>
                    <h3 class="text-2xl font-black text-rose-600 dark:text-rose-400">{{ number_format($failedCount) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-rose-50 dark:bg-rose-500/10 text-rose-600 dark:text-rose-400 flex items-center justify-center text-xl font-black">
                    <i class="fas fa-triangle-exclamation"></i>
                </div>
            </div>
            <div class="mt-3 flex items-center gap-1.5 text-[11px] font-bold text-rose-500">
                <i class="fas fa-bug text-xs"></i>
                <span>Error details logged</span>
            </div>
        </div>
    </div>

    <!-- Search & Filter Bar -->
    <div class="glass-card rounded-2xl p-5 border border-slate-200/80 dark:border-white/10">
        <form method="GET" action="{{ route('admin.transactions.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3.5">
            <!-- Search Query -->
            <div class="lg:col-span-4">
                <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1.5">Search Keyword</label>
                <div class="relative">
                    <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Txn Ref, Razorpay ID, Patient Phone..."
                        class="w-full pl-9 pr-3 py-2 rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] text-xs font-semibold text-slate-800 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
            </div>

            <!-- Status Dropdown -->
            <div class="lg:col-span-2">
                <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1.5">Payment Status</label>
                <select name="status" class="w-full px-3 py-2 rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white focus:ring-2 focus:ring-emerald-500 outline-none">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Statuses</option>
                    <option value="captured" {{ request('status') == 'captured' ? 'selected' : '' }}>Captured / Success</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                    <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                </select>
            </div>

            <!-- Method Dropdown -->
            <div class="lg:col-span-2">
                <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1.5">Payment Method</label>
                <select name="method" class="w-full px-3 py-2 rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white focus:ring-2 focus:ring-emerald-500 outline-none">
                    <option value="all" {{ request('method') == 'all' ? 'selected' : '' }}>All Methods</option>
                    <option value="upi" {{ request('method') == 'upi' ? 'selected' : '' }}>UPI (GPay / PhonePe)</option>
                    <option value="card" {{ request('method') == 'card' ? 'selected' : '' }}>Debit / Credit Card</option>
                    <option value="netbanking" {{ request('method') == 'netbanking' ? 'selected' : '' }}>Netbanking</option>
                    <option value="wallet" {{ request('method') == 'wallet' ? 'selected' : '' }}>Wallet</option>
                    <option value="cash" {{ request('method') == 'cash' ? 'selected' : '' }}>Cash on Collection</option>
                </select>
            </div>

            <!-- Type Dropdown -->
            <div class="lg:col-span-2">
                <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1.5">Transaction Type</label>
                <select name="type" class="w-full px-3 py-2 rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white focus:ring-2 focus:ring-emerald-500 outline-none">
                    <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>All Types</option>
                    <option value="booking" {{ request('type') == 'booking' ? 'selected' : '' }}>Lab Tests Booking</option>
                    <option value="membership" {{ request('type') == 'membership' ? 'selected' : '' }}>VIP Membership</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="lg:col-span-2 flex items-end gap-2">
                <button type="submit" class="flex-1 bg-emerald-600 hover:bg-emerald-500 text-white font-black py-2 rounded-xl text-xs transition shadow-md shadow-emerald-600/20 flex items-center justify-center gap-1.5">
                    <i class="fas fa-filter text-xs"></i> Filter
                </button>
                <a href="{{ route('admin.transactions.index') }}" class="p-2 rounded-xl border border-slate-200 dark:border-white/10 hover:bg-slate-100 dark:hover:bg-white/10 text-slate-500 text-xs flex items-center justify-center" title="Reset Filters">
                    <i class="fas fa-rotate-left"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Transactions Table Card -->
    <div class="glass-card rounded-3xl border border-slate-200/80 dark:border-white/10 overflow-hidden shadow-sm">
        <div class="p-5 border-b border-slate-200/80 dark:border-white/10 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h3 class="font-black text-slate-900 dark:text-white text-base">Transaction Log Records</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Showing latest {{ $transactions->count() }} of {{ $transactions->total() }} recorded gateway transactions</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold text-slate-400">Auto-synced via Webhooks</span>
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-200/80 dark:border-white/10 bg-slate-50/50 dark:bg-white/[0.02] text-[11px] font-black uppercase tracking-wider text-slate-400">
                        <th class="py-3.5 px-5">Ref / Timestamp</th>
                        <th class="py-3.5 px-5">Patient Details</th>
                        <th class="py-3.5 px-5">Service / Order</th>
                        <th class="py-3.5 px-5">Gateway IDs</th>
                        <th class="py-3.5 px-5">Amount</th>
                        <th class="py-3.5 px-5">Method</th>
                        <th class="py-3.5 px-5">Status</th>
                        <th class="py-3.5 px-5 text-right">Audit</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-white/[0.06] text-xs">
                    @forelse($transactions as $txn)
                    @php
                        $badge = $txn->status_badge;
                    @endphp
                    <tr class="hover:bg-slate-50/60 dark:hover:bg-white/[0.02] transition">
                        <!-- Ref / Timestamp -->
                        <td class="py-4 px-5">
                            <span class="font-mono font-black text-slate-900 dark:text-white block">{{ $txn->transaction_reference }}</span>
                            <span class="text-[11px] text-slate-400 flex items-center gap-1 mt-0.5">
                                <i class="far fa-clock text-[10px]"></i>
                                <span>{{ $txn->created_at->format('d M Y, h:i A') }}</span>
                            </span>
                        </td>

                        <!-- Patient Details -->
                        <td class="py-4 px-5">
                            @if($txn->patient)
                                <span class="font-extrabold text-slate-800 dark:text-slate-200 block">{{ $txn->patient->name }}</span>
                                <span class="text-[11px] text-slate-400 block font-mono">{{ $txn->patient->mobile }}</span>
                            @else
                                <span class="text-slate-400 italic">Guest / Unknown</span>
                            @endif
                        </td>

                        <!-- Service / Order -->
                        <td class="py-4 px-5">
                            @if($txn->type === 'booking' && $txn->booking)
                                <a href="{{ route('admin.bookings.index', ['search' => $txn->booking->booking_reference]) }}" class="inline-flex items-center gap-1.5 font-bold text-teal-600 dark:text-teal-400 hover:underline">
                                    <i class="fas fa-flask text-xs"></i>
                                    <span>#{{ $txn->booking->booking_reference }}</span>
                                </a>
                                <span class="text-[10px] text-slate-400 block uppercase font-bold">Lab Test Booking</span>
                            @elseif($txn->type === 'membership')
                                <span class="inline-flex items-center gap-1 text-amber-600 dark:text-amber-400 font-bold">
                                    <i class="fas fa-crown text-xs"></i>
                                    <span>VIP Pass</span>
                                </span>
                                <span class="text-[10px] text-slate-400 block">{{ $txn->request_payload['plan_name'] ?? 'Membership' }}</span>
                            @else
                                <span class="text-slate-500 font-medium">Diagnostic Service</span>
                            @endif
                        </td>

                        <!-- Gateway IDs -->
                        <td class="py-4 px-5 font-mono text-[11px]">
                            @if($txn->razorpay_order_id)
                                <div class="flex items-center gap-1 text-slate-600 dark:text-slate-300">
                                    <span class="text-[10px] text-slate-400 font-sans uppercase font-bold">Ord:</span>
                                    <span>{{ $txn->razorpay_order_id }}</span>
                                </div>
                            @endif
                            @if($txn->razorpay_payment_id)
                                <div class="flex items-center gap-1 text-emerald-600 dark:text-emerald-400 font-bold mt-0.5">
                                    <span class="text-[10px] text-slate-400 font-sans uppercase font-bold">Pay:</span>
                                    <span>{{ $txn->razorpay_payment_id }}</span>
                                </div>
                            @endif
                            @if(!$txn->razorpay_order_id && !$txn->razorpay_payment_id)
                                <span class="text-slate-400 italic">No gateway ref</span>
                            @endif
                        </td>

                        <!-- Amount -->
                        <td class="py-4 px-5">
                            <span class="font-black text-slate-900 dark:text-white text-sm">₹{{ number_format($txn->amount, 2) }}</span>
                            <span class="text-[10px] text-slate-400 block uppercase">{{ $txn->currency }}</span>
                        </td>

                        <!-- Method -->
                        <td class="py-4 px-5">
                            <div class="flex items-center gap-1.5">
                                <i class="fas {{ $txn->method_icon }} text-xs"></i>
                                <span class="font-bold uppercase tracking-wider text-[11px] text-slate-700 dark:text-slate-300">
                                    {{ $txn->payment_method ?: 'Online' }}
                                </span>
                            </div>
                            @if($txn->vpa)
                                <span class="text-[10px] text-slate-400 font-mono block truncate max-w-[120px]">{{ $txn->vpa }}</span>
                            @elseif($txn->bank)
                                <span class="text-[10px] text-slate-400 block">{{ $txn->bank }}</span>
                            @endif
                        </td>

                        <!-- Status Badge -->
                        <td class="py-4 px-5">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-black border {{ $badge['class'] }}">
                                <i class="fas {{ $badge['icon'] }} text-[10px]"></i>
                                <span>{{ $badge['label'] }}</span>
                            </span>
                        </td>

                        <!-- Audit Action -->
                        <td class="py-4 px-5 text-right">
                            <button type="button" onclick="viewAuditModal({{ $txn->id }})" class="p-2 rounded-xl bg-slate-100 dark:bg-white/10 hover:bg-emerald-50 hover:text-emerald-600 dark:hover:bg-emerald-500/20 dark:hover:text-emerald-400 transition text-slate-600 dark:text-slate-300 shadow-2xs" title="View Payload & Details">
                                <i class="fas fa-file-code"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-12 text-slate-400">
                            <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-white/5 flex items-center justify-center mx-auto mb-3 text-2xl text-slate-400">
                                <i class="fas fa-receipt"></i>
                            </div>
                            <p class="font-bold text-sm text-slate-600 dark:text-slate-300">No payment transactions found</p>
                            <p class="text-xs text-slate-400 mt-1">Transactions will appear automatically as patients checkout or pay online.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($transactions->hasPages())
        <div class="p-4 border-t border-slate-200/80 dark:border-white/10">
            {{ $transactions->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Transaction Audit Details Modal -->
<div id="auditModal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-900 rounded-3xl max-w-3xl w-full border border-slate-200 dark:border-white/10 shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
        <!-- Modal Header -->
        <div class="p-5 border-b border-slate-200/80 dark:border-white/10 flex items-center justify-between bg-slate-50/50 dark:bg-white/[0.02]">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-lg">
                    <i class="fas fa-code-compare"></i>
                </div>
                <div>
                    <h3 class="font-black text-slate-900 dark:text-white text-base">Gateway Audit Trail & Raw Payload</h3>
                    <p class="text-xs text-slate-400" id="modalTxnRef">Loading...</p>
                </div>
            </div>
            <button type="button" onclick="closeAuditModal()" class="w-8 h-8 rounded-full bg-slate-100 dark:bg-white/10 hover:bg-slate-200 text-slate-500 flex items-center justify-center">
                <i class="fas fa-times text-xs"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-6 overflow-y-auto space-y-4 text-xs">
            <!-- Key Facts Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 bg-slate-50 dark:bg-white/[0.02] p-4 rounded-2xl border border-slate-200/60 dark:border-white/10">
                <div>
                    <span class="text-[10px] uppercase font-bold text-slate-400 block">Amount</span>
                    <span class="text-sm font-black text-slate-900 dark:text-white" id="modalAmount">-</span>
                </div>
                <div>
                    <span class="text-[10px] uppercase font-bold text-slate-400 block">Status</span>
                    <span class="text-xs font-black" id="modalStatus">-</span>
                </div>
                <div>
                    <span class="text-[10px] uppercase font-bold text-slate-400 block">Method</span>
                    <span class="text-xs font-bold text-slate-800 dark:text-slate-200" id="modalMethod">-</span>
                </div>
                <div>
                    <span class="text-[10px] uppercase font-bold text-slate-400 block">Paid Timestamp</span>
                    <span class="text-xs font-mono text-slate-600 dark:text-slate-400" id="modalPaidAt">-</span>
                </div>
            </div>

            <!-- Error Banner (if any) -->
            <div id="modalErrorContainer" class="hidden p-3.5 rounded-2xl bg-rose-50 dark:bg-rose-500/10 border border-rose-200 dark:border-rose-500/20 text-rose-700 dark:text-rose-400">
                <span class="font-black uppercase tracking-wider text-[10px] block" id="modalErrorCode">ERROR</span>
                <p class="text-xs mt-0.5" id="modalErrorDesc"></p>
            </div>

            <!-- Tabs: Response vs Webhook vs Request -->
            <div>
                <div class="flex space-x-2 border-b border-slate-200 dark:border-white/10 pb-2 mb-3">
                    <button type="button" onclick="switchPayloadTab('response')" id="tabBtn-response" class="px-3 py-1.5 rounded-xl font-black text-xs bg-emerald-600 text-white">Gateway Response</button>
                    <button type="button" onclick="switchPayloadTab('webhook')" id="tabBtn-webhook" class="px-3 py-1.5 rounded-xl font-bold text-xs bg-slate-100 dark:bg-white/10 text-slate-600 dark:text-slate-300">Webhook Payload</button>
                    <button type="button" onclick="switchPayloadTab('request')" id="tabBtn-request" class="px-3 py-1.5 rounded-xl font-bold text-xs bg-slate-100 dark:bg-white/10 text-slate-600 dark:text-slate-300">Request Data</button>
                </div>

                <div id="payloadContainer" class="bg-slate-950 text-emerald-400 p-4 rounded-2xl font-mono text-[11px] overflow-x-auto max-h-72 leading-relaxed">
                    <pre id="payloadCodeContent">// Select a tab to inspect payload</pre>
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="p-4 border-t border-slate-200/80 dark:border-white/10 flex justify-end bg-slate-50/50 dark:bg-white/[0.02]">
            <button type="button" onclick="closeAuditModal()" class="px-5 py-2 rounded-xl bg-slate-200 dark:bg-white/10 hover:bg-slate-300 text-slate-700 dark:text-white font-bold text-xs">
                Close Audit
            </button>
        </div>
    </div>
</div>

<script>
    let activeTxnData = null;

    function viewAuditModal(txnId) {
        document.getElementById('auditModal').classList.remove('hidden');
        document.getElementById('modalTxnRef').innerText = 'Loading transaction #' + txnId + '...';

        fetch(`/admin/transactions/${txnId}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success && data.transaction) {
                activeTxnData = data.transaction;
                document.getElementById('modalTxnRef').innerText = activeTxnData.transaction_reference + ' (' + activeTxnData.gateway + ')';
                document.getElementById('modalAmount').innerText = '₹' + parseFloat(activeTxnData.amount).toFixed(2);
                document.getElementById('modalStatus').innerText = activeTxnData.status.toUpperCase();
                document.getElementById('modalMethod').innerText = (activeTxnData.payment_method || 'Online').toUpperCase();
                document.getElementById('modalPaidAt').innerText = activeTxnData.paid_at ? activeTxnData.paid_at : 'Not yet paid';

                if (activeTxnData.error_description || activeTxnData.error_code) {
                    document.getElementById('modalErrorContainer').classList.remove('hidden');
                    document.getElementById('modalErrorCode').innerText = activeTxnData.error_code || 'GATEWAY ERROR';
                    document.getElementById('modalErrorDesc').innerText = activeTxnData.error_description || 'Payment failed';
                } else {
                    document.getElementById('modalErrorContainer').classList.add('hidden');
                }

                switchPayloadTab('response');
            }
        })
        .catch(err => {
            alert('Failed to load transaction details.');
            closeAuditModal();
        });
    }

    function switchPayloadTab(tab) {
        if (!activeTxnData) return;

        ['response', 'webhook', 'request'].forEach(t => {
            let btn = document.getElementById('tabBtn-' + t);
            if (t === tab) {
                btn.className = 'px-3 py-1.5 rounded-xl font-black text-xs bg-emerald-600 text-white';
            } else {
                btn.className = 'px-3 py-1.5 rounded-xl font-bold text-xs bg-slate-100 dark:bg-white/10 text-slate-600 dark:text-slate-300';
            }
        });

        let targetData = null;
        if (tab === 'response') targetData = activeTxnData.response_payload;
        if (tab === 'webhook') targetData = activeTxnData.webhook_payload;
        if (tab === 'request') targetData = activeTxnData.request_payload;

        let codeEl = document.getElementById('payloadCodeContent');
        if (!targetData || Object.keys(targetData).length === 0) {
            codeEl.innerText = '// No ' + tab + ' payload captured for this transaction.';
        } else {
            codeEl.innerText = JSON.stringify(targetData, null, 2);
        }
    }

    function closeAuditModal() {
        document.getElementById('auditModal').classList.add('hidden');
        activeTxnData = null;
    }
</script>
@endsection
