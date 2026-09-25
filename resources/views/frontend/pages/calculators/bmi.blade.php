@extends('frontend.layouts.app')

@section('title', 'Free Body Mass Index (BMI) Calculator & Health Risk Analyzer | Av Wellcare')

@section('content')
<!-- Ambient Background Elements -->
<div class="fixed inset-0 z-[-1] pointer-events-none overflow-hidden bg-slate-50/60">
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-blue-200/30 rounded-full blur-3xl"></div>
    <div class="absolute top-96 -right-32 w-96 h-96 bg-teal-200/20 rounded-full blur-3xl"></div>
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
        <span class="text-blue-700 font-bold">Body Mass Index (BMI)</span>
    </nav>

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-800 text-xs font-bold uppercase tracking-wider mb-2 border border-blue-200/70">
                <i class="fas fa-weight-scale text-blue-600"></i> Diagnostic Health Metric
            </div>
            <h1 class="text-2xl sm:text-4xl font-black text-gray-900 tracking-tight">
                Body Mass Index (BMI) Calculator
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1 max-w-2xl">
                Check whether your weight is within the healthy range for your height, calculate ideal weight targets, and review clinical biomarker recommendations.
            </p>
        </div>

        <!-- Standard / Asian Toggle -->
        <div class="bg-white p-1.5 rounded-2xl border border-gray-200 shadow-sm flex items-center self-start md:self-auto">
            <button type="button" id="toggleAsianStandard" onclick="setStandard('asian')" class="px-3 py-1.5 rounded-xl text-xs font-bold transition bg-blue-600 text-white shadow-xs">
                Asian-Indian (ICMR)
            </button>
            <button type="button" id="toggleWhoStandard" onclick="setStandard('who')" class="px-3 py-1.5 rounded-xl text-xs font-semibold text-gray-600 hover:text-gray-900 transition">
                Global (WHO)
            </button>
        </div>
    </div>

    <!-- Main Calculator Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-14">
        
        <!-- Left 7 Cols: Inputs -->
        <div class="lg:col-span-7 space-y-6">
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm">
                
                <!-- Unit Switcher -->
                <div class="flex items-center justify-between pb-6 mb-6 border-b border-gray-100">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-500">Measurement Units</span>
                    <div class="bg-gray-100 p-1 rounded-xl flex">
                        <button type="button" onclick="setUnit('metric')" id="btnUnitMetric" class="px-4 py-1.5 rounded-lg text-xs font-extrabold bg-white text-blue-700 shadow-xs transition">
                            Metric (kg, cm)
                        </button>
                        <button type="button" onclick="setUnit('imperial')" id="btnUnitImperial" class="px-4 py-1.5 rounded-lg text-xs font-semibold text-gray-600 hover:text-gray-900 transition">
                            Imperial (lbs, ft+in)
                        </button>
                    </div>
                </div>

                <!-- Gender Selection -->
                <div class="mb-6">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">Gender</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="gender" value="male" checked class="peer sr-only" onchange="calculateBMI()">
                            <div class="p-3.5 rounded-2xl border-2 border-gray-200 peer-checked:border-blue-600 peer-checked:bg-blue-50/50 flex items-center justify-center gap-2.5 text-xs font-bold text-gray-700 peer-checked:text-blue-700 transition">
                                <i class="fas fa-mars text-base"></i> Male
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="gender" value="female" class="peer sr-only" onchange="calculateBMI()">
                            <div class="p-3.5 rounded-2xl border-2 border-gray-200 peer-checked:border-blue-600 peer-checked:bg-blue-50/50 flex items-center justify-center gap-2.5 text-xs font-bold text-gray-700 peer-checked:text-blue-700 transition">
                                <i class="fas fa-venus text-base"></i> Female
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Age -->
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="inputAge" class="text-xs font-bold uppercase tracking-wider text-gray-700">Age (Years)</label>
                        <span id="displayAge" class="text-xs font-bold text-blue-600 font-mono">30 yrs</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="range" id="sliderAge" min="15" max="100" value="30" class="w-full accent-blue-600" oninput="document.getElementById('inputAge').value = this.value; document.getElementById('displayAge').innerText = this.value + ' yrs'; calculateBMI();">
                        <input type="number" id="inputAge" min="15" max="100" value="30" class="w-20 px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold text-gray-800 text-center focus:ring-2 focus:ring-blue-500 font-mono" oninput="document.getElementById('sliderAge').value = this.value; document.getElementById('displayAge').innerText = this.value + ' yrs'; calculateBMI();">
                    </div>
                </div>

                <!-- Height Inputs -->
                <!-- Metric Height -->
                <div id="metricHeightGroup" class="mb-6">
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="inputHeightCm" class="text-xs font-bold uppercase tracking-wider text-gray-700">Height (cm)</label>
                        <span id="displayHeightCm" class="text-xs font-bold text-blue-600 font-mono">170 cm</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="range" id="sliderHeightCm" min="100" max="230" value="170" class="w-full accent-blue-600" oninput="document.getElementById('inputHeightCm').value = this.value; document.getElementById('displayHeightCm').innerText = this.value + ' cm'; calculateBMI();">
                        <input type="number" id="inputHeightCm" min="100" max="230" value="170" class="w-24 px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold text-gray-800 text-center focus:ring-2 focus:ring-blue-500 font-mono" oninput="document.getElementById('sliderHeightCm').value = this.value; document.getElementById('displayHeightCm').innerText = this.value + ' cm'; calculateBMI();">
                    </div>
                </div>

                <!-- Imperial Height -->
                <div id="imperialHeightGroup" class="mb-6 hidden">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">Height (Feet & Inches)</label>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <select id="inputHeightFt" class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold text-gray-800" onchange="calculateBMI()">
                                <option value="4">4 Feet</option>
                                <option value="5" selected>5 Feet</option>
                                <option value="6">6 Feet</option>
                                <option value="7">7 Feet</option>
                            </select>
                        </div>
                        <div>
                            <select id="inputHeightIn" class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold text-gray-800" onchange="calculateBMI()">
                                @for($i = 0; $i < 12; $i++)
                                <option value="{{ $i }}" {{ $i == 7 ? 'selected' : '' }}>{{ $i }} Inches</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Weight Inputs -->
                <!-- Metric Weight -->
                <div id="metricWeightGroup" class="mb-6">
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="inputWeightKg" class="text-xs font-bold uppercase tracking-wider text-gray-700">Weight (kg)</label>
                        <span id="displayWeightKg" class="text-xs font-bold text-blue-600 font-mono">68 kg</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="range" id="sliderWeightKg" min="30" max="180" step="0.5" value="68" class="w-full accent-blue-600" oninput="document.getElementById('inputWeightKg').value = this.value; document.getElementById('displayWeightKg').innerText = this.value + ' kg'; calculateBMI();">
                        <input type="number" id="inputWeightKg" min="30" max="180" step="0.5" value="68" class="w-24 px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold text-gray-800 text-center focus:ring-2 focus:ring-blue-500 font-mono" oninput="document.getElementById('sliderWeightKg').value = this.value; document.getElementById('displayWeightKg').innerText = this.value + ' kg'; calculateBMI();">
                    </div>
                </div>

                <!-- Imperial Weight -->
                <div id="imperialWeightGroup" class="mb-6 hidden">
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="inputWeightLbs" class="text-xs font-bold uppercase tracking-wider text-gray-700">Weight (Pounds / lbs)</label>
                        <span id="displayWeightLbs" class="text-xs font-bold text-blue-600 font-mono">150 lbs</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="range" id="sliderWeightLbs" min="70" max="400" value="150" class="w-full accent-blue-600" oninput="document.getElementById('inputWeightLbs').value = this.value; document.getElementById('displayWeightLbs').innerText = this.value + ' lbs'; calculateBMI();">
                        <input type="number" id="inputWeightLbs" min="70" max="400" value="150" class="w-24 px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold text-gray-800 text-center focus:ring-2 focus:ring-blue-500 font-mono" oninput="document.getElementById('sliderWeightLbs').value = this.value; document.getElementById('displayWeightLbs').innerText = this.value + ' lbs'; calculateBMI();">
                    </div>
                </div>

                <div class="p-3 bg-blue-50/60 rounded-2xl border border-blue-100 flex items-center gap-3 text-xs text-blue-900">
                    <i class="fas fa-circle-info text-blue-600 text-base flex-shrink-0"></i>
                    <span>For South Asian / Indian adults, health risks like diabetes & heart disease begin at a lower BMI threshold (23+ kg/m²) than international benchmarks.</span>
                </div>
            </div>
        </div>

        <!-- Right 5 Cols: Live Results Display -->
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-xl sticky top-24">
                <span class="text-[10px] font-extrabold uppercase tracking-wider text-gray-400 block mb-1">Your Result</span>
                
                <!-- Big BMI Score -->
                <div class="flex items-baseline justify-between mb-2">
                    <div class="flex items-baseline gap-2">
                        <span id="bmiScoreText" class="text-5xl sm:text-6xl font-black text-gray-900 font-mono tracking-tight">23.5</span>
                        <span class="text-xs text-gray-400 font-semibold font-mono">kg/m²</span>
                    </div>
                    <span id="bmiCategoryBadge" class="px-3.5 py-1.5 rounded-full text-xs font-extrabold uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-200">
                        Normal Weight
                    </span>
                </div>

                <!-- Visual Bar Indicator -->
                <div class="my-5">
                    <div class="relative h-3.5 rounded-full overflow-hidden bg-gradient-to-r from-blue-400 via-emerald-400 via-amber-400 to-rose-500">
                        <!-- Marker Needle -->
                        <div id="gaugeMarker" class="absolute top-0 bottom-0 w-2.5 bg-gray-900 border-2 border-white rounded-full shadow-md transform -translate-x-1/2 transition-all duration-300" style="left: 45%;"></div>
                    </div>
                    <div class="flex justify-between text-[10px] font-bold text-gray-400 mt-1.5">
                        <span>Underweight</span>
                        <span>Normal</span>
                        <span>Overweight</span>
                        <span>Obese</span>
                    </div>
                </div>

                <!-- Interpretation Text -->
                <p id="bmiInterpretation" class="text-xs text-gray-600 leading-relaxed mb-5">
                    Your BMI is within the normal healthy range. Maintaining your current weight through balanced nutrition and routine physical activity keeps your heart and metabolic risk low.
                </p>

                <!-- Metrics Breakdown Grid -->
                <div class="grid grid-cols-2 gap-3 mb-6">
                    <div class="bg-slate-50 p-3.5 rounded-2xl border border-slate-100">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 block mb-0.5">Ideal Weight</span>
                        <span id="idealWeightText" class="text-sm font-black text-gray-800 font-mono">53.5 – 66.2 kg</span>
                    </div>
                    <div class="bg-slate-50 p-3.5 rounded-2xl border border-slate-100">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 block mb-0.5">Estimated BMR</span>
                        <span id="bmrText" class="text-sm font-black text-blue-700 font-mono">1,620 kcal/day</span>
                    </div>
                </div>

                <!-- Action Button -->
                <a href="#recommended-tests" class="w-full py-3 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs shadow-md transition flex items-center justify-center gap-2">
                    <i class="fas fa-flask"></i>
                    <span>View Recommended Health Tests</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Diagnostic Lab Tests & Health Packages Section -->
    <div id="recommended-tests" class="mb-14 scroll-mt-24">
        <div class="flex items-center justify-between mb-8">
            <div>
                <span class="text-[10px] font-extrabold uppercase tracking-wider text-blue-700 bg-blue-50 px-2.5 py-1 rounded-full border border-blue-200 inline-block mb-2">Physician Guidance</span>
                <h2 class="text-2xl font-black text-gray-900 tracking-tight">Recommended Tests for Your Metabolic Health</h2>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">Weight alone does not reveal lipid accumulation, fatty liver, or early sugar spikes. Book certified blood tests with free home collection.</p>
            </div>
        </div>

        <!-- Individual Tests Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            @forelse($recommendedTests as $test)
            <div class="bg-white rounded-3xl p-5 border border-gray-100 hover:border-blue-300 shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col justify-between group">
                <div>
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-sm mb-3">
                        <i class="fas fa-vial"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 text-sm leading-snug mb-1 group-hover:text-blue-600 transition-colors line-clamp-2">
                        <a href="{{ route('test.show', $test->id) }}" class="hover:underline">{{ $test->name }}</a>
                    </h4>
                    <p class="text-[11px] text-gray-500 mb-3">Same Day Fasting Report Available</p>
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
                        class="w-full py-2 px-3 rounded-xl bg-blue-50 hover:bg-blue-600 text-blue-700 hover:text-white font-bold text-xs transition-colors flex items-center justify-center gap-1.5">
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
                            {{ $pkg->subcategory ?? 'Full Body' }}
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
    let currentUnit = 'metric';
    let currentStandard = 'asian';

    function setUnit(unit) {
        currentUnit = unit;
        const btnMetric = document.getElementById('btnUnitMetric');
        const btnImperial = document.getElementById('btnUnitImperial');

        const mHeight = document.getElementById('metricHeightGroup');
        const iHeight = document.getElementById('imperialHeightGroup');
        const mWeight = document.getElementById('metricWeightGroup');
        const iWeight = document.getElementById('imperialWeightGroup');

        if (unit === 'metric') {
            btnMetric.className = 'px-4 py-1.5 rounded-lg text-xs font-extrabold bg-white text-blue-700 shadow-xs transition';
            btnImperial.className = 'px-4 py-1.5 rounded-lg text-xs font-semibold text-gray-600 hover:text-gray-900 transition';
            mHeight.classList.remove('hidden');
            iHeight.classList.add('hidden');
            mWeight.classList.remove('hidden');
            iWeight.classList.add('hidden');
        } else {
            btnImperial.className = 'px-4 py-1.5 rounded-lg text-xs font-extrabold bg-white text-blue-700 shadow-xs transition';
            btnMetric.className = 'px-4 py-1.5 rounded-lg text-xs font-semibold text-gray-600 hover:text-gray-900 transition';
            mHeight.classList.add('hidden');
            iHeight.classList.remove('hidden');
            mWeight.classList.add('hidden');
            iWeight.classList.remove('hidden');
        }
        calculateBMI();
    }

    function setStandard(std) {
        currentStandard = std;
        const btnAsian = document.getElementById('toggleAsianStandard');
        const btnWho = document.getElementById('toggleWhoStandard');

        if (std === 'asian') {
            btnAsian.className = 'px-3 py-1.5 rounded-xl text-xs font-bold transition bg-blue-600 text-white shadow-xs';
            btnWho.className = 'px-3 py-1.5 rounded-xl text-xs font-semibold text-gray-600 hover:text-gray-900 transition';
        } else {
            btnWho.className = 'px-3 py-1.5 rounded-xl text-xs font-bold transition bg-blue-600 text-white shadow-xs';
            btnAsian.className = 'px-3 py-1.5 rounded-xl text-xs font-semibold text-gray-600 hover:text-gray-900 transition';
        }
        calculateBMI();
    }

    function calculateBMI() {
        let heightCm = 170;
        let weightKg = 68;

        if (currentUnit === 'metric') {
            heightCm = parseFloat(document.getElementById('inputHeightCm').value) || 170;
            weightKg = parseFloat(document.getElementById('inputWeightKg').value) || 68;
        } else {
            const ft = parseFloat(document.getElementById('inputHeightFt').value) || 5;
            const inches = parseFloat(document.getElementById('inputHeightIn').value) || 7;
            const totalInches = (ft * 12) + inches;
            heightCm = totalInches * 2.54;

            const lbs = parseFloat(document.getElementById('inputWeightLbs').value) || 150;
            weightKg = lbs * 0.453592;
        }

        const age = parseInt(document.getElementById('inputAge').value) || 30;
        const gender = document.querySelector('input[name="gender"]:checked')?.value || 'male';

        const heightMeters = heightCm / 100;
        const bmi = weightKg / (heightMeters * heightMeters);
        const roundedBmi = Math.round(bmi * 10) / 10;

        document.getElementById('bmiScoreText').innerText = roundedBmi.toFixed(1);

        // Interpretation
        let category = '';
        let badgeClass = '';
        let message = '';
        let gaugePercent = 50;

        // Cutoffs
        // Asian-Indian: <18.5 Underweight, 18.5-22.9 Normal, 23.0-24.9 Overweight, >=25 Obese
        // WHO: <18.5 Underweight, 18.5-24.9 Normal, 25.0-29.9 Overweight, >=30 Obese
        const normalMax = currentStandard === 'asian' ? 22.9 : 24.9;
        const overMax = currentStandard === 'asian' ? 24.9 : 29.9;

        if (bmi < 18.5) {
            category = 'Underweight';
            badgeClass = 'bg-blue-50 text-blue-700 border border-blue-200';
            message = 'Your BMI is below the healthy range. Being underweight can be related to nutrient malabsorption, thyroid imbalance, or low bone density. Consider checking Complete Hemogram and Vitamin profiles.';
            gaugePercent = Math.max(5, (bmi / 18.5) * 25);
        } else if (bmi <= normalMax) {
            category = 'Normal Weight';
            badgeClass = 'bg-emerald-50 text-emerald-700 border border-emerald-200';
            message = 'Great! Your BMI falls within the healthy physiological range for your demographic. Continue eating nutrient-dense whole foods and maintaining daily physical activity.';
            gaugePercent = 25 + ((bmi - 18.5) / (normalMax - 18.5)) * 25;
        } else if (bmi <= overMax) {
            category = 'Overweight';
            badgeClass = 'bg-amber-50 text-amber-700 border border-amber-200';
            message = 'Your BMI is in the overweight tier. In South Asians, excess visceral adipose tissue increases the predisposition for insulin resistance and lipid imbalance even before symptoms appear.';
            gaugePercent = 50 + ((bmi - normalMax) / (overMax - normalMax)) * 25;
        } else {
            category = 'Obese';
            badgeClass = 'bg-rose-50 text-rose-700 border border-rose-200';
            message = 'Your BMI is classified as Obese. This significantly elevates risk for cardiovascular disease, pre-diabetes, hypertension, and fatty liver. We strongly recommend comprehensive lipid & glycemic testing.';
            gaugePercent = Math.min(95, 75 + ((bmi - overMax) / 10) * 20);
        }

        const badge = document.getElementById('bmiCategoryBadge');
        badge.className = 'px-3.5 py-1.5 rounded-full text-xs font-extrabold uppercase tracking-wider ' + badgeClass;
        badge.innerText = category;

        document.getElementById('bmiInterpretation').innerText = message;
        document.getElementById('gaugeMarker').style.left = gaugePercent + '%';

        // Ideal weight range
        const idealMinKg = Math.round((18.5 * heightMeters * heightMeters) * 10) / 10;
        const idealMaxKg = Math.round((normalMax * heightMeters * heightMeters) * 10) / 10;

        if (currentUnit === 'metric') {
            document.getElementById('idealWeightText').innerText = idealMinKg + ' – ' + idealMaxKg + ' kg';
        } else {
            const idealMinLbs = Math.round(idealMinKg * 2.20462);
            const idealMaxLbs = Math.round(idealMaxKg * 2.20462);
            document.getElementById('idealWeightText').innerText = idealMinLbs + ' – ' + idealMaxLbs + ' lbs';
        }

        // BMR (Mifflin-St Jeor)
        // Men: BMR = (10 × weight in kg) + (6.25 × height in cm) - (5 × age) + 5
        // Women: BMR = (10 × weight in kg) + (6.25 × height in cm) - (5 × age) - 161
        let bmr = (10 * weightKg) + (6.25 * heightCm) - (5 * age);
        bmr = gender === 'male' ? bmr + 5 : bmr - 161;
        document.getElementById('bmrText').innerText = Math.round(bmr).toLocaleString() + ' kcal/day';
    }

    // Run on load
    document.addEventListener('DOMContentLoaded', calculateBMI);
</script>
@endsection
