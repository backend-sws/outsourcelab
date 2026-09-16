<?php
    $welcomeOffer = \App\Models\Coupon::where('is_active', true)
        ->where('coupon_type', 'welcome')
        ->latest()
        ->first();
    $isPatientLoggedIn = session()->has('patient_id');
?>

<?php if($welcomeOffer): ?>
<div id="floatingWelcomeTicketWrapper" 
    data-is-logged-in="<?php echo e($isPatientLoggedIn ? '1' : '0'); ?>" 
    data-coupons-url="<?php echo e(route('patient.coupons')); ?>"
    class="fixed bottom-5 right-5 z-40 select-none">
    <style>
        /* Irregular Ticket Clip Path with Notches on all 4 sides and cut corners */
        .irregular-ticket-shape {
            clip-path: polygon(
                0% 10px, 10px 0%,
                calc(50% - 12px) 0%, calc(50% - 9px) 6px, calc(50% + 9px) 6px, calc(50% + 12px) 0%,
                calc(100% - 10px) 0%, 100% 10px,
                100% calc(50% - 12px), calc(100% - 6px) calc(50% - 9px), calc(100% - 6px) calc(50% + 9px), 100% calc(50% + 12px),
                100% calc(100% - 10px), calc(100% - 10px) 100%,
                calc(50% + 12px) 100%, calc(50% + 9px) calc(100% - 6px), calc(50% - 9px) calc(100% - 6px), calc(50% - 12px) 100%,
                10px 100%, 0% calc(100% - 10px),
                0% calc(50% + 12px), 6px calc(50% + 9px), 6px calc(50% - 9px), 0% calc(50% - 12px)
            );
        }

        @keyframes welcomeTicketFloat {
            0%, 100% {
                transform: translateY(0px) rotate(-3deg);
            }
            50% {
                transform: translateY(-6px) rotate(-1deg);
            }
        }

        .animate-ticket-float {
            animation: welcomeTicketFloat 4s ease-in-out infinite;
            transform-origin: center center;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .animate-ticket-float:hover {
            animation-play-state: paused;
            transform: translateY(-4px) rotate(0deg) scale(1.03);
        }

        /* Subtle ticket shine */
        .ticket-shimmer {
            background: linear-gradient(
                135deg,
                rgba(255, 255, 255, 0) 0%,
                rgba(255, 255, 255, 0.25) 50%,
                rgba(255, 255, 255, 0) 100%
            );
            background-size: 200% 200%;
            animation: ticketShimmer 3s infinite;
        }

        @keyframes ticketShimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
    </style>

    <!-- Main Floating Square Ticket Container (Compact) -->
    <div id="welcomeTicketCard" class="relative group">
        <!-- Close / Dismiss Button -->
        <button type="button" onclick="event.stopPropagation(); dismissWelcomeTicket();" 
            class="absolute -top-1.5 -right-1.5 z-50 w-5 h-5 rounded-full bg-slate-900/90 hover:bg-rose-600 text-white text-[10px] font-bold flex items-center justify-center shadow-md border border-white/30 transition-all active:scale-90" 
            title="Close offer">
            <i class="fas fa-times"></i>
        </button>

        <!-- Drop Shadow wrapper following irregular clip-path -->
        <div class="filter drop-shadow-[0_8px_18px_rgba(245,158,11,0.4)] cursor-pointer" onclick="handleWelcomeTicketClick()">
            <!-- The Compact Square Irregular Ticket -->
            <div class="irregular-ticket-shape animate-ticket-float w-[170px] h-[170px] sm:w-[180px] sm:h-[180px] bg-gradient-to-br from-amber-400 via-orange-500 to-amber-600 p-2 sm:p-2.5 flex flex-col justify-between text-white relative overflow-hidden">
                <!-- Shimmer Overlay -->
                <div class="absolute inset-0 ticket-shimmer pointer-events-none"></div>

                <!-- Ticket Inner Dashed Border Frame -->
                <div class="absolute inset-1.5 border border-dashed border-white/40 rounded pointer-events-none"></div>

                <!-- 1. Header: Admit One / Welcome Pass -->
                <div class="relative z-10 flex items-center justify-between px-1 pt-0.5">
                    <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded-full bg-slate-950/40 backdrop-blur-xs text-[8px] font-black uppercase tracking-wider text-amber-200 border border-amber-300/30">
                        <i class="fas fa-ticket-alt text-[7px] text-amber-300 -rotate-12"></i>
                        <span>WELCOME</span>
                    </span>
                    <span class="text-[8px] font-mono font-bold text-white/90">#<?php echo e($welcomeOffer->code); ?></span>
                </div>

                <!-- 2. Center: Discount Details -->
                <div class="relative z-10 text-center my-auto px-1">
                    <div class="text-[8px] font-extrabold text-amber-100 uppercase tracking-wider">
                        First Visit Gift
                    </div>
                    <div class="text-2xl sm:text-[26px] font-black tracking-tight text-white drop-shadow-[0_2px_4px_rgba(0,0,0,0.4)] leading-tight">
                        <?php if($welcomeOffer->discount_type === 'percentage'): ?>
                            <?php echo e(intval($welcomeOffer->discount_value)); ?>% <span class="text-base sm:text-lg font-extrabold text-amber-200">OFF</span>
                        <?php else: ?>
                            ₹<?php echo e(number_format($welcomeOffer->discount_value)); ?> <span class="text-base sm:text-lg font-extrabold text-amber-200">OFF</span>
                        <?php endif; ?>
                    </div>
                    <div class="text-[8px] font-medium text-white/90 leading-none mt-0.5">
                        1st Lab Booking
                    </div>

                    <!-- Coupon Code Tag -->
                    <div class="mt-1 inline-block">
                        <span class="px-2 py-0.5 rounded bg-slate-950 text-amber-300 font-mono font-black text-[10px] uppercase tracking-wider border border-amber-400/50 shadow-xs">
                            <?php echo e($welcomeOffer->code); ?>

                        </span>
                    </div>
                </div>

                <!-- 3. Perforated Dashed Tear Line -->
                <div class="relative z-10 my-0.5 flex items-center justify-center">
                    <div class="w-full border-b border-dashed border-white/40"></div>
                </div>

                <!-- 4. Footer: Claim CTA Button & Barcode -->
                <div class="relative z-10 px-0.5 pb-0.5">
                    <button type="button" class="w-full py-1 px-2 rounded bg-slate-950 hover:bg-black text-amber-300 font-extrabold text-[9px] uppercase tracking-wider flex items-center justify-center gap-1 shadow-sm border border-amber-400/40 group-hover:scale-[1.02] transition-all">
                        <span>Claim Offer</span>
                        <i class="fas fa-arrow-right text-[8px] group-hover:translate-x-0.5 transition-transform"></i>
                    </button>

                    <!-- Mini Barcode & Notice -->
                    <div class="flex items-center justify-between text-[7px] font-mono text-white/75 mt-0.5 px-0.5">
                        <span>|||| |||</span>
                        <span><?php echo e($isPatientLoggedIn ? 'My Coupons' : 'Login & Claim'); ?></span>
                        <span>||| ||||</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Minimized Pill (Shown when closed so customer can re-open) -->
    <div id="welcomeTicketMiniPill" class="hidden">
        <button type="button" onclick="reopenWelcomeTicket()" 
            class="flex items-center gap-2 px-3.5 py-2 rounded-full bg-gradient-to-r from-amber-500 to-orange-500 text-white text-xs font-black shadow-xl hover:scale-105 active:scale-95 transition-all border-2 border-white">
            <i class="fas fa-gift text-amber-200 animate-bounce"></i>
            <span><?php echo e($welcomeOffer->discount_type === 'percentage' ? intval($welcomeOffer->discount_value) . '% OFF' : '₹' . number_format($welcomeOffer->discount_value) . ' OFF'); ?> Ticket</span>
        </button>
    </div>
</div>

<script>
    function handleWelcomeTicketClick() {
        const wrapper = document.getElementById('floatingWelcomeTicketWrapper');
        const isLoggedIn = wrapper ? wrapper.getAttribute('data-is-logged-in') === '1' : false;
        const couponsUrl = wrapper ? wrapper.getAttribute('data-coupons-url') : '/patient/coupons';

        if (isLoggedIn) {
            window.location.href = couponsUrl;
        } else {
            if (typeof window.openLoginModal === 'function') {
                window.openLoginModal(false);
            } else {
                window.location.href = "/";
            }
        }
    }

    function dismissWelcomeTicket() {
        const card = document.getElementById('welcomeTicketCard');
        const pill = document.getElementById('welcomeTicketMiniPill');
        if (card && pill) {
            card.classList.add('hidden');
            pill.classList.remove('hidden');
        }
    }

    function reopenWelcomeTicket() {
        const card = document.getElementById('welcomeTicketCard');
        const pill = document.getElementById('welcomeTicketMiniPill');
        if (card && pill) {
            pill.classList.add('hidden');
            card.classList.remove('hidden');
        }
    }
</script>
<?php endif; ?>
<?php /**PATH D:\laravel\outsourcelab\resources\views/partials/floating-welcome-ticket.blade.php ENDPATH**/ ?>