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

        // Cart Logic - keyed by patient ID to prevent stale data
        const cartPatientId = "<?php echo e(session('patient_id', 'guest')); ?>";
        const cartKey = 'cart_' + cartPatientId;

        // Clean up old-style cart key if present
        localStorage.removeItem('cartCount');

        document.addEventListener('DOMContentLoaded', function() {
            refreshCartUI();
        });

        function getCart() {
            try {
                return JSON.parse(localStorage.getItem(cartKey)) || [];
            } catch(e) {
                return [];
            }
        }

        function saveCart(items) {
            localStorage.setItem(cartKey, JSON.stringify(items));
        }

        function refreshCartUI() {
            let cart = getCart();
            let countEl = document.getElementById('cartCount');
            if (countEl) {
                countEl.innerText = cart.length;
                countEl.style.display = cart.length > 0 ? '' : 'none';
            }
        }

        function addToCart(btn) {
            // Read directly from data attributes — no DOM scraping
            let name   = btn.getAttribute('data-name')   || 'Health Package';
            let price  = btn.getAttribute('data-price')  || '0';
            let mrp    = btn.getAttribute('data-mrp')    || price;
            let params = btn.getAttribute('data-params') || '';

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
            let countEl = document.getElementById('cartCount');
            let count = countEl ? parseInt(countEl.innerText) : 0;
            
            if (count === 0) {
                alert('Your cart is empty. Please add a package first!');
                return;
            }

            const isLoggedIn = "<?php echo e(session()->has('patient_id') ? 'true' : 'false'); ?>" === "true";
            
            if (isLoggedIn) {
                window.location.href = "<?php echo e(route('checkout.index')); ?>";
            } else {
                if(window.openLoginModal) {
                    window.openLoginModal();
                }
            }
        }
    </script>
<?php /**PATH D:\lab\lab\resources\views/partials/scripts.blade.php ENDPATH**/ ?>