@extends('frontend.layouts.app')

@section('title', 'Free Online Health Calculators & Risk Profilers | Av Wellcare Diagnostics')

@section('content')
<!-- Ambient Background Elements -->
<div class="fixed inset-0 z-[-1] pointer-events-none overflow-hidden bg-slate-50/60">
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-teal-200/30 rounded-full blur-3xl"></div>
    <div class="absolute top-96 -right-32 w-96 h-96 bg-emerald-200/20 rounded-full blur-3xl"></div>
</div>

<div class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-xs font-semibold text-gray-500 mb-6" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-teal-700 transition flex items-center gap-1.5">
            <i class="fas fa-home text-gray-400"></i>
            <span>Home</span>
        </a>
        <i class="fas fa-chevron-right text-[9px] text-gray-300"></i>
        <span class="text-teal-800 font-bold">Health Calculators</span>
    </nav>

    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-brand-dark via-teal-900 to-slate-900 rounded-3xl p-8 sm:p-12 text-white shadow-xl relative overflow-hidden mb-12">
        <div class="absolute top-0 right-0 w-96 h-96 bg-teal-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-brand-secondary/15 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 max-w-3xl">
            <span class="px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-teal-500/20 text-teal-300 border border-teal-500/30 inline-flex items-center gap-1.5 mb-4">
                <i class="fas fa-heart-pulse text-amber-400"></i> Self-Care & Preventive Health Suite
            </span>
            <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-white leading-tight mb-4">
                Smart Health Calculators & Risk Profilers
            </h1>
            <p class="text-gray-200 text-sm sm:text-base leading-relaxed mb-6 font-normal">
                Monitor your wellness biomarkers in seconds with our free, evidence-based diagnostic tools. Understand your risks early and explore physician-recommended laboratory tests to protect your long-term health.
            </p>

            <div class="flex flex-wrap items-center gap-4 text-xs text-teal-100 font-semibold">
                <div class="flex items-center gap-1.5 bg-white/10 px-3 py-1.5 rounded-xl backdrop-blur-sm border border-white/10">
                    <i class="fas fa-circle-check text-emerald-400"></i> 100% Free & Anonymous
                </div>
                <div class="flex items-center gap-1.5 bg-white/10 px-3 py-1.5 rounded-xl backdrop-blur-sm border border-white/10">
                    <i class="fas fa-brain text-teal-300"></i> Evidence-Based Algorithms
                </div>
                <div class="flex items-center gap-1.5 bg-white/10 px-3 py-1.5 rounded-xl backdrop-blur-sm border border-white/10">
                    <i class="fas fa-file-medical text-amber-300"></i> Actionable Lab Recommendations
                </div>
            </div>
        </div>
    </div>

    <!-- The 4 Main Tools Grid -->
    <div class="mb-14">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl font-black text-gray-900 tracking-tight">Interactive Assessment Tools</h2>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">Select a calculator below to start your personal health screening</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- 1. BMI Calculator -->
            <div class="bg-white rounded-3xl p-6 border border-blue-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between hover:-translate-y-1.5 group border-t-4 border-t-blue-500">
                <div>
                    <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl mb-5 group-hover:scale-110 transition-transform">
                        <i class="fas fa-weight-scale"></i>
                    </div>
                    <span class="text-[10px] font-extrabold uppercase tracking-wider text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full border border-blue-200 inline-block mb-3">Instant Metric</span>
                    <h3 class="text-lg font-extrabold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">
                        Body Mass Index (BMI)
                    </h3>
                    <p class="text-xs text-gray-600 leading-relaxed mb-4">
                        Calculate your body mass index instantly using metric or imperial units. Includes Asian-Indian specific criteria, ideal weight targets, and daily caloric metrics.
                    </p>

                    <ul class="text-[11px] text-gray-500 space-y-1.5 mb-6">
                        <li class="flex items-center gap-1.5"><i class="fas fa-check text-blue-500 text-[10px]"></i> Asian-Indian & WHO BMI tiers</li>
                        <li class="flex items-center gap-1.5"><i class="fas fa-check text-blue-500 text-[10px]"></i> Ideal healthy weight target range</li>
                        <li class="flex items-center gap-1.5"><i class="fas fa-check text-blue-500 text-[10px]"></i> Metabolic syndrome biomarker guide</li>
                    </ul>
                </div>

                <a href="{{ route('calculators.bmi') }}" class="w-full py-2.5 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-md shadow-blue-500/20 transition flex items-center justify-center gap-2">
                    <span>Calculate BMI Now</span>
                    <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>

            <!-- 2. Cardiovascular Risk -->
            <div class="bg-white rounded-3xl p-6 border border-rose-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between hover:-translate-y-1.5 group border-t-4 border-t-rose-500">
                <div>
                    <div class="w-16 h-16 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-2xl mb-5 group-hover:scale-110 transition-transform">
                        <i class="fas fa-heart-pulse"></i>
                    </div>
                    <span class="text-[10px] font-extrabold uppercase tracking-wider text-rose-600 bg-rose-50 px-2.5 py-1 rounded-full border border-rose-200 inline-block mb-3">Heart Health</span>
                    <h3 class="text-lg font-extrabold text-gray-900 mb-2 group-hover:text-rose-600 transition-colors">
                        Cardiovascular Risk
                    </h3>
                    <p class="text-xs text-gray-600 leading-relaxed mb-4">
                        Evaluate your 10-year heart disease risk and estimate your physiological "Heart Age" through blood pressure, lipid profile, and lifestyle markers.
                    </p>

                    <ul class="text-[11px] text-gray-500 space-y-1.5 mb-6">
                        <li class="flex items-center gap-1.5"><i class="fas fa-check text-rose-500 text-[10px]"></i> 10-Year cardiac risk tier estimation</li>
                        <li class="flex items-center gap-1.5"><i class="fas fa-check text-rose-500 text-[10px]"></i> Chronological vs Heart Age score</li>
                        <li class="flex items-center gap-1.5"><i class="fas fa-check text-rose-500 text-[10px]"></i> Lipid & hs-CRP screening tests</li>
                    </ul>
                </div>

                <a href="{{ route('calculators.cardiovascular') }}" class="w-full py-2.5 px-4 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs shadow-md shadow-rose-500/20 transition flex items-center justify-center gap-2">
                    <span>Check Heart Health</span>
                    <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>

            <!-- 3. Diabetes Risk Profiler -->
            <div class="bg-white rounded-3xl p-6 border border-teal-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between hover:-translate-y-1.5 group border-t-4 border-t-teal-600">
                <div>
                    <div class="w-16 h-16 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center text-2xl mb-5 group-hover:scale-110 transition-transform">
                        <i class="fas fa-droplet"></i>
                    </div>
                    <span class="text-[10px] font-extrabold uppercase tracking-wider text-teal-700 bg-teal-50 px-2.5 py-1 rounded-full border border-teal-200 inline-block mb-3">Pre-Diabetes Alert</span>
                    <h3 class="text-lg font-extrabold text-gray-900 mb-2 group-hover:text-teal-700 transition-colors">
                        Diabetes Risk Profiler
                    </h3>
                    <p class="text-xs text-gray-600 leading-relaxed mb-4">
                        Discover your likelihood of pre-diabetes and Type 2 diabetes with clinical criteria based on the Indian Diabetes Risk Score (IDRS) and symptoms.
                    </p>

                    <ul class="text-[11px] text-gray-500 space-y-1.5 mb-6">
                        <li class="flex items-center gap-1.5"><i class="fas fa-check text-teal-600 text-[10px]"></i> Validated IDRS risk point score</li>
                        <li class="flex items-center gap-1.5"><i class="fas fa-check text-teal-600 text-[10px]"></i> Early pre-diabetes warning indicators</li>
                        <li class="flex items-center gap-1.5"><i class="fas fa-check text-teal-600 text-[10px]"></i> HbA1c & Fasting Glucose booking</li>
                    </ul>
                </div>

                <a href="{{ route('calculators.diabetes') }}" class="w-full py-2.5 px-4 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-bold text-xs shadow-md shadow-teal-600/20 transition flex items-center justify-center gap-2">
                    <span>Evaluate Diabetes Risk</span>
                    <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>

            <!-- 4. Vitamin Deficiency -->
            <div class="bg-white rounded-3xl p-6 border border-amber-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between hover:-translate-y-1.5 group border-t-4 border-t-amber-500">
                <div>
                    <div class="w-16 h-16 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl mb-5 group-hover:scale-110 transition-transform">
                        <i class="fas fa-sun"></i>
                    </div>
                    <span class="text-[10px] font-extrabold uppercase tracking-wider text-amber-700 bg-amber-50 px-2.5 py-1 rounded-full border border-amber-200 inline-block mb-3">Vitamins D & B12</span>
                    <h3 class="text-lg font-extrabold text-gray-900 mb-2 group-hover:text-amber-600 transition-colors">
                        Vitamin Deficiency
                    </h3>
                    <p class="text-xs text-gray-600 leading-relaxed mb-4">
                        Identify clinical symptoms of Vitamin D3 and B12 deficiency (fatigue, bone ache, neuropathy) influenced by sunlight and dietary habits.
                    </p>

                    <ul class="text-[11px] text-gray-500 space-y-1.5 mb-6">
                        <li class="flex items-center gap-1.5"><i class="fas fa-check text-amber-500 text-[10px]"></i> Dual Vitamin D3 & B12 rating</li>
                        <li class="flex items-center gap-1.5"><i class="fas fa-check text-amber-500 text-[10px]"></i> Vegetarian & vegan specific risk markers</li>
                        <li class="flex items-center gap-1.5"><i class="fas fa-check text-amber-500 text-[10px]"></i> Direct 25-OH Vitamin D test booking</li>
                    </ul>
                </div>

                <a href="{{ route('calculators.vitamin') }}" class="w-full py-2.5 px-4 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-900 font-extrabold text-xs shadow-md shadow-amber-500/20 transition flex items-center justify-center gap-2">
                    <span>Start Assessment</span>
                    <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Educational Banner: Online Screen vs Lab Diagnosis -->
    <div class="bg-gradient-to-r from-teal-50 via-emerald-50 to-cyan-50 border border-teal-200/80 rounded-3xl p-6 sm:p-8 mb-14">
        <div class="flex flex-col md:flex-row items-center gap-6">
            <div class="w-16 h-16 rounded-2xl bg-teal-600 text-white flex items-center justify-center text-2xl flex-shrink-0 shadow-md shadow-teal-600/20">
                <i class="fas fa-microscope"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-extrabold text-teal-950 mb-1">
                    Why Blood Tests are the Gold Standard
                </h3>
                <p class="text-xs sm:text-sm text-teal-900/80 leading-relaxed">
                    Online health calculators provide valuable risk screening, but only certified laboratory blood tests give definitive biochemical metrics. A silent lipid spike, early pre-diabetes, or Vitamin D depletion often show zero external symptoms until verified by a test.
                </p>
            </div>
            <div class="flex-shrink-0">
                <a href="#featured-packages" class="px-5 py-3 rounded-xl bg-teal-700 hover:bg-teal-800 text-white font-bold text-xs transition shadow-md inline-flex items-center gap-2">
                    <span>Explore Health Packages</span>
                    <i class="fas fa-chevron-down text-xs"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Recommended Health Packages -->
    <div id="featured-packages" class="mb-14 scroll-mt-24">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl font-black text-gray-900 tracking-tight">Physician-Curated Preventive Health Panels</h2>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">Comprehensive checkups designed to screen all key organ biomarkers in one visit</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($featuredPackages as $pkg)
            @php
                $mrp = round($pkg->price * 1.45);
                $discountPct = round((($mrp - $pkg->price) / $mrp) * 100);
            @endphp
            <div class="bg-white rounded-3xl p-6 border border-gray-100 hover:border-teal-300 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                <div>
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-[10px] font-bold text-teal-800 bg-teal-50 px-2.5 py-1 rounded-full uppercase border border-teal-100">
                            {{ $pkg->subcategory ?? 'Full Body' }}
                        </span>
                        <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100">
                            {{ $discountPct }}% OFF
                        </span>
                    </div>

                    <h4 class="font-extrabold text-gray-900 text-base leading-snug mb-2 group-hover:text-teal-700 transition-colors line-clamp-2">
                        <a href="{{ route('package.show', $pkg->id) }}" class="hover:underline">{{ $pkg->name }}</a>
                    </h4>

                    <div class="bg-slate-50 rounded-2xl p-3 flex items-center justify-between mb-4 border border-slate-100">
                        <div class="text-center w-full">
                            <p class="text-[10px] text-gray-400 uppercase font-semibold">Reports In</p>
                            <p class="text-xs font-bold text-gray-800">10-12 hrs</p>
                        </div>
                        <div class="w-px h-6 bg-gray-200 mx-2"></div>
                        <div class="text-center w-full">
                            <p class="text-[10px] text-gray-400 uppercase font-semibold">Biomarkers</p>
                            <p class="text-xs font-black text-teal-700">{{ $pkg->total_parameters_count }} Tests</p>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-4 mt-auto">
                    <div class="flex items-baseline gap-2 mb-3">
                        <span class="text-2xl font-black text-gray-900 tracking-tight">₹{{ number_format($pkg->price) }}</span>
                        <span class="text-xs text-gray-400 line-through">₹{{ number_format($mrp) }}</span>
                    </div>

                    <button type="button" 
                        onclick="addToCart(this)" 
                        data-id="{{ $pkg->id }}"
                        data-type="package"
                        data-name="{{ $pkg->name }}"
                        data-price="{{ $pkg->price }}" 
                        data-mrp="{{ $mrp }}" 
                        data-params="Includes {{ $pkg->total_parameters_count }} Parameters"
                        class="w-full bg-brand-secondary hover:bg-yellow-500 text-brand-dark font-extrabold py-2.5 rounded-xl transition-all duration-200 flex items-center justify-center gap-2 shadow-sm text-xs active:scale-98 cursor-pointer">
                        <i class="fas fa-cart-plus"></i> Add to Cart
                    </button>
                </div>
            </div>
            @empty
            @endforelse
        </div>
    </div>
</div>
@endsection
