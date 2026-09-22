@extends('frontend.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 bg-gray-50/50">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar -->
        @include('patient.layouts.sidebar')

        <!-- Main Content -->
        <div class="w-full md:w-2/3 lg:w-3/4 space-y-6">

            <!-- Success Alert -->
            @if(session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-sm animate-fade-in">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                        <i class="fas fa-check-circle text-lg"></i>
                    </div>
                    <div>
                        <p class="font-bold text-sm">{{ session('success') }}</p>
                        <p class="text-xs text-emerald-600">Your profile details have been saved and updated across all reports.</p>
                    </div>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 text-lg font-bold p-1">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            @endif

            <!-- Validation Errors Alert -->
            @if(isset($errors) && $errors->any())
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 shadow-sm">
                <div class="flex items-center gap-2 mb-2 font-bold text-sm">
                    <i class="fas fa-exclamation-triangle text-rose-500 text-base"></i>
                    <span>Please correct the errors below before saving:</span>
                </div>
                <ul class="list-disc list-inside text-xs space-y-1 font-medium text-rose-700 ml-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Patient Hero Passport Card -->
            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm relative overflow-hidden">
                <div class="absolute -right-10 -bottom-10 w-48 h-48 rounded-full bg-teal-500/5 blur-2xl pointer-events-none"></div>

                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 pb-6 border-b border-gray-100 relative z-10">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-brand-dark to-teal-600 text-white flex items-center justify-center font-black text-2xl shadow-md flex-shrink-0">
                            {{ strtoupper(substr($profile->name ?: 'P', 0, 1)) }}
                        </div>
                        <div>
                            <div class="flex items-center gap-2 flex-wrap">
                                <h2 class="text-2xl font-black text-brand-dark">{{ $profile->name ?: 'Patient Profile' }}</h2>
                                <span class="inline-flex items-center gap-1 bg-emerald-50 border border-emerald-200 text-emerald-700 text-[11px] font-extrabold px-2.5 py-0.5 rounded-full">
                                    <i class="fas fa-shield-alt text-[10px]"></i> Verified Patient
                                </span>
                                <span class="text-xs font-mono font-bold text-gray-500 bg-gray-100 px-2 py-0.5 rounded-md">
                                    #PAT-{{ str_pad($profile->id, 5, '0', STR_PAD_LEFT) }}
                                </span>
                            </div>

                            <p class="text-xs text-gray-500 font-medium mt-1 flex items-center gap-3 flex-wrap">
                                <span><i class="fas fa-phone-alt text-brand-primary mr-1"></i> +91 {{ $profile->mobile }}</span>
                                <span><i class="far fa-envelope text-gray-400 mr-1"></i> {{ $profile->email !== '-' ? $profile->email : 'Email not updated' }}</span>
                                <span><i class="far fa-calendar-check text-gray-400 mr-1"></i> Member since {{ $profile->created_at ? $profile->created_at->format('M Y') : 'Recent' }}</span>
                            </p>
                        </div>
                    </div>

                    <!-- Quick Action Buttons -->
                    <div class="flex items-center gap-2 flex-wrap sm:flex-nowrap">
                        <a href="/" class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 bg-brand-dark hover:bg-brand-primary text-white text-xs font-extrabold rounded-xl shadow-sm transition flex-shrink-0">
                            <i class="fas fa-plus"></i> Book Test
                        </a>
                        <a href="{{ route('patient.prescriptions') }}" class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 bg-white border border-gray-200 hover:border-teal-300 text-gray-700 text-xs font-extrabold rounded-xl shadow-2xs transition flex-shrink-0">
                            <i class="fas fa-file-medical text-teal-600"></i> Upload Rx
                        </a>
                    </div>
                </div>

                <!-- 4 Quick Metric Cards -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-5 relative z-10">
                    <!-- Bookings -->
                    <a href="{{ route('patient.bookings') }}" class="p-3.5 bg-gray-50/80 hover:bg-teal-50/60 rounded-xl border border-gray-100 hover:border-teal-200 transition group">
                        <span class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider group-hover:text-brand-dark">My Bookings</span>
                        <div class="flex items-center justify-between mt-1">
                            <span class="text-2xl font-black text-brand-dark">{{ $profile->bookings->count() }}</span>
                            <i class="fas fa-calendar-check text-gray-300 group-hover:text-brand-primary transition text-base"></i>
                        </div>
                        <span class="text-[10px] font-bold text-teal-600 mt-1 block">
                            {{ $profile->bookings->whereNotIn('status', ['Completed', 'Cancelled'])->count() }} In Progress &rarr;
                        </span>
                    </a>

                    <!-- Lab Reports -->
                    <a href="{{ route('patient.reports') }}" class="p-3.5 bg-gray-50/80 hover:bg-teal-50/60 rounded-xl border border-gray-100 hover:border-teal-200 transition group">
                        <span class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider group-hover:text-brand-dark">Lab Reports</span>
                        <div class="flex items-center justify-between mt-1">
                            <span class="text-2xl font-black text-brand-dark">{{ $profile->bookings->whereIn('status', ['Completed', 'Report Ready'])->count() }}</span>
                            <i class="fas fa-file-medical-alt text-gray-300 group-hover:text-brand-primary transition text-base"></i>
                        </div>
                        <span class="text-[10px] font-bold text-emerald-600 mt-1 block">
                            <i class="fas fa-check-circle text-[9px]"></i> Certified Reports &rarr;
                        </span>
                    </a>

                    <!-- Health Coins -->
                    <a href="{{ route('patient.rewards') }}" class="p-3.5 bg-gray-50/80 hover:bg-teal-50/60 rounded-xl border border-gray-100 hover:border-teal-200 transition group">
                        <span class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider group-hover:text-brand-dark">Health Coins</span>
                        <div class="flex items-center justify-between mt-1">
                            <span class="text-2xl font-black text-amber-600">{{ number_format($profile->reward_coins ?? 0) }}</span>
                            <i class="fas fa-coins text-amber-400 group-hover:scale-110 transition text-base"></i>
                        </div>
                        <span class="text-[10px] font-bold text-amber-700 mt-1 block">
                            Redeem on tests &rarr;
                        </span>
                    </a>

                    <!-- Family Members -->
                    <a href="{{ route('patient.family_members') }}" class="p-3.5 bg-gray-50/80 hover:bg-teal-50/60 rounded-xl border border-gray-100 hover:border-teal-200 transition group">
                        <span class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider group-hover:text-brand-dark">Family Members</span>
                        <div class="flex items-center justify-between mt-1">
                            <span class="text-2xl font-black text-brand-dark">{{ $profile->familyMembers->count() }}</span>
                            <i class="fas fa-users text-gray-300 group-hover:text-brand-primary transition text-base"></i>
                        </div>
                        <span class="text-[10px] font-bold text-gray-500 mt-1 block">
                            Manage family &rarr;
                        </span>
                    </a>
                </div>

                <!-- VIP Privilege Strip -->
                @if($profile->isVipMember())
                    @php $activeVip = $profile->activeMembership(); @endphp
                    <div class="mt-4 p-4 rounded-xl bg-gradient-to-r from-amber-500/15 via-amber-400/5 to-transparent border border-amber-300/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3 relative z-10">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-amber-500 text-white flex items-center justify-center font-bold text-base shadow-sm flex-shrink-0">
                                <i class="fas fa-crown"></i>
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h4 class="text-xs font-black text-brand-dark">Wellcare VIP Member: <span class="text-amber-800">{{ $activeVip->plan_name_snapshot }}</span></h4>
                                    <span class="text-[10px] font-bold bg-amber-200 text-amber-900 px-2 py-0.2 rounded-full">ACTIVE</span>
                                </div>
                                <p class="text-[11px] text-gray-600 font-medium mt-0.5">Flat {{ $activeVip->discount_percentage }}% OFF on all pathology tests • Free home sample collection • Priority report release</p>
                            </div>
                        </div>
                        <a href="{{ route('patient.membership') }}" class="px-3.5 py-1.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-xs font-extrabold transition shadow-xs flex-shrink-0 self-start sm:self-auto">
                            View Card & Perks &rarr;
                        </a>
                    </div>
                @else
                    <div class="mt-4 p-4 rounded-xl bg-gradient-to-r from-teal-900/10 via-amber-500/5 to-transparent border border-teal-200/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3 relative z-10">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-amber-500 text-white flex items-center justify-center font-bold text-sm shadow-sm flex-shrink-0">
                                <i class="fas fa-crown"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-black text-brand-dark">Unlock Wellcare VIP Health Pass</h4>
                                <p class="text-[11px] text-gray-500 font-medium mt-0.5">Save up to 25% on every booking with free home collection for your entire family.</p>
                            </div>
                        </div>
                        <a href="{{ route('patient.membership') }}" class="px-3.5 py-1.5 rounded-xl bg-brand-dark hover:bg-brand-primary text-white text-xs font-extrabold transition shadow-xs flex-shrink-0 self-start sm:self-auto">
                            Explore VIP Plans &rarr;
                        </a>
                    </div>
                @endif
            </div>

            <!-- Dashboard Navigation Tabs -->
            <div class="bg-white rounded-2xl border border-gray-200 p-2 shadow-xs flex items-center gap-2 overflow-x-auto">
                <button type="button" onclick="switchDashboardTab('overview')" id="tabBtn-overview" class="tab-btn flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-xs font-black transition-all bg-brand-dark text-white shadow-xs">
                    <i class="fas fa-chart-pie text-xs"></i>
                    <span>Overview & Live Tracker</span>
                </button>

                <button type="button" onclick="switchDashboardTab('notifications')" id="tabBtn-notifications" class="tab-btn flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-xs font-black transition-all text-gray-600 hover:text-brand-dark hover:bg-gray-50">
                    <i class="fas fa-bell text-xs"></i>
                    <span>Notifications</span>
                    @if($unreadNotificationsCount > 0)
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-rose-500 text-white animate-pulse">
                            {{ $unreadNotificationsCount }}
                        </span>
                    @endif
                </button>

                <button type="button" onclick="switchDashboardTab('profile')" id="tabBtn-profile" class="tab-btn flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-xs font-black transition-all text-gray-600 hover:text-brand-dark hover:bg-gray-50">
                    <i class="far fa-user-circle text-xs"></i>
                    <span>Personal Details & Form</span>
                </button>
            </div>

            <!-- ========================================================= -->
            <!-- TAB 1: OVERVIEW & ACTIVE TRACKER                          -->
            <!-- ========================================================= -->
            <div id="tabContent-overview" class="space-y-6">

                <!-- Active / Ongoing Booking Tracker -->
                @if($activeBooking)
                    @php
                        $statusMap = [
                            'Booked'                      => ['label' => 'Booked',           'badge' => 'bg-indigo-50 text-indigo-700 border-indigo-200',   'icon' => 'fa-calendar-check', 'step' => 1],
                            'Pending'                     => ['label' => 'Pending',          'badge' => 'bg-amber-50 text-amber-700 border-amber-200',     'icon' => 'fa-clock',          'step' => 1],
                            'Confirmed'                   => ['label' => 'Confirmed',        'badge' => 'bg-blue-50 text-blue-700 border-blue-200',       'icon' => 'fa-check',          'step' => 1],
                            'Assigned'                    => ['label' => 'Agent Assigned',   'badge' => 'bg-teal-50 text-teal-700 border-teal-200',       'icon' => 'fa-motorcycle',     'step' => 2],
                            'Sample Collection Scheduled' => ['label' => 'Scheduled',        'badge' => 'bg-teal-50 text-teal-700 border-teal-200',       'icon' => 'fa-calendar-alt',   'step' => 2],
                            'Out for Collection'          => ['label' => 'Agent On The Way', 'badge' => 'bg-amber-50 text-amber-700 border-amber-200',    'icon' => 'fa-biking',         'step' => 2],
                            'Sample Collected'            => ['label' => 'Sample Collected', 'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'icon' => 'fa-vial',       'step' => 2],
                            'In Process'                  => ['label' => 'Lab Processing',   'badge' => 'bg-yellow-50 text-yellow-700 border-yellow-200', 'icon' => 'fa-microscope',   'step' => 3],
                            'Processing'                  => ['label' => 'Lab Processing',   'badge' => 'bg-yellow-50 text-yellow-700 border-yellow-200', 'icon' => 'fa-microscope',   'step' => 3],
                            'Report Ready'                => ['label' => 'Report Ready',     'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'icon' => 'fa-file-medical-alt', 'step' => 4],
                        ];
                        $lookupKey = !empty($activeBooking->sample_status) && $activeBooking->sample_status !== 'Pending' ? $activeBooking->sample_status : $activeBooking->status;
                        $curInfo = $statusMap[$lookupKey] ?? [
                            'label' => $activeBooking->status ?: 'Booked',
                            'badge' => 'bg-gray-50 text-gray-700 border-gray-200',
                            'icon'  => 'fa-info-circle',
                            'step'  => ($activeBooking->agent ? 2 : 1)
                        ];
                        $activeFor = $activeBooking->familyMember ? $activeBooking->familyMember->name : ($profile->name ?? 'Self');
                        $activeRelation = $activeBooking->familyMember ? $activeBooking->familyMember->relation : 'Self';
                        $actTests = is_array($activeBooking->test_details) ? $activeBooking->test_details : (json_decode($activeBooking->test_details, true) ?: []);
                        $steps = ['Booked', 'Sample Collection', 'Lab Processing', 'Report Ready'];
                    @endphp

                    <div class="bg-white rounded-2xl border-2 border-teal-500/40 shadow-sm overflow-hidden">
                        <!-- Card Header -->
                        <div class="bg-gradient-to-r from-teal-50/80 via-white to-teal-50/80 border-b border-teal-100 px-6 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div class="flex items-center gap-3 flex-wrap">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-teal-600 text-white font-mono font-bold text-xs shadow-xs">
                                    <i class="fas fa-barcode"></i>
                                    <span>#{{ $activeBooking->booking_reference }}</span>
                                </span>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl border text-xs font-black {{ $curInfo['badge'] }}">
                                    <i class="fas {{ $curInfo['icon'] }}"></i>
                                    <span>{{ $curInfo['label'] }}</span>
                                </span>
                                <span class="text-xs font-bold text-gray-700">
                                    For: <strong class="text-gray-900">{{ $activeFor }}</strong> ({{ $activeRelation }})
                                </span>
                            </div>

                            <div class="text-left sm:text-right">
                                <span class="inline-flex items-center gap-1 text-[11px] font-black text-teal-900 bg-teal-100/60 border border-teal-200 px-2.5 py-1 rounded-lg">
                                    <i class="far fa-clock text-teal-700"></i>
                                    <span>Slot: {{ $activeBooking->display_slot }}</span>
                                </span>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-6 space-y-6">
                            <!-- Stepper Pipeline -->
                            <div class="relative py-2">
                                <div class="absolute top-9 left-10 right-10 h-1 bg-gray-200 rounded-full z-0"></div>
                                @php
                                    $curStep = max(1, min(4, $curInfo['step']));
                                    $stepPct = ($curStep - 1) / 3 * 100;
                                @endphp
                                <div class="absolute top-9 left-10 h-1 bg-brand-primary rounded-full z-0 transition-all duration-500" style="width: {{ (int)$stepPct }}%;"></div>

                                <div class="flex justify-between relative z-10">
                                    @foreach($steps as $sIdx => $stepLabel)
                                        @php
                                            $sNum = $sIdx + 1;
                                            $done = $sNum < $curStep;
                                            $isCurrent = $sNum === $curStep;
                                        @endphp
                                        <div class="text-center w-24 sm:w-28">
                                            <div class="w-9 h-9 sm:w-10 sm:h-10 mx-auto rounded-full flex items-center justify-center font-bold text-xs mb-1.5 shadow-sm border-4 border-white transition-all
                                                {{ $done ? 'bg-brand-primary text-white' : ($isCurrent ? 'bg-amber-500 text-white ring-4 ring-amber-100 animate-pulse' : 'bg-gray-200 text-gray-400') }}">
                                                @if($done)
                                                    <i class="fas fa-check text-xs"></i>
                                                @elseif($isCurrent)
                                                    <i class="fas fa-spinner fa-spin text-xs"></i>
                                                @else
                                                    <span>{{ $sNum }}</span>
                                                @endif
                                            </div>
                                            <span class="text-[11px] font-black block leading-tight {{ $isCurrent ? 'text-brand-dark font-extrabold' : ($done ? 'text-teal-700' : 'text-gray-400') }}">
                                                {{ $stepLabel }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Assigned Phlebotomist Card -->
                            @if($activeBooking->agent)
                                <div class="p-4 rounded-xl bg-teal-50/70 border border-teal-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-11 h-11 rounded-xl bg-teal-600 text-white flex items-center justify-center font-bold text-base shadow-sm flex-shrink-0">
                                            <i class="fas fa-user-nurse"></i>
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="text-[10px] uppercase font-black tracking-wider text-teal-800">Assigned Phlebotomist</span>
                                                <span class="text-[10px] bg-teal-200 text-teal-900 font-bold px-2 py-0.2 rounded-full">{{ $activeBooking->sample_status ?: 'Assigned' }}</span>
                                            </div>
                                            <h4 class="font-black text-teal-950 text-sm">{{ $activeBooking->agent->name }}</h4>
                                            @if($activeBooking->agent->vehicle_number)
                                                <p class="text-[11px] text-teal-700 font-medium">Vehicle: {{ $activeBooking->agent->vehicle_number }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    @if($activeBooking->agent->phone)
                                        <a href="tel:{{ $activeBooking->agent->phone }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold transition shadow-sm w-fit">
                                            <i class="fas fa-phone-alt text-xs"></i>
                                            <span>Call: +91 {{ $activeBooking->agent->phone }}</span>
                                        </a>
                                    @endif
                                </div>
                            @endif

                            <!-- Tests & Actions Row -->
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-2 border-t border-gray-100">
                                <div>
                                    <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block mb-1">Diagnostic Tests:</span>
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach(array_slice($actTests, 0, 3) as $t)
                                            @php $tTitle = is_array($t) ? ($t['name'] ?? 'Diagnostic Test') : $t; @endphp
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-gray-50 border border-gray-200 text-xs font-semibold text-gray-700">
                                                <i class="fas fa-vial text-[10px] text-teal-600"></i>
                                                <span>{{ $tTitle }}</span>
                                            </span>
                                        @endforeach
                                        @if(count($actTests) > 3)
                                            <span class="inline-flex items-center px-2 py-1 rounded-lg bg-gray-100 text-[11px] font-bold text-gray-600">
                                                +{{ count($actTests) - 3 }} more
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex items-center gap-2">
                                    <a href="{{ route('patient.bookings') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-brand-dark hover:bg-teal-800 text-white font-extrabold text-xs rounded-xl shadow-xs transition">
                                        <span>Full Booking Details</span>
                                        <i class="fas fa-arrow-right text-[10px]"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- No Active Booking Card -->
                    <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-teal-50 border border-teal-200 text-teal-700 flex items-center justify-center text-xl flex-shrink-0">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div>
                                <h3 class="font-extrabold text-sm text-gray-900">No active test bookings in progress</h3>
                                <p class="text-xs text-gray-500 font-medium mt-0.5">Need a routine blood test or complete full body health checkup with home collection?</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <a href="/" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-brand-dark hover:bg-teal-800 text-white font-extrabold text-xs transition shadow-sm">
                                <i class="fas fa-flask"></i> Book Test Now
                            </a>
                            <a href="{{ route('patient.prescriptions') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 font-extrabold text-xs hover:bg-amber-100 transition">
                                <i class="fas fa-file-medical text-amber-600"></i> Upload Rx
                            </a>
                        </div>
                    </div>
                @endif

                <!-- Ready Reports Quick Download Widget -->
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 via-white to-gray-50 border-b border-gray-200 flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs">
                                <i class="fas fa-file-medical-alt"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-black text-brand-dark">Latest Certified Medical Reports</h3>
                                <p class="text-[11px] text-gray-500 font-medium">100% NABL Accredited & Digitally Signed PDF Reports</p>
                            </div>
                        </div>
                        <a href="{{ route('patient.reports') }}" class="text-xs font-black text-teal-700 hover:underline flex items-center gap-1">
                            <span>View All</span>
                            <i class="fas fa-chevron-right text-[9px]"></i>
                        </a>
                    </div>

                    @if($readyReports->isNotEmpty())
                        <div class="divide-y divide-gray-100">
                            @foreach($readyReports as $rep)
                                @php
                                    $repFor = $rep->familyMember ? $rep->familyMember->name : ($profile->name ?? 'Patient');
                                    $repRelation = $rep->familyMember ? $rep->familyMember->relation : 'Self';
                                    $repTests = is_array($rep->test_details) ? $rep->test_details : (json_decode($rep->test_details, true) ?: []);
                                    $repTitle = !empty($repTests) 
                                        ? (is_array($repTests[0]) ? ($repTests[0]['name'] ?? 'Diagnostic Test Report') : $repTests[0]) 
                                        : 'Diagnostic Health Report';
                                @endphp
                                <div class="p-4 sm:px-6 hover:bg-gray-50/70 transition flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                    <div class="flex items-start gap-3.5">
                                        <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center justify-center text-lg flex-shrink-0">
                                            <i class="far fa-file-pdf"></i>
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2 flex-wrap mb-0.5">
                                                <span class="text-xs font-bold text-gray-900 font-mono">#{{ $rep->booking_reference }}</span>
                                                <span class="inline-flex items-center gap-1 text-[10px] font-black px-2 py-0.2 rounded-full bg-emerald-100 text-emerald-800">
                                                    <i class="fas fa-check-circle"></i> READY
                                                </span>
                                            </div>
                                            <h4 class="text-xs font-black text-gray-800">{{ $repTitle }}</h4>
                                            <p class="text-[11px] text-gray-500 font-medium">
                                                For: <strong class="text-gray-700">{{ $repFor }}</strong> ({{ $repRelation }}) • 
                                                <span>{{ $rep->booking_date ? $rep->booking_date->format('d M Y') : $rep->created_at->format('d M Y') }}</span>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-2 self-start sm:self-auto flex-shrink-0">
                                        @if($rep->report_file_path)
                                            <a href="{{ asset('storage/' . $rep->report_file_path) }}" target="_blank" download class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-xs transition">
                                                <i class="fas fa-download text-[10px]"></i>
                                                <span>Download PDF</span>
                                            </a>
                                        @else
                                            <a href="{{ route('patient.reports') }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs rounded-xl transition">
                                                <i class="far fa-eye text-[10px]"></i>
                                                <span>View Report Status</span>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-8 text-center">
                            <div class="w-14 h-14 mx-auto rounded-2xl bg-teal-50 border border-teal-100 text-teal-600 flex items-center justify-center text-2xl mb-3">
                                <i class="fas fa-file-medical-alt"></i>
                            </div>
                            <h4 class="font-extrabold text-sm text-gray-800 mb-1">No Test Reports Ready Yet</h4>
                            <p class="text-xs text-gray-500 max-w-md mx-auto">
                                When our NABL certified pathologist validates your diagnostic samples, your digitally signed PDF reports will be available here for 1-click download.
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Recent Activity / Bookings Table -->
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 via-white to-gray-50 border-b border-gray-200 flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-black text-brand-dark">Recent Bookings & Tests</h3>
                            <p class="text-[11px] text-gray-500 font-medium">Quick history of your diagnostic orders</p>
                        </div>
                        <a href="{{ route('patient.bookings') }}" class="text-xs font-black text-teal-700 hover:underline flex items-center gap-1">
                            <span>View All Bookings</span>
                            <i class="fas fa-chevron-right text-[9px]"></i>
                        </a>
                    </div>

                    @if($recentBookings->isNotEmpty())
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs text-gray-600">
                                <thead class="bg-gray-50/75 text-[10px] font-black uppercase tracking-wider text-gray-400 border-b border-gray-100">
                                    <tr>
                                        <th class="py-3 px-6">Booking Ref</th>
                                        <th class="py-3 px-6">Patient</th>
                                        <th class="py-3 px-6">Date & Slot</th>
                                        <th class="py-3 px-6">Amount</th>
                                        <th class="py-3 px-6">Status</th>
                                        <th class="py-3 px-6 text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 font-medium">
                                    @foreach($recentBookings as $bk)
                                        @php
                                            $bFor = $bk->familyMember ? $bk->familyMember->name : ($profile->name ?? 'Self');
                                            $bRel = $bk->familyMember ? $bk->familyMember->relation : 'Self';
                                        @endphp
                                        <tr class="hover:bg-gray-50/50 transition">
                                            <td class="py-3.5 px-6 font-mono font-bold text-gray-900">
                                                #{{ $bk->booking_reference }}
                                            </td>
                                            <td class="py-3.5 px-6">
                                                <span class="font-bold text-gray-800 block">{{ $bFor }}</span>
                                                <span class="text-[10px] text-gray-400">{{ $bRel }}</span>
                                            </td>
                                            <td class="py-3.5 px-6">
                                                <span class="block text-gray-800 font-semibold">{{ $bk->booking_date ? $bk->booking_date->format('d M Y') : $bk->created_at->format('d M Y') }}</span>
                                                <span class="text-[10px] text-teal-700 font-bold">{{ $bk->display_slot }}</span>
                                            </td>
                                            <td class="py-3.5 px-6 font-black text-gray-900">
                                                ₹{{ number_format($bk->amount, 0) }}
                                            </td>
                                            <td class="py-3.5 px-6">
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-black
                                                    {{ in_array($bk->status, ['Report Ready', 'Completed']) ? 'bg-emerald-100 text-emerald-800' : (in_array($bk->status, ['Cancelled']) ? 'bg-rose-100 text-rose-800' : 'bg-teal-100 text-teal-800') }}">
                                                    {{ $bk->status ?: 'Booked' }}
                                                </span>
                                            </td>
                                            <td class="py-3.5 px-6 text-right">
                                                <a href="{{ route('patient.bookings') }}" class="inline-flex items-center gap-1 text-teal-600 hover:text-teal-800 font-bold hover:underline">
                                                    <span>View</span>
                                                    <i class="fas fa-chevron-right text-[9px]"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-6 text-center text-xs text-gray-400">
                            No booking records found.
                        </div>
                    @endif
                </div>

                <!-- Preventive Health Advice Banner -->
                <div class="rounded-2xl bg-gradient-to-r from-teal-900 via-teal-950 to-slate-950 p-5 text-white shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-amber-400 text-slate-950 flex items-center justify-center text-base font-black flex-shrink-0">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-black text-white">Preventive Diagnostic Tip: Fasting Requirements</h4>
                            <p class="text-[11px] text-teal-200/90 font-medium">For accurate Lipid Profiles and Fasting Blood Sugar, maintain 10-12 hours overnight fasting before morning collection.</p>
                        </div>
                    </div>
                    <a href="/faqs" class="px-4 py-2 rounded-xl bg-teal-800/90 hover:bg-teal-700 text-teal-100 text-xs font-extrabold transition shadow-xs flex-shrink-0 self-start sm:self-auto">
                        Collection FAQs &rarr;
                    </a>
                </div>

            </div>

            <!-- ========================================================= -->
            <!-- TAB 2: NOTIFICATIONS FEED                                 -->
            <!-- ========================================================= -->
            <div id="tabContent-notifications" class="hidden space-y-4">
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                    <!-- Tab Header -->
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 via-white to-gray-50 border-b border-gray-200 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-bell text-brand-primary"></i>
                            <h3 class="text-sm font-black text-brand-dark">Recent In-App Notifications</h3>
                            @if($unreadNotificationsCount > 0)
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-rose-500 text-white animate-pulse">
                                    {{ $unreadNotificationsCount }} New
                                </span>
                            @endif
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="button" onclick="markAllPatientNotifsRead()" class="text-xs font-bold text-teal-600 hover:underline">
                                Mark all as read
                            </button>
                            <span class="text-gray-300">•</span>
                            <a href="{{ route('patient.notifications') }}" class="text-xs font-bold text-teal-700 hover:underline">
                                Full History Center &rarr;
                            </a>
                        </div>
                    </div>

                    <!-- Notification List -->
                    @if($notifications->isNotEmpty())
                        <div class="divide-y divide-gray-100" id="dashNotifsList">
                            @foreach($notifications as $item)
                                @php
                                    $isUnread = !$item->isRead();
                                    $iconClass = $item->eventIcon($item->event);
                                    $badgeClass = $item->eventBadgeClass($item->event);
                                @endphp
                                <div class="p-4 sm:px-6 transition flex items-start justify-between gap-4 notif-row-{{ $item->id }} {{ $isUnread ? 'bg-teal-50/40' : 'hover:bg-gray-50/60' }}">
                                    <div class="flex items-start gap-3.5">
                                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-base flex-shrink-0 shadow-xs {{ $badgeClass }}">
                                            <i class="{{ $iconClass }}"></i>
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2 flex-wrap mb-0.5">
                                                <span class="text-xs font-black text-gray-900">{{ $item->subject ?: 'Notification' }}</span>
                                                <span class="text-[10px] font-extrabold uppercase tracking-wider px-2 py-0.2 rounded-full {{ $badgeClass }}">
                                                    {{ $item->eventLabel($item->event) }}
                                                </span>
                                                @if($isUnread)
                                                    <span class="inline-block w-2 h-2 rounded-full bg-teal-500 animate-ping"></span>
                                                @endif
                                            </div>
                                            <p class="text-xs text-gray-600 font-medium leading-relaxed">{{ $item->body }}</p>
                                            <div class="flex items-center gap-3 mt-1.5 text-[11px] text-gray-400 font-semibold">
                                                <span><i class="far fa-clock mr-1"></i> {{ $item->created_at ? $item->created_at->diffForHumans() : 'Recently' }}</span>
                                                @if($item->action_url)
                                                    <span>•</span>
                                                    <a href="{{ $item->action_url }}" onclick="markNotifReadInline({{ $item->id }})" class="text-teal-600 font-bold hover:underline flex items-center gap-1">
                                                        <span>View Details</span>
                                                        <i class="fas fa-arrow-right text-[9px]"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    @if($isUnread)
                                        <button type="button" onclick="markNotifReadInline({{ $item->id }})" class="text-[11px] font-bold text-teal-600 hover:text-teal-800 bg-white border border-teal-200 px-2.5 py-1 rounded-lg transition shadow-2xs flex-shrink-0" title="Mark as Read">
                                            <i class="fas fa-check text-[9px] mr-1"></i> Mark read
                                        </button>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-10 text-center">
                            <div class="w-14 h-14 mx-auto rounded-2xl bg-gray-50 border border-gray-100 text-gray-400 flex items-center justify-center text-2xl mb-3">
                                <i class="far fa-bell-slash"></i>
                            </div>
                            <h4 class="font-extrabold text-sm text-gray-800 mb-1">No Notifications Yet</h4>
                            <p class="text-xs text-gray-500 max-w-sm mx-auto">
                                You will receive real-time notifications when your booking is placed, your phlebotomist is on the way, and your test report is released.
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- ========================================================= -->
            <!-- TAB 3: PERSONAL & HEALTH DETAILS (FORM)                   -->
            <!-- ========================================================= -->
            <div id="tabContent-profile" class="hidden">
                <div id="profile-form" class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                    <!-- Card Header -->
                    <div class="px-6 py-5 bg-gradient-to-r from-gray-50 via-white to-gray-50 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div>
                            <h3 class="text-lg font-black text-brand-dark flex items-center gap-2">
                                <i class="far fa-id-card text-brand-secondary"></i>
                                <span>Edit Personal & Health Details</span>
                            </h3>
                            <p class="text-xs text-gray-500 font-medium mt-0.5">Please provide accurate information for age-specific normal reference ranges on your lab test reports.</p>
                        </div>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-extrabold bg-teal-50 text-brand-dark border border-teal-200 w-fit">
                            <span class="w-1.5 h-1.5 rounded-full bg-brand-primary animate-pulse"></span>
                            Active Profile
                        </span>
                    </div>

                    <!-- Form Content -->
                    <form action="{{ route('patient.profile.store') }}" method="POST" class="p-6 md:p-8 space-y-6">
                        @csrf

                        <!-- Full Name -->
                        <div>
                            <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">
                                Enter Full Name <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">
                                    <i class="far fa-user"></i>
                                </span>
                                <input 
                                    type="text" 
                                    name="name" 
                                    value="{{ old('name', $profile->name) }}" 
                                    placeholder="Enter Full Name" 
                                    class="w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-primary focus:border-brand-primary font-bold text-gray-800 text-sm outline-none transition placeholder-gray-300" 
                                    required
                                >
                            </div>
                        </div>

                        <!-- Gender Selection -->
                        <div>
                            <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">
                                Select Gender <span class="text-rose-500">*</span>
                            </label>
                            @php
                                $selectedGender = strtolower(old('gender', $profile->gender ?? ''));
                            @endphp
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                <!-- Female -->
                                <label class="cursor-pointer">
                                    <input type="radio" name="gender" value="Female" {{ $selectedGender === 'female' ? 'checked' : '' }} class="peer hidden">
                                    <div class="border-2 border-gray-200 bg-white rounded-xl py-3 px-4 text-center cursor-pointer font-bold text-gray-500 peer-checked:bg-brand-light/40 peer-checked:text-brand-dark peer-checked:border-brand-dark transition flex items-center justify-center gap-2 hover:border-gray-300 shadow-sm">
                                        <i class="fas fa-female text-lg text-pink-500"></i>
                                        <span>Female</span>
                                    </div>
                                </label>

                                <!-- Male -->
                                <label class="cursor-pointer">
                                    <input type="radio" name="gender" value="Male" {{ $selectedGender === 'male' ? 'checked' : '' }} class="peer hidden">
                                    <div class="border-2 border-gray-200 bg-white rounded-xl py-3 px-4 text-center cursor-pointer font-bold text-gray-500 peer-checked:bg-brand-light/40 peer-checked:text-brand-dark peer-checked:border-brand-dark transition flex items-center justify-center gap-2 hover:border-gray-300 shadow-sm">
                                        <i class="fas fa-male text-lg text-blue-500"></i>
                                        <span>Male</span>
                                    </div>
                                </label>

                                <!-- Other -->
                                <label class="cursor-pointer col-span-2 sm:col-span-1">
                                    <input type="radio" name="gender" value="Other" {{ $selectedGender === 'other' ? 'checked' : '' }} class="peer hidden">
                                    <div class="border-2 border-gray-200 bg-white rounded-xl py-3 px-4 text-center cursor-pointer font-bold text-gray-500 peer-checked:bg-brand-light/40 peer-checked:text-brand-dark peer-checked:border-brand-dark transition flex items-center justify-center gap-2 hover:border-gray-300 shadow-sm">
                                        <i class="fas fa-user-circle text-lg text-teal-600"></i>
                                        <span>Other</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Age & Date of Birth -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">
                                    Enter Age
                                </label>
                                <div class="relative">
                                    <input 
                                        type="number" 
                                        id="profile_age" 
                                        name="age" 
                                        value="{{ old('age', $profile->age !== '-' ? $profile->age : '') }}" 
                                        min="1" 
                                        max="120" 
                                        placeholder="Enter Age (e.g. 28)" 
                                        class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-primary focus:border-brand-primary font-bold text-gray-800 text-sm outline-none transition placeholder-gray-300"
                                    >
                                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-bold text-gray-400">Years</span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">
                                    Date Of Birth
                                </label>
                                <input 
                                    type="date" 
                                    id="profile_dob" 
                                    name="dob" 
                                    value="{{ old('dob', $profile->dob ? \Carbon\Carbon::parse($profile->dob)->format('Y-m-d') : '') }}" 
                                    class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-primary focus:border-brand-primary font-bold text-gray-800 text-sm outline-none transition text-gray-700"
                                >
                            </div>
                        </div>

                        <!-- Relation Selector -->
                        <div>
                            <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">
                                Select Relation
                            </label>
                            @php
                                $currentRelation = strtolower(old('relation', $profile->relation ?: 'self'));
                                $relations = [
                                    'self' => 'Self',
                                    'spouse' => 'Spouse',
                                    'mother' => 'Mother',
                                    'father' => 'Father',
                                    'daughter' => 'Daughter',
                                    'son' => 'Son',
                                    'other' => 'Other',
                                ];
                            @endphp
                            <div class="flex flex-wrap gap-2.5">
                                @foreach($relations as $relKey => $relLabel)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="relation" value="{{ $relKey }}" {{ $currentRelation === $relKey ? 'checked' : '' }} class="peer hidden">
                                        <div class="border border-gray-200 bg-gray-50 rounded-full px-5 py-2.5 cursor-pointer font-bold text-xs text-gray-500 peer-checked:bg-brand-dark peer-checked:text-white peer-checked:border-brand-dark transition shadow-sm hover:border-gray-300 hover:bg-gray-100">
                                            {{ $relLabel }}
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Contact Details Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                            <!-- Primary Mobile (Locked & Verified) -->
                            <div>
                                <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">
                                    Mobile Number (Primary)
                                </label>
                                <div class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 flex items-center justify-between">
                                    <div>
                                        <span class="block text-xs font-bold text-gray-400 mb-0.5">Verified Primary Number</span>
                                        <span class="font-black text-gray-800 text-base tracking-wide">+91 {{ $profile->mobile }}</span>
                                    </div>
                                    <span class="inline-flex items-center gap-1 bg-emerald-100 text-emerald-700 text-[11px] font-black px-2.5 py-1 rounded-full">
                                        <i class="fas fa-check-circle text-xs"></i> Verified
                                    </span>
                                </div>
                                <input type="hidden" name="mobile" value="{{ $profile->mobile }}">
                            </div>

                            <!-- Alternate Mobile -->
                            <div>
                                <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">
                                    Alternate Number (Optional)
                                </label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-bold text-sm border-r pr-3 border-gray-200 flex items-center gap-1">
                                        <span>+91</span>
                                        <i class="fas fa-caret-down text-gray-400 text-xs"></i>
                                    </span>
                                    <input 
                                        type="tel" 
                                        name="alt_mobile" 
                                        value="{{ old('alt_mobile', $profile->alt_mobile) }}" 
                                        maxlength="10" 
                                        placeholder="Enter Alternate Number" 
                                        class="w-full pl-24 pr-4 py-3.5 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-primary focus:border-brand-primary font-bold text-gray-800 text-sm outline-none transition placeholder-gray-300"
                                    >
                                </div>
                            </div>
                        </div>

                        <!-- Email Address -->
                        <div>
                            <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">
                                Email Address (For Reports & Invoices) <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">
                                    <i class="far fa-envelope"></i>
                                </span>
                                <input 
                                    type="email" 
                                    name="email" 
                                    value="{{ old('email', $profile->email !== '-' ? $profile->email : '') }}" 
                                    placeholder="Enter Email Address (e.g. user@example.com)" 
                                    class="w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-primary focus:border-brand-primary font-bold text-gray-800 text-sm outline-none transition placeholder-gray-300" 
                                    required
                                >
                            </div>
                            <p class="text-[11px] text-gray-400 font-medium mt-1">Your digitally signed laboratory test reports and billing receipts will be sent to this email.</p>
                        </div>

                        <!-- Actions -->
                        <div class="flex flex-col-reverse sm:flex-row items-center gap-3 pt-6 border-t border-gray-100">
                            <button type="button" onclick="switchDashboardTab('overview')" class="w-full sm:w-1/3 text-center border-2 border-gray-200 hover:border-gray-300 text-gray-600 font-extrabold py-3.5 rounded-xl hover:bg-gray-50 transition text-sm">
                                Return to Overview
                            </button>
                            <button type="submit" class="w-full sm:w-2/3 bg-brand-dark hover:bg-opacity-95 text-white font-extrabold py-3.5 rounded-xl shadow-md hover:shadow-lg transition flex items-center justify-center gap-2 text-sm">
                                <i class="fas fa-save"></i> Save Profile Details
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // Tab switching system
    function switchDashboardTab(tabName) {
        const tabs = ['overview', 'notifications', 'profile'];
        tabs.forEach(t => {
            const btn = document.getElementById('tabBtn-' + t);
            const content = document.getElementById('tabContent-' + t);
            if (!btn || !content) return;

            if (t === tabName) {
                btn.className = 'tab-btn flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-xs font-black transition-all bg-brand-dark text-white shadow-xs';
                content.classList.remove('hidden');
            } else {
                btn.className = 'tab-btn flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-xs font-black transition-all text-gray-600 hover:text-brand-dark hover:bg-gray-50';
                content.classList.add('hidden');
            }
        });
    }

    // Mark single notification read inline
    function markNotifReadInline(notifId) {
        fetch('/patient/notifications/mark-read/' + notifId, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                const row = document.querySelector('.notif-row-' + notifId);
                if (row) {
                    row.classList.remove('bg-teal-50/40');
                    row.classList.add('hover:bg-gray-50/60');
                    const markBtn = row.querySelector('button');
                    if (markBtn) markBtn.remove();
                    const pingDot = row.querySelector('.animate-ping');
                    if (pingDot) pingDot.remove();
                }
                // Also trigger header refresh if available
                if (typeof fetchPatientNotifications === 'function') {
                    fetchPatientNotifications();
                }
            }
        })
        .catch(err => console.error('Mark read error:', err));
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Auto Age calculation from DOB
        const dobInput = document.getElementById('profile_dob');
        const ageInput = document.getElementById('profile_age');

        if (dobInput && ageInput) {
            dobInput.addEventListener('change', function() {
                if (this.value) {
                    const dob = new Date(this.value);
                    const today = new Date();
                    let age = today.getFullYear() - dob.getFullYear();
                    const monthDiff = today.getMonth() - dob.getMonth();
                    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                        age--;
                    }
                    if (age >= 0 && age <= 120) {
                        ageInput.value = age;
                    }
                }
            });
        }

        // Check URL hash on page load
        const hash = window.location.hash;
        if (hash === '#profile-form' || hash === '#profile') {
            switchDashboardTab('profile');
        } else if (hash === '#notifications') {
            switchDashboardTab('notifications');
        } else {
            switchDashboardTab('overview');
        }
    });
</script>
@endsection
