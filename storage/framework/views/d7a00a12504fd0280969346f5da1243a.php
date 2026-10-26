<!-- Add / Edit Address Side Modal (Offcanvas) -->
<div id="addAddressModal" class="fixed inset-0 z-50 hidden" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
    <!-- Background overlay -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeAddAddressModal()"></div>

    <div class="fixed inset-0 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                <!-- Sliding panel -->
                <div id="addAddressPanel" class="pointer-events-auto w-screen max-w-md transform transition ease-in-out duration-300 translate-x-full">
                    <div class="flex h-full flex-col bg-white shadow-2xl rounded-l-3xl overflow-hidden">
                        <!-- Header -->
                        <div class="bg-gradient-to-r from-gray-50 to-white px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-teal-50 text-brand-dark flex items-center justify-center font-bold text-lg border border-teal-100 shadow-sm">
                                    <i class="fas fa-map-marker-alt text-brand-primary"></i>
                                </div>
                                <div>
                                    <h2 class="text-lg font-black text-brand-dark" id="addressModalTitle">Add Delivery Address</h2>
                                    <p class="text-xs text-gray-500 font-medium">Enter your complete address for home sample collection.</p>
                                </div>
                            </div>
                            <button type="button" onclick="closeAddAddressModal()" class="w-8 h-8 rounded-full hover:bg-gray-100 text-gray-400 hover:text-gray-600 flex items-center justify-center transition">
                                <i class="fas fa-times text-base"></i>
                            </button>
                        </div>
                        
                        <!-- Content / Form -->
                        <div class="relative flex-1 px-6 py-6 overflow-y-auto space-y-5">
                            <form id="addAddressForm" onsubmit="event.preventDefault(); saveNewAddress();" class="space-y-5">
                                <input type="hidden" id="editAddressId" value="">

                                <!-- Error Alert Box (Dynamic) -->
                                <div id="addAddressErrorBox" class="hidden p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold"></div>

                                <!-- Address Title / Quick Tags -->
                                <div>
                                    <div class="flex items-center justify-between mb-2">
                                        <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider">
                                            Address Title / Label
                                        </label>
                                        <span class="text-[11px] text-gray-400 font-medium">e.g. Home, Office, Native</span>
                                    </div>

                                    <!-- Quick Tags -->
                                    <div class="flex flex-wrap gap-2 mb-2">
                                        <button type="button" onclick="setAddressTitleTag('Home')" class="addr-tag-btn px-3 py-1 rounded-full text-xs font-bold border border-gray-200 bg-gray-50 text-gray-600 hover:border-brand-primary hover:text-brand-dark hover:bg-teal-50 transition">
                                            <i class="fas fa-home text-[10px] mr-1"></i> Home
                                        </button>
                                        <button type="button" onclick="setAddressTitleTag('Office')" class="addr-tag-btn px-3 py-1 rounded-full text-xs font-bold border border-gray-200 bg-gray-50 text-gray-600 hover:border-brand-primary hover:text-brand-dark hover:bg-teal-50 transition">
                                            <i class="fas fa-briefcase text-[10px] mr-1"></i> Office
                                        </button>
                                        <button type="button" onclick="setAddressTitleTag('Parents')" class="addr-tag-btn px-3 py-1 rounded-full text-xs font-bold border border-gray-200 bg-gray-50 text-gray-600 hover:border-brand-primary hover:text-brand-dark hover:bg-teal-50 transition">
                                            <i class="fas fa-heart text-[10px] mr-1"></i> Parents
                                        </button>
                                        <button type="button" onclick="setAddressTitleTag('Other')" class="addr-tag-btn px-3 py-1 rounded-full text-xs font-bold border border-gray-200 bg-gray-50 text-gray-600 hover:border-brand-primary hover:text-brand-dark hover:bg-teal-50 transition">
                                            <i class="fas fa-map-pin text-[10px] mr-1"></i> Other
                                        </button>
                                    </div>

                                    <input 
                                        type="text" 
                                        id="newAddressTitle" 
                                        placeholder="Enter Address Title (e.g. Home, Village Address)" 
                                        class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-primary focus:border-brand-primary font-bold text-gray-800 text-sm outline-none transition placeholder-gray-300"
                                    >
                                </div>

                                <!-- Full Address -->
                                <div>
                                    <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">
                                        Complete Address <span class="text-rose-500">*</span>
                                    </label>
                                    <textarea 
                                        id="newAddressText" 
                                        rows="4" 
                                        placeholder="House/Flat No, S/O, Village / Colony, Street, Post Office, Police Station, Landmark" 
                                        class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-primary focus:border-brand-primary font-bold text-gray-800 text-sm outline-none transition placeholder-gray-300 leading-relaxed" 
                                        required
                                    ></textarea>
                                </div>

                                <!-- Pincode -->
                                <div>
                                    <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">
                                        Postal Pincode <span class="text-rose-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input 
                                            type="text" 
                                            id="newAddressPincode" 
                                            placeholder="e.g. 822116" 
                                            maxlength="10" 
                                            class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-primary focus:border-brand-primary font-bold text-gray-800 text-sm outline-none transition placeholder-gray-300 font-mono tracking-wider" 
                                            required
                                        >
                                        <span class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs font-semibold">
                                            <i class="fas fa-mail-bulk"></i>
                                        </span>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Footer -->
                        <div class="border-t border-gray-100 bg-gray-50/70 px-6 py-4 flex gap-3">
                            <button type="button" onclick="closeAddAddressModal()" class="w-1/3 border border-gray-200 bg-white hover:bg-gray-100 text-gray-700 font-bold py-3 rounded-xl transition text-sm">
                                Cancel
                            </button>
                            <button type="button" id="saveAddressBtn" onclick="saveNewAddress()" class="w-2/3 bg-brand-dark hover:bg-teal-800 text-white font-extrabold py-3 rounded-xl transition shadow-md flex items-center justify-center gap-2 text-sm">
                                <i class="fas fa-check-circle"></i>
                                <span id="saveAddressBtnText">Save Address</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function setAddressTitleTag(val) {
        const titleInput = document.getElementById('newAddressTitle');
        if (titleInput) {
            titleInput.value = val;
            titleInput.focus();
        }
    }

    function windowOpenAddAddressModal(editData = null) {
        const modal = document.getElementById('addAddressModal');
        const panel = document.getElementById('addAddressPanel');
        const errorBox = document.getElementById('addAddressErrorBox');
        if (errorBox) errorBox.classList.add('hidden');

        const titleEl = document.getElementById('newAddressTitle');
        const textEl = document.getElementById('newAddressText');
        const pinEl = document.getElementById('newAddressPincode');
        const idEl = document.getElementById('editAddressId');
        const modalTitle = document.getElementById('addressModalTitle');
        const btnText = document.getElementById('saveAddressBtnText');

        if (editData) {
            if (idEl) idEl.value = editData.id || '';
            if (titleEl) titleEl.value = editData.title || '';
            if (textEl) textEl.value = editData.full_address || editData.address || '';
            if (pinEl) pinEl.value = editData.pincode || '';
            if (modalTitle) modalTitle.textContent = 'Edit Delivery Address';
            if (btnText) btnText.textContent = 'Update Address';
        } else {
            if (idEl) idEl.value = '';
            if (titleEl) titleEl.value = 'Home';
            if (textEl) textEl.value = '';
            if (pinEl) pinEl.value = '';
            if (modalTitle) modalTitle.textContent = 'Add Delivery Address';
            if (btnText) btnText.textContent = 'Save Address';
        }

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        setTimeout(() => {
            panel.classList.remove('translate-x-full');
            panel.classList.add('translate-x-0');
        }, 10);
    }

    function closeAddAddressModal() {
        const panel = document.getElementById('addAddressPanel');
        panel.classList.remove('translate-x-0');
        panel.classList.add('translate-x-full');
        document.body.style.overflow = '';
        setTimeout(() => {
            document.getElementById('addAddressModal').classList.add('hidden');
        }, 300);
    }

    function saveNewAddress() {
        const titleInput = document.getElementById('newAddressTitle');
        const addressInput = document.getElementById('newAddressText');
        const pincodeInput = document.getElementById('newAddressPincode');
        const idInput = document.getElementById('editAddressId');
        const errorBox = document.getElementById('addAddressErrorBox');
        const saveBtn = document.getElementById('saveAddressBtn');

        let title = (titleInput ? titleInput.value : '').trim();
        let address = (addressInput ? addressInput.value : '').trim();
        let pincode = (pincodeInput ? pincodeInput.value : '').trim();
        const editId = idInput ? idInput.value : '';

        if (!title) {
            title = 'Home';
        }

        if (!address || !pincode) {
            if (errorBox) {
                errorBox.textContent = 'Please enter complete address and postal pincode.';
                errorBox.classList.remove('hidden');
            } else {
                alert('Please enter complete address and pincode.');
            }
            return;
        }

        saveBtn.disabled = true;
        saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Saving...';

        const url = editId ? `/patient/address-book/${editId}` : "<?php echo e(route('patient.add_address')); ?>";
        const method = editId ? 'PUT' : 'POST';

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({ title, address, pincode })
        })
        .then(async (response) => {
            saveBtn.disabled = false;
            saveBtn.innerHTML = '<i class="fas fa-check-circle mr-1"></i> <span>' + (editId ? 'Update Address' : 'Save Address') + '</span>';

            const data = await response.json().catch(() => ({}));

            if (response.ok && data.success) {
                closeAddAddressModal();
                // If on address book page, reload
                if (window.location.pathname.includes('/address-book')) {
                    window.location.reload();
                } else if (typeof window.refreshAddresses === 'function') {
                    // If on checkout page, call refresh
                    window.refreshAddresses();
                } else {
                    window.location.reload();
                }
            } else {
                let errorMsg = data.message || 'Error saving address. Please verify your details.';
                if (data.errors) {
                    const firstKey = Object.keys(data.errors)[0];
                    if (firstKey && data.errors[firstKey].length) {
                        errorMsg = data.errors[firstKey][0];
                    }
                }
                if (errorBox) {
                    errorBox.textContent = errorMsg;
                    errorBox.classList.remove('hidden');
                } else {
                    alert(errorMsg);
                }
            }
        })
        .catch(err => {
            saveBtn.disabled = false;
            saveBtn.innerHTML = '<i class="fas fa-check-circle mr-1"></i> <span>' + (editId ? 'Update Address' : 'Save Address') + '</span>';
            if (errorBox) {
                errorBox.textContent = 'A network error occurred. Please try again.';
                errorBox.classList.remove('hidden');
            } else {
                alert('A network error occurred. Please try again.');
            }
        });
    }

    window.openAddAddressModal = windowOpenAddAddressModal;
    window.saveNewAddress = saveNewAddress;
</script>
<?php /**PATH C:\Users\Employee\Desktop\outsourcelab\resources\views/patient/modals/add-address.blade.php ENDPATH**/ ?>