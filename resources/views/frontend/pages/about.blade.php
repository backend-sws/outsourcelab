@extends('frontend.layouts.app')

@section('title', 'About Us - Adding Healthy Years to Lives | Av Wellcare Diagnostics')

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
        <span class="text-teal-800 font-bold">About Us</span>
    </nav>

    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-brand-dark via-teal-950 to-slate-900 rounded-3xl p-8 sm:p-14 text-white shadow-2xl relative overflow-hidden mb-12">
        <div class="absolute top-0 right-0 w-96 h-96 bg-teal-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-brand-secondary/15 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 max-w-3xl">
            <span class="px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-teal-500/20 text-teal-300 border border-teal-500/30 inline-flex items-center gap-1.5 mb-4">
                <i class="fas fa-shield-heart text-amber-400"></i> Clinical Excellence & Purpose
            </span>
            <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-white leading-tight mb-5">
                Redefining Diagnostics, Adding Healthy Years to Lives
            </h1>
            <p class="text-gray-200 text-sm sm:text-base leading-relaxed mb-6 font-normal">
                Av Wellcare Diagnostics is an impact-driven, technology-forward diagnostic network founded on a single conviction: healthcare outcomes improve exponentially when chronic illnesses are intercepted early through precise, accessible, and affordable biomarker screening.
            </p>

            <div class="flex flex-wrap gap-4 text-xs font-semibold">
                <div class="px-3.5 py-2 rounded-xl bg-white/10 border border-white/10 flex items-center gap-2 text-teal-100">
                    <i class="fas fa-certificate text-amber-400"></i> NABL Aligned Protocol
                </div>
                <div class="px-3.5 py-2 rounded-xl bg-white/10 border border-white/10 flex items-center gap-2 text-teal-100">
                    <i class="fas fa-robot text-teal-300"></i> AI-Assisted Clinical QC
                </div>
                <div class="px-3.5 py-2 rounded-xl bg-white/10 border border-white/10 flex items-center gap-2 text-teal-100">
                    <i class="fas fa-temperature-arrow-down text-cyan-300"></i> Strict Cold-Chain Logistics
                </div>
            </div>
        </div>
    </div>

    <!-- Impact & Footprint Counter Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 mb-16">
        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm text-center">
            <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-700 mx-auto flex items-center justify-center text-xl mb-3">
                <i class="fas fa-users"></i>
            </div>
            <div class="text-3xl font-black text-gray-900 font-mono mb-1">1 Crore+</div>
            <p class="text-xs text-gray-500 uppercase font-semibold tracking-wider">Patients Served</p>
        </div>

        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm text-center">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-700 mx-auto flex items-center justify-center text-xl mb-3">
                <i class="fas fa-flask"></i>
            </div>
            <div class="text-3xl font-black text-gray-900 font-mono mb-1">3,600+</div>
            <p class="text-xs text-gray-500 uppercase font-semibold tracking-wider">Clinical Tests Offered</p>
        </div>

        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm text-center">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-700 mx-auto flex items-center justify-center text-xl mb-3">
                <i class="fas fa-map-location-dot"></i>
            </div>
            <div class="text-3xl font-black text-gray-900 font-mono mb-1">220+</div>
            <p class="text-xs text-gray-500 uppercase font-semibold tracking-wider">Cities Covered</p>
        </div>

        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm text-center">
            <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-700 mx-auto flex items-center justify-center text-xl mb-3">
                <i class="fas fa-truck-medical"></i>
            </div>
            <div class="text-3xl font-black text-gray-900 font-mono mb-1">2,000+</div>
            <p class="text-xs text-gray-500 uppercase font-semibold tracking-wider">Collection Points</p>
        </div>
    </div>

    <!-- Core Philosophy: Preventive-First Approach -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-16">
        <div>
            <span class="text-xs font-extrabold uppercase tracking-wider text-teal-700 bg-teal-50 px-3 py-1 rounded-full border border-teal-200 inline-block mb-3">Our Core Philosophy</span>
            <h2 class="text-2xl sm:text-4xl font-black text-gray-900 tracking-tight leading-tight mb-4">
                Healthcare Must Shift From Reactive Sick-Care to Proactive Wellness
            </h2>
            <p class="text-sm text-gray-600 leading-relaxed mb-4">
                Lifestyle-related diseases like diabetes, hypertension, dyslipidemia, and non-alcoholic fatty liver disease (NAFLD) develop silently over 5 to 10 years before overt symptoms appear. Standard healthcare often catches them only when organ damage has already begun.
            </p>
            <p class="text-sm text-gray-600 leading-relaxed mb-6">
                At Av Wellcare Diagnostics, our full-body screening panels analyze systemic inflammation (hs-CRP), insulin resistance (HbA1c), lipid fractionation, and hormone levels to alert you years ahead of clinical onset.
            </p>

            <div class="space-y-3 text-xs text-gray-700 font-semibold">
                <div class="flex items-center gap-2.5">
                    <i class="fas fa-check-circle text-teal-600 text-sm"></i>
                    <span>Trained, background-verified phlebotomists for painless home sample collection</span>
                </div>
                <div class="flex items-center gap-2.5">
                    <i class="fas fa-check-circle text-teal-600 text-sm"></i>
                    <span>Zero-compromise sample temperature loggers from home to laboratory centrifuge</span>
                </div>
                <div class="flex items-center gap-2.5">
                    <i class="fas fa-check-circle text-teal-600 text-sm"></i>
                    <span>Smart digital PDF reports delivered directly on WhatsApp within 10 to 12 hours</span>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-teal-50 to-slate-100 rounded-3xl p-8 border border-teal-100 shadow-sm">
            <h3 class="text-lg font-extrabold text-gray-900 mb-6">Our 4 Pillars of Laboratory Quality</h3>
            <div class="space-y-5">
                <div class="flex gap-4">
                    <div class="w-10 h-10 rounded-xl bg-teal-600 text-white flex items-center justify-center flex-shrink-0 text-sm font-bold">1</div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm">Robotic Analyzers</h4>
                        <p class="text-xs text-gray-600 mt-0.5">Fully automated immunoassay & chemistry analyzers minimize human touchpoint variability.</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="w-10 h-10 rounded-xl bg-teal-600 text-white flex items-center justify-center flex-shrink-0 text-sm font-bold">2</div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm">Cold-Chain Assurance</h4>
                        <p class="text-xs text-gray-600 mt-0.5">Samples stored in temperature-regulated ice-gel containers prevent analyte degradation.</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="w-10 h-10 rounded-xl bg-teal-600 text-white flex items-center justify-center flex-shrink-0 text-sm font-bold">3</div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm">Two-Tier Pathologist Validation</h4>
                        <p class="text-xs text-gray-600 mt-0.5">Every abnormal biomarker triggers an automatic delta check and second senior review.</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="w-10 h-10 rounded-xl bg-teal-600 text-white flex items-center justify-center flex-shrink-0 text-sm font-bold">4</div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm">Patient-First Pricing</h4>
                        <p class="text-xs text-gray-600 mt-0.5">Direct-to-consumer digital infrastructure passes cost savings directly to families.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recommended Preventive Packages -->
    @if(isset($featuredPackages) && $featuredPackages->count() > 0)
    <div class="mb-14">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl font-black text-gray-900 tracking-tight">Popular Health Packages</h2>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">Screen your health comprehensively with free home collection</p>
            </div>
            <a href="{{ route('home') }}" class="text-xs font-bold text-teal-700 hover:text-teal-900 inline-flex items-center gap-1">
                <span>View Full Catalogue</span> <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($featuredPackages as $pkg)
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

                    <h4 class="font-extrabold text-gray-900 text-base leading-snug mb-2 group-hover:text-teal-700 transition-colors">
                        <a href="{{ route('package.show', $pkg->id) }}" class="hover:underline">{{ $pkg->name }}</a>
                    </h4>
                    <p class="text-xs text-gray-500 mb-4 line-clamp-2">{{ $pkg->description }}</p>
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
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
