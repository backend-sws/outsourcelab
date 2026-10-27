@extends('frontend.layouts.app')

@section('content')
<div class="container mx-auto px-3 sm:px-4 py-4 sm:py-8 bg-gray-50/50">
    <div class="flex flex-col md:flex-row gap-5 md:gap-8">
        <!-- Sidebar -->
        @include('patient.layouts.sidebar')

        <!-- Main Content -->
        <div class="w-full md:w-2/3 lg:w-3/4 space-y-5 sm:space-y-6">

            @if(session('success'))
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-bold flex items-start gap-3 shadow-2xs">
                    <i class="fas fa-check-circle text-emerald-600 mt-0.5 text-base flex-shrink-0"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm font-bold flex items-start gap-3 shadow-2xs">
                    <i class="fas fa-exclamation-circle text-rose-600 mt-0.5 text-base flex-shrink-0"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            @if(session('warning'))
                <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-800 text-xs sm:text-sm font-bold flex items-start gap-3 shadow-2xs">
                    <i class="fas fa-exclamation-triangle text-amber-600 mt-0.5 text-base flex-shrink-0"></i>
                    <div>{{ session('warning') }}</div>
                </div>
            @endif

            <!-- Top Header Bar -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4">
                <div>
                    <h2 class="text-xl sm:text-2xl font-black text-brand-dark flex items-center gap-2">
                        <i class="far fa-calendar-check text-brand-primary"></i>
                        <span>My Test Bookings</span>
                    </h2>
                    <p class="text-[11px] sm:text-xs text-gray-500 font-medium mt-0.5 sm:mt-1">Live diagnostic tracking, assigned phlebotomist details, and test reports in real-time.</p>
                </div>
                <div class="grid grid-cols-2 sm:flex sm:items-center gap-2 w-full sm:w-auto">
                    <a href="{{ route('patient.prescriptions') }}" class="inline-flex items-center justify-center gap-1.5 px-3 py-2 sm:px-4 sm:py-2 rounded-xl bg-white border border-gray-200 text-gray-700 hover:text-brand-dark hover:border-teal-300 font-extrabold text-xs transition shadow-2xs">
                        <i class="fas fa-file-medical text-brand-primary"></i>
                        <span>Upload Rx</span>
                    </a>
                    <a href="/" class="inline-flex items-center justify-center gap-1.5 px-3 py-2 sm:px-4 sm:py-2 rounded-xl bg-brand-dark hover:bg-teal-800 text-white font-extrabold text-xs transition shadow-sm">
                        <i class="fas fa-plus"></i>
                        <span>Book New Test</span>
                    </a>
                </div>
            </div>

            @php
                $allBookings = $profile->bookings->sortByDesc('created_at');
                $totalCount = $allBookings->count();
                $inProgressCount = $allBookings->filter(function($b) {
                    return !in_array($b->status, ['Report Ready', 'Completed', 'Cancelled']);
                })->count();
                $completedCount = $allBookings->filter(function($b) {
                    return in_array($b->status, ['Report Ready', 'Completed']) || !empty($b->report_file_path);
                })->count();
            @endphp

            <!-- Summary Stats Bar (Fully Responsive 3-Column on all mobile widths) -->
            <div class="grid grid-cols-3 gap-2 sm:gap-4">
                <div class="bg-white rounded-xl sm:rounded-2xl border border-gray-200 p-2 sm:p-4 shadow-2xs sm:shadow-sm flex flex-col sm:flex-row items-center sm:items-center gap-1 sm:gap-3 text-center sm:text-left min-w-0">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl bg-teal-50 border border-teal-200 text-teal-800 flex items-center justify-center font-bold text-xs sm:text-base flex-shrink-0">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div class="min-w-0 w-full">
                        <span class="text-[9px] sm:text-[11px] font-black text-slate-600 uppercase tracking-wider block truncate">Total</span>
                        <span class="text-base sm:text-xl font-black text-brand-dark leading-none sm:leading-normal block">{{ $totalCount }}</span>
                    </div>
                </div>

                <div class="bg-white rounded-xl sm:rounded-2xl border border-gray-200 p-2 sm:p-4 shadow-2xs sm:shadow-sm flex flex-col sm:flex-row items-center sm:items-center gap-1 sm:gap-3 text-center sm:text-left min-w-0">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl bg-amber-50 border border-amber-200 text-amber-700 flex items-center justify-center font-bold text-xs sm:text-base flex-shrink-0">
                        <i class="fas fa-running"></i>
                    </div>
                    <div class="min-w-0 w-full">
                        <span class="text-[9px] sm:text-[11px] font-black text-slate-600 uppercase tracking-wider block truncate">In Progress</span>
                        <span class="text-base sm:text-xl font-black text-amber-600 leading-none sm:leading-normal block">{{ $inProgressCount }}</span>
                    </div>
                </div>

                <div class="bg-white rounded-xl sm:rounded-2xl border border-gray-200 p-2 sm:p-4 shadow-2xs sm:shadow-sm flex flex-col sm:flex-row items-center sm:items-center gap-1 sm:gap-3 text-center sm:text-left min-w-0">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center justify-center font-bold text-xs sm:text-base flex-shrink-0">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="min-w-0 w-full">
                        <span class="text-[9px] sm:text-[11px] font-black text-slate-600 uppercase tracking-wider block truncate">Completed</span>
                        <span class="text-base sm:text-xl font-black text-emerald-600 leading-none sm:leading-normal block">{{ $completedCount }}</span>
                    </div>
                </div>
            </div>

            @if($allBookings->isEmpty())
                <!-- Premium High-Trust Empty State -->
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4 sm:p-8 md:p-12 text-center">
                    <div class="w-14 h-14 sm:w-20 sm:h-20 mx-auto bg-gradient-to-tr from-teal-50 to-emerald-100 rounded-2xl sm:rounded-3xl flex items-center justify-center mb-3 sm:mb-5 border border-teal-200 shadow-inner">
                        <i class="fas fa-calendar-plus text-2xl sm:text-3xl text-brand-primary"></i>
                    </div>
                    <h3 class="font-black text-gray-900 text-lg sm:text-xl mb-1.5 sm:mb-2">No Diagnostic Bookings Found</h3>
                    <p class="text-gray-500 font-medium text-xs sm:text-sm max-w-lg mx-auto mb-6 sm:mb-8">
                        You haven't scheduled any pathology tests or preventive health packages yet. Start your wellness journey with certified home sample collection.
                    </p>

                    <!-- Quick Discovery Action Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 sm:gap-4 text-left max-w-3xl mx-auto mb-6 sm:mb-8">
                        <a href="/checkups/1" class="group bg-gradient-to-br from-teal-50/70 to-white p-3.5 sm:p-4 rounded-2xl border border-teal-200 hover:border-brand-primary hover:shadow-md transition">
                            <div class="flex items-center justify-between mb-2.5 sm:mb-3">
                                <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-brand-dark text-white flex items-center justify-center text-xs sm:text-sm shadow-xs">
                                    <i class="fas fa-heartbeat"></i>
                                </div>
                                <span class="text-[9px] sm:text-[10px] font-black uppercase tracking-wider px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800">POPULAR</span>
                            </div>
                            <h4 class="font-extrabold text-xs sm:text-sm text-gray-900 group-hover:text-brand-primary transition">Full Body Packages</h4>
                            <p class="text-[11px] text-gray-500 font-medium mt-1">Liver, Kidney, Lipid, Sugar & 60+ parameters with free home collection.</p>
                            <span class="inline-flex items-center gap-1 text-[11px] sm:text-xs font-black text-brand-primary mt-2.5 sm:mt-3 group-hover:translate-x-0.5 transition-transform">
                                Explore Packages &rarr;
                            </span>
                        </a>

                        <a href="/#single-health-checkup" class="group bg-gradient-to-br from-blue-50/70 to-white p-3.5 sm:p-4 rounded-2xl border border-blue-200 hover:border-blue-500 hover:shadow-md transition">
                            <div class="flex items-center justify-between mb-2.5 sm:mb-3">
                                <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-blue-600 text-white flex items-center justify-center text-xs sm:text-sm shadow-xs">
                                    <i class="fas fa-vial"></i>
                                </div>
                                <span class="text-[9px] sm:text-[10px] font-black uppercase tracking-wider px-2 py-0.5 rounded-full bg-blue-100 text-blue-800">ROUTINE</span>
                            </div>
                            <h4 class="font-extrabold text-xs sm:text-sm text-gray-900 group-hover:text-blue-600 transition">Individual Tests</h4>
                            <p class="text-[11px] text-gray-500 font-medium mt-1">HbA1c, Thyroid Profile, CBC, Vitamin D3, Vitamin B12 and single scans.</p>
                            <span class="inline-flex items-center gap-1 text-[11px] sm:text-xs font-black text-blue-600 mt-2.5 sm:mt-3 group-hover:translate-x-0.5 transition-transform">
                                Search Tests &rarr;
                            </span>
                        </a>

                        <a href="{{ route('patient.prescriptions') }}" class="group bg-gradient-to-br from-amber-50/70 to-white p-3.5 sm:p-4 rounded-2xl border border-amber-200 hover:border-amber-500 hover:shadow-md transition">
                            <div class="flex items-center justify-between mb-2.5 sm:mb-3">
                                <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-amber-500 text-white flex items-center justify-center text-xs sm:text-sm shadow-xs">
                                    <i class="fas fa-file-medical"></i>
                                </div>
                                <span class="text-[9px] sm:text-[10px] font-black uppercase tracking-wider px-2 py-0.5 rounded-full bg-amber-100 text-amber-800">EASY RX</span>
                            </div>
                            <h4 class="font-extrabold text-xs sm:text-sm text-gray-900 group-hover:text-amber-700 transition">Upload Prescription</h4>
                            <p class="text-[11px] text-gray-500 font-medium mt-1">Have a doctor's slip? Upload photo and our lab team will schedule tests for you.</p>
                            <span class="inline-flex items-center gap-1 text-[11px] sm:text-xs font-black text-amber-700 mt-2.5 sm:mt-3 group-hover:translate-x-0.5 transition-transform">
                                Upload Photo &rarr;
                            </span>
                        </a>
                    </div>

                    <a href="/" class="inline-flex items-center justify-center gap-2 bg-brand-dark hover:bg-teal-800 text-white font-extrabold px-6 sm:px-8 py-3 sm:py-3.5 rounded-xl transition shadow-sm hover:shadow-md text-xs sm:text-sm w-full sm:w-auto">
                        <i class="fas fa-flask"></i>
                        <span>Browse Diagnostic Catalogue</span>
                    </a>
                </div>
            @else
                <!-- Filter Tabs Styling -->
                <style>
                    .tab-btn-active {
                        background-color: #115e59 !important;
                        color: #ffffff !important;
                        border-color: #0f766e !important;
                        box-shadow: 0 1px 3px rgba(17, 94, 89, 0.3) !important;
                    }
                    .tab-btn-active i {
                        color: #5eead4 !important;
                    }
                    .tab-btn-active .tab-count-badge {
                        background-color: rgba(255, 255, 255, 0.22) !important;
                        color: #ffffff !important;
                    }

                    .tab-btn-inactive {
                        background-color: transparent !important;
                        color: #334155 !important;
                        border-color: transparent !important;
                    }
                    .tab-btn-inactive:hover, .tab-btn-inactive:focus {
                        background-color: #ffffff !important;
                        color: #0f172a !important;
                    }
                    .tab-btn-inactive i {
                        color: #64748b !important;
                    }
                    .tab-btn-inactive .tab-count-badge {
                        background-color: #e2e8f0 !important;
                        color: #475569 !important;
                    }
                </style>

                <!-- Filter Tabs (Segmented Control Pill Bar) -->
                <div class="bg-gray-100/90 p-1 sm:p-1.5 rounded-2xl flex items-center gap-1 sm:gap-1.5 overflow-x-auto no-scrollbar border border-gray-200/90 shadow-2xs">
                    <button type="button" onclick="filterBookings('all')" id="btn-tab-all" class="booking-tab tab-btn-active flex items-center gap-1.5 px-3 sm:px-4 py-2 rounded-xl text-xs font-black transition-all flex-shrink-0 cursor-pointer">
                        <i class="fas fa-layer-group text-[11px]"></i>
                        <span>All Bookings</span>
                        <span class="tab-count-badge px-1.5 py-0.5 rounded-full text-[10px] font-black">({{ $totalCount }})</span>
                    </button>
                    <button type="button" onclick="filterBookings('active')" id="btn-tab-active" class="booking-tab tab-btn-inactive flex items-center gap-1.5 px-3 sm:px-4 py-2 rounded-xl text-xs font-black transition-all flex-shrink-0 cursor-pointer">
                        <i class="fas fa-running text-[11px]"></i>
                        <span>In Progress</span>
                        <span class="tab-count-badge px-1.5 py-0.5 rounded-full text-[10px] font-black">({{ $inProgressCount }})</span>
                    </button>
                    <button type="button" onclick="filterBookings('completed')" id="btn-tab-completed" class="booking-tab tab-btn-inactive flex items-center gap-1.5 px-3 sm:px-4 py-2 rounded-xl text-xs font-black transition-all flex-shrink-0 cursor-pointer">
                        <i class="fas fa-check-circle text-[11px]"></i>
                        <span>Completed & Reports</span>
                        <span class="tab-count-badge px-1.5 py-0.5 rounded-full text-[10px] font-black">({{ $completedCount }})</span>
                    </button>
                </div>

                <!-- Bookings Cards Container -->
                <div class="space-y-4 sm:space-y-5" id="bookingsListContainer">
                    @foreach($allBookings as $booking)
                        @php
                            $statusMap = [
                                'Booked'                      => ['label' => 'Booked',           'badge' => 'bg-indigo-50 text-indigo-700 border-indigo-200',   'icon' => 'fa-calendar-check', 'activeStep' => 1],
                                'Pending'                     => ['label' => 'Pending',          'badge' => 'bg-amber-50 text-amber-700 border-amber-200',     'icon' => 'fa-clock',          'activeStep' => 1],
                                'Confirmed'                   => ['label' => 'Confirmed',        'badge' => 'bg-blue-50 text-blue-700 border-blue-200',       'icon' => 'fa-check',          'activeStep' => 1],
                                'Assigned'                    => ['label' => 'Agent Assigned',   'badge' => 'bg-teal-50 text-teal-700 border-teal-200',       'icon' => 'fa-motorcycle',     'activeStep' => 2],
                                'Sample Collection Scheduled' => ['label' => 'Scheduled',        'badge' => 'bg-teal-50 text-teal-700 border-teal-200',       'icon' => 'fa-calendar-alt',   'activeStep' => 2],
                                'Out for Collection'          => ['label' => 'Agent On The Way', 'badge' => 'bg-amber-50 text-amber-700 border-amber-200',    'icon' => 'fa-biking',         'activeStep' => 2],
                                'Sample Collected'            => ['label' => 'Sample Collected', 'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'icon' => 'fa-vial',       'activeStep' => 2],
                                'Dispatched'                  => ['label' => 'Processing',       'badge' => 'bg-yellow-50 text-yellow-700 border-yellow-200',   'icon' => 'fa-microscope',   'activeStep' => 3],
                                'Delivered to Lab'            => ['label' => 'Processing',       'badge' => 'bg-yellow-50 text-yellow-700 border-yellow-200',   'icon' => 'fa-microscope',   'activeStep' => 3],
                                'In Process'                  => ['label' => 'Processing',       'badge' => 'bg-yellow-50 text-yellow-700 border-yellow-200',   'icon' => 'fa-microscope',   'activeStep' => 3],
                                'Processing'                  => ['label' => 'Processing',       'badge' => 'bg-yellow-50 text-yellow-700 border-yellow-200',   'icon' => 'fa-microscope',   'activeStep' => 3],
                                'Report Ready'                => ['label' => 'Report Ready',     'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'icon' => 'fa-file-medical-alt', 'activeStep' => 4],
                                'Completed'                   => ['label' => 'Completed',        'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'icon' => 'fa-check-double',     'activeStep' => 4],
                                'Cancelled'                   => ['label' => 'Cancelled',        'badge' => 'bg-rose-50 text-rose-700 border-rose-200',       'icon' => 'fa-times-circle',   'activeStep' => 0],
                            ];
                            $lookupKey = !empty($booking->sample_status) && $booking->sample_status !== 'Pending' ? $booking->sample_status : $booking->status;
                            $info = $statusMap[$lookupKey] ?? [
                                'label' => $booking->status ?: 'Booked',
                                'badge' => 'bg-gray-50 text-gray-700 border-gray-200',
                                'icon'  => 'fa-info-circle',
                                'activeStep' => ($booking->agent ? 2 : 1)
                            ];
                            $isCompleted = in_array($booking->status, ['Report Ready', 'Completed']) || !empty($booking->report_file_path);
                            $filterGroup = $isCompleted ? 'completed' : 'active';
                            $steps = ['Booked', 'Sample Collection', 'Processing', 'Report Ready'];
                            $forName = $booking->familyMember ? $booking->familyMember->name : ($profile->name ?? 'Patient (Self)');
                            $relation = $booking->familyMember ? $booking->familyMember->relation : 'Self';
                            $testDetails = is_array($booking->test_details) ? $booking->test_details : (json_decode($booking->test_details, true) ?: []);
                        @endphp

                        <div class="booking-item-card bg-white rounded-2xl border border-gray-200 hover:border-teal-300 shadow-sm transition overflow-hidden" data-status-group="{{ $filterGroup }}">
                            
                            <!-- Card Header Bar -->
                            <div class="bg-gradient-to-r from-gray-50/80 via-white to-gray-50/80 border-b border-gray-200 px-3.5 sm:px-6 py-3 sm:py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 sm:gap-3">
                                <div class="flex items-center gap-2 sm:gap-3 flex-wrap">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 sm:px-3 py-1 rounded-xl bg-gray-100 text-gray-800 font-mono font-bold text-[11px] sm:text-xs border border-gray-200">
                                        <i class="fas fa-barcode text-gray-400"></i>
                                        <span>#{{ $booking->booking_reference }}</span>
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 sm:px-3 py-1 rounded-xl border text-[11px] sm:text-xs font-black {{ $info['badge'] }}">
                                        <i class="fas {{ $info['icon'] }}"></i>
                                        <span>{{ $info['label'] }}</span>
                                    </span>
                                    @if($booking->cancellation_request_status === 'requested')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 sm:px-3 py-1 rounded-xl border border-amber-300 bg-amber-50 text-amber-800 text-[11px] sm:text-xs font-black animate-pulse">
                                            <i class="fas fa-hourglass-half text-amber-600"></i>
                                            <span>Cancellation Under Review</span>
                                        </span>
                                    @elseif($booking->refund_status === 'refunded')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 sm:px-3 py-1 rounded-xl border border-emerald-300 bg-emerald-50 text-emerald-800 text-[11px] sm:text-xs font-black">
                                            <i class="fas fa-check-circle text-emerald-600"></i>
                                            <span>Refund Processed (₹{{ number_format($booking->refund_amount, 2) }})</span>
                                        </span>
                                    @endif
                                    <span class="text-xs font-bold text-gray-600 flex items-center gap-1">
                                        <i class="far fa-user text-gray-400"></i>
                                        <span>For: <strong class="text-gray-900">{{ $booking->beneficiary_display }}</strong></span>
                                    </span>
                                </div>
                                <div class="text-left sm:text-right flex flex-row sm:flex-col items-center sm:items-end justify-between sm:justify-start gap-2 sm:gap-0">
                                    <p class="text-xs font-black text-gray-900 flex items-center gap-1.5">
                                        <i class="far fa-calendar-alt text-teal-600"></i>
                                        <span>{{ $booking->booking_date ? $booking->booking_date->format('d M Y') : $booking->created_at->format('d M Y') }}</span>
                                    </p>
                                    <span class="inline-flex items-center gap-1 text-[10px] sm:text-[11px] font-black text-amber-900 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded-md sm:mt-1 shadow-2xs">
                                        <i class="far fa-clock text-[9px] sm:text-[10px] text-amber-700"></i>
                                        <span>{{ $booking->display_slot }}</span>
                                    </span>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="p-3.5 sm:p-6 space-y-4 sm:space-y-5">
                                
                                <!-- Tests List & Pricing Row -->
                                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 sm:gap-5">
                                    <div class="space-y-2 flex-1 min-w-0">
                                        <span class="text-[10px] sm:text-[11px] font-extrabold uppercase tracking-wider text-gray-400">Diagnostic Tests & Packages</span>
                                        
                                        @if(!empty($testDetails))
                                            <div class="space-y-1.5">
                                                @foreach($testDetails as $test)
                                                    @php
                                                        $tName = is_array($test) ? ($test['name'] ?? 'Diagnostic Test') : $test;
                                                        $tPrice = is_array($test) ? ($test['price'] ?? ($test['selling_price'] ?? 0)) : 0;
                                                        $tType = is_array($test) ? ($test['type'] ?? null) : null;
                                                    @endphp
                                                    <div class="flex items-center justify-between gap-2.5 bg-gray-50/80 rounded-xl px-3 py-2 border border-gray-100">
                                                        <div class="flex items-center gap-2 min-w-0">
                                                            <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-lg bg-teal-100/60 text-brand-dark flex items-center justify-center text-xs flex-shrink-0">
                                                                <i class="fas fa-flask"></i>
                                                            </div>
                                                            <span class="font-extrabold text-xs text-gray-900 truncate">{{ $tName }}</span>
                                                            @if($tType)
                                                                <span class="text-[9px] sm:text-[10px] px-1.5 sm:px-2 py-0.5 rounded-full font-bold {{ $tType === 'package' ? 'bg-amber-100 text-amber-800' : 'bg-blue-100 text-blue-800' }}">
                                                                    {{ ucfirst($tType) }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                        @if($tPrice > 0)
                                                            <span class="font-black text-xs text-brand-dark flex-shrink-0">
                                                                ₹{{ number_format($tPrice, 0) }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-xs font-bold text-gray-700">General Diagnostic Health Checkup</p>
                                        @endif

                                        @if(($booking->coins_redeemed ?? 0) > 0 || ($booking->coins_earned ?? 0) > 0)
                                            <div class="flex items-center gap-2 pt-1 flex-wrap">
                                                @if(($booking->coins_redeemed ?? 0) > 0)
                                                    <span class="inline-flex items-center gap-1 text-[10px] sm:text-[11px] font-bold text-amber-900 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded-md">
                                                        <span>🪙</span> Redeemed {{ $booking->coins_redeemed }} Coins (-₹{{ number_format($booking->coins_discount, 0) }})
                                                    </span>
                                                @endif
                                                @if(($booking->coins_earned ?? 0) > 0)
                                                    <span class="inline-flex items-center gap-1 text-[10px] sm:text-[11px] font-bold text-emerald-900 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-md">
                                                        <span>🪙</span> Earned +{{ $booking->coins_earned }} Coins
                                                    </span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Price & Payment Summary Card -->
                                    <div class="lg:text-right lg:border-l lg:border-gray-100 lg:pl-6 flex-shrink-0 pt-2 lg:pt-0 border-t lg:border-t-0 border-gray-100">
                                        <div class="flex items-center justify-between lg:block">
                                            <div>
                                                <span class="text-[10px] sm:text-[11px] font-extrabold uppercase tracking-wider text-gray-400 block">Total Amount</span>
                                                <span class="text-xl sm:text-2xl font-black text-brand-dark block mt-0.5">₹{{ number_format($booking->amount, 0) }}</span>
                                            </div>
                                            <div class="text-right lg:text-right">
                                                <div class="flex items-center lg:justify-end gap-1.5 flex-wrap">
                                                    <span class="inline-flex items-center gap-1 text-[10px] sm:text-[11px] font-extrabold px-2.5 py-0.5 rounded-full {{ $booking->payment_status === 'Paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                                        <i class="fas {{ $booking->payment_status === 'Paid' ? 'fa-check-circle text-emerald-600' : 'fa-hourglass-half text-amber-600' }} text-[10px]"></i>
                                                        <span>{{ $booking->payment_status === 'Paid' ? 'Paid Online' : ($booking->payment_method === 'Cash' ? 'Pay on Collection' : 'Payment Pending') }}</span>
                                                    </span>
                                                </div>
                                                <span class="text-[10px] sm:text-[11px] text-gray-500 font-semibold block mt-1">
                                                    <i class="fas fa-map-pin text-[10px] mr-1 text-teal-600"></i> {{ $booking->collection_type ?: 'Home Collection' }}
                                                </span>
                                            </div>
                                        </div>

                                        @if($booking->razorpay_payment_id)
                                            <span class="font-mono text-[9px] sm:text-[10px] text-gray-400 block mt-1">ID: {{ $booking->razorpay_payment_id }}</span>
                                        @endif

                                        @if($booking->payment_status !== 'Paid' && $booking->status !== 'Cancelled')
                                            <button type="button" onclick="retryBookingPayment({{ $booking->id }}, {{ $booking->amount }}, '{{ $booking->booking_reference }}', this)" class="mt-2 w-full lg:w-auto inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs transition shadow-xs cursor-pointer">
                                                <i class="fas fa-credit-card text-[10px]"></i>
                                                <span>Pay Online Now</span>
                                            </button>
                                        @endif
                                    </div>
                                </div>

                                <!-- Assigned Phlebotomist Card -->
                                @if($booking->agent)
                                    <div class="p-3 sm:p-3.5 rounded-xl bg-teal-50/60 border border-teal-200 flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 sm:gap-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-teal-600 text-white flex items-center justify-center font-bold text-xs sm:text-sm shadow-sm flex-shrink-0">
                                                <i class="fas fa-motorcycle"></i>
                                            </div>
                                            <div class="min-w-0">
                                                <div class="flex items-center gap-2 flex-wrap">
                                                    <span class="text-[9px] sm:text-[10px] uppercase font-black tracking-wider text-teal-800">Assigned Phlebotomist</span>
                                                    <span class="text-[9px] sm:text-[10px] bg-teal-200 text-teal-900 font-bold px-2 py-0.2 rounded-full">{{ $booking->sample_status ?: 'Assigned' }}</span>
                                                </div>
                                                <h4 class="font-black text-teal-950 text-xs sm:text-sm truncate">{{ $booking->agent->name }}</h4>
                                                @if($booking->agent->vehicle_number)
                                                    <p class="text-[10px] sm:text-[11px] text-teal-700 font-medium">Vehicle: {{ $booking->agent->vehicle_number }}</p>
                                                @endif
                                            </div>
                                        </div>

                                        @if($booking->agent->phone)
                                            <a href="tel:{{ $booking->agent->phone }}" class="inline-flex items-center justify-center gap-1.5 px-3.5 py-1.5 sm:px-4 sm:py-2 rounded-xl bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold transition shadow-sm w-full sm:w-fit">
                                                <i class="fas fa-phone-alt text-[10px]"></i>
                                                <span>Call Phlebotomist: {{ $booking->agent->phone }}</span>
                                            </a>
                                        @endif
                                    </div>
                                @endif

                                <!-- 4-Step Diagnostic Progress Tracker (Fluid Responsive) -->
                                <div class="relative pt-4 sm:pt-6 pb-2">
                                    {{-- Background line --}}
                                    <div class="absolute top-8 sm:top-10 left-5 sm:left-8 right-5 sm:right-8 h-1 bg-gray-200 rounded-full z-0"></div>
                                    {{-- Progress fill line --}}
                                    @php 
                                        $stepIdx = max(1, min(4, $info['activeStep']));
                                        $fillPct = ($stepIdx - 1) / 3 * 100; 
                                    @endphp
                                    <div class="absolute top-8 sm:top-10 left-5 sm:left-8 right-5 sm:right-8 h-1 z-0 pointer-events-none">
                                        <div class="h-full bg-brand-primary rounded-full transition-all duration-500" style="width: {{ (int)$fillPct }}%;"></div>
                                    </div>

                                    <div class="flex justify-between relative z-10">
                                        @foreach($steps as $i => $stepTitle)
                                            @php
                                                $sNum = $i + 1;
                                                $done = $sNum < $info['activeStep'] || $isCompleted;
                                                $current = ($sNum === $info['activeStep']) && !$isCompleted;
                                            @endphp
                                            <div class="text-center flex-1 min-w-0 px-0.5">
                                                <div class="w-7 h-7 sm:w-9 sm:h-9 mx-auto rounded-full flex items-center justify-center font-bold text-xs sm:text-sm mb-1 sm:mb-2 shadow-sm border-2 sm:border-4 border-white transition-all
                                                    {{ $done ? 'bg-brand-primary text-white' : ($current ? 'bg-amber-500 text-white animate-pulse' : 'bg-gray-200 text-gray-400') }}">
                                                    @if($done)
                                                        <i class="fas fa-check text-[10px] sm:text-xs"></i>
                                                    @elseif($current)
                                                        <i class="fas fa-spinner fa-spin text-[10px] sm:text-xs"></i>
                                                    @else
                                                        {{ $sNum }}
                                                    @endif
                                                </div>
                                                <p class="text-[9px] sm:text-xs leading-tight font-{{ $done || $current ? 'extrabold text-brand-dark' : 'semibold text-gray-400' }} truncate sm:overflow-visible">
                                                    {{ $stepTitle }}
                                                </p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Card Footer Actions -->
                                <div class="pt-3.5 sm:pt-4 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 sm:gap-3">
                                    <div class="flex items-center gap-2 flex-wrap w-full sm:w-auto">
                                        @if($booking->report_file_path)
                                            <a href="{{ route('patient.bookings.download_report', $booking->id) }}" class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 sm:px-4 sm:py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-extrabold shadow-sm transition flex-1 sm:flex-initial">
                                                <i class="fas fa-file-pdf"></i>
                                                <span>Download Report</span>
                                            </a>
                                            <a href="{{ $booking->report_url }}" target="_blank" class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 sm:px-3 sm:py-2 rounded-xl bg-white hover:bg-slate-50 text-slate-700 hover:text-teal-900 border border-slate-200 text-xs font-bold transition shadow-2xs">
                                                <i class="far fa-eye text-teal-700"></i>
                                                <span>View Online</span>
                                            </a>
                                        @elseif($isCompleted)
                                            <span class="inline-flex items-center gap-1.5 text-[11px] sm:text-xs font-bold text-emerald-800 bg-emerald-50 border border-emerald-200 px-3 py-1.5 rounded-xl">
                                                <i class="fas fa-check-circle text-emerald-600"></i>
                                                <span>Report Generated • Check Reports tab</span>
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 text-[11px] sm:text-xs font-bold text-gray-500 bg-gray-50 border border-gray-200 px-2.5 sm:px-3 py-1.5 rounded-xl">
                                                <i class="fas fa-shield-alt text-teal-600"></i>
                                                <span>Under Protocol & Tracking</span>
                                            </span>
                                        @endif

                                        <a href="{{ route('patient.bookings.invoice', $booking->id) }}" target="_blank" class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 sm:px-3.5 sm:py-2 rounded-xl bg-slate-100 hover:bg-teal-50 text-slate-700 hover:text-teal-950 border border-slate-200 hover:border-teal-300 text-xs font-bold transition shadow-2xs">
                                            <i class="fas fa-file-invoice text-teal-700"></i>
                                            <span>Invoice</span>
                                        </a>
                                    </div>

                                    <div class="flex items-center justify-between sm:justify-end gap-2.5 sm:gap-3 w-full sm:w-auto pt-1 sm:pt-0 flex-wrap">
                                        @php
                                            $canModify = !in_array($booking->status, ['Sample Collected', 'In Process', 'Processing', 'Report Ready', 'Completed', 'Cancelled']) && $booking->sample_status !== 'Sample Collected';
                                        @endphp
                                        @if($canModify)
                                            <button type="button" onclick="openModifyBookingModal({{ $booking->id }})" class="inline-flex items-center gap-1.5 px-3 py-1.5 sm:px-3.5 sm:py-1.5 rounded-xl bg-teal-50 hover:bg-teal-100 text-teal-800 border border-teal-200 text-xs font-black transition shadow-2xs hover:shadow-xs cursor-pointer">
                                                <i class="fas fa-edit text-[11px] text-teal-700"></i>
                                                <span>Modify Booking</span>
                                            </button>
                                        @endif

                                        {{-- Cancellation Request Button & Statuses --}}
                                        @if($booking->cancellation_request_status === 'requested')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-50 text-amber-800 border border-amber-200 text-xs font-bold" title="Reason: {{ $booking->cancellation_reason }}">
                                                <i class="fas fa-hourglass-half text-amber-600"></i>
                                                <span>Cancellation Under Review</span>
                                            </span>
                                        @elseif($booking->cancellation_request_status === 'rejected')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-rose-50 text-rose-800 border border-rose-200 text-xs font-bold" title="{{ $booking->cancellation_admin_notes ?: 'Declined by lab administration' }}">
                                                <i class="fas fa-times-circle text-rose-600"></i>
                                                <span>Cancellation Declined</span>
                                            </span>
                                            @if($booking->canRequestCancellation())
                                                <button type="button" onclick="openCancelModal({{ $booking->id }}, '{{ $booking->booking_reference }}', {{ $booking->refundable_amount }})" class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 text-xs font-bold transition cursor-pointer">
                                                    <i class="fas fa-ban text-[11px] text-rose-600"></i>
                                                    <span>Re-request</span>
                                                </button>
                                            @endif
                                        @elseif($booking->canRequestCancellation())
                                            <button type="button" onclick="openCancelModal({{ $booking->id }}, '{{ $booking->booking_reference }}', {{ $booking->refundable_amount }})" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 hover:text-rose-900 border border-rose-200 text-xs font-bold transition shadow-2xs hover:shadow-xs cursor-pointer">
                                                <i class="fas fa-ban text-[11px] text-rose-600"></i>
                                                <span>Cancel Booking</span>
                                            </button>
                                        @endif

                                        <a href="{{ route('patient.reports') }}" class="text-xs font-bold text-teal-700 hover:text-brand-dark transition flex items-center gap-1">
                                            <span>All Reports</span>
                                            <i class="fas fa-chevron-right text-[10px]"></i>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    function filterBookings(type) {
        // 1. Update button states
        document.querySelectorAll('.booking-tab').forEach(btn => {
            btn.classList.remove('tab-btn-active');
            btn.classList.add('tab-btn-inactive');
            btn.blur();
        });
        const activeBtn = document.getElementById('btn-tab-' + type);
        if (activeBtn) {
            activeBtn.classList.remove('tab-btn-inactive');
            activeBtn.classList.add('tab-btn-active');
        }

        // 2. Filter booking cards
        const cards = document.querySelectorAll('.booking-item-card');
        cards.forEach(card => {
            const group = card.getAttribute('data-status-group');
            if (type === 'all') {
                card.style.display = 'block';
            } else if (type === group) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

    function retryBookingPayment(bookingId, amount, ref, btn) {
        let originalHtml = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin text-xs"></i>';

        fetch("{{ url('razorpay/booking') }}/" + bookingId + "/retry", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(r => r.json())
        .then(data => {
            if (!data.success) {
                alert(data.message || 'Payment retry initialization failed.');
                btn.disabled = false;
                btn.innerHTML = originalHtml;
                return;
            }

            const options = {
                key: data.key,
                amount: data.amount,
                currency: data.currency || 'INR',
                name: data.name || 'Av Wellcare Diagnostics',
                description: data.description || ('Payment for #' + ref),
                order_id: data.order_id,
                prefill: data.prefill || {},
                theme: data.theme || { color: '#0d9488' },
                handler: function(response) {
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin text-xs"></i> Verifying...';
                    fetch("{{ route('razorpay.payment.verify') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            razorpay_payment_id: response.razorpay_payment_id,
                            razorpay_order_id: response.razorpay_order_id,
                            razorpay_signature: response.razorpay_signature,
                            booking_id: bookingId
                        })
                    })
                    .then(vr => vr.json())
                    .then(vData => {
                        if (vData.success) {
                            window.location.reload();
                        } else {
                            alert('Verification failed: ' + (vData.message || 'Please contact support.'));
                            window.location.reload();
                        }
                    })
                    .catch(() => {
                        alert('Network issue during verification. Your booking will update automatically.');
                        window.location.reload();
                    });
                },
                modal: {
                    ondismiss: function() {
                        btn.disabled = false;
                        btn.innerHTML = originalHtml;
                    }
                }
            };

            const rzp = new Razorpay(options);
            rzp.on('payment.failed', function(response) {
                alert('Payment failed: ' + (response.error.description || 'Declined'));
                btn.disabled = false;
                btn.innerHTML = originalHtml;
            });
            rzp.open();
        })
        .catch(() => {
            alert('Network error. Please try again.');
            btn.disabled = false;
            btn.innerHTML = originalHtml;
        });
    }

    function openCancelModal(bookingId, reference, refundableAmount) {
        const form = document.getElementById('cancelBookingForm');
        form.action = "{{ url('patient/bookings') }}/" + bookingId + "/request-cancellation";
        document.getElementById('cancelModalBookingRef').innerText = '#' + reference;
        
        const refundNoteBox = document.getElementById('cancelModalRefundNote');
        const refundAmountEl = document.getElementById('cancelModalRefundAmount');
        if (refundableAmount > 0) {
            refundAmountEl.innerText = '₹' + Number(refundableAmount).toLocaleString('en-IN', { minimumFractionDigits: 2 });
            refundNoteBox.classList.remove('hidden');
        } else {
            refundNoteBox.classList.add('hidden');
        }

        document.getElementById('cancelBookingModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeCancelModal() {
        document.getElementById('cancelBookingModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        document.getElementById('cancelBookingForm').reset();
    }
</script>

<!-- Cancel Booking Modal -->
<div id="cancelBookingModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" onclick="closeCancelModal()"></div>

    <div class="flex min-h-full items-center justify-center p-3 sm:p-4 text-center">
        <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all w-full max-w-lg border border-slate-100 my-8">
            
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-rose-900 via-rose-800 to-slate-900 px-6 py-4 text-white flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-ban text-rose-300"></i>
                        <h3 class="text-base sm:text-lg font-black tracking-tight">Request Booking Cancellation</h3>
                    </div>
                    <p class="text-xs text-rose-100/80 mt-0.5">Booking Ref: <span id="cancelModalBookingRef" class="font-mono font-bold text-white">#--</span></p>
                </div>
                <button type="button" onclick="closeCancelModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition cursor-pointer flex-shrink-0">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>

            <!-- Modal Form -->
            <form id="cancelBookingForm" method="POST" action="" class="p-6 space-y-4">
                @csrf

                <!-- Informational Policy Card -->
                <div class="p-3.5 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 text-xs space-y-1">
                    <p class="font-bold flex items-center gap-1.5 text-amber-800">
                        <i class="fas fa-info-circle text-amber-600"></i> Cancellation Policy:
                    </p>
                    <p class="text-amber-700 leading-relaxed">
                        To maintain clinical readiness and avoid unnecessary phlebotomist transit, cancellations are reviewed by the medical dispatch team before approval.
                    </p>
                </div>

                <!-- Refund Notification Banner (Dynamic) -->
                <div id="cancelModalRefundNote" class="hidden p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs">
                    <div class="flex items-start gap-2">
                        <i class="fas fa-wallet text-emerald-600 mt-0.5 text-sm"></i>
                        <div>
                            <p class="font-black text-emerald-800">Automatic Razorpay Refund:</p>
                            <p class="text-emerald-700 mt-0.5 leading-relaxed">
                                You paid <strong id="cancelModalRefundAmount" class="text-emerald-900">₹0.00</strong> online. Upon admin approval, this amount will be automatically refunded back to your original payment method via Razorpay within 5-7 business days.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Reason Selection -->
                <div>
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-1.5">
                        Reason for Cancellation <span class="text-rose-500">*</span>
                    </label>
                    <select name="reason" required class="w-full text-xs font-bold border border-slate-300 rounded-xl px-3.5 py-2.5 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none transition">
                        <option value="" disabled selected>-- Select a reason --</option>
                        <option value="Doctor modified or cancelled prescription">Doctor modified or cancelled prescription</option>
                        <option value="Patient feeling better / Test no longer required">Patient feeling better / Test no longer required</option>
                        <option value="Date / Time slot not suitable (Want to re-schedule)">Date / Time slot not suitable (Want to re-schedule)</option>
                        <option value="Found another diagnostic facility">Found another diagnostic facility</option>
                        <option value="Personal emergency or travel">Personal emergency or travel</option>
                        <option value="Duplicate booking created by mistake">Duplicate booking created by mistake</option>
                        <option value="Other reason">Other reason</option>
                    </select>
                </div>

                <!-- Additional Notes Textarea -->
                <div>
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-1.5">
                        Additional Notes / Remarks (Optional)
                    </label>
                    <textarea name="notes" rows="3" placeholder="Please describe any additional details for the medical administrator..." class="w-full text-xs font-medium border border-slate-300 rounded-xl px-3.5 py-2.5 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none transition"></textarea>
                </div>

                <!-- Actions -->
                <div class="pt-2 flex items-center justify-end gap-3 border-t border-slate-100">
                    <button type="button" onclick="closeCancelModal()" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 text-xs font-bold transition cursor-pointer">
                        Nevermind, Keep Booking
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-rose-600 to-rose-700 hover:from-rose-700 hover:to-rose-800 text-white text-xs font-black shadow-md hover:shadow-lg transition cursor-pointer flex items-center gap-1.5">
                        <i class="fas fa-paper-plane text-xs"></i>
                        <span>Submit Request</span>
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
