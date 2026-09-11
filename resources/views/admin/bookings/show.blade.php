@extends('admin.layout.app')

@section('title', 'Booking Details')
@section('header')
<div class="flex items-center">
    <a href="{{ route('admin.bookings.index') }}" class="text-indigo-600 hover:text-indigo-800 mr-4">
        <i class="fas fa-arrow-left"></i>
    </a>
    Booking #{{ $booking->booking_reference }}
</div>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Left Column: Details -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Booking & Patient Details -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-800 border-b pb-3 mb-4">Patient & Appointment Details</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Patient Name</p>
                    <p class="font-medium text-gray-800">{{ $booking->patient->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Booking Date & Time</p>
                    <p class="font-medium text-gray-800">{{ $booking->booking_date->format('F d, Y - h:i A') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Collection Type</p>
                    <p class="font-medium text-gray-800">{{ $booking->collection_type }}</p>
                </div>
                @if($booking->collection_type == 'Home Collection' && $booking->address)
                <div class="md:col-span-2">
                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Collection Address</p>
                    <p class="font-medium text-gray-800 bg-gray-50 p-3 rounded-lg border border-gray-100">
                        {{ $booking->address->full_address }}<br>
                        {{ $booking->address->city }}, {{ $booking->address->state }} {{ $booking->address->pincode }}
                    </p>
                </div>
                @endif
                
                @if($booking->family_member_id && $booking->familyMember)
                <div class="md:col-span-2 mt-2 pt-4 border-t">
                    <p class="text-xs text-indigo-500 uppercase tracking-wider mb-1 font-semibold">Booking for Family Member</p>
                    <p class="font-medium text-gray-800">{{ $booking->familyMember->name }} ({{ $booking->familyMember->relation }}) - {{ $booking->familyMember->gender }}, {{ $booking->familyMember->age }} Yrs</p>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Tests Included -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-800 border-b pb-3 mb-4">Tests Included</h3>
            <ul class="space-y-3">
                @foreach($booking->test_details as $test)
                <li class="flex justify-between items-center bg-gray-50 p-3 rounded-lg border border-gray-100">
                    <span class="font-medium text-gray-800">{{ $test['name'] ?? 'Test' }}</span>
                    <span class="text-gray-600 font-semibold">₹{{ isset($test['price']) ? $test['price'] : 0 }}</span>
                </li>
                @endforeach
            </ul>
        </div>
        
    </div>
    
    <!-- Right Column: Status & Payment -->
    <div class="space-y-6">
        
        <!-- Actions / Workflow -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-800 border-b pb-3 mb-4">Update Status</h3>
            
            <form action="{{ route('admin.bookings.updateStatus', $booking->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Status</label>
                    <select name="status" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-2 border bg-gray-50">
                        @php
                            $statuses = ['Pending', 'Confirmed', 'Sample Collection Scheduled', 'Sample Collected', 'In Process', 'Report Ready', 'Completed', 'Cancelled'];
                        @endphp
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" {{ $booking->status == $status ? 'selected' : '' }}>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-4 rounded-xl transition-colors shadow-sm">
                    <i class="fas fa-sync-alt mr-2"></i> Update Status
                </button>
            </form>
            
            <div class="mt-4 pt-4 border-t flex gap-2">
                <a href="{{ route('admin.bookings.print', $booking->id) }}" target="_blank" class="w-full flex-1 bg-white border-2 border-slate-200 hover:border-slate-800 hover:bg-slate-800 hover:text-white text-slate-700 font-bold py-2 px-4 rounded-xl transition-all text-center">
                    <i class="fas fa-print mr-2"></i> Print
                </a>
            </div>
        </div>

        <!-- Field Agent Assignment & Collection Status -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between border-b pb-3 mb-4">
                <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-motorcycle text-teal-600"></i> Field Agent / Sample
                </h3>
                @if($booking->agent)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                        {{ $booking->sample_status == 'Delivered to Lab' ? 'bg-purple-100 text-purple-800' :
                          ($booking->sample_status == 'Sample Collected' ? 'bg-emerald-100 text-emerald-800' :
                          ($booking->sample_status == 'Out for Collection' ? 'bg-blue-100 text-blue-800' : 'bg-amber-100 text-amber-800')) }}">
                        <i class="fas fa-circle text-[8px] mr-1.5 animate-pulse"></i>
                        {{ $booking->sample_status }}
                    </span>
                @else
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">
                        Unassigned
                    </span>
                @endif
            </div>

            @if($booking->agent)
                <div class="p-3.5 bg-teal-50/70 rounded-xl border border-teal-100 mb-4 space-y-2">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="font-bold text-teal-950 text-sm flex items-center gap-1.5">
                                <i class="fas fa-user-circle text-teal-600"></i> {{ $booking->agent->name }}
                            </p>
                            <p class="text-xs text-teal-700 mt-0.5">
                                <i class="fas fa-phone-alt text-[10px] mr-1"></i>
                                <a href="tel:{{ $booking->agent->phone }}" class="underline font-semibold">{{ $booking->agent->phone }}</a>
                            </p>
                        </div>
                        @if($booking->agent->vehicle_number)
                            <span class="text-[11px] font-mono font-bold bg-white px-2 py-0.5 rounded border border-teal-200 text-teal-800">
                                {{ $booking->agent->vehicle_number }}
                            </span>
                        @endif
                    </div>

                    @if($booking->sample_notes)
                        <div class="pt-2 border-t border-teal-200/60 text-xs text-teal-900">
                            <span class="font-bold">Agent Notes:</span> {{ $booking->sample_notes }}
                        </div>
                    @endif

                    @if($booking->sample_collected_at)
                        <div class="text-[11px] text-teal-700 flex items-center gap-1">
                            <i class="fas fa-vial text-teal-500"></i> Sample collected: {{ $booking->sample_collected_at->format('M d, Y • h:i A') }}
                        </div>
                    @endif
                </div>

                <!-- Doorstep Money Collection Status in Admin -->
                <div class="p-3 rounded-xl border mb-4 text-xs {{ $booking->payment_status == 'Paid' ? 'bg-emerald-50/60 border-emerald-100 text-emerald-900' : 'bg-amber-50/60 border-amber-100 text-amber-900' }}">
                    <div class="flex items-center justify-between font-bold">
                        <span>Doorstep Collection:</span>
                        @if($booking->payment_status == 'Paid')
                            @if($booking->money_collected_by)
                                <span class="text-emerald-700 font-black">₹{{ $booking->amount }} Collected (Cash)</span>
                            @else
                                <span class="text-emerald-700 font-black">Paid Online</span>
                            @endif
                        @else
                            <span class="text-amber-700 font-black">₹{{ $booking->amount }} Cash Due</span>
                        @endif
                    </div>
                    @if($booking->money_collected_at)
                        <p class="text-[11px] text-emerald-700 mt-1">
                            Collected by {{ $booking->agent->name }} on {{ $booking->money_collected_at->format('M d, h:i A') }}
                        </p>
                    @endif
                </div>
            @else
                <div class="p-3 bg-amber-50 border border-amber-200 rounded-xl mb-4 text-xs text-amber-800 flex items-start gap-2">
                    <i class="fas fa-exclamation-triangle text-amber-600 mt-0.5"></i>
                    <div>
                        <p class="font-bold">No Agent Assigned</p>
                        <p class="text-amber-700 mt-0.5">Assign a phlebotomist below so they can view this client's address, pick up samples, and collect cash.</p>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.bookings.assign_agent', $booking->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                        {{ $booking->agent ? 'Reassign / Change Agent' : 'Select Field Agent' }}
                    </label>
                    <select name="agent_id" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500 shadow-sm px-3 py-2 text-sm border bg-gray-50">
                        <option value="">-- Unassigned (None) --</option>
                        @foreach($agents as $agent)
                            <option value="{{ $agent->id }}" {{ $booking->agent_id == $agent->id ? 'selected' : '' }}>
                                {{ $agent->name }} ({{ $agent->phone }}) {{ $agent->area ? '• ' . $agent->area : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-2.5 px-4 rounded-xl transition-colors shadow-sm text-sm flex items-center justify-center gap-2">
                    <i class="fas fa-user-check"></i>
                    {{ $booking->agent ? 'Update Assigned Agent' : 'Assign Agent Now' }}
                </button>
            </form>
        </div>
        
        <!-- Payment Details -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-800 border-b pb-3 mb-4">Payment Summary</h3>
            
            <div class="space-y-3 mb-4">
                <div class="flex justify-between">
                    <span class="text-gray-500">Method</span>
                    <span class="font-medium text-gray-800">{{ $booking->payment_method }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Status</span>
                    <span class="font-medium {{ $booking->payment_status == 'Paid' ? 'text-green-600' : 'text-orange-600' }}">{{ $booking->payment_status }}</span>
                </div>
                <div class="border-t pt-2 flex justify-between items-center">
                    <span class="font-bold text-gray-800">Total Amount</span>
                    <span class="text-xl font-black text-indigo-600">₹{{ $booking->amount }}</span>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection
