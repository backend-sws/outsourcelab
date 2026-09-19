@extends('frontend.layouts.app')

@section('title', $category->name . ' - Health Checkup Packages & Tests | Wellcare')

@section('content')
<!-- Ambient Background Elements -->
<div class="fixed inset-0 z-[-1] pointer-events-none overflow-hidden bg-slate-50/50">
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-teal-200/30 rounded-full blur-3xl"></div>
    <div class="absolute top-96 -right-32 w-96 h-96 bg-indigo-200/20 rounded-full blur-3xl"></div>
</div>

<div class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- Breadcrumb Navigation -->
    <nav class="flex items-center gap-2 text-xs font-semibold text-gray-500 mb-6" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-teal-700 transition flex items-center gap-1.5">
            <i class="fas fa-home text-gray-400"></i>
            <span>Home</span>
        </a>
        <i class="fas fa-chevron-right text-[9px] text-gray-300"></i>
        <span class="text-teal-800 font-bold">{{ $category->name }}</span>
        @if($selectedSubcategory)
            <i class="fas fa-chevron-right text-[9px] text-gray-300"></i>
            <span class="text-gray-700 font-bold">{{ $selectedSubcategory }}</span>
        @endif
    </nav>

    <!-- Hero Header Banner -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-teal-900 via-teal-800 to-indigo-950 text-white p-8 sm:p-12 mb-10 shadow-xl shadow-teal-950/10">
        <div class="relative z-10 max-w-3xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md text-teal-200 text-xs font-bold uppercase tracking-wider mb-4 border border-white/15">
                <i class="fas fa-shield-halved text-amber-400"></i>
                <span>NABL Quality Accredited Lab Partners</span>
            </div>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tight leading-tight mb-4">
                {{ $category->name }} <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-200 to-amber-300">Checkups & Tests</span>
            </h1>
            <p class="text-teal-100/90 text-sm sm:text-base leading-relaxed mb-6 font-medium">
                Comprehensive doctor-curated pathology panels, painless home sample collection, and verified digital reports delivered on WhatsApp within hours.
            </p>

            <!-- Key Trust Pills -->
            <div class="flex flex-wrap gap-4 text-xs font-semibold text-white/90">
                <div class="flex items-center gap-2 bg-white/10 px-3.5 py-1.5 rounded-xl border border-white/10 backdrop-blur-sm">
                    <i class="fas fa-house-medical text-teal-300"></i>
                    <span>Free Home Collection</span>
                </div>
                <div class="flex items-center gap-2 bg-white/10 px-3.5 py-1.5 rounded-xl border border-white/10 backdrop-blur-sm">
                    <i class="fas fa-bolt text-amber-400"></i>
                    <span>Same-Day Digital Reports</span>
                </div>
                <div class="flex items-center gap-2 bg-white/10 px-3.5 py-1.5 rounded-xl border border-white/10 backdrop-blur-sm">
                    <i class="fas fa-user-doctor text-cyan-300"></i>
                    <span>Free Doctor Tele-Consultation</span>
                </div>
            </div>
        </div>

        <!-- Decorative Pattern Background -->
        <div class="absolute -right-16 -bottom-16 w-80 h-80 rounded-full bg-teal-500/10 blur-2xl pointer-events-none"></div>
    </div>

    <!-- Subcategory Tabs Navigation -->
    @php
        $subs = is_array($category->sub_category) ? $category->sub_category : [];
    @endphp
    @if(!empty($subs))
    <div class="mb-10">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-gray-900">Explore by Sub-Category</h2>
            <span class="text-xs font-semibold text-gray-500">{{ count($subs) }} Specialized Profiles</span>
        </div>
        <div class="flex items-center gap-2.5 overflow-x-auto pb-2 scrollbar-none">
            <a href="{{ route('category.show', $category->id) }}" 
               class="px-5 py-2.5 rounded-2xl text-xs font-bold transition-all whitespace-nowrap flex items-center gap-2 {{ !$selectedSubcategory ? 'bg-teal-800 text-white shadow-md shadow-teal-800/20' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200' }}">
                <i class="fas fa-layer-group text-xs"></i>
                <span>All {{ $category->name }}</span>
            </a>
            @foreach($subs as $sub)
                @php
                    $subName = is_array($sub) ? ($sub['name'] ?? '') : $sub;
                    $rawImg = is_array($sub) ? ($sub['image'] ?? null) : null;
                    $isActive = ($selectedSubcategory === $subName);
                @endphp
                @if($subName)
                <a href="{{ route('category.show', ['id' => $category->id, 'subcategory' => $subName]) }}" 
                   class="px-4 py-2 rounded-2xl text-xs font-bold transition-all whitespace-nowrap flex items-center gap-2.5 {{ $isActive ? 'bg-teal-800 text-white shadow-md shadow-teal-800/20' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200' }}">
                    @if($rawImg)
                        <img src="{{ \Illuminate\Support\Str::startsWith($rawImg, ['http://', 'https://', '//']) ? $rawImg : \Illuminate\Support\Facades\Storage::url($rawImg) }}" 
                             alt="{{ $subName }}" 
                             class="w-5 h-5 rounded-full object-cover border {{ $isActive ? 'border-white/60' : 'border-slate-200' }}">
                    @else
                        <i class="fas fa-notes-medical text-xs {{ $isActive ? 'text-teal-200' : 'text-teal-600' }}"></i>
                    @endif
                    <span>{{ $subName }}</span>
                </a>
                @endif
            @endforeach
        </div>
    </div>
    @endif

    <!-- Available Health Packages Section -->
    <div class="mb-14">
        <div class="flex items-end justify-between mb-6">
            <div>
                <h2 class="text-2xl font-black text-gray-900 tracking-tight">Health Packages Available</h2>
                <p class="text-xs text-gray-500 mt-1">Multi-parameter checkups with bundled savings for {{ $selectedSubcategory ?: $category->name }}</p>
            </div>
            <span class="text-xs font-bold text-teal-800 bg-teal-50 px-3 py-1 rounded-full border border-teal-200/60">
                {{ $packages->count() }} Packages Found
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($packages as $package)
            <div class="bg-white rounded-3xl p-6 border border-gray-200/80 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between relative group overflow-hidden">
                <!-- Top Accent Line -->
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-teal-500 to-indigo-600 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>

                <div>
                    <!-- Badge & Category -->
                    <div class="flex items-center justify-between mb-3">
                        <span class="bg-teal-50 text-teal-800 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider border border-teal-200/60">
                            {{ $package->subcategory ?: 'Full Body' }}
                        </span>
                        <div class="w-8 h-8 rounded-full bg-teal-50 text-teal-700 flex items-center justify-center text-xs font-bold">
                            <i class="fas fa-boxes-stacked"></i>
                        </div>
                    </div>

                    <!-- Package Title -->
                    <h3 class="font-extrabold text-gray-900 text-lg leading-snug mb-3 group-hover:text-teal-700 transition-colors">
                        <a href="{{ route('package.show', $package->id) }}">
                            {{ $package->name }}
                        </a>
                    </h3>

                    <!-- Turnaround & Parameters Metrics -->
                    <div class="bg-slate-50 rounded-2xl p-3.5 flex items-center justify-between mb-4 border border-slate-200/60">
                        <div class="text-center w-1/2 pr-2 border-r border-slate-200">
                            <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Reports In</p>
                            <p class="text-sm font-bold text-gray-800 flex items-center justify-center gap-1 mt-0.5">
                                <i class="fas fa-clock text-amber-500 text-[11px]"></i>
                                <span>10-12 Hours</span>
                            </p>
                        </div>
                        <div class="text-center w-1/2 pl-2">
                            <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Parameters</p>
                            <p class="text-sm font-bold text-teal-700 mt-0.5">
                                {{ $package->total_parameters_count }} Tests
                            </p>
                        </div>
                    </div>

                    <!-- Department Tags Breakdown -->
                    @php
                        $grouped = $package->getGroupedParameters();
                    @endphp
                    @if(!empty($grouped))
                    <div class="flex flex-wrap gap-1.5 mb-4">
                        @foreach(array_slice(array_keys($grouped), 0, 3) as $deptName)
                        <span class="bg-slate-50 text-slate-700 text-[10px] font-medium px-2 py-0.5 rounded-md border border-slate-200 flex items-center">
                            <i class="fas fa-check-circle text-teal-600 mr-1 text-[9px]"></i> {{ \Illuminate\Support\Str::limit($deptName, 18) }}
                        </span>
                        @endforeach
                        @if(count($grouped) > 3)
                        <span class="text-[10px] text-teal-700 font-bold self-center ml-1">+{{ count($grouped) - 3 }} More Organs</span>
                        @endif
                    </div>
                    @endif

                    @if($package->description)
                    <p class="text-xs text-gray-500 mb-6 line-clamp-2 leading-relaxed">{{ $package->description }}</p>
                    @endif
                </div>

                <!-- Footer & Booking Buttons -->
                <div class="border-t border-gray-100 pt-4 mt-auto">
                    <div class="flex items-baseline justify-between mb-3">
                        <div>
                            <span class="text-[10px] text-gray-400 uppercase font-bold tracking-wider block">Special Price</span>
                            <div class="text-2xl font-black text-gray-900 tracking-tight">₹{{ number_format($package->price) }}</div>
                        </div>
                        <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100">
                            Save Up to 65%
                        </span>
                    </div>

                    <!-- Quick View Tests Modal Trigger -->
                    <button type="button" onclick="openPackageDetails({{ $package->id }})" class="w-full mb-2 py-2 px-3 bg-teal-50 hover:bg-teal-100 text-teal-800 border border-teal-200 text-xs font-semibold rounded-xl transition flex items-center justify-center gap-1.5">
                        <i class="fas fa-file-waveform text-teal-600 text-[11px]"></i>
                        <span>View {{ $package->total_parameters_count }} Tests Included</span>
                    </button>

                    <!-- Add to Cart / Book Button -->
                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ route('package.show', $package->id) }}" class="py-2.5 text-center text-xs font-bold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition">
                            Full Details
                        </a>
                        <button onclick="addToCart(this)" 
                            data-id="{{ $package->id }}"
                            data-type="package"
                            data-name="{{ $package->name }}"
                            data-price="{{ $package->price }}" data-mrp="{{ $package->price }}" data-params="Includes {{ $package->total_parameters_count }} Parameters"
                            class="bg-teal-700 hover:bg-teal-800 text-white font-bold py-2.5 rounded-xl transition shadow-md shadow-teal-700/20 text-xs flex items-center justify-center gap-1 cursor-pointer">
                            <i class="fas fa-cart-plus text-[11px]"></i> Add to Cart
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full bg-white rounded-3xl p-12 text-center border border-gray-200">
                <div class="w-16 h-16 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center text-2xl mx-auto mb-4">
                    <i class="fas fa-clipboard-question"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">No specific packages for this subcategory yet</h3>
                <p class="text-xs text-gray-500 max-w-md mx-auto mb-4">You can browse our other full body health packages or select individual tests from below.</p>
                <a href="{{ route('category.show', $category->id) }}" class="inline-flex items-center px-4 py-2 bg-teal-700 text-white text-xs font-bold rounded-xl">
                    View All {{ $category->name }} Packages
                </a>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Matching Single Lab Tests Section -->
    <div class="mb-14">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-black text-gray-900 tracking-tight">Individual Pathology Tests</h2>
                <p class="text-xs text-gray-500 mt-1">Single diagnostic blood tests available with immediate sample pickup</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($singleTests as $test)
            <div class="bg-white rounded-2xl p-5 border border-gray-200/80 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2.5">
                        <span class="text-[9px] font-bold text-teal-800 bg-teal-50 px-2 py-0.5 rounded uppercase border border-teal-100">
                            {{ $test->category ? $test->category->name : 'General Test' }}
                        </span>
                        <i class="fas fa-vial text-teal-600 text-xs"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 text-sm leading-snug mb-2 hover:text-teal-700">
                        <a href="{{ route('test.show', $test->id) }}">{{ $test->name }}</a>
                    </h4>
                    <p class="text-[11px] text-gray-500 flex items-center gap-1.5 mb-4">
                        <i class="fas fa-clock text-amber-500 text-[10px]"></i>
                        <span>{{ $test->report_delivery_time ?? 'Within 6 Hours' }}</span>
                    </p>
                </div>
                <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] text-gray-400 block font-semibold">Test Price</span>
                        <span class="text-lg font-black text-gray-900">₹{{ number_format($test->price) }}</span>
                    </div>
                    <button onclick="addToCart(this)"
                        data-id="{{ $test->id }}"
                        data-type="test"
                        data-name="{{ $test->name }}"
                        data-price="{{ $test->price }}" data-mrp="{{ $test->price }}" data-params="Individual Pathology Test"
                        class="px-3 py-1.5 bg-teal-50 hover:bg-teal-700 text-teal-800 hover:text-white text-xs font-bold rounded-xl transition border border-teal-200 flex items-center gap-1 cursor-pointer">
                        <i class="fas fa-plus text-[10px]"></i> Add
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Clinical Guide & Educational Section (Dr Lal / 1mg Style) -->
    <div class="bg-white rounded-3xl p-8 sm:p-12 border border-gray-200 mb-14 shadow-sm">
        <div class="max-w-3xl mb-8">
            <span class="text-xs font-bold text-teal-700 uppercase tracking-wider mb-2 block">Medical Knowledge & Guidelines</span>
            <h2 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">Everything You Need to Know About {{ $category->name }}</h2>
            <p class="text-xs sm:text-sm text-gray-500 mt-2 leading-relaxed">
                Regular clinical diagnostic screenings help identify asymptomatic organ stress, hormonal imbalances, and nutritional deficits before they manifest as chronic medical conditions.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <!-- Pillar 1 -->
            <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200/80">
                <div class="w-10 h-10 rounded-xl bg-teal-100 text-teal-800 flex items-center justify-center text-lg font-bold mb-4">
                    <i class="fas fa-user-check"></i>
                </div>
                <h3 class="text-base font-bold text-gray-900 mb-2">Who Needs This Checkup?</h3>
                <ul class="text-xs text-gray-600 space-y-2 leading-relaxed">
                    <li class="flex items-start gap-2"><i class="fas fa-check text-teal-600 mt-0.5"></i> Adults with a busy, stressful lifestyle or sedentary desk job.</li>
                    <li class="flex items-start gap-2"><i class="fas fa-check text-teal-600 mt-0.5"></i> Individuals with a family history of diabetes, thyroid, or hypertension.</li>
                    <li class="flex items-start gap-2"><i class="fas fa-check text-teal-600 mt-0.5"></i> People experiencing sudden fatigue, sleep issues, or weight fluctuations.</li>
                </ul>
            </div>

            <!-- Pillar 2 -->
            <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200/80">
                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center text-lg font-bold mb-4">
                    <i class="fas fa-triangle-exclamation"></i>
                </div>
                <h3 class="text-base font-bold text-gray-900 mb-2">Key Warning Signs & Symptoms</h3>
                <ul class="text-xs text-gray-600 space-y-2 leading-relaxed">
                    <li class="flex items-start gap-2"><i class="fas fa-circle-exclamation text-amber-500 mt-0.5"></i> Persistent low energy, morning tiredness, and brain fog.</li>
                    <li class="flex items-start gap-2"><i class="fas fa-circle-exclamation text-amber-500 mt-0.5"></i> Chronic joint aches, back stiffness, and muscle weakness.</li>
                    <li class="flex items-start gap-2"><i class="fas fa-circle-exclamation text-amber-500 mt-0.5"></i> Digestive issues, frequent acidity, bloating, or skin changes.</li>
                </ul>
            </div>

            <!-- Pillar 3 -->
            <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200/80">
                <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-800 flex items-center justify-center text-lg font-bold mb-4">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <h3 class="text-base font-bold text-gray-900 mb-2">Recommended Testing Frequency</h3>
                <ul class="text-xs text-gray-600 space-y-2 leading-relaxed">
                    <li class="flex items-start gap-2"><i class="fas fa-clock text-indigo-600 mt-0.5"></i> <strong>Age 20 - 35:</strong> Routine preventive screening once every 12 months.</li>
                    <li class="flex items-start gap-2"><i class="fas fa-clock text-indigo-600 mt-0.5"></i> <strong>Age 35 - 50:</strong> Comprehensive profile check every 6 to 12 months.</li>
                    <li class="flex items-start gap-2"><i class="fas fa-clock text-indigo-600 mt-0.5"></i> <strong>Seniors & Chronic Care:</strong> Vital monitoring every 3 to 6 months.</li>
                </ul>
            </div>
        </div>

        <!-- Sample Preparation Timeline -->
        <div class="border-t border-gray-100 pt-8">
            <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                <i class="fas fa-list-ol text-teal-600"></i>
                <span>Sample Collection & Preparation Protocol</span>
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <div class="p-4 rounded-2xl bg-teal-50/50 border border-teal-100">
                    <span class="text-xs font-black text-teal-800 uppercase tracking-wider block mb-1">Step 1 • Night Prior</span>
                    <p class="text-xs text-gray-600 leading-relaxed">Maintain 10-12 hours of overnight fasting. Only plain water is allowed.</p>
                </div>
                <div class="p-4 rounded-2xl bg-teal-50/50 border border-teal-100">
                    <span class="text-xs font-black text-teal-800 uppercase tracking-wider block mb-1">Step 2 • Morning</span>
                    <p class="text-xs text-gray-600 leading-relaxed">Avoid morning tea, coffee, milk, or smoking before your blood draw.</p>
                </div>
                <div class="p-4 rounded-2xl bg-teal-50/50 border border-teal-100">
                    <span class="text-xs font-black text-teal-800 uppercase tracking-wider block mb-1">Step 3 • At Home</span>
                    <p class="text-xs text-gray-600 leading-relaxed">Certified phlebotomist collects samples using single-use vacuum vacutainers.</p>
                </div>
                <div class="p-4 rounded-2xl bg-teal-50/50 border border-teal-100">
                    <span class="text-xs font-black text-teal-800 uppercase tracking-wider block mb-1">Step 4 • Reports</span>
                    <p class="text-xs text-gray-600 leading-relaxed">Smart digital reports sent on WhatsApp & Portal within 6 to 12 hours.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Prescription Upload / Fast Booking Banner -->
    <div class="bg-gradient-to-r from-amber-500 via-orange-500 to-amber-600 rounded-3xl p-8 sm:p-10 text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-6">
        <div>
            <span class="text-xs font-black uppercase tracking-wider bg-black/20 px-3 py-1 rounded-full backdrop-blur-md inline-block mb-2">Have a Doctor's Prescription?</span>
            <h3 class="text-2xl sm:text-3xl font-black">Upload Prescription & Get a Free Callback</h3>
            <p class="text-white/90 text-xs sm:text-sm mt-1 max-w-xl">Our senior medical team will review your prescription, schedule your test, and provide maximum combo discounts.</p>
        </div>
        <div>
            <button type="button" onclick="openPrescriptionModal()" class="px-8 py-4 bg-white text-gray-900 hover:bg-gray-100 font-extrabold text-sm rounded-2xl shadow-xl hover:scale-105 transition active:scale-95 whitespace-nowrap">
                <i class="fas fa-upload mr-2 text-amber-600"></i> Upload Prescription
            </button>
        </div>
    </div>
</div>

<!-- Reusable Package Breakdown Modal -->
@include('frontend.partials.package-details-modal')

@php
    $packagesModalPayload = [];
    foreach ($packages as $p) {
        $packagesModalPayload[$p->id] = [
            'id' => $p->id,
            'name' => $p->name,
            'price' => $p->price,
            'description' => $p->description,
            'total_parameters' => $p->total_parameters_count,
            'grouped' => $p->getGroupedParameters(),
        ];
    }
@endphp
<script>
    window.PACKAGE_DETAILS_DATA = {!! json_encode($packagesModalPayload) !!};
</script>
@endsection
