@extends('admin.layouts.app')

@section('title', 'VIP Memberships & Loyalty Plans')

@section('content')
<div class="space-y-6">

    <!-- Top Header & Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-amber-500 to-yellow-400 text-white flex items-center justify-center font-bold text-lg shadow-md shadow-amber-500/20">
                    <i class="fas fa-crown"></i>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white">VIP Memberships & Loyalty Plans</h1>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Configure membership cards, discount percentages, validity periods, and perks for recurring health wellness.</p>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3 flex-wrap">
            <a href="{{ route('admin.memberships.subscribers') }}" class="px-4 py-2.5 rounded-xl text-xs font-bold bg-white dark:bg-white/[0.05] border border-slate-200 dark:border-white/[0.08] text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-white/[0.08] transition shadow-sm flex items-center gap-2">
                <i class="fas fa-users text-amber-500"></i>
                <span>Enrolled Patients ({{ $totalSubscribers }})</span>
            </a>

            <a href="{{ route('admin.memberships.create') }}" class="px-4 py-2.5 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-600 text-slate-950 transition flex items-center gap-2 shadow-sm shadow-amber-500/30">
                <i class="fas fa-plus"></i>
                <span>Create Membership Card</span>
            </a>
        </div>
    </div>

    <!-- Metric Counters -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- 1. Total Plans -->
        <div class="p-5 rounded-2xl bg-white dark:bg-white/[0.02] border border-slate-200/80 dark:border-white/[0.05] shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400">Total Plans</span>
                <h3 class="text-2xl font-black text-slate-900 dark:text-white mt-1">{{ $totalPlans }}</h3>
                <span class="text-[11px] text-emerald-500 font-bold mt-1 inline-block">{{ $activePlans }} Active</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-amber-500/10 text-amber-500 flex items-center justify-center text-xl">
                <i class="fas fa-id-card"></i>
            </div>
        </div>

        <!-- 2. Active Subscribers -->
        <div class="p-5 rounded-2xl bg-white dark:bg-white/[0.02] border border-slate-200/80 dark:border-white/[0.05] shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400">Active VIP Members</span>
                <h3 class="text-2xl font-black text-slate-900 dark:text-white mt-1">{{ $totalSubscribers }}</h3>
                <span class="text-[11px] text-teal-600 font-bold mt-1 inline-block">Loyal Customers</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-teal-50 dark:bg-teal-500/10 text-teal-600 flex items-center justify-center text-xl">
                <i class="fas fa-crown"></i>
            </div>
        </div>

        <!-- 3. Total Membership Revenue -->
        <div class="p-5 rounded-2xl bg-white dark:bg-white/[0.02] border border-slate-200/80 dark:border-white/[0.05] shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400">Membership Revenue</span>
                <h3 class="text-2xl font-black text-slate-900 dark:text-white mt-1">₹{{ number_format($totalRevenue, 0) }}</h3>
                <span class="text-[11px] text-indigo-500 font-bold mt-1 inline-block">Direct Pass Sales</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-500/10 text-indigo-500 flex items-center justify-center text-xl">
                <i class="fas fa-receipt"></i>
            </div>
        </div>

        <!-- 4. Default Discount Rate -->
        <div class="p-5 rounded-2xl bg-white dark:bg-white/[0.02] border border-slate-200/80 dark:border-white/[0.05] shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400">Average Savings</span>
                <h3 class="text-2xl font-black text-slate-900 dark:text-white mt-1">20% - 25%</h3>
                <span class="text-[11px] text-amber-600 font-bold mt-1 inline-block">+ Free Home Pickups</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-purple-50 dark:bg-purple-500/10 text-purple-600 flex items-center justify-center text-xl">
                <i class="fas fa-percentage"></i>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="p-4 rounded-2xl bg-white dark:bg-white/[0.02] border border-slate-200/80 dark:border-white/[0.05] shadow-sm">
        <form method="GET" action="{{ route('admin.memberships.index') }}" class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-center justify-between">
            <div class="relative flex-1">
                <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Search membership plans by name or tagline..." 
                    class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-white/[0.08] bg-slate-50/50 dark:bg-white/[0.03] text-xs font-semibold text-slate-800 dark:text-slate-200 outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500"
                >
            </div>

            <div class="flex items-center gap-2">
                <select name="status" onchange="this.form.submit()" class="px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-white/[0.08] bg-slate-50/50 dark:bg-white/[0.03] text-xs font-semibold text-slate-700 dark:text-slate-300 outline-none">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active Only</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive Only</option>
                </select>

                @if(request()->anyFilled(['search', 'status']))
                    <a href="{{ route('admin.memberships.index') }}" class="px-3 py-2.5 rounded-xl bg-slate-100 dark:bg-white/[0.05] text-slate-600 dark:text-slate-400 hover:text-slate-900 text-xs font-bold transition">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Membership Plans Visual Cards Deck -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($plans as $plan)
            @php
                $themeMap = [
                    'gold'     => ['border' => 'border-amber-400/60', 'header' => 'from-amber-500 to-yellow-600', 'badge' => 'bg-amber-100 text-amber-900 border-amber-300', 'accent' => 'text-amber-600'],
                    'platinum' => ['border' => 'border-slate-300 dark:border-slate-600', 'header' => 'from-slate-700 to-slate-900', 'badge' => 'bg-slate-100 text-slate-800 border-slate-300', 'accent' => 'text-slate-700 dark:text-slate-300'],
                    'emerald'  => ['border' => 'border-emerald-400/60', 'header' => 'from-teal-600 to-emerald-700', 'badge' => 'bg-emerald-100 text-emerald-900 border-emerald-300', 'accent' => 'text-emerald-600'],
                    'purple'   => ['border' => 'border-purple-400/60', 'header' => 'from-indigo-600 to-purple-700', 'badge' => 'bg-purple-100 text-purple-900 border-purple-300', 'accent' => 'text-purple-600'],
                ];
                $theme = $themeMap[$plan->theme_color] ?? $themeMap['gold'];
            @endphp

            <div class="bg-white dark:bg-white/[0.02] border-2 {{ $theme['border'] }} rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group relative">
                
                <!-- Card Top Gradient Banner -->
                <div>
                    <div class="bg-gradient-to-r {{ $theme['header'] }} text-white p-6 relative overflow-hidden">
                        <!-- Background Glow Accent -->
                        <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-white/10 rounded-full blur-xl pointer-events-none"></div>

                        <div class="flex items-center justify-between gap-2 mb-3">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-white/20 backdrop-blur-md border border-white/20">
                                <i class="fas fa-crown text-amber-300"></i>
                                <span>{{ $plan->formatted_duration }} Validity</span>
                            </span>

                            @if($plan->is_popular)
                                <span class="bg-amber-400 text-slate-950 text-[10px] font-black px-2.5 py-0.5 rounded-full uppercase tracking-wider shadow-sm">
                                    ★ Most Popular
                                </span>
                            @endif
                        </div>

                        <h3 class="text-xl font-black tracking-tight mb-1">{{ $plan->name }}</h3>
                        <p class="text-xs text-white/80 font-medium line-clamp-1">{{ $plan->tagline ?: 'Annual health wellness & diagnostic security' }}</p>

                        <!-- Price Section -->
                        <div class="mt-4 pt-3 border-t border-white/15 flex items-baseline justify-between">
                            <div>
                                <span class="text-3xl font-black">₹{{ number_format($plan->price, 0) }}</span>
                                @if($plan->original_price)
                                    <span class="text-xs text-white/60 line-through ml-2 font-bold">₹{{ number_format($plan->original_price, 0) }}</span>
                                @endif
                            </div>
                            <span class="px-2.5 py-1 rounded-xl bg-white/20 backdrop-blur-md text-xs font-black">
                                Flat {{ $plan->discount_percentage }}% OFF
                            </span>
                        </div>
                    </div>

                    <!-- Benefits Checklist -->
                    <div class="p-6 space-y-3">
                        <span class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400 block">Plan Benefits</span>
                        
                        <ul class="space-y-2.5 text-xs text-slate-700 dark:text-slate-300 font-medium">
                            <li class="flex items-start gap-2.5">
                                <i class="fas fa-check-circle text-emerald-500 mt-0.5 flex-shrink-0"></i>
                                <span><strong>{{ $plan->discount_percentage }}% Flat Discount</strong> on all diagnostic tests</span>
                            </li>
                            @if($plan->free_home_collection)
                                <li class="flex items-start gap-2.5">
                                    <i class="fas fa-check-circle text-emerald-500 mt-0.5 flex-shrink-0"></i>
                                    <span><strong>Zero Collection Fee</strong> (Free home pickup on every test)</span>
                                </li>
                            @endif
                            @if($plan->free_teleconsultation)
                                <li class="flex items-start gap-2.5">
                                    <i class="fas fa-check-circle text-emerald-500 mt-0.5 flex-shrink-0"></i>
                                    <span><strong>Free Doctor Consultations</strong> on test reports</span>
                                </li>
                            @endif
                            @if($plan->priority_reports)
                                <li class="flex items-start gap-2.5">
                                    <i class="fas fa-check-circle text-emerald-500 mt-0.5 flex-shrink-0"></i>
                                    <span><strong>Priority Report Delivery</strong> within 6-8 hours</span>
                                </li>
                            @endif
                            @if(!empty($plan->benefits) && is_array($plan->benefits))
                                @foreach($plan->benefits as $perk)
                                    <li class="flex items-start gap-2.5">
                                        <i class="fas fa-check-circle text-emerald-500 mt-0.5 flex-shrink-0"></i>
                                        <span>{{ $perk }}</span>
                                    </li>
                                @endforeach
                            @endif
                        </ul>

                        <div class="mt-4 pt-3 border-t border-slate-100 dark:border-white/[0.05] flex items-center justify-between text-xs">
                            <span class="text-slate-500 font-semibold">Family Coverage:</span>
                            <span class="font-extrabold text-slate-800 dark:text-slate-200">Up to {{ $plan->family_coverage_limit }} Members</span>
                        </div>

                        <div class="flex items-center justify-between text-xs pt-1">
                            <span class="text-slate-500 font-semibold">Active Subscribers:</span>
                            <span class="font-extrabold text-amber-600 bg-amber-50 dark:bg-amber-500/10 px-2 py-0.5 rounded-full">
                                {{ $plan->active_subscribers_count }} Patients
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Card Footer Actions -->
                <div class="p-4 bg-slate-50/70 dark:bg-white/[0.02] border-t border-slate-100 dark:border-white/[0.05] flex items-center justify-between gap-2">
                    <!-- Toggle Status -->
                    <form action="{{ route('admin.memberships.toggle', $plan->id) }}" method="POST" class="inline-block">
                        @csrf
                        <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5 {{ $plan->is_active ? 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200' : 'bg-slate-100 text-slate-500 hover:bg-slate-200' }}">
                            <span class="w-2 h-2 rounded-full {{ $plan->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                            <span>{{ $plan->is_active ? 'Active' : 'Hidden' }}</span>
                        </button>
                    </form>

                    <div class="flex items-center gap-1.5">
                        <a href="{{ route('admin.memberships.edit', $plan->id) }}" class="p-2 text-slate-500 hover:text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-500/10 rounded-lg transition" title="Edit Plan">
                            <i class="far fa-edit"></i>
                        </a>

                        <form action="{{ route('admin.memberships.destroy', $plan->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this plan?');" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-500/10 rounded-lg transition" title="Delete Plan">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center bg-white dark:bg-white/[0.02] rounded-3xl border border-dashed border-slate-300 dark:border-white/[0.08]">
                <div class="w-16 h-16 rounded-full bg-amber-50 dark:bg-amber-500/10 text-amber-500 flex items-center justify-center text-2xl mx-auto mb-3">
                    <i class="fas fa-crown"></i>
                </div>
                <h4 class="text-base font-extrabold text-slate-800 dark:text-slate-200">No Membership Plans Configured</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400 max-w-sm mx-auto mt-1 mb-5">Create your first VIP Health Membership card to offer discounts and loyalty incentives to your patients.</p>
                <a href="{{ route('admin.memberships.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-slate-950 text-xs font-extrabold rounded-xl shadow-sm">
                    <i class="fas fa-plus"></i> Create First Plan
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($plans->hasPages())
        <div class="pt-4">
            {{ $plans->links() }}
        </div>
    @endif

</div>
@endsection
