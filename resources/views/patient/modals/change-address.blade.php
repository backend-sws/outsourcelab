<!-- Change Address Side Modal (Offcanvas) -->
<div id="changeAddressModal" class="fixed inset-0 z-50 hidden" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
    <!-- Background overlay -->
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeChangeAddressModal()"></div>

    <div class="fixed inset-0 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                <!-- Sliding panel -->
                <div id="changeAddressPanel" class="pointer-events-auto w-screen max-w-md transform transition ease-in-out duration-500 sm:duration-700 translate-x-full">
                    <div class="flex h-full flex-col bg-white shadow-xl">
                        <!-- Header -->
                        <div class="bg-gray-50 px-4 py-6 sm:px-6 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <h2 class="text-xl font-extrabold text-gray-900" id="slide-over-title">Change Address</h2>
                                <div class="ml-3 flex h-7 items-center">
                                    <button type="button" onclick="closeChangeAddressModal()" class="relative rounded-md bg-gray-50 text-gray-400 hover:text-gray-500 focus:outline-none">
                                        <span class="absolute -inset-2.5"></span>
                                        <span class="sr-only">Close panel</span>
                                        <i class="fas fa-times text-xl"></i>
                                    </button>
                                </div>
                            </div>
                            <p class="mt-1 text-xs text-gray-500 font-semibold">Select an address from your saved addresses.</p>
                        </div>
                        
                        <!-- Content / List -->
                        <div class="relative flex-1 px-4 py-6 sm:px-6 overflow-y-auto bg-gray-50/50">
                            <div class="space-y-4" id="addressList">
                                <!-- Address Item 1 -->
                                <label class="block cursor-pointer">
                                    <input type="radio" name="selected_address" value="home" class="peer hidden" checked data-type="Home" data-address="3rd Floor, Parvati Tower, Phulwari Rd, Jagdeo Path...">
                                    <div class="border border-gray-200 bg-white rounded-xl p-4 peer-checked:border-brand-dark peer-checked:bg-brand-light/10 transition shadow-sm">
                                        <div class="flex items-start">
                                            <div class="pt-1 mr-3 text-gray-400 peer-checked:text-brand-dark">
                                                <i class="fas fa-home"></i>
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="font-bold text-gray-800 text-sm">Home</h4>
                                                <p class="text-xs text-gray-500 mt-1 leading-relaxed">3rd Floor, Parvati Tower, Phulwari Rd, Jagdeo Path...</p>
                                            </div>
                                            <div class="w-5 h-5 rounded-full border border-gray-300 peer-checked:border-brand-dark flex items-center justify-center">
                                                <div class="w-2.5 h-2.5 rounded-full bg-brand-dark opacity-0 peer-checked:opacity-100 transition"></div>
                                            </div>
                                        </div>
                                    </div>
                                </label>

                                <!-- Address Item 2 -->
                                <label class="block cursor-pointer">
                                    <input type="radio" name="selected_address" value="office" class="peer hidden" data-type="Office" data-address="Tech Park, Block B, Floor 4, Sector 5, Patna, 800001">
                                    <div class="border border-gray-200 bg-white rounded-xl p-4 peer-checked:border-brand-dark peer-checked:bg-brand-light/10 transition shadow-sm">
                                        <div class="flex items-start">
                                            <div class="pt-1 mr-3 text-gray-400 peer-checked:text-brand-dark">
                                                <i class="fas fa-building"></i>
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="font-bold text-gray-800 text-sm">Office</h4>
                                                <p class="text-xs text-gray-500 mt-1 leading-relaxed">Tech Park, Block B, Floor 4, Sector 5, Patna, 800001</p>
                                            </div>
                                            <div class="w-5 h-5 rounded-full border border-gray-300 peer-checked:border-brand-dark flex items-center justify-center">
                                                <div class="w-2.5 h-2.5 rounded-full bg-brand-dark opacity-0 peer-checked:opacity-100 transition"></div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            
                            <button class="w-full mt-6 py-3 border border-brand-dark border-dashed rounded-xl text-brand-dark font-bold text-sm hover:bg-brand-light/20 transition flex items-center justify-center">
                                <i class="fas fa-plus mr-2"></i> Add New Address
                            </button>
                        </div>

                        <!-- Footer -->
                        <div class="flex flex-shrink-0 justify-end px-4 py-4 border-t border-gray-200 bg-white">
                            <button type="button" onclick="closeChangeAddressModal()" class="rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 mr-3">Cancel</button>
                            <button type="button" onclick="confirmAddressChange()" class="inline-flex justify-center rounded-lg bg-brand-dark px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-brand-secondary">Confirm Address</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function windowOpenChangeAddressModal() {
        const modal = document.getElementById('changeAddressModal');
        const panel = document.getElementById('changeAddressPanel');
        
        modal.classList.remove('hidden');
        // Small delay to allow display:block to apply before animating transform
        setTimeout(() => {
            panel.classList.remove('translate-x-full');
            panel.classList.add('translate-x-0');
        }, 10);
    }

    function closeChangeAddressModal() {
        const panel = document.getElementById('changeAddressPanel');
        
        panel.classList.remove('translate-x-0');
        panel.classList.add('translate-x-full');
        
        // Wait for animation to finish before hiding modal
        setTimeout(() => {
            document.getElementById('changeAddressModal').classList.add('hidden');
        }, 500);
    }

    function confirmAddressChange() {
        const selectedOption = document.querySelector('input[name="selected_address"]:checked');
        if(selectedOption) {
            const addressType = selectedOption.getAttribute('data-type');
            const addressText = selectedOption.getAttribute('data-address');
            
            // Update UI in checkout
            document.getElementById('displayAddressType').innerText = addressType;
            document.getElementById('displayAddressText').innerText = addressText;
            
            closeChangeAddressModal();
        }
    }

    // Expose globally
    window.openChangeAddressModal = windowOpenChangeAddressModal;
</script>
