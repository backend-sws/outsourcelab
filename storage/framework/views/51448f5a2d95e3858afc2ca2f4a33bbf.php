<!-- Hero Section -->
<div class="relative py-28 px-4 bg-cover bg-center bg-no-repeat overflow-hidden" style="background-image: url('/hero_banner_dna.jpg');">
    <!-- Gradient Overlay for readability -->
    <div class="absolute inset-0 bg-gradient-to-r from-brand-light/95 via-brand-light/60 to-transparent"></div>

    <!-- Live Electricity Animations -->
    <div class="absolute inset-0 pointer-events-none" style="z-index: 5;">
        <div class="electricity-line" style="left: 60%; animation-duration: 2.5s; animation-delay: 0s;"></div>
        <div class="electricity-line" style="left: 75%; animation-duration: 3s; animation-delay: 1s; height: 350px;"></div>
        <div class="electricity-line" style="left: 85%; animation-duration: 2s; animation-delay: 0.5s; height: 200px;"></div>
        <div class="electricity-line" style="left: 95%; animation-duration: 4s; animation-delay: 2s;"></div>
        <div class="electricity-line" style="left: 70%; animation-duration: 1.5s; animation-delay: 1.5s; height: 100px;"></div>
    </div>

    <div class="container mx-auto flex flex-col md:flex-row items-center justify-between relative z-10">
        <div class="md:w-3/5 space-y-6 z-20">
            <h1 id="typewriter-text" class="text-3xl md:text-4xl font-extrabold text-brand-dark drop-shadow-sm mb-4 min-h-[40px] md:min-h-[48px]"></h1>

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
                });
            </script>

            <div class="relative max-w-xl mb-6">
                <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input type="text" placeholder="Search Tests" class="w-full pl-12 pr-16 py-4 rounded-xl shadow-lg focus:outline-none focus:ring-2 focus:ring-brand-secondary text-base border-0">
                <div class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 space-x-3 text-lg flex items-center">
                    <i class="fas fa-microphone cursor-pointer hover:text-brand-secondary text-brand-secondary"></i>
                    <span class="text-gray-300">|</span>
                    <i class="fas fa-camera cursor-pointer hover:text-brand-secondary text-blue-500"></i>
                </div>
            </div>

            <div class="flex space-x-4 max-w-xl">
                <button class="flex-1 bg-white px-4 py-3 rounded-xl shadow-md flex items-center justify-center font-bold text-gray-800 hover:bg-gray-50 transition border border-gray-100">
                    <div class="bg-blue-100 p-2 rounded-lg mr-3"><i class="fas fa-box text-blue-500 text-xl"></i></div>
                    Create Your Own Package
                </button>
            </div>
        </div>

        <div class="md:w-2/5 hidden md:block">
            <!-- Empty column so the DNA background is clearly visible on the right side -->
        </div>
    </div>
</div>
<?php /**PATH D:\lab\lab\resources\views/home/hero.blade.php ENDPATH**/ ?>