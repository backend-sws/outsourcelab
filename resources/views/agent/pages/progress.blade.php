@extends('agent.layouts.app')

@section('title', 'Live Collection Progress')

@section('content')
<div class="space-y-6">

    <!-- Header & Filter Tabs -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
        <div>
            <h1 class="text-xl font-black text-slate-900 flex items-center gap-2">
                <i class="fas fa-route text-teal-600"></i>
                <span>Sample Collection Tracker</span>
            </h1>
            <p class="text-xs text-slate-500 mt-0.5">Track real-time sample collection stages from dispatch to lab handover</p>
        </div>

        <!-- Filter Pills -->
        <div class="bg-white p-1 rounded-xl shadow-sm border border-slate-200 flex flex-wrap gap-1">
            <a href="{{ route('agent.progress', ['status' => 'all']) }}" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all {{ $filter === 'all' ? 'bg-teal-600 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                All ({{ $bookings->count() }})
            </a>
            <a href="{{ route('agent.progress', ['status' => 'active']) }}" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all {{ $filter === 'active' ? 'bg-teal-600 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                In-Progress
            </a>
            <a href="{{ route('agent.progress', ['status' => 'collected']) }}" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all {{ $filter === 'collected' ? 'bg-teal-600 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                Collected
            </a>
            <a href="{{ route('agent.progress', ['status' => 'delivered']) }}" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all {{ $filter === 'delivered' ? 'bg-teal-600 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                Finished / Lab
            </a>
        </div>
    </div>

    <!-- Progress Cards List -->
    <div class="space-y-4">
        @forelse($bookings as $booking)
            @php
                $patientPhone = $booking->patient->mobile ?: ($booking->patient->phone ?? '');
                $addressStr = $booking->address ? ($booking->address->full_address . ', ' . $booking->address->city) : 'Address N/A';
                
                // Stage determination (1 to 4)
                $currentStage = 1;
                if ($booking->sample_status === 'Out for Collection') $currentStage = 2;
                elseif ($booking->sample_status === 'Sample Collected') $currentStage = 3;
                elseif ($booking->sample_status === 'Delivered to Lab') $currentStage = 4;
            @endphp

            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/80 space-y-4">
                
                <!-- Card Header -->
                <div class="flex flex-wrap justify-between items-start gap-2 border-b border-slate-100 pb-3">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-mono text-xs font-black bg-slate-900 text-teal-300 px-2.5 py-1 rounded-lg">
                                #{{ $booking->booking_reference }}
                            </span>
                            <span class="text-sm font-extrabold text-slate-900">{{ $booking->patient->name ?? 'Patient' }}</span>
                            @if($booking->familyMember)
                                <span class="text-xs bg-slate-100 text-slate-700 px-2 py-0.5 rounded font-semibold">
                                    ({{ $booking->familyMember->name }} - {{ $booking->familyMember->relation }})
                                </span>
                            @endif
                        </div>
                        <p class="text-xs text-slate-500 mt-1 flex items-center gap-3">
                            <span><i class="fas fa-map-marker-alt text-teal-600 mr-1"></i> {{ $addressStr }}</span>
                            @if($patientPhone)
                                <a href="tel:{{ $patientPhone }}" class="text-emerald-600 hover:underline font-bold">
                                    <i class="fas fa-phone mr-1"></i> {{ $patientPhone }}
                                </a>
                            @endif
                        </p>
                    </div>

                    <div class="text-right">
                        <span class="text-xs text-slate-400 block font-medium">Scheduled Appointment</span>
                        <div class="flex items-center gap-1.5 justify-end mt-0.5">
                            <span class="text-xs font-bold text-slate-800">
                                {{ $booking->booking_date ? $booking->booking_date->format('M d, Y') : 'Today' }}
                            </span>
                            <span class="inline-flex items-center gap-1 text-[11px] font-black text-amber-900 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded-md">
                                <i class="far fa-clock text-[10px] text-amber-700"></i> {{ $booking->display_slot }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Visual Step-by-Step Progress Timeline -->
                <div class="py-2">
                    <div class="grid grid-cols-4 gap-2 text-center relative">
                        <!-- Progress Bar Line -->
                        <div class="absolute top-4 left-6 right-6 h-1 bg-slate-100 -z-0">
                            @php
                                $barWidthClass = match($currentStage) {
                                    1 => 'w-1/6',
                                    2 => 'w-1/2',
                                    3 => 'w-3/4',
                                    default => 'w-full'
                                };
                            @endphp
                            <div class="h-full bg-teal-500 transition-all duration-500 {{ $barWidthClass }}">
                            </div>
                        </div>

                        <!-- Step 1: Assigned -->
                        <div class="flex flex-col items-center relative z-10">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs {{ $currentStage >= 1 ? 'bg-teal-600 text-white shadow-md shadow-teal-500/30' : 'bg-slate-200 text-slate-500' }}">
                                <i class="fas fa-check"></i>
                            </div>
                            <span class="text-[11px] font-bold mt-1.5 {{ $currentStage >= 1 ? 'text-teal-900' : 'text-slate-400' }}">Assigned</span>
                        </div>

                        <!-- Step 2: Out for Collection -->
                        <div class="flex flex-col items-center relative z-10">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs {{ $currentStage >= 2 ? 'bg-blue-600 text-white shadow-md shadow-blue-500/30' : 'bg-slate-200 text-slate-500' }}">
                                <i class="fas fa-motorcycle"></i>
                            </div>
                            <span class="text-[11px] font-bold mt-1.5 {{ $currentStage >= 2 ? 'text-blue-900' : 'text-slate-400' }}">On The Way</span>
                        </div>

                        <!-- Step 3: Sample Collected -->
                        <div class="flex flex-col items-center relative z-10">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs {{ $currentStage >= 3 ? 'bg-emerald-600 text-white shadow-md shadow-emerald-500/30' : 'bg-slate-200 text-slate-500' }}">
                                <i class="fas fa-vial"></i>
                            </div>
                            <span class="text-[11px] font-bold mt-1.5 {{ $currentStage >= 3 ? 'text-emerald-900' : 'text-slate-400' }}">Sample Taken</span>
                        </div>

                        <!-- Step 4: Delivered to Lab -->
                        <div class="flex flex-col items-center relative z-10">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs {{ $currentStage >= 4 ? 'bg-purple-600 text-white shadow-md shadow-purple-500/30' : 'bg-slate-200 text-slate-500' }}">
                                <i class="fas fa-flask"></i>
                            </div>
                            <span class="text-[11px] font-bold mt-1.5 {{ $currentStage >= 4 ? 'text-purple-900' : 'text-slate-400' }}">Handed to Lab</span>
                        </div>
                    </div>
                </div>

                <!-- Stage Details & Notes -->
                @if($booking->sample_collected_at || $booking->sample_notes)
                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-100 text-xs text-slate-600 flex flex-wrap gap-4">
                        @if($booking->sample_collected_at)
                            <div>
                                <span class="font-bold text-slate-500">Collected At:</span>
                                <span class="font-semibold text-emerald-700 ml-1">{{ $booking->sample_collected_at->format('M d, Y • h:i A') }}</span>
                            </div>
                        @endif
                        @if($booking->sample_notes)
                            <div>
                                <span class="font-bold text-slate-500">Collector Notes:</span>
                                <span class="italic text-slate-700 ml-1">{{ $booking->sample_notes }}</span>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Interactive Stage Transition Buttons -->
                <div class="pt-2 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3">
                    <div class="flex flex-wrap items-center gap-2">
                        @if($currentStage == 1)
                            <form action="{{ route('agent.update_sample_status', $booking->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="sample_status" value="Out for Collection">
                                <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-sm transition">
                                    <i class="fas fa-motorcycle"></i> Start Journey (On The Way)
                                </button>
                            </form>
                        @elseif($currentStage == 2)
                            <form action="{{ route('agent.update_sample_status', $booking->id) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                <input type="hidden" name="sample_status" value="Sample Collected">
                                <input type="text" name="notes" placeholder="Optional notes (e.g. 2 vials drawn)" class="px-3 py-1.5 border border-slate-200 rounded-lg text-xs font-medium w-48 sm:w-60">
                                <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-sm transition">
                                    <i class="fas fa-check-circle"></i> Mark Sample Collected
                                </button>
                            </form>
                        @elseif($currentStage == 3)
                            <form action="{{ route('agent.update_sample_status', $booking->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="sample_status" value="Delivered to Lab">
                                <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold shadow-sm transition">
                                    <i class="fas fa-flask"></i> Mark Handed to Lab (Finished)
                                </button>
                            </form>
                        @else
                            <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700 bg-emerald-50 px-3 py-1.5 rounded-lg border border-emerald-200">
                                <i class="fas fa-badge-check text-emerald-600"></i> Sample Completed & Delivered to Laboratory
                            </span>
                        @endif
                    </div>

                    <a href="{{ route('agent.dashboard') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800">
                        View Full Details <i class="fas fa-chevron-right ml-1 text-[10px]"></i>
                    </a>
                </div>

            </div>
        @empty
            <div class="bg-white rounded-2xl p-10 text-center border border-slate-200 shadow-sm">
                <p class="text-sm font-bold text-slate-600">No collection records match this filter.</p>
            </div>
        @endforelse
    </div>

</div>
@endsection
