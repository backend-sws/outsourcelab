@extends('admin.layouts.app')

@section('title', 'Sample Collection Slots')
@section('header', 'Sample Collection Slots Management')

@section('content')
<div class="space-y-6">

    <!-- Top Action Bar & Description -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white dark:bg-[#051210] p-5 rounded-2xl border border-slate-100 dark:border-teal-900/40 shadow-sm">
        <div class="space-y-1">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-teal-500/10 text-teal-600 dark:text-teal-400 flex items-center justify-center font-bold">
                    <i class="fas fa-clock text-base"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white">Sample Collection Slots</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Configure customer time windows for doorstep phlebotomy and sample collections</p>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-2.5 flex-wrap">
            <button onclick="openAddSlotModal()" class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-500 hover:to-emerald-500 text-white text-xs font-bold shadow-md shadow-teal-600/30 transition-all flex items-center gap-2 cursor-pointer">
                <i class="fas fa-plus"></i>
                <span>Add New Slot</span>
            </button>
        </div>
    </div>

    <!-- Stat Summary Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3.5">
        <!-- Total Slots -->
        <div class="bg-white dark:bg-[#051210] p-4 rounded-2xl border border-slate-100 dark:border-teal-900/40 shadow-sm">
            <div class="flex items-center justify-between text-slate-400 dark:text-slate-500 mb-2">
                <span class="text-[11px] font-bold uppercase tracking-wider">Total Slots</span>
                <i class="fas fa-calendar-alt text-teal-500 text-sm"></i>
            </div>
            <div class="text-2xl font-black text-slate-900 dark:text-white">{{ $totalSlots }}</div>
            <div class="text-[10px] text-slate-400 mt-0.5">Configured windows</div>
        </div>

        <!-- Active Slots -->
        <div class="bg-white dark:bg-[#051210] p-4 rounded-2xl border border-slate-100 dark:border-teal-900/40 shadow-sm">
            <div class="flex items-center justify-between text-slate-400 dark:text-slate-500 mb-2">
                <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">Active</span>
                <span class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_8px_#10b981]"></span>
            </div>
            <div class="text-2xl font-black text-emerald-600 dark:text-emerald-400">{{ $activeSlots }}</div>
            <div class="text-[10px] text-slate-400 mt-0.5">Live on checkout</div>
        </div>

        <!-- Inactive Slots -->
        <div class="bg-white dark:bg-[#051210] p-4 rounded-2xl border border-slate-100 dark:border-teal-900/40 shadow-sm">
            <div class="flex items-center justify-between text-slate-400 dark:text-slate-500 mb-2">
                <span class="text-[11px] font-bold uppercase tracking-wider text-amber-600 dark:text-amber-400">Disabled</span>
                <i class="fas fa-pause-circle text-amber-500 text-sm"></i>
            </div>
            <div class="text-2xl font-black text-amber-600 dark:text-amber-400">{{ $inactiveSlots }}</div>
            <div class="text-[10px] text-slate-400 mt-0.5">Temporarily off</div>
        </div>

        <!-- Morning Slots -->
        <div class="bg-white dark:bg-[#051210] p-4 rounded-2xl border border-slate-100 dark:border-teal-900/40 shadow-sm">
            <div class="flex items-center justify-between text-slate-400 dark:text-slate-500 mb-2">
                <span class="text-[11px] font-bold uppercase tracking-wider">Morning</span>
                <i class="fas fa-cloud-sun text-amber-500 text-sm"></i>
            </div>
            <div class="text-2xl font-black text-slate-900 dark:text-white">{{ $morningCount }}</div>
            <div class="text-[10px] text-slate-400 mt-0.5">Early morning / fasting</div>
        </div>

        <!-- Afternoon Slots -->
        <div class="bg-white dark:bg-[#051210] p-4 rounded-2xl border border-slate-100 dark:border-teal-900/40 shadow-sm">
            <div class="flex items-center justify-between text-slate-400 dark:text-slate-500 mb-2">
                <span class="text-[11px] font-bold uppercase tracking-wider">Afternoon</span>
                <i class="fas fa-sun text-orange-500 text-sm"></i>
            </div>
            <div class="text-2xl font-black text-slate-900 dark:text-white">{{ $afternoonCount }}</div>
            <div class="text-[10px] text-slate-400 mt-0.5">12:00 PM - 05:00 PM</div>
        </div>

        <!-- Evening Slots -->
        <div class="bg-white dark:bg-[#051210] p-4 rounded-2xl border border-slate-100 dark:border-teal-900/40 shadow-sm">
            <div class="flex items-center justify-between text-slate-400 dark:text-slate-500 mb-2">
                <span class="text-[11px] font-bold uppercase tracking-wider">Evening</span>
                <i class="fas fa-moon text-indigo-500 text-sm"></i>
            </div>
            <div class="text-2xl font-black text-slate-900 dark:text-white">{{ $eveningCount }}</div>
            <div class="text-[10px] text-slate-400 mt-0.5">05:00 PM - 08:00 PM</div>
        </div>
    </div>

    <!-- Filters & Search Toolbar -->
    <div class="bg-white dark:bg-[#051210] p-4 rounded-2xl border border-slate-100 dark:border-teal-900/40 shadow-sm flex flex-col md:flex-row justify-between items-stretch md:items-center gap-4">
        <!-- Period Tabs -->
        <div class="flex items-center gap-1.5 overflow-x-auto pb-1 md:pb-0">
            <a href="{{ route('admin.slots.index', array_merge(request()->except('period', 'page'), [])) }}"
               class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all whitespace-nowrap {{ !request('period') ? 'bg-teal-500 text-white shadow-sm' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700' }}">
                All Slots ({{ $totalSlots }})
            </a>
            <a href="{{ route('admin.slots.index', array_merge(request()->except('period', 'page'), ['period' => 'morning'])) }}"
               class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all whitespace-nowrap flex items-center gap-1.5 {{ request('period') === 'morning' ? 'bg-amber-500 text-white shadow-sm' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700' }}">
                <i class="fas fa-cloud-sun text-[11px]"></i>
                <span>Morning ({{ $morningCount }})</span>
            </a>
            <a href="{{ route('admin.slots.index', array_merge(request()->except('period', 'page'), ['period' => 'afternoon'])) }}"
               class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all whitespace-nowrap flex items-center gap-1.5 {{ request('period') === 'afternoon' ? 'bg-orange-500 text-white shadow-sm' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700' }}">
                <i class="fas fa-sun text-[11px]"></i>
                <span>Afternoon ({{ $afternoonCount }})</span>
            </a>
            <a href="{{ route('admin.slots.index', array_merge(request()->except('period', 'page'), ['period' => 'evening'])) }}"
               class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all whitespace-nowrap flex items-center gap-1.5 {{ request('period') === 'evening' ? 'bg-indigo-500 text-white shadow-sm' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700' }}">
                <i class="fas fa-moon text-[11px]"></i>
                <span>Evening ({{ $eveningCount }})</span>
            </a>
        </div>

        <!-- Search & Status Filter Form -->
        <form method="GET" action="{{ route('admin.slots.index') }}" class="flex items-center gap-2 flex-wrap">
            @if(request('period'))
                <input type="hidden" name="period" value="{{ request('period') }}">
            @endif

            <select name="status" onchange="this.form.submit()" class="px-3 py-1.5 text-xs font-semibold bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-teal-900/40 rounded-xl text-slate-700 dark:text-slate-300 outline-none focus:ring-2 focus:ring-teal-500">
                <option value="">All Statuses</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active Only</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Disabled Only</option>
            </select>

            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search time slot..." class="pl-8 pr-3 py-1.5 text-xs font-medium bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-teal-900/40 rounded-xl text-slate-700 dark:text-slate-200 placeholder-slate-400 outline-none focus:ring-2 focus:ring-teal-500 w-44">
            </div>

            @if(request()->anyFilled(['search', 'status', 'period']))
                <a href="{{ route('admin.slots.index') }}" class="px-2.5 py-1.5 text-xs text-rose-500 hover:text-rose-600 font-bold" title="Reset Filters">
                    <i class="fas fa-times"></i>
                </a>
            @endif
        </form>
    </div>

    <!-- Slots Table -->
    <div class="bg-white dark:bg-[#051210] rounded-2xl shadow-sm border border-slate-100 dark:border-teal-900/40 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-900/60 text-slate-500 dark:text-slate-400 text-[11px] uppercase tracking-wider border-b border-slate-100 dark:border-teal-900/40">
                        <th class="px-5 py-3.5 font-bold">Order</th>
                        <th class="px-5 py-3.5 font-bold">Slot Time Window</th>
                        <th class="px-5 py-3.5 font-bold">Day Period</th>
                        <th class="px-5 py-3.5 font-bold">Start - End Time</th>
                        <th class="px-5 py-3.5 font-bold">Daily Limit</th>
                        <th class="px-5 py-3.5 font-bold">Today's Bookings</th>
                        <th class="px-5 py-3.5 font-bold text-center">Status</th>
                        <th class="px-5 py-3.5 font-bold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-teal-900/30 text-sm">
                    @forelse($slots as $slot)
                    @php
                        $todayCount = $todayBookingStats[$slot->title] ?? 0;
                        $isAtCap = $slot->max_bookings > 0 && $todayCount >= $slot->max_bookings;
                    @endphp
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-teal-900/10 transition-colors {{ !$slot->is_active ? 'opacity-65' : '' }}">
                        <!-- Sort Order -->
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 font-black text-xs">
                                #{{ $slot->sort_order }}
                            </span>
                        </td>

                        <!-- Title -->
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center {{ $slot->period === 'morning' ? 'bg-amber-500/10 text-amber-500' : ($slot->period === 'afternoon' ? 'bg-orange-500/10 text-orange-500' : 'bg-indigo-500/10 text-indigo-500') }}">
                                    <i class="{{ $slot->period_icon }} text-xs"></i>
                                </div>
                                <div>
                                    <span class="font-extrabold text-slate-900 dark:text-white block">{{ $slot->title }}</span>
                                    <span class="text-[10px] text-slate-400">ID: #{{ $slot->id }}</span>
                                </div>
                            </div>
                        </td>

                        <!-- Period Badge -->
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold border {{ $slot->period_badge_classes }}">
                                <i class="{{ $slot->period_icon }} text-[10px]"></i>
                                <span>{{ $slot->period_label }}</span>
                            </span>
                        </td>

                        <!-- 24-hr Time Values -->
                        <td class="px-5 py-4 text-xs font-semibold text-slate-600 dark:text-slate-300">
                            @if($slot->start_time && $slot->end_time)
                                <div class="font-mono text-[11px]">
                                    {{ substr($slot->start_time, 0, 5) }} &rarr; {{ substr($slot->end_time, 0, 5) }}
                                </div>
                            @else
                                <span class="text-slate-400 text-xs">N/A</span>
                            @endif
                        </td>

                        <!-- Max Bookings Limit -->
                        <td class="px-5 py-4">
                            @if($slot->max_bookings > 0)
                                <span class="inline-flex items-center gap-1 text-xs font-bold text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-slate-800 px-2 py-0.5 rounded">
                                    <i class="fas fa-users text-[10px] text-slate-400"></i> Max {{ $slot->max_bookings }}/day
                                </span>
                            @else
                                <span class="text-xs font-semibold text-teal-600 dark:text-teal-400">
                                    <i class="fas fa-infinity text-[10px] mr-1"></i> Unlimited
                                </span>
                            @endif
                        </td>

                        <!-- Today's Bookings Count -->
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2">
                                <span class="font-black text-xs {{ $todayCount > 0 ? 'text-teal-600 dark:text-teal-400' : 'text-slate-400' }}">
                                    {{ $todayCount }} booking(s)
                                </span>
                                @if($isAtCap)
                                    <span class="text-[10px] font-bold text-rose-500 bg-rose-500/10 px-1.5 py-0.5 rounded border border-rose-500/20">Full</span>
                                @endif
                            </div>
                        </td>

                        <!-- Active Toggle -->
                        <td class="px-5 py-4 text-center">
                            <form action="{{ route('admin.slots.toggle', $slot->id) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" 
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold transition cursor-pointer {{ $slot->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800/40 hover:bg-emerald-100' : 'bg-slate-100 text-slate-500 border border-slate-200 dark:bg-slate-800 dark:text-slate-400 dark:border-slate-700 hover:bg-slate-200' }}"
                                        title="Click to {{ $slot->is_active ? 'deactivate' : 'activate' }} slot">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $slot->is_active ? 'bg-emerald-500 shadow-[0_0_6px_#10b981]' : 'bg-slate-400' }}"></span>
                                    <span>{{ $slot->is_active ? 'Active' : 'Disabled' }}</span>
                                </button>
                            </form>
                        </td>

                        <!-- Actions -->
                        <td class="px-5 py-4 text-right">
                            <div class="inline-flex items-center gap-1">
                                <!-- Edit Button -->
                                <button type="button"
                                        class="edit-slot-btn p-2 text-slate-400 hover:text-teal-600 hover:bg-teal-50 dark:hover:bg-teal-900/20 rounded-xl transition cursor-pointer"
                                        data-slot='@json($slot)'
                                        title="Edit Slot">
                                    <i class="fas fa-edit text-xs"></i>
                                </button>

                                <!-- Delete Button -->
                                <button type="button"
                                        class="delete-slot-btn p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/20 rounded-xl transition cursor-pointer"
                                        data-id="{{ $slot->id }}"
                                        data-title="{{ $slot->title }}"
                                        title="Delete Slot">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-12">
                            <div class="max-w-sm mx-auto text-center space-y-3">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center mx-auto text-xl">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <h4 class="font-bold text-slate-800 dark:text-slate-200 text-sm">No Collection Slots Found</h4>
                                <p class="text-xs text-slate-500 dark:text-slate-400">No time slots match your current filter criteria or none have been created yet.</p>
                                <button onclick="openAddSlotModal()" class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-xs font-bold transition shadow-xs cursor-pointer">
                                    Create First Slot
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($slots->hasPages())
        <div class="p-4 border-t border-slate-100 dark:border-teal-900/40">
            {{ $slots->links() }}
        </div>
        @endif
    </div>

</div>

<!-- ══════════════════════ MODAL: ADD NEW SLOT ══════════════════════ -->
<div id="addSlotModal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white dark:bg-[#071916] rounded-3xl max-w-lg w-full border border-slate-200 dark:border-teal-900/50 shadow-2xl overflow-hidden animate-subtle-pulse-none">
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 dark:border-teal-900/40 bg-slate-50/50 dark:bg-slate-900/30">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-teal-500/10 text-teal-600 dark:text-teal-400 flex items-center justify-center font-bold">
                    <i class="fas fa-plus text-xs"></i>
                </div>
                <div>
                    <h3 class="font-black text-sm text-slate-900 dark:text-white">Add Collection Slot</h3>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400">Create a new time window for sample pickup</p>
                </div>
            </div>
            <button onclick="closeAddSlotModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-white p-1 cursor-pointer">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.slots.store') }}" method="POST" class="p-6 space-y-4">
            @csrf

            <!-- Day Period -->
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                    Period Group <span class="text-rose-500">*</span>
                </label>
                <div class="grid grid-cols-3 gap-2">
                    <label class="flex items-center justify-center gap-2 p-2.5 rounded-xl border border-slate-200 dark:border-teal-900/50 cursor-pointer hover:border-teal-500 has-checked:border-teal-500 has-checked:bg-teal-50 dark:has-checked:bg-teal-900/30 transition text-xs font-bold">
                        <input type="radio" name="period" value="morning" checked class="text-teal-600 focus:ring-teal-500">
                        <span>🌅 Morning</span>
                    </label>
                    <label class="flex items-center justify-center gap-2 p-2.5 rounded-xl border border-slate-200 dark:border-teal-900/50 cursor-pointer hover:border-teal-500 has-checked:border-teal-500 has-checked:bg-teal-50 dark:has-checked:bg-teal-900/30 transition text-xs font-bold">
                        <input type="radio" name="period" value="afternoon" class="text-teal-600 focus:ring-teal-500">
                        <span>☀️ Afternoon</span>
                    </label>
                    <label class="flex items-center justify-center gap-2 p-2.5 rounded-xl border border-slate-200 dark:border-teal-900/50 cursor-pointer hover:border-teal-500 has-checked:border-teal-500 has-checked:bg-teal-50 dark:has-checked:bg-teal-900/30 transition text-xs font-bold">
                        <input type="radio" name="period" value="evening" class="text-teal-600 focus:ring-teal-500">
                        <span>🌙 Evening</span>
                    </label>
                </div>
            </div>

            <!-- Start & End Time -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                        Start Time <span class="text-rose-500">*</span>
                    </label>
                    <input type="time" name="start_time" id="addStartTime" required onchange="autoGenerateTitle('add')" class="w-full px-3.5 py-2.5 text-xs font-bold bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-teal-900/50 rounded-xl outline-none focus:ring-2 focus:ring-teal-500 text-slate-900 dark:text-white">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                        End Time <span class="text-rose-500">*</span>
                    </label>
                    <input type="time" name="end_time" id="addEndTime" required onchange="autoGenerateTitle('add')" class="w-full px-3.5 py-2.5 text-xs font-bold bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-teal-900/50 rounded-xl outline-none focus:ring-2 focus:ring-teal-500 text-slate-900 dark:text-white">
                </div>
            </div>

            <!-- Title / Display Label -->
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                    Display Title <span class="text-slate-400 font-normal">(Auto-generated or custom)</span>
                </label>
                <input type="text" name="title" id="addTitle" placeholder="e.g. 07:00 AM - 08:00 AM" class="w-full px-3.5 py-2.5 text-xs font-bold bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-teal-900/50 rounded-xl outline-none focus:ring-2 focus:ring-teal-500 text-slate-900 dark:text-white">
                <span class="text-[10px] text-slate-400 mt-1 block">Shown directly to patients during booking checkout</span>
            </div>

            <!-- Max Bookings & Sort Order -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                        Daily Capacity Limit
                    </label>
                    <input type="number" name="max_bookings" value="0" min="0" placeholder="0 = Unlimited" class="w-full px-3.5 py-2.5 text-xs font-bold bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-teal-900/50 rounded-xl outline-none focus:ring-2 focus:ring-teal-500 text-slate-900 dark:text-white">
                    <span class="text-[10px] text-slate-400 mt-1 block">0 for unlimited bookings</span>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                        Sort Order
                    </label>
                    <input type="number" name="sort_order" value="{{ ($slots->max('sort_order') ?? 0) + 1 }}" min="0" class="w-full px-3.5 py-2.5 text-xs font-bold bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-teal-900/50 rounded-xl outline-none focus:ring-2 focus:ring-teal-500 text-slate-900 dark:text-white">
                    <span class="text-[10px] text-slate-400 mt-1 block">Position in checkout grid</span>
                </div>
            </div>

            <!-- Active Status Checkbox -->
            <div class="pt-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 rounded text-teal-600 focus:ring-teal-500 border-slate-300 dark:border-slate-700">
                    <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Enable this slot immediately</span>
                </label>
            </div>

            <!-- Footer Action Buttons -->
            <div class="flex items-center justify-end gap-2.5 pt-4 border-t border-slate-100 dark:border-teal-900/40">
                <button type="button" onclick="closeAddSlotModal()" class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition cursor-pointer">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold shadow-md shadow-teal-600/30 transition cursor-pointer">
                    Save Slot
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ══════════════════════ MODAL: EDIT SLOT ══════════════════════ -->
<div id="editSlotModal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white dark:bg-[#071916] rounded-3xl max-w-lg w-full border border-slate-200 dark:border-teal-900/50 shadow-2xl overflow-hidden">
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 dark:border-teal-900/40 bg-slate-50/50 dark:bg-slate-900/30">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-teal-500/10 text-teal-600 dark:text-teal-400 flex items-center justify-center font-bold">
                    <i class="fas fa-edit text-xs"></i>
                </div>
                <div>
                    <h3 class="font-black text-sm text-slate-900 dark:text-white">Edit Collection Slot</h3>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400">Modify time window parameters</p>
                </div>
            </div>
            <button onclick="closeEditSlotModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-white p-1 cursor-pointer">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>

        <!-- Form -->
        <form id="editSlotForm" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')

            <!-- Day Period -->
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                    Period Group <span class="text-rose-500">*</span>
                </label>
                <div class="grid grid-cols-3 gap-2">
                    <label class="flex items-center justify-center gap-2 p-2.5 rounded-xl border border-slate-200 dark:border-teal-900/50 cursor-pointer hover:border-teal-500 has-checked:border-teal-500 has-checked:bg-teal-50 dark:has-checked:bg-teal-900/30 transition text-xs font-bold">
                        <input type="radio" name="period" id="editPeriodMorning" value="morning" class="text-teal-600 focus:ring-teal-500">
                        <span>🌅 Morning</span>
                    </label>
                    <label class="flex items-center justify-center gap-2 p-2.5 rounded-xl border border-slate-200 dark:border-teal-900/50 cursor-pointer hover:border-teal-500 has-checked:border-teal-500 has-checked:bg-teal-50 dark:has-checked:bg-teal-900/30 transition text-xs font-bold">
                        <input type="radio" name="period" id="editPeriodAfternoon" value="afternoon" class="text-teal-600 focus:ring-teal-500">
                        <span>☀️ Afternoon</span>
                    </label>
                    <label class="flex items-center justify-center gap-2 p-2.5 rounded-xl border border-slate-200 dark:border-teal-900/50 cursor-pointer hover:border-teal-500 has-checked:border-teal-500 has-checked:bg-teal-50 dark:has-checked:bg-teal-900/30 transition text-xs font-bold">
                        <input type="radio" name="period" id="editPeriodEvening" value="evening" class="text-teal-600 focus:ring-teal-500">
                        <span>🌙 Evening</span>
                    </label>
                </div>
            </div>

            <!-- Start & End Time -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                        Start Time
                    </label>
                    <input type="time" name="start_time" id="editStartTime" onchange="autoGenerateTitle('edit')" class="w-full px-3.5 py-2.5 text-xs font-bold bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-teal-900/50 rounded-xl outline-none focus:ring-2 focus:ring-teal-500 text-slate-900 dark:text-white">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                        End Time
                    </label>
                    <input type="time" name="end_time" id="editEndTime" onchange="autoGenerateTitle('edit')" class="w-full px-3.5 py-2.5 text-xs font-bold bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-teal-900/50 rounded-xl outline-none focus:ring-2 focus:ring-teal-500 text-slate-900 dark:text-white">
                </div>
            </div>

            <!-- Title / Display Label -->
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                    Display Title <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="title" id="editTitle" required class="w-full px-3.5 py-2.5 text-xs font-bold bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-teal-900/50 rounded-xl outline-none focus:ring-2 focus:ring-teal-500 text-slate-900 dark:text-white">
            </div>

            <!-- Max Bookings & Sort Order -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                        Daily Capacity Limit
                    </label>
                    <input type="number" name="max_bookings" id="editMaxBookings" min="0" placeholder="0 = Unlimited" class="w-full px-3.5 py-2.5 text-xs font-bold bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-teal-900/50 rounded-xl outline-none focus:ring-2 focus:ring-teal-500 text-slate-900 dark:text-white">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                        Sort Order
                    </label>
                    <input type="number" name="sort_order" id="editSortOrder" min="0" class="w-full px-3.5 py-2.5 text-xs font-bold bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-teal-900/50 rounded-xl outline-none focus:ring-2 focus:ring-teal-500 text-slate-900 dark:text-white">
                </div>
            </div>

            <!-- Active Status Checkbox -->
            <div class="pt-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" id="editIsActive" value="1" class="w-4 h-4 rounded text-teal-600 focus:ring-teal-500 border-slate-300 dark:border-slate-700">
                    <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Active (Visible in checkout)</span>
                </label>
            </div>

            <!-- Footer Action Buttons -->
            <div class="flex items-center justify-end gap-2.5 pt-4 border-t border-slate-100 dark:border-teal-900/40">
                <button type="button" onclick="closeEditSlotModal()" class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition cursor-pointer">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold shadow-md shadow-teal-600/30 transition cursor-pointer">
                    Update Slot
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ══════════════════════ MODAL: DELETE CONFIRMATION ══════════════════════ -->
<div id="deleteSlotModal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white dark:bg-[#071916] rounded-3xl max-w-sm w-full border border-slate-200 dark:border-teal-900/50 shadow-2xl overflow-hidden p-6 text-center space-y-4">
        <div class="w-12 h-12 rounded-2xl bg-rose-50 dark:bg-rose-950/40 text-rose-600 flex items-center justify-center mx-auto text-xl">
            <i class="fas fa-trash-alt"></i>
        </div>
        <div>
            <h3 class="font-bold text-slate-900 dark:text-white text-base">Delete Collection Slot?</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                Are you sure you want to remove slot <strong id="deleteSlotTitle" class="text-slate-800 dark:text-slate-200"></strong>? Existing booking history will remain intact.
            </p>
        </div>
        <form id="deleteSlotForm" method="POST" class="flex items-center justify-center gap-3 pt-2">
            @csrf
            @method('DELETE')
            <button type="button" onclick="closeDeleteSlotModal()" class="px-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition cursor-pointer">
                Cancel
            </button>
            <button type="submit" class="px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold shadow-md shadow-rose-600/30 transition cursor-pointer">
                Yes, Delete
            </button>
        </form>
    </div>
</div>

<!-- Modal Handling Scripts -->
<script>
    function openAddSlotModal() {
        document.getElementById('addSlotModal').classList.remove('hidden');
    }

    function closeAddSlotModal() {
        document.getElementById('addSlotModal').classList.add('hidden');
    }

    function openEditSlotModal(slot) {
        const form = document.getElementById('editSlotForm');
        form.action = `/admin/slots/${slot.id}`;

        document.getElementById('editTitle').value = slot.title || '';
        document.getElementById('editStartTime').value = slot.start_time ? slot.start_time.substring(0, 5) : '';
        document.getElementById('editEndTime').value = slot.end_time ? slot.end_time.substring(0, 5) : '';
        document.getElementById('editMaxBookings').value = slot.max_bookings || 0;
        document.getElementById('editSortOrder').value = slot.sort_order || 0;
        document.getElementById('editIsActive').checked = !!slot.is_active;

        if (slot.period === 'morning') {
            document.getElementById('editPeriodMorning').checked = true;
        } else if (slot.period === 'afternoon') {
            document.getElementById('editPeriodAfternoon').checked = true;
        } else if (slot.period === 'evening') {
            document.getElementById('editPeriodEvening').checked = true;
        }

        document.getElementById('editSlotModal').classList.remove('hidden');
    }

    function closeEditSlotModal() {
        document.getElementById('editSlotModal').classList.add('hidden');
    }

    function openDeleteSlotModal(slotId, slotTitle) {
        document.getElementById('deleteSlotForm').action = `/admin/slots/${slotId}`;
        document.getElementById('deleteSlotTitle').innerText = slotTitle;
        document.getElementById('deleteSlotModal').classList.remove('hidden');
    }

    function closeDeleteSlotModal() {
        document.getElementById('deleteSlotModal').classList.add('hidden');
    }

    // Helper: auto format 24-hr time to 12-hr AM/PM string
    function formatTime12h(timeStr) {
        if (!timeStr) return '';
        const parts = timeStr.split(':');
        let hours = parseInt(parts[0], 10);
        const minutes = parts[1] || '00';
        const ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12; // 0 becomes 12
        const hoursPadded = hours < 10 ? '0' + hours : hours;
        return `${hoursPadded}:${minutes} ${ampm}`;
    }

    function autoGenerateTitle(prefix) {
        const startVal = document.getElementById(prefix + 'StartTime').value;
        const endVal = document.getElementById(prefix + 'EndTime').value;
        const titleInput = document.getElementById(prefix + 'Title');

        if (startVal && endVal && (!titleInput.value || titleInput.value.includes('-'))) {
            titleInput.value = `${formatTime12h(startVal)} - ${formatTime12h(endVal)}`;
        }
    }

    // Bind click events to edit and delete buttons
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.edit-slot-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                try {
                    const slotData = JSON.parse(btn.getAttribute('data-slot'));
                    openEditSlotModal(slotData);
                } catch (e) {
                    console.error('Failed to parse slot data', e);
                }
            });
        });

        document.querySelectorAll('.delete-slot-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.getAttribute('data-id');
                const title = btn.getAttribute('data-title');
                openDeleteSlotModal(id, title);
            });
        });
    });

    // Close modals on clicking outside / Esc key
    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeAddSlotModal();
            closeEditSlotModal();
            closeDeleteSlotModal();
        }
    });
</script>
@endsection
