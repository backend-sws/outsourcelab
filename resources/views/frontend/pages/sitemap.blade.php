@extends('frontend.layouts.app')

@section('title', 'Website Directory & HTML Sitemap | Av Wellcare Diagnostics')

@section('content')
<!-- Ambient Background Elements -->
<div class="fixed inset-0 z-[-1] pointer-events-none overflow-hidden bg-slate-50/60">
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-teal-200/30 rounded-full blur-3xl"></div>
    <div class="absolute top-96 -right-32 w-96 h-96 bg-blue-200/20 rounded-full blur-3xl"></div>
</div>

<div class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-xs font-semibold text-gray-500 mb-6" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-teal-700 transition flex items-center gap-1.5">
            <i class="fas fa-home text-gray-400"></i>
            <span>Home</span>
        </a>
        <i class="fas fa-chevron-right text-[9px] text-gray-300"></i>
        <span class="text-teal-800 font-bold">HTML Sitemap</span>
    </nav>

    <!-- Header Section -->
    <div class="bg-gradient-to-br from-brand-dark via-teal-950 to-slate-900 rounded-3xl p-8 sm:p-12 text-white shadow-2xl relative overflow-hidden mb-12">
        <div class="absolute top-0 right-0 w-80 h-80 bg-teal-500/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 max-w-3xl">
            <span class="px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-teal-500/20 text-teal-300 border border-teal-500/30 inline-flex items-center gap-1.5 mb-4">
                <i class="fas fa-sitemap text-amber-400"></i> Complete Portal Navigation
            </span>
            <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-white leading-tight mb-4">
                Av Wellcare Website Directory & Sitemap
            </h1>
            <p class="text-gray-200 text-xs sm:text-sm leading-relaxed mb-6 font-normal">
                Easily navigate through our extensive directory of clinical pathology tests, full body preventive packages, interactive health risk calculators, corporate information, and regulatory pages.
            </p>

            <div class="flex flex-wrap items-center gap-3 text-xs">
                <a href="{{ route('sitemap.xml') }}" target="_blank" class="px-4 py-2 bg-teal-500/30 hover:bg-teal-500/50 border border-teal-400/40 text-teal-200 font-bold rounded-xl transition inline-flex items-center gap-2">
                    <i class="fas fa-code text-amber-400"></i> View Dynamic XML Sitemap (Search Engines)
                </a>
            </div>
        </div>
    </div>

    <!-- Sitemap Sections Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">

        <!-- 1. Corporate & Core Pages -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center text-lg">
                    <i class="fas fa-building"></i>
                </div>
                <div>
                    <h2 class="text-base font-black text-gray-900">Corporate & Services</h2>
                    <span class="text-[10px] text-gray-400 font-bold uppercase">Main Portals</span>
                </div>
            </div>

            <ul class="space-y-2.5 text-xs text-gray-700">
                <li>
                    <a href="{{ route('home') }}" class="hover:text-teal-700 font-semibold flex items-center gap-2 transition">
                        <i class="fas fa-chevron-right text-[9px] text-teal-600"></i> Home / Main Hub
                    </a>
                </li>
                <li>
                    <a href="{{ route('about') }}" class="hover:text-teal-700 font-semibold flex items-center gap-2 transition">
                        <i class="fas fa-chevron-right text-[9px] text-teal-600"></i> About Us (Mission, Impact & Quality)
                    </a>
                </li>
                <li>
                    <a href="{{ route('labs') }}" class="hover:text-teal-700 font-semibold flex items-center gap-2 transition">
                        <i class="fas fa-chevron-right text-[9px] text-teal-600"></i> Our Labs & Pincode Network
                    </a>
                </li>
                <li>
                    <a href="{{ route('partner') }}" class="hover:text-teal-700 font-semibold flex items-center gap-2 transition">
                        <i class="fas fa-chevron-right text-[9px] text-teal-600"></i> Partner With Us (Doctors, Corporates, Hospitals)
                    </a>
                </li>
                <li>
                    <a href="{{ route('franchise') }}" class="hover:text-teal-700 font-semibold flex items-center gap-2 transition">
                        <i class="fas fa-chevron-right text-[9px] text-teal-600"></i> Franchise Opportunity (Collection Centre)
                    </a>
                </li>
                <li>
                    <a href="{{ route('careers') }}" class="hover:text-teal-700 font-semibold flex items-center gap-2 transition">
                        <i class="fas fa-chevron-right text-[9px] text-teal-600"></i> Careers & Job Openings
                    </a>
                </li>
                <li>
                    <a href="{{ route('membership') }}" class="hover:text-teal-700 font-semibold flex items-center gap-2 transition">
                        <i class="fas fa-chevron-right text-[9px] text-teal-600"></i> Care+ Family Membership Plans
                    </a>
                </li>
                <li>
                    <a href="{{ route('faqs') }}" class="hover:text-teal-700 font-semibold flex items-center gap-2 transition">
                        <i class="fas fa-chevron-right text-[9px] text-teal-600"></i> Frequently Asked Questions (FAQs)
                    </a>
                </li>
                <li>
                    <a href="{{ route('download.report') }}" class="hover:text-teal-700 font-semibold flex items-center gap-2 transition">
                        <i class="fas fa-chevron-right text-[9px] text-teal-600"></i> Download Patient Report
                    </a>
                </li>
                <li>
                    <a href="{{ route('agent.login') }}" class="text-teal-700 hover:text-teal-900 font-bold flex items-center gap-2 transition">
                        <i class="fas fa-motorcycle text-[9px]"></i> Phlebotomist / Agent Portal
                    </a>
                </li>
                <li>
                    <a href="{{ route('lis.login') }}" class="hover:text-teal-700 font-semibold flex items-center gap-2 transition">
                        <i class="fas fa-microchip text-[9px] text-teal-600"></i> Laboratory LIS Access Portal
                    </a>
                </li>
            </ul>
        </div>

        <!-- 2. Health Calculators Suite -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center text-lg">
                    <i class="fas fa-calculator"></i>
                </div>
                <div>
                    <h2 class="text-base font-black text-gray-900">Health Calculators</h2>
                    <span class="text-[10px] text-gray-400 font-bold uppercase">Self-Assessment Suite</span>
                </div>
            </div>

            <ul class="space-y-2.5 text-xs text-gray-700">
                <li>
                    <a href="{{ route('calculators.index') }}" class="hover:text-teal-700 font-semibold flex items-center gap-2 transition">
                        <i class="fas fa-chevron-right text-[9px] text-purple-600"></i> Health Calculators Overview
                    </a>
                </li>
                <li>
                    <a href="{{ route('calculators.bmi') }}" class="hover:text-teal-700 font-semibold flex items-center gap-2 transition">
                        <i class="fas fa-chevron-right text-[9px] text-purple-600"></i> BMI & Healthy Weight Calculator
                    </a>
                </li>
                <li>
                    <a href="{{ route('calculators.cardiovascular') }}" class="hover:text-teal-700 font-semibold flex items-center gap-2 transition">
                        <i class="fas fa-chevron-right text-[9px] text-purple-600"></i> Cardiovascular 10-Year Heart Risk Calculator
                    </a>
                </li>
                <li>
                    <a href="{{ route('calculators.diabetes') }}" class="hover:text-teal-700 font-semibold flex items-center gap-2 transition">
                        <i class="fas fa-chevron-right text-[9px] text-purple-600"></i> Type 2 Diabetes Risk Screener (IDRS)
                    </a>
                </li>
                <li>
                    <a href="{{ route('calculators.vitamin') }}" class="hover:text-teal-700 font-semibold flex items-center gap-2 transition">
                        <i class="fas fa-chevron-right text-[9px] text-purple-600"></i> Vitamin D & B12 Deficiency Screener
                    </a>
                </li>
            </ul>

            <div class="mt-8 pt-6 border-t border-gray-100">
                <h3 class="text-xs font-black text-gray-900 mb-3 flex items-center gap-2">
                    <i class="fas fa-scale-balanced text-teal-700"></i> Statutory & Legal Policies
                </h3>
                <ul class="space-y-2 text-xs text-gray-600">
                    <li>
                        <a href="{{ route('compliance') }}" class="hover:text-teal-700 font-semibold flex items-center gap-2 transition">
                            <i class="fas fa-chevron-right text-[9px] text-gray-400"></i> Statutory Compliance (BMWM, AERB, PCPNDT)
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('privacy') }}" class="hover:text-teal-700 font-semibold flex items-center gap-2 transition">
                            <i class="fas fa-chevron-right text-[9px] text-gray-400"></i> Privacy Policy (DPDP Act 2023)
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('terms') }}" class="hover:text-teal-700 font-semibold flex items-center gap-2 transition">
                            <i class="fas fa-chevron-right text-[9px] text-gray-400"></i> Terms & Conditions of Service
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- 3. Health Categories -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center text-lg">
                    <i class="fas fa-stethoscope"></i>
                </div>
                <div>
                    <h2 class="text-base font-black text-gray-900">Checkup Categories</h2>
                    <span class="text-[10px] text-gray-400 font-bold uppercase">Organ & Disease Panels</span>
                </div>
            </div>

            <ul class="space-y-2.5 text-xs text-gray-700 max-h-96 overflow-y-auto pr-2">
                @forelse($categories as $category)
                    <li>
                        <a href="{{ route('category.show', $category->id) }}" class="hover:text-teal-700 font-semibold flex items-center justify-between transition group">
                            <span class="flex items-center gap-2">
                                <i class="fas fa-folder text-[9px] text-blue-500 group-hover:text-teal-600"></i>
                                {{ $category->name }}
                            </span>
                            <span class="text-[10px] text-gray-400">View &rarr;</span>
                        </a>
                    </li>
                @empty
                    <li class="text-xs text-gray-400">Categories available on home page.</li>
                @endforelse
            </ul>
        </div>
    </div>

    <!-- Packages Directory -->
    <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm mb-12">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-lg font-black text-gray-900 flex items-center gap-2">
                    <i class="fas fa-box-tissue text-amber-500"></i> Full-Body Preventive Health Checkup Packages
                </h2>
                <p class="text-xs text-gray-500 mt-1">Multi-parameter preventive screening panels with home sample collection</p>
            </div>
            <span class="text-xs font-bold px-3 py-1 bg-amber-50 text-amber-800 rounded-full border border-amber-200">
                {{ $packages->count() }} Packages
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($packages as $pkg)
                <a href="{{ route('package.show', $pkg->id) }}" class="p-4 rounded-2xl bg-gray-50 hover:bg-teal-50 border border-gray-100 hover:border-teal-200 transition group flex flex-col justify-between">
                    <div>
                        <strong class="text-xs font-bold text-gray-900 group-hover:text-teal-800 block mb-1">
                            {{ $pkg->name }}
                        </strong>
                        <span class="text-[10px] text-gray-500">{{ Str::limit($pkg->description ?? 'Comprehensive screening test profile', 60) }}</span>
                    </div>
                    <div class="mt-3 flex items-center justify-between pt-2 border-t border-gray-200/60 text-xs">
                        <span class="font-bold text-teal-800 font-mono">₹{{ number_format($pkg->price, 0) }}</span>
                        <span class="text-[10px] text-teal-600 font-bold group-hover:underline">View Details &rarr;</span>
                    </div>
                </a>
            @empty
                <p class="text-xs text-gray-500 col-span-3">All preventive packages are listed on the main booking catalogue.</p>
            @endforelse
        </div>
    </div>

    <!-- Individual Clinical Tests Directory -->
    <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm mb-16">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-lg font-black text-gray-900 flex items-center gap-2">
                    <i class="fas fa-vial-virus text-teal-600"></i> Individual Diagnostic Blood Tests Menu
                </h2>
                <p class="text-xs text-gray-500 mt-1">Certified pathology investigations, metabolic profiles, and hormonal assays</p>
            </div>
            <span class="text-xs font-bold px-3 py-1 bg-teal-50 text-teal-800 rounded-full border border-teal-200">
                {{ $tests->count() }} Clinical Tests
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
            @forelse($tests as $test)
                <a href="{{ route('test.show', $test->id) }}" class="p-3 rounded-xl bg-gray-50 hover:bg-teal-50 border border-gray-100 hover:border-teal-200 transition group flex items-center justify-between">
                    <span class="text-xs font-semibold text-gray-800 group-hover:text-teal-900 truncate mr-2" title="{{ $test->name }}">
                        {{ $test->name }}
                    </span>
                    <span class="text-xs font-bold text-teal-700 font-mono flex-shrink-0">
                        ₹{{ number_format($test->price, 0) }}
                    </span>
                </a>
            @empty
                <p class="text-xs text-gray-500 col-span-4">Complete test menu accessible through search bar.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
