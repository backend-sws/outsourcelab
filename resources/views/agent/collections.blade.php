@extends('agent.layout.app')

@section('title', 'Doorstep Money Collections')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
        <div>
            <h1 class="text-xl font-black text-slate-900 flex items-center gap-2">
                <i class="fas fa-hand-holding-usd text-teal-600"></i>
                <span>Doorstep Money Collections</span>
            </h1>
            <p class="text-xs text-slate-500 mt-0.5">Manage patient payments, collect cash on delivery, and view online paid status</p>
        </div>
    </div>

    <!-- Collection KPI Summary -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <!-- Cash in Hand (Ready for Lab Handover) -->
        <div class="bg-gradient-to-br from-emerald-600 to-teal-700 rounded-2xl p-5 text-white shadow-lg shadow-teal-700/20">
            <span class="text-xs font-bold uppercase tracking-wider text-emerald-200 block">Cash Collected in Hand</span>
            <div class="flex items-baseline gap-2 mt-1">
                <span class="text-3xl font-black text-white">₹{{ number_format($totalCashInHand) }}</span>
                <span class="text-xs text-emerald-200">Ready to submit</span>
            </div>
            <p class="text-[11px] text-emerald-100/80 mt-2 flex items-center gap-1">
                <i class="fas fa-check-circle"></i> Cash & UPI collected from doorstep visits
            </p>
        </div>

        <!-- Pending Cash to Collect -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
            <span class="text-xs font-bold uppercase tracking-wider text-rose-500 block">Pending Cash to Collect</span>
            <div class="flex items-baseline gap-2 mt-1">
                <span class="text-3xl font-black text-slate-900">₹{{ number_format($totalPendingCash) }}</span>
            </div>
            <p class="text-[11px] text-slate-500 mt-2 flex items-center gap-1">
                <i class="fas fa-coins text-amber-500"></i> Amount awaiting collection from patients
            </p>
        </div>

        <!-- Online Paid Bookings -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
            <span class="text-xs font-bold uppercase tracking-wider text-teal-600 block">Online Paid Visits</span>
            <div class="flex items-baseline gap-2 mt-1">
                <span class="text-3xl font-black text-slate-900">{{ $totalOnlinePaid }}</span>
                <span class="text-xs text-slate-500">patients</span>
            </div>
            <p class="text-[11px] text-slate-500 mt-2 flex items-center gap-1 text-emerald-600 font-semibold">
                <i class="fas fa-shield-alt text-emerald-500"></i> Prepaid online (No cash needed)
            </p>
        </div>
    </div>

    <!-- Collections List -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
        <div class="p-4 sm:p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <h2 class="text-sm sm:text-base font-extrabold text-slate-800 flex items-center gap-2">
                <i class="fas fa-receipt text-teal-600"></i>
                <span>Client Payment Records ({{ $bookings->count() }})</span>
            </h2>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($bookings as $booking)
                @php
                    $isOnlinePaid = ($booking->payment_status === 'Paid' && $booking->money_collected_by != $agent->id);
                    $isCollectedByMe = ($booking->payment_status === 'Paid' && $booking->money_collected_by == $agent->id);
                    $isPending = ($booking->payment_status !== 'Paid');
                    $patientPhone = $booking->patient->mobile ?: ($booking->patient->phone ?? '');
                @endphp

                <div class="p-4 sm:p-5 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 hover:bg-slate-50/40 transition">
                    <!-- Client & Booking Info -->
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="font-mono text-xs font-black bg-slate-900 text-teal-300 px-2 py-0.5 rounded">
                                #{{ $booking->booking_reference }}
                            </span>
                            <span class="text-sm font-extrabold text-slate-900">{{ $booking->patient->name ?? 'Patient' }}</span>
                            @if($booking->familyMember)
                                <span class="text-[11px] text-slate-500 font-semibold">({{ $booking->familyMember->name }})</span>
                            @endif
                        </div>
                        <div class="text-xs text-slate-500 flex flex-wrap items-center gap-3">
                            @if($patientPhone)
                                <span><i class="fas fa-phone text-slate-400 mr-1"></i> {{ $patientPhone }}</span>
                            @endif
                            <span><i class="far fa-calendar mr-1"></i> {{ $booking->booking_date ? $booking->booking_date->format('M d, Y') : 'Today' }}</span>
                            <span><i class="fas fa-wallet text-slate-400 mr-1"></i> Method: <strong>{{ $booking->payment_method }}</strong></span>
                        </div>
                    </div>

                    <!-- Amount & Payment Status Action -->
                    <div class="flex flex-wrap items-center gap-3 self-stretch sm:self-auto justify-between sm:justify-end border-t sm:border-t-0 pt-3 sm:pt-0 border-slate-100">
                        <div class="text-left sm:text-right">
                            <span class="text-xs text-slate-400 block font-medium">Bill Amount</span>
                            <span class="text-lg font-black text-slate-900">₹{{ number_format($booking->amount) }}</span>
                        </div>

                        <!-- Status Presentation -->
                        <div>
                            @if($isOnlinePaid)
                                <div class="text-right">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-500 text-white text-xs font-black shadow-sm shadow-emerald-500/20">
                                        <i class="fas fa-check-circle"></i> PAID ONLINE
                                    </span>
                                    <span class="text-[10px] text-emerald-700 block mt-1 font-semibold">Do not collect money</span>
                                </div>
                            @elseif($isCollectedByMe)
                                <div class="text-right">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-teal-50 border border-teal-200 text-teal-800 text-xs font-black">
                                        <i class="fas fa-badge-check text-teal-600"></i> COLLECTED BY YOU
                                    </span>
                                    <span class="text-[10px] text-slate-500 block mt-1 font-medium">
                                        {{ $booking->money_collected_at ? $booking->money_collected_at->format('M d, h:i A') : 'Recorded' }} ({{ $booking->money_payment_mode ?? 'Cash' }})
                                    </span>
                                </div>
                            @else
                                <div class="flex items-center gap-2">
                                    <form action="{{ route('agent.collect_money', $booking->id) }}" method="POST" class="flex items-center gap-1.5">
                                        @csrf
                                        <select name="payment_mode" class="text-xs font-semibold px-2 py-1.5 border border-slate-300 rounded-lg bg-white">
                                            <option value="Cash">Cash</option>
                                            <option value="UPI / QR">UPI / QR</option>
                                        </select>
                                        <button type="submit" onclick="return confirm('Confirm receipt of ₹{{ $booking->amount }} from this patient?');" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 text-xs font-black shadow-sm transition">
                                            <i class="fas fa-hand-holding-usd"></i> Collect ₹{{ $booking->amount }}
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-slate-500 text-xs font-medium">
                    No client payment records found for your account.
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
