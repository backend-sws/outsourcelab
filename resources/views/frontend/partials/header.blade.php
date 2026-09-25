@php
    $siteBannerCoupon = \App\Models\Coupon::where('is_active', true)->where('is_banner', true)->latest()->first();
    $helplinePrimary = \App\Models\Setting::get('helpline_primary', '898 898 8787');
    $helplineClean = preg_replace('/[^0-9]/', '', $helplinePrimary);
    $whatsappNumber = \App\Models\Setting::get('whatsapp_number', $helplineClean ?: '8988988787');
    $whatsappClean = preg_replace('/[^0-9]/', '', $whatsappNumber);
    if (strlen($whatsappClean) === 10) {
        $whatsappClean = '91' . $whatsappClean;
    }
    $whatsappUrl = "https://wa.me/{$whatsappClean}?text=" . urlencode("Hello Av Wellcare Diagnostics, I would like to book a test / consultation.");
@endphp
@if($siteBannerCoupon)
    @php
        $bannerText = $siteBannerCoupon->banner_text ?: ($siteBannerCoupon->title . ': ' . ($siteBannerCoupon->discount_type === 'percentage' ? $siteBannerCoupon->discount_value . '% OFF' : 'Flat ₹' . number_format($siteBannerCoupon->discount_value) . ' OFF') . ($siteBannerCoupon->min_order_amount > 0 ? ' on bookings above ₹' . number_format($siteBannerCoupon->min_order_amount) : ''));
    @endphp
    <div class="relative w-full overflow-hidden bg-gradient-to-r from-indigo-900 via-purple-900 to-indigo-950 text-white py-2 shadow-inner z-50 coupon-marquee-wrapper border-b border-white/10 select-none cursor-default" title="Hover to pause">
            <style>
                @keyframes couponTickerRTL {
                    0% {
                        transform: translateX(0%);
                    }
                    100% {
                        transform: translateX(-50%);
                    }
                }
                .coupon-marquee-track {
                    display: inline-flex;
                    width: max-content;
                    will-change: transform;
                    animation: couponTickerRTL 35s linear infinite;
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
                <!-- Mobile Quick Contact Icons (Visible on Mobile Screens) -->
                <div class="flex lg:hidden items-center gap-1.5">
                    <a href="tel:{{ $helplineClean }}" class="w-9 h-9 rounded-full bg-amber-50 text-amber-700 border border-amber-300 flex items-center justify-center shadow-xs active:scale-95 transition" title="Call Helpline {{ $helplinePrimary }}">
                        <i class="fas fa-phone-alt text-xs animate-pulse"></i>
                    </a>
                    <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="w-9 h-9 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-300 flex items-center justify-center shadow-xs active:scale-95 transition" title="Chat on WhatsApp">
                        <i class="fab fa-whatsapp text-lg"></i>
                    </a>
                </div>

                <!-- Desktop Only Options -->
                <div class="hidden lg:flex items-center space-x-3">
                    <a href="{{ route('pharmacy') }}" class="flex items-center font-medium text-brand-dark hover:text-brand-primary transition px-3 py-2 text-sm rounded-lg hover:bg-gray-50 group">
                        <i class="fas fa-prescription-bottle-alt text-emerald-600 mr-2 text-lg group-hover:scale-110 transition-transform"></i> Pharmacy
                        <span class="ml-1.5 px-1.5 py-0.2 rounded-full text-[9px] font-black uppercase tracking-wider bg-amber-100 text-amber-800 border border-amber-200">Soon</span>
                    </a>
                    <a href="{{ route('download.report') }}" class="flex items-center font-medium text-brand-dark hover:text-brand-primary transition px-3 py-2 text-sm rounded-lg hover:bg-gray-50">
                        <i class="fas fa-file-download text-brand-secondary mr-2 text-lg"></i> Download Report
                    </a>
                    @if(config('pathology.sso_enabled', true))
                    <a href="{{ route('lis.login') }}" class="flex items-center font-medium text-brand-dark hover:text-brand-primary transition px-3 py-2 text-sm rounded-lg hover:bg-gray-50">
                        <i class="fas fa-sign-in-alt text-brand-secondary mr-2 text-lg"></i> Login (LIS)
                    </a>
                    @endif
                    <div class="w-px h-6 bg-gray-200 mx-1"></div>
                </div>

                <!-- Cart Button (Responsive) -->
                <button onclick="proceedToCheckout()" class="flex items-center font-semibold lg:border lg:border-gray-200 rounded-full p-2 lg:px-5 lg:py-2 shadow-none lg:shadow-sm hover:lg:shadow-md hover:bg-gray-50 transition text-sm relative">
                    <i class="fas fa-shopping-cart text-gray-500 lg:mr-2 text-xl lg:text-base"></i> 
                    <span class="hidden lg:inline">Cart</span> 
                    <span id="cartCount" class="bg-brand-secondary text-white text-[10px] lg:text-xs rounded-full px-1.5 py-0.5 lg:px-2 lg:ml-1 font-bold absolute lg:static -top-1 -right-1 lg:top-auto lg:right-auto {{ $initialCartCount > 0 ? '' : 'hidden' }}">{{ $initialCartCount }}</span>
                </button>

                @if($loggedInPatient)
                    <!-- Patient Notification Bell & Dropdown -->
                    <div class="relative" id="patientNotifDropdownContainer">
                        <button id="patientNotifBtn" type="button" aria-label="My Notifications" class="relative w-9 h-9 lg:w-10 lg:h-10 rounded-full bg-gray-50 hover:bg-teal-50 border border-gray-200 hover:border-teal-300 flex items-center justify-center text-gray-600 hover:text-teal-700 transition focus:outline-none shadow-xs">
                            <i class="fas fa-bell text-sm"></i>
                            <span id="patientNotifBadge" class="hidden absolute -top-1 -right-1 min-w-[18px] h-[18px] px-1 rounded-full bg-rose-500 text-white text-[9px] font-black flex items-center justify-center ring-2 ring-white shadow-sm animate-pulse">0</span>
                        </button>

                        <!-- Patient Notification Dropdown Menu -->
                        <div id="patientNotifMenu" class="hidden absolute right-0 mt-2 w-80 sm:w-96 rounded-2xl bg-white border border-gray-200 shadow-2xl z-50 overflow-hidden text-left">
                            <!-- Dropdown Header -->
                            <div class="p-3.5 px-4 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-xs text-gray-900">Notifications</span>
                                    <span id="patientNotifHeaderCount" class="hidden px-2 py-0.5 rounded-full text-[10px] font-bold bg-teal-100 text-teal-800">0 Unread</span>
                                </div>
                                <button type="button" onclick="markAllPatientNotifsRead()" class="text-[11px] font-semibold text-teal-600 hover:underline">
                                    Mark all as read
                                </button>
                            </div>

                            <!-- Notification Items List -->
                            <div id="patientNotifList" class="max-h-80 overflow-y-auto divide-y divide-gray-100">
                                <div class="p-6 text-center text-xs text-gray-400">
                                    <i class="fas fa-spinner fa-spin text-teal-500 mb-2 text-base block"></i>
                                    <span>Loading your alerts...</span>
                                </div>
                            </div>

                            <!-- Dropdown Footer -->
                            <div class="p-2.5 bg-gray-50 border-t border-gray-100 text-center">
                                <a href="{{ route('patient.notifications') }}" class="text-xs font-bold text-teal-700 hover:underline flex items-center justify-center gap-1.5 py-1">
                                    <span>View All Notifications</span>
                                    <i class="fas fa-arrow-right text-[10px]"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
                
                <!-- Profile / Login Button (Desktop Only) -->
                <div class="hidden lg:block">
                    @if($loggedInPatient)
                        <a href="{{ route('patient.dashboard') }}" class="flex items-center font-bold border border-brand-secondary rounded-full px-5 py-2 shadow-xs bg-brand-light/20 hover:bg-brand-light/40 transition text-brand-dark text-sm" title="My Profile & Dashboard">
                            <i class="far fa-user text-brand-secondary mr-2"></i> {{ !empty($loggedInPatient->name) ? explode(' ', $loggedInPatient->name)[0] : 'Profile' }}
                        </a>
                    @else
                        <button onclick="window.openLoginModal()" class="flex items-center font-bold border border-gray-200 hover:border-teal-600 rounded-full px-5 py-2 shadow-xs hover:shadow-md hover:bg-teal-50/50 hover:text-teal-800 transition text-sm text-gray-700">
                            <i class="far fa-user text-gray-500 mr-2"></i> Login
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
                <a href="{{ route('home') }}" class="text-brand-dark font-extrabold flex items-center text-base hover:text-brand-secondary transition group">
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
                <a href="{{ route('pharmacy') }}" class="text-brand-dark font-extrabold flex items-center text-base hover:text-brand-secondary transition group">
                    <i class="fas fa-prescription-bottle-alt mr-2 text-emerald-600 group-hover:scale-110 transition-transform"></i> Pharmacy
                    <span class="ml-2 px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-100 text-amber-800 border border-amber-200 shadow-2xs">Coming Soon</span>
                </a>
                <a href="{{ route('home') }}#reviews" class="text-brand-dark font-extrabold flex items-center text-base hover:text-brand-secondary transition group">
                    <i class="fas fa-star mr-2 text-amber-400 group-hover:scale-110 transition-transform"></i> Reviews
                </a>
                <a href="{{ route('home') }}#contact-enquiry" class="text-brand-dark font-extrabold flex items-center text-base hover:text-brand-secondary transition group">
                    <i class="fas fa-envelope-open-text mr-2 text-teal-600 group-hover:scale-110 transition-transform"></i> Enquiry
                </a>
            </div>

            <!-- Right: Phone & WhatsApp Quick Connect -->
            <div class="flex items-center gap-3">
                <!-- Phone Call Button -->
                <a href="tel:{{ $helplineClean }}" class="font-bold text-brand-dark flex items-center text-sm lg:text-base bg-gradient-to-r from-brand-light/40 to-white px-4 py-2 rounded-full border border-teal-200/70 shadow-xs hover:shadow-md hover:text-brand-secondary transition group" title="Call Helpline {{ $helplinePrimary }}">
                    <div class="bg-brand-secondary w-7 h-7 rounded-full flex items-center justify-center mr-2.5 shadow-xs group-hover:scale-105 transition-transform">
                        <i class="fas fa-phone-alt text-white text-xs animate-pulse"></i>
                    </div>
                    <span class="font-black">{{ $helplinePrimary }}</span>
                </a>

                <!-- WhatsApp Quick Redirection Button -->
                <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="font-bold text-emerald-800 flex items-center text-xs lg:text-sm bg-emerald-50 hover:bg-emerald-500 hover:text-white px-4 py-2 rounded-full border border-emerald-300 shadow-xs hover:shadow-md transition-all group" title="Chat on WhatsApp">
                    <div class="bg-emerald-500 group-hover:bg-white w-7 h-7 rounded-full flex items-center justify-center mr-2 shadow-xs transition-colors">
                        <i class="fab fa-whatsapp text-white group-hover:text-emerald-600 text-sm"></i>
                    </div>
                    <span class="font-extrabold tracking-wide">WhatsApp</span>
                </a>
            </div>
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
                    <a href="{{ route('pharmacy') }}" class="flex items-center text-gray-700 hover:text-brand-primary font-bold p-3 rounded-xl hover:bg-gray-50 transition justify-between">
                        <div class="flex items-center">
                            <div class="bg-emerald-50 w-8 h-8 rounded-full flex items-center justify-center mr-3 text-emerald-600">
                                <i class="fas fa-prescription-bottle-alt"></i>
                            </div>
                            <span>Pharmacy</span>
                        </div>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-100 text-amber-800">Coming Soon</span>
                    </a>
                    <a href="{{ route('download.report') }}" class="flex items-center text-gray-700 hover:text-brand-primary font-bold p-3 rounded-xl hover:bg-gray-50 transition">
                        <div class="bg-gray-100 w-8 h-8 rounded-full flex items-center justify-center mr-3 text-brand-secondary">
                            <i class="fas fa-file-download"></i>
                        </div>
                        Download Report
                    </a>
                    @if(config('pathology.sso_enabled', true))
                    <a href="{{ route('lis.login') }}" class="flex items-center text-gray-700 hover:text-brand-primary font-bold p-3 rounded-xl hover:bg-gray-50 transition">
                        <div class="bg-gray-100 w-8 h-8 rounded-full flex items-center justify-center mr-3 text-brand-secondary">
                            <i class="fas fa-sign-in-alt"></i>
                        </div>
                        Login (LIS)
                    </a>
                    @endif
                </div>

                <!-- Navigation Links -->
                <div class="flex flex-col gap-1 pb-5">
                    <p class="text-xs text-gray-400 font-semibold mb-2 uppercase tracking-wider px-2">Navigation</p>
                    <a href="{{ route('home') }}" class="flex items-center text-gray-700 hover:text-brand-primary font-bold p-3 rounded-xl hover:bg-brand-light/10 transition">
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
                    <a href="{{ route('home') }}#reviews" class="flex items-center text-gray-700 hover:text-brand-primary font-bold p-3 rounded-xl hover:bg-brand-light/10 transition">
                        <i class="fas fa-star text-amber-400 w-6 text-center mr-3 text-lg"></i> Reviews
                    </a>
                    <a href="{{ route('home') }}#contact-enquiry" class="flex items-center text-gray-700 hover:text-brand-primary font-bold p-3 rounded-xl hover:bg-brand-light/10 transition">
                        <i class="fas fa-envelope-open-text text-teal-500 w-6 text-center mr-3 text-lg"></i> Enquiry
                    </a>
                </div>
                
                <!-- Contact & WhatsApp Box (Mobile Drawer) -->
                <div class="mt-auto flex flex-col gap-2.5">
                    <a href="tel:{{ $helplineClean }}" class="bg-gradient-to-r from-brand-dark to-teal-950 text-white rounded-2xl p-3.5 flex items-center justify-between shadow-md hover:opacity-95 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-amber-400 text-slate-950 flex items-center justify-center font-bold">
                                <i class="fas fa-phone-alt text-xs animate-pulse"></i>
                            </div>
                            <div class="text-left">
                                <span class="text-[10px] text-teal-200 uppercase font-bold block">24/7 Helpline</span>
                                <span class="text-sm font-black">{{ $helplinePrimary }}</span>
                            </div>
                        </div>
                        <span class="text-xs bg-white/20 px-2.5 py-1 rounded-lg font-bold">Call</span>
                    </a>

                    <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl p-3.5 flex items-center justify-between shadow-md transition">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-white/20 flex items-center justify-center">
                                <i class="fab fa-whatsapp text-lg text-white"></i>
                            </div>
                            <div class="text-left">
                                <span class="text-[10px] text-emerald-100 uppercase font-bold block">Instant Assistance</span>
                                <span class="text-sm font-black">Chat on WhatsApp</span>
                            </div>
                        </div>
                        <span class="text-xs bg-white/20 px-2.5 py-1 rounded-lg font-bold">Chat</span>
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

        @if($loggedInPatient)
        // ── Patient In-App Notifications Bell ──
        const patientNotifBtn = document.getElementById('patientNotifBtn');
        const patientNotifMenu = document.getElementById('patientNotifMenu');
        const patientNotifBadge = document.getElementById('patientNotifBadge');
        const patientNotifHeaderCount = document.getElementById('patientNotifHeaderCount');
        const patientNotifList = document.getElementById('patientNotifList');

        window.loadPatientNotifications = function() {
            fetch("{{ route('patient.notifications.unreadFeed') }}", {
                headers: { 'Accept': 'application/json' }
            })
            .then(res => res.json())
            .then(data => {
                if (data.unread_count > 0) {
                    patientNotifBadge.textContent = data.unread_count > 99 ? '99+' : data.unread_count;
                    patientNotifBadge.classList.remove('hidden');
                    patientNotifHeaderCount.textContent = `${data.unread_count} Unread`;
                    patientNotifHeaderCount.classList.remove('hidden');
                } else {
                    patientNotifBadge.classList.add('hidden');
                    patientNotifHeaderCount.classList.add('hidden');
                }

                if (!data.notifications || data.notifications.length === 0) {
                    patientNotifList.innerHTML = `
                        <div class="p-8 text-center text-xs text-gray-400">
                            <i class="far fa-bell-slash text-2xl text-gray-300 mb-2 block"></i>
                            <span>No notifications yet</span>
                        </div>
                    `;
                    return;
                }

                patientNotifList.innerHTML = data.notifications.map(item => `
                    <div onclick="handlePatientNotifClick(${item.id}, '${item.action_url}')" class="p-3.5 px-4 flex items-start gap-3 hover:bg-gray-50 transition cursor-pointer ${item.is_read ? 'opacity-70' : 'bg-teal-50/50'}">
                        <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0 ${item.badge_class}">
                            <i class="${item.icon} text-xs"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-1">
                                <h5 class="text-xs font-bold text-gray-900 truncate ${item.is_read ? '' : 'text-teal-700'}">${item.title}</h5>
                                ${!item.is_read ? '<span class="w-2 h-2 rounded-full bg-teal-500 flex-shrink-0 animate-pulse"></span>' : ''}
                            </div>
                            <p class="text-[11px] text-gray-500 line-clamp-2 mt-0.5 leading-snug">${item.message}</p>
                            <span class="text-[10px] text-gray-400 mt-1 block">${item.time_ago}</span>
                        </div>
                    </div>
                `).join('');
            })
            .catch(() => {
                patientNotifList.innerHTML = `
                    <div class="p-4 text-center text-xs text-rose-500">
                        Failed to load notifications
                    </div>
                `;
            });
        };

        window.handlePatientNotifClick = function(notifId, actionUrl) {
            fetch(`{{ url('/patient/notifications/mark-read') }}/${notifId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                }
            }).finally(() => {
                if (actionUrl && actionUrl !== '#' && !actionUrl.includes('javascript')) {
                    window.location.href = actionUrl;
                } else {
                    loadPatientNotifications();
                }
            });
        };

        window.markAllPatientNotifsRead = function() {
            fetch("{{ route('patient.notifications.markRead') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                }
            }).then(() => {
                loadPatientNotifications();
            });
        };

        if (patientNotifBtn && patientNotifMenu) {
            patientNotifBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                const isHidden = patientNotifMenu.classList.contains('hidden');
                patientNotifMenu.classList.toggle('hidden', !isHidden);
            });

            document.addEventListener('click', (e) => {
                if (!patientNotifMenu.contains(e.target) && !patientNotifBtn.contains(e.target)) {
                    patientNotifMenu.classList.add('hidden');
                }
            });
        }

        loadPatientNotifications();
        @endif
    </script>

