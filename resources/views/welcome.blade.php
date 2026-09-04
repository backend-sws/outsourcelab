@extends('layouts.app')
@section('content')
    <!-- Global Glassy Blurred Background -->
    <div class="fixed inset-0 z-[-1] pointer-events-none overflow-hidden bg-slate-50/30 backdrop-blur-3xl">
        <!-- Soft animated color blobs -->
        <div class="absolute -top-[20%] -left-[10%] w-[60vw] h-[60vw] bg-teal-200/20 rounded-full mix-blend-multiply filter blur-[100px] animate-[pulse_8s_ease-in-out_infinite]"></div>
        <div class="absolute top-[20%] -right-[10%] w-[50vw] h-[50vw] bg-yellow-200/20 rounded-full mix-blend-multiply filter blur-[120px] animate-[pulse_10s_ease-in-out_infinite_2s]"></div>
        <div class="absolute -bottom-[20%] left-[20%] w-[70vw] h-[70vw] bg-red-200/10 rounded-full mix-blend-multiply filter blur-[150px] animate-[pulse_12s_ease-in-out_infinite_4s]"></div>
    </div>

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

    <!-- Spreading Quality Healthcare -->
<div class="container mx-auto px-4 py-8 relative z-20 -mt-12 mb-4">
    <div class="bg-white rounded-2xl p-6 shadow-2xl border border-gray-100">
        <h3 class="text-center text-brand-dark font-bold mb-6 text-xl">Spreading Quality Healthcare Across India</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6" id="stats-section">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 rounded-xl overflow-hidden shadow-sm flex-shrink-0 border-[3px] border-orange-50">
                    <img src="https://images.unsplash.com/photo-1579684385127-1ef15d508118?w=100&h=100&fit=crop" class="w-full h-full object-cover">
                </div>
                <div>
                    <h4 class="font-bold text-gray-800 text-2xl leading-tight"><span class="count-up text-brand-dark" data-target="1">0</span> Crore+</h4>
                    <p class="text-[10px] text-gray-500 uppercase tracking-wide font-semibold mt-1">Lives Touched</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 rounded-xl overflow-hidden shadow-sm flex-shrink-0 border-[3px] border-pink-50">
                    <img src="https://images.unsplash.com/photo-1581594693702-fbdc51b2763b?w=100&h=100&fit=crop" class="w-full h-full object-cover">
                </div>
                <div>
                    <h4 class="font-bold text-gray-800 text-2xl leading-tight"><span class="count-up text-brand-dark" data-target="80">0</span>+</h4>
                    <p class="text-[10px] text-gray-500 uppercase tracking-wide font-semibold mt-1">Self-Owned Labs</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 rounded-xl overflow-hidden shadow-sm flex-shrink-0 border-[3px] border-blue-50">
                    <img src="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=100&h=100&fit=crop" class="w-full h-full object-cover">
                </div>
                <div>
                    <h4 class="font-bold text-gray-800 text-2xl leading-tight"><span class="count-up text-brand-dark" data-target="2000">0</span>+</h4>
                    <p class="text-[10px] text-gray-500 uppercase tracking-wide font-semibold mt-1">Collection Centres</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 rounded-xl overflow-hidden shadow-sm flex-shrink-0 border-[3px] border-purple-50">
                    <img src="https://images.unsplash.com/photo-1584036561566-baf8f5f1b144?w=100&h=100&fit=crop" class="w-full h-full object-cover">
                </div>
                <div>
                    <h4 class="font-bold text-gray-800 text-2xl leading-tight"><span class="count-up text-brand-dark" data-target="1500">0</span>+</h4>
                    <p class="text-[10px] text-gray-500 uppercase tracking-wide font-semibold mt-1">Trained Phlebotomists</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const counters = document.querySelectorAll('.count-up');
    
    const animateCounters = (entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const targetEl = entry.target;
                const target = parseInt(targetEl.getAttribute('data-target'), 10);
                
                // For very small numbers like 1, just set it immediately or count very fast
                if (target === 1) {
                    targetEl.innerText = target;
                    observer.unobserve(targetEl);
                    return;
                }
                
                const duration = 2500; // 2.5 seconds
                const stepTime = 30; 
                const steps = duration / stepTime;
                const inc = target / steps;
                
                let current = 0;
                
                const updateCount = setInterval(() => {
                    current += inc;
                    if (current >= target) {
                        targetEl.innerText = target.toLocaleString('en-IN');
                        clearInterval(updateCount);
                    } else {
                        targetEl.innerText = Math.ceil(current).toLocaleString('en-IN');
                    }
                }, stepTime);
                
                observer.unobserve(targetEl);
            }
        });
    };

    const observer = new IntersectionObserver(animateCounters, { threshold: 0.3 });
    
    counters.forEach(counter => {
        observer.observe(counter);
    });
});
</script>

    <!-- Routine Health Checkups -->
<div class="container mx-auto px-4 py-8 flex flex-col gap-6">
    <!-- Men -->
    <div class="bg-white rounded-2xl border border-gray-200 p-6 w-full relative">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-brand-dark">Routine health checkups for men</h3>
            <a href="#" class="text-xs font-bold text-gray-500 hover:text-brand-secondary">View All <i class="fas fa-chevron-right ml-1"></i></a>
        </div>

        <div class="flex space-x-4 overflow-x-auto pb-4 hide-scroll-bar">
            <!-- Under 30 -->
            <div class="min-w-[130px] bg-white border border-gray-100 rounded-xl p-3 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all cursor-pointer text-center group">
                <img src="https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?w=400&h=400&fit=crop" alt="Under 30" class="w-full aspect-square object-cover rounded-lg mb-3 shadow-sm group-hover:scale-105 transition-transform duration-300">
                <span class="font-bold text-gray-800 text-sm group-hover:text-blue-600 transition-colors">Under 30</span>
                <span class="text-xs text-gray-400 block mt-1">Years</span>
            </div>
            <!-- 30-45 -->
            <div class="min-w-[130px] bg-white border border-gray-100 rounded-xl p-3 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all cursor-pointer text-center group">
                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=400&fit=crop" alt="30-45" class="w-full aspect-square object-cover rounded-lg mb-3 shadow-sm group-hover:scale-105 transition-transform duration-300">
                <span class="font-bold text-gray-800 text-sm group-hover:text-blue-600 transition-colors">30 - 45</span>
                <span class="text-xs text-gray-400 block mt-1">Years</span>
            </div>
            <!-- 45-60 -->
            <div class="min-w-[130px] bg-white border border-gray-100 rounded-xl p-3 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all cursor-pointer text-center group">
                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400&h=400&fit=crop" alt="45-60" class="w-full aspect-square object-cover rounded-lg mb-3 shadow-sm group-hover:scale-105 transition-transform duration-300">
                <span class="font-bold text-gray-800 text-sm group-hover:text-blue-600 transition-colors">45 - 60</span>
                <span class="text-xs text-gray-400 block mt-1">Years</span>
            </div>
            <!-- Above 60 -->
            <div class="min-w-[130px] bg-white border border-gray-100 rounded-xl p-3 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all cursor-pointer text-center group">
                <img src="https://images.unsplash.com/photo-1544717305-2782549b5136?w=400&h=400&fit=crop" alt="Above 60" class="w-full aspect-square object-cover rounded-lg mb-3 shadow-sm group-hover:scale-105 transition-transform duration-300">
                <span class="font-bold text-gray-800 text-sm group-hover:text-blue-600 transition-colors">Above 60</span>
                <span class="text-xs text-gray-400 block mt-1">Years</span>
            </div>
        </div>
    </div>

    <!-- Women -->
    <div class="bg-white rounded-2xl border border-gray-200 p-6 w-full relative">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-brand-dark">Routine health checkups for women</h3>
            <a href="#" class="text-xs font-bold text-gray-500 hover:text-brand-secondary">View All <i class="fas fa-chevron-right ml-1"></i></a>
        </div>

        <div class="flex space-x-4 overflow-x-auto pb-4 hide-scroll-bar">
            <!-- Under 30 -->
            <div class="min-w-[130px] bg-white border border-gray-100 rounded-xl p-3 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all cursor-pointer text-center group">
                <img src="https://images.unsplash.com/photo-1524504388940-b1c1722653e1?w=400&h=400&fit=crop" alt="Under 30" class="w-full aspect-square object-cover rounded-lg mb-3 shadow-sm group-hover:scale-105 transition-transform duration-300">
                <span class="font-bold text-gray-800 text-sm group-hover:text-pink-600 transition-colors">Under 30</span>
                <span class="text-xs text-gray-400 block mt-1">Years</span>
            </div>
            <!-- 30-45 -->
            <div class="min-w-[130px] bg-white border border-gray-100 rounded-xl p-3 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all cursor-pointer text-center group">
                <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=400&h=400&fit=crop" alt="30-45" class="w-full aspect-square object-cover rounded-lg mb-3 shadow-sm group-hover:scale-105 transition-transform duration-300">
                <span class="font-bold text-gray-800 text-sm group-hover:text-pink-600 transition-colors">30 - 45</span>
                <span class="text-xs text-gray-400 block mt-1">Years</span>
            </div>
            <!-- 45-60 -->
            <div class="min-w-[130px] bg-white border border-gray-100 rounded-xl p-3 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all cursor-pointer text-center group">
                <img src="https://images.unsplash.com/photo-1551836022-d5d88e9218df?w=400&h=400&fit=crop" alt="45-60" class="w-full aspect-square object-cover rounded-lg mb-3 shadow-sm group-hover:scale-105 transition-transform duration-300">
                <span class="font-bold text-gray-800 text-sm group-hover:text-pink-600 transition-colors">45 - 60</span>
                <span class="text-xs text-gray-400 block mt-1">Years</span>
            </div>
            <!-- Above 60 -->
            <div class="min-w-[130px] bg-white border border-gray-100 rounded-xl p-3 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all cursor-pointer text-center group">
                <img src="https://images.unsplash.com/photo-1584432810601-6c7f27d2362b?auto=format&fit=crop&w=400&h=400&q=80" alt="Above 60" class="w-full aspect-square object-cover rounded-lg mb-3 shadow-sm group-hover:scale-105 transition-transform duration-300">
                <span class="font-bold text-gray-800 text-sm group-hover:text-pink-600 transition-colors">Above 60</span>
                <span class="text-xs text-gray-400 block mt-1">Years</span>
            </div>
        </div>
    </div>
</div>


    <!-- Doctors Curated Health Checkup Packages -->
<div class="container mx-auto px-4 py-10">
    <div class="flex justify-between items-center mb-6">
        <h2 class="section-title mb-0">Doctors Curated Health Checkup Packages</h2>
        <a href="#" class="text-brand-dark font-bold text-sm hover:underline">See All</a>
    </div>

    <div class="swiper categorySwiper">
        <div class="swiper-wrapper py-4">
            <!-- Slides -->
            <!-- Slides with Real Images -->
            <div class="swiper-slide">
                <div class="bg-white border border-gray-100 rounded-2xl p-5 flex flex-col items-center justify-center cursor-pointer transition-colors duration-300 hover:border-brand-secondary group h-full shadow-sm">
                    <div class="flex flex-col items-center justify-center space-y-3 group-hover:-translate-y-2 transition-transform duration-300">
                        <div class="w-16 h-16 rounded-full overflow-hidden flex-shrink-0 shadow-sm border-4 border-gray-50 group-hover:scale-110 transition-transform duration-300">
                            <img src="{{ asset('icons/icon_thyroid.jpg') }}" alt="Thyroid" class="w-full h-full object-cover">
                        </div>
                        <span class="font-bold text-gray-800 text-sm group-hover:text-brand-secondary transition-colors text-center w-full">Thyroid</span>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="bg-white border border-gray-100 rounded-2xl p-5 flex flex-col items-center justify-center cursor-pointer transition-colors duration-300 hover:border-brand-secondary group h-full shadow-sm">
                    <div class="flex flex-col items-center justify-center space-y-3 group-hover:-translate-y-2 transition-transform duration-300">
                        <div class="w-16 h-16 rounded-full overflow-hidden flex-shrink-0 shadow-sm border-4 border-gray-50 group-hover:scale-110 transition-transform duration-300">
                            <img src="{{ asset('icons/icon_hormones.jpg') }}" alt="Hormones" class="w-full h-full object-cover">
                        </div>
                        <span class="font-bold text-gray-800 text-sm group-hover:text-brand-secondary transition-colors text-center w-full">Hormones</span>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="bg-white border border-gray-100 rounded-2xl p-5 flex flex-col items-center justify-center cursor-pointer transition-colors duration-300 hover:border-brand-secondary group h-full shadow-sm">
                    <div class="flex flex-col items-center justify-center space-y-3 group-hover:-translate-y-2 transition-transform duration-300">
                        <div class="w-16 h-16 rounded-full overflow-hidden flex-shrink-0 shadow-sm border-4 border-gray-50 group-hover:scale-110 transition-transform duration-300">
                            <img src="{{ asset('icons/icon_lifestyle.jpg') }}" alt="Lifestyle" class="w-full h-full object-cover">
                        </div>
                        <span class="font-bold text-gray-800 text-sm group-hover:text-brand-secondary transition-colors text-center w-full">Lifestyle</span>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="bg-white border border-gray-100 rounded-2xl p-5 flex flex-col items-center justify-center cursor-pointer transition-colors duration-300 hover:border-brand-secondary group h-full shadow-sm">
                    <div class="flex flex-col items-center justify-center space-y-3 group-hover:-translate-y-2 transition-transform duration-300">
                        <div class="w-16 h-16 rounded-full overflow-hidden flex-shrink-0 shadow-sm border-4 border-gray-50 group-hover:scale-110 transition-transform duration-300">
                            <img src="{{ asset('icons/icon_cancer.jpg') }}" alt="Cancer" class="w-full h-full object-cover">
                        </div>
                        <span class="font-bold text-gray-800 text-sm group-hover:text-brand-secondary transition-colors text-center w-full">Cancer</span>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="bg-white border border-gray-100 rounded-2xl p-5 flex flex-col items-center justify-center cursor-pointer transition-colors duration-300 hover:border-brand-secondary group h-full shadow-sm">
                    <div class="flex flex-col items-center justify-center space-y-3 group-hover:-translate-y-2 transition-transform duration-300">
                        <div class="w-16 h-16 rounded-full overflow-hidden flex-shrink-0 shadow-sm border-4 border-gray-50 group-hover:scale-110 transition-transform duration-300">
                            <img src="{{ asset('icons/icon_combo.jpg') }}" alt="Combo" class="w-full h-full object-cover">
                        </div>
                        <span class="font-bold text-gray-800 text-sm group-hover:text-brand-secondary transition-colors text-center w-full">Combo</span>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="bg-white border border-gray-100 rounded-2xl p-5 flex flex-col items-center justify-center cursor-pointer transition-colors duration-300 hover:border-brand-secondary group h-full shadow-sm">
                    <div class="flex flex-col items-center justify-center space-y-3 group-hover:-translate-y-2 transition-transform duration-300">
                        <div class="w-16 h-16 rounded-full overflow-hidden flex-shrink-0 shadow-sm border-4 border-gray-50 group-hover:scale-110 transition-transform duration-300">
                            <img src="{{ asset('icons/icon_pregnancy.jpg') }}" alt="Pregnancy" class="w-full h-full object-cover">
                        </div>
                        <span class="font-bold text-gray-800 text-sm group-hover:text-brand-secondary transition-colors text-center w-full">Pregnancy</span>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="bg-white border border-gray-100 rounded-2xl p-5 flex flex-col items-center justify-center cursor-pointer transition-colors duration-300 hover:border-brand-secondary group h-full shadow-sm">
                    <div class="flex flex-col items-center justify-center space-y-3 group-hover:-translate-y-2 transition-transform duration-300">
                        <div class="w-16 h-16 rounded-full overflow-hidden flex-shrink-0 shadow-sm border-4 border-gray-50 group-hover:scale-110 transition-transform duration-300">
                            <img src="{{ asset('icons/icon_allergy.jpg') }}" alt="Allergy" class="w-full h-full object-cover">
                        </div>
                        <span class="font-bold text-gray-800 text-sm group-hover:text-brand-secondary transition-colors text-center w-full">Allergy</span>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="bg-white border border-gray-100 rounded-2xl p-5 flex flex-col items-center justify-center cursor-pointer transition-colors duration-300 hover:border-brand-secondary group h-full shadow-sm">
                    <div class="flex flex-col items-center justify-center space-y-3 group-hover:-translate-y-2 transition-transform duration-300">
                        <div class="w-16 h-16 rounded-full overflow-hidden flex-shrink-0 shadow-sm border-4 border-gray-50 group-hover:scale-110 transition-transform duration-300">
                            <img src="{{ asset('icons/icon_arthritis.jpg') }}" alt="Arthritis" class="w-full h-full object-cover">
                        </div>
                        <span class="font-bold text-gray-800 text-sm group-hover:text-brand-secondary transition-colors text-center w-full">Arthritis</span>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="bg-white border border-gray-100 rounded-2xl p-5 flex flex-col items-center justify-center cursor-pointer transition-colors duration-300 hover:border-brand-secondary group h-full shadow-sm">
                    <div class="flex flex-col items-center justify-center space-y-3 group-hover:-translate-y-2 transition-transform duration-300">
                        <div class="w-16 h-16 rounded-full overflow-hidden flex-shrink-0 shadow-sm border-4 border-gray-50 group-hover:scale-110 transition-transform duration-300">
                            <img src="{{ asset('icons/icon_std.jpg') }}" alt="STD" class="w-full h-full object-cover">
                        </div>
                        <span class="font-bold text-gray-800 text-sm group-hover:text-brand-secondary transition-colors text-center w-full">STD</span>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="bg-white border border-gray-100 rounded-2xl p-5 flex flex-col items-center justify-center cursor-pointer transition-colors duration-300 hover:border-brand-secondary group h-full shadow-sm">
                    <div class="flex flex-col items-center justify-center space-y-3 group-hover:-translate-y-2 transition-transform duration-300">
                        <div class="w-16 h-16 rounded-full overflow-hidden flex-shrink-0 shadow-sm border-4 border-gray-50 group-hover:scale-110 transition-transform duration-300">
                            <img src="{{ asset('icons/icon_anemia.jpg') }}" alt="Anemia" class="w-full h-full object-cover">
                        </div>
                        <span class="font-bold text-gray-800 text-sm group-hover:text-brand-secondary transition-colors text-center w-full">Anemia</span>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="bg-white border border-gray-100 rounded-2xl p-5 flex flex-col items-center justify-center cursor-pointer transition-colors duration-300 hover:border-brand-secondary group h-full shadow-sm">
                    <div class="flex flex-col items-center justify-center space-y-3 group-hover:-translate-y-2 transition-transform duration-300">
                        <div class="w-16 h-16 rounded-full overflow-hidden flex-shrink-0 shadow-sm border-4 border-gray-50 group-hover:scale-110 transition-transform duration-300">
                            <img src="{{ asset('icons/icon_antenatal.jpg') }}" alt="Antenatal" class="w-full h-full object-cover">
                        </div>
                        <span class="font-bold text-gray-800 text-sm group-hover:text-brand-secondary transition-colors text-center w-full">Antenatal</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper-button-next shadow-lg"></div>
        <div class="swiper-button-prev shadow-lg"></div>
    </div>
</div>


<style>
    .hide-scroll-bar::-webkit-scrollbar {
        display: none;
    }

    .hide-scroll-bar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>


    <!-- Top Booked Health Checkup Packages -->
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-end mb-6">
        <div>
            <h2 class="section-title mb-1">Top Booked Health Checkup Packages</h2>
            <p class="text-xs text-gray-500 italic">Chosen by Doctors, Trusted by Patients</p>
        </div>
        <div class="flex space-x-2">
            <button class="w-8 h-8 rounded-full border flex items-center justify-center text-gray-400 hover:text-brand-dark hover:border-brand-dark"><i class="fas fa-chevron-left text-xs"></i></button>
            <button class="w-8 h-8 rounded-full bg-brand-dark text-white flex items-center justify-center"><i class="fas fa-chevron-right text-xs"></i></button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Package Card 1 -->
        <div class="rounded-[2rem] p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 flex flex-col justify-between hover:-translate-y-1 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300 relative overflow-hidden group bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1579154204601-01588f351e67?auto=format&fit=crop&w=600&q=80');">
            <div class="absolute inset-0 bg-white/95 group-hover:opacity-0 transition-opacity duration-500 z-0"></div>
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-brand-dark to-brand-secondary transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500 z-10"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-4">
                    <span class="bg-blue-50/80 text-blue-700 text-xs font-bold px-3 py-1 rounded-full border border-blue-200/50 backdrop-blur-sm">MOST BOOKED</span>
                    <div class="w-8 h-8 rounded-full bg-orange-50/80 flex items-center justify-center text-brand-secondary backdrop-blur-sm">
                        <i class="fas fa-shield-alt text-sm"></i>
                    </div>
                </div>
                <h3 class="font-bold text-brand-secondary text-base leading-snug mb-2 group-hover:text-black group-hover:[text-shadow:_0_0_15px_rgba(255,255,255,1),_0_0_20px_rgba(255,255,255,1)] transition-all">Fit India Full Body Checkup With Vitamin Screening...</h3>
                <div class="bg-gray-50/80 backdrop-blur-sm rounded-xl p-3 flex items-center justify-between mb-4 border border-gray-200/50">
                    <div class="text-center">
                        <p class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold">Reports In</p>
                        <p class="text-sm font-bold text-gray-800">10 hrs</p>
                    </div>
                    <div class="w-px h-8 bg-gray-200"></div>
                    <div class="text-center">
                        <p class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold">Parameters</p>
                        <p class="text-sm font-bold text-gray-800">98</p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2 mb-6">
                    <span class="bg-white/80 backdrop-blur-sm text-gray-700 text-[10px] px-2 py-1 rounded-md border border-gray-200/50 flex items-center shadow-sm"><i class="fas fa-heart text-red-400 mr-1.5"></i> Heart</span>
                    <span class="bg-white/80 backdrop-blur-sm text-gray-700 text-[10px] px-2 py-1 rounded-md border border-gray-200/50 flex items-center shadow-sm"><i class="fas fa-tint text-blue-400 mr-1.5"></i> Diabetes</span>
                    <span class="bg-white/80 backdrop-blur-sm text-gray-700 text-[10px] px-2 py-1 rounded-md border border-gray-200/50 flex items-center shadow-sm"><i class="fas fa-lungs text-gray-400 mr-1.5"></i> Lungs</span>
                    <span class="text-[10px] text-brand-secondary font-bold self-center ml-1">+6 More</span>
                </div>
            </div>
            <div class="border-t border-gray-200/50 pt-4 mt-auto relative z-10">
                <div class="flex items-end justify-between mb-4">
                    <div>
                        <div class="flex items-center gap-2 mb-0.5">
                            <span class="text-xs text-gray-400 line-through">₹4000</span>
                            <span class="bg-green-100/90 text-green-700 text-[10px] font-bold px-1.5 py-0.5 rounded backdrop-blur-sm">55% OFF</span>
                        </div>
                        <div class="text-2xl font-black text-gray-900 tracking-tight">₹1799</div>
                    </div>
                </div>
                <button onclick="addToCart(this)" class="w-full bg-white/90 backdrop-blur-sm border-2 border-brand-secondary text-brand-secondary hover:bg-gradient-to-r hover:from-brand-dark hover:to-brand-secondary hover:border-transparent hover:text-white font-bold py-2.5 rounded-xl transition-all duration-300 flex items-center justify-center group/btn">
                    <i class="fas fa-cart-plus mr-2 group-hover/btn:scale-110 transition-transform"></i> Add to Cart
                </button>
                <p class="text-[9px] text-gray-500 font-medium text-center mt-3">For Extra 10% OFF With RC VIP</p>
            </div>
        </div>

        <!-- Package Card 2 -->
        <div class="rounded-[2rem] p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 flex flex-col justify-between hover:-translate-y-1 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300 relative overflow-hidden group bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=600&q=80');">
            <div class="absolute inset-0 bg-white/95 group-hover:opacity-0 transition-opacity duration-500 z-0"></div>
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-brand-dark to-brand-secondary transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500 z-10"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-4">
                    <span class="bg-blue-50/80 text-blue-700 text-xs font-bold px-3 py-1 rounded-full border border-blue-200/50 backdrop-blur-sm">MOST BOOKED</span>
                    <div class="w-8 h-8 rounded-full bg-orange-50/80 flex items-center justify-center text-brand-secondary backdrop-blur-sm">
                        <i class="fas fa-shield-alt text-sm"></i>
                    </div>
                </div>
                <h3 class="font-bold text-brand-secondary text-base leading-snug mb-2 group-hover:text-black group-hover:[text-shadow:_0_0_15px_rgba(255,255,255,1),_0_0_20px_rgba(255,255,255,1)] transition-all">Advance Plus Full Body Checkup with Free Heart Test</h3>
                <div class="bg-gray-50/80 backdrop-blur-sm rounded-xl p-3 flex items-center justify-between mb-4 border border-gray-200/50">
                    <div class="text-center">
                        <p class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold">Reports In</p>
                        <p class="text-sm font-bold text-gray-800">10 hrs</p>
                    </div>
                    <div class="w-px h-8 bg-gray-200"></div>
                    <div class="text-center">
                        <p class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold">Parameters</p>
                        <p class="text-sm font-bold text-gray-800">100</p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2 mb-6">
                    <span class="bg-white/80 backdrop-blur-sm text-gray-700 text-[10px] px-2 py-1 rounded-md border border-gray-200/50 flex items-center shadow-sm"><i class="fas fa-heart text-red-400 mr-1.5"></i> Heart</span>
                    <span class="bg-white/80 backdrop-blur-sm text-gray-700 text-[10px] px-2 py-1 rounded-md border border-gray-200/50 flex items-center shadow-sm"><i class="fas fa-tint text-blue-400 mr-1.5"></i> Diabetes</span>
                    <span class="bg-white/80 backdrop-blur-sm text-gray-700 text-[10px] px-2 py-1 rounded-md border border-gray-200/50 flex items-center shadow-sm"><i class="fas fa-lungs text-gray-400 mr-1.5"></i> Lungs</span>
                    <span class="text-[10px] text-brand-secondary font-bold self-center ml-1">+13 More</span>
                </div>
            </div>
            <div class="border-t border-gray-200/50 pt-4 mt-auto relative z-10">
                <div class="flex items-end justify-between mb-4">
                    <div>
                        <div class="flex items-center gap-2 mb-0.5">
                            <span class="text-xs text-gray-400 line-through">₹5600</span>
                            <span class="bg-green-100/90 text-green-700 text-[10px] font-bold px-1.5 py-0.5 rounded backdrop-blur-sm">55% OFF</span>
                        </div>
                        <div class="text-2xl font-black text-gray-900 tracking-tight">₹2499</div>
                    </div>
                </div>
                <button onclick="addToCart(this)" class="w-full bg-white/90 backdrop-blur-sm border-2 border-brand-secondary text-brand-secondary hover:bg-gradient-to-r hover:from-brand-dark hover:to-brand-secondary hover:border-transparent hover:text-white font-bold py-2.5 rounded-xl transition-all duration-300 flex items-center justify-center group/btn">
                    <i class="fas fa-cart-plus mr-2 group-hover/btn:scale-110 transition-transform"></i> Add to Cart
                </button>
                <p class="text-[9px] text-gray-500 font-medium text-center mt-3">For Extra 10% OFF With RC VIP</p>
            </div>
        </div>

        <!-- Package Card 3 -->
        <div class="rounded-[2rem] p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 flex flex-col justify-between hover:-translate-y-1 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300 relative overflow-hidden group bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=600&q=80');">
            <div class="absolute inset-0 bg-white/95 group-hover:opacity-0 transition-opacity duration-500 z-0"></div>
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-brand-dark to-brand-secondary transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500 z-10"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-4">
                    <span class="bg-purple-50/80 text-purple-700 text-xs font-bold px-3 py-1 rounded-full border border-purple-200/50 backdrop-blur-sm">POPULAR</span>
                    <div class="w-8 h-8 rounded-full bg-orange-50/80 flex items-center justify-center text-brand-secondary backdrop-blur-sm">
                        <i class="fas fa-shield-alt text-sm"></i>
                    </div>
                </div>
                <h3 class="font-bold text-brand-secondary text-base leading-snug mb-2 group-hover:text-black group-hover:[text-shadow:_0_0_15px_rgba(255,255,255,1),_0_0_20px_rgba(255,255,255,1)] transition-all">Annual Full Body Checkup - Advance</h3>
                <div class="bg-gray-50/80 backdrop-blur-sm rounded-xl p-3 flex items-center justify-between mb-4 border border-gray-200/50">
                    <div class="text-center">
                        <p class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold">Reports In</p>
                        <p class="text-sm font-bold text-gray-800">10 hrs</p>
                    </div>
                    <div class="w-px h-8 bg-gray-200"></div>
                    <div class="text-center">
                        <p class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold">Parameters</p>
                        <p class="text-sm font-bold text-gray-800">98</p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2 mb-6">
                    <span class="bg-white/80 backdrop-blur-sm text-gray-700 text-[10px] px-2 py-1 rounded-md border border-gray-200/50 flex items-center shadow-sm"><i class="fas fa-heart text-red-400 mr-1.5"></i> Heart</span>
                    <span class="bg-white/80 backdrop-blur-sm text-gray-700 text-[10px] px-2 py-1 rounded-md border border-gray-200/50 flex items-center shadow-sm"><i class="fas fa-tint text-blue-400 mr-1.5"></i> Diabetes</span>
                    <span class="bg-white/80 backdrop-blur-sm text-gray-700 text-[10px] px-2 py-1 rounded-md border border-gray-200/50 flex items-center shadow-sm"><i class="fas fa-lungs text-gray-400 mr-1.5"></i> Lungs</span>
                    <span class="text-[10px] text-brand-secondary font-bold self-center ml-1">+6 More</span>
                </div>
            </div>
            <div class="border-t border-gray-200/50 pt-4 mt-auto relative z-10">
                <div class="flex items-end justify-between mb-4">
                    <div>
                        <div class="flex items-center gap-2 mb-0.5">
                            <span class="text-xs text-gray-400 line-through">₹4000</span>
                            <span class="bg-green-100/90 text-green-700 text-[10px] font-bold px-1.5 py-0.5 rounded backdrop-blur-sm">55% OFF</span>
                        </div>
                        <div class="text-2xl font-black text-gray-900 tracking-tight">₹1799</div>
                    </div>
                </div>
                <button onclick="addToCart(this)" class="w-full bg-white/90 backdrop-blur-sm border-2 border-brand-secondary text-brand-secondary hover:bg-gradient-to-r hover:from-brand-dark hover:to-brand-secondary hover:border-transparent hover:text-white font-bold py-2.5 rounded-xl transition-all duration-300 flex items-center justify-center group/btn">
                    <i class="fas fa-cart-plus mr-2 group-hover/btn:scale-110 transition-transform"></i> Add to Cart
                </button>
                <p class="text-[9px] text-gray-500 font-medium text-center mt-3">For Extra 10% OFF With RC VIP</p>
            </div>
        </div>

        <!-- Package Card 4 -->
        <div class="rounded-[2rem] p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 flex flex-col justify-between hover:-translate-y-1 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300 relative overflow-hidden group bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1581594693702-fbdc51b2763b?auto=format&fit=crop&w=600&q=80');">
            <div class="absolute inset-0 bg-white/95 group-hover:opacity-0 transition-opacity duration-500 z-0"></div>
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-brand-dark to-brand-secondary transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500 z-10"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-4">
                    <span class="bg-purple-50/80 text-purple-700 text-xs font-bold px-3 py-1 rounded-full border border-purple-200/50 backdrop-blur-sm">POPULAR</span>
                    <div class="w-8 h-8 rounded-full bg-orange-50/80 flex items-center justify-center text-brand-secondary backdrop-blur-sm">
                        <i class="fas fa-shield-alt text-sm"></i>
                    </div>
                </div>
                <h3 class="font-bold text-brand-secondary text-base leading-snug mb-2 group-hover:text-black group-hover:[text-shadow:_0_0_15px_rgba(255,255,255,1),_0_0_20px_rgba(255,255,255,1)] transition-all">One Plus Full Body Checkup with Free Heart Test...</h3>
                <div class="bg-gray-50/80 backdrop-blur-sm rounded-xl p-3 flex items-center justify-between mb-4 border border-gray-200/50">
                    <div class="text-center">
                        <p class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold">Reports In</p>
                        <p class="text-sm font-bold text-gray-800">10 hrs</p>
                    </div>
                    <div class="w-px h-8 bg-gray-200"></div>
                    <div class="text-center">
                        <p class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold">Parameters</p>
                        <p class="text-sm font-bold text-gray-800">100</p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2 mb-6">
                    <span class="bg-white/80 backdrop-blur-sm text-gray-700 text-[10px] px-2 py-1 rounded-md border border-gray-200/50 flex items-center shadow-sm"><i class="fas fa-heart text-red-400 mr-1.5"></i> Heart</span>
                    <span class="bg-white/80 backdrop-blur-sm text-gray-700 text-[10px] px-2 py-1 rounded-md border border-gray-200/50 flex items-center shadow-sm"><i class="fas fa-tint text-blue-400 mr-1.5"></i> Diabetes</span>
                    <span class="bg-white/80 backdrop-blur-sm text-gray-700 text-[10px] px-2 py-1 rounded-md border border-gray-200/50 flex items-center shadow-sm"><i class="fas fa-lungs text-gray-400 mr-1.5"></i> Lungs</span>
                    <span class="text-[10px] text-brand-secondary font-bold self-center ml-1">+13 More</span>
                </div>
            </div>
            <div class="border-t border-gray-200/50 pt-4 mt-auto relative z-10">
                <div class="flex items-end justify-between mb-4">
                    <div>
                        <div class="flex items-center gap-2 mb-0.5">
                            <span class="text-xs text-gray-400 line-through">₹7000</span>
                            <span class="bg-green-100/90 text-green-700 text-[10px] font-bold px-1.5 py-0.5 rounded backdrop-blur-sm">51% OFF</span>
                        </div>
                        <div class="text-2xl font-black text-gray-900 tracking-tight">₹3399</div>
                    </div>
                </div>
                <button onclick="addToCart(this)" class="w-full bg-white/90 backdrop-blur-sm border-2 border-brand-secondary text-brand-secondary hover:bg-gradient-to-r hover:from-brand-dark hover:to-brand-secondary hover:border-transparent hover:text-white font-bold py-2.5 rounded-xl transition-all duration-300 flex items-center justify-center group/btn">
                    <i class="fas fa-cart-plus mr-2 group-hover/btn:scale-110 transition-transform"></i> Add to Cart
                </button>
                <p class="text-[9px] text-gray-500 font-medium text-center mt-3">For Extra 10% OFF With RC VIP</p>
            </div>
        </div>
    </div>
</div>


    <!-- Unhealthy Habits -->
<div class="container mx-auto px-4 py-8">
    <div class="bg-gray-50 rounded-2xl p-6">
        <div class="flex justify-between items-end mb-4">
            <div>
                <h2 class="section-title mb-1">Unhealthy Habits</h2>
                <p class="text-xs text-gray-500">Understand how daily habits may be impacting your health.</p>
            </div>
            <div class="flex space-x-2">
                <button class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center text-gray-400 hover:text-brand-dark hover:border-brand-dark"><i class="fas fa-chevron-left text-xs"></i></button>
                <button class="w-8 h-8 rounded-full bg-brand-dark text-white flex items-center justify-center"><i class="fas fa-chevron-right text-xs"></i></button>
            </div>
        </div>

        <!-- Tabs -->
        <div class="flex space-x-2 overflow-x-auto pb-4 hide-scroll-bar">
            <button class="bg-brand-dark text-white px-4 py-2 rounded-lg text-sm font-bold min-w-max">All</button>
            <button class="bg-white border text-gray-600 px-4 py-2 rounded-lg text-sm font-semibold min-w-max hover:bg-gray-50"><i class="fas fa-hamburger mr-2 text-orange-400"></i> Junk Food</button>
            <button class="bg-white border text-gray-600 px-4 py-2 rounded-lg text-sm font-semibold min-w-max hover:bg-gray-50"><i class="fas fa-couch mr-2 text-purple-400"></i> Sedentary Lifestyle</button>
            <button class="bg-white border text-gray-600 px-4 py-2 rounded-lg text-sm font-semibold min-w-max hover:bg-gray-50"><i class="fas fa-smoking mr-2 text-gray-400"></i> Smoking</button>
            <button class="bg-white border text-gray-600 px-4 py-2 rounded-lg text-sm font-semibold min-w-max hover:bg-gray-50"><i class="fas fa-glass-martini-alt mr-2 text-red-400"></i> Alcohol</button>
            <button class="bg-white border text-gray-600 px-4 py-2 rounded-lg text-sm font-semibold min-w-max hover:bg-gray-50"><i class="fas fa-brain mr-2 text-pink-400"></i> Stress</button>
            <button class="bg-white border text-gray-600 px-4 py-2 rounded-lg text-sm font-semibold min-w-max hover:bg-gray-50"><i class="fas fa-angry mr-2 text-red-600"></i> Anger</button>
            <button class="bg-white border text-gray-600 px-4 py-2 rounded-lg text-sm font-semibold min-w-max hover:bg-gray-50"><i class="fas fa-bed mr-2 text-blue-400"></i> Sleepless</button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6">
            <!-- Habit Package 1 -->
            <div class="bg-white rounded-tr-[3rem] rounded-bl-[3rem] rounded-tl-xl rounded-br-xl p-6 border border-gray-100 flex flex-col justify-between hover:-translate-y-1 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300 relative overflow-hidden group">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-teal-400 to-brand-dark transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                <div>
                    <div class="flex justify-between items-start mb-2">
                        <div class="w-8 h-8 rounded-full bg-teal-50 flex items-center justify-center text-teal-600 mb-2">
                            <i class="fas fa-battery-quarter text-sm"></i>
                        </div>
                        <span class="bg-teal-50 text-teal-700 text-[10px] font-bold px-2 py-1 rounded-md">LIFESTYLE</span>
                    </div>
                    <h4 class="font-bold text-gray-800 text-base leading-snug mb-1 group-hover:text-brand-secondary transition-colors">Low Energy Screening Package</h4>
                    <a href="#" class="text-[10px] text-brand-secondary font-semibold hover:underline">View Details ></a>

                    <div class="bg-gray-50 rounded-xl p-3 flex items-center justify-between mt-4 mb-4 border border-gray-100">
                        <div class="text-center">
                            <p class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold">Reports In</p>
                            <p class="text-sm font-bold text-gray-800">12 hrs</p>
                        </div>
                        <div class="w-px h-8 bg-gray-200"></div>
                        <div class="text-center">
                            <p class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold">Parameters</p>
                            <p class="text-sm font-bold text-gray-800">33</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mb-6 line-clamp-2">This test helps diagnose the root cause of constant fatigue or other low-energy</p>
                </div>
                <div class="border-t border-gray-100 pt-4 mt-auto">
                    <div class="flex items-end justify-between mb-4">
                        <div>
                            <div class="flex items-center gap-2 mb-0.5">
                                <span class="text-xs text-gray-400 line-through">₹1700</span>
                                <span class="bg-green-100 text-green-700 text-[10px] font-bold px-1.5 py-0.5 rounded">53% OFF</span>
                            </div>
                            <div class="text-2xl font-black text-gray-900 tracking-tight">₹799</div>
                        </div>
                    </div>
                    <button class="w-full bg-white border-2 border-brand-secondary text-brand-secondary hover:bg-gradient-to-r hover:from-brand-dark hover:to-brand-secondary hover:border-transparent hover:text-white font-bold py-2.5 rounded-xl transition-all duration-300 flex items-center justify-center group/btn">
                        <i class="fas fa-cart-plus mr-2 group-hover/btn:scale-110 transition-transform"></i> Add to Cart
                    </button>
                    <p class="text-[9px] text-gray-400 text-center mt-3">For Extra 10% OFF With RC VIP</p>
                </div>
            </div>

            <!-- Habit Package 2 -->
            <div class="bg-white rounded-tr-[3rem] rounded-bl-[3rem] rounded-tl-xl rounded-br-xl p-6 border border-gray-100 flex flex-col justify-between hover:-translate-y-1 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300 relative overflow-hidden group">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-400 to-blue-600 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                <div>
                    <div class="flex justify-between items-start mb-2">
                        <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 mb-2">
                            <i class="fas fa-procedures text-sm"></i>
                        </div>
                        <span class="bg-blue-50 text-blue-700 text-[10px] font-bold px-2 py-1 rounded-md">LIFESTYLE</span>
                    </div>
                    <h4 class="font-bold text-gray-800 text-base leading-snug mb-1 group-hover:text-brand-secondary transition-colors">Fatigue Syndrome Test</h4>
                    <a href="#" class="text-[10px] text-brand-secondary font-semibold hover:underline">View Details ></a>

                    <div class="bg-gray-50 rounded-xl p-3 flex items-center justify-between mt-4 mb-4 border border-gray-100">
                        <div class="text-center">
                            <p class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold">Reports In</p>
                            <p class="text-sm font-bold text-gray-800">10 hrs</p>
                        </div>
                        <div class="w-px h-8 bg-gray-200"></div>
                        <div class="text-center">
                            <p class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold">Parameters</p>
                            <p class="text-sm font-bold text-gray-800">62</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mb-6 line-clamp-2">It helps diagnose the cause behind chronic fatigue & help a doctor guide treatment.</p>
                </div>
                <div class="border-t border-gray-100 pt-4 mt-auto">
                    <div class="flex items-end justify-between mb-4">
                        <div>
                            <div class="flex items-center gap-2 mb-0.5">
                                <span class="text-xs text-gray-400 line-through">₹3500</span>
                                <span class="bg-green-100 text-green-700 text-[10px] font-bold px-1.5 py-0.5 rounded">54% OFF</span>
                            </div>
                            <div class="text-2xl font-black text-gray-900 tracking-tight">₹1599</div>
                        </div>
                    </div>
                    <button class="w-full bg-white border-2 border-brand-secondary text-brand-secondary hover:bg-gradient-to-r hover:from-brand-dark hover:to-brand-secondary hover:border-transparent hover:text-white font-bold py-2.5 rounded-xl transition-all duration-300 flex items-center justify-center group/btn">
                        <i class="fas fa-cart-plus mr-2 group-hover/btn:scale-110 transition-transform"></i> Add to Cart
                    </button>
                    <p class="text-[9px] text-gray-400 text-center mt-3">For Extra 10% OFF With RC VIP</p>
                </div>
            </div>

            <!-- Habit Package 3 -->
            <div class="bg-white rounded-tr-[3rem] rounded-bl-[3rem] rounded-tl-xl rounded-br-xl p-6 border border-gray-100 flex flex-col justify-between hover:-translate-y-1 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300 relative overflow-hidden group">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red-500 to-red-700 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                <div>
                    <div class="flex justify-between items-start mb-2">
                        <div class="w-8 h-8 rounded-full bg-red-50 flex items-center justify-center text-red-600 mb-2">
                            <i class="fas fa-angry text-sm"></i>
                        </div>
                        <span class="bg-red-50 text-red-700 text-[10px] font-bold px-2 py-1 rounded-md">EMOTIONAL</span>
                    </div>
                    <h4 class="font-bold text-gray-800 text-base leading-snug mb-1 group-hover:text-brand-secondary transition-colors">Anger Impact Package - Extended</h4>
                    <a href="#" class="text-[10px] text-brand-secondary font-semibold hover:underline">View Details ></a>

                    <div class="bg-gray-50 rounded-xl p-3 flex items-center justify-between mt-4 mb-4 border border-gray-100">
                        <div class="text-center">
                            <p class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold">Reports In</p>
                            <p class="text-sm font-bold text-gray-800">10 hrs</p>
                        </div>
                        <div class="w-px h-8 bg-gray-200"></div>
                        <div class="text-center">
                            <p class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold">Parameters</p>
                            <p class="text-sm font-bold text-gray-800">56</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mb-6 line-clamp-2">CBC, HbA1C, Lipid Profile, LFT, Iron Studies, CRP, TSH, Vitamin D</p>
                </div>
                <div class="border-t border-gray-100 pt-4 mt-auto">
                    <div class="flex items-end justify-between mb-4">
                        <div>
                            <div class="flex items-center gap-2 mb-0.5">
                                <span class="text-xs text-gray-400 line-through">₹3000</span>
                                <span class="bg-green-100 text-green-700 text-[10px] font-bold px-1.5 py-0.5 rounded">63% OFF</span>
                            </div>
                            <div class="text-2xl font-black text-gray-900 tracking-tight">₹1099</div>
                        </div>
                    </div>
                    <button class="w-full bg-white border-2 border-brand-secondary text-brand-secondary hover:bg-gradient-to-r hover:from-brand-dark hover:to-brand-secondary hover:border-transparent hover:text-white font-bold py-2.5 rounded-xl transition-all duration-300 flex items-center justify-center group/btn">
                        <i class="fas fa-cart-plus mr-2 group-hover/btn:scale-110 transition-transform"></i> Add to Cart
                    </button>
                    <p class="text-[9px] text-gray-400 text-center mt-3">For Extra 10% OFF With RC VIP</p>
                </div>
            </div>

            <!-- Habit Package 4 -->
            <div class="bg-white rounded-tr-[3rem] rounded-bl-[3rem] rounded-tl-xl rounded-br-xl p-6 border border-gray-100 flex flex-col justify-between hover:-translate-y-1 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300 relative overflow-hidden group">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-orange-400 to-orange-600 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                <div>
                    <div class="flex justify-between items-start mb-2">
                        <div class="w-8 h-8 rounded-full bg-orange-50 flex items-center justify-center text-orange-600 mb-2">
                            <i class="fas fa-hamburger text-sm"></i>
                        </div>
                        <span class="bg-orange-50 text-orange-700 text-[10px] font-bold px-2 py-1 rounded-md">DIET</span>
                    </div>
                    <h4 class="font-bold text-gray-800 text-base leading-snug mb-1 group-hover:text-brand-secondary transition-colors">Junk Food Test</h4>
                    <a href="#" class="text-[10px] text-brand-secondary font-semibold hover:underline">View Details ></a>

                    <div class="bg-gray-50 rounded-xl p-3 flex items-center justify-between mt-4 mb-4 border border-gray-100">
                        <div class="text-center">
                            <p class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold">Reports In</p>
                            <p class="text-sm font-bold text-gray-800">12 hrs</p>
                        </div>
                        <div class="w-px h-8 bg-gray-200"></div>
                        <div class="text-center">
                            <p class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold">Parameters</p>
                            <p class="text-sm font-bold text-gray-800">40</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mb-6 line-clamp-2">Evaluates key health markers affected by high junk food and sugar consumption.</p>
                </div>
                <div class="border-t border-gray-100 pt-4 mt-auto">
                    <div class="flex items-end justify-between mb-4">
                        <div>
                            <div class="flex items-center gap-2 mb-0.5">
                                <span class="text-xs text-gray-400 line-through">₹2000</span>
                                <span class="bg-green-100 text-green-700 text-[10px] font-bold px-1.5 py-0.5 rounded">50% OFF</span>
                            </div>
                            <div class="text-2xl font-black text-gray-900 tracking-tight">₹999</div>
                        </div>
                    </div>
                    <button class="w-full bg-white border-2 border-brand-secondary text-brand-secondary hover:bg-gradient-to-r hover:from-brand-dark hover:to-brand-secondary hover:border-transparent hover:text-white font-bold py-2.5 rounded-xl transition-all duration-300 flex items-center justify-center group/btn">
                        <i class="fas fa-cart-plus mr-2 group-hover/btn:scale-110 transition-transform"></i> Add to Cart
                    </button>
                    <p class="text-[9px] text-gray-400 text-center mt-3">For Extra 10% OFF With RC VIP</p>
                </div>
            </div>
        </div>
    </div>
</div>


    <!-- Femcliffe Health Packages -->
<div class="bg-pink-50/50 py-8 mt-8 rounded-[2rem] mx-4 lg:mx-0">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-end mb-6">
            <div>
                <h2 class="section-title mb-1 flex items-center">Femcliffe <span class="bg-pink-100 text-pink-600 text-[10px] px-3 py-1 rounded-full ml-3 uppercase font-bold tracking-wide shadow-sm border border-pink-200">Health Packages</span></h2>
                <p class="text-xs text-gray-500 mt-2">India's First She-Centric Diagnostic Platform <a href="#" class="text-pink-500 underline font-bold hover:text-pink-700 transition">Know More</a></p>
            </div>
            <div class="flex space-x-2">
                <button class="w-8 h-8 rounded-full border border-gray-300 bg-white flex items-center justify-center text-gray-400 hover:text-brand-dark hover:border-brand-dark transition-colors"><i class="fas fa-chevron-left text-xs"></i></button>
                <button class="w-8 h-8 rounded-full bg-brand-dark text-white flex items-center justify-center hover:bg-black transition-colors"><i class="fas fa-chevron-right text-xs"></i></button>
            </div>
        </div>

        <!-- Tabs -->
        <div class="flex space-x-2 overflow-x-auto pb-4 hide-scroll-bar">
            <button class="bg-pink-500 text-white px-5 py-2 rounded-xl text-sm font-bold min-w-max shadow-md">All</button>
            <button class="bg-white border border-gray-200 text-gray-600 px-5 py-2 rounded-xl text-sm font-semibold min-w-max hover:bg-pink-50 hover:border-pink-200 hover:text-pink-600 transition-all">Pregnancy</button>
            <button class="bg-white border border-gray-200 text-gray-600 px-5 py-2 rounded-xl text-sm font-semibold min-w-max hover:bg-pink-50 hover:border-pink-200 hover:text-pink-600 transition-all">Wellness</button>
            <button class="bg-white border border-gray-200 text-gray-600 px-5 py-2 rounded-xl text-sm font-semibold min-w-max hover:bg-pink-50 hover:border-pink-200 hover:text-pink-600 transition-all">PCOS/PCOD</button>
            <button class="bg-white border border-gray-200 text-gray-600 px-5 py-2 rounded-xl text-sm font-semibold min-w-max hover:bg-pink-50 hover:border-pink-200 hover:text-pink-600 transition-all">Sexual Health</button>
            <button class="bg-white border border-gray-200 text-gray-600 px-5 py-2 rounded-xl text-sm font-semibold min-w-max hover:bg-pink-50 hover:border-pink-200 hover:text-pink-600 transition-all">Menstrual Health</button>
            <button class="bg-white border border-gray-200 text-gray-600 px-5 py-2 rounded-xl text-sm font-semibold min-w-max hover:bg-pink-50 hover:border-pink-200 hover:text-pink-600 transition-all">Cancer</button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
            <!-- Femcliffe Package 1 -->
            <div class="bg-white rounded-[2rem] p-6 border border-pink-100 flex flex-col justify-between hover:-translate-y-1 hover:shadow-[0_8px_30px_rgb(236,72,153,0.15)] transition-all duration-300 relative overflow-hidden group">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-pink-400 to-purple-500 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                <div>
                    <div class="flex justify-between items-start mb-2">
                        <div class="w-8 h-8 rounded-full bg-pink-50 flex items-center justify-center text-pink-500 mb-2">
                            <i class="fas fa-venus text-sm"></i>
                        </div>
                    </div>
                    <h4 class="font-bold text-gray-800 text-base leading-snug mb-1 group-hover:text-pink-500 transition-colors">Thyroid Profile Total</h4>
                    <a href="#" class="text-[10px] text-pink-500 font-semibold hover:underline">View Details ></a>

                    <div class="bg-pink-50/50 rounded-xl p-3 flex items-center justify-between mt-4 mb-4 border border-pink-100">
                        <div class="text-center w-full">
                            <p class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold">Reports In</p>
                            <p class="text-sm font-bold text-gray-800">10 hrs</p>
                        </div>
                        <div class="w-px h-8 bg-pink-200 mx-2"></div>
                        <div class="text-center w-full">
                            <p class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold">Parameters</p>
                            <p class="text-sm font-bold text-gray-800">3</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mb-6 line-clamp-2">A comprehensive thyroid panel measuring total T3, total T4, and TSH.</p>
                </div>
                <div class="border-t border-gray-100 pt-4 mt-auto">
                    <div class="flex items-end justify-between mb-4">
                        <div>
                            <div class="flex items-center gap-2 mb-0.5">
                                <span class="text-xs text-gray-400 line-through">₹1000</span>
                                <span class="bg-green-100 text-green-700 text-[10px] font-bold px-1.5 py-0.5 rounded">57% OFF</span>
                            </div>
                            <div class="text-2xl font-black text-gray-900 tracking-tight">₹429</div>
                        </div>
                    </div>
                    <button class="w-full bg-white border-2 border-pink-500 text-pink-500 hover:bg-gradient-to-r hover:from-pink-500 hover:to-purple-500 hover:border-transparent hover:text-white font-bold py-2.5 rounded-xl transition-all duration-300 flex items-center justify-center group/btn shadow-sm">
                        <i class="fas fa-cart-plus mr-2 group-hover/btn:scale-110 transition-transform"></i> Add to Cart
                    </button>
                    <p class="text-[9px] text-gray-400 text-center mt-3">For Extra 10% OFF With RC VIP</p>
                </div>
            </div>

            <!-- Femcliffe Package 2 -->
            <div class="bg-white rounded-[2rem] p-6 border border-pink-100 flex flex-col justify-between hover:-translate-y-1 hover:shadow-[0_8px_30px_rgb(236,72,153,0.15)] transition-all duration-300 relative overflow-hidden group">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-pink-400 to-purple-500 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                <div>
                    <div class="flex justify-between items-start mb-2">
                        <div class="w-8 h-8 rounded-full bg-pink-50 flex items-center justify-center text-pink-500 mb-2">
                            <i class="fas fa-venus text-sm"></i>
                        </div>
                    </div>
                    <h4 class="font-bold text-gray-800 text-base leading-snug mb-1 group-hover:text-pink-500 transition-colors">Stay Fit Plus Full Body Checkup With Free RA Factor</h4>
                    <a href="#" class="text-[10px] text-pink-500 font-semibold hover:underline">View Details ></a>

                    <div class="bg-pink-50/50 rounded-xl p-3 flex items-center justify-between mt-4 mb-4 border border-pink-100">
                        <div class="text-center w-full">
                            <p class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold">Reports In</p>
                            <p class="text-sm font-bold text-gray-800">10 hrs</p>
                        </div>
                        <div class="w-px h-8 bg-pink-200 mx-2"></div>
                        <div class="text-center w-full">
                            <p class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold">Parameters</p>
                            <p class="text-sm font-bold text-gray-800">89</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mb-6 line-clamp-2">Complete health checkup designed specifically for women's wellness.</p>
                </div>
                <div class="border-t border-gray-100 pt-4 mt-auto">
                    <div class="flex items-end justify-between mb-4">
                        <div>
                            <div class="flex items-center gap-2 mb-0.5">
                                <span class="text-xs text-gray-400 line-through">₹6800</span>
                                <span class="bg-green-100 text-green-700 text-[10px] font-bold px-1.5 py-0.5 rounded">62% OFF</span>
                            </div>
                            <div class="text-2xl font-black text-gray-900 tracking-tight">₹2599</div>
                        </div>
                    </div>
                    <button class="w-full bg-white border-2 border-pink-500 text-pink-500 hover:bg-gradient-to-r hover:from-pink-500 hover:to-purple-500 hover:border-transparent hover:text-white font-bold py-2.5 rounded-xl transition-all duration-300 flex items-center justify-center group/btn shadow-sm">
                        <i class="fas fa-cart-plus mr-2 group-hover/btn:scale-110 transition-transform"></i> Add to Cart
                    </button>
                    <p class="text-[9px] text-gray-400 text-center mt-3">For Extra 10% OFF With RC VIP</p>
                </div>
            </div>

            <!-- Femcliffe Package 3 -->
            <div class="bg-white rounded-[2rem] p-6 border border-pink-100 flex flex-col justify-between hover:-translate-y-1 hover:shadow-[0_8px_30px_rgb(236,72,153,0.15)] transition-all duration-300 relative overflow-hidden group">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-pink-400 to-purple-500 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                <div>
                    <div class="flex justify-between items-start mb-2">
                        <div class="w-8 h-8 rounded-full bg-pink-50 flex items-center justify-center text-pink-500 mb-2">
                            <i class="fas fa-venus text-sm"></i>
                        </div>
                    </div>
                    <h4 class="font-bold text-gray-800 text-base leading-snug mb-1 group-hover:text-pink-500 transition-colors">Master Full Body Checkup Package - Women</h4>
                    <a href="#" class="text-[10px] text-pink-500 font-semibold hover:underline">View Details ></a>

                    <div class="bg-pink-50/50 rounded-xl p-3 flex items-center justify-between mt-4 mb-4 border border-pink-100">
                        <div class="text-center w-full">
                            <p class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold">Reports In</p>
                            <p class="text-sm font-bold text-gray-800">10 hrs</p>
                        </div>
                        <div class="w-px h-8 bg-pink-200 mx-2"></div>
                        <div class="text-center w-full">
                            <p class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold">Parameters</p>
                            <p class="text-sm font-bold text-gray-800">107</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mb-6 line-clamp-2">Assesses parameters like TSH, LH-FSH, CBC, lipid profile, vit D & B12.</p>
                </div>
                <div class="border-t border-gray-100 pt-4 mt-auto">
                    <div class="flex items-end justify-between mb-4">
                        <div>
                            <div class="flex items-center gap-2 mb-0.5">
                                <span class="text-xs text-gray-400 line-through">₹9000</span>
                                <span class="bg-green-100 text-green-700 text-[10px] font-bold px-1.5 py-0.5 rounded">48% OFF</span>
                            </div>
                            <div class="text-2xl font-black text-gray-900 tracking-tight">₹4699</div>
                        </div>
                    </div>
                    <button class="w-full bg-white border-2 border-pink-500 text-pink-500 hover:bg-gradient-to-r hover:from-pink-500 hover:to-purple-500 hover:border-transparent hover:text-white font-bold py-2.5 rounded-xl transition-all duration-300 flex items-center justify-center group/btn shadow-sm">
                        <i class="fas fa-cart-plus mr-2 group-hover/btn:scale-110 transition-transform"></i> Add to Cart
                    </button>
                    <p class="text-[9px] text-gray-400 text-center mt-3">For Extra 10% OFF With RC VIP</p>
                </div>
            </div>

            <!-- Femcliffe Package 4 -->
            <div class="bg-white rounded-[2rem] p-6 border border-pink-100 flex flex-col justify-between hover:-translate-y-1 hover:shadow-[0_8px_30px_rgb(236,72,153,0.15)] transition-all duration-300 relative overflow-hidden group">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-pink-400 to-purple-500 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                <div>
                    <div class="flex justify-between items-start mb-2">
                        <div class="w-8 h-8 rounded-full bg-pink-50 flex items-center justify-center text-pink-500 mb-2">
                            <i class="fas fa-venus text-sm"></i>
                        </div>
                    </div>
                    <h4 class="font-bold text-gray-800 text-base leading-snug mb-1 group-hover:text-pink-500 transition-colors">TSH Test</h4>
                    <a href="#" class="text-[10px] text-pink-500 font-semibold hover:underline">View Details ></a>

                    <div class="bg-pink-50/50 rounded-xl p-3 flex items-center justify-between mt-4 mb-4 border border-pink-100">
                        <div class="text-center w-full">
                            <p class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold">Reports In</p>
                            <p class="text-sm font-bold text-gray-800">12 hrs</p>
                        </div>
                        <div class="w-px h-8 bg-pink-200 mx-2"></div>
                        <div class="text-center w-full">
                            <p class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold">Parameters</p>
                            <p class="text-sm font-bold text-gray-800">1</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mb-6 line-clamp-2">Measures Thyroid Stimulating Hormone levels to check thyroid function.</p>
                </div>
                <div class="border-t border-gray-100 pt-4 mt-auto">
                    <div class="flex items-end justify-between mb-4">
                        <div>
                            <div class="flex items-center gap-2 mb-0.5">
                                <span class="text-xs text-gray-400 line-through">₹400</span>
                                <span class="bg-green-100 text-green-700 text-[10px] font-bold px-1.5 py-0.5 rounded">25% OFF</span>
                            </div>
                            <div class="text-2xl font-black text-gray-900 tracking-tight">₹299</div>
                        </div>
                    </div>
                    <button class="w-full bg-white border-2 border-pink-500 text-pink-500 hover:bg-gradient-to-r hover:from-pink-500 hover:to-purple-500 hover:border-transparent hover:text-white font-bold py-2.5 rounded-xl transition-all duration-300 flex items-center justify-center group/btn shadow-sm">
                        <i class="fas fa-cart-plus mr-2 group-hover/btn:scale-110 transition-transform"></i> Add to Cart
                    </button>
                    <p class="text-[9px] text-gray-400 text-center mt-3">For Extra 10% OFF With RC VIP</p>
                </div>
            </div>
        </div>
        </div>
</div>


    <!-- Why Book Tests With Us? -->
<div class="relative py-20 overflow-hidden bg-gradient-to-br from-gray-50 to-white">
    <!-- Decorative background elements -->
    <div class="absolute top-0 right-0 w-64 h-64 bg-brand-light rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
    <div class="absolute bottom-0 left-0 w-72 h-72 bg-blue-100 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-5xl font-extrabold text-brand-dark mb-4 tracking-tight">Why Book Tests With <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-dark to-brand-secondary">Us?</span></h2>
            <p class="text-gray-500 max-w-2xl mx-auto text-lg">Experience world-class diagnostics with unparalleled accuracy, speed, and comfort right at your doorstep.</p>
        </div>
        
        <div class="flex flex-col lg:flex-row gap-12 items-center">
            <!-- Features Grid -->
            <div class="lg:w-1/2 grid grid-cols-1 sm:grid-cols-2 gap-8 relative pb-10 sm:pb-0">
                <!-- Decorative Hanging Bar (optional, can just use the staggered grid) -->
                <!-- Card 1 -->
                <div class="group bg-pink-50/80 rounded-xl p-6 shadow-xl hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border-[6px] border-white relative overflow-hidden sm:-rotate-3 z-10 hover:z-20 origin-top">
                    <!-- Hanging String -->
                    <div class="absolute -top-1 left-1/2 -translate-x-1/2 w-0.5 h-4 bg-gray-300"></div>
                    <div class="absolute top-2 left-1/2 -translate-x-1/2 w-2 h-2 bg-gray-400 rounded-full shadow-sm"></div>
                    
                    <div class="absolute inset-0 bg-gradient-to-br from-pink-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10 mt-2">
                        <div class="w-14 h-14 bg-pink-100/50 rounded-lg flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-syringe text-2xl text-pink-500 drop-shadow-sm"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 text-lg mb-2">Painless Collection</h4>
                        <p class="text-sm font-medium text-gray-500 leading-relaxed">One-prick sample collection by trained experts at your home.</p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="group bg-teal-50/80 rounded-xl p-6 shadow-xl hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border-[6px] border-white relative overflow-hidden sm:rotate-2 mt-0 sm:mt-12 z-10 hover:z-20 origin-top">
                    <!-- Hanging String -->
                    <div class="absolute -top-1 left-1/2 -translate-x-1/2 w-0.5 h-4 bg-gray-300"></div>
                    <div class="absolute top-2 left-1/2 -translate-x-1/2 w-2 h-2 bg-gray-400 rounded-full shadow-sm"></div>
                    
                    <div class="absolute inset-0 bg-gradient-to-br from-teal-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10 mt-2">
                        <div class="w-14 h-14 bg-teal-100/50 rounded-lg flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-temperature-low text-2xl text-teal-500 drop-shadow-sm"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 text-lg mb-2">100% Sample Integrity</h4>
                        <p class="text-sm font-medium text-gray-500 leading-relaxed">Temperature-controlled bags ensure samples arrive in pristine condition.</p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="group bg-blue-50/80 rounded-xl p-6 shadow-xl hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border-[6px] border-white relative overflow-hidden sm:rotate-3 z-10 hover:z-20 origin-top">
                    <!-- Hanging String -->
                    <div class="absolute -top-1 left-1/2 -translate-x-1/2 w-0.5 h-4 bg-gray-300"></div>
                    <div class="absolute top-2 left-1/2 -translate-x-1/2 w-2 h-2 bg-gray-400 rounded-full shadow-sm"></div>
                    
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10 mt-2">
                        <div class="w-14 h-14 bg-blue-100/50 rounded-lg flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-flask text-2xl text-blue-500 drop-shadow-sm"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 text-lg mb-2">Certified Labs</h4>
                        <p class="text-sm font-medium text-gray-500 leading-relaxed">Processed at self-owned, NABL & CAP certified laboratories.</p>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="group bg-yellow-50/80 rounded-xl p-6 shadow-xl hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border-[6px] border-white relative overflow-hidden sm:-rotate-2 mt-0 sm:mt-12 z-10 hover:z-20 origin-top">
                    <!-- Hanging String -->
                    <div class="absolute -top-1 left-1/2 -translate-x-1/2 w-0.5 h-4 bg-gray-300"></div>
                    <div class="absolute top-2 left-1/2 -translate-x-1/2 w-2 h-2 bg-gray-400 rounded-full shadow-sm"></div>
                    
                    <div class="absolute inset-0 bg-gradient-to-br from-yellow-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10 mt-2">
                        <div class="w-14 h-14 bg-yellow-100/50 rounded-lg flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-file-invoice text-2xl text-brand-secondary drop-shadow-sm"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 text-lg mb-2">Smart Reports</h4>
                        <p class="text-sm font-medium text-gray-500 leading-relaxed">Easy-to-understand, verified reports by top MD pathologists.</p>
                    </div>
                </div>
            </div>

            <!-- Image Section -->
            <div class="lg:w-1/2 relative group">
                <div class="absolute inset-0 bg-gradient-to-tr from-brand-secondary to-brand-dark rounded-[2.5rem] transform rotate-3 scale-[0.98] opacity-20 group-hover:rotate-6 group-hover:scale-[1.02] transition-all duration-500 ease-out z-0"></div>
                <div class="relative z-10 rounded-[2.5rem] overflow-hidden border-8 border-white shadow-2xl h-[450px]">
                    <img id="why-book-hero-img" src="https://images.unsplash.com/photo-1579154204601-01588f351e67?auto=format&fit=crop&w=1000&q=80" alt="Lab Technician analyzing samples" class="w-full h-full object-cover transform group-hover:scale-110 transition-all duration-700 ease-out">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6">
                        <div class="bg-white/90 backdrop-blur-md p-4 rounded-2xl shadow-lg flex items-center gap-4 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-500">
                            <div class="bg-green-100 text-green-600 w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check-circle text-xl"></i>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 text-sm">NABL & CAP Certified</p>
                                <p class="text-xs text-gray-500 font-medium">Guaranteeing 100% accuracy</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Rotator Script -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const images = [
            "https://images.unsplash.com/photo-1579154204601-01588f351e67?auto=format&fit=crop&w=1000&q=80",
            "https://images.unsplash.com/photo-1581594693702-fbdc51b2763b?auto=format&fit=crop&w=1000&q=80",
            "https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=1000&q=80",
            "https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=1000&q=80"
        ];
        let currentIndex = 0;
        const imgElement = document.getElementById('why-book-hero-img');
        
        if(imgElement) {
            setInterval(() => {
                // Fade out
                imgElement.style.opacity = '0.5';
                
                setTimeout(() => {
                    currentIndex = (currentIndex + 1) % images.length;
                    imgElement.src = images[currentIndex];
                    // Fade in
                    imgElement.style.opacity = '1';
                }, 700); // Wait for CSS transition-all duration-700
            }, 6000);
        }
    });
</script>


    <!-- 5 Simple Steps to Manage Your Health -->
<div class="container mx-auto px-4 py-16 relative">
    <!-- Decorative dashed line connecting steps (hidden on mobile) -->
    <div class="hidden lg:block absolute top-[280px] left-[10%] right-[10%] border-t-2 border-dashed border-gray-300 z-0"></div>

    <div class="text-center mb-12 relative z-10">
        <h2 class="text-3xl md:text-4xl font-extrabold text-brand-dark mb-3">5 Simple Steps to Manage Your Health</h2>
        <p class="text-gray-500 font-medium">Quick, Simple & Convenient; trusted care delivered to your doorstep.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 relative z-10">
        <!-- Step 1 -->
        <div class="group bg-white rounded-3xl p-4 shadow-lg hover:shadow-2xl hover:-translate-y-4 transition-all duration-500 border border-gray-100 flex flex-col items-center text-center relative mt-0 lg:mt-8">
            <div class="w-12 h-12 bg-blue-500 text-white rounded-full flex items-center justify-center font-black text-xl absolute -top-5 shadow-lg shadow-blue-500/40 z-20 group-hover:scale-110 transition-transform duration-300">1</div>
            <div class="w-full h-40 rounded-2xl overflow-hidden mb-5 relative group-hover:ring-4 ring-blue-100 transition-all duration-300">
                <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=500&q=80" alt="Booking" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-out">
                <div class="absolute inset-0 bg-blue-900/10 group-hover:bg-transparent transition-colors duration-300"></div>
            </div>
            <h4 class="font-bold text-gray-800 mb-2">Start Online Booking</h4>
            <p class="text-xs text-gray-500 leading-relaxed pb-2">Select your desired test or package, enter details, and schedule a convenient time slot via our app or website.</p>
        </div>

        <!-- Step 2 -->
        <div class="group bg-white rounded-3xl p-4 shadow-lg hover:shadow-2xl hover:-translate-y-4 transition-all duration-500 border border-gray-100 flex flex-col items-center text-center relative mt-0 lg:-mt-4">
            <div class="w-12 h-12 bg-red-500 text-white rounded-full flex items-center justify-center font-black text-xl absolute -top-5 shadow-lg shadow-red-500/40 z-20 group-hover:scale-110 transition-transform duration-300">2</div>
            <div class="w-full h-40 rounded-2xl overflow-hidden mb-5 relative group-hover:ring-4 ring-red-100 transition-all duration-300">
                <img src="https://images.unsplash.com/photo-1524661135-423995f22d0b?auto=format&fit=crop&w=500&q=80" alt="Live Tracking" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-out">
                <div class="absolute inset-0 bg-red-900/10 group-hover:bg-transparent transition-colors duration-300"></div>
            </div>
            <h4 class="font-bold text-gray-800 mb-2">Live Tracking</h4>
            <p class="text-xs text-gray-500 leading-relaxed pb-2">Stay fully updated with real-time GPS tracking of your phlebotomist for a smooth home collection.</p>
        </div>

        <!-- Step 3 -->
        <div class="group bg-white rounded-3xl p-4 shadow-lg hover:shadow-2xl hover:-translate-y-4 transition-all duration-500 border border-gray-100 flex flex-col items-center text-center relative mt-0 lg:mt-8">
            <div class="w-12 h-12 bg-teal-500 text-white rounded-full flex items-center justify-center font-black text-xl absolute -top-5 shadow-lg shadow-teal-500/40 z-20 group-hover:scale-110 transition-transform duration-300">3</div>
            <div class="w-full h-40 rounded-2xl overflow-hidden mb-5 relative group-hover:ring-4 ring-teal-100 transition-all duration-300">
                <img src="https://images.unsplash.com/photo-1579154204601-01588f351e67?auto=format&fit=crop&w=500&q=80" alt="Sample Collection" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-out">
                <div class="absolute inset-0 bg-teal-900/10 group-hover:bg-transparent transition-colors duration-300"></div>
            </div>
            <h4 class="font-bold text-gray-800 mb-2">Sample Collection</h4>
            <p class="text-xs text-gray-500 leading-relaxed pb-2">Our certified experts ensure a painless, highly hygienic, and fully compliant sample collection process.</p>
        </div>

        <!-- Step 4 -->
        <div class="group bg-white rounded-3xl p-4 shadow-lg hover:shadow-2xl hover:-translate-y-4 transition-all duration-500 border border-gray-100 flex flex-col items-center text-center relative mt-0 lg:-mt-4">
            <div class="w-12 h-12 bg-purple-500 text-white rounded-full flex items-center justify-center font-black text-xl absolute -top-5 shadow-lg shadow-purple-500/40 z-20 group-hover:scale-110 transition-transform duration-300">4</div>
            <div class="w-full h-40 rounded-2xl overflow-hidden mb-5 relative group-hover:ring-4 ring-purple-100 transition-all duration-300">
                <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=500&q=80" alt="Smart Reports" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-out">
                <div class="absolute inset-0 bg-purple-900/10 group-hover:bg-transparent transition-colors duration-300"></div>
            </div>
            <h4 class="font-bold text-gray-800 mb-2">Verified Smart Reports</h4>
            <p class="text-xs text-gray-500 leading-relaxed pb-2">Every report is clinically verified by expert MD doctors and packed with actionable health insights.</p>
        </div>

        <!-- Step 5 -->
        <div class="group bg-white rounded-3xl p-4 shadow-lg hover:shadow-2xl hover:-translate-y-4 transition-all duration-500 border border-gray-100 flex flex-col items-center text-center relative mt-0 lg:mt-8">
            <div class="w-12 h-12 bg-pink-500 text-white rounded-full flex items-center justify-center font-black text-xl absolute -top-5 shadow-lg shadow-pink-500/40 z-20 group-hover:scale-110 transition-transform duration-300">5</div>
            <div class="w-full h-40 rounded-2xl overflow-hidden mb-5 relative group-hover:ring-4 ring-pink-100 transition-all duration-300">
                <img src="https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=500&q=80" alt="Consultation" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-out">
                <div class="absolute inset-0 bg-pink-900/10 group-hover:bg-transparent transition-colors duration-300"></div>
            </div>
            <h4 class="font-bold text-gray-800 mb-2">Health Journey Continues</h4>
            <p class="text-xs text-gray-500 leading-relaxed pb-2">Post-report, easily consult with our expert medical team to plan the next steps for your well-being.</p>
        </div>
    </div>
</div>





    <!-- Health Calculators -->
<style>
@keyframes live-beat {
  0%, 100% { transform: scale(1); }
  15% { transform: scale(1.25); }
  30% { transform: scale(1); }
  45% { transform: scale(1.15); }
}
@keyframes live-rock {
  0%, 100% { transform: rotate(-15deg); }
  50% { transform: rotate(15deg); }
}
@keyframes live-spin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}
@keyframes live-drip {
  0% { transform: translateY(-5px) scaleY(1); opacity: 0; }
  50% { transform: translateY(0) scaleY(1.1); opacity: 1; }
  100% { transform: translateY(5px) scaleY(1); opacity: 0; }
}
.anim-beat { animation: live-beat 1.5s infinite; }
.anim-rock { animation: live-rock 2s infinite ease-in-out; }
.anim-spin { animation: live-spin 5s linear infinite; }
.anim-drip { animation: live-drip 1.5s infinite ease-in; }
</style>

<div class="container mx-auto px-4 py-12">
    <div class="text-center mb-10">
        <h2 class="text-3xl font-extrabold text-brand-dark mb-2">Health Calculators</h2>
        <p class="text-gray-500 font-medium">Use our free tools to track and monitor your health metrics instantly</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        <!-- BMI -->
        <div class="bg-white border border-blue-100 p-6 flex flex-col items-center text-center shadow-lg hover:shadow-2xl transition-all duration-300 rounded-tr-[50px] rounded-bl-[50px] rounded-tl-xl rounded-br-xl group border-b-4 hover:border-b-blue-500">
            <div class="bg-blue-50 w-20 h-20 rounded-tl-full rounded-tr-full rounded-br-full rounded-bl-lg mb-5 flex items-center justify-center text-blue-500 text-3xl shadow-inner relative overflow-hidden group-hover:bg-blue-100 transition">
                <i class="fas fa-weight anim-rock"></i>
            </div>
            <h4 class="font-bold text-gray-800 text-base mb-2">Body Mass Index (BMI)</h4>
            <p class="text-xs text-gray-500 mb-5 leading-relaxed flex-grow">Find out if your weight falls within the ideal range for your height and age instantly.</p>
            <a href="#" class="text-xs font-extrabold text-blue-600 bg-blue-50 px-4 py-2 rounded-full hover:bg-blue-500 hover:text-white transition w-full">Calculate BMI</a>
        </div>

        <!-- Heart Health -->
        <div class="bg-white border border-red-100 p-6 flex flex-col items-center text-center shadow-lg hover:shadow-2xl transition-all duration-300 rounded-tl-[50px] rounded-br-[50px] rounded-tr-xl rounded-bl-xl group border-b-4 hover:border-b-red-500">
            <div class="bg-red-50 w-20 h-20 rounded-tl-full rounded-tr-full rounded-bl-full rounded-br-lg mb-5 flex items-center justify-center text-red-500 text-3xl shadow-inner relative overflow-hidden group-hover:bg-red-100 transition">
                <i class="fas fa-heartbeat anim-beat"></i>
            </div>
            <h4 class="font-bold text-gray-800 text-base mb-2">Cardiovascular Risk</h4>
            <p class="text-xs text-gray-500 mb-5 leading-relaxed flex-grow">Evaluate your heart's overall health and discover early warning signs of cardiac issues.</p>
            <a href="#" class="text-xs font-extrabold text-red-600 bg-red-50 px-4 py-2 rounded-full hover:bg-red-500 hover:text-white transition w-full">Check Heart Health</a>
        </div>

        <!-- Pre-Diabetic -->
        <div class="bg-white border border-teal-100 p-6 flex flex-col items-center text-center shadow-lg hover:shadow-2xl transition-all duration-300 rounded-tr-[50px] rounded-bl-[50px] rounded-tl-xl rounded-br-xl group border-b-4 hover:border-b-teal-500">
            <div class="bg-teal-50 w-20 h-20 rounded-t-full rounded-b-full mb-5 flex items-center justify-center text-teal-500 text-3xl shadow-inner relative overflow-hidden group-hover:bg-teal-100 transition">
                <i class="fas fa-tint anim-drip"></i>
            </div>
            <h4 class="font-bold text-gray-800 text-base mb-2">Diabetes Risk Profiler</h4>
            <p class="text-xs text-gray-500 mb-5 leading-relaxed flex-grow">Identify your chances of pre-diabetes early with our comprehensive symptom checker.</p>
            <a href="#" class="text-xs font-extrabold text-teal-600 bg-teal-50 px-4 py-2 rounded-full hover:bg-teal-500 hover:text-white transition w-full">Evaluate Risk</a>
        </div>

        <!-- Vitamin D -->
        <div class="bg-white border border-yellow-100 p-6 flex flex-col items-center text-center shadow-lg hover:shadow-2xl transition-all duration-300 rounded-tl-[50px] rounded-br-[50px] rounded-tr-xl rounded-bl-xl group border-b-4 hover:border-b-yellow-500">
            <div class="bg-yellow-50 w-20 h-20 rounded-full mb-5 flex items-center justify-center text-yellow-500 text-3xl shadow-inner relative overflow-hidden group-hover:bg-yellow-100 transition">
                <i class="fas fa-sun anim-spin"></i>
            </div>
            <h4 class="font-bold text-gray-800 text-base mb-2">Vitamin Deficiency</h4>
            <p class="text-xs text-gray-500 mb-5 leading-relaxed flex-grow">Check for common signs of Vitamin D & B12 shortages that cause fatigue and bone pain.</p>
            <a href="#" class="text-xs font-extrabold text-yellow-600 bg-yellow-50 px-4 py-2 rounded-full hover:bg-yellow-500 hover:text-white transition w-full">Start Assessment</a>
        </div>
    </div>
</div>


    <!-- Create your Own Package Banner -->
<div class="container mx-auto px-4 py-6">
    <div class="border rounded-2xl flex flex-col md:flex-row items-center justify-between p-6 bg-white shadow-sm overflow-hidden relative">
        <div class="z-10 md:w-1/2">
            <span class="bg-green-100 text-green-700 text-[10px] font-bold px-2 py-1 rounded border border-green-200 mb-3 inline-block flex items-center w-max"><i class="fas fa-cog mr-1"></i> Customise</span>
            <h2 class="text-2xl font-bold text-brand-dark mb-2">Create your Own Package</h2>
            <p class="text-xs text-gray-600 mb-6">Customise your package based on test you choose and get extra 10% OFF</p>
            <button class="bg-brand-dark text-white font-bold py-2 px-6 rounded-lg hover:bg-blue-900 transition text-sm shadow flex items-center">
                Create Now <i class="fas fa-arrow-right ml-2"></i>
            </button>
        </div>
        <div class="absolute right-0 top-0 h-full w-1/2 md:w-1/3 opacity-30 md:opacity-100 mix-blend-multiply flex justify-end">
            <!-- Placeholder for Happy Woman Image -->
            <img src="https://via.placeholder.com/400x300/f8f9fa/333333?text=Happy+Woman" alt="Customise Package" class="object-cover h-full w-auto">
        </div>
    </div>
</div>


    <!-- GeneCliffe Section -->
<div class="container mx-auto px-4 py-8">
    <div class="bg-gradient-to-br from-green-50 to-blue-50 rounded-[40px] p-6 md:p-10 flex flex-col md:flex-row items-center gap-8 border border-green-100 shadow-xl overflow-hidden relative">
        <!-- Decorative Background -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-green-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse" style="animation-delay: 2s;"></div>

        <div class="md:w-1/3 relative z-10">
            <h2 class="text-3xl font-extrabold text-brand-dark mb-4 leading-tight">Decode Your DNA for a Healthier Tomorrow</h2>
            <p class="text-sm text-gray-700 mb-6 leading-relaxed">Your genetic blueprint holds the key to proactive healthcare. Discover personalized insights to prevent diseases, optimize your diet, and make informed lifestyle choices.</p>
            <a href="#" class="inline-flex items-center font-bold text-white bg-brand-dark px-6 py-3 rounded-full hover:bg-brand-secondary transition transform hover:scale-105 shadow-lg mb-6">Explore GeneCliffe <i class="fas fa-arrow-right ml-2"></i></a>
        </div>
        
        <div class="md:w-2/3 w-full relative z-10">
            <!-- Slider Container -->
            <div id="gene-slider" class="flex space-x-6 overflow-x-auto hide-scroll-bar py-4 scroll-smooth snap-x snap-mandatory">
                
                <!-- Card 1 -->
                <div class="min-w-[280px] md:min-w-[320px] bg-white rounded-tr-[50px] rounded-bl-[50px] rounded-tl-xl rounded-br-xl shadow-lg border border-gray-100 p-5 flex flex-col h-full snap-center hover:-translate-y-2 transition-transform duration-300">
                    <div class="rounded-tr-[35px] rounded-bl-[35px] rounded-tl-lg rounded-br-lg overflow-hidden mb-5 relative group h-40">
                        <img src="https://images.unsplash.com/photo-1532094349884-543bc11b234d?auto=format&fit=crop&w=400&q=80" alt="Genome Mapping" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-brand-dark/20 group-hover:bg-transparent transition-colors"></div>
                    </div>
                    <div class="flex-grow">
                        <h4 class="font-extrabold text-brand-dark text-lg mb-2">Advanced Genome Mapping</h4>
                        <p class="text-xs text-gray-500 leading-relaxed">Unlock your complete genetic profile to identify silent mutations and understand your body at a cellular level.</p>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button class="w-8 h-8 rounded-full bg-green-100 text-green-700 flex items-center justify-center hover:bg-green-600 hover:text-white transition"><i class="fas fa-arrow-right text-xs"></i></button>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="min-w-[280px] md:min-w-[320px] bg-white rounded-tr-[50px] rounded-bl-[50px] rounded-tl-xl rounded-br-xl shadow-lg border border-gray-100 p-5 flex flex-col h-full snap-center hover:-translate-y-2 transition-transform duration-300">
                    <div class="rounded-tr-[35px] rounded-bl-[35px] rounded-tl-lg rounded-br-lg overflow-hidden mb-5 relative group h-40">
                        <img src="https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=400&q=80" alt="Hereditary Risk" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-brand-dark/20 group-hover:bg-transparent transition-colors"></div>
                    </div>
                    <div class="flex-grow">
                        <h4 class="font-extrabold text-brand-dark text-lg mb-2">Hereditary Risk Profiling</h4>
                        <p class="text-xs text-gray-500 leading-relaxed">Early detection saves lives. Learn if you carry genetic markers for hereditary cancers, cardiac issues, and more.</p>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center hover:bg-blue-600 hover:text-white transition"><i class="fas fa-arrow-right text-xs"></i></button>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="min-w-[280px] md:min-w-[320px] bg-white rounded-tr-[50px] rounded-bl-[50px] rounded-tl-xl rounded-br-xl shadow-lg border border-gray-100 p-5 flex flex-col h-full snap-center hover:-translate-y-2 transition-transform duration-300">
                    <div class="rounded-tr-[35px] rounded-bl-[35px] rounded-tl-lg rounded-br-lg overflow-hidden mb-5 relative group h-40">
                        <img src="https://images.unsplash.com/photo-1581594693702-fbdc51b2763b?auto=format&fit=crop&w=400&q=80" alt="Nutrigenomics" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-brand-dark/20 group-hover:bg-transparent transition-colors"></div>
                    </div>
                    <div class="flex-grow">
                        <h4 class="font-extrabold text-brand-dark text-lg mb-2">Nutrigenomics (Diet & DNA)</h4>
                        <p class="text-xs text-gray-500 leading-relaxed">Stop guessing your diet. Discover exactly which foods your body processes best and which ones to avoid entirely.</p>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button class="w-8 h-8 rounded-full bg-yellow-100 text-yellow-700 flex items-center justify-center hover:bg-yellow-600 hover:text-white transition"><i class="fas fa-arrow-right text-xs"></i></button>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="min-w-[280px] md:min-w-[320px] bg-white rounded-tr-[50px] rounded-bl-[50px] rounded-tl-xl rounded-br-xl shadow-lg border border-gray-100 p-5 flex flex-col h-full snap-center hover:-translate-y-2 transition-transform duration-300">
                    <div class="rounded-tr-[35px] rounded-bl-[35px] rounded-tl-lg rounded-br-lg overflow-hidden mb-5 relative group h-40">
                        <img src="https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=400&q=80" alt="Gut Microbiome" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-brand-dark/20 group-hover:bg-transparent transition-colors"></div>
                    </div>
                    <div class="flex-grow">
                        <h4 class="font-extrabold text-brand-dark text-lg mb-2">Microbiome Analysis</h4>
                        <p class="text-xs text-gray-500 leading-relaxed">Map the millions of bacteria in your gut to resolve chronic digestion issues and boost your immune system organically.</p>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button class="w-8 h-8 rounded-full bg-purple-100 text-purple-700 flex items-center justify-center hover:bg-purple-600 hover:text-white transition"><i class="fas fa-arrow-right text-xs"></i></button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const slider = document.getElementById('gene-slider');
        let scrollAmount = 0;
        
        // Auto rotate every 3 seconds
        setInterval(() => {
            if(slider) {
                // If we've reached the end, scroll back to 0
                if (slider.scrollLeft + slider.clientWidth >= slider.scrollWidth - 10) {
                    slider.scrollTo({ left: 0, behavior: 'smooth' });
                } else {
                    // Scroll by the width of approximately one card
                    slider.scrollBy({ left: 320, behavior: 'smooth' });
                }
            }
        }, 3000);
    });
</script>


    <!-- Family Care Packages -->
<style>
    /* Custom Scrollbar for Slider */
    .slider-scrollbar::-webkit-scrollbar {
        height: 6px;
    }
    .slider-scrollbar::-webkit-scrollbar-track {
        background: #f1f5f9; 
        border-radius: 10px;
    }
    .slider-scrollbar::-webkit-scrollbar-thumb {
        background: #0f766e; /* brand-dark approximation */
        border-radius: 10px;
    }
    .slider-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #dc2626; /* brand-secondary approximation */
    }
</style>

<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-end mb-6">
        <div>
            <h2 class="section-title mb-0">Family Care Packages</h2>
            <p class="text-xs text-gray-500 mt-1">Slide to explore packages for your loved ones</p>
        </div>
        <div class="flex space-x-2">
            <button onclick="document.getElementById('family-slider').scrollBy({left: -340, behavior: 'smooth'})" class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center text-gray-500 hover:text-brand-dark hover:border-brand-dark transition shadow-sm"><i class="fas fa-chevron-left text-xs"></i></button>
            <button onclick="document.getElementById('family-slider').scrollBy({left: 340, behavior: 'smooth'})" class="w-8 h-8 rounded-full bg-brand-dark text-white flex items-center justify-center hover:bg-brand-secondary transition shadow-md"><i class="fas fa-chevron-right text-xs"></i></button>
        </div>
    </div>

    <div id="family-slider" class="flex space-x-6 overflow-x-auto pb-10 pt-4 px-2 snap-x snap-mandatory slider-scrollbar">
        
        <!-- Package 1 -->
        <div class="min-w-[280px] md:min-w-[320px] bg-white rounded-b-[30px] border-x-2 border-b-2 border-gray-800 mt-10 relative snap-center hover:-translate-y-1 transition-transform">
            <!-- Top Teal Band -->
            <div class="absolute -top-10 -left-[2px] -right-[2px] h-10 bg-brand-dark rounded-t-[30px]"></div>
            
            <!-- Circular Image Overlap -->
            <div class="absolute -bottom-6 right-8 w-16 h-16 rounded-full border-[6px] border-white bg-white shadow-md overflow-hidden z-10 flex items-center justify-center">
                <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=100&q=80" alt="Mother" class="w-full h-full object-cover">
            </div>
            
            <div class="p-6">
                <h3 class="font-extrabold text-brand-dark text-xl mb-3 leading-tight pt-1">Free HsCRP With Annual Health Checkup</h3>
                <p class="text-xs text-gray-500 mb-6 leading-relaxed">Comprehensive testing specifically tailored for maternal health and holistic wellness.</p>
                
                <div class="flex items-center mb-2">
                    <span class="text-2xl font-black text-brand-secondary">₹1,799/-</span>
                </div>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Recommended For: <span class="text-brand-dark">Mothers</span></p>
            </div>
        </div>

        <!-- Package 2 -->
        <div class="min-w-[280px] md:min-w-[320px] bg-white rounded-b-[30px] border-x-2 border-b-2 border-gray-800 mt-10 relative snap-center hover:-translate-y-1 transition-transform">
            <!-- Top Teal Band -->
            <div class="absolute -top-10 -left-[2px] -right-[2px] h-10 bg-brand-dark rounded-t-[30px]"></div>
            
            <!-- Circular Image Overlap -->
            <div class="absolute -bottom-6 right-8 w-16 h-16 rounded-full border-[6px] border-white bg-white shadow-md overflow-hidden z-10 flex items-center justify-center">
                <img src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?auto=format&fit=crop&w=100&q=80" alt="Father" class="w-full h-full object-cover">
            </div>
            
            <div class="p-6">
                <h3 class="font-extrabold text-brand-dark text-xl mb-3 leading-tight pt-1">Annual Health Checkup - Advance Plus</h3>
                <p class="text-xs text-gray-500 mb-6 leading-relaxed">Includes a free HsCRP test. Vital heart and body profiling for complete peace of mind.</p>
                
                <div class="flex items-center mb-2">
                    <span class="text-2xl font-black text-brand-secondary">₹2,499/-</span>
                </div>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Recommended For: <span class="text-brand-dark">Fathers</span></p>
            </div>
        </div>

        <!-- Package 3 -->
        <div class="min-w-[280px] md:min-w-[320px] bg-white rounded-b-[30px] border-x-2 border-b-2 border-gray-800 mt-10 relative snap-center hover:-translate-y-1 transition-transform">
            <!-- Top Teal Band -->
            <div class="absolute -top-10 -left-[2px] -right-[2px] h-10 bg-brand-dark rounded-t-[30px]"></div>
            
            <!-- Circular Image Overlap -->
            <div class="absolute -bottom-6 right-8 w-16 h-16 rounded-full border-[6px] border-white bg-white shadow-md overflow-hidden z-10 flex items-center justify-center">
                <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=100&q=80" alt="Women" class="w-full h-full object-cover">
            </div>
            
            <div class="p-6">
                <h3 class="font-extrabold text-brand-dark text-xl mb-3 leading-tight pt-1">Fit India Full Body Checkup + Vit B12</h3>
                <p class="text-xs text-gray-500 mb-6 leading-relaxed">Advanced screening to uncover hidden deficiencies and ensure peak performance.</p>
                
                <div class="flex items-center mb-2">
                    <span class="text-2xl font-black text-brand-secondary">₹1,399/-</span>
                </div>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Recommended For: <span class="text-brand-dark">Women</span></p>
            </div>
        </div>
        
    </div>
</div>




    <style>
        @keyframes marquee {
            0% { transform: translateX(0%); }
            100% { transform: translateX(-50%); }
        }
        .marquee-container {
            overflow: hidden;
            width: 100%;
            position: relative;
        }
        /* Optional fade effect on edges */
        .marquee-container::before, .marquee-container::after {
            content: "";
            position: absolute;
            top: 0;
            width: 100px;
            height: 100%;
            z-index: 2;
            pointer-events: none;
        }
        .marquee-container::before {
            left: 0;
            background: linear-gradient(to right, white, transparent);
        }
        .marquee-container::after {
            right: 0;
            background: linear-gradient(to left, white, transparent);
        }
        
        .marquee-track {
            display: inline-flex;
            width: max-content;
            animation: marquee 35s linear infinite;
        }
        .marquee-track:hover {
            animation-play-state: paused;
        }
        .marquee-track-reverse {
            display: inline-flex;
            width: max-content;
            animation: marquee 35s linear infinite reverse;
        }
        .marquee-track-reverse:hover {
            animation-play-state: paused;
        }
    </style>

    <!-- Why Millions Trust Av Wellcare Diagnostics -->
<div class="container mx-auto px-4 py-12 overflow-hidden">
    <div class="text-center mb-10">
        <h2 class="section-title mb-2 text-3xl">Why Millions Trust Av Wellcare</h2>
        <p class="text-sm text-gray-500">Real stories from our valued patients</p>
    </div>

    <div class="marquee-container mb-12 pb-4">
        <div class="marquee-track">
            <!-- Patient Cards Set 1 -->
            <div class="min-w-[300px] max-w-[300px] md:min-w-[400px] md:max-w-[400px] bg-teal-50 rounded-[20px] p-6 mx-3 shadow-sm border border-teal-100 flex flex-col whitespace-normal transition-transform transform hover:-translate-y-2">
                <i class="fas fa-quote-left text-teal-200 text-3xl mb-3"></i>
                <p class="text-sm text-gray-700 mb-4 italic leading-relaxed flex-grow font-medium">"The home collection service was incredibly prompt and professional. I got my reports on WhatsApp the very same day. Highly recommended!"</p>
                <div class="flex items-center mt-auto">
                    <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=100&q=80" alt="Patient" class="w-12 h-12 rounded-full mr-3 border-2 border-brand-dark p-0.5 object-cover">
                    <div>
                        <h4 class="font-bold text-brand-dark text-sm">Sunita R.</h4>
                        <p class="text-[10px] text-teal-700 font-semibold uppercase tracking-wider"><i class="fas fa-check-circle mr-1"></i>Verified Patient</p>
                    </div>
                </div>
            </div>

            <div class="min-w-[300px] max-w-[300px] md:min-w-[400px] md:max-w-[400px] bg-teal-50 rounded-[20px] p-6 mx-3 shadow-sm border border-teal-100 flex flex-col whitespace-normal transition-transform transform hover:-translate-y-2">
                <i class="fas fa-quote-left text-teal-200 text-3xl mb-3"></i>
                <p class="text-sm text-gray-700 mb-4 italic leading-relaxed flex-grow font-medium">"I booked the Fit India package for my parents. The phlebotomist was very patient, and the reports were detailed and easy to understand."</p>
                <div class="flex items-center mt-auto">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=100&q=80" alt="Patient" class="w-12 h-12 rounded-full mr-3 border-2 border-brand-dark p-0.5 object-cover">
                    <div>
                        <h4 class="font-bold text-brand-dark text-sm">Vikram S.</h4>
                        <p class="text-[10px] text-teal-700 font-semibold uppercase tracking-wider"><i class="fas fa-check-circle mr-1"></i>Verified Patient</p>
                    </div>
                </div>
            </div>

            <div class="min-w-[300px] max-w-[300px] md:min-w-[400px] md:max-w-[400px] bg-teal-50 rounded-[20px] p-6 mx-3 shadow-sm border border-teal-100 flex flex-col whitespace-normal transition-transform transform hover:-translate-y-2">
                <i class="fas fa-quote-left text-teal-200 text-3xl mb-3"></i>
                <p class="text-sm text-gray-700 mb-4 italic leading-relaxed flex-grow font-medium">"Their molecular diagnostics lab is top-notch. I needed urgent allergy testing and Av Wellcare delivered accurate results flawlessly."</p>
                <div class="flex items-center mt-auto">
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=100&q=80" alt="Patient" class="w-12 h-12 rounded-full mr-3 border-2 border-brand-dark p-0.5 object-cover">
                    <div>
                        <h4 class="font-bold text-brand-dark text-sm">Anjali M.</h4>
                        <p class="text-[10px] text-teal-700 font-semibold uppercase tracking-wider"><i class="fas fa-check-circle mr-1"></i>Verified Patient</p>
                    </div>
                </div>
            </div>
            
            <div class="min-w-[300px] max-w-[300px] md:min-w-[400px] md:max-w-[400px] bg-teal-50 rounded-[20px] p-6 mx-3 shadow-sm border border-teal-100 flex flex-col whitespace-normal transition-transform transform hover:-translate-y-2">
                <i class="fas fa-quote-left text-teal-200 text-3xl mb-3"></i>
                <p class="text-sm text-gray-700 mb-4 italic leading-relaxed flex-grow font-medium">"I appreciate the smart report feature! It highlights exactly what's out of range so I don't have to guess. Very modern clinic."</p>
                <div class="flex items-center mt-auto">
                    <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=100&q=80" alt="Patient" class="w-12 h-12 rounded-full mr-3 border-2 border-brand-dark p-0.5 object-cover">
                    <div>
                        <h4 class="font-bold text-brand-dark text-sm">Rahul K.</h4>
                        <p class="text-[10px] text-teal-700 font-semibold uppercase tracking-wider"><i class="fas fa-check-circle mr-1"></i>Verified Patient</p>
                    </div>
                </div>
            </div>

            <!-- Patient Cards Set 2 (Duplicated for seamless loop) -->
            <div class="min-w-[300px] max-w-[300px] md:min-w-[400px] md:max-w-[400px] bg-teal-50 rounded-[20px] p-6 mx-3 shadow-sm border border-teal-100 flex flex-col whitespace-normal transition-transform transform hover:-translate-y-2">
                <i class="fas fa-quote-left text-teal-200 text-3xl mb-3"></i>
                <p class="text-sm text-gray-700 mb-4 italic leading-relaxed flex-grow font-medium">"The home collection service was incredibly prompt and professional. I got my reports on WhatsApp the very same day. Highly recommended!"</p>
                <div class="flex items-center mt-auto">
                    <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=100&q=80" alt="Patient" class="w-12 h-12 rounded-full mr-3 border-2 border-brand-dark p-0.5 object-cover">
                    <div>
                        <h4 class="font-bold text-brand-dark text-sm">Sunita R.</h4>
                        <p class="text-[10px] text-teal-700 font-semibold uppercase tracking-wider"><i class="fas fa-check-circle mr-1"></i>Verified Patient</p>
                    </div>
                </div>
            </div>

            <div class="min-w-[300px] max-w-[300px] md:min-w-[400px] md:max-w-[400px] bg-teal-50 rounded-[20px] p-6 mx-3 shadow-sm border border-teal-100 flex flex-col whitespace-normal transition-transform transform hover:-translate-y-2">
                <i class="fas fa-quote-left text-teal-200 text-3xl mb-3"></i>
                <p class="text-sm text-gray-700 mb-4 italic leading-relaxed flex-grow font-medium">"I booked the Fit India package for my parents. The phlebotomist was very patient, and the reports were detailed and easy to understand."</p>
                <div class="flex items-center mt-auto">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=100&q=80" alt="Patient" class="w-12 h-12 rounded-full mr-3 border-2 border-brand-dark p-0.5 object-cover">
                    <div>
                        <h4 class="font-bold text-brand-dark text-sm">Vikram S.</h4>
                        <p class="text-[10px] text-teal-700 font-semibold uppercase tracking-wider"><i class="fas fa-check-circle mr-1"></i>Verified Patient</p>
                    </div>
                </div>
            </div>

            <div class="min-w-[300px] max-w-[300px] md:min-w-[400px] md:max-w-[400px] bg-teal-50 rounded-[20px] p-6 mx-3 shadow-sm border border-teal-100 flex flex-col whitespace-normal transition-transform transform hover:-translate-y-2">
                <i class="fas fa-quote-left text-teal-200 text-3xl mb-3"></i>
                <p class="text-sm text-gray-700 mb-4 italic leading-relaxed flex-grow font-medium">"Their molecular diagnostics lab is top-notch. I needed urgent allergy testing and Av Wellcare delivered accurate results flawlessly."</p>
                <div class="flex items-center mt-auto">
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=100&q=80" alt="Patient" class="w-12 h-12 rounded-full mr-3 border-2 border-brand-dark p-0.5 object-cover">
                    <div>
                        <h4 class="font-bold text-brand-dark text-sm">Anjali M.</h4>
                        <p class="text-[10px] text-teal-700 font-semibold uppercase tracking-wider"><i class="fas fa-check-circle mr-1"></i>Verified Patient</p>
                    </div>
                </div>
            </div>
            
            <div class="min-w-[300px] max-w-[300px] md:min-w-[400px] md:max-w-[400px] bg-teal-50 rounded-[20px] p-6 mx-3 shadow-sm border border-teal-100 flex flex-col whitespace-normal transition-transform transform hover:-translate-y-2">
                <i class="fas fa-quote-left text-teal-200 text-3xl mb-3"></i>
                <p class="text-sm text-gray-700 mb-4 italic leading-relaxed flex-grow font-medium">"I appreciate the smart report feature! It highlights exactly what's out of range so I don't have to guess. Very modern clinic."</p>
                <div class="flex items-center mt-auto">
                    <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=100&q=80" alt="Patient" class="w-12 h-12 rounded-full mr-3 border-2 border-brand-dark p-0.5 object-cover">
                    <div>
                        <h4 class="font-bold text-brand-dark text-sm">Rahul K.</h4>
                        <p class="text-[10px] text-teal-700 font-semibold uppercase tracking-wider"><i class="fas fa-check-circle mr-1"></i>Verified Patient</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="text-center mb-10 mt-6">
        <h2 class="section-title mb-2 text-3xl">What Doctors Are Saying</h2>
        <p class="text-sm text-gray-500">Trusted by the medical community</p>
    </div>

    <!-- Doctors Marquee (Moving Opposite Direction) -->
    <div class="marquee-container pb-10">
        <div class="marquee-track-reverse">
            <!-- Doctor Cards Set 1 -->
            <div class="min-w-[300px] max-w-[300px] md:min-w-[400px] md:max-w-[400px] bg-red-50 rounded-[20px] p-6 mx-3 shadow-sm border border-red-100 flex flex-col whitespace-normal transition-transform transform hover:-translate-y-2">
                <i class="fas fa-user-md text-red-200 text-3xl mb-3"></i>
                <p class="text-sm text-gray-700 mb-4 italic leading-relaxed flex-grow font-medium">"I always recommend Av Wellcare to my patients because their molecular diagnostics are highly reliable. Accurate testing is the backbone of good treatment."</p>
                <div class="flex items-center mt-auto">
                    <img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=100&q=80" alt="Doctor" class="w-12 h-12 rounded-full mr-3 border-2 border-brand-secondary p-0.5 object-cover">
                    <div>
                        <h4 class="font-bold text-brand-dark text-sm">Dr. Amit Sharma</h4>
                        <p class="text-[10px] text-red-700 font-semibold uppercase tracking-wider">Chief Cardiologist</p>
                    </div>
                </div>
            </div>

            <div class="min-w-[300px] max-w-[300px] md:min-w-[400px] md:max-w-[400px] bg-red-50 rounded-[20px] p-6 mx-3 shadow-sm border border-red-100 flex flex-col whitespace-normal transition-transform transform hover:-translate-y-2">
                <i class="fas fa-user-md text-red-200 text-3xl mb-3"></i>
                <p class="text-sm text-gray-700 mb-4 italic leading-relaxed flex-grow font-medium">"Av Wellcare Diagnostics has been an invaluable partner. Their commitment to using the latest automation technologies ensures zero human error in critical reports."</p>
                <div class="flex items-center mt-auto">
                    <img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=100&q=80" alt="Doctor" class="w-12 h-12 rounded-full mr-3 border-2 border-brand-secondary p-0.5 object-cover">
                    <div>
                        <h4 class="font-bold text-brand-dark text-sm">Dr. Saneesh KV</h4>
                        <p class="text-[10px] text-red-700 font-semibold uppercase tracking-wider">Fetal Medicine Specialist</p>
                    </div>
                </div>
            </div>

            <div class="min-w-[300px] max-w-[300px] md:min-w-[400px] md:max-w-[400px] bg-red-50 rounded-[20px] p-6 mx-3 shadow-sm border border-red-100 flex flex-col whitespace-normal transition-transform transform hover:-translate-y-2">
                <i class="fas fa-user-md text-red-200 text-3xl mb-3"></i>
                <p class="text-sm text-gray-700 mb-4 italic leading-relaxed flex-grow font-medium">"The GeneCliffe genomic testing provided by Av Wellcare allows us to personalize treatments like never before. They are pioneering predictive healthcare."</p>
                <div class="flex items-center mt-auto">
                    <img src="https://images.unsplash.com/photo-1594824432258-f99f36b63795?auto=format&fit=crop&w=100&q=80" alt="Doctor" class="w-12 h-12 rounded-full mr-3 border-2 border-brand-secondary p-0.5 object-cover">
                    <div>
                        <h4 class="font-bold text-brand-dark text-sm">Dr. Priya Menon</h4>
                        <p class="text-[10px] text-red-700 font-semibold uppercase tracking-wider">Genetics & Oncology</p>
                    </div>
                </div>
            </div>

            <!-- Doctor Cards Set 2 (Duplicated for seamless loop) -->
            <div class="min-w-[300px] max-w-[300px] md:min-w-[400px] md:max-w-[400px] bg-red-50 rounded-[20px] p-6 mx-3 shadow-sm border border-red-100 flex flex-col whitespace-normal transition-transform transform hover:-translate-y-2">
                <i class="fas fa-user-md text-red-200 text-3xl mb-3"></i>
                <p class="text-sm text-gray-700 mb-4 italic leading-relaxed flex-grow font-medium">"I always recommend Av Wellcare to my patients because their molecular diagnostics are highly reliable. Accurate testing is the backbone of good treatment."</p>
                <div class="flex items-center mt-auto">
                    <img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=100&q=80" alt="Doctor" class="w-12 h-12 rounded-full mr-3 border-2 border-brand-secondary p-0.5 object-cover">
                    <div>
                        <h4 class="font-bold text-brand-dark text-sm">Dr. Amit Sharma</h4>
                        <p class="text-[10px] text-red-700 font-semibold uppercase tracking-wider">Chief Cardiologist</p>
                    </div>
                </div>
            </div>

            <div class="min-w-[300px] max-w-[300px] md:min-w-[400px] md:max-w-[400px] bg-red-50 rounded-[20px] p-6 mx-3 shadow-sm border border-red-100 flex flex-col whitespace-normal transition-transform transform hover:-translate-y-2">
                <i class="fas fa-user-md text-red-200 text-3xl mb-3"></i>
                <p class="text-sm text-gray-700 mb-4 italic leading-relaxed flex-grow font-medium">"Av Wellcare Diagnostics has been an invaluable partner. Their commitment to using the latest automation technologies ensures zero human error in critical reports."</p>
                <div class="flex items-center mt-auto">
                    <img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=100&q=80" alt="Doctor" class="w-12 h-12 rounded-full mr-3 border-2 border-brand-secondary p-0.5 object-cover">
                    <div>
                        <h4 class="font-bold text-brand-dark text-sm">Dr. Saneesh KV</h4>
                        <p class="text-[10px] text-red-700 font-semibold uppercase tracking-wider">Fetal Medicine Specialist</p>
                    </div>
                </div>
            </div>

            <div class="min-w-[300px] max-w-[300px] md:min-w-[400px] md:max-w-[400px] bg-red-50 rounded-[20px] p-6 mx-3 shadow-sm border border-red-100 flex flex-col whitespace-normal transition-transform transform hover:-translate-y-2">
                <i class="fas fa-user-md text-red-200 text-3xl mb-3"></i>
                <p class="text-sm text-gray-700 mb-4 italic leading-relaxed flex-grow font-medium">"The GeneCliffe genomic testing provided by Av Wellcare allows us to personalize treatments like never before. They are pioneering predictive healthcare."</p>
                <div class="flex items-center mt-auto">
                    <img src="https://images.unsplash.com/photo-1594824432258-f99f36b63795?auto=format&fit=crop&w=100&q=80" alt="Doctor" class="w-12 h-12 rounded-full mr-3 border-2 border-brand-secondary p-0.5 object-cover">
                    <div>
                        <h4 class="font-bold text-brand-dark text-sm">Dr. Priya Menon</h4>
                        <p class="text-[10px] text-red-700 font-semibold uppercase tracking-wider">Genetics & Oncology</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    <!-- Awards & Recognition -->
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-end mb-6">
        <h2 class="section-title mb-0">Awards & Recognition</h2>
        <a href="#" class="text-xs font-bold text-gray-500 hover:text-brand-secondary border-b border-gray-400 border-dashed">View All ></a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Award 1 -->
        <div class="border border-teal-100 rounded-2xl p-4 bg-teal-50 shadow-sm flex justify-between items-center overflow-hidden transition-transform hover:-translate-y-1">
            <div class="w-2/3 pr-2">
                <span class="text-[8px] bg-teal-100 text-teal-800 px-2 py-0.5 rounded uppercase font-bold tracking-wider mb-2 inline-block">Excellence in Diagnostics</span>
                <h4 class="font-bold text-brand-dark text-sm leading-tight mt-1 mb-4">Best Diagnostic Lab<br>of the Year</h4>
                <p class="text-[10px] text-teal-600 font-bold uppercase"><i class="fas fa-trophy mr-1"></i> Healthcare Excellence Awards</p>
            </div>
            <div class="w-1/3 flex justify-end">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-inner border-2 border-teal-100">
                    <i class="fas fa-award text-3xl text-teal-500"></i>
                </div>
            </div>
        </div>
        <!-- Award 2 -->
        <div class="border border-yellow-100 rounded-2xl p-4 bg-yellow-50 shadow-sm flex justify-between items-center overflow-hidden transition-transform hover:-translate-y-1">
            <div class="w-2/3 pr-2 z-10">
                <span class="text-[8px] bg-yellow-200 text-yellow-800 px-2 py-0.5 rounded uppercase font-bold tracking-wider mb-2 inline-block">Patient Safety & Care</span>
                <h4 class="font-bold text-brand-dark text-sm leading-tight mt-1 mb-4">Highest Standards in<br>Patient Safety</h4>
                <p class="text-[10px] text-yellow-600 font-bold uppercase"><i class="fas fa-shield-alt mr-1"></i> National Health Board</p>
            </div>
            <div class="w-1/3 flex justify-end z-10">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-inner border-2 border-yellow-100">
                    <i class="fas fa-medal text-3xl text-yellow-500"></i>
                </div>
            </div>
        </div>
        <!-- Award 3 -->
        <div class="border border-teal-100 rounded-2xl p-4 bg-teal-50 shadow-sm flex justify-between items-center overflow-hidden transition-transform hover:-translate-y-1">
            <div class="w-2/3 pr-2">
                <span class="text-[8px] bg-teal-100 text-teal-800 px-2 py-0.5 rounded uppercase font-bold tracking-wider mb-2 inline-block">Innovation in Tech</span>
                <h4 class="font-bold text-brand-dark text-sm leading-tight mt-1 mb-4">Pioneers in Molecular<br>Diagnostics</h4>
                <p class="text-[10px] text-teal-600 font-bold uppercase"><i class="fas fa-microscope mr-1"></i> Medical Tech Summit</p>
            </div>
            <div class="w-1/3 flex justify-end">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-inner border-2 border-teal-100">
                    <i class="fas fa-certificate text-3xl text-teal-500"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- Slider dots mockup -->
    <div class="flex justify-center mt-6 space-x-1">
        <div class="w-4 h-1 bg-brand-dark rounded-full"></div>
        <div class="w-1 h-1 bg-gray-300 rounded-full"></div>
    </div>
</div>


@endsection
