@extends('layouts.app')
@section('content')
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


    <!-- Routine Health Checkups -->
<div class="container mx-auto px-4 py-8 flex flex-col md:flex-row gap-6">
    <!-- Men -->
    <div class="bg-white rounded-2xl border border-gray-200 p-6 w-full md:w-1/2 relative">
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
                <img src="https://images.unsplash.com/photo-1566492031516-e3b52cb2e4dc?w=400&h=400&fit=crop" alt="45-60" class="w-full aspect-square object-cover rounded-lg mb-3 shadow-sm group-hover:scale-105 transition-transform duration-300">
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
    <div class="bg-white rounded-2xl border border-gray-200 p-6 w-full md:w-1/2 relative">
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
                <img src="https://images.unsplash.com/photo-1581579186913-4674c57c4333?w=400&h=400&fit=crop" alt="Above 60" class="w-full aspect-square object-cover rounded-lg mb-3 shadow-sm group-hover:scale-105 transition-transform duration-300">
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
                <button class="w-full bg-white/90 backdrop-blur-sm border-2 border-brand-secondary text-brand-secondary hover:bg-gradient-to-r hover:from-brand-dark hover:to-brand-secondary hover:border-transparent hover:text-white font-bold py-2.5 rounded-xl transition-all duration-300 flex items-center justify-center group/btn">
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
                <button class="w-full bg-white/90 backdrop-blur-sm border-2 border-brand-secondary text-brand-secondary hover:bg-gradient-to-r hover:from-brand-dark hover:to-brand-secondary hover:border-transparent hover:text-white font-bold py-2.5 rounded-xl transition-all duration-300 flex items-center justify-center group/btn">
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
                <button class="w-full bg-white/90 backdrop-blur-sm border-2 border-brand-secondary text-brand-secondary hover:bg-gradient-to-r hover:from-brand-dark hover:to-brand-secondary hover:border-transparent hover:text-white font-bold py-2.5 rounded-xl transition-all duration-300 flex items-center justify-center group/btn">
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
                <button class="w-full bg-white/90 backdrop-blur-sm border-2 border-brand-secondary text-brand-secondary hover:bg-gradient-to-r hover:from-brand-dark hover:to-brand-secondary hover:border-transparent hover:text-white font-bold py-2.5 rounded-xl transition-all duration-300 flex items-center justify-center group/btn">
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
<div class="container mx-auto px-4 py-8">
    <h2 class="section-title mb-6">Why Book Tests With Us?</h2>
    <div class="flex flex-col md:flex-row gap-8">
        <div class="md:w-1/2 grid grid-cols-2 gap-4">
            <div class="border rounded-xl p-4 flex flex-col items-start bg-white shadow-sm">
                <div class="bg-pink-50 p-2 rounded-lg mb-3"><i class="fas fa-syringe text-pink-500"></i></div>
                <p class="text-xs font-semibold text-gray-700">One-prick sample collection by trained & experienced experts at home</p>
            </div>
            <div class="border rounded-xl p-4 flex flex-col items-start bg-white shadow-sm">
                <div class="bg-teal-50 p-2 rounded-lg mb-3"><i class="fas fa-temperature-low text-teal-500"></i></div>
                <p class="text-xs font-semibold text-gray-700">Sample Transfer in Temperature-controlled Bags, Maintaining Sample Integrity</p>
            </div>
            <div class="border rounded-xl p-4 flex flex-col items-start bg-white shadow-sm">
                <div class="bg-blue-50 p-2 rounded-lg mb-3"><i class="fas fa-flask text-blue-500"></i></div>
                <p class="text-xs font-semibold text-gray-700">Sample Processing at Self-Owned Certified Laboratories under strict quality protocols</p>
            </div>
            <div class="border rounded-xl p-4 flex flex-col items-start bg-white shadow-sm">
                <div class="bg-yellow-50 p-2 rounded-lg mb-3"><i class="fas fa-file-invoice text-brand-secondary"></i></div>
                <p class="text-xs font-semibold text-gray-700">Smart, Easy-to-understand, verified reports by MD pathologists</p>
            </div>
        </div>
        <div class="md:w-1/2">
            <img src="https://via.placeholder.com/600x400/e2e8f0/475569?text=Lab+Technician" alt="Lab Technician" class="rounded-2xl w-full h-full object-cover shadow-lg">
        </div>
    </div>
</div>


    <!-- 5 Simple Steps to Manage Your Health -->
<div class="container mx-auto px-4 py-8">
    <h2 class="section-title mb-1">5 Simple Steps to Manage Your Health with Av Wellcare Diagnostics</h2>
    <p class="text-xs text-gray-500 mb-6">Quick, Simple & Convenient; trusted care delivered to your doorstep.</p>

    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        <!-- Step 1 -->
        <div class="border rounded-xl overflow-hidden bg-white shadow-sm flex flex-col text-center pb-4">
            <div class="relative h-24 bg-blue-100 flex items-center justify-center mb-4">
                <div class="absolute left-2 top-2 text-4xl font-black text-blue-200/50">STEP<br>1</div>
                <img src="https://via.placeholder.com/150x100?text=Booking" class="w-full h-full object-cover mix-blend-multiply opacity-80">
            </div>
            <h4 class="font-bold text-sm text-gray-800 px-2">Start Your Online Booking</h4>
            <p class="text-[10px] text-gray-500 px-3 mt-2">Open the Av Wellcare Diagnostics website/app, select the test or package and enter your details, schedule the service for your preferred slot.</p>
        </div>
        <!-- Step 2 -->
        <div class="border rounded-xl overflow-hidden bg-white shadow-sm flex flex-col text-center pb-4">
            <div class="relative h-24 bg-red-100 flex items-center justify-center mb-4">
                <div class="absolute left-2 top-2 text-4xl font-black text-red-200/50">STEP<br>2</div>
                <img src="https://via.placeholder.com/150x100?text=Tracking" class="w-full h-full object-cover mix-blend-multiply opacity-80">
            </div>
            <h4 class="font-bold text-sm text-gray-800 px-2">Live Tracking</h4>
            <p class="text-[10px] text-gray-500 px-3 mt-2">Stay updated with real-time tracking for a smooth and timely home sample collection.</p>
        </div>
        <!-- Step 3 -->
        <div class="border rounded-xl overflow-hidden bg-white shadow-sm flex flex-col text-center pb-4">
            <div class="relative h-24 bg-teal-100 flex items-center justify-center mb-4">
                <div class="absolute left-2 top-2 text-4xl font-black text-teal-200/50">STEP<br>3</div>
                <img src="https://via.placeholder.com/150x100?text=Collection" class="w-full h-full object-cover mix-blend-multiply opacity-80">
            </div>
            <h4 class="font-bold text-sm text-gray-800 px-2">Sample Collection</h4>
            <p class="text-[10px] text-gray-500 px-3 mt-2">Our certified experts ensure a smooth, hygienic, and fully compliant sample collection experience.</p>
        </div>
        <!-- Step 4 -->
        <div class="border rounded-xl overflow-hidden bg-white shadow-sm flex flex-col text-center pb-4">
            <div class="relative h-24 bg-purple-100 flex items-center justify-center mb-4">
                <div class="absolute left-2 top-2 text-4xl font-black text-purple-200/50">STEP<br>4</div>
                <img src="https://via.placeholder.com/150x100?text=Report" class="w-full h-full object-cover mix-blend-multiply opacity-80">
            </div>
            <h4 class="font-bold text-sm text-gray-800 px-2">Doctor-Verified Smart Reports</h4>
            <p class="text-[10px] text-gray-500 px-3 mt-2">Every report is clinically checked by expert doctors and shared with smart, actionable insights.</p>
        </div>
        <!-- Step 5 -->
        <div class="border rounded-xl overflow-hidden bg-white shadow-sm flex flex-col text-center pb-4">
            <div class="relative h-24 bg-pink-100 flex items-center justify-center mb-4">
                <div class="absolute left-2 top-2 text-4xl font-black text-pink-200/50">STEP<br>5</div>
                <img src="https://via.placeholder.com/150x100?text=Consult" class="w-full h-full object-cover mix-blend-multiply opacity-80">
            </div>
            <h4 class="font-bold text-sm text-gray-800 px-2">Your Health Journey Continues Post Reports</h4>
            <p class="text-[10px] text-gray-500 px-3 mt-2">Consult with our expert medical team to get actionable insights to improve your health.</p>
        </div>
    </div>
</div>


    <!-- Trusted by Millions -->
<div class="container mx-auto px-4 py-12">
    <div class="flex flex-col md:flex-row gap-8 items-center bg-gray-50 rounded-2xl p-6 border">
        <div class="md:w-1/2 relative rounded-xl overflow-hidden shadow-lg h-64 md:h-80 w-full group">
            <img src="https://via.placeholder.com/800x600?text=Patient+with+Doctor" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/30 flex items-center justify-center">
                <button class="w-16 h-16 bg-white/30 backdrop-blur-sm rounded-full flex items-center justify-center text-white text-2xl hover:bg-white/50 transition group-hover:scale-110"><i class="fas fa-play"></i></button>
            </div>
        </div>
        <div class="md:w-1/2 space-y-4">
            <h2 class="text-3xl font-bold text-brand-dark">Trusted by Millions; <br><span class="text-brand-secondary font-light">Personalized for You</span></h2>
            <p class="text-xs text-gray-500 mb-4 leading-relaxed">At Av Wellcare Diagnostics, we ensure that highly accessible and accurate healthcare is offered across Bharat at an affordable price, "driving India its Right to Quality Diagnostics."</p>

            <ul class="space-y-3">
                <li class="flex items-center text-sm font-semibold text-gray-700">
                    <i class="far fa-check-circle text-brand-secondary mr-3 text-lg"></i> Doctor-Curated Packages for All Age-Groups
                </li>
                <li class="flex items-center text-sm font-semibold text-gray-700">
                    <i class="far fa-check-circle text-brand-secondary mr-3 text-lg"></i> Handle Samples with Family-like Care
                </li>
                <li class="flex items-center text-sm font-semibold text-gray-700">
                    <i class="far fa-check-circle text-brand-secondary mr-3 text-lg"></i> 100% Report Accuracy or Money-Back Guaranteed
                </li>
                <li class="flex items-center text-sm font-semibold text-gray-700">
                    <i class="far fa-check-circle text-brand-secondary mr-3 text-lg"></i> Test, Talk, Track: Care Beyond Reports
                </li>
            </ul>

            <button class="mt-4 bg-brand-secondary text-white font-bold py-3 px-6 rounded-lg hover:bg-red-700 transition uppercase text-xs tracking-wider shadow-md">Book Your Test Today</button>
        </div>
    </div>
</div>


    <!-- Spreading Quality Healthcare -->
<div class="container mx-auto px-4 py-8">
    <h3 class="text-center text-brand-dark font-bold mb-6">Spreading Quality Healthcare Across India</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="border rounded-xl p-4 bg-white shadow-sm flex items-center justify-center space-x-4">
            <div class="bg-orange-50 p-3 rounded-lg"><i class="fas fa-users text-orange-500 text-2xl"></i></div>
            <div>
                <h4 class="font-bold text-gray-800 text-lg leading-tight">1 Crore+</h4>
                <p class="text-[10px] text-gray-500 uppercase tracking-wide">Lives Touched</p>
            </div>
        </div>
        <div class="border rounded-xl p-4 bg-white shadow-sm flex items-center justify-center space-x-4">
            <div class="bg-pink-50 p-3 rounded-lg"><i class="fas fa-map-marker-alt text-pink-500 text-2xl"></i></div>
            <div>
                <h4 class="font-bold text-gray-800 text-lg leading-tight">80+</h4>
                <p class="text-[10px] text-gray-500 uppercase tracking-wide">Self-Owned Certified Labs</p>
            </div>
        </div>
        <div class="border rounded-xl p-4 bg-white shadow-sm flex items-center justify-center space-x-4">
            <div class="bg-blue-50 p-3 rounded-lg"><i class="fas fa-hospital text-blue-500 text-2xl"></i></div>
            <div>
                <h4 class="font-bold text-gray-800 text-lg leading-tight">2,000+</h4>
                <p class="text-[10px] text-gray-500 uppercase tracking-wide">Collection Centres</p>
            </div>
        </div>
        <div class="border rounded-xl p-4 bg-white shadow-sm flex items-center justify-center space-x-4">
            <div class="bg-purple-50 p-3 rounded-lg"><i class="fas fa-user-md text-purple-500 text-2xl"></i></div>
            <div>
                <h4 class="font-bold text-gray-800 text-lg leading-tight">1500+</h4>
                <p class="text-[10px] text-gray-500 uppercase tracking-wide">Trained Phlebotomists</p>
            </div>
        </div>
    </div>
</div>


    <!-- Health Calculators -->
<div class="container mx-auto px-4 py-8">
    <h2 class="section-title mb-1">Health Calculators</h2>
    <p class="text-xs text-gray-500 mb-6">Use our free tools to track and monitor your health metrics instantly</p>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="border rounded-xl p-6 bg-gray-50 flex flex-col items-center text-center shadow-sm hover:shadow-md transition">
            <div class="bg-blue-100 p-4 rounded-full mb-4 text-blue-500 text-2xl"><i class="fas fa-weight"></i></div>
            <h4 class="font-bold text-gray-800 text-sm mb-2">Check BMI</h4>
            <p class="text-[10px] text-gray-500 mb-4 line-clamp-3">Quickly assess if your body weight is in the healthy range.</p>
            <a href="#" class="text-xs font-bold text-brand-secondary mt-auto">Try Now <i class="fas fa-arrow-right ml-1"></i></a>
        </div>
        <div class="border rounded-xl p-6 bg-gray-50 flex flex-col items-center text-center shadow-sm hover:shadow-md transition">
            <div class="bg-red-100 p-4 rounded-full mb-4 text-red-500 text-2xl"><i class="fas fa-heartbeat"></i></div>
            <h4 class="font-bold text-gray-800 text-sm mb-2">Heart Health</h4>
            <p class="text-[10px] text-gray-500 mb-4 line-clamp-3">Calculate your heart's age and assess your cardiovascular health.</p>
            <a href="#" class="text-xs font-bold text-brand-secondary mt-auto">Try Now <i class="fas fa-arrow-right ml-1"></i></a>
        </div>
        <div class="border rounded-xl p-6 bg-gray-50 flex flex-col items-center text-center shadow-sm hover:shadow-md transition">
            <div class="bg-teal-100 p-4 rounded-full mb-4 text-teal-500 text-2xl"><i class="fas fa-tint"></i></div>
            <h4 class="font-bold text-gray-800 text-sm mb-2">Pre-Diabetic</h4>
            <p class="text-[10px] text-gray-500 mb-4 line-clamp-3">Assess your risk of developing diabetes and take proactive steps towards prevention.</p>
            <a href="#" class="text-xs font-bold text-brand-secondary mt-auto">Try Now <i class="fas fa-arrow-right ml-1"></i></a>
        </div>
        <div class="border rounded-xl p-6 bg-gray-50 flex flex-col items-center text-center shadow-sm hover:shadow-md transition">
            <div class="bg-yellow-100 p-4 rounded-full mb-4 text-brand-secondary text-2xl"><i class="fas fa-sun"></i></div>
            <h4 class="font-bold text-gray-800 text-sm mb-2">Vitamin D</h4>
            <p class="text-[10px] text-gray-500 mb-4 line-clamp-3">Find out if you're at risk of Vitamin D deficiency in under a minute.</p>
            <a href="#" class="text-xs font-bold text-brand-secondary mt-auto">Try Now <i class="fas fa-arrow-right ml-1"></i></a>
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
    <div class="bg-gray-50 rounded-2xl p-6 md:p-10 flex flex-col md:flex-row items-center gap-8 border">
        <div class="md:w-1/3">
            <h2 class="text-2xl font-bold text-brand-dark mb-4 leading-tight">Discover the insights encoded in your DNA, Chromosomes and Proteins for a better understanding of your health.</h2>
            <p class="text-xs text-gray-600 mb-6 leading-relaxed">Your genes are unique and carry hidden information that can help you understand your personalized health conditions, choose prevention strategies, initiate or redefine treatment, or make decisions about family planning.</p>
            <a href="#" class="font-bold text-brand-dark text-sm hover:text-brand-secondary flex items-center mb-6">Explore GeneCliffe <i class="fas fa-arrow-right ml-2"></i></a>
            <div class="flex space-x-2">
                <button class="w-8 h-8 rounded-full border border-gray-400 flex items-center justify-center text-gray-500 hover:text-brand-dark hover:border-brand-dark"><i class="fas fa-chevron-left text-xs"></i></button>
                <button class="w-8 h-8 rounded-full border border-gray-400 flex items-center justify-center text-gray-500 hover:text-brand-dark hover:border-brand-dark"><i class="fas fa-chevron-right text-xs"></i></button>
            </div>
        </div>
        <div class="md:w-2/3 flex space-x-4 overflow-x-auto hide-scroll-bar py-4">
            <!-- Gene Card 1 -->
            <div class="min-w-[250px] bg-white rounded-xl shadow-sm border p-4 flex flex-col h-full">
                <img src="https://via.placeholder.com/250x150?text=Kidney" alt="Health" class="w-full h-32 object-cover rounded-lg mb-4">
                <div class="flex-grow">
                    <h4 class="font-bold text-brand-dark text-sm mb-2">Kidney Health</h4>
                    <p class="text-[10px] text-gray-500 line-clamp-3">Identify genetic predisposition to kidney-related issues...</p>
                </div>
                <div class="flex justify-end mt-2">
                    <button class="w-6 h-6 rounded-full bg-brand-dark text-white flex items-center justify-center"><i class="fas fa-chevron-right text-[10px]"></i></button>
                </div>
            </div>
            <!-- Gene Card 2 (Active) -->
            <div class="min-w-[300px] bg-white rounded-xl shadow-md border p-4 flex flex-col h-full transform scale-105 z-10">
                <img src="https://via.placeholder.com/300x150?text=Couple" alt="Health EX" class="w-full h-40 object-cover rounded-lg mb-4">
                <div class="flex-grow">
                    <h4 class="font-bold text-brand-dark text-base mb-2">Health EX</h4>
                    <p class="text-xs text-gray-500 line-clamp-3">Our bodies are intricate; just like machines, they need regular maintenance to run smoothly. HealthEx is a specially curated test by genetic experts...</p>
                </div>
                <div class="flex justify-end mt-2">
                    <button class="w-8 h-8 rounded-full bg-brand-dark text-white flex items-center justify-center"><i class="fas fa-chevron-right text-xs"></i></button>
                </div>
            </div>
            <!-- Gene Card 3 -->
            <div class="min-w-[250px] bg-white rounded-xl shadow-sm border p-4 flex flex-col h-full">
                <img src="https://via.placeholder.com/250x150?text=Gut" alt="GutMicrobiome" class="w-full h-32 object-cover rounded-lg mb-4">
                <div class="flex-grow">
                    <h4 class="font-bold text-brand-dark text-sm mb-2">GutMicrobiome</h4>
                    <p class="text-[10px] text-gray-500 line-clamp-3">Gut Microbiome is unique to individuals based on gender, geography, genetics, lifestyle, and diet...</p>
                </div>
                <div class="flex justify-end mt-2">
                    <button class="w-6 h-6 rounded-full bg-brand-dark text-white flex items-center justify-center"><i class="fas fa-chevron-right text-[10px]"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>


    <!-- Family Care Packages -->
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-end mb-6">
        <h2 class="section-title mb-0">Family Care Packages</h2>
        <div class="flex space-x-2">
            <button class="w-8 h-8 rounded-full border flex items-center justify-center text-gray-400 hover:text-brand-dark hover:border-brand-dark"><i class="fas fa-chevron-left text-xs"></i></button>
            <button class="w-8 h-8 rounded-full bg-brand-dark text-white flex items-center justify-center"><i class="fas fa-chevron-right text-xs"></i></button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Family Banner 1 -->
        <div class="rounded-2xl overflow-hidden relative h-48 bg-green-100 flex items-center">
            <div class="p-6 z-10 w-2/3">
                <h3 class="font-bold text-brand-dark text-lg mb-1 leading-tight">Free HsCRP With Annual Health Checkup</h3>
                <div class="flex items-center mt-2 mb-2">
                    <span class="text-lg font-bold text-gray-800">ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¹1799/-</span>
                </div>
                <p class="text-[10px] text-gray-600 font-semibold mt-4">Recommended For: <span class="text-brand-dark font-bold">Mothers</span></p>
            </div>
            <img src="https://via.placeholder.com/200x200/c6f6d5/276749?text=Mother+Daughter" alt="Mother" class="absolute right-0 bottom-0 h-full w-auto mix-blend-multiply opacity-80">
        </div>

        <!-- Family Banner 2 -->
        <div class="rounded-2xl overflow-hidden relative h-48 bg-purple-100 flex items-center">
            <div class="p-6 z-10 w-2/3">
                <h3 class="font-bold text-brand-dark text-lg mb-1 leading-tight">Annual Health Checkup - Advance Plus with Free HsCRP</h3>
                <div class="flex items-center mt-2 mb-2">
                    <span class="text-lg font-bold text-gray-800">ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¹2499/-</span>
                </div>
                <p class="text-[10px] text-gray-600 font-semibold mt-4">Recommended For: <span class="text-brand-dark font-bold">Fathers</span></p>
            </div>
            <img src="https://via.placeholder.com/200x200/e9d8fd/553c9a?text=Father+Child" alt="Father" class="absolute right-0 bottom-0 h-full w-auto mix-blend-multiply opacity-80">
        </div>

        <!-- Family Banner 3 -->
        <div class="rounded-2xl overflow-hidden relative h-48 bg-yellow-100 flex items-center">
            <div class="p-6 z-10 w-2/3">
                <h3 class="font-bold text-brand-dark text-lg mb-1 leading-tight">Fit India Full Body Checkup with Vitamin B12</h3>
                <div class="flex items-center mt-2 mb-2">
                    <span class="text-lg font-bold text-gray-800">ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¹1399/-</span>
                </div>
                <p class="text-[10px] text-gray-600 font-semibold mt-4">Recommended For: <span class="text-brand-dark font-bold">Women</span></p>
            </div>
            <img src="https://via.placeholder.com/200x200/fefcbf/975a16?text=Woman" alt="Woman" class="absolute right-0 bottom-0 h-full w-auto mix-blend-multiply opacity-80">
        </div>
    </div>
</div>


    <!-- Recently Viewed -->
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-end mb-6">
        <div>
            <h2 class="section-title mb-1">Recently Viewed</h2>
            <p class="text-xs text-gray-500 italic">Chosen by Doctors, Trusted by Patients</p>
        </div>
        <div class="flex space-x-2">
            <button class="w-8 h-8 rounded-full border flex items-center justify-center text-gray-400 hover:text-brand-dark hover:border-brand-dark"><i class="fas fa-chevron-left text-xs"></i></button>
            <button class="w-8 h-8 rounded-full bg-brand-dark text-white flex items-center justify-center"><i class="fas fa-chevron-right text-xs"></i></button>
        </div>
    </div>

    <!-- Re-using the same card style from Top Booked for brevity in cloning layout -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 opacity-70 hover:opacity-100 transition-opacity duration-300">
        <!-- Package Card 1 -->
        <div class="border rounded-2xl p-4 bg-white shadow-sm flex flex-col justify-between grayscale-[30%]">
            <div>
                <span class="bg-blue-100 text-blue-800 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase">Most Booked</span>
                <h3 class="font-bold text-brand-secondary mt-3 mb-1 text-sm leading-tight">Fit India Full Body Checkup With Vitamin Screening...</h3>
                <div class="mt-4 flex items-center text-xs text-gray-500 bg-gray-50 p-2 rounded-lg mb-4">
                    <span>Reports in <strong class="text-gray-700">10 hours</strong></span>
                    <span class="mx-2">|</span>
                    <span>Parameters <strong class="text-gray-700">98</strong></span>
                </div>
            </div>
            <div>
                <div class="flex justify-between items-center mb-1 border-t pt-3">
                    <span class="text-lg font-bold text-gray-800">ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¹1799</span>
                    <button class="bg-gray-200 text-gray-600 text-[10px] font-bold py-1.5 px-3 rounded-xl flex items-center">
                        View
                    </button>
                </div>
            </div>
        </div>
        <!-- Package Card 2 -->
        <div class="border rounded-2xl p-4 bg-white shadow-sm flex flex-col justify-between grayscale-[30%]">
            <div>
                <span class="bg-blue-100 text-blue-800 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase">Most Booked</span>
                <h3 class="font-bold text-brand-secondary mt-3 mb-1 text-sm leading-tight">Advance Plus Full Body Checkup with Free Heart...</h3>
                <div class="mt-4 flex items-center text-xs text-gray-500 bg-gray-50 p-2 rounded-lg mb-4">
                    <span>Reports in <strong class="text-gray-700">10 hours</strong></span>
                    <span class="mx-2">|</span>
                    <span>Parameters <strong class="text-gray-700">100</strong></span>
                </div>
            </div>
            <div>
                <div class="flex justify-between items-center mb-1 border-t pt-3">
                    <span class="text-lg font-bold text-gray-800">ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¹2499</span>
                    <button class="bg-gray-200 text-gray-600 text-[10px] font-bold py-1.5 px-3 rounded-xl flex items-center">
                        View
                    </button>
                </div>
            </div>
        </div>
        <!-- Package Card 3 -->
        <div class="border rounded-2xl p-4 bg-white shadow-sm flex flex-col justify-between grayscale-[30%]">
            <div>
                <h3 class="font-bold text-brand-secondary mt-3 mb-1 text-sm leading-tight">Annual Full Body Checkup - Advance</h3>
                <div class="mt-4 flex items-center text-xs text-gray-500 bg-gray-50 p-2 rounded-lg mb-4">
                    <span>Reports in <strong class="text-gray-700">10 hours</strong></span>
                    <span class="mx-2">|</span>
                    <span>Parameters <strong class="text-gray-700">98</strong></span>
                </div>
            </div>
            <div>
                <div class="flex justify-between items-center mb-1 border-t pt-3">
                    <span class="text-lg font-bold text-gray-800">ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¹1799</span>
                    <button class="bg-gray-200 text-gray-600 text-[10px] font-bold py-1.5 px-3 rounded-xl flex items-center">
                        View
                    </button>
                </div>
            </div>
        </div>
        <!-- Package Card 4 -->
        <div class="border rounded-2xl p-4 bg-white shadow-sm flex flex-col justify-between grayscale-[30%]">
            <div>
                <h3 class="font-bold text-brand-secondary mt-3 mb-1 text-sm leading-tight">One Plus Full Body Checkup with Free...</h3>
                <div class="mt-4 flex items-center text-xs text-gray-500 bg-gray-50 p-2 rounded-lg mb-4">
                    <span>Reports in <strong class="text-gray-700">10 hours</strong></span>
                    <span class="mx-2">|</span>
                    <span>Parameters <strong class="text-gray-700">100</strong></span>
                </div>
            </div>
            <div>
                <div class="flex justify-between items-center mb-1 border-t pt-3">
                    <span class="text-lg font-bold text-gray-800">ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¹3399</span>
                    <button class="bg-gray-200 text-gray-600 text-[10px] font-bold py-1.5 px-3 rounded-xl flex items-center">
                        View
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


    <!-- Why Millions Trust Av Wellcare Diagnostics -->
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-end mb-6">
        <h2 class="section-title mb-0">Why Millions Trust Av Wellcare Diagnostics</h2>
        <div class="flex space-x-2">
            <button class="w-8 h-8 rounded-full border flex items-center justify-center text-gray-400 hover:text-brand-dark hover:border-brand-dark"><i class="fas fa-chevron-left text-xs"></i></button>
            <button class="w-8 h-8 rounded-full bg-brand-dark text-white flex items-center justify-center"><i class="fas fa-chevron-right text-xs"></i></button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Review 1 -->
        <div class="border rounded-2xl p-6 bg-white shadow-sm flex flex-col justify-between h-full">
            <i class="fas fa-quote-left text-blue-100 text-4xl mb-4"></i>
            <p class="text-xs text-gray-600 mb-6 italic leading-relaxed flex-grow">"I recently took the Fit India Full Body Checkup with Vitamin B12 and was impressed with the efficiency. The sample collection was smooth and hygienic. I received the detailed reports within 12 hours, helping me consult my doctor promptly. Great service by Av Wellcare Diagnostics!"</p>
            <div class="flex items-center">
                <img src="https://via.placeholder.com/40" alt="Meera Sharma" class="w-10 h-10 rounded-full mr-3">
                <div>
                    <h4 class="font-bold text-gray-800 text-sm">Meera Sharma</h4>
                    <p class="text-[10px] text-gray-500"><i class="fas fa-map-marker-alt text-teal-500 mr-1"></i> Delhi</p>
                </div>
            </div>
        </div>
        <!-- Review 2 -->
        <div class="border rounded-2xl p-6 bg-white shadow-sm flex flex-col justify-between h-full">
            <i class="fas fa-quote-left text-blue-100 text-4xl mb-4"></i>
            <p class="text-xs text-gray-600 mb-6 italic leading-relaxed flex-grow">"Booking an online appointment for the Fit India Full Body Checkup with Vitamin B12 was easy, and the doorstep service was very convenient. I received accurate results on time, allowing me to manage my health better. Excellent service by Av Wellcare Diagnostics."</p>
            <div class="flex items-center">
                <img src="https://via.placeholder.com/40" alt="Pooja Verma" class="w-10 h-10 rounded-full mr-3">
                <div>
                    <h4 class="font-bold text-gray-800 text-sm">Pooja Verma</h4>
                    <p class="text-[10px] text-gray-500"><i class="fas fa-map-marker-alt text-teal-500 mr-1"></i> Jammu, J&K</p>
                </div>
            </div>
        </div>
        <!-- Review 3 -->
        <div class="border rounded-2xl p-6 bg-white shadow-sm flex flex-col justify-between h-full">
            <i class="fas fa-quote-left text-blue-100 text-4xl mb-4"></i>
            <p class="text-xs text-gray-600 mb-6 italic leading-relaxed flex-grow">"I opted for the Fit India Full Body Checkup with Vitamin B12 and received detailed and understandable reports. The free doctor consultation was a great addition, helping me interpret the results effectively. Thank you, Av Wellcare Diagnostics!"</p>
            <div class="flex items-center">
                <img src="https://via.placeholder.com/40" alt="Raj Patel" class="w-10 h-10 rounded-full mr-3">
                <div>
                    <h4 class="font-bold text-gray-800 text-sm">Raj Patel</h4>
                    <p class="text-[10px] text-gray-500"><i class="fas fa-map-marker-alt text-teal-500 mr-1"></i> Bangalore</p>
                </div>
            </div>
        </div>
    </div>
</div>


    <!-- What Doctors Are Saying -->
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-end mb-6">
        <h2 class="section-title mb-0">What Doctors Are Saying</h2>
        <div class="flex space-x-2">
            <button class="w-8 h-8 rounded-full border flex items-center justify-center text-gray-400 hover:text-brand-dark hover:border-brand-dark"><i class="fas fa-chevron-left text-xs"></i></button>
            <button class="w-8 h-8 rounded-full bg-brand-dark text-white flex items-center justify-center"><i class="fas fa-chevron-right text-xs"></i></button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Doc 1 -->
        <div class="border rounded-2xl p-6 bg-white shadow-sm flex flex-col justify-between h-full">
            <i class="fas fa-quote-left text-brand-dark text-4xl mb-4"></i>
            <p class="text-xs text-gray-600 mb-6 italic leading-relaxed flex-grow">"Av Wellcare Diagnostics delivers exceptional and accurate diagnostic services with a knowledgeable and dedicated team."</p>
            <div class="flex items-center mt-auto">
                <img src="https://via.placeholder.com/50" alt="Doctor" class="w-12 h-12 rounded-full mr-3 border-2 border-brand-secondary p-0.5">
                <div>
                    <h4 class="font-bold text-gray-800 text-sm">Dr. Vykunta Raju K. N</h4>
                    <p class="text-[10px] text-gray-500">Pediatric Neurologist</p>
                    <p class="text-[9px] text-gray-400">Bengaluru</p>
                </div>
            </div>
        </div>
        <!-- Doc 2 -->
        <div class="border rounded-2xl p-6 bg-white shadow-sm flex flex-col justify-between h-full">
            <i class="fas fa-quote-left text-brand-dark text-4xl mb-4"></i>
            <p class="text-xs text-gray-600 mb-6 italic leading-relaxed flex-grow">"Av Wellcare Diagnostics has been an invaluable diagnostic service provider for me and my patients. Their commitment to using the latest technologies and techniques to deliver quality & timely reports is commendable."</p>
            <div class="flex items-center mt-auto">
                <img src="https://via.placeholder.com/50" alt="Doctor" class="w-12 h-12 rounded-full mr-3 border-2 border-brand-secondary p-0.5">
                <div>
                    <h4 class="font-bold text-gray-800 text-sm">Dr. Saneesh KV</h4>
                    <p class="text-[10px] text-gray-500">Fetal Medicine Specialist</p>
                    <p class="text-[9px] text-gray-400">Kerala</p>
                </div>
            </div>
        </div>
        <!-- Doc 3 -->
        <div class="border rounded-2xl p-6 bg-white shadow-sm flex flex-col justify-between h-full">
            <i class="fas fa-quote-left text-brand-dark text-4xl mb-4"></i>
            <p class="text-xs text-gray-600 mb-6 italic leading-relaxed flex-grow">"Av Wellcare Diagnostics is synonymous with trusted healthcare, delivering high-quality diagnostic services on time."</p>
            <div class="flex items-center mt-auto">
                <img src="https://via.placeholder.com/50" alt="Doctor" class="w-12 h-12 rounded-full mr-3 border-2 border-brand-secondary p-0.5">
                <div>
                    <h4 class="font-bold text-gray-800 text-sm">Dr. Chitra Ganesh</h4>
                    <p class="text-[10px] text-gray-500">Fetal Medicine Specialist</p>
                    <p class="text-[9px] text-gray-400">Bengaluru</p>
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
        <div class="border rounded-2xl p-4 bg-white shadow-sm flex justify-between items-center overflow-hidden">
            <div class="w-2/3 pr-2">
                <span class="text-[8px] bg-gray-100 text-gray-600 px-2 py-0.5 rounded uppercase font-bold tracking-wider mb-2 inline-block">Corporate Wellness</span>
                <h4 class="font-bold text-brand-dark text-sm leading-tight mt-1 mb-4">Workplace Wellness<br>Champion</h4>
                <p class="text-[10px] text-gray-400 font-bold uppercase"><i class="fas fa-building mr-1"></i> ET HR</p>
            </div>
            <div class="w-1/3">
                <img src="https://via.placeholder.com/100x120?text=Trophy" alt="Award" class="object-contain h-24">
            </div>
        </div>
        <!-- Award 2 -->
        <div class="border rounded-2xl p-4 bg-blue-900 shadow-sm flex justify-between items-center overflow-hidden text-white relative">
            <div class="w-2/3 pr-2 z-10">
                <span class="text-[8px] bg-white/20 text-white px-2 py-0.5 rounded uppercase font-bold tracking-wider mb-2 inline-block">Healthcare Innovation</span>
                <h4 class="font-bold text-white text-sm leading-tight mt-1 mb-4">Center of Excellence<br>for Women's Health</h4>
                <p class="text-[10px] text-blue-200 font-bold uppercase"><i class="fas fa-newspaper mr-1"></i> Times Internet</p>
            </div>
            <div class="w-1/3 z-10">
                <img src="https://via.placeholder.com/100x120/ffd700/000000?text=Gold+Trophy" alt="Award" class="object-contain h-24">
            </div>
            <!-- Abstract BG shape -->
            <div class="absolute right-0 top-0 h-full w-1/2 bg-blue-800 transform skew-x-12 opacity-50 translate-x-4"></div>
        </div>
        <!-- Award 3 -->
        <div class="border rounded-2xl p-4 bg-white shadow-sm flex justify-between items-center overflow-hidden">
            <div class="w-2/3 pr-2">
                <span class="text-[8px] bg-gray-100 text-gray-600 px-2 py-0.5 rounded uppercase font-bold tracking-wider mb-2 inline-block">AI & Analytics</span>
                <h4 class="font-bold text-brand-dark text-sm leading-tight mt-1 mb-4">Best Use of AI in<br>Healthcare & Lifesciences</h4>
                <p class="text-[10px] text-gray-400 font-bold uppercase"><i class="fas fa-globe mr-1"></i> Financial Express</p>
            </div>
            <div class="w-1/3">
                <img src="https://via.placeholder.com/100x120?text=Plaque" alt="Award" class="object-contain h-24">
            </div>
        </div>
    </div>
    <!-- Slider dots mockup -->
    <div class="flex justify-center mt-6 space-x-1">
        <div class="w-4 h-1 bg-brand-dark rounded-full"></div>
        <div class="w-1 h-1 bg-gray-300 rounded-full"></div>
    </div>
</div>


    <!-- App Download Section -->
<div class="container mx-auto px-4 py-12">
    <div class="bg-white rounded-3xl p-8 md:p-12 shadow-xl border flex flex-col md:flex-row items-center justify-between relative overflow-hidden">
        <!-- Abstract background blob -->
        <div class="absolute -left-20 -top-20 w-64 h-64 bg-red-50 rounded-full opacity-50 blur-3xl"></div>

        <div class="md:w-1/2 z-10">
            <h2 class="text-3xl font-bold text-brand-dark mb-2">Experience all new</h2>
            <h2 class="text-4xl font-bold text-brand-secondary mb-4">Av Wellcare Diagnostics <span class="text-gray-800">App</span></h2>
            <p class="text-sm text-gray-600 mb-6">Download the App for exclusive offers, manage your<br>account and much more, on-the-go.</p>

            <div class="flex items-center space-x-6">
                <img src="https://via.placeholder.com/120x120?text=QR+Code" alt="QR Code" class="border-4 border-white shadow-lg rounded-xl">
                <p class="text-xs font-semibold text-gray-500 max-w-[150px]">Scan QR code to download the Av Wellcare Diagnostics app</p>
            </div>
        </div>

        <div class="md:w-1/2 mt-8 md:mt-0 relative h-[400px] flex justify-center items-center z-10">
            <!-- Phone Mockups -->
            <img src="https://via.placeholder.com/250x500/000/fff?text=Phone+Left" class="absolute -ml-32 transform -rotate-6 scale-90 rounded-3xl shadow-2xl opacity-80" style="z-index: 1;">
            <img src="https://via.placeholder.com/280x560/000/fff?text=Phone+Center" class="absolute z-10 rounded-[40px] shadow-2xl border-4 border-gray-800" style="z-index: 3;">
            <img src="https://via.placeholder.com/250x500/000/fff?text=Phone+Right" class="absolute ml-32 transform rotate-6 scale-90 rounded-3xl shadow-2xl opacity-80" style="z-index: 2;">
        </div>
    </div>
</div>


@endsection
