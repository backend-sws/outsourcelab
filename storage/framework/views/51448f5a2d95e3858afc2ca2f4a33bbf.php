<!-- Hero Section -->
<div class="relative py-28 px-4 overflow-hidden">
    <!-- Background Image Slider -->
    <div class="absolute inset-0 z-0">
        <img src="/hero_banner_dna.jpg" class="hero-bg-slider absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 ease-in-out opacity-100" style="image-rendering: high-quality; filter: contrast(1.05) saturate(1.1); transform: translateZ(0);" alt="Background 1">
        <img src="/banner.jpg" class="hero-bg-slider absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 ease-in-out opacity-0" style="image-rendering: high-quality; filter: contrast(1.05) saturate(1.1); transform: translateZ(0);" alt="Background 2">
        <img src="/biochemistry.jpg" class="hero-bg-slider absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 ease-in-out opacity-0" style="image-rendering: high-quality; filter: contrast(1.05) saturate(1.1); transform: translateZ(0);" alt="Background 3">
        <img src="/flask.jpg" class="hero-bg-slider absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 ease-in-out opacity-0" style="image-rendering: high-quality; filter: contrast(1.05) saturate(1.1); transform: translateZ(0);" alt="Background 4">
        <img src="/two-asian.jpg" class="hero-bg-slider absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 ease-in-out opacity-0" style="image-rendering: high-quality; filter: contrast(1.05) saturate(1.1); transform: translateZ(0);" alt="Background 5">
    </div>

    <!-- Live Electricity Animations -->
    <div class="absolute inset-0 pointer-events-none z-10">
        <div class="electricity-line" style="left: 60%; animation-duration: 2.5s; animation-delay: 0s;"></div>
        <div class="electricity-line" style="left: 75%; animation-duration: 3s; animation-delay: 1s; height: 350px;"></div>
        <div class="electricity-line" style="left: 85%; animation-duration: 2s; animation-delay: 0.5s; height: 200px;"></div>
        <div class="electricity-line" style="left: 95%; animation-duration: 4s; animation-delay: 2s;"></div>
        <div class="electricity-line" style="left: 70%; animation-duration: 1.5s; animation-delay: 1.5s; height: 100px;"></div>
    </div>

    <div class="container mx-auto flex flex-col md:flex-row items-center justify-between relative z-20">
        <div class="md:w-3/5 space-y-6">
            <!-- Added a subtle text-shadow to make it readable against different backgrounds since overlay is removed -->
            <h1 id="typewriter-text" class="text-3xl md:text-4xl font-extrabold text-brand-dark mb-4 min-h-[40px] md:min-h-[48px]" style="text-shadow: 2px 2px 4px rgba(255,255,255,0.8), -2px -2px 4px rgba(255,255,255,0.8), 0px 0px 10px rgba(255,255,255,1);"></h1>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const text = "Fast, Reliable Diagnostics.";
                    let i = 0;
                    const speed = 70; // typing speed in milliseconds
                    const element = document.getElementById("typewriter-text");

                    function typeWriter() {
                        if (i < text.length) {
                            element.innerHTML = text.substring(0, i + 1) + '<span class="animate-pulse text-brand-secondary">|</span>';
                            i++;
                            setTimeout(typeWriter, speed);
                        } else {
                            element.innerHTML = text + '<span class="animate-pulse text-transparent">|</span>'; // Hide cursor after typing
                        }
                    }

                    setTimeout(typeWriter, 300); // Start after small delay

                    // Background slider logic
                    const bgImages = document.querySelectorAll('.hero-bg-slider');
                    let currentBgIndex = 0;
                    
                    if(bgImages.length > 0) {
                        setInterval(() => {
                            bgImages[currentBgIndex].classList.remove('opacity-100');
                            bgImages[currentBgIndex].classList.add('opacity-0');
                            
                            currentBgIndex = (currentBgIndex + 1) % bgImages.length;
                            
                            bgImages[currentBgIndex].classList.remove('opacity-0');
                            bgImages[currentBgIndex].classList.add('opacity-100');
                        }, 5000); // 5 seconds
                    }
                });
            </script>

            <div class="relative max-w-xl mb-6">
                <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 z-10"></i>
                <input type="text" placeholder="Search Tests" class="w-full pl-12 pr-16 py-4 rounded-xl shadow-lg focus:outline-none focus:ring-2 focus:ring-brand-secondary text-base border-0 bg-white/95">
                <div class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 space-x-3 text-lg flex items-center z-10">
                    <i class="fas fa-microphone cursor-pointer hover:text-brand-secondary text-brand-secondary"></i>
                    <span class="text-gray-300">|</span>
                    <i class="fas fa-camera cursor-pointer hover:text-brand-secondary text-blue-500"></i>
                </div>
            </div>

            <div class="flex space-x-4 max-w-xl">
                <button class="flex-1 bg-white/95 px-4 py-3 rounded-xl shadow-md flex items-center justify-center font-bold text-gray-800 hover:bg-white transition border border-gray-100">
                    <div class="bg-blue-100 p-2 rounded-lg mr-3"><i class="fas fa-box text-blue-500 text-xl"></i></div>
                    Create Your Own Package
                </button>
            </div>
        </div>

        <div class="md:w-2/5 hidden md:block">
            <!-- Empty column so the background is clearly visible on the right side -->
        </div>
    </div>
</div>
<?php /**PATH D:\lab\lab\resources\views/home/hero.blade.php ENDPATH**/ ?>