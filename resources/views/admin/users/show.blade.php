@extends('admin.layout.app')

@section('title', 'User Profile - ' . ($user->name ?: $user->email))
@section('header', 'User Details')

@section('content')
<!-- Back button and title -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div class="flex items-center space-x-3">
        <a href="{{ route('admin.users.index') }}" class="w-9 h-9 rounded-xl bg-white dark:bg-white/[0.05] border border-slate-200 dark:border-white/[0.08] text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white flex items-center justify-center transition-all shadow-sm">
            <i class="fas fa-arrow-left text-xs"></i>
        </a>
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white">
                {{ $user->name ?: 'User Profile' }}
            </h1>
            <p class="text-xs text-slate-400">
                Registered customer account details & diagnostic booking history.
            </p>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex items-center space-x-2">
        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user? All bookings and linked data will be deleted.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-3.5 py-2 rounded-xl text-xs font-semibold bg-rose-50 dark:bg-rose-500/10 border border-rose-200/60 dark:border-rose-500/20 text-rose-600 dark:text-rose-400 hover:bg-rose-100 transition-colors flex items-center gap-1.5">
                <i class="fas fa-trash text-xs"></i>
                <span>Delete Account</span>
            </button>
        </form>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column: Profile Card & Linked Data -->
    <div class="space-y-6">
        <!-- User Info Card -->
        <div class="bg-white dark:bg-[#12142d] rounded-2xl p-6 border border-slate-200 dark:border-white/[0.06] shadow-sm">
            @php
                $displayName = $user->name ?: ($user->email ? explode('@', $user->email)[0] : 'User #' . $user->id);
                $initials = strtoupper(substr($displayName, 0, 2));
            @endphp
            <div class="flex items-center space-x-4 pb-6 border-b border-slate-100 dark:border-white/[0.06]">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-indigo-600 to-purple-600 text-white font-black text-xl flex items-center justify-center shadow-lg shadow-indigo-500/20">
                    {{ $initials }}
                </div>
                <div class="min-w-0">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white truncate">
                        {{ $user->name ?: 'No Name Set' }}
                    </h3>
                    <p class="text-xs text-slate-400 truncate">{{ $user->email }}</p>
                    <span class="inline-flex items-center px-2 py-0.5 mt-1 rounded text-[10px] font-bold bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 border border-indigo-200/50 dark:border-indigo-500/20">
                        Patient Account #{{ $user->id }}
                    </span>
                </div>
            </div>

            <div class="pt-5 space-y-3.5 text-xs">
                <div class="flex justify-between items-center">
                    <span class="text-slate-400 font-medium">Primary Mobile</span>
                    <span class="font-bold text-slate-800 dark:text-slate-200">{{ $user->mobile ?: 'Not provided' }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-slate-400 font-medium">Alternate Mobile</span>
                    <span class="font-semibold text-slate-700 dark:text-slate-300">{{ $user->alt_mobile ?: '—' }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-slate-400 font-medium">Gender</span>
                    <span class="font-semibold text-slate-700 dark:text-slate-300">{{ $user->gender ?: '—' }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-slate-400 font-medium">Age</span>
                    <span class="font-semibold text-slate-700 dark:text-slate-300">{{ $user->age ? $user->age . ' Years' : '—' }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-slate-400 font-medium">Date of Birth</span>
                    <span class="font-semibold text-slate-700 dark:text-slate-300">{{ $user->dob ?: '—' }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-slate-400 font-medium">Registered Date</span>
                    <span class="font-semibold text-slate-700 dark:text-slate-300">{{ $user->created_at ? $user->created_at->format('d M, Y h:i A') : '—' }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-slate-400 font-medium">Last Login / Activity</span>
                    <span class="font-semibold text-emerald-600 dark:text-emerald-400">
                        {{ $user->last_login_at ? $user->last_login_at->format('d M, Y h:i A') : ($user->updated_at ? $user->updated_at->format('d M, Y') : '—') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Family Members Card -->
        <div class="bg-white dark:bg-[#12142d] rounded-2xl p-6 border border-slate-200 dark:border-white/[0.06] shadow-sm">
            <h3 class="text-sm font-bold text-slate-900 dark:text-white flex items-center justify-between mb-4">
                <span>Family Members</span>
                <span class="text-[11px] px-2 py-0.5 rounded-full bg-slate-100 dark:bg-white/[0.05] text-slate-600 dark:text-slate-300 font-semibold">
                    {{ $user->familyMembers->count() }}
                </span>
            </h3>

            @forelse($user->familyMembers as $member)
                <div class="p-3 mb-2.5 rounded-xl bg-slate-50 dark:bg-white/[0.02] border border-slate-200/70 dark:border-white/[0.04] flex items-center justify-between text-xs">
                    <div>
                        <div class="font-bold text-slate-800 dark:text-slate-200">{{ $member->name }}</div>
                        <div class="text-[11px] text-slate-400">{{ $member->relation }} • {{ $member->gender }} • {{ $member->age ? $member->age . ' yrs' : '' }}</div>
                    </div>
                    <span class="text-slate-400 text-xs"><i class="fas fa-user-tag"></i></span>
                </div>
            @empty
                <p class="text-xs text-slate-400 italic">No family members added yet.</p>
            @endforelse
        </div>

        <!-- Saved Addresses Card -->
        <div class="bg-white dark:bg-[#12142d] rounded-2xl p-6 border border-slate-200 dark:border-white/[0.06] shadow-sm">
            <h3 class="text-sm font-bold text-slate-900 dark:text-white flex items-center justify-between mb-4">
                <span>Saved Addresses</span>
                <span class="text-[11px] px-2 py-0.5 rounded-full bg-slate-100 dark:bg-white/[0.05] text-slate-600 dark:text-slate-300 font-semibold">
                    {{ $user->addresses->count() }}
                </span>
            </h3>

            @forelse($user->addresses as $addr)
                <div class="p-3 mb-2.5 rounded-xl bg-slate-50 dark:bg-white/[0.02] border border-slate-200/70 dark:border-white/[0.04] text-xs">
                    <div class="font-bold text-slate-800 dark:text-slate-200 flex items-center gap-1.5">
                        <i class="fas fa-location-dot text-indigo-500 text-[11px]"></i>
                        <span>{{ $addr->title ?: 'Address' }}</span>
                    </div>
                    <p class="text-slate-600 dark:text-slate-400 text-[11px] mt-1">{{ $addr->full_address }}</p>
                    @if($addr->pincode)
                        <div class="text-[10px] text-slate-400 mt-1 font-semibold">Pincode: {{ $addr->pincode }}</div>
                    @endif
                </div>
            @empty
                <p class="text-xs text-slate-400 italic">No saved addresses found.</p>
            @endforelse
        </div>
    </div>

    <!-- Right Column: Bookings History -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white dark:bg-[#12142d] rounded-2xl p-6 border border-slate-200 dark:border-white/[0.06] shadow-sm">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <i class="fas fa-calendar-check text-indigo-500"></i>
                        <span>Booking History</span>
                    </h3>
                    <p class="text-xs text-slate-400">All tests and health packages booked by this user.</p>
                </div>
                <span class="px-3 py-1 rounded-xl text-xs font-bold bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 border border-indigo-200/60 dark:border-indigo-500/20">
                    {{ $user->bookings->count() }} Total
                </span>
            </div>

            @forelse($user->bookings as $booking)
                <div class="p-4 mb-3.5 rounded-xl bg-slate-50/75 dark:bg-white/[0.02] border border-slate-200 dark:border-white/[0.06] hover:border-indigo-300 dark:hover:border-indigo-500/40 transition-all text-xs">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-3 border-b border-slate-200/60 dark:border-white/[0.06]">
                        <div class="flex items-center gap-2">
                            <span class="font-black text-slate-900 dark:text-white text-sm">#{{ $booking->booking_reference }}</span>
                            <span class="text-[10px] text-slate-400">
                                {{ $booking->booking_date ? $booking->booking_date->format('d M, Y h:i A') : $booking->created_at->format('d M, Y') }}
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            @php
                                $statusColors = [
                                    'Booked' => 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-300',
                                    'Sample Collected' => 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-300',
                                    'Report Ready' => 'bg-purple-100 text-purple-700 dark:bg-purple-500/20 dark:text-purple-300',
                                    'Completed' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300',
                                    'Cancelled' => 'bg-rose-100 text-rose-700 dark:bg-rose-500/20 dark:text-rose-300',
                                ];
                                $colorClass = $statusColors[$booking->status] ?? 'bg-slate-100 text-slate-700';
                            @endphp
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $colorClass }}">
                                {{ $booking->status }}
                            </span>
                            <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-indigo-600 dark:text-indigo-400 font-semibold hover:underline flex items-center gap-1 text-[11px]">
                                <span>View</span>
                                <i class="fas fa-chevron-right text-[9px]"></i>
                            </a>
                        </div>
                    </div>

                    <div class="pt-3 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                        <div>
                            <div class="text-[11px] text-slate-500 dark:text-slate-400">
                                <span class="font-semibold text-slate-700 dark:text-slate-300">Collection:</span> {{ $booking->collection_type }}
                                @if($booking->payment_method)
                                    <span class="ml-2 font-semibold text-slate-700 dark:text-slate-300">Payment:</span> {{ $booking->payment_method }} ({{ $booking->payment_status }})
                                @endif
                            </div>
                            @if(!empty($booking->test_details) && is_array($booking->test_details))
                                <div class="mt-1.5 flex flex-wrap gap-1">
                                    @foreach($booking->test_details as $item)
                                        <span class="px-2 py-0.5 rounded bg-white dark:bg-white/[0.05] border border-slate-200 dark:border-white/[0.08] text-[10px] font-medium text-slate-700 dark:text-slate-300">
                                            {{ $item['name'] ?? 'Test Item' }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="text-right flex-shrink-0">
                            <span class="text-xs text-slate-400 block">Total Amount</span>
                            <span class="text-base font-black text-slate-900 dark:text-white">₹{{ number_format($booking->amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center">
                    <div class="w-12 h-12 rounded-xl bg-slate-100 dark:bg-white/[0.05] text-slate-400 flex items-center justify-center mx-auto mb-2 text-lg">
                        <i class="fas fa-calendar-xmark"></i>
                    </div>
                    <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">No bookings placed yet</p>
                    <p class="text-xs text-slate-400 mt-1">This user has not booked any diagnostic tests or packages yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
