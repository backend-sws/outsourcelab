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
    <div class="bg-white py-2 sm:py-2.5 px-2.5 sm:px-4 border-b">
        <div class="container mx-auto flex justify-between items-center text-sm gap-2">
            <!-- Brand Logo & City Selector -->
            <div class="flex items-center gap-1.5 min-[360px]:gap-2 sm:gap-3 min-w-0 flex-1">
                @php
                    $headerLogoUrl = \App\Models\Setting::getLogoUrl();
                    $siteName = \App\Models\Setting::get('site_name', 'Av Wellcare Diagnostics');
                    $activeHeaderCities = \App\Models\City::active()->ordered()->get();
                    $defaultHeaderCity = \App\Models\City::getDefaultCity();
                    $selectedHeaderCityId = session('selected_city_id', $defaultHeaderCity?->id);
                    $selectedHeaderCity = $activeHeaderCities->firstWhere('id', $selectedHeaderCityId) ?? $defaultHeaderCity;
                @endphp
                <a href="{{ route('home') }}" class="block flex-shrink-0">
                    <img src="{{ $headerLogoUrl }}" alt="{{ $siteName }}" class="h-8 min-[360px]:h-8.5 sm:h-10 md:h-12 w-auto max-w-[105px] min-[360px]:max-w-[130px] sm:max-w-[170px] md:max-w-none object-contain">
                </a>

                @if($activeHeaderCities->isNotEmpty())
                <!-- City Selector Button (Logo Ke Bagal Me) -->
                <div class="relative flex-shrink-0" id="headerCityDropdownContainer">
                    <button type="button" 
                            id="headerCityDropdownBtn"
                            onclick="toggleHeaderCityDropdown(event)"
                            class="flex items-center gap-1.5 px-2 sm:px-3 py-1.5 rounded-xl border border-teal-200/90 hover:border-teal-500 bg-teal-50/70 hover:bg-teal-100/70 text-slate-800 transition shadow-2xs group cursor-pointer focus:outline-none"
                            title="Select Your City & View Pincodes">
                        <div class="w-5 h-5 rounded-lg bg-teal-600 text-white flex items-center justify-center flex-shrink-0 shadow-2xs group-hover:scale-105 transition-transform text-[10px] sm:text-xs">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="text-left leading-tight">
                            <span class="hidden sm:block text-[8px] font-bold text-teal-700/80 uppercase tracking-wider">City</span>
                            <div class="flex items-center gap-1">
                                <span id="headerSelectedCityName" class="text-xs sm:text-sm font-extrabold text-slate-900 tracking-tight max-w-[65px] min-[360px]:max-w-[85px] sm:max-w-none truncate">
                                    {{ $selectedHeaderCity?->name ?? 'Select City' }}
                                </span>
                                <i class="fas fa-chevron-down text-[9px] text-teal-600 group-hover:text-teal-800 transition-transform duration-200" id="headerCityChevron"></i>
                            </div>
                        </div>
                    </button>

                    <!-- Mobile Backdrop Overlay for City Dropdown -->
                    <div id="headerCityBackdrop" 
                         onclick="toggleHeaderCityDropdown(event)" 
                         class="hidden fixed inset-0 bg-slate-950/60 z-[99] backdrop-blur-xs transition-opacity sm:hidden"></div>

                    <!-- Dropdown Menu / Bottom Sheet Modal -->
                    <div id="headerCityDropdownMenu" 
                         class="hidden fixed inset-x-0 bottom-0 z-[100] w-full max-w-full max-h-[88vh] rounded-t-[28px] sm:rounded-2xl sm:absolute sm:inset-x-auto sm:bottom-auto sm:top-full sm:left-0 sm:mt-2.5 sm:w-[450px] sm:min-w-[420px] sm:max-w-none sm:max-h-[580px] sm:z-50 bg-white shadow-2xl border border-slate-200/90 overflow-hidden text-left flex flex-col">
                        
                        <!-- Mobile Drag Handle Bar -->
                        <div class="pt-2.5 pb-1 flex justify-center sm:hidden bg-gradient-to-r from-teal-700 via-teal-800 to-emerald-800">
                            <span class="w-12 h-1.5 bg-white/35 rounded-full"></span>
                        </div>

                        <!-- Header with Gradient & Glowing Glass Badge -->
                        <div class="px-3.5 sm:px-5 py-3 sm:py-4 bg-gradient-to-r from-teal-700 via-teal-800 to-emerald-800 text-white flex items-center justify-between border-b border-white/10 relative overflow-hidden gap-2">
                            <!-- Background subtle ambient circles -->
                            <div class="absolute -right-6 -top-6 w-24 h-24 rounded-full bg-white/10 blur-xl pointer-events-none"></div>
                            
                            <div class="flex items-center gap-2.5 sm:gap-3 relative z-10 min-w-0 flex-1">
                                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl sm:rounded-2xl bg-white/15 backdrop-blur-md border border-white/20 text-white flex items-center justify-center text-sm sm:text-base shadow-inner flex-shrink-0">
                                    <i class="fas fa-map-marked-alt text-teal-200"></i>
                                </div>
                                <div class="min-w-0">
                                    <h4 class="text-xs sm:text-base font-black text-white tracking-tight truncate">
                                        Select Diagnostic City
                                    </h4>
                                    <p class="text-[10px] sm:text-[11px] text-teal-100/90 font-medium leading-snug truncate">
                                        Serviceable pincodes & sample collection
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-1.5 sm:gap-2 relative z-10 flex-shrink-0">
                                <span class="hidden min-[380px]:inline-flex text-[10px] sm:text-[11px] font-extrabold px-2 sm:px-2.5 py-0.5 sm:py-1 rounded-full bg-white/20 text-teal-50 border border-white/20 shadow-2xs backdrop-blur-xs flex-shrink-0">
                                    {{ $activeHeaderCities->count() }} Cities
                                </span>
                                <button type="button" 
                                        onclick="toggleHeaderCityDropdown(event)" 
                                        class="w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center rounded-full bg-white/20 hover:bg-white/30 text-white active:scale-95 transition flex-shrink-0 border border-white/30"
                                        aria-label="Close City Selector">
                                    <i class="fas fa-times text-xs sm:text-sm"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Search Section with Floating Input & Clear Button -->
                        <div class="p-3 sm:p-4 bg-slate-50/90 border-b border-slate-200/80">
                            <div class="relative">
                                <div class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 rounded bg-teal-50 text-teal-600 flex items-center justify-center text-[10px] pointer-events-none">
                                    <i class="fas fa-search"></i>
                                </div>
                                <input type="text" 
                                       id="headerCitySearchInput" 
                                       oninput="filterHeaderCities(this.value)" 
                                       placeholder="Search by city name, state, or 6-digit pincode..." 
                                       autocomplete="off"
                                       class="w-full pl-9 pr-8 py-2 text-xs sm:text-sm font-semibold bg-white border border-slate-200 hover:border-teal-400 focus:border-teal-600 rounded-xl outline-none focus:ring-4 focus:ring-teal-500/15 transition shadow-2xs text-slate-800 placeholder:text-slate-400 placeholder:font-normal">
                                <button type="button" 
                                        id="headerCityClearSearchBtn"
                                        onclick="clearHeaderCitySearch()" 
                                        class="hidden absolute right-3 top-1/2 -translate-y-1/2 w-5 h-5 rounded-full bg-slate-200 hover:bg-slate-300 text-slate-600 flex items-center justify-center text-[10px] transition"
                                        title="Clear search">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>

                            <!-- Dynamic Pincode Availability Notification Box -->
                            <div id="headerPincodeResultBox" class="hidden mt-3 sm:mt-3.5 mb-2.5 sm:mb-3"></div>

                            <div class="flex items-center justify-between text-[11px] text-slate-500 mt-2 px-1 font-medium">
                                <span>Showing <strong id="headerCityFilteredCount" class="text-teal-700 font-extrabold">{{ $activeHeaderCities->count() }}</strong> serviceable cities</span>
                                <span class="text-emerald-700 font-bold flex items-center gap-1">
                                    <i class="fas fa-check-circle text-[10px]"></i> Free Sample Pickup
                                </span>
                            </div>
                        </div>

                        <!-- List of Cities (Clean, Compact, Pincode-Free Cards) -->
                        <div id="headerCityList" class="flex-1 max-h-[58vh] sm:max-h-80 overflow-y-auto p-3 sm:p-4 space-y-2 overscroll-contain bg-slate-50/40">
                            @foreach($activeHeaderCities as $cItem)
                                @php
                                    $isSelected = ($selectedHeaderCity?->id === $cItem->id);
                                    $cPinList = $cItem->pincode_list;
                                @endphp
                                <div onclick="selectHeaderCity({{ $cItem->id }}, '{{ addslashes($cItem->name) }}')"
                                     class="city-item header-city-option group relative p-3 sm:p-3.5 rounded-2xl transition-all cursor-pointer {{ $isSelected ? 'bg-gradient-to-br from-teal-50/95 via-emerald-50/60 to-white border-2 border-teal-600 shadow-sm ring-2 ring-teal-500/10' : 'bg-white hover:bg-teal-50/40 border border-slate-200/90 hover:border-teal-300 shadow-2xs hover:shadow-xs' }}"
                                     data-city-id="{{ $cItem->id }}"
                                     data-city-name="{{ strtolower($cItem->name) }}"
                                     data-display-name="{{ $cItem->name }}"
                                     data-city-state="{{ strtolower((string)$cItem->state) }}"
                                     data-city-pincodes="{{ implode(' ', $cPinList) }}">
                                    
                                    <!-- City Header Row (Pure City Display) -->
                                    <div class="flex items-center justify-between gap-2">
                                        <div class="flex items-center gap-2.5 flex-wrap min-w-0">
                                            <div class="city-icon-box w-8 h-8 rounded-xl {{ $isSelected ? 'bg-teal-600 text-white' : 'bg-slate-100 text-slate-600 group-hover:bg-teal-50 group-hover:text-teal-600' }} flex items-center justify-center text-xs font-bold transition-colors flex-shrink-0">
                                                <i class="fas fa-city"></i>
                                            </div>
                                            <span class="font-black text-sm sm:text-base text-slate-900 group-hover:text-teal-700 transition-colors block truncate">
                                                {{ $cItem->name }}
                                            </span>
                                            @if($cItem->state)
                                                <span class="text-[10px] font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-md border border-slate-200/70">
                                                    {{ $cItem->state }}
                                                </span>
                                            @endif
                                            @if($cItem->is_default)
                                                <span class="text-[9px] font-black uppercase tracking-wider text-amber-800 bg-amber-100 px-2 py-0.5 rounded-full border border-amber-200 shadow-2xs">
                                                    Default
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Status Badge / Select Action -->
                                        <div class="city-status-box flex-shrink-0">
                                            @if($isSelected)
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black bg-teal-600 text-white shadow-xs">
                                                    <i class="fas fa-check-circle text-xs"></i>
                                                    <span>Selected</span>
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-xl text-xs font-bold text-slate-600 group-hover:text-teal-700 bg-slate-100 group-hover:bg-teal-100/70 border border-slate-200 group-hover:border-teal-300 transition-all">
                                                    <span>Select</span>
                                                    <i class="fas fa-chevron-right text-[10px] group-hover:translate-x-0.5 transition-transform"></i>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <!-- No search results placeholder -->
                            <div id="headerCityEmptyState" class="hidden text-center py-8 px-4 bg-white rounded-2xl border border-dashed border-slate-200">
                                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mx-auto mb-2 text-xl">
                                    <i class="fas fa-search-location"></i>
                                </div>
                                <h5 class="text-sm font-bold text-slate-800">No matching city or pincode found</h5>
                                <p class="text-xs text-slate-500 mt-1">Please try searching with another city name or 6-digit pincode</p>
                                <button type="button" onclick="clearHeaderCitySearch()" class="mt-3 px-3 py-1.5 rounded-xl bg-teal-50 text-teal-700 hover:bg-teal-100 text-xs font-bold border border-teal-200 transition">
                                    Clear Search & View All
                                </button>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="p-3 sm:p-3.5 bg-slate-50 border-t border-slate-200/80 flex items-center justify-between text-xs text-slate-500">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center text-xs flex-shrink-0">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <span class="font-medium text-slate-600">Doorstep sample collection by verified phlebotomists</span>
                            </div>
                            <span class="hidden sm:inline-flex items-center gap-1 text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200">
                                <i class="fas fa-check-circle"></i> NABL Certified
                            </span>
                        </div>

                    </div>
                </div>
                @endif
            </div>
            
            @php
                $loggedInPatient = session('patient_id') ? \App\Models\Patient::find(session('patient_id')) : null;
                $initialCartCount = $loggedInPatient ? count($loggedInPatient->cart ?? []) : 0;
            @endphp
            
            <!-- Actions -->
            <div class="flex items-center gap-1.5 min-[360px]:gap-2 sm:gap-2.5 md:gap-3 flex-shrink-0">
                <!-- Mobile Quick Contact Icons (Hidden on <360px to prevent overflow, helpline available in drawer) -->
                <div class="hidden min-[360px]:flex lg:hidden items-center gap-1.5">
                    <a href="tel:{{ $helplineClean }}" class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-amber-50 text-amber-700 border border-amber-300 flex items-center justify-center shadow-2xs active:scale-95 transition flex-shrink-0" title="Call Helpline {{ $helplinePrimary }}">
                        <i class="fas fa-phone-alt text-[11px] sm:text-xs animate-pulse"></i>
                    </a>
                    <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="hidden min-[420px]:flex sm:flex w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-300 items-center justify-center shadow-2xs active:scale-95 transition flex-shrink-0" title="Chat on WhatsApp">
                        <i class="fab fa-whatsapp text-sm sm:text-base"></i>
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
                <button onclick="proceedToCheckout()" class="flex items-center font-semibold border border-gray-200 rounded-full w-8 h-8 sm:w-9 sm:h-9 lg:w-auto lg:h-auto p-0 lg:px-5 lg:py-2 justify-center shadow-2xs lg:shadow-xs hover:bg-gray-50 transition text-sm relative flex-shrink-0" title="View Cart">
                    <i class="fas fa-shopping-cart text-gray-600 lg:mr-2 text-sm lg:text-base"></i> 
                    <span class="hidden lg:inline">Cart</span> 
                    <span id="cartCount" class="bg-brand-secondary text-white text-[9px] min-[360px]:text-[10px] lg:text-xs rounded-full px-1.5 py-0.2 lg:px-2 lg:ml-1 font-bold absolute lg:static -top-1 -right-1 lg:top-auto lg:right-auto {{ $initialCartCount > 0 ? '' : 'hidden' }}">{{ $initialCartCount }}</span>
                </button>

                @if($loggedInPatient)
                    <!-- Patient Notification Bell & Dropdown -->
                    <div class="relative" id="patientNotifDropdownContainer">
                        <button id="patientNotifBtn" type="button" aria-label="My Notifications" class="relative w-8 h-8 sm:w-9 sm:h-9 lg:w-10 lg:h-10 rounded-full bg-gray-50 hover:bg-teal-50 border border-gray-200 hover:border-teal-300 flex items-center justify-center text-gray-600 hover:text-teal-700 transition focus:outline-none shadow-xs">
                            <i class="fas fa-bell text-xs sm:text-sm"></i>
                            <span id="patientNotifBadge" class="hidden absolute -top-1 -right-1 min-w-[16px] h-[16px] px-1 rounded-full bg-rose-500 text-white text-[8px] font-black flex items-center justify-center ring-2 ring-white shadow-sm animate-pulse">0</span>
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
                <button id="mobileMenuBtn" class="lg:hidden text-slate-700 font-bold flex items-center justify-center w-8 h-8 sm:w-9 sm:h-9 rounded-xl hover:bg-slate-100 hover:text-brand-primary transition focus:outline-none flex-shrink-0" aria-label="Open Navigation Menu">
                    <i class="fas fa-bars text-base sm:text-lg"></i>
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
            <div class="flex justify-between items-center px-5 py-4 border-b border-gray-100 bg-white">
                <a href="{{ route('home') }}" class="flex items-center group" title="{{ $siteName }}">
                    <img src="{{ $headerLogoUrl }}" alt="{{ $siteName }}" class="h-10 sm:h-11 w-auto max-w-[210px] object-contain transition-transform duration-200 group-hover:scale-105">
                </a>
                <button id="closeMobileMenuBtn" class="text-gray-400 hover:text-red-500 p-2 focus:outline-none transition-colors rounded-full hover:bg-red-50" aria-label="Close menu">
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

                @if($activeHeaderCities->isNotEmpty())
                <!-- City Selector (Mobile Drawer) -->
                <div class="pb-5 border-b border-gray-100">
                    <p class="text-xs text-gray-400 font-semibold mb-2 uppercase tracking-wider px-1">Diagnostic City</p>
                    <button type="button" 
                            onclick="closeMobileMenu(); setTimeout(() => toggleHeaderCityDropdown(), 200);"
                            class="w-full flex items-center justify-between p-3 rounded-2xl bg-teal-50/70 border border-teal-200/80 hover:bg-teal-50 active:scale-[0.99] transition text-left group">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-teal-600 text-white flex items-center justify-center flex-shrink-0 shadow-2xs">
                                <i class="fas fa-map-marker-alt text-xs"></i>
                            </div>
                            <div>
                                <span class="text-[10px] uppercase font-bold text-teal-700 block leading-tight">Selected City</span>
                                <span class="text-sm font-extrabold text-gray-900 group-hover:text-teal-700 transition-colors">
                                    {{ $selectedHeaderCity?->name ?? 'Select City' }}
                                </span>
                            </div>
                        </div>
                        <span class="text-xs font-bold text-teal-700 bg-white px-2.5 py-1 rounded-lg border border-teal-200/70 shadow-2xs flex items-center gap-1">
                            <span>Change</span>
                            <i class="fas fa-chevron-right text-[10px]"></i>
                        </span>
                    </button>
                </div>
                @endif

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

        function toggleHeaderCityDropdown(e) {
            if (e) e.stopPropagation();
            const menu = document.getElementById('headerCityDropdownMenu');
            const backdrop = document.getElementById('headerCityBackdrop');
            const chevron = document.getElementById('headerCityChevron');
            if (!menu) return;

            const isHidden = menu.classList.contains('hidden');
            if (isHidden) {
                menu.classList.remove('hidden');
                if (backdrop) backdrop.classList.remove('hidden');
                if (chevron) chevron.style.transform = 'rotate(180deg)';
                if (window.innerWidth < 640) {
                    document.body.classList.add('overflow-hidden');
                }
                const input = document.getElementById('headerCitySearchInput');
                if (input) {
                    input.value = '';
                    filterHeaderCities('');
                    if (window.innerWidth >= 640) {
                        setTimeout(() => input.focus(), 50);
                    }
                }
            } else {
                closeHeaderCityDropdown();
            }
        }

        function closeHeaderCityDropdown() {
            const menu = document.getElementById('headerCityDropdownMenu');
            const backdrop = document.getElementById('headerCityBackdrop');
            const chevron = document.getElementById('headerCityChevron');
            if (menu) menu.classList.add('hidden');
            if (backdrop) backdrop.classList.add('hidden');
            if (chevron) chevron.style.transform = 'rotate(0deg)';
            document.body.classList.remove('overflow-hidden');
        }

        function filterHeaderCities(query) {
            const rawQ = (query || '').trim();
            const q = rawQ.toLowerCase();
            const items = document.querySelectorAll('#headerCityList .city-item');
            const clearBtn = document.getElementById('headerCityClearSearchBtn');
            const emptyState = document.getElementById('headerCityEmptyState');
            const countEl = document.getElementById('headerCityFilteredCount');
            const pincodeBox = document.getElementById('headerPincodeResultBox');

            if (clearBtn) {
                clearBtn.classList.toggle('hidden', !rawQ);
            }

            // Check if query is primarily digits (pincode search)
            const isPincodeSearch = /^\d{2,6}$/.test(rawQ);

            let matchingCityForPincode = null;
            let visibleCount = 0;

            items.forEach(item => {
                const name = (item.getAttribute('data-city-name') || '').toLowerCase();
                const state = (item.getAttribute('data-city-state') || '').toLowerCase();
                const pins = item.getAttribute('data-city-pincodes') || '';
                const pinArray = pins.split(/\s+/).filter(Boolean);

                let matches = false;
                if (!q) {
                    matches = true;
                } else if (isPincodeSearch) {
                    // Check if any pincode matches
                    const matchedPin = pinArray.find(p => p.startsWith(rawQ) || p === rawQ);
                    if (matchedPin) {
                        matches = true;
                        if (!matchingCityForPincode && (matchedPin === rawQ || rawQ.length >= 4)) {
                            matchingCityForPincode = {
                                id: item.getAttribute('data-city-id'),
                                name: item.getAttribute('data-display-name'),
                                pincode: matchedPin
                            };
                        }
                    }
                } else {
                    matches = name.includes(q) || state.includes(q);
                }

                if (matches) {
                    item.style.display = '';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            // Pincode Search Availability Banner
            if (pincodeBox) {
                if (isPincodeSearch && rawQ.length >= 3) {
                    if (visibleCount > 0) {
                        const targetCity = matchingCityForPincode || {
                            id: document.querySelector('#headerCityList .city-item:not([style*="display: none"])')?.getAttribute('data-city-id'),
                            name: document.querySelector('#headerCityList .city-item:not([style*="display: none"])')?.getAttribute('data-display-name')
                        };

                        pincodeBox.innerHTML = `
                            <div class="p-2.5 sm:p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs font-bold flex items-center justify-between gap-2 shadow-2xs">
                                <div class="flex items-center gap-2.5 min-w-0">
                                    <span class="w-6 h-6 rounded-full bg-emerald-600 text-white flex items-center justify-center text-xs flex-shrink-0 shadow-2xs">
                                        <i class="fas fa-check"></i>
                                    </span>
                                    <div class="min-w-0">
                                        <span class="block truncate text-emerald-950 font-black">
                                            Service Available in Pincode <span class="font-mono text-emerald-800 bg-white px-1.5 py-0.5 rounded border border-emerald-200">${rawQ}</span>
                                        </span>
                                        <span class="text-[11px] text-emerald-700 font-semibold block truncate">
                                            Doorstep sample collection available in <strong>${targetCity.name}</strong>
                                        </span>
                                    </div>
                                </div>
                                ${targetCity.id ? `
                                    <button type="button" onclick="selectHeaderCity(${targetCity.id}, '${targetCity.name}')" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition flex-shrink-0 shadow-xs cursor-pointer whitespace-nowrap">
                                        Select ${targetCity.name}
                                    </button>
                                ` : ''}
                            </div>
                        `;
                        pincodeBox.classList.remove('hidden');
                    } else if (rawQ.length === 6) {
                        pincodeBox.innerHTML = `
                            <div class="p-2.5 sm:p-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-900 text-xs font-bold flex items-center gap-2.5 shadow-2xs">
                                <span class="w-6 h-6 rounded-full bg-rose-500 text-white flex items-center justify-center text-xs flex-shrink-0 shadow-2xs">
                                    <i class="fas fa-times"></i>
                                </span>
                                <div class="min-w-0">
                                    <span class="block text-rose-950 font-black">
                                        Pincode <span class="font-mono bg-white px-1.5 py-0.5 rounded border border-rose-200">${rawQ}</span> is Not Serviceable
                                    </span>
                                    <span class="text-[11px] text-rose-700 font-medium block">
                                        Doorstep sample collection is currently not available in this area.
                                    </span>
                                </div>
                            </div>
                        `;
                        pincodeBox.classList.remove('hidden');
                    } else {
                        pincodeBox.classList.add('hidden');
                        pincodeBox.innerHTML = '';
                    }
                } else {
                    pincodeBox.classList.add('hidden');
                    pincodeBox.innerHTML = '';
                }
            }

            if (emptyState) {
                emptyState.classList.toggle('hidden', visibleCount > 0);
            }
            if (countEl) {
                countEl.innerText = visibleCount;
            }
        }

        function clearHeaderCitySearch() {
            const input = document.getElementById('headerCitySearchInput');
            if (input) {
                input.value = '';
                filterHeaderCities('');
                input.focus();
            }
        }

        function updateCitySelectionUI(selectedId) {
            const selectedIdInt = parseInt(selectedId, 10);
            document.querySelectorAll('#headerCityList .city-item').forEach(item => {
                const itemId = parseInt(item.getAttribute('data-city-id'), 10);
                const iconBox = item.querySelector('.city-icon-box');
                const statusBox = item.querySelector('.city-status-box');

                if (itemId === selectedIdInt) {
                    item.className = 'city-item header-city-option group relative p-3 sm:p-3.5 rounded-2xl transition-all cursor-pointer bg-gradient-to-br from-teal-50/95 via-emerald-50/60 to-white border-2 border-teal-600 shadow-sm ring-2 ring-teal-500/10';
                    if (iconBox) {
                        iconBox.className = 'city-icon-box w-8 h-8 rounded-xl bg-teal-600 text-white flex items-center justify-center text-xs font-bold transition-colors flex-shrink-0';
                    }
                    if (statusBox) {
                        statusBox.innerHTML = `
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black bg-teal-600 text-white shadow-xs">
                                <i class="fas fa-check-circle text-xs"></i>
                                <span>Selected</span>
                            </span>
                        `;
                    }
                } else {
                    item.className = 'city-item header-city-option group relative p-3 sm:p-3.5 rounded-2xl transition-all cursor-pointer bg-white hover:bg-teal-50/40 border border-slate-200/90 hover:border-teal-300 shadow-2xs hover:shadow-xs';
                    if (iconBox) {
                        iconBox.className = 'city-icon-box w-8 h-8 rounded-xl bg-slate-100 text-slate-600 group-hover:bg-teal-50 group-hover:text-teal-600 flex items-center justify-center text-xs font-bold transition-colors flex-shrink-0';
                    }
                    if (statusBox) {
                        statusBox.innerHTML = `
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-xl text-xs font-bold text-slate-600 group-hover:text-teal-700 bg-slate-100 group-hover:bg-teal-100/70 border border-slate-200 group-hover:border-teal-300 transition-all">
                                <span>Select</span>
                                <i class="fas fa-chevron-right text-[10px] group-hover:translate-x-0.5 transition-transform"></i>
                            </span>
                        `;
                    }
                }
            });
        }

        function selectHeaderCity(id, name) {
            const nameEl = document.getElementById('headerSelectedCityName');
            if (nameEl) nameEl.innerText = name;

            try {
                localStorage.setItem('selected_city_id', id);
                localStorage.setItem('selected_city_name', name);
            } catch (err) {}

            // Instantly update UI selection badge & active card style
            updateCitySelectionUI(id);

            fetch("{{ route('set.city') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ city_id: id })
            }).then(res => res.json()).then(data => {
                // Successfully stored in session
            }).catch(err => console.error('Error saving city', err));

            // Smooth close so user sees the checkmark state
            setTimeout(() => {
                closeHeaderCityDropdown();
            }, 250);
        }

        document.addEventListener('DOMContentLoaded', () => {
            document.addEventListener('click', (e) => {
                const container = document.getElementById('headerCityDropdownContainer');
                const menu = document.getElementById('headerCityDropdownMenu');
                if (container && !container.contains(e.target) && menu && !menu.contains(e.target)) {
                    closeHeaderCityDropdown();
                }
            });

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    closeHeaderCityDropdown();
                }
            });
        });
    </script>

