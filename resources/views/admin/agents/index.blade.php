@extends('admin.layout.app')

@section('title', 'Field Agents & Collectors')
@section('header', 'Field Agent / Sample Collector Management')

@section('content')
<div class="space-y-6">

    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
        <div>
            <h2 class="text-lg font-bold text-slate-900">Phlebotomists & Field Agents</h2>
            <p class="text-xs text-slate-500 mt-0.5">Manage certified agents responsible for doorstep sample collections and cash handovers</p>
        </div>
        <button onclick="document.getElementById('addAgentModal').classList.remove('hidden')" class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white text-xs font-bold shadow-md shadow-indigo-600/30 transition-all flex items-center gap-2">
            <i class="fas fa-user-plus"></i>
            <span>Add New Agent</span>
        </button>
    </div>

    <!-- Agents Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                        <th class="px-6 py-4 font-semibold">Agent Name</th>
                        <th class="px-6 py-4 font-semibold">Contact Info</th>
                        <th class="px-6 py-4 font-semibold">City / Vehicle</th>
                        <th class="px-6 py-4 font-semibold">Active Tasks</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($agents as $agent)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <!-- Name -->
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-sm">
                                    {{ substr($agent->name, 0, 1) }}
                                </div>
                                <div>
                                    <span class="font-bold text-slate-900 block">{{ $agent->name }}</span>
                                    <span class="text-[11px] text-slate-400">Joined {{ $agent->created_at->format('M Y') }}</span>
                                </div>
                            </div>
                        </td>

                        <!-- Contact -->
                        <td class="px-6 py-4">
                            <div class="text-xs space-y-0.5">
                                <a href="tel:{{ $agent->phone }}" class="font-bold text-slate-800 hover:text-indigo-600 block">
                                    <i class="fas fa-phone-alt text-slate-400 mr-1 text-[10px]"></i> {{ $agent->phone }}
                                </a>
                                <span class="text-slate-500 block">
                                    <i class="fas fa-envelope text-slate-400 mr-1 text-[10px]"></i> {{ $agent->email }}
                                </span>
                            </div>
                        </td>

                        <!-- City & Vehicle -->
                        <td class="px-6 py-4 text-xs">
                            <span class="font-semibold text-slate-700 block">{{ $agent->city ?: 'N/A' }}</span>
                            @if($agent->vehicle_number)
                                <span class="text-slate-400 flex items-center gap-1 mt-0.5">
                                    <i class="fas fa-motorcycle text-[10px]"></i> {{ $agent->vehicle_number }}
                                </span>
                            @endif
                        </td>

                        <!-- Tasks Count -->
                        <td class="px-6 py-4 text-xs">
                            <span class="inline-flex items-center gap-1 font-bold text-slate-800 bg-slate-100 px-2.5 py-1 rounded-lg">
                                <i class="fas fa-clipboard-check text-indigo-500"></i>
                                <span>{{ $agent->active_bookings_count ?? 0 }} Active</span>
                            </span>
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $agent->status === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $agent->status === 'active' ? 'bg-emerald-500' : 'bg-slate-400' }} mr-1.5"></span>
                                {{ ucfirst($agent->status) }}
                            </span>
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 text-right space-x-2">
                            <!-- Toggle Status Form -->
                            <form action="{{ route('admin.agents.toggle_status', $agent->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-2.5 py-1.5 rounded-lg text-xs font-semibold {{ $agent->status === 'active' ? 'bg-amber-50 text-amber-700 hover:bg-amber-100' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' }} transition">
                                    {{ $agent->status === 'active' ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>

                            <!-- Delete Form -->
                            <form action="{{ route('admin.agents.destroy', $agent->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to remove this agent? Existing assignments will be unlinked.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-lg transition">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                            <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-2 text-slate-400">
                                <i class="fas fa-user-friends text-lg"></i>
                            </div>
                            <p class="font-bold text-slate-700 text-sm">No Field Agents Registered Yet</p>
                            <p class="text-xs text-slate-400 mt-0.5">Click "Add New Agent" above or have them register from the website login modal.</p>
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

<!-- Modal: Add New Agent -->
<div id="addAgentModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-5">
        <div class="flex justify-between items-center border-b border-slate-100 pb-3">
            <h3 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                <i class="fas fa-user-plus text-indigo-600"></i>
                <span>Register Field Agent</span>
            </h3>
            <button onclick="document.getElementById('addAgentModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form action="{{ route('admin.agents.store') }}" method="POST" class="space-y-4 text-xs">
            @csrf
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Full Name</label>
                <input type="text" name="name" required class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800" placeholder="e.g. Rahul Singh">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Email Address</label>
                    <input type="email" name="email" required class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800" placeholder="agent@example.com">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Mobile Number</label>
                    <input type="tel" name="phone" required class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800" placeholder="9876543210">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Login Password</label>
                <input type="password" name="password" required class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800" placeholder="Create password">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">City / Region</label>
                    <input type="text" name="city" class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800" placeholder="e.g. Patna">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Vehicle Number</label>
                    <input type="text" name="vehicle_number" class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800" placeholder="BR-01-AB-1234">
                </div>
            </div>

            <div class="pt-3 border-t border-slate-100 flex gap-2 justify-end">
                <button type="button" onclick="document.getElementById('addAgentModal').classList.add('hidden')" class="px-4 py-2 rounded-xl border border-slate-200 font-bold text-slate-600 hover:bg-slate-50">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold shadow-md shadow-indigo-600/20">
                    Save Agent
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
