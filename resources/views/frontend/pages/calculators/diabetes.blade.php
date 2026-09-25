@extends('frontend.layouts.app')

@section('title', 'Diabetes Risk Profiler & Pre-Diabetes Screening Score (IDRS) | Av Wellcare')

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
        <a href="{{ route('calculators.index') }}" class="hover:text-teal-700 transition">Health Calculators</a>
        <i class="fas fa-chevron-right text-[9px] text-gray-300"></i>
        <span class="text-teal-700 font-bold">Diabetes Risk Profiler</span>
    </nav>

    <!-- Header Section -->
    <div class="mb-8">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-teal-50 text-teal-800 text-xs font-bold uppercase tracking-wider mb-2 border border-teal-200/70">
            <i class="fas fa-droplet text-teal-600"></i> Clinical Pre-Diabetes Assessment
        </div>
        <h1 class="text-2xl sm:text-4xl font-black text-gray-900 tracking-tight">
            Diabetes Risk Profiler & Pre-Diabetes Screener
        </h1>
        <p class="text-xs sm:text-sm text-gray-500 mt-1 max-w-2xl">
            Evaluate your predisposition for insulin resistance and Type 2 diabetes using the clinically validated Indian Diabetes Risk Score (IDRS) methodology.
        </p>
    </div>

    <!-- Main Calculator Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-14">
        
        <!-- Left 7 Cols: IDRS Questionnaire -->
        <div class="lg:col-span-7 space-y-6">
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm space-y-6">
                
                <!-- 1. Age Group -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">1. Age Bracket</label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="idrs_age" value="0" class="peer sr-only" onchange="calculateDiabetesRisk()">
                            <div class="p-3.5 rounded-2xl border-2 border-gray-200 peer-checked:border-teal-600 peer-checked:bg-teal-50/50 flex flex-col items-center justify-center text-center transition">
                                <span class="text-xs font-bold text-gray-800 peer-checked:text-teal-800">Under 35 Yrs</span>
                                <span class="text-[10px] text-gray-400 mt-0.5">Low baseline</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="idrs_age" value="20" checked class="peer sr-only" onchange="calculateDiabetesRisk()">
                            <div class="p-3.5 rounded-2xl border-2 border-gray-200 peer-checked:border-teal-600 peer-checked:bg-teal-50/50 flex flex-col items-center justify-center text-center transition">
                                <span class="text-xs font-bold text-gray-800 peer-checked:text-teal-800">35 – 49 Yrs</span>
                                <span class="text-[10px] text-gray-400 mt-0.5">Moderate risk</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="idrs_age" value="30" class="peer sr-only" onchange="calculateDiabetesRisk()">
                            <div class="p-3.5 rounded-2xl border-2 border-gray-200 peer-checked:border-teal-600 peer-checked:bg-teal-50/50 flex flex-col items-center justify-center text-center transition">
                                <span class="text-xs font-bold text-gray-800 peer-checked:text-teal-800">50+ Yrs</span>
                                <span class="text-[10px] text-gray-400 mt-0.5">Elevated risk</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- 2. Gender & Abdominal Waist Circumference -->
                <div class="pt-4 border-t border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-gray-700">2. Waist Circumference (Navel Level)</label>
                        <div class="flex items-center gap-2">
                            <label class="text-xs text-gray-600 cursor-pointer inline-flex items-center gap-1">
                                <input type="radio" name="idrs_gender" value="male" checked class="text-teal-600" onchange="updateWaistLabels(); calculateDiabetesRisk();">
                                <span>Male</span>
                            </label>
                            <label class="text-xs text-gray-600 cursor-pointer inline-flex items-center gap-1">
                                <input type="radio" name="idrs_gender" value="female" class="text-teal-600" onchange="updateWaistLabels(); calculateDiabetesRisk();">
                                <span>Female</span>
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="idrs_waist" value="0" class="peer sr-only" onchange="calculateDiabetesRisk()">
                            <div class="p-3.5 rounded-2xl border-2 border-gray-200 peer-checked:border-teal-600 peer-checked:bg-teal-50/50 flex flex-col items-center justify-center text-center transition">
                                <span id="labelWaistLow" class="text-xs font-bold text-gray-800 peer-checked:text-teal-800">&lt; 80 cm (&lt; 31 in)</span>
                                <span class="text-[10px] text-gray-400 mt-0.5">Lean abdomen</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="idrs_waist" value="10" checked class="peer sr-only" onchange="calculateDiabetesRisk()">
                            <div class="p-3.5 rounded-2xl border-2 border-gray-200 peer-checked:border-teal-600 peer-checked:bg-teal-50/50 flex flex-col items-center justify-center text-center transition">
                                <span id="labelWaistMid" class="text-xs font-bold text-gray-800 peer-checked:text-teal-800">80 – 89 cm (31–35 in)</span>
                                <span class="text-[10px] text-gray-400 mt-0.5">Mild abdominal fat</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="idrs_waist" value="20" class="peer sr-only" onchange="calculateDiabetesRisk()">
                            <div class="p-3.5 rounded-2xl border-2 border-gray-200 peer-checked:border-teal-600 peer-checked:bg-teal-50/50 flex flex-col items-center justify-center text-center transition">
                                <span id="labelWaistHigh" class="text-xs font-bold text-gray-800 peer-checked:text-teal-800">≥ 90 cm (≥ 35.5 in)</span>
                                <span class="text-[10px] text-gray-400 mt-0.5">Visceral adiposity</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- 3. Physical Activity -->
                <div class="pt-4 border-t border-gray-100">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">3. Physical Activity / Routine</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="idrs_activity" value="0" class="peer sr-only" onchange="calculateDiabetesRisk()">
                            <div class="p-3 rounded-xl border-2 border-gray-200 peer-checked:border-teal-600 peer-checked:bg-teal-50/50 flex items-center gap-3 transition">
                                <i class="fas fa-person-running text-teal-600 text-lg"></i>
                                <div>
                                    <span class="text-xs font-bold text-gray-800 block">Vigorous Exercise</span>
                                    <span class="text-[10px] text-gray-500">Strenuous work or sport daily</span>
                                </div>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="idrs_activity" value="10" class="peer sr-only" onchange="calculateDiabetesRisk()">
                            <div class="p-3 rounded-xl border-2 border-gray-200 peer-checked:border-teal-600 peer-checked:bg-teal-50/50 flex items-center gap-3 transition">
                                <i class="fas fa-person-walking text-teal-600 text-lg"></i>
                                <div>
                                    <span class="text-xs font-bold text-gray-800 block">Moderate Activity</span>
                                    <span class="text-[10px] text-gray-500">Brisk walk / yoga 30 min daily</span>
                                </div>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="idrs_activity" value="20" checked class="peer sr-only" onchange="calculateDiabetesRisk()">
                            <div class="p-3 rounded-xl border-2 border-gray-200 peer-checked:border-teal-600 peer-checked:bg-teal-50/50 flex items-center gap-3 transition">
                                <i class="fas fa-briefcase text-teal-600 text-lg"></i>
                                <div>
                                    <span class="text-xs font-bold text-gray-800 block">Mild / Desk Bound</span>
                                    <span class="text-[10px] text-gray-500">Sedentary job with light movement</span>
                                </div>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="idrs_activity" value="30" class="peer sr-only" onchange="calculateDiabetesRisk()">
                            <div class="p-3 rounded-xl border-2 border-gray-200 peer-checked:border-teal-600 peer-checked:bg-teal-50/50 flex items-center gap-3 transition">
                                <i class="fas fa-couch text-teal-600 text-lg"></i>
                                <div>
                                    <span class="text-xs font-bold text-gray-800 block">Completely Sedentary</span>
                                    <span class="text-[10px] text-gray-500">Little to no exercise</span>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- 4. Family History -->
                <div class="pt-4 border-t border-gray-100">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">4. Family History of Diabetes</label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="idrs_family" value="0" class="peer sr-only" onchange="calculateDiabetesRisk()">
                            <div class="p-3.5 rounded-2xl border-2 border-gray-200 peer-checked:border-teal-600 peer-checked:bg-teal-50/50 flex flex-col items-center justify-center text-center transition">
                                <span class="text-xs font-bold text-gray-800 peer-checked:text-teal-800">Neither Parent</span>
                                <span class="text-[10px] text-gray-400 mt-0.5">No immediate family</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="idrs_family" value="10" checked class="peer sr-only" onchange="calculateDiabetesRisk()">
                            <div class="p-3.5 rounded-2xl border-2 border-gray-200 peer-checked:border-teal-600 peer-checked:bg-teal-50/50 flex flex-col items-center justify-center text-center transition">
                                <span class="text-xs font-bold text-gray-800 peer-checked:text-teal-800">One Parent</span>
                                <span class="text-[10px] text-gray-400 mt-0.5">Father or Mother</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="idrs_family" value="20" class="peer sr-only" onchange="calculateDiabetesRisk()">
                            <div class="p-3.5 rounded-2xl border-2 border-gray-200 peer-checked:border-teal-600 peer-checked:bg-teal-50/50 flex flex-col items-center justify-center text-center transition">
                                <span class="text-xs font-bold text-gray-800 peer-checked:text-teal-800">Both Parents</span>
                                <span class="text-[10px] text-gray-400 mt-0.5">Strong genetic link</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- 5. Symptoms Checklist -->
                <div class="pt-4 border-t border-gray-100">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">5. Experiencing Any of These Symptoms? (Optional)</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs text-gray-700">
                        <label class="flex items-center gap-2 p-2.5 bg-gray-50 rounded-xl hover:bg-gray-100 cursor-pointer transition">
                            <input type="checkbox" class="symptom-check rounded border-gray-300 text-teal-600" onchange="calculateDiabetesRisk()">
                            <span>Frequent urination (waking up at night)</span>
                        </label>
                        <label class="flex items-center gap-2 p-2.5 bg-gray-50 rounded-xl hover:bg-gray-100 cursor-pointer transition">
                            <input type="checkbox" class="symptom-check rounded border-gray-300 text-teal-600" onchange="calculateDiabetesRisk()">
                            <span>Unexplained extreme thirst / dry mouth</span>
                        </label>
                        <label class="flex items-center gap-2 p-2.5 bg-gray-50 rounded-xl hover:bg-gray-100 cursor-pointer transition">
                            <input type="checkbox" class="symptom-check rounded border-gray-300 text-teal-600" onchange="calculateDiabetesRisk()">
                            <span>Excessive fatigue after high-carb meals</span>
                        </label>
                        <label class="flex items-center gap-2 p-2.5 bg-gray-50 rounded-xl hover:bg-gray-100 cursor-pointer transition">
                            <input type="checkbox" class="symptom-check rounded border-gray-300 text-teal-600" onchange="calculateDiabetesRisk()">
                            <span>Slow wound healing or blurred vision</span>
                        </label>
                    </div>
                </div>

            </div>
        </div>

        <!-- Right 5 Cols: Diabetes Score & Clinical Action Plan -->
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-xl sticky top-24">
                <span class="text-[10px] font-extrabold uppercase tracking-wider text-gray-400 block mb-1">Indian Diabetes Risk Score</span>

                <!-- Score Big Text -->
                <div class="flex items-baseline justify-between mb-2">
                    <div class="flex items-baseline gap-2">
                        <span id="diabetesScoreText" class="text-5xl sm:text-6xl font-black text-gray-900 font-mono tracking-tight">50</span>
                        <span class="text-xs text-gray-400 font-semibold font-mono">/ 100</span>
                    </div>
                    <span id="diabetesTierBadge" class="px-3.5 py-1.5 rounded-full text-xs font-extrabold uppercase tracking-wider bg-amber-50 text-amber-700 border border-amber-200">
                        Moderate Risk
                    </span>
                </div>

                <!-- Visual Meter -->
                <div class="my-5">
                    <div class="relative h-3.5 rounded-full overflow-hidden bg-gradient-to-r from-emerald-400 via-amber-400 to-rose-600">
                        <div id="diabetesGaugeMarker" class="absolute top-0 bottom-0 w-2.5 bg-gray-900 border-2 border-white rounded-full shadow-md transform -translate-x-1/2 transition-all duration-300" style="left: 50%;"></div>
                    </div>
                    <div class="flex justify-between text-[10px] font-bold text-gray-400 mt-1.5">
                        <span>Low (&lt;30)</span>
                        <span>Moderate (30-59)</span>
                        <span>High (60+)</span>
                    </div>
                </div>

                <!-- Diagnostic Interpretation -->
                <div class="p-4 rounded-2xl bg-teal-50/70 border border-teal-100 mb-5">
                    <span class="text-[10px] font-extrabold uppercase tracking-wider text-teal-800 block mb-1">
                        <i class="fas fa-stethoscope mr-1"></i> Pre-Diabetes Reversibility
                    </span>
                    <p id="diabetesInsightText" class="text-xs text-teal-950 leading-relaxed font-medium">
                        Your score places you in the Moderate Risk range. Approximately 60% of pre-diabetics can restore normal glucose tolerance simply through structured 30-minute daily walking and refined carbohydrate control.
                    </p>
                </div>

                <!-- Breakdown Info -->
                <div class="space-y-2 mb-6 text-xs text-gray-600">
                    <div class="flex justify-between items-center py-1.5 border-b border-gray-100">
                        <span class="font-medium">Gold-Standard Confirmation</span>
                        <span class="font-bold text-gray-900">HbA1c Blood Test</span>
                    </div>
                    <div class="flex justify-between items-center py-1.5 border-b border-gray-100">
                        <span class="font-medium">Early Detection Benefit</span>
                        <span class="font-bold text-emerald-600">100% Reversible in Pre-stage</span>
                    </div>
                </div>

                <a href="#recommended-diabetes-tests" class="w-full py-3 px-4 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-extrabold text-xs shadow-md transition flex items-center justify-center gap-2">
                    <i class="fas fa-droplet"></i>
                    <span>Book HbA1c & Blood Sugar Screen</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Diagnostic Lab Tests & Health Packages Section -->
    <div id="recommended-diabetes-tests" class="mb-14 scroll-mt-24">
        <div class="flex items-center justify-between mb-8">
            <div>
                <span class="text-[10px] font-extrabold uppercase tracking-wider text-teal-700 bg-teal-50 px-2.5 py-1 rounded-full border border-teal-200 inline-block mb-2">Certified Laboratory Tests</span>
                <h2 class="text-2xl font-black text-gray-900 tracking-tight">Accurate Blood Glucose & Glycated Biomarkers</h2>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">Screen your average 3-month sugar level, early morning insulin resistance, and lipid markers at home.</p>
            </div>
        </div>

        <!-- Individual Tests Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            @forelse($recommendedTests as $test)
            <div class="bg-white rounded-3xl p-5 border border-gray-100 hover:border-teal-300 shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col justify-between group">
                <div>
                    <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-sm mb-3">
                        <i class="fas fa-vial-circle-check"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 text-sm leading-snug mb-1 group-hover:text-teal-700 transition-colors line-clamp-2">
                        <a href="{{ route('test.show', $test->id) }}" class="hover:underline">{{ $test->name }}</a>
                    </h4>
                    <p class="text-[11px] text-gray-500 mb-3">Same-Day Certified Report</p>
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
                        class="w-full py-2 px-3 rounded-xl bg-teal-50 hover:bg-teal-600 text-teal-700 hover:text-white font-bold text-xs transition-colors flex items-center justify-center gap-1.5">
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
            <div class="bg-white rounded-3xl p-6 border border-gray-100 hover:border-teal-300 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                <div>
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-[10px] font-bold text-teal-800 bg-teal-50 px-2.5 py-1 rounded-full uppercase border border-teal-100">
                            {{ $pkg->subcategory ?? 'Diabetes & Metabolic' }}
                        </span>
                        @if($pkg->hasDiscount())
                        <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100">
                            {{ $pkg->effective_discount_percentage }}% OFF
                        </span>
                        @endif
                    </div>

                    <h4 class="font-extrabold text-gray-900 text-base leading-snug mb-2 group-hover:text-teal-700 transition-colors">
                        <a href="{{ route('package.show', $pkg->id) }}" class="hover:underline">{{ $pkg->name }}</a>
                    </h4>
                    <p class="text-xs text-gray-500 mb-4 line-clamp-2">{{ $pkg->description }}</p>
                </div>

                <div class="border-t border-gray-100 pt-4 mt-auto">
                    <div class="flex items-baseline gap-2 mb-3">
                        <span class="text-2xl font-black text-gray-900 tracking-tight">₹{{ number_format($pkg->price) }}</span>
                        @if($pkg->hasDiscount())
                            <span class="text-xs text-gray-400 line-through">₹{{ number_format($pkg->effective_mrp) }}</span>
                        @endif
                    </div>
                    <button type="button" 
                        onclick="addToCart(this)" 
                        data-id="{{ $pkg->id }}"
                        data-type="package"
                        data-name="{{ $pkg->name }}"
                        data-price="{{ $pkg->price }}" 
                        data-mrp="{{ $pkg->effective_mrp ?? $pkg->price }}" 
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
    function updateWaistLabels() {
        const gender = document.querySelector('input[name="idrs_gender"]:checked')?.value || 'male';
        const low = document.getElementById('labelWaistLow');
        const mid = document.getElementById('labelWaistMid');
        const high = document.getElementById('labelWaistHigh');

        if (gender === 'male') {
            low.innerText = '< 80 cm (< 31 in)';
            mid.innerText = '80 – 89 cm (31–35 in)';
            high.innerText = '≥ 90 cm (≥ 35.5 in)';
        } else {
            low.innerText = '< 70 cm (< 28 in)';
            mid.innerText = '70 – 79 cm (28–31 in)';
            high.innerText = '≥ 80 cm (≥ 31.5 in)';
        }
    }

    function calculateDiabetesRisk() {
        const agePoints = parseInt(document.querySelector('input[name="idrs_age"]:checked')?.value || 20);
        const waistPoints = parseInt(document.querySelector('input[name="idrs_waist"]:checked')?.value || 10);
        const activityPoints = parseInt(document.querySelector('input[name="idrs_activity"]:checked')?.value || 20);
        const familyPoints = parseInt(document.querySelector('input[name="idrs_family"]:checked')?.value || 10);

        let symptomCount = 0;
        document.querySelectorAll('.symptom-check:checked').forEach(() => symptomCount++);

        const idrsScore = agePoints + waistPoints + activityPoints + familyPoints;
        document.getElementById('diabetesScoreText').innerText = idrsScore;

        let tier = 'Low Risk';
        let badgeClass = 'bg-emerald-50 text-emerald-700 border-emerald-200';
        let insight = '';
        let gaugePercent = (idrsScore / 100) * 100;

        if (idrsScore < 30) {
            tier = 'Low Risk';
            badgeClass = 'bg-emerald-50 text-emerald-700 border-emerald-200';
            insight = 'Your IDRS score indicates a low statistical likelihood of diabetes. Maintaining your active lifestyle and fibrous diet will preserve insulin sensitivity.';
        } else if (idrsScore < 60) {
            tier = 'Moderate Risk';
            badgeClass = 'bg-amber-50 text-amber-700 border-amber-200';
            insight = 'You are in the Moderate Risk range (Pre-Diabetes Alert). Approximately 60% of pre-diabetics can reverse this trajectory through 30 minutes of daily brisk walking and reducing sugar intake.';
        } else {
            tier = 'High Risk';
            badgeClass = 'bg-rose-50 text-rose-700 border-rose-200';
            insight = 'High Risk tier detected (IDRS ≥ 60). South Asian clinical guidelines strongly advise taking a certified HbA1c & Fasting Glucose blood test immediately to screen for silent pre-diabetes or diabetes.';
        }

        if (symptomCount >= 2 && idrsScore < 60) {
            insight += ' Note: You also reported multiple symptoms (frequent urination or tiredness), which warrants closer clinical attention.';
        }

        const badge = document.getElementById('diabetesTierBadge');
        badge.className = 'px-3.5 py-1.5 rounded-full text-xs font-extrabold uppercase tracking-wider border ' + badgeClass;
        badge.innerText = tier;

        document.getElementById('diabetesInsightText').innerText = insight;
        document.getElementById('diabetesGaugeMarker').style.left = Math.max(5, Math.min(95, gaugePercent)) + '%';
    }

    document.addEventListener('DOMContentLoaded', () => {
        updateWaistLabels();
        calculateDiabetesRisk();
    });
</script>
@endsection
