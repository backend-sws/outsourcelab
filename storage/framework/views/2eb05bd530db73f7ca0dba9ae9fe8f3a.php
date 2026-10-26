    <?php
        $currentPatient = session('patient_id') ? \App\Models\Patient::find(session('patient_id')) : null;
        $currentPatientCart = $currentPatient ? ($currentPatient->cart ?? []) : [];
    ?>
    <!-- Patient Cart Configuration Data -->
    <script id="patient-cart-data" type="application/json">
        <?php echo json_encode([
            'isLoggedIn' => (bool)$currentPatient,
            'patientId'  => $currentPatient ? (string)$currentPatient->id : '',
            'cart'       => $currentPatientCart,
        ]); ?>

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
                return;
            }

            cart.push({ id, type, name, price, mrp, params });
            saveCart(cart);
            refreshCartUI();

            // Sync with database
            fetch('<?php echo e(route("patient.cart.sync")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
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

            window.location.href = "<?php echo e(route('checkout.index')); ?>";
        }
    </script>
<?php /**PATH C:\Users\Employee\Desktop\outsourcelab\resources\views/frontend/partials/scripts.blade.php ENDPATH**/ ?>