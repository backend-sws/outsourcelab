@extends('frontend.layouts.app')

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
                        <i class="far fa-file-alt text-brand-primary"></i>
                        <span>Medical Test Reports</span>
                    </h2>
                    <p class="text-xs text-gray-500 font-medium mt-1">100% Verified & Digitally Signed Diagnostic Reports. Download or view anytime.</p>
                </div>
                <div class="flex items-center gap-2 flex-wrap">
                    <a href="{{ route('patient.bookings') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-white border border-gray-200 text-gray-700 hover:text-brand-dark hover:border-teal-300 font-extrabold text-xs transition shadow-2xs">
                        <i class="far fa-calendar-check text-brand-primary"></i>
                        <span>Track Bookings</span>
                    </a>
                    <a href="/" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-brand-dark hover:bg-teal-800 text-white font-extrabold text-xs transition shadow-sm">
                        <i class="fas fa-plus"></i>
                        <span>Book New Test</span>
                    </a>
                </div>
            </div>

            @php
                $reportsCount = $reportBookings->count();
            @endphp

            <!-- Reports Highlights Row -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 md:gap-4">
                <div class="bg-white rounded-2xl border border-gray-200 p-4 shadow-sm flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center justify-center font-bold text-base flex-shrink-0">
                        <i class="fas fa-file-medical"></i>
                    </div>
                    <div>
                        <span class="text-[11px] font-extrabold text-gray-400 uppercase tracking-wider block">Available Reports</span>
                        <span class="text-xl font-black text-brand-dark">{{ $reportsCount }}</span>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-200 p-4 shadow-sm flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-teal-50 border border-teal-200 text-teal-800 flex items-center justify-center font-bold text-base flex-shrink-0">
                        <i class="fas fa-award"></i>
                    </div>
                    <div>
                        <span class="text-[11px] font-extrabold text-gray-400 uppercase tracking-wider block">Lab Accreditation</span>
                        <span class="text-sm font-black text-teal-900">100% Lab Verified</span>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-200 p-4 shadow-sm flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 border border-amber-200 text-amber-700 flex items-center justify-center font-bold text-base flex-shrink-0">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <div>
                        <span class="text-[11px] font-extrabold text-gray-400 uppercase tracking-wider block">Turnaround Time</span>
                        <span class="text-sm font-black text-amber-900">Within 6–12 Hours</span>
                    </div>
                </div>
            </div>

            <!-- Lab Quality Assurance Strip -->
            <div class="rounded-2xl bg-gradient-to-r from-teal-900 via-teal-950 to-slate-950 p-4 text-white shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-amber-400 text-slate-950 flex items-center justify-center text-sm font-black flex-shrink-0">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-black text-white">ISO 15189 Standard Diagnostic Quality</h4>
                        <p class="text-[11px] text-teal-200/90 font-medium">All reports are certified by MD Pathologists and securely preserved with lifetime digital access.</p>
                    </div>
                </div>
                <span class="inline-flex items-center gap-1 text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-full bg-teal-800/80 text-teal-200 border border-teal-700 self-start sm:self-auto flex-shrink-0">
                    <i class="fas fa-check-circle text-amber-400"></i> Certified Lab
                </span>
            </div>

            @if($reportBookings->isEmpty())
                <!-- High-Trust Empty State -->
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8 md:p-12 text-center">
                    <div class="w-20 h-20 mx-auto bg-gradient-to-tr from-teal-50 to-emerald-100 rounded-3xl flex items-center justify-center mb-5 border border-teal-200 shadow-inner">
                        <i class="fas fa-file-medical-alt text-3xl text-brand-primary"></i>
                    </div>
                    <h3 class="font-black text-gray-900 text-xl mb-2">No Test Reports Available Yet</h3>
                    <p class="text-gray-500 font-medium text-xs md:text-sm max-w-lg mx-auto mb-8">
                        Your diagnostic test reports will appear here automatically as soon as your samples are collected, analyzed at our certified lab, and certified by our Senior Pathologist.
                    </p>

                    <!-- Workflow Informational Steps -->
                    <div class="bg-gray-50/80 rounded-2xl border border-gray-200 p-5 max-w-2xl mx-auto mb-8 text-left">
                        <span class="text-[10px] font-black uppercase tracking-wider text-gray-400 block mb-3">HOW YOU RECEIVE YOUR REPORTS:</span>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="flex items-start gap-2.5">
                                <span class="w-6 h-6 rounded-full bg-teal-100 text-teal-800 flex items-center justify-center text-xs font-black flex-shrink-0">1</span>
                                <div>
                                    <h5 class="text-xs font-extrabold text-gray-900">Sample Collection</h5>
                                    <p class="text-[11px] text-gray-500 font-medium mt-0.5">Barcoded vacutainers with strict temperature control.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <span class="w-6 h-6 rounded-full bg-teal-100 text-teal-800 flex items-center justify-center text-xs font-black flex-shrink-0">2</span>
                                <div>
                                    <h5 class="text-xs font-extrabold text-gray-900">Lab Analysis</h5>
                                    <p class="text-[11px] text-gray-500 font-medium mt-0.5">Automated testing & review by MD Pathologist.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center text-xs font-black flex-shrink-0">3</span>
                                <div>
                                    <h5 class="text-xs font-extrabold text-gray-900">Digital PDF Report</h5>
                                    <p class="text-[11px] text-gray-500 font-medium mt-0.5">Instant SMS/WhatsApp alert + Download PDF here.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CTAs -->
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                        <a href="/" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-brand-dark hover:bg-teal-800 text-white font-extrabold px-6 py-3 rounded-xl transition shadow-sm text-xs">
                            <i class="fas fa-flask"></i>
                            <span>Book Health Checkup</span>
                        </a>
                        <a href="{{ route('patient.bookings') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-white border border-gray-200 hover:border-teal-300 text-gray-800 font-extrabold px-6 py-3 rounded-xl transition shadow-2xs text-xs">
                            <i class="far fa-calendar-check text-brand-primary"></i>
                            <span>Track Active Bookings</span>
                        </a>
                        <a href="{{ route('patient.prescriptions') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-amber-50 hover:bg-amber-100 text-amber-900 border border-amber-200 font-extrabold px-6 py-3 rounded-xl transition text-xs">
                            <i class="fas fa-file-medical text-amber-600"></i>
                            <span>Upload Prescription</span>
                        </a>
                    </div>
                </div>
            @else
                <!-- Reports List Container -->
                <div class="space-y-4">
                    @foreach($reportBookings as $booking)
                        @php
                            $forName = $booking->familyMember ? $booking->familyMember->name : ($profile->name ?? 'Patient (Self)');
                            $relation = $booking->familyMember ? $booking->familyMember->relation : 'Self';
                            $testDetails = is_array($booking->test_details) ? $booking->test_details : (json_decode($booking->test_details, true) ?: []);
                            $mainTitle = !empty($testDetails) 
                                ? (is_array($testDetails[0]) ? ($testDetails[0]['name'] ?? 'Diagnostic Test Report') : $testDetails[0]) 
                                : 'Diagnostic Health Report';
                        @endphp

                        <div class="bg-white rounded-2xl border border-gray-200 hover:border-teal-300 shadow-sm transition overflow-hidden">
                            <div class="p-5 md:p-6">
                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-gray-100">
                                    <div class="flex items-start gap-3.5">
                                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center justify-center text-xl flex-shrink-0 shadow-2xs">
                                            <i class="fas fa-file-medical-alt"></i>
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2 flex-wrap mb-1">
                                                <span class="inline-flex items-center gap-1 text-[10px] font-black uppercase tracking-wider px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                    <i class="fas fa-check-circle"></i> REPORT READY
                                                </span>
                                                <span class="text-xs font-mono font-bold text-gray-500 bg-gray-100 px-2 py-0.5 rounded-md">
                                                    #{{ $booking->booking_reference }}
                                                </span>
                                            </div>
                                            <h3 class="text-base font-extrabold text-gray-900">{{ $mainTitle }}</h3>
                                            <p class="text-xs text-gray-500 font-semibold mt-0.5 flex items-center gap-2 flex-wrap">
                                                <span>For: <strong class="text-gray-800">{{ $forName }}</strong> ({{ $relation }})</span>
                                                <span>•</span>
                                                <span><i class="far fa-calendar-alt text-teal-600 mr-1"></i> Sample: {{ $booking->booking_date ? $booking->booking_date->format('d M Y') : $booking->created_at->format('d M Y') }}</span>
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Verified Badge -->
                                    <div class="flex flex-col items-start md:items-end">
                                        <span class="inline-flex items-center gap-1.5 text-xs font-extrabold text-emerald-800 bg-emerald-50 border border-emerald-200 px-3 py-1 rounded-xl">
                                            <i class="fas fa-signature text-emerald-600"></i>
                                            <span>MD Pathologist Certified</span>
                                        </span>
                                        <span class="text-[11px] text-gray-400 font-semibold mt-1">100% Diagnostic Quality Assurance</span>
                                    </div>
                                </div>

                                <!-- Tests Included in Report -->
                                @if(count($testDetails) > 1)
                                    <div class="py-3">
                                        <span class="text-[11px] font-extrabold uppercase tracking-wider text-gray-400 block mb-1.5">Parameters & Tests Covered:</span>
                                        <div class="flex flex-wrap gap-1.5">
                                            @foreach($testDetails as $t)
                                                @php $itemTitle = is_array($t) ? ($t['name'] ?? 'Test') : $t; @endphp
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-gray-50 border border-gray-200 text-xs font-semibold text-gray-700">
                                                    <i class="fas fa-vial text-[10px] text-teal-600"></i>
                                                    <span>{{ $itemTitle }}</span>
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- Actions Row -->
                                <div class="pt-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        @if($booking->report_file_path)
                                            <a href="{{ asset('storage/' . $booking->report_file_path) }}" target="_blank" download class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-sm transition">
                                                <i class="fas fa-file-pdf"></i>
                                                <span>Download PDF Report</span>
                                            </a>
                                            <a href="{{ asset('storage/' . $booking->report_file_path) }}" target="_blank" class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-white border border-gray-200 hover:border-teal-300 text-gray-700 hover:text-brand-dark font-extrabold text-xs rounded-xl transition shadow-2xs">
                                                <i class="far fa-eye"></i>
                                                <span>View Online</span>
                                            </a>
                                        @else
                                            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs font-bold">
                                                <i class="fas fa-spinner fa-spin text-amber-600"></i>
                                                <span>Digital report undergoing final verification</span>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('patient.bookings') }}" class="text-xs font-bold text-teal-700 hover:text-brand-dark transition flex items-center gap-1">
                                            <span>View Booking Details</span>
                                            <i class="fas fa-arrow-right text-[10px]"></i>
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
@endsection
