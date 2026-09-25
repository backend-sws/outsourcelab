<!-- Modify Booking Modal -->
<div id="modifyBookingModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" onclick="closeModifyBookingModal()"></div>

    <div class="flex min-h-full items-center justify-center p-3 sm:p-4 text-center">
        <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all w-full max-w-2xl border border-slate-100 my-8">
            
            <!-- Loading Skeleton -->
            <div id="mbLoadingState" class="p-8 text-center space-y-4">
                <div class="w-12 h-12 mx-auto rounded-2xl bg-teal-50 border border-teal-200 flex items-center justify-center text-teal-700 animate-spin text-xl">
                    <i class="fas fa-spinner"></i>
                </div>
                <p class="text-xs font-bold text-slate-500">Loading booking details...</p>
            </div>

            <!-- Content State -->
            <div id="mbContentState" class="hidden">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-teal-900 via-teal-800 to-slate-900 px-6 py-5 text-white flex items-center justify-between">
                    <div>
                        <div class="flex items-center gap-2.5 flex-wrap">
                            <h3 class="text-base sm:text-lg font-black tracking-tight flex items-center gap-2">
                                <i class="fas fa-edit text-teal-400"></i>
                                <span>Modify Booking</span>
                            </h3>
                            <span id="mbBadgeRef" class="px-2.5 py-0.5 rounded-lg bg-white/10 font-mono text-xs font-bold text-teal-200 border border-white/10"></span>
                            <span id="mbBadgePayment" class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider"></span>
                        </div>
                        <p class="text-xs text-teal-100/80 mt-1 font-medium">Update tests, address, or reschedule appointment slot.</p>
                    </div>
                    <button type="button" onclick="closeModifyBookingModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition cursor-pointer flex-shrink-0">
                        <i class="fas fa-times text-sm"></i>
                    </button>
                </div>

                <!-- Modal Body (Scrollable) -->
                <div class="p-6 space-y-6 max-h-[72vh] overflow-y-auto bg-slate-50/50">

                    <!-- Info Alert Banner -->
                    <div id="mbNoticeBanner" class="p-3.5 rounded-2xl border text-xs flex items-start gap-3"></div>

                    <!-- 1. Diagnostic Tests & Packages -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-4 sm:p-5 shadow-2xs space-y-3">
                        <div class="flex items-center justify-between">
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-700 flex items-center gap-1.5">
                                <i class="fas fa-flask text-teal-700"></i>
                                <span>Diagnostic Tests & Packages</span>
                            </label>
                            <span id="mbTestCountBadge" class="text-[11px] font-bold text-slate-400">0 items</span>
                        </div>

                        <!-- Current Selected Tests List -->
                        <div id="mbTestsList" class="space-y-2 max-h-56 overflow-y-auto pr-1"></div>

                        <!-- Add Test / Package Autocomplete Search -->
                        <div class="pt-2 border-t border-slate-100 relative">
                            <label class="block text-[11px] font-bold text-slate-600 mb-1.5 flex items-center gap-1">
                                <i class="fas fa-plus-circle text-teal-600"></i>
                                <span>Add More Tests or Health Packages:</span>
                            </label>
                            <div class="relative">
                                <input 
                                    type="text" 
                                    id="mbSearchTestInput" 
                                    placeholder="Search by test name (e.g. CBC, Lipid, Thyroid, Vitamin D...)" 
                                    class="w-full px-3.5 py-2.5 text-xs font-bold bg-slate-50 border border-slate-300 rounded-xl outline-none focus:bg-white focus:ring-2 focus:ring-teal-700 transition"
                                    oninput="mbFilterCatalog(this.value)"
                                    autocomplete="off"
                                >
                                <i class="fas fa-search absolute right-3.5 top-3 text-slate-400 text-xs"></i>
                            </div>

                            <!-- Search Results Dropdown -->
                            <div id="mbSearchResults" class="hidden absolute left-0 right-0 top-full mt-1 bg-white border border-slate-200 rounded-2xl shadow-xl z-30 max-h-60 overflow-y-auto divide-y divide-slate-100"></div>
                        </div>
                    </div>

                    <!-- 2. Appointment Date & Slot -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-4 sm:p-5 shadow-2xs space-y-3">
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-700 flex items-center gap-1.5">
                            <i class="far fa-calendar-alt text-teal-700"></i>
                            <span>Reschedule Date & Time Slot</span>
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 mb-1">Collection Date</label>
                                <input 
                                    type="date" 
                                    id="mbDateInput" 
                                    min="{{ date('Y-m-d') }}"
                                    class="w-full px-3.5 py-2.5 text-xs font-bold bg-slate-50 border border-slate-300 rounded-xl outline-none focus:bg-white focus:ring-2 focus:ring-teal-700 transition"
                                >
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 mb-1">Preferred Time Window</label>
                                <select 
                                    id="mbSlotSelect" 
                                    class="w-full px-3.5 py-2.5 text-xs font-bold bg-slate-50 border border-slate-300 rounded-xl outline-none focus:bg-white focus:ring-2 focus:ring-teal-700 transition cursor-pointer"
                                >
                                    <option value="06:00 AM - 07:00 AM">06:00 AM - 07:00 AM (Early Morning Fasting)</option>
                                    <option value="07:00 AM - 08:00 AM">07:00 AM - 08:00 AM</option>
                                    <option value="08:00 AM - 09:00 AM">08:00 AM - 09:00 AM</option>
                                    <option value="09:00 AM - 10:00 AM">09:00 AM - 10:00 AM</option>
                                    <option value="10:00 AM - 11:00 AM">10:00 AM - 11:00 AM</option>
                                    <option value="11:00 AM - 12:00 PM">11:00 AM - 12:00 PM</option>
                                    <option value="12:00 PM - 02:00 PM">12:00 PM - 02:00 PM</option>
                                    <option value="02:00 PM - 04:00 PM">02:00 PM - 04:00 PM</option>
                                    <option value="04:00 PM - 06:00 PM">04:00 PM - 06:00 PM</option>
                                    <option value="06:00 PM - 08:00 PM">06:00 PM - 08:00 PM (Evening)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Beneficiary (Patient/Family Member) -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-4 sm:p-5 shadow-2xs space-y-3">
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-700 flex items-center gap-1.5">
                            <i class="far fa-user text-teal-700"></i>
                            <span>Test Beneficiary (For Whom)</span>
                        </label>
                        <select 
                            id="mbMemberSelect" 
                            class="w-full px-3.5 py-2.5 text-xs font-bold bg-slate-50 border border-slate-300 rounded-xl outline-none focus:bg-white focus:ring-2 focus:ring-teal-700 transition cursor-pointer"
                        ></select>
                    </div>

                    <!-- 4. Sample Collection Address -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-4 sm:p-5 shadow-2xs space-y-3">
                        <div class="flex items-center justify-between">
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-700 flex items-center gap-1.5">
                                <i class="fas fa-map-marker-alt text-teal-700"></i>
                                <span>Sample Collection Address</span>
                            </label>
                            <button type="button" onclick="window.openAddAddressModal && window.openAddAddressModal()" class="text-xs font-bold text-teal-700 hover:text-teal-900 underline flex items-center gap-1 cursor-pointer">
                                <i class="fas fa-plus text-[10px]"></i>
                                <span>Add New Address</span>
                            </button>
                        </div>
                        <div id="mbAddressList" class="space-y-2"></div>
                    </div>

                    <!-- 5. Payment & Additional Price Summary (For Paid Bookings with New Tests) -->
                    <div id="mbPaymentChoiceSection" class="hidden bg-emerald-50/70 border border-emerald-200 rounded-2xl p-4 sm:p-5 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-black uppercase tracking-wider text-emerald-900 flex items-center gap-1.5">
                                <i class="fas fa-wallet text-emerald-700"></i>
                                <span>Additional Amount for Added Tests</span>
                            </span>
                            <span id="mbAdditionalAmountText" class="text-base font-black text-emerald-800">₹0</span>
                        </div>
                        <p class="text-xs text-emerald-800/80 font-medium">Choose how you'd like to pay for the newly added tests:</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                            <label class="border-2 border-emerald-300 bg-white rounded-xl p-3 flex items-center gap-3 cursor-pointer hover:border-emerald-600 transition">
                                <input type="radio" name="mb_payment_diff" value="Cash" checked class="text-teal-700 focus:ring-teal-700">
                                <div>
                                    <span class="block text-xs font-black text-slate-800">Pay on Collection</span>
                                    <span class="block text-[11px] text-slate-500 font-medium">Pay cash to phlebotomist at sample collection</span>
                                </div>
                            </label>
                            <label class="border-2 border-emerald-300 bg-white rounded-xl p-3 flex items-center gap-3 cursor-pointer hover:border-emerald-600 transition">
                                <input type="radio" name="mb_payment_diff" value="Online" class="text-teal-700 focus:ring-teal-700">
                                <div>
                                    <span class="block text-xs font-black text-slate-800">Pay Online (Razorpay)</span>
                                    <span class="block text-[11px] text-slate-500 font-medium">Instant UPI, Cards & Netbanking</span>
                                </div>
                            </label>
                        </div>
                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="bg-white px-6 py-4 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-3">
                    <div class="text-left">
                        <span class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400 block">Total Booking Amount</span>
                        <div class="flex items-baseline gap-2">
                            <span id="mbTotalAmountText" class="text-xl font-black text-teal-900">₹0</span>
                            <span id="mbOriginalAmountSubtext" class="text-xs text-slate-400 font-semibold line-through hidden"></span>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 w-full sm:w-auto">
                        <button type="button" onclick="closeModifyBookingModal()" class="w-1/2 sm:w-auto px-4 py-2.5 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-100 font-extrabold text-xs transition cursor-pointer">
                            Cancel
                        </button>
                        <button type="button" id="mbSubmitBtn" onclick="submitModifyBooking()" class="w-1/2 sm:w-auto px-6 py-2.5 rounded-xl bg-teal-800 hover:bg-teal-900 text-white font-black text-xs transition shadow-md hover:shadow-lg cursor-pointer flex items-center justify-center gap-1.5">
                            <i class="fas fa-check"></i>
                            <span id="mbSubmitBtnText">Save Changes</span>
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<script>
    // State for booking modification
    let mbCurrentBookingId = null;
    let mbBookingData = null;
    let mbSelectedTests = []; // [{id, name, price, type, is_original}]
    let mbOriginalTestKeys = new Set();
    let mbCatalogTests = [];
    let mbCatalogPackages = [];

    function openModifyBookingModal(bookingId) {
        mbCurrentBookingId = bookingId;
        const modal = document.getElementById('modifyBookingModal');
        const loadingState = document.getElementById('mbLoadingState');
        const contentState = document.getElementById('mbContentState');
        
        modal.classList.remove('hidden');
        loadingState.classList.remove('hidden');
        contentState.classList.add('hidden');
        document.body.classList.add('overflow-hidden');

        fetch(`/patient/bookings/${bookingId}/details`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(r => r.json())
        .then(data => {
            if (!data.success) {
                alert(data.message || 'Could not load booking details.');
                closeModifyBookingModal();
                return;
            }

            mbBookingData = data;
            mbCatalogTests = data.catalog?.tests || [];
            mbCatalogPackages = data.catalog?.packages || [];

            // Initialize Original Tests
            mbOriginalTestKeys.clear();
            mbSelectedTests = (data.booking.tests || []).map(t => {
                const k = (t.type || 'test') + '_' + t.id;
                mbOriginalTestKeys.add(k);
                return {
                    id: t.id,
                    name: t.name || t.title || 'Diagnostic Test',
                    price: parseFloat(t.price || t.selling_price || 0),
                    type: t.type || 'test',
                    is_original: true
                };
            });

            // Populate UI Elements
            document.getElementById('mbBadgeRef').innerText = '#' + data.booking.reference;
            const badgePayment = document.getElementById('mbBadgePayment');
            if (data.is_paid) {
                badgePayment.className = 'px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-emerald-500/20 text-emerald-300 border border-emerald-400/30';
                badgePayment.innerHTML = '<i class="fas fa-check-circle mr-1"></i> Paid Online';
            } else {
                badgePayment.className = 'px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-amber-500/20 text-amber-300 border border-amber-400/30';
                badgePayment.innerHTML = '<i class="fas fa-clock mr-1"></i> Pay on Collection';
            }

            // Banner
            const banner = document.getElementById('mbNoticeBanner');
            if (data.is_paid) {
                banner.className = 'p-3.5 rounded-2xl border text-xs flex items-start gap-3 bg-blue-50 border-blue-200 text-blue-900';
                banner.innerHTML = `
                    <i class="fas fa-lock text-blue-700 text-base mt-0.5 flex-shrink-0"></i>
                    <div>
                        <strong class="font-extrabold">Booking is Already Paid:</strong>
                        <span>Existing paid tests cannot be removed. You can <strong>add more tests/packages</strong> or update your collection date, time slot, and address.</span>
                    </div>
                `;
            } else {
                banner.className = 'p-3.5 rounded-2xl border text-xs flex items-start gap-3 bg-teal-50 border-teal-200 text-teal-900';
                banner.innerHTML = `
                    <i class="fas fa-pen-to-square text-teal-700 text-base mt-0.5 flex-shrink-0"></i>
                    <div>
                        <strong class="font-extrabold">Unpaid Booking:</strong>
                        <span>You can add or remove diagnostic tests, change sample collection address, or reschedule appointment slot freely.</span>
                    </div>
                `;
            }

            // Date & Slot
            document.getElementById('mbDateInput').value = data.booking.booking_date || '';
            if (data.booking.collection_slot) {
                const slotSelect = document.getElementById('mbSlotSelect');
                let found = false;
                for (let i = 0; i < slotSelect.options.length; i++) {
                    if (slotSelect.options[i].value === data.booking.collection_slot) {
                        slotSelect.selectedIndex = i;
                        found = true;
                        break;
                    }
                }
                if (!found) {
                    const opt = new Option(data.booking.collection_slot, data.booking.collection_slot, true, true);
                    slotSelect.add(opt);
                }
            }

            // Beneficiary Member
            const memberSelect = document.getElementById('mbMemberSelect');
            memberSelect.innerHTML = `<option value="">${data.patient_name || 'Primary Patient'} (Self)</option>`;
            (data.family_members || []).forEach(m => {
                const opt = document.createElement('option');
                opt.value = m.id;
                opt.textContent = `${m.name} (${m.relation})`;
                if (data.booking.family_member_id == m.id) opt.selected = true;
                memberSelect.appendChild(opt);
            });

            // Address List
            const addressList = document.getElementById('mbAddressList');
            addressList.innerHTML = '';
            if ((data.addresses || []).length === 0) {
                addressList.innerHTML = `
                    <div class="p-3 bg-amber-50 border border-amber-200 rounded-xl text-xs text-amber-800 font-bold">
                        No address found. Please click "Add New Address".
                    </div>
                `;
            } else {
                data.addresses.forEach((addr, idx) => {
                    const isChecked = (data.booking.address_id == addr.id) || (!data.booking.address_id && idx === 0);
                    addressList.innerHTML += `
                        <label class="border border-slate-200 bg-slate-50/70 hover:bg-white rounded-xl p-3 flex items-start gap-3 cursor-pointer transition">
                            <input type="radio" name="mb_selected_address" value="${addr.id}" ${isChecked ? 'checked' : ''} class="mt-0.5 text-teal-700 focus:ring-teal-700">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <span class="font-extrabold text-xs text-slate-800">${addr.title}</span>
                                    <span class="text-[10px] text-slate-400 font-bold">#PIN: ${addr.pincode}</span>
                                </div>
                                <p class="text-xs text-slate-600 mt-0.5 leading-relaxed truncate">${addr.full_address}</p>
                            </div>
                        </label>
                    `;
                });
            }

            // Render Tests
            mbRenderTests();

            loadingState.classList.add('hidden');
            contentState.classList.remove('hidden');
        })
        .catch(err => {
            console.error(err);
            alert('Failed to load booking details.');
            closeModifyBookingModal();
        });
    }
    window.openModifyBookingModal = openModifyBookingModal;

    function closeModifyBookingModal() {
        const modal = document.getElementById('modifyBookingModal');
        if (modal) modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        document.getElementById('mbSearchResults').classList.add('hidden');
        document.getElementById('mbSearchTestInput').value = '';
    }
    window.closeModifyBookingModal = closeModifyBookingModal;

    function mbRenderTests() {
        const listContainer = document.getElementById('mbTestsList');
        const countBadge = document.getElementById('mbTestCountBadge');
        listContainer.innerHTML = '';
        countBadge.innerText = `${mbSelectedTests.length} item${mbSelectedTests.length > 1 ? 's' : ''}`;

        let totalAmount = 0;
        let additionalAmount = 0;

        mbSelectedTests.forEach((t, idx) => {
            totalAmount += t.price;
            const k = t.type + '_' + t.id;
            const isOriginal = mbBookingData.is_paid && mbOriginalTestKeys.has(k);
            if (!isOriginal && mbBookingData.is_paid) {
                additionalAmount += t.price;
            }

            let badgeHtml = '';
            let deleteBtnHtml = '';

            if (isOriginal) {
                badgeHtml = `<span class="inline-flex items-center gap-1 text-[10px] font-black text-emerald-800 bg-emerald-100 border border-emerald-200 px-2 py-0.5 rounded-md"><i class="fas fa-lock text-[9px]"></i> Paid</span>`;
            } else if (mbBookingData.is_paid) {
                badgeHtml = `<span class="inline-flex items-center gap-1 text-[10px] font-black text-amber-800 bg-amber-100 border border-amber-200 px-2 py-0.5 rounded-md"><i class="fas fa-plus text-[9px]"></i> New</span>`;
                deleteBtnHtml = `<button type="button" onclick="mbRemoveTest(${idx})" class="w-7 h-7 rounded-lg text-rose-500 hover:text-rose-700 hover:bg-rose-50 flex items-center justify-center transition cursor-pointer" title="Remove"><i class="fas fa-trash-alt text-xs"></i></button>`;
            } else {
                deleteBtnHtml = `<button type="button" onclick="mbRemoveTest(${idx})" class="w-7 h-7 rounded-lg text-rose-500 hover:text-rose-700 hover:bg-rose-50 flex items-center justify-center transition cursor-pointer" title="Remove"><i class="fas fa-trash-alt text-xs"></i></button>`;
            }

            const typeLabel = t.type === 'package' ? 'Package' : 'Test';
            const typeColor = t.type === 'package' ? 'bg-amber-100 text-amber-800' : 'bg-blue-100 text-blue-800';

            listContainer.innerHTML += `
                <div class="flex items-center justify-between gap-3 bg-slate-50/80 rounded-xl px-3.5 py-2.5 border border-slate-200">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <div class="w-7 h-7 rounded-lg bg-teal-100 text-teal-800 flex items-center justify-center text-xs flex-shrink-0">
                            <i class="fas ${t.type === 'package' ? 'fa-heartbeat' : 'fa-flask'}"></i>
                        </div>
                        <span class="font-extrabold text-xs text-slate-900 truncate">${t.name}</span>
                        <span class="text-[10px] px-2 py-0.5 rounded-full font-bold ${typeColor} flex-shrink-0">${typeLabel}</span>
                        ${badgeHtml}
                    </div>
                    <div class="flex items-center gap-2 flex-shrink-0">
                        <span class="font-black text-xs text-teal-900">₹${Math.round(t.price)}</span>
                        ${deleteBtnHtml}
                    </div>
                </div>
            `;
        });

        // Update Footers & Pricing
        const totalText = document.getElementById('mbTotalAmountText');
        const paymentSection = document.getElementById('mbPaymentChoiceSection');
        const addAmountText = document.getElementById('mbAdditionalAmountText');
        const submitBtnText = document.getElementById('mbSubmitBtnText');

        if (mbBookingData.is_paid) {
            totalText.innerText = '₹' + Math.round(mbBookingData.booking.amount + additionalAmount);
            if (additionalAmount > 0) {
                paymentSection.classList.remove('hidden');
                addAmountText.innerText = '₹' + Math.round(additionalAmount);
                const payMethod = document.querySelector('input[name="mb_payment_diff"]:checked')?.value || 'Cash';
                submitBtnText.innerText = payMethod === 'Online' ? `Pay Additional ₹${Math.round(additionalAmount)} Online` : `Confirm (+₹${Math.round(additionalAmount)} on Collection)`;
            } else {
                paymentSection.classList.add('hidden');
                submitBtnText.innerText = 'Save Modifications';
            }
        } else {
            paymentSection.classList.add('hidden');
            totalText.innerText = '₹' + Math.round(totalAmount);
            submitBtnText.innerText = 'Save Changes';
        }
    }

    document.addEventListener('change', (e) => {
        if (e.target && e.target.name === 'mb_payment_diff') {
            mbRenderTests();
        }
    });

    function mbRemoveTest(idx) {
        if (!mbBookingData) return;
        const target = mbSelectedTests[idx];
        const k = target.type + '_' + target.id;
        if (mbBookingData.is_paid && mbOriginalTestKeys.has(k)) {
            alert('Existing paid tests cannot be removed from this booking.');
            return;
        }

        if (mbSelectedTests.length <= 1) {
            alert('A booking must have at least one diagnostic test.');
            return;
        }

        mbSelectedTests.splice(idx, 1);
        mbRenderTests();
    }

    function mbFilterCatalog(query) {
        query = (query || '').trim().toLowerCase();
        const resultsBox = document.getElementById('mbSearchResults');
        if (!query || query.length < 2) {
            resultsBox.classList.add('hidden');
            return;
        }

        const currentKeys = new Set(mbSelectedTests.map(t => t.type + '_' + t.id));

        const matchedTests = mbCatalogTests.filter(t => t.name.toLowerCase().includes(query) && !currentKeys.has('test_' + t.id));
        const matchedPackages = mbCatalogPackages.filter(p => p.name.toLowerCase().includes(query) && !currentKeys.has('package_' + p.id));

        const allMatches = [
            ...matchedTests.map(t => ({ ...t, type: 'test' })),
            ...matchedPackages.map(p => ({ ...p, type: 'package' }))
        ].slice(0, 10);

        if (allMatches.length === 0) {
            resultsBox.innerHTML = `
                <div class="p-3 text-center text-xs text-slate-400 font-bold">
                    No matching tests or packages found.
                </div>
            `;
            resultsBox.classList.remove('hidden');
            return;
        }

        resultsBox.innerHTML = allMatches.map(item => `
            <div 
                onclick="mbAddTest(${item.id}, '${item.type}', '${item.name.replace(/'/g, "\\'")}', ${item.price})" 
                class="px-4 py-2.5 hover:bg-teal-50 cursor-pointer flex items-center justify-between transition"
            >
                <div class="flex items-center gap-2">
                    <span class="w-6 h-6 rounded-md bg-teal-100 text-teal-800 text-[11px] flex items-center justify-center font-bold">
                        <i class="fas ${item.type === 'package' ? 'fa-heartbeat' : 'fa-flask'}"></i>
                    </span>
                    <div>
                        <p class="text-xs font-bold text-slate-800">${item.name}</p>
                        <span class="text-[10px] text-teal-700 font-bold uppercase">${item.type}</span>
                    </div>
                </div>
                <div class="text-right">
                    <span class="text-xs font-black text-teal-900">₹${Math.round(item.price)}</span>
                    <span class="block text-[10px] font-bold text-teal-600">+ Add</span>
                </div>
            </div>
        `).join('');

        resultsBox.classList.remove('hidden');
    }

    function mbAddTest(id, type, name, price) {
        const k = type + '_' + id;
        if (mbSelectedTests.some(t => (t.type + '_' + t.id) === k)) {
            alert('This item is already added to the booking.');
            return;
        }

        mbSelectedTests.push({
            id: id,
            name: name,
            price: parseFloat(price),
            type: type,
            is_original: false
        });

        document.getElementById('mbSearchTestInput').value = '';
        document.getElementById('mbSearchResults').classList.add('hidden');
        mbRenderTests();
    }

    function submitModifyBooking() {
        if (!mbCurrentBookingId || !mbBookingData) return;

        const addressRadio = document.querySelector('input[name="mb_selected_address"]:checked');
        const addressId = addressRadio ? addressRadio.value : null;
        const bookingDate = document.getElementById('mbDateInput').value;
        const collectionSlot = document.getElementById('mbSlotSelect').value;
        const familyMemberId = document.getElementById('mbMemberSelect').value || null;
        const paymentMethodDiff = document.querySelector('input[name="mb_payment_diff"]:checked')?.value || 'Cash';

        if (!addressId) {
            alert('Please select a sample collection address.');
            return;
        }
        if (!bookingDate) {
            alert('Please select a collection date.');
            return;
        }
        if (mbSelectedTests.length === 0) {
            alert('At least one diagnostic test is required.');
            return;
        }

        // Calculate if additional tests were added on a paid booking
        let additionalAmount = 0;
        if (mbBookingData.is_paid) {
            mbSelectedTests.forEach(t => {
                const k = t.type + '_' + t.id;
                if (!mbOriginalTestKeys.has(k)) {
                    additionalAmount += t.price;
                }
            });
        }

        const submitBtn = document.getElementById('mbSubmitBtn');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';

        // CASE 1: Paid booking with additional tests AND user chose Online Razorpay
        if (mbBookingData.is_paid && additionalAmount > 0 && paymentMethodDiff === 'Online') {
            fetch(`/patient/bookings/${mbCurrentBookingId}/modify/create-order`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    tests: mbSelectedTests,
                    address_id: addressId,
                    booking_date: bookingDate,
                    collection_slot: collectionSlot,
                    family_member_id: familyMemberId
                })
            })
            .then(r => r.json())
            .then(orderData => {
                if (!orderData.success) {
                    alert(orderData.message || 'Could not initiate payment.');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                    return;
                }

                // Open Razorpay Popup
                const options = {
                    key: orderData.key,
                    amount: orderData.amount,
                    currency: orderData.currency || 'INR',
                    name: orderData.name,
                    description: orderData.description,
                    order_id: orderData.order_id,
                    prefill: orderData.prefill || {},
                    theme: orderData.theme || { color: '#0d9488' },
                    handler: function(response) {
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Verifying Payment...';
                        fetch(`/patient/bookings/${mbCurrentBookingId}/modify/verify-payment`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({
                                razorpay_order_id: response.razorpay_order_id,
                                razorpay_payment_id: response.razorpay_payment_id,
                                razorpay_signature: response.razorpay_signature,
                                tests: mbSelectedTests,
                                address_id: addressId,
                                booking_date: bookingDate,
                                collection_slot: collectionSlot,
                                family_member_id: familyMemberId
                            })
                        })
                        .then(vr => vr.json())
                        .then(vData => {
                            if (vData.success) {
                                alert(vData.message || 'Booking updated successfully!');
                                window.location.reload();
                            } else {
                                alert(vData.message || 'Payment verification failed.');
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = originalText;
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            alert('Network error verifying payment.');
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalText;
                        });
                    },
                    modal: {
                        ondismiss: function() {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalText;
                        }
                    }
                };

                const rzp = new Razorpay(options);
                rzp.open();
            })
            .catch(err => {
                console.error(err);
                alert('Network error initiating online payment.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
            return;
        }

        // CASE 2: Unpaid booking OR Paid booking with Cash for diff OR Paid booking with details-only update
        fetch(`/patient/bookings/${mbCurrentBookingId}/modify`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                tests: mbSelectedTests,
                address_id: addressId,
                booking_date: bookingDate,
                collection_slot: collectionSlot,
                family_member_id: familyMemberId,
                payment_method_for_diff: paymentMethodDiff
            })
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                alert(res.message || 'Booking modified successfully!');
                window.location.reload();
            } else {
                alert(res.message || 'Failed to modify booking.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        })
        .catch(err => {
            console.error(err);
            alert('Network error while saving modifications.');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    }
</script>
