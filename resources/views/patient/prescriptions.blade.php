@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 bg-gray-50/50">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar -->
        @include('patient.partials.sidebar')

        <!-- Main Content -->
        <div class="w-full md:w-2/3 lg:w-3/4">
            <h2 class="text-2xl font-extrabold text-brand-dark mb-6">Prescriptions</h2>
            
            <div class="bg-white rounded-xl border border-gray-200 p-8 shadow-sm">
                <!-- Member Selection -->
                <div class="mb-8">
                    <label class="block text-sm font-bold text-gray-700 mb-3">Select Member to Upload Prescription For</label>
                    <div class="flex flex-wrap gap-4">
                        <!-- Member 1 -->
                        <label class="cursor-pointer">
                            <input type="radio" name="prescription_member" value="self" class="peer hidden" checked 
                                data-name="{{ $profile['name'] ?? 'Self' }}" 
                                data-age="{{ $profile['age'] ?? 30 }}" 
                                data-gender="{{ $profile['gender'] ?? 'Male' }}" 
                                onchange="updateMemberDetails(this.dataset.name, this.dataset.age, this.dataset.gender)">
                            <div class="px-5 py-3 rounded-xl border border-gray-200 font-bold text-gray-600 peer-checked:bg-brand-light/20 peer-checked:border-brand-dark peer-checked:text-brand-dark transition shadow-sm">
                                {{ $profile['name'] }} (Self)
                            </div>
                        </label>
                        <!-- Member 2 -->
                        <label class="cursor-pointer">
                            <input type="radio" name="prescription_member" value="1" class="peer hidden" 
                                data-name="Anita Sharma" 
                                data-age="55" 
                                data-gender="Female" 
                                onchange="updateMemberDetails(this.dataset.name, this.dataset.age, this.dataset.gender)">
                            <div class="px-5 py-3 rounded-xl border border-gray-200 font-bold text-gray-600 peer-checked:bg-brand-light/20 peer-checked:border-brand-dark peer-checked:text-brand-dark transition shadow-sm">
                                Anita Sharma (Mother)
                            </div>
                        </label>
                        <!-- Member 3 -->
                        <label class="cursor-pointer">
                            <input type="radio" name="prescription_member" value="2" class="peer hidden" 
                                data-name="Rohan Sharma" 
                                data-age="12" 
                                data-gender="Male" 
                                onchange="updateMemberDetails(this.dataset.name, this.dataset.age, this.dataset.gender)">
                            <div class="px-5 py-3 rounded-xl border border-gray-200 font-bold text-gray-600 peer-checked:bg-brand-light/20 peer-checked:border-brand-dark peer-checked:text-brand-dark transition shadow-sm">
                                Rohan Sharma (Son)
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Selected Member Details -->
                <div class="bg-blue-50/50 rounded-xl p-5 border border-blue-100 mb-8 flex items-center justify-between">
                    <div>
                        <p class="text-xs text-brand-secondary font-extrabold uppercase tracking-wider mb-1">Selected Patient</p>
                        <h3 class="text-lg font-black text-brand-dark" id="displayMemberName">{{ $profile['name'] }}</h3>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-gray-600" id="displayMemberAge">{{ $profile['age'] ?? 30 }} Years</p>
                        <p class="text-sm font-bold text-gray-600" id="displayMemberGender">{{ $profile['gender'] ?? 'Male' }}</p>
                    </div>
                </div>

                <!-- Upload Section -->
                <div>
                    <h4 class="font-extrabold text-gray-800 mb-4">Upload New Prescription (PDF)</h4>
                    <div class="border-2 border-dashed border-gray-300 rounded-2xl p-10 text-center hover:border-brand-secondary transition bg-gray-50/50 cursor-pointer relative">
                        <input type="file" accept=".pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <div class="w-16 h-16 bg-brand-light/20 text-brand-secondary rounded-full flex items-center justify-center text-3xl mx-auto mb-4">
                            <i class="fas fa-file-upload"></i>
                        </div>
                        <p class="font-bold text-brand-dark text-lg mb-1">Click to upload or drag and drop</p>
                        <p class="text-sm text-gray-500 font-semibold">PDF (MAX. 10MB)</p>
                    </div>
                </div>

                <!-- History -->
                <div class="mt-12">
                    <h4 class="font-extrabold text-gray-800 mb-4">Past Prescriptions</h4>
                    <div class="space-y-4">
                        <!-- Item -->
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-xl bg-gray-50/30">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-red-50 text-red-500 rounded flex items-center justify-center text-lg mr-4">
                                    <i class="fas fa-file-pdf"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800">prescription_jan_2023.pdf</p>
                                    <p class="text-xs text-gray-500 font-semibold mt-0.5">Uploaded for {{ $profile['name'] }} • 12 Jan 2023</p>
                                </div>
                            </div>
                            <button class="text-brand-dark hover:text-brand-secondary font-bold text-sm">
                                <i class="fas fa-download mr-1"></i> Download
                            </button>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<script>
    function updateMemberDetails(name, age, gender) {
        document.getElementById('displayMemberName').innerText = name;
        document.getElementById('displayMemberAge').innerText = age + ' Years';
        document.getElementById('displayMemberGender').innerText = gender;
    }
</script>
@endsection
