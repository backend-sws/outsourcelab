@php
    $siteBannerCoupon = \App\Models\Coupon::where('is_active', true)->where('is_banner', true)->latest()->first();
@endphp
@if($siteBannerCoupon)
    @php
        $bannerText = $siteBannerCoupon->banner_text ?: ($siteBannerCoupon->title . ': ' . ($siteBannerCoupon->discount_type === 'percentage' ? $siteBannerCoupon->discount_value . '% OFF' : 'Flat ₹' . number_format($siteBannerCoupon->discount_value) . ' OFF') . ($siteBannerCoupon->min_order_amount > 0 ? ' on bookings above ₹' . number_format($siteBannerCoupon->min_order_amount) : ''));
    @endphp
    <div class="relative w-full overflow-hidden bg-gradient-to-r from-indigo-900 via-purple-900 to-indigo-950 text-white py-2 shadow-inner z-50 coupon-marquee-wrapper border-b border-white/10 select-none cursor-default" title="Hover to pause">
            <style>
                @keyframes couponTickerLTR {
                    0% {
                        transform: translateX(-50%);
                    }
                    100% {
                        transform: translateX(0%);
                    }
                }
                .coupon-marquee-track {
                    display: inline-flex;
                    width: max-content;
                    will-change: transform;
                    animation: couponTickerLTR 35s linear infinite;
                }
                .coupon-marquee-wrapper:hover .coupon-marquee-track {
                    animation-play-state: paused;
                }
                .coupon-ticket-badge {
                    position: relative;
                    background: linear-gradient(135deg, #fef08a 0%, #facc15 50%, #eab308 100%);
                    color: #0f172a;
                    padding: 3px 12px;
                    border-radius: 6px;
                    font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
                    font-weight: 800;
                    letter-spacing: 0.08em;
                    display: inline-flex;
                    align-items: center;
                    gap: 6px;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3), inset 0 0 0 1.5px rgba(255, 255, 255, 0.6);
                    border: 1.5px dashed #854d0e;
                }
                .coupon-ticket-badge::before,
                .coupon-ticket-badge::after {
                    content: '';
                    position: absolute;
                    top: 50%;
                    width: 7px;
                    height: 7px;
                    background: #312e81;
                    border-radius: 50%;
                    transform: translateY(-50%);
                }
                .coupon-ticket-badge::before {
                    left: -4px;
                }
                .coupon-ticket-badge::after {
                    right: -4px;
                }
            </style>

            <div class="coupon-marquee-track">
                <!-- Group 1 -->
                <div class="flex items-center gap-10 pr-10">
                    @for($i = 0; $i < 3; $i++)
                        <div class="inline-flex items-center gap-3">
                            <span class="flex items-center gap-2 text-xs md:text-sm font-semibold tracking-wide text-white drop-shadow-sm">
                                <i class="fas fa-bullhorn text-amber-300"></i>
                                <span>{{ $bannerText }}</span>
                            </span>
                            
                            <!-- Authentic Coupon Ticket (Code Show Only, No Copy Button) -->
                            <div class="coupon-ticket-badge">
                                <i class="fas fa-ticket-alt text-amber-950 text-xs -rotate-12"></i>
                                <span class="text-[9px] font-sans font-bold uppercase tracking-wider text-amber-900">TICKET:</span>
                                <span class="bg-slate-950 text-yellow-300 px-1.5 py-0.5 rounded text-xs font-black tracking-widest">{{ $siteBannerCoupon->code }}</span>
                            </div>

                            <span class="text-amber-400/60 text-xs ml-3">✦</span>
                        </div>
                    @endfor
                </div>

                <!-- Group 2 (Duplicate for 100% seamless infinite loop) -->
                <div class="flex items-center gap-10 pr-10" aria-hidden="true">
                    @for($i = 0; $i < 3; $i++)
                        <div class="inline-flex items-center gap-3">
                            <span class="flex items-center gap-2 text-xs md:text-sm font-semibold tracking-wide text-white drop-shadow-sm">
                                <i class="fas fa-bullhorn text-amber-300"></i>
                                <span>{{ $bannerText }}</span>
                            </span>
                            
                            <!-- Authentic Coupon Ticket (Code Show Only, No Copy Button) -->
                            <div class="coupon-ticket-badge">
                                <i class="fas fa-ticket-alt text-amber-950 text-xs -rotate-12"></i>
                                <span class="text-[9px] font-sans font-bold uppercase tracking-wider text-amber-900">TICKET:</span>
                                <span class="bg-slate-950 text-yellow-300 px-1.5 py-0.5 rounded text-xs font-black tracking-widest">{{ $siteBannerCoupon->code }}</span>
                            </div>

                            <span class="text-amber-400/60 text-xs ml-3">✦</span>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    @endif

    <!-- Top Header -->
    <div class="bg-white py-3 px-4 border-b">
        <div class="container mx-auto flex justify-between items-center text-sm">
            <!-- Brand Logo -->
            <div class="flex items-center space-x-2 md:space-x-4">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="h-12 md:h-16">
                <!-- <div class="flex flex-col sm:flex-row sm:items-center">
                    <span class="text-brand-primary font-extrabold text-lg md:text-2xl tracking-tight leading-tight">Wellcare</span>
                    <span class="text-brand-secondary font-extrabold text-lg md:text-2xl tracking-tight sm:ml-1 leading-tight">Diagnostics</span>
                </div> -->
            </div>
            
            @php
                $loggedInPatient = session('patient_id') ? \App\Models\Patient::find(session('patient_id')) : null;
                $initialCartCount = $loggedInPatient ? count($loggedInPatient->cart ?? []) : 0;
            @endphp
            
            <!-- Actions -->
            <div class="flex items-center space-x-2 md:space-x-4">
                <!-- Desktop Only Options -->
                <div class="hidden lg:flex items-center space-x-3">
                    <a href="{{ route('download.report') }}" class="flex items-center font-medium text-brand-dark hover:text-brand-primary transition px-3 py-2 text-sm rounded-lg hover:bg-gray-50">
                        <i class="fas fa-file-download text-brand-secondary mr-2 text-lg"></i> Download Report
                    </a>
                    <a href="{{ route('lis.login') }}" class="flex items-center font-medium text-brand-dark hover:text-brand-primary transition px-3 py-2 text-sm rounded-lg hover:bg-gray-50">
                        <i class="fas fa-sign-in-alt text-brand-secondary mr-2 text-lg"></i> Login (LIS)
                    </a>
                    <div class="w-px h-6 bg-gray-200 mx-1"></div>
                </div>

                <!-- Cart Button (Responsive) -->
                <button onclick="proceedToCheckout()" class="flex items-center font-semibold lg:border lg:border-gray-200 rounded-full p-2 lg:px-5 lg:py-2 shadow-none lg:shadow-sm hover:lg:shadow-md hover:bg-gray-50 transition text-sm relative">
                    <i class="fas fa-shopping-cart text-gray-500 lg:mr-2 text-xl lg:text-base"></i> 
                    <span class="hidden lg:inline">Cart</span> 
                    <span id="cartCount" class="bg-brand-secondary text-white text-[10px] lg:text-xs rounded-full px-1.5 py-0.5 lg:px-2 lg:ml-1 font-bold absolute lg:static -top-1 -right-1 lg:top-auto lg:right-auto {{ $initialCartCount > 0 ? '' : 'hidden' }}">{{ $initialCartCount }}</span>
                </button>
                
                <!-- Profile Button (Desktop Only) -->
                <div class="hidden lg:block">
                    @if($loggedInPatient)
                        <a href="{{ route('patient.dashboard') }}" class="flex items-center font-semibold border border-brand-secondary rounded-full px-5 py-2 shadow-sm bg-brand-light/10 hover:bg-brand-light/20 transition text-brand-dark text-sm">
                            <i class="far fa-user text-brand-secondary mr-2"></i> {{ explode(' ', $loggedInPatient->name ?? 'Guest')[0] }}
                        </a>
                    @else
                        <button onclick="window.openLoginModal()" class="flex items-center font-semibold border border-gray-200 rounded-full px-5 py-2 shadow-sm hover:shadow-md hover:bg-gray-50 transition text-sm">
                            <i class="far fa-user text-gray-500 mr-2"></i> Profile
                        </button>
                    @endif
                </div>

                <!-- Mobile Menu Hamburger -->
                <button id="mobileMenuBtn" class="lg:hidden text-gray-700 font-bold flex items-center p-2 hover:text-brand-primary transition focus:outline-none">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Navigation (Desktop) -->
    <nav class="bg-white shadow-md sticky top-0 z-40 hidden lg:block border-t border-gray-50">
        <div class="container mx-auto px-4 flex justify-between items-center h-16 relative">
            <!-- Center: Links -->
            <div class="flex items-center space-x-10">
                <a href="/" class="text-brand-dark font-extrabold flex items-center text-base hover:text-brand-secondary transition group">
                    <i class="fas fa-home mr-2 text-brand-secondary group-hover:scale-110 transition-transform"></i> Home
                </a>
                @if($loggedInPatient)
                    <a href="{{ route('patient.bookings') }}" class="text-brand-dark font-extrabold flex items-center text-base hover:text-brand-secondary transition group">
                        <i class="far fa-calendar-check mr-2 text-brand-secondary group-hover:scale-110 transition-transform"></i> My Bookings
                    </a>
                    <a href="{{ route('patient.reports') }}" class="text-brand-dark font-extrabold flex items-center text-base hover:text-brand-secondary transition group">
                        <i class="far fa-file-alt mr-2 text-brand-secondary group-hover:scale-110 transition-transform"></i> My Reports
                    </a>
                @else
                    <button onclick="window.openLoginModal()" class="text-brand-dark font-extrabold flex items-center text-base hover:text-brand-secondary transition group">
                        <i class="far fa-calendar-check mr-2 text-brand-secondary group-hover:scale-110 transition-transform"></i> My Bookings
                    </button>
                    <button onclick="window.openLoginModal()" class="text-brand-dark font-extrabold flex items-center text-base hover:text-brand-secondary transition group">
                        <i class="far fa-file-alt mr-2 text-brand-secondary group-hover:scale-110 transition-transform"></i> My Reports
                    </button>
                @endif
                <a href="/#reviews" class="text-brand-dark font-extrabold flex items-center text-base hover:text-brand-secondary transition group">
                    <i class="fas fa-star mr-2 text-amber-400 group-hover:scale-110 transition-transform"></i> Reviews
                </a>
                <a href="/#contact-enquiry" class="text-brand-dark font-extrabold flex items-center text-base hover:text-brand-secondary transition group">
                    <i class="fas fa-envelope-open-text mr-2 text-teal-600 group-hover:scale-110 transition-transform"></i> Enquiry
                </a>
            </div>

            <!-- Right: Phone -->
            @php
                $helplinePrimary = \App\Models\Setting::get('helpline_primary', '898 898 8787');
                $helplineClean = preg_replace('/[^0-9]/', '', $helplinePrimary);
            @endphp
            <a href="tel:{{ $helplineClean }}" class="font-bold text-brand-dark flex items-center text-lg md:text-xl bg-gradient-to-r from-brand-light/30 to-brand-light/10 px-5 py-2 rounded-full border border-brand-light/50 shadow-sm hover:shadow-md hover:text-brand-secondary transition">
                <div class="bg-brand-secondary w-8 h-8 rounded-full flex items-center justify-center mr-3 shadow-md">
                    <i class="fas fa-phone-alt text-white text-sm animate-pulse"></i>
                </div>
                {{ $helplinePrimary }}
            </a>
        </div>
    </nav>

    <!-- Mobile Menu Drawer (Small Screens) -->
    <div id="mobileMenu" class="fixed inset-0 z-50 bg-black/60 hidden opacity-0 transition-opacity duration-300">
        <div class="absolute right-0 top-0 bottom-0 w-[85%] max-w-sm bg-white shadow-2xl transform translate-x-full transition-transform duration-300 flex flex-col" id="mobileMenuDrawer">
            <!-- Drawer Header -->
            <div class="flex justify-between items-center p-5 border-b border-gray-100 bg-gray-50/50">
                <div class="flex items-center space-x-2">
                    <img src="{{ asset('logo.jpeg') }}" alt="Logo" class="h-8">
                    <span class="text-brand-primary font-extrabold text-xl tracking-tight">Wellcare</span>
                </div>
                <button id="closeMobileMenuBtn" class="text-gray-400 hover:text-red-500 p-2 focus:outline-none transition-colors rounded-full hover:bg-red-50">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
            
            <!-- Drawer Content -->
            <div class="flex-1 overflow-y-auto py-5 px-5 flex flex-col gap-6">
                <!-- User Section -->
                <div class="flex flex-col gap-3 pb-5 border-b border-gray-100">
                    @if($loggedInPatient)
                        <div class="mb-2">
                            <p class="text-xs text-gray-500 font-semibold mb-1 uppercase tracking-wider">Logged In As</p>
                            <a href="{{ route('patient.dashboard') }}" class="flex items-center text-brand-dark font-bold text-lg">
                                <div class="bg-brand-light/20 w-10 h-10 rounded-full flex items-center justify-center mr-3 border border-brand-secondary/30 text-brand-secondary">
                                    <i class="far fa-user"></i>
                                </div>
                                {{ $loggedInPatient->name ?? 'Guest' }}
                            </a>
                        </div>
                    @else
                        <button onclick="window.openLoginModal(); closeMobileMenu();" class="flex justify-center items-center bg-brand-secondary text-white font-bold px-4 py-3.5 rounded-xl shadow-md hover:bg-brand-primary transition w-full">
                            <i class="far fa-user mr-2 text-lg"></i> Login / Sign Up
                        </button>
                    @endif
                </div>

                <!-- New Header Options -->
                <div class="flex flex-col gap-2 pb-5 border-b border-gray-100">
                    <p class="text-xs text-gray-400 font-semibold mb-2 uppercase tracking-wider px-2">Services</p>
                    <a href="{{ route('download.report') }}" class="flex items-center text-gray-700 hover:text-brand-primary font-bold p-3 rounded-xl hover:bg-gray-50 transition">
                        <div class="bg-gray-100 w-8 h-8 rounded-full flex items-center justify-center mr-3 text-brand-secondary">
                            <i class="fas fa-file-download"></i>
                        </div>
                        Download Report
                    </a>
                    <a href="{{ route('lis.login') }}" class="flex items-center text-gray-700 hover:text-brand-primary font-bold p-3 rounded-xl hover:bg-gray-50 transition">
                        <div class="bg-gray-100 w-8 h-8 rounded-full flex items-center justify-center mr-3 text-brand-secondary">
                            <i class="fas fa-sign-in-alt"></i>
                        </div>
                        Login (LIS)
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="flex flex-col gap-1 pb-5">
                    <p class="text-xs text-gray-400 font-semibold mb-2 uppercase tracking-wider px-2">Navigation</p>
                    <a href="/" class="flex items-center text-gray-700 hover:text-brand-primary font-bold p-3 rounded-xl hover:bg-brand-light/10 transition">
                        <i class="fas fa-home text-gray-400 w-6 text-center mr-3 text-lg"></i> Home
                    </a>
                    @if($loggedInPatient)
                        <a href="{{ route('patient.bookings') }}" class="flex items-center text-gray-700 hover:text-brand-primary font-bold p-3 rounded-xl hover:bg-brand-light/10 transition">
                            <i class="far fa-calendar-check text-gray-400 w-6 text-center mr-3 text-lg"></i> My Bookings
                        </a>
                        <a href="{{ route('patient.reports') }}" class="flex items-center text-gray-700 hover:text-brand-primary font-bold p-3 rounded-xl hover:bg-brand-light/10 transition">
                            <i class="far fa-file-alt text-gray-400 w-6 text-center mr-3 text-lg"></i> My Reports
                        </a>
                    @else
                        <button onclick="window.openLoginModal(); closeMobileMenu();" class="flex items-center text-gray-700 hover:text-brand-primary font-bold p-3 rounded-xl hover:bg-brand-light/10 transition w-full text-left">
                            <i class="far fa-calendar-check text-gray-400 w-6 text-center mr-3 text-lg"></i> My Bookings
                        </button>
                        <button onclick="window.openLoginModal(); closeMobileMenu();" class="flex items-center text-gray-700 hover:text-brand-primary font-bold p-3 rounded-xl hover:bg-brand-light/10 transition w-full text-left">
                            <i class="far fa-file-alt text-gray-400 w-6 text-center mr-3 text-lg"></i> My Reports
                        </button>
                    @endif
                    <a href="/#reviews" class="flex items-center text-gray-700 hover:text-brand-primary font-bold p-3 rounded-xl hover:bg-brand-light/10 transition">
                        <i class="fas fa-star text-amber-400 w-6 text-center mr-3 text-lg"></i> Reviews
                    </a>
                    <a href="/#contact-enquiry" class="flex items-center text-gray-700 hover:text-brand-primary font-bold p-3 rounded-xl hover:bg-brand-light/10 transition">
                        <i class="fas fa-envelope-open-text text-teal-500 w-6 text-center mr-3 text-lg"></i> Enquiry
                    </a>
                </div>
                
                <!-- Contact Box -->
                <div class="mt-auto bg-gradient-to-br from-brand-primary to-brand-secondary rounded-2xl p-5 text-white text-center shadow-lg relative overflow-hidden">
                    <div class="absolute top-0 right-0 opacity-10">
                        <i class="fas fa-stethoscope text-6xl -mr-4 -mt-4"></i>
                    </div>
                    <p class="text-sm font-medium mb-1 opacity-90 relative z-10">Need Help? Call Us</p>
                    <a href="tel:{{ $helplineClean }}" class="text-2xl font-black flex items-center justify-center gap-2 relative z-10 mt-1 hover:scale-105 transition-transform">
                        <i class="fas fa-phone-alt animate-pulse"></i> {{ $helplinePrimary }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        const mobileMenu = document.getElementById('mobileMenu');
        const mobileMenuDrawer = document.getElementById('mobileMenuDrawer');
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const closeMobileMenuBtn = document.getElementById('closeMobileMenuBtn');

        function openMobileMenu() {
            mobileMenu.classList.remove('hidden');
            // Small delay to allow display:block to apply before animating opacity/transform
            setTimeout(() => {
                mobileMenu.classList.remove('opacity-0');
                mobileMenuDrawer.classList.remove('translate-x-full');
            }, 10);
            document.body.classList.add('overflow-hidden');
        }

        function closeMobileMenu() {
            mobileMenu.classList.add('opacity-0');
            mobileMenuDrawer.classList.add('translate-x-full');
            setTimeout(() => {
                mobileMenu.classList.add('hidden');
            }, 300);
            document.body.classList.remove('overflow-hidden');
        }

        if(mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', openMobileMenu);
        }
        if(closeMobileMenuBtn) {
            closeMobileMenuBtn.addEventListener('click', closeMobileMenu);
        }
        // Close on clicking backdrop
        if(mobileMenu) {
            mobileMenu.addEventListener('click', function(e) {
                if(e.target === mobileMenu) {
                    closeMobileMenu();
                }
            });
        }
    </script>

