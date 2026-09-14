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

        function addToCart(btn) {
            // Read directly from data attributes — no DOM scraping
            let name   = btn.getAttribute('data-name')   || 'Health Package';
            let price  = btn.getAttribute('data-price')  || '0';
            let mrp    = btn.getAttribute('data-mrp')    || price;
            let params = btn.getAttribute('data-params') || '';

            if (!isLoggedInPatient) {
                sessionStorage.setItem('pending_cart_item', JSON.stringify({ name, price, mrp, params }));
                if (window.openLoginModal) {
                    window.openLoginModal(false, 'Please login to add "' + name + '" to your cart.');
                }
                return;
            }

            // Avoid adding duplicate
            let cart = getCart();
            let alreadyExists = cart.some(item => item.name === name);
            if (alreadyExists) {
                btn.innerHTML = '<i class="fas fa-check mr-2"></i>Already Added!';
                setTimeout(() => { btn.innerHTML = '<i class="fas fa-cart-plus mr-2"></i> Add to Cart'; }, 1500);
                return;
            }

            cart.push({ name, price, mrp, params });
            saveCart(cart);
            refreshCartUI();

            // Sync with database
            fetch('{{ route("patient.cart.sync") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ cart: cart })
            });

            let originalHtml = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-check mr-2"></i>Added!';
            btn.classList.add('bg-green-500', 'text-white', 'border-green-500');
            btn.classList.remove('bg-white/90', 'text-brand-secondary', 'border-brand-secondary');

            setTimeout(() => {
                btn.innerHTML = originalHtml;
                btn.classList.remove('bg-green-500', 'text-white', 'border-green-500');
                btn.classList.add('bg-white/90', 'text-brand-secondary', 'border-brand-secondary');
            }, 1500);
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
