@extends('frontend.layouts.app')

@php
    $patientVipData = $patientVipData ?? ($patientVip ? [
        'id' => $patientVip->id,
        'plan_name' => $patientVip->plan_name_snapshot,
        'discount_percentage' => (int) $patientVip->discount_percentage,
    ] : null);

    $allVipPlansData = $allVipPlansData ?? ($vipPlans ?? collect())->map(function ($p) {
        return [
            'id' => $p->id,
            'name' => $p->name,
            'formatted_duration' => $p->formatted_duration,
            'price' => (float) $p->price,
            'discount_percentage' => (int) $p->discount_percentage,
            'is_popular' => (bool) $p->is_popular,
        ];
    })->values()->toArray();

    $featuredPlan = $featuredPlan ?? (collect($vipPlans ?? [])->firstWhere('is_popular', true) ?? collect($vipPlans ?? [])->first());
    $defaultAddress = $patient?->addresses?->first();
    $defaultAddr = $defaultAddress;
@endphp

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="container mx-auto px-4 max-w-6xl">
        <!-- Modern Multi-Step Progress Bar -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/90 p-4 sm:p-6 mb-8">
            <div class="relative flex justify-between items-center max-w-4xl mx-auto">
                <!-- Connecting Line Background -->
                <div class="absolute left-8 right-8 sm:left-14 sm:right-14 top-5 sm:top-6 h-1 bg-slate-100 -z-0 rounded-full"></div>
                <!-- Progress Fill Line -->
                <div id="progressFill" class="absolute left-8 sm:left-14 top-5 sm:top-6 h-1 bg-teal-600 -z-0 rounded-full transition-all duration-500" style="width: 0%;"></div>
                
                <!-- Step 1 -->
                <div class="step-wrapper relative z-10 flex flex-col items-center cursor-pointer group" onclick="goToStep(1)">
                    <div class="step-icon bg-white border-2 border-teal-600 text-teal-800 rounded-2xl w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center font-extrabold shadow-sm transition-all" data-step="1">
                        <i class="fas fa-flask text-sm sm:text-base"></i>
                    </div>
                    <span class="step-label text-[11px] sm:text-xs font-black text-teal-800 mt-2 text-center">Cart & Tests</span>
                    <span class="step-sub text-[9px] font-semibold text-teal-600 hidden sm:block">Step 1</span>
                </div>

                <!-- Step 2 -->
                <div class="step-wrapper relative z-10 flex flex-col items-center cursor-pointer group" onclick="goToStep(2)">
                    <div class="step-icon bg-white border-2 border-slate-200 text-slate-400 rounded-2xl w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center font-extrabold shadow-sm transition-all" data-step="2">
                        <i class="fas fa-user-plus text-sm sm:text-base"></i>
                    </div>
                    <span class="step-label text-[11px] sm:text-xs font-bold text-slate-400 mt-2 text-center">Select Patient</span>
                    <span class="step-sub text-[9px] font-semibold text-slate-400 hidden sm:block">Step 2</span>
                </div>

                <!-- Step 3 -->
                <div class="step-wrapper relative z-10 flex flex-col items-center cursor-pointer group" onclick="goToStep(3)">
                    <div class="step-icon bg-white border-2 border-slate-200 text-slate-400 rounded-2xl w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center font-extrabold shadow-sm transition-all" data-step="3">
                        <i class="far fa-calendar-alt text-sm sm:text-base"></i>
                    </div>
                    <span class="step-label text-[11px] sm:text-xs font-bold text-slate-400 mt-2 text-center">Date & Slot</span>
                    <span class="step-sub text-[9px] font-semibold text-slate-400 hidden sm:block">Step 3</span>
                </div>

                <!-- Step 4 -->
                <div class="step-wrapper relative z-10 flex flex-col items-center cursor-pointer group" onclick="goToStep(4)">
                    <div class="step-icon bg-white border-2 border-slate-200 text-slate-400 rounded-2xl w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center font-extrabold shadow-sm transition-all" data-step="4">
                        <i class="fas fa-wallet text-sm sm:text-base"></i>
                    </div>
                    <span class="step-label text-[11px] sm:text-xs font-bold text-slate-400 mt-2 text-center">Review & Pay</span>
                    <span class="step-sub text-[9px] font-semibold text-slate-400 hidden sm:block">Step 4</span>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Left Column: Steps -->
            <div class="lg:w-2/3">
                
                <!-- STEP 1: Tests & Packages -->
                <div id="step1" class="step-content">
                    <div class="flex justify-between items-center mb-5">
                        <div>
                            <h2 class="text-2xl font-black text-slate-900 tracking-tight">Tests & Packages in Cart</h2>
                            <p class="text-xs text-slate-500 font-medium mt-0.5">Review your selected diagnostic panels and tests before proceeding</p>
                        </div>
                        <button onclick="window.location.href='/'" class="text-xs font-bold text-teal-800 hover:text-white bg-teal-50 hover:bg-teal-700 px-3.5 py-1.5 rounded-xl border border-teal-200 transition-all flex items-center gap-1.5 shadow-sm">
                            <i class="fas fa-plus text-[10px]"></i>
                            <span>Add More Tests</span>
                        </button>
                    </div>
                    
                    <!-- Clinical Care Inclusions (Free Add-on Banner) -->
                    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-teal-900 via-teal-800 to-indigo-950 text-white p-4 sm:p-5 mb-5 shadow-sm">
                        <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="bg-amber-400 text-slate-950 text-[10px] font-black px-2 py-0.5 rounded-full uppercase tracking-wider">COMPLIMENTARY</span>
                                    <span class="text-xs font-bold text-teal-200">Value Pack worth ₹1,200</span>
                                </div>
                                <h3 class="font-black text-white text-base sm:text-lg tracking-tight">Complete Care Included with Every Report</h3>
                            </div>
                            <div class="flex flex-wrap gap-2 text-xs font-semibold text-teal-100">
                                <div class="flex items-center bg-white/10 backdrop-blur-md rounded-xl px-2.5 py-1.5 border border-white/15">
                                    <i class="fas fa-file-medical text-teal-300 mr-2"></i> Smart AI Report
                                </div>
                                <div class="flex items-center bg-white/10 backdrop-blur-md rounded-xl px-2.5 py-1.5 border border-white/15">
                                    <i class="fas fa-user-doctor text-cyan-300 mr-2"></i> Doctor Tele-Consult
                                </div>
                                <div class="flex items-center bg-white/10 backdrop-blur-md rounded-xl px-2.5 py-1.5 border border-white/15">
                                    <i class="fas fa-apple-whole text-emerald-300 mr-2"></i> Diet Guidance
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Active VIP Member Banner (Step 1) -->
                    @if($patientVip)
                    <div class="mb-5 rounded-2xl bg-gradient-to-r from-amber-500/15 via-amber-400/10 to-amber-500/5 border border-amber-300/80 p-4 sm:p-5 flex items-center justify-between gap-4 shadow-sm">
                        <div class="flex items-center gap-3.5">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-amber-400 to-amber-600 text-slate-950 flex items-center justify-center text-lg font-black shadow-sm flex-shrink-0">
                                <i class="fas fa-crown"></i>
                            </div>
                            <div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="text-[10px] font-black uppercase tracking-wider text-amber-900 bg-amber-200/60 px-2.5 py-0.5 rounded-full border border-amber-300">
                                        VIP Member Perks Applied
                                    </span>
                                    <span class="text-xs font-black text-slate-800">{{ $patientVip->plan_name_snapshot }}</span>
                                </div>
                                <p class="text-xs text-slate-600 font-semibold mt-1">
                                    Flat <strong class="text-amber-800 font-black">{{ $patientVip->discount_percentage }}% VIP Discount</strong> automatically applied to your cart + 100% Free Home Sample Collection!
                                </p>
                            </div>
                        </div>
                        <div class="hidden sm:block text-right flex-shrink-0">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Status</span>
                            <span class="text-xs font-black text-emerald-600 flex items-center gap-1 justify-end"><i class="fas fa-check-circle"></i> Active VIP</span>
                        </div>
                    </div>
                    @endif

                    <!-- Dynamic Cart Items (filled by JS from localStorage) -->
                    <div id="checkoutCartItems">
                        <!-- JS will render items here -->
                    </div>

                    <!-- 1-Click VIP Upsell Card (Step 1) -->
                    @php
                        $featuredPlan = $vipPlans->firstWhere('is_popular', true) ?? $vipPlans->first();
                    @endphp
                    @if(!$patientVip && $featuredPlan)
                    <div id="vipUpsellCard" class="mt-4 mb-6 rounded-3xl bg-gradient-to-br from-slate-950 via-slate-900 to-amber-950 text-white p-5 sm:p-6 border border-amber-500/40 shadow-xl relative overflow-hidden transition-all">
                        <div class="absolute -right-10 -bottom-10 w-48 h-48 rounded-full bg-amber-500/15 blur-2xl pointer-events-none"></div>
                        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-5">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-amber-400 to-amber-600 text-slate-950 flex items-center justify-center text-xl font-black shadow-lg flex-shrink-0 mt-0.5">
                                    <i class="fas fa-crown"></i>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-500/20 text-amber-300 border border-amber-500/40">
                                            Special Checkout Upsell
                                        </span>
                                        <span class="text-xs font-bold text-slate-300">
                                            {{ $featuredPlan->name }} ({{ $featuredPlan->formatted_duration }})
                                        </span>
                                    </div>
                                    <h3 class="text-base sm:text-lg font-black text-white mt-1 leading-snug">
                                        Add VIP Pass for ₹{{ number_format($featuredPlan->price, 0) }} & Save flat {{ $featuredPlan->discount_percentage }}% on today's tests!
                                    </h3>
                                    <p class="text-xs text-slate-300 font-medium mt-1 leading-relaxed">
                                        Enjoy flat {{ $featuredPlan->discount_percentage }}% OFF all lab tests for {{ $featuredPlan->formatted_duration }}, ₹0 home collection fees, and priority WhatsApp reports for your entire family.
                                    </p>
                                </div>
                            </div>

                            <!-- Upsell Checkbox Control -->
                            <div class="flex-shrink-0 bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/15 flex items-center gap-3">
                                <input type="checkbox" id="vipUpsellCheckbox" onchange="toggleVipUpsell(this)" class="w-5 h-5 rounded text-amber-500 focus:ring-amber-400 border-gray-300 cursor-pointer">
                                <label for="vipUpsellCheckbox" class="cursor-pointer select-none">
                                    <span class="block text-xs font-black text-white">Add VIP Pass (+₹{{ number_format($featuredPlan->price, 0) }})</span>
                                    <span id="vipInstantSavingsText" class="block text-[11px] font-bold text-amber-300">Save instantly on today's tests!</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Empty Cart State -->
                    <div id="emptyCartMsg" class="hidden bg-white border border-dashed border-slate-300 rounded-2xl p-10 text-center shadow-sm my-6">
                        <div class="w-16 h-16 rounded-full bg-teal-50 text-teal-700 flex items-center justify-center mx-auto mb-4 text-2xl">
                            <i class="fas fa-shopping-basket"></i>
                        </div>
                        <h3 class="font-black text-slate-800 text-lg mb-1">Your Diagnostic Cart is Empty</h3>
                        <p class="text-xs text-slate-500 font-medium max-w-sm mx-auto mb-5">Browse doctor-curated full body packages and lab tests with free home sample collection.</p>
                        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-teal-800 text-white px-6 py-2.5 rounded-xl font-bold text-xs hover:bg-teal-900 transition shadow-md">
                            <i class="fas fa-magnifying-glass text-xs"></i>
                            <span>Browse Health Packages</span>
                        </a>
                    </div>

                    <!-- Frequently Added / Suggested Diagnostic Tests Section -->
                    <div class="mt-8 pt-6 border-t border-slate-200" id="suggestedTestsSection">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-4">
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-teal-50 border border-teal-200 text-teal-800 text-[10px] font-black uppercase tracking-wider">
                                        <i class="fas fa-sparkles text-amber-500"></i> Recommended Add-ons
                                    </span>
                                    <span class="text-[11px] font-bold text-slate-400">• High Diagnostic Value</span>
                                </div>
                                <h3 class="text-xl font-black text-slate-900 tracking-tight">Frequently Added Together</h3>
                                <p class="text-xs text-slate-500 font-medium">Add vital individual parameters to your booking with a single click.</p>
                            </div>
                        </div>

                        <!-- Suggested Tests Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3.5" id="suggestedTestsGrid">
                            @forelse($suggestedTests ?? [] as $st)
                                @php
                                    $categoryName = $st->category?->name ?? 'Clinical Pathology';
                                    $hasDiscount = $st->hasDiscount();
                                    $mrpPrice = $hasDiscount ? $st->effective_mrp : $st->price;
                                @endphp
                                <div class="suggested-test-card bg-white rounded-2xl p-4 border border-slate-200/90 hover:border-teal-500/50 hover:shadow-md transition-all flex flex-col justify-between group" data-test-name="{{ $st->name }}">
                                    <div>
                                        <div class="flex items-center justify-between gap-2 mb-2">
                                            <span class="text-[10px] font-black text-teal-700 bg-teal-50 px-2 py-0.5 rounded-md border border-teal-100 uppercase tracking-wider truncate max-w-[170px]">
                                                {{ $categoryName }}
                                            </span>
                                            <span class="text-[10px] font-bold text-slate-400 flex items-center gap-1">
                                                <i class="fas fa-bolt text-amber-500 text-[9px]"></i> {{ $st->report_delivery_time ?: '6-12h' }}
                                            </span>
                                        </div>
                                        <h4 class="text-sm font-black text-slate-900 group-hover:text-teal-800 transition-colors line-clamp-2 mb-1.5" title="{{ $st->name }}">
                                            {{ $st->name }}
                                        </h4>
                                        <p class="text-[11px] text-slate-500 font-medium line-clamp-1 mb-3">
                                            {{ $st->preparation_instructions ?: 'Home collection available. Fast verified reporting.' }}
                                        </p>
                                    </div>

                                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between mt-auto">
                                        <div>
                                            <div class="flex items-baseline gap-1.5">
                                                <span class="text-base font-black text-slate-900">₹{{ number_format($st->price) }}</span>
                                                @if($hasDiscount)
                                                    <span class="text-xs text-slate-400 line-through font-bold">₹{{ number_format($mrpPrice) }}</span>
                                                @endif
                                            </div>
                                            @if($hasDiscount)
                                                <span class="text-[10px] font-black text-emerald-600 block">{{ $st->discount_percentage }}% OFF</span>
                                            @endif
                                        </div>
                                        <button type="button" 
                                                onclick="addSuggestedToCart('{{ addslashes($st->name) }}', {{ $st->price }}, {{ $mrpPrice }}, '1 Parameter', this)"
                                                class="suggest-add-btn px-3.5 py-1.5 rounded-xl bg-teal-50 hover:bg-teal-700 text-teal-800 hover:text-white text-xs font-black border border-teal-200/80 hover:border-teal-700 transition-all duration-200 flex items-center gap-1 shadow-sm">
                                            <i class="fas fa-plus text-[10px]"></i>
                                            <span>Add</span>
                                        </button>
                                    </div>
                                </div>
                            @empty
                                {{-- Fallback standard tests if DB empty --}}
                                @php
                                    $defaultAddons = [
                                        ['name' => 'Complete Blood Count (CBC) with ESR', 'price' => 350, 'mrp' => 550, 'dept' => 'Complete Hemogram'],
                                        ['name' => 'HbA1c (3-Months Average Sugar)', 'price' => 450, 'mrp' => 700, 'dept' => 'Diabetes Profile'],
                                        ['name' => 'Vitamin D 25-Hydroxy (Total)', 'price' => 699, 'mrp' => 1200, 'dept' => 'Bone & Immunity'],
                                    ];
                                @endphp
                                @foreach($defaultAddons as $da)
                                <div class="suggested-test-card bg-white rounded-2xl p-4 border border-slate-200/90 hover:border-teal-500/50 hover:shadow-md transition-all flex flex-col justify-between group" data-test-name="{{ $da['name'] }}">
                                    <div>
                                        <div class="flex items-center justify-between gap-2 mb-2">
                                            <span class="text-[10px] font-black text-teal-700 bg-teal-50 px-2 py-0.5 rounded-md border border-teal-100 uppercase tracking-wider">
                                                {{ $da['dept'] }}
                                            </span>
                                            <span class="text-[10px] font-bold text-slate-400">Reports in 6h</span>
                                        </div>
                                        <h4 class="text-sm font-black text-slate-900 group-hover:text-teal-800 transition-colors line-clamp-2 mb-1.5">
                                            {{ $da['name'] }}
                                        </h4>
                                    </div>
                                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between mt-auto">
                                        <div>
                                            <span class="text-base font-black text-slate-900">₹{{ $da['price'] }}</span>
                                            <span class="text-xs text-slate-400 line-through font-bold">₹{{ $da['mrp'] }}</span>
                                        </div>
                                        <button type="button" 
                                                onclick="addSuggestedToCart('{{ addslashes($da['name']) }}', {{ $da['price'] }}, {{ $da['mrp'] }}, '1 Parameter', this)"
                                                class="suggest-add-btn px-3.5 py-1.5 rounded-xl bg-teal-50 hover:bg-teal-700 text-teal-800 hover:text-white text-xs font-black border border-teal-200/80 transition-all flex items-center gap-1 shadow-sm">
                                            <i class="fas fa-plus text-[10px]"></i>
                                            <span>Add</span>
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- STEP 2: Select Patient / Add Members -->
                <div id="step2" class="step-content hidden">
                    <div class="flex justify-between items-end mb-4">
                        <div>
                            <h2 class="text-2xl font-extrabold text-gray-800">Select Patient / Member</h2>
                            <p class="text-xs text-gray-500 font-semibold mt-1">Choose who this booking and sample collection is for</p>
                        </div>
                        <button onclick="window.openAddMemberModal()" class="text-brand-secondary font-bold text-sm border-b-2 border-brand-secondary border-dashed hover:text-brand-dark">+ Add Member</button>
                    </div>

                    <div class="space-y-4" id="memberSelectionList">
                        <!-- Primary Patient (Self) -->
                        <div class="member-card cursor-pointer bg-white border-2 border-brand-secondary rounded-xl p-4 flex items-start transition shadow-sm" onclick="selectMember(null, this)">
                            <div class="pt-1 mr-4">
                                <div class="w-6 h-6 rounded-full bg-brand-dark text-white flex items-center justify-center text-xs member-check-indicator">
                                    <i class="fas fa-check"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-bold text-gray-900 text-lg flex items-center"><span id="primaryPatientDisplayName">{{ (!empty($patient->name) && strtolower($patient->name) !== 'self') ? $patient->name : 'Self' }}</span> <span class="text-[10px] bg-brand-light/30 text-brand-dark px-2 py-0.5 rounded ml-2 uppercase font-extrabold">Self</span></h3>
                                        <p class="text-xs text-gray-500 font-semibold mt-1">{{ $patient->age ?? '25' }} Years | {{ ucfirst($patient->gender ?? 'Not Specified') }}</p>
                                    </div>
                                    <span class="text-xs font-bold text-brand-secondary">Primary Patient</span>
                                </div>

                                <!-- Inline Name Required Input if Name is missing or 'Self' -->
                                <div class="mt-3 pt-3 border-t border-slate-100 {{ (!empty($patient->name) && strtolower($patient->name) !== 'self') ? 'hidden' : '' }}" id="patientNamePromptBox" onclick="event.stopPropagation()">
                                    <label class="block text-xs font-black text-rose-700 mb-1 flex items-center gap-1.5">
                                        <i class="fas fa-id-card text-rose-600"></i>
                                        <span>Full Name Required for Diagnostic Report <span class="text-rose-600">*</span></span>
                                    </label>
                                    <div class="flex gap-2">
                                        <input type="text" id="checkoutPatientNameInput" value="{{ (!empty($patient->name) && strtolower($patient->name) !== 'self') ? $patient->name : '' }}" placeholder="Enter Patient Full Name (e.g. Ramesh Kumar)" class="flex-1 px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-xs font-bold text-gray-800 outline-none focus:bg-white focus:ring-2 focus:ring-teal-600">
                                        <button type="button" onclick="saveCheckoutPatientName()" class="px-3.5 py-2 bg-teal-800 hover:bg-teal-900 text-white rounded-lg text-xs font-bold transition flex items-center gap-1 whitespace-nowrap shadow-sm cursor-pointer">
                                            <i class="fas fa-check text-[10px]"></i>
                                            <span>Save Name</span>
                                        </button>
                                    </div>
                                    <p id="checkoutNameSavedMsg" class="text-[11px] text-emerald-700 font-bold mt-1.5 hidden flex items-center gap-1"><i class="fas fa-circle-check text-emerald-600"></i> Name saved successfully!</p>
                                </div>

                                <div class="mt-3 pt-3 border-t border-gray-100">
                                    <p class="text-xs text-gray-400 font-bold mb-1 uppercase tracking-wider">Assigned Tests / Packages:</p>
                                    <div class="member-cart-summary text-sm font-semibold text-gray-700">All tests in cart</div>
                                </div>
                            </div>
                        </div>

                        <!-- Family Members -->
                        @foreach(($patient->familyMembers ?? []) as $mem)
                        <div class="member-card cursor-pointer bg-white border border-gray-200 rounded-xl p-4 flex items-start transition hover:border-brand-secondary shadow-sm" onclick="selectMember({{ $mem->id }}, this)">
                            <div class="pt-1 mr-4">
                                <div class="w-6 h-6 rounded-full border border-gray-300 text-transparent flex items-center justify-center text-xs member-check-indicator">
                                    <i class="fas fa-check"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-bold text-gray-900 text-lg flex items-center">{{ $mem->name }} <span class="text-[10px] bg-gray-100 text-gray-600 px-2 py-0.5 rounded ml-2 uppercase font-extrabold">{{ $mem->relation }}</span></h3>
                                        <p class="text-xs text-gray-500 font-semibold mt-1">{{ $mem->age }} Years | {{ ucfirst($mem->gender) }}</p>
                                    </div>
                                    <span class="text-xs font-bold text-gray-400">Family Member</span>
                                </div>
                                <div class="mt-3 pt-3 border-t border-gray-100">
                                    <p class="text-xs text-gray-400 font-bold mb-1 uppercase tracking-wider">Assigned Tests / Packages:</p>
                                    <div class="member-cart-summary text-sm font-semibold text-gray-700">All tests in cart</div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- STEP 3: Address & Slots -->
                <div id="step3" class="step-content hidden">
                    <h2 class="text-2xl font-extrabold text-gray-800 mb-2">Sample Collection Address</h2>
                    <p class="text-sm text-gray-500 font-semibold mb-6">Select an address from where the sample will be picked</p>

                    <!-- Pincode Check (Custom Logic) -->
                    <div id="pincodeCheckSection" class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm mb-6 transition-all">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Area Pincode</label>
                        <div class="flex gap-4">
                            <input type="text" id="pincodeInput" class="flex-1 border border-gray-300 rounded-lg px-4 py-2 font-bold focus:ring-2 focus:ring-brand-secondary outline-none text-gray-800 tracking-wider" placeholder="Enter Pincode (e.g. 800001)" maxlength="6">
                            <button onclick="verifyPincode()" class="bg-brand-dark text-white font-bold px-6 py-2 rounded-lg hover:bg-brand-secondary transition">Verify</button>
                        </div>
                        <p id="pincodeError" class="text-red-500 text-sm font-bold mt-2 hidden">Sorry, service not available in this area.</p>
                        <p id="pincodeSuccess" class="text-green-600 text-sm font-bold mt-2 hidden"><i class="fas fa-check-circle mr-1"></i> Service available!</p>
                    </div>

                    <!-- Hidden Address & Slot Section -->
                    <div id="addressAndSlotSection" class="hidden">
                        @php
                            $defaultAddress = $patient->addresses->first();
                        @endphp
                        @if($patient->addresses->isEmpty())
                        <div id="noAddressAlertBox" class="border-2 border-dashed border-amber-300 rounded-2xl p-5 mb-8 bg-amber-50/70 flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center text-xl font-bold flex-shrink-0">
                                    <i class="fas fa-map-location-dot"></i>
                                </div>
                                <div>
                                    <h4 class="font-black text-gray-900 text-sm">Sample Collection Address Required</h4>
                                    <p class="text-xs text-gray-600 mt-0.5">Please add your complete address for home sample collection before proceeding.</p>
                                </div>
                            </div>
                            <button type="button" onclick="window.openAddAddressModal()" class="w-full sm:w-auto px-5 py-2.5 bg-teal-800 hover:bg-teal-900 text-white rounded-xl text-xs font-bold transition flex items-center justify-center gap-2 shadow-sm whitespace-nowrap cursor-pointer">
                                <i class="fas fa-plus text-xs"></i>
                                <span>Add Address Now</span>
                            </button>
                        </div>
                        @else
                        <div class="border border-gray-200 rounded-xl p-4 flex justify-between items-center mb-8 bg-white shadow-sm">
                            <div class="flex items-start">
                                <i class="fas fa-map-marker-alt text-brand-secondary mt-1 mr-3 text-lg"></i>
                                <div>
                                    <h4 class="font-bold text-gray-800 text-sm">Collection Address <span id="displayAddressType" class="bg-brand-light/30 text-brand-dark text-[10px] px-2 py-0.5 rounded ml-2">{{ $defaultAddress?->title ?? 'Home' }}</span></h4>
                                    <p id="displayAddressText" class="text-xs text-gray-500 mt-1">{{ $defaultAddress ? ($defaultAddress->full_address . ' - ' . $defaultAddress->pincode) : 'No address selected. Please click Change to select or add.' }}</p>
                                </div>
                            </div>
                            <button onclick="window.openChangeAddressModal()" class="text-brand-dark font-bold text-xs border-b border-brand-dark border-dashed hover:text-brand-secondary">Change</button>
                        </div>
                        @endif

                        <h3 class="font-extrabold text-gray-800 text-lg mb-4">Collection Date</h3>
                        <div class="flex gap-3 overflow-x-auto pb-4 no-scrollbar" id="dateContainer">
                            @for ($d = 0; $d < 7; $d++)
                                @php
                                    $dateObj = now()->addDays($d);
                                    $isFirst = ($d === 0);
                                @endphp
                                <div class="date-item flex-none w-16 h-20 rounded-xl flex flex-col items-center justify-center cursor-pointer shadow-sm transition {{ $isFirst ? 'border-2 border-brand-secondary bg-brand-light/10 text-brand-secondary active-date' : 'border border-gray-200 bg-white hover:border-brand-secondary' }}"
                                     data-date="{{ $dateObj->format('Y-m-d') }}">
                                    <span class="text-xs {{ $isFirst ? 'font-bold text-brand-secondary' : 'font-semibold text-gray-500' }}">{{ $dateObj->format('D') }}</span>
                                    <span class="text-lg font-black {{ $isFirst ? 'text-brand-secondary' : 'text-gray-800' }}">{{ $dateObj->format('d') }}</span>
                                    <span class="text-xs {{ $isFirst ? 'font-bold text-brand-secondary' : 'font-semibold text-gray-500' }}">{{ $dateObj->format('M') }}</span>
                                </div>
                            @endfor
                        </div>

                        <h3 class="font-extrabold text-gray-800 text-lg mb-4 mt-6">Available Slots</h3>
                        
                        <!-- Morning Slots -->
                        <div class="mb-6">
                            <p class="text-xs font-bold text-gray-400 mb-3 flex items-center"><i class="fas fa-cloud-sun mr-2"></i> Morning</p>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3 slot-container">
                                <div class="slot-item border border-gray-200 bg-white rounded-lg py-2 text-center text-xs font-bold text-gray-600 hover:border-brand-secondary hover:text-brand-secondary cursor-pointer transition shadow-sm">05:00 AM - 06:00 AM</div>
                                <div class="slot-item border border-gray-200 bg-white rounded-lg py-2 text-center text-xs font-bold text-gray-600 hover:border-brand-secondary hover:text-brand-secondary cursor-pointer transition shadow-sm">06:00 AM - 07:00 AM</div>
                                <div class="slot-item border-2 border-brand-secondary bg-brand-light/10 rounded-lg py-2 text-center text-xs font-bold text-brand-dark cursor-pointer shadow-sm transition active-slot">07:00 AM - 08:00 AM</div>
                                <div class="slot-item border border-gray-200 bg-white rounded-lg py-2 text-center text-xs font-bold text-gray-600 hover:border-brand-secondary hover:text-brand-secondary cursor-pointer transition shadow-sm">08:00 AM - 09:00 AM</div>
                                <div class="slot-item border border-gray-200 bg-white rounded-lg py-2 text-center text-xs font-bold text-gray-600 hover:border-brand-secondary hover:text-brand-secondary cursor-pointer transition shadow-sm">09:00 AM - 10:00 AM</div>
                                <div class="slot-item border border-gray-200 bg-white rounded-lg py-2 text-center text-xs font-bold text-gray-600 hover:border-brand-secondary hover:text-brand-secondary cursor-pointer transition shadow-sm">10:00 AM - 11:00 AM</div>
                                <div class="slot-item border border-gray-200 bg-white rounded-lg py-2 text-center text-xs font-bold text-gray-600 hover:border-brand-secondary hover:text-brand-secondary cursor-pointer transition shadow-sm">11:00 AM - 12:00 PM</div>
                            </div>
                        </div>

                        <!-- Afternoon Slots -->
                        <div class="mb-6">
                            <p class="text-xs font-bold text-gray-400 mb-3 flex items-center"><i class="fas fa-sun mr-2"></i> Afternoon</p>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3 slot-container">
                                <div class="slot-item border border-gray-200 bg-white rounded-lg py-2 text-center text-xs font-bold text-gray-600 hover:border-brand-secondary hover:text-brand-secondary cursor-pointer transition shadow-sm">12:00 PM - 01:00 PM</div>
                                <div class="slot-item border border-gray-200 bg-white rounded-lg py-2 text-center text-xs font-bold text-gray-600 hover:border-brand-secondary hover:text-brand-secondary cursor-pointer transition shadow-sm">01:00 PM - 02:00 PM</div>
                                <div class="slot-item border border-gray-200 bg-white rounded-lg py-2 text-center text-xs font-bold text-gray-600 hover:border-brand-secondary hover:text-brand-secondary cursor-pointer transition shadow-sm">02:00 PM - 03:00 PM</div>
                                <div class="slot-item border border-gray-200 bg-white rounded-lg py-2 text-center text-xs font-bold text-gray-600 hover:border-brand-secondary hover:text-brand-secondary cursor-pointer transition shadow-sm">03:00 PM - 04:00 PM</div>
                            </div>
                        </div>

                        <!-- Evening Slots -->
                        <div class="mb-6">
                            <p class="text-xs font-bold text-gray-400 mb-3 flex items-center"><i class="fas fa-moon mr-2"></i> Evening</p>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3 slot-container">
                                <div class="slot-item border border-gray-200 bg-white rounded-lg py-2 text-center text-xs font-bold text-gray-600 hover:border-brand-secondary hover:text-brand-secondary cursor-pointer transition shadow-sm">05:00 PM - 06:00 PM</div>
                                <div class="slot-item border border-gray-200 bg-white rounded-lg py-2 text-center text-xs font-bold text-gray-600 hover:border-brand-secondary hover:text-brand-secondary cursor-pointer transition shadow-sm">06:00 PM - 07:00 PM</div>
                                <div class="slot-item border border-gray-200 bg-white rounded-lg py-2 text-center text-xs font-bold text-gray-600 hover:border-brand-secondary hover:text-brand-secondary cursor-pointer transition shadow-sm">07:00 PM - 08:00 PM</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 4: Payment -->
                <div id="step4" class="step-content hidden">
                    <div class="bg-brand-light/10 border-l-4 border-brand-secondary rounded-r-xl p-4 mb-6 flex items-center shadow-sm">
                        <h2 class="text-brand-dark font-extrabold text-2xl tracking-tighter mr-4">4x<span class="text-lg font-normal">VALUE</span></h2>
                        <div>
                            <h4 class="font-bold text-sm text-gray-800">Expert Consultation</h4>
                            <p class="text-xs text-gray-500 font-semibold">Free with every test</p>
                        </div>
                    </div>

                    <!-- 1. Interactive Booking Summary Accordion -->
                    <div class="border border-slate-200 bg-white rounded-2xl mb-4 shadow-sm overflow-hidden transition-all">
                        <button type="button" onclick="toggleBookingSummaryAccordion()" class="w-full p-4 sm:p-4.5 flex justify-between items-center hover:bg-slate-50/80 transition text-left cursor-pointer group">
                            <div class="flex items-center gap-3.5">
                                <div class="w-10 h-10 rounded-xl bg-teal-50 border border-teal-200/60 text-teal-800 flex items-center justify-center text-base font-black shadow-2xs group-hover:scale-105 transition-transform">
                                    <i class="fas fa-clipboard-list"></i>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h4 class="font-black text-slate-900 text-sm">Booking Summary</h4>
                                        <span class="text-[10px] font-black uppercase tracking-wider text-teal-800 bg-teal-50 border border-teal-200 px-2 py-0.5 rounded-full" id="bookingSummaryItemCount">0 Items</span>
                                    </div>
                                    <p class="text-[11px] text-slate-500 font-medium mt-0.5">Click to review tests, patient details & collection address</p>
                                </div>
                            </div>
                            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 group-hover:bg-teal-50 group-hover:text-teal-800 transition">
                                <i class="fas fa-chevron-down text-xs transition-transform duration-200" id="bookingSummaryChevron"></i>
                            </div>
                        </button>
                        
                        <!-- Collapsible Body -->
                        <div id="bookingSummaryContent" class="hidden border-t border-slate-100 p-4 sm:p-5 bg-slate-50/60 space-y-3.5">
                            <!-- Patient Details Card -->
                            <div class="bg-white p-3.5 rounded-xl border border-slate-200/80 flex items-center justify-between shadow-2xs">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-700 flex items-center justify-center text-xs font-bold">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div>
                                        <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 block">Patient / Beneficiary</span>
                                        <span class="text-xs font-black text-slate-800" id="summaryPatientName">{{ $patient->name ?? 'Self' }} (Primary Patient)</span>
                                    </div>
                                </div>
                                <button type="button" onclick="goToStep(2)" class="text-xs font-black text-teal-800 hover:text-teal-950 underline underline-offset-2">
                                    Change
                                </button>
                            </div>

                            <!-- Collection Address Card -->
                            <div class="bg-white p-3.5 rounded-xl border border-slate-200/80 flex items-start justify-between gap-3 shadow-2xs">
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-teal-50 text-teal-700 flex items-center justify-center text-xs font-bold mt-0.5 flex-shrink-0">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div>
                                        <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 block">Sample Pickup Address</span>
                                        <span class="text-xs font-medium text-slate-700 block leading-snug" id="summaryAddressFull">{{ $defaultAddr ? ($defaultAddr->full_address . ' - ' . $defaultAddr->pincode) : 'No address selected' }}</span>
                                    </div>
                                </div>
                                <button type="button" onclick="window.openChangeAddressModal()" class="text-xs font-black text-teal-800 hover:text-teal-950 underline underline-offset-2 flex-shrink-0">
                                    Change
                                </button>
                            </div>

                            <!-- Appointment Slot Card -->
                            <div class="bg-white p-3.5 rounded-xl border border-slate-200/80 flex items-center justify-between shadow-2xs">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-700 flex items-center justify-center text-xs font-bold">
                                        <i class="far fa-clock"></i>
                                    </div>
                                    <div>
                                        <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 block">Appointment Schedule</span>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            <span class="text-xs font-black text-slate-900" id="summarySlotDateText">Selected Date</span>
                                            <span class="text-slate-300">•</span>
                                            <span class="text-[11px] font-black text-amber-900 bg-amber-100/90 border border-amber-300/80 px-2 py-0.5 rounded-md" id="summarySlotTimeText">07:00 AM - 08:00 AM</span>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" onclick="goToStep(3)" class="text-xs font-black text-teal-800 hover:text-teal-950 underline underline-offset-2">
                                    Change
                                </button>
                            </div>

                            <!-- Booked Tests & Packages List -->
                            <div class="pt-1">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-[10px] font-black uppercase tracking-wider text-slate-400">Diagnostic Tests & Panels</span>
                                    <button type="button" onclick="goToStep(1)" class="text-[11px] font-bold text-teal-800 hover:underline">Edit Cart</button>
                                </div>
                                <div id="bookingSummaryItemsList" class="space-y-2 max-h-56 overflow-y-auto pr-1">
                                    <!-- Populated via JS -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Interactive Unlock Coupons & Offers Card -->
                    <div onclick="openCouponsModal()" class="border border-indigo-200/80 bg-gradient-to-r from-indigo-50/70 via-purple-50/40 to-white rounded-2xl p-4 mb-5 flex justify-between items-center cursor-pointer hover:border-indigo-400 hover:shadow-md transition-all shadow-xs group">
                        <div class="flex items-center gap-3.5">
                            <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center text-base font-black shadow-xs group-hover:scale-105 transition-transform">
                                <i class="fas fa-ticket-alt"></i>
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h4 class="font-black text-slate-900 text-sm">Unlock Coupons & Offers</h4>
                                    <span class="text-[9px] font-black uppercase tracking-wider text-indigo-700 bg-indigo-100 px-2 py-0.5 rounded-full border border-indigo-200">Offers Available</span>
                                </div>
                                <p class="text-[11px] text-slate-500 font-medium mt-0.5" id="step4CouponSummaryText">Click to browse promo codes & instant discounts</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-black text-indigo-700 group-hover:underline">View Offers</span>
                            <i class="fas fa-chevron-right text-indigo-400 text-xs group-hover:translate-x-0.5 transition-transform"></i>
                        </div>
                    </div>

                    <!-- Selected Appointment Date & Time Slot Banner -->
                    <div id="step4AppointmentSummary" class="bg-gradient-to-r from-teal-50/90 via-emerald-50/70 to-teal-50/90 border border-teal-200/90 rounded-2xl p-4 mb-6 flex items-center justify-between shadow-xs">
                        <div class="flex items-center gap-3.5">
                            <div class="w-10 h-10 rounded-xl bg-teal-700 text-white flex items-center justify-center text-lg font-black shadow-xs flex-shrink-0">
                                <i class="far fa-calendar-check"></i>
                            </div>
                            <div>
                                <span class="text-[10px] font-black uppercase tracking-wider text-teal-800 block leading-tight">Collection Appointment Slot</span>
                                <div class="flex items-center gap-2 mt-1 flex-wrap">
                                    <span class="text-xs font-black text-slate-900" id="step4SummaryDate">Date</span>
                                    <span class="text-slate-300 hidden sm:inline">•</span>
                                    <span class="inline-flex items-center gap-1 text-[11px] font-black text-amber-900 bg-amber-100/90 border border-amber-300/80 px-2 py-0.5 rounded-md">
                                        <i class="far fa-clock text-[10px] text-amber-700"></i>
                                        <span id="step4SummarySlot">07:00 AM - 08:00 AM</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <button type="button" onclick="currentStep = 3; updateUI(); window.scrollTo({ top: 0, behavior: 'smooth' });" class="text-xs font-black text-teal-800 hover:text-teal-950 underline underline-offset-2 flex-shrink-0">
                            Change Slot
                        </button>
                    </div>

                    <div class="flex justify-between items-end mb-4">
                        <div>
                            <h3 class="font-extrabold text-gray-800 text-lg">Wellcare VIP Membership</h3>
                            <p class="text-xs text-gray-500 font-medium">Unlock flat discounts and complimentary home sample collections</p>
                        </div>
                        <a href="{{ route('patient.membership') }}" target="_blank" class="text-brand-secondary font-bold text-xs hover:underline flex items-center gap-1">
                            <span>Compare Plans</span> <i class="fas fa-external-link-alt text-[10px]"></i>
                        </a>
                    </div>

                    @if($patientVip)
                        <div class="rounded-2xl bg-gradient-to-r from-amber-500/15 via-amber-400/10 to-amber-500/5 border border-amber-300/80 p-4 sm:p-5 flex items-center justify-between gap-4 shadow-sm mb-6">
                            <div class="flex items-center gap-3.5">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-amber-400 to-amber-600 text-slate-950 flex items-center justify-center text-lg font-black shadow-sm flex-shrink-0">
                                    <i class="fas fa-crown"></i>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-[10px] font-black uppercase tracking-wider text-amber-900 bg-amber-200/60 px-2.5 py-0.5 rounded-full border border-amber-300">Active Membership</span>
                                        <span class="text-xs font-black text-slate-800">{{ $patientVip->plan_name_snapshot }}</span>
                                    </div>
                                    <p class="text-xs text-slate-600 font-semibold mt-1">
                                        Flat <strong class="text-amber-800 font-black">{{ $patientVip->discount_percentage }}% VIP Discount</strong> is applied to this booking.
                                    </p>
                                </div>
                            </div>
                            <span class="text-xs font-black text-emerald-600 flex items-center gap-1 flex-shrink-0"><i class="fas fa-check-circle"></i> Benefit Applied</span>
                        </div>
                    @elseif($vipPlans->isNotEmpty())
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                            @foreach($vipPlans as $vPlan)
                                <div class="vip-plan-card border-2 {{ $vPlan->is_popular ? 'border-amber-400 bg-amber-50/20' : 'border-slate-200 bg-white' }} rounded-2xl p-4 sm:p-5 relative cursor-pointer hover:border-amber-500 shadow-sm transition-all" 
                                     onclick="selectVipPlanCard({{ $vPlan->id }}, {{ $vPlan->price }}, {{ $vPlan->discount_percentage }}, '{{ addslashes($vPlan->name) }}', '{{ $vPlan->formatted_duration }}', this)"
                                     data-vip-plan-id="{{ $vPlan->id }}"
                                     {{ $vPlan->is_popular ? 'data-is-popular="true"' : '' }}>
                                    @if($vPlan->is_popular)
                                        <div class="absolute top-0 right-4 bg-amber-500 text-white text-[9px] font-black uppercase px-2.5 py-0.5 rounded-b-md tracking-wider">
                                            Recommended
                                        </div>
                                    @endif
                                    <div class="vip-check-indicator absolute top-4 right-4 w-6 h-6 rounded-full border-2 border-slate-300 bg-white flex items-center justify-center text-xs text-transparent">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center text-lg mb-3 shadow-xs">
                                        <i class="fas fa-crown"></i>
                                    </div>
                                    <h4 class="font-black text-slate-900 text-sm mb-0.5">{{ $vPlan->name }}</h4>
                                    <p class="text-[11px] text-slate-500 font-medium leading-tight mb-2">Flat <strong class="text-amber-700 font-black">{{ $vPlan->discount_percentage }}% OFF</strong> + Free Home Collection</p>
                                    <div class="flex items-baseline gap-1.5">
                                        <span class="text-xl font-black text-slate-900">₹{{ number_format($vPlan->price, 0) }}</span>
                                        <span class="text-[11px] font-bold text-slate-400">/ {{ $vPlan->formatted_duration }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    
                    <div class="bg-green-50 text-green-700 text-xs font-bold p-3 rounded-lg text-center shadow-sm"><i class="fas fa-tree mr-2"></i> With every health checkup, you're helping plant a tree!</div>
                </div>

            </div>

            <!-- Right Column: Summary & Bill -->
            <div class="lg:w-1/3">
                <div class="sticky top-24">
                    
                    <!-- Apply Coupon / Promo Code Block -->
                    <div id="checkoutCouponSection" class="bg-white border border-gray-200 rounded-xl p-4 mb-4 shadow-sm">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-black text-gray-800 uppercase tracking-wide flex items-center gap-1.5">
                                <i class="fas fa-ticket-alt text-brand-secondary"></i>
                                <span>Apply Coupon / Promo Code</span>
                            </span>
                        </div>

                        <!-- Coupon Input Field -->
                        <div id="couponInputContainer" class="flex gap-2">
                            <input type="text" id="checkoutCouponInput" placeholder="Enter coupon code" 
                                class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-xs uppercase font-mono font-black focus:ring-2 focus:ring-brand-secondary outline-none text-gray-800 placeholder-gray-400">
                            <button type="button" onclick="applyCouponManual()" id="applyCouponBtn" 
                                class="bg-brand-dark hover:bg-brand-secondary text-white px-4 py-2 rounded-lg text-xs font-bold transition flex items-center gap-1">
                                <span>Apply</span>
                            </button>
                        </div>

                        <!-- Coupon Message Alert -->
                        <div id="couponStatusMessage" class="hidden text-[11px] font-bold mt-2 p-2 rounded-lg"></div>

                        <!-- Active Applied Coupon Pill -->
                        <div id="appliedCouponDisplay" class="hidden mt-2.5 p-3 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-lg bg-emerald-500 text-white flex items-center justify-center text-[10px] font-bold">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <span class="font-mono font-black text-xs text-emerald-800" id="appliedCouponCodeText"></span>
                                    <span class="text-[10px] text-emerald-600 block font-semibold" id="appliedCouponSavingsText"></span>
                                </div>
                            </div>
                            <button type="button" onclick="removeAppliedCoupon()" class="text-xs font-bold text-rose-500 hover:text-rose-700">Remove</button>
                        </div>

                        <!-- Available Coupons for Quick Apply -->
                        @if((isset($myCoupons) && $myCoupons->count() > 0) || (isset($bannerCoupons) && $bannerCoupons->count() > 0))
                            <div class="mt-3 pt-3 border-t border-gray-100">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Available Offers</span>
                                    <span class="text-[10px] font-bold text-brand-secondary">Click to Apply</span>
                                </div>
                                <div class="space-y-2 max-h-48 overflow-y-auto pr-1">
                                    {{-- User Welcome Coupon --}}
                                    @if(isset($myCoupons))
                                        @foreach($myCoupons as $pc)
                                            @if($pc->coupon && $pc->coupon->is_active)
                                                <div onclick="applyQuickCoupon('{{ $pc->coupon->code }}')" class="p-2.5 rounded-xl border border-indigo-100 bg-indigo-50/50 hover:bg-indigo-50 cursor-pointer transition flex items-center justify-between group">
                                                    <div>
                                                        <div class="flex items-center gap-1.5">
                                                            <span class="font-mono font-black text-xs text-indigo-700 bg-white px-2 py-0.5 rounded border border-indigo-200">{{ $pc->coupon->code }}</span>
                                                            @if($pc->coupon->coupon_type === 'welcome')
                                                                <span class="text-[9px] font-black uppercase text-purple-600 bg-purple-100 px-1.5 py-0.5 rounded">🎁 1st Order</span>
                                                            @endif
                                                        </div>
                                                        <p class="text-[10px] text-gray-600 font-medium mt-1">
                                                            {{ $pc->coupon->discount_type === 'percentage' ? $pc->coupon->discount_value . '% OFF' : '₹' . number_format($pc->coupon->discount_value) . ' Flat OFF' }}
                                                            @if($pc->coupon->min_order_amount > 0)
                                                                (Min order: ₹{{ number_format($pc->coupon->min_order_amount) }})
                                                            @endif
                                                        </p>
                                                    </div>
                                                    <span class="text-[11px] font-bold text-indigo-600 group-hover:underline">Apply</span>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif

                                    {{-- Banner / Spend-Based Coupons --}}
                                    @if(isset($bannerCoupons))
                                        @foreach($bannerCoupons as $bc)
                                            <div onclick="applyQuickCoupon('{{ $bc->code }}')" class="p-2.5 rounded-xl border border-amber-100 bg-amber-50/50 hover:bg-amber-50 cursor-pointer transition flex items-center justify-between group">
                                                <div>
                                                    <div class="flex items-center gap-1.5">
                                                        <span class="font-mono font-black text-xs text-amber-800 bg-white px-2 py-0.5 rounded border border-amber-200">{{ $bc->code }}</span>
                                                        <span class="text-[9px] font-black uppercase text-amber-700 bg-amber-100 px-1.5 py-0.5 rounded">📢 Offer</span>
                                                    </div>
                                                    <p class="text-[10px] text-gray-600 font-medium mt-1">
                                                        {{ $bc->discount_type === 'percentage' ? $bc->discount_value . '% OFF' : '₹' . number_format($bc->discount_value) . ' Flat OFF' }}
                                                        @if($bc->min_order_amount > 0)
                                                            on orders > ₹{{ number_format($bc->min_order_amount) }}
                                                        @endif
                                                    </p>
                                                </div>
                                                <span class="text-[11px] font-bold text-amber-700 group-hover:underline">Apply</span>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Health Coins Redemption Widget -->
                    @if(isset($rewardSettings) && $rewardSettings['enabled'])
                    <div id="rewardCoinsSection" class="bg-gradient-to-br from-amber-500/10 via-yellow-500/5 to-white border border-amber-300/80 rounded-2xl p-4 mb-4 shadow-sm relative overflow-hidden">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-xl bg-amber-500 text-slate-950 flex items-center justify-center text-xs font-black shadow-xs">
                                    🪙
                                </div>
                                <div>
                                    <span class="text-xs font-black text-slate-900 block leading-tight">Health Coins Loyalty</span>
                                    <span class="text-[11px] text-amber-800 font-bold">
                                        Balance: <strong class="text-slate-900">{{ number_format($rewardSettings['patient_coins']) }}</strong> Coins
                                        <span class="text-slate-500 font-normal">(≈ ₹{{ number_format($rewardSettings['patient_coins'] * $rewardSettings['coin_value'], 2) }})</span>
                                    </span>
                                </div>
                            </div>
                            <span class="text-[10px] font-black uppercase tracking-wider px-2 py-0.5 rounded-full bg-amber-100 text-amber-900 border border-amber-300/60">
                                1 🪙 = ₹{{ number_format($rewardSettings['coin_value'], 2) }}
                            </span>
                        </div>

                        <!-- Eligible Container -->
                        <div id="coinEligibleNotice" class="hidden mt-3 pt-3 border-t border-amber-200/60">
                            <label class="flex items-center gap-2 cursor-pointer select-none">
                                <input type="checkbox" id="redeemCoinsCheckbox" onchange="toggleCoinRedemption(this.checked)" class="w-4 h-4 rounded text-amber-600 focus:ring-amber-500 accent-amber-600">
                                <span class="text-xs font-black text-slate-900">
                                    Redeem Health Coins on this Order
                                </span>
                            </label>

                            <!-- Coin Input Wrapper (Hidden when unchecked) -->
                            <div id="coinInputWrapper" class="hidden mt-2.5 p-3 rounded-xl bg-white border border-amber-200 space-y-2">
                                <div class="flex items-center justify-between text-[11px] font-bold text-slate-600">
                                    <span>Coins to redeem:</span>
                                    <span>Max allowed: <strong id="maxCoinsAllowedBadge" class="text-amber-700">0</strong></span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <input type="number" id="coinsToRedeemInput" min="1" step="1" oninput="onCoinInputChange(this.value)"
                                        class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs font-black text-slate-900 focus:ring-2 focus:ring-amber-500 outline-none">
                                    <button type="button" onclick="applyMaxCoins()" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-slate-950 font-black text-[11px] rounded-lg transition whitespace-nowrap">
                                        Max
                                    </button>
                                </div>
                                <p class="text-[10px] text-slate-400">
                                    Cap: Max {{ $rewardSettings['max_redeem_type'] === 'percentage' ? $rewardSettings['max_redeem_value'] . '% of order' : $rewardSettings['max_redeem_value'] . ' coins' }}.
                                </p>
                            </div>
                        </div>

                        <!-- Ineligible Notice -->
                        <div id="coinIneligibleNotice" class="hidden mt-2 pt-2 border-t border-amber-100 text-[11px] text-amber-800 font-semibold flex items-center gap-1.5">
                            <i class="fas fa-lock text-[10px] text-amber-600"></i>
                            <span></span>
                        </div>
                    </div>
                    @endif

                    <!-- Persistent Unified Order Bill Breakdown (Always Visible in Steps 1-4) -->
                    <div id="orderBillBreakdown" class="border border-slate-200/90 rounded-2xl overflow-hidden mb-4 bg-white shadow-sm">
                        <div class="p-4 sm:p-5 border-b border-slate-100 space-y-3">
                            <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                                <span class="text-xs font-black uppercase tracking-wider text-slate-600 flex items-center gap-1.5">
                                    <i class="fas fa-file-invoice-dollar text-teal-600"></i> Order Bill Breakdown
                                </span>
                                <span class="text-[10px] font-bold text-teal-800 bg-teal-50 px-2 py-0.5 rounded-full border border-teal-200/60 flex items-center gap-1">
                                    <i class="fas fa-shield-halved text-teal-600"></i> Verified Prices
                                </span>
                            </div>

                            <!-- MRP Total -->
                            <div class="flex justify-between text-sm font-medium text-slate-600">
                                <span>Tests Total (MRP)</span>
                                <span data-bill-mrp class="line-through text-slate-400 font-bold">₹0</span>
                            </div>

                            <!-- Diagnostic Discount -->
                            <div class="flex justify-between text-sm font-semibold text-emerald-600">
                                <span>Diagnostic Discount</span>
                                <span data-bill-mrp-savings class="font-bold">-₹0</span>
                            </div>

                            <!-- VIP Plan Row -->
                            <div class="vip-plan-row hidden flex justify-between text-sm font-semibold text-amber-800">
                                <span class="flex items-center gap-1.5"><i class="fas fa-crown text-amber-500 text-xs"></i> <span><span class="vip-plan-name-badge font-bold">VIP Pass</span> (<span class="vip-plan-duration-badge text-[11px]"></span>)</span></span>
                                <span class="font-black text-slate-900">+<span data-bill-vip-price>₹0</span></span>
                            </div>

                            <!-- VIP Discount Row -->
                            <div class="vip-discount-row hidden flex justify-between text-sm font-semibold text-emerald-600">
                                <span class="flex items-center gap-1.5"><i class="fas fa-crown text-amber-500 text-xs"></i> <span>VIP Test Discount (<span class="vip-discount-percent-badge font-black"></span>)</span></span>
                                <span class="font-black">-<span data-bill-vip-discount>₹0</span></span>
                            </div>

                            <!-- Free Home Sample Collection -->
                            <div class="flex justify-between text-sm font-medium text-slate-600">
                                <span>Home Sample Collection</span>
                                <span class="font-bold text-emerald-600 flex items-center gap-1">
                                    <span class="line-through text-slate-400 text-xs font-normal">₹150</span>
                                    <span>FREE</span>
                                </span>
                            </div>

                            <!-- Free Doctor Tele-Consultation -->
                            <div class="flex justify-between text-sm font-medium text-slate-600">
                                <span>Doctor Report Consultation</span>
                                <span class="font-bold text-emerald-600 flex items-center gap-1">
                                    <span class="line-through text-slate-400 text-xs font-normal">₹299</span>
                                    <span>FREE</span>
                                </span>
                            </div>

                            <!-- Coupon Discount Row -->
                            <div class="coupon-discount-row hidden flex justify-between text-sm font-semibold text-emerald-600 pt-1 border-t border-slate-100">
                                <span class="flex items-center gap-1"><i class="fas fa-tag text-xs"></i> <span>Coupon (<span class="coupon-code-badge font-mono font-black"></span>)</span></span>
                                <span class="font-bold">-<span data-bill-discount>₹0</span></span>
                            </div>

                            <!-- Health Coins Redeemed Row -->
                            <div class="coins-discount-row hidden flex justify-between text-sm font-semibold text-amber-700 pt-1 border-t border-slate-100">
                                <span class="flex items-center gap-1.5"><i class="fas fa-coins text-amber-500 text-xs"></i> <span>Health Coins Redeemed (<span class="coins-redeemed-count-badge font-mono font-black">0</span> 🪙)</span></span>
                                <span class="font-bold text-amber-700"><span data-bill-coins-discount>-₹0</span></span>
                            </div>
                        </div>

                        <!-- Total Payable Row -->
                        <div class="p-4 sm:p-5 bg-slate-50 flex justify-between items-center border-t border-slate-100">
                            <div>
                                <span class="font-black text-slate-900 text-sm block">Total Payable</span>
                                <span class="text-[11px] font-semibold text-slate-500">Includes all taxes & sample fees</span>
                            </div>
                            <span data-bill-amount class="font-black text-2xl text-teal-900">₹0</span>
                        </div>

                        <!-- Coins Earning Preview Callout -->
                        <div id="coinEarnPreview" class="hidden px-4 py-2.5 bg-amber-50/70 border-t border-amber-100 text-amber-900 text-xs font-bold flex items-center justify-between">
                            <span class="flex items-center gap-1.5">
                                <span>🪙</span>
                                <span>Rewards you'll earn on this order:</span>
                            </span>
                            <span class="font-black text-amber-800 bg-amber-100/80 px-2 py-0.5 rounded-full">+<span id="coinsToEarnValue">0</span> Coins</span>
                        </div>
                    </div>

                    <!-- Booking Savings Highlight Box -->
                    <div id="bookingSavingsCallout" class="bg-emerald-50 border border-emerald-200/80 text-emerald-800 text-xs font-bold p-3 rounded-2xl text-center mb-4 shadow-sm flex items-center justify-center gap-2">
                        <span>🎉</span>
                        <span>Total Savings on this order: <span id="totalSavingsValueText" class="font-black text-emerald-900 text-sm">₹0</span></span>
                    </div>

                    <!-- Action Buttons -->
                    <button id="btnNext" onclick="nextStep()" class="w-full bg-teal-800 hover:bg-teal-900 text-white font-black py-4 rounded-2xl shadow-lg shadow-teal-900/15 transition-all text-base flex items-center justify-center gap-2">
                        <span>Proceed to Patient Details</span>
                        <i class="fas fa-arrow-right text-xs"></i>
                    </button>
                    
                    <div id="btnPay" class="hidden flex gap-3 mt-3">
                        <button type="button" onclick="payOnCollection()" class="flex-1 bg-white border-2 border-slate-200 hover:border-slate-300 text-slate-800 font-bold py-3.5 rounded-2xl transition shadow-sm text-xs">
                            <i class="fas fa-money-bill-wave text-teal-600 mr-1.5"></i> Pay on Collection
                        </button>
                        <button type="button" onclick="payOnlineRazorpay()" id="btnPayOnline" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-black py-3.5 rounded-2xl shadow-md transition text-xs flex items-center justify-center gap-1.5 cursor-pointer">
                            <i class="fas fa-lock text-xs"></i> <span>Pay Now Online</span>
                        </button>
                    </div>
                    
                    <!-- Clinical Quality & Trust Badges -->
                    <div class="mt-5 pt-4 border-t border-slate-200 space-y-2 text-[11px] font-semibold text-slate-500">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-shield-halved text-teal-600 text-xs flex-shrink-0"></i>
                            <span>100% Quality Certified Testing Laboratories</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-temperature-arrow-down text-teal-600 text-xs flex-shrink-0"></i>
                            <span>Barcoded Cold-Chain Temperature Controlled Vials</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fab fa-whatsapp text-emerald-600 text-xs flex-shrink-0"></i>
                            <span>Smart PDF Reports on WhatsApp within 12-24 Hours</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Interactive Coupons & Offers Modal -->
<div id="couponsModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full shadow-2xl border border-slate-100 overflow-hidden transform transition-all animate-in fade-in zoom-in-95 duration-200">
        <!-- Modal Header -->
        <div class="p-5 sm:p-6 bg-gradient-to-r from-teal-900 via-teal-800 to-indigo-950 text-white flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-white/15 text-amber-300 flex items-center justify-center text-lg font-black backdrop-blur-xs shadow-xs">
                    <i class="fas fa-tags"></i>
                </div>
                <div>
                    <h3 class="font-black text-white text-base">Exclusive Offers & Coupons</h3>
                    <p class="text-xs text-teal-200 font-medium">Apply a promo code to save more on your booking</p>
                </div>
            </div>
            <button type="button" onclick="closeCouponsModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition cursor-pointer">
                <i class="fas fa-times text-xs"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-5 sm:p-6 space-y-5 max-h-[75vh] overflow-y-auto">
            <!-- Manual Coupon Code Input Box -->
            <div>
                <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Have a Promo Code?</label>
                <div class="flex gap-2">
                    <input type="text" id="modalCouponInput" placeholder="ENTER COUPON CODE" 
                        class="flex-1 border-2 border-slate-200 focus:border-teal-600 rounded-xl px-4 py-2.5 text-xs font-mono font-black uppercase outline-none text-slate-800 placeholder-slate-400 tracking-wider">
                    <button type="button" onclick="applyModalCouponManual()" id="modalApplyBtn" 
                        class="bg-teal-800 hover:bg-teal-900 text-white px-5 py-2.5 rounded-xl text-xs font-black transition shadow-sm cursor-pointer">
                        Apply
                    </button>
                </div>
                <div id="modalCouponStatusMessage" class="hidden text-xs font-bold mt-2 p-2.5 rounded-xl"></div>
            </div>

            <!-- Active Applied Coupon (if any) -->
            <div id="modalAppliedCouponBox" class="hidden p-4 rounded-2xl bg-emerald-50 border border-emerald-200 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center text-xs font-black">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-mono font-black text-xs text-emerald-900" id="modalAppliedCodeText"></span>
                            <span class="text-[9px] font-black uppercase text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-full">Applied</span>
                        </div>
                        <span class="text-xs text-emerald-700 font-bold block mt-0.5" id="modalAppliedSavingsText"></span>
                    </div>
                </div>
                <button type="button" onclick="removeAppliedCoupon(); syncModalCouponState();" class="text-xs font-black text-rose-600 hover:text-rose-800 underline cursor-pointer">
                    Remove
                </button>
            </div>

            <!-- Available Coupons List -->
            <div>
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-black text-slate-700 uppercase tracking-wider">Available Lab Offers</span>
                    <span class="text-[11px] font-semibold text-teal-700">Click Apply to use</span>
                </div>
                <div class="space-y-3">
                    @if(isset($myCoupons) && $myCoupons->count() > 0)
                        @foreach($myCoupons as $pc)
                            @if($pc->coupon && $pc->coupon->is_active)
                                <div class="p-4 rounded-2xl border-2 border-indigo-100 bg-indigo-50/40 hover:border-indigo-300 hover:bg-indigo-50/70 transition flex items-center justify-between gap-3">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2">
                                            <span class="font-mono font-black text-xs text-indigo-900 bg-white px-2.5 py-1 rounded-lg border border-indigo-200">{{ $pc->coupon->code }}</span>
                                            @if($pc->coupon->coupon_type === 'welcome')
                                                <span class="text-[9px] font-black uppercase text-purple-700 bg-purple-100 px-2 py-0.5 rounded-full">🎁 1st Order Gift</span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-slate-800 font-black">
                                            {{ $pc->coupon->discount_type === 'percentage' ? $pc->coupon->discount_value . '% OFF' : '₹' . number_format($pc->coupon->discount_value) . ' Flat OFF' }}
                                        </p>
                                        <p class="text-[11px] text-slate-500 font-medium">
                                            {{ $pc->coupon->description ?? ($pc->coupon->min_order_amount > 0 ? 'Applicable on orders above ₹' . number_format($pc->coupon->min_order_amount) : 'Valid on all diagnostic tests') }}
                                        </p>
                                    </div>
                                    <button type="button" onclick="applyQuickCoupon('{{ $pc->coupon->code }}'); setTimeout(() => { syncModalCouponState(); closeCouponsModal(); }, 300);" 
                                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-black rounded-xl transition shadow-xs flex-shrink-0 cursor-pointer">
                                        Apply
                                    </button>
                                </div>
                            @endif
                        @endforeach
                    @endif

                    @if(isset($bannerCoupons) && $bannerCoupons->count() > 0)
                        @foreach($bannerCoupons as $bc)
                            <div class="p-4 rounded-2xl border-2 border-amber-100 bg-amber-50/40 hover:border-amber-300 hover:bg-amber-50/70 transition flex items-center justify-between gap-3">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2">
                                        <span class="font-mono font-black text-xs text-amber-900 bg-white px-2.5 py-1 rounded-lg border border-amber-200">{{ $bc->code }}</span>
                                        <span class="text-[9px] font-black uppercase text-amber-800 bg-amber-100 px-2 py-0.5 rounded-full">✨ Special Offer</span>
                                    </div>
                                    <p class="text-xs text-slate-800 font-black">
                                        {{ $bc->discount_type === 'percentage' ? $bc->discount_value . '% OFF' : '₹' . number_format($bc->discount_value) . ' Flat OFF' }}
                                    </p>
                                    <p class="text-[11px] text-slate-500 font-medium">
                                        {{ $bc->description ?? ($bc->min_order_amount > 0 ? 'Min order amount: ₹' . number_format($bc->min_order_amount) : 'Valid across full cart') }}
                                    </p>
                                </div>
                                <button type="button" onclick="applyQuickCoupon('{{ $bc->code }}'); setTimeout(() => { syncModalCouponState(); closeCouponsModal(); }, 300);" 
                                    class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-slate-950 text-xs font-black rounded-xl transition shadow-xs flex-shrink-0 cursor-pointer">
                                    Apply
                                </button>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

    <script id="checkout-patient-data" type="application/json">
        {!! json_encode([
            'patientId' => (string)($patient->id ?? session('patient_id', '')),
            'patientVip' => $patientVipData ?? null,
            'allVipPlans' => $allVipPlansData ?? [],
            'featuredPlan' => isset($featuredPlan) && $featuredPlan ? [
                'id' => $featuredPlan->id,
                'name' => $featuredPlan->name,
                'formatted_duration' => $featuredPlan->formatted_duration,
                'price' => (float) $featuredPlan->price,
                'discount_percentage' => (int) $featuredPlan->discount_percentage,
                'is_popular' => (bool) $featuredPlan->is_popular,
            ] : null,
            'activeMemberId' => null,
            'activeAddressId' => isset($defaultAddress) ? $defaultAddress?->id : null,
            'initialStep' => (int) request('step', 1),
            'rewardSettings' => $rewardSettings ?? [
                'enabled' => false,
                'patient_coins' => 0,
                'coin_value' => 1,
                'earn_type' => 'percentage',
                'earn_value' => 5,
                'min_order_to_earn' => 100,
                'max_redeem_type' => 'percentage',
                'max_redeem_value' => 20,
                'min_order_to_redeem' => 200,
                'min_coins_to_redeem' => 10,
            ],
            'serverCart' => $patient->cart ?? []
        ], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) !!}
    </script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    // --- Cart & Coupon Data (keyed by patient ID) ---
    const checkoutPatientMeta = JSON.parse(document.getElementById('checkout-patient-data').textContent);
    const checkoutPatientId = checkoutPatientMeta.patientId;
    const checkoutCartKey = 'cart_' + checkoutPatientId;
    const serverCheckoutCart = Array.isArray(checkoutPatientMeta.serverCart) ? checkoutPatientMeta.serverCart : [];
    let currentAppliedCoupon = null;

    function getCheckoutCart() {
        try {
            let stored = JSON.parse(localStorage.getItem(checkoutCartKey));
            if (Array.isArray(stored) && stored.length > 0) {
                return stored;
            }
            if (serverCheckoutCart.length > 0) {
                localStorage.setItem(checkoutCartKey, JSON.stringify(serverCheckoutCart));
                return serverCheckoutCart;
            }
            return Array.isArray(stored) ? stored : [];
        } catch(e) {
            return serverCheckoutCart || [];
        }
    }

    function removeFromCart(index) {
        let cart = getCheckoutCart();
        cart.splice(index, 1);
        localStorage.setItem(checkoutCartKey, JSON.stringify(cart));
        fetch('{{ route("patient.cart.sync") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ cart: cart })
        });
        renderCheckoutCart();
        updateCartBadge();
    }

    function updateCartBadge() {
        let cart = getCheckoutCart();
        let countEl = document.getElementById('cartCount');
        if (countEl) {
            countEl.innerText = cart.length;
            if (cart.length > 0) {
                countEl.classList.remove('hidden');
            } else {
                countEl.classList.add('hidden');
            }
        }
    }

    function showCouponMessage(msg, type) {
        let el = document.getElementById('couponStatusMessage');
        if (!el) return;
        el.className = 'text-[11px] font-bold mt-2 p-2.5 rounded-lg ' + 
            (type === 'success' ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : 
            (type === 'error' ? 'bg-rose-100 text-rose-800 border border-rose-200' : 'bg-gray-100 text-gray-700'));
        el.innerText = msg;
        el.classList.remove('hidden');
    }

    function applyCouponManual() {
        let code = document.getElementById('checkoutCouponInput').value.trim();
        if (!code) {
            showCouponMessage('Please enter a coupon code.', 'error');
            return;
        }
        applyCoupon(code);
    }

    function applyQuickCoupon(code) {
        document.getElementById('checkoutCouponInput').value = code;
        applyCoupon(code);
    }

    function applyCoupon(code) {
        let cart = getCheckoutCart();
        let subtotal = cart.reduce((acc, item) => acc + (parseFloat(item.price) || 0), 0);
        if (subtotal <= 0) {
            showCouponMessage('Please add tests or packages to your cart before applying a coupon.', 'error');
            return;
        }

        let btn = document.getElementById('applyCouponBtn');
        if (btn) btn.innerText = 'Checking...';

        fetch("{{ route('patient.apply_coupon') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                code: code,
                cart_total: subtotal
            })
        })
        .then(r => r.json())
        .then(data => {
            if (btn) btn.innerText = 'Apply';
            if (data.success) {
                currentAppliedCoupon = {
                    code: data.coupon_code,
                    title: data.coupon_title,
                    discount: parseFloat(data.discount_amount),
                    type: data.discount_type,
                    value: parseFloat(data.discount_value)
                };
                showCouponMessage(data.message, 'success');
                document.getElementById('couponInputContainer').classList.add('hidden');
                document.getElementById('appliedCouponDisplay').classList.remove('hidden');
                document.getElementById('appliedCouponCodeText').innerText = data.coupon_code;
                document.getElementById('appliedCouponSavingsText').innerText = 'You save ₹' + Number(data.discount_amount).toFixed(2);
                renderCheckoutCart();
                syncModalCouponState();
            } else {
                showCouponMessage(data.message, 'error');
            }
        })
        .catch(() => {
            if (btn) btn.innerText = 'Apply';
            showCouponMessage('Could not verify coupon. Please try again.', 'error');
        });
    }

    function removeAppliedCoupon() {
        currentAppliedCoupon = null;
        document.getElementById('couponInputContainer').classList.remove('hidden');
        document.getElementById('appliedCouponDisplay').classList.add('hidden');
        document.getElementById('checkoutCouponInput').value = '';
        showCouponMessage('Coupon removed.', 'info');
        renderCheckoutCart();
        syncModalCouponState();
    }

    // --- Coupons & Offers Modal Functions ---
    function openCouponsModal() {
        let modal = document.getElementById('couponsModal');
        if (!modal) return;
        modal.classList.remove('hidden');
        syncModalCouponState();
    }
    window.openCouponsModal = openCouponsModal;

    function closeCouponsModal() {
        let modal = document.getElementById('couponsModal');
        if (modal) modal.classList.add('hidden');
    }
    window.closeCouponsModal = closeCouponsModal;

    function syncModalCouponState() {
        let appliedBox = document.getElementById('modalAppliedCouponBox');
        let codeText = document.getElementById('modalAppliedCodeText');
        let savingsText = document.getElementById('modalAppliedSavingsText');
        let step4Text = document.getElementById('step4CouponSummaryText');

        if (currentAppliedCoupon) {
            if (appliedBox) appliedBox.classList.remove('hidden');
            if (codeText) codeText.innerText = currentAppliedCoupon.code;
            if (savingsText) savingsText.innerText = 'You save ₹' + Number(currentAppliedCoupon.discount).toFixed(2);
            if (step4Text) step4Text.innerText = `Coupon active: ${currentAppliedCoupon.code} (Saving ₹${Number(currentAppliedCoupon.discount).toFixed(0)})`;
        } else {
            if (appliedBox) appliedBox.classList.add('hidden');
            if (step4Text) step4Text.innerText = 'Click to browse promo codes & instant discounts';
        }
    }
    window.syncModalCouponState = syncModalCouponState;

    function applyModalCouponManual() {
        let input = document.getElementById('modalCouponInput');
        let code = input ? input.value.trim() : '';
        let msgEl = document.getElementById('modalCouponStatusMessage');
        if (!code) {
            if (msgEl) {
                msgEl.className = 'text-xs font-bold mt-2 p-2.5 rounded-xl bg-rose-100 text-rose-800 border border-rose-200';
                msgEl.innerText = 'Please enter a coupon code.';
                msgEl.classList.remove('hidden');
            }
            return;
        }
        applyCoupon(code);
        setTimeout(() => {
            syncModalCouponState();
            let mainMsg = document.getElementById('couponStatusMessage');
            if (currentAppliedCoupon) {
                if (msgEl) msgEl.classList.add('hidden');
                if (input) input.value = '';
                closeCouponsModal();
            } else if (msgEl && mainMsg) {
                msgEl.className = mainMsg.className;
                msgEl.innerText = mainMsg.innerText;
                msgEl.classList.remove('hidden');
            }
        }, 500);
    }
    window.applyModalCouponManual = applyModalCouponManual;

    // --- Booking Summary Accordion Functions ---
    function toggleBookingSummaryAccordion() {
        let content = document.getElementById('bookingSummaryContent');
        let chevron = document.getElementById('bookingSummaryChevron');
        if (!content) return;
        if (content.classList.contains('hidden')) {
            content.classList.remove('hidden');
            if (chevron) chevron.classList.add('rotate-180');
            renderBookingSummaryDetails();
        } else {
            content.classList.add('hidden');
            if (chevron) chevron.classList.remove('rotate-180');
        }
    }
    window.toggleBookingSummaryAccordion = toggleBookingSummaryAccordion;

    function renderBookingSummaryDetails() {
        let cart = getCheckoutCart();
        let countBadge = document.getElementById('bookingSummaryItemCount');
        if (countBadge) countBadge.innerText = cart.length + ' Item' + (cart.length === 1 ? '' : 's');

        // Patient / Beneficiary
        let patientEl = document.getElementById('summaryPatientName');
        if (patientEl) {
            if (window.selectedMemberId) {
                let activeMemberCard = document.querySelector(`.member-card[onclick*="${window.selectedMemberId}"]`);
                let memName = activeMemberCard ? activeMemberCard.querySelector('h3')?.innerText : 'Family Member';
                patientEl.innerText = memName || 'Family Member';
            } else {
                patientEl.innerText = "{{ $patient->name ?? 'Self' }} (Primary Patient)";
            }
        }

        // Collection Address
        let addrEl = document.getElementById('summaryAddressFull');
        let displayAddr = document.getElementById('displayAddressText');
        if (addrEl && displayAddr) {
            addrEl.innerText = displayAddr.innerText;
        }

        // Appointment Slot
        let slotDateEl = document.getElementById('summarySlotDateText');
        let slotTimeEl = document.getElementById('summarySlotTimeText');
        let activeDateEl = document.querySelector('.date-item.active-date');
        let activeSlotEl = document.querySelector('.slot-item.active-slot');
        if (slotDateEl && activeDateEl) {
            let ymd = activeDateEl.getAttribute('data-date');
            if (ymd) {
                let parts = ymd.split('-');
                if (parts.length === 3) {
                    let dObj = new Date(parseInt(parts[0]), parseInt(parts[1]) - 1, parseInt(parts[2]));
                    slotDateEl.innerText = dObj.toLocaleDateString('en-US', { weekday: 'short', day: 'numeric', month: 'short' });
                }
            }
        }
        if (slotTimeEl && activeSlotEl) {
            slotTimeEl.innerText = activeSlotEl.innerText.trim();
        }

        // Booked Tests & Packages
        let listEl = document.getElementById('bookingSummaryItemsList');
        if (listEl) {
            if (cart.length === 0) {
                listEl.innerHTML = '<p class="text-xs text-slate-400">Your cart is empty.</p>';
            } else {
                listEl.innerHTML = cart.map(item => `
                    <div class="bg-white p-3 rounded-xl border border-slate-200/80 flex items-center justify-between text-xs">
                        <div class="flex items-center gap-2 min-w-0">
                            <span class="w-6 h-6 rounded-lg bg-teal-100/70 text-teal-800 flex items-center justify-center text-[10px] font-bold flex-shrink-0">
                                <i class="fas fa-flask"></i>
                            </span>
                            <div class="truncate">
                                <span class="font-bold text-slate-800">${item.name || item.title}</span>
                                <span class="text-[9px] font-bold text-slate-400 uppercase ml-1 px-1.5 py-0.5 bg-slate-100 rounded">${item.type || 'test'}</span>
                            </div>
                        </div>
                        <span class="font-black text-slate-900 ml-2 whitespace-nowrap">₹${Number(item.price).toLocaleString('en-IN')}</span>
                    </div>
                `).join('');
            }
        }
    }
    window.renderBookingSummaryDetails = renderBookingSummaryDetails;

    function addSuggestedToCart(name, price, mrp, params, btn) {
        let cart = getCheckoutCart();
        let alreadyExists = cart.some(item => item.name === name);
        if (alreadyExists) return;

        cart.push({ name, price, mrp, params });
        localStorage.setItem(checkoutCartKey, JSON.stringify(cart));

        fetch('{{ route("patient.cart.sync") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ cart: cart })
        });

        renderCheckoutCart();
        updateCartBadge();
    }
    window.addSuggestedToCart = addSuggestedToCart;

    function syncSuggestedButtons() {
        let cart = getCheckoutCart();
        document.querySelectorAll('#suggestedTestsGrid .suggested-test-card').forEach(card => {
            let testName = card.getAttribute('data-test-name');
            let btn = card.querySelector('.suggest-add-btn');
            if (!btn) return;
            let inCart = cart.some(item => item.name === testName);
            if (inCart) {
                btn.innerHTML = '<i class="fas fa-check text-[10px]"></i> <span>Added</span>';
                btn.className = 'suggest-add-btn px-3.5 py-1.5 rounded-xl bg-emerald-600 text-white text-xs font-black border border-emerald-600 transition-all flex items-center gap-1 shadow-sm cursor-default';
                btn.disabled = true;
            } else {
                btn.innerHTML = '<i class="fas fa-plus text-[10px]"></i> <span>Add</span>';
                btn.className = 'suggest-add-btn px-3.5 py-1.5 rounded-xl bg-teal-50 hover:bg-teal-700 text-teal-800 hover:text-white text-xs font-black border border-teal-200/80 hover:border-teal-700 transition-all duration-200 flex items-center gap-1 shadow-sm';
                btn.disabled = false;
            }
        });
    }

    const existingPatientVip = @json($patientVipData);
    const allVipPlans = @json($allVipPlansData);
    const availableFeaturedVipPlan = (allVipPlans && allVipPlans.length > 0) 
        ? (allVipPlans.find(p => p.is_popular) || allVipPlans[0]) 
        : null;
    let selectedVipPlan = null;

    const rewardConfig = @json($rewardSettings ?? []);
    window.coinsToRedeem = 0;
    window.isRedeemingCoins = false;

    function toggleCoinRedemption(checked) {
        window.isRedeemingCoins = checked;
        if (!checked) {
            window.coinsToRedeem = 0;
        }
        renderCheckoutCart();
    }
    window.toggleCoinRedemption = toggleCoinRedemption;

    function onCoinInputChange(val) {
        let parsed = parseInt(val) || 0;
        window.coinsToRedeem = Math.max(0, parsed);
        window.isRedeemingCoins = (window.coinsToRedeem > 0);
        renderCheckoutCart();
    }
    window.onCoinInputChange = onCoinInputChange;

    function applyMaxCoins() {
        const badge = document.getElementById('maxCoinsAllowedBadge');
        const maxVal = badge ? (parseInt(badge.innerText) || 0) : 0;
        window.coinsToRedeem = maxVal;
        window.isRedeemingCoins = (maxVal > 0);
        const cb = document.getElementById('redeemCoinsCheckbox');
        if (cb) cb.checked = (maxVal > 0);
        const input = document.getElementById('coinsToRedeemInput');
        if (input) input.value = maxVal;
        renderCheckoutCart();
    }
    window.applyMaxCoins = applyMaxCoins;

    function toggleVipUpsell(checkbox) {
        if (checkbox.checked) {
            selectedVipPlan = availableFeaturedVipPlan;
        } else {
            selectedVipPlan = null;
        }
        syncVipSelectionUI();
        renderCheckoutCart();
    }
    window.toggleVipUpsell = toggleVipUpsell;

    function selectVipPlanCard(planId, price, discountPct, planName, duration, cardEl) {
        if (selectedVipPlan && selectedVipPlan.id === planId) {
            selectedVipPlan = null;
        } else {
            selectedVipPlan = allVipPlans.find(p => p.id === planId) || {
                id: planId,
                price: price,
                discount_percentage: discountPct,
                name: planName,
                formatted_duration: duration
            };
        }
        syncVipSelectionUI();
        renderCheckoutCart();
    }
    window.selectVipPlanCard = selectVipPlanCard;

    function syncVipSelectionUI() {
        const upsellCb = document.getElementById('vipUpsellCheckbox');
        if (upsellCb) {
            upsellCb.checked = (selectedVipPlan !== null);
        }

        document.querySelectorAll('.vip-plan-card').forEach(card => {
            const pId = parseInt(card.getAttribute('data-vip-plan-id'));
            const indicator = card.querySelector('.vip-check-indicator');
            if (selectedVipPlan && selectedVipPlan.id === pId) {
                card.classList.add('border-amber-500', 'bg-amber-50/40', 'ring-2', 'ring-amber-400');
                card.classList.remove('border-slate-200');
                if (indicator) {
                    indicator.classList.add('bg-amber-500', 'text-white', 'border-amber-500');
                    indicator.classList.remove('text-transparent', 'border-slate-300', 'bg-white');
                }
            } else {
                card.classList.remove('border-amber-500', 'bg-amber-50/40', 'ring-2', 'ring-amber-400');
                if (!card.hasAttribute('data-is-popular')) {
                    card.classList.add('border-slate-200');
                }
                if (indicator) {
                    indicator.classList.remove('bg-amber-500', 'text-white', 'border-amber-500');
                    indicator.classList.add('text-transparent', 'border-slate-300', 'bg-white');
                }
            }
        });
    }

    function renderCheckoutCart() {
        let cart = getCheckoutCart();
        let container = document.getElementById('checkoutCartItems');
        let emptyMsg = document.getElementById('emptyCartMsg');
        let totalAmount = 0;
        let totalMrp = 0;

        if (cart.length === 0) {
            container.innerHTML = '';
            emptyMsg.classList.remove('hidden');
            syncSuggestedButtons();
            return;
        }

        emptyMsg.classList.add('hidden');
        container.innerHTML = cart.map((item, i) => {
            let price = parseInt(item.price) || 0;
            let mrp = parseInt(item.mrp) || price;
            totalAmount += price;
            totalMrp += mrp;
            let discountPct = mrp > price ? Math.round(((mrp - price) / mrp) * 100) : 0;

            return `
                <div class="bg-white border border-slate-200/90 rounded-2xl p-5 sm:p-6 shadow-sm hover:shadow-md transition-all mb-4 relative group">
                    <!-- Remove button -->
                    <button type="button" onclick="removeFromCart(${i})" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-slate-50 hover:bg-rose-50 text-slate-400 hover:text-rose-600 flex items-center justify-center transition-all" title="Remove from cart">
                        <i class="far fa-trash-alt text-xs"></i>
                    </button>
                    
                    <!-- Header & Title -->
                    <div class="pr-10 mb-3">
                        <div class="flex items-center gap-2 mb-1.5">
                            <span class="px-2 py-0.5 rounded-md bg-teal-50 text-teal-800 text-[10px] font-black uppercase tracking-wider border border-teal-100">
                                ${item.params && (item.params.includes('Parameter') || item.params.includes('Test')) ? item.params : 'Diagnostic Test'}
                            </span>
                            <span class="text-[10px] font-bold text-emerald-600 flex items-center gap-1">
                                <i class="fas fa-shield-check text-[9px]"></i> Certified Lab
                            </span>
                        </div>
                        <h3 class="text-slate-900 font-black text-base sm:text-lg leading-snug group-hover:text-teal-800 transition-colors">
                            ${item.name}
                        </h3>
                    </div>

                    <!-- Clinical Highlights Pills -->
                    <div class="flex flex-wrap items-center gap-2 text-xs font-semibold text-slate-500 mb-4 pb-3 border-b border-slate-100">
                        <span class="inline-flex items-center gap-1 text-[11px] bg-slate-50 px-2.5 py-1 rounded-lg border border-slate-100 text-slate-600">
                            <i class="fas fa-house-medical text-teal-600"></i> Free Home Sample Pickup
                        </span>
                        <span class="inline-flex items-center gap-1 text-[11px] bg-slate-50 px-2.5 py-1 rounded-lg border border-slate-100 text-slate-600">
                            <i class="fas fa-bolt text-amber-500"></i> Reports in 10-12h
                        </span>
                        <span class="inline-flex items-center gap-1 text-[11px] bg-slate-50 px-2.5 py-1 rounded-lg border border-slate-100 text-slate-600 hidden sm:inline-flex">
                            <i class="fas fa-user-doctor text-cyan-600"></i> Free Doctor Consult
                        </span>
                    </div>

                    <!-- Pricing & Action Row -->
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-1.5 text-xs font-bold text-teal-800">
                            <i class="fas fa-check-circle text-teal-600 text-xs"></i>
                            <span>Cold Chain Sealed Sample Handling</span>
                        </div>
                        <div class="flex items-baseline gap-2">
                            ${mrp > price ? `
                                <span class="text-xs font-bold text-slate-400 line-through">₹${mrp.toLocaleString('en-IN')}</span>
                                <span class="text-[10px] font-black text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200/60">${discountPct}% OFF</span>
                            ` : ''}
                            <span class="text-xl font-black text-slate-900">₹${price.toLocaleString('en-IN')}</span>
                        </div>
                    </div>
                </div>`;
        }).join('');

        let subtotal = totalAmount;
        let itemNames = cart.map(i => i.name || i.title).join(', ');
        document.querySelectorAll('.member-cart-summary').forEach(el => {
            el.innerText = itemNames || 'All tests in cart';
        });

        // 1. VIP Calculations
        let vipDiscount = 0;
        let vipPlanPrice = 0;
        let activeVipRate = 0;

        if (existingPatientVip) {
            activeVipRate = existingPatientVip.discount_percentage;
            vipDiscount = Math.round((subtotal * activeVipRate) / 100);

            document.querySelectorAll('.vip-plan-row').forEach(r => r.classList.add('hidden'));
            document.querySelectorAll('.vip-discount-row').forEach(r => {
                r.classList.remove('hidden');
                let discEl = r.querySelector('[data-bill-vip-discount]');
                if (discEl) discEl.innerText = '₹' + vipDiscount.toLocaleString('en-IN');
                let badge = r.querySelector('.vip-discount-percent-badge');
                if (badge) badge.innerText = activeVipRate + '% OFF';
            });
        } else if (selectedVipPlan) {
            activeVipRate = selectedVipPlan.discount_percentage;
            vipPlanPrice = parseFloat(selectedVipPlan.price) || 0;
            vipDiscount = Math.round((subtotal * activeVipRate) / 100);

            document.querySelectorAll('.vip-plan-row').forEach(r => {
                r.classList.remove('hidden');
                let priceEl = r.querySelector('[data-bill-vip-price]');
                if (priceEl) priceEl.innerText = '₹' + vipPlanPrice.toLocaleString('en-IN');
                let durBadge = r.querySelector('.vip-plan-duration-badge');
                if (durBadge) durBadge.innerText = selectedVipPlan.formatted_duration;
                let nameBadge = r.querySelector('.vip-plan-name-badge');
                if (nameBadge) nameBadge.innerText = selectedVipPlan.name;
            });

            document.querySelectorAll('.vip-discount-row').forEach(r => {
                r.classList.remove('hidden');
                let discEl = r.querySelector('[data-bill-vip-discount]');
                if (discEl) discEl.innerText = '₹' + vipDiscount.toLocaleString('en-IN');
                let badge = r.querySelector('.vip-discount-percent-badge');
                if (badge) badge.innerText = activeVipRate + '% OFF';
            });
        } else {
            document.querySelectorAll('.vip-plan-row').forEach(r => r.classList.add('hidden'));
            document.querySelectorAll('.vip-discount-row').forEach(r => r.classList.add('hidden'));
        }

        // Update instant savings text on upsell card
        if (!existingPatientVip && availableFeaturedVipPlan) {
            let potentialSavings = Math.round((subtotal * availableFeaturedVipPlan.discount_percentage) / 100);
            let savTextEl = document.getElementById('vipInstantSavingsText');
            if (savTextEl) {
                savTextEl.innerText = 'Save ₹' + potentialSavings.toLocaleString('en-IN') + ' immediately on today\'s tests!';
            }
        }

        let subtotalAfterVip = Math.max(0, subtotal - vipDiscount);

        // 2. Coupon Calculations (applies to subtotalAfterVip)
        let discount = 0;
        if (currentAppliedCoupon) {
            if (currentAppliedCoupon.type === 'percentage') {
                discount = (subtotalAfterVip * currentAppliedCoupon.value) / 100;
            } else {
                discount = Math.min(subtotalAfterVip, currentAppliedCoupon.value);
            }
            discount = Math.round(discount * 100) / 100;
            currentAppliedCoupon.discount = discount;
        }

        let subtotalAfterCoupon = Math.max(0, subtotalAfterVip - discount);

        // 3. Health Coins Loyalty Calculations
        let coinsDiscount = 0;
        let maxCoinsAllowed = 0;

        const rewardCoinsSection = document.getElementById('rewardCoinsSection');
        if (rewardConfig && rewardConfig.enabled && rewardCoinsSection) {
            const pCoins = rewardConfig.patient_coins || 0;
            const minCoins = rewardConfig.min_coins_to_redeem || 0;
            const minOrder = rewardConfig.min_order_to_redeem || 0;
            const coinVal = rewardConfig.coin_value || 1.0;

            const meetsRequirements = (pCoins >= minCoins) && (subtotalAfterVip >= minOrder);

            const coinEligibleNotice = document.getElementById('coinEligibleNotice');
            const coinIneligibleNotice = document.getElementById('coinIneligibleNotice');
            const coinInputWrap = document.getElementById('coinInputWrapper');
            const redeemCheckbox = document.getElementById('redeemCoinsCheckbox');
            const coinInput = document.getElementById('coinsToRedeemInput');
            const maxAllowedBadge = document.getElementById('maxCoinsAllowedBadge');

            if (meetsRequirements) {
                if (rewardConfig.max_redeem_type === 'percentage') {
                    const maxDisc = (subtotalAfterCoupon * rewardConfig.max_redeem_value) / 100;
                    maxCoinsAllowed = Math.floor(maxDisc / coinVal);
                } else {
                    maxCoinsAllowed = Math.floor(rewardConfig.max_redeem_value);
                }

                maxCoinsAllowed = Math.min(pCoins, maxCoinsAllowed, Math.floor(subtotalAfterCoupon / coinVal));
                maxCoinsAllowed = Math.max(0, maxCoinsAllowed);

                if (coinEligibleNotice) coinEligibleNotice.classList.remove('hidden');
                if (coinIneligibleNotice) coinIneligibleNotice.classList.add('hidden');
                if (maxAllowedBadge) maxAllowedBadge.innerText = maxCoinsAllowed;

                if (window.isRedeemingCoins && maxCoinsAllowed > 0) {
                    if (!window.coinsToRedeem || window.coinsToRedeem <= 0) {
                        window.coinsToRedeem = maxCoinsAllowed;
                    }
                    window.coinsToRedeem = Math.min(window.coinsToRedeem, maxCoinsAllowed);
                    coinsDiscount = Math.round(window.coinsToRedeem * coinVal * 100) / 100;

                    if (redeemCheckbox) redeemCheckbox.checked = true;
                    if (coinInputWrap) coinInputWrap.classList.remove('hidden');
                    if (coinInput) coinInput.value = window.coinsToRedeem;
                } else {
                    window.coinsToRedeem = 0;
                    coinsDiscount = 0;
                    if (redeemCheckbox) redeemCheckbox.checked = false;
                    if (coinInputWrap) coinInputWrap.classList.add('hidden');
                }
            } else {
                window.coinsToRedeem = 0;
                window.isRedeemingCoins = false;
                coinsDiscount = 0;
                if (coinEligibleNotice) coinEligibleNotice.classList.add('hidden');
                if (coinIneligibleNotice) {
                    coinIneligibleNotice.classList.remove('hidden');
                    let lockText = '';
                    if (pCoins < minCoins) {
                        lockText = `Hold at least ${minCoins} Coins to redeem (You have ${pCoins}).`;
                    } else if (subtotalAfterVip < minOrder) {
                        lockText = `Cart value must be ≥ ₹${minOrder.toLocaleString('en-IN')} to redeem coins.`;
                    }
                    const textSpan = coinIneligibleNotice.querySelector('span');
                    if (textSpan) textSpan.innerText = lockText;
                }
                if (coinInputWrap) coinInputWrap.classList.add('hidden');
                if (redeemCheckbox) redeemCheckbox.checked = false;
            }
        }

        let payable = Math.max(0, subtotalAfterCoupon - coinsDiscount + vipPlanPrice);

        // Calculate coins earned on this order
        let coinsToEarn = 0;
        if (rewardConfig && rewardConfig.enabled && payable >= rewardConfig.min_order_to_earn) {
            if (rewardConfig.earn_type === 'percentage') {
                coinsToEarn = Math.round((payable * rewardConfig.earn_value) / 100);
            } else {
                coinsToEarn = Math.round(rewardConfig.earn_value);
            }
        }

        const coinEarnBadge = document.getElementById('coinsToEarnValue');
        if (coinEarnBadge) coinEarnBadge.innerText = coinsToEarn;
        const coinEarnPreview = document.getElementById('coinEarnPreview');
        if (coinEarnPreview) {
            if (coinsToEarn > 0) {
                coinEarnPreview.classList.remove('hidden');
            } else {
                coinEarnPreview.classList.add('hidden');
            }
        }

        // Update bill summary blocks
        document.querySelectorAll('[data-bill-subtotal]').forEach(el => el.innerText = '₹' + subtotal.toLocaleString('en-IN'));
        document.querySelectorAll('[data-bill-mrp]').forEach(el => el.innerText = '₹' + totalMrp.toLocaleString('en-IN'));
        document.querySelectorAll('[data-bill-amount]').forEach(el => el.innerText = '₹' + payable.toLocaleString('en-IN'));

        let labDiscount = Math.max(0, totalMrp - subtotal);
        document.querySelectorAll('[data-bill-mrp-savings]').forEach(el => el.innerText = '-₹' + labDiscount.toLocaleString('en-IN'));

        let totalOverallSavings = labDiscount + discount + vipDiscount + coinsDiscount + 150 + 299;
        document.querySelectorAll('#totalSavingsValueText').forEach(el => el.innerText = '₹' + totalOverallSavings.toLocaleString('en-IN'));

        // Update discount rows
        document.querySelectorAll('.coupon-discount-row').forEach(row => {
            if (discount > 0 && currentAppliedCoupon) {
                row.classList.remove('hidden');
                let discVal = row.querySelector('[data-bill-discount]');
                if (discVal) discVal.innerText = '-₹' + discount.toFixed(2);
                let badge = row.querySelector('.coupon-code-badge');
                if (badge) badge.innerText = currentAppliedCoupon.code;
            } else {
                row.classList.add('hidden');
            }
        });

        // Update coins discount row
        document.querySelectorAll('.coins-discount-row').forEach(row => {
            if (coinsDiscount > 0) {
                row.classList.remove('hidden');
                let discVal = row.querySelector('[data-bill-coins-discount]');
                if (discVal) discVal.innerText = '-₹' + coinsDiscount.toFixed(2);
                let countBadge = row.querySelector('.coins-redeemed-count-badge');
                if (countBadge) countBadge.innerText = window.coinsToRedeem;
            } else {
                row.classList.add('hidden');
            }
        });

        syncSuggestedButtons();
    }

    document.addEventListener('DOMContentLoaded', () => {
        renderCheckoutCart();
    });

    function payOnCollection() {
        let cart = getCheckoutCart();
        if (cart.length === 0) {
            alert('Your cart is empty!');
            return;
        }

        // Validate Patient Full Name
        if (!window.selectedMemberId) {
            let nameVal = (window.currentPatientName || '').trim();
            let inputVal = document.getElementById('checkoutPatientNameInput')?.value?.trim() || '';
            if ((!nameVal || nameVal.toLowerCase() === 'self') && (!inputVal || inputVal.toLowerCase() === 'self')) {
                alert('Patient Full Name is required to place your booking.');
                goToStep(2);
                document.getElementById('checkoutPatientNameInput')?.focus();
                return;
            }
        }

        // Validate Address
        if (!window.selectedAddressId) {
            alert('Sample collection address is required to place your booking. Please add an address.');
            goToStep(3);
            if (typeof window.openAddAddressModal === 'function') {
                window.openAddAddressModal();
            }
            return;
        }

        // Get selected date
        let activeDateEl = document.querySelector('.date-item.active-date');
        let selectedDateYmd = activeDateEl ? (activeDateEl.getAttribute('data-date') || new Date().toISOString().slice(0, 10)) : new Date().toISOString().slice(0, 10);

        // Get selected slot
        let activeSlotEl = document.querySelector('.slot-item.active-slot');
        let selectedSlot = activeSlotEl ? activeSlotEl.innerText.trim() : '07:00 AM - 08:00 AM';

        // Parse slot start time for full datetime
        let slotStart = selectedSlot.split('-')[0].trim();
        let bookingDate = selectedDateYmd + ' ' + (slotStart || '08:00 AM');

        let btn = document.querySelector('#btnPay button') || event.target;
        btn.disabled = true;
        btn.innerText = 'Booking...';

        fetch("{{ route('patient.place_booking') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                cart: cart,
                payment_method: 'Cash',
                collection_type: 'Home Collection',
                booking_date: bookingDate,
                collection_slot: selectedSlot,
                address_id: window.selectedAddressId || null,
                family_member_id: window.selectedMemberId || null,
                coupon_code: currentAppliedCoupon ? currentAppliedCoupon.code : null,
                discount_amount: currentAppliedCoupon ? currentAppliedCoupon.discount : 0,
                membership_plan_id: selectedVipPlan ? selectedVipPlan.id : null,
                coins_to_redeem: window.coinsToRedeem || 0,
            })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                // Clear cart from localStorage
                localStorage.removeItem(checkoutCartKey);
                localStorage.removeItem('cart_guest');
                // Redirect to bookings
                window.location.href = "{{ route('patient.bookings') }}";
            } else {
                alert('Booking failed: ' + (data.message || 'Unknown error'));
                btn.disabled = false;
                btn.innerText = 'Pay On Collection';
            }
        })
        .catch(() => {
            alert('Network error. Please try again.');
            btn.disabled = false;
            btn.innerText = 'Pay On Collection';
        });
    }

    function payOnlineRazorpay() {
        let cart = getCheckoutCart();
        if (cart.length === 0) {
            alert('Your cart is empty!');
            return;
        }

        // Validate Patient Full Name
        if (!window.selectedMemberId) {
            let nameVal = (window.currentPatientName || '').trim();
            let inputVal = document.getElementById('checkoutPatientNameInput')?.value?.trim() || '';
            if ((!nameVal || nameVal.toLowerCase() === 'self') && (!inputVal || inputVal.toLowerCase() === 'self')) {
                alert('Patient Full Name is required to place your booking.');
                goToStep(2);
                document.getElementById('checkoutPatientNameInput')?.focus();
                return;
            }
        }

        // Validate Address
        if (!window.selectedAddressId) {
            alert('Sample collection address is required to place your booking. Please add an address.');
            goToStep(3);
            if (typeof window.openAddAddressModal === 'function') {
                window.openAddAddressModal();
            }
            return;
        }

        // Get selected date
        let activeDateEl = document.querySelector('.date-item.active-date');
        let selectedDateYmd = activeDateEl ? (activeDateEl.getAttribute('data-date') || new Date().toISOString().slice(0, 10)) : new Date().toISOString().slice(0, 10);

        // Get selected slot
        let activeSlotEl = document.querySelector('.slot-item.active-slot');
        let selectedSlot = activeSlotEl ? activeSlotEl.innerText.trim() : '07:00 AM - 08:00 AM';

        // Parse slot start time for full datetime
        let slotStart = selectedSlot.split('-')[0].trim();
        let bookingDate = selectedDateYmd + ' ' + (slotStart || '08:00 AM');

        let btn = document.getElementById('btnPayOnline') || event.target;
        let originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Initializing...';

        fetch("{{ route('razorpay.order.create') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                cart: cart,
                collection_type: 'Home Collection',
                booking_date: bookingDate,
                collection_slot: selectedSlot,
                address_id: window.selectedAddressId || null,
                family_member_id: window.selectedMemberId || null,
                coupon_code: currentAppliedCoupon ? currentAppliedCoupon.code : null,
                discount_amount: currentAppliedCoupon ? currentAppliedCoupon.discount : 0,
                membership_plan_id: selectedVipPlan ? selectedVipPlan.id : null,
                coins_to_redeem: window.coinsToRedeem || 0,
            })
        })
        .then(r => r.json())
        .then(data => {
            if (!data.success) {
                alert(data.message || 'Payment initiation failed. Please try again.');
                btn.disabled = false;
                btn.innerHTML = originalText;
                return;
            }

            const options = {
                key: data.key,
                amount: data.amount,
                currency: data.currency || 'INR',
                name: data.name || 'Av Wellcare Diagnostics',
                description: data.description || 'Health Checkup Booking',
                order_id: data.order_id,
                prefill: data.prefill || {},
                theme: data.theme || { color: '#0d9488' },
                handler: function (response) {
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Verifying Payment...';
                    fetch("{{ route('razorpay.payment.verify') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            razorpay_payment_id: response.razorpay_payment_id,
                            razorpay_order_id: response.razorpay_order_id,
                            razorpay_signature: response.razorpay_signature,
                            booking_id: data.booking_id
                        })
                    })
                    .then(vr => vr.json())
                    .then(vData => {
                        if (vData.success) {
                            localStorage.removeItem(checkoutCartKey);
                            localStorage.removeItem('cart_guest');
                            window.location.href = vData.redirect_url || "{{ route('patient.bookings') }}";
                        } else {
                            alert('Payment verification error: ' + (vData.message || 'Please contact customer support.'));
                            window.location.href = "{{ route('patient.bookings') }}";
                        }
                    })
                    .catch(err => {
                        alert('Network error during verification. If money was debited, your booking will be confirmed automatically.');
                        window.location.href = "{{ route('patient.bookings') }}";
                    });
                },
                modal: {
                    ondismiss: function () {
                        btn.disabled = false;
                        btn.innerHTML = originalText;
                    }
                }
            };

            const rzp = new Razorpay(options);
            rzp.on('payment.failed', function (response) {
                alert('Payment failed: ' + (response.error.description || 'Transaction declined.'));
                btn.disabled = false;
                btn.innerHTML = originalText;
            });
            rzp.open();
        })
        .catch(err => {
            console.error(err);
            alert('Network error. Please try again.');
            btn.disabled = false;
            btn.innerHTML = originalText;
        });
    }


    @php
        $pincodeStr = \App\Models\Setting::get('serviceable_pincodes', '800001, 800002, 110001, 400001');
        $pincodeArray = array_values(array_filter(array_map('trim', preg_split('/[,\r\n]+/', $pincodeStr))));
        $defaultAddr = $patient->addresses->first();
    @endphp

    let currentStep = 1;
    const validPincodes = @json($pincodeArray);
    window.selectedAddressId = @json($defaultAddr?->id ?? null);
    window.selectedMemberId = null;
    window.currentPatientName = @json($patient->name ?? '');
    let isPincodeVerified = false;

    function saveCheckoutPatientName() {
        const input = document.getElementById('checkoutPatientNameInput');
        if (!input) return;
        const name = input.value.trim();
        if (!name || name.toLowerCase() === 'self') {
            alert('Please enter a valid full name for the diagnostic report.');
            input.focus();
            return;
        }

        const btn = document.querySelector('#patientNamePromptBox button');
        let oldHtml = '';
        if (btn) {
            oldHtml = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
        }

        fetch("{{ route('patient.update_name') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ name: name })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                window.currentPatientName = name;
                const primaryNameEl = document.getElementById('primaryPatientDisplayName');
                if (primaryNameEl) primaryNameEl.innerText = name;
                const msg = document.getElementById('checkoutNameSavedMsg');
                if (msg) {
                    msg.classList.remove('hidden');
                    setTimeout(() => msg.classList.add('hidden'), 4000);
                }
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-check"></i> Saved';
                    setTimeout(() => { if (btn) btn.innerHTML = oldHtml; }, 2000);
                }
            } else {
                alert(data.message || 'Could not update name. Please try again.');
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = oldHtml;
                }
            }
        })
        .catch(err => {
            console.error(err);
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = oldHtml;
            }
        });
    }
    window.saveCheckoutPatientName = saveCheckoutPatientName;

    function selectMember(memberId, cardEl) {
        window.selectedMemberId = memberId;
        document.querySelectorAll('#memberSelectionList .member-card').forEach(card => {
            card.classList.remove('border-2', 'border-brand-secondary');
            card.classList.add('border', 'border-gray-200');
            const ind = card.querySelector('.member-check-indicator');
            if (ind) {
                ind.classList.remove('bg-brand-dark', 'text-white');
                ind.classList.add('border', 'border-gray-300', 'text-transparent');
            }
        });

        cardEl.classList.add('border-2', 'border-brand-secondary');
        cardEl.classList.remove('border', 'border-gray-200');
        const activeInd = cardEl.querySelector('.member-check-indicator');
        if (activeInd) {
            activeInd.classList.add('bg-brand-dark', 'text-white');
            activeInd.classList.remove('border', 'border-gray-300', 'text-transparent');
        }
    }

    function goToStep(step) {
        if (step < currentStep) {
            currentStep = step;
            updateUI();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        } else if (step === currentStep + 1 && (currentStep !== 3 || isPincodeVerified)) {
            nextStep();
        }
    }
    window.goToStep = goToStep;

    function updateUI() {
        // Hide all steps
        document.querySelectorAll('.step-content').forEach(el => el.classList.add('hidden'));
        document.getElementById('step' + currentStep).classList.remove('hidden');

        // Update Stepper Elements
        document.querySelectorAll('.step-wrapper').forEach(wrapper => {
            let icon = wrapper.querySelector('.step-icon');
            let label = wrapper.querySelector('.step-label');
            let sub = wrapper.querySelector('.step-sub');
            if (!icon) return;
            let step = parseInt(icon.getAttribute('data-step'));
            let iconMap = { 1: 'fa-flask', 2: 'fa-user-plus', 3: 'fa-calendar-alt', 4: 'fa-wallet' };

            if (step < currentStep) {
                // Completed
                icon.className = 'step-icon bg-teal-800 text-white border-2 border-teal-800 rounded-2xl w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center font-extrabold shadow-sm transition-all';
                icon.innerHTML = '<i class="fas fa-check text-sm sm:text-base"></i>';
                if (label) label.className = 'step-label text-[11px] sm:text-xs font-bold text-slate-700 mt-2 text-center';
                if (sub) sub.innerText = 'Completed';
            } else if (step === currentStep) {
                // Active
                icon.className = 'step-icon bg-white text-teal-800 border-2 border-teal-800 rounded-2xl w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center font-extrabold shadow-md shadow-teal-900/10 transition-all';
                icon.innerHTML = `<i class="${step === 3 ? 'far' : 'fas'} ${iconMap[step]} text-sm sm:text-base"></i>`;
                if (label) label.className = 'step-label text-[11px] sm:text-xs font-black text-teal-800 mt-2 text-center';
                if (sub) sub.innerText = 'In Progress';
            } else {
                // Upcoming
                icon.className = 'step-icon bg-white text-slate-400 border-2 border-slate-200 rounded-2xl w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center font-extrabold shadow-sm transition-all';
                icon.innerHTML = `<i class="${step === 3 ? 'far' : 'fas'} ${iconMap[step]} text-sm sm:text-base"></i>`;
                if (label) label.className = 'step-label text-[11px] sm:text-xs font-semibold text-slate-400 mt-2 text-center';
                if (sub) sub.innerText = 'Step ' + step;
            }
        });

        // Update Progress Bar Line
        let progress = ((currentStep - 1) / 3) * 100;
        let progressEl = document.getElementById('progressFill');
        if (progressEl) progressEl.style.width = progress + '%';

        // Update Action Buttons
        let btnNext = document.getElementById('btnNext');
        let btnPay = document.getElementById('btnPay');
        if (btnNext) {
            btnNext.disabled = false;
            btnNext.classList.remove('opacity-50', 'cursor-not-allowed');
            btnNext.classList.remove('hidden');
        }
        if (btnPay) btnPay.classList.add('hidden');

        if(currentStep === 1) {
            if (btnNext) btnNext.innerHTML = '<span>Proceed to Patient Details</span> <i class="fas fa-arrow-right text-xs ml-2"></i>';
        } else if(currentStep === 2) {
            if (btnNext) btnNext.innerHTML = '<span>Proceed to Date & Slot</span> <i class="fas fa-arrow-right text-xs ml-2"></i>';
        } else if(currentStep === 3) {
            if (btnNext) {
                btnNext.innerHTML = '<span>Proceed to Review & Pay</span> <i class="fas fa-arrow-right text-xs ml-2"></i>';
                if(!isPincodeVerified) {
                    btnNext.disabled = true;
                    btnNext.classList.add('opacity-50', 'cursor-not-allowed');
                }
            }
        } else if(currentStep === 4) {
            if (btnNext) btnNext.classList.add('hidden');
            if (btnPay) btnPay.classList.remove('hidden');

            // Update appointment date & slot summary on step 4
            let activeDateEl = document.querySelector('.date-item.active-date');
            let activeSlotEl = document.querySelector('.slot-item.active-slot');
            let selectedDateYmd = activeDateEl ? activeDateEl.getAttribute('data-date') : '';
            let selectedSlotText = activeSlotEl ? activeSlotEl.innerText.trim() : '07:00 AM - 08:00 AM';

            let dateSummaryEl = document.getElementById('step4SummaryDate');
            let slotSummaryEl = document.getElementById('step4SummarySlot');
            if (dateSummaryEl && selectedDateYmd) {
                let parts = selectedDateYmd.split('-');
                if (parts.length === 3) {
                    let dObj = new Date(parseInt(parts[0]), parseInt(parts[1]) - 1, parseInt(parts[2]));
                    dateSummaryEl.innerText = dObj.toLocaleDateString('en-US', { weekday: 'short', day: 'numeric', month: 'short', year: 'numeric' });
                }
            }
            if (slotSummaryEl) {
                slotSummaryEl.innerText = selectedSlotText;
            }

            // Sync booking summary accordion & coupon modal text
            renderBookingSummaryDetails();
            syncModalCouponState();
        }
    }

    function nextStep() {
        // Step 2 Validation: Check patient name if primary patient is selected
        if (currentStep === 2) {
            if (!window.selectedMemberId) {
                let nameVal = (window.currentPatientName || '').trim();
                let inputVal = document.getElementById('checkoutPatientNameInput')?.value?.trim() || '';
                if ((!nameVal || nameVal.toLowerCase() === 'self') && (!inputVal || inputVal.toLowerCase() === 'self')) {
                    alert('Patient Full Name is required before proceeding to the next step.');
                    document.getElementById('checkoutPatientNameInput')?.focus();
                    return;
                }
                if ((!nameVal || nameVal.toLowerCase() === 'self') && inputVal && inputVal.toLowerCase() !== 'self') {
                    // Automatically persist the typed name
                    saveCheckoutPatientName();
                }
            }
        }

        // Step 3 Validation: Pincode and Address
        if (currentStep === 3) {
            if (!isPincodeVerified) {
                alert('Please verify a valid serviceable pincode first.');
                return;
            }
            if (!window.selectedAddressId) {
                alert('Sample collection address is required. Please add or select an address.');
                if (typeof window.openAddAddressModal === 'function') {
                    window.openAddAddressModal();
                }
                return;
            }
        }

        if (currentStep < 4) {
            currentStep++;
            updateUI();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }

    function verifyPincode() {
        let val = document.getElementById('pincodeInput').value.trim();
        let errorEl = document.getElementById('pincodeError');
        let successEl = document.getElementById('pincodeSuccess');
        if (validPincodes.includes(val)) {
            errorEl.classList.add('hidden');
            successEl.classList.remove('hidden');
            isPincodeVerified = true;
            document.getElementById('addressAndSlotSection').classList.remove('hidden');
            updateUI(); // Unlock next button
        } else {
            errorEl.classList.remove('hidden');
            successEl.classList.add('hidden');
            isPincodeVerified = false;
            document.getElementById('addressAndSlotSection').classList.add('hidden');
            updateUI(); // Lock next button
        }
    }
    window.verifyPincode = verifyPincode;

    function saveNewMember() {
        // Get values
        let name = document.getElementById('newMemberName').value.trim();
        let age = document.getElementById('newMemberAge').value.trim();
        let genderInput = document.querySelector('input[name="new_member_gender"]:checked');
        let relationInput = document.querySelector('input[name="new_member_relation"]:checked');
        let gender = genderInput ? genderInput.value : 'female';
        let relation = relationInput ? relationInput.value : 'other';

        if (!name || !age) {
            alert('Please enter member name and age.');
            return;
        }

        gender = gender.charAt(0).toUpperCase() + gender.slice(1);
        relation = relation.charAt(0).toUpperCase() + relation.slice(1);

        fetch("{{ route('patient.add_family_member') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ name, age, gender, relation })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success && data.member) {
                let m = data.member;
                let cart = getCheckoutCart();
                let itemNames = cart.map(i => i.name || i.title).join(', ') || 'All tests in cart';

                let html = `
                    <div class="member-card cursor-pointer bg-white border border-gray-200 rounded-xl p-4 flex items-start transition hover:border-brand-secondary shadow-sm" onclick="selectMember(${m.id}, this)">
                        <div class="pt-1 mr-4">
                            <div class="w-6 h-6 rounded-full border border-gray-300 text-transparent flex items-center justify-center text-xs member-check-indicator">
                                <i class="fas fa-check"></i>
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-bold text-gray-900 text-lg flex items-center">${m.name} <span class="text-[10px] bg-gray-100 text-gray-600 px-2 py-0.5 rounded ml-2 uppercase font-extrabold">${m.relation}</span></h3>
                                    <p class="text-xs text-gray-500 font-semibold mt-1">${m.age} Years | ${m.gender}</p>
                                </div>
                                <span class="text-xs font-bold text-gray-400">Family Member</span>
                            </div>
                            <div class="mt-3 pt-3 border-t border-gray-100">
                                <p class="text-xs text-gray-400 font-bold mb-1 uppercase tracking-wider">Assigned Tests / Packages:</p>
                                <div class="member-cart-summary text-sm font-semibold text-gray-700">${itemNames}</div>
                            </div>
                        </div>
                    </div>
                `;

                const list = document.getElementById('memberSelectionList');
                list.insertAdjacentHTML('beforeend', html);
                
                // Select the new member
                const newCard = list.lastElementChild;
                selectMember(m.id, newCard);

                // Reset form and close modal
                document.getElementById('addMemberForm').reset();
                window.closeAddMemberModal();
            } else {
                alert(data.message || 'Could not save member. Please try again.');
            }
        })
        .catch(() => alert('Network error adding member.'));
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', () => {
        updateUI();

        // Check if default address pincode is valid
        const defaultPincode = @json($defaultAddr?->pincode ?? '');
        if (defaultPincode && validPincodes.includes(defaultPincode)) {
            const pinInput = document.getElementById('pincodeInput');
            if (pinInput) {
                pinInput.value = defaultPincode;
                verifyPincode();
            }
        }

        // Date Selection Logic
        const dateContainer = document.getElementById('dateContainer');
        if (dateContainer) {
            dateContainer.addEventListener('click', (e) => {
                const item = e.target.closest('.date-item');
                if (!item) return;

                document.querySelectorAll('.date-item').forEach(d => {
                    d.classList.remove('border-2', 'border-brand-secondary', 'bg-brand-light/10', 'text-brand-secondary', 'active-date');
                    d.classList.add('border', 'border-gray-200', 'bg-white');
                    const spans = d.querySelectorAll('span');
                    if (spans.length === 3) {
                        spans[0].className = 'text-xs font-semibold text-gray-500';
                        spans[1].className = 'text-lg font-black text-gray-800';
                        spans[2].className = 'text-xs font-semibold text-gray-500';
                    }
                });

                item.classList.add('border-2', 'border-brand-secondary', 'bg-brand-light/10', 'text-brand-secondary', 'active-date');
                item.classList.remove('border', 'border-gray-200', 'bg-white');
                const spans = item.querySelectorAll('span');
                if (spans.length === 3) {
                    spans[0].className = 'text-xs font-bold text-brand-secondary';
                    spans[1].className = 'text-lg font-black text-brand-secondary';
                    spans[2].className = 'text-xs font-bold text-brand-secondary';
                }
            });
        }

        // Slot Selection Logic
        const slotItems = document.querySelectorAll('.slot-item');
        slotItems.forEach(item => {
            item.addEventListener('click', () => {
                slotItems.forEach(s => {
                    s.classList.remove('border-2', 'border-brand-secondary', 'bg-brand-light/10', 'text-brand-dark', 'active-slot');
                    s.classList.add('border', 'border-gray-200', 'bg-white', 'text-gray-600');
                });
                
                item.classList.add('border-2', 'border-brand-secondary', 'bg-brand-light/10', 'text-brand-dark', 'active-slot');
                item.classList.remove('border', 'border-gray-200', 'bg-white', 'text-gray-600');
            });
        });
    });
</script>
@endsection
