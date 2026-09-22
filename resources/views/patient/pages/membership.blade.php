@extends('frontend.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 bg-gray-50/50 min-h-screen">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar -->
        @include('patient.layouts.sidebar')

        <!-- Main Content -->
        <div class="w-full md:w-2/3 lg:w-3/4 space-y-8">

            <!-- Success Alert -->
            @if(session('success'))
            <div class="p-5 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-600 text-white shadow-lg flex items-center justify-between animate-fade-in">
                <div class="flex items-center gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center text-white text-xl">
                        <i class="fas fa-crown"></i>
                    </div>
                    <div>
                        <h4 class="font-black text-sm sm:text-base">{{ session('success') }}</h4>
                        <p class="text-xs text-white/90 font-medium mt-0.5">Your VIP privileges are immediately active across your account and checkout.</p>
                    </div>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-white/80 hover:text-white text-xl font-bold p-1">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            @endif

            <!-- Header Banner -->
            <div class="rounded-3xl bg-gradient-to-br from-slate-900 via-brand-dark to-slate-900 text-white p-6 sm:p-8 shadow-xl relative overflow-hidden border border-slate-800">
                <div class="absolute -right-16 -bottom-16 w-64 h-64 rounded-full bg-amber-500/10 blur-3xl pointer-events-none"></div>
                <div class="absolute right-6 top-6 text-white/5 text-9xl font-black select-none pointer-events-none">
                    <i class="fas fa-crown"></i>
                </div>

                <div class="relative z-10 max-w-2xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-500/20 border border-amber-500/30 text-amber-300 text-xs font-black uppercase tracking-wider mb-3">
                        <i class="fas fa-crown text-amber-400"></i> Wellcare VIP Health Club
                    </div>
                    <h1 class="text-2xl sm:text-4xl font-black tracking-tight leading-tight">
                        Healthcare that saves you money with every single test.
                    </h1>
                    <p class="text-slate-300 text-xs sm:text-sm mt-3 leading-relaxed">
                        Enjoy flat discounts on all diagnostic packages, 100% free home sample collections, priority processing, and family coverage with Wellcare VIP membership.
                    </p>

                    <div class="flex flex-wrap items-center gap-4 mt-6 pt-5 border-t border-white/10 text-xs font-semibold text-slate-300">
                        <div class="flex items-center gap-2">
                            <span class="w-5 h-5 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-[10px]"><i class="fas fa-check"></i></span>
                            <span>Flat 20-25% OFF Tests</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-5 h-5 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-[10px]"><i class="fas fa-check"></i></span>
                            <span>₹0 Home Pickup Fee</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-5 h-5 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-[10px]"><i class="fas fa-check"></i></span>
                            <span>Whole Family Coverage</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Membership Virtual Card (If Active) -->
            @if($activeMembership)
            <div class="bg-white rounded-3xl border border-gray-200 p-6 sm:p-8 shadow-sm">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-gray-100">
                    <div>
                        <span class="text-[11px] font-black uppercase tracking-wider text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full border border-amber-200">
                            Current Status: Active
                        </span>
                        <h2 class="text-xl sm:text-2xl font-black text-brand-dark mt-2">Your Virtual VIP Membership Card</h2>
                        <p class="text-xs text-gray-500 font-medium mt-1">This digital card entitles you to exclusive pricing and benefits across all lab services.</p>
                    </div>
                    <div class="text-left sm:text-right">
                        <span class="text-xs font-bold text-gray-400 block">Valid Until</span>
                        <span class="text-base font-black text-brand-dark">{{ $activeMembership->expires_at ? $activeMembership->expires_at->format('d M Y') : 'Lifetime' }}</span>
                        @if($activeMembership->days_remaining > 0)
                            <span class="block text-[11px] font-bold text-emerald-600">({{ $activeMembership->days_remaining }} days remaining)</span>
                        @endif
                    </div>
                </div>

                <!-- Virtual Card Visual Display -->
                <div class="mt-6 grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
                    <!-- The Card Canvas -->
                    <div class="lg:col-span-7">
                        <div class="w-full max-w-md mx-auto aspect-[1.586/1] rounded-3xl p-6 sm:p-8 text-white relative overflow-hidden shadow-2xl transition transform hover:scale-[1.01]"
                             style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 50%, #020617 100%); border: 1px solid rgba(245, 158, 11, 0.3);">
                            
                            <!-- Gold Ambient Glow -->
                            <div class="absolute -top-10 -right-10 w-44 h-44 rounded-full bg-amber-500/20 blur-2xl pointer-events-none"></div>
                            <div class="absolute -bottom-10 -left-10 w-44 h-44 rounded-full bg-brand-primary/20 blur-2xl pointer-events-none"></div>

                            <!-- Card Header -->
                            <div class="flex items-center justify-between relative z-10">
                                <div class="flex items-center gap-2">
                                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-amber-400 to-amber-600 flex items-center justify-center text-slate-950 font-black shadow-md">
                                        <i class="fas fa-crown text-base"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-xs sm:text-sm font-black tracking-wider uppercase text-amber-300">Wellcare VIP</h3>
                                        <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">Health Pass</p>
                                    </div>
                                </div>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black tracking-wider uppercase bg-amber-500/20 text-amber-300 border border-amber-500/40">
                                    {{ $activeMembership->plan_name_snapshot }}
                                </span>
                            </div>

                            <!-- Simulated Chip & Contactless -->
                            <div class="my-5 flex items-center gap-3 relative z-10">
                                <div class="w-11 h-8 rounded-md bg-gradient-to-br from-amber-200 via-amber-400 to-amber-600 border border-amber-300 shadow-inner flex items-center justify-center">
                                    <div class="w-8 h-5 border border-amber-700/40 rounded flex flex-col justify-around py-0.5">
                                        <div class="h-px bg-amber-700/40"></div>
                                        <div class="h-px bg-amber-700/40"></div>
                                    </div>
                                </div>
                                <i class="fas fa-wifi text-slate-500 text-sm rotate-90"></i>
                            </div>

                            <!-- Membership Number Simulation -->
                            <div class="relative z-10 mb-4">
                                <span class="font-mono text-sm sm:text-lg font-bold tracking-[0.2em] text-slate-200">
                                    VIP •••• •••• {{ str_pad($activeMembership->id, 4, '0', STR_PAD_LEFT) }}
                                </span>
                            </div>

                            <!-- Card Footer -->
                            <div class="flex items-end justify-between relative z-10 pt-2 border-t border-slate-800">
                                <div>
                                    <span class="text-[9px] text-slate-400 uppercase tracking-widest font-bold block">Card Holder</span>
                                    <span class="text-xs sm:text-sm font-black text-white tracking-wide uppercase">{{ $profile->name }}</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-[9px] text-slate-400 uppercase tracking-widest font-bold block">Discount Benefit</span>
                                    <span class="text-xs sm:text-sm font-black text-amber-400">{{ $activeMembership->discount_percentage }}% OFF All Tests</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Benefits Highlight List -->
                    <div class="lg:col-span-5 space-y-4">
                        <h3 class="font-black text-brand-dark text-base">Your Active Privileges:</h3>
                        <div class="space-y-3">
                            <div class="flex items-start gap-3 p-3 rounded-xl bg-amber-50/60 border border-amber-100">
                                <div class="w-8 h-8 rounded-lg bg-amber-500 text-white flex items-center justify-center flex-shrink-0 text-sm font-bold shadow-sm">
                                    <i class="fas fa-percent"></i>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-slate-900">Flat {{ $activeMembership->discount_percentage }}% Instant Discount</h4>
                                    <p class="text-[11px] text-slate-600 mt-0.5">Applies automatically at checkout on all pathology tests and health packages.</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3 p-3 rounded-xl bg-teal-50/60 border border-teal-100">
                                <div class="w-8 h-8 rounded-lg bg-brand-primary text-white flex items-center justify-center flex-shrink-0 text-sm font-bold shadow-sm">
                                    <i class="fas fa-home"></i>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-slate-900">100% Free Home Sample Collection</h4>
                                    <p class="text-[11px] text-slate-600 mt-0.5">Certified phlebotomist visit to your doorstep at ₹0 collection fee.</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3 p-3 rounded-xl bg-indigo-50/60 border border-indigo-100">
                                <div class="w-8 h-8 rounded-lg bg-indigo-600 text-white flex items-center justify-center flex-shrink-0 text-sm font-bold shadow-sm">
                                    <i class="fas fa-file-medical-alt"></i>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-slate-900">Priority Processing & WhatsApp Reports</h4>
                                    <p class="text-[11px] text-slate-600 mt-0.5">Faster report turnaround time with instant WhatsApp PDF delivery.</p>
                                </div>
                            </div>
                        </div>

                        <a href="/" class="inline-flex items-center justify-center gap-2 w-full py-3 bg-brand-dark hover:bg-brand-secondary text-white font-extrabold text-xs rounded-xl shadow-md transition">
                            <i class="fas fa-search"></i> Book a Test with VIP Discount
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Available Plans Section -->
            <div>
                <div class="text-center max-w-xl mx-auto mb-8">
                    <span class="text-xs font-black tracking-wider uppercase text-amber-600 bg-amber-50 px-3 py-1 rounded-full border border-amber-200">
                        Choose Your Plan
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black text-brand-dark mt-2">
                        {{ $activeMembership ? 'Renew or Upgrade Your VIP Membership' : 'Select a VIP Health Pass' }}
                    </h2>
                    <p class="text-xs sm:text-sm text-gray-500 font-medium mt-1">
                        Select a plan that fits your family's annual diagnostic and preventive checkup needs.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($plans as $plan)
                    @php
                        $isCurrent = $activeMembership && $activeMembership->membership_plan_id == $plan->id;
                    @endphp
                    <div class="rounded-3xl bg-white border {{ $plan->is_popular ? 'border-amber-400 ring-2 ring-amber-400/20 shadow-xl' : 'border-gray-200 shadow-sm' }} p-6 sm:p-8 flex flex-col justify-between relative overflow-hidden transition-all hover:shadow-lg">
                        @if($plan->is_popular)
                        <div class="absolute top-0 right-0">
                            <span class="bg-gradient-to-l from-amber-500 to-amber-600 text-white text-[10px] font-black uppercase tracking-wider py-1 px-4 rounded-bl-xl shadow-sm">
                                <i class="fas fa-fire mr-1"></i> Most Popular
                            </span>
                        </div>
                        @endif

                        <div>
                            <!-- Header -->
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-2xl {{ $plan->is_popular ? 'bg-amber-100 text-amber-600 border border-amber-200' : 'bg-slate-100 text-slate-700 border border-slate-200' }} flex items-center justify-center text-xl font-black shadow-sm">
                                    <i class="fas fa-crown"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-black text-brand-dark">{{ $plan->name }}</h3>
                                    <span class="inline-flex items-center gap-1 text-[11px] font-extrabold px-2 py-0.5 rounded-full bg-slate-100 text-slate-700 mt-0.5">
                                        <i class="far fa-clock text-[10px]"></i> {{ $plan->formatted_duration }} Validity
                                    </span>
                                </div>
                            </div>

                            @if($plan->tagline)
                            <p class="text-xs text-gray-500 font-medium mt-3">{{ $plan->tagline }}</p>
                            @endif

                            <!-- Pricing -->
                            <div class="mt-6 p-4 rounded-2xl bg-gradient-to-br from-gray-50 to-slate-50 border border-gray-100">
                                <div class="flex items-baseline gap-2">
                                    <span class="text-3xl sm:text-4xl font-black text-brand-dark">₹{{ number_format($plan->price, 0) }}</span>
                                    @if($plan->original_price && $plan->original_price > $plan->price)
                                    <span class="text-sm font-bold text-gray-400 line-through">₹{{ number_format($plan->original_price, 0) }}</span>
                                    <span class="text-xs font-black text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-100">
                                        Save {{ $plan->savings_percentage }}%
                                    </span>
                                    @endif
                                </div>
                                <p class="text-[11px] text-gray-500 font-semibold mt-1">
                                    Effective cost just ₹{{ round($plan->price / ($plan->duration_in_months ?: 12)) }}/month
                                </p>
                            </div>

                            <!-- Flat Discount Highlight -->
                            <div class="mt-4 p-3 rounded-xl bg-amber-50 border border-amber-200/80 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-tag text-amber-600 text-sm"></i>
                                    <span class="text-xs font-black text-amber-900">VIP Test Discount Rate</span>
                                </div>
                                <span class="text-sm font-black text-amber-700 bg-white px-2.5 py-0.5 rounded-lg shadow-xs border border-amber-200">
                                    Flat {{ $plan->discount_percentage }}% OFF
                                </span>
                            </div>

                            <!-- Features List -->
                            <div class="mt-6 space-y-3">
                                <h4 class="text-xs font-extrabold uppercase tracking-wider text-gray-400">Included Benefits</h4>
                                <ul class="text-xs font-semibold text-gray-700 space-y-2.5">
                                    @if($plan->free_home_collection)
                                    <li class="flex items-center gap-2.5">
                                        <i class="fas fa-check-circle text-emerald-500 text-sm flex-shrink-0"></i>
                                        <span><strong>100% Free Home Sample Collection</strong> on every test</span>
                                    </li>
                                    @endif

                                    @if($plan->family_coverage_limit > 0)
                                    <li class="flex items-center gap-2.5">
                                        <i class="fas fa-check-circle text-emerald-500 text-sm flex-shrink-0"></i>
                                        <span>Covers up to <strong>{{ $plan->family_coverage_limit }} Family Members</strong></span>
                                    </li>
                                    @endif

                                    @if($plan->priority_reports)
                                    <li class="flex items-center gap-2.5">
                                        <i class="fas fa-check-circle text-emerald-500 text-sm flex-shrink-0"></i>
                                        <span>Priority Lab Processing & Rapid Dispatch</span>
                                    </li>
                                    @endif

                                    @if($plan->free_teleconsultation)
                                    <li class="flex items-center gap-2.5">
                                        <i class="fas fa-check-circle text-emerald-500 text-sm flex-shrink-0"></i>
                                        <span>Complimentary Tele-consultation on Report Review</span>
                                    </li>
                                    @endif

                                    @if(is_array($plan->benefits))
                                        @foreach($plan->benefits as $benefit)
                                            @if(!empty(trim($benefit)))
                                            <li class="flex items-center gap-2.5">
                                                <i class="fas fa-check-circle text-amber-500 text-sm flex-shrink-0"></i>
                                                <span>{{ $benefit }}</span>
                                            </li>
                                            @endif
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="mt-8 pt-4 border-t border-gray-100">
                            @if($isCurrent)
                            <div class="w-full py-3 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-center font-black text-xs flex items-center justify-center gap-2">
                                <i class="fas fa-check-circle text-emerald-600"></i> Currently Active Plan
                            </div>
                            @else
                            <button type="button" onclick="purchaseMembershipRazorpay({{ $plan->id }}, '{{ addslashes($plan->name) }}', {{ $plan->price }}, this)" class="w-full py-3.5 rounded-2xl {{ $plan->is_popular ? 'bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white shadow-lg shadow-amber-500/20' : 'bg-brand-dark hover:bg-brand-secondary text-white shadow-md' }} font-black text-xs transition flex items-center justify-center gap-2 cursor-pointer">
                                <i class="fas fa-bolt"></i>
                                <span>{{ $activeMembership ? 'Upgrade to '.$plan->name : 'Activate '.$plan->name.' Now' }}</span>
                            </button>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="col-span-2 text-center py-12 bg-white rounded-3xl border border-gray-200 p-8">
                        <div class="w-16 h-16 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center text-2xl mx-auto mb-3">
                            <i class="fas fa-crown"></i>
                        </div>
                        <h4 class="font-extrabold text-brand-dark text-base">New VIP Plans Coming Soon</h4>
                        <p class="text-xs text-gray-500 mt-1">Our administrative team is updating our loyalty packages. Please check back shortly!</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Benefits Comparison Infographic -->
            <div class="bg-white rounded-3xl border border-gray-200 p-6 sm:p-8 shadow-sm">
                <h3 class="text-lg sm:text-xl font-black text-brand-dark mb-2">Why Become a Wellcare VIP Member?</h3>
                <p class="text-xs text-gray-500 font-medium mb-6">Compare regular patient booking benefits vs. VIP health club members.</p>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="border-b border-gray-200 text-gray-400 font-extrabold uppercase tracking-wider">
                                <th class="pb-3 w-1/2">Privilege / Feature</th>
                                <th class="pb-3 text-center w-1/4">Regular Patient</th>
                                <th class="pb-3 text-center w-1/4 text-amber-600 font-black">Wellcare VIP Member</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 font-semibold text-gray-700">
                            <tr>
                                <td class="py-3.5">Diagnostic Test & Package Discount</td>
                                <td class="py-3.5 text-center text-gray-400">Standard MRP</td>
                                <td class="py-3.5 text-center font-black text-emerald-600">Flat 20% to 25% OFF Every Order</td>
                            </tr>
                            <tr>
                                <td class="py-3.5">Home Sample Collection Fee</td>
                                <td class="py-3.5 text-center text-gray-500">₹100 - ₹150 / visit</td>
                                <td class="py-3.5 text-center font-black text-emerald-600">100% FREE (Zero convenience charges)</td>
                            </tr>
                            <tr>
                                <td class="py-3.5">Report Turnaround Time</td>
                                <td class="py-3.5 text-center text-gray-500">Standard queue</td>
                                <td class="py-3.5 text-center font-black text-brand-primary">Priority Fast-Track Queue</td>
                            </tr>
                            <tr>
                                <td class="py-3.5">Family Member Coverage</td>
                                <td class="py-3.5 text-center text-gray-500">Individual only</td>
                                <td class="py-3.5 text-center font-black text-indigo-600">Up to 6 Family Members Covered</td>
                            </tr>
                            <tr>
                                <td class="py-3.5">VIP WhatsApp Concierge</td>
                                <td class="py-3.5 text-center text-gray-400"><i class="fas fa-times text-gray-300"></i></td>
                                <td class="py-3.5 text-center font-black text-emerald-600"><i class="fas fa-check text-emerald-500"></i> Included</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Membership History Table (if any) -->
            @if($membershipHistory && $membershipHistory->count() > 0)
            <div class="bg-white rounded-3xl border border-gray-200 p-6 sm:p-8 shadow-sm">
                <h3 class="text-base font-black text-brand-dark mb-4">Membership History</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="border-b border-gray-200 text-gray-400 font-bold uppercase tracking-wider">
                                <th class="pb-2">Plan</th>
                                <th class="pb-2">Price</th>
                                <th class="pb-2">Discount</th>
                                <th class="pb-2">Activated</th>
                                <th class="pb-2">Expires</th>
                                <th class="pb-2 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 font-semibold text-gray-700">
                            @foreach($membershipHistory as $history)
                            <tr>
                                <td class="py-3 font-extrabold text-brand-dark">{{ $history->plan_name_snapshot }}</td>
                                <td class="py-3">₹{{ number_format($history->price_paid, 0) }}</td>
                                <td class="py-3 font-bold text-amber-600">{{ $history->discount_percentage }}% OFF</td>
                                <td class="py-3 text-gray-500">{{ $history->started_at ? $history->started_at->format('d M Y') : '-' }}</td>
                                <td class="py-3 text-gray-500">{{ $history->expires_at ? $history->expires_at->format('d M Y') : 'Lifetime' }}</td>
                                <td class="py-3 text-right">
                                    @if($history->is_valid)
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-emerald-50 text-emerald-700 border border-emerald-200">Active</span>
                                    @else
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-gray-100 text-gray-500">Expired</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    function purchaseMembershipRazorpay(planId, planName, price, btn) {
        let originalHtml = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Initializing...';

        fetch("{{ route('razorpay.membership.order') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                plan_id: planId
            })
        })
        .then(r => r.json())
        .then(data => {
            if (!data.success) {
                alert(data.message || 'Could not initiate membership payment.');
                btn.disabled = false;
                btn.innerHTML = originalHtml;
                return;
            }

            const options = {
                key: data.key,
                amount: data.amount,
                currency: data.currency || 'INR',
                name: data.name || 'Av Wellcare Diagnostics',
                description: data.description || ('VIP Membership - ' + planName),
                order_id: data.order_id,
                prefill: data.prefill || {},
                theme: data.theme || { color: '#d97706' },
                handler: function(response) {
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Activating Membership...';
                    fetch("{{ route('razorpay.membership.verify') }}", {
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
                            plan_id: planId
                        })
                    })
                    .then(vr => vr.json())
                    .then(vData => {
                        if (vData.success) {
                            window.location.reload();
                        } else {
                            alert('Membership verification error: ' + (vData.message || 'Please contact support.'));
                            window.location.reload();
                        }
                    })
                    .catch(err => {
                        alert('Network issue during verification. Your membership will update shortly.');
                        window.location.reload();
                    });
                },
                modal: {
                    ondismiss: function() {
                        btn.disabled = false;
                        btn.innerHTML = originalHtml;
                    }
                }
            };

            const rzp = new Razorpay(options);
            rzp.on('payment.failed', function(response) {
                alert('Payment failed: ' + (response.error.description || 'Transaction declined.'));
                btn.disabled = false;
                btn.innerHTML = originalHtml;
            });
            rzp.open();
        })
        .catch(err => {
            console.error(err);
            alert('Network error. Please try again.');
            btn.disabled = false;
            btn.innerHTML = originalHtml;
        });
    }
</script>
@endsection

