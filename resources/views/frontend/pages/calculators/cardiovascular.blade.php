@extends('frontend.layouts.app')

@section('title', 'Cardiovascular Heart Disease Risk Calculator & Heart Age Estimator | Av Wellcare')

@section('content')
<!-- Ambient Background Elements -->
<div class="fixed inset-0 z-[-1] pointer-events-none overflow-hidden bg-slate-50/60">
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-rose-200/30 rounded-full blur-3xl"></div>
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
        <span class="text-rose-600 font-bold">Cardiovascular Risk</span>
    </nav>

    <!-- Header Section -->
    <div class="mb-8">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-rose-50 text-rose-800 text-xs font-bold uppercase tracking-wider mb-2 border border-rose-200/70">
            <i class="fas fa-heart-pulse text-rose-600"></i> Cardiac Wellness Profiler
        </div>
        <h1 class="text-2xl sm:text-4xl font-black text-gray-900 tracking-tight">
            Cardiovascular Risk & Heart Age Calculator
        </h1>
        <p class="text-xs sm:text-sm text-gray-500 mt-1 max-w-2xl">
            Assess your 10-year risk of cardiovascular disease (atherosclerosis, heart attack, or stroke) and compare your physiological heart age with your chronological age.
        </p>
    </div>

    <!-- Main Calculator Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-14">
        
        <!-- Left 7 Cols: Clinical Questions -->
        <div class="lg:col-span-7 space-y-6">
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm space-y-6">
                
                <!-- Demographics -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">Biological Sex</label>
                        <div class="grid grid-cols-2 gap-2">
                            <label class="cursor-pointer">
                                <input type="radio" name="heart_gender" value="male" checked class="peer sr-only" onchange="calculateHeartRisk()">
                                <div class="p-3 rounded-xl border-2 border-gray-200 peer-checked:border-rose-600 peer-checked:bg-rose-50/50 flex items-center justify-center gap-2 text-xs font-bold text-gray-700 peer-checked:text-rose-700 transition">
                                    <i class="fas fa-mars"></i> Male
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="heart_gender" value="female" class="peer sr-only" onchange="calculateHeartRisk()">
                                <div class="p-3 rounded-xl border-2 border-gray-200 peer-checked:border-rose-600 peer-checked:bg-rose-50/50 flex items-center justify-center gap-2 text-xs font-bold text-gray-700 peer-checked:text-rose-700 transition">
                                    <i class="fas fa-venus"></i> Female
                                </div>
                            </label>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="heart_age" class="text-xs font-bold uppercase tracking-wider text-gray-700">Age (Years)</label>
                            <span id="displayHeartAge" class="text-xs font-bold text-rose-600 font-mono">42 yrs</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="range" id="sliderHeartAge" min="20" max="85" value="42" class="w-full accent-rose-600" oninput="document.getElementById('inputHeartAge').value = this.value; document.getElementById('displayHeartAge').innerText = this.value + ' yrs'; calculateHeartRisk();">
                            <input type="number" id="inputHeartAge" min="20" max="85" value="42" class="w-20 px-2.5 py-1.5 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold text-gray-800 text-center font-mono" oninput="document.getElementById('sliderHeartAge').value = this.value; document.getElementById('displayHeartAge').innerText = this.value + ' yrs'; calculateHeartRisk();">
                        </div>
                    </div>
                </div>

                <!-- Blood Pressure -->
                <div class="pt-4 border-t border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <label for="heart_bp" class="text-xs font-bold uppercase tracking-wider text-gray-700">Systolic Blood Pressure (mmHg)</label>
                        <span id="displayHeartBp" class="text-xs font-bold text-rose-600 font-mono">125 mmHg</span>
                    </div>
                    <div class="flex items-center gap-2 mb-3">
                        <input type="range" id="sliderHeartBp" min="90" max="200" value="125" class="w-full accent-rose-600" oninput="document.getElementById('inputHeartBp').value = this.value; document.getElementById('displayHeartBp').innerText = this.value + ' mmHg'; calculateHeartRisk();">
                        <input type="number" id="inputHeartBp" min="90" max="200" value="125" class="w-20 px-2.5 py-1.5 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold text-gray-800 text-center font-mono" oninput="document.getElementById('sliderHeartBp').value = this.value; document.getElementById('displayHeartBp').innerText = this.value + ' mmHg'; calculateHeartRisk();">
                    </div>
                    
                    <label class="inline-flex items-center gap-2 text-xs text-gray-600 cursor-pointer">
                        <input type="checkbox" id="checkBpMeds" class="rounded border-gray-300 text-rose-600 focus:ring-rose-500" onchange="calculateHeartRisk()">
                        <span>Currently taking prescribed blood pressure medication</span>
                    </label>
                </div>

                <!-- Cholesterol Status -->
                <div class="pt-4 border-t border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-gray-700">Total Blood Cholesterol</label>
                        <label class="inline-flex items-center gap-1.5 text-xs text-gray-500 cursor-pointer">
                            <input type="checkbox" id="checkUnknownCholesterol" class="rounded border-gray-300 text-rose-600 focus:ring-rose-500" onchange="toggleCholesterolInput()">
                            <span>I don't know my exact cholesterol values</span>
                        </label>
                    </div>

                    <div id="cholesterolInputsGrid" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <span class="text-[11px] text-gray-500 block mb-1">Total Cholesterol (mg/dL)</span>
                            <input type="number" id="inputCholesterol" min="100" max="400" value="200" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold text-gray-800 font-mono" placeholder="e.g. 190" oninput="calculateHeartRisk()">
                        </div>
                        <div>
                            <span class="text-[11px] text-gray-500 block mb-1">HDL "Good" Cholesterol (mg/dL)</span>
                            <input type="number" id="inputHdl" min="20" max="100" value="45" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold text-gray-800 font-mono" placeholder="e.g. 50" oninput="calculateHeartRisk()">
                        </div>
                    </div>
                </div>

                <!-- Lifestyle & Medical History -->
                <div class="pt-4 border-t border-gray-100 space-y-4">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700">Lifestyle & Risk History</label>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <!-- Smoking -->
                        <div>
                            <span class="text-[11px] font-semibold text-gray-600 block mb-1.5">Smoking Status</span>
                            <select id="selectSmoking" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold text-gray-800" onchange="calculateHeartRisk()">
                                <option value="never">Never Smoked</option>
                                <option value="former">Former Smoker</option>
                                <option value="current">Current Smoker</option>
                            </select>
                        </div>

                        <!-- Diabetes -->
                        <div>
                            <span class="text-[11px] font-semibold text-gray-600 block mb-1.5">Diabetes / Blood Sugar</span>
                            <select id="selectDiabetes" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold text-gray-800" onchange="calculateHeartRisk()">
                                <option value="no">No Diabetes</option>
                                <option value="prediabetes">Pre-Diabetic</option>
                                <option value="yes">Diagnosed Diabetic</option>
                            </select>
                        </div>

                        <!-- Exercise -->
                        <div>
                            <span class="text-[11px] font-semibold text-gray-600 block mb-1.5">Weekly Exercise</span>
                            <select id="selectExercise" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold text-gray-800" onchange="calculateHeartRisk()">
                                <option value="active">>150 mins / week</option>
                                <option value="moderate" selected>30–150 mins / week</option>
                                <option value="sedentary">Sedentary (Rarely)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Family History -->
                    <label class="inline-flex items-center gap-2 text-xs text-gray-700 cursor-pointer pt-2">
                        <input type="checkbox" id="checkFamilyHeart" class="rounded border-gray-300 text-rose-600 focus:ring-rose-500" onchange="calculateHeartRisk()">
                        <span>Immediate family member had heart attack or stroke before age 55 (men) or 65 (women)</span>
                    </label>
                </div>

            </div>
        </div>

        <!-- Right 5 Cols: Heart Risk Score & Estimated Heart Age -->
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-xl sticky top-24">
                <span class="text-[10px] font-extrabold uppercase tracking-wider text-gray-400 block mb-1">Cardiac Risk Evaluation</span>

                <!-- 10-Yr Risk Percent -->
                <div class="flex items-baseline justify-between mb-2">
                    <div class="flex items-baseline gap-2">
                        <span id="heartRiskPercentText" class="text-5xl sm:text-6xl font-black text-gray-900 font-mono tracking-tight">4.2%</span>
                        <span class="text-xs text-gray-400 font-semibold font-mono">10-Yr Risk</span>
                    </div>
                    <span id="heartRiskTierBadge" class="px-3.5 py-1.5 rounded-full text-xs font-extrabold uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-200">
                        Low Risk
                    </span>
                </div>

                <!-- Heart Age Comparison -->
                <div class="my-5 p-4 rounded-2xl bg-gradient-to-r from-rose-50 to-pink-50 border border-rose-100 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-extrabold uppercase tracking-wider text-rose-700 block">Estimated Heart Age</span>
                        <span id="heartAgeComparisonText" class="text-xs text-gray-600">Your heart is aging alongside your real age</span>
                    </div>
                    <div class="text-right">
                        <span id="heartAgeNumberText" class="text-3xl font-black text-rose-600 font-mono">42</span>
                        <span class="text-xs text-gray-500 font-medium block">Years</span>
                    </div>
                </div>

                <!-- Visual Risk Meter -->
                <div class="mb-5">
                    <div class="relative h-3 rounded-full overflow-hidden bg-gradient-to-r from-emerald-400 via-amber-400 to-rose-600">
                        <div id="heartGaugeMarker" class="absolute top-0 bottom-0 w-2.5 bg-gray-900 border-2 border-white rounded-full shadow-md transform -translate-x-1/2 transition-all duration-300" style="left: 20%;"></div>
                    </div>
                    <div class="flex justify-between text-[10px] font-bold text-gray-400 mt-1.5">
                        <span>Low (&lt;5%)</span>
                        <span>Borderline</span>
                        <span>Intermediate</span>
                        <span>High (20%+)</span>
                    </div>
                </div>

                <!-- Clinical Insight Text -->
                <p id="heartInsightText" class="text-xs text-gray-600 leading-relaxed mb-5">
                    Your cardiovascular risk profile is currently in the low category. Keeping systolic blood pressure below 120 and maintaining healthy HDL cholesterol will preserve arterial elasticity.
                </p>

                <!-- Key Contributors Tags -->
                <div class="mb-6">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 block mb-2">Key Risk Factors</span>
                    <div id="heartRiskFactorsContainer" class="flex flex-wrap gap-1.5">
                        <span class="px-2 py-0.5 rounded-md text-[10px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-100">Optimal Blood Pressure</span>
                        <span class="px-2 py-0.5 rounded-md text-[10px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-100">Non-Smoker</span>
                    </div>
                </div>

                <a href="#recommended-cardiac-tests" class="w-full py-3 px-4 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-extrabold text-xs shadow-md transition flex items-center justify-center gap-2">
                    <i class="fas fa-heart"></i>
                    <span>View Cardiac Diagnostic Tests</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Diagnostic Lab Tests & Health Packages Section -->
    <div id="recommended-cardiac-tests" class="mb-14 scroll-mt-24">
        <div class="flex items-center justify-between mb-8">
            <div>
                <span class="text-[10px] font-extrabold uppercase tracking-wider text-rose-700 bg-rose-50 px-2.5 py-1 rounded-full border border-rose-200 inline-block mb-2">Diagnostic Recommendations</span>
                <h2 class="text-2xl font-black text-gray-900 tracking-tight">Physician-Recommended Cardiovascular Biomarkers</h2>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">Accurate cholesterol profiling, systemic vascular inflammation (hs-CRP), and kidney filtration are critical for early cardiac prevention.</p>
            </div>
        </div>

        <!-- Individual Tests Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            @forelse($recommendedTests as $test)
            <div class="bg-white rounded-3xl p-5 border border-gray-100 hover:border-rose-300 shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col justify-between group">
                <div>
                    <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-sm mb-3">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 text-sm leading-snug mb-1 group-hover:text-rose-600 transition-colors line-clamp-2">
                        <a href="{{ route('test.show', $test->id) }}" class="hover:underline">{{ $test->name }}</a>
                    </h4>
                    <p class="text-[11px] text-gray-500 mb-3">Certified Lab Fasting Biomarker</p>
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
                        class="w-full py-2 px-3 rounded-xl bg-rose-50 hover:bg-rose-600 text-rose-700 hover:text-white font-bold text-xs transition-colors flex items-center justify-center gap-1.5">
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
            <div class="bg-white rounded-3xl p-6 border border-gray-100 hover:border-rose-300 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                <div>
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-[10px] font-bold text-rose-800 bg-rose-50 px-2.5 py-1 rounded-full uppercase border border-rose-100">
                            {{ $pkg->subcategory ?? 'Cardiac & Vital' }}
                        </span>
                        <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100">
                            {{ $discountPct }}% OFF
                        </span>
                    </div>

                    <h4 class="font-extrabold text-gray-900 text-base leading-snug mb-2 group-hover:text-rose-700 transition-colors">
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
    function toggleCholesterolInput() {
        const unknown = document.getElementById('checkUnknownCholesterol').checked;
        const grid = document.getElementById('cholesterolInputsGrid');
        if (unknown) {
            grid.classList.add('opacity-40', 'pointer-events-none');
        } else {
            grid.classList.remove('opacity-40', 'pointer-events-none');
        }
        calculateHeartRisk();
    }

    function calculateHeartRisk() {
        const age = parseInt(document.getElementById('inputHeartAge').value) || 42;
        const gender = document.querySelector('input[name="heart_gender"]:checked')?.value || 'male';
        const bp = parseInt(document.getElementById('inputHeartBp').value) || 125;
        const bpMeds = document.getElementById('checkBpMeds').checked;
        const smoking = document.getElementById('selectSmoking').value;
        const diabetes = document.getElementById('selectDiabetes').value;
        const exercise = document.getElementById('selectExercise').value;
        const familyHistory = document.getElementById('checkFamilyHeart').checked;
        const unknownCholesterol = document.getElementById('checkUnknownCholesterol').checked;

        let totalChol = 200;
        let hdl = 45;
        if (!unknownCholesterol) {
            totalChol = parseFloat(document.getElementById('inputCholesterol').value) || 200;
            hdl = parseFloat(document.getElementById('inputHdl').value) || 45;
        }

        // Base ACC/AHA Framingham risk-inspired algorithm
        let riskScore = 1.0;

        // Age factor
        if (age < 35) riskScore += 0.5;
        else if (age <= 45) riskScore += 2.0;
        else if (age <= 55) riskScore += 5.0;
        else if (age <= 65) riskScore += 10.0;
        else riskScore += 16.0;

        if (gender === 'male') riskScore += 1.8;

        // BP factor
        if (bp >= 140) riskScore += bpMeds ? 4.5 : 3.5;
        else if (bp >= 130) riskScore += 2.0;
        else if (bp >= 120) riskScore += 0.8;

        // Cholesterol
        if (!unknownCholesterol) {
            if (totalChol >= 240) riskScore += 3.5;
            else if (totalChol >= 200) riskScore += 1.5;

            if (hdl < 40) riskScore += 2.0;
            else if (hdl >= 60) riskScore -= 1.0;
        } else {
            riskScore += 1.0; // slight uncertainty weight
        }

        // Smoking
        if (smoking === 'current') riskScore += 5.0;
        else if (smoking === 'former') riskScore += 1.0;

        // Diabetes
        if (diabetes === 'yes') riskScore += 6.0;
        else if (diabetes === 'prediabetes') riskScore += 2.5;

        // Exercise
        if (exercise === 'sedentary') riskScore += 2.0;
        else if (exercise === 'active') riskScore -= 1.0;

        // Family History
        if (familyHistory) riskScore += 2.5;

        // Bound risk score
        riskScore = Math.max(0.5, Math.min(45, riskScore));
        const finalPercent = Math.round(riskScore * 10) / 10;
        document.getElementById('heartRiskPercentText').innerText = finalPercent.toFixed(1) + '%';

        // Tiers
        let tier = 'Low Risk';
        let badgeClass = 'bg-emerald-50 text-emerald-700 border-emerald-200';
        let insight = '';
        let gaugePercent = 20;

        if (finalPercent < 5.0) {
            tier = 'Low Risk';
            badgeClass = 'bg-emerald-50 text-emerald-700 border-emerald-200';
            insight = 'Your 10-year cardiac event probability is well below average. Keep maintaining regular aerobic exercise, healthy blood pressure, and low saturated fats.';
            gaugePercent = Math.max(5, (finalPercent / 5) * 25);
        } else if (finalPercent < 7.5) {
            tier = 'Borderline Risk';
            badgeClass = 'bg-amber-50 text-amber-700 border-amber-200';
            insight = 'Your cardiovascular risk is borderline. Moderate lifestyle interventions, sodium reduction, and routine lipid profile checks can easily keep your arteries clear.';
            gaugePercent = 25 + ((finalPercent - 5.0) / 2.5) * 25;
        } else if (finalPercent < 20.0) {
            tier = 'Intermediate Risk';
            badgeClass = 'bg-orange-50 text-orange-700 border-orange-200';
            insight = 'You fall in the intermediate risk tier. Physician evaluation, detailed lipid fractionation (ApoB/Lp(a)), and blood sugar monitoring are strongly advised.';
            gaugePercent = 50 + ((finalPercent - 7.5) / 12.5) * 25;
        } else {
            tier = 'High Risk';
            badgeClass = 'bg-rose-50 text-rose-700 border-rose-200';
            insight = 'High cardiovascular risk detected. Multiple cardiac risk factors are compounding. We strongly urge a comprehensive Lipid Profile & ECG checkup with a cardiologist.';
            gaugePercent = Math.min(95, 75 + ((finalPercent - 20) / 25) * 20);
        }

        const badge = document.getElementById('heartRiskTierBadge');
        badge.className = 'px-3.5 py-1.5 rounded-full text-xs font-extrabold uppercase tracking-wider border ' + badgeClass;
        badge.innerText = tier;

        document.getElementById('heartInsightText').innerText = insight;
        document.getElementById('heartGaugeMarker').style.left = gaugePercent + '%';

        // Heart Age calculation
        let heartAgeDelta = (finalPercent - 4.5) * 1.5;
        let heartAge = Math.round(age + heartAgeDelta);
        heartAge = Math.max(age - 5, Math.min(age + 20, heartAge));

        document.getElementById('heartAgeNumberText').innerText = heartAge;
        if (heartAge > age) {
            document.getElementById('heartAgeComparisonText').innerText = 'Heart age is ' + (heartAge - age) + ' years older than chronological age';
        } else if (heartAge < age) {
            document.getElementById('heartAgeComparisonText').innerText = 'Heart age is ' + (age - heartAge) + ' years younger than chronological age!';
        } else {
            document.getElementById('heartAgeComparisonText').innerText = 'Your heart is aging synchronously with your real age';
        }

        // Dynamic Risk Factor Pills
        const factorsContainer = document.getElementById('heartRiskFactorsContainer');
        factorsContainer.innerHTML = '';

        if (smoking === 'current') {
            factorsContainer.innerHTML += '<span class="px-2 py-0.5 rounded-md text-[10px] font-semibold bg-rose-50 text-rose-700 border border-rose-100"><i class="fas fa-triangle-exclamation mr-1"></i>Active Smoking</span>';
        }
        if (bp >= 130) {
            factorsContainer.innerHTML += '<span class="px-2 py-0.5 rounded-md text-[10px] font-semibold bg-rose-50 text-rose-700 border border-rose-100"><i class="fas fa-arrow-trend-up mr-1"></i>Elevated Blood Pressure</span>';
        }
        if (diabetes === 'yes') {
            factorsContainer.innerHTML += '<span class="px-2 py-0.5 rounded-md text-[10px] font-semibold bg-rose-50 text-rose-700 border border-rose-100"><i class="fas fa-circle-exclamation mr-1"></i>Diabetes Mellitus</span>';
        }
        if (familyHistory) {
            factorsContainer.innerHTML += '<span class="px-2 py-0.5 rounded-md text-[10px] font-semibold bg-amber-50 text-amber-800 border border-amber-100"><i class="fas fa-dna mr-1"></i>Family Cardiac History</span>';
        }
        if (exercise === 'sedentary') {
            factorsContainer.innerHTML += '<span class="px-2 py-0.5 rounded-md text-[10px] font-semibold bg-amber-50 text-amber-800 border border-amber-100"><i class="fas fa-couch mr-1"></i>Sedentary Lifestyle</span>';
        }
        if (factorsContainer.children.length === 0) {
            factorsContainer.innerHTML = '<span class="px-2 py-0.5 rounded-md text-[10px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-100"><i class="fas fa-shield-check mr-1"></i>No Major Lifestyle Cardiac Flags</span>';
        }
    }

    document.addEventListener('DOMContentLoaded', calculateHeartRisk);
</script>
@endsection
