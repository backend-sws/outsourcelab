@extends('agent.layouts.app')

@section('title', 'Assigned Visits & Tasks')

@section('content')
<div class="space-y-6">

    <!-- Agent Welcome & Stats Bar -->
    <div class="bg-gradient-to-r from-slate-900 via-teal-950 to-slate-900 rounded-2xl p-5 text-white shadow-lg border border-teal-900/40">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-white/10 pb-4 mb-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-teal-400">Welcome Back</span>
                <h1 class="text-xl sm:text-2xl font-black text-white mt-0.5">{{ $agent->name }}</h1>
                <p class="text-xs text-slate-300 mt-0.5">
                    <i class="fas fa-map-marker-alt text-amber-400 mr-1"></i> {{ $agent->city ?: 'Assigned Territory' }}
                    @if(!empty($agent->vehicle_number))
                        <span class="mx-1 text-slate-500">•</span>
                        <i class="fas fa-motorcycle text-teal-400 mr-1"></i> {{ $agent->vehicle_number }}
                    @endif
                </p>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/40">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 mr-1.5 animate-ping"></span> On Duty / Ready
                </span>
            </div>
        </div>

        <!-- Metric KPI Cards -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            <div class="bg-white/5 backdrop-blur-sm rounded-xl p-3 border border-white/10">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Assigned Visits</span>
                <span class="text-2xl font-black text-white mt-1 block">{{ $totalAssigned }}</span>
            </div>
            <div class="bg-white/5 backdrop-blur-sm rounded-xl p-3 border border-white/10">
                <span class="text-[11px] font-bold text-amber-400 uppercase tracking-wider block">Pending Samples</span>
                <span class="text-2xl font-black text-amber-300 mt-1 block">{{ $pendingCollection }}</span>
            </div>
            <div class="bg-white/5 backdrop-blur-sm rounded-xl p-3 border border-white/10">
                <span class="text-[11px] font-bold text-emerald-400 uppercase tracking-wider block">Collected</span>
                <span class="text-2xl font-black text-emerald-300 mt-1 block">{{ $samplesCollected }}</span>
            </div>
            <div class="bg-white/5 backdrop-blur-sm rounded-xl p-3 border border-white/10">
                <span class="text-[11px] font-bold text-teal-400 uppercase tracking-wider block">Cash In-Hand</span>
                <span class="text-2xl font-black text-teal-300 mt-1 block">₹{{ number_format($cashCollected) }}</span>
            </div>
        </div>
    </div>

    <!-- Assigned Visits Section -->
    <div class="space-y-4">
        <div class="flex justify-between items-center">
            <h2 class="text-base sm:text-lg font-black text-slate-800 flex items-center gap-2">
                <i class="fas fa-clipboard-list text-teal-600"></i>
                <span>Patients Assigned to You ({{ $bookings->count() }})</span>
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('agent.progress') }}" class="text-xs font-bold text-teal-700 hover:text-teal-900 underline flex items-center gap-1">
                    <span>View Progress Timeline</span>
                    <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
            </div>
        </div>

        @forelse($bookings as $booking)
            @php
                $patientPhone = $booking->patient->mobile ?: ($booking->patient->phone ?? '');
                $addressStr = $booking->address ? ($booking->address->full_address . ', ' . ($booking->address->landmark ? 'Near ' . $booking->address->landmark . ', ' : '') . $booking->address->city . ' ' . $booking->address->pincode) : 'Address not specified';
                $mapsQuery = urlencode($addressStr);
                $isOnlinePaid = ($booking->payment_status === 'Paid' && $booking->money_collected_by != $agent->id);
                $isCashPending = ($booking->payment_status !== 'Paid');
                $isCollectedByMe = ($booking->payment_status === 'Paid' && $booking->money_collected_by == $agent->id);
            @endphp
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/80 hover:border-teal-500/40 transition-all space-y-4">
                
                <!-- Top Header of Card: Ref # and Badges -->
                <div class="flex flex-wrap justify-between items-center gap-2 border-b border-slate-100 pb-3">
                    <div class="flex items-center gap-2">
                        <span class="font-mono text-xs font-black bg-slate-900 text-teal-300 px-2.5 py-1 rounded-lg">
                            #{{ $booking->booking_reference }}
                        </span>
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="text-xs font-bold text-slate-700 flex items-center gap-1">
                                <i class="far fa-calendar text-teal-600"></i>
                                {{ $booking->booking_date ? $booking->booking_date->format('M d, Y') : 'Today' }}
                            </span>
                            <span class="inline-flex items-center gap-1 text-[11px] font-black text-amber-900 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded-md shadow-2xs">
                                <i class="far fa-clock text-[10px] text-amber-700"></i>
                                <span>{{ $booking->display_slot }}</span>
                            </span>
                        </div>
                    </div>

                    <!-- Status Badges -->
                    <div class="flex items-center gap-2">
                        <!-- Sample Status Badge -->
                        @if($booking->sample_status === 'Sample Collected')
                            <span class="inline-flex items-center gap-1 text-xs font-bold px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-300">
                                <i class="fas fa-check-circle"></i> Sample Collected
                            </span>
                        @elseif($booking->sample_status === 'Out for Collection')
                            <span class="inline-flex items-center gap-1 text-xs font-bold px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-800 border border-blue-300 animate-pulse">
                                <i class="fas fa-motorcycle"></i> En Route / Collecting
                            </span>
                        @elseif($booking->sample_status === 'Delivered to Lab')
                            <span class="inline-flex items-center gap-1 text-xs font-bold px-2.5 py-0.5 rounded-full bg-purple-100 text-purple-800 border border-purple-300">
                                <i class="fas fa-flask"></i> Handed to Lab
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 text-xs font-bold px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800 border border-amber-300">
                                <i class="fas fa-hourglass-start"></i> Assigned (Pending)
                            </span>
                        @endif

                        <!-- Payment Badge -->
                        @if($isOnlinePaid)
                            <span class="inline-flex items-center gap-1 text-xs font-black px-2.5 py-0.5 rounded-full bg-emerald-500 text-white shadow-sm shadow-emerald-500/30">
                                <i class="fas fa-shield-check"></i> PAID ONLINE
                            </span>
                        @elseif($isCollectedByMe)
                            <span class="inline-flex items-center gap-1 text-xs font-black px-2.5 py-0.5 rounded-full bg-teal-100 text-teal-800 border border-teal-300">
                                <i class="fas fa-check-double"></i> Cash Collected (₹{{ $booking->amount }})
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 text-xs font-black px-2.5 py-0.5 rounded-full bg-rose-100 text-rose-800 border border-rose-300">
                                <i class="fas fa-coins"></i> CASH DUE: ₹{{ $booking->amount }}
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Patient & Location Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Patient Info -->
                    <div class="space-y-1.5">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Patient Details</span>
                        <div class="flex items-center gap-2">
                            <span class="text-base font-extrabold text-slate-900">{{ $booking->patient->name ?? 'Patient' }}</span>
                            @if($booking->familyMember)
                                <span class="text-xs bg-slate-100 text-slate-700 px-2 py-0.5 rounded-md font-bold">
                                    For: {{ $booking->familyMember->name }} ({{ $booking->familyMember->relation }})
                                </span>
                            @endif
                        </div>
                        
                        <!-- Click to call patient phone -->
                        @if($patientPhone)
                            <div class="pt-1">
                                <a href="tel:{{ $patientPhone }}" class="inline-flex items-center gap-2 px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200 rounded-xl text-xs font-extrabold transition">
                                    <i class="fas fa-phone-alt text-emerald-600"></i>
                                    <span>Call: {{ $patientPhone }}</span>
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Destination & Maps Navigation -->
                    <div class="space-y-1.5">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Doorstep Collection Address</span>
                        <p class="text-xs text-slate-700 font-medium leading-relaxed bg-slate-50 p-2.5 rounded-xl border border-slate-200/60">
                            <i class="fas fa-home text-teal-600 mr-1.5"></i>
                            {{ $addressStr }}
                        </p>
                        @if($booking->address)
                            <div class="pt-0.5">
                                <a href="https://www.google.com/maps/search/?api=1&query={{ $mapsQuery }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-bold text-indigo-600 hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 px-2.5 py-1 rounded-lg border border-indigo-200 transition">
                                    <i class="fas fa-location-arrow text-indigo-500"></i>
                                    <span>Open in Google Maps</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Tests to Collect -->
                <div class="bg-teal-50/40 rounded-xl p-3 border border-teal-100">
                    <span class="text-[11px] font-bold text-teal-800 uppercase tracking-wider flex items-center gap-1.5 mb-2">
                        <i class="fas fa-vials text-teal-600"></i>
                        <span>Lab Tests to Collect Sample For:</span>
                    </span>
                    <div class="flex flex-wrap gap-2">
                        @if(!empty($booking->test_details) && is_array($booking->test_details))
                            @foreach($booking->test_details as $test)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-white border border-teal-200 text-xs font-bold text-slate-800 shadow-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-teal-500"></span>
                                    <span>{{ $test['name'] ?? 'Diagnostic Test' }}</span>
                                    @if(isset($test['params']) && $test['params'])
                                        <span class="text-[10px] text-slate-500 font-normal">({{ $test['params'] }})</span>
                                    @endif
                                </span>
                            @endforeach
                        @else
                            <span class="text-xs text-slate-500">Diagnostic Checkup</span>
                        @endif
                    </div>
                </div>

                <!-- Action Controls for Agent -->
                <div class="pt-3 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3">
                    <div class="flex flex-wrap items-center gap-2">
                        <!-- Progress Status Update Actions -->
                        @if($booking->sample_status === 'Pending' || $booking->sample_status === 'Assigned')
                            <form action="{{ route('agent.update_sample_status', $booking->id) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="sample_status" value="Out for Collection">
                                <button type="submit" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-sm transition">
                                    <i class="fas fa-motorcycle"></i> Start Journey (On The Way)
                                </button>
                            </form>
                        @endif

                        @if($booking->sample_status === 'Out for Collection')
                            <form action="{{ route('agent.update_sample_status', $booking->id) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="sample_status" value="Sample Collected">
                                <button type="submit" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-sm transition">
                                    <i class="fas fa-check-circle"></i> Mark Sample Collected
                                </button>
                            </form>
                        @endif

                        @if($booking->sample_status === 'Sample Collected')
                            <form action="{{ route('agent.update_sample_status', $booking->id) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="sample_status" value="Delivered to Lab">
                                <button type="submit" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold shadow-sm transition">
                                    <i class="fas fa-flask"></i> Handed to Lab
                                </button>
                            </form>
                        @endif

                        <!-- Collect Cash Button if pending -->
                        @if($isCashPending)
                            <form action="{{ route('agent.collect_money', $booking->id) }}" method="POST" class="inline" onsubmit="return confirm('Confirm that you have collected cash payment of ₹{{ $booking->amount }} from the patient?');">
                                @csrf
                                <input type="hidden" name="payment_mode" value="Cash">
                                <button type="submit" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 text-xs font-black shadow-sm transition">
                                    <i class="fas fa-hand-holding-usd"></i> Collect Cash ₹{{ $booking->amount }}
                                </button>
                            </form>
                        @endif
                    </div>

                    <div class="text-right text-xs text-slate-400">
                        Total Amount: <span class="font-black text-slate-900 text-sm">₹{{ $booking->amount }}</span>
                    </div>
                </div>

            </div>
        @empty
            <div class="bg-white rounded-2xl p-10 text-center border border-slate-200 shadow-sm">
                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-400 text-2xl">
                    <i class="fas fa-inbox"></i>
                </div>
                <h3 class="text-base font-bold text-slate-800">No Patient Visits Assigned Right Now</h3>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                    Admin has not assigned any pending sample collection bookings to your account yet. When assigned, patient details, address, and test requirements will appear here.
                </p>
            </div>
        @endforelse
    </div>

</div>
@endsection
