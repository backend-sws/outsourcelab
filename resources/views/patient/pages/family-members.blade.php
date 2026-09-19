@extends('frontend.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 bg-gray-50/50">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar -->
        @include('patient.layouts.sidebar')

        <!-- Main Content -->
        <div class="w-full md:w-2/3 lg:w-3/4 space-y-6">

            <!-- Top Header & Add Member Action -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-black text-brand-dark flex items-center gap-2.5">
                        <i class="fas fa-users text-brand-primary"></i>
                        <span>Family Health Profiles</span>
                    </h2>
                    <p class="text-xs text-gray-500 font-medium mt-1">Select any family member below to view their individual diagnostic test bookings, sample collection progress, and medical reports.</p>
                </div>
                <button onclick="window.openAddMemberModal()" class="inline-flex items-center justify-center gap-2 bg-brand-dark hover:bg-teal-800 text-white px-5 py-2.5 rounded-xl font-extrabold text-xs transition shadow-sm hover:shadow-md flex-shrink-0">
                    <i class="fas fa-user-plus"></i>
                    <span>+ Add Family Member</span>
                </button>
            </div>

            @php
                // Self bookings (where family_member_id is null or 0)
                $selfBookings = $profile->bookings->whereNull('family_member_id')->sortByDesc('created_at');
            @endphp

            <!-- Family Members Selection Grid -->
            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-extrabold uppercase tracking-wider text-gray-500 flex items-center gap-2">
                        <span>Select Profile</span>
                        <span class="px-2 py-0.5 rounded-full bg-gray-100 text-gray-600 text-[10px] font-black">{{ 1 + $profile->familyMembers->count() }} Profiles</span>
                    </span>
                    <span class="text-xs text-brand-primary font-bold flex items-center gap-1">
                        <i class="fas fa-mouse-pointer text-[10px]"></i>
                        <span>Click card to switch booking history</span>
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    
                    <!-- 1. Self (Primary Account Holder) -->
                    <div 
                        onclick="selectMember('self', '{{ addslashes($profile->name ?: 'You') }}', 'Self')" 
                        id="card-member-self"
                        data-member-id="self"
                        class="member-card cursor-pointer border-2 rounded-2xl p-4 relative transition-all duration-200 bg-teal-50/60 border-brand-dark shadow-sm ring-2 ring-brand-dark/10"
                    >
                        <div class="flex items-center justify-between mb-3">
                            <span class="inline-flex items-center gap-1 bg-brand-dark text-white text-[10px] font-black px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                                <i class="fas fa-star text-[9px] text-amber-300"></i> Self (Primary)
                            </span>
                            <span id="active-badge-self" class="active-indicator flex items-center gap-1 text-[11px] font-black text-brand-dark">
                                <span class="w-2 h-2 rounded-full bg-brand-primary animate-pulse"></span>
                                <span>Viewing</span>
                            </span>
                        </div>

                        <div class="flex items-start gap-3.5">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-brand-dark to-teal-600 text-white flex items-center justify-center font-black text-lg shadow-sm flex-shrink-0">
                                {{ strtoupper(substr($profile->name ?: 'P', 0, 1)) }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <h3 class="font-extrabold text-gray-900 text-base truncate">{{ $profile->name ?: 'Primary User' }}</h3>
                                <p class="text-xs text-gray-500 font-semibold mt-0.5">
                                    {{ $profile->age ? $profile->age . ' Years' : 'Age not set' }} • {{ $profile->gender ?: 'Male' }}
                                </p>
                                <div class="mt-2.5 flex items-center gap-2">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-white border border-teal-200 text-teal-800 text-[11px] font-bold">
                                        <i class="fas fa-flask text-[10px] text-teal-600"></i>
                                        <span>{{ $selfBookings->count() }} {{ Str::plural('Booking', $selfBookings->count()) }}</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2..N Family Members -->
                    @foreach($profile->familyMembers as $member)
                        @php
                            $memberBookings = $profile->bookings->where('family_member_id', $member->id)->sortByDesc('created_at');
                            $genderIcon = strtolower($member->gender) === 'male' ? 'fa-male text-blue-500' : 'fa-female text-pink-500';
                            if (in_array(strtolower($member->relation), ['son', 'daughter', 'child'])) {
                                $genderIcon = 'fa-child text-amber-500';
                            }
                        @endphp
                        <div 
                            onclick="selectMember('{{ $member->id }}', '{{ addslashes($member->name) }}', '{{ addslashes($member->relation) }}')" 
                            id="card-member-{{ $member->id }}"
                            data-member-id="{{ $member->id }}"
                            class="member-card cursor-pointer border-2 border-gray-200 bg-white hover:border-teal-300 hover:bg-gray-50/60 rounded-2xl p-4 relative transition-all duration-200 shadow-sm"
                        >
                            <div class="flex items-center justify-between mb-3">
                                <span class="inline-flex items-center gap-1 bg-gray-100 text-gray-700 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                                    {{ $member->relation }}
                                </span>
                                
                                <div class="flex items-center gap-2">
                                    <span id="active-badge-{{ $member->id }}" class="active-indicator hidden items-center gap-1 text-[11px] font-black text-brand-dark">
                                        <span class="w-2 h-2 rounded-full bg-brand-primary animate-pulse"></span>
                                        <span>Viewing</span>
                                    </span>
                                    <button 
                                        type="button" 
                                        onclick="event.stopPropagation(); deleteFamilyMember('{{ $member->id }}', '{{ addslashes($member->name) }}')" 
                                        class="text-gray-300 hover:text-rose-500 p-1 rounded transition" 
                                        title="Remove member"
                                    >
                                        <i class="far fa-trash-alt text-xs"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="flex items-start gap-3.5">
                                <div class="w-12 h-12 rounded-2xl bg-gray-50 border border-gray-200 text-gray-700 flex items-center justify-center font-black text-lg shadow-sm flex-shrink-0">
                                    <i class="fas {{ $genderIcon }}"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h3 class="font-extrabold text-gray-900 text-base truncate">{{ $member->name }}</h3>
                                    <p class="text-xs text-gray-500 font-semibold mt-0.5">
                                        {{ $member->age }} Years • {{ $member->gender }}
                                    </p>
                                    <div class="mt-2.5 flex items-center gap-2">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-gray-50 border border-gray-200 text-gray-700 text-[11px] font-bold">
                                            <i class="fas fa-flask text-[10px] text-gray-400"></i>
                                            <span>{{ $memberBookings->count() }} {{ Str::plural('Booking', $memberBookings->count()) }}</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

            <!-- Member Test History Section -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <!-- Section Header with active member display -->
                <div class="px-6 py-5 bg-gradient-to-r from-teal-900/5 via-white to-teal-900/5 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-teal-50 border border-teal-200 text-brand-dark flex items-center justify-center font-bold text-lg">
                            <i class="fas fa-file-medical-alt text-brand-primary"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 flex-wrap">
                                <h3 class="text-lg font-black text-brand-dark">
                                    Diagnostic History: <span id="activeMemberHeading" class="text-teal-700 underline decoration-teal-300 decoration-2 underline-offset-4">{{ $profile->name ?: 'You' }} (Self)</span>
                                </h3>
                            </div>
                            <p class="text-xs text-gray-500 font-medium mt-0.5">All scheduled lab appointments, collection progress, and verified test reports.</p>
                        </div>
                    </div>
                    <a href="/" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-brand-dark hover:bg-brand-primary text-white text-xs font-extrabold rounded-xl shadow-sm transition flex-shrink-0">
                        <i class="fas fa-plus-circle"></i>
                        <span>Book New Test</span>
                    </a>
                </div>

                <div class="p-6 md:p-8">
                    
                    <!-- 1. History Pane for Self -->
                    <div id="history-pane-self" class="history-pane space-y-4">
                        @if($selfBookings->isEmpty())
                            <div class="text-center py-12 px-4 bg-gray-50/60 rounded-2xl border border-dashed border-gray-200">
                                <div class="w-16 h-16 rounded-full bg-teal-50 text-brand-primary flex items-center justify-center text-2xl mx-auto mb-3 shadow-inner">
                                    <i class="fas fa-calendar-times text-gray-300"></i>
                                </div>
                                <h4 class="text-base font-extrabold text-gray-800 mb-1">No Test Bookings Found for {{ $profile->name ?: 'Self' }}</h4>
                                <p class="text-xs text-gray-500 max-w-md mx-auto mb-5 font-medium">You haven't scheduled any diagnostic tests or preventive health checkups for yourself yet.</p>
                                <a href="/" class="inline-flex items-center gap-2 px-6 py-2.5 bg-brand-dark hover:bg-teal-800 text-white text-xs font-extrabold rounded-xl shadow-sm transition">
                                    <i class="fas fa-flask"></i>
                                    <span>Browse Health Packages</span>
                                </a>
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach($selfBookings as $booking)
                                    @include('patient.pages.partials.booking-history-card', ['booking' => $booking, 'memberName' => $profile->name ?: 'Self'])
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- 2..N History Panes for Each Family Member -->
                    @foreach($profile->familyMembers as $member)
                        @php
                            $memberBookings = $profile->bookings->where('family_member_id', $member->id)->sortByDesc('created_at');
                        @endphp
                        <div id="history-pane-{{ $member->id }}" class="history-pane hidden space-y-4">
                            @if($memberBookings->isEmpty())
                                <div class="text-center py-12 px-4 bg-gray-50/60 rounded-2xl border border-dashed border-gray-200">
                                    <div class="w-16 h-16 rounded-full bg-teal-50 text-brand-primary flex items-center justify-center text-2xl mx-auto mb-3 shadow-inner">
                                        <i class="fas fa-calendar-times text-gray-300"></i>
                                    </div>
                                    <h4 class="text-base font-extrabold text-gray-800 mb-1">No Test Bookings Found for {{ $member->name }}</h4>
                                    <p class="text-xs text-gray-500 max-w-md mx-auto mb-5 font-medium">No diagnostic tests or health packages have been booked for {{ $member->name }} ({{ $member->relation }}) yet.</p>
                                    <a href="/" class="inline-flex items-center gap-2 px-6 py-2.5 bg-brand-dark hover:bg-teal-800 text-white text-xs font-extrabold rounded-xl shadow-sm transition">
                                        <i class="fas fa-flask"></i>
                                        <span>Book Test for {{ $member->name }}</span>
                                    </a>
                                </div>
                            @else
                                <div class="space-y-4">
                                    @foreach($memberBookings as $booking)
                                        @include('patient.pages.partials.booking-history-card', ['booking' => $booking, 'memberName' => $member->name])
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach

                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function selectMember(memberId, memberName, memberRelation) {
        // 1. Update Heading
        const heading = document.getElementById('activeMemberHeading');
        if (heading) {
            heading.textContent = memberName + ' (' + memberRelation + ')';
        }

        // 2. Update Member Cards Styling
        document.querySelectorAll('.member-card').forEach(card => {
            card.classList.remove('bg-teal-50/60', 'border-brand-dark', 'ring-2', 'ring-brand-dark/10');
            card.classList.add('border-gray-200', 'bg-white');
        });

        const activeCard = document.getElementById('card-member-' + memberId);
        if (activeCard) {
            activeCard.classList.remove('border-gray-200', 'bg-white');
            activeCard.classList.add('bg-teal-50/60', 'border-brand-dark', 'ring-2', 'ring-brand-dark/10');
        }

        // 3. Update Active Badges
        document.querySelectorAll('.active-indicator').forEach(el => {
            el.classList.add('hidden');
            el.classList.remove('flex');
        });
        const activeBadge = document.getElementById('active-badge-' + memberId);
        if (activeBadge) {
            activeBadge.classList.remove('hidden');
            activeBadge.classList.add('flex');
        }

        // 4. Switch History Panes
        document.querySelectorAll('.history-pane').forEach(pane => {
            pane.classList.add('hidden');
        });

        const targetPane = document.getElementById('history-pane-' + memberId);
        if (targetPane) {
            targetPane.classList.remove('hidden');
        }

        // 5. Update URL hash without jump
        if (history.replaceState) {
            history.replaceState(null, null, '#member-' + memberId);
        }
    }

    function deleteFamilyMember(memberId, memberName) {
        if (!confirm(`Are you sure you want to remove ${memberName} from your family profiles?`)) {
            return;
        }

        fetch(`/patient/family-members/${memberId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert(data.message || 'Error removing member.');
            }
        })
        .catch(err => {
            alert('A network error occurred. Please try again.');
        });
    }

    // Auto-select on page load if hash present
    document.addEventListener('DOMContentLoaded', function() {
        const hash = window.location.hash;
        if (hash && hash.startsWith('#member-')) {
            const memberId = hash.replace('#member-', '');
            const card = document.getElementById('card-member-' + memberId);
            if (card) {
                card.click();
            }
        }
    });
</script>
@endsection
