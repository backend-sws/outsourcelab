@extends('admin.layouts.app')

@section('title', 'VIP Enrolled Patients')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.memberships.index') }}" class="w-10 h-10 rounded-xl bg-white dark:bg-white/[0.05] border border-slate-200 dark:border-white/[0.08] text-slate-500 hover:text-slate-900 dark:hover:text-white flex items-center justify-center transition shadow-sm">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white">VIP Health Club Subscribers</h1>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Track active patient memberships, validity periods, and renewal dates.</p>
            </div>
        </div>

        <a href="{{ route('admin.memberships.index') }}" class="px-4 py-2.5 rounded-xl text-xs font-bold bg-white dark:bg-white/[0.05] border border-slate-200 dark:border-white/[0.08] text-slate-700 dark:text-slate-200 hover:bg-slate-50 transition shadow-sm flex items-center gap-2">
            <i class="fas fa-id-card text-amber-500"></i>
            <span>Manage Plans</span>
        </a>
    </div>

    <!-- Filters -->
    <div class="p-4 rounded-2xl bg-white dark:bg-white/[0.02] border border-slate-200/80 dark:border-white/[0.05] shadow-sm">
        <form method="GET" action="{{ route('admin.memberships.subscribers') }}" class="flex flex-col md:flex-row gap-3 items-stretch md:items-center justify-between">
            <div class="relative flex-1">
                <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Search by patient name, phone, or email..." 
                    class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-white/[0.08] bg-slate-50/50 dark:bg-white/[0.03] text-xs font-semibold text-slate-800 dark:text-slate-200 outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500"
                >
            </div>

            <div class="flex items-center gap-2 flex-wrap">
                <select name="plan_id" onchange="this.form.submit()" class="px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-white/[0.08] bg-slate-50/50 dark:bg-white/[0.03] text-xs font-semibold text-slate-700 dark:text-slate-300 outline-none">
                    <option value="">All Plans</option>
                    @foreach($plans as $p)
                        <option value="{{ $p->id }}" {{ request('plan_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                    @endforeach
                </select>

                <select name="status" onchange="this.form.submit()" class="px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-white/[0.08] bg-slate-50/50 dark:bg-white/[0.03] text-xs font-semibold text-slate-700 dark:text-slate-300 outline-none">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expired</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>

                @if(request()->anyFilled(['search', 'plan_id', 'status']))
                    <a href="{{ route('admin.memberships.subscribers') }}" class="px-3 py-2.5 rounded-xl bg-slate-100 dark:bg-white/[0.05] text-slate-600 dark:text-slate-400 hover:text-slate-900 text-xs font-bold transition">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Subscribers Table -->
    <div class="bg-white dark:bg-white/[0.02] border border-slate-200/80 dark:border-white/[0.05] rounded-3xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 dark:border-white/[0.05] bg-slate-50/60 dark:bg-white/[0.02] text-[11px] font-black uppercase tracking-wider text-slate-400">
                        <th class="py-4 px-6">Patient</th>
                        <th class="py-4 px-6">Enrolled Plan</th>
                        <th class="py-4 px-6">Discount Rate</th>
                        <th class="py-4 px-6">Price Paid</th>
                        <th class="py-4 px-6">Started Date</th>
                        <th class="py-4 px-6">Valid Until</th>
                        <th class="py-4 px-6">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-white/[0.05] text-xs">
                    @forelse($subscribers as $sub)
                        @php
                            $isExpired = $sub->expires_at && $sub->expires_at->isPast();
                            $daysLeft = $sub->days_remaining;
                        @endphp
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-white/[0.01] transition">
                            <!-- Patient Info -->
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-amber-500 to-yellow-400 text-white font-black text-sm flex items-center justify-center flex-shrink-0 shadow-sm">
                                        {{ strtoupper(substr($sub->patient->name ?? 'P', 0, 1)) }}
                                    </div>
                                    <div>
                                        <h4 class="font-extrabold text-slate-900 dark:text-white">{{ $sub->patient->name ?? 'Unknown Patient' }}</h4>
                                        <p class="text-[11px] text-slate-400 font-mono mt-0.5">+91 {{ $sub->patient->mobile ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Plan Name -->
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl bg-amber-50 dark:bg-amber-500/10 text-amber-800 dark:text-amber-300 font-extrabold text-xs border border-amber-200/60">
                                    <i class="fas fa-crown text-amber-500 text-[10px]"></i>
                                    <span>{{ $sub->plan_name_snapshot }}</span>
                                </span>
                            </td>

                            <!-- Discount Rate -->
                            <td class="py-4 px-6 font-black text-emerald-600">
                                {{ $sub->discount_percentage }}% OFF
                            </td>

                            <!-- Price Paid -->
                            <td class="py-4 px-6 font-black text-slate-900 dark:text-white">
                                ₹{{ number_format($sub->price_paid, 0) }}
                            </td>

                            <!-- Started At -->
                            <td class="py-4 px-6 text-slate-500 font-medium">
                                {{ $sub->started_at ? $sub->started_at->format('d M Y') : $sub->created_at->format('d M Y') }}
                            </td>

                            <!-- Expires At -->
                            <td class="py-4 px-6">
                                <div>
                                    <span class="font-bold text-slate-800 dark:text-slate-200 block">
                                        {{ $sub->expires_at ? $sub->expires_at->format('d M Y') : 'Lifetime' }}
                                    </span>
                                    @if(!$isExpired && $daysLeft > 0)
                                        <span class="text-[10px] text-teal-600 font-bold">({{ $daysLeft }} days left)</span>
                                    @elseif($isExpired)
                                        <span class="text-[10px] text-rose-500 font-bold">(Expired)</span>
                                    @endif
                                </div>
                            </td>

                            <!-- Status Pill -->
                            <td class="py-4 px-6">
                                @if($sub->status === 'active' && !$isExpired)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-black bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                                    </span>
                                @elseif($isExpired || $sub->status === 'expired')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-black bg-slate-100 text-slate-600 border border-slate-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Expired
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-black bg-rose-50 text-rose-700 border border-rose-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Cancelled
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <i class="fas fa-users-slash text-3xl mb-2 text-slate-300"></i>
                                <p class="text-xs font-bold">No enrolled VIP subscribers found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($subscribers->hasPages())
            <div class="p-4 border-t border-slate-100 dark:border-white/[0.05]">
                {{ $subscribers->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
