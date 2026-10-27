@extends('admin.layouts.app')

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
            <div class="flex items-center justify-between border-b pb-3 mb-4">
                <h3 class="text-lg font-bold text-gray-800">Patient & Appointment Details</h3>
                <button type="button" onclick="document.getElementById('adminModifyBookingForm').classList.toggle('hidden')" class="px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-lg text-xs font-bold transition flex items-center gap-1.5 cursor-pointer">
                    <i class="fas fa-edit text-xs"></i>
                    <span>Modify Details</span>
                </button>
            </div>

            <!-- Admin Modify Form -->
            <form id="adminModifyBookingForm" action="{{ route('admin.bookings.modify', $booking->id) }}" method="POST" class="hidden mb-6 p-4 rounded-xl bg-slate-50 border border-slate-200">
                @csrf
                <h4 class="text-xs font-black uppercase text-indigo-900 mb-3 tracking-wider flex items-center gap-1.5">
                    <i class="fas fa-sliders text-indigo-600"></i> Modify Booking Details
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Collection Date</label>
                        <input type="date" name="booking_date" value="{{ $booking->booking_date ? $booking->booking_date->format('Y-m-d') : '' }}" class="w-full text-xs font-bold border border-gray-300 rounded-lg px-3 py-2 bg-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Time Slot Window</label>
                        <input type="text" name="collection_slot" value="{{ $booking->collection_slot }}" placeholder="e.g. 07:00 AM - 08:00 AM" class="w-full text-xs font-bold border border-gray-300 rounded-lg px-3 py-2 bg-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Total Amount (₹)</label>
                        <input type="number" step="0.01" name="amount" value="{{ $booking->amount }}" class="w-full text-xs font-bold border border-gray-300 rounded-lg px-3 py-2 bg-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Payment Status</label>
                        <select name="payment_status" class="w-full text-xs font-bold border border-gray-300 rounded-lg px-3 py-2 bg-white">
                            <option value="Pending" {{ $booking->payment_status === 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Paid" {{ $booking->payment_status === 'Paid' ? 'selected' : '' }}>Paid</option>
                            <option value="Partial Online / Cash on Collection" {{ $booking->payment_status === 'Partial Online / Cash on Collection' ? 'selected' : '' }}>Partial Online / Cash on Collection</option>
                        </select>
                    </div>
                </div>
                <div class="mt-4 flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('adminModifyBookingForm').classList.add('hidden')" class="px-3 py-1.5 text-xs font-bold text-gray-600 hover:bg-gray-200 rounded-lg cursor-pointer">Cancel</button>
                    <button type="submit" class="px-4 py-1.5 text-xs font-bold bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow-sm cursor-pointer">Save Changes</button>
                </div>
            </form>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Patient Name (Beneficiary)</p>
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="font-extrabold text-gray-900 text-base">{{ $booking->beneficiary_name }}</span>
                        @if($booking->familyMember)
                            <span class="text-xs font-bold px-2 py-0.5 rounded-md bg-teal-50 text-teal-800 border border-teal-200">
                                {{ $booking->familyMember->relation }}
                            </span>
                        @else
                            <span class="text-xs font-bold px-2 py-0.5 rounded-md bg-gray-100 text-gray-700 border border-gray-200">
                                Primary Patient (Self)
                            </span>
                        @endif
                    </div>
                    @if($booking->familyMember)
                        <p class="text-xs text-teal-800 font-semibold mt-1">
                            ({{ $booking->familyMember->relation }} of {{ $booking->patient->name ?? 'Account Owner' }})
                        </p>
                        <p class="text-xs text-gray-500 mt-0.5">
                            Age: <strong class="text-gray-700">{{ $booking->beneficiary_age ?? 'N/A' }} Yrs</strong> •
                            Gender: <strong class="text-gray-700">{{ ucfirst($booking->beneficiary_gender ?? 'N/A') }}</strong>
                        </p>
                        <p class="text-[11px] text-gray-400 mt-1 pt-1 border-t border-gray-100">
                            Booked by Account Owner: <strong class="text-gray-700">{{ $booking->patient->name ?? 'N/A' }}</strong> (<a href="tel:{{ $booking->patient->mobile }}" class="text-teal-700 underline">{{ $booking->patient->mobile ?? 'N/A' }}</a>)
                        </p>
                    @else
                        <p class="text-xs text-gray-500 mt-1">
                            Age: <strong class="text-gray-700">{{ $booking->beneficiary_age ?? 'N/A' }} Yrs</strong> •
                            Gender: <strong class="text-gray-700">{{ ucfirst($booking->beneficiary_gender ?? 'N/A') }}</strong> •
                            Phone: <a href="tel:{{ $booking->patient->mobile }}" class="text-teal-700 font-bold underline">{{ $booking->patient->mobile ?? 'N/A' }}</a>
                        </p>
                    @endif
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Collection Date</p>
                    <p class="font-bold text-gray-900 flex items-center gap-1.5">
                        <i class="far fa-calendar-alt text-teal-600"></i>
                        <span>{{ $booking->booking_date->format('F d, Y') }}</span>
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Scheduled Time Slot Window</p>
                    <div class="inline-flex items-center gap-1.5 font-bold text-xs px-3 py-1.5 rounded-xl bg-amber-50 text-amber-900 border border-amber-200 shadow-xs">
                        <i class="far fa-clock text-amber-600"></i>
                        <span>{{ $booking->display_slot }}</span>
                    </div>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Collection Type</p>
                    <p class="font-medium text-gray-800">{{ $booking->collection_type }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Assigned Field Agent</p>
                    @if($booking->agent)
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-teal-500/10 text-teal-600 dark:text-teal-400 flex items-center justify-center font-bold text-xs">
                                <i class="fas fa-motorcycle"></i>
                            </div>
                            <div>
                                <p class="font-bold text-teal-700 dark:text-teal-400 text-sm">{{ $booking->agent->name }}</p>
                                <p class="text-[11px] text-gray-500">{{ $booking->agent->phone }}</p>
                            </div>
                        </div>
                    @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-500/20">
                            <i class="fas fa-user-slash text-[10px]"></i> No Agent Assigned Yet
                        </span>
                    @endif
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
                    <p class="text-xs text-teal-700 uppercase tracking-wider mb-1.5 font-bold flex items-center gap-1.5">
                        <i class="fas fa-users"></i> Booking Placed For Family Member
                    </p>
                    <div class="p-3.5 bg-teal-50/70 rounded-xl border border-teal-200/80 flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <span class="font-extrabold text-teal-950 text-sm">{{ $booking->familyMember->name }}</span>
                            <span class="text-xs text-teal-800 font-bold ml-1">({{ $booking->familyMember->relation }} of {{ $booking->patient->name ?? 'Account Owner' }})</span>
                            <div class="text-xs text-slate-600 mt-0.5">
                                Age: <strong class="text-slate-800">{{ $booking->familyMember->age }} Yrs</strong> • Gender: <strong class="text-slate-800">{{ ucfirst($booking->familyMember->gender) }}</strong>
                            </div>
                        </div>
                        <span class="text-xs bg-white text-teal-900 font-extrabold px-3 py-1 rounded-lg border border-teal-200 shadow-2xs">
                            Account Owner: {{ $booking->patient->name ?? 'N/A' }}
                        </span>
                    </div>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Tests Included -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between border-b pb-3 mb-4">
                <div class="flex items-center gap-2">
                    <h3 class="text-lg font-bold text-gray-800">Tests Included</h3>
                    <span class="text-xs bg-teal-50 text-teal-800 font-extrabold px-2.5 py-0.5 rounded-full border border-teal-200">
                        {{ is_array($booking->test_details) ? count($booking->test_details) : 0 }} {{ Str::plural('Item', is_array($booking->test_details) ? count($booking->test_details) : 0) }}
                    </span>
                </div>
                <button type="button" onclick="openAdminModifyTestsModal()" class="px-3.5 py-1.5 bg-gradient-to-r from-teal-600 to-teal-700 hover:from-teal-700 hover:to-teal-800 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-sm cursor-pointer">
                    <i class="fas fa-edit text-xs"></i>
                    <span>Manage / Add Tests</span>
                </button>
            </div>

            <ul class="space-y-3">
                @if(!empty($booking->test_details) && is_array($booking->test_details))
                    @foreach($booking->test_details as $test)
                    <li class="flex justify-between items-center bg-gray-50/80 hover:bg-gray-100/70 p-3.5 rounded-xl border border-gray-100 transition">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-8 h-8 rounded-lg {{ ($test['type'] ?? 'test') === 'package' ? 'bg-amber-100 text-amber-700' : 'bg-teal-100 text-teal-700' }} flex items-center justify-center text-xs flex-shrink-0 font-bold">
                                <i class="fas {{ ($test['type'] ?? 'test') === 'package' ? 'fa-box-open' : 'fa-flask' }}"></i>
                            </div>
                            <div class="min-w-0">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="font-extrabold text-gray-800 text-xs sm:text-sm truncate">{{ $test['name'] ?? ($test['title'] ?? 'Diagnostic Test') }}</span>
                                    <span class="text-[10px] font-black px-2 py-0.5 rounded-full {{ ($test['type'] ?? 'test') === 'package' ? 'bg-amber-50 text-amber-800 border border-amber-200' : 'bg-blue-50 text-blue-800 border border-blue-200' }}">
                                        {{ ucfirst($test['type'] ?? 'test') }}
                                    </span>
                                    @if(!empty($test['sample_type']))
                                        <span class="text-[10px] font-bold text-gray-500 bg-gray-100 px-1.5 py-0.5 rounded">
                                            {{ $test['sample_type'] }}
                                        </span>
                                    @endif
                                    @if(!empty($test['parameters_count']))
                                        <span class="text-[10px] font-bold text-indigo-700 bg-indigo-50 px-1.5 py-0.5 rounded border border-indigo-100">
                                            {{ $test['parameters_count'] }} Parameters
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <span class="text-gray-900 font-black text-sm flex-shrink-0">₹{{ number_format($test['price'] ?? 0, 0) }}</span>
                    </li>
                    @endforeach
                @else
                    <li class="text-xs text-gray-500 italic p-3">No tests recorded for this booking.</li>
                @endif
            </ul>

            <!-- Breakdown in tests card -->
            <div class="mt-4 pt-3 border-t border-gray-100 flex flex-wrap items-center justify-between text-xs text-gray-600 gap-2">
                <div class="flex items-center gap-4 flex-wrap">
                    <span>Subtotal: <strong class="text-gray-900">₹{{ number_format(is_array($booking->test_details) ? array_sum(array_column($booking->test_details, 'price')) : 0, 0) }}</strong></span>
                    @if($booking->collection_fee > 0)
                        <span>Collection Fee: <strong class="text-gray-900">₹{{ number_format($booking->collection_fee, 0) }}</strong></span>
                    @endif
                    @if(($booking->discount_amount ?? 0) > 0 || ($booking->coins_discount ?? 0) > 0)
                        <span class="text-emerald-700">Discount: <strong class="text-emerald-700">-₹{{ number_format(($booking->discount_amount ?? 0) + ($booking->coins_discount ?? 0), 0) }}</strong></span>
                    @endif
                </div>
                <div>
                    <span class="font-bold text-gray-800">Total: <span class="text-sm font-black text-teal-700">₹{{ number_format($booking->amount, 0) }}</span></span>
                </div>
            </div>
        </div>
        
    </div>
    
    <!-- Right Column: Status & Payment -->
    <div class="space-y-6">

        {{-- ════════════════ CANCELLATION & REFUND CARD ════════════════ --}}
        @if($booking->cancellation_request_status === 'requested')
            <div class="bg-gradient-to-br from-rose-50 via-white to-amber-50 rounded-2xl shadow-sm border-2 border-rose-300 p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-rose-200 pb-3">
                    <h3 class="text-base font-black text-rose-950 flex items-center gap-2">
                        <i class="fas fa-exclamation-circle text-rose-600 animate-pulse text-lg"></i>
                        <span>Customer Cancellation Request</span>
                    </h3>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-rose-100 text-rose-800 border border-rose-200">
                        Action Required
                    </span>
                </div>

                <div class="space-y-2 text-xs">
                    <div class="bg-white/80 p-3 rounded-xl border border-rose-100">
                        <span class="text-gray-500 font-bold block mb-0.5">Patient's Stated Reason:</span>
                        <p class="text-rose-950 font-black text-sm">{{ $booking->cancellation_reason ?: 'No detailed reason provided.' }}</p>
                        <span class="text-[10px] text-gray-400 mt-1 block">
                            Requested at: {{ $booking->cancellation_requested_at ? $booking->cancellation_requested_at->format('M d, Y • h:i A') : 'Recently' }}
                        </span>
                    </div>

                    <!-- Online Payment & Refund Details -->
                    @if($booking->hasOnlinePayment() && $booking->refundable_amount > 0)
                        <div class="p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-950 space-y-1">
                            <div class="flex items-center justify-between font-bold">
                                <span>Online Paid Amount:</span>
                                <span class="text-emerald-700 font-black text-sm">₹{{ number_format($booking->refundable_amount, 2) }}</span>
                            </div>
                            <p class="text-[11px] text-emerald-800">
                                <i class="fas fa-bolt text-emerald-600 mr-1"></i>
                                Razorpay Payment ID: <strong class="font-mono text-emerald-900">{{ $booking->razorpay_payment_id ?: 'Via Transaction' }}</strong>
                            </p>
                            <p class="text-[10px] text-emerald-700">
                                Approving this cancellation will automatically trigger an instant refund of ₹{{ number_format($booking->refundable_amount, 2) }} back to the customer's payment method via Razorpay API.
                            </p>
                        </div>
                    @else
                        <div class="p-3 rounded-xl bg-gray-50 border border-gray-200 text-gray-700 text-xs">
                            <i class="fas fa-money-bill-wave text-gray-500 mr-1"></i>
                            <strong>Payment Method:</strong> {{ $booking->payment_method ?: 'Cash on collection' }}. No online gateway refund required.
                        </div>
                    @endif
                </div>

                <!-- Approve Form -->
                <form action="{{ route('admin.bookings.cancellation.approve', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to approve this cancellation? @if($booking->hasOnlinePayment() && $booking->refundable_amount > 0)An automatic refund of ₹{{ number_format($booking->refundable_amount, 2) }} will be processed via Razorpay.@endif')" class="pt-2 border-t border-rose-100 space-y-3">
                    @csrf
                    <div>
                        <label class="block text-[11px] font-bold text-gray-700 mb-1">Admin Notes / Remarks for Patient (Optional)</label>
                        <input type="text" name="admin_notes" placeholder="e.g. Cancellation approved and refund initiated." class="w-full text-xs font-medium border border-gray-300 rounded-xl px-3 py-2 bg-white">
                    </div>

                    @if($booking->hasOnlinePayment() && $booking->refundable_amount > 0)
                        <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-gray-800">
                            <input type="checkbox" name="auto_refund" value="1" checked class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 w-4 h-4">
                            <span>Auto-refund ₹{{ number_format($booking->refundable_amount, 2) }} via Razorpay</span>
                        </label>
                    @endif

                    <div class="flex items-center gap-2">
                        <button type="submit" class="flex-1 py-2.5 px-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs transition shadow-sm flex items-center justify-center gap-1.5 cursor-pointer">
                            <i class="fas fa-check-circle"></i>
                            <span>Approve & Cancel</span>
                        </button>
                        <button type="button" onclick="document.getElementById('rejectCancellationBox').classList.toggle('hidden')" class="py-2.5 px-3 rounded-xl bg-rose-100 hover:bg-rose-200 text-rose-800 font-bold text-xs transition cursor-pointer flex items-center gap-1">
                            <i class="fas fa-times"></i>
                            <span>Decline</span>
                        </button>
                    </div>
                </form>

                <!-- Decline Drawer / Form -->
                <form id="rejectCancellationBox" action="{{ route('admin.bookings.cancellation.reject', $booking->id) }}" method="POST" class="hidden p-3.5 rounded-xl bg-white border border-rose-200 space-y-2.5">
                    @csrf
                    <label class="block text-[11px] font-bold text-rose-900">Reason for Declining Request <span class="text-rose-500">*</span></label>
                    <input type="text" name="rejection_reason" required placeholder="e.g. Phlebotomist has already arrived at location..." class="w-full text-xs font-medium border border-rose-300 rounded-lg px-3 py-2 bg-white">
                    <button type="submit" class="w-full py-2 rounded-lg bg-rose-700 hover:bg-rose-800 text-white font-bold text-xs transition shadow-xs">
                        Confirm Decline
                    </button>
                </form>
            </div>
        @elseif($booking->status === 'Cancelled')
            <div class="bg-white rounded-2xl shadow-sm border border-rose-200 p-6 space-y-3">
                <div class="flex items-center justify-between border-b pb-3">
                    <h3 class="text-base font-bold text-rose-800 flex items-center gap-2">
                        <i class="fas fa-ban text-rose-600"></i>
                        <span>Booking Cancelled</span>
                    </h3>
                    <span class="px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-wider bg-rose-100 text-rose-800">
                        {{ $booking->cancellation_request_status === 'approved' ? 'Customer Requested' : 'Cancelled by Admin' }}
                    </span>
                </div>

                @if($booking->cancellation_reason)
                    <div class="text-xs">
                        <span class="text-gray-500 font-semibold">Reason:</span>
                        <p class="font-bold text-gray-800">{{ $booking->cancellation_reason }}</p>
                    </div>
                @endif

                @if($booking->cancellation_admin_notes)
                    <div class="text-xs">
                        <span class="text-gray-500 font-semibold">Admin Notes:</span>
                        <p class="font-medium text-gray-800">{{ $booking->cancellation_admin_notes }}</p>
                    </div>
                @endif

                <!-- Refund Status Summary -->
                <div class="p-3 rounded-xl border text-xs {{ $booking->refund_status === 'refunded' ? 'bg-emerald-50 border-emerald-200 text-emerald-950' : ($booking->refund_status === 'failed' ? 'bg-rose-50 border-rose-200 text-rose-950' : 'bg-gray-50 border-gray-200 text-gray-700') }}">
                    <div class="flex items-center justify-between font-bold">
                        <span>Gateway Refund:</span>
                        @if($booking->refund_status === 'refunded')
                            <span class="text-emerald-700 font-black">₹{{ number_format($booking->refund_amount, 2) }} Refunded</span>
                        @elseif($booking->refund_status === 'failed')
                            <span class="text-rose-700 font-black">Failed (Manual Check Required)</span>
                        @else
                            <span class="text-gray-600 font-semibold">Not Applicable</span>
                        @endif
                    </div>
                    @if($booking->refund_id)
                        <p class="text-[11px] font-mono mt-1 text-emerald-800">
                            Refund ID: <strong>{{ $booking->refund_id }}</strong>
                        </p>
                    @endif
                    @if($booking->refunded_at)
                        <p class="text-[10px] text-gray-500 mt-0.5">
                            Processed on: {{ $booking->refunded_at->format('M d, Y • h:i A') }}
                        </p>
                    @endif
                </div>
            </div>
        @elseif($booking->cancellation_request_status === 'rejected')
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 space-y-2">
                <div class="flex items-center justify-between border-b pb-2">
                    <h3 class="text-xs font-black uppercase text-gray-700 flex items-center gap-1.5">
                        <i class="fas fa-times-circle text-rose-500"></i> Cancellation Request Declined
                    </h3>
                    <span class="text-[10px] font-bold text-gray-400">
                        {{ $booking->cancellation_processed_at ? $booking->cancellation_processed_at->format('M d, Y') : '' }}
                    </span>
                </div>
                <p class="text-xs text-gray-600">
                    <strong class="text-gray-700">Decline Note:</strong> {{ $booking->cancellation_admin_notes ?: 'No note provided' }}
                </p>
            </div>
        @endif
        
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
                        {{ $booking->sample_status ?: 'Assigned' }}
                    </span>
                @else
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">
                        Unassigned
                    </span>
                @endif
            </div>

            @if($booking->agent)
                @if($booking->agent->status !== 'active')
                    <div class="p-3 bg-rose-50 border border-rose-200 rounded-xl mb-3 text-xs text-rose-800 flex items-center gap-2">
                        <i class="fas fa-exclamation-triangle text-rose-600 text-sm"></i>
                        <div>
                            <span class="font-bold">Assigned Phlebotomist is Deactivated!</span>
                            <p class="text-[11px] text-rose-700 mt-0.5">Please reassign this booking to an active phlebotomist below.</p>
                        </div>
                    </div>
                @endif
                <div class="p-3.5 {{ $booking->agent->status === 'active' ? 'bg-teal-50/70 border-teal-100' : 'bg-rose-50/40 border-rose-200' }} rounded-xl border mb-4 space-y-2">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="font-bold text-teal-950 text-sm flex items-center gap-1.5">
                                <i class="fas fa-user-circle text-teal-600"></i> {{ $booking->agent->name }}
                                @if($booking->agent->status !== 'active')
                                    <span class="px-1.5 py-0.5 rounded text-[10px] bg-rose-100 text-rose-800 uppercase font-black tracking-wider">Deactivated</span>
                                @endif
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
                                <span class="text-emerald-700 font-black">₹{{ number_format($booking->amount) }} Collected (Cash)</span>
                            @else
                                <span class="text-emerald-700 font-black">Paid Online (₹{{ number_format($booking->amount) }})</span>
                            @endif
                        @else
                            <div class="text-right">
                                <span class="text-amber-700 font-black text-sm">₹{{ number_format($booking->due_amount) }} Cash Due</span>
                                @if(($booking->paid_amount ?? 0) > 0)
                                    <span class="block text-[10px] text-gray-500 font-medium">(New tests added • ₹{{ number_format($booking->paid_amount) }} already paid)</span>
                                @endif
                            </div>
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
                        <p class="text-amber-700 mt-0.5">
                            Assign a phlebotomist below so they can view this client's address, pick up samples, and collect cash
                            @if($booking->due_amount > 0)
                                (<strong>₹{{ number_format($booking->due_amount) }} Due</strong>)
                            @endif.
                        </p>
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
                        @if($booking->agent && $booking->agent->status !== 'active')
                            <option value="{{ $booking->agent->id }}" selected disabled class="text-rose-600 font-bold">
                                ⚠️ {{ $booking->agent->name }} (Currently Deactivated - Please Reassign)
                            </option>
                        @endif
                        @foreach($agents as $agent)
                            <option value="{{ $agent->id }}" {{ (int)$booking->agent_id === (int)$agent->id ? 'selected' : '' }}>
                                {{ $agent->name }} ({{ $agent->phone }}) {{ $agent->city ? '• ' . $agent->city : '' }}
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
            
            <div class="space-y-3 mb-4 text-xs sm:text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Method</span>
                    <span class="font-medium text-gray-800">{{ $booking->payment_method }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Status</span>
                    <span class="font-bold {{ $booking->payment_status == 'Paid' ? 'text-green-600' : 'text-orange-600' }}">{{ $booking->payment_status }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Total Booking Bill</span>
                    <span class="font-bold text-gray-800">₹{{ number_format($booking->amount, 0) }}</span>
                </div>
                @if(($booking->paid_amount ?? 0) > 0)
                <div class="flex justify-between text-emerald-700">
                    <span class="font-semibold">Already Paid</span>
                    <span class="font-bold">₹{{ number_format($booking->paid_amount, 0) }}</span>
                </div>
                @endif
                <div class="border-t pt-2 flex justify-between items-center">
                    <span class="font-bold text-gray-800">Amount To Collect</span>
                    <span class="text-xl font-black {{ $booking->due_amount > 0 ? 'text-amber-600' : 'text-teal-600' }}">
                        ₹{{ number_format($booking->due_amount, 0) }}
                    </span>
                </div>
            </div>
        </div>

        @if(config('pathology.enabled', false))
        <!-- ═══════════════ PATHOLOGY LIS INTEGRATION CARD ═══════════════ -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between border-b pb-3 mb-4">
                <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-microscope text-teal-600"></i>
                    Pathology LIS Sync
                </h3>
                @if($booking->lis_booking_reference)
                    <span class="inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 border border-emerald-200">
                        <i class="fas fa-check-circle text-xs"></i> Synced
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 border border-amber-200">
                        <i class="fas fa-cloud-upload-alt text-xs"></i> Unsynced
                    </span>
                @endif
            </div>

            <div class="space-y-3 mb-4 text-xs">
                @if($booking->lis_booking_reference)
                    <div class="p-3 bg-teal-50/60 rounded-xl border border-teal-100 space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-teal-800 font-semibold">LIS Booking Ref:</span>
                            <span class="font-mono font-bold text-teal-900 bg-white px-2 py-0.5 rounded border border-teal-200 select-all">
                                {{ $booking->lis_booking_reference }}
                            </span>
                        </div>
                        @if($booking->lis_bill_number)
                        <div class="flex justify-between items-center">
                            <span class="text-teal-800 font-semibold">LIS Bill Number:</span>
                            <span class="font-mono font-bold text-teal-900 bg-white px-2 py-0.5 rounded border border-teal-200 select-all">
                                {{ $booking->lis_bill_number }}
                            </span>
                        </div>
                        @endif
                        <div class="flex justify-between items-center">
                            <span class="text-teal-800 font-semibold">LIS Processing Status:</span>
                            <span class="font-bold uppercase tracking-wider text-[11px] px-2 py-0.5 rounded bg-teal-100 text-teal-800">
                                {{ $booking->lis_status ?: 'In Queue' }}
                            </span>
                        </div>
                        @if($booking->lis_synced_at)
                        <div class="text-[11px] text-teal-700 pt-1 border-t border-teal-200/50 flex items-center justify-between">
                            <span>Last Transmitted:</span>
                            <span>{{ $booking->lis_synced_at->format('M d, Y h:i A') }}</span>
                        </div>
                        @endif
                    </div>
                @else
                    <div class="p-3 bg-amber-50 rounded-xl border border-amber-200 text-amber-800 text-xs">
                        <p class="font-bold flex items-center gap-1.5 mb-1">
                            <i class="fas fa-info-circle text-amber-600"></i> Not Pushed to LIS
                        </p>
                        <p class="text-amber-700">This order has not been transmitted to your central laboratory software yet.</p>
                    </div>
                @endif
            </div>

            <form action="{{ route('admin.bookings.push_lis', $booking->id) }}" method="POST" onsubmit="return confirm('{{ $booking->lis_booking_reference ? 'Re-transmit this booking to Pathology LIS?' : 'Push this booking to Pathology LIS now?' }}')">
                @csrf
                <button type="submit" class="w-full flex justify-center items-center gap-2 py-2.5 px-4 rounded-xl text-xs font-bold shadow-sm transition {{ $booking->lis_booking_reference ? 'bg-gray-100 hover:bg-gray-200 text-gray-700 border border-gray-300' : 'bg-teal-600 hover:bg-teal-700 text-white' }}">
                    <i class="fas {{ $booking->lis_booking_reference ? 'fa-rotate' : 'fa-paper-plane' }}"></i>
                    {{ $booking->lis_booking_reference ? 'Re-push / Resync to LIS' : 'Push Booking to LIS Now' }}
                </button>
            </form>
        </div>
        @endif

        <!-- ═══════════════ REPORT MANAGEMENT CARD ═══════════════ -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between border-b pb-3 mb-4">
                <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-file-medical-alt text-emerald-600"></i>
                    Test Report
                </h3>
                @if($booking->report_file_path)
                    <span class="inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 border border-emerald-200">
                        <i class="fas fa-check-circle text-xs"></i> Uploaded
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 border border-amber-200">
                        <i class="fas fa-clock text-xs"></i> Pending
                    </span>
                @endif
            </div>

            {{-- Current Report Display --}}
            @if($booking->report_file_path)
                <div class="mb-4 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200">
                    <p class="text-xs font-bold text-emerald-800 mb-2 flex items-center gap-1.5">
                        <i class="fas fa-file-pdf"></i> Current Report
                    </p>
                    <div class="flex items-center gap-2 flex-wrap">
                        @if(str_starts_with($booking->report_file_path, 'http'))
                            {{-- External link --}}
                            <a href="{{ $booking->report_file_path }}" target="_blank"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition">
                                <i class="fas fa-external-link-alt"></i> Open Link
                            </a>
                        @else
                            {{-- Stored file --}}
                            <a href="{{ asset('storage/' . $booking->report_file_path) }}" target="_blank"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition">
                                <i class="fas fa-eye"></i> View Report
                            </a>
                            <a href="{{ asset('storage/' . $booking->report_file_path) }}" download
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white hover:bg-gray-50 border border-emerald-300 text-emerald-800 text-xs font-bold transition">
                                <i class="fas fa-download"></i> Download
                            </a>
                        @endif
                        {{-- Remove report --}}
                        <form method="POST" action="{{ route('admin.bookings.report.delete', $booking->id) }}"
                              onsubmit="return confirm('Remove this report? The customer will no longer see it.')"
                              style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 border border-rose-200 text-rose-600 text-xs font-bold transition">
                                <i class="fas fa-trash-alt"></i> Remove
                            </button>
                        </form>
                    </div>
                    @if(!str_starts_with($booking->report_file_path, 'http'))
                        <p class="text-[10px] text-emerald-600 mt-2 font-mono truncate">
                            {{ basename($booking->report_file_path) }}
                        </p>
                    @endif
                </div>
                <p class="text-xs font-bold text-gray-600 mb-3">
                    <i class="fas fa-edit text-teal-500 mr-1"></i> Replace / Update Report:
                </p>
            @else
                <p class="text-xs text-gray-500 mb-4">
                    Upload the diagnostic PDF or paste an external report link. The patient will instantly see it in their portal.
                </p>
            @endif

            {{-- Upload / Link Form --}}
            <form action="{{ route('admin.bookings.report.upload', $booking->id) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  id="reportForm">
                @csrf

                {{-- Toggle: File vs Link --}}
                <div class="flex gap-2 mb-4" id="reportTypeTabs">
                    <button type="button" data-type="file"
                            class="report-tab flex-1 py-2 rounded-xl text-xs font-bold border transition active-tab
                                   bg-teal-600 text-white border-teal-600"
                            onclick="switchReportTab('file')">
                        <i class="fas fa-upload mr-1"></i> Upload PDF
                    </button>
                    <button type="button" data-type="link"
                            class="report-tab flex-1 py-2 rounded-xl text-xs font-bold border transition
                                   bg-white text-gray-600 border-gray-300 hover:border-teal-400"
                            onclick="switchReportTab('link')">
                        <i class="fas fa-link mr-1"></i> Paste Link
                    </button>
                </div>

                <input type="hidden" name="report_type" id="reportTypeInput" value="file">

                {{-- File Upload Panel --}}
                <div id="filePanel">
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Select PDF / Image File</label>
                    <div class="border-2 border-dashed border-gray-300 hover:border-teal-400 rounded-xl p-4 text-center cursor-pointer transition bg-gray-50/60"
                         onclick="document.getElementById('reportFileInput').click()">
                        <i class="fas fa-cloud-upload-alt text-2xl text-teal-500 mb-1"></i>
                        <p class="text-xs font-bold text-gray-600">Click to browse</p>
                        <p class="text-[11px] text-gray-400 mt-0.5">PDF, JPG or PNG • Max 20 MB</p>
                        <p class="text-[11px] text-teal-600 font-semibold mt-1" id="selectedFileName">No file chosen</p>
                    </div>
                    <input type="file" name="report_file" id="reportFileInput" accept=".pdf,.jpg,.jpeg,.png" class="hidden"
                           onchange="document.getElementById('selectedFileName').textContent = this.files[0]?.name || 'No file chosen'">
                </div>

                {{-- Link Panel --}}
                <div id="linkPanel" class="hidden">
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Report URL / Drive Link</label>
                    <input type="url" name="report_link" id="reportLinkInput"
                           placeholder="https://drive.google.com/... or any PDF URL"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 text-sm bg-white outline-none transition">
                    <p class="text-[11px] text-gray-400 mt-1.5">
                        <i class="fas fa-info-circle text-teal-500"></i>
                        Paste a Google Drive, Dropbox, or any direct PDF/report link.
                    </p>
                </div>

                @error('report_file')
                    <p class="text-xs text-rose-500 mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                @enderror
                @error('report_link')
                    <p class="text-xs text-rose-500 mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                @enderror

                <button type="submit"
                        class="w-full mt-4 flex justify-center items-center gap-2 py-3 rounded-xl bg-gradient-to-r from-teal-600 to-teal-700 hover:from-teal-500 hover:to-teal-600 text-white text-sm font-bold shadow-sm transition">
                    <i class="fas fa-cloud-upload-alt"></i>
                    {{ $booking->report_file_path ? 'Update Report' : 'Upload Report' }}
                </button>
            </form>

            <p class="text-[11px] text-gray-400 text-center mt-3">
                <i class="fas fa-shield-alt text-teal-500"></i>
                Report will be instantly visible in the patient's portal.
            </p>
        </div>
        {{-- ══════════════════════════════════════════════════════ --}}

    </div>
</div>

<!-- Admin Modify Tests Modal -->
<div id="adminModifyTestsModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Backdrop with blur -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" onclick="closeAdminModifyTestsModal()"></div>

    <div class="flex min-h-full items-center justify-center p-3 sm:p-4 text-center">
        <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all w-full max-w-3xl border border-slate-100 my-8">
            
            <!-- Header -->
            <div class="bg-gradient-to-r from-teal-900 via-teal-800 to-slate-900 px-6 py-4 text-white flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-2.5 flex-wrap">
                        <h3 class="text-base sm:text-lg font-black tracking-tight flex items-center gap-2">
                            <i class="fas fa-flask-vial text-teal-400"></i>
                            <span>Manage Diagnostic Tests & Packages</span>
                        </h3>
                        <span class="px-2.5 py-0.5 rounded-lg bg-white/10 font-mono text-xs font-bold text-teal-200 border border-white/10">
                            #{{ $booking->booking_reference }}
                        </span>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider {{ $booking->payment_status === 'Paid' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-400/30' : 'bg-amber-500/20 text-amber-300 border border-amber-400/30' }}">
                            {{ $booking->payment_status === 'Paid' ? 'Paid' : 'Payment: ' . $booking->payment_status }}
                        </span>
                    </div>
                    <p class="text-xs text-teal-100/80 mt-1">Add tests, remove existing tests, and customize booking pricing.</p>
                </div>
                <button type="button" onclick="closeAdminModifyTestsModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition cursor-pointer flex-shrink-0">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>

            <!-- Body -->
            <form id="adminUpdateTestsForm" action="{{ route('admin.bookings.updateTests', $booking->id) }}" method="POST">
                @csrf
                <input type="hidden" name="tests" id="adminTestsPayloadInput">

                <div class="p-6 space-y-6 max-h-[75vh] overflow-y-auto bg-slate-50/50">

                    <!-- 1. Search & Add Test or Package -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-4 sm:p-5 shadow-2xs space-y-3 relative">
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-700 flex items-center gap-1.5">
                            <i class="fas fa-search-plus text-teal-700"></i>
                            <span>Search & Add Test / Package</span>
                        </label>
                        <div class="relative">
                            <input 
                                type="text" 
                                id="adminCatalogSearchInput" 
                                placeholder="Search by name (e.g. CBC, Liver, Lipid, Thyroid, Fever, Vitamin D, Full Body)..." 
                                class="w-full px-4 py-2.5 pl-10 text-xs font-bold bg-slate-50 border border-slate-300 rounded-xl outline-none focus:bg-white focus:ring-2 focus:ring-teal-700 transition"
                                oninput="filterAdminCatalog(this.value)"
                                autocomplete="off"
                            >
                            <i class="fas fa-search absolute left-3.5 top-3 text-slate-400 text-xs"></i>
                            <button type="button" onclick="clearAdminSearch()" id="adminClearSearchBtn" class="hidden absolute right-3 top-2.5 text-xs text-slate-400 hover:text-slate-600">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </div>

                        <!-- Search Results Dropdown -->
                        <div id="adminCatalogSearchResults" class="hidden absolute left-4 right-4 top-full mt-1 bg-white border border-slate-200 rounded-2xl shadow-2xl z-40 max-h-64 overflow-y-auto divide-y divide-slate-100"></div>
                    </div>

                    <!-- 2. Currently Selected Tests List -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-4 sm:p-5 shadow-2xs space-y-3">
                        <div class="flex items-center justify-between">
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-700 flex items-center gap-1.5">
                                <i class="fas fa-list-check text-teal-700"></i>
                                <span>Included Tests & Packages</span>
                            </label>
                            <span id="adminSelectedCountBadge" class="text-xs font-black px-2.5 py-0.5 rounded-full bg-teal-50 text-teal-800 border border-teal-200">
                                0 items
                            </span>
                        </div>

                        <div id="adminSelectedTestsContainer" class="space-y-2.5 max-h-64 overflow-y-auto pr-1">
                            <!-- Injected dynamically via JS -->
                        </div>

                        <div id="adminEmptyTestsWarning" class="hidden p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 text-xs text-center font-bold">
                            <i class="fas fa-exclamation-triangle text-amber-600 mr-1.5"></i>
                            At least one test or package must be included in the booking.
                        </div>
                    </div>

                    <!-- 3. Financial Calculation & Fee Adjustments -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-4 sm:p-5 shadow-2xs space-y-4">
                        <h4 class="text-xs font-black uppercase tracking-wider text-slate-700 flex items-center gap-1.5">
                            <i class="fas fa-calculator text-teal-700"></i>
                            <span>Pricing & Payment Calculation</span>
                        </h4>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 flex justify-between items-center">
                                <span class="font-bold text-slate-600">Tests Subtotal:</span>
                                <span class="text-sm font-black text-slate-900" id="adminSubtotalDisplay">₹0</span>
                            </div>

                            <div>
                                <label class="block font-bold text-slate-600 mb-1 flex items-center justify-between">
                                    <span>Collection Fee (₹):</span>
                                    <span class="text-[10px] text-teal-700 font-semibold">Free threshold: ₹{{ number_format(\App\Models\Setting::get('free_collection_threshold', 500), 0) }}</span>
                                </label>
                                <input 
                                    type="number" 
                                    step="1" 
                                    min="0" 
                                    id="adminCollectionFeeInput" 
                                    name="collection_fee" 
                                    value="{{ (float) $booking->collection_fee }}"
                                    class="w-full px-3 py-2 font-bold text-xs bg-slate-50 border border-slate-300 rounded-xl outline-none focus:bg-white focus:ring-2 focus:ring-teal-700"
                                    oninput="recalculateAdminTotals()"
                                >
                            </div>

                            @php
                                $totalDiscount = ($booking->discount_amount ?? 0) + ($booking->coins_discount ?? 0);
                            @endphp
                            @if($totalDiscount > 0)
                            <div class="p-3 bg-emerald-50/70 rounded-xl border border-emerald-100 flex justify-between items-center sm:col-span-2">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-tag text-emerald-600"></i>
                                    <span class="font-bold text-emerald-900">Applied Discount (Coupon & Coins):</span>
                                </div>
                                <span class="text-sm font-black text-emerald-800">-₹{{ number_format($totalDiscount, 0) }}</span>
                            </div>
                            @endif

                            <div class="p-3 bg-teal-50/80 rounded-xl border border-teal-200 flex justify-between items-center sm:col-span-2">
                                <div>
                                    <span class="font-black text-teal-950 text-sm block">Final Total Booking Amount:</span>
                                    <span class="text-[11px] text-teal-700 font-medium">Subtotal + Collection Fee - Discounts</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-bold text-teal-800">₹</span>
                                    <input 
                                        type="number" 
                                        step="0.01" 
                                        min="0" 
                                        id="adminFinalAmountInput" 
                                        name="amount" 
                                        value="{{ (float) $booking->amount }}"
                                        class="w-32 px-3 py-1.5 text-base font-black text-teal-900 bg-white border border-teal-300 rounded-xl text-right outline-none focus:ring-2 focus:ring-teal-600"
                                        oninput="recalculateAdminTotals()"
                                    >
                                </div>
                            </div>

                            @php
                                $modalPaidAmt = (float) ($booking->paid_amount ?? ($booking->payment_status === 'Paid' ? $booking->amount : 0));
                            @endphp
                            <div id="adminDueBreakdownCard" class="p-3.5 bg-amber-50/90 rounded-xl border border-amber-200 sm:col-span-2 {{ $modalPaidAmt > 0 ? '' : 'hidden' }}">
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-amber-900 font-semibold flex items-center gap-1.5">
                                        <i class="fas fa-check-circle text-emerald-600"></i> Amount Customer Already Paid:
                                    </span>
                                    <span class="font-black text-slate-900" id="adminPrevPaidDisplay">₹{{ number_format($modalPaidAmt, 0) }}</span>
                                </div>
                                <div class="flex justify-between items-center text-xs mt-2 pt-2 border-t border-amber-200 font-black">
                                    <span class="text-amber-950 flex items-center gap-1.5">
                                        <i class="fas fa-hand-holding-usd text-amber-600"></i>
                                        <span>Doorstep Cash To Be Collected (New Tests):</span>
                                    </span>
                                    <span class="text-base text-amber-800 font-black" id="adminDueToCollectDisplay">₹0</span>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Payment Status Setting -->
                        <div class="pt-3 border-t border-slate-100 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Payment Status</label>
                                <select 
                                    name="payment_status" 
                                    id="adminPaymentStatusSelect" 
                                    class="w-full px-3 py-2 text-xs font-bold bg-slate-50 border border-slate-300 rounded-xl outline-none focus:bg-white focus:ring-2 focus:ring-teal-700"
                                >
                                    <option value="Paid" {{ $booking->payment_status === 'Paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="Partial Online / Cash on Collection" {{ $booking->payment_status === 'Partial Online / Cash on Collection' ? 'selected' : '' }}>Partial Online / Cash on Collection</option>
                                    <option value="Pending" {{ $booking->payment_status === 'Pending' ? 'selected' : '' }}>Pending</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Payment Method</label>
                                <input 
                                    type="text" 
                                    name="payment_method" 
                                    value="{{ $booking->payment_method }}" 
                                    placeholder="e.g. Online, Cash, UPI" 
                                    class="w-full px-3 py-2 text-xs font-bold bg-slate-50 border border-slate-300 rounded-xl outline-none focus:bg-white focus:ring-2 focus:ring-teal-700"
                                >
                            </div>
                        </div>

                        <!-- Helper banner for paid booking amount difference -->
                        <div id="adminDiffAlert" class="hidden p-3 rounded-xl border text-xs"></div>
                    </div>

                </div>

                <!-- Footer -->
                <div class="px-6 py-4 bg-slate-100 border-t border-slate-200 flex items-center justify-between gap-3">
                    <button 
                        type="button" 
                        onclick="closeAdminModifyTestsModal()" 
                        class="px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-200 rounded-xl transition cursor-pointer"
                    >
                        Cancel
                    </button>
                    <button 
                        type="submit" 
                        id="adminSaveTestsBtn" 
                        class="px-6 py-2.5 bg-teal-600 hover:bg-teal-700 text-white text-xs font-black rounded-xl transition shadow-md flex items-center gap-2 cursor-pointer"
                    >
                        <i class="fas fa-check-circle"></i>
                        <span>Save Tests & Update Booking</span>
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function switchReportTab(type) {
        document.getElementById('reportTypeInput').value = type;
        document.getElementById('filePanel').classList.toggle('hidden', type !== 'file');
        document.getElementById('linkPanel').classList.toggle('hidden', type !== 'link');

        document.querySelectorAll('.report-tab').forEach(btn => {
            const isActive = btn.dataset.type === type;
            btn.classList.toggle('bg-teal-600',   isActive);
            btn.classList.toggle('text-white',     isActive);
            btn.classList.toggle('border-teal-600',isActive);
            btn.classList.toggle('bg-white',       !isActive);
            btn.classList.toggle('text-gray-600',  !isActive);
            btn.classList.toggle('border-gray-300',!isActive);
        });
    }

    // Admin Tests Modification State
    const adminCatalogTests = @json($allTests ?? []);
    const adminCatalogPackages = @json($allPackages ?? []);
    let adminCurrentTests = @json($booking->test_details ?? []);
    const adminIsHomeCollection = {{ str_contains(strtolower((string) $booking->collection_type), 'home') ? 'true' : 'false' }};
    const adminExistingDiscount = {{ (float) (($booking->discount_amount ?? 0) + ($booking->coins_discount ?? 0)) }};
    const adminOriginalAmount = {{ (float) $booking->amount }};
    const adminOriginalPaymentStatus = @json($booking->payment_status);
    const adminPaidAmount = {{ (float) ($booking->paid_amount ?? ($booking->payment_status === 'Paid' ? $booking->amount : 0)) }};
    const adminFeeEnabled = {{ \App\Models\Setting::get('collection_fee_enabled', '1') == '1' ? 'true' : 'false' }};
    const adminStandardFee = {{ (float) \App\Models\Setting::get('home_collection_fee', '100') }};
    const adminFreeThreshold = {{ (float) \App\Models\Setting::get('free_collection_threshold', '500') }};
    let adminCollectionFeeManualOverride = false;

    function openAdminModifyTestsModal() {
        const raw = @json($booking->test_details ?? []);
        adminCurrentTests = Array.isArray(raw) ? JSON.parse(JSON.stringify(raw)) : [];
        adminCollectionFeeManualOverride = false;
        renderAdminTestsList();
        recalculateAdminTotals();
        document.getElementById('adminModifyTestsModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeAdminModifyTestsModal() {
        document.getElementById('adminModifyTestsModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        clearAdminSearch();
    }

    function renderAdminTestsList() {
        const container = document.getElementById('adminSelectedTestsContainer');
        const countBadge = document.getElementById('adminSelectedCountBadge');
        const emptyWarning = document.getElementById('adminEmptyTestsWarning');
        const saveBtn = document.getElementById('adminSaveTestsBtn');

        container.innerHTML = '';
        countBadge.innerText = `${adminCurrentTests.length} ${adminCurrentTests.length === 1 ? 'item' : 'items'}`;

        if (adminCurrentTests.length === 0) {
            emptyWarning.classList.remove('hidden');
            saveBtn.disabled = true;
            saveBtn.classList.add('opacity-50', 'cursor-not-allowed');
            return;
        }

        emptyWarning.classList.add('hidden');
        saveBtn.disabled = false;
        saveBtn.classList.remove('opacity-50', 'cursor-not-allowed');

        adminCurrentTests.forEach((item, index) => {
            const isPackage = (item.type || 'test') === 'package';
            const price = parseFloat(item.price || 0);

            const row = document.createElement('div');
            row.className = 'flex items-center justify-between gap-3 p-3 bg-slate-50 hover:bg-slate-100/80 rounded-xl border border-slate-200 transition';
            row.innerHTML = `
                <div class="flex items-center gap-3 min-w-0 flex-1">
                    <div class="w-8 h-8 rounded-lg ${isPackage ? 'bg-amber-100 text-amber-700' : 'bg-teal-100 text-teal-700'} flex items-center justify-center text-xs flex-shrink-0 font-bold">
                        <i class="fas ${isPackage ? 'fa-box-open' : 'fa-flask'}"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-1.5 flex-wrap">
                            <span class="font-extrabold text-slate-800 text-xs truncate">${item.name || item.title || 'Diagnostic Test'}</span>
                            <span class="text-[9px] font-black px-1.5 py-0.2 rounded-full ${isPackage ? 'bg-amber-100 text-amber-800 border border-amber-200' : 'bg-blue-100 text-blue-800 border border-blue-200'}">
                                ${isPackage ? 'Package' : 'Test'}
                            </span>
                            ${item.sample_type ? `<span class="text-[9px] font-bold text-slate-500 bg-white px-1.5 py-0.2 rounded border border-slate-200">${item.sample_type}</span>` : ''}
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-2 flex-shrink-0">
                    <div class="flex items-center gap-1 bg-white border border-slate-300 rounded-lg px-2 py-1">
                        <span class="text-xs font-bold text-slate-500">₹</span>
                        <input 
                            type="number" 
                            step="1" 
                            min="0" 
                            value="${price}" 
                            class="w-16 text-xs font-black text-slate-800 text-right outline-none bg-transparent"
                            onchange="updateAdminItemPrice(${index}, this.value)"
                            oninput="updateAdminItemPrice(${index}, this.value)"
                        >
                    </div>

                    <button 
                        type="button" 
                        onclick="removeAdminTest(${index})" 
                        class="w-7 h-7 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 flex items-center justify-center text-xs transition cursor-pointer"
                        title="Remove Test"
                    >
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            `;
            container.appendChild(row);
        });
    }

    function updateAdminItemPrice(index, newPrice) {
        const p = parseFloat(newPrice);
        if (!isNaN(p) && p >= 0 && adminCurrentTests[index]) {
            adminCurrentTests[index].price = p;
            recalculateAdminTotals();
        }
    }

    function removeAdminTest(index) {
        adminCurrentTests.splice(index, 1);
        renderAdminTestsList();
        recalculateAdminTotals();
    }

    function addAdminItem(item, type) {
        const exists = adminCurrentTests.some(t => String(t.id) === String(item.id) && (t.type || 'test') === type);
        if (exists) {
            alert(`'${item.name}' is already included in this booking.`);
            return;
        }

        const isPackage = type === 'package';
        const price = parseFloat(item.price || 0);

        adminCurrentTests.push({
            id: item.id,
            name: item.name,
            title: item.name,
            type: type,
            price: price,
            sample_type: item.sample_type || (isPackage ? null : 'Blood'),
            parameters_count: isPackage ? (item.parameters_count || 0) : null
        });

        clearAdminSearch();
        renderAdminTestsList();
        recalculateAdminTotals();
    }

    function filterAdminCatalog(query) {
        const resultsBox = document.getElementById('adminCatalogSearchResults');
        const clearBtn = document.getElementById('adminClearSearchBtn');
        const q = (query || '').trim().toLowerCase();

        if (q.length < 1) {
            resultsBox.classList.add('hidden');
            resultsBox.innerHTML = '';
            clearBtn.classList.add('hidden');
            return;
        }

        clearBtn.classList.remove('hidden');

        const matchingTests = adminCatalogTests.filter(t => (t.name || '').toLowerCase().includes(q));
        const matchingPackages = adminCatalogPackages.filter(p => (p.name || '').toLowerCase().includes(q));
        const totalResults = matchingTests.length + matchingPackages.length;

        if (totalResults === 0) {
            resultsBox.innerHTML = `
                <div class="p-4 text-center text-xs text-slate-500 font-bold">
                    <i class="fas fa-search text-slate-400 mb-1 block text-base"></i>
                    No tests or health packages match "${q}".
                </div>
            `;
            resultsBox.classList.remove('hidden');
            return;
        }

        let html = '';

        if (matchingPackages.length > 0) {
            html += `<div class="px-3.5 py-1.5 bg-amber-50 text-[10px] font-black uppercase tracking-wider text-amber-800">Health Packages (${matchingPackages.length})</div>`;
            matchingPackages.forEach(pkg => {
                const isSelected = adminCurrentTests.some(t => String(t.id) === String(pkg.id) && t.type === 'package');
                const pkgJson = JSON.stringify(pkg).replace(/'/g, "&apos;");
                html += `
                    <div class="p-3 hover:bg-slate-50 flex items-center justify-between gap-3 transition">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <div class="w-7 h-7 rounded-lg bg-amber-100 text-amber-800 flex items-center justify-center text-xs flex-shrink-0 font-bold">
                                <i class="fas fa-box-open"></i>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-bold text-slate-800 truncate">${pkg.name}</p>
                                <span class="text-[10px] text-slate-400">Health Package</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2.5 flex-shrink-0">
                            <span class="text-xs font-black text-slate-800">₹${pkg.price}</span>
                            ${isSelected ? `
                                <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-400 text-[11px] font-bold">Added</span>
                            ` : `
                                <button type="button" onclick='addAdminItem(${pkgJson}, "package")' class="px-2.5 py-1 rounded-lg bg-teal-600 hover:bg-teal-700 text-white text-[11px] font-black shadow-2xs transition cursor-pointer">
                                    + Add
                                </button>
                            `}
                        </div>
                    </div>
                `;
            });
        }

        if (matchingTests.length > 0) {
            html += `<div class="px-3.5 py-1.5 bg-teal-50 text-[10px] font-black uppercase tracking-wider text-teal-800">Individual Tests (${matchingTests.length})</div>`;
            matchingTests.forEach(test => {
                const isSelected = adminCurrentTests.some(t => String(t.id) === String(test.id) && (t.type || 'test') === 'test');
                const testJson = JSON.stringify(test).replace(/'/g, "&apos;");
                html += `
                    <div class="p-3 hover:bg-slate-50 flex items-center justify-between gap-3 transition">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <div class="w-7 h-7 rounded-lg bg-teal-100 text-teal-800 flex items-center justify-center text-xs flex-shrink-0 font-bold">
                                <i class="fas fa-flask"></i>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-bold text-slate-800 truncate">${test.name}</p>
                                ${test.sample_type ? `<span class="text-[10px] text-slate-400">${test.sample_type}</span>` : ''}
                            </div>
                        </div>
                        <div class="flex items-center gap-2.5 flex-shrink-0">
                            <span class="text-xs font-black text-slate-800">₹${test.price}</span>
                            ${isSelected ? `
                                <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-400 text-[11px] font-bold">Added</span>
                            ` : `
                                <button type="button" onclick='addAdminItem(${testJson}, "test")' class="px-2.5 py-1 rounded-lg bg-teal-600 hover:bg-teal-700 text-white text-[11px] font-black shadow-2xs transition cursor-pointer">
                                    + Add
                                </button>
                            `}
                        </div>
                    </div>
                `;
            });
        }

        resultsBox.innerHTML = html;
        resultsBox.classList.remove('hidden');
    }

    function clearAdminSearch() {
        const input = document.getElementById('adminCatalogSearchInput');
        const resultsBox = document.getElementById('adminCatalogSearchResults');
        const clearBtn = document.getElementById('adminClearSearchBtn');
        if (input) input.value = '';
        if (resultsBox) {
            resultsBox.classList.add('hidden');
            resultsBox.innerHTML = '';
        }
        if (clearBtn) clearBtn.classList.add('hidden');
    }

    function recalculateAdminTotals() {
        const subtotal = adminCurrentTests.reduce((sum, item) => sum + parseFloat(item.price || 0), 0);
        const subtotalDisplay = document.getElementById('adminSubtotalDisplay');
        if (subtotalDisplay) subtotalDisplay.innerText = '₹' + subtotal.toLocaleString('en-IN');

        const feeInput = document.getElementById('adminCollectionFeeInput');
        let collectionFee = parseFloat(feeInput ? (feeInput.value || 0) : 0);

        if (!adminCollectionFeeManualOverride && feeInput) {
            if (adminIsHomeCollection && adminFeeEnabled) {
                collectionFee = (subtotal < adminFreeThreshold && subtotal > 0) ? adminStandardFee : 0;
                feeInput.value = collectionFee;
            } else {
                collectionFee = 0;
                feeInput.value = 0;
            }
        }

        const finalAmount = Math.max(0, subtotal - adminExistingDiscount + collectionFee);
        const amountInput = document.getElementById('adminFinalAmountInput');
        if (amountInput) amountInput.value = finalAmount;

        const dueBreakdownCard = document.getElementById('adminDueBreakdownCard');
        const dueToCollectDisplay = document.getElementById('adminDueToCollectDisplay');

        const remainingDue = (adminPaidAmount > 0) ? Math.max(0, finalAmount - adminPaidAmount) : finalAmount;
        if (dueToCollectDisplay) {
            dueToCollectDisplay.innerText = '₹' + remainingDue.toLocaleString('en-IN');
        }

        if (dueBreakdownCard) {
            if (adminPaidAmount > 0) {
                dueBreakdownCard.classList.remove('hidden');
            } else {
                dueBreakdownCard.classList.add('hidden');
            }
        }

        const diffAlert = document.getElementById('adminDiffAlert');
        const paymentSelect = document.getElementById('adminPaymentStatusSelect');

        if (diffAlert && paymentSelect) {
            if (adminPaidAmount > 0 && finalAmount > adminPaidAmount) {
                const diff = finalAmount - adminPaidAmount;
                diffAlert.className = 'p-3.5 rounded-xl border text-xs bg-amber-50 border-amber-200 text-amber-900 block';
                diffAlert.innerHTML = `
                    <div class="flex items-start gap-2.5">
                        <i class="fas fa-exclamation-circle text-amber-600 mt-0.5 flex-shrink-0 text-sm"></i>
                        <div>
                            <div class="font-bold text-amber-950">Additional Tests Added to Booking:</div>
                            <div class="text-slate-700 mt-0.5">
                                Customer previously paid: <strong>₹${adminPaidAmount.toLocaleString('en-IN')}</strong> | New Total Bill: <strong>₹${finalAmount.toLocaleString('en-IN')}</strong>
                            </div>
                            <div class="mt-2 p-2 rounded-lg bg-amber-100/70 border border-amber-300/60 font-black text-amber-900 flex items-center justify-between">
                                <span><i class="fas fa-hand-holding-usd text-amber-700 mr-1"></i> Amount to collect at doorstep (New Tests):</span>
                                <span class="text-base font-black text-amber-800">₹${diff.toLocaleString('en-IN')}</span>
                            </div>
                            <p class="text-[11px] text-amber-700 mt-1">Payment status set to <strong>Partial Online / Cash on Collection</strong> so field agent collects only this ₹${diff}.</p>
                        </div>
                    </div>
                `;
                if (paymentSelect.value === 'Paid') {
                    paymentSelect.value = 'Partial Online / Cash on Collection';
                }
            } else if (adminPaidAmount > 0 && finalAmount < adminPaidAmount) {
                const refundDiff = adminPaidAmount - finalAmount;
                diffAlert.className = 'p-3 rounded-xl border text-xs bg-blue-50 border-blue-200 text-blue-900 block';
                diffAlert.innerHTML = `
                    <div class="flex items-start gap-2">
                        <i class="fas fa-info-circle text-blue-600 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <strong>Tests Reduced:</strong> Customer paid <strong>₹${adminPaidAmount.toLocaleString('en-IN')}</strong>, new total is <strong>₹${finalAmount.toLocaleString('en-IN')}</strong> (Refund due: <strong>₹${refundDiff.toLocaleString('en-IN')}</strong>).
                        </div>
                    </div>
                `;
            } else {
                diffAlert.classList.add('hidden');
            }
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('adminCollectionFeeInput')?.addEventListener('change', () => {
            adminCollectionFeeManualOverride = true;
            recalculateAdminTotals();
        });

        document.getElementById('adminUpdateTestsForm')?.addEventListener('submit', function (e) {
            if (adminCurrentTests.length === 0) {
                e.preventDefault();
                alert('Please select at least one diagnostic test or package.');
                return false;
            }
            document.getElementById('adminTestsPayloadInput').value = JSON.stringify(adminCurrentTests);
        });
    });
</script>
@endsection

