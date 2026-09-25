@php
    $testDetails = is_array($booking->test_details) ? $booking->test_details : json_decode($booking->test_details, true);
    
    // Status Badge Mapping
    $statusMap = [
        'Booked'                      => ['label' => 'Booked',           'badge' => 'bg-indigo-50 text-indigo-700 border-indigo-200',   'icon' => 'fa-calendar-check'],
        'Pending'                     => ['label' => 'Pending',          'badge' => 'bg-amber-50 text-amber-700 border-amber-200',     'icon' => 'fa-clock'],
        'Confirmed'                   => ['label' => 'Confirmed',        'badge' => 'bg-blue-50 text-blue-700 border-blue-200',       'icon' => 'fa-check'],
        'Assigned'                    => ['label' => 'Agent Assigned',   'badge' => 'bg-teal-50 text-teal-700 border-teal-200',       'icon' => 'fa-motorcycle'],
        'Sample Collection Scheduled' => ['label' => 'Scheduled',        'badge' => 'bg-teal-50 text-teal-700 border-teal-200',       'icon' => 'fa-calendar-alt'],
        'Out for Collection'          => ['label' => 'Agent On The Way', 'badge' => 'bg-amber-50 text-amber-700 border-amber-200',    'icon' => 'fa-biking'],
        'Sample Collected'            => ['label' => 'Sample Collected', 'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'icon' => 'fa-vial'],
        'In Process'                  => ['label' => 'Processing',       'badge' => 'bg-yellow-50 text-yellow-700 border-yellow-200',   'icon' => 'fa-microscope'],
        'Processing'                  => ['label' => 'Processing',       'badge' => 'bg-yellow-50 text-yellow-700 border-yellow-200',   'icon' => 'fa-microscope'],
        'Report Ready'                => ['label' => 'Report Ready',     'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'icon' => 'fa-file-medical-alt'],
        'Completed'                   => ['label' => 'Completed',        'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'icon' => 'fa-check-double'],
        'Cancelled'                   => ['label' => 'Cancelled',        'badge' => 'bg-rose-50 text-rose-700 border-rose-200',       'icon' => 'fa-times-circle'],
    ];

    $currentStatus = $statusMap[$booking->status] ?? [
        'label' => $booking->status ?: 'Booked',
        'badge' => 'bg-gray-50 text-gray-700 border-gray-200',
        'icon'  => 'fa-info-circle'
    ];
@endphp

<div class="bg-white border border-gray-200 hover:border-teal-300 rounded-2xl p-5 md:p-6 shadow-sm hover:shadow-md transition duration-200 space-y-4">
    <!-- Top Header Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-gray-100">
        <div class="flex items-center gap-3 flex-wrap">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-gray-100 text-gray-800 font-mono font-bold text-xs">
                <i class="fas fa-barcode text-gray-400"></i>
                <span>#{{ $booking->booking_reference }}</span>
            </span>

            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl border text-xs font-black {{ $currentStatus['badge'] }}">
                <i class="fas {{ $currentStatus['icon'] }}"></i>
                <span>{{ $currentStatus['label'] }}</span>
            </span>

            <span class="text-xs font-bold text-gray-500 flex items-center gap-1">
                <i class="far fa-user text-gray-400"></i>
                <span>For: <strong class="text-gray-800">{{ $memberName }}</strong></span>
            </span>
        </div>

        <div class="text-xs text-gray-500 font-semibold flex items-center gap-2 flex-wrap">
            <span class="flex items-center gap-1"><i class="far fa-calendar text-teal-600"></i> {{ $booking->booking_date ? $booking->booking_date->format('d M Y') : $booking->created_at->format('d M Y') }}</span>
            <span class="inline-flex items-center gap-1 text-[11px] font-black text-amber-900 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded-md shadow-2xs">
                <i class="far fa-clock text-[10px] text-amber-700"></i>
                <span>{{ $booking->display_slot }}</span>
            </span>
        </div>
    </div>

    <!-- Tests Breakdown & Total Price Row -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <div class="space-y-2 flex-1">
            <span class="text-[11px] font-extrabold uppercase tracking-wider text-gray-400">Booked Diagnostic Tests & Packages</span>
            
            @if(!empty($testDetails) && is_array($testDetails))
                <div class="space-y-1.5">
                    @foreach($testDetails as $test)
                        <div class="flex items-center justify-between gap-3 bg-gray-50/80 rounded-xl px-3.5 py-2 border border-gray-100">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <div class="w-7 h-7 rounded-lg bg-teal-100/60 text-brand-dark flex items-center justify-center text-xs flex-shrink-0">
                                    <i class="fas fa-flask"></i>
                                </div>
                                <span class="font-extrabold text-xs text-gray-900 truncate">{{ $test['name'] ?? 'Diagnostic Test' }}</span>
                                @if(isset($test['type']))
                                    <span class="text-[10px] px-2 py-0.5 rounded-full font-bold {{ $test['type'] === 'package' ? 'bg-amber-100 text-amber-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ ucfirst($test['type']) }}
                                    </span>
                                @endif
                            </div>
                            <span class="font-black text-xs text-brand-dark flex-shrink-0">
                                ₹{{ number_format($test['price'] ?? ($test['selling_price'] ?? 0), 0) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-xs font-bold text-gray-700">General Diagnostic Health Checkup</p>
            @endif
        </div>

        <!-- Price & Payment Summary Card -->
        <div class="lg:text-right lg:border-l lg:border-gray-100 lg:pl-6 flex-shrink-0">
            <span class="text-[11px] font-extrabold uppercase tracking-wider text-gray-400 block">Total Amount</span>
            <span class="text-2xl font-black text-brand-dark block mt-0.5">₹{{ number_format($booking->amount, 0) }}</span>
            <div class="mt-1 flex items-center lg:justify-end gap-1.5 flex-wrap">
                <span class="inline-flex items-center gap-1 text-[11px] font-extrabold px-2.5 py-0.5 rounded-full {{ $booking->payment_status === 'Paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                    <i class="fas {{ $booking->payment_status === 'Paid' ? 'fa-check-circle text-emerald-600' : 'fa-hourglass-half text-amber-600' }} text-[10px]"></i>
                    <span>{{ $booking->payment_status === 'Paid' ? 'Paid Online' : ($booking->payment_method === 'Cash' ? 'Pay on Collection' : 'Payment Pending') }}</span>
                </span>
                @if($booking->razorpay_payment_id)
                    <span class="font-mono text-[10px] text-gray-400 block">ID: {{ $booking->razorpay_payment_id }}</span>
                @endif
            </div>

            @if($booking->payment_status !== 'Paid' && $booking->status !== 'Cancelled')
                <button type="button" onclick="retryBookingPayment({{ $booking->id }}, {{ $booking->amount }}, '{{ $booking->booking_reference }}', this)" class="mt-2 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs transition shadow-xs cursor-pointer">
                    <i class="fas fa-credit-card text-[10px]"></i>
                    <span>Pay Online Now</span>
                </button>
            @endif

            <span class="text-[11px] text-gray-400 font-semibold block mt-1">
                <i class="fas fa-map-pin text-[10px] mr-1"></i> {{ $booking->collection_type ?: 'Home Collection' }}
            </span>
        </div>
    </div>

    <!-- Phlebotomist / Agent Details (if assigned) -->
    @if($booking->agent)
        <div class="p-3.5 rounded-xl bg-teal-50/60 border border-teal-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-teal-600 text-white flex items-center justify-center font-bold text-xs shadow-sm">
                    <i class="fas fa-motorcycle"></i>
                </div>
                <div>
                    <div class="flex items-center gap-1.5">
                        <span class="text-[10px] uppercase font-black tracking-wider text-teal-800">Assigned Phlebotomist</span>
                        <span class="text-[10px] bg-teal-200 text-teal-900 font-bold px-1.5 py-0.2 rounded-full">{{ $booking->sample_status ?: 'Assigned' }}</span>
                    </div>
                    <h4 class="font-extrabold text-teal-950 text-xs">{{ $booking->agent->name }}</h4>
                </div>
            </div>

            @if($booking->agent->phone)
                <a href="tel:{{ $booking->agent->phone }}" class="inline-flex items-center justify-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold transition shadow-sm w-fit">
                    <i class="fas fa-phone-alt text-[10px]"></i>
                    <span>Call Technician</span>
                </a>
            @endif
        </div>
    @endif

    <!-- Bottom Actions: Download Report & Track Booking -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-3 border-t border-gray-100">
        <div class="flex items-center gap-2">
            @if($booking->report_file_path)
                <a 
                    href="{{ asset('storage/' . $booking->report_file_path) }}" 
                    target="_blank" 
                    download 
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-extrabold shadow-sm transition"
                >
                    <i class="fas fa-file-pdf"></i>
                    <span>Download PDF Report</span>
                </a>
            @else
                <span class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-400 bg-gray-50 border border-gray-200 px-3 py-1.5 rounded-xl">
                    <i class="fas fa-clock text-amber-500"></i>
                    <span>Report under analysis at certified lab</span>
                </span>
            @endif
        </div>

        <div class="flex items-center gap-3">
            @php
                $canModify = !in_array($booking->status, ['Sample Collected', 'In Process', 'Processing', 'Report Ready', 'Completed', 'Cancelled']) && $booking->sample_status !== 'Sample Collected';
            @endphp
            @if($canModify)
                <button type="button" onclick="openModifyBookingModal({{ $booking->id }})" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-teal-50 hover:bg-teal-100 text-teal-800 border border-teal-200 text-xs font-black transition shadow-2xs hover:shadow-xs cursor-pointer">
                    <i class="fas fa-edit text-[11px] text-teal-700"></i>
                    <span>Modify</span>
                </button>
            @endif
            <a 
                href="{{ route('patient.bookings') }}" 
                class="inline-flex items-center justify-center gap-1.5 text-xs font-extrabold text-brand-dark hover:text-brand-secondary transition"
            >
                <span>View Full Timeline & Tracking</span>
                <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
        </div>
    </div>
</div>
