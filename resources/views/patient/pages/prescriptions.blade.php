@extends('frontend.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 bg-gray-50/50">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar -->
        @include('patient.layouts.sidebar')

        <!-- Main Content -->
        <div class="w-full md:w-2/3 lg:w-3/4">
            <h2 class="text-2xl font-extrabold text-brand-dark mb-6">Prescriptions</h2>
            
            <div class="bg-white rounded-xl border border-gray-200 p-8 shadow-sm">
                <!-- Member Selection -->
                <div class="mb-8">
                    <label class="block text-sm font-bold text-gray-700 mb-3">Select Member to Upload Prescription For</label>
                    <div class="flex flex-wrap gap-4" id="memberList">
                        <!-- Self -->
                        <label class="cursor-pointer">
                            <input type="radio" name="prescription_member" value="" class="peer hidden" checked 
                                data-name="{{ $profile->name ?? 'Self' }}" 
                                data-age="{{ $profile->age ?? 30 }}" 
                                data-gender="{{ $profile->gender ?? 'Not Specified' }}" 
                                onchange="updateMemberDetails(this.dataset.name, this.dataset.age, this.dataset.gender)">
                            <div class="px-5 py-3 rounded-xl border border-gray-200 font-bold text-gray-600 peer-checked:bg-brand-light/20 peer-checked:border-brand-dark peer-checked:text-brand-dark transition shadow-sm">
                                {{ $profile->name ?? 'Self' }} (Self)
                            </div>
                        </label>
                        @foreach($profile->familyMembers as $member)
                        <label class="cursor-pointer">
                            <input type="radio" name="prescription_member" value="{{ $member->id }}" class="peer hidden" 
                                data-name="{{ $member->name }}" 
                                data-age="{{ $member->age }}" 
                                data-gender="{{ $member->gender }}" 
                                onchange="updateMemberDetails(this.dataset.name, this.dataset.age, this.dataset.gender)">
                            <div class="px-5 py-3 rounded-xl border border-gray-200 font-bold text-gray-600 peer-checked:bg-brand-light/20 peer-checked:border-brand-dark peer-checked:text-brand-dark transition shadow-sm">
                                {{ $member->name }} ({{ $member->relation }})
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Selected Member Details -->
                <div class="bg-blue-50/50 rounded-xl p-5 border border-blue-100 mb-8 flex items-center justify-between">
                    <div>
                        <p class="text-xs text-brand-secondary font-extrabold uppercase tracking-wider mb-1">Selected Patient</p>
                        <h3 class="text-lg font-black text-brand-dark" id="displayMemberName">{{ $profile->name ?? 'Self' }}</h3>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-gray-600" id="displayMemberAge">{{ $profile->age ?? 30 }} Years</p>
                        <p class="text-sm font-bold text-gray-600" id="displayMemberGender">{{ $profile->gender ?? 'Not Specified' }}</p>
                    </div>
                </div>

                <!-- Upload Section -->
                <div>
                    <h4 class="font-extrabold text-gray-800 mb-4">Upload New Prescription (PDF / Images)</h4>
                    <form id="prescriptionForm" enctype="multipart/form-data">
                        @csrf
                        <div class="border-2 border-dashed border-gray-300 rounded-2xl p-10 text-center hover:border-brand-secondary transition bg-gray-50/50 cursor-pointer relative" id="dropZone">
                            <input type="file" id="prescriptionFileInput" name="prescription_file" accept=".pdf,image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="handleFileUpload(this)">
                            <div class="w-16 h-16 bg-brand-light/20 text-brand-secondary rounded-full flex items-center justify-center text-3xl mx-auto mb-4" id="uploadIcon">
                                <i class="fas fa-file-upload"></i>
                            </div>
                            <p class="font-bold text-brand-dark text-lg mb-1" id="uploadStatusText">Click to upload or drag and drop</p>
                            <p class="text-sm text-gray-500 font-semibold">PDF, JPG, PNG (MAX. 10MB)</p>
                        </div>
                    </form>
                </div>

                <!-- History -->
                <div class="mt-12">
                    <h4 class="font-extrabold text-gray-800 mb-4">Past Prescriptions</h4>
                    <div class="space-y-4">
                        @forelse($profile->prescriptions as $prescription)
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-xl bg-gray-50/30">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-red-50 text-red-500 rounded flex items-center justify-center text-lg mr-4">
                                    <i class="fas {{ str_ends_with(strtolower($prescription->file_path), '.pdf') ? 'fa-file-pdf' : 'fa-file-image' }}"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800">{{ $prescription->original_name ?? basename($prescription->file_path) }}</p>
                                    <p class="text-xs text-gray-500 font-semibold mt-0.5">
                                        Uploaded for {{ $prescription->familyMember ? $prescription->familyMember->name : ($profile->name ?? 'Self') }} • {{ $prescription->created_at->format('d M Y') }}
                                    </p>
                                </div>
                            </div>
                            <a href="{{ asset('storage/' . $prescription->file_path) }}" target="_blank" download class="text-brand-dark hover:text-brand-secondary font-bold text-sm">
                                <i class="fas fa-download mr-1"></i> Download
                            </a>
                        </div>
                        @empty
                        <div class="text-center py-8 text-gray-400 font-medium">
                            <i class="fas fa-folder-open text-4xl mb-2"></i>
                            <p>No prescriptions uploaded yet.</p>
                        </div>
                        @endforelse
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

    function handleFileUpload(input) {
        if (!input.files || !input.files[0]) return;

        const file = input.files[0];
        const memberId = document.querySelector('input[name="prescription_member"]:checked')?.value || '';
        
        const statusText = document.getElementById('uploadStatusText');
        statusText.innerText = 'Uploading ' + file.name + '...';

        const formData = new FormData();
        formData.append('prescription_file', file);
        if (memberId) {
            formData.append('family_member_id', memberId);
        }
        formData.append('_token', '{{ csrf_token() }}');

        fetch('{{ route("patient.upload_prescription") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Prescription uploaded successfully!');
                window.location.reload();
            } else {
                alert(data.message || 'Upload failed. Please try again.');
                statusText.innerText = 'Click to upload or drag and drop';
            }
        })
        .catch(err => {
            alert('Upload failed. Please check file size and format.');
            statusText.innerText = 'Click to upload or drag and drop';
        });
    }
</script>
@endsection
