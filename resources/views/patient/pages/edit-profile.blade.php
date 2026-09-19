@extends('frontend.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 bg-gray-50/50">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar -->
        @include('patient.layouts.sidebar')

        <!-- Main Content -->
        <div class="w-full md:w-2/3 lg:w-3/4 space-y-6">

            <!-- Success Alert -->
            @if(session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-sm animate-fade-in">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                        <i class="fas fa-check-circle text-lg"></i>
                    </div>
                    <div>
                        <p class="font-bold text-sm">{{ session('success') }}</p>
                        <p class="text-xs text-emerald-600">Your profile changes are now saved and updated across all reports.</p>
                    </div>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 text-lg font-bold p-1">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            @endif

            <!-- Validation Errors Alert -->
            @if($errors->any())
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 shadow-sm">
                <div class="flex items-center gap-2 mb-2 font-bold text-sm">
                    <i class="fas fa-exclamation-triangle text-rose-500 text-base"></i>
                    <span>Please correct the errors below before saving:</span>
                </div>
                <ul class="list-disc list-inside text-xs space-y-1 font-medium text-rose-700 ml-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Profile Edit Form Card -->
            <div id="profile-form" class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <!-- Card Header -->
                <div class="px-6 py-5 bg-gradient-to-r from-gray-50 via-white to-gray-50 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <div>
                        <h3 class="text-lg font-black text-brand-dark flex items-center gap-2">
                            <i class="far fa-id-card text-brand-secondary"></i>
                            <span>Edit Personal & Health Details</span>
                        </h3>
                        <p class="text-xs text-gray-500 font-medium mt-0.5">Please provide accurate information for age-specific normal reference ranges on your lab test reports.</p>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-extrabold bg-teal-50 text-brand-dark border border-teal-200 w-fit">
                        <span class="w-1.5 h-1.5 rounded-full bg-brand-primary animate-pulse"></span>
                        Active Profile
                    </span>
                </div>

                <!-- Form Content -->
                <form action="{{ route('patient.profile.store') }}" method="POST" class="p-6 md:p-8 space-y-6">
                    @csrf

                    <!-- Full Name -->
                    <div>
                        <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">
                            Enter Full Name <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">
                                <i class="far fa-user"></i>
                            </span>
                            <input 
                                type="text" 
                                name="name" 
                                value="{{ old('name', $profile->name) }}" 
                                placeholder="Enter Full Name" 
                                class="w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-primary focus:border-brand-primary font-bold text-gray-800 text-sm outline-none transition placeholder-gray-300" 
                                required
                            >
                        </div>
                    </div>

                    <!-- Gender Selection -->
                    <div>
                        <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">
                            Select Gender <span class="text-rose-500">*</span>
                        </label>
                        @php
                            $selectedGender = strtolower(old('gender', $profile->gender ?? ''));
                        @endphp
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            <!-- Female -->
                            <label class="cursor-pointer">
                                <input type="radio" name="gender" value="Female" {{ $selectedGender === 'female' ? 'checked' : '' }} class="peer hidden">
                                <div class="border-2 border-gray-200 bg-white rounded-xl py-3 px-4 text-center cursor-pointer font-bold text-gray-500 peer-checked:bg-brand-light/40 peer-checked:text-brand-dark peer-checked:border-brand-dark transition flex items-center justify-center gap-2 hover:border-gray-300 shadow-sm">
                                    <i class="fas fa-female text-lg text-pink-500"></i>
                                    <span>Female</span>
                                </div>
                            </label>

                            <!-- Male -->
                            <label class="cursor-pointer">
                                <input type="radio" name="gender" value="Male" {{ $selectedGender === 'male' ? 'checked' : '' }} class="peer hidden">
                                <div class="border-2 border-gray-200 bg-white rounded-xl py-3 px-4 text-center cursor-pointer font-bold text-gray-500 peer-checked:bg-brand-light/40 peer-checked:text-brand-dark peer-checked:border-brand-dark transition flex items-center justify-center gap-2 hover:border-gray-300 shadow-sm">
                                    <i class="fas fa-male text-lg text-blue-500"></i>
                                    <span>Male</span>
                                </div>
                            </label>

                            <!-- Other -->
                            <label class="cursor-pointer col-span-2 sm:col-span-1">
                                <input type="radio" name="gender" value="Other" {{ $selectedGender === 'other' ? 'checked' : '' }} class="peer hidden">
                                <div class="border-2 border-gray-200 bg-white rounded-xl py-3 px-4 text-center cursor-pointer font-bold text-gray-500 peer-checked:bg-brand-light/40 peer-checked:text-brand-dark peer-checked:border-brand-dark transition flex items-center justify-center gap-2 hover:border-gray-300 shadow-sm">
                                    <i class="fas fa-user-circle text-lg text-teal-600"></i>
                                    <span>Other</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Age & Date of Birth -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">
                                Enter Age
                            </label>
                            <div class="relative">
                                <input 
                                    type="number" 
                                    id="profile_age" 
                                    name="age" 
                                    value="{{ old('age', $profile->age !== '-' ? $profile->age : '') }}" 
                                    min="1" 
                                    max="120" 
                                    placeholder="Enter Age (e.g. 28)" 
                                    class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-primary focus:border-brand-primary font-bold text-gray-800 text-sm outline-none transition placeholder-gray-300"
                                >
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-bold text-gray-400">Years</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">
                                Date Of Birth
                            </label>
                            <input 
                                type="date" 
                                id="profile_dob" 
                                name="dob" 
                                value="{{ old('dob', $profile->dob ? \Carbon\Carbon::parse($profile->dob)->format('Y-m-d') : '') }}" 
                                class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-primary focus:border-brand-primary font-bold text-gray-800 text-sm outline-none transition text-gray-700"
                            >
                        </div>
                    </div>

                    <!-- Relation Selector -->
                    <div>
                        <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">
                            Select Relation
                        </label>
                        @php
                            $currentRelation = strtolower(old('relation', $profile->relation ?: 'self'));
                            $relations = [
                                'self' => 'Self',
                                'spouse' => 'Spouse',
                                'mother' => 'Mother',
                                'father' => 'Father',
                                'daughter' => 'Daughter',
                                'son' => 'Son',
                                'other' => 'Other',
                            ];
                        @endphp
                        <div class="flex flex-wrap gap-2.5">
                            @foreach($relations as $relKey => $relLabel)
                                <label class="cursor-pointer">
                                    <input type="radio" name="relation" value="{{ $relKey }}" {{ $currentRelation === $relKey ? 'checked' : '' }} class="peer hidden">
                                    <div class="border border-gray-200 bg-gray-50 rounded-full px-5 py-2.5 cursor-pointer font-bold text-xs text-gray-500 peer-checked:bg-brand-dark peer-checked:text-white peer-checked:border-brand-dark transition shadow-sm hover:border-gray-300 hover:bg-gray-100">
                                        {{ $relLabel }}
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Contact Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                        <!-- Primary Mobile (Locked & Verified) -->
                        <div>
                            <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">
                                Mobile Number (Primary)
                            </label>
                            <div class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 flex items-center justify-between">
                                <div>
                                    <span class="block text-xs font-bold text-gray-400 mb-0.5">Verified Primary Number</span>
                                    <span class="font-black text-gray-800 text-base tracking-wide">+91 {{ $profile->mobile }}</span>
                                </div>
                                <span class="inline-flex items-center gap-1 bg-emerald-100 text-emerald-700 text-[11px] font-black px-2.5 py-1 rounded-full">
                                    <i class="fas fa-check-circle text-xs"></i> Verified
                                </span>
                            </div>
                            <input type="hidden" name="mobile" value="{{ $profile->mobile }}">
                        </div>

                        <!-- Alternate Mobile -->
                        <div>
                            <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">
                                Alternate Number (Optional)
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-bold text-sm border-r pr-3 border-gray-200 flex items-center gap-1">
                                    <span>+91</span>
                                    <i class="fas fa-caret-down text-gray-400 text-xs"></i>
                                </span>
                                <input 
                                    type="tel" 
                                    name="alt_mobile" 
                                    value="{{ old('alt_mobile', $profile->alt_mobile) }}" 
                                    maxlength="10" 
                                    placeholder="Enter Alternate Number" 
                                    class="w-full pl-24 pr-4 py-3.5 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-primary focus:border-brand-primary font-bold text-gray-800 text-sm outline-none transition placeholder-gray-300"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">
                            Email Address (For Reports & Invoices) <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">
                                <i class="far fa-envelope"></i>
                            </span>
                            <input 
                                type="email" 
                                name="email" 
                                value="{{ old('email', $profile->email !== '-' ? $profile->email : '') }}" 
                                placeholder="Enter Email Address (e.g. user@example.com)" 
                                class="w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-primary focus:border-brand-primary font-bold text-gray-800 text-sm outline-none transition placeholder-gray-300" 
                                required
                            >
                        </div>
                        <p class="text-[11px] text-gray-400 font-medium mt-1">Your digitally signed laboratory test reports and billing receipts will be sent to this email.</p>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col-reverse sm:flex-row items-center gap-3 pt-6 border-t border-gray-100">
                        <a href="{{ route('patient.dashboard') }}" class="w-full sm:w-1/3 text-center border-2 border-gray-200 hover:border-gray-300 text-gray-600 font-extrabold py-3.5 rounded-xl hover:bg-gray-50 transition text-sm">
                            Cancel
                        </a>
                        <button type="submit" class="w-full sm:w-2/3 bg-brand-dark hover:bg-opacity-95 text-white font-extrabold py-3.5 rounded-xl shadow-md hover:shadow-lg transition flex items-center justify-center gap-2 text-sm">
                            <i class="fas fa-save"></i> Save Profile Details
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dobInput = document.getElementById('profile_dob');
        const ageInput = document.getElementById('profile_age');

        if (dobInput && ageInput) {
            dobInput.addEventListener('change', function() {
                if (this.value) {
                    const dob = new Date(this.value);
                    const today = new Date();
                    let age = today.getFullYear() - dob.getFullYear();
                    const monthDiff = today.getMonth() - dob.getMonth();
                    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                        age--;
                    }
                    if (age >= 0 && age <= 120) {
                        ageInput.value = age;
                    }
                }
            });
        }
    });
</script>
@endsection
