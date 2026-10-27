@extends('admin.layouts.app')

@section('title', 'Phlebotomists & Field Agents')
@section('header', 'Phlebotomist & Sample Collector Management')

@section('content')
<div class="space-y-6">

    <!-- Top Action Bar & Summary -->
    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-black bg-indigo-50 text-indigo-700 uppercase tracking-wide">Area Auto-Assignment & Roster</span>
                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-black bg-emerald-50 text-emerald-700 uppercase tracking-wide">Ojaselab LIS Integrated</span>
            </div>
            <h2 class="text-xl font-black text-slate-900 mt-1">Phlebotomists & Sample Collectors</h2>
            <p class="text-xs text-slate-500 mt-0.5">Manage area-wise serviceable pincodes, time slot capacity, weekly offs, and leave schedules for auto-assignment</p>
        </div>
        <div class="flex items-center gap-2 flex-wrap">
            <button onclick="document.getElementById('addAgentModal').classList.remove('hidden')" class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white text-xs font-bold shadow-md shadow-indigo-600/30 transition-all flex items-center gap-2 cursor-pointer">
                <i class="fas fa-user-plus"></i>
                <span>Add Phlebotomist</span>
            </button>
        </div>
    </div>

    <!-- Agents Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-[11px] uppercase tracking-wider border-b border-slate-100">
                        <th class="px-5 py-4 font-bold">Phlebotomist</th>
                        <th class="px-5 py-4 font-bold">Serviceable Pincodes</th>
                        <th class="px-5 py-4 font-bold">Slot Capacity</th>
                        <th class="px-5 py-4 font-bold">Weekly Offs & Leaves</th>
                        <th class="px-5 py-4 font-bold">Active Tasks</th>
                        <th class="px-5 py-4 font-bold">Status</th>
                        <th class="px-5 py-4 font-bold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($agents as $agent)
                    @php
                        $pincodes = $agent->pincode_list;
                        $weeklyOffs = is_array($agent->weekly_offs) ? $agent->weekly_offs : [];
                        $isOffToday = $agent->isOnLeave(now()->format('Y-m-d'));
                    @endphp
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <!-- Phlebotomist Details -->
                        <td class="px-5 py-4">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-50 to-indigo-100 text-indigo-700 flex items-center justify-center font-black text-sm flex-shrink-0 shadow-xs border border-indigo-200/50">
                                    {{ strtoupper(substr($agent->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <div class="flex items-center gap-1.5 flex-wrap">
                                        <span class="font-black text-slate-900 block truncate">{{ $agent->name }}</span>
                                        @if($isOffToday)
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-rose-100 text-rose-800" title="Phlebotomist is off-duty today">
                                                <i class="fas fa-bed text-[9px] mr-1"></i> Off Today
                                            </span>
                                        @endif
                                    </div>
                                    <div class="text-xs text-slate-500 space-y-0.5 mt-0.5">
                                        <a href="tel:{{ $agent->phone }}" class="hover:text-indigo-600 block text-[11px] font-semibold text-slate-700">
                                            <i class="fas fa-phone-alt text-slate-400 mr-1 text-[10px]"></i>{{ $agent->phone }}
                                        </a>
                                        <span class="block text-[11px] text-slate-500 truncate max-w-[200px]">
                                            <i class="fas fa-envelope text-slate-400 mr-1 text-[10px]"></i>{{ $agent->email }}
                                        </span>
                                    </div>
                                    @if($agent->lis_collector_id)
                                        <div class="mt-1">
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-purple-50 text-purple-700 text-[10px] font-mono font-bold border border-purple-200/60" title="Ojaselab LIS Staff / Collector ID">
                                                <i class="fas fa-network-wired text-[9px]"></i> LIS: {{ $agent->lis_collector_id }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <!-- Serviceable Pincodes -->
                        <td class="px-5 py-4">
                            @if(empty($pincodes))
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200/60" title="No specific pincodes assigned. Acts as global fallback pool.">
                                    <i class="fas fa-globe text-[10px]"></i> All Areas (Fallback)
                                </span>
                            @elseif(in_array('*', $pincodes) || in_array('all', array_map('strtolower', $pincodes)))
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200/60">
                                    <i class="fas fa-globe text-[10px]"></i> All Areas (*)
                                </span>
                            @else
                                <div class="flex flex-wrap gap-1 max-w-[240px]">
                                    @foreach(array_slice($pincodes, 0, 4) as $pin)
                                        <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-800 text-[11px] font-bold font-mono border border-slate-200">
                                            {{ $pin }}
                                        </span>
                                    @endforeach
                                    @if(count($pincodes) > 4)
                                        <span class="px-1.5 py-0.5 rounded-md bg-indigo-50 text-indigo-700 text-[10px] font-extrabold" title="{{ implode(', ', $pincodes) }}">
                                            +{{ count($pincodes) - 4 }} more
                                        </span>
                                    @endif
                                </div>
                            @endif
                            @if($agent->city)
                                <span class="text-[11px] text-slate-400 block mt-1"><i class="fas fa-city mr-1 text-[10px]"></i>{{ $agent->city }}</span>
                            @endif
                        </td>

                        <!-- Slot Capacity -->
                        <td class="px-5 py-4 text-xs font-semibold text-slate-700">
                            <div class="flex items-center gap-1.5">
                                <span class="w-6 h-6 rounded-lg bg-teal-50 text-teal-800 font-black flex items-center justify-center text-xs border border-teal-200">
                                    {{ $agent->max_orders_per_slot ?: 2 }}
                                </span>
                                <span class="text-[11px] text-slate-500">orders / slot</span>
                            </div>
                            @if($agent->vehicle_number)
                                <span class="text-[11px] text-slate-400 flex items-center gap-1 mt-1">
                                    <i class="fas fa-motorcycle text-[10px]"></i> {{ $agent->vehicle_number }}
                                </span>
                            @endif
                        </td>

                        <!-- Weekly Offs & Leave Status -->
                        <td class="px-5 py-4 text-xs">
                            <div class="space-y-1">
                                <div class="text-[11px]">
                                    <span class="text-slate-400 font-semibold">Weekly Off:</span>
                                    @if(!empty($weeklyOffs))
                                        <span class="font-bold text-slate-800">{{ implode(', ', $weeklyOffs) }}</span>
                                    @else
                                        <span class="text-slate-400 italic">None set</span>
                                    @endif
                                </div>
                                <div>
                                    @if($agent->upcoming_leaves_count > 0)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-rose-50 text-rose-700 text-[10px] font-extrabold border border-rose-200/60">
                                            <i class="far fa-calendar-check text-[9px]"></i> {{ $agent->upcoming_leaves_count }} Leave(s) Scheduled
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-[10px] text-slate-400">
                                            <i class="far fa-calendar-alt text-[9px]"></i> No upcoming leave
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <!-- Tasks Count -->
                        <td class="px-5 py-4 text-xs">
                            <a href="{{ route('admin.bookings.index', ['agent_id' => $agent->id]) }}" class="inline-flex items-center gap-1 font-bold text-indigo-700 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-2.5 py-1.5 rounded-xl border border-indigo-200/60 transition shadow-2xs" title="View assigned bookings for this agent">
                                <i class="fas fa-clipboard-check text-indigo-600"></i>
                                <span>{{ $agent->active_bookings_count ?? 0 }} Active</span>
                                <i class="fas fa-arrow-right text-[9px] ml-0.5"></i>
                            </a>
                        </td>

                        <!-- Status -->
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ $agent->status === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800 border border-rose-200/60' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $agent->status === 'active' ? 'bg-emerald-500' : 'bg-rose-500' }} mr-1.5"></span>
                                {{ ucfirst($agent->status) }}
                            </span>
                        </td>

                        <!-- Actions -->
                        <td class="px-5 py-4 text-right space-x-1.5 whitespace-nowrap">
                            <!-- Leaves & Roster Button -->
                            <button type="button" onclick="openLeavesModal({{ $agent->id }}, '{{ addslashes($agent->name) }}', '{{ $agent->serviceable_pincodes }}')" class="px-2.5 py-1.5 rounded-xl text-xs font-bold bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200/70 transition inline-flex items-center gap-1 cursor-pointer" title="Manage Leaves & Offs">
                                <i class="far fa-calendar-alt text-amber-600"></i>
                                <span>Roster / Offs</span>
                            </button>

                            <!-- Edit Agent Button -->
                            <button type="button" onclick="openEditAgentModal({{ json_encode($agent) }})" class="px-2.5 py-1.5 rounded-xl text-xs font-bold bg-indigo-50 hover:bg-indigo-100 text-indigo-800 border border-indigo-200/70 transition inline-flex items-center gap-1 cursor-pointer" title="Edit Agent Details & Pincodes">
                                <i class="fas fa-edit text-indigo-600"></i>
                                <span>Edit</span>
                            </button>

                            <!-- Toggle Status Form -->
                            <form action="{{ route('admin.agents.toggle_status', $agent->id) }}" method="POST" class="inline" onsubmit="return confirm('{{ $agent->status === 'active' ? 'Are you sure you want to deactivate ' . addslashes($agent->name) . '? Any active bookings assigned to this agent will be unassigned and queued for reassignment.' : 'Activate ' . addslashes($agent->name) . '?' }}');">
                                @csrf
                                <button type="submit" class="px-2.5 py-1.5 rounded-xl text-xs font-bold transition cursor-pointer inline-flex items-center gap-1.5 {{ $agent->status === 'active' ? 'bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200/70' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200/70' }}" title="{{ $agent->status === 'active' ? 'Deactivate this phlebotomist' : 'Activate this phlebotomist' }}">
                                    @if($agent->status === 'active')
                                        <i class="fas fa-user-slash text-[10px]"></i>
                                        <span>Deactivate</span>
                                    @else
                                        <i class="fas fa-user-check text-[10px]"></i>
                                        <span>Activate</span>
                                    @endif
                                </button>
                            </form>

                            <!-- Delete Form -->
                            <form action="{{ route('admin.agents.destroy', $agent->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this phlebotomist? Existing assignments will be unlinked.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-xl transition cursor-pointer" title="Delete">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                            <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-2 text-slate-400">
                                <i class="fas fa-user-friends text-lg"></i>
                            </div>
                            <p class="font-bold text-slate-700 text-sm">No Phlebotomists Registered Yet</p>
                            <p class="text-xs text-slate-400 mt-0.5">Click "Add Phlebotomist" above to register sample collectors and assign their serviceable area pincodes.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($agents->hasPages())
        <div class="p-4 border-t border-slate-100 bg-slate-50/50">
            {{ $agents->links() }}
        </div>
        @endif
    </div>

</div>

<!-- Modal: Add New Phlebotomist / Agent -->
<div id="addAgentModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden overflow-y-auto">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-2xl space-y-5 my-8">
        <div class="flex justify-between items-center border-b border-slate-100 pb-3">
            <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                <i class="fas fa-user-plus text-indigo-600"></i>
                <span>Register Phlebotomist & Area Settings</span>
            </h3>
            <button onclick="document.getElementById('addAgentModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 text-lg cursor-pointer">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form action="{{ route('admin.agents.store') }}" method="POST" class="space-y-4 text-xs">
            @csrf
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Full Name *</label>
                <input type="text" name="name" required class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="e.g. Rahul Singh">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Email Address *</label>
                    <input type="email" name="email" required class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="agent@example.com">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Mobile Number *</label>
                    <input type="tel" name="phone" required class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="9876543210">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Login Password *</label>
                    <input type="password" name="password" required class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Create password">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Ojaselab LIS Staff ID</label>
                    <input type="text" name="lis_collector_id" class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="e.g. PHLEBO-01">
                </div>
            </div>

            <!-- Serviceable Pincodes -->
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">
                    Serviceable Pincodes (Comma separated)
                    <span class="text-indigo-600 font-semibold normal-case">(e.g. 800001, 800002 or * for all)</span>
                </label>
                <textarea name="serviceable_pincodes" rows="2" class="w-full px-3.5 py-2 border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="800001, 800002, 800003"></textarea>
                <p class="text-[10px] text-slate-500 mt-0.5">When bookings occur in these pincodes, this phlebotomist is auto-assigned.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Max Orders Per Slot</label>
                    <input type="number" name="max_orders_per_slot" value="2" min="1" max="20" class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">City / Region</label>
                    <input type="text" name="city" class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="e.g. Patna">
                </div>
            </div>

            <!-- Weekly Off Selection -->
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1.5">Weekly Off Day(s)</label>
                <div class="flex flex-wrap gap-2">
                    @foreach(['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                        <label class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg border border-slate-200 bg-slate-50 hover:bg-slate-100 cursor-pointer text-xs font-bold text-slate-700">
                            <input type="checkbox" name="weekly_offs[]" value="{{ $day }}" class="rounded text-indigo-600 focus:ring-indigo-500">
                            <span>{{ substr($day, 0, 3) }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Vehicle Number</label>
                    <input type="text" name="vehicle_number" class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="BR-01-AB-1234">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Address</label>
                    <input type="text" name="address" class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Residential address">
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex gap-2 justify-end">
                <button type="button" onclick="document.getElementById('addAgentModal').classList.add('hidden')" class="px-4 py-2.5 rounded-xl border border-slate-200 font-bold text-slate-600 hover:bg-slate-50 cursor-pointer">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-bold shadow-md shadow-indigo-600/20 cursor-pointer">
                    Save Phlebotomist
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Edit Phlebotomist / Agent -->
<div id="editAgentModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden overflow-y-auto">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-2xl space-y-5 my-8">
        <div class="flex justify-between items-center border-b border-slate-100 pb-3">
            <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                <i class="fas fa-edit text-indigo-600"></i>
                <span>Edit Phlebotomist Details</span>
            </h3>
            <button onclick="document.getElementById('editAgentModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 text-lg cursor-pointer">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form id="editAgentForm" method="POST" class="space-y-4 text-xs">
            @csrf
            @method('PUT')
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Full Name *</label>
                <input type="text" id="editAgentName" name="name" required class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Email Address *</label>
                    <input type="email" id="editAgentEmail" name="email" required class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Mobile Number *</label>
                    <input type="tel" id="editAgentPhone" name="phone" required class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Password (Leave blank to keep)</label>
                    <input type="password" name="password" class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="••••••••">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Ojaselab LIS Staff ID</label>
                    <input type="text" id="editAgentLisId" name="lis_collector_id" class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="e.g. PHLEBO-01">
                </div>
            </div>

            <!-- Serviceable Pincodes -->
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">
                    Serviceable Pincodes (Comma separated)
                    <span class="text-indigo-600 font-semibold normal-case">(e.g. 800001, 800002 or * for all)</span>
                </label>
                <textarea id="editAgentPincodes" name="serviceable_pincodes" rows="2" class="w-full px-3.5 py-2 border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="800001, 800002, 800003"></textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Max Orders Per Slot</label>
                    <input type="number" id="editAgentMaxOrders" name="max_orders_per_slot" min="1" max="20" class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">City / Region</label>
                    <input type="text" id="editAgentCity" name="city" class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
            </div>

            <!-- Weekly Off Selection -->
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1.5">Weekly Off Day(s)</label>
                <div class="flex flex-wrap gap-2" id="editWeeklyOffsContainer">
                    @foreach(['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                        <label class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg border border-slate-200 bg-slate-50 hover:bg-slate-100 cursor-pointer text-xs font-bold text-slate-700">
                            <input type="checkbox" name="weekly_offs[]" value="{{ $day }}" class="edit-weekly-off rounded text-indigo-600 focus:ring-indigo-500">
                            <span>{{ substr($day, 0, 3) }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Vehicle Number</label>
                    <input type="text" id="editAgentVehicle" name="vehicle_number" class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Status</label>
                    <select id="editAgentStatus" name="status" class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-indigo-500 outline-none">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex gap-2 justify-end">
                <button type="button" onclick="document.getElementById('editAgentModal').classList.add('hidden')" class="px-4 py-2.5 rounded-xl border border-slate-200 font-bold text-slate-600 hover:bg-slate-50 cursor-pointer">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-bold shadow-md shadow-indigo-600/20 cursor-pointer">
                    Update Details
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Phlebotomist Leaves & Roster Management -->
<div id="leavesModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden overflow-y-auto">
    <div class="bg-white rounded-3xl max-w-xl w-full p-6 sm:p-7 shadow-2xl space-y-5 my-8">
        <div class="flex justify-between items-center border-b border-slate-100 pb-3">
            <div>
                <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                    <i class="far fa-calendar-times text-rose-600"></i>
                    <span>Roster & Leaves: <span id="leavesModalAgentName" class="text-indigo-600"></span></span>
                </h3>
                <p id="leavesModalPincodesInfo" class="text-xs text-slate-500 font-semibold mt-0.5"></p>
            </div>
            <button onclick="document.getElementById('leavesModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 text-lg cursor-pointer">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Quick Off Actions -->
        <div class="bg-amber-50/80 border border-amber-200/80 rounded-2xl p-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div>
                <h4 class="font-black text-amber-900 text-xs">Quick Duty Toggle</h4>
                <p class="text-[11px] text-amber-700">Quickly toggle full-day off-duty for today without filling the form below.</p>
            </div>
            <form id="quickOffTodayForm" method="POST" class="flex-shrink-0">
                @csrf
                <input type="hidden" name="date" value="{{ now()->format('Y-m-d') }}">
                <button type="submit" class="px-3.5 py-1.5 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-bold transition shadow-xs cursor-pointer">
                    Toggle Off for Today
                </button>
            </form>
        </div>

        <!-- Form: Schedule Leave / Off -->
        <div class="border border-slate-200 rounded-2xl p-4.5 bg-slate-50/50">
            <h4 class="font-black text-slate-800 text-xs uppercase tracking-wider mb-3 flex items-center gap-1.5">
                <i class="fas fa-plus-circle text-indigo-600"></i>
                <span>Schedule New Leave / Off</span>
            </h4>
            <form id="addLeaveForm" method="POST" class="space-y-3 text-xs">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Leave Date *</label>
                        <input type="date" name="leave_date" required min="{{ now()->format('Y-m-d') }}" value="{{ now()->format('Y-m-d') }}" class="w-full px-3 py-2 border border-slate-200 rounded-xl bg-white text-xs font-semibold text-slate-800 focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Scope / Type</label>
                        <select name="leave_type" id="newLeaveTypeSelect" onchange="toggleSlotSelectVisibility()" class="w-full px-3 py-2 border border-slate-200 rounded-xl bg-white text-xs font-semibold text-slate-800 focus:ring-2 focus:ring-indigo-500 outline-none">
                            <option value="full_day">Full Day (All Slots)</option>
                            <option value="slot_specific">Specific Time Slot Only</option>
                            <option value="sick">Sick Leave</option>
                            <option value="emergency">Emergency Off</option>
                        </select>
                    </div>
                </div>

                <div id="slotSelectContainer" class="hidden">
                    <label class="block font-bold text-slate-700 mb-1">Select Time Slot to Block</label>
                    <select name="slot_title" class="w-full px-3 py-2 border border-slate-200 rounded-xl bg-white text-xs font-semibold text-slate-800 focus:ring-2 focus:ring-indigo-500 outline-none">
                        <option value="">-- Choose Slot --</option>
                        @foreach($slots ?? [] as $s)
                            <option value="{{ $s->title }}">{{ $s->title }} ({{ ucfirst($s->period) }})</option>
                        @endforeach
                    </select>
                    <p class="text-[10px] text-slate-500 mt-1">This slot will not be shown to patients in this phlebotomist's serviceable pincodes.</p>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Reason / Notes</label>
                    <input type="text" name="reason" placeholder="e.g. Personal emergency, Doctor appointment, Weekly off" class="w-full px-3 py-2 border border-slate-200 rounded-xl bg-white text-xs font-semibold text-slate-800 focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>

                <div class="pt-1 flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition shadow-sm cursor-pointer">
                        Mark Leave
                    </button>
                </div>
            </form>
        </div>

        <!-- Scheduled Leaves List -->
        <div>
            <h4 class="font-black text-slate-800 text-xs uppercase tracking-wider mb-2.5 flex items-center justify-between">
                <span>Active & Upcoming Leaves</span>
                <span id="leavesCountBadge" class="text-[11px] text-slate-400 font-semibold"></span>
            </h4>
            <div id="leavesListContainer" class="space-y-2 max-h-60 overflow-y-auto pr-1">
                <div class="text-center py-6 text-slate-400 text-xs">
                    <i class="fas fa-spinner fa-spin mr-1"></i> Loading leaves...
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Open Edit Agent Modal
    function openEditAgentModal(agent) {
        document.getElementById('editAgentForm').action = `/admin/agents/${agent.id}`;
        document.getElementById('editAgentName').value = agent.name || '';
        document.getElementById('editAgentEmail').value = agent.email || '';
        document.getElementById('editAgentPhone').value = agent.phone || '';
        document.getElementById('editAgentLisId').value = agent.lis_collector_id || '';
        document.getElementById('editAgentPincodes').value = agent.serviceable_pincodes || '';
        document.getElementById('editAgentMaxOrders').value = agent.max_orders_per_slot || 2;
        document.getElementById('editAgentCity').value = agent.city || '';
        document.getElementById('editAgentVehicle').value = agent.vehicle_number || '';
        document.getElementById('editAgentStatus').value = agent.status || 'active';

        // Set weekly offs checkboxes
        const offs = Array.isArray(agent.weekly_offs) ? agent.weekly_offs : [];
        document.querySelectorAll('.edit-weekly-off').forEach(cb => {
            cb.checked = offs.includes(cb.value);
        });

        document.getElementById('editAgentModal').classList.remove('hidden');
    }

    // Toggle Slot Select Visibility in Leaves Form
    function toggleSlotSelectVisibility() {
        const val = document.getElementById('newLeaveTypeSelect').value;
        const container = document.getElementById('slotSelectContainer');
        if (val === 'slot_specific') {
            container.classList.remove('hidden');
        } else {
            container.classList.add('hidden');
        }
    }

    // Open Leaves Management Modal
    let currentAgentForLeaves = null;
    function openLeavesModal(agentId, agentName, pincodes) {
        currentAgentForLeaves = agentId;
        document.getElementById('leavesModalAgentName').innerText = agentName;
        document.getElementById('leavesModalPincodesInfo').innerText = pincodes ? `Covers Pincodes: ${pincodes}` : 'Covers: All Areas (Default Fallback)';
        document.getElementById('addLeaveForm').action = `/admin/agents/${agentId}/leaves`;
        document.getElementById('quickOffTodayForm').action = `/admin/agents/${agentId}/quick-off`;

        document.getElementById('leavesModal').classList.remove('hidden');
        loadAgentLeaves(agentId);
    }

    // Load Agent Leaves via Ajax
    function loadAgentLeaves(agentId) {
        const container = document.getElementById('leavesListContainer');
        container.innerHTML = '<div class="text-center py-6 text-slate-400 text-xs"><i class="fas fa-spinner fa-spin mr-1"></i> Fetching roster...</div>';

        fetch(`/admin/agents/${agentId}/leaves`, {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success && Array.isArray(data.leaves)) {
                const countBadge = document.getElementById('leavesCountBadge');
                countBadge.innerText = `${data.leaves.length} records`;

                if (data.leaves.length === 0) {
                    container.innerHTML = `
                        <div class="text-center py-6 border-2 border-dashed border-slate-100 rounded-2xl">
                            <i class="far fa-smile text-emerald-500 text-xl mb-1"></i>
                            <p class="text-xs font-bold text-slate-700">No Leaves Logged</p>
                            <p class="text-[11px] text-slate-400">This phlebotomist is available for all rostered shifts.</p>
                        </div>
                    `;
                    return;
                }

                let html = '';
                data.leaves.forEach(leave => {
                    const isFullDay = !leave.slot_title || leave.leave_type === 'full_day';
                    const formattedDate = new Date(leave.leave_date).toLocaleDateString('en-US', { weekday: 'short', day: 'numeric', month: 'short', year: 'numeric' });
                    
                    html += `
                        <div class="flex items-center justify-between p-3 bg-white border border-slate-200/80 rounded-xl shadow-2xs">
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="font-black text-slate-900 text-xs">${formattedDate}</span>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold ${isFullDay ? 'bg-rose-100 text-rose-800' : 'bg-amber-100 text-amber-800'}">
                                        ${isFullDay ? 'Full Day Off' : leave.slot_title}
                                    </span>
                                </div>
                                <p class="text-[11px] text-slate-500 font-medium mt-0.5">${leave.reason || 'Leave marked'}</p>
                            </div>
                            <button type="button" onclick="deleteLeaveRecord(${leave.id})" class="px-2.5 py-1 text-xs font-bold text-rose-600 hover:text-rose-800 hover:bg-rose-50 rounded-lg transition cursor-pointer">
                                <i class="fas fa-trash-alt mr-1"></i> Cancel
                            </button>
                        </div>
                    `;
                });
                container.innerHTML = html;
            } else {
                container.innerHTML = '<p class="text-xs text-rose-500 text-center py-4">Error loading roster.</p>';
            }
        })
        .catch(() => {
            container.innerHTML = '<p class="text-xs text-rose-500 text-center py-4">Network error loading roster.</p>';
        });
    }

    // Delete Leave Record
    function deleteLeaveRecord(leaveId) {
        if (!confirm('Are you sure you want to cancel this leave record? The slot will immediately become bookable again in this area.')) return;

        fetch(`/admin/agents/leaves/${leaveId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                if (currentAgentForLeaves) {
                    loadAgentLeaves(currentAgentForLeaves);
                }
            } else {
                alert('Could not cancel leave.');
            }
        })
        .catch(() => alert('Network error.'));
    }
</script>
@endsection
