@extends('frontend.layouts.app')

@section('title', 'Vitamin Deficiency Assessment (Vitamins D3 & B12) | Av Wellcare Diagnostics')

@section('content')
<!-- Ambient Background Elements -->
<div class="fixed inset-0 z-[-1] pointer-events-none overflow-hidden bg-slate-50/60">
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-amber-200/30 rounded-full blur-3xl"></div>
    <div class="absolute top-96 -right-32 w-96 h-96 bg-yellow-200/20 rounded-full blur-3xl"></div>
</div>

<div class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-xs font-semibold text-gray-500 mb-6" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-teal-700 transition flex items-center gap-1.5">
            <i class="fas fa-home text-gray-400"></i>
            <span>Home</span>
        </a>
        <i class="fas fa-chevron-right text-[9px] text-gray-300"></i>
        <a href="{{ route('calculators.index') }}" class="hover:text-teal-700 transition">Health Calculators</a>
        <i class="fas fa-chevron-right text-[9px] text-gray-300"></i>
        <span class="text-amber-700 font-bold">Vitamin Deficiency</span>
    </nav>

    <!-- Header Section -->
    <div class="mb-8">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-50 text-amber-800 text-xs font-bold uppercase tracking-wider mb-2 border border-amber-200/70">
            <i class="fas fa-sun text-amber-600"></i> Micronutrient Self-Assessment
        </div>
        <h1 class="text-2xl sm:text-4xl font-black text-gray-900 tracking-tight">
            Vitamin D3 & B12 Deficiency Profiler
        </h1>
        <p class="text-xs sm:text-sm text-gray-500 mt-1 max-w-2xl">
            Over 75% of urban Indians live with silent Vitamin D3 or B12 shortages. Answer questions regarding your sunlight, diet, and clinical symptoms to assess your risk.
        </p>
    </div>

    <!-- Main Assessment Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-14">
        
        <!-- Left 7 Cols: Questionnaire -->
        <div class="lg:col-span-7 space-y-6">
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm space-y-6">
                
                <!-- 1. Sunlight Exposure -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                        1. Daily Direct Sunlight Exposure (Between 10:00 AM – 3:00 PM)
                    </label>
                    <p class="text-[11px] text-gray-500 mb-3">Skin exposure without sunscreen on face, arms, or legs</p>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="vit_sun" value="low" checked class="peer sr-only" onchange="calculateVitaminRisk()">
                            <div class="p-3.5 rounded-2xl border-2 border-gray-200 peer-checked:border-amber-500 peer-checked:bg-amber-50/50 flex flex-col items-center justify-center text-center transition">
                                <i class="fas fa-cloud-sun text-amber-500 text-lg mb-1"></i>
                                <span class="text-xs font-bold text-gray-800 peer-checked:text-amber-900">&lt; 15 mins / day</span>
                                <span class="text-[10px] text-gray-400">Mostly indoors</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="vit_sun" value="mid" class="peer sr-only" onchange="calculateVitaminRisk()">
                            <div class="p-3.5 rounded-2xl border-2 border-gray-200 peer-checked:border-amber-500 peer-checked:bg-amber-50/50 flex flex-col items-center justify-center text-center transition">
                                <i class="fas fa-sun text-amber-500 text-lg mb-1"></i>
                                <span class="text-xs font-bold text-gray-800 peer-checked:text-amber-900">15 – 30 mins / day</span>
                                <span class="text-[10px] text-gray-400">Moderate sun</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="vit_sun" value="high" class="peer sr-only" onchange="calculateVitaminRisk()">
                            <div class="p-3.5 rounded-2xl border-2 border-gray-200 peer-checked:border-amber-500 peer-checked:bg-amber-50/50 flex flex-col items-center justify-center text-center transition">
                                <i class="fas fa-sun-plant-wilt text-amber-500 text-lg mb-1"></i>
                                <span class="text-xs font-bold text-gray-800 peer-checked:text-amber-900">&gt; 30 mins / day</span>
                                <span class="text-[10px] text-gray-400">Frequent outdoors</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- 2. Diet Preference -->
                <div class="pt-4 border-t border-gray-100">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                        2. Primary Dietary Habit
                    </label>
                    <p class="text-[11px] text-gray-500 mb-3">Vitamin B12 is almost exclusively found in animal products and dairy</p>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="vit_diet" value="vegan" class="peer sr-only" onchange="calculateVitaminRisk()">
                            <div class="p-3.5 rounded-2xl border-2 border-gray-200 peer-checked:border-amber-500 peer-checked:bg-amber-50/50 flex flex-col items-center justify-center text-center transition">
                                <i class="fas fa-seedling text-emerald-600 text-lg mb-1"></i>
                                <span class="text-xs font-bold text-gray-800 peer-checked:text-amber-900">Strict Vegan</span>
                                <span class="text-[10px] text-gray-400">Zero dairy / meat</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="vit_diet" value="veg" checked class="peer sr-only" onchange="calculateVitaminRisk()">
                            <div class="p-3.5 rounded-2xl border-2 border-gray-200 peer-checked:border-amber-500 peer-checked:bg-amber-50/50 flex flex-col items-center justify-center text-center transition">
                                <i class="fas fa-bowl-rice text-amber-600 text-lg mb-1"></i>
                                <span class="text-xs font-bold text-gray-800 peer-checked:text-amber-900">Vegetarian</span>
                                <span class="text-[10px] text-gray-400">Includes milk/curd</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="vit_diet" value="nonveg" class="peer sr-only" onchange="calculateVitaminRisk()">
                            <div class="p-3.5 rounded-2xl border-2 border-gray-200 peer-checked:border-amber-500 peer-checked:bg-amber-50/50 flex flex-col items-center justify-center text-center transition">
                                <i class="fas fa-egg text-amber-600 text-lg mb-1"></i>
                                <span class="text-xs font-bold text-gray-800 peer-checked:text-amber-900">Non-Vegetarian</span>
                                <span class="text-[10px] text-gray-400">Eggs / fish / poultry</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- 3. Symptoms Checklist -->
                <div class="pt-4 border-t border-gray-100">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">
                        3. Common Micronutrient Deficiency Symptoms
                    </label>
                    <p class="text-[11px] text-gray-500 mb-3">Check all persistent sensations you frequently experience:</p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 text-xs text-gray-700">
                        <label class="flex items-center gap-2.5 p-3 bg-gray-50 rounded-xl hover:bg-amber-50/50 cursor-pointer transition">
                            <input type="checkbox" class="vit-symptom-d rounded border-gray-300 text-amber-600" onchange="calculateVitaminRisk()">
                            <div>
                                <span class="font-bold text-gray-900 block">Deep bone or lower back ache</span>
                                <span class="text-[10px] text-gray-400">Classic hallmark of low Vitamin D3</span>
                            </div>
                        </label>

                        <label class="flex items-center gap-2.5 p-3 bg-gray-50 rounded-xl hover:bg-amber-50/50 cursor-pointer transition">
                            <input type="checkbox" class="vit-symptom-b rounded border-gray-300 text-amber-600" onchange="calculateVitaminRisk()">
                            <div>
                                <span class="font-bold text-gray-900 block">Tingling / numbness in hands or feet</span>
                                <span class="text-[10px] text-gray-400">Peripheral nerve sign of low B12</span>
                            </div>
                        </label>

                        <label class="flex items-center gap-2.5 p-3 bg-gray-50 rounded-xl hover:bg-amber-50/50 cursor-pointer transition">
                            <input type="checkbox" class="vit-symptom-both rounded border-gray-300 text-amber-600" onchange="calculateVitaminRisk()">
                            <div>
                                <span class="font-bold text-gray-900 block">Chronic daytime fatigue & weakness</span>
                                <span class="text-[10px] text-gray-400">Waking up unrefreshed, low stamina</span>
                            </div>
                        </label>

                        <label class="flex items-center gap-2.5 p-3 bg-gray-50 rounded-xl hover:bg-amber-50/50 cursor-pointer transition">
                            <input type="checkbox" class="vit-symptom-b rounded border-gray-300 text-amber-600" onchange="calculateVitaminRisk()">
                            <div>
                                <span class="font-bold text-gray-900 block">Brain fog, poor memory, or mood swings</span>
                                <span class="text-[10px] text-gray-400">Cognitive & neurotransmitter depletion</span>
                            </div>
                        </label>

                        <label class="flex items-center gap-2.5 p-3 bg-gray-50 rounded-xl hover:bg-amber-50/50 cursor-pointer transition">
                            <input type="checkbox" class="vit-symptom-d rounded border-gray-300 text-amber-600" onchange="calculateVitaminRisk()">
                            <div>
                                <span class="font-bold text-gray-900 block">Sudden severe hair fall / brittle nails</span>
                                <span class="text-[10px] text-gray-400">Follicular regeneration shortage</span>
                            </div>
                        </label>

                        <label class="flex items-center gap-2.5 p-3 bg-gray-50 rounded-xl hover:bg-amber-50/50 cursor-pointer transition">
                            <input type="checkbox" class="vit-symptom-d rounded border-gray-300 text-amber-600" onchange="calculateVitaminRisk()">
                            <div>
                                <span class="font-bold text-gray-900 block">Frequent colds, infections, or slow recovery</span>
                                <span class="text-[10px] text-gray-400">Depressed cellular immune function</span>
                            </div>
                        </label>
                    </div>
                </div>

            </div>
        </div>

        <!-- Right 5 Cols: Dual Vitamin Results -->
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-xl sticky top-24 space-y-6">
                <span class="text-[10px] font-extrabold uppercase tracking-wider text-gray-400 block">Micronutrient Risk Status</span>

                <!-- 1. Vitamin D3 Card -->
                <div class="p-4 rounded-2xl bg-amber-50/60 border border-amber-200/80">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center text-sm">
                                <i class="fas fa-sun"></i>
                            </div>
                            <span class="font-extrabold text-gray-900 text-sm">Vitamin D3 (25-OH)</span>
                        </div>
                        <span id="badgeVitD" class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-rose-100 text-rose-800">
                            Likely Deficient
                        </span>
                    </div>

                    <div class="relative h-2 rounded-full overflow-hidden bg-gray-200 my-2">
                        <div id="barVitD" class="h-full bg-rose-500 transition-all duration-300" style="width: 80%;"></div>
                    </div>
                    <p id="msgVitD" class="text-[11px] text-gray-600 leading-snug">
                        Limited sunlight exposure and reported bone/fatigue symptoms strongly indicate low serum 25-OH Vitamin D.
                    </p>
                </div>

                <!-- 2. Vitamin B12 Card -->
                <div class="p-4 rounded-2xl bg-purple-50/60 border border-purple-200/80">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-purple-100 text-purple-700 flex items-center justify-center text-sm">
                                <i class="fas fa-dna"></i>
                            </div>
                            <span class="font-extrabold text-gray-900 text-sm">Vitamin B12 (Cobalamin)</span>
                        </div>
                        <span id="badgeVitB" class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-amber-100 text-amber-800">
                            Borderline / Risk
                        </span>
                    </div>

                    <div class="relative h-2 rounded-full overflow-hidden bg-gray-200 my-2">
                        <div id="barVitB" class="h-full bg-amber-500 transition-all duration-300" style="width: 55%;"></div>
                    </div>
                    <p id="msgVitB" class="text-[11px] text-gray-600 leading-snug">
                        Vegetarian diets have limited natural B12 sources. Testing serum B12 prevents irreversible neurological tingling.
                    </p>
                </div>

                <!-- Action Button -->
                <a href="#recommended-vitamin-tests" class="w-full py-3 px-4 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-900 font-extrabold text-xs shadow-md shadow-amber-500/20 transition flex items-center justify-center gap-2">
                    <i class="fas fa-flask"></i>
                    <span>Book Vitamin Blood Test</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Diagnostic Lab Tests & Health Packages Section -->
    <div id="recommended-vitamin-tests" class="mb-14 scroll-mt-24">
        <div class="flex items-center justify-between mb-8">
            <div>
                <span class="text-[10px] font-extrabold uppercase tracking-wider text-amber-800 bg-amber-50 px-2.5 py-1 rounded-full border border-amber-200 inline-block mb-2">Diagnostic Confirmation</span>
                <h2 class="text-2xl font-black text-gray-900 tracking-tight">Accurate Vitamin Blood Profiles</h2>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">High-precision chemiluminescence immunoassay (CLIA) testing for accurate Vitamin D3 and B12 values.</p>
            </div>
        </div>

        <!-- Individual Tests Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            @forelse($recommendedTests as $test)
            <div class="bg-white rounded-3xl p-5 border border-gray-100 hover:border-amber-300 shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col justify-between group">
                <div>
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-sm mb-3">
                        <i class="fas fa-sun"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 text-sm leading-snug mb-1 group-hover:text-amber-600 transition-colors line-clamp-2">
                        <a href="{{ route('test.show', $test->id) }}" class="hover:underline">{{ $test->name }}</a>
                    </h4>
                    <p class="text-[11px] text-gray-500 mb-3">High-Precision Immunoassay Test</p>
                </div>

                <div class="border-t border-gray-100 pt-3 mt-auto">
                    <div class="text-lg font-black text-gray-900 mb-2">₹{{ number_format($test->price) }}</div>
                    <button type="button" 
                        onclick="addToCart(this)" 
                        data-id="{{ $test->id }}"
                        data-type="test"
                        data-name="{{ $test->name }}"
                        data-price="{{ $test->price }}" 
                        data-mrp="{{ $test->price }}" 
                        data-params="Individual Test"
                        class="w-full py-2 px-3 rounded-xl bg-amber-50 hover:bg-amber-500 text-amber-800 hover:text-white font-bold text-xs transition-colors flex items-center justify-center gap-1.5">
                        <i class="fas fa-cart-plus text-xs"></i> Add Test
                    </button>
                </div>
            </div>
            @empty
            @endforelse
        </div>

        <!-- Packages Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($recommendedPackages as $pkg)
            @php
                $mrp = round($pkg->price * 1.45);
                $discountPct = round((($mrp - $pkg->price) / $mrp) * 100);
            @endphp
            <div class="bg-white rounded-3xl p-6 border border-gray-100 hover:border-teal-300 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                <div>
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-[10px] font-bold text-teal-800 bg-teal-50 px-2.5 py-1 rounded-full uppercase border border-teal-100">
                            {{ $pkg->subcategory ?? 'Full Body & Vitamins' }}
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
                        <i class="fas fa-cart-plus"></i> Add Package to Cart
                    </button>
                </div>
            </div>
            @empty
            @endforelse
        </div>
    </div>
</div>

<script>
    function calculateVitaminRisk() {
        const sun = document.querySelector('input[name="vit_sun"]:checked')?.value || 'low';
        const diet = document.querySelector('input[name="vit_diet"]:checked')?.value || 'veg';

        let symDCount = 0;
        let symBCount = 0;

        document.querySelectorAll('.vit-symptom-d:checked').forEach(() => symDCount++);
        document.querySelectorAll('.vit-symptom-b:checked').forEach(() => symBCount++);
        document.querySelectorAll('.vit-symptom-both:checked').forEach(() => {
            symDCount++;
            symBCount++;
        });

        // 1. Vitamin D Risk
        let scoreD = 0;
        if (sun === 'low') scoreD += 50;
        else if (sun === 'mid') scoreD += 25;
        else scoreD += 5;

        scoreD += (symDCount * 18);
        scoreD = Math.min(95, Math.max(10, scoreD));

        let badgeDText = 'Likely Deficient';
        let badgeDClass = 'bg-rose-100 text-rose-800';
        let barDClass = 'bg-rose-500';
        let msgD = '';

        if (scoreD >= 60) {
            badgeDText = 'Likely Deficient';
            badgeDClass = 'bg-rose-100 text-rose-800';
            barDClass = 'bg-rose-500';
            msgD = 'Your minimal sunlight exposure and reported bone/fatigue symptoms strongly indicate low serum 25-OH Vitamin D.';
        } else if (scoreD >= 35) {
            badgeDText = 'Borderline / Insufficient';
            badgeDClass = 'bg-amber-100 text-amber-800';
            barDClass = 'bg-amber-500';
            msgD = 'Your lifestyle suggests suboptimal Vitamin D levels. A blood test will determine if oral cholecalciferol supplementation is needed.';
        } else {
            badgeDText = 'Likely Sufficient';
            badgeDClass = 'bg-emerald-100 text-emerald-800';
            barDClass = 'bg-emerald-500';
            msgD = 'You report adequate direct sunlight exposure with minimal bone ache. Periodic annual screening is still advised.';
        }

        const bD = document.getElementById('badgeVitD');
        bD.className = 'px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider ' + badgeDClass;
        bD.innerText = badgeDText;
        document.getElementById('barVitD').className = 'h-full transition-all duration-300 ' + barDClass;
        document.getElementById('barVitD').style.width = scoreD + '%';
        document.getElementById('msgVitD').innerText = msgD;

        // 2. Vitamin B12 Risk
        let scoreB = 0;
        if (diet === 'vegan') scoreB += 55;
        else if (diet === 'veg') scoreB += 35;
        else scoreB += 10;

        scoreB += (symBCount * 20);
        scoreB = Math.min(95, Math.max(10, scoreB));

        let badgeBText = 'Likely Deficient';
        let badgeBClass = 'bg-rose-100 text-rose-800';
        let barBClass = 'bg-rose-500';
        let msgB = '';

        if (scoreB >= 60) {
            badgeBText = 'Likely Deficient';
            badgeBClass = 'bg-rose-100 text-rose-800';
            barBClass = 'bg-rose-500';
            msgB = 'Plant-based diets coupled with neurological symptoms (tingling, numbness, fatigue) indicate a high risk of cobalamin deficiency.';
        } else if (scoreB >= 35) {
            badgeBText = 'Borderline / Moderate Risk';
            badgeBClass = 'bg-amber-100 text-amber-800';
            barBClass = 'bg-amber-500';
            msgB = 'Your dietary pattern provides modest Vitamin B12. Measuring serum levels ensures early prevention against nerve sheath degeneration.';
        } else {
            badgeBText = 'Likely Sufficient';
            badgeBClass = 'bg-emerald-100 text-emerald-800';
            barBClass = 'bg-emerald-500';
            msgB = 'Regular intake of animal proteins generally preserves liver B12 stores unless intrinsic factor malabsorption is present.';
        }

        const bB = document.getElementById('badgeVitB');
        bB.className = 'px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider ' + badgeBClass;
        bB.innerText = badgeBText;
        document.getElementById('barVitB').className = 'h-full transition-all duration-300 ' + barBClass;
        document.getElementById('barVitB').style.width = scoreB + '%';
        document.getElementById('msgVitB').innerText = msgB;
    }

    document.addEventListener('DOMContentLoaded', calculateVitaminRisk);
</script>
@endsection
