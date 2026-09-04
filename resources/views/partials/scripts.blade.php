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

        // Cart Logic
        document.addEventListener('DOMContentLoaded', function() {
            let savedCount = localStorage.getItem('cartCount');
            if(savedCount) {
                let countEl = document.getElementById('cartCount');
                if(countEl) countEl.innerText = savedCount;
            }
        });

        function addToCart(btn) {
            let countEl = document.getElementById('cartCount');
            if(countEl) {
                let currentCount = parseInt(countEl.innerText) || 0;
                let newCount = currentCount + 1;
                countEl.innerText = newCount;
                localStorage.setItem('cartCount', newCount);
            }
            
            let originalHtml = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-check mr-2"></i> Added!';
            btn.classList.add('bg-green-500', 'text-white', 'border-green-500');
            btn.classList.remove('bg-white/90', 'text-brand-secondary', 'border-brand-secondary', 'hover:from-brand-dark');
            
            setTimeout(() => {
                btn.innerHTML = originalHtml;
                btn.classList.remove('bg-green-500', 'text-white', 'border-green-500');
                btn.classList.add('bg-white/90', 'text-brand-secondary', 'border-brand-secondary', 'hover:from-brand-dark');
            }, 1500);
        }

        function proceedToCheckout() {
            let countEl = document.getElementById('cartCount');
            let count = countEl ? parseInt(countEl.innerText) : 0;
            
            if (count === 0) {
                alert('Your cart is empty. Please add a package first!');
                return;
            }

            const isLoggedIn = "{{ session()->has('patient_id') ? 'true' : 'false' }}" === "true";
            
            if (isLoggedIn) {
                window.location.href = "{{ route('checkout.index') }}";
            } else {
                if(window.openLoginModal) {
                    window.openLoginModal();
                }
            }
        }
    </script>
