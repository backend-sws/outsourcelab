@extends('frontend.layouts.app')
@section('content')
    <!-- Global Glassy Blurred Background -->
    <div class="fixed inset-0 z-[-1] pointer-events-none overflow-hidden bg-slate-50/30 backdrop-blur-3xl">
        <!-- Soft animated color blobs -->
        <div class="absolute -top-[20%] -left-[10%] w-[60vw] h-[60vw] bg-teal-200/20 rounded-full mix-blend-multiply filter blur-[100px] animate-[pulse_8s_ease-in-out_infinite]"></div>
        <div class="absolute top-[20%] -right-[10%] w-[50vw] h-[50vw] bg-yellow-200/20 rounded-full mix-blend-multiply filter blur-[120px] animate-[pulse_10s_ease-in-out_infinite_2s]"></div>
        <div class="absolute -bottom-[20%] left-[20%] w-[70vw] h-[70vw] bg-red-200/10 rounded-full mix-blend-multiply filter blur-[150px] animate-[pulse_12s_ease-in-out_infinite_4s]"></div>
    </div>

    @include('frontend.partials.hero')

<!-- Routine Health Checkups -->
@php
    $subcategoryFallbackImages = [
        'Basic Preventive Screening' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=800&q=80',
        'Advanced Full Body Checkup' => 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=800&q=80',
        'Executive Platinum Comprehensive' => 'https://images.unsplash.com/photo-1505751172876-fa1923c5c528?auto=format&fit=crop&w=800&q=80',
        'Men Under 40 Vitality' => 'https://images.unsplash.com/photo-1517838277536-f5f99be501cd?auto=format&fit=crop&w=800&q=80',
        'Men 40+ Senior Health' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=800&q=80',
        'Executive Working Men' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=800&q=80',
        'PCOS & PCOD Care' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=800&q=80',
        'Antenatal & Pregnancy Screening' => 'https://images.unsplash.com/photo-1584515979956-d9f6e5d09982?auto=format&fit=crop&w=800&q=80',
        'Hormonal Wellness & Vitality' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=800&q=80',
        'Women 40+ Menopause Profile' => 'https://images.unsplash.com/photo-1581579438747-1dc8d17bbce4?auto=format&fit=crop&w=800&q=80',
        'Joint & Bone Health' => 'https://images.unsplash.com/photo-1582750433449-648ed127bb54?auto=format&fit=crop&w=800&q=80',
        'Cardiac & Diabetes Screen' => 'https://images.unsplash.com/photo-1628348068343-c6a848d2b6dd?auto=format&fit=crop&w=800&q=80',
        'Elderly Vital Organ Check' => 'https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&w=800&q=80',
        'Smokers & High Pollution Shield' => 'https://images.unsplash.com/photo-1584036561566-baf8f5f1b144?auto=format&fit=crop&w=800&q=80',
        'Alcohol & Liver Wellness Screen' => 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=800&q=80',
        'Stress & Fatigue Profile' => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&fit=crop&w=800&q=80',
    ];
    $genericFallback = 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=800&q=80';
@endphp

<div class="container mx-auto px-4 py-8 flex flex-col gap-10">
    @foreach($categories as $category)
    @php
        $hasSubs = is_array($category->sub_category) && count($category->sub_category) > 0;
        $patternIndex = $loop->index % 3;
    @endphp
    @if($hasSubs)

        {{-- ========================================================= --}}
        {{-- PATTERN 0: PANORAMIC VISUAL SLIDER SHOWCASE (Light Modern) --}}
        {{-- ========================================================= --}}
        @if($patternIndex === 0)
        <div class="relative overflow-hidden rounded-[2.25rem] bg-white border border-slate-200/90 shadow-md shadow-slate-100/80 p-6 sm:p-8 transition-all">
            <!-- Ambient decorative background glows -->
            <div class="absolute -top-24 -right-24 w-80 h-80 bg-teal-50/70 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-indigo-50/50 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Section Header -->
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4 mb-7 pb-5 border-b border-slate-100">
                <div>
                    <div class="flex flex-wrap items-center gap-2 mb-2">
                        <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full bg-teal-50 border border-teal-200/70 text-teal-800 text-[11px] font-extrabold uppercase tracking-wider">
                            <i class="fas fa-stethoscope text-teal-600"></i> Doctor-Curated Panels
                        </span>
                        <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-slate-500">
                            <i class="fas fa-circle text-[5px] text-emerald-500"></i> Free Home Sample Pickup
                        </span>
                        <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-slate-500 hidden sm:inline-flex">
                            <i class="fas fa-circle text-[5px] text-cyan-500"></i> Same-Day Reports
                        </span>
                    </div>
                    <h3 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                        Routine health checkups for <span class="text-teal-800">{{ $category->name }}</span>
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1 font-medium max-w-2xl">
                        Certified clinical checkups and preventive pathology screening designed specifically for {{ strtolower($category->name) }}.
                    </p>
                </div>
                <div class="flex items-center gap-3 self-start md:self-auto">
                    <a href="{{ route('category.show', $category->id) }}" class="group inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-teal-800 hover:bg-teal-900 text-white text-xs font-bold shadow-md shadow-teal-900/10 hover:shadow-lg transition-all duration-200">
                        <span>View All</span>
                        <i class="fas fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>

            <!-- Relative wrapper for slider and buttons -->
            <div class="relative group/slider">
                <!-- Left Scroll Button -->
                <button type="button" onclick="document.getElementById('cat-slider-{{ $category->id }}').scrollBy({left: -380, behavior: 'smooth'})" 
                        class="absolute -left-3 sm:-left-5 top-1/2 -translate-y-1/2 z-20 w-11 h-11 rounded-full bg-white/95 backdrop-blur-md shadow-xl border border-slate-200/80 flex items-center justify-center text-slate-700 hover:text-teal-700 hover:scale-110 active:scale-95 transition-all opacity-0 group-hover/slider:opacity-100 focus:opacity-100 disabled:opacity-0 hidden md:flex"
                        aria-label="Previous">
                    <i class="fas fa-chevron-left text-sm"></i>
                </button>

                <!-- Cards Track -->
                <div id="cat-slider-{{ $category->id }}" class="flex space-x-6 overflow-x-auto pb-4 hide-scroll-bar scroll-smooth px-1 {{ count($category->sub_category) == 1 ? 'justify-center' : '' }} {{ count($category->sub_category) == 2 ? 'md:justify-center' : '' }} {{ count($category->sub_category) == 3 ? 'lg:justify-center' : '' }}">
                    @foreach($category->sub_category as $sub)
                        @php
                            $isObj = is_array($sub);
                            $name = $isObj ? ($sub['name'] ?? '') : $sub;
                            $rawImage = $isObj ? ($sub['image'] ?? null) : null;

                            if (!empty($rawImage)) {
                                $imageUrl = \Illuminate\Support\Str::startsWith($rawImage, ['http://', 'https://', '//'])
                                    ? $rawImage
                                    : \Illuminate\Support\Facades\Storage::url($rawImage);
                            } else {
                                $imageUrl = $subcategoryFallbackImages[$name] ?? $genericFallback;
                            }
                        @endphp
                        @if($name)
                        <a href="{{ route('category.show', ['id' => $category->id, 'subcategory' => $name]) }}" 
                           class="w-[290px] sm:w-[340px] flex-shrink-0 bg-white rounded-3xl border border-slate-200/90 shadow-sm hover:shadow-2xl hover:border-teal-500/40 hover:-translate-y-2 transition-all duration-300 overflow-hidden flex flex-col group block cursor-pointer">
                            
                            <!-- Top High-Res Hero Image Banner -->
                            <div class="relative h-44 sm:h-48 w-full overflow-hidden bg-slate-100">
                                <img src="{{ $imageUrl }}" 
                                     alt="{{ $name }}" 
                                     loading="lazy"
                                     class="w-full h-full object-cover object-center group-hover:scale-108 transition-transform duration-700 ease-out">
                                
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-black/20"></div>

                                <div class="absolute top-3 left-3 right-3 flex items-center justify-between">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-white/95 backdrop-blur-md text-slate-800 text-[10px] font-extrabold shadow-sm">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                        <span>NABL Lab</span>
                                    </span>
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-slate-900/80 backdrop-blur-md text-amber-300 text-[10px] font-bold border border-white/10">
                                        <i class="fas fa-bolt text-[9px]"></i> Fast Report
                                    </span>
                                </div>

                                <div class="absolute bottom-3 left-4 right-4 flex items-center justify-between text-white text-[11px] font-semibold">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-white/20 backdrop-blur-md border border-white/25 text-[10px] text-white">
                                        <i class="fas fa-house-medical text-teal-300"></i> Free Home Pickup
                                    </span>
                                    <span class="text-teal-200 font-bold flex items-center gap-1 text-[11px] drop-shadow-sm">
                                        <i class="fas fa-shield-check"></i> Doctor Verified
                                    </span>
                                </div>
                            </div>

                            <!-- Card Body Content -->
                            <div class="p-5 sm:p-6 flex flex-col flex-grow justify-between gap-4 bg-white">
                                <div>
                                    <h4 class="text-lg font-black text-slate-900 group-hover:text-teal-800 transition-colors tracking-tight line-clamp-1 mb-2">
                                        {{ $name }}
                                    </h4>

                                    <div class="space-y-1.5 text-xs text-slate-600 font-medium">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-check-circle text-teal-600 text-xs flex-shrink-0"></i>
                                            <span class="truncate">NABL / ISO accredited sample testing</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-file-medical text-teal-600 text-xs flex-shrink-0"></i>
                                            <span class="truncate">Digital PDF report on WhatsApp & email</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-user-doctor text-teal-600 text-xs flex-shrink-0"></i>
                                            <span class="truncate">Free doctor tele-consultation included</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-3.5 border-t border-slate-100 flex items-center justify-between mt-auto">
                                    <div>
                                        <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 block">Health Screening</span>
                                        <span class="text-xs font-bold text-teal-800 group-hover:text-teal-900 transition-colors">
                                            Explore Tests & Packages
                                        </span>
                                    </div>
                                    <div class="w-9 h-9 rounded-2xl bg-teal-50 group-hover:bg-teal-700 text-teal-700 group-hover:text-white flex items-center justify-center transition-all duration-300 shadow-sm">
                                        <i class="fas fa-arrow-right text-xs group-hover:translate-x-0.5 transition-transform"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endif
                    @endforeach
                </div>

                <!-- Right Scroll Button -->
                <button type="button" onclick="document.getElementById('cat-slider-{{ $category->id }}').scrollBy({left: 380, behavior: 'smooth'})" 
                        class="absolute -right-3 sm:-right-5 top-1/2 -translate-y-1/2 z-20 w-11 h-11 rounded-full bg-white/95 backdrop-blur-md shadow-xl border border-slate-200/80 flex items-center justify-center text-slate-700 hover:text-teal-700 hover:scale-110 active:scale-95 transition-all opacity-0 group-hover/slider:opacity-100 focus:opacity-100 disabled:opacity-0 hidden md:flex"
                        aria-label="Next">
                    <i class="fas fa-chevron-right text-sm"></i>
                </button>
            </div>
        </div>

        {{-- ========================================================= --}}
        {{-- PATTERN 1: ASYMMETRIC SPOTLIGHT HERO + SUB-CARDS GRID --}}
        {{-- ========================================================= --}}
        @elseif($patternIndex === 1)
        <div class="relative overflow-hidden rounded-[2.5rem] bg-gradient-to-br from-slate-900 via-teal-950 to-indigo-950 text-white p-6 sm:p-10 shadow-2xl transition-all">
            <!-- Ambient glows -->
            <div class="absolute -top-20 -right-20 w-96 h-96 bg-teal-500/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-20 -left-20 w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Top Header -->
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 pb-6 border-b border-white/10">
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-teal-400/20 text-teal-300 text-[11px] font-extrabold uppercase tracking-wider border border-teal-400/30 mb-2">
                        <i class="fas fa-bullseye"></i> Specialized Pathology Profiles
                    </span>
                    <h3 class="text-2xl sm:text-4xl font-black tracking-tight text-white">
                        Targeted Care for {{ $category->name }}
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-2xl font-medium">
                        Focused clinical panels with advanced biomarkers tailored for risk screening, organ wellness, and vitality.
                    </p>
                </div>
                <div class="flex items-center gap-3 self-start md:self-auto">
                    <a href="{{ route('category.show', $category->id) }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-white/10 hover:bg-white/20 text-white text-xs font-bold border border-white/20 backdrop-blur-md transition-all duration-200">
                        <span>View All {{ $category->name }}</span>
                        <i class="fas fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>

            <!-- Asymmetric Grid: Left Spotlight Feature Card, Right Subcategory Cards -->
            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
                <!-- Left Spotlight Card -->
                <div class="lg:col-span-4 flex flex-col justify-between p-6 sm:p-8 rounded-3xl bg-white/10 backdrop-blur-xl border border-white/15 shadow-xl">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-teal-400/20 border border-teal-400/30 text-teal-300 flex items-center justify-center text-xl mb-5 shadow-inner">
                            <i class="fas fa-microscope"></i>
                        </div>
                        <h4 class="text-xl sm:text-2xl font-black text-white mb-2 leading-tight">
                            Comprehensive {{ $category->name }} Shield
                        </h4>
                        <p class="text-xs sm:text-sm text-slate-300 font-normal leading-relaxed mb-6">
                            Every checkup is processed inside ISO/NABL accredited laboratories with barcoded collection and end-to-end cold chain integrity.
                        </p>

                        <div class="space-y-3 text-xs font-semibold text-slate-200">
                            <div class="flex items-center gap-3">
                                <div class="w-7 h-7 rounded-xl bg-teal-400/20 flex items-center justify-center text-teal-300 flex-shrink-0">
                                    <i class="fas fa-house-medical text-xs"></i>
                                </div>
                                <span>Painless Home Sample Collection</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-7 h-7 rounded-xl bg-amber-400/20 flex items-center justify-center text-amber-300 flex-shrink-0">
                                    <i class="fas fa-bolt text-xs"></i>
                                </div>
                                <span>Fast 10-12 Hour Digital WhatsApp Reports</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-7 h-7 rounded-xl bg-cyan-400/20 flex items-center justify-center text-cyan-300 flex-shrink-0">
                                    <i class="fas fa-user-doctor text-xs"></i>
                                </div>
                                <span>Complimentary Doctor Tele-Consultation</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 mt-6 border-t border-white/10">
                        <a href="{{ route('category.show', $category->id) }}" class="w-full py-3 px-5 rounded-2xl bg-white text-slate-950 hover:bg-teal-300 font-black text-xs transition-all shadow-lg flex items-center justify-center gap-2">
                            <span>Browse Complete Catalogue</span>
                            <i class="fas fa-arrow-right text-[11px]"></i>
                        </a>
                    </div>
                </div>

                <!-- Right Cards Grid -->
                <div class="lg:col-span-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($category->sub_category as $sub)
                        @php
                            $isObj = is_array($sub);
                            $name = $isObj ? ($sub['name'] ?? '') : $sub;
                            $rawImage = $isObj ? ($sub['image'] ?? null) : null;

                            if (!empty($rawImage)) {
                                $imageUrl = \Illuminate\Support\Str::startsWith($rawImage, ['http://', 'https://', '//'])
                                    ? $rawImage
                                    : \Illuminate\Support\Facades\Storage::url($rawImage);
                            } else {
                                $imageUrl = $subcategoryFallbackImages[$name] ?? $genericFallback;
                            }
                        @endphp
                        @if($name)
                        <a href="{{ route('category.show', ['id' => $category->id, 'subcategory' => $name]) }}" 
                           class="bg-white text-slate-900 rounded-3xl p-5 shadow-lg hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between group border border-white/20 relative overflow-hidden">
                            
                            <div>
                                <!-- Image Preview -->
                                <div class="relative h-36 w-full overflow-hidden rounded-2xl bg-slate-100 mb-4">
                                    <img src="{{ $imageUrl }}" 
                                         alt="{{ $name }}" 
                                         loading="lazy"
                                         class="w-full h-full object-cover object-center group-hover:scale-110 transition-transform duration-500">
                                    
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                                    
                                    <div class="absolute top-2.5 left-2.5">
                                        <span class="px-2 py-0.5 rounded-full bg-slate-900/80 backdrop-blur-md text-amber-300 text-[9px] font-extrabold border border-white/10 flex items-center gap-1">
                                            <i class="fas fa-bolt text-[8px]"></i> 12h Report
                                        </span>
                                    </div>

                                    <div class="absolute bottom-2.5 left-3 right-3 flex items-center justify-between text-white text-[10px] font-bold">
                                        <span><i class="fas fa-house-medical text-teal-300 mr-1"></i> Home Pickup</span>
                                        <span class="text-teal-200">Certified</span>
                                    </div>
                                </div>

                                <h5 class="text-base font-black text-slate-900 group-hover:text-teal-800 transition-colors line-clamp-1 mb-1.5">
                                    {{ $name }}
                                </h5>
                                
                                <p class="text-xs text-slate-500 font-medium leading-relaxed line-clamp-2">
                                    Doctor curated comprehensive organ and metabolic risk evaluation panel.
                                </p>
                            </div>

                            <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between">
                                <span class="text-xs font-bold text-teal-800 group-hover:text-teal-900">
                                    Explore Packages
                                </span>
                                <div class="w-8 h-8 rounded-xl bg-teal-50 group-hover:bg-teal-700 text-teal-700 group-hover:text-white flex items-center justify-center transition-all shadow-sm">
                                    <i class="fas fa-arrow-right text-xs group-hover:translate-x-0.5 transition-transform"></i>
                                </div>
                            </div>
                        </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ========================================================= --}}
        {{-- PATTERN 2: CLINICAL WELLNESS MULTI-COLUMN MATRIX GRID     --}}
        {{-- ========================================================= --}}
        @else
        <div class="relative overflow-hidden rounded-[2.25rem] bg-gradient-to-b from-teal-50/60 via-white to-slate-50/70 border border-teal-200/80 shadow-md shadow-teal-900/5 p-6 sm:p-8 transition-all">
            <!-- Ambient glows -->
            <div class="absolute -top-20 -right-20 w-80 h-80 bg-teal-100/50 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-cyan-100/40 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Section Header -->
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 pb-5 border-b border-teal-100">
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full bg-teal-100/80 text-teal-900 text-[11px] font-extrabold uppercase tracking-wider border border-teal-200 mb-2">
                        <i class="fas fa-heart-pulse text-teal-700"></i> Comprehensive Wellness Matrix
                    </span>
                    <h3 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                        Preventive Panels for <span class="text-teal-800">{{ $category->name }}</span>
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1 font-medium">
                        Multi-parameter clinical screening designed for early detection, cellular health, and overall wellness.
                    </p>
                </div>
                <div class="flex items-center gap-3 self-start md:self-auto">
                    <a href="{{ route('category.show', $category->id) }}" class="group inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-teal-800 hover:bg-teal-900 text-white text-xs font-bold shadow-md shadow-teal-900/10 hover:shadow-lg transition-all duration-200">
                        <span>View All {{ $category->name }}</span>
                        <i class="fas fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>

            <!-- Multi-Column Grid -->
            <div class="relative z-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6">
                @foreach($category->sub_category as $sub)
                    @php
                        $isObj = is_array($sub);
                        $name = $isObj ? ($sub['name'] ?? '') : $sub;
                        $rawImage = $isObj ? ($sub['image'] ?? null) : null;

                        if (!empty($rawImage)) {
                            $imageUrl = \Illuminate\Support\Str::startsWith($rawImage, ['http://', 'https://', '//'])
                                ? $rawImage
                                : \Illuminate\Support\Facades\Storage::url($rawImage);
                        } else {
                            $imageUrl = $subcategoryFallbackImages[$name] ?? $genericFallback;
                        }
                    @endphp
                    @if($name)
                    <a href="{{ route('category.show', ['id' => $category->id, 'subcategory' => $name]) }}" 
                       class="bg-white rounded-3xl border border-slate-200/90 shadow-sm hover:shadow-xl hover:border-teal-500/50 hover:-translate-y-2 transition-all duration-300 overflow-hidden flex flex-col group block cursor-pointer">
                        
                        <!-- Top Image Banner -->
                        <div class="relative h-44 w-full overflow-hidden bg-slate-100">
                            <img src="{{ $imageUrl }}" 
                                 alt="{{ $name }}" 
                                 loading="lazy"
                                 class="w-full h-full object-cover object-center group-hover:scale-108 transition-transform duration-700 ease-out">
                            
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-black/20"></div>

                            <div class="absolute top-3 left-3">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-white/95 backdrop-blur-md text-slate-800 text-[10px] font-extrabold shadow-sm">
                                    <i class="fas fa-shield-halved text-teal-600"></i>
                                    <span>Accredited</span>
                                </span>
                            </div>

                            <!-- Overlapping Floating Specialty Badge -->
                            <div class="w-10 h-10 rounded-2xl bg-white shadow-md border border-slate-100 text-teal-700 flex items-center justify-center text-sm absolute -bottom-5 left-4 group-hover:scale-110 group-hover:bg-teal-700 group-hover:text-white transition-all">
                                <i class="fas fa-dna"></i>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="pt-7 p-5 flex flex-col flex-grow justify-between gap-3 bg-white">
                            <div>
                                <h4 class="text-base font-black text-slate-900 group-hover:text-teal-800 transition-colors tracking-tight line-clamp-1 mb-2">
                                    {{ $name }}
                                </h4>

                                <div class="space-y-1.5 text-xs text-slate-500 font-medium">
                                    <div class="flex items-center gap-1.5">
                                        <i class="fas fa-check text-teal-600 text-[10px] flex-shrink-0"></i>
                                        <span class="truncate">Hormonal & vital organ profile</span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <i class="fas fa-house-medical text-teal-600 text-[10px] flex-shrink-0"></i>
                                        <span class="truncate">Free home sample collection</span>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-3 border-t border-slate-100 mt-2">
                                <div class="w-full py-2.5 px-3.5 rounded-xl bg-slate-50 group-hover:bg-teal-800 text-slate-700 group-hover:text-white text-xs font-bold transition-all flex items-center justify-between">
                                    <span>Explore Tests & Packages</span>
                                    <i class="fas fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endif
                @endforeach
            </div>
        </div>
        @endif

    @endif
    @endforeach
</div>

<!-- Interactive Health Concern & Symptom Explorer -->
<div class="container mx-auto px-4 py-8">
    <div class="bg-gradient-to-br from-slate-900 via-indigo-950 to-teal-950 rounded-[2.5rem] p-8 md:p-12 text-white shadow-2xl relative overflow-hidden">
        <!-- Ambient background glows -->
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-teal-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-teal-400/20 text-teal-300 text-xs font-bold uppercase tracking-wider border border-teal-400/30 mb-2">
                        <i class="fas fa-stethoscope"></i> Symptom-Based Diagnostics
                    </span>
                    <h2 class="text-2xl md:text-4xl font-black tracking-tight">
                        Explore Tests by Health Concern or Symptom
                    </h2>
                    <p class="text-xs md:text-sm text-slate-300 mt-1 max-w-xl leading-relaxed">
                        Experiencing unusual symptoms? Select your health concern to find doctor-curated tests and full body screening packages.
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <button type="button" onclick="window.openPrescriptionModal()" class="px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-bold border border-white/20 transition flex items-center gap-2">
                        <i class="fas fa-file-prescription text-amber-400"></i>
                        <span>Upload Prescription Slip</span>
                    </button>
                </div>
            </div>

            <!-- 8 Symptom Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Concern 1: Fatigue -->
                <div class="bg-white/10 hover:bg-white/15 border border-white/15 rounded-2xl p-5 backdrop-blur-md transition-all duration-300 hover:-translate-y-1 flex flex-col justify-between group">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-amber-400/20 text-amber-300 flex items-center justify-center text-lg mb-3">
                            <i class="fas fa-bed-pulse"></i>
                        </div>
                        <h4 class="font-bold text-white text-base mb-1">Fatigue & Exhaustion</h4>
                        <p class="text-xs text-slate-300 mb-3">Unexplained tiredness, dizziness, brain fog or low stamina.</p>
                        <div class="flex flex-wrap gap-1 mb-4">
                            <span class="text-[9px] font-mono px-2 py-0.5 rounded bg-white/10 text-amber-200">Thyroid TSH</span>
                            <span class="text-[9px] font-mono px-2 py-0.5 rounded bg-white/10 text-amber-200">Vitamin D & B12</span>
                            <span class="text-[9px] font-mono px-2 py-0.5 rounded bg-white/10 text-amber-200">Hemoglobin</span>
                        </div>
                    </div>
                    <button type="button" onclick="triggerSearch('Fatigue')" class="w-full py-2 bg-amber-400/90 hover:bg-amber-400 text-slate-950 font-bold rounded-xl text-xs transition flex items-center justify-center gap-1.5 shadow-sm">
                        <span>Check Recommended Tests</span>
                        <i class="fas fa-arrow-right text-[10px]"></i>
                    </button>
                </div>

                <!-- Concern 2: Diabetes -->
                <div class="bg-white/10 hover:bg-white/15 border border-white/15 rounded-2xl p-5 backdrop-blur-md transition-all duration-300 hover:-translate-y-1 flex flex-col justify-between group">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-red-400/20 text-red-300 flex items-center justify-center text-lg mb-3">
                            <i class="fas fa-cubes-stacked"></i>
                        </div>
                        <h4 class="font-bold text-white text-base mb-1">Diabetes & Sugar Spike</h4>
                        <p class="text-xs text-slate-300 mb-3">Excessive thirst, frequent urination, or family history of high glucose.</p>
                        <div class="flex flex-wrap gap-1 mb-4">
                            <span class="text-[9px] font-mono px-2 py-0.5 rounded bg-white/10 text-red-200">HbA1c</span>
                            <span class="text-[9px] font-mono px-2 py-0.5 rounded bg-white/10 text-red-200">Fasting Blood Sugar</span>
                            <span class="text-[9px] font-mono px-2 py-0.5 rounded bg-white/10 text-red-200">Urine Microalbumin</span>
                        </div>
                    </div>
                    <button type="button" onclick="triggerSearch('HbA1c')" class="w-full py-2 bg-red-400/90 hover:bg-red-400 text-slate-950 font-bold rounded-xl text-xs transition flex items-center justify-center gap-1.5 shadow-sm">
                        <span>Check Recommended Tests</span>
                        <i class="fas fa-arrow-right text-[10px]"></i>
                    </button>
                </div>

                <!-- Concern 3: Heart & Cholesterol -->
                <div class="bg-white/10 hover:bg-white/15 border border-white/15 rounded-2xl p-5 backdrop-blur-md transition-all duration-300 hover:-translate-y-1 flex flex-col justify-between group">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-rose-400/20 text-rose-300 flex items-center justify-center text-lg mb-3">
                            <i class="fas fa-heart-pulse"></i>
                        </div>
                        <h4 class="font-bold text-white text-base mb-1">Heart & Cholesterol</h4>
                        <p class="text-xs text-slate-300 mb-3">Shortness of breath, high blood pressure, or sedentary lifestyle.</p>
                        <div class="flex flex-wrap gap-1 mb-4">
                            <span class="text-[9px] font-mono px-2 py-0.5 rounded bg-white/10 text-rose-200">Lipid Profile</span>
                            <span class="text-[9px] font-mono px-2 py-0.5 rounded bg-white/10 text-rose-200">Triglycerides</span>
                            <span class="text-[9px] font-mono px-2 py-0.5 rounded bg-white/10 text-rose-200">hs-CRP</span>
                        </div>
                    </div>
                    <button type="button" onclick="triggerSearch('Lipid')" class="w-full py-2 bg-rose-400/90 hover:bg-rose-400 text-slate-950 font-bold rounded-xl text-xs transition flex items-center justify-center gap-1.5 shadow-sm">
                        <span>Check Recommended Tests</span>
                        <i class="fas fa-arrow-right text-[10px]"></i>
                    </button>
                </div>

                <!-- Concern 4: Joint & Bone Pain -->
                <div class="bg-white/10 hover:bg-white/15 border border-white/15 rounded-2xl p-5 backdrop-blur-md transition-all duration-300 hover:-translate-y-1 flex flex-col justify-between group">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-indigo-400/20 text-indigo-300 flex items-center justify-center text-lg mb-3">
                            <i class="fas fa-bone"></i>
                        </div>
                        <h4 class="font-bold text-white text-base mb-1">Joints & Knee Pain</h4>
                        <p class="text-xs text-slate-300 mb-3">Morning stiffness, knee clicks, swelling, or high uric acid symptoms.</p>
                        <div class="flex flex-wrap gap-1 mb-4">
                            <span class="text-[9px] font-mono px-2 py-0.5 rounded bg-white/10 text-indigo-200">Uric Acid</span>
                            <span class="text-[9px] font-mono px-2 py-0.5 rounded bg-white/10 text-indigo-200">Calcium Total</span>
                            <span class="text-[9px] font-mono px-2 py-0.5 rounded bg-white/10 text-indigo-200">Vitamin D</span>
                        </div>
                    </div>
                    <button type="button" onclick="triggerSearch('Joint')" class="w-full py-2 bg-indigo-400/90 hover:bg-indigo-400 text-slate-950 font-bold rounded-xl text-xs transition flex items-center justify-center gap-1.5 shadow-sm">
                        <span>Check Recommended Tests</span>
                        <i class="fas fa-arrow-right text-[10px]"></i>
                    </button>
                </div>

                <!-- Concern 5: Hair Fall & Skin -->
                <div class="bg-white/10 hover:bg-white/15 border border-white/15 rounded-2xl p-5 backdrop-blur-md transition-all duration-300 hover:-translate-y-1 flex flex-col justify-between group">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-emerald-400/20 text-emerald-300 flex items-center justify-center text-lg mb-3">
                            <i class="fas fa-spa"></i>
                        </div>
                        <h4 class="font-bold text-white text-base mb-1">Hair Fall & Skin Glow</h4>
                        <p class="text-xs text-slate-300 mb-3">Excessive hair shedding, brittle nails, dull complexion or acne.</p>
                        <div class="flex flex-wrap gap-1 mb-4">
                            <span class="text-[9px] font-mono px-2 py-0.5 rounded bg-white/10 text-emerald-200">Ferritin / Iron</span>
                            <span class="text-[9px] font-mono px-2 py-0.5 rounded bg-white/10 text-emerald-200">Zinc</span>
                            <span class="text-[9px] font-mono px-2 py-0.5 rounded bg-white/10 text-emerald-200">Thyroid TSH</span>
                        </div>
                    </div>
                    <button type="button" onclick="triggerSearch('Hair')" class="w-full py-2 bg-emerald-400/90 hover:bg-emerald-400 text-slate-950 font-bold rounded-xl text-xs transition flex items-center justify-center gap-1.5 shadow-sm">
                        <span>Check Recommended Tests</span>
                        <i class="fas fa-arrow-right text-[10px]"></i>
                    </button>
                </div>

                <!-- Concern 6: Liver & Alcohol -->
                <div class="bg-white/10 hover:bg-white/15 border border-white/15 rounded-2xl p-5 backdrop-blur-md transition-all duration-300 hover:-translate-y-1 flex flex-col justify-between group">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-orange-400/20 text-orange-300 flex items-center justify-center text-lg mb-3">
                            <i class="fas fa-bottle-droplet"></i>
                        </div>
                        <h4 class="font-bold text-white text-base mb-1">Fatty Liver & Alcohol</h4>
                        <p class="text-xs text-slate-300 mb-3">Heavy meal indigestion, alcohol consumption, jaundice signs, or gas.</p>
                        <div class="flex flex-wrap gap-1 mb-4">
                            <span class="text-[9px] font-mono px-2 py-0.5 rounded bg-white/10 text-orange-200">Liver Profile (LFT)</span>
                            <span class="text-[9px] font-mono px-2 py-0.5 rounded bg-white/10 text-orange-200">SGPT / SGOT</span>
                            <span class="text-[9px] font-mono px-2 py-0.5 rounded bg-white/10 text-orange-200">Bilirubin</span>
                        </div>
                    </div>
                    <button type="button" onclick="triggerSearch('Liver')" class="w-full py-2 bg-orange-400/90 hover:bg-orange-400 text-slate-950 font-bold rounded-xl text-xs transition flex items-center justify-center gap-1.5 shadow-sm">
                        <span>Check Recommended Tests</span>
                        <i class="fas fa-arrow-right text-[10px]"></i>
                    </button>
                </div>

                <!-- Concern 7: Women's PCOD & Hormones -->
                <div class="bg-white/10 hover:bg-white/15 border border-white/15 rounded-2xl p-5 backdrop-blur-md transition-all duration-300 hover:-translate-y-1 flex flex-col justify-between group">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-pink-400/20 text-pink-300 flex items-center justify-center text-lg mb-3">
                            <i class="fas fa-venus"></i>
                        </div>
                        <h4 class="font-bold text-white text-base mb-1">PCOD & Women's Hormones</h4>
                        <p class="text-xs text-slate-300 mb-3">Irregular menstrual cycles, weight gain, facial hair or mood swings.</p>
                        <div class="flex flex-wrap gap-1 mb-4">
                            <span class="text-[9px] font-mono px-2 py-0.5 rounded bg-white/10 text-pink-200">Prolactin</span>
                            <span class="text-[9px] font-mono px-2 py-0.5 rounded bg-white/10 text-pink-200">LH / FSH Ratio</span>
                            <span class="text-[9px] font-mono px-2 py-0.5 rounded bg-white/10 text-pink-200">Thyroid & Sugar</span>
                        </div>
                    </div>
                    <button type="button" onclick="triggerSearch('PCOD')" class="w-full py-2 bg-pink-400/90 hover:bg-pink-400 text-slate-950 font-bold rounded-xl text-xs transition flex items-center justify-center gap-1.5 shadow-sm">
                        <span>Check Recommended Tests</span>
                        <i class="fas fa-arrow-right text-[10px]"></i>
                    </button>
                </div>

                <!-- Concern 8: Routine Annual Wellness -->
                <div class="bg-white/10 hover:bg-white/15 border border-white/15 rounded-2xl p-5 backdrop-blur-md transition-all duration-300 hover:-translate-y-1 flex flex-col justify-between group">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-teal-400/20 text-teal-300 flex items-center justify-center text-lg mb-3">
                            <i class="fas fa-shield-heart"></i>
                        </div>
                        <h4 class="font-bold text-white text-base mb-1">Annual Full Body Checkup</h4>
                        <p class="text-xs text-slate-300 mb-3">Overall organ health checkup recommended once every 6-12 months.</p>
                        <div class="flex flex-wrap gap-1 mb-4">
                            <span class="text-[9px] font-mono px-2 py-0.5 rounded bg-white/10 text-teal-200">80+ Parameters</span>
                            <span class="text-[9px] font-mono px-2 py-0.5 rounded bg-white/10 text-teal-200">Liver, Kidney, Heart</span>
                            <span class="text-[9px] font-mono px-2 py-0.5 rounded bg-white/10 text-teal-200">Vitamins & CBC</span>
                        </div>
                    </div>
                    <button type="button" onclick="triggerSearch('Full Body')" class="w-full py-2 bg-teal-400/90 hover:bg-teal-400 text-slate-950 font-bold rounded-xl text-xs transition flex items-center justify-center gap-1.5 shadow-sm">
                        <span>Check Recommended Tests</span>
                        <i class="fas fa-arrow-right text-[10px]"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>



<style>
    .hide-scroll-bar::-webkit-scrollbar {
        display: none;
    }

    .hide-scroll-bar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>


    <!-- Single Health Checkup (Individual Tests Managed by Admin) -->
    @include('frontend.partials.single-tests-section')

    <!-- Quick Doctor Prescription Upload Banner (Tata 1mg / Dr Lal PathLabs Style) -->
    <div class="container mx-auto px-4 py-4">
        <div class="bg-gradient-to-r from-teal-800 via-emerald-800 to-indigo-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
            
            <div class="flex items-center gap-5 relative z-10">
                <div class="w-16 h-16 rounded-2xl bg-white/15 border border-white/25 flex items-center justify-center text-3xl text-amber-300 flex-shrink-0 shadow-inner">
                    <i class="fas fa-file-prescription"></i>
                </div>
                <div>
                    <div class="inline-flex items-center gap-2 px-2.5 py-0.5 rounded-full bg-amber-400 text-amber-950 text-[10px] font-black uppercase tracking-wider mb-1.5">
                        <i class="fas fa-bolt"></i> 15-Minute Callback Guarantee
                    </div>
                    <h3 class="text-xl sm:text-2xl font-black tracking-tight leading-snug">
                        Have a Doctor's Prescription?
                    </h3>
                    <p class="text-xs sm:text-sm text-teal-100 mt-1 max-w-xl">
                        Just upload your prescription slip or photo. Our certified medical team will review it, select required lab tests, and schedule free doorstep sample collection.
                    </p>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto relative z-10 flex-shrink-0">
                <button type="button" onclick="window.openPrescriptionModal()" class="w-full sm:w-auto px-6 py-3.5 bg-white hover:bg-teal-50 text-teal-900 font-extrabold text-xs uppercase tracking-wider rounded-2xl shadow-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-arrow-up-from-bracket text-teal-700"></i>
                    <span>Upload Prescription</span>
                </button>

                @php
                    $helplinePrimary = \App\Models\Setting::get('helpline_primary', '898 898 8787');
                    $helplineClean = preg_replace('/[^0-9]/', '', $helplinePrimary);
                @endphp
                <a href="tel:{{ $helplineClean }}" class="w-full sm:w-auto px-5 py-3.5 bg-teal-900/60 hover:bg-teal-900 text-white font-bold text-xs rounded-2xl border border-white/20 transition flex items-center justify-center gap-2">
                    <i class="fas fa-phone-volume text-amber-300"></i>
                    <span>Call {{ $helplinePrimary }}</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Top Booked Health Checkup Packages -->
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-end mb-6">
        <div>
            <h2 class="section-title mb-1">Top Booked Health Checkup Packages</h2>
            <p class="text-xs text-gray-500 italic">Chosen by Doctors, Trusted by Patients</p>
        </div>
        <div class="flex space-x-2">
            <button type="button" onclick="document.getElementById('top-booked-slider').scrollBy({left: -350, behavior: 'smooth'})" class="w-8 h-8 rounded-full border border-gray-300 bg-white flex items-center justify-center text-gray-500 hover:text-brand-dark hover:border-brand-dark transition shadow-sm active:scale-95" title="Previous"><i class="fas fa-chevron-left text-xs"></i></button>
            <button type="button" onclick="document.getElementById('top-booked-slider').scrollBy({left: 350, behavior: 'smooth'})" class="w-8 h-8 rounded-full bg-brand-dark text-white flex items-center justify-center hover:bg-brand-secondary transition shadow-sm active:scale-95" title="Next"><i class="fas fa-chevron-right text-xs"></i></button>
        </div>
    </div>

    <div id="top-booked-slider" class="flex space-x-5 overflow-x-auto pb-6 pt-2 hide-scroll-bar snap-x snap-mandatory scroll-smooth {{ count($packages) == 1 ? 'justify-center' : '' }} {{ count($packages) == 2 ? 'md:justify-center' : '' }} {{ count($packages) == 3 ? 'lg:justify-center' : '' }}">
        @forelse($packages as $package)
        <!-- Package Card -->
        <div class="w-[290px] md:w-[330px] flex-shrink-0 snap-start rounded-[2rem] p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 flex flex-col justify-between hover:-translate-y-1 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300 relative overflow-hidden group bg-cover bg-center" style="background-image: url('{{ $package->image ? Storage::url($package->image) : 'https://images.unsplash.com/photo-1579154204601-01588f351e67?auto=format&fit=crop&w=600&q=80' }}');">
            <div class="absolute inset-0 bg-white/95 group-hover:opacity-0 transition-opacity duration-500 z-0"></div>
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-brand-dark to-brand-secondary transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500 z-10"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-4">
                    <span class="bg-blue-50/80 text-blue-700 text-xs font-bold px-3 py-1 rounded-full border border-blue-200/50 backdrop-blur-sm">MOST BOOKED</span>
                    <div class="w-8 h-8 rounded-full bg-orange-50/80 flex items-center justify-center text-brand-secondary backdrop-blur-sm">
                        <i class="fas fa-shield-alt text-sm"></i>
                    </div>
                </div>
                <h3 class="font-bold text-brand-secondary text-base leading-snug mb-2 group-hover:text-black group-hover:[text-shadow:_0_0_15px_rgba(255,255,255,1),_0_0_20px_rgba(255,255,255,1)] transition-all">
                    <a href="{{ route('package.show', $package->id) }}" class="hover:underline">
                        {{ $package->name }}
                    </a>
                </h3>
                <div class="bg-gray-50/80 backdrop-blur-sm rounded-xl p-3 flex items-center justify-between mb-4 border border-gray-200/50">
                    <div class="text-center">
                        <p class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold">Reports In</p>
                        <p class="text-sm font-bold text-gray-800">10 hrs</p>
                    </div>
                    <div class="w-px h-8 bg-gray-200"></div>
                    <div class="text-center">
                        <p class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold">Parameters</p>
                        <p class="text-sm font-bold text-teal-700">{{ $package->total_parameters_count }} Tests</p>
                    </div>
                </div>
                
                @php
                    $pkgGrouped = $package->getGroupedParameters();
                @endphp
                @if(!empty($pkgGrouped))
                <div class="flex flex-wrap gap-1.5 mb-4">
                    @foreach(array_slice(array_keys($pkgGrouped), 0, 3) as $deptKey)
                    <span class="bg-white/90 backdrop-blur-sm text-gray-700 text-[10px] font-medium px-2 py-0.5 rounded-md border border-gray-200/60 flex items-center shadow-xs">
                        <i class="fas fa-check-circle text-teal-600 mr-1 text-[9px]"></i> {{ \Illuminate\Support\Str::limit($deptKey, 16) }}
                    </span>
                    @endforeach
                    @if(count($pkgGrouped) > 3)
                    <span class="text-[10px] text-brand-secondary font-bold self-center ml-1">+{{ count($pkgGrouped) - 3 }} More</span>
                    @endif
                </div>
                @endif
                
                @if($package->description)
                <p class="text-xs text-gray-600 mb-4 line-clamp-2">{{ $package->description }}</p>
                @endif
                
            </div>
            <div class="border-t border-gray-200/50 pt-4 mt-auto relative z-10">
                <div class="flex items-end justify-between mb-3">
                    <div>
                        <div class="text-2xl font-black text-gray-900 tracking-tight">₹{{ number_format($package->price) }}</div>
                    </div>
                </div>
                <a href="{{ route('package.show', $package->id) }}" class="w-full mb-2.5 py-1.5 px-3 bg-teal-50 hover:bg-teal-100 text-teal-800 border border-teal-200 text-xs font-semibold rounded-xl transition flex items-center justify-center gap-1.5">
                    <i class="fas fa-file-waveform text-teal-600 text-[11px]"></i>
                    <span>View {{ $package->total_parameters_count }} Tests Included</span>
                </a>
                <button onclick="addToCart(this)" 
                    data-id="{{ $package->id }}"
                    data-type="package"
                    data-name="{{ $package->name }}"
                    data-price="{{ $package->price }}" data-mrp="{{ $package->price }}" data-params="Includes {{ $package->total_parameters_count }} Parameters"
                    class="w-full bg-white/90 backdrop-blur-sm border-2 border-brand-secondary text-brand-secondary hover:bg-gradient-to-r hover:from-brand-dark hover:to-brand-secondary hover:border-transparent hover:text-white font-bold py-2.5 rounded-xl transition-all duration-300 flex items-center justify-center group/btn shadow-sm">
                    <i class="fas fa-cart-plus mr-2 group-hover/btn:scale-110 transition-transform"></i> Add to Cart
                </button>
                <p class="text-[9px] text-gray-500 font-medium text-center mt-3">Free Home Sample Collection Included</p>
            </div>
        </div>
        @empty
        <div class="text-gray-500 italic p-4">No packages available at the moment.</div>
        @endforelse
    </div>
</div>

    <!-- Unhealthy Habits -->
<div class="container mx-auto px-4 py-8" id="habits-section">
    <div class="bg-gradient-to-br from-slate-50 to-teal-50/40 rounded-3xl p-6 sm:p-8 border border-teal-100/60 shadow-xs">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-6 gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-teal-100/80 text-teal-800 text-[11px] font-bold uppercase tracking-wider mb-2">
                    <i class="fas fa-heartbeat text-teal-600"></i> Lifestyle Risks
                </div>
                <h2 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">Unhealthy Habits</h2>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">Understand how daily habits may be impacting your health & screen key biomarkers early.</p>
            </div>
            <div class="flex items-center space-x-2 self-end sm:self-auto">
                <button type="button" onclick="document.getElementById('habits-slider').scrollBy({left: -340, behavior: 'smooth'})" class="w-9 h-9 rounded-xl border border-gray-200 bg-white flex items-center justify-center text-gray-600 hover:text-brand-dark hover:border-brand-dark hover:bg-teal-50/50 transition shadow-xs active:scale-95 cursor-pointer" title="Previous"><i class="fas fa-chevron-left text-xs"></i></button>
                <button type="button" onclick="document.getElementById('habits-slider').scrollBy({left: 340, behavior: 'smooth'})" class="w-9 h-9 rounded-xl bg-brand-dark text-white flex items-center justify-center hover:bg-brand-secondary transition shadow-sm active:scale-95 cursor-pointer" title="Next"><i class="fas fa-chevron-right text-xs"></i></button>
            </div>
        </div>

        <!-- Tabs -->
        <div class="flex space-x-2 overflow-x-auto pb-4 hide-scroll-bar" id="habits-tabs">
            <button type="button" onclick="filterPackages('habit', 'All', this)" class="habit-tab bg-brand-dark text-white px-5 py-2 rounded-xl text-sm font-bold min-w-max shadow-md transition-all">All</button>
            <button type="button" onclick="filterPackages('habit', 'Junk Food', this)" class="habit-tab bg-white border border-gray-200 text-gray-700 px-4 py-2 rounded-xl text-sm font-semibold min-w-max hover:bg-gray-50 hover:border-gray-300 transition-all shadow-xs"><i class="fas fa-hamburger mr-1.5 text-amber-500"></i> Junk Food</button>
            <button type="button" onclick="filterPackages('habit', 'Sedentary Lifestyle', this)" class="habit-tab bg-white border border-gray-200 text-gray-700 px-4 py-2 rounded-xl text-sm font-semibold min-w-max hover:bg-gray-50 hover:border-gray-300 transition-all shadow-xs"><i class="fas fa-couch mr-1.5 text-purple-500"></i> Sedentary Lifestyle</button>
            <button type="button" onclick="filterPackages('habit', 'Smoking', this)" class="habit-tab bg-white border border-gray-200 text-gray-700 px-4 py-2 rounded-xl text-sm font-semibold min-w-max hover:bg-gray-50 hover:border-gray-300 transition-all shadow-xs"><i class="fas fa-smoking mr-1.5 text-slate-500"></i> Smoking</button>
            <button type="button" onclick="filterPackages('habit', 'Alcohol', this)" class="habit-tab bg-white border border-gray-200 text-gray-700 px-4 py-2 rounded-xl text-sm font-semibold min-w-max hover:bg-gray-50 hover:border-gray-300 transition-all shadow-xs"><i class="fas fa-wine-glass-alt mr-1.5 text-rose-500"></i> Alcohol</button>
            <button type="button" onclick="filterPackages('habit', 'Stress', this)" class="habit-tab bg-white border border-gray-200 text-gray-700 px-4 py-2 rounded-xl text-sm font-semibold min-w-max hover:bg-gray-50 hover:border-gray-300 transition-all shadow-xs"><i class="fas fa-brain mr-1.5 text-pink-500"></i> Stress</button>
            <button type="button" onclick="filterPackages('habit', 'Anger', this)" class="habit-tab bg-white border border-gray-200 text-gray-700 px-4 py-2 rounded-xl text-sm font-semibold min-w-max hover:bg-gray-50 hover:border-gray-300 transition-all shadow-xs"><i class="fas fa-fire mr-1.5 text-red-500"></i> Anger</button>
            <button type="button" onclick="filterPackages('habit', 'Sleepless', this)" class="habit-tab bg-white border border-gray-200 text-gray-700 px-4 py-2 rounded-xl text-sm font-semibold min-w-max hover:bg-gray-50 hover:border-gray-300 transition-all shadow-xs"><i class="fas fa-moon mr-1.5 text-blue-500"></i> Sleepless</button>
        </div>

        <!-- Slider of habit cards -->
        <div id="habits-slider" class="flex space-x-5 overflow-x-auto pb-6 pt-2 hide-scroll-bar snap-x snap-mandatory scroll-smooth mt-4">
            @forelse($habitPackages as $package)
            @php
                $mrp = round($package->price * 1.45);
                $discountPct = round((($mrp - $package->price) / $mrp) * 100);
                $pkgGrouped = $package->getGroupedParameters();
            @endphp
            <!-- Habit Package Card -->
            <div onclick="window.location.href='{{ route('package.show', $package->id) }}'" 
                class="habit-card cursor-pointer w-[290px] sm:w-[310px] md:w-[330px] flex-shrink-0 snap-start bg-white rounded-3xl p-6 border border-gray-100 hover:border-teal-300 flex flex-col justify-between hover:-translate-y-1.5 hover:shadow-[0_12px_35px_rgba(15,118,110,0.12)] transition-all duration-300 relative overflow-hidden group" 
                data-category="{{ $package->subcategory }}">
                <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-teal-400 via-teal-600 to-brand-dark transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                <div>
                    <div class="flex justify-between items-center mb-3">
                        <span class="bg-teal-50 text-teal-800 text-[10px] font-extrabold px-2.5 py-1 rounded-full uppercase border border-teal-100 tracking-wider flex items-center gap-1">
                            <i class="fas fa-tag text-[9px]"></i> {{ $package->subcategory ?? 'Lifestyle' }}
                        </span>
                        <div class="w-8 h-8 rounded-full bg-teal-50 flex items-center justify-center text-teal-600 group-hover:scale-110 transition-transform">
                            <i class="fas fa-notes-medical text-xs"></i>
                        </div>
                    </div>
                    <h4 class="font-extrabold text-gray-900 text-base leading-snug mb-2 group-hover:text-teal-700 transition-colors line-clamp-2">
                        <a href="{{ route('package.show', $package->id) }}" class="hover:underline" onclick="event.stopPropagation();">
                            {{ $package->name }}
                        </a>
                    </h4>
                    
                    <div class="bg-gray-50/90 rounded-2xl p-3 flex items-center justify-between mt-3 mb-3 border border-gray-100">
                        <div class="text-center w-full">
                            <p class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold">Reports In</p>
                            <p class="text-xs sm:text-sm font-black text-gray-800">12 hrs</p>
                        </div>
                        <div class="w-px h-7 bg-gray-200 mx-2"></div>
                        <div class="text-center w-full">
                            <p class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold">Parameters</p>
                            <p class="text-xs sm:text-sm font-black text-teal-700">{{ $package->total_parameters_count }} Tests</p>
                        </div>
                    </div>

                    @if(!empty($pkgGrouped))
                    <div class="flex flex-wrap gap-1.5 mb-3">
                        @foreach(array_slice(array_keys($pkgGrouped), 0, 3) as $deptKey)
                        <span class="bg-teal-50/70 text-teal-900 text-[10px] font-semibold px-2 py-0.5 rounded-md border border-teal-100/60 flex items-center">
                            <i class="fas fa-check-circle text-teal-600 mr-1 text-[8px]"></i> {{ \Illuminate\Support\Str::limit($deptKey, 15) }}
                        </span>
                        @endforeach
                        @if(count($pkgGrouped) > 3)
                        <span class="text-[10px] text-teal-700 font-bold self-center ml-1">+{{ count($pkgGrouped) - 3 }} more</span>
                        @endif
                    </div>
                    @endif

                    @if($package->description)
                    <p class="text-xs text-gray-500 mb-4 line-clamp-2 leading-relaxed">{{ $package->description }}</p>
                    @endif
                </div>
                <div class="border-t border-gray-100 pt-4 mt-auto">
                    <div class="flex items-baseline justify-between mb-3">
                        <div class="flex items-baseline gap-2">
                            <span class="text-2xl font-black text-gray-900 tracking-tight">₹{{ number_format($package->price) }}</span>
                            <span class="text-xs text-gray-400 line-through font-semibold">₹{{ number_format($mrp) }}</span>
                        </div>
                        <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-extrabold px-2 py-0.5 rounded-md uppercase tracking-wider">
                            {{ $discountPct }}% OFF
                        </span>
                    </div>
                    
                    <button type="button" 
                        onclick="event.stopPropagation(); openPackageDetails({{ $package->id }})" 
                        class="w-full mb-2 py-2 px-3 bg-teal-50 hover:bg-teal-100 text-teal-800 border border-teal-200 text-xs font-bold rounded-xl transition flex items-center justify-center gap-1.5 cursor-pointer active:scale-98">
                        <i class="fas fa-file-waveform text-teal-600 text-xs"></i>
                        <span>View {{ $package->total_parameters_count }} Tests Included</span>
                    </button>

                    <button type="button" 
                        onclick="event.stopPropagation(); addToCart(this)" 
                        data-id="{{ $package->id }}"
                        data-type="package"
                        data-name="{{ $package->name }}"
                        data-price="{{ $package->price }}" 
                        data-mrp="{{ $mrp }}" 
                        data-params="Includes {{ $package->total_parameters_count }} Parameters"
                        class="w-full bg-white border-2 border-brand-secondary text-brand-secondary hover:bg-gradient-to-r hover:from-brand-dark hover:to-brand-secondary hover:border-transparent hover:text-white font-bold py-2.5 rounded-xl transition-all duration-300 flex items-center justify-center group/btn shadow-xs active:scale-98 cursor-pointer">
                        <i class="fas fa-cart-plus mr-2 group-hover/btn:scale-110 transition-transform"></i> Add to Cart
                    </button>
                    <p class="text-[9px] text-gray-400 text-center mt-2.5 flex items-center justify-center gap-1">
                        <i class="fas fa-house-user text-teal-500"></i> Free Home Sample Collection
                    </p>
                </div>
            </div>
            @empty
            <div class="text-gray-500 italic p-6 bg-white rounded-2xl w-full text-center border border-gray-100">No habit packages available yet.</div>
            @endforelse
        </div>

        <!-- Habits Empty State (Filtered) -->
        <div id="habits-empty-state" class="hidden py-10 text-center w-full bg-white rounded-3xl border border-gray-100 p-8 shadow-xs mt-2">
            <div class="w-14 h-14 bg-teal-50 text-teal-600 rounded-2xl flex items-center justify-center mx-auto mb-3 text-xl">
                <i class="fas fa-clipboard-check"></i>
            </div>
            <h4 class="font-extrabold text-gray-900 text-base mb-1">No packages found under <span class="empty-category-name text-teal-700"></span> yet</h4>
            <p class="text-xs text-gray-500 max-w-md mx-auto mb-4">You can browse our comprehensive lifestyle packages or consult our health team for a custom test panel.</p>
            <button type="button" onclick="filterPackages('habit', 'All', document.querySelector('#habits-tabs button'))" class="px-5 py-2 bg-brand-dark text-white rounded-xl text-xs font-bold hover:bg-brand-secondary transition cursor-pointer">
                View All Habit Packages
            </button>
        </div>
    </div>
</div>


    <!-- Femcliffe Health Packages -->
<div class="bg-gradient-to-br from-pink-50/70 via-rose-50/40 to-purple-50/60 py-10 mt-8 rounded-[2.5rem] mx-4 lg:mx-0 border border-pink-100/70 shadow-xs" id="femcliffe-section">
    <div class="container mx-auto px-4">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-6 gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-pink-100 text-pink-700 text-[11px] font-bold uppercase tracking-wider mb-2 border border-pink-200">
                    <i class="fas fa-venus text-pink-600"></i> She-Centric Diagnostic Platform
                </div>
                <h2 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight flex items-center flex-wrap gap-2">
                    Femcliffe <span class="bg-gradient-to-r from-pink-500 to-purple-600 text-white text-[10px] px-3 py-1 rounded-full uppercase font-extrabold tracking-wide shadow-xs">Women's Health</span>
                </h2>
                <p class="text-xs sm:text-sm text-gray-600 mt-1">
                    India's First She-Centric Diagnostic Platform • Specialized Female Biomarkers & Confidential Reporting
                    <button type="button" onclick="openFemcliffeModal()" class="text-pink-600 font-extrabold underline hover:text-pink-800 transition ml-1.5 cursor-pointer">Know More</button>
                </p>
            </div>
            <div class="flex items-center space-x-2 self-end sm:self-auto">
                <button type="button" onclick="document.getElementById('femcliffe-slider').scrollBy({left: -340, behavior: 'smooth'})" class="w-9 h-9 rounded-xl border border-pink-200 bg-white flex items-center justify-center text-gray-600 hover:text-pink-600 hover:border-pink-400 hover:bg-pink-50/50 transition shadow-xs active:scale-95 cursor-pointer" title="Previous"><i class="fas fa-chevron-left text-xs"></i></button>
                <button type="button" onclick="document.getElementById('femcliffe-slider').scrollBy({left: 340, behavior: 'smooth'})" class="w-9 h-9 rounded-xl bg-gradient-to-r from-pink-600 to-purple-600 text-white flex items-center justify-center hover:from-pink-700 hover:to-purple-700 transition shadow-xs active:scale-95 cursor-pointer" title="Next"><i class="fas fa-chevron-right text-xs"></i></button>
            </div>
        </div>

        <!-- Tabs -->
        <div class="flex space-x-2 overflow-x-auto pb-4 hide-scroll-bar" id="femcliffe-tabs">
            <button type="button" onclick="filterPackages('femcliffe', 'All', this)" class="femcliffe-tab bg-gradient-to-r from-pink-600 to-purple-600 text-white px-5 py-2 rounded-xl text-sm font-bold min-w-max shadow-md shadow-pink-500/20 transition-all">All</button>
            <button type="button" onclick="filterPackages('femcliffe', 'Pregnancy', this)" class="femcliffe-tab bg-white border border-pink-200 text-gray-700 px-5 py-2 rounded-xl text-sm font-semibold min-w-max hover:bg-pink-50 hover:text-pink-700 hover:border-pink-300 transition-all shadow-xs"><i class="fas fa-baby mr-1.5 text-pink-500"></i> Pregnancy</button>
            <button type="button" onclick="filterPackages('femcliffe', 'Wellness', this)" class="femcliffe-tab bg-white border border-pink-200 text-gray-700 px-5 py-2 rounded-xl text-sm font-semibold min-w-max hover:bg-pink-50 hover:text-pink-700 hover:border-pink-300 transition-all shadow-xs"><i class="fas fa-spa mr-1.5 text-rose-500"></i> Wellness</button>
            <button type="button" onclick="filterPackages('femcliffe', 'PCOS/PCOD', this)" class="femcliffe-tab bg-white border border-pink-200 text-gray-700 px-5 py-2 rounded-xl text-sm font-semibold min-w-max hover:bg-pink-50 hover:text-pink-700 hover:border-pink-300 transition-all shadow-xs"><i class="fas fa-dna mr-1.5 text-purple-500"></i> PCOS/PCOD</button>
            <button type="button" onclick="filterPackages('femcliffe', 'Sexual Health', this)" class="femcliffe-tab bg-white border border-pink-200 text-gray-700 px-5 py-2 rounded-xl text-sm font-semibold min-w-max hover:bg-pink-50 hover:text-pink-700 hover:border-pink-300 transition-all shadow-xs"><i class="fas fa-shield-heart mr-1.5 text-rose-600"></i> Sexual Health</button>
            <button type="button" onclick="filterPackages('femcliffe', 'Menstrual Health', this)" class="femcliffe-tab bg-white border border-pink-200 text-gray-700 px-5 py-2 rounded-xl text-sm font-semibold min-w-max hover:bg-pink-50 hover:text-pink-700 hover:border-pink-300 transition-all shadow-xs"><i class="fas fa-calendar-check mr-1.5 text-pink-600"></i> Menstrual Health</button>
            <button type="button" onclick="filterPackages('femcliffe', 'Cancer', this)" class="femcliffe-tab bg-white border border-pink-200 text-gray-700 px-5 py-2 rounded-xl text-sm font-semibold min-w-max hover:bg-pink-50 hover:text-pink-700 hover:border-pink-300 transition-all shadow-xs"><i class="fas fa-ribbon mr-1.5 text-fuchsia-600"></i> Cancer</button>
        </div>

        <!-- Slider of Femcliffe cards -->
        <div id="femcliffe-slider" class="flex space-x-5 overflow-x-auto pb-6 pt-2 hide-scroll-bar snap-x snap-mandatory scroll-smooth mt-4">
            @forelse($femcliffePackages as $package)
            @php
                $mrp = round($package->price * 1.45);
                $discountPct = round((($mrp - $package->price) / $mrp) * 100);
                $pkgGrouped = $package->getGroupedParameters();
            @endphp
            <!-- Femcliffe Package Card -->
            <div onclick="window.location.href='{{ route('package.show', $package->id) }}'" 
                class="femcliffe-card cursor-pointer w-[290px] sm:w-[310px] md:w-[330px] flex-shrink-0 snap-start bg-white rounded-3xl p-6 border border-pink-100 hover:border-pink-300 flex flex-col justify-between hover:-translate-y-1.5 hover:shadow-[0_12px_35px_rgba(236,72,153,0.16)] transition-all duration-300 relative overflow-hidden group" 
                data-category="{{ $package->subcategory }}">
                <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-pink-400 via-rose-500 to-purple-600 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                <div>
                    <div class="flex justify-between items-center mb-3">
                        <span class="bg-pink-50 text-pink-700 text-[10px] font-extrabold px-2.5 py-1 rounded-full uppercase border border-pink-200/80 tracking-wider flex items-center gap-1">
                            <i class="fas fa-venus text-[9px]"></i> {{ $package->subcategory ?? 'Women Care' }}
                        </span>
                        <div class="w-8 h-8 rounded-full bg-pink-50 flex items-center justify-center text-pink-600 group-hover:scale-110 transition-transform">
                            <i class="fas fa-heart text-xs"></i>
                        </div>
                    </div>
                    <h4 class="font-extrabold text-gray-900 text-base leading-snug mb-2 group-hover:text-pink-600 transition-colors line-clamp-2">
                        <a href="{{ route('package.show', $package->id) }}" class="hover:underline" onclick="event.stopPropagation();">
                            {{ $package->name }}
                        </a>
                    </h4>
                    
                    <div class="bg-pink-50/50 rounded-2xl p-3 flex items-center justify-between mt-3 mb-3 border border-pink-100/80">
                        <div class="text-center w-full">
                            <p class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold">Reports In</p>
                            <p class="text-xs sm:text-sm font-black text-gray-800">10 hrs</p>
                        </div>
                        <div class="w-px h-7 bg-pink-200 mx-2"></div>
                        <div class="text-center w-full">
                            <p class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold">Parameters</p>
                            <p class="text-xs sm:text-sm font-black text-pink-600">{{ $package->total_parameters_count }} Tests</p>
                        </div>
                    </div>

                    @if(!empty($pkgGrouped))
                    <div class="flex flex-wrap gap-1.5 mb-3">
                        @foreach(array_slice(array_keys($pkgGrouped), 0, 3) as $deptKey)
                        <span class="bg-pink-50/60 text-pink-900 text-[10px] font-semibold px-2 py-0.5 rounded-md border border-pink-100 flex items-center">
                            <i class="fas fa-check-circle text-pink-500 mr-1 text-[8px]"></i> {{ \Illuminate\Support\Str::limit($deptKey, 15) }}
                        </span>
                        @endforeach
                        @if(count($pkgGrouped) > 3)
                        <span class="text-[10px] text-pink-600 font-bold self-center ml-1">+{{ count($pkgGrouped) - 3 }} more</span>
                        @endif
                    </div>
                    @endif

                    @if($package->description)
                    <p class="text-xs text-gray-500 mb-4 line-clamp-2 leading-relaxed">{{ $package->description }}</p>
                    @endif
                </div>
                <div class="border-t border-gray-100 pt-4 mt-auto">
                    <div class="flex items-baseline justify-between mb-3">
                        <div class="flex items-baseline gap-2">
                            <span class="text-2xl font-black text-gray-900 tracking-tight">₹{{ number_format($package->price) }}</span>
                            <span class="text-xs text-gray-400 line-through font-semibold">₹{{ number_format($mrp) }}</span>
                        </div>
                        <span class="bg-rose-50 text-rose-700 border border-rose-200 text-[10px] font-extrabold px-2 py-0.5 rounded-md uppercase tracking-wider">
                            {{ $discountPct }}% OFF
                        </span>
                    </div>
                    
                    <button type="button" 
                        onclick="event.stopPropagation(); openPackageDetails({{ $package->id }})" 
                        class="w-full mb-2 py-2 px-3 bg-pink-50 hover:bg-pink-100 text-pink-700 border border-pink-200 text-xs font-bold rounded-xl transition flex items-center justify-center gap-1.5 cursor-pointer active:scale-98">
                        <i class="fas fa-file-waveform text-pink-500 text-xs"></i>
                        <span>View {{ $package->total_parameters_count }} Tests Included</span>
                    </button>

                    <button type="button" 
                        onclick="event.stopPropagation(); addToCart(this)" 
                        data-id="{{ $package->id }}"
                        data-type="package"
                        data-name="{{ $package->name }}"
                        data-price="{{ $package->price }}" 
                        data-mrp="{{ $mrp }}" 
                        data-params="Includes {{ $package->total_parameters_count }} Parameters"
                        class="w-full bg-white border-2 border-pink-500 text-pink-600 hover:bg-gradient-to-r hover:from-pink-500 hover:to-purple-600 hover:border-transparent hover:text-white font-bold py-2.5 rounded-xl transition-all duration-300 flex items-center justify-center group/btn shadow-xs active:scale-98 cursor-pointer">
                        <i class="fas fa-cart-plus mr-2 group-hover/btn:scale-110 transition-transform"></i> Add to Cart
                    </button>
                    <p class="text-[9px] text-gray-400 text-center mt-2.5 flex items-center justify-center gap-1">
                        <i class="fas fa-shield-halved text-pink-400"></i> 100% Confidential • Female Phlebotomist on Request
                    </p>
                </div>
            </div>
            @empty
            <div class="text-gray-500 italic p-6 bg-white rounded-2xl w-full text-center border border-pink-100">No femcliffe packages available yet.</div>
            @endforelse
        </div>

        <!-- Femcliffe Empty State (Filtered) -->
        <div id="femcliffe-empty-state" class="hidden py-10 text-center w-full bg-white rounded-3xl border border-pink-100 p-8 shadow-xs mt-2">
            <div class="w-14 h-14 bg-pink-50 text-pink-600 rounded-2xl flex items-center justify-center mx-auto mb-3 text-xl">
                <i class="fas fa-hand-holding-heart"></i>
            </div>
            <h4 class="font-extrabold text-gray-900 text-base mb-1">No packages found under <span class="empty-category-name text-pink-600"></span> yet</h4>
            <p class="text-xs text-gray-500 max-w-md mx-auto mb-4">Explore our other specialized women's health packages or reach out for personalized diagnostic assistance.</p>
            <button type="button" onclick="filterPackages('femcliffe', 'All', document.querySelector('#femcliffe-tabs button'))" class="px-5 py-2 bg-gradient-to-r from-pink-600 to-purple-600 text-white rounded-xl text-xs font-bold hover:opacity-95 transition cursor-pointer">
                View All Women's Packages
            </button>
        </div>
    </div>
</div>


    <!-- Spreading Quality Healthcare Stats Strip -->
    @include('frontend.partials.stats')

    <!-- Why Book Tests With Us? -->
<div class="relative py-20 overflow-hidden bg-gradient-to-br from-gray-50 to-white">
    <!-- Decorative background elements -->
    <div class="absolute top-0 right-0 w-64 h-64 bg-brand-light rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
    <div class="absolute bottom-0 left-0 w-72 h-72 bg-blue-100 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-5xl font-extrabold text-brand-dark mb-4 tracking-tight">Why Book Tests With <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-dark to-brand-secondary">Us?</span></h2>
            <p class="text-gray-500 max-w-2xl mx-auto text-lg">Experience world-class diagnostics with unparalleled accuracy, speed, and comfort right at your doorstep.</p>
        </div>
        
        <div class="flex flex-col lg:flex-row gap-12 items-center">
            <!-- Features Grid -->
            <div class="lg:w-1/2 grid grid-cols-1 sm:grid-cols-2 gap-8 relative pb-10 sm:pb-0">
                <!-- Decorative Hanging Bar (optional, can just use the staggered grid) -->
                <!-- Card 1 -->
                <div class="group bg-pink-50/80 rounded-xl p-6 shadow-xl hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border-[6px] border-white relative overflow-hidden sm:-rotate-3 z-10 hover:z-20 origin-top">
                    <!-- Hanging String -->
                    <div class="absolute -top-1 left-1/2 -translate-x-1/2 w-0.5 h-4 bg-gray-300"></div>
                    <div class="absolute top-2 left-1/2 -translate-x-1/2 w-2 h-2 bg-gray-400 rounded-full shadow-sm"></div>
                    
                    <div class="absolute inset-0 bg-gradient-to-br from-pink-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10 mt-2">
                        <div class="w-14 h-14 bg-pink-100/50 rounded-lg flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-syringe text-2xl text-pink-500 drop-shadow-sm"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 text-lg mb-2">Painless Collection</h4>
                        <p class="text-sm font-medium text-gray-500 leading-relaxed">One-prick sample collection by trained experts at your home.</p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="group bg-teal-50/80 rounded-xl p-6 shadow-xl hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border-[6px] border-white relative overflow-hidden sm:rotate-2 mt-0 sm:mt-12 z-10 hover:z-20 origin-top">
                    <!-- Hanging String -->
                    <div class="absolute -top-1 left-1/2 -translate-x-1/2 w-0.5 h-4 bg-gray-300"></div>
                    <div class="absolute top-2 left-1/2 -translate-x-1/2 w-2 h-2 bg-gray-400 rounded-full shadow-sm"></div>
                    
                    <div class="absolute inset-0 bg-gradient-to-br from-teal-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10 mt-2">
                        <div class="w-14 h-14 bg-teal-100/50 rounded-lg flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-temperature-low text-2xl text-teal-500 drop-shadow-sm"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 text-lg mb-2">100% Sample Integrity</h4>
                        <p class="text-sm font-medium text-gray-500 leading-relaxed">Temperature-controlled bags ensure samples arrive in pristine condition.</p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="group bg-blue-50/80 rounded-xl p-6 shadow-xl hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border-[6px] border-white relative overflow-hidden sm:rotate-3 z-10 hover:z-20 origin-top">
                    <!-- Hanging String -->
                    <div class="absolute -top-1 left-1/2 -translate-x-1/2 w-0.5 h-4 bg-gray-300"></div>
                    <div class="absolute top-2 left-1/2 -translate-x-1/2 w-2 h-2 bg-gray-400 rounded-full shadow-sm"></div>
                    
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10 mt-2">
                        <div class="w-14 h-14 bg-blue-100/50 rounded-lg flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-flask text-2xl text-blue-500 drop-shadow-sm"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 text-lg mb-2">Certified Labs</h4>
                        <p class="text-sm font-medium text-gray-500 leading-relaxed">Processed at self-owned, NABL & CAP certified laboratories.</p>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="group bg-yellow-50/80 rounded-xl p-6 shadow-xl hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border-[6px] border-white relative overflow-hidden sm:-rotate-2 mt-0 sm:mt-12 z-10 hover:z-20 origin-top">
                    <!-- Hanging String -->
                    <div class="absolute -top-1 left-1/2 -translate-x-1/2 w-0.5 h-4 bg-gray-300"></div>
                    <div class="absolute top-2 left-1/2 -translate-x-1/2 w-2 h-2 bg-gray-400 rounded-full shadow-sm"></div>
                    
                    <div class="absolute inset-0 bg-gradient-to-br from-yellow-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10 mt-2">
                        <div class="w-14 h-14 bg-yellow-100/50 rounded-lg flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-file-invoice text-2xl text-brand-secondary drop-shadow-sm"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 text-lg mb-2">Smart Reports</h4>
                        <p class="text-sm font-medium text-gray-500 leading-relaxed">Easy-to-understand, verified reports by top MD pathologists.</p>
                    </div>
                </div>
            </div>

            <!-- Image Section -->
            <div class="lg:w-1/2 relative group">
                <div class="absolute inset-0 bg-gradient-to-tr from-brand-secondary to-brand-dark rounded-[2.5rem] transform rotate-3 scale-[0.98] opacity-20 group-hover:rotate-6 group-hover:scale-[1.02] transition-all duration-500 ease-out z-0"></div>
                <div class="relative z-10 rounded-[2.5rem] overflow-hidden border-8 border-white shadow-2xl h-[450px]">
                    <img id="why-book-hero-img" src="https://images.unsplash.com/photo-1579154204601-01588f351e67?auto=format&fit=crop&w=1000&q=80" alt="Lab Technician analyzing samples" class="w-full h-full object-cover transform group-hover:scale-110 transition-all duration-700 ease-out">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6">
                        <div class="bg-white/90 backdrop-blur-md p-4 rounded-2xl shadow-lg flex items-center gap-4 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-500">
                            <div class="bg-green-100 text-green-600 w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check-circle text-xl"></i>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 text-sm">NABL & CAP Certified</p>
                                <p class="text-xs text-gray-500 font-medium">Guaranteeing 100% accuracy</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Rotator Script -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const images = [
            "https://images.unsplash.com/photo-1579154204601-01588f351e67?auto=format&fit=crop&w=1000&q=80",
            "https://images.unsplash.com/photo-1581594693702-fbdc51b2763b?auto=format&fit=crop&w=1000&q=80",
            "https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=1000&q=80",
            "https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=1000&q=80"
        ];
        let currentIndex = 0;
        const imgElement = document.getElementById('why-book-hero-img');
        
        if(imgElement) {
            setInterval(() => {
                // Fade out
                imgElement.style.opacity = '0.5';
                
                setTimeout(() => {
                    currentIndex = (currentIndex + 1) % images.length;
                    imgElement.src = images[currentIndex];
                    // Fade in
                    imgElement.style.opacity = '1';
                }, 700); // Wait for CSS transition-all duration-700
            }, 6000);
        }
    });
</script>


    <!-- 5 Simple Steps to Manage Your Health -->
<div class="container mx-auto px-4 py-16 relative">
    <!-- Decorative dashed line connecting steps (hidden on mobile) -->
    <div class="hidden lg:block absolute top-[280px] left-[10%] right-[10%] border-t-2 border-dashed border-gray-300 z-0"></div>

    <div class="text-center mb-12 relative z-10">
        <h2 class="text-3xl md:text-4xl font-extrabold text-brand-dark mb-3">5 Simple Steps to Manage Your Health</h2>
        <p class="text-gray-500 font-medium">Quick, Simple & Convenient; trusted care delivered to your doorstep.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 relative z-10">
        <!-- Step 1 -->
        <div class="group bg-white rounded-3xl p-4 shadow-lg hover:shadow-2xl hover:-translate-y-4 transition-all duration-500 border border-gray-100 flex flex-col items-center text-center relative mt-0 lg:mt-8">
            <div class="w-12 h-12 bg-blue-500 text-white rounded-full flex items-center justify-center font-black text-xl absolute -top-5 shadow-lg shadow-blue-500/40 z-20 group-hover:scale-110 transition-transform duration-300">1</div>
            <div class="w-full h-40 rounded-2xl overflow-hidden mb-5 relative group-hover:ring-4 ring-blue-100 transition-all duration-300">
                <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=500&q=80" alt="Booking" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-out">
                <div class="absolute inset-0 bg-blue-900/10 group-hover:bg-transparent transition-colors duration-300"></div>
            </div>
            <h4 class="font-bold text-gray-800 mb-2">Start Online Booking</h4>
            <p class="text-xs text-gray-500 leading-relaxed pb-2">Select your desired test or package, enter details, and schedule a convenient time slot via our app or website.</p>
        </div>

        <!-- Step 2 -->
        <div class="group bg-white rounded-3xl p-4 shadow-lg hover:shadow-2xl hover:-translate-y-4 transition-all duration-500 border border-gray-100 flex flex-col items-center text-center relative mt-0 lg:-mt-4">
            <div class="w-12 h-12 bg-red-500 text-white rounded-full flex items-center justify-center font-black text-xl absolute -top-5 shadow-lg shadow-red-500/40 z-20 group-hover:scale-110 transition-transform duration-300">2</div>
            <div class="w-full h-40 rounded-2xl overflow-hidden mb-5 relative group-hover:ring-4 ring-red-100 transition-all duration-300">
                <img src="https://images.unsplash.com/photo-1524661135-423995f22d0b?auto=format&fit=crop&w=500&q=80" alt="Live Tracking" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-out">
                <div class="absolute inset-0 bg-red-900/10 group-hover:bg-transparent transition-colors duration-300"></div>
            </div>
            <h4 class="font-bold text-gray-800 mb-2">Live Tracking</h4>
            <p class="text-xs text-gray-500 leading-relaxed pb-2">Stay fully updated with real-time GPS tracking of your phlebotomist for a smooth home collection.</p>
        </div>

        <!-- Step 3 -->
        <div class="group bg-white rounded-3xl p-4 shadow-lg hover:shadow-2xl hover:-translate-y-4 transition-all duration-500 border border-gray-100 flex flex-col items-center text-center relative mt-0 lg:mt-8">
            <div class="w-12 h-12 bg-teal-500 text-white rounded-full flex items-center justify-center font-black text-xl absolute -top-5 shadow-lg shadow-teal-500/40 z-20 group-hover:scale-110 transition-transform duration-300">3</div>
            <div class="w-full h-40 rounded-2xl overflow-hidden mb-5 relative group-hover:ring-4 ring-teal-100 transition-all duration-300">
                <img src="https://images.unsplash.com/photo-1579154204601-01588f351e67?auto=format&fit=crop&w=500&q=80" alt="Sample Collection" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-out">
                <div class="absolute inset-0 bg-teal-900/10 group-hover:bg-transparent transition-colors duration-300"></div>
            </div>
            <h4 class="font-bold text-gray-800 mb-2">Sample Collection</h4>
            <p class="text-xs text-gray-500 leading-relaxed pb-2">Our certified experts ensure a painless, highly hygienic, and fully compliant sample collection process.</p>
        </div>

        <!-- Step 4 -->
        <div class="group bg-white rounded-3xl p-4 shadow-lg hover:shadow-2xl hover:-translate-y-4 transition-all duration-500 border border-gray-100 flex flex-col items-center text-center relative mt-0 lg:-mt-4">
            <div class="w-12 h-12 bg-purple-500 text-white rounded-full flex items-center justify-center font-black text-xl absolute -top-5 shadow-lg shadow-purple-500/40 z-20 group-hover:scale-110 transition-transform duration-300">4</div>
            <div class="w-full h-40 rounded-2xl overflow-hidden mb-5 relative group-hover:ring-4 ring-purple-100 transition-all duration-300">
                <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=500&q=80" alt="Smart Reports" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-out">
                <div class="absolute inset-0 bg-purple-900/10 group-hover:bg-transparent transition-colors duration-300"></div>
            </div>
            <h4 class="font-bold text-gray-800 mb-2">Verified Smart Reports</h4>
            <p class="text-xs text-gray-500 leading-relaxed pb-2">Every report is clinically verified by expert MD doctors and packed with actionable health insights.</p>
        </div>

        <!-- Step 5 -->
        <div class="group bg-white rounded-3xl p-4 shadow-lg hover:shadow-2xl hover:-translate-y-4 transition-all duration-500 border border-gray-100 flex flex-col items-center text-center relative mt-0 lg:mt-8">
            <div class="w-12 h-12 bg-pink-500 text-white rounded-full flex items-center justify-center font-black text-xl absolute -top-5 shadow-lg shadow-pink-500/40 z-20 group-hover:scale-110 transition-transform duration-300">5</div>
            <div class="w-full h-40 rounded-2xl overflow-hidden mb-5 relative group-hover:ring-4 ring-pink-100 transition-all duration-300">
                <img src="https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=500&q=80" alt="Consultation" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-out">
                <div class="absolute inset-0 bg-pink-900/10 group-hover:bg-transparent transition-colors duration-300"></div>
            </div>
            <h4 class="font-bold text-gray-800 mb-2">Health Journey Continues</h4>
            <p class="text-xs text-gray-500 leading-relaxed pb-2">Post-report, easily consult with our expert medical team to plan the next steps for your well-being.</p>
        </div>
    </div>
</div>





    <!-- Health Calculators -->
<style>
@keyframes live-beat {
  0%, 100% { transform: scale(1); }
  15% { transform: scale(1.25); }
  30% { transform: scale(1); }
  45% { transform: scale(1.15); }
}
@keyframes live-rock {
  0%, 100% { transform: rotate(-15deg); }
  50% { transform: rotate(15deg); }
}
@keyframes live-spin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}
@keyframes live-drip {
  0% { transform: translateY(-5px) scaleY(1); opacity: 0; }
  50% { transform: translateY(0) scaleY(1.1); opacity: 1; }
  100% { transform: translateY(5px) scaleY(1); opacity: 0; }
}
.anim-beat { animation: live-beat 1.5s infinite; }
.anim-rock { animation: live-rock 2s infinite ease-in-out; }
.anim-spin { animation: live-spin 5s linear infinite; }
.anim-drip { animation: live-drip 1.5s infinite ease-in; }
</style>

<div class="container mx-auto px-4 py-12">
    <div class="text-center mb-10">
        <h2 class="text-3xl font-extrabold text-brand-dark mb-2">Health Calculators</h2>
        <p class="text-gray-500 font-medium">Use our free tools to track and monitor your health metrics instantly</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        <!-- BMI -->
        <div class="bg-white border border-blue-100 p-6 flex flex-col items-center text-center shadow-lg hover:shadow-2xl transition-all duration-300 rounded-tr-[50px] rounded-bl-[50px] rounded-tl-xl rounded-br-xl group border-b-4 hover:border-b-blue-500">
            <div class="bg-blue-50 w-20 h-20 rounded-tl-full rounded-tr-full rounded-br-full rounded-bl-lg mb-5 flex items-center justify-center text-blue-500 text-3xl shadow-inner relative overflow-hidden group-hover:bg-blue-100 transition">
                <i class="fas fa-weight anim-rock"></i>
            </div>
            <h4 class="font-bold text-gray-800 text-base mb-2">Body Mass Index (BMI)</h4>
            <p class="text-xs text-gray-500 mb-5 leading-relaxed flex-grow">Find out if your weight falls within the ideal range for your height and age instantly.</p>
            <a href="#" class="text-xs font-extrabold text-blue-600 bg-blue-50 px-4 py-2 rounded-full hover:bg-blue-500 hover:text-white transition w-full">Calculate BMI</a>
        </div>

        <!-- Heart Health -->
        <div class="bg-white border border-red-100 p-6 flex flex-col items-center text-center shadow-lg hover:shadow-2xl transition-all duration-300 rounded-tl-[50px] rounded-br-[50px] rounded-tr-xl rounded-bl-xl group border-b-4 hover:border-b-red-500">
            <div class="bg-red-50 w-20 h-20 rounded-tl-full rounded-tr-full rounded-bl-full rounded-br-lg mb-5 flex items-center justify-center text-red-500 text-3xl shadow-inner relative overflow-hidden group-hover:bg-red-100 transition">
                <i class="fas fa-heartbeat anim-beat"></i>
            </div>
            <h4 class="font-bold text-gray-800 text-base mb-2">Cardiovascular Risk</h4>
            <p class="text-xs text-gray-500 mb-5 leading-relaxed flex-grow">Evaluate your heart's overall health and discover early warning signs of cardiac issues.</p>
            <a href="#" class="text-xs font-extrabold text-red-600 bg-red-50 px-4 py-2 rounded-full hover:bg-red-500 hover:text-white transition w-full">Check Heart Health</a>
        </div>

        <!-- Pre-Diabetic -->
        <div class="bg-white border border-teal-100 p-6 flex flex-col items-center text-center shadow-lg hover:shadow-2xl transition-all duration-300 rounded-tr-[50px] rounded-bl-[50px] rounded-tl-xl rounded-br-xl group border-b-4 hover:border-b-teal-500">
            <div class="bg-teal-50 w-20 h-20 rounded-t-full rounded-b-full mb-5 flex items-center justify-center text-teal-500 text-3xl shadow-inner relative overflow-hidden group-hover:bg-teal-100 transition">
                <i class="fas fa-tint anim-drip"></i>
            </div>
            <h4 class="font-bold text-gray-800 text-base mb-2">Diabetes Risk Profiler</h4>
            <p class="text-xs text-gray-500 mb-5 leading-relaxed flex-grow">Identify your chances of pre-diabetes early with our comprehensive symptom checker.</p>
            <a href="#" class="text-xs font-extrabold text-teal-600 bg-teal-50 px-4 py-2 rounded-full hover:bg-teal-500 hover:text-white transition w-full">Evaluate Risk</a>
        </div>

        <!-- Vitamin D -->
        <div class="bg-white border border-yellow-100 p-6 flex flex-col items-center text-center shadow-lg hover:shadow-2xl transition-all duration-300 rounded-tl-[50px] rounded-br-[50px] rounded-tr-xl rounded-bl-xl group border-b-4 hover:border-b-yellow-500">
            <div class="bg-yellow-50 w-20 h-20 rounded-full mb-5 flex items-center justify-center text-yellow-500 text-3xl shadow-inner relative overflow-hidden group-hover:bg-yellow-100 transition">
                <i class="fas fa-sun anim-spin"></i>
            </div>
            <h4 class="font-bold text-gray-800 text-base mb-2">Vitamin Deficiency</h4>
            <p class="text-xs text-gray-500 mb-5 leading-relaxed flex-grow">Check for common signs of Vitamin D & B12 shortages that cause fatigue and bone pain.</p>
            <a href="#" class="text-xs font-extrabold text-yellow-600 bg-yellow-50 px-4 py-2 rounded-full hover:bg-yellow-500 hover:text-white transition w-full">Start Assessment</a>
        </div>
    </div>
</div>


    <!-- Create your Own Package Banner -->
<div class="container mx-auto px-4 py-6">
    <div class="rounded-3xl flex flex-col md:flex-row items-center justify-between p-6 sm:p-8 bg-gradient-to-r from-teal-900 via-teal-800 to-emerald-900 text-white shadow-xl overflow-hidden relative group">
        <!-- Subtle decorative glow -->
        <div class="absolute -top-12 -left-12 w-48 h-48 bg-emerald-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-12 right-1/4 w-48 h-48 bg-teal-400/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="z-10 md:w-3/5">
            <span class="bg-emerald-400/20 text-emerald-300 text-[11px] font-extrabold px-3 py-1 rounded-full border border-emerald-400/30 mb-3 inline-flex items-center gap-1.5 backdrop-blur-sm">
                <i class="fas fa-wand-magic-sparkles text-xs"></i> 100% Flexible Customisation
            </span>
            <h2 class="text-2xl sm:text-3xl font-black mb-2 tracking-tight text-white">Create Your Own Package</h2>
            <p class="text-xs sm:text-sm text-teal-100/90 mb-6 max-w-xl leading-relaxed">
                Customise your health package based on the tests you choose and unlock an extra <span class="font-extrabold text-amber-300">Flat 10% OFF</span> automatically.
            </p>
            <div class="flex flex-wrap items-center gap-3">
                <a href="#single-health-checkup" class="bg-gradient-to-r from-amber-400 to-yellow-400 text-teal-950 font-black py-2.5 px-6 rounded-xl hover:from-amber-300 hover:to-yellow-300 transition text-sm shadow-lg shadow-amber-400/20 flex items-center gap-2 cursor-pointer active:scale-95">
                    <span>Create Now</span>
                    <i class="fas fa-arrow-right text-xs"></i>
                </a>
                <a href="#enquiry-section" class="bg-white/10 hover:bg-white/20 text-white font-bold py-2.5 px-5 rounded-xl transition text-sm border border-white/20 backdrop-blur-sm flex items-center gap-1.5 cursor-pointer">
                    <i class="fas fa-phone-volume text-xs"></i>
                    <span>Doctor Assistance</span>
                </a>
            </div>
        </div>

        <div class="relative mt-6 md:mt-0 md:w-2/5 flex justify-center md:justify-end z-10">
            <div class="relative w-44 h-44 sm:w-52 sm:h-52 rounded-2xl overflow-hidden shadow-2xl border-2 border-white/20 transform md:rotate-2 group-hover:rotate-0 transition-all duration-500">
                <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=600&q=80" 
                     onerror="this.onerror=null; this.src='{{ asset('two-asian.jpg') }}';" 
                     alt="Customise Package" 
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                <div class="absolute bottom-2 left-2 right-2 bg-black/60 backdrop-blur-md rounded-xl p-1.5 text-center text-white border border-white/10">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-amber-300">3,600+ Tests Available</p>
                </div>
            </div>
        </div>
    </div>
</div>


    <!-- GeneCliffe Section -->
<div class="container mx-auto px-4 py-8">
    <div class="bg-gradient-to-br from-green-50 to-blue-50 rounded-[40px] p-6 md:p-10 flex flex-col md:flex-row items-center gap-8 border border-green-100 shadow-xl overflow-hidden relative">
        <!-- Decorative Background -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-green-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse" style="animation-delay: 2s;"></div>

        <div class="md:w-1/3 relative z-10">
            <h2 class="text-3xl font-extrabold text-brand-dark mb-4 leading-tight">Decode Your DNA for a Healthier Tomorrow</h2>
            <p class="text-sm text-gray-700 mb-6 leading-relaxed">Your genetic blueprint holds the key to proactive healthcare. Discover personalized insights to prevent diseases, optimize your diet, and make informed lifestyle choices.</p>
            <div class="flex flex-wrap items-center gap-3 mb-6">
                <a href="#" class="inline-flex items-center font-bold text-white bg-brand-dark px-6 py-3 rounded-full hover:bg-brand-secondary transition transform hover:scale-105 shadow-lg">Explore GeneCliffe <i class="fas fa-arrow-right ml-2"></i></a>
                <div class="flex space-x-2">
                    <button type="button" onclick="document.getElementById('gene-slider').scrollBy({left: -330, behavior: 'smooth'})" class="w-9 h-9 rounded-full bg-white text-brand-dark border border-green-200 flex items-center justify-center hover:bg-brand-secondary hover:text-white shadow-sm transition active:scale-95" title="Previous"><i class="fas fa-chevron-left text-xs"></i></button>
                    <button type="button" onclick="document.getElementById('gene-slider').scrollBy({left: 330, behavior: 'smooth'})" class="w-9 h-9 rounded-full bg-brand-dark text-white flex items-center justify-center hover:bg-brand-secondary shadow-md transition active:scale-95" title="Next"><i class="fas fa-chevron-right text-xs"></i></button>
                </div>
            </div>
        </div>
        
        <div class="md:w-2/3 w-full relative z-10">
            <!-- Slider Container -->
            <div id="gene-slider" class="flex space-x-6 overflow-x-auto hide-scroll-bar py-4 scroll-smooth snap-x snap-mandatory">
                
                <!-- Card 1 -->
                <div class="min-w-[280px] md:min-w-[320px] bg-white rounded-tr-[50px] rounded-bl-[50px] rounded-tl-xl rounded-br-xl shadow-lg border border-gray-100 p-5 flex flex-col h-full snap-center hover:-translate-y-2 transition-transform duration-300">
                    <div class="rounded-tr-[35px] rounded-bl-[35px] rounded-tl-lg rounded-br-lg overflow-hidden mb-5 relative group h-40">
                        <img src="https://images.unsplash.com/photo-1532094349884-543bc11b234d?auto=format&fit=crop&w=400&q=80" alt="Genome Mapping" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-brand-dark/20 group-hover:bg-transparent transition-colors"></div>
                    </div>
                    <div class="flex-grow">
                        <h4 class="font-extrabold text-brand-dark text-lg mb-2">Advanced Genome Mapping</h4>
                        <p class="text-xs text-gray-500 leading-relaxed">Unlock your complete genetic profile to identify silent mutations and understand your body at a cellular level.</p>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="button" onclick="document.getElementById('gene-slider').scrollBy({left: 330, behavior: 'smooth'})" class="w-8 h-8 rounded-full bg-green-100 text-green-700 flex items-center justify-center hover:bg-green-600 hover:text-white transition active:scale-95" title="Next Slide"><i class="fas fa-arrow-right text-xs"></i></button>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="min-w-[280px] md:min-w-[320px] bg-white rounded-tr-[50px] rounded-bl-[50px] rounded-tl-xl rounded-br-xl shadow-lg border border-gray-100 p-5 flex flex-col h-full snap-center hover:-translate-y-2 transition-transform duration-300">
                    <div class="rounded-tr-[35px] rounded-bl-[35px] rounded-tl-lg rounded-br-lg overflow-hidden mb-5 relative group h-40">
                        <img src="https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=400&q=80" alt="Hereditary Risk" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-brand-dark/20 group-hover:bg-transparent transition-colors"></div>
                    </div>
                    <div class="flex-grow">
                        <h4 class="font-extrabold text-brand-dark text-lg mb-2">Hereditary Risk Profiling</h4>
                        <p class="text-xs text-gray-500 leading-relaxed">Early detection saves lives. Learn if you carry genetic markers for hereditary cancers, cardiac issues, and more.</p>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="button" onclick="document.getElementById('gene-slider').scrollBy({left: 330, behavior: 'smooth'})" class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center hover:bg-blue-600 hover:text-white transition active:scale-95" title="Next Slide"><i class="fas fa-arrow-right text-xs"></i></button>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="min-w-[280px] md:min-w-[320px] bg-white rounded-tr-[50px] rounded-bl-[50px] rounded-tl-xl rounded-br-xl shadow-lg border border-gray-100 p-5 flex flex-col h-full snap-center hover:-translate-y-2 transition-transform duration-300">
                    <div class="rounded-tr-[35px] rounded-bl-[35px] rounded-tl-lg rounded-br-lg overflow-hidden mb-5 relative group h-40">
                        <img src="https://images.unsplash.com/photo-1581594693702-fbdc51b2763b?auto=format&fit=crop&w=400&q=80" alt="Nutrigenomics" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-brand-dark/20 group-hover:bg-transparent transition-colors"></div>
                    </div>
                    <div class="flex-grow">
                        <h4 class="font-extrabold text-brand-dark text-lg mb-2">Nutrigenomics (Diet & DNA)</h4>
                        <p class="text-xs text-gray-500 leading-relaxed">Stop guessing your diet. Discover exactly which foods your body processes best and which ones to avoid entirely.</p>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="button" onclick="document.getElementById('gene-slider').scrollBy({left: 330, behavior: 'smooth'})" class="w-8 h-8 rounded-full bg-yellow-100 text-yellow-700 flex items-center justify-center hover:bg-yellow-600 hover:text-white transition active:scale-95" title="Next Slide"><i class="fas fa-arrow-right text-xs"></i></button>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="min-w-[280px] md:min-w-[320px] bg-white rounded-tr-[50px] rounded-bl-[50px] rounded-tl-xl rounded-br-xl shadow-lg border border-gray-100 p-5 flex flex-col h-full snap-center hover:-translate-y-2 transition-transform duration-300">
                    <div class="rounded-tr-[35px] rounded-bl-[35px] rounded-tl-lg rounded-br-lg overflow-hidden mb-5 relative group h-40">
                        <img src="https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=400&q=80" alt="Gut Microbiome" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-brand-dark/20 group-hover:bg-transparent transition-colors"></div>
                    </div>
                    <div class="flex-grow">
                        <h4 class="font-extrabold text-brand-dark text-lg mb-2">Microbiome Analysis</h4>
                        <p class="text-xs text-gray-500 leading-relaxed">Map the millions of bacteria in your gut to resolve chronic digestion issues and boost your immune system organically.</p>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="button" onclick="document.getElementById('gene-slider').scrollBy({left: 330, behavior: 'smooth'})" class="w-8 h-8 rounded-full bg-purple-100 text-purple-700 flex items-center justify-center hover:bg-purple-600 hover:text-white transition active:scale-95" title="Next Slide"><i class="fas fa-arrow-right text-xs"></i></button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const slider = document.getElementById('gene-slider');
        let scrollAmount = 0;
        
        // Auto rotate every 3 seconds
        setInterval(() => {
            if(slider) {
                // If we've reached the end, scroll back to 0
                if (slider.scrollLeft + slider.clientWidth >= slider.scrollWidth - 10) {
                    slider.scrollTo({ left: 0, behavior: 'smooth' });
                } else {
                    // Scroll by the width of approximately one card
                    slider.scrollBy({ left: 320, behavior: 'smooth' });
                }
            }
        }, 3000);
    });
</script>


    <!-- Family Care Packages -->
<style>
    /* Custom Scrollbar for Slider */
    .slider-scrollbar::-webkit-scrollbar {
        height: 6px;
    }
    .slider-scrollbar::-webkit-scrollbar-track {
        background: #f1f5f9; 
        border-radius: 10px;
    }
    .slider-scrollbar::-webkit-scrollbar-thumb {
        background: #0f766e; /* brand-dark approximation */
        border-radius: 10px;
    }
    .slider-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #dc2626; /* brand-secondary approximation */
    }
</style>

<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-end mb-6">
        <div>
            <h2 class="section-title mb-0">Family Care Packages</h2>
            <p class="text-xs text-gray-500 mt-1">Slide to explore packages for your loved ones</p>
        </div>
        <div class="flex space-x-2">
            <button type="button" onclick="document.getElementById('family-slider').scrollBy({left: -340, behavior: 'smooth'})" class="w-8 h-8 rounded-full border border-gray-300 bg-white flex items-center justify-center text-gray-500 hover:text-brand-dark hover:border-brand-dark transition shadow-sm active:scale-95" title="Previous"><i class="fas fa-chevron-left text-xs"></i></button>
            <button type="button" onclick="document.getElementById('family-slider').scrollBy({left: 340, behavior: 'smooth'})" class="w-8 h-8 rounded-full bg-brand-dark text-white flex items-center justify-center hover:bg-brand-secondary transition shadow-md active:scale-95" title="Next"><i class="fas fa-chevron-right text-xs"></i></button>
        </div>
    </div>

    <div id="family-slider" class="flex space-x-6 overflow-x-auto pb-10 pt-4 px-2 snap-x snap-mandatory slider-scrollbar">
        
        <!-- Package 1 -->
        <div class="min-w-[280px] md:min-w-[320px] bg-white rounded-b-[30px] border-x-2 border-b-2 border-gray-800 mt-10 relative snap-center hover:-translate-y-1 transition-transform">
            <!-- Top Teal Band -->
            <div class="absolute -top-10 -left-[2px] -right-[2px] h-10 bg-brand-dark rounded-t-[30px]"></div>
            
            <!-- Circular Image Overlap -->
            <div class="absolute -bottom-6 right-8 w-16 h-16 rounded-full border-[6px] border-white bg-white shadow-md overflow-hidden z-10 flex items-center justify-center">
                <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=100&q=80" alt="Mother" class="w-full h-full object-cover">
            </div>
            
            <div class="p-6">
                <h3 class="font-extrabold text-brand-dark text-xl mb-3 leading-tight pt-1">Free HsCRP With Annual Health Checkup</h3>
                <p class="text-xs text-gray-500 mb-6 leading-relaxed">Comprehensive testing specifically tailored for maternal health and holistic wellness.</p>
                
                <div class="flex items-center mb-2">
                    <span class="text-2xl font-black text-brand-secondary">₹1,799/-</span>
                </div>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Recommended For: <span class="text-brand-dark">Mothers</span></p>
            </div>
        </div>

        <!-- Package 2 -->
        <div class="min-w-[280px] md:min-w-[320px] bg-white rounded-b-[30px] border-x-2 border-b-2 border-gray-800 mt-10 relative snap-center hover:-translate-y-1 transition-transform">
            <!-- Top Teal Band -->
            <div class="absolute -top-10 -left-[2px] -right-[2px] h-10 bg-brand-dark rounded-t-[30px]"></div>
            
            <!-- Circular Image Overlap -->
            <div class="absolute -bottom-6 right-8 w-16 h-16 rounded-full border-[6px] border-white bg-white shadow-md overflow-hidden z-10 flex items-center justify-center">
                <img src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?auto=format&fit=crop&w=100&q=80" alt="Father" class="w-full h-full object-cover">
            </div>
            
            <div class="p-6">
                <h3 class="font-extrabold text-brand-dark text-xl mb-3 leading-tight pt-1">Annual Health Checkup - Advance Plus</h3>
                <p class="text-xs text-gray-500 mb-6 leading-relaxed">Includes a free HsCRP test. Vital heart and body profiling for complete peace of mind.</p>
                
                <div class="flex items-center mb-2">
                    <span class="text-2xl font-black text-brand-secondary">₹2,499/-</span>
                </div>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Recommended For: <span class="text-brand-dark">Fathers</span></p>
            </div>
        </div>

        <!-- Package 3 -->
        <div class="min-w-[280px] md:min-w-[320px] bg-white rounded-b-[30px] border-x-2 border-b-2 border-gray-800 mt-10 relative snap-center hover:-translate-y-1 transition-transform">
            <!-- Top Teal Band -->
            <div class="absolute -top-10 -left-[2px] -right-[2px] h-10 bg-brand-dark rounded-t-[30px]"></div>
            
            <!-- Circular Image Overlap -->
            <div class="absolute -bottom-6 right-8 w-16 h-16 rounded-full border-[6px] border-white bg-white shadow-md overflow-hidden z-10 flex items-center justify-center">
                <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=100&q=80" alt="Women" class="w-full h-full object-cover">
            </div>
            
            <div class="p-6">
                <h3 class="font-extrabold text-brand-dark text-xl mb-3 leading-tight pt-1">Fit India Full Body Checkup + Vit B12</h3>
                <p class="text-xs text-gray-500 mb-6 leading-relaxed">Advanced screening to uncover hidden deficiencies and ensure peak performance.</p>
                
                <div class="flex items-center mb-2">
                    <span class="text-2xl font-black text-brand-secondary">₹1,399/-</span>
                </div>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Recommended For: <span class="text-brand-dark">Women</span></p>
            </div>
        </div>
        
    </div>
</div>




    <style>
        @keyframes marquee {
            0% { transform: translateX(0%); }
            100% { transform: translateX(-50%); }
        }
        .marquee-container {
            overflow: hidden;
            width: 100%;
            position: relative;
        }
        /* Optional fade effect on edges */
        .marquee-container::before, .marquee-container::after {
            content: "";
            position: absolute;
            top: 0;
            width: 100px;
            height: 100%;
            z-index: 2;
            pointer-events: none;
        }
        .marquee-container::before {
            left: 0;
            background: linear-gradient(to right, white, transparent);
        }
        .marquee-container::after {
            right: 0;
            background: linear-gradient(to left, white, transparent);
        }
        
        .marquee-track {
            display: inline-flex;
            width: max-content;
            animation: marquee 35s linear infinite;
        }
        .marquee-track:hover {
            animation-play-state: paused;
        }
        .marquee-track-reverse {
            display: inline-flex;
            width: max-content;
            animation: marquee 35s linear infinite reverse;
        }
        .marquee-track-reverse:hover {
            animation-play-state: paused;
        }
    </style>

    <!-- Why Millions Trust Av Wellcare Diagnostics -->
<div class="container mx-auto px-4 py-12 overflow-hidden">
    <div class="text-center mb-10">
        <h2 class="section-title mb-2 text-3xl">Why Millions Trust Av Wellcare</h2>
        <p class="text-sm text-gray-500">Real stories from our valued patients</p>
    </div>

    <div class="marquee-container mb-12 pb-4">
        <div class="marquee-track">
            <!-- Patient Cards Set 1 -->
            <div class="min-w-[300px] max-w-[300px] md:min-w-[400px] md:max-w-[400px] bg-teal-50 rounded-[20px] p-6 mx-3 shadow-sm border border-teal-100 flex flex-col whitespace-normal transition-transform transform hover:-translate-y-2">
                <i class="fas fa-quote-left text-teal-200 text-3xl mb-3"></i>
                <p class="text-sm text-gray-700 mb-4 italic leading-relaxed flex-grow font-medium">"The home collection service was incredibly prompt and professional. I got my reports on WhatsApp the very same day. Highly recommended!"</p>
                <div class="flex items-center mt-auto">
                    <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=100&q=80" alt="Patient" class="w-12 h-12 rounded-full mr-3 border-2 border-brand-dark p-0.5 object-cover">
                    <div>
                        <h4 class="font-bold text-brand-dark text-sm">Sunita R.</h4>
                        <p class="text-[10px] text-teal-700 font-semibold uppercase tracking-wider"><i class="fas fa-check-circle mr-1"></i>Verified Patient</p>
                    </div>
                </div>
            </div>

            <div class="min-w-[300px] max-w-[300px] md:min-w-[400px] md:max-w-[400px] bg-teal-50 rounded-[20px] p-6 mx-3 shadow-sm border border-teal-100 flex flex-col whitespace-normal transition-transform transform hover:-translate-y-2">
                <i class="fas fa-quote-left text-teal-200 text-3xl mb-3"></i>
                <p class="text-sm text-gray-700 mb-4 italic leading-relaxed flex-grow font-medium">"I booked the Fit India package for my parents. The phlebotomist was very patient, and the reports were detailed and easy to understand."</p>
                <div class="flex items-center mt-auto">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=100&q=80" alt="Patient" class="w-12 h-12 rounded-full mr-3 border-2 border-brand-dark p-0.5 object-cover">
                    <div>
                        <h4 class="font-bold text-brand-dark text-sm">Vikram S.</h4>
                        <p class="text-[10px] text-teal-700 font-semibold uppercase tracking-wider"><i class="fas fa-check-circle mr-1"></i>Verified Patient</p>
                    </div>
                </div>
            </div>

            <div class="min-w-[300px] max-w-[300px] md:min-w-[400px] md:max-w-[400px] bg-teal-50 rounded-[20px] p-6 mx-3 shadow-sm border border-teal-100 flex flex-col whitespace-normal transition-transform transform hover:-translate-y-2">
                <i class="fas fa-quote-left text-teal-200 text-3xl mb-3"></i>
                <p class="text-sm text-gray-700 mb-4 italic leading-relaxed flex-grow font-medium">"Their molecular diagnostics lab is top-notch. I needed urgent allergy testing and Av Wellcare delivered accurate results flawlessly."</p>
                <div class="flex items-center mt-auto">
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=100&q=80" alt="Patient" class="w-12 h-12 rounded-full mr-3 border-2 border-brand-dark p-0.5 object-cover">
                    <div>
                        <h4 class="font-bold text-brand-dark text-sm">Anjali M.</h4>
                        <p class="text-[10px] text-teal-700 font-semibold uppercase tracking-wider"><i class="fas fa-check-circle mr-1"></i>Verified Patient</p>
                    </div>
                </div>
            </div>
            
            <div class="min-w-[300px] max-w-[300px] md:min-w-[400px] md:max-w-[400px] bg-teal-50 rounded-[20px] p-6 mx-3 shadow-sm border border-teal-100 flex flex-col whitespace-normal transition-transform transform hover:-translate-y-2">
                <i class="fas fa-quote-left text-teal-200 text-3xl mb-3"></i>
                <p class="text-sm text-gray-700 mb-4 italic leading-relaxed flex-grow font-medium">"I appreciate the smart report feature! It highlights exactly what's out of range so I don't have to guess. Very modern clinic."</p>
                <div class="flex items-center mt-auto">
                    <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=100&q=80" alt="Patient" class="w-12 h-12 rounded-full mr-3 border-2 border-brand-dark p-0.5 object-cover">
                    <div>
                        <h4 class="font-bold text-brand-dark text-sm">Rahul K.</h4>
                        <p class="text-[10px] text-teal-700 font-semibold uppercase tracking-wider"><i class="fas fa-check-circle mr-1"></i>Verified Patient</p>
                    </div>
                </div>
            </div>

            <!-- Patient Cards Set 2 (Duplicated for seamless loop) -->
            <div class="min-w-[300px] max-w-[300px] md:min-w-[400px] md:max-w-[400px] bg-teal-50 rounded-[20px] p-6 mx-3 shadow-sm border border-teal-100 flex flex-col whitespace-normal transition-transform transform hover:-translate-y-2">
                <i class="fas fa-quote-left text-teal-200 text-3xl mb-3"></i>
                <p class="text-sm text-gray-700 mb-4 italic leading-relaxed flex-grow font-medium">"The home collection service was incredibly prompt and professional. I got my reports on WhatsApp the very same day. Highly recommended!"</p>
                <div class="flex items-center mt-auto">
                    <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=100&q=80" alt="Patient" class="w-12 h-12 rounded-full mr-3 border-2 border-brand-dark p-0.5 object-cover">
                    <div>
                        <h4 class="font-bold text-brand-dark text-sm">Sunita R.</h4>
                        <p class="text-[10px] text-teal-700 font-semibold uppercase tracking-wider"><i class="fas fa-check-circle mr-1"></i>Verified Patient</p>
                    </div>
                </div>
            </div>

            <div class="min-w-[300px] max-w-[300px] md:min-w-[400px] md:max-w-[400px] bg-teal-50 rounded-[20px] p-6 mx-3 shadow-sm border border-teal-100 flex flex-col whitespace-normal transition-transform transform hover:-translate-y-2">
                <i class="fas fa-quote-left text-teal-200 text-3xl mb-3"></i>
                <p class="text-sm text-gray-700 mb-4 italic leading-relaxed flex-grow font-medium">"I booked the Fit India package for my parents. The phlebotomist was very patient, and the reports were detailed and easy to understand."</p>
                <div class="flex items-center mt-auto">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=100&q=80" alt="Patient" class="w-12 h-12 rounded-full mr-3 border-2 border-brand-dark p-0.5 object-cover">
                    <div>
                        <h4 class="font-bold text-brand-dark text-sm">Vikram S.</h4>
                        <p class="text-[10px] text-teal-700 font-semibold uppercase tracking-wider"><i class="fas fa-check-circle mr-1"></i>Verified Patient</p>
                    </div>
                </div>
            </div>

            <div class="min-w-[300px] max-w-[300px] md:min-w-[400px] md:max-w-[400px] bg-teal-50 rounded-[20px] p-6 mx-3 shadow-sm border border-teal-100 flex flex-col whitespace-normal transition-transform transform hover:-translate-y-2">
                <i class="fas fa-quote-left text-teal-200 text-3xl mb-3"></i>
                <p class="text-sm text-gray-700 mb-4 italic leading-relaxed flex-grow font-medium">"Their molecular diagnostics lab is top-notch. I needed urgent allergy testing and Av Wellcare delivered accurate results flawlessly."</p>
                <div class="flex items-center mt-auto">
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=100&q=80" alt="Patient" class="w-12 h-12 rounded-full mr-3 border-2 border-brand-dark p-0.5 object-cover">
                    <div>
                        <h4 class="font-bold text-brand-dark text-sm">Anjali M.</h4>
                        <p class="text-[10px] text-teal-700 font-semibold uppercase tracking-wider"><i class="fas fa-check-circle mr-1"></i>Verified Patient</p>
                    </div>
                </div>
            </div>
            
            <div class="min-w-[300px] max-w-[300px] md:min-w-[400px] md:max-w-[400px] bg-teal-50 rounded-[20px] p-6 mx-3 shadow-sm border border-teal-100 flex flex-col whitespace-normal transition-transform transform hover:-translate-y-2">
                <i class="fas fa-quote-left text-teal-200 text-3xl mb-3"></i>
                <p class="text-sm text-gray-700 mb-4 italic leading-relaxed flex-grow font-medium">"I appreciate the smart report feature! It highlights exactly what's out of range so I don't have to guess. Very modern clinic."</p>
                <div class="flex items-center mt-auto">
                    <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=100&q=80" alt="Patient" class="w-12 h-12 rounded-full mr-3 border-2 border-brand-dark p-0.5 object-cover">
                    <div>
                        <h4 class="font-bold text-brand-dark text-sm">Rahul K.</h4>
                        <p class="text-[10px] text-teal-700 font-semibold uppercase tracking-wider"><i class="fas fa-check-circle mr-1"></i>Verified Patient</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="text-center mb-10 mt-6">
        <h2 class="section-title mb-2 text-3xl">What Doctors Are Saying</h2>
        <p class="text-sm text-gray-500">Trusted by the medical community</p>
    </div>

    <!-- Doctors Marquee (Moving Opposite Direction) -->
    <div class="marquee-container pb-10">
        <div class="marquee-track-reverse">
            <!-- Doctor Cards Set 1 -->
            <div class="min-w-[300px] max-w-[300px] md:min-w-[400px] md:max-w-[400px] bg-red-50 rounded-[20px] p-6 mx-3 shadow-sm border border-red-100 flex flex-col whitespace-normal transition-transform transform hover:-translate-y-2">
                <i class="fas fa-user-md text-red-200 text-3xl mb-3"></i>
                <p class="text-sm text-gray-700 mb-4 italic leading-relaxed flex-grow font-medium">"I always recommend Av Wellcare to my patients because their molecular diagnostics are highly reliable. Accurate testing is the backbone of good treatment."</p>
                <div class="flex items-center mt-auto">
                    <img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=100&q=80" alt="Doctor" class="w-12 h-12 rounded-full mr-3 border-2 border-brand-secondary p-0.5 object-cover">
                    <div>
                        <h4 class="font-bold text-brand-dark text-sm">Dr. Amit Sharma</h4>
                        <p class="text-[10px] text-red-700 font-semibold uppercase tracking-wider">Chief Cardiologist</p>
                    </div>
                </div>
            </div>

            <div class="min-w-[300px] max-w-[300px] md:min-w-[400px] md:max-w-[400px] bg-red-50 rounded-[20px] p-6 mx-3 shadow-sm border border-red-100 flex flex-col whitespace-normal transition-transform transform hover:-translate-y-2">
                <i class="fas fa-user-md text-red-200 text-3xl mb-3"></i>
                <p class="text-sm text-gray-700 mb-4 italic leading-relaxed flex-grow font-medium">"Av Wellcare Diagnostics has been an invaluable partner. Their commitment to using the latest automation technologies ensures zero human error in critical reports."</p>
                <div class="flex items-center mt-auto">
                    <img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=100&q=80" alt="Doctor" class="w-12 h-12 rounded-full mr-3 border-2 border-brand-secondary p-0.5 object-cover">
                    <div>
                        <h4 class="font-bold text-brand-dark text-sm">Dr. Saneesh KV</h4>
                        <p class="text-[10px] text-red-700 font-semibold uppercase tracking-wider">Fetal Medicine Specialist</p>
                    </div>
                </div>
            </div>

            <div class="min-w-[300px] max-w-[300px] md:min-w-[400px] md:max-w-[400px] bg-red-50 rounded-[20px] p-6 mx-3 shadow-sm border border-red-100 flex flex-col whitespace-normal transition-transform transform hover:-translate-y-2">
                <i class="fas fa-user-md text-red-200 text-3xl mb-3"></i>
                <p class="text-sm text-gray-700 mb-4 italic leading-relaxed flex-grow font-medium">"The GeneCliffe genomic testing provided by Av Wellcare allows us to personalize treatments like never before. They are pioneering predictive healthcare."</p>
                <div class="flex items-center mt-auto">
                    <img src="https://images.unsplash.com/photo-1594824432258-f99f36b63795?auto=format&fit=crop&w=100&q=80" alt="Doctor" class="w-12 h-12 rounded-full mr-3 border-2 border-brand-secondary p-0.5 object-cover">
                    <div>
                        <h4 class="font-bold text-brand-dark text-sm">Dr. Priya Menon</h4>
                        <p class="text-[10px] text-red-700 font-semibold uppercase tracking-wider">Genetics & Oncology</p>
                    </div>
                </div>
            </div>

            <!-- Doctor Cards Set 2 (Duplicated for seamless loop) -->
            <div class="min-w-[300px] max-w-[300px] md:min-w-[400px] md:max-w-[400px] bg-red-50 rounded-[20px] p-6 mx-3 shadow-sm border border-red-100 flex flex-col whitespace-normal transition-transform transform hover:-translate-y-2">
                <i class="fas fa-user-md text-red-200 text-3xl mb-3"></i>
                <p class="text-sm text-gray-700 mb-4 italic leading-relaxed flex-grow font-medium">"I always recommend Av Wellcare to my patients because their molecular diagnostics are highly reliable. Accurate testing is the backbone of good treatment."</p>
                <div class="flex items-center mt-auto">
                    <img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=100&q=80" alt="Doctor" class="w-12 h-12 rounded-full mr-3 border-2 border-brand-secondary p-0.5 object-cover">
                    <div>
                        <h4 class="font-bold text-brand-dark text-sm">Dr. Amit Sharma</h4>
                        <p class="text-[10px] text-red-700 font-semibold uppercase tracking-wider">Chief Cardiologist</p>
                    </div>
                </div>
            </div>

            <div class="min-w-[300px] max-w-[300px] md:min-w-[400px] md:max-w-[400px] bg-red-50 rounded-[20px] p-6 mx-3 shadow-sm border border-red-100 flex flex-col whitespace-normal transition-transform transform hover:-translate-y-2">
                <i class="fas fa-user-md text-red-200 text-3xl mb-3"></i>
                <p class="text-sm text-gray-700 mb-4 italic leading-relaxed flex-grow font-medium">"Av Wellcare Diagnostics has been an invaluable partner. Their commitment to using the latest automation technologies ensures zero human error in critical reports."</p>
                <div class="flex items-center mt-auto">
                    <img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=100&q=80" alt="Doctor" class="w-12 h-12 rounded-full mr-3 border-2 border-brand-secondary p-0.5 object-cover">
                    <div>
                        <h4 class="font-bold text-brand-dark text-sm">Dr. Saneesh KV</h4>
                        <p class="text-[10px] text-red-700 font-semibold uppercase tracking-wider">Fetal Medicine Specialist</p>
                    </div>
                </div>
            </div>

            <div class="min-w-[300px] max-w-[300px] md:min-w-[400px] md:max-w-[400px] bg-red-50 rounded-[20px] p-6 mx-3 shadow-sm border border-red-100 flex flex-col whitespace-normal transition-transform transform hover:-translate-y-2">
                <i class="fas fa-user-md text-red-200 text-3xl mb-3"></i>
                <p class="text-sm text-gray-700 mb-4 italic leading-relaxed flex-grow font-medium">"The GeneCliffe genomic testing provided by Av Wellcare allows us to personalize treatments like never before. They are pioneering predictive healthcare."</p>
                <div class="flex items-center mt-auto">
                    <img src="https://images.unsplash.com/photo-1594824432258-f99f36b63795?auto=format&fit=crop&w=100&q=80" alt="Doctor" class="w-12 h-12 rounded-full mr-3 border-2 border-brand-secondary p-0.5 object-cover">
                    <div>
                        <h4 class="font-bold text-brand-dark text-sm">Dr. Priya Menon</h4>
                        <p class="text-[10px] text-red-700 font-semibold uppercase tracking-wider">Genetics & Oncology</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    <!-- Awards & Recognition -->
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-end mb-6">
        <h2 class="section-title mb-0">Awards & Recognition</h2>
        <a href="#" class="text-xs font-bold text-gray-500 hover:text-brand-secondary border-b border-gray-400 border-dashed">View All ></a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Award 1 -->
        <div class="border border-teal-100 rounded-2xl p-4 bg-teal-50 shadow-sm flex justify-between items-center overflow-hidden transition-transform hover:-translate-y-1">
            <div class="w-2/3 pr-2">
                <span class="text-[8px] bg-teal-100 text-teal-800 px-2 py-0.5 rounded uppercase font-bold tracking-wider mb-2 inline-block">Excellence in Diagnostics</span>
                <h4 class="font-bold text-brand-dark text-sm leading-tight mt-1 mb-4">Best Diagnostic Lab<br>of the Year</h4>
                <p class="text-[10px] text-teal-600 font-bold uppercase"><i class="fas fa-trophy mr-1"></i> Healthcare Excellence Awards</p>
            </div>
            <div class="w-1/3 flex justify-end">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-inner border-2 border-teal-100">
                    <i class="fas fa-award text-3xl text-teal-500"></i>
                </div>
            </div>
        </div>
        <!-- Award 2 -->
        <div class="border border-yellow-100 rounded-2xl p-4 bg-yellow-50 shadow-sm flex justify-between items-center overflow-hidden transition-transform hover:-translate-y-1">
            <div class="w-2/3 pr-2 z-10">
                <span class="text-[8px] bg-yellow-200 text-yellow-800 px-2 py-0.5 rounded uppercase font-bold tracking-wider mb-2 inline-block">Patient Safety & Care</span>
                <h4 class="font-bold text-brand-dark text-sm leading-tight mt-1 mb-4">Highest Standards in<br>Patient Safety</h4>
                <p class="text-[10px] text-yellow-600 font-bold uppercase"><i class="fas fa-shield-alt mr-1"></i> National Health Board</p>
            </div>
            <div class="w-1/3 flex justify-end z-10">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-inner border-2 border-yellow-100">
                    <i class="fas fa-medal text-3xl text-yellow-500"></i>
                </div>
            </div>
        </div>
        <!-- Award 3 -->
        <div class="border border-teal-100 rounded-2xl p-4 bg-teal-50 shadow-sm flex justify-between items-center overflow-hidden transition-transform hover:-translate-y-1">
            <div class="w-2/3 pr-2">
                <span class="text-[8px] bg-teal-100 text-teal-800 px-2 py-0.5 rounded uppercase font-bold tracking-wider mb-2 inline-block">Innovation in Tech</span>
                <h4 class="font-bold text-brand-dark text-sm leading-tight mt-1 mb-4">Pioneers in Molecular<br>Diagnostics</h4>
                <p class="text-[10px] text-teal-600 font-bold uppercase"><i class="fas fa-microscope mr-1"></i> Medical Tech Summit</p>
            </div>
            <div class="w-1/3 flex justify-end">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-inner border-2 border-teal-100">
                    <i class="fas fa-certificate text-3xl text-teal-500"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- Slider dots mockup -->
    <div class="flex justify-center mt-6 space-x-1">
        <div class="w-4 h-1 bg-brand-dark rounded-full"></div>
        <div class="w-1 h-1 bg-gray-300 rounded-full"></div>
    </div>
</div>


    <!-- Patient Reviews & Testimonials Section -->
    @include('frontend.partials.reviews-section')

    <!-- Contact & Quick Medical Enquiry Section -->
    @include('frontend.partials.enquiry-section')

    <!-- Package Clinical Breakdown Modal (Dr Lal / 1mg Style) -->
    @include('frontend.partials.package-details-modal')

    <!-- Femcliffe Information Modal -->
    <div id="femcliffeModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm hidden transition-opacity duration-300">
        <div class="relative w-full max-w-xl bg-white rounded-3xl shadow-2xl border border-pink-100 overflow-hidden flex flex-col max-h-[90vh] animate-in fade-in zoom-in duration-200">
            <!-- Modal Header -->
            <div class="p-6 bg-gradient-to-r from-pink-700 via-rose-700 to-purple-800 text-white relative flex items-start justify-between">
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 text-pink-100 text-xs font-bold mb-2 backdrop-blur-md border border-white/20">
                        <i class="fas fa-venus"></i> India's First She-Centric Diagnostic Platform
                    </span>
                    <h3 class="text-2xl font-black tracking-tight">About Femcliffe</h3>
                    <p class="text-xs text-pink-100/90 mt-1">Dedicated to women's hormonal, reproductive & preventive wellness</p>
                </div>
                <button type="button" onclick="closeFemcliffeModal()" class="text-white/80 hover:text-white bg-white/10 hover:bg-white/20 p-2 rounded-xl transition cursor-pointer">
                    <i class="fas fa-times text-base"></i>
                </button>
            </div>

            <!-- Modal Content -->
            <div class="p-6 overflow-y-auto space-y-4 text-sm text-gray-700">
                <div class="flex items-start gap-3.5 p-3.5 rounded-2xl bg-pink-50/70 border border-pink-100">
                    <div class="w-10 h-10 rounded-xl bg-pink-100 text-pink-600 flex items-center justify-center flex-shrink-0 text-base">
                        <i class="fas fa-user-nurse"></i>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-gray-900 text-sm">Certified Female Phlebotomists</h4>
                        <p class="text-xs text-gray-600 mt-0.5 leading-relaxed">Sample collection by experienced women phlebotomists in the comfort and privacy of your home.</p>
                    </div>
                </div>

                <div class="flex items-start gap-3.5 p-3.5 rounded-2xl bg-purple-50/70 border border-purple-100">
                    <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center flex-shrink-0 text-base">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-gray-900 text-sm">Hormone & Menstrual Cycle References</h4>
                        <p class="text-xs text-gray-600 mt-0.5 leading-relaxed">Test values and interpretations calibrated against standard follicular, ovulatory, and luteal phases.</p>
                    </div>
                </div>

                <div class="flex items-start gap-3.5 p-3.5 rounded-2xl bg-rose-50/70 border border-rose-100">
                    <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center flex-shrink-0 text-base">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-gray-900 text-sm">100% Confidential & Secure Reports</h4>
                        <p class="text-xs text-gray-600 mt-0.5 leading-relaxed">Encrypted digital reports delivered directly to your verified WhatsApp and secure patient portal.</p>
                    </div>
                </div>

                <div class="flex items-start gap-3.5 p-3.5 rounded-2xl bg-teal-50/70 border border-teal-100">
                    <div class="w-10 h-10 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center flex-shrink-0 text-base">
                        <i class="fas fa-stethoscope"></i>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-gray-900 text-sm">Complimentary Doctor Consultation</h4>
                        <p class="text-xs text-gray-600 mt-0.5 leading-relaxed">Free medical guidance on report analysis for abnormal parameters with certified gynecologists.</p>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="p-5 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                <span class="text-xs text-gray-500">Need immediate help? Call 898 898 8787</span>
                <button type="button" onclick="closeFemcliffeModal(); document.getElementById('femcliffe-section').scrollIntoView({behavior: 'smooth'})" class="px-5 py-2.5 bg-gradient-to-r from-pink-600 to-purple-600 text-white rounded-xl text-xs font-extrabold shadow-md shadow-pink-500/20 hover:opacity-95 transition cursor-pointer">
                    Explore Packages
                </button>
            </div>
        </div>
    </div>

    @php
        $allPackagesForModal = ($packages ?? collect())->merge($habitPackages ?? collect())->merge($femcliffePackages ?? collect())->unique('id');
        $packagesModalPayload = [];
        foreach ($allPackagesForModal as $p) {
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

        function openFemcliffeModal() {
            const modal = document.getElementById('femcliffeModal');
            if (modal) modal.classList.remove('hidden');
        }

        function closeFemcliffeModal() {
            const modal = document.getElementById('femcliffeModal');
            if (modal) modal.classList.add('hidden');
        }

        function filterPackages(section, category, btn) {
            const sliderId = section === 'habit' ? 'habits-slider' : 'femcliffe-slider';
            const tabsId = section === 'habit' ? 'habits-tabs' : 'femcliffe-tabs';
            const cardClass = section === 'habit' ? '.habit-card' : '.femcliffe-card';
            const emptyId = section === 'habit' ? 'habits-empty-state' : 'femcliffe-empty-state';

            const slider = document.getElementById(sliderId);
            const tabsContainer = document.getElementById(tabsId);
            if (!slider || !tabsContainer) return;

            // Reset tab styles
            const tabs = tabsContainer.querySelectorAll('button');
            tabs.forEach(t => {
                if (section === 'habit') {
                    t.className = 'habit-tab bg-white border border-gray-200 text-gray-700 px-4 py-2 rounded-xl text-sm font-semibold min-w-max hover:bg-gray-50 hover:border-gray-300 transition-all shadow-xs';
                } else {
                    t.className = 'femcliffe-tab bg-white border border-pink-200 text-gray-700 px-5 py-2 rounded-xl text-sm font-semibold min-w-max hover:bg-pink-50 hover:text-pink-700 hover:border-pink-300 transition-all shadow-xs';
                }
            });

            // Activate clicked tab
            if (btn) {
                if (section === 'habit') {
                    btn.className = 'habit-tab bg-brand-dark text-white px-5 py-2 rounded-xl text-sm font-bold min-w-max shadow-md transition-all scale-102';
                } else {
                    btn.className = 'femcliffe-tab bg-gradient-to-r from-pink-600 to-purple-600 text-white px-5 py-2 rounded-xl text-sm font-bold min-w-max shadow-md shadow-pink-500/20 transition-all scale-102';
                }
            }

            // Filter cards
            const cards = slider.querySelectorAll(cardClass);
            const emptyState = document.getElementById(emptyId);
            let visibleCount = 0;
            const targetCat = (category || 'All').trim().toLowerCase();

            cards.forEach(card => {
                const cardCat = (card.getAttribute('data-category') || '').trim().toLowerCase();
                let isMatch = false;

                if (targetCat === 'all') {
                    isMatch = true;
                } else if (cardCat === targetCat) {
                    isMatch = true;
                } else if (cardCat.includes(targetCat) || targetCat.includes(cardCat)) {
                    isMatch = true;
                } else {
                    // Category synonyms
                    if (targetCat.includes('pcos') && cardCat.includes('pcos')) isMatch = true;
                    if (targetCat.includes('smok') && cardCat.includes('smok')) isMatch = true;
                    if (targetCat.includes('alcoh') && cardCat.includes('alcoh')) isMatch = true;
                    if (targetCat.includes('sleep') && (cardCat.includes('sleep') || cardCat.includes('insomnia'))) isMatch = true;
                    if (targetCat.includes('cancer') && cardCat.includes('cancer')) isMatch = true;
                }

                if (isMatch) {
                    card.style.display = 'flex';
                    card.classList.remove('hidden');
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                    card.classList.add('hidden');
                }
            });

            if (emptyState) {
                if (visibleCount === 0) {
                    emptyState.classList.remove('hidden');
                    const span = emptyState.querySelector('.empty-category-name');
                    if (span) span.innerText = category;
                } else {
                    emptyState.classList.add('hidden');
                }
            }

            // Reset scroll position
            slider.scrollTo({ left: 0, behavior: 'smooth' });
        }
    </script>
@endsection
