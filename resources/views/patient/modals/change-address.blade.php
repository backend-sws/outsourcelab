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
                                @forelse(($patient->addresses ?? []) as $index => $addr)
                                <label class="block cursor-pointer">
                                    <input type="radio" name="selected_address" value="{{ $addr->id }}" class="peer hidden" {{ $index === 0 ? 'checked' : '' }} data-id="{{ $addr->id }}" data-type="{{ $addr->title ?? 'Home' }}" data-address="{{ $addr->full_address }}" data-pincode="{{ $addr->pincode }}">
                                    <div class="border border-gray-200 bg-white rounded-xl p-4 peer-checked:border-brand-dark peer-checked:bg-brand-light/10 transition shadow-sm">
                                        <div class="flex items-start">
                                            <div class="pt-1 mr-3 text-gray-400 peer-checked:text-brand-dark">
                                                <i class="fas {{ strtolower($addr->title) === 'office' ? 'fa-building' : 'fa-home' }}"></i>
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="font-bold text-gray-800 text-sm">{{ $addr->title ?? 'Address' }}</h4>
                                                <p class="text-xs text-gray-500 mt-1 leading-relaxed">{{ $addr->full_address }} - {{ $addr->pincode }}</p>
                                            </div>
                                            <div class="w-5 h-5 rounded-full border border-gray-300 peer-checked:border-brand-dark flex items-center justify-center">
                                                <div class="w-2.5 h-2.5 rounded-full bg-brand-dark opacity-0 peer-checked:opacity-100 transition"></div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                                @empty
                                <div id="noAddressPlaceholder" class="text-center py-6 text-gray-400">
                                    <i class="fas fa-map-marked-alt text-3xl mb-2 text-gray-300"></i>
                                    <p class="text-sm font-semibold">No saved addresses found.</p>
                                </div>
                                @endforelse
                            </div>
                            
                            <!-- Inline Add Address Form -->
                            <div id="inlineAddAddressForm" class="hidden mt-4 bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                                <h4 class="font-bold text-sm text-gray-800 mb-3">Add New Address</h4>
                                <div class="space-y-3">
                                    <input type="text" id="newAddrTitle" placeholder="Address Label (e.g. Home, Office)" class="w-full text-xs border border-gray-300 rounded-lg p-2.5 outline-none focus:border-brand-dark">
                                    <textarea id="newAddrFull" rows="2" placeholder="Full Street Address" class="w-full text-xs border border-gray-300 rounded-lg p-2.5 outline-none focus:border-brand-dark"></textarea>
                                    <input type="text" id="newAddrPincode" placeholder="6-digit Pincode" maxlength="6" class="w-full text-xs border border-gray-300 rounded-lg p-2.5 outline-none focus:border-brand-dark">
                                    <div class="flex gap-2">
                                        <button type="button" onclick="submitNewAddress()" class="flex-1 bg-brand-dark text-white text-xs font-bold py-2 rounded-lg hover:bg-brand-secondary transition">Save Address</button>
                                        <button type="button" onclick="toggleInlineAddressForm(false)" class="px-3 bg-gray-100 text-gray-600 text-xs font-bold py-2 rounded-lg hover:bg-gray-200">Cancel</button>
                                    </div>
                                </div>
                            </div>

                            <button id="btnShowAddAddress" type="button" onclick="toggleInlineAddressForm(true)" class="w-full mt-6 py-3 border border-brand-dark border-dashed rounded-xl text-brand-dark font-bold text-sm hover:bg-brand-light/20 transition flex items-center justify-center">
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
        setTimeout(() => {
            panel.classList.remove('translate-x-full');
            panel.classList.add('translate-x-0');
        }, 10);
    }

    function closeChangeAddressModal() {
        const panel = document.getElementById('changeAddressPanel');
        
        panel.classList.remove('translate-x-0');
        panel.classList.add('translate-x-full');
        
        setTimeout(() => {
            document.getElementById('changeAddressModal').classList.add('hidden');
        }, 500);
    }

    function toggleInlineAddressForm(show) {
        document.getElementById('inlineAddAddressForm').classList.toggle('hidden', !show);
        document.getElementById('btnShowAddAddress').classList.toggle('hidden', show);
    }

    function submitNewAddress() {
        const title = document.getElementById('newAddrTitle').value.trim();
        const address = document.getElementById('newAddrFull').value.trim();
        const pincode = document.getElementById('newAddrPincode').value.trim();

        if (!title || !address || !pincode) {
            alert('Please fill out all address fields.');
            return;
        }

        fetch('{{ route("patient.add_address") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ title, address, pincode })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success && data.address) {
                const addr = data.address;
                const placeholder = document.getElementById('noAddressPlaceholder');
                if (placeholder) placeholder.remove();

                const newHtml = `
                    <label class="block cursor-pointer">
                        <input type="radio" name="selected_address" value="${addr.id}" class="peer hidden" checked data-id="${addr.id}" data-type="${addr.title}" data-address="${addr.full_address}" data-pincode="${addr.pincode}">
                        <div class="border border-gray-200 bg-white rounded-xl p-4 peer-checked:border-brand-dark peer-checked:bg-brand-light/10 transition shadow-sm">
                            <div class="flex items-start">
                                <div class="pt-1 mr-3 text-gray-400 peer-checked:text-brand-dark">
                                    <i class="fas ${addr.title.toLowerCase() === 'office' ? 'fa-building' : 'fa-home'}"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-800 text-sm">${addr.title}</h4>
                                    <p class="text-xs text-gray-500 mt-1 leading-relaxed">${addr.full_address} - ${addr.pincode}</p>
                                </div>
                                <div class="w-5 h-5 rounded-full border border-gray-300 peer-checked:border-brand-dark flex items-center justify-center">
                                    <div class="w-2.5 h-2.5 rounded-full bg-brand-dark opacity-0 peer-checked:opacity-100 transition"></div>
                                </div>
                            </div>
                        </div>
                    </label>
                `;
                document.getElementById('addressList').insertAdjacentHTML('afterbegin', newHtml);
                toggleInlineAddressForm(false);
                document.getElementById('newAddrTitle').value = '';
                document.getElementById('newAddrFull').value = '';
                document.getElementById('newAddrPincode').value = '';
            } else {
                alert('Could not save address. Please try again.');
            }
        })
        .catch(() => alert('Network error saving address.'));
    }

    function confirmAddressChange() {
        const selectedOption = document.querySelector('input[name="selected_address"]:checked');
        if (selectedOption) {
            const addressId = selectedOption.value;
            const addressType = selectedOption.getAttribute('data-type');
            const addressText = selectedOption.getAttribute('data-address');
            const addressPincode = selectedOption.getAttribute('data-pincode');
            
            // Update UI in checkout
            const typeEl = document.getElementById('displayAddressType');
            const textEl = document.getElementById('displayAddressText');
            if (typeEl) typeEl.innerText = addressType;
            if (textEl) textEl.innerText = addressText;

            window.selectedAddressId = addressId;

            if (addressPincode && document.getElementById('pincodeInput')) {
                document.getElementById('pincodeInput').value = addressPincode;
                if (typeof window.verifyPincode === 'function') {
                    window.verifyPincode();
                }
            }
            
            closeChangeAddressModal();
        }
    }

    // Expose globally
    window.openChangeAddressModal = windowOpenChangeAddressModal;
</script>
