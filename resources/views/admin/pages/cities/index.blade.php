@extends('admin.layouts.app')

@section('title', 'Serviceable Cities & Pincodes')
@section('header', 'City & Pincode Management')

@section('content')
<div class="space-y-6">

    <!-- Top Action Bar -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white dark:bg-[#051210] p-5 rounded-2xl border border-slate-100 dark:border-teal-900/40 shadow-sm">
        <div class="space-y-1">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-teal-500/10 text-teal-600 dark:text-teal-400 flex items-center justify-center font-bold">
                    <i class="fas fa-map-marked-alt text-base"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white">Serviceable Cities & Pincodes</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Control active operational areas, doorstep sample pickup pincodes, and website city dropdown</p>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-2.5 flex-wrap">
            <button onclick="openAddCityModal()" class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-500 hover:to-emerald-500 text-white text-xs font-bold shadow-md shadow-teal-600/30 transition-all flex items-center gap-2 cursor-pointer">
                <i class="fas fa-plus"></i>
                <span>Add New City</span>
            </button>
        </div>
    </div>

    <!-- Stat Summary Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3.5">
        <!-- Total Cities -->
        <div class="bg-white dark:bg-[#051210] p-4 rounded-2xl border border-slate-100 dark:border-teal-900/40 shadow-sm">
            <div class="flex items-center justify-between text-slate-400 dark:text-slate-500 mb-2">
                <span class="text-[11px] font-bold uppercase tracking-wider">Total Cities</span>
                <i class="fas fa-city text-teal-500 text-sm"></i>
            </div>
            <div class="text-2xl font-black text-slate-900 dark:text-white">{{ $totalCities }}</div>
            <div class="text-[10px] text-slate-400 mt-0.5">Configured locations</div>
        </div>

        <!-- Active Cities -->
        <div class="bg-white dark:bg-[#051210] p-4 rounded-2xl border border-slate-100 dark:border-teal-900/40 shadow-sm">
            <div class="flex items-center justify-between text-slate-400 dark:text-slate-500 mb-2">
                <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">Active</span>
                <span class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_8px_#10b981]"></span>
            </div>
            <div class="text-2xl font-black text-emerald-600 dark:text-emerald-400">{{ $activeCities }}</div>
            <div class="text-[10px] text-slate-400 mt-0.5">Available for patients</div>
        </div>

        <!-- Inactive Cities -->
        <div class="bg-white dark:bg-[#051210] p-4 rounded-2xl border border-slate-100 dark:border-teal-900/40 shadow-sm">
            <div class="flex items-center justify-between text-slate-400 dark:text-slate-500 mb-2">
                <span class="text-[11px] font-bold uppercase tracking-wider text-amber-600 dark:text-amber-400">Disabled</span>
                <i class="fas fa-pause-circle text-amber-500 text-sm"></i>
            </div>
            <div class="text-2xl font-black text-amber-600 dark:text-amber-400">{{ $inactiveCities }}</div>
            <div class="text-[10px] text-slate-400 mt-0.5">Service paused</div>
        </div>

        <!-- Total Pincodes Covered -->
        <div class="bg-white dark:bg-[#051210] p-4 rounded-2xl border border-slate-100 dark:border-teal-900/40 shadow-sm">
            <div class="flex items-center justify-between text-slate-400 dark:text-slate-500 mb-2">
                <span class="text-[11px] font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">Pincodes</span>
                <i class="fas fa-mail-bulk text-indigo-500 text-sm"></i>
            </div>
            <div class="text-2xl font-black text-indigo-600 dark:text-indigo-400">{{ $totalPincodesCovered }}</div>
            <div class="text-[10px] text-slate-400 mt-0.5">Serviceable postal codes</div>
        </div>

        <!-- Default Location -->
        <div class="bg-white dark:bg-[#051210] p-4 rounded-2xl border border-slate-100 dark:border-teal-900/40 shadow-sm col-span-2 sm:col-span-1">
            <div class="flex items-center justify-between text-slate-400 dark:text-slate-500 mb-2">
                <span class="text-[11px] font-bold uppercase tracking-wider text-amber-600 dark:text-amber-400">Default City</span>
                <i class="fas fa-star text-amber-400 text-sm"></i>
            </div>
            <div class="text-lg font-black text-slate-900 dark:text-white truncate">
                {{ $defaultCity?->name ?? 'None' }}
            </div>
            <div class="text-[10px] text-slate-400 mt-0.5">{{ $defaultCity?->state ?? 'Default landing' }}</div>
        </div>
    </div>

    <!-- Filters & Search Toolbar -->
    <div class="bg-white dark:bg-[#051210] p-4 rounded-2xl border border-slate-100 dark:border-teal-900/40 shadow-sm flex flex-col md:flex-row justify-between items-stretch md:items-center gap-4">
        <!-- Quick State / Status Pills -->
        <div class="flex items-center gap-1.5 overflow-x-auto pb-1 md:pb-0">
            <a href="{{ route('admin.cities.index', array_merge(request()->except('state', 'page'), [])) }}"
               class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all whitespace-nowrap {{ !request('state') ? 'bg-teal-500 text-white shadow-sm' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700' }}">
                All Locations ({{ $totalCities }})
            </a>
            @foreach($statesList as $stateName)
                <a href="{{ route('admin.cities.index', array_merge(request()->except('state', 'page'), ['state' => $stateName])) }}"
                   class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all whitespace-nowrap {{ request('state') === $stateName ? 'bg-teal-600 text-white shadow-sm' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700' }}">
                    {{ $stateName }}
                </a>
            @endforeach
        </div>

        <!-- Search & Filter Form -->
        <form method="GET" action="{{ route('admin.cities.index') }}" class="flex items-center gap-2 flex-wrap">
            @if(request('state'))
                <input type="hidden" name="state" value="{{ request('state') }}">
            @endif

            <select name="status" onchange="this.form.submit()" class="px-3 py-1.5 text-xs font-semibold bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-teal-900/40 rounded-xl text-slate-700 dark:text-slate-300 outline-none focus:ring-2 focus:ring-teal-500">
                <option value="">All Statuses</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active Only</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Disabled Only</option>
            </select>

            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search city or pincode..." class="pl-8 pr-3 py-1.5 text-xs font-medium bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-teal-900/40 rounded-xl text-slate-700 dark:text-slate-200 placeholder-slate-400 outline-none focus:ring-2 focus:ring-teal-500 w-48">
            </div>

            @if(request()->anyFilled(['search', 'status', 'state']))
                <a href="{{ route('admin.cities.index') }}" class="px-2.5 py-1.5 text-xs text-rose-500 hover:text-rose-600 font-bold" title="Reset Filters">
                    <i class="fas fa-times"></i>
                </a>
            @endif
        </form>
    </div>

    <!-- Cities Table -->
    <div class="bg-white dark:bg-[#051210] rounded-2xl shadow-sm border border-slate-100 dark:border-teal-900/40 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-900/60 text-slate-500 dark:text-slate-400 text-[11px] uppercase tracking-wider border-b border-slate-100 dark:border-teal-900/40">
                        <th class="px-5 py-3.5 font-bold">Order</th>
                        <th class="px-5 py-3.5 font-bold">City & State</th>
                        <th class="px-5 py-3.5 font-bold">Serviceable Pincodes</th>
                        <th class="px-5 py-3.5 font-bold text-center">Default</th>
                        <th class="px-5 py-3.5 font-bold text-center">Status</th>
                        <th class="px-5 py-3.5 font-bold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-teal-900/30 text-sm">
                    @forelse($cities as $city)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-teal-900/10 transition-colors {{ !$city->is_active ? 'opacity-65' : '' }}">
                        <!-- Order -->
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 font-black text-xs">
                                #{{ $city->sort_order }}
                            </span>
                        </td>

                        <!-- City Name & State -->
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2.5">
                                <div class="w-9 h-9 rounded-xl bg-teal-500/10 text-teal-600 dark:text-teal-400 flex items-center justify-center font-bold">
                                    <i class="fas fa-map-marker-alt text-sm"></i>
                                </div>
                                <div>
                                    <div class="flex items-center gap-1.5">
                                        <span class="font-extrabold text-slate-900 dark:text-white text-sm">{{ $city->name }}</span>
                                        @if($city->is_default)
                                            <span class="px-1.5 py-0.5 rounded text-[9px] font-black uppercase tracking-wider bg-amber-100 text-amber-800 dark:bg-amber-950/40 dark:text-amber-400 border border-amber-300 dark:border-amber-800/40">
                                                <i class="fas fa-star text-[8px] mr-0.5"></i> Default
                                            </span>
                                        @endif
                                    </div>
                                    <span class="text-xs text-slate-400 block">{{ $city->state ?: 'State not specified' }}</span>
                                </div>
                            </div>
                        </td>

                        <!-- Pincodes Chips -->
                        <td class="px-5 py-4">
                            <div class="space-y-1 max-w-md">
                                <div class="flex items-center gap-1.5 flex-wrap">
                                    @php
                                        $pinList = $city->pincode_list;
                                        $displayPins = array_slice($pinList, 0, 7);
                                        $remainingCount = count($pinList) - count($displayPins);
                                    @endphp

                                    @forelse($displayPins as $pin)
                                        <span class="px-2 py-0.5 rounded-md text-[11px] font-mono font-bold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 border border-slate-200 dark:border-teal-900/50">
                                            {{ $pin }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-slate-400 italic">No pincodes configured</span>
                                    @endforelse

                                    @if($remainingCount > 0)
                                        <span class="px-2 py-0.5 rounded-md text-[11px] font-bold bg-teal-50 dark:bg-teal-900/30 text-teal-700 dark:text-teal-300 border border-teal-200 dark:border-teal-800/50" title="{{ implode(', ', array_slice($pinList, 7)) }}">
                                            +{{ $remainingCount }} more
                                        </span>
                                    @endif
                                </div>
                                <span class="text-[10px] text-slate-400 block font-semibold">Total: {{ count($pinList) }} covered pincode(s)</span>
                            </div>
                        </td>

                        <!-- Make Default Button / Badge -->
                        <td class="px-5 py-4 text-center">
                            @if($city->is_default)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200 dark:bg-amber-900/30 dark:text-amber-400 dark:border-amber-800/40">
                                    <i class="fas fa-check-circle text-xs"></i> Default
                                </span>
                            @else
                                <form action="{{ route('admin.cities.set_default', $city->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="px-2.5 py-1 rounded-xl text-xs font-semibold text-slate-500 hover:text-amber-700 hover:bg-amber-50 dark:hover:bg-amber-900/20 border border-transparent hover:border-amber-200 transition cursor-pointer" title="Set as default landing city">
                                        Set as Default
                                    </button>
                                </form>
                            @endif
                        </td>

                        <!-- Active Toggle -->
                        <td class="px-5 py-4 text-center">
                            <form action="{{ route('admin.cities.toggle', $city->id) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" 
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold transition cursor-pointer {{ $city->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800/40 hover:bg-emerald-100' : 'bg-slate-100 text-slate-500 border border-slate-200 dark:bg-slate-800 dark:text-slate-400 dark:border-slate-700 hover:bg-slate-200' }}"
                                        title="Click to toggle status">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $city->is_active ? 'bg-emerald-500 shadow-[0_0_6px_#10b981]' : 'bg-slate-400' }}"></span>
                                    <span>{{ $city->is_active ? 'Active' : 'Disabled' }}</span>
                                </button>
                            </form>
                        </td>

                        <!-- Actions -->
                        <td class="px-5 py-4 text-right">
                            <div class="inline-flex items-center gap-1">
                                <!-- Edit Button -->
                                <button type="button"
                                        class="edit-city-btn p-2 text-slate-400 hover:text-teal-600 hover:bg-teal-50 dark:hover:bg-teal-900/20 rounded-xl transition cursor-pointer"
                                        data-city='@json($city)'
                                        title="Edit City">
                                    <i class="fas fa-edit text-xs"></i>
                                </button>

                                <!-- Delete Button -->
                                <button type="button"
                                        class="delete-city-btn p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/20 rounded-xl transition cursor-pointer"
                                        data-id="{{ $city->id }}"
                                        data-name="{{ $city->name }}"
                                        title="Delete City">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-12">
                            <div class="max-w-sm mx-auto text-center space-y-3">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center mx-auto text-xl">
                                    <i class="fas fa-map-marked-alt"></i>
                                </div>
                                <h4 class="font-bold text-slate-800 dark:text-slate-200 text-sm">No Cities Found</h4>
                                <p class="text-xs text-slate-500 dark:text-slate-400">No cities match your current search criteria or none have been added yet.</p>
                                <button onclick="openAddCityModal()" class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-xs font-bold transition shadow-xs cursor-pointer">
                                    Add First City
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($cities->hasPages())
        <div class="p-4 border-t border-slate-100 dark:border-teal-900/40">
            {{ $cities->links() }}
        </div>
        @endif
    </div>

</div>

<!-- ══════════════════════ MODAL: ADD NEW CITY ══════════════════════ -->
<div id="addCityModal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white dark:bg-[#071916] rounded-3xl max-w-lg w-full border border-slate-200 dark:border-teal-900/50 shadow-2xl overflow-hidden">
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 dark:border-teal-900/40 bg-slate-50/50 dark:bg-slate-900/30">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-teal-500/10 text-teal-600 dark:text-teal-400 flex items-center justify-center font-bold">
                    <i class="fas fa-plus text-xs"></i>
                </div>
                <div>
                    <h3 class="font-black text-sm text-slate-900 dark:text-white">Add Serviceable City</h3>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400">Configure operational city and pincodes</p>
                </div>
            </div>
            <button onclick="closeAddCityModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-white p-1 cursor-pointer">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.cities.store') }}" method="POST" class="p-6 space-y-4">
            @csrf

            <!-- City Name & State -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                        City Name <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="name" required placeholder="e.g. Patna, Gaya, Delhi" class="w-full px-3.5 py-2.5 text-xs font-bold bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-teal-900/50 rounded-xl outline-none focus:ring-2 focus:ring-teal-500 text-slate-900 dark:text-white">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                        State / Region
                    </label>
                    <input type="text" name="state" placeholder="e.g. Bihar, Jharkhand" class="w-full px-3.5 py-2.5 text-xs font-bold bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-teal-900/50 rounded-xl outline-none focus:ring-2 focus:ring-teal-500 text-slate-900 dark:text-white">
                </div>
            </div>

            <!-- Serviceable Pincodes -->
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                    Serviceable Pincodes <span class="text-slate-400 font-normal">(Comma or newline separated)</span>
                </label>
                <textarea name="pincodes" rows="4" placeholder="800001, 800002, 800003, 800004..." class="w-full px-3.5 py-2.5 text-xs font-mono bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-teal-900/50 rounded-xl outline-none focus:ring-2 focus:ring-teal-500 text-slate-900 dark:text-white"></textarea>
                <span class="text-[10px] text-slate-400 mt-1 block">These pincodes will be shown in the city dropdown and verified during checkout</span>
            </div>

            <!-- Sort Order & Default -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                        Sort Order
                    </label>
                    <input type="number" name="sort_order" value="{{ ($cities->max('sort_order') ?? 0) + 1 }}" min="0" class="w-full px-3.5 py-2.5 text-xs font-bold bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-teal-900/50 rounded-xl outline-none focus:ring-2 focus:ring-teal-500 text-slate-900 dark:text-white">
                </div>
                <div class="flex flex-col justify-end pb-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_default" value="1" class="w-4 h-4 rounded text-teal-600 focus:ring-teal-500 border-slate-300 dark:border-slate-700">
                        <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Set as Default City</span>
                    </label>
                </div>
            </div>

            <!-- Active Checkbox -->
            <div>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 rounded text-teal-600 focus:ring-teal-500 border-slate-300 dark:border-slate-700">
                    <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Active (Visible in header & checkout)</span>
                </label>
            </div>

            <!-- Footer Action Buttons -->
            <div class="flex items-center justify-end gap-2.5 pt-4 border-t border-slate-100 dark:border-teal-900/40">
                <button type="button" onclick="closeAddCityModal()" class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition cursor-pointer">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold shadow-md shadow-teal-600/30 transition cursor-pointer">
                    Save City
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ══════════════════════ MODAL: EDIT CITY ══════════════════════ -->
<div id="editCityModal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white dark:bg-[#071916] rounded-3xl max-w-lg w-full border border-slate-200 dark:border-teal-900/50 shadow-2xl overflow-hidden">
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 dark:border-teal-900/40 bg-slate-50/50 dark:bg-slate-900/30">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-teal-500/10 text-teal-600 dark:text-teal-400 flex items-center justify-center font-bold">
                    <i class="fas fa-edit text-xs"></i>
                </div>
                <div>
                    <h3 class="font-black text-sm text-slate-900 dark:text-white">Edit Serviceable City</h3>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400">Modify city name and covered postal pincodes</p>
                </div>
            </div>
            <button onclick="closeEditCityModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-white p-1 cursor-pointer">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>

        <!-- Form -->
        <form id="editCityForm" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')

            <!-- City Name & State -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                        City Name <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="name" id="editCityName" required class="w-full px-3.5 py-2.5 text-xs font-bold bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-teal-900/50 rounded-xl outline-none focus:ring-2 focus:ring-teal-500 text-slate-900 dark:text-white">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                        State / Region
                    </label>
                    <input type="text" name="state" id="editCityState" class="w-full px-3.5 py-2.5 text-xs font-bold bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-teal-900/50 rounded-xl outline-none focus:ring-2 focus:ring-teal-500 text-slate-900 dark:text-white">
                </div>
            </div>

            <!-- Serviceable Pincodes -->
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                    Serviceable Pincodes <span class="text-slate-400 font-normal">(Comma or newline separated)</span>
                </label>
                <textarea name="pincodes" id="editCityPincodes" rows="4" class="w-full px-3.5 py-2.5 text-xs font-mono bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-teal-900/50 rounded-xl outline-none focus:ring-2 focus:ring-teal-500 text-slate-900 dark:text-white"></textarea>
            </div>

            <!-- Sort Order & Default -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                        Sort Order
                    </label>
                    <input type="number" name="sort_order" id="editCitySortOrder" min="0" class="w-full px-3.5 py-2.5 text-xs font-bold bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-teal-900/50 rounded-xl outline-none focus:ring-2 focus:ring-teal-500 text-slate-900 dark:text-white">
                </div>
                <div class="flex flex-col justify-end pb-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_default" id="editCityIsDefault" value="1" class="w-4 h-4 rounded text-teal-600 focus:ring-teal-500 border-slate-300 dark:border-slate-700">
                        <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Default City</span>
                    </label>
                </div>
            </div>

            <!-- Active Checkbox -->
            <div>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" id="editCityIsActive" value="1" class="w-4 h-4 rounded text-teal-600 focus:ring-teal-500 border-slate-300 dark:border-slate-700">
                    <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Active</span>
                </label>
            </div>

            <!-- Footer Action Buttons -->
            <div class="flex items-center justify-end gap-2.5 pt-4 border-t border-slate-100 dark:border-teal-900/40">
                <button type="button" onclick="closeEditCityModal()" class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition cursor-pointer">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold shadow-md shadow-teal-600/30 transition cursor-pointer">
                    Update City
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ══════════════════════ MODAL: DELETE CITY ══════════════════════ -->
<div id="deleteCityModal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white dark:bg-[#071916] rounded-3xl max-w-sm w-full border border-slate-200 dark:border-teal-900/50 shadow-2xl overflow-hidden p-6 text-center space-y-4">
        <div class="w-12 h-12 rounded-2xl bg-rose-50 dark:bg-rose-950/40 text-rose-600 flex items-center justify-center mx-auto text-xl">
            <i class="fas fa-trash-alt"></i>
        </div>
        <div>
            <h3 class="font-bold text-slate-900 dark:text-white text-base">Delete City?</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                Are you sure you want to remove <strong id="deleteCityName" class="text-slate-800 dark:text-slate-200"></strong>? Its pincodes will no longer be serviced.
            </p>
        </div>
        <form id="deleteCityForm" method="POST" class="flex items-center justify-center gap-3 pt-2">
            @csrf
            @method('DELETE')
            <button type="button" onclick="closeDeleteCityModal()" class="px-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition cursor-pointer">
                Cancel
            </button>
            <button type="submit" class="px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold shadow-md shadow-rose-600/30 transition cursor-pointer">
                Yes, Delete
            </button>
        </form>
    </div>
</div>

<!-- Scripts -->
<script>
    function openAddCityModal() {
        document.getElementById('addCityModal').classList.remove('hidden');
    }

    function closeAddCityModal() {
        document.getElementById('addCityModal').classList.add('hidden');
    }

    function openEditCityModal(city) {
        const form = document.getElementById('editCityForm');
        form.action = `/admin/cities/${city.id}`;

        document.getElementById('editCityName').value = city.name || '';
        document.getElementById('editCityState').value = city.state || '';
        document.getElementById('editCityPincodes').value = city.pincodes || '';
        document.getElementById('editCitySortOrder').value = city.sort_order || 0;
        document.getElementById('editCityIsDefault').checked = !!city.is_default;
        document.getElementById('editCityIsActive').checked = !!city.is_active;

        document.getElementById('editCityModal').classList.remove('hidden');
    }

    function closeEditCityModal() {
        document.getElementById('editCityModal').classList.add('hidden');
    }

    function openDeleteCityModal(cityId, cityName) {
        document.getElementById('deleteCityForm').action = `/admin/cities/${cityId}`;
        document.getElementById('deleteCityName').innerText = cityName;
        document.getElementById('deleteCityModal').classList.remove('hidden');
    }

    function closeDeleteCityModal() {
        document.getElementById('deleteCityModal').classList.add('hidden');
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.edit-city-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                try {
                    const cityData = JSON.parse(btn.getAttribute('data-city'));
                    openEditCityModal(cityData);
                } catch (e) {
                    console.error('Failed to parse city data', e);
                }
            });
        });

        document.querySelectorAll('.delete-city-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.getAttribute('data-id');
                const name = btn.getAttribute('data-name');
                openDeleteCityModal(id, name);
            });
        });
    });

    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeAddCityModal();
            closeEditCityModal();
            closeDeleteCityModal();
        }
    });
</script>
@endsection
