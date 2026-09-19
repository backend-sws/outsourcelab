<!-- Single Health Checkup Section (Individual Tests Slider Managed by Admin) -->
<section id="single-health-checkup" class="container mx-auto px-4 py-8 scroll-mt-24">
    <!-- Header with Slide Controls -->
    <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-6 gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1.5">
                <span class="px-3 py-0.5 rounded-full text-[11px] font-bold uppercase tracking-wider bg-teal-50 text-teal-700 border border-teal-200">
                    <i class="fas fa-flask-vial mr-1 text-teal-500"></i> Individual Diagnostic Tests
                </span>
            </div>
            <h2 class="section-title mb-1">Single Health Checkup</h2>
            <p class="text-xs text-gray-500 italic">Slide through routine & specialized single pathology tests added and verified by our medical experts</p>
        </div>

        <!-- Slide Navigation Buttons (Age badhane aur side slide karne ke liye) -->
        <div class="flex items-center space-x-3 self-end sm:self-auto">
            <span class="text-xs text-gray-500 font-medium hidden md:inline-block">
                Showing {{ count($singleTests ?? []) }} Active Tests
            </span>
            <div class="flex items-center space-x-2">
                <button type="button" onclick="slideSingleTests(-1)" aria-label="Previous Tests" class="single-tests-prev w-9 h-9 rounded-full border border-gray-200 bg-white flex items-center justify-center text-gray-600 hover:text-brand-dark hover:border-brand-dark hover:bg-gray-50 shadow-sm transition active:scale-95 focus:outline-none" title="Previous Test">
                    <i class="fas fa-chevron-left text-xs"></i>
                </button>
                <button type="button" onclick="slideSingleTests(1)" aria-label="Next Tests" class="single-tests-next w-9 h-9 rounded-full bg-brand-dark hover:bg-teal-800 text-white flex items-center justify-center shadow-md transition active:scale-95 focus:outline-none" title="Next Test">
                    <i class="fas fa-chevron-right text-xs"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Swiper Carousel Container -->
    <div class="swiper singleTestsSwiper overflow-hidden !py-3">
        <div class="swiper-wrapper">
            @forelse($singleTests ?? [] as $test)
                <div class="swiper-slide !h-auto">
                    <div class="bg-white rounded-[2rem] p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 flex flex-col justify-between hover:-translate-y-1 hover:shadow-[0_12px_35px_rgb(0,0,0,0.08)] transition-all duration-300 relative group overflow-hidden h-full">
                        <!-- Top subtle gradient bar on hover -->
                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-teal-500 via-brand-secondary to-indigo-500 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>

                        <div>
                            <!-- Top Category & Specimen Badge -->
                            <div class="flex justify-between items-center mb-3">
                                @php
                                    $testCats = $test->allCategories();
                                @endphp
                                <div class="flex items-center gap-1 flex-wrap max-w-[80%]">
                                    @if($testCats->count() > 0)
                                        @foreach($testCats->take(2) as $tc)
                                            <span class="bg-teal-50 text-teal-700 text-[9px] font-bold px-2 py-0.5 rounded-full border border-teal-200/60 uppercase tracking-wider truncate max-w-[120px]">
                                                {{ $tc->name }}
                                            </span>
                                        @endforeach
                                        @if($testCats->count() > 2)
                                            <span class="text-[9px] text-teal-600 font-bold">+{{ $testCats->count() - 2 }}</span>
                                        @endif
                                    @else
                                        <span class="bg-teal-50 text-teal-700 text-[9px] font-bold px-2 py-0.5 rounded-full border border-teal-200/60 uppercase tracking-wider">
                                            Single Test
                                        </span>
                                    @endif
                                </div>
                                <div class="w-7 h-7 rounded-full bg-teal-50 flex items-center justify-center text-teal-600 text-xs">
                                    <i class="fas fa-vial"></i>
                                </div>
                            </div>

                            <!-- Test Name -->
                            <h3 class="font-bold text-gray-900 text-sm leading-snug mb-3 group-hover:text-teal-700 transition-colors line-clamp-2 min-h-[40px]" title="{{ $test->name }}">
                                <a href="{{ route('test.show', $test->id) }}" class="hover:underline">
                                    {{ $test->name }}
                                </a>
                            </h3>

                            <!-- Turnaround & Collection Row -->
                            <div class="bg-gray-50/80 rounded-xl p-2.5 flex items-center justify-between mb-3 border border-gray-200/60 text-center">
                                <div class="w-1/2 pr-2">
                                    <span class="text-[9px] text-gray-400 uppercase font-semibold block leading-tight">Turnaround</span>
                                    <span class="font-bold text-gray-800 text-[11px] flex items-center justify-center gap-1 mt-0.5">
                                        <i class="fas fa-clock text-amber-500 text-[10px]"></i>
                                        {{ $test->report_delivery_time ?? 'Same Day' }}
                                    </span>
                                </div>
                                <div class="w-px h-6 bg-gray-200"></div>
                                <div class="w-1/2 pl-2">
                                    <span class="text-[9px] text-gray-400 uppercase font-semibold block leading-tight">Sample Type</span>
                                    <span class="font-bold text-emerald-600 text-[11px] flex items-center justify-center gap-1 mt-0.5">
                                        <i class="fas fa-house-medical text-emerald-500 text-[10px]"></i>
                                        {{ $test->home_collection_available ? 'Home Pickup' : 'Lab Visit' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Preparation / Fasting note -->
                            <div class="text-[11px] text-gray-500 mb-4 flex items-center gap-1.5">
                                <i class="fas fa-circle-info text-teal-500 text-xs flex-shrink-0"></i>
                                <span class="truncate" title="{{ $test->preparation_instructions ?? 'Standard Blood Sample' }}">
                                    {{ $test->preparation_instructions ?? 'Standard Sample • Certified Lab' }}
                                </span>
                            </div>
                        </div>

                        <!-- Price & Action Buttons -->
                        <div class="border-t border-gray-100 pt-3 mt-auto">
                            @php
                                $mrp = round($test->price * 1.35);
                            @endphp
                            <div class="flex items-baseline justify-between mb-3">
                                <div>
                                    <div class="flex items-center gap-1.5 mb-0.5">
                                        <span class="text-xs text-gray-400 line-through">₹{{ $mrp }}</span>
                                        <span class="bg-emerald-100 text-emerald-700 text-[9px] font-bold px-1.5 py-0.2 rounded">25% OFF</span>
                                    </div>
                                    <div class="text-2xl font-black text-gray-900 tracking-tight">
                                        ₹{{ number_format($test->price, 0) }}
                                    </div>
                                </div>
                                <span class="text-[9px] text-gray-400 font-semibold uppercase tracking-wider">NABL Lab</span>
                            </div>

                            <div class="grid grid-cols-2 gap-2">
                                <a href="{{ route('test.show', $test->id) }}" class="w-full bg-teal-50 hover:bg-teal-100 text-teal-800 font-bold py-2 rounded-xl transition text-xs flex items-center justify-center gap-1 border border-teal-200/60">
                                    <i class="fas fa-file-waveform text-[10px]"></i> Info
                                </a>
                                <button onclick="addToCart(this)" 
                                    data-id="{{ $test->id }}"
                                    data-type="test"
                                    data-name="{{ $test->name }}"
                                    data-price="{{ $test->price }}"
                                    data-mrp="{{ $mrp }}"
                                    data-params="{{ $test->preparation_instructions ?? 'Single Diagnostic Test' }}"
                                    class="w-full bg-white border-2 border-brand-secondary text-brand-secondary hover:bg-gradient-to-r hover:from-brand-dark hover:to-brand-secondary hover:border-transparent hover:text-white font-bold py-2 rounded-xl transition-all duration-300 flex items-center justify-center group/btn text-xs shadow-sm cursor-pointer">
                                    <i class="fas fa-cart-plus mr-1 group-hover/btn:scale-110 transition-transform"></i> Add
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="swiper-slide !w-full">
                    <div class="bg-white rounded-2xl p-8 border border-gray-100 text-center shadow-sm w-full">
                        <i class="fas fa-vial text-3xl text-gray-300 mb-2"></i>
                        <h4 class="font-bold text-gray-700 text-sm">No Single Tests Available Yet</h4>
                        <p class="text-xs text-gray-400 mt-1 mb-3">Add tests in the admin panel to display them here.</p>
                        <a href="{{ route('admin.tests.create') }}" class="px-4 py-2 rounded-full bg-brand-primary text-white text-xs font-bold inline-block">
                            Add Single Test in Admin
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Single Tests Swiper Initialization Script -->
<script>
    window.singleTestsSwiperInstance = null;

    window.slideSingleTests = function(direction) {
        if (window.singleTestsSwiperInstance && typeof window.singleTestsSwiperInstance.slideNext === 'function') {
            if (direction === 1) {
                window.singleTestsSwiperInstance.slideNext();
            } else {
                window.singleTestsSwiperInstance.slidePrev();
            }
        } else {
            const swiperContainer = document.querySelector('.singleTestsSwiper');
            if (swiperContainer) {
                swiperContainer.scrollBy({ left: direction * 320, behavior: 'smooth' });
            }
        }
    };

    document.addEventListener('DOMContentLoaded', function() {
        function initSingleTestsSwiper() {
            if (typeof Swiper !== 'undefined') {
                window.singleTestsSwiperInstance = new Swiper(".singleTestsSwiper", {
                    slidesPerView: 1.15,
                    spaceBetween: 16,
                    grabCursor: true,
                    navigation: {
                        nextEl: ".single-tests-next",
                        prevEl: ".single-tests-prev",
                    },
                    breakpoints: {
                        540: {
                            slidesPerView: 2,
                            spaceBetween: 16
                        },
                        768: {
                            slidesPerView: 3,
                            spaceBetween: 18
                        },
                        1024: {
                            slidesPerView: 4,
                            spaceBetween: 20
                        }
                    }
                });
            } else {
                setTimeout(initSingleTestsSwiper, 150);
            }
        }
        initSingleTestsSwiper();
    });
</script>
