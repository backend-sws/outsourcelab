@extends('frontend.layouts.app')

@section('title', 'Our Labs & Diagnostic Centers | Av Wellcare Diagnostics')

@section('content')
<!-- Ambient Background Elements -->
<div class="fixed inset-0 z-[-1] pointer-events-none overflow-hidden bg-slate-50/60">
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-teal-200/30 rounded-full blur-3xl"></div>
    <div class="absolute top-96 -right-32 w-96 h-96 bg-cyan-200/20 rounded-full blur-3xl"></div>
</div>

<div class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-xs font-semibold text-gray-500 mb-6" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-teal-700 transition flex items-center gap-1.5">
            <i class="fas fa-home text-gray-400"></i>
            <span>Home</span>
        </a>
        <i class="fas fa-chevron-right text-[9px] text-gray-300"></i>
        <span class="text-teal-800 font-bold">Our Labs</span>
    </nav>

    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-brand-dark via-teal-950 to-slate-900 rounded-3xl p-8 sm:p-14 text-white shadow-2xl relative overflow-hidden mb-12">
        <div class="absolute top-0 right-0 w-96 h-96 bg-teal-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-brand-secondary/15 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 max-w-3xl">
            <span class="px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-teal-500/20 text-teal-300 border border-teal-500/30 inline-flex items-center gap-1.5 mb-4">
                <i class="fas fa-flask-vial text-amber-400"></i> Advanced Laboratory Infrastructure
            </span>
            <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-white leading-tight mb-5">
                State-of-the-Art Labs & Pincode Network
            </h1>
            <p class="text-gray-200 text-sm sm:text-base leading-relaxed mb-6 font-normal">
                Our hub-and-spoke testing network connects centralized reference laboratories equipped with robotic analyzers to thousands of local sample touchpoints, ensuring medical-grade accuracy and ultra-fast turnaround times.
            </p>

            <div class="flex flex-wrap gap-4 text-xs font-semibold">
                <div class="px-3.5 py-2 rounded-xl bg-white/10 border border-white/10 flex items-center gap-2 text-teal-100">
                    <i class="fas fa-microscope text-teal-300"></i> Fully Automated Chemistry & Immunoassay
                </div>
                <div class="px-3.5 py-2 rounded-xl bg-white/10 border border-white/10 flex items-center gap-2 text-teal-100">
                    <i class="fas fa-temperature-snowflake text-cyan-300"></i> Validated 2°C - 8°C Cold Chain
                </div>
                <div class="px-3.5 py-2 rounded-xl bg-white/10 border border-white/10 flex items-center gap-2 text-teal-100">
                    <i class="fas fa-barcode text-amber-400"></i> Zero-Error Barcoded Tracking
                </div>
            </div>
        </div>
    </div>

    <!-- National Reference Lab Card -->
    <div class="bg-white rounded-3xl border border-teal-100 shadow-sm overflow-hidden mb-12">
        <div class="grid grid-cols-1 lg:grid-cols-12">
            <div class="lg:col-span-7 p-8 sm:p-10 flex flex-col justify-between">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-amber-50 text-amber-800 rounded-full text-xs font-black uppercase tracking-wider mb-4 border border-amber-200">
                        <i class="fas fa-crown text-amber-500"></i> Central Apex Facility
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-black text-gray-900 mb-3">
                        National Reference Laboratory (NRL)
                    </h2>
                    <p class="text-gray-600 text-sm leading-relaxed mb-6">
                        Handling complex multi-parameter molecular genetics, specialized oncology markers, therapeutic drug monitoring, and esoteric biochemistry with computerized sample segregation and zero manual pipetting variance.
                    </p>

                    <div class="space-y-3.5 text-xs text-gray-700 mb-8">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-map-marker-alt text-teal-600 mt-1 flex-shrink-0"></i>
                            <div>
                                <strong class="text-gray-900 block text-sm font-bold">Facility Address</strong>
                                <span class="text-gray-600">{{ \App\Models\Setting::get('reference_lab_address', 'H-21, 4th Floor, Electronic City, H Block, Sector 63, Noida, Uttar Pradesh 201301') }}</span>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="fas fa-phone-alt text-teal-600 mt-1 flex-shrink-0"></i>
                            <div>
                                <strong class="text-gray-900 block text-sm font-bold">Direct Desk & Sample Inquiries</strong>
                                <a href="tel:{{ preg_replace('/[^0-9]/', '', \App\Models\Setting::get('helpline_primary', '8988988787')) }}" class="text-teal-700 font-bold hover:underline">
                                    {{ \App\Models\Setting::get('helpline_primary', '898 898 8787') }}
                                </a>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="fas fa-envelope text-teal-600 mt-1 flex-shrink-0"></i>
                            <div>
                                <strong class="text-gray-900 block text-sm font-bold">Laboratory Support Email</strong>
                                <a href="mailto:{{ \App\Models\Setting::get('contact_email', 'care@avwellcarediagnostics.com') }}" class="text-teal-700 font-bold hover:underline">
                                    {{ \App\Models\Setting::get('contact_email', 'care@avwellcarediagnostics.com') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3 pt-4 border-t border-gray-100">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Operational Hours:</span>
                    <span class="text-xs font-semibold px-2.5 py-1 bg-teal-50 text-teal-800 rounded-lg">24x7 Continuous Ingestion</span>
                    <span class="text-xs font-semibold px-2.5 py-1 bg-slate-100 text-slate-700 rounded-lg">Real-Time LIS Interfacing</span>
                </div>
            </div>

            <div class="lg:col-span-5 bg-gradient-to-br from-teal-900 to-slate-900 p-8 sm:p-10 text-white flex flex-col justify-between">
                <div>
                    <h3 class="text-lg font-black text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-microchip text-teal-400"></i> Robotic Testing Suites
                    </h3>
                    <ul class="space-y-3 text-xs text-teal-100">
                        <li class="flex items-center gap-2.5">
                            <i class="fas fa-check-circle text-teal-400"></i> Chemiluminescence Immunoassay (CLIA)
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fas fa-check-circle text-teal-400"></i> High-Performance Liquid Chromatography (HPLC)
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fas fa-check-circle text-teal-400"></i> Real-Time PCR & Molecular Diagnostics
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fas fa-check-circle text-teal-400"></i> 6-Part Flow Cytometry Hematology
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fas fa-check-circle text-teal-400"></i> Nephelometry & Specific Protein Profiling
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fas fa-check-circle text-teal-400"></i> Automated Urine Sediment Microscopy
                        </li>
                    </ul>
                </div>

                <div class="mt-8 pt-6 border-t border-teal-800/60">
                    <a href="{{ route('home') }}#tests" class="inline-flex items-center justify-center w-full py-3 px-4 rounded-xl bg-teal-500 hover:bg-teal-400 text-white font-bold text-xs uppercase tracking-wider transition shadow-lg">
                        Explore Full Test Menu <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Pincode Serviceability Search & Interactive Checker -->
    <div class="bg-white rounded-3xl p-8 sm:p-10 border border-gray-100 shadow-sm mb-16" id="pincode-checker">
        <div class="max-w-3xl mb-8">
            <span class="text-xs font-extrabold uppercase tracking-wider text-teal-700 bg-teal-50 px-3 py-1 rounded-full border border-teal-200 inline-block mb-3">Service Coverage</span>
            <h2 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight mb-2">
                Check Home Sample Collection in Your Pincode
            </h2>
            <p class="text-sm text-gray-600">
                Our certified phlebotomists provide sterile, painless blood sample collection directly at your doorstep with real-time temperature tracking boxes.
            </p>
        </div>

        <div class="max-w-xl mb-8">
            <div class="relative flex items-center">
                <input type="text" id="pincodeInput" maxlength="6" placeholder="Enter your 6-digit Pincode (e.g. 201301)" 
                       class="w-full pl-4 pr-32 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white transition">
                <button onclick="checkServiceability()" type="button" 
                        class="absolute right-2 px-5 py-2.5 bg-teal-700 hover:bg-teal-800 text-white text-xs font-bold rounded-xl transition shadow">
                    Check Now
                </button>
            </div>
            <div id="pincodeResult" class="mt-3 hidden text-xs font-bold p-3 rounded-xl"></div>
        </div>

        <div class="border-t border-gray-100 pt-6">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                <i class="fas fa-city text-teal-600"></i> Sample of Actively Serviced Major Pincodes
            </h3>
            <div class="flex flex-wrap gap-2">
                @forelse($serviceablePincodes as $pin)
                    <span class="px-3 py-1 bg-slate-100 text-slate-700 rounded-lg text-xs font-mono font-medium hover:bg-teal-50 hover:text-teal-800 transition">
                        {{ $pin }}
                    </span>
                @empty
                    <span class="text-xs text-gray-500">Pan-India network across 220+ key cities.</span>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Diagnostic Equipment Pillars -->
    <div class="mb-16">
        <div class="text-center max-w-2xl mx-auto mb-10">
            <span class="text-xs font-extrabold uppercase tracking-wider text-teal-700 bg-teal-50 px-3 py-1 rounded-full border border-teal-200 inline-block mb-3">Diagnostic Technology</span>
            <h2 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
                Global Gold-Standard Equipment
            </h2>
            <p class="text-xs sm:text-sm text-gray-500 mt-2">
                Zero clinical compromises. Every sample is evaluated on calibrated, globally approved analytical platforms.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center text-xl mb-4">
                    <i class="fas fa-wave-square"></i>
                </div>
                <h4 class="font-bold text-gray-900 text-base mb-2">Roche Cobas & Beckman Coulter</h4>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Closed-system automated analyzers handling metabolic panels, cardiac enzymes, liver panels, and renal parameters with bidirectional barcode verification.
                </p>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center text-xl mb-4">
                    <i class="fas fa-dna"></i>
                </div>
                <h4 class="font-bold text-gray-900 text-base mb-2">Bio-Rad HPLC & Abbott Architect</h4>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Gold standard for accurate HbA1c diabetic monitoring without variant interference, hormone profiling, infectious disease serology, and cancer biomarkers.
                </p>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-xl mb-4">
                    <i class="fas fa-vial"></i>
                </div>
                <h4 class="font-bold text-gray-900 text-base mb-2">Sysmex Automated Hematology</h4>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Fluorescence flow cytometry technology for full blood counts (CBC), platelet counts, reticulocyte analysis, and optical flagging of atypical white blood cells.
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    const serviceablePincodesList = @json($serviceablePincodes);

    function checkServiceability() {
        const input = document.getElementById('pincodeInput').value.trim();
        const res = document.getElementById('pincodeResult');
        res.classList.remove('hidden', 'bg-emerald-50', 'text-emerald-800', 'border-emerald-200', 'bg-rose-50', 'text-rose-800', 'border-rose-200');
        res.classList.add('border');

        if (!/^\d{6}$/.test(input)) {
            res.classList.add('bg-rose-50', 'text-rose-800', 'border-rose-200');
            res.innerHTML = '<i class="fas fa-exclamation-circle mr-1"></i> Please enter a valid 6-digit Indian postal pincode.';
            return;
        }

        const isServiced = serviceablePincodesList.includes(input);

        if (isServiced || serviceablePincodesList.length === 0) {
            res.classList.add('bg-emerald-50', 'text-emerald-800', 'border-emerald-200');
            res.innerHTML = `<i class="fas fa-check-circle mr-1"></i> Pincode <strong>${input}</strong> is serviced! Home collection slots are available for today and tomorrow.`;
        } else {
            res.classList.add('bg-teal-50', 'text-teal-900', 'border-teal-200');
            res.innerHTML = `<i class="fas fa-info-circle mr-1"></i> Pincode <strong>${input}</strong> is currently served through our express network. Please call our helpline at {{ \App\Models\Setting::get('helpline_primary', '898 898 8787') }} for immediate slot booking.`;
        }
    }
</script>
@endsection
