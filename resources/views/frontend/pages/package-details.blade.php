@extends('frontend.layouts.app')

@section('title', $package->name . ' (' . $package->total_parameters_count . ' Tests) - Pricing, Fasting & Booking | Wellcare')

@section('content')
<!-- Ambient Background Elements -->
<div class="fixed inset-0 z-[-1] pointer-events-none overflow-hidden bg-slate-50/50">
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-teal-200/30 rounded-full blur-3xl"></div>
    <div class="absolute top-96 -right-32 w-96 h-96 bg-indigo-200/20 rounded-full blur-3xl"></div>
</div>

<div class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-xs font-semibold text-gray-500 mb-6" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-teal-700 transition flex items-center gap-1.5">
            <i class="fas fa-home text-gray-400"></i>
            <span>Home</span>
        </a>
        <i class="fas fa-chevron-right text-[9px] text-gray-300"></i>
        <span class="text-gray-500">Packages</span>
        <i class="fas fa-chevron-right text-[9px] text-gray-300"></i>
        <span class="text-teal-800 font-bold truncate max-w-xs">{{ $package->name }}</span>
    </nav>

    <!-- Main Package Overview & Sticky Booking Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-14">
        
        <!-- Left 8 Columns: Package Info & Biomarkers -->
        <div class="lg:col-span-8 space-y-8">
            <div class="bg-white rounded-3xl p-8 border border-gray-200 shadow-sm">
                <!-- Badges -->
                <div class="flex flex-wrap items-center gap-2 mb-4">
                    <span class="px-3 py-1 rounded-full bg-teal-50 text-teal-800 text-xs font-bold uppercase tracking-wider border border-teal-200/60">
                        {{ $package->subcategory ?: 'Full Body Health' }}
                    </span>
                    <span class="px-3 py-1 rounded-full bg-indigo-50 text-indigo-800 text-xs font-bold uppercase tracking-wider border border-indigo-200/60">
                        {{ $package->total_parameters_count }} Clinical Biomarkers
                    </span>
                    @if($package->is_featured)
                    <span class="px-3 py-1 rounded-full bg-amber-50 text-amber-800 text-xs font-bold uppercase tracking-wider border border-amber-200/60 flex items-center gap-1">
                        <i class="fas fa-star text-amber-500 text-[10px]"></i> Most Popular
                    </span>
                    @endif
                </div>

                <!-- Package Title -->
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-gray-900 tracking-tight leading-tight mb-4">
                    {{ $package->name }}
                </h1>

                @if($package->description)
                <p class="text-sm text-gray-600 leading-relaxed mb-6 font-medium">
                    {{ $package->description }}
                </p>
                @endif

                <!-- Clinical Specs Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 bg-slate-50 rounded-2xl p-4 border border-slate-200/80">
                    <div class="text-center p-2">
                        <span class="text-[10px] text-gray-400 uppercase font-bold tracking-wider block">Turnaround</span>
                        <span class="text-xs font-bold text-gray-800 mt-1 flex items-center justify-center gap-1">
                            <i class="fas fa-clock text-amber-500"></i> 10-12 Hours
                        </span>
                    </div>
                    <div class="text-center p-2 border-l border-slate-200">
                        <span class="text-[10px] text-gray-400 uppercase font-bold tracking-wider block">Fasting</span>
                        <span class="text-xs font-bold text-gray-800 mt-1 flex items-center justify-center gap-1">
                            <i class="fas fa-utensils text-teal-600"></i> 10-12 Hrs Req.
                        </span>
                    </div>
                    <div class="text-center p-2 border-l border-slate-200">
                        <span class="text-[10px] text-gray-400 uppercase font-bold tracking-wider block">Sample Type</span>
                        <span class="text-xs font-bold text-gray-800 mt-1 flex items-center justify-center gap-1">
                            <i class="fas fa-vial text-indigo-600"></i> Blood & Urine
                        </span>
                    </div>
                    <div class="text-center p-2 border-l border-slate-200">
                        <span class="text-[10px] text-gray-400 uppercase font-bold tracking-wider block">Collection</span>
                        <span class="text-xs font-bold text-emerald-700 mt-1 flex items-center justify-center gap-1">
                            <i class="fas fa-house-medical"></i> Free at Home
                        </span>
                    </div>
                </div>
            </div>

            <!-- Serviceable Pincode Checker Widget -->
            <div class="bg-gradient-to-r from-teal-50 to-indigo-50 rounded-2xl p-6 border border-teal-100/80 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 shadow-sm">
                <div>
                    <h3 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-location-dot text-teal-700"></i>
                        <span>Check Sample Collection Availability</span>
                    </h3>
                    <p class="text-xs text-gray-500 mt-0.5">Enter your 6-digit area pincode to verify free home pickup slots.</p>
                </div>
                <div class="w-full sm:w-auto flex items-center gap-2">
                    <input type="text" id="checkPincodeInput" maxlength="6" placeholder="Enter Pincode (e.g. 110001)" class="px-4 py-2 text-xs rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-teal-500 bg-white font-mono">
                    <button type="button" onclick="verifyPincodeSlot()" class="px-4 py-2 bg-teal-800 text-white text-xs font-bold rounded-xl hover:bg-teal-900 transition whitespace-nowrap">
                        Check
                    </button>
                </div>
            </div>
            <div id="pincodeResultMsg" class="hidden text-xs font-semibold px-4 py-2.5 rounded-xl"></div>

            <!-- Complete Biomarkers Breakdown by Organ / Department -->
            <div class="bg-white rounded-3xl p-8 border border-gray-200 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-black text-gray-900 tracking-tight">Complete Tests & Biomarkers Included</h2>
                        <p class="text-xs text-gray-500 mt-1">Organized clinical view of all {{ $package->total_parameters_count }} parameters</p>
                    </div>
                    <span class="text-xs font-black text-teal-800 bg-teal-50 px-3 py-1 rounded-full border border-teal-200/60">
                        {{ count($groupedParameters) }} Organs Covered
                    </span>
                </div>

                <div class="space-y-4">
                    @forelse($groupedParameters as $deptName => $parameters)
                    <div class="rounded-2xl border border-gray-200/80 overflow-hidden shadow-xs">
                        <div class="bg-slate-50 p-4 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-teal-100 text-teal-800 flex items-center justify-center text-xs font-bold">
                                    <i class="fas fa-flask"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 text-sm">{{ $deptName }}</h3>
                                    <p class="text-[11px] text-gray-500">Includes vital physiological markers</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 rounded-full bg-white text-gray-700 text-xs font-bold border border-gray-200 shadow-xs">
                                {{ count($parameters) }} Tests
                            </span>
                        </div>
                        <div class="p-4 bg-white flex flex-wrap gap-2">
                            @foreach($parameters as $param)
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-slate-50 text-slate-800 border border-slate-200/60">
                                <i class="fas fa-check text-teal-600 mr-1.5 text-[9px]"></i>
                                <span>{{ $param }}</span>
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @empty
                    <p class="text-xs text-gray-500 italic">Detailed parameters will be provided in your test report.</p>
                    @endforelse
                </div>
            </div>

            <!-- Side-by-Side Comparison Matrix -->
            <div class="bg-white rounded-3xl p-8 border border-gray-200 shadow-sm">
                <div class="mb-6">
                    <span class="text-xs font-bold text-teal-700 uppercase tracking-wider block mb-1">Comparative Analysis</span>
                    <h2 class="text-xl font-black text-gray-900 tracking-tight">How Does This Package Compare?</h2>
                    <p class="text-xs text-gray-500 mt-1">See what is covered compared to other popular full body screening tiers</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-gray-200 bg-slate-50">
                                <th class="p-3 font-bold text-gray-600">Health Checkup Parameter</th>
                                <th class="p-3 font-bold text-teal-800 bg-teal-50/70 border-x border-teal-100">
                                    {{ $package->name }} (Current)
                                </th>
                                @foreach($comparisonPackages as $cp)
                                    @if($cp->id !== $package->id)
                                    <th class="p-3 font-bold text-gray-700">{{ $cp->name }}</th>
                                    @endif
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr>
                                <td class="p-3 font-semibold text-gray-800">Total Biomarkers</td>
                                <td class="p-3 font-black text-teal-700 bg-teal-50/30 border-x border-teal-100">{{ $package->total_parameters_count }} Tests</td>
                                @foreach($comparisonPackages as $cp)
                                    @if($cp->id !== $package->id)
                                    <td class="p-3 font-semibold text-gray-700">{{ $cp->total_parameters_count }} Tests</td>
                                    @endif
                                @endforeach
                            </tr>
                            <tr>
                                <td class="p-3 font-semibold text-gray-800">Complete Hemogram (CBC)</td>
                                <td class="p-3 font-bold text-emerald-600 bg-teal-50/30 border-x border-teal-100"><i class="fas fa-check-circle mr-1"></i> 24 Tests Included</td>
                                @foreach($comparisonPackages as $cp)
                                    @if($cp->id !== $package->id)
                                    <td class="p-3 text-emerald-600 font-medium"><i class="fas fa-check mr-1"></i> Included</td>
                                    @endif
                                @endforeach
                            </tr>
                            <tr>
                                <td class="p-3 font-semibold text-gray-800">Lipid & Heart Health</td>
                                <td class="p-3 font-bold text-emerald-600 bg-teal-50/30 border-x border-teal-100"><i class="fas fa-check-circle mr-1"></i> 8 Tests Included</td>
                                @foreach($comparisonPackages as $cp)
                                    @if($cp->id !== $package->id)
                                    <td class="p-3 text-emerald-600 font-medium"><i class="fas fa-check mr-1"></i> Included</td>
                                    @endif
                                @endforeach
                            </tr>
                            <tr>
                                <td class="p-3 font-semibold text-gray-800">Liver & Kidney Functions</td>
                                <td class="p-3 font-bold text-emerald-600 bg-teal-50/30 border-x border-teal-100"><i class="fas fa-check-circle mr-1"></i> Full Organ Screen</td>
                                @foreach($comparisonPackages as $cp)
                                    @if($cp->id !== $package->id)
                                    <td class="p-3 text-emerald-600 font-medium"><i class="fas fa-check mr-1"></i> Included</td>
                                    @endif
                                @endforeach
                            </tr>
                            <tr>
                                <td class="p-3 font-semibold text-gray-800">Thyroid Hormones</td>
                                <td class="p-3 font-bold text-emerald-600 bg-teal-50/30 border-x border-teal-100"><i class="fas fa-check-circle mr-1"></i> T3, T4, TSH Included</td>
                                @foreach($comparisonPackages as $cp)
                                    @if($cp->id !== $package->id)
                                    <td class="p-3 text-gray-600 font-medium">Standard</td>
                                    @endif
                                @endforeach
                            </tr>
                            <tr class="bg-slate-50/50">
                                <td class="p-3 font-bold text-gray-900">Package Price</td>
                                <td class="p-3 font-black text-lg text-teal-800 bg-teal-50/70 border-x border-teal-100">₹{{ number_format($package->price) }}</td>
                                @foreach($comparisonPackages as $cp)
                                    @if($cp->id !== $package->id)
                                    <td class="p-3 font-bold text-gray-800">₹{{ number_format($cp->price) }}</td>
                                    @endif
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right 4 Columns: Sticky Booking Card -->
        <div class="lg:col-span-4">
            <div class="bg-white rounded-3xl p-6 border border-gray-200 shadow-xl sticky top-24 space-y-6">
                <!-- Price & Discount Header -->
                <div>
                    <span class="text-[10px] text-gray-400 uppercase font-bold tracking-wider block">Special Promotional Price</span>
                    <div class="flex items-baseline gap-3 mt-1">
                        <span class="text-3xl font-black text-gray-900 tracking-tight">₹{{ number_format($package->price) }}</span>
                        <span class="text-sm font-semibold text-gray-400 line-through">₹{{ number_format($package->price * 2.5) }}</span>
                        <span class="text-xs font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100">
                            60% OFF
                        </span>
                    </div>
                    <p class="text-[11px] text-gray-500 mt-1">Inclusive of all sample collection charges and digital reports.</p>
                </div>

                <!-- Fast Booking CTAs -->
                <div class="space-y-3">
                    <button onclick="addToCart(this)"
                        data-id="{{ $package->id }}"
                        data-type="package"
                        data-name="{{ $package->name }}"
                        data-price="{{ $package->price }}" data-mrp="{{ $package->price }}" data-params="Includes {{ $package->total_parameters_count }} Parameters"
                        class="w-full py-3.5 px-6 bg-gradient-to-r from-teal-700 via-teal-800 to-indigo-900 hover:from-teal-800 hover:to-indigo-950 text-white font-extrabold text-sm rounded-2xl shadow-lg shadow-teal-800/25 transition active:scale-95 flex items-center justify-center gap-2 cursor-pointer">
                        <i class="fas fa-cart-plus"></i>
                        <span>Add Package to Cart</span>
                    </button>

                    @php
                        $waNumber = \App\Models\Setting::get('whatsapp_number', '8988988787');
                        $waText = urlencode("Hello Wellcare, I would like to book the " . $package->name . " (Price: Rs. " . number_format($package->price) . "). Please share available appointment slots.");
                    @endphp
                    <a href="https://wa.me/91{{ $waNumber }}?text={{ $waText }}" target="_blank" class="w-full py-3 px-4 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-bold text-xs rounded-2xl border border-emerald-200 transition flex items-center justify-center gap-2">
                        <i class="fab fa-whatsapp text-emerald-600 text-sm"></i>
                        <span>Book via WhatsApp Assistant</span>
                    </a>
                </div>

                <!-- Trust Guarantees List -->
                <div class="border-t border-gray-100 pt-5 space-y-3 text-xs text-gray-600 font-medium">
                    <div class="flex items-center gap-3">
                        <div class="w-6 h-6 rounded-full bg-teal-50 text-teal-700 flex items-center justify-center text-[10px] flex-shrink-0">
                            <i class="fas fa-shield-halved"></i>
                        </div>
                        <span>NABL & ISO Accredited Laboratory Partners</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-6 h-6 rounded-full bg-teal-50 text-teal-700 flex items-center justify-center text-[10px] flex-shrink-0">
                            <i class="fas fa-temperature-low"></i>
                        </div>
                        <span>2°C - 8°C Cold Chain Sample Bags</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-6 h-6 rounded-full bg-teal-50 text-teal-700 flex items-center justify-center text-[10px] flex-shrink-0">
                            <i class="fas fa-clock"></i>
                        </div>
                        <span>Digital PDF Report Delivered on WhatsApp</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-6 h-6 rounded-full bg-teal-50 text-teal-700 flex items-center justify-center text-[10px] flex-shrink-0">
                            <i class="fas fa-user-doctor"></i>
                        </div>
                        <span>Free Doctor Consultation Included</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function verifyPincodeSlot() {
        const input = document.getElementById('checkPincodeInput');
        const res = document.getElementById('pincodeResultMsg');
        const code = (input.value || '').trim();

        if (!/^\d{6}$/.test(code)) {
            res.className = 'text-xs font-semibold px-4 py-2.5 rounded-xl bg-amber-50 text-amber-800 border border-amber-200';
            res.textContent = 'Please enter a valid 6-digit postal pincode.';
            res.classList.remove('hidden');
            return;
        }

        @php
            $serviceablePincodes = \App\Models\Setting::get('serviceable_pincodes', '800001,800002,110001,201301,400001');
        @endphp
        const serviceableStr = @json($serviceablePincodes);
        const serviceableArray = (serviceableStr || '').split(',').map(s => s.trim());

        if (serviceableArray.includes(code)) {
            res.className = 'text-xs font-semibold px-4 py-2.5 rounded-xl bg-emerald-50 text-emerald-800 border border-emerald-200';
            res.innerHTML = `<i class="fas fa-circle-check text-emerald-600 mr-1.5"></i> Great news! <strong>Free Home Sample Collection</strong> is available tomorrow at 6:30 AM in pincode <strong>${code}</strong>.`;
        } else {
            res.className = 'text-xs font-semibold px-4 py-2.5 rounded-xl bg-slate-100 text-slate-800 border border-slate-200';
            res.innerHTML = `<i class="fas fa-info-circle text-teal-600 mr-1.5"></i> Pincode <strong>${code}</strong> is currently served on priority phone booking. Proceed to checkout or call support.`;
        }
        res.classList.remove('hidden');
    }
</script>
@endsection
