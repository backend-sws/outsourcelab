@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 bg-gray-50/50">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar -->
        @include('patient.partials.sidebar')

        <!-- Main Content -->
        <div class="w-full md:w-2/3 lg:w-3/4">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-extrabold text-brand-dark">Family Members</h2>
                <button onclick="window.openAddMemberModal()" class="bg-brand-dark text-white px-5 py-2 rounded-xl font-bold text-sm hover:bg-brand-secondary transition shadow-sm">
                    <i class="fas fa-plus mr-2"></i> Add Member
                </button>
            </div>
            
            <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
                <!-- List of Members -->
                <div id="familyMembersList" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    
                    <!-- Member Card (Self) -->
                    <div class="border border-brand-secondary/30 bg-brand-light/10 rounded-xl p-5 relative overflow-hidden">
                        <div class="absolute top-0 right-0 bg-brand-secondary text-white text-[10px] font-bold px-3 py-1 rounded-bl-xl uppercase tracking-wider">Self</div>
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-white text-brand-dark rounded-full flex items-center justify-center font-bold text-xl border border-brand-secondary/20 mr-4 shadow-sm">
                                <i class="fas fa-user-circle"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg">{{ $profile['name'] }}</h3>
                                <p class="text-sm text-gray-500 font-semibold mt-1">{{ $profile['age'] ?? 30 }} Years | {{ $profile['gender'] ?? 'Male' }}</p>
                            </div>
                        </div>
                    </div>

                    @foreach($profile->familyMembers as $member)
                        @php
                            $icon = $member->gender === 'Male' ? 'fa-male' : 'fa-female';
                            if (in_array(strtolower($member->relation), ['son', 'daughter', 'child'])) {
                                $icon = 'fa-child';
                            }
                        @endphp
                        <div class="border border-gray-200 bg-white rounded-xl p-5 relative hover:border-brand-secondary transition group">
                            <div class="absolute top-0 right-0 bg-gray-100 text-gray-500 text-[10px] font-bold px-3 py-1 rounded-bl-xl uppercase tracking-wider">{{ $member->relation }}</div>
                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-gray-50 text-gray-400 rounded-full flex items-center justify-center font-bold text-xl border border-gray-200 mr-4 group-hover:text-brand-secondary transition">
                                    <i class="fas {{ $icon }}"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 text-lg">{{ $member->name }}</h3>
                                    <p class="text-sm text-gray-500 font-semibold mt-1">{{ $member->age }} Years | {{ $member->gender }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function saveNewMember() {
        let name = document.getElementById('newMemberName').value.trim();
        let age = document.getElementById('newMemberAge').value.trim();
        let gender = document.querySelector('input[name="new_member_gender"]:checked').value;
        let relation = document.querySelector('input[name="new_member_relation"]:checked').value;

        if (!name || !age) {
            alert('Please enter name and age.');
            return;
        }

        fetch("{{ route('patient.add_family_member') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ name, age, gender, relation })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Reload to show new member
                window.location.reload();
            } else {
                alert('Error saving member');
            }
        });
    }
</script>
@endsection
