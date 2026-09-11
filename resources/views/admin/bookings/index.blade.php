@extends('admin.layout.app')

@section('title', 'Bookings')
@section('header', 'Booking Management')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
        <h2 class="text-lg font-bold text-gray-800">All Bookings</h2>
        <!-- Future Search/Filter could go here -->
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 text-gray-500 text-xs uppercase tracking-wider">
                    <th class="px-6 py-4 font-semibold">Ref #</th>
                    <th class="px-6 py-4 font-semibold">Date</th>
                    <th class="px-6 py-4 font-semibold">Patient</th>
                    <th class="px-6 py-4 font-semibold">Field Agent</th>
                    <th class="px-6 py-4 font-semibold">Amount</th>
                    <th class="px-6 py-4 font-semibold">Status</th>
                    <th class="px-6 py-4 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($bookings as $booking)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $booking->booking_reference }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $booking->booking_date->format('M d, Y h:i A') }}</td>
                    <td class="px-6 py-4 text-gray-600">
                        <div class="font-medium text-gray-800">{{ $booking->patient->name ?? 'N/A' }}</div>
                        <span class="text-xs text-gray-400">{{ $booking->collection_type }}</span>
                    </td>
                    <td class="px-6 py-4">
                        @if($booking->agent)
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-teal-100 text-teal-700 flex items-center justify-center font-bold text-xs">
                                    {{ substr($booking->agent->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-800 text-xs">{{ $booking->agent->name }}</div>
                                    <span class="inline-flex items-center text-[10px] font-bold text-teal-700 bg-teal-50 px-1.5 py-0.5 rounded border border-teal-200">
                                        {{ $booking->sample_status ?? 'Assigned' }}
                                    </span>
                                </div>
                            </div>
                        @else
                            <span class="inline-flex items-center gap-1 text-xs text-gray-400 bg-gray-100 px-2 py-1 rounded-md">
                                <i class="fas fa-user-slash text-[10px]"></i> Unassigned
                            </span>
                        @endif
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
                        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-md transition-colors inline-flex items-center">
                            <i class="fas fa-eye mr-1.5"></i> Manage
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
