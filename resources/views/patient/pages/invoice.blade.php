@extends('frontend.layouts.app')

@section('title', 'Tax Invoice #' . $booking->booking_reference . ' - Av Wellcare Diagnostics')

@section('content')
<style>
    @media print {
        header, footer, nav, .site-header, .site-footer, .no-print, #headerCityDropdownContainer, .coupon-marquee-wrapper {
            display: none !important;
        }
        body {
            background: #ffffff !important;
            color: #0f172a !important;
            padding: 0 !important;
            margin: 0 !important;
            font-size: 11pt !important;
        }
        .invoice-card {
            border: none !important;
            box-shadow: none !important;
            max-width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        .print-break-inside-avoid {
            break-inside: avoid;
        }
    }
</style>

<div class="container mx-auto px-3 sm:px-4 py-6 sm:py-10 max-w-4xl">
    <!-- Action Bar (Hidden in Print) -->
    <div class="flex items-center justify-between gap-3 mb-6 no-print">
        <a href="{{ route('patient.bookings') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-slate-700 hover:text-teal-800 font-bold text-xs transition shadow-2xs hover:shadow-xs">
            <i class="fas fa-arrow-left"></i>
            <span>Back to My Bookings</span>
        </a>
        <div class="flex items-center gap-2">
            @if($booking->report_file_path)
                <a href="{{ route('patient.bookings.download_report', $booking->id) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs transition shadow-sm">
                    <i class="fas fa-file-pdf"></i>
                    <span>Download Lab Report</span>
                </a>
            @endif
            <button type="button" onclick="window.print()" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-teal-800 hover:bg-teal-900 text-white font-black text-xs transition shadow-sm active:scale-95 cursor-pointer">
                <i class="fas fa-print"></i>
                <span>Print / Save as PDF</span>
            </button>
        </div>
    </div>

    <!-- Official Printable Diagnostic Tax Invoice -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden invoice-card">
        <!-- Top Lab Letterhead Banner -->
        <div class="bg-gradient-to-r from-teal-950 via-teal-900 to-slate-900 text-white p-6 sm:p-8">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                <div class="flex items-start sm:items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-400 text-slate-950 flex items-center justify-center font-black text-xl shadow-md flex-shrink-0">
                        <i class="fas fa-microscope"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <h1 class="text-xl sm:text-2xl font-black tracking-tight text-white">Av Wellcare Diagnostics</h1>
                            <span class="px-2 py-0.5 rounded-md bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 text-[10px] font-black uppercase tracking-wider">
                                NABL & ICMR Approved
                            </span>
                        </div>
                        <p class="text-xs text-teal-200/90 font-medium mt-0.5">High-Precision Pathology, Preventive Health & Molecular Diagnostic Center</p>
                        <p class="text-[11px] text-teal-300/80 font-normal mt-0.5">
                            Helpline: {{ \App\Models\Setting::get('helpline_primary', '898 898 8787') }} • Email: support@avwellcarediagnostics.com
                        </p>
                    </div>
                </div>

                <div class="sm:text-right flex-shrink-0 border-t sm:border-t-0 pt-4 sm:pt-0 border-white/10">
                    <span class="inline-block px-3 py-1 rounded-full text-[11px] font-black uppercase tracking-wider bg-white/10 text-teal-100 border border-white/20 mb-1.5">
                        TAX INVOICE & BILL OF SUPPLY
                    </span>
                    <p class="text-sm font-mono font-black text-amber-300">#{{ $booking->booking_reference }}</p>
                    <p class="text-[11px] text-slate-300 mt-0.5 font-medium">
                        {{ $booking->booking_date ? $booking->booking_date->format('d M Y, h:i A') : $booking->created_at->format('d M Y, h:i A') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="p-6 sm:p-8 space-y-6">
            <!-- Patient, Beneficiary & Service Details -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pb-6 border-b border-slate-200/80">
                <!-- Primary Patient Info -->
                <div>
                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-wider mb-2">Billed To (Account Owner)</h4>
                    <p class="text-sm font-black text-slate-900">{{ $booking->patient->name ?? 'Patient' }}</p>
                    <p class="text-xs text-slate-600 mt-0.5">
                        <i class="fas fa-phone-alt text-teal-700 text-[10px] mr-1"></i> {{ $booking->patient->mobile ?? 'N/A' }}
                    </p>
                    @if($booking->patient && $booking->patient->email)
                        <p class="text-xs text-slate-600 mt-0.5 truncate">
                            <i class="fas fa-envelope text-teal-700 text-[10px] mr-1"></i> {{ $booking->patient->email }}
                        </p>
                    @endif
                </div>

                <!-- Patient / Beneficiary -->
                <div>
                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-wider mb-2">Sample Collection Beneficiary</h4>
                    <p class="text-sm font-black text-slate-900">{{ $booking->beneficiary_name }}</p>
                    <p class="text-xs text-slate-600 mt-0.5">
                        <span class="font-bold text-slate-700">Relation:</span> {{ $booking->beneficiary_relation }}
                        @if($booking->beneficiary_age) • <span class="font-bold text-slate-700">Age:</span> {{ $booking->beneficiary_age }} Yrs @endif
                        @if($booking->beneficiary_gender) • <span class="font-bold text-slate-700">Gender:</span> {{ $booking->beneficiary_gender }} @endif
                    </p>
                    <p class="text-xs text-teal-800 font-bold mt-1">
                        <i class="fas fa-calendar-check text-[10px] mr-1"></i> Slot: {{ $booking->display_slot }}
                    </p>
                </div>

                <!-- Collection Address & Phlebotomist -->
                <div>
                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-wider mb-2">Collection Location & Staff</h4>
                    @if($booking->collection_type === 'home' || $booking->collection_type === 'Home Collection')
                        <div class="text-xs text-slate-700 leading-relaxed">
                            <span class="inline-flex items-center gap-1 font-bold text-teal-800 bg-teal-50 px-2 py-0.5 rounded-md border border-teal-200 mb-1">
                                <i class="fas fa-home text-[10px]"></i> Home Sample Pickup
                            </span>
                            @if($booking->address)
                                <p class="text-slate-600 text-[11px] leading-snug">
                                    {{ $booking->address->address_line1 }}, {{ $booking->address->city }} - {{ $booking->address->pincode }}
                                </p>
                            @else
                                <p class="text-slate-500 text-[11px]">Home collection at registered address</p>
                            @endif
                        </div>
                    @else
                        <span class="inline-flex items-center gap-1 font-bold text-slate-800 bg-slate-100 px-2 py-0.5 rounded-md border border-slate-200 text-xs">
                            <i class="fas fa-clinic-medical text-[10px] text-teal-700"></i> Walk-in Lab Visit
                        </span>
                    @endif

                    @if($booking->agent)
                        <div class="mt-2 pt-2 border-t border-slate-100 text-[11px] text-slate-700">
                            <span class="font-bold text-teal-900">Assigned Phlebotomist:</span>
                            <span class="font-semibold block">{{ $booking->agent->name }} ({{ $booking->agent->phone }})</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Itemized Diagnostic Tests Table -->
            <div class="print-break-inside-avoid">
                <div class="flex items-center justify-between mb-2.5">
                    <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-wider">Booked Diagnostic Tests & Health Packages</h4>
                    <span class="text-xs text-slate-500 font-semibold">{{ is_array($booking->test_details) ? count($booking->test_details) : 1 }} Item(s)</span>
                </div>
                
                <div class="border border-slate-200 rounded-2xl overflow-hidden shadow-2xs">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase font-black tracking-wider text-[10px]">
                            <tr>
                                <th class="p-3.5 w-12 text-center">#</th>
                                <th class="p-3.5">Diagnostic Test / Health Package</th>
                                <th class="p-3.5 text-center">Type</th>
                                <th class="p-3.5 text-right">Standard MRP</th>
                                <th class="p-3.5 text-right">Offer Price</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-800 font-medium">
                            @php
                                $testsList = is_array($booking->test_details) ? $booking->test_details : [];
                                $subtotalCalc = 0;
                            @endphp

                            @if(count($testsList) > 0)
                                @foreach($testsList as $idx => $tItem)
                                    @php
                                        $tName = is_array($tItem) ? ($tItem['name'] ?? 'Diagnostic Test') : (string)$tItem;
                                        $tPrice = is_array($tItem) ? (float)($tItem['price'] ?? 0) : 0;
                                        $tType = is_array($tItem) ? ($tItem['type'] ?? 'Test') : 'Test';
                                        $tCategory = is_array($tItem) ? ($tItem['category_name'] ?? ($tItem['category'] ?? 'Laboratory')) : 'Pathology';
                                        $subtotalCalc += $tPrice;
                                    @endphp
                                    <tr class="hover:bg-slate-50/50">
                                        <td class="p-3.5 text-center text-slate-400 font-mono">{{ $idx + 1 }}</td>
                                        <td class="p-3.5">
                                            <div class="font-extrabold text-slate-900 text-xs sm:text-sm">{{ $tName }}</div>
                                            <div class="text-[10px] text-teal-700 font-semibold mt-0.5">
                                                <i class="fas fa-vial text-[9px] mr-1"></i> Category: {{ $tCategory }}
                                            </div>
                                        </td>
                                        <td class="p-3.5 text-center">
                                            <span class="px-2 py-0.5 rounded-md {{ strtolower($tType) === 'package' ? 'bg-amber-50 text-amber-800 border border-amber-200' : 'bg-teal-50 text-teal-800 border border-teal-200' }} font-bold text-[10px] uppercase">
                                                {{ ucfirst($tType) }}
                                            </span>
                                        </td>
                                        <td class="p-3.5 text-right font-mono text-slate-400">
                                            ₹{{ number_format($tPrice > 0 ? $tPrice * 1.25 : $booking->amount, 0) }}
                                        </td>
                                        <td class="p-3.5 text-right font-bold font-mono text-slate-900">
                                            ₹{{ number_format($tPrice > 0 ? $tPrice : $booking->amount, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="p-3.5 text-center text-slate-400 font-mono">1</td>
                                    <td class="p-3.5">
                                        <div class="font-bold text-slate-900">Diagnostic Health Services</div>
                                        <div class="text-[10px] text-slate-500">Booking Reference #{{ $booking->booking_reference }}</div>
                                    </td>
                                    <td class="p-3.5 text-center">
                                        <span class="px-2 py-0.5 rounded-md bg-teal-50 text-teal-700 font-bold text-[10px] uppercase">Package</span>
                                    </td>
                                    <td class="p-3.5 text-right font-mono text-slate-400">₹{{ number_format($booking->amount, 2) }}</td>
                                    <td class="p-3.5 text-right font-black font-mono text-slate-900">₹{{ number_format($booking->amount, 2) }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Payment & Price Settlement Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2 print-break-inside-avoid">
                <!-- Payment Mode & Security Card -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2 text-xs">
                    <div class="flex items-center justify-between border-b border-slate-200/80 pb-2">
                        <span class="font-bold text-slate-500 uppercase tracking-wider text-[10px]">Payment Mode:</span>
                        <span class="font-black text-slate-800 uppercase px-2 py-0.5 rounded bg-white border border-slate-200 shadow-2xs">
                            {{ $booking->payment_method ?: 'ONLINE' }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between border-b border-slate-200/80 pb-2">
                        <span class="font-bold text-slate-500 uppercase tracking-wider text-[10px]">Payment Status:</span>
                        @php
                            $isPaid = in_array(strtolower((string)$booking->payment_status), ['paid', 'captured', 'completed', 'success']) || $booking->money_collected_at !== null;
                        @endphp
                        <span class="font-black text-xs px-2.5 py-0.5 rounded-full {{ $isPaid ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : 'bg-amber-100 text-amber-800 border border-amber-300' }}">
                            {{ $isPaid ? 'PAID IN FULL' : 'PAYMENT DUE / CASH ON PICKUP' }}
                        </span>
                    </div>

                    @if($booking->razorpay_payment_id)
                        <div class="flex items-center justify-between border-b border-slate-200/80 pb-2 font-mono text-[11px]">
                            <span class="font-bold font-sans text-slate-500">Transaction ID:</span>
                            <span class="text-teal-900 font-bold">{{ $booking->razorpay_payment_id }}</span>
                        </div>
                    @endif

                    @if($booking->money_collected_at)
                        <div class="flex items-center justify-between text-[11px]">
                            <span class="font-bold text-slate-500">Cash Received On:</span>
                            <span class="font-semibold text-slate-800">{{ $booking->money_collected_at->format('d M Y, h:i A') }}</span>
                        </div>
                    @endif

                    <div class="pt-1 text-[11px] text-slate-500 flex items-center gap-1.5">
                        <i class="fas fa-shield-alt text-emerald-600"></i>
                        <span>GST Exemption Notification No. 12/2017 (Health Care Services).</span>
                    </div>
                </div>

                <!-- Price Breakdown Calculation Card -->
                <div class="bg-gradient-to-br from-teal-50 via-emerald-50/70 to-slate-50 rounded-2xl p-5 border border-teal-200 shadow-2xs space-y-2 text-xs">
                    <div class="flex justify-between items-center text-slate-600">
                        <span>Items Subtotal:</span>
                        <span class="font-bold font-mono">₹{{ number_format($subtotalCalc > 0 ? $subtotalCalc : $booking->amount + $booking->discount_amount + $booking->coins_discount, 2) }}</span>
                    </div>

                    @if($booking->discount_amount > 0)
                        <div class="flex justify-between items-center text-emerald-700 font-semibold">
                            <span>Promotional Coupon Discount @if($booking->coupon_code) ({{ $booking->coupon_code }}) @endif:</span>
                            <span class="font-mono font-bold">- ₹{{ number_format($booking->discount_amount, 2) }}</span>
                        </div>
                    @endif

                    @if($booking->coins_discount > 0)
                        <div class="flex justify-between items-center text-amber-800 font-semibold">
                            <span>Health Coins Redeemed ({{ $booking->coins_redeemed }} coins):</span>
                            <span class="font-mono font-bold">- ₹{{ number_format($booking->coins_discount, 2) }}</span>
                        </div>
                    @endif

                    @if(str_contains(strtolower((string) $booking->collection_type), 'home'))
                        <div class="flex justify-between items-center text-slate-700 font-semibold">
                            <span>Home Sample Collection Fee:</span>
                            @if(($booking->collection_fee ?? 0) > 0)
                                <span class="font-mono font-bold text-slate-900">+ ₹{{ number_format($booking->collection_fee, 2) }}</span>
                            @else
                                <span class="font-bold text-emerald-700">₹0.00 (FREE)</span>
                            @endif
                        </div>
                    @endif

                    <div class="flex justify-between items-center text-slate-500 text-[11px]">
                        <span>Diagnostic Healthcare Tax (GST):</span>
                        <span class="font-bold text-emerald-800 font-mono">₹0.00 (Exempt)</span>
                    </div>

                    <div class="flex justify-between items-center pt-3 border-t border-teal-200">
                        <span class="font-black text-sm text-teal-950 uppercase tracking-tight">Net Amount:</span>
                        <span class="font-black text-2xl text-teal-900 font-mono">₹{{ number_format($booking->amount, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Terms, Verification & Digital Signature -->
            <div class="pt-6 border-t border-slate-200 print-break-inside-avoid">
                <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-6">
                    <div class="text-[11px] text-slate-500 space-y-1 max-w-lg">
                        <p class="font-bold text-slate-700">Important Terms & Laboratory Policy:</p>
                        <p>1. This is a computer-generated tax invoice and bill of supply issued in accordance with clinical establishment guidelines.</p>
                        <p>2. Phlebotomists follow standard cold-chain sample transport protocols with verified barcoding.</p>
                        <p>3. Digitally signed laboratory reports certified by an MD Pathologist will be accessible directly on the patient portal upon completion.</p>
                    </div>

                    <!-- Digital Stamp & Seal -->
                    <div class="text-center sm:text-right flex flex-col items-center sm:items-end">
                        <div class="w-32 h-14 border border-dashed border-teal-300 rounded-xl bg-teal-50/50 flex flex-col items-center justify-center text-[10px] text-teal-900 font-black p-1 shadow-2xs mb-1">
                            <i class="fas fa-certificate text-teal-600 mb-0.5"></i>
                            <span>Av Wellcare Verified</span>
                            <span class="text-[9px] font-mono text-teal-700">Electronic Bill</span>
                        </div>
                        <p class="text-[10px] font-bold text-slate-500">Authorized Digital Billing Officer</p>
                    </div>
                </div>
            </div>

            <!-- Footer Contact Notice -->
            <div class="pt-4 border-t border-slate-100 text-center text-slate-400 text-[10px] space-y-0.5 no-print">
                <p>For billing inquiries or report downloads, visit <strong>www.avwellcarediagnostics.com</strong> or call <strong>{{ \App\Models\Setting::get('helpline_primary', '898 898 8787') }}</strong></p>
                <p>Thank you for choosing Av Wellcare Diagnostics for your healthcare.</p>
            </div>
        </div>
    </div>
</div>
@endsection
