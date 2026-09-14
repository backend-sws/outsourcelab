@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="container mx-auto px-4 max-w-6xl">
        <!-- Progress Bar -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8 flex justify-between items-center relative">
            <div class="absolute left-10 right-10 top-1/2 h-0.5 bg-gray-200 -z-0"></div>
            <!-- Progress Fill (JS will update width) -->
            <div id="progressFill" class="absolute left-10 top-1/2 h-0.5 bg-brand-secondary -z-0 transition-all duration-500" style="width: 0%;"></div>
            
            <!-- Step Icons -->
            <div class="step-icon relative z-10 bg-white border-2 border-brand-secondary text-brand-secondary rounded-full w-12 h-12 flex items-center justify-center font-bold" data-step="1">
                <i class="fas fa-flask"></i>
            </div>
            <div class="step-icon relative z-10 bg-white border-2 border-gray-300 text-gray-400 rounded-full w-12 h-12 flex items-center justify-center font-bold" data-step="2">
                <i class="fas fa-user-plus"></i>
            </div>
            <div class="step-icon relative z-10 bg-white border-2 border-gray-300 text-gray-400 rounded-full w-12 h-12 flex items-center justify-center font-bold" data-step="3">
                <i class="far fa-calendar-alt"></i>
            </div>
            <div class="step-icon relative z-10 bg-white border-2 border-gray-300 text-gray-400 rounded-full w-12 h-12 flex items-center justify-center font-bold" data-step="4">
                <i class="fas fa-wallet"></i>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Left Column: Steps -->
            <div class="lg:w-2/3">
                
                <!-- STEP 1: Tests & Packages -->
                <div id="step1" class="step-content">
                    <div class="flex justify-between items-end mb-4">
                        <h2 class="text-2xl font-extrabold text-gray-800">Tests & Packages</h2>
                        <button onclick="window.location.href='/'" class="text-brand-secondary font-bold text-sm border-b-2 border-brand-secondary border-dashed hover:text-brand-dark">+ Add More Tests</button>
                    </div>
                    
                    <!-- Package Card (Free addon) -->
                    <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-4">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-bold text-green-900 text-lg">Complete Care with Every Report <span class="bg-red-500 text-white text-[10px] px-2 py-0.5 rounded ml-2">FREE</span></h3>
                            <i class="fas fa-chevron-up text-gray-400"></i>
                        </div>
                        <div class="flex gap-4 text-xs font-semibold text-green-800 mt-4">
                            <div class="flex items-center bg-white rounded px-2 py-1 shadow-sm"><i class="far fa-file-alt text-gray-400 mr-2"></i> Smart Report</div>
                            <div class="flex items-center bg-white rounded px-2 py-1 shadow-sm"><i class="fas fa-user-md text-gray-400 mr-2"></i> Expert Consultation</div>
                            <div class="flex items-center bg-white rounded px-2 py-1 shadow-sm"><i class="fas fa-apple-alt text-gray-400 mr-2"></i> Diet Plan</div>
                        </div>
                    </div>

                    <!-- Dynamic Cart Items (filled by JS from localStorage) -->
                    <div id="checkoutCartItems">
                        <!-- JS will render items here -->
                    </div>
                    
                    <!-- Empty Cart State -->
                    <div id="emptyCartMsg" class="hidden bg-gray-50 border border-dashed border-gray-300 rounded-xl p-8 text-center">
                        <i class="fas fa-shopping-cart text-4xl text-gray-300 mb-3"></i>
                        <p class="font-bold text-gray-500">Your cart is empty</p>
                        <a href="/" class="mt-4 inline-block bg-brand-dark text-white px-6 py-2 rounded-xl font-bold text-sm hover:bg-brand-secondary transition">Browse Packages</a>
                    </div>
                </div>

                <!-- STEP 2: Add Members -->
                <div id="step2" class="step-content hidden">
                    <div class="flex justify-between items-end mb-4">
                        <h2 class="text-2xl font-extrabold text-gray-800">Add Members</h2>
                        <button onclick="window.openAddMemberModal()" class="text-brand-secondary font-bold text-sm border-b-2 border-brand-secondary border-dashed hover:text-brand-dark">+ Add Member</button>
                    </div>

                    <div class="bg-red-50/30 border border-red-100 rounded-xl p-4 flex items-start">
                        <div class="pt-1 mr-4">
                            <div class="w-6 h-6 rounded bg-brand-dark text-white flex items-center justify-center text-xs">
                                <i class="fas fa-check"></i>
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-bold text-gray-900 text-lg flex items-center">{{ explode(' ', $patient->name ?? 'Guest')[0] }} <span class="text-[10px] bg-gray-200 text-gray-600 px-2 py-0.5 rounded ml-2 uppercase">{{ $patient->relation ?? 'Self' }}</span></h3>
                                    <p class="text-xs text-gray-500 font-semibold mt-1">{{ $patient->age ?? '25' }} Years | {{ ucfirst($patient->gender ?? 'Male') }} | <button class="text-brand-dark underline font-bold">Edit</button></p>
                                </div>
                                <div class="font-bold text-gray-800">(1) <i class="fas fa-chevron-up text-gray-400 ml-2"></i></div>
                            </div>
                            <div class="mt-4 pt-4 border-t border-red-100 flex justify-between items-center">
                                <span class="text-sm font-semibold text-red-500 w-3/4 leading-tight">Fit India Full Body Checkup With Vitamin Screening with Free Heart Test (HsCRP)</span>
                                <div class="w-5 h-5 rounded bg-brand-dark text-white flex items-center justify-center text-[10px]">
                                    <i class="fas fa-check"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 3: Address & Slots -->
                <div id="step3" class="step-content hidden">
                    <h2 class="text-2xl font-extrabold text-gray-800 mb-2">Sample Collection Address</h2>
                    <p class="text-sm text-gray-500 font-semibold mb-6">Select an address from where the sample will be picked</p>

                    <!-- Pincode Check (Custom Logic) -->
                    <div id="pincodeCheckSection" class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm mb-6 transition-all">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Check Service Availability</label>
                        <div class="flex gap-4">
                            <input type="text" id="pincodeInput" class="flex-1 border border-gray-300 rounded-lg px-4 py-2 font-bold focus:ring-2 focus:ring-brand-secondary outline-none text-gray-800 tracking-wider" placeholder="Enter Pincode (e.g. 800001)" maxlength="6">
                            <button onclick="verifyPincode()" class="bg-brand-dark text-white font-bold px-6 py-2 rounded-lg hover:bg-brand-secondary transition">Verify</button>
                        </div>
                        <p id="pincodeError" class="text-red-500 text-sm font-bold mt-2 hidden">Sorry, service not available in this area.</p>
                        <p id="pincodeSuccess" class="text-green-600 text-sm font-bold mt-2 hidden"><i class="fas fa-check-circle mr-1"></i> Service available!</p>
                    </div>

                    <!-- Hidden Address & Slot Section -->
                    <div id="addressAndSlotSection" class="hidden">
                        <div class="border border-gray-200 rounded-xl p-4 flex justify-between items-center mb-8 bg-white shadow-sm">
                            <div class="flex items-start">
                                <i class="fas fa-map-marker-alt text-gray-400 mt-1 mr-3 text-lg"></i>
                                <div>
                                    <h4 class="font-bold text-gray-800 text-sm">Collection Address <span id="displayAddressType" class="bg-brand-light/30 text-brand-dark text-[10px] px-2 py-0.5 rounded ml-2">Home</span></h4>
                                    <p id="displayAddressText" class="text-xs text-gray-500 mt-1">3rd Floor, Parvati Tower, Phulwari Rd, Jagdeo Path...</p>
                                </div>
                            </div>
                            <button onclick="window.openChangeAddressModal()" class="text-brand-dark font-bold text-xs border-b border-brand-dark border-dashed hover:text-brand-secondary">Change</button>
                        </div>

                        <h3 class="font-extrabold text-gray-800 text-lg mb-4">Collection Date</h3>
                        <div class="flex gap-3 overflow-x-auto pb-4 no-scrollbar" id="dateContainer">
                            <div class="date-item flex-none w-16 h-20 border border-gray-200 bg-white rounded-xl flex flex-col items-center justify-center cursor-pointer hover:border-brand-secondary transition shadow-sm">
                                <span class="text-xs font-semibold text-gray-500">Fri</span>
                                <span class="text-lg font-black text-gray-800">04</span>
                                <span class="text-xs font-semibold text-gray-500">Sep</span>
                            </div>
                            <div class="date-item flex-none w-16 h-20 border-2 border-brand-secondary bg-brand-light/10 text-brand-secondary rounded-xl flex flex-col items-center justify-center cursor-pointer shadow-sm transition active-date">
                                <span class="text-xs font-bold">Sat</span>
                                <span class="text-lg font-black">05</span>
                                <span class="text-xs font-bold">Sep</span>
                            </div>
                            <div class="date-item flex-none w-16 h-20 border border-gray-200 bg-white rounded-xl flex flex-col items-center justify-center cursor-pointer hover:border-brand-secondary transition shadow-sm">
                                <span class="text-xs font-semibold text-gray-500">Sun</span>
                                <span class="text-lg font-black text-gray-800">06</span>
                                <span class="text-xs font-semibold text-gray-500">Sep</span>
                            </div>
                            <div class="date-item flex-none w-16 h-20 border border-gray-200 bg-white rounded-xl flex flex-col items-center justify-center cursor-pointer hover:border-brand-secondary transition shadow-sm">
                                <span class="text-xs font-semibold text-gray-500">Mon</span>
                                <span class="text-lg font-black text-gray-800">07</span>
                                <span class="text-xs font-semibold text-gray-500">Sep</span>
                            </div>
                            <div class="date-item flex-none w-16 h-20 border border-gray-200 bg-white rounded-xl flex flex-col items-center justify-center cursor-pointer hover:border-brand-secondary transition shadow-sm">
                                <span class="text-xs font-semibold text-gray-500">Tue</span>
                                <span class="text-lg font-black text-gray-800">08</span>
                                <span class="text-xs font-semibold text-gray-500">Sep</span>
                            </div>
                            <div class="date-item flex-none w-16 h-20 border border-gray-200 bg-white rounded-xl flex flex-col items-center justify-center cursor-pointer hover:border-brand-secondary transition shadow-sm">
                                <span class="text-xs font-semibold text-gray-500">Wed</span>
                                <span class="text-lg font-black text-gray-800">09</span>
                                <span class="text-xs font-semibold text-gray-500">Sep</span>
                            </div>
                            <div class="date-item flex-none w-16 h-20 border border-gray-200 bg-white rounded-xl flex flex-col items-center justify-center cursor-pointer hover:border-brand-secondary transition shadow-sm">
                                <span class="text-xs font-semibold text-gray-500">Thu</span>
                                <span class="text-lg font-black text-gray-800">10</span>
                                <span class="text-xs font-semibold text-gray-500">Sep</span>
                            </div>
                        </div>

                        <h3 class="font-extrabold text-gray-800 text-lg mb-4 mt-6">Available Slots</h3>
                        
                        <!-- Morning Slots -->
                        <div class="mb-6">
                            <p class="text-xs font-bold text-gray-400 mb-3 flex items-center"><i class="fas fa-cloud-sun mr-2"></i> Morning</p>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3 slot-container">
                                <div class="slot-item border border-gray-200 bg-white rounded-lg py-2 text-center text-xs font-bold text-gray-600 hover:border-brand-secondary hover:text-brand-secondary cursor-pointer transition shadow-sm">05:00 AM - 06:00 AM</div>
                                <div class="slot-item border border-gray-200 bg-white rounded-lg py-2 text-center text-xs font-bold text-gray-600 hover:border-brand-secondary hover:text-brand-secondary cursor-pointer transition shadow-sm">06:00 AM - 07:00 AM</div>
                                <div class="slot-item border-2 border-brand-secondary bg-brand-light/10 rounded-lg py-2 text-center text-xs font-bold text-brand-dark cursor-pointer shadow-sm transition active-slot">07:00 AM - 08:00 AM</div>
                                <div class="slot-item border border-gray-200 bg-white rounded-lg py-2 text-center text-xs font-bold text-gray-600 hover:border-brand-secondary hover:text-brand-secondary cursor-pointer transition shadow-sm">08:00 AM - 09:00 AM</div>
                                <div class="slot-item border border-gray-200 bg-white rounded-lg py-2 text-center text-xs font-bold text-gray-600 hover:border-brand-secondary hover:text-brand-secondary cursor-pointer transition shadow-sm">09:00 AM - 10:00 AM</div>
                                <div class="slot-item border border-gray-200 bg-white rounded-lg py-2 text-center text-xs font-bold text-gray-600 hover:border-brand-secondary hover:text-brand-secondary cursor-pointer transition shadow-sm">10:00 AM - 11:00 AM</div>
                                <div class="slot-item border border-gray-200 bg-white rounded-lg py-2 text-center text-xs font-bold text-gray-600 hover:border-brand-secondary hover:text-brand-secondary cursor-pointer transition shadow-sm">11:00 AM - 12:00 PM</div>
                            </div>
                        </div>

                        <!-- Afternoon Slots -->
                        <div class="mb-6">
                            <p class="text-xs font-bold text-gray-400 mb-3 flex items-center"><i class="fas fa-sun mr-2"></i> Afternoon</p>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3 slot-container">
                                <div class="slot-item border border-gray-200 bg-white rounded-lg py-2 text-center text-xs font-bold text-gray-600 hover:border-brand-secondary hover:text-brand-secondary cursor-pointer transition shadow-sm">12:00 PM - 01:00 PM</div>
                                <div class="slot-item border border-gray-200 bg-white rounded-lg py-2 text-center text-xs font-bold text-gray-600 hover:border-brand-secondary hover:text-brand-secondary cursor-pointer transition shadow-sm">01:00 PM - 02:00 PM</div>
                                <div class="slot-item border border-gray-200 bg-white rounded-lg py-2 text-center text-xs font-bold text-gray-600 hover:border-brand-secondary hover:text-brand-secondary cursor-pointer transition shadow-sm">02:00 PM - 03:00 PM</div>
                                <div class="slot-item border border-gray-200 bg-white rounded-lg py-2 text-center text-xs font-bold text-gray-600 hover:border-brand-secondary hover:text-brand-secondary cursor-pointer transition shadow-sm">03:00 PM - 04:00 PM</div>
                            </div>
                        </div>

                        <!-- Evening Slots -->
                        <div class="mb-6">
                            <p class="text-xs font-bold text-gray-400 mb-3 flex items-center"><i class="fas fa-moon mr-2"></i> Evening</p>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3 slot-container">
                                <div class="slot-item border border-gray-200 bg-white rounded-lg py-2 text-center text-xs font-bold text-gray-600 hover:border-brand-secondary hover:text-brand-secondary cursor-pointer transition shadow-sm">05:00 PM - 06:00 PM</div>
                                <div class="slot-item border border-gray-200 bg-white rounded-lg py-2 text-center text-xs font-bold text-gray-600 hover:border-brand-secondary hover:text-brand-secondary cursor-pointer transition shadow-sm">06:00 PM - 07:00 PM</div>
                                <div class="slot-item border border-gray-200 bg-white rounded-lg py-2 text-center text-xs font-bold text-gray-600 hover:border-brand-secondary hover:text-brand-secondary cursor-pointer transition shadow-sm">07:00 PM - 08:00 PM</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 4: Payment -->
                <div id="step4" class="step-content hidden">
                    <div class="bg-brand-light/10 border-l-4 border-brand-secondary rounded-r-xl p-4 mb-6 flex items-center shadow-sm">
                        <h2 class="text-brand-dark font-extrabold text-2xl tracking-tighter mr-4">4x<span class="text-lg font-normal">VALUE</span></h2>
                        <div>
                            <h4 class="font-bold text-sm text-gray-800">Expert Consultation</h4>
                            <p class="text-xs text-gray-500 font-semibold">Free with every test</p>
                        </div>
                    </div>

                    <div class="border border-gray-200 bg-white rounded-xl p-4 flex justify-between items-center mb-4 cursor-pointer hover:bg-gray-50 shadow-sm transition">
                        <span class="font-bold text-gray-800 text-sm">Booking Summary</span>
                        <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                    </div>

                    <div class="border border-gray-200 bg-white rounded-xl p-4 flex justify-between items-center mb-4 cursor-pointer hover:bg-gray-50 shadow-sm transition">
                        <div class="flex items-center">
                            <i class="fas fa-percentage text-brand-secondary bg-brand-light/20 p-2 rounded-full mr-3"></i>
                            <div>
                                <h4 class="font-bold text-gray-800 text-sm">Unlock Coupons & Offers</h4>
                                <p class="text-[10px] text-gray-500 font-semibold">View all available coupons</p>
                            </div>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                    </div>

                    <div class="border border-gray-200 bg-white rounded-xl p-4 flex justify-between items-center mb-8 shadow-sm">
                        <div class="flex items-center text-gray-800 font-bold text-sm">
                            <i class="fas fa-print mr-3 text-lg text-gray-400"></i> Add Hard Copy Reports @ ₹150 <i class="fas fa-info-circle text-gray-300 ml-1"></i>
                        </div>
                        <input type="checkbox" class="w-5 h-5 rounded border-gray-300 text-brand-secondary focus:ring-brand-secondary cursor-pointer">
                    </div>

                    <div class="flex justify-between items-end mb-4">
                        <h3 class="font-extrabold text-gray-800 text-lg">Save more on every booking</h3>
                        <a href="#" class="text-brand-secondary font-bold text-xs hover:underline">Compare Plans ></a>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <!-- VIP Plan -->
                        <div class="border border-gray-200 bg-white rounded-xl p-4 relative cursor-pointer hover:border-brand-secondary shadow-sm transition">
                            <div class="absolute top-4 right-4 w-5 h-5 bg-brand-dark rounded text-white flex items-center justify-center text-xs"><i class="fas fa-check"></i></div>
                            <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-400 text-xl mb-3"><i class="fas fa-crown"></i></div>
                            <h4 class="font-bold text-brand-dark text-sm mb-1">VIP Membership</h4>
                            <p class="text-[10px] text-gray-500 font-semibold leading-tight mb-3"><span class="text-green-600 font-bold">Save ₹180</span> on this order & 10% on every booking</p>
                            <div class="font-black text-gray-800">₹99<span class="text-[10px] font-semibold text-gray-400">/yr</span></div>
                        </div>
                        <!-- VIP Gold -->
                        <div class="border border-yellow-200 bg-yellow-50/30 rounded-xl p-4 relative cursor-pointer hover:border-yellow-400 shadow-sm transition">
                            <div class="absolute top-0 left-1/2 -translate-x-1/2 bg-brand-dark text-white text-[9px] font-bold px-2 py-0.5 rounded-b-md whitespace-nowrap">Recommended</div>
                            <div class="absolute top-4 right-4 w-5 h-5 border-2 border-gray-300 rounded bg-white"></div>
                            <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center text-yellow-500 text-xl mb-3"><i class="fas fa-crown"></i></div>
                            <h4 class="font-bold text-yellow-600 text-sm mb-1">VIP Gold Membership</h4>
                            <p class="text-[10px] text-gray-500 font-semibold leading-tight mb-3"><span class="text-green-600 font-bold">Save ₹270</span> on this order & 15% on every booking</p>
                            <div class="font-black text-gray-800">₹499<span class="text-[10px] font-semibold text-gray-400">/yr</span></div>
                        </div>
                    </div>
                    
                    <div class="bg-green-50 text-green-700 text-xs font-bold p-3 rounded-lg text-center shadow-sm"><i class="fas fa-tree mr-2"></i> With every health checkup, you're helping plant a tree!</div>
                </div>

            </div>

            <!-- Right Column: Summary & Bill -->
            <div class="lg:w-1/3">
                <div class="sticky top-24">
                    
                    <!-- Apply Coupon / Promo Code Block -->
                    <div id="checkoutCouponSection" class="bg-white border border-gray-200 rounded-xl p-4 mb-4 shadow-sm">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-black text-gray-800 uppercase tracking-wide flex items-center gap-1.5">
                                <i class="fas fa-ticket-alt text-brand-secondary"></i>
                                <span>Apply Coupon / Promo Code</span>
                            </span>
                        </div>

                        <!-- Coupon Input Field -->
                        <div id="couponInputContainer" class="flex gap-2">
                            <input type="text" id="checkoutCouponInput" placeholder="Enter coupon code" 
                                class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-xs uppercase font-mono font-black focus:ring-2 focus:ring-brand-secondary outline-none text-gray-800 placeholder-gray-400">
                            <button type="button" onclick="applyCouponManual()" id="applyCouponBtn" 
                                class="bg-brand-dark hover:bg-brand-secondary text-white px-4 py-2 rounded-lg text-xs font-bold transition flex items-center gap-1">
                                <span>Apply</span>
                            </button>
                        </div>

                        <!-- Coupon Message Alert -->
                        <div id="couponStatusMessage" class="hidden text-[11px] font-bold mt-2 p-2 rounded-lg"></div>

                        <!-- Active Applied Coupon Pill -->
                        <div id="appliedCouponDisplay" class="hidden mt-2.5 p-3 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-lg bg-emerald-500 text-white flex items-center justify-center text-[10px] font-bold">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <span class="font-mono font-black text-xs text-emerald-800" id="appliedCouponCodeText"></span>
                                    <span class="text-[10px] text-emerald-600 block font-semibold" id="appliedCouponSavingsText"></span>
                                </div>
                            </div>
                            <button type="button" onclick="removeAppliedCoupon()" class="text-xs font-bold text-rose-500 hover:text-rose-700">Remove</button>
                        </div>

                        <!-- Available Coupons for Quick Apply -->
                        @if((isset($myCoupons) && $myCoupons->count() > 0) || (isset($bannerCoupons) && $bannerCoupons->count() > 0))
                            <div class="mt-3 pt-3 border-t border-gray-100">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Available Offers</span>
                                    <span class="text-[10px] font-bold text-brand-secondary">Click to Apply</span>
                                </div>
                                <div class="space-y-2 max-h-48 overflow-y-auto pr-1">
                                    {{-- User Welcome Coupon --}}
                                    @if(isset($myCoupons))
                                        @foreach($myCoupons as $pc)
                                            @if($pc->coupon && $pc->coupon->is_active)
                                                <div onclick="applyQuickCoupon('{{ $pc->coupon->code }}')" class="p-2.5 rounded-xl border border-indigo-100 bg-indigo-50/50 hover:bg-indigo-50 cursor-pointer transition flex items-center justify-between group">
                                                    <div>
                                                        <div class="flex items-center gap-1.5">
                                                            <span class="font-mono font-black text-xs text-indigo-700 bg-white px-2 py-0.5 rounded border border-indigo-200">{{ $pc->coupon->code }}</span>
                                                            @if($pc->coupon->coupon_type === 'welcome')
                                                                <span class="text-[9px] font-black uppercase text-purple-600 bg-purple-100 px-1.5 py-0.5 rounded">🎁 1st Order</span>
                                                            @endif
                                                        </div>
                                                        <p class="text-[10px] text-gray-600 font-medium mt-1">
                                                            {{ $pc->coupon->discount_type === 'percentage' ? $pc->coupon->discount_value . '% OFF' : '₹' . number_format($pc->coupon->discount_value) . ' Flat OFF' }}
                                                            @if($pc->coupon->min_order_amount > 0)
                                                                (Min order: ₹{{ number_format($pc->coupon->min_order_amount) }})
                                                            @endif
                                                        </p>
                                                    </div>
                                                    <span class="text-[11px] font-bold text-indigo-600 group-hover:underline">Apply</span>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif

                                    {{-- Banner / Spend-Based Coupons --}}
                                    @if(isset($bannerCoupons))
                                        @foreach($bannerCoupons as $bc)
                                            <div onclick="applyQuickCoupon('{{ $bc->code }}')" class="p-2.5 rounded-xl border border-amber-100 bg-amber-50/50 hover:bg-amber-50 cursor-pointer transition flex items-center justify-between group">
                                                <div>
                                                    <div class="flex items-center gap-1.5">
                                                        <span class="font-mono font-black text-xs text-amber-800 bg-white px-2 py-0.5 rounded border border-amber-200">{{ $bc->code }}</span>
                                                        <span class="text-[9px] font-black uppercase text-amber-700 bg-amber-100 px-1.5 py-0.5 rounded">📢 Offer</span>
                                                    </div>
                                                    <p class="text-[10px] text-gray-600 font-medium mt-1">
                                                        {{ $bc->discount_type === 'percentage' ? $bc->discount_value . '% OFF' : '₹' . number_format($bc->discount_value) . ' Flat OFF' }}
                                                        @if($bc->min_order_amount > 0)
                                                            on orders > ₹{{ number_format($bc->min_order_amount) }}
                                                        @endif
                                                    </p>
                                                </div>
                                                <span class="text-[11px] font-bold text-amber-700 group-hover:underline">Apply</span>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Dynamic Summary Block (Changes based on step) -->
                    <div id="summaryBlockStep1" class="border border-gray-200 rounded-xl overflow-hidden mb-4 bg-white shadow-sm">
                        <div class="p-4 border-b border-gray-100 space-y-2">
                            <div class="flex justify-between text-sm font-semibold text-gray-600">
                                <span>Tests Subtotal</span>
                                <span><span data-bill-mrp class="line-through text-gray-400 text-xs mr-1">₹0</span> <span data-bill-subtotal>₹0</span></span>
                            </div>
                            <div class="coupon-discount-row hidden flex justify-between text-sm font-semibold text-emerald-600">
                                <span class="flex items-center gap-1"><i class="fas fa-tag text-xs"></i> <span>Coupon (<span class="coupon-code-badge font-mono"></span>)</span></span>
                                <span>-<span data-bill-discount>₹0</span></span>
                            </div>
                        </div>
                        <div class="p-4 bg-gray-50 flex justify-between items-center">
                            <span class="font-extrabold text-gray-800">Total Payable</span>
                            <span data-bill-amount class="font-black text-xl text-brand-dark">₹0</span>
                        </div>
                    </div>

                    <div id="summaryBlockStep2" class="hidden">
                        <div class="bg-gray-50 rounded-xl p-4 mb-4 border border-gray-200 flex items-center justify-between cursor-pointer hover:bg-gray-100 transition shadow-sm">
                            <div class="flex items-center text-sm font-bold text-gray-800">
                                <i class="fas fa-users mr-3 text-gray-400"></i> Unlock ₹720 OFF
                            </div>
                            <i class="fas fa-chevron-right text-xs text-gray-400"></i>
                        </div>
                    </div>

                    <div id="summaryBlockStep4" class="hidden">
                        <!-- Detailed Bill -->
                        <div class="border border-gray-200 rounded-xl overflow-hidden mb-4 bg-white shadow-sm">
                            <div class="p-4 border-b border-gray-100 space-y-3">
                                <div class="flex justify-between text-sm font-semibold text-gray-600">
                                    <span>Tests Subtotal</span>
                                    <span><span data-bill-mrp class="line-through text-gray-400 text-xs mr-1">₹0</span> <span data-bill-subtotal>₹0</span></span>
                                </div>
                                <div class="coupon-discount-row hidden flex justify-between text-sm font-semibold text-emerald-600">
                                    <span class="flex items-center gap-1"><i class="fas fa-tag text-xs"></i> <span>Coupon (<span class="coupon-code-badge font-mono"></span>)</span></span>
                                    <span>-<span data-bill-discount>₹0</span></span>
                                </div>
                                <div class="flex justify-between text-sm font-semibold text-gray-600">
                                    <span>Expert Consultation</span>
                                    <span><span class="line-through text-gray-400 text-xs mr-1">₹299</span> <span class="text-green-600">FREE</span></span>
                                </div>
                            </div>
                            <div class="p-4 bg-gray-50 flex justify-between items-center">
                                <span class="font-extrabold text-gray-800">Total Payable</span>
                                <span data-bill-amount class="font-black text-xl text-brand-dark">₹0</span>
                            </div>
                        </div>
                        <div class="bg-green-100/50 border border-green-200 text-green-700 text-xs font-bold p-2 rounded-lg text-center mb-6 shadow-sm">
                            🎉 Maximum savings applied on this booking
                        </div>
                    </div>

                    <!-- Shared Bill Summary for Step 2 & 3 -->
                    <div id="sharedBillBlock" class="hidden border border-gray-200 rounded-xl overflow-hidden mb-4 bg-white shadow-sm">
                        <div class="p-4 border-b border-gray-100 space-y-2">
                            <div class="flex justify-between text-sm font-semibold text-gray-600">
                                <span>Tests Subtotal</span>
                                <span><span data-bill-mrp class="line-through text-gray-400 text-xs mr-1">₹0</span> <span data-bill-subtotal>₹0</span></span>
                            </div>
                            <div class="coupon-discount-row hidden flex justify-between text-sm font-semibold text-emerald-600">
                                <span class="flex items-center gap-1"><i class="fas fa-tag text-xs"></i> <span>Coupon (<span class="coupon-code-badge font-mono"></span>)</span></span>
                                <span>-<span data-bill-discount>₹0</span></span>
                            </div>
                        </div>
                        <div class="p-4 bg-gray-50 flex justify-between items-center">
                            <span class="font-extrabold text-gray-800">Total Payable</span>
                            <span data-bill-amount class="font-black text-xl text-brand-dark">₹0</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <button id="btnNext" onclick="nextStep()" class="w-full bg-brand-dark text-white font-bold py-3.5 rounded-xl hover:bg-brand-secondary transition shadow-sm text-lg">Next</button>
                    
                    <div id="btnPay" class="hidden flex gap-3 mt-2">
                        <button onclick="payOnCollection()" class="flex-1 bg-gray-200 text-gray-800 font-bold py-3.5 rounded-xl hover:bg-gray-300 transition shadow-sm text-sm">Pay On Collection</button>
                        <button class="flex-1 bg-rose-600 text-white font-bold py-3.5 rounded-xl hover:bg-rose-700 transition shadow-sm text-sm">Pay Now</button>
                    </div>
                    
                    <p id="safePaymentsText" class="hidden text-center text-xs font-bold text-gray-400 mt-4"><i class="fas fa-shield-alt mr-1"></i> Safe and Secure payments</p>
                </div>
            </div>
        </div>
    </div>
</div>

    <script id="checkout-patient-data" type="application/json">
        {!! json_encode([
            'patientId' => (string)($patient->id ?? session('patient_id', '')),
            'serverCart' => $patient->cart ?? []
        ]) !!}
    </script>
<script>
    // --- Cart & Coupon Data (keyed by patient ID) ---
    const checkoutPatientMeta = JSON.parse(document.getElementById('checkout-patient-data').textContent);
    const checkoutPatientId = checkoutPatientMeta.patientId;
    const checkoutCartKey = 'cart_' + checkoutPatientId;
    const serverCheckoutCart = Array.isArray(checkoutPatientMeta.serverCart) ? checkoutPatientMeta.serverCart : [];
    let currentAppliedCoupon = null;

    function getCheckoutCart() {
        try {
            let stored = JSON.parse(localStorage.getItem(checkoutCartKey));
            if (Array.isArray(stored) && stored.length > 0) {
                return stored;
            }
            if (serverCheckoutCart.length > 0) {
                localStorage.setItem(checkoutCartKey, JSON.stringify(serverCheckoutCart));
                return serverCheckoutCart;
            }
            return Array.isArray(stored) ? stored : [];
        } catch(e) {
            return serverCheckoutCart || [];
        }
    }

    function removeFromCart(index) {
        let cart = getCheckoutCart();
        cart.splice(index, 1);
        localStorage.setItem(checkoutCartKey, JSON.stringify(cart));
        fetch('{{ route("patient.cart.sync") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ cart: cart })
        });
        renderCheckoutCart();
        updateCartBadge();
    }

    function updateCartBadge() {
        let cart = getCheckoutCart();
        let countEl = document.getElementById('cartCount');
        if (countEl) {
            countEl.innerText = cart.length;
            if (cart.length > 0) {
                countEl.classList.remove('hidden');
            } else {
                countEl.classList.add('hidden');
            }
        }
    }

    function showCouponMessage(msg, type) {
        let el = document.getElementById('couponStatusMessage');
        if (!el) return;
        el.className = 'text-[11px] font-bold mt-2 p-2.5 rounded-lg ' + 
            (type === 'success' ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : 
            (type === 'error' ? 'bg-rose-100 text-rose-800 border border-rose-200' : 'bg-gray-100 text-gray-700'));
        el.innerText = msg;
        el.classList.remove('hidden');
    }

    function applyCouponManual() {
        let code = document.getElementById('checkoutCouponInput').value.trim();
        if (!code) {
            showCouponMessage('Please enter a coupon code.', 'error');
            return;
        }
        applyCoupon(code);
    }

    function applyQuickCoupon(code) {
        document.getElementById('checkoutCouponInput').value = code;
        applyCoupon(code);
    }

    function applyCoupon(code) {
        let cart = getCheckoutCart();
        let subtotal = cart.reduce((acc, item) => acc + (parseFloat(item.price) || 0), 0);
        if (subtotal <= 0) {
            showCouponMessage('Please add tests or packages to your cart before applying a coupon.', 'error');
            return;
        }

        let btn = document.getElementById('applyCouponBtn');
        if (btn) btn.innerText = 'Checking...';

        fetch("{{ route('patient.apply_coupon') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                code: code,
                cart_total: subtotal
            })
        })
        .then(r => r.json())
        .then(data => {
            if (btn) btn.innerText = 'Apply';
            if (data.success) {
                currentAppliedCoupon = {
                    code: data.coupon_code,
                    title: data.coupon_title,
                    discount: parseFloat(data.discount_amount),
                    type: data.discount_type,
                    value: parseFloat(data.discount_value)
                };
                showCouponMessage(data.message, 'success');
                document.getElementById('couponInputContainer').classList.add('hidden');
                document.getElementById('appliedCouponDisplay').classList.remove('hidden');
                document.getElementById('appliedCouponCodeText').innerText = data.coupon_code;
                document.getElementById('appliedCouponSavingsText').innerText = 'You save ₹' + Number(data.discount_amount).toFixed(2);
                renderCheckoutCart();
            } else {
                showCouponMessage(data.message, 'error');
            }
        })
        .catch(() => {
            if (btn) btn.innerText = 'Apply';
            showCouponMessage('Could not verify coupon. Please try again.', 'error');
        });
    }

    function removeAppliedCoupon() {
        currentAppliedCoupon = null;
        document.getElementById('couponInputContainer').classList.remove('hidden');
        document.getElementById('appliedCouponDisplay').classList.add('hidden');
        document.getElementById('checkoutCouponInput').value = '';
        showCouponMessage('Coupon removed.', 'info');
        renderCheckoutCart();
    }

    function renderCheckoutCart() {
        let cart = getCheckoutCart();
        let container = document.getElementById('checkoutCartItems');
        let emptyMsg = document.getElementById('emptyCartMsg');
        let totalAmount = 0;
        let totalMrp = 0;

        if (cart.length === 0) {
            container.innerHTML = '';
            emptyMsg.classList.remove('hidden');
            return;
        }

        emptyMsg.classList.add('hidden');
        container.innerHTML = cart.map((item, i) => {
            let price = parseInt(item.price) || 0;
            let mrp = parseInt(item.mrp) || price;
            totalAmount += price;
            totalMrp += mrp;
            return `
                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm mb-4 relative">
                    <button onclick="removeFromCart(${i})" class="absolute top-4 right-4 text-gray-300 hover:text-red-500 transition"><i class="far fa-times-circle text-xl"></i></button>
                    <h3 class="text-red-500 font-bold text-lg w-5/6 leading-tight mb-4">${item.name}</h3>
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-bold text-gray-800">${item.params ? item.params : 'Health Package'} <i class="fas fa-chevron-right text-gray-400 ml-1"></i></span>
                        <div class="flex items-center gap-2">
                            <span class="text-xl font-black text-gray-800">₹${price}</span>
                            ${mrp > price ? `<span class="text-sm font-bold text-gray-400 line-through">₹${mrp}</span>` : ''}
                            <i class="fas fa-info-circle text-gray-300 ml-1"></i>
                        </div>
                    </div>
                </div>`;
        }).join('');

        let subtotal = totalAmount;
        let discount = 0;
        if (currentAppliedCoupon) {
            if (currentAppliedCoupon.type === 'percentage') {
                discount = (subtotal * currentAppliedCoupon.value) / 100;
            } else {
                discount = Math.min(subtotal, currentAppliedCoupon.value);
            }
            discount = Math.round(discount * 100) / 100;
            currentAppliedCoupon.discount = discount;
        }

        let payable = Math.max(0, subtotal - discount);

        // Update bill summary blocks
        document.querySelectorAll('[data-bill-subtotal]').forEach(el => el.innerText = '₹' + subtotal);
        document.querySelectorAll('[data-bill-mrp]').forEach(el => el.innerText = '₹' + totalMrp);
        document.querySelectorAll('[data-bill-amount]').forEach(el => el.innerText = '₹' + payable);

        // Update discount rows
        document.querySelectorAll('.coupon-discount-row').forEach(row => {
            if (discount > 0 && currentAppliedCoupon) {
                row.classList.remove('hidden');
                let discVal = row.querySelector('[data-bill-discount]');
                if (discVal) discVal.innerText = '₹' + discount.toFixed(2);
                let badge = row.querySelector('.coupon-code-badge');
                if (badge) badge.innerText = currentAppliedCoupon.code;
            } else {
                row.classList.add('hidden');
            }
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        renderCheckoutCart();
    });

    function payOnCollection() {
        let cart = getCheckoutCart();
        if (cart.length === 0) {
            alert('Your cart is empty!');
            return;
        }

        // Get selected date
        let activeDateEl = document.querySelector('.date-item.active-date');
        let selectedDate = activeDateEl ? activeDateEl.innerText.trim().replace(/\n/g, ' ') : new Date().toDateString();

        // Get selected slot
        let activeSlotEl = document.querySelector('.slot-item.active-slot');
        let selectedSlot = activeSlotEl ? activeSlotEl.innerText.trim() : '07:00 AM - 08:00 AM';

        // Get pincode
        let pincode = document.getElementById('pincodeInput') ? document.getElementById('pincodeInput').value : '';

        // Combine date + slot into datetime string
        let bookingDate = new Date().toISOString().slice(0, 19).replace('T', ' ');

        let btn = event.target;
        btn.disabled = true;
        btn.innerText = 'Booking...';

        fetch("{{ route('patient.place_booking') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                cart: cart,
                payment_method: 'Cash',
                collection_type: 'Home Collection',
                booking_date: bookingDate,
                coupon_code: currentAppliedCoupon ? currentAppliedCoupon.code : null,
                discount_amount: currentAppliedCoupon ? currentAppliedCoupon.discount : 0,
            })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                // Clear cart from localStorage
                localStorage.removeItem(checkoutCartKey);
                localStorage.removeItem('cart_guest');
                // Redirect to bookings
                window.location.href = "{{ route('patient.bookings') }}";
            } else {
                alert('Booking failed: ' + (data.message || 'Unknown error'));
                btn.disabled = false;
                btn.innerText = 'Pay On Collection';
            }
        })
        .catch(() => {
            alert('Network error. Please try again.');
            btn.disabled = false;
            btn.innerText = 'Pay On Collection';
        });
    }

    let currentStep = 1;
    const validPincodes = ['800001', '800002', '110001', '400001']; 
    let isPincodeVerified = false;

    function updateUI() {
        // Hide all steps
        document.querySelectorAll('.step-content').forEach(el => el.classList.add('hidden'));
        document.getElementById('step' + currentStep).classList.remove('hidden');

        // Update Icons
        document.querySelectorAll('.step-icon').forEach(el => {
            let step = parseInt(el.getAttribute('data-step'));
            if(step < currentStep) {
                // Completed
                el.classList.add('bg-brand-secondary', 'text-white', 'border-brand-secondary');
                el.classList.remove('bg-white', 'text-brand-secondary', 'text-gray-400', 'border-gray-300');
            } else if (step === currentStep) {
                // Active
                el.classList.add('bg-white', 'text-brand-secondary', 'border-brand-secondary');
                el.classList.remove('bg-brand-secondary', 'text-white', 'text-gray-400', 'border-gray-300');
            } else {
                // Future
                el.classList.add('bg-white', 'text-gray-400', 'border-gray-300');
                el.classList.remove('bg-brand-secondary', 'text-white', 'text-brand-secondary', 'border-brand-secondary');
            }
        });

        // Update Progress Bar Line
        let progress = ((currentStep - 1) / 3) * 100;
        document.getElementById('progressFill').style.width = progress + '%';

        // Update Right Panel Summary
        document.getElementById('summaryBlockStep1').classList.add('hidden');
        document.getElementById('summaryBlockStep2').classList.add('hidden');
        document.getElementById('summaryBlockStep4').classList.add('hidden');
        document.getElementById('sharedBillBlock').classList.add('hidden');
        document.getElementById('btnNext').classList.remove('hidden');
        document.getElementById('btnPay').classList.add('hidden');
        document.getElementById('safePaymentsText').classList.add('hidden');
        
        // Default Button State
        document.getElementById('btnNext').disabled = false;
        document.getElementById('btnNext').classList.remove('opacity-50', 'cursor-not-allowed');

        if(currentStep === 1) {
            document.getElementById('summaryBlockStep1').classList.remove('hidden');
        } else if(currentStep === 2) {
            document.getElementById('summaryBlockStep2').classList.remove('hidden');
            document.getElementById('sharedBillBlock').classList.remove('hidden');
        } else if(currentStep === 3) {
            document.getElementById('sharedBillBlock').classList.remove('hidden');
            if(!isPincodeVerified) {
                document.getElementById('btnNext').disabled = true;
                document.getElementById('btnNext').classList.add('opacity-50', 'cursor-not-allowed');
            }
        } else if(currentStep === 4) {
            document.getElementById('summaryBlockStep4').classList.remove('hidden');
            document.getElementById('btnNext').classList.add('hidden');
            document.getElementById('btnPay').classList.remove('hidden');
            document.getElementById('safePaymentsText').classList.remove('hidden');
        }
    }

    function nextStep() {
        if(currentStep === 3 && !isPincodeVerified) {
            alert('Please verify a valid pincode first.');
            return;
        }
        if (currentStep < 4) {
            currentStep++;
            updateUI();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }

    function verifyPincode() {
        let val = document.getElementById('pincodeInput').value.trim();
        let errorEl = document.getElementById('pincodeError');
        let successEl = document.getElementById('pincodeSuccess');
        if (validPincodes.includes(val)) {
            errorEl.classList.add('hidden');
            successEl.classList.remove('hidden');
            isPincodeVerified = true;
            document.getElementById('addressAndSlotSection').classList.remove('hidden');
            updateUI(); // Unlock next button
        } else {
            errorEl.classList.remove('hidden');
            successEl.classList.add('hidden');
            isPincodeVerified = false;
            document.getElementById('addressAndSlotSection').classList.add('hidden');
            updateUI(); // Lock next button
        }
    }

    function saveNewMember() {
        // Get values
        let name = document.getElementById('newMemberName').value.trim();
        let age = document.getElementById('newMemberAge').value.trim();
        let gender = document.querySelector('input[name="new_member_gender"]:checked').value;
        let relation = document.querySelector('input[name="new_member_relation"]:checked').value;

        if (!name || !age) {
            alert('Please enter name and age.');
            return;
        }

        // Title case gender & relation
        gender = gender.charAt(0).toUpperCase() + gender.slice(1);
        relation = relation.charAt(0).toUpperCase() + relation.slice(1);
        
        // Capitalize first name for display
        let firstName = name.split(' ')[0];
        firstName = firstName.charAt(0).toUpperCase() + firstName.slice(1);

        // Generate ID
        let idCount = document.querySelectorAll('#step2 .bg-red-50\\/30').length + 1;

        // Build HTML for new member
        let html = `
            <div class="bg-red-50/30 border border-red-100 rounded-xl p-4 flex items-start mt-4">
                <div class="pt-1 mr-4">
                    <div class="w-6 h-6 rounded bg-brand-dark text-white flex items-center justify-center text-xs">
                        <i class="fas fa-check"></i>
                    </div>
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-bold text-gray-900 text-lg flex items-center">${firstName} <span class="text-[10px] bg-gray-200 text-gray-600 px-2 py-0.5 rounded ml-2 uppercase">${relation}</span></h3>
                            <p class="text-xs text-gray-500 font-semibold mt-1">${age} Years | ${gender} | <button class="text-brand-dark underline font-bold">Edit</button></p>
                        </div>
                        <div class="font-bold text-gray-800">(${idCount}) <i class="fas fa-chevron-up text-gray-400 ml-2"></i></div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-red-100 flex justify-between items-center">
                        <span class="text-sm font-semibold text-red-500 w-3/4 leading-tight">Fit India Full Body Checkup With Vitamin Screening with Free Heart Test (HsCRP)</span>
                        <div class="w-5 h-5 rounded border border-gray-300 text-gray-300 flex items-center justify-center text-[10px] cursor-pointer hover:bg-brand-dark hover:text-white hover:border-brand-dark transition">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Append to Step 2
        document.getElementById('step2').insertAdjacentHTML('beforeend', html);

        // Reset form and close modal
        document.getElementById('addMemberForm').reset();
        window.closeAddMemberModal();
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', () => {
        updateUI();

        // Date Selection Logic
        const dateItems = document.querySelectorAll('.date-item');
        dateItems.forEach(item => {
            item.addEventListener('click', () => {
                // Remove active classes from all
                dateItems.forEach(d => {
                    d.classList.remove('border-2', 'border-brand-secondary', 'bg-brand-light/10', 'text-brand-secondary', 'active-date');
                    d.classList.add('border', 'border-gray-200', 'bg-white');
                    const spans = d.querySelectorAll('span');
                    if(spans.length === 3) {
                        spans[0].classList.add('text-gray-500'); spans[0].classList.remove('text-brand-secondary');
                        spans[1].classList.add('text-gray-800'); spans[1].classList.remove('text-brand-secondary');
                        spans[2].classList.add('text-gray-500'); spans[2].classList.remove('text-brand-secondary');
                    }
                });
                
                // Add active classes to clicked
                item.classList.add('border-2', 'border-brand-secondary', 'bg-brand-light/10', 'text-brand-secondary', 'active-date');
                item.classList.remove('border', 'border-gray-200', 'bg-white');
                const spans = item.querySelectorAll('span');
                if(spans.length === 3) {
                    spans[0].classList.remove('text-gray-500'); spans[0].classList.add('text-brand-secondary');
                    spans[1].classList.remove('text-gray-800'); spans[1].classList.add('text-brand-secondary');
                    spans[2].classList.remove('text-gray-500'); spans[2].classList.add('text-brand-secondary');
                }
            });
        });

        // Slot Selection Logic
        const slotItems = document.querySelectorAll('.slot-item');
        slotItems.forEach(item => {
            item.addEventListener('click', () => {
                // Remove active classes from all
                slotItems.forEach(s => {
                    s.classList.remove('border-2', 'border-brand-secondary', 'bg-brand-light/10', 'text-brand-dark', 'active-slot');
                    s.classList.add('border', 'border-gray-200', 'bg-white', 'text-gray-600');
                });
                
                // Add active classes to clicked
                item.classList.add('border-2', 'border-brand-secondary', 'bg-brand-light/10', 'text-brand-dark', 'active-slot');
                item.classList.remove('border', 'border-gray-200', 'bg-white', 'text-gray-600');
            });
        });
    });
</script>
@endsection
