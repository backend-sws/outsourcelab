    <!-- Promotional Banner for Banner Coupon with Left-to-Right Moving Ticket -->
    <?php
        $siteBannerCoupon = \App\Models\Coupon::where('is_active', true)->where('is_banner', true)->latest()->first();
    ?>
    <?php if($siteBannerCoupon): ?>
        <?php
            $bannerText = $siteBannerCoupon->banner_text ?: ($siteBannerCoupon->title . ': ' . ($siteBannerCoupon->discount_type === 'percentage' ? $siteBannerCoupon->discount_value . '% OFF' : 'Flat ₹' . number_format($siteBannerCoupon->discount_value) . ' OFF') . ($siteBannerCoupon->min_order_amount > 0 ? ' on bookings above ₹' . number_format($siteBannerCoupon->min_order_amount) : ''));
        ?>
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
                    <?php for($i = 0; $i < 3; $i++): ?>
                        <div class="inline-flex items-center gap-3">
                            <span class="flex items-center gap-2 text-xs md:text-sm font-semibold tracking-wide text-white drop-shadow-sm">
                                <i class="fas fa-bullhorn text-amber-300"></i>
                                <span><?php echo e($bannerText); ?></span>
                            </span>
                            
                            <!-- Authentic Coupon Ticket (Code Show Only, No Copy Button) -->
                            <div class="coupon-ticket-badge">
                                <i class="fas fa-ticket-alt text-amber-950 text-xs -rotate-12"></i>
                                <span class="text-[9px] font-sans font-bold uppercase tracking-wider text-amber-900">TICKET:</span>
                                <span class="bg-slate-950 text-yellow-300 px-1.5 py-0.5 rounded text-xs font-black tracking-widest"><?php echo e($siteBannerCoupon->code); ?></span>
                            </div>

                            <span class="text-amber-400/60 text-xs ml-3">✦</span>
                        </div>
                    <?php endfor; ?>
                </div>

                <!-- Group 2 (Duplicate for 100% seamless infinite loop) -->
                <div class="flex items-center gap-10 pr-10" aria-hidden="true">
                    <?php for($i = 0; $i < 3; $i++): ?>
                        <div class="inline-flex items-center gap-3">
                            <span class="flex items-center gap-2 text-xs md:text-sm font-semibold tracking-wide text-white drop-shadow-sm">
                                <i class="fas fa-bullhorn text-amber-300"></i>
                                <span><?php echo e($bannerText); ?></span>
                            </span>
                            
                            <!-- Authentic Coupon Ticket (Code Show Only, No Copy Button) -->
                            <div class="coupon-ticket-badge">
                                <i class="fas fa-ticket-alt text-amber-950 text-xs -rotate-12"></i>
                                <span class="text-[9px] font-sans font-bold uppercase tracking-wider text-amber-900">TICKET:</span>
                                <span class="bg-slate-950 text-yellow-300 px-1.5 py-0.5 rounded text-xs font-black tracking-widest"><?php echo e($siteBannerCoupon->code); ?></span>
                            </div>

                            <span class="text-amber-400/60 text-xs ml-3">✦</span>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Top Header -->
    <div class="bg-white py-4 px-4 border-b">
        <div class="container mx-auto flex justify-between items-center text-sm">
            <div class="flex items-center space-x-4">
                <img src="<?php echo e(asset('logo.jpeg')); ?>" alt="Logo" class="h-10">
                <div class="flex items-center ml-2">
                    <span class="text-brand-primary font-extrabold text-2xl tracking-tight">Wellcare</span>
                    <span class="text-brand-secondary font-extrabold text-2xl tracking-tight ml-1">Diagnostics</span>
                </div>
            </div>
            <div class="flex items-center space-x-6">
                <button onclick="proceedToCheckout()" class="flex items-center font-semibold border rounded-full px-5 py-2 shadow-sm hover:bg-gray-50 transition"><i class="fas fa-shopping-cart text-gray-500 mr-2"></i> Cart <span id="cartCount" class="bg-gray-200 text-xs rounded-full px-2 py-0.5 ml-1 font-bold">0</span></button>
                <?php
                    $loggedInPatient = session('patient_id') ? \App\Models\Patient::find(session('patient_id')) : null;
                ?>
                <?php if($loggedInPatient): ?>
                    <a href="<?php echo e(route('patient.dashboard')); ?>" class="flex items-center font-semibold border border-brand-secondary rounded-full px-5 py-2 shadow-sm bg-brand-light/10 hover:bg-brand-light/20 transition text-brand-dark"><i class="far fa-user text-brand-secondary mr-2"></i> <?php echo e(explode(' ', $loggedInPatient->name ?? 'Guest')[0]); ?></a>
                <?php else: ?>
                    <button onclick="window.openLoginModal()" class="flex items-center font-semibold border rounded-full px-5 py-2 shadow-sm hover:bg-gray-50 transition"><i class="far fa-user text-gray-500 mr-2"></i> Profile</button>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 py-5 flex justify-between items-center relative">
            <!-- Left: Menu -->
            <div class="flex-none">
                <button class="text-gray-700 font-bold flex items-center text-lg hover:text-brand-primary transition"><i class="fas fa-bars mr-3 text-xl"></i> Menu</button>
            </div>
            
            <!-- Center: Links -->
            <div class="hidden lg:flex absolute left-1/2 transform -translate-x-1/2 items-center space-x-10">
                <a href="/" class="text-brand-secondary font-extrabold flex items-center text-base hover:text-brand-primary transition"><i class="fas fa-home mr-1.5"></i> Home</a>
                <?php if($loggedInPatient): ?>
                    <a href="<?php echo e(route('patient.bookings')); ?>" class="text-brand-dark font-extrabold flex items-center text-base hover:text-brand-secondary transition"><i class="far fa-calendar-check mr-1.5"></i> My Bookings</a>
                    <a href="<?php echo e(route('patient.reports')); ?>" class="text-brand-dark font-extrabold flex items-center text-base hover:text-brand-secondary transition"><i class="far fa-file-alt mr-1.5"></i> My Reports</a>
                <?php else: ?>
                    <button onclick="window.openLoginModal()" class="text-brand-dark font-extrabold flex items-center text-base hover:text-brand-secondary transition"><i class="far fa-calendar-check mr-1.5"></i> My Bookings</button>
                    <button onclick="window.openLoginModal()" class="text-brand-dark font-extrabold flex items-center text-base hover:text-brand-secondary transition"><i class="far fa-file-alt mr-1.5"></i> My Reports</button>
                <?php endif; ?>
                <a href="/#reviews" class="text-brand-dark font-extrabold flex items-center text-base hover:text-brand-secondary transition"><i class="fas fa-star mr-1.5 text-amber-400"></i> Reviews</a>
                <a href="/#contact-enquiry" class="text-brand-dark font-extrabold flex items-center text-base hover:text-brand-secondary transition"><i class="fas fa-envelope-open-text mr-1.5 text-teal-600"></i> Enquiry</a>
            </div>

            <!-- Right: Phone -->
            <div class="font-bold text-brand-dark flex items-center text-xl flex-none bg-brand-light/20 px-4 py-2 rounded-full border border-brand-light/50 shadow-sm">
                <i class="fas fa-phone-alt text-brand-secondary mr-3 text-lg animate-pulse"></i> +91 0000000000
            </div>
        </div>
    </nav>

<?php /**PATH D:\lab\lab\resources\views/partials/header.blade.php ENDPATH**/ ?>