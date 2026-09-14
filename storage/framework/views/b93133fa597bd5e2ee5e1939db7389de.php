<!-- Add Member Side Modal (Offcanvas) -->
<div id="addMemberModal" class="fixed inset-0 z-50 hidden" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
    <!-- Background overlay -->
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeAddMemberModal()"></div>

    <div class="fixed inset-0 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                <!-- Sliding panel -->
                <div id="addMemberPanel" class="pointer-events-auto w-screen max-w-md transform transition ease-in-out duration-500 sm:duration-700 translate-x-full">
                    <div class="flex h-full flex-col bg-white shadow-xl">
                        <!-- Header -->
                        <div class="bg-gray-50 px-4 py-6 sm:px-6 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <h2 class="text-xl font-extrabold text-gray-900" id="slide-over-title">Add Member</h2>
                                <div class="ml-3 flex h-7 items-center">
                                    <button type="button" onclick="closeAddMemberModal()" class="relative rounded-md bg-gray-50 text-gray-400 hover:text-gray-500 focus:outline-none">
                                        <span class="absolute -inset-2.5"></span>
                                        <span class="sr-only">Close panel</span>
                                        <i class="fas fa-times text-xl"></i>
                                    </button>
                                </div>
                            </div>
                            <p class="mt-1 text-xs text-gray-500 font-semibold">Please fill all details properly. This will be used in the test report.</p>
                        </div>
                        
                        <!-- Content / Form -->
                        <div class="relative flex-1 px-4 py-6 sm:px-6 overflow-y-auto">
                            <form id="addMemberForm" class="space-y-6">
                                <!-- Full Name -->
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 mb-2">Enter Full Name</label>
                                    <input type="text" id="newMemberName" class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-secondary focus:border-brand-secondary font-bold text-gray-800 outline-none" required>
                                </div>

                                <!-- Gender -->
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 mb-2">Select Gender</label>
                                    <div class="flex space-x-4">
                                        <label class="flex-1">
                                            <input type="radio" name="new_member_gender" value="female" class="peer hidden" checked>
                                            <div class="border border-gray-200 rounded-full py-2.5 text-center cursor-pointer font-bold text-gray-400 peer-checked:bg-brand-light/10 peer-checked:text-brand-dark peer-checked:border-brand-dark transition flex items-center justify-center">
                                                <i class="fas fa-female mr-2 text-lg"></i> Female
                                            </div>
                                        </label>
                                        <label class="flex-1">
                                            <input type="radio" name="new_member_gender" value="male" class="peer hidden">
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
                                        <input type="number" id="newMemberAge" placeholder="Age" class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-secondary focus:border-brand-secondary font-bold text-gray-800 outline-none placeholder-gray-300">
                                    </div>
                                    <div class="flex items-center justify-center text-gray-300 pt-6">/</div>
                                    <div class="flex-1 relative">
                                        <label class="block text-xs font-bold text-gray-500 mb-2">Date Of Birth</label>
                                        <input type="date" class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-secondary focus:border-brand-secondary font-bold text-gray-800 outline-none text-gray-400">
                                    </div>
                                </div>

                                <!-- Relation -->
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 mb-2">Select Relation</label>
                                    <div class="flex flex-wrap gap-3">
                                        <label>
                                            <input type="radio" name="new_member_relation" value="spouse" class="peer hidden" checked>
                                            <div class="border border-gray-200 bg-gray-50 rounded-full px-6 py-2 cursor-pointer font-bold text-gray-400 peer-checked:bg-blue-50 peer-checked:text-brand-dark peer-checked:border-brand-dark transition text-sm">Spouse</div>
                                        </label>
                                        <label>
                                            <input type="radio" name="new_member_relation" value="mother" class="peer hidden">
                                            <div class="border border-gray-200 bg-gray-50 rounded-full px-6 py-2 cursor-pointer font-bold text-gray-400 peer-checked:bg-blue-50 peer-checked:text-brand-dark peer-checked:border-brand-dark transition text-sm">Mother</div>
                                        </label>
                                        <label>
                                            <input type="radio" name="new_member_relation" value="father" class="peer hidden">
                                            <div class="border border-gray-200 bg-gray-50 rounded-full px-6 py-2 cursor-pointer font-bold text-gray-400 peer-checked:bg-blue-50 peer-checked:text-brand-dark peer-checked:border-brand-dark transition text-sm">Father</div>
                                        </label>
                                        <label>
                                            <input type="radio" name="new_member_relation" value="daughter" class="peer hidden">
                                            <div class="border border-gray-200 bg-gray-50 rounded-full px-6 py-2 cursor-pointer font-bold text-gray-400 peer-checked:bg-blue-50 peer-checked:text-brand-dark peer-checked:border-brand-dark transition text-sm">Daughter</div>
                                        </label>
                                        <label>
                                            <input type="radio" name="new_member_relation" value="other" class="peer hidden">
                                            <div class="border border-gray-200 bg-gray-50 rounded-full px-6 py-2 cursor-pointer font-bold text-gray-400 peer-checked:bg-blue-50 peer-checked:text-brand-dark peer-checked:border-brand-dark transition text-sm">Other</div>
                                        </label>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Footer -->
                        <div class="border-t border-gray-200 px-4 py-4 sm:px-6">
                            <button type="button" onclick="saveNewMember()" class="w-full bg-brand-dark text-white font-bold py-3.5 rounded-xl hover:bg-brand-secondary transition shadow-sm">Save Details</button>
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
        modal.classList.remove('hidden');
        setTimeout(() => {
            panel.classList.remove('translate-x-full');
            panel.classList.add('translate-x-0');
        }, 10);
    }

    function closeAddMemberModal() {
        const panel = document.getElementById('addMemberPanel');
        panel.classList.remove('translate-x-0');
        panel.classList.add('translate-x-full');
        setTimeout(() => {
            document.getElementById('addMemberModal').classList.add('hidden');
        }, 500); // match transition duration
    }

    // Bind to window so it can be called from anywhere
    window.openAddMemberModal = windowOpenAddMemberModal;
</script>
<?php /**PATH D:\lab\lab\resources\views/patient/modals/add-member.blade.php ENDPATH**/ ?>