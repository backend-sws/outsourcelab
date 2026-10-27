    @php
        $currentPatient = session('patient_id') ? \App\Models\Patient::find(session('patient_id')) : null;
        $currentPatientCart = $currentPatient ? ($currentPatient->cart ?? []) : [];
    @endphp
    <!-- Patient Cart Configuration Data -->
    <script id="patient-cart-data" type="application/json">
        {!! json_encode([
            'isLoggedIn' => (bool)$currentPatient,
            'patientId'  => $currentPatient ? (string)$currentPatient->id : '',
            'cart'       => $currentPatientCart,
        ]) !!}
    </script>

    <!-- Swiper JS & Init -->    
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script>
        // Curated Packages
        var swiperCategory = new Swiper(".categorySwiper", {
            slidesPerView: 2,
            spaceBetween: 10,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                640: { slidesPerView: 3, spaceBetween: 20 },
                768: { slidesPerView: 4, spaceBetween: 20 },
                1024: { slidesPerView: 6, spaceBetween: 20 },
            }
        });

        // Patient Authentication & Cart State
        const patientDataEl = document.getElementById('patient-cart-data');
        const patientData = patientDataEl ? JSON.parse(patientDataEl.textContent) : { isLoggedIn: false, patientId: '', cart: [] };
        const isLoggedInPatient = Boolean(patientData.isLoggedIn);
        const cartPatientId = patientData.patientId || '';
        const cartKey = isLoggedInPatient ? ('cart_' + cartPatientId) : null;
        const initialServerCart = Array.isArray(patientData.cart) ? patientData.cart : [];

        // Always remove old unauthenticated guest cart key
        localStorage.removeItem('cart_guest');
        localStorage.removeItem('cartCount');

        // If user is logged in, sync localStorage with database cart
        if (isLoggedInPatient && cartKey) {
            localStorage.setItem(cartKey, JSON.stringify(initialServerCart));
        }

        document.addEventListener('DOMContentLoaded', function() {
            refreshCartUI();
        });

        function getCart() {
            if (!isLoggedInPatient || !cartKey) {
                return [];
            }
            try {
                return JSON.parse(localStorage.getItem(cartKey)) || [];
            } catch(e) {
                return [];
            }
        }

        function saveCart(items) {
            if (!isLoggedInPatient || !cartKey) return;
            localStorage.setItem(cartKey, JSON.stringify(items));
        }

        function refreshCartUI() {
            let cart = getCart();
            let countEl = document.getElementById('cartCount');
            if (countEl) {
                countEl.innerText = cart.length;
                if (cart.length > 0) {
                    countEl.classList.remove('hidden');
                } else {
                    countEl.classList.add('hidden');
                }
            }
        }

        function pulseCartButton() {
            let countEl = document.getElementById('cartCount');
            let cartBtn = document.querySelector('button[onclick="proceedToCheckout()"]');
            if (cartBtn) {
                cartBtn.classList.add('ring-4', 'ring-emerald-400', 'scale-105', 'bg-emerald-50', 'transition-all', 'duration-300');
                setTimeout(() => {
                    cartBtn.classList.remove('ring-4', 'ring-emerald-400', 'scale-105', 'bg-emerald-50');
                }, 600);
            }
            if (countEl) {
                countEl.classList.add('scale-125', 'bg-emerald-600', 'transition-all', 'duration-300');
                setTimeout(() => {
                    countEl.classList.remove('scale-125', 'bg-emerald-600');
                }, 600);
            }
        }

        function showCartToast(item, isDuplicate = false) {
            let container = document.getElementById('cartToastContainer');
            if (!container) {
                container = document.createElement('div');
                container.id = 'cartToastContainer';
                container.className = 'fixed top-4 right-3 sm:top-5 sm:right-6 z-[999999] pointer-events-none flex flex-col gap-2.5 max-w-[380px] sm:max-w-md w-[calc(100%-1.5rem)] sm:w-auto items-end';
                document.body.appendChild(container);
            }

            let cart = getCart();
            let totalCount = cart.length;
            let formattedPrice = item.price ? ('₹' + Number(item.price).toLocaleString('en-IN')) : '₹0';
            let typeLabel = (item.type === 'test') ? 'Single Test' : 'Health Package';

            let toast = document.createElement('div');
            toast.className = 'pointer-events-auto bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl border p-3.5 sm:p-4 text-slate-800 flex flex-col gap-2.5 transition-all duration-300 transform translate-y-[-20px] opacity-0 scale-95 relative overflow-hidden w-full ' + 
                (isDuplicate ? 'border-amber-200/90 ring-1 ring-amber-500/20' : 'border-emerald-200/90 ring-1 ring-emerald-500/20');

            if (isDuplicate) {
                toast.innerHTML = `
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500 to-orange-500 text-white flex items-center justify-center font-bold text-base flex-shrink-0 shadow-md shadow-amber-500/30">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div class="flex-1 min-w-0 pr-1">
                            <div class="flex items-center gap-1.5 flex-wrap">
                                <span class="text-[10px] uppercase font-black tracking-wider text-amber-700 bg-amber-50 px-2 py-0.5 rounded-full border border-amber-200/60">Already in Cart</span>
                                <span class="text-[11px] font-black text-slate-900 bg-slate-100 px-1.5 py-0.5 rounded font-mono">${formattedPrice}</span>
                            </div>
                            <h4 class="font-bold text-slate-900 text-xs sm:text-sm truncate mt-1" title="${item.name}">${item.name}</h4>
                            <p class="text-[11px] text-slate-500 mt-0.5">This item is already added to your cart.</p>
                        </div>
                        <button type="button" class="toast-close text-slate-400 hover:text-slate-600 p-1 text-xs cursor-pointer">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="flex items-center justify-between gap-2 pt-2 border-t border-slate-100">
                        <button type="button" class="toast-dismiss text-[11px] font-bold text-slate-500 hover:text-slate-700 px-2 py-1 transition cursor-pointer">Close</button>
                        <button type="button" onclick="proceedToCheckout()" class="cursor-pointer px-3.5 py-1.5 rounded-xl bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white text-xs font-bold shadow-md shadow-amber-600/25 transition-all flex items-center gap-1.5 active:scale-95">
                            <span>Go to Cart</span>
                            <i class="fas fa-arrow-right text-[10px]"></i>
                        </button>
                    </div>
                    <div class="toast-progress absolute bottom-0 left-0 h-1 bg-amber-400 rounded-b-2xl w-full"></div>
                `;
            } else {
                toast.innerHTML = `
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white flex items-center justify-center font-bold text-base flex-shrink-0 shadow-md shadow-emerald-600/30">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="flex-1 min-w-0 pr-1">
                            <div class="flex items-center gap-1.5 flex-wrap">
                                <span class="text-[10px] uppercase font-black tracking-wider text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200/60">${typeLabel} Added</span>
                                <span class="text-[11px] font-black text-slate-900 bg-slate-100 px-1.5 py-0.5 rounded font-mono">${formattedPrice}</span>
                            </div>
                            <h4 class="font-bold text-slate-900 text-xs sm:text-sm truncate mt-1" title="${item.name}">${item.name}</h4>
                            <p class="text-[11px] text-slate-500 mt-0.5 flex items-center gap-1">
                                <i class="fas fa-shopping-bag text-teal-600 text-[10px]"></i>
                                <span>Cart: <strong>${totalCount} item${totalCount > 1 ? 's' : ''}</strong></span>
                            </p>
                        </div>
                        <button type="button" class="toast-close text-slate-400 hover:text-slate-600 p-1 text-xs cursor-pointer">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="flex items-center justify-between gap-2 pt-2 border-t border-slate-100">
                        <button type="button" class="toast-dismiss text-[11px] font-bold text-slate-500 hover:text-slate-700 px-2 py-1 transition cursor-pointer">Continue Browsing</button>
                        <button type="button" onclick="proceedToCheckout()" class="cursor-pointer px-3.5 py-1.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white text-xs font-bold shadow-md shadow-emerald-600/25 transition-all flex items-center gap-1.5 active:scale-95">
                            <span>View Cart & Checkout</span>
                            <i class="fas fa-arrow-right text-[10px]"></i>
                        </button>
                    </div>
                    <div class="toast-progress absolute bottom-0 left-0 h-1 bg-gradient-to-r from-emerald-500 via-teal-500 to-indigo-500 rounded-b-2xl w-full"></div>
                `;
            }

            container.appendChild(toast);

            // Animate In
            requestAnimationFrame(() => {
                toast.classList.remove('translate-y-[-20px]', 'opacity-0', 'scale-95');
                toast.classList.add('translate-y-0', 'opacity-100', 'scale-100');
            });

            // Progress bar shrinking animation
            const progressBar = toast.querySelector('.toast-progress');
            if (progressBar) {
                progressBar.style.transition = 'width 3.8s linear';
                requestAnimationFrame(() => {
                    progressBar.style.width = '0%';
                });
            }

            // Dismiss handling
            let dismissTimeout = null;
            function dismiss() {
                if (dismissTimeout) clearTimeout(dismissTimeout);
                toast.classList.remove('translate-y-0', 'opacity-100', 'scale-100');
                toast.classList.add('translate-x-[20px]', 'opacity-0', 'scale-95');
                setTimeout(() => {
                    if (toast.parentNode) toast.parentNode.removeChild(toast);
                }, 300);
            }

            dismissTimeout = setTimeout(dismiss, 4000);

            // Pause dismiss on hover
            toast.addEventListener('mouseenter', () => {
                if (dismissTimeout) clearTimeout(dismissTimeout);
                if (progressBar) progressBar.style.transition = 'none';
            });
            toast.addEventListener('mouseleave', () => {
                dismissTimeout = setTimeout(dismiss, 2000);
            });

            toast.querySelectorAll('.toast-close, .toast-dismiss').forEach(btn => {
                btn.addEventListener('click', dismiss);
            });
        }

        function addToCart(btn) {
            // Read directly from data attributes or plain config object
            let id     = (btn.getAttribute ? btn.getAttribute('data-id') : (btn.dataset ? btn.dataset.id : btn.id)) || '';
            let type   = (btn.getAttribute ? btn.getAttribute('data-type') : (btn.dataset ? btn.dataset.type : btn.type)) || 'package';
            let name   = (btn.getAttribute ? btn.getAttribute('data-name') : (btn.dataset ? btn.dataset.name : btn.name)) || 'Health Package';
            let price  = (btn.getAttribute ? btn.getAttribute('data-price') : (btn.dataset ? btn.dataset.price : btn.price)) || '0';
            let mrp    = (btn.getAttribute ? btn.getAttribute('data-mrp') : (btn.dataset ? btn.dataset.mrp : btn.mrp)) || price;
            let params = (btn.getAttribute ? btn.getAttribute('data-params') : (btn.dataset ? btn.dataset.params : btn.params)) || '';

            if (!isLoggedInPatient) {
                sessionStorage.setItem('pending_cart_item', JSON.stringify({ id, type, name, price, mrp, params }));
                if (window.openLoginModal) {
                    window.openLoginModal(false, 'Please login to add "' + name + '" to your cart.');
                }
                return;
            }

            // Avoid adding duplicate
            let cart = getCart();
            let alreadyExists = cart.some(item => (id && item.id && String(item.id) === String(id) && (item.type || 'package') === type) || item.name === name);
            if (alreadyExists) {
                if (btn instanceof HTMLElement) {
                    let oldHtml = btn.innerHTML;
                    btn.innerHTML = '<i class="fas fa-check mr-1.5"></i>Already Added!';
                    setTimeout(() => { btn.innerHTML = oldHtml; }, 1500);
                }
                showCartToast({ id, type, name, price, mrp, params }, true);
                return;
            }

            cart.push({ id, type, name, price, mrp, params });
            saveCart(cart);
            refreshCartUI();
            pulseCartButton();
            showCartToast({ id, type, name, price, mrp, params }, false);

            // Sync with database
            fetch('{{ route("patient.cart.sync") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ cart: cart })
            });

            if (btn instanceof HTMLElement) {
                let originalHtml = btn.innerHTML;
                let originalClasses = btn.className;
                btn.innerHTML = '<i class="fas fa-check mr-1.5"></i>Added to Cart!';
                btn.classList.add('!bg-emerald-600', '!text-white', '!border-emerald-600');

                setTimeout(() => {
                    btn.innerHTML = originalHtml;
                    btn.className = originalClasses;
                }, 1600);
            }
        }

        function proceedToCheckout() {
            if (!isLoggedInPatient) {
                if (window.openLoginModal) {
                    window.openLoginModal(false, 'Please login to proceed to checkout.');
                }
                return;
            }

            let cart = getCart();
            if (cart.length === 0) {
                alert('Your cart is empty. Please add a package first!');
                return;
            }

            window.location.href = "{{ route('checkout.index') }}";
        }
    </script>
