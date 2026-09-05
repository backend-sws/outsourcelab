@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 bg-gray-50/50">
    <div class="max-w-5xl mx-auto">
        <h2 class="text-2xl font-extrabold text-brand-dark mb-6">My Bookings</h2>
        
        <div class="space-y-6">
            @if($profile->bookings->isEmpty())
                {{-- Empty State --}}
                <div class="bg-white rounded-xl border border-dashed border-gray-300 shadow-sm p-16 text-center">
                    <div class="w-20 h-20 mx-auto bg-brand-light/20 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-calendar-check text-3xl text-brand-secondary"></i>
                    </div>
                    <h3 class="font-extrabold text-gray-700 text-xl mb-2">No Bookings Yet</h3>
                    <p class="text-gray-400 font-semibold text-sm mb-6">You haven't booked any tests yet. Browse our packages and book your first test!</p>
                    <a href="/" class="inline-block bg-brand-dark text-white font-bold px-8 py-3 rounded-xl hover:bg-brand-secondary transition shadow-sm">
                        <i class="fas fa-flask mr-2"></i> Browse Packages
                    </a>
                </div>
            @else
                @foreach($profile->bookings->sortByDesc('created_at') as $booking)
                    @php
                        $statusMap = [
                            'Booked'            => ['label' => 'In Progress',  'badge' => 'bg-green-100 text-green-700',    'activeStep' => 1],
                            'Sample Collected'  => ['label' => 'In Progress',  'badge' => 'bg-blue-100 text-blue-700',      'activeStep' => 2],
                            'Processing'        => ['label' => 'Processing',   'badge' => 'bg-yellow-100 text-yellow-700',  'activeStep' => 3],
                            'Report Ready'      => ['label' => 'Completed',    'badge' => 'bg-gray-200 text-gray-600',      'activeStep' => 4],
                        ];
                        $info = $statusMap[$booking->status] ?? ['label' => $booking->status, 'badge' => 'bg-gray-200 text-gray-600', 'activeStep' => 1];
                        $isCompleted = $booking->status === 'Report Ready';
                        $steps = ['Booked', 'Sample Collection', 'Processing', 'Report Ready'];
                        $forName = $booking->familyMember ? $booking->familyMember->name : ($profile->name ?? 'Patient');
                        $tests = is_array($booking->test_details) ? $booking->test_details : [];
                        $testName = !empty($tests) ? (is_string($tests[0]) ? $tests[0] : ($tests[0]['name'] ?? 'Health Package')) : 'Health Package';
                    @endphp

                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden {{ $isCompleted ? 'opacity-80 hover:opacity-100 transition' : '' }}">
                        <div class="{{ $isCompleted ? 'bg-gray-50' : 'bg-brand-light/10' }} border-b border-gray-200 px-6 py-4 flex justify-between items-center">
                            <div>
                                <span class="{{ $info['badge'] }} text-xs font-extrabold px-3 py-1 rounded-full uppercase tracking-wide mr-3">{{ $info['label'] }}</span>
                                <span class="text-sm font-bold text-gray-500">Booking ID: #{{ $booking->booking_reference }}</span>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-gray-800">{{ $booking->booking_date->format('d M Y, h:i A') }}</p>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-6">
                                <div>
                                    <h3 class="font-extrabold text-gray-900 text-lg">{{ $testName }}</h3>
                                    <p class="text-sm text-gray-500 font-semibold mt-1">For: {{ $forName }} • {{ $booking->collection_type }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-black text-brand-dark text-xl">₹{{ number_format($booking->amount, 0) }}</p>
                                    <p class="text-xs text-gray-400 font-bold">
                                        @if($booking->payment_status === 'Paid')
                                            Paid Online
                                        @else
                                            To be paid via Cash
                                        @endif
                                    </p>
                                </div>
                            </div>

                            {{-- Progress Tracker --}}
                            <div class="relative pt-8 pb-4">
                                {{-- Background line --}}
                                <div class="absolute top-12 left-8 right-8 h-1 bg-gray-200 rounded-full z-0"></div>
                                {{-- Progress fill --}}
                                @php $fillWidth = ($info['activeStep'] - 1) / 3 * 100; @endphp
                                <div class="absolute top-12 left-8 h-1 bg-brand-secondary rounded-full z-0" style="width: {{ $fillWidth }}%;"></div>

                                <div class="flex justify-between relative z-10">
                                    @foreach($steps as $i => $stepName)
                                        @php
                                            $stepNum = $i + 1;
                                            $done    = $stepNum < $info['activeStep'];
                                            $active  = $stepNum === $info['activeStep'];
                                            $future  = $stepNum > $info['activeStep'];
                                        @endphp
                                        <div class="text-center {{ $i === 3 ? 'w-28' : 'w-24' }}">
                                            <div class="w-10 h-10 mx-auto rounded-full flex items-center justify-center font-bold text-lg mb-2 shadow-sm border-4 border-white
                                                {{ $done || ($isCompleted) ? 'bg-brand-secondary text-white' : ($active ? 'bg-brand-secondary text-white' : 'bg-gray-200 text-gray-400') }}">
                                                @if($done || $isCompleted)
                                                    <i class="fas fa-check"></i>
                                                @elseif($active && !$isCompleted)
                                                    <i class="fas fa-spinner fa-spin"></i>
                                                @else
                                                    {{ $stepNum }}
                                                @endif
                                            </div>
                                            <p class="text-xs font-{{ $done || $active || $isCompleted ? 'extrabold text-brand-dark' : 'bold text-gray-400' }}">{{ $stepName }}</p>

                                            @if($isCompleted && $i === 3 && $booking->report_file_path)
                                                <a href="{{ asset('storage/' . $booking->report_file_path) }}" target="_blank"
                                                   class="mt-2 inline-block px-4 py-2 bg-brand-dark text-white font-bold text-xs rounded-lg hover:bg-brand-secondary transition shadow-sm w-full text-center">
                                                    <i class="fas fa-download mr-1"></i> Download
                                                </a>
                                            @elseif($isCompleted && $i === 3)
                                                <button class="mt-2 px-4 py-2 bg-brand-dark text-white font-bold text-xs rounded-lg hover:bg-brand-secondary transition shadow-sm w-full">
                                                    <i class="fas fa-download mr-1"></i> Download
                                                </button>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
