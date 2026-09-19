<!-- Add Member Side Modal (Offcanvas) -->
<div id="addMemberModal" class="fixed inset-0 z-50 hidden" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
    <!-- Background overlay -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeAddMemberModal()"></div>

    <div class="fixed inset-0 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                <!-- Sliding panel -->
                <div id="addMemberPanel" class="pointer-events-auto w-screen max-w-md transform transition ease-in-out duration-300 translate-x-full">
                    <div class="flex h-full flex-col bg-white shadow-2xl rounded-l-3xl overflow-hidden">
                        <!-- Header -->
                        <div class="bg-gradient-to-r from-gray-50 to-white px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-teal-50 text-brand-dark flex items-center justify-center font-bold text-lg border border-teal-100 shadow-sm">
                                    <i class="fas fa-user-plus text-brand-primary"></i>
                                </div>
                                <div>
                                    <h2 class="text-lg font-black text-brand-dark" id="slide-over-title">Add Family Member</h2>
                                    <p class="text-xs text-gray-500 font-medium">Link family profile for lab test booking & reports.</p>
                                </div>
                            </div>
                            <button type="button" onclick="closeAddMemberModal()" class="w-8 h-8 rounded-full hover:bg-gray-100 text-gray-400 hover:text-gray-600 flex items-center justify-center transition">
                                <i class="fas fa-times text-base"></i>
                            </button>
                        </div>
                        
                        <!-- Content / Form -->
                        <div class="relative flex-1 px-6 py-6 overflow-y-auto space-y-5">
                            <form id="addMemberForm" onsubmit="event.preventDefault(); saveNewMember();" class="space-y-5">
                                <!-- Error Alert Box (Dynamic) -->
                                <div id="addMemberErrorBox" class="hidden p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold"></div>

                                <!-- Full Name -->
                                <div>
                                    <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">
                                        Full Name (As per Govt. ID) <span class="text-rose-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">
                                            <i class="far fa-user"></i>
                                        </span>
                                        <input type="text" id="newMemberName" placeholder="e.g. Sunita Sharma" class="w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-primary focus:border-brand-primary font-bold text-gray-800 text-sm outline-none transition placeholder-gray-300" required>
                                    </div>
                                </div>

                                <!-- Gender Selection -->
                                <div>
                                    <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">
                                        Select Gender <span class="text-rose-500">*</span>
                                    </label>
                                    <div class="grid grid-cols-3 gap-2.5">
                                        <label class="cursor-pointer">
                                            <input type="radio" name="new_member_gender" value="Female" class="peer hidden" checked>
                                            <div class="border-2 border-gray-200 bg-white rounded-xl py-2.5 px-3 text-center font-bold text-xs text-gray-500 peer-checked:bg-teal-50 peer-checked:text-brand-dark peer-checked:border-brand-dark transition flex items-center justify-center gap-1.5 hover:border-gray-300 shadow-sm">
                                                <i class="fas fa-female text-pink-500"></i>
                                                <span>Female</span>
                                            </div>
                                        </label>
                                        <label class="cursor-pointer">
                                            <input type="radio" name="new_member_gender" value="Male" class="peer hidden">
                                            <div class="border-2 border-gray-200 bg-white rounded-xl py-2.5 px-3 text-center font-bold text-xs text-gray-500 peer-checked:bg-teal-50 peer-checked:text-brand-dark peer-checked:border-brand-dark transition flex items-center justify-center gap-1.5 hover:border-gray-300 shadow-sm">
                                                <i class="fas fa-male text-blue-500"></i>
                                                <span>Male</span>
                                            </div>
                                        </label>
                                        <label class="cursor-pointer">
                                            <input type="radio" name="new_member_gender" value="Other" class="peer hidden">
                                            <div class="border-2 border-gray-200 bg-white rounded-xl py-2.5 px-3 text-center font-bold text-xs text-gray-500 peer-checked:bg-teal-50 peer-checked:text-brand-dark peer-checked:border-brand-dark transition flex items-center justify-center gap-1.5 hover:border-gray-300 shadow-sm">
                                                <i class="fas fa-genderless text-emerald-500"></i>
                                                <span>Other</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <!-- Age / DOB -->
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">
                                            Age (Years) <span class="text-rose-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <input type="number" id="newMemberAge" min="0" max="120" placeholder="e.g. 28" class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-primary focus:border-brand-primary font-bold text-gray-800 text-sm outline-none transition placeholder-gray-300" required>
                                            <span class="absolute right-3.5 top-1/2 -translate-y-1/2 text-xs font-bold text-gray-400">Yrs</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">
                                            Date Of Birth
                                        </label>
                                        <input type="date" id="newMemberDob" class="w-full px-3 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-primary focus:border-brand-primary font-bold text-gray-800 text-sm outline-none transition text-gray-700">
                                    </div>
                                </div>

                                <!-- Relation Selector -->
                                <div>
                                    <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">
                                        Relation with Primary Member <span class="text-rose-500">*</span>
                                    </label>
                                    <div class="flex flex-wrap gap-2">
                                        <?php
                                            $modalRelations = ['Spouse', 'Mother', 'Father', 'Daughter', 'Son', 'Brother', 'Sister', 'Other'];
                                        ?>
                                        <?php $__currentLoopData = $modalRelations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $relOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <label class="cursor-pointer">
                                                <input type="radio" name="new_member_relation" value="<?php echo e($relOption); ?>" class="peer hidden" <?php echo e($idx === 0 ? 'checked' : ''); ?>>
                                                <div class="border border-gray-200 bg-gray-50 rounded-full px-4 py-2 cursor-pointer font-bold text-xs text-gray-600 peer-checked:bg-brand-dark peer-checked:text-white peer-checked:border-brand-dark transition hover:border-gray-300 shadow-sm">
                                                    <?php echo e($relOption); ?>

                                                </div>
                                            </label>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Footer -->
                        <div class="border-t border-gray-100 bg-gray-50/70 px-6 py-4 flex gap-3">
                            <button type="button" onclick="closeAddMemberModal()" class="w-1/3 border border-gray-200 bg-white hover:bg-gray-100 text-gray-700 font-bold py-3 rounded-xl transition text-sm">
                                Cancel
                            </button>
                            <button type="button" id="saveMemberBtn" onclick="saveNewMember()" class="w-2/3 bg-brand-dark hover:bg-teal-800 text-white font-extrabold py-3 rounded-xl transition shadow-md flex items-center justify-center gap-2 text-sm">
                                <i class="fas fa-check-circle"></i>
                                <span>Save Member</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function windowOpenAddMemberModal() {
        const modal = document.getElementById('addMemberModal');
        const panel = document.getElementById('addMemberPanel');
        const errorBox = document.getElementById('addMemberErrorBox');
        if (errorBox) errorBox.classList.add('hidden');

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        setTimeout(() => {
            panel.classList.remove('translate-x-full');
            panel.classList.add('translate-x-0');
        }, 10);
    }

    function closeAddMemberModal() {
        const panel = document.getElementById('addMemberPanel');
        panel.classList.remove('translate-x-0');
        panel.classList.add('translate-x-full');
        document.body.style.overflow = '';
        setTimeout(() => {
            document.getElementById('addMemberModal').classList.add('hidden');
        }, 300);
    }

    // Auto-calculate age from DOB inside modal
    document.addEventListener('DOMContentLoaded', function() {
        const dobInput = document.getElementById('newMemberDob');
        const ageInput = document.getElementById('newMemberAge');
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

    function saveNewMember() {
        const nameInput = document.getElementById('newMemberName');
        const ageInput = document.getElementById('newMemberAge');
        const errorBox = document.getElementById('addMemberErrorBox');
        const saveBtn = document.getElementById('saveMemberBtn');

        const name = nameInput.value.trim();
        const age = ageInput.value.trim();
        const genderEl = document.querySelector('input[name="new_member_gender"]:checked');
        const relationEl = document.querySelector('input[name="new_member_relation"]:checked');

        const gender = genderEl ? genderEl.value : 'Female';
        const relation = relationEl ? relationEl.value : 'Other';

        if (!name || !age) {
            if (errorBox) {
                errorBox.textContent = 'Please enter member full name and age.';
                errorBox.classList.remove('hidden');
            } else {
                alert('Please enter member full name and age.');
            }
            return;
        }

        saveBtn.disabled = true;
        saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Saving...';

        fetch("<?php echo e(route('patient.add_family_member')); ?>", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({ name, age, gender, relation })
        })
        .then(response => response.json())
        .then(data => {
            saveBtn.disabled = false;
            saveBtn.innerHTML = '<i class="fas fa-check-circle mr-1"></i> Save Member';

            if (data.success) {
                // Store active tab in session or hash to focus on newly created member
                if (data.member && data.member.id) {
                    window.location.hash = 'member-' + data.member.id;
                }
                window.location.reload();
            } else {
                if (errorBox) {
                    errorBox.textContent = data.message || 'Error saving member details. Please check inputs.';
                    errorBox.classList.remove('hidden');
                } else {
                    alert('Error saving member');
                }
            }
        })
        .catch(err => {
            saveBtn.disabled = false;
            saveBtn.innerHTML = '<i class="fas fa-check-circle mr-1"></i> Save Member';
            if (errorBox) {
                errorBox.textContent = 'A network error occurred. Please try again.';
                errorBox.classList.remove('hidden');
            }
        });
    }

    window.openAddMemberModal = windowOpenAddMemberModal;
</script>
<?php /**PATH C:\Users\Employee\Desktop\outsourcelab\resources\views/patient/modals/add-member.blade.php ENDPATH**/ ?>