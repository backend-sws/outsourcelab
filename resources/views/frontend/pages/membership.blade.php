@extends('frontend.layouts.app')

@section('title', 'Care+ Health Membership Plans - Save on Diagnostics | Av Wellcare Diagnostics')

@section('content')
<!-- Ambient Background Elements -->
<div class="fixed inset-0 z-[-1] pointer-events-none overflow-hidden bg-slate-50/60">
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-amber-200/30 rounded-full blur-3xl"></div>
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
        <span class="text-teal-800 font-bold">Membership Subscription</span>
    </nav>

    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-brand-dark via-teal-950 to-slate-900 rounded-3xl p-8 sm:p-14 text-white shadow-2xl relative overflow-hidden mb-12 text-center">
        <div class="absolute top-0 right-0 w-96 h-96 bg-amber-500/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-teal-500/15 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 max-w-3xl mx-auto">
            <span class="px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-amber-400/20 text-amber-300 border border-amber-400/30 inline-flex items-center gap-1.5 mb-4">
                <i class="fas fa-crown text-amber-400"></i> Av Wellcare Care+ Subscription
            </span>
            <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-white leading-tight mb-5">
                Total Family Health Protection at Fraction of the Cost
            </h1>
            <p class="text-gray-200 text-sm sm:text-base leading-relaxed mb-6 font-normal">
                Enjoy flat discounts on all 3,600+ lab tests, unlimited free home sample collections, priority report turnaround, and complimentary physician teleconsultation.
            </p>

            <div class="flex flex-wrap justify-center gap-4 text-xs font-semibold">
                <div class="px-4 py-2 rounded-xl bg-white/10 border border-white/10 flex items-center gap-2 text-teal-100">
                    <i class="fas fa-house-medical text-teal-300"></i> Unlimited Free Home Visits
                </div>
                <div class="px-4 py-2 rounded-xl bg-white/10 border border-white/10 flex items-center gap-2 text-teal-100">
                    <i class="fas fa-percent text-amber-400"></i> Extra Flat Discounts
                </div>
                <div class="px-4 py-2 rounded-xl bg-white/10 border border-white/10 flex items-center gap-2 text-teal-100">
                    <i class="fas fa-people-roof text-cyan-300"></i> Up to 6 Family Members
                </div>
            </div>
        </div>
    </div>

    <!-- Membership Plans Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16 items-stretch">
        @forelse($plans as $plan)
            <div class="bg-white rounded-3xl p-8 border {{ $plan->is_popular ? 'border-2 border-amber-400 shadow-xl relative' : 'border-gray-100 shadow-sm' }} flex flex-col justify-between transition hover:-translate-y-1 duration-200">
                @if($plan->is_popular)
                    <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-gradient-to-r from-amber-500 to-yellow-400 text-slate-950 font-black text-[10px] uppercase tracking-wider py-1 px-4 rounded-full shadow-md">
                        Most Popular Plan
                    </div>
                @endif

                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-black text-gray-900">{{ $plan->name }}</h3>
                        <span class="text-xs font-bold px-2.5 py-1 bg-teal-50 text-teal-800 rounded-lg">
                            {{ $plan->duration_value }} {{ ucfirst($plan->duration_type) }}
                        </span>
                    </div>

                    @if($plan->tagline)
                        <p class="text-xs text-gray-500 mb-6">{{ $plan->tagline }}</p>
                    @endif

                    <!-- Price Box -->
                    <div class="mb-6 p-4 rounded-2xl bg-gray-50 border border-gray-100">
                        <div class="flex items-baseline gap-2">
                            <span class="text-3xl font-black text-gray-900 font-mono">₹{{ number_format($plan->price, 0) }}</span>
                            @if($plan->original_price && $plan->original_price > $plan->price)
                                <span class="text-sm font-bold text-gray-400 line-through font-mono">₹{{ number_format($plan->original_price, 0) }}</span>
                                <span class="text-xs font-extrabold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">
                                    {{ round((($plan->original_price - $plan->price) / $plan->original_price) * 100) }}% OFF
                                </span>
                            @endif
                        </div>
                        <span class="text-[10px] text-gray-500 block mt-1">Covers up to {{ $plan->family_coverage_limit ?? 1 }} family members</span>
                    </div>

                    <!-- Core Feature Checklist -->
                    <ul class="space-y-3 text-xs text-gray-700 mb-8">
                        @if($plan->discount_percentage)
                            <li class="flex items-center gap-2 font-bold text-teal-800">
                                <i class="fas fa-check-circle text-teal-600"></i> Extra {{ $plan->discount_percentage }}% OFF on all tests & packages
                            </li>
                        @endif
                        @if($plan->free_home_collection)
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check-circle text-teal-600"></i> Unlimited Free Home Sample Collections
                            </li>
                        @endif
                        @if($plan->free_teleconsultation)
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check-circle text-teal-600"></i> Free Doctor Teleconsultation on Reports
                            </li>
                        @endif
                        @if($plan->priority_reports)
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check-circle text-teal-600"></i> Fast-Track Priority Lab Processing
                            </li>
                        @endif
                        @if(is_array($plan->benefits))
                            @foreach($plan->benefits as $b)
                                <li class="flex items-center gap-2">
                                    <i class="fas fa-check-circle text-teal-600"></i> {{ $b }}
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>

                <div>
                    <a href="tel:{{ preg_replace('/[^0-9]/', '', \App\Models\Setting::get('helpline_primary', '8988988787')) }}" class="w-full py-3 px-4 {{ $plan->is_popular ? 'bg-amber-400 hover:bg-amber-300 text-slate-950' : 'bg-teal-700 hover:bg-teal-800 text-white' }} font-bold text-xs uppercase tracking-wider rounded-xl transition shadow text-center block">
                        Activate {{ $plan->name }}
                    </a>
                </div>
            </div>
        @empty
            <!-- Fallback Static Presentation if no database records exist yet -->
            <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm flex flex-col justify-between">
                <div>
                    <h3 class="text-xl font-black text-gray-900 mb-2">Individual Care+</h3>
                    <p class="text-xs text-gray-500 mb-6">Designed for individuals prioritizing preventative health tracking.</p>
                    <div class="text-3xl font-black text-gray-900 font-mono mb-4">₹499 <span class="text-xs font-semibold text-gray-400">/ year</span></div>
                    <ul class="space-y-3 text-xs text-gray-700 mb-8">
                        <li class="flex items-center gap-2"><i class="fas fa-check-circle text-teal-600"></i> Flat 15% OFF on all lab tests</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check-circle text-teal-600"></i> Free Home Sample Collections</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check-circle text-teal-600"></i> Priority Digital Reports</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check-circle text-teal-600"></i> 1 Free Doctor Teleconsultation</li>
                    </ul>
                </div>
                <a href="tel:{{ preg_replace('/[^0-9]/', '', \App\Models\Setting::get('helpline_primary', '8988988787')) }}" class="w-full py-3 bg-teal-700 text-white font-bold text-xs uppercase rounded-xl text-center block">Activate Plan</a>
            </div>

            <div class="bg-white rounded-3xl p-8 border-2 border-amber-400 shadow-xl relative flex flex-col justify-between">
                <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-amber-400 text-slate-950 font-black text-[10px] uppercase py-1 px-4 rounded-full">Most Popular</div>
                <div>
                    <h3 class="text-xl font-black text-gray-900 mb-2">Family Care+</h3>
                    <p class="text-xs text-gray-500 mb-6">Complete health peace of mind covering up to 4 family members.</p>
                    <div class="text-3xl font-black text-gray-900 font-mono mb-4">₹999 <span class="text-xs font-semibold text-gray-400">/ year</span></div>
                    <ul class="space-y-3 text-xs text-gray-700 mb-8">
                        <li class="flex items-center gap-2"><i class="fas fa-check-circle text-teal-600"></i> Covers up to 4 family members</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check-circle text-teal-600"></i> Flat 20% OFF on all lab tests & packages</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check-circle text-teal-600"></i> Unlimited Free Home Collections</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check-circle text-teal-600"></i> 4 Free Doctor Teleconsultations</li>
                    </ul>
                </div>
                <a href="tel:{{ preg_replace('/[^0-9]/', '', \App\Models\Setting::get('helpline_primary', '8988988787')) }}" class="w-full py-3 bg-amber-400 text-slate-950 font-bold text-xs uppercase rounded-xl text-center block">Activate Plan</a>
            </div>

            <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm flex flex-col justify-between">
                <div>
                    <h3 class="text-xl font-black text-gray-900 mb-2">Senior VIP Care+</h3>
                    <p class="text-xs text-gray-500 mb-6">Tailored for elderly parents with chronic condition tracking.</p>
                    <div class="text-3xl font-black text-gray-900 font-mono mb-4">₹1,499 <span class="text-xs font-semibold text-gray-400">/ year</span></div>
                    <ul class="space-y-3 text-xs text-gray-700 mb-8">
                        <li class="flex items-center gap-2"><i class="fas fa-check-circle text-teal-600"></i> Covers up to 6 family members</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check-circle text-teal-600"></i> Flat 25% OFF on tests & diabetic monitoring</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check-circle text-teal-600"></i> Unlimited priority home collections</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check-circle text-teal-600"></i> Dedicated clinical relationship manager</li>
                    </ul>
                </div>
                <a href="tel:{{ preg_replace('/[^0-9]/', '', \App\Models\Setting::get('helpline_primary', '8988988787')) }}" class="w-full py-3 bg-teal-700 text-white font-bold text-xs uppercase rounded-xl text-center block">Activate Plan</a>
            </div>
        @endforelse
    </div>

    <!-- How It Works Steps -->
    <div class="bg-white rounded-3xl p-8 sm:p-12 border border-gray-100 shadow-sm mb-16">
        <h3 class="text-xl font-black text-gray-900 mb-8 text-center">How to Subscribe & Redeem Benefits</h3>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-14 h-14 rounded-2xl bg-teal-50 text-teal-700 font-black text-xl mx-auto flex items-center justify-center mb-4">1</div>
                <h4 class="font-bold text-sm text-gray-900 mb-2">Choose & Enroll</h4>
                <p class="text-xs text-gray-500">Pick your preferred plan and activate via phone or online with your mobile number.</p>
            </div>
            <div class="text-center">
                <div class="w-14 h-14 rounded-2xl bg-teal-50 text-teal-700 font-black text-xl mx-auto flex items-center justify-center mb-4">2</div>
                <h4 class="font-bold text-sm text-gray-900 mb-2">Add Family Members</h4>
                <p class="text-xs text-gray-500">Register family profiles easily so everyone receives automatic membership discounts.</p>
            </div>
            <div class="text-center">
                <div class="w-14 h-14 rounded-2xl bg-teal-50 text-teal-700 font-black text-xl mx-auto flex items-center justify-center mb-4">3</div>
                <h4 class="font-bold text-sm text-gray-900 mb-2">Save on Every Booking</h4>
                <p class="text-xs text-gray-500">Your registered mobile number automatically triggers membership pricing and free doorstep visits.</p>
            </div>
        </div>
    </div>
</div>
@endsection
