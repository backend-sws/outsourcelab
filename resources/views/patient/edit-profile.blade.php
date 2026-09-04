@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 bg-gray-50/50">
    <div class="flex flex-col md:flex-row gap-8 justify-center">
        <!-- Main Content Form -->
        <div class="w-full md:w-2/3 lg:w-1/2">
            
            <div class="bg-white rounded-xl border border-gray-200 p-8 shadow-sm">
                <form action="{{ route('patient.profile.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <!-- Full Name -->
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-2">Enter Full Name</label>
                        <input type="text" name="name" value="{{ $profile['name'] ?? '' }}" class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-secondary focus:border-brand-secondary font-bold text-gray-800 outline-none" required>
                    </div>

                    <!-- Gender -->
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-2">Select Gender</label>
                        <div class="flex space-x-4">
                            <label class="flex-1">
                                <input type="radio" name="gender" value="female" {{ (strtolower($profile['gender'] ?? '') === 'female') ? 'checked' : '' }} class="peer hidden">
                                <div class="border border-gray-200 rounded-full py-2.5 text-center cursor-pointer font-bold text-gray-400 peer-checked:bg-brand-light/10 peer-checked:text-brand-dark peer-checked:border-brand-dark transition flex items-center justify-center">
                                    <i class="fas fa-female mr-2 text-lg"></i> Female
                                </div>
                            </label>
                            <label class="flex-1">
                                <input type="radio" name="gender" value="male" {{ (strtolower($profile['gender'] ?? '') === 'male') ? 'checked' : '' }} class="peer hidden">
                                <div class="border border-gray-200 rounded-full py-2.5 text-center cursor-pointer font-bold text-gray-400 peer-checked:bg-brand-light/10 peer-checked:text-brand-dark peer-checked:border-brand-dark transition flex items-center justify-center">
                                    <i class="fas fa-male mr-2 text-lg"></i> Male
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Age / DOB -->
                    <div class="flex space-x-4">
                        <div class="flex-1">
                            <label class="block text-xs font-bold text-gray-500 mb-2">Enter Age</label>
                            <input type="number" name="age" value="{{ $profile['age'] !== '-' ? $profile['age'] : '' }}" placeholder="Enter Age" class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-secondary focus:border-brand-secondary font-bold text-gray-800 outline-none placeholder-gray-300">
                        </div>
                        <div class="flex items-center justify-center text-gray-300 pt-6">/</div>
                        <div class="flex-1 relative">
                            <label class="block text-xs font-bold text-gray-500 mb-2">Date Of Birth</label>
                            <input type="date" name="dob" value="{{ $profile['dob'] ?? '' }}" class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-secondary focus:border-brand-secondary font-bold text-gray-800 outline-none text-gray-400">
                        </div>
                    </div>

                    <!-- Relation -->
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-2">Select Relation</label>
                        <div class="flex flex-wrap gap-3">
                            <label>
                                <input type="radio" name="relation" value="self" {{ ($profile['relation'] ?? 'self') === 'self' ? 'checked' : '' }} class="peer hidden">
                                <div class="border border-gray-200 bg-gray-50 rounded-full px-6 py-2 cursor-pointer font-bold text-gray-400 peer-checked:bg-blue-50 peer-checked:text-brand-dark peer-checked:border-brand-dark transition text-sm">Self</div>
                            </label>
                            <label>
                                <input type="radio" name="relation" value="spouse" {{ ($profile['relation'] ?? '') === 'spouse' ? 'checked' : '' }} class="peer hidden">
                                <div class="border border-gray-200 bg-gray-50 rounded-full px-6 py-2 cursor-pointer font-bold text-gray-400 peer-checked:bg-blue-50 peer-checked:text-brand-dark peer-checked:border-brand-dark transition text-sm">Spouse</div>
                            </label>
                            <label>
                                <input type="radio" name="relation" value="mother" {{ ($profile['relation'] ?? '') === 'mother' ? 'checked' : '' }} class="peer hidden">
                                <div class="border border-gray-200 bg-gray-50 rounded-full px-6 py-2 cursor-pointer font-bold text-gray-400 peer-checked:bg-blue-50 peer-checked:text-brand-dark peer-checked:border-brand-dark transition text-sm">Mother</div>
                            </label>
                            <label>
                                <input type="radio" name="relation" value="father" {{ ($profile['relation'] ?? '') === 'father' ? 'checked' : '' }} class="peer hidden">
                                <div class="border border-gray-200 bg-gray-50 rounded-full px-6 py-2 cursor-pointer font-bold text-gray-400 peer-checked:bg-blue-50 peer-checked:text-brand-dark peer-checked:border-brand-dark transition text-sm">Father</div>
                            </label>
                            <label>
                                <input type="radio" name="relation" value="daughter" {{ ($profile['relation'] ?? '') === 'daughter' ? 'checked' : '' }} class="peer hidden">
                                <div class="border border-gray-200 bg-gray-50 rounded-full px-6 py-2 cursor-pointer font-bold text-gray-400 peer-checked:bg-blue-50 peer-checked:text-brand-dark peer-checked:border-brand-dark transition text-sm">Daughter</div>
                            </label>
                        </div>
                    </div>

                    <!-- Mobile Number -->
                    <div>
                        <div class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 relative">
                            <span class="block text-xs font-bold text-gray-400 mb-1">Mobile Number</span>
                            <span class="font-bold text-gray-800 text-lg">{{ $profile['mobile'] ?? '9470700693' }}</span>
                            <!-- Hidden input to still submit mobile if we wanted to -->
                            <input type="hidden" name="mobile" value="{{ $profile['mobile'] ?? '9470700693' }}">
                        </div>
                    </div>

                    <!-- Alternate Number -->
                    <div>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-bold border-r pr-3 border-gray-200">+91 <i class="fas fa-caret-down text-xs ml-1"></i></span>
                            <input type="tel" name="alt_mobile" value="{{ $profile['alt_mobile'] ?? '' }}" class="w-full pl-24 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-secondary focus:border-brand-secondary transition shadow-sm font-bold text-gray-800 text-lg placeholder-gray-300 outline-none" placeholder="Enter Alternate Number" maxlength="10">
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <input type="email" name="email" value="{{ $profile['email'] !== '-' ? $profile['email'] : '' }}" class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-secondary focus:border-brand-secondary transition shadow-sm font-bold text-gray-800 placeholder-gray-300 outline-none" placeholder="Enter Email Address">
                    </div>

                    <!-- Actions -->
                    <div class="flex space-x-4 pt-4">
                        <a href="{{ route('patient.dashboard') }}" class="flex-1 text-center border border-brand-dark text-brand-dark font-bold py-3.5 rounded-xl hover:bg-gray-50 transition">Cancel</a>
                        <button type="submit" class="flex-1 bg-brand-dark text-white font-bold py-3.5 rounded-xl hover:bg-opacity-90 transition shadow-lg">Save</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
