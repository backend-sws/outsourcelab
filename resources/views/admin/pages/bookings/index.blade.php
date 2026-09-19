@extends('admin.layouts.app')

@section('title', 'Bookings')
@section('header', 'Booking Management')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <!-- Header with Search/Filter Bar -->
    <div class="p-5 border-b border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-gray-50/50">
        <div>
            <h2 class="text-lg font-bold text-gray-800">All Bookings ({{ $bookings->total() }})</h2>
            <p class="text-xs text-gray-500 mt-0.5">Assign phlebotomists, track sample collection status, and manage payments</p>
        </div>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('admin.bookings.index') }}" class="flex flex-wrap items-center gap-2">
            <!-- Filter by Agent -->
            <select name="agent_id" onchange="this.form.submit()" class="text-xs rounded-xl border-gray-200 bg-white px-3 py-2 text-gray-700 font-medium focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                <option value="">All Field Agents</option>
                <option value="unassigned" {{ request('agent_id') === 'unassigned' ? 'selected' : '' }}>⚠️ Unassigned Only</option>
                @foreach($agents as $agent)
                    <option value="{{ $agent->id }}" {{ request('agent_id') == $agent->id ? 'selected' : '' }}>
                        {{ $agent->name }} ({{ $agent->city ?: 'Field' }})
                    </option>
                @endforeach
            </select>

            <!-- Filter by Status -->
            <select name="status" onchange="this.form.submit()" class="text-xs rounded-xl border-gray-200 bg-white px-3 py-2 text-gray-700 font-medium focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                <option value="">All Statuses</option>
                @foreach(['Booked', 'Confirmed', 'Pending', 'Sample Collected', 'In Process', 'Report Ready', 'Completed', 'Cancelled'] as $st)
                    <option value="{{ $st }}" {{ request('status') === $st ? 'selected' : '' }}>{{ $st }}</option>
                @endforeach
            </select>

            @if(request()->hasAny(['agent_id', 'status']))
                <a href="{{ route('admin.bookings.index') }}" class="text-xs font-bold text-rose-500 hover:text-rose-700 px-2 py-1">
                    <i class="fas fa-times mr-1"></i> Reset
                </a>
            @endif
        </form>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 text-gray-500 text-xs uppercase tracking-wider">
                    <th class="px-6 py-4 font-semibold">Ref #</th>
                    <th class="px-6 py-4 font-semibold">Date</th>
                    <th class="px-6 py-4 font-semibold">Patient</th>
                    <th class="px-6 py-4 font-semibold">Field Agent Assignment</th>
                    <th class="px-6 py-4 font-semibold">Amount</th>
                    <th class="px-6 py-4 font-semibold">Status</th>
                    <th class="px-6 py-4 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($bookings as $booking)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 font-medium text-gray-800 font-mono">{{ $booking->booking_reference }}</td>
                    <td class="px-6 py-4 text-xs">
                        <div class="font-bold text-gray-900 flex items-center gap-1.5">
                            <i class="far fa-calendar-alt text-teal-600"></i>
                            <span>{{ $booking->booking_date->format('M d, Y') }}</span>
                        </div>
                        <div class="mt-1">
                            <span class="inline-flex items-center gap-1 font-semibold text-[11px] px-2 py-0.5 rounded-md bg-amber-50 text-amber-800 border border-amber-200 shadow-xs">
                                <i class="far fa-clock text-[10px] text-amber-600"></i>
                                <span>{{ $booking->display_slot }}</span>
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                        <div class="font-bold text-gray-800">{{ $booking->patient->name ?? 'N/A' }}</div>
                        <span class="text-xs text-gray-400">{{ $booking->collection_type }}</span>
                    </td>

                    <!-- Interactive Field Agent Column -->
                    <td class="px-6 py-4">
                        <form action="{{ route('admin.bookings.assign_agent', $booking->id) }}" method="POST" class="flex flex-col gap-1.5">
                            @csrf
                            <div class="flex items-center gap-1.5">
                                <select name="agent_id" onchange="this.form.submit()" class="text-xs rounded-xl border {{ $booking->agent ? 'border-teal-300 bg-teal-50/30 text-teal-900 font-semibold' : 'border-amber-300 bg-amber-50/40 text-amber-900 font-medium' }} py-1.5 pl-2.5 pr-7 focus:ring-teal-500 focus:border-teal-500 shadow-sm cursor-pointer transition-all">
                                    <option value="">-- Assign Agent --</option>
                                    @foreach($agents as $agent)
                                        <option value="{{ $agent->id }}" {{ (int)$booking->agent_id === (int)$agent->id ? 'selected' : '' }}>
                                            {{ $agent->name }} ({{ $agent->city ?: $agent->phone }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            @if($booking->agent)
                                <div class="flex items-center gap-1 text-[11px] text-teal-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-teal-500 animate-pulse"></span>
                                    <span class="font-bold">{{ $booking->sample_status ?: 'Assigned' }}</span>
                                    <span class="text-gray-400">• {{ $booking->agent->phone }}</span>
                                </div>
                            @else
                                <span class="text-[10px] text-amber-600 font-bold flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle text-[9px]"></i> Not assigned yet
                                </span>
                            @endif
                        </form>
                    </td>

                    <td class="px-6 py-4 font-medium text-gray-700">
                        ₹{{ $booking->amount }}
                        <span class="block text-[11px] {{ $booking->payment_status == 'Paid' ? 'text-green-600' : 'text-amber-600' }} font-bold">
                            {{ $booking->payment_status }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $booking->status == 'Completed' ? 'bg-green-100 text-green-800' : 
                              ($booking->status == 'Cancelled' ? 'bg-red-100 text-red-800' : 
                              ($booking->status == 'Pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800')) }}">
                            {{ $booking->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-xl font-semibold text-xs transition-colors inline-flex items-center gap-1">
                            <i class="fas fa-eye"></i>
                            <span>Manage</span>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">No bookings found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($bookings->hasPages())
    <div class="p-4 border-t border-gray-100 bg-gray-50/50">
        {{ $bookings->links() }}
    </div>
    @endif
</div>
@endsection
