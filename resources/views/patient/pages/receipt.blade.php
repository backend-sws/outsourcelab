@extends('frontend.layouts.app')

@section('title', 'Payment Receipt #' . $transaction->transaction_reference . ' - Av Wellcare Diagnostics')

@section('content')
<style>
    @media print {
        header, footer, .no-print {
            display: none !important;
        }
        body {
            background: #ffffff !important;
            color: #000000 !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        .print-container {
            border: none !important;
            box-shadow: none !important;
            max-width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }
    }
</style>

<div class="container mx-auto px-4 py-8 max-w-3xl">
    <!-- Action Bar -->
    <div class="flex items-center justify-between gap-4 mb-6 no-print">
        <a href="{{ route('patient.transactions') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-gray-200 text-gray-700 hover:text-teal-800 font-bold text-xs transition shadow-2xs">
            <i class="fas fa-arrow-left"></i>
            <span>Back to Payment History</span>
        </a>
        <div class="flex items-center gap-2">
            <button type="button" onclick="window.print()" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-teal-800 hover:bg-teal-900 text-white font-black text-xs transition shadow-sm">
                <i class="fas fa-print"></i>
                <span>Print Tax Invoice</span>
            </button>
        </div>
    </div>

    <!-- Printable Invoice Sheet -->
    <div class="bg-white rounded-3xl border border-gray-200 shadow-xl overflow-hidden print-container">
        <!-- Top Banner -->
        <div class="bg-gradient-to-r from-teal-950 via-teal-900 to-slate-900 text-white p-6 sm:p-8">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2.5 mb-2">
                        <div class="w-10 h-10 rounded-xl bg-amber-400 text-slate-950 flex items-center justify-center font-black text-lg shadow-sm">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                        <div>
                            <h1 class="text-xl font-black tracking-tight text-white">Av Wellcare Diagnostics</h1>
                            <p class="text-[11px] text-teal-300 font-medium">NABL Accredited & ICMR Approved Medical Laboratory</p>
                        </div>
                    </div>
                </div>
                <div class="sm:text-right">
                    <span class="inline-block px-3 py-1 rounded-full text-[11px] font-black uppercase tracking-wider bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 mb-1">
                        {{ strtoupper($transaction->status) }}
                    </span>
                    <p class="text-xs font-mono font-bold text-gray-300">#{{ $transaction->transaction_reference }}</p>
                </div>
            </div>
        </div>

        <div class="p-6 sm:p-8 space-y-6">
            <!-- Metadata Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pb-6 border-b border-gray-100">
                <div>
                    <h4 class="text-[11px] font-black text-gray-400 uppercase tracking-wider mb-2">Billed To (Patient)</h4>
                    <p class="text-sm font-black text-gray-900">{{ $transaction->patient->name ?? 'Guest Patient' }}</p>
                    <p class="text-xs text-gray-600 mt-0.5"><i class="fas fa-phone-alt text-teal-700 text-[10px] mr-1"></i> {{ $transaction->patient->mobile ?? 'N/A' }}</p>
                    @if($transaction->patient && $transaction->patient->email)
                        <p class="text-xs text-gray-600"><i class="fas fa-envelope text-teal-700 text-[10px] mr-1"></i> {{ $transaction->patient->email }}</p>
                    @endif
                    @if($transaction->booking && $transaction->booking->address)
                        <p class="text-xs text-gray-500 mt-1.5 leading-relaxed">
                            <i class="fas fa-map-marker-alt text-teal-700 text-[10px] mr-1"></i>
                            {{ $transaction->booking->address->address_line1 ?? '' }}, {{ $transaction->booking->address->city ?? '' }} {{ $transaction->booking->address->pincode ?? '' }}
                        </p>
                    @endif
                </div>

                <div class="sm:text-right space-y-1">
                    <h4 class="text-[11px] font-black text-gray-400 uppercase tracking-wider mb-2">Invoice Summary</h4>
                    <p class="text-xs text-gray-600"><span class="font-bold text-gray-800">Date:</span> {{ $transaction->paid_at ? $transaction->paid_at->format('d M Y, h:i A') : $transaction->created_at->format('d M Y, h:i A') }}</p>
                    <p class="text-xs text-gray-600"><span class="font-bold text-gray-800">Payment Gateway:</span> Razorpay 256-Bit SSL</p>
                    @if($transaction->razorpay_payment_id)
                        <p class="text-xs text-gray-600 font-mono"><span class="font-bold font-sans text-gray-800">Payment ID:</span> {{ $transaction->razorpay_payment_id }}</p>
                    @endif
                    @if($transaction->razorpay_order_id)
                        <p class="text-xs text-gray-600 font-mono"><span class="font-bold font-sans text-gray-800">Order ID:</span> {{ $transaction->razorpay_order_id }}</p>
                    @endif
                    <p class="text-xs text-gray-600"><span class="font-bold text-gray-800">Payment Mode:</span> <span class="uppercase font-bold text-teal-800">{{ $transaction->payment_method ?? 'Online' }}</span></p>
                </div>
            </div>

            <!-- Transaction Line Items -->
            <div>
                <h4 class="text-[11px] font-black text-gray-400 uppercase tracking-wider mb-3">Service & Billing Details</h4>
                <div class="border border-gray-200 rounded-2xl overflow-hidden">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-gray-50 border-b border-gray-200 text-gray-600 uppercase font-black tracking-wider text-[10px]">
                            <tr>
                                <th class="p-3.5">Description</th>
                                <th class="p-3.5 text-center">Type</th>
                                <th class="p-3.5 text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-800">
                            @if($transaction->type === 'booking' && $transaction->booking)
                                <tr>
                                    <td class="p-3.5">
                                        <div class="font-bold text-gray-900">Diagnostic Health Booking #{{ $transaction->booking->booking_reference }}</div>
                                        <div class="text-[11px] text-gray-500 mt-0.5">
                                            Scheduled: {{ \Carbon\Carbon::parse($transaction->booking->scheduled_date)->format('d M Y') }} at {{ $transaction->booking->time_slot }}
                                            ({{ $transaction->booking->collection_type === 'home' ? 'Home Sample Collection' : 'Lab Walk-in' }})
                                        </div>
                                    </td>
                                    <td class="p-3.5 text-center">
                                        <span class="px-2 py-0.5 rounded-md bg-teal-50 text-teal-700 font-black text-[10px] uppercase">Lab Booking</span>
                                    </td>
                                    <td class="p-3.5 text-right font-black text-gray-900">₹{{ number_format($transaction->amount, 2) }}</td>
                                </tr>
                            @elseif($transaction->type === 'membership' && $transaction->membership)
                                <tr>
                                    <td class="p-3.5">
                                        <div class="font-bold text-amber-900">VIP Health Membership - {{ $transaction->membership->name }}</div>
                                        <div class="text-[11px] text-gray-500 mt-0.5">
                                            Priority lab slots, free annual health checks, and discount benefits.
                                        </div>
                                    </td>
                                    <td class="p-3.5 text-center">
                                        <span class="px-2 py-0.5 rounded-md bg-amber-50 text-amber-700 font-black text-[10px] uppercase">VIP Pass</span>
                                    </td>
                                    <td class="p-3.5 text-right font-black text-gray-900">₹{{ number_format($transaction->amount, 2) }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td class="p-3.5 font-bold text-gray-900">Online Diagnostic Consultation / Service</td>
                                    <td class="p-3.5 text-center"><span class="px-2 py-0.5 rounded-md bg-gray-100 text-gray-700 font-black text-[10px] uppercase">Service</span></td>
                                    <td class="p-3.5 text-right font-black text-gray-900">₹{{ number_format($transaction->amount, 2) }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Total Amount Card -->
            <div class="flex justify-end pt-2">
                <div class="w-full sm:w-72 bg-gradient-to-br from-teal-50 to-emerald-50 rounded-2xl p-4 border border-teal-200">
                    <div class="flex justify-between items-center text-xs text-gray-600 mb-1.5">
                        <span>Net Paid Amount:</span>
                        <span class="font-bold">₹{{ number_format($transaction->amount, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center text-xs text-gray-600 mb-2">
                        <span>Tax / GST:</span>
                        <span class="font-bold text-emerald-700">Included (0% Medical Diagnostic Exemption)</span>
                    </div>
                    <div class="flex justify-between items-center pt-2 border-t border-teal-200">
                        <span class="font-black text-sm text-teal-950">Grand Total:</span>
                        <span class="font-black text-2xl text-teal-900">₹{{ number_format($transaction->amount, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Footer Notice -->
            <div class="pt-6 border-t border-gray-200 text-center text-gray-400 text-[11px] space-y-1">
                <p class="font-medium">This is a system-generated electronic payment receipt. No physical signature required.</p>
                <p>For billing discrepancies or sample collection queries, call our 24x7 helpdesk at <strong>+91 99999 99999</strong> or email <strong>billing@avwellcarediagnostics.com</strong>.</p>
            </div>
        </div>
    </div>
</div>
@endsection
