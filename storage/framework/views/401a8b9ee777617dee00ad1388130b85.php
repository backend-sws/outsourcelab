<!-- Add Address Side Modal (Offcanvas) -->
<div id="addAddressModal" class="fixed inset-0 z-50 hidden" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
    <!-- Background overlay -->
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeAddAddressModal()"></div>

    <div class="fixed inset-0 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                <!-- Sliding panel -->
                <div id="addAddressPanel" class="pointer-events-auto w-screen max-w-md transform transition ease-in-out duration-500 sm:duration-700 translate-x-full">
                    <div class="flex h-full flex-col bg-white shadow-xl">
                        <!-- Header -->
                        <div class="bg-gray-50 px-4 py-6 sm:px-6 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <h2 class="text-xl font-extrabold text-gray-900" id="slide-over-title">Add Address</h2>
                                <div class="ml-3 flex h-7 items-center">
                                    <button type="button" onclick="closeAddAddressModal()" class="relative rounded-md bg-gray-50 text-gray-400 hover:text-gray-500 focus:outline-none">
                                        <span class="absolute -inset-2.5"></span>
                                        <span class="sr-only">Close panel</span>
                                        <i class="fas fa-times text-xl"></i>
                                    </button>
                                </div>
                            </div>
                            <p class="mt-1 text-xs text-gray-500 font-semibold">Enter your complete address for sample collection.</p>
                        </div>
                        
                        <!-- Content / Form -->
                        <div class="relative flex-1 px-4 py-6 sm:px-6 overflow-y-auto">
                            <form id="addAddressForm" class="space-y-6">
                                <!-- Address Title -->
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 mb-2">Address Title (e.g. Home, Office)</label>
                                    <input type="text" id="newAddressTitle" placeholder="Home" class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-secondary focus:border-brand-secondary font-bold text-gray-800 outline-none" required>
                                </div>

                                <!-- Full Address -->
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 mb-2">Complete Address</label>
                                    <textarea id="newAddressText" rows="3" placeholder="House/Flat No, Building, Street, Area" class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-secondary focus:border-brand-secondary font-bold text-gray-800 outline-none" required></textarea>
                                </div>

                                <!-- Pincode -->
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 mb-2">Pincode</label>
                                    <input type="text" id="newAddressPincode" placeholder="e.g. 800001" maxlength="6" class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-secondary focus:border-brand-secondary font-bold text-gray-800 outline-none" required>
                                </div>
                            </form>
                        </div>

                        <!-- Footer -->
                        <div class="flex flex-shrink-0 justify-end px-4 py-4 border-t border-gray-200 bg-white">
                            <button type="button" onclick="closeAddAddressModal()" class="rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 mr-3">Cancel</button>
                            <button type="button" onclick="saveNewAddress()" class="inline-flex justify-center rounded-lg bg-brand-dark px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-brand-secondary">Save Address</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function windowOpenAddAddressModal() {
        const modal = document.getElementById('addAddressModal');
        const panel = document.getElementById('addAddressPanel');
        
        modal.classList.remove('hidden');
        setTimeout(() => {
            panel.classList.remove('translate-x-full');
            panel.classList.add('translate-x-0');
        }, 10);
    }

    function closeAddAddressModal() {
        const panel = document.getElementById('addAddressPanel');
        
        panel.classList.remove('translate-x-0');
        panel.classList.add('translate-x-full');
        
        setTimeout(() => {
            document.getElementById('addAddressModal').classList.add('hidden');
        }, 500);
    }

    window.openAddAddressModal = windowOpenAddAddressModal;
</script>
<?php /**PATH D:\lab\lab\resources\views/patient/modals/add-address.blade.php ENDPATH**/ ?>