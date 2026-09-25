<!-- Prescription Upload & Doctor Callback Modal -->
<div id="prescriptionModal" class="fixed inset-0 z-50 bg-black/60 hidden opacity-0 transition-opacity duration-300 flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full shadow-2xl overflow-hidden transform scale-95 transition-transform duration-300 relative border border-gray-100" id="prescriptionModalCard">
        <!-- Modal Top Ribbon -->
        <div class="bg-gradient-to-r from-teal-800 to-indigo-900 text-white p-6 relative">
            <button type="button" onclick="window.closePrescriptionModal()" class="absolute top-5 right-5 text-white/70 hover:text-white bg-white/10 hover:bg-white/20 rounded-full w-8 h-8 flex items-center justify-center transition">
                <i class="fas fa-times text-sm"></i>
            </button>
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-white/10 border border-white/20 flex items-center justify-center text-xl text-teal-300">
                    <i class="fas fa-file-prescription"></i>
                </div>
                <div>
                    <h3 class="text-xl font-extrabold tracking-tight">Upload Doctor Prescription</h3>
                    <p class="text-xs text-teal-200 mt-0.5">We will read your prescription & schedule home collection</p>
                </div>
            </div>
        </div>

        @if(session('prescription_success'))
            <div class="p-6 bg-emerald-50 border-b border-emerald-100 text-emerald-800 text-xs font-semibold flex items-start gap-3">
                <i class="fas fa-check-circle text-emerald-600 text-lg mt-0.5"></i>
                <div>
                    <p class="font-bold text-sm">Booking Request Placed!</p>
                    <p class="mt-1 leading-relaxed">{{ session('prescription_success') }}</p>
                </div>
            </div>
        @endif

        <form action="{{ route('prescription.quick_upload') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf

            @php
                $patient = session('patient_id') ? \App\Models\Patient::find(session('patient_id')) : null;
            @endphp

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">
                    Patient Name <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <i class="fas fa-user absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    <input type="text" name="patient_name" value="{{ old('patient_name', $patient ? $patient->name : '') }}" required placeholder="e.g. Rahul Sharma" class="w-full pl-9 pr-3 py-2.5 text-xs rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-teal-600">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">
                    Mobile Number (For Callback & Verification) <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <i class="fas fa-phone absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    <input type="tel" name="mobile_number" value="{{ old('mobile_number', $patient ? $patient->phone : '') }}" required maxlength="15" placeholder="e.g. 9876543210" class="w-full pl-9 pr-3 py-2.5 text-xs rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-teal-600 font-mono">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">
                    Attach Prescription (Image or PDF) <span class="text-red-500">*</span>
                </label>
                <div class="border-2 border-dashed border-gray-300 hover:border-teal-600 rounded-2xl p-4 text-center cursor-pointer transition bg-gray-50/50 hover:bg-teal-50/30 relative" onclick="document.getElementById('prescriptionFileInput').click()">
                    <input type="file" id="prescriptionFileInput" name="prescription_file" accept=".jpg,.jpeg,.png,.pdf" required class="hidden" onchange="previewPrescriptionFile(this)">
                    <div id="fileUploadPrompt">
                        <i class="fas fa-cloud-arrow-up text-2xl text-teal-700 mb-2"></i>
                        <p class="text-xs font-bold text-gray-700">Click to upload photo or document</p>
                        <p class="text-[10px] text-gray-400 mt-0.5">Supports JPG, PNG, PDF up to 5 MB</p>
                    </div>
                    <div id="fileSelectedDisplay" class="hidden text-xs font-bold text-teal-800">
                        <i class="fas fa-file-circle-check text-xl text-teal-700 mb-1 block"></i>
                        <span id="selectedFileName"></span>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">
                    Notes / Preferred Time Slot (Optional)
                </label>
                <textarea name="notes" rows="2" placeholder="e.g. Please arrange home collection tomorrow at 7:30 AM" class="w-full p-3 text-xs rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-teal-600"></textarea>
            </div>

            <!-- Trust Points -->
            <div class="bg-gray-50 rounded-xl p-3 flex items-center justify-between text-[10px] text-gray-500 font-medium">
                <span class="flex items-center gap-1.5"><i class="fas fa-lock text-teal-700"></i> 100% Confidential</span>
                <span class="flex items-center gap-1.5"><i class="fas fa-phone-volume text-amber-500"></i> Contact You Soon</span>
                <span class="flex items-center gap-1.5"><i class="fas fa-truck-medical text-emerald-600"></i> Doorstep Pickup</span>
            </div>

            <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-teal-700 to-teal-800 hover:from-teal-800 hover:to-teal-900 text-white text-xs font-extrabold uppercase tracking-wider rounded-xl shadow-lg transition flex items-center justify-center gap-2">
                <i class="fas fa-paper-plane"></i> Submit & Request Callback
            </button>
        </form>
    </div>
</div>

<script>
    window.openPrescriptionModal = function() {
        const modal = document.getElementById('prescriptionModal');
        const card = document.getElementById('prescriptionModalCard');
        if (!modal) return;
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            card.classList.remove('scale-95');
            card.classList.add('scale-100');
        }, 10);
        document.body.classList.add('overflow-hidden');
    };

    window.closePrescriptionModal = function() {
        const modal = document.getElementById('prescriptionModal');
        const card = document.getElementById('prescriptionModalCard');
        if (!modal) return;
        modal.classList.add('opacity-0');
        card.classList.remove('scale-100');
        card.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }, 250);
    };

    function previewPrescriptionFile(input) {
        if (input.files && input.files[0]) {
            const fileName = input.files[0].name;
            document.getElementById('fileUploadPrompt').classList.add('hidden');
            const display = document.getElementById('fileSelectedDisplay');
            display.classList.remove('hidden');
            document.getElementById('selectedFileName').innerText = fileName;
        }
    }

    // Auto-open modal if there is a prescription success alert
    @if(session('prescription_success'))
        document.addEventListener('DOMContentLoaded', function() {
            window.openPrescriptionModal();
        });
    @endif
</script>
