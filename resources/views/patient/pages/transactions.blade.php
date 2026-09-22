@extends('frontend.layouts.app')

@section('title', 'Payment History & Receipts - Av Wellcare Diagnostics')

@section('content')
<div class="container mx-auto px-4 py-8 bg-gray-50/50">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar -->
        @include('patient.layouts.sidebar')

        <!-- Main Content -->
        <div class="w-full md:w-2/3 lg:w-3/4 space-y-6">

            <!-- Top Header Bar -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-black text-brand-dark flex items-center gap-2.5">
                        <i class="fas fa-receipt text-teal-600"></i>
                        <span>Payment History & Tax Invoices</span>
                    </h2>
                    <p class="text-xs text-gray-500 font-medium mt-1">Complete record of your diagnostic booking payments, VIP memberships, and official transaction receipts.</p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('patient.bookings') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-white border border-gray-200 text-gray-700 hover:text-brand-dark font-extrabold text-xs transition shadow-2xs">
                        <i class="far fa-calendar-check text-teal-600"></i>
                        <span>My Bookings</span>
                    </a>
                    <a href="{{ route('patient.membership') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-black text-xs transition shadow-sm">
                        <i class="fas fa-crown"></i>
                        <span>VIP Status</span>
                    </a>
                </div>
            </div>

            <!-- Summary KPI Strip -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 md:gap-4">
                <div class="bg-white rounded-2xl border border-gray-200 p-4 shadow-sm flex items-center gap-3.5">
                    <div class="w-11 h-11 rounded-2xl bg-teal-50 border border-teal-200 text-teal-800 flex items-center justify-center font-bold text-lg flex-shrink-0">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <div>
                        <span class="text-[11px] font-extrabold text-gray-400 uppercase tracking-wider block">Total Spent</span>
                        <span class="text-xl font-black text-brand-dark">₹{{ number_format($totalSpent, 2) }}</span>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-200 p-4 shadow-sm flex items-center gap-3.5">
                    <div class="w-11 h-11 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center justify-center font-bold text-lg flex-shrink-0">
                        <i class="fas fa-circle-check"></i>
                    </div>
                    <div>
                        <span class="text-[11px] font-extrabold text-gray-400 uppercase tracking-wider block">Successful Orders</span>
                        <span class="text-xl font-black text-emerald-600">{{ $paidCount }} Paid</span>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-200 p-4 shadow-sm flex items-center gap-3.5">
                    <div class="w-11 h-11 rounded-2xl bg-indigo-50 border border-indigo-200 text-indigo-700 flex items-center justify-center font-bold text-lg flex-shrink-0">
                        <i class="fas fa-shield-halved"></i>
                    </div>
                    <div>
                        <span class="text-[11px] font-extrabold text-gray-400 uppercase tracking-wider block">Security</span>
                        <span class="text-xs font-black text-slate-800 block">256-Bit Razorpay SSL</span>
                    </div>
                </div>
            </div>

            <!-- Transactions List -->
            @if($transactions->isEmpty())
                <div class="bg-white rounded-3xl border border-gray-200 shadow-sm p-8 md:p-12 text-center">
                    <div class="w-20 h-20 mx-auto bg-gradient-to-tr from-teal-50 to-emerald-100 rounded-3xl flex items-center justify-center mb-5 border border-teal-200 shadow-inner">
                        <i class="fas fa-receipt text-3xl text-teal-700"></i>
                    </div>
                    <h3 class="font-black text-gray-900 text-xl mb-2">No Transactions Found</h3>
                    <p class="text-gray-500 font-medium text-xs md:text-sm max-w-lg mx-auto mb-6">
                        You haven't made any online payments yet. When you book a health checkup or activate a VIP pass, your payment receipts will be recorded here.
                    </p>
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-teal-800 hover:bg-teal-900 text-white font-extrabold text-xs px-6 py-3 rounded-xl shadow-md transition">
                        <span>Explore Health Packages</span>
                        <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
            @else
                <div class="space-y-3.5">
                    @foreach($transactions as $txn)
                    @php
                        $badge = $txn->status_badge;
                    @endphp
                    <div class="bg-white border border-gray-200 hover:border-teal-300 rounded-2xl p-5 shadow-sm hover:shadow-md transition duration-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-start gap-3.5">
                            <div class="w-11 h-11 rounded-2xl {{ $txn->status === 'captured' ? 'bg-emerald-50 text-emerald-600 border border-emerald-200' : ($txn->status === 'failed' ? 'bg-rose-50 text-rose-600 border border-rose-200' : 'bg-amber-50 text-amber-600 border border-amber-200') }} flex items-center justify-center text-lg flex-shrink-0 mt-0.5">
                                <i class="fas {{ $txn->method_icon }}"></i>
                            </div>
                            <div class="space-y-1">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="font-mono font-black text-xs text-slate-800">#{{ $txn->transaction_reference }}</span>
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-black border {{ $badge['class'] }}">
                                        <i class="fas {{ $badge['icon'] }} text-[9px]"></i>
                                        <span>{{ $badge['label'] }}</span>
                                    </span>
                                </div>

                                <div class="flex items-center gap-2 text-xs font-bold text-gray-700 flex-wrap">
                                    @if($txn->type === 'booking' && $txn->booking)
                                        <span>Booking:</span>
                                        <a href="{{ route('patient.bookings') }}" class="text-teal-700 hover:underline">
                                            #{{ $txn->booking->booking_reference }}
                                        </a>
                                    @elseif($txn->type === 'membership')
                                        <span class="text-amber-700">VIP Membership Purchase</span>
                                    @else
                                        <span>Diagnostic Service</span>
                                    @endif
                                </div>

                                <div class="flex items-center gap-3 text-[11px] text-gray-400 font-medium flex-wrap">
                                    <span class="flex items-center gap-1">
                                        <i class="far fa-calendar text-teal-600 text-[10px]"></i>
                                        <span>{{ $txn->created_at->format('d M Y, h:i A') }}</span>
                                    </span>
                                    @if($txn->razorpay_payment_id)
                                    <span>•</span>
                                    <span class="font-mono text-gray-500">ID: {{ $txn->razorpay_payment_id }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Amount & Actions -->
                        <div class="flex sm:flex-col items-center sm:items-end justify-between border-t sm:border-t-0 pt-3 sm:pt-0 border-gray-100 flex-shrink-0">
                            <div>
                                <span class="text-xs text-gray-400 font-bold uppercase tracking-wider block sm:text-right">Amount</span>
                                <span class="text-xl font-black text-brand-dark block sm:text-right">₹{{ number_format($txn->amount, 2) }}</span>
                            </div>

                            <button type="button" onclick="openReceiptModal({{ json_encode($txn) }})" class="mt-2 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-gray-50 hover:bg-teal-50 text-teal-800 border border-gray-200 hover:border-teal-300 font-bold text-xs transition">
                                <i class="fas fa-file-invoice text-xs"></i>
                                <span>View Receipt</span>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>

                @if($transactions->hasPages())
                    <div class="pt-4">
                        {{ $transactions->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>

<!-- Receipt Modal -->
<div id="receiptModal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full border border-gray-200 shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
        <!-- Receipt Header -->
        <div class="p-6 bg-gradient-to-br from-teal-900 to-slate-900 text-white relative">
            <button type="button" onclick="closeReceiptModal()" class="absolute right-4 top-4 w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition">
                <i class="fas fa-times text-xs"></i>
            </button>
            <div class="flex items-center gap-2 mb-2">
                <div class="w-8 h-8 rounded-lg bg-amber-400 text-slate-950 flex items-center justify-center font-black text-sm">
                    <i class="fas fa-heartbeat"></i>
                </div>
                <span class="font-black tracking-tight text-sm">Av Wellcare Diagnostics</span>
            </div>
            <h3 class="text-lg font-black text-white">Payment Receipt</h3>
            <p class="text-xs text-teal-200" id="receiptTxnRef">#TXN-...</p>
        </div>

        <!-- Receipt Body -->
        <div class="p-6 overflow-y-auto space-y-4 text-xs">
            <div class="flex justify-between items-center pb-3 border-b border-dashed border-gray-200">
                <span class="text-gray-500 font-medium">Payment Status:</span>
                <span class="font-black text-emerald-600 px-2.5 py-0.5 rounded-full bg-emerald-50 border border-emerald-200" id="receiptStatus">SUCCESS</span>
            </div>
            <div class="flex justify-between items-center pb-3 border-b border-dashed border-gray-200">
                <span class="text-gray-500 font-medium">Payment Date:</span>
                <span class="font-bold text-gray-800" id="receiptDate">-</span>
            </div>
            <div class="flex justify-between items-center pb-3 border-b border-dashed border-gray-200">
                <span class="text-gray-500 font-medium">Payment Gateway:</span>
                <span class="font-bold text-gray-800">Razorpay (100% Encrypted)</span>
            </div>
            <div class="flex justify-between items-center pb-3 border-b border-dashed border-gray-200">
                <span class="text-gray-500 font-medium">Razorpay Payment ID:</span>
                <span class="font-mono font-bold text-teal-700" id="receiptPayId">-</span>
            </div>
            <div class="flex justify-between items-center pb-3 border-b border-dashed border-gray-200">
                <span class="text-gray-500 font-medium">Payment Method:</span>
                <span class="font-bold text-gray-800 uppercase" id="receiptMethod">-</span>
            </div>

            <div class="bg-gray-50 p-4 rounded-2xl flex justify-between items-center">
                <span class="font-black text-sm text-gray-900">Total Amount Paid</span>
                <span class="text-2xl font-black text-teal-900" id="receiptAmount">₹0.00</span>
            </div>

            <p class="text-[11px] text-gray-400 text-center italic">
                Computer-generated receipt. Official test reports will be released upon completion of laboratory sample processing.
            </p>
        </div>

        <!-- Receipt Footer -->
        <div class="p-4 border-t border-gray-100 flex gap-2 bg-gray-50">
            <button type="button" onclick="window.print()" class="flex-1 py-2.5 rounded-xl bg-teal-800 hover:bg-teal-900 text-white font-black text-xs transition flex items-center justify-center gap-1.5">
                <i class="fas fa-print"></i> Print Slip
            </button>
            <a id="receiptFullPageLink" href="#" target="_blank" class="px-3.5 py-2.5 rounded-xl bg-teal-50 border border-teal-200 hover:bg-teal-100 text-teal-800 font-bold text-xs transition flex items-center justify-center gap-1">
                <i class="fas fa-file-invoice"></i> Full Invoice
            </a>
            <button type="button" onclick="closeReceiptModal()" class="px-4 py-2.5 rounded-xl bg-white border border-gray-200 hover:bg-gray-100 text-gray-700 font-bold text-xs transition">
                Close
            </button>
        </div>
    </div>
</div>

<script>
    function openReceiptModal(txn) {
        document.getElementById('receiptModal').classList.remove('hidden');
        document.getElementById('receiptTxnRef').innerText = '#' + txn.transaction_reference;
        document.getElementById('receiptStatus').innerText = (txn.status || 'captured').toUpperCase();
        document.getElementById('receiptDate').innerText = txn.created_at ? new Date(txn.created_at).toLocaleString() : '-';
        document.getElementById('receiptPayId').innerText = txn.razorpay_payment_id || 'N/A';
        document.getElementById('receiptMethod').innerText = (txn.payment_method || 'Online').toUpperCase();
        document.getElementById('receiptAmount').innerText = '₹' + parseFloat(txn.amount).toFixed(2);
        const fullLink = document.getElementById('receiptFullPageLink');
        if (fullLink) {
            fullLink.href = '{{ url("/patient/transactions") }}/' + txn.id + '/receipt';
        }
    }

    function closeReceiptModal() {
        document.getElementById('receiptModal').classList.add('hidden');
    }
</script>
@endsection
