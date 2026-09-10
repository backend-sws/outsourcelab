<?php $__env->startSection('title', isset($coupon) ? 'Edit Coupon: ' . $coupon->code : 'Create Coupon'); ?>
<?php $__env->startSection('header', isset($coupon) ? 'Edit Coupon' : 'Create Coupon'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto">
    <!-- Header & Back Button -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-3">
            <a href="<?php echo e(route('admin.coupons.index')); ?>" class="w-9 h-9 rounded-xl bg-white dark:bg-white/[0.05] border border-slate-200 dark:border-white/[0.08] text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white flex items-center justify-center transition-all shadow-sm">
                <i class="fas fa-arrow-left text-xs"></i>
            </a>
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white">
                    <?php echo e(isset($coupon) ? 'Edit Coupon: ' . $coupon->code : 'Create New Coupon'); ?>

                </h1>
                <p class="text-xs text-slate-500 dark:text-slate-400">
                    Configure first-login discounts, minimum order banner coupons, and validity limits.
                </p>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white dark:bg-[#12142d] rounded-2xl p-6 sm:p-8 border border-slate-200 dark:border-white/[0.06] shadow-sm">
        <?php if($errors->any()): ?>
            <div class="mb-6 p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-600 dark:text-rose-400 text-xs font-semibold">
                <ul class="list-disc list-inside space-y-1">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(isset($coupon) ? route('admin.coupons.update', $coupon->id) : route('admin.coupons.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php if(isset($coupon)): ?>
                <?php echo method_field('PUT'); ?>
            <?php endif; ?>

            <div class="space-y-6">
                <!-- Section 1: Basic Information -->
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400 mb-4 flex items-center gap-2">
                        <i class="fas fa-info-circle"></i>
                        <span>Basic Details</span>
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Code -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wide mb-1.5">
                                Coupon Code <span class="text-rose-500">*</span>
                            </label>
                            <div class="flex gap-2">
                                <input type="text" name="code" id="couponCodeInput" value="<?php echo e(old('code', $coupon->code ?? '')); ?>" required placeholder="e.g. WELCOME15, SAVE20"
                                    class="flex-1 px-4 py-2.5 rounded-xl uppercase font-mono font-bold bg-slate-50 dark:bg-white/[0.04] border border-slate-200 dark:border-white/[0.08] text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500/50">
                                <button type="button" onclick="generateCode()" class="px-3 py-2 bg-slate-100 dark:bg-white/[0.06] text-slate-700 dark:text-slate-300 hover:bg-slate-200 rounded-xl text-xs font-semibold transition">
                                    <i class="fas fa-wand-magic-sparkles mr-1"></i> Auto
                                </button>
                            </div>
                            <span class="text-[10px] text-slate-400 mt-1 block">Uppercase, unique code used by customers at checkout.</span>
                        </div>

                        <!-- Title -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wide mb-1.5">
                                Coupon Title <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="title" value="<?php echo e(old('title', $coupon->title ?? '')); ?>" required placeholder="e.g. First Time Login Welcome Discount"
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-white/[0.04] border border-slate-200 dark:border-white/[0.08] text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500/50">
                            <span class="text-[10px] text-slate-400 mt-1 block">Short descriptive name shown to user.</span>
                        </div>

                        <!-- Description -->
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wide mb-1.5">
                                Description
                            </label>
                            <textarea name="description" rows="2" placeholder="e.g. Enjoy 15% discount on all health packages & lab tests for your first diagnostic order."
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-white/[0.04] border border-slate-200 dark:border-white/[0.08] text-xs text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500/50"><?php echo e(old('description', $coupon->description ?? '')); ?></textarea>
                        </div>
                    </div>
                </div>

                <hr class="border-slate-100 dark:border-white/[0.06]">

                <!-- Section 2: Coupon Type & Discount Configuration -->
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400 mb-4 flex items-center gap-2">
                        <i class="fas fa-sliders"></i>
                        <span>Type & Discount Calculation</span>
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <!-- Coupon Type -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wide mb-1.5">
                                Coupon Category <span class="text-rose-500">*</span>
                            </label>
                            <select name="coupon_type" id="couponTypeSelect" onchange="onTypeChange()" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-white/[0.04] border border-slate-200 dark:border-white/[0.08] text-xs text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 font-medium">
                                <option value="welcome" <?php echo e(old('coupon_type', $coupon->coupon_type ?? 'welcome') === 'welcome' ? 'selected' : ''); ?>>🎁 First Login Welcome (Auto assigned to users)</option>
                                <option value="banner" <?php echo e(old('coupon_type', $coupon->coupon_type ?? '') === 'banner' ? 'selected' : ''); ?>>📢 Banner Offer (Min Order Threshold)</option>
                                <option value="general" <?php echo e(old('coupon_type', $coupon->coupon_type ?? '') === 'general' ? 'selected' : ''); ?>>🏷️ Standard Coupon</option>
                            </select>
                            <span class="text-[10px] text-slate-400 mt-1 block">First login coupons show in user profile and checkout automatically.</span>
                        </div>

                        <!-- Discount Type -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wide mb-1.5">
                                Discount Calculation <span class="text-rose-500">*</span>
                            </label>
                            <select name="discount_type" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-white/[0.04] border border-slate-200 dark:border-white/[0.08] text-xs text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 font-medium">
                                <option value="percentage" <?php echo e(old('discount_type', $coupon->discount_type ?? 'percentage') === 'percentage' ? 'selected' : ''); ?>>Percentage (%) Discount</option>
                                <option value="fixed" <?php echo e(old('discount_type', $coupon->discount_type ?? '') === 'fixed' ? 'selected' : ''); ?>>Fixed Amount (₹) Flat Discount</option>
                            </select>
                        </div>

                        <!-- Discount Value -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wide mb-1.5">
                                Discount Value <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" step="0.01" name="discount_value" value="<?php echo e(old('discount_value', $coupon->discount_value ?? '15')); ?>" required min="0.01" placeholder="e.g. 15 or 200"
                                    class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-white/[0.04] border border-slate-200 dark:border-white/[0.08] text-sm font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500/50">
                            </div>
                            <span class="text-[10px] text-slate-400 mt-1 block">e.g. 15 for 15% discount, or 200 for ₹200 off.</span>
                        </div>
                    </div>

                    <!-- Row 2: Spend Limits -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                        <!-- Min Order Amount -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wide mb-1.5">
                                Minimum Order Amount (₹)
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-sm">₹</span>
                                <input type="number" step="0.01" name="min_order_amount" id="minOrderInput" value="<?php echo e(old('min_order_amount', $coupon->min_order_amount ?? '0')); ?>" min="0" placeholder="0"
                                    class="w-full pl-8 pr-4 py-2.5 rounded-xl bg-slate-50 dark:bg-white/[0.04] border border-slate-200 dark:border-white/[0.08] text-sm font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500/50">
                            </div>
                            <span class="text-[10px] text-slate-400 mt-1 block">User's test cart must exceed this value for discount to apply (e.g. ₹999).</span>
                        </div>

                        <!-- Max Discount Cap (Optional) -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wide mb-1.5">
                                Maximum Discount Cap (₹) (Optional)
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-sm">₹</span>
                                <input type="number" step="0.01" name="max_discount_amount" value="<?php echo e(old('max_discount_amount', $coupon->max_discount_amount ?? '')); ?>" min="0" placeholder="e.g. 500"
                                    class="w-full pl-8 pr-4 py-2.5 rounded-xl bg-slate-50 dark:bg-white/[0.04] border border-slate-200 dark:border-white/[0.08] text-sm font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500/50">
                            </div>
                            <span class="text-[10px] text-slate-400 mt-1 block">Leave empty for no maximum discount limit.</span>
                        </div>
                    </div>
                </div>

                <hr class="border-slate-100 dark:border-white/[0.06]">

                <!-- Section 3: Website Banner Configuration -->
                <div class="p-5 rounded-2xl bg-amber-500/5 border border-amber-500/20">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-amber-600 dark:text-amber-400 flex items-center gap-2">
                            <i class="fas fa-bullhorn"></i>
                            <span>Website Top Banner Promotion</span>
                        </h3>
                        <button type="button" onclick="generateBannerText(true)" class="px-2.5 py-1 rounded-lg bg-amber-500/10 hover:bg-amber-500/20 text-amber-700 dark:text-amber-300 text-xs font-bold transition flex items-center gap-1.5 border border-amber-500/30">
                            <i class="fas fa-wand-magic-sparkles text-[10px]"></i>
                            <span>Auto Generate Text</span>
                        </button>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="is_banner" id="isBannerCheckbox" value="1" <?php echo e(old('is_banner', $coupon->is_banner ?? false) ? 'checked' : ''); ?>

                                class="w-4 h-4 rounded text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                            <label for="isBannerCheckbox" class="ml-2 text-xs font-bold text-slate-800 dark:text-slate-200 cursor-pointer">
                                Display this coupon as an announcement banner on top of the website
                            </label>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wide">
                                    Custom Banner Text
                                </label>
                                <span id="manualEditIndicator" class="hidden text-[10px] text-amber-600 font-semibold flex items-center gap-1">
                                    <i class="fas fa-pen text-[9px]"></i> Edited manually (will save as typed)
                                </span>
                            </div>
                            <input type="text" name="banner_text" id="bannerTextInput" 
                                data-is-edit="<?php echo e(isset($coupon) && !empty($coupon->banner_text) ? '1' : '0'); ?>"
                                value="<?php echo e(old('banner_text', $coupon->banner_text ?? '')); ?>" placeholder="e.g. Flat 20% OFF on all lab tests for bookings above ₹999! Use Code: WELLCARE20"
                                class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-white/[0.04] border border-slate-200 dark:border-white/[0.08] text-xs text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500/50 transition">
                            
                            <!-- Quick Text Suggestion Pills -->
                            <div class="mt-2.5 flex flex-wrap items-center gap-1.5">
                                <span class="text-[10px] text-slate-400 font-semibold mr-1">Quick Templates:</span>
                                <button type="button" onclick="setTemplate('offer')" class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-white dark:bg-white/[0.05] border border-slate-200 dark:border-white/[0.08] text-slate-700 dark:text-slate-300 hover:border-amber-400 hover:text-amber-600 transition">
                                    📢 Min Spend Deal
                                </button>
                                <button type="button" onclick="setTemplate('welcome')" class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-white dark:bg-white/[0.05] border border-slate-200 dark:border-white/[0.08] text-slate-700 dark:text-slate-300 hover:border-amber-400 hover:text-amber-600 transition">
                                    🎁 Welcome Reward
                                </button>
                                <button type="button" onclick="setTemplate('flat')" class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-white dark:bg-white/[0.05] border border-slate-200 dark:border-white/[0.08] text-slate-700 dark:text-slate-300 hover:border-amber-400 hover:text-amber-600 transition">
                                    ⚡ Limited Period Offer
                                </button>
                                <button type="button" onclick="generateBannerText(true)" class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 hover:bg-amber-200 transition ml-auto">
                                    ↺ Reset Auto-Text
                                </button>
                            </div>
                            <span class="text-[10px] text-slate-400 mt-1.5 block">Auto-text updates in real time based on discount, min order & code. You can also edit it manually to finalize.</span>
                        </div>
                    </div>
                </div>

                <!-- Section 4: Validity & Active Status -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wide mb-1.5">
                            Valid From
                        </label>
                        <input type="date" name="valid_from" value="<?php echo e(old('valid_from', isset($coupon->valid_from) ? $coupon->valid_from->format('Y-m-d') : '')); ?>"
                            class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-white/[0.04] border border-slate-200 dark:border-white/[0.08] text-xs text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500/50">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wide mb-1.5">
                            Valid Until
                        </label>
                        <input type="date" name="valid_until" value="<?php echo e(old('valid_until', isset($coupon->valid_until) ? $coupon->valid_until->format('Y-m-d') : '')); ?>"
                            class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-white/[0.04] border border-slate-200 dark:border-white/[0.08] text-xs text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500/50">
                    </div>

                    <div class="flex items-center pt-6">
                        <input type="checkbox" name="is_active" id="isActiveCheckbox" value="1" <?php echo e(old('is_active', $coupon->is_active ?? true) ? 'checked' : ''); ?>

                            class="w-5 h-5 rounded text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                        <label for="isActiveCheckbox" class="ml-2.5 text-xs font-bold text-slate-800 dark:text-slate-200 cursor-pointer">
                            Active Coupon (Can be used by customers)
                        </label>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100 dark:border-white/[0.06]">
                    <a href="<?php echo e(route('admin.coupons.index')); ?>" class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-white/[0.08] text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-50 transition">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md shadow-indigo-500/20 transition-all">
                        <?php echo e(isset($coupon) ? 'Update Coupon' : 'Save & Publish Coupon'); ?>

                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    let userHasManuallyEditedBanner = false;

    function generateCode() {
        const type = document.getElementById('couponTypeSelect').value;
        let prefix = 'WELLCARE';
        if (type === 'welcome') prefix = 'WELCOME';
        if (type === 'banner') prefix = 'DEAL';
        const random = Math.floor(10 + Math.random() * 90);
        document.getElementById('couponCodeInput').value = prefix + random;
        if (!userHasManuallyEditedBanner) {
            generateBannerText(false);
        }
    }

    function onTypeChange() {
        const type = document.getElementById('couponTypeSelect').value;
        const isBannerCheckbox = document.getElementById('isBannerCheckbox');
        const minOrderInput = document.getElementById('minOrderInput');

        if (type === 'banner') {
            isBannerCheckbox.checked = true;
            if (minOrderInput.value === '0' || !minOrderInput.value) {
                minOrderInput.value = '999';
            }
        }
        if (!userHasManuallyEditedBanner) {
            generateBannerText(false);
        }
    }

    function generateBannerText(force = false) {
        const codeInput = document.getElementById('couponCodeInput');
        const code = (codeInput?.value || 'OFFER').trim().toUpperCase();
        const discountType = document.querySelector('select[name="discount_type"]')?.value || 'percentage';
        const discountVal = document.querySelector('input[name="discount_value"]')?.value || '15';
        const minOrder = parseFloat(document.getElementById('minOrderInput')?.value || 0);
        const couponType = document.getElementById('couponTypeSelect')?.value || 'general';
        const bannerInput = document.getElementById('bannerTextInput');

        if (!bannerInput) return;

        let discountStr = discountType === 'percentage' ? `${discountVal}% OFF` : `Flat ₹${discountVal} OFF`;

        let text = '';
        if (couponType === 'welcome') {
            text = `🎉 Welcome to Wellcare! Get ${discountStr} on your first lab test booking! Use Code: ${code}`;
        } else if (minOrder > 0) {
            text = `🎉 Special Health Deal: Flat ${discountStr} on all lab tests for bookings above ₹${minOrder}! Use Code: ${code}`;
        } else {
            text = `🎉 Limited Time Offer: Get ${discountStr} on all health checkup packages! Use Code: ${code}`;
        }

        bannerInput.value = text;

        if (force) {
            userHasManuallyEditedBanner = false;
            document.getElementById('manualEditIndicator')?.classList.add('hidden');
            bannerInput.classList.add('ring-2', 'ring-amber-500');
            setTimeout(() => bannerInput.classList.remove('ring-2', 'ring-amber-500'), 800);
        }
    }

    function setTemplate(style) {
        const code = (document.getElementById('couponCodeInput')?.value || 'OFFER').trim().toUpperCase();
        const discountType = document.querySelector('select[name="discount_type"]')?.value || 'percentage';
        const discountVal = document.querySelector('input[name="discount_value"]')?.value || '15';
        const minOrder = parseFloat(document.getElementById('minOrderInput')?.value || 0);
        const bannerInput = document.getElementById('bannerTextInput');

        let discountStr = discountType === 'percentage' ? `${discountVal}% OFF` : `Flat ₹${discountVal} OFF`;

        if (style === 'offer') {
            bannerInput.value = `🎉 Special Offer: Get ${discountStr} on all lab tests on orders above ₹${minOrder > 0 ? minOrder : '999'}! Use Code: ${code}`;
        } else if (style === 'welcome') {
            bannerInput.value = `🎁 First-Time User Special: Enjoy ${discountStr} on your first health checkup! Use Code: ${code}`;
        } else if (style === 'flat') {
            bannerInput.value = `⚡ Limited Period Health Offer: Save ${discountStr} on all diagnostic bookings! Use Code: ${code}`;
        }

        userHasManuallyEditedBanner = true;
        document.getElementById('manualEditIndicator')?.classList.remove('hidden');
    }

    document.addEventListener('DOMContentLoaded', () => {
        const bannerInput = document.getElementById('bannerTextInput');
        const codeInput = document.getElementById('couponCodeInput');
        const discountValInput = document.querySelector('input[name="discount_value"]');
        const discountTypeSelect = document.querySelector('select[name="discount_type"]');
        const minOrderInput = document.getElementById('minOrderInput');

        if (bannerInput) {
            userHasManuallyEditedBanner = bannerInput.getAttribute('data-is-edit') === '1';

            if (!userHasManuallyEditedBanner || !bannerInput.value) {
                generateBannerText(false);
            }

            bannerInput.addEventListener('input', () => {
                userHasManuallyEditedBanner = true;
                document.getElementById('manualEditIndicator')?.classList.remove('hidden');
            });
        }

        const autoUpdateFields = [codeInput, discountValInput, discountTypeSelect, minOrderInput];
        autoUpdateFields.forEach(field => {
            if (field) {
                field.addEventListener('input', () => {
                    if (!userHasManuallyEditedBanner) {
                        generateBannerText(false);
                    }
                });
                field.addEventListener('change', () => {
                    if (!userHasManuallyEditedBanner) {
                        generateBannerText(false);
                    }
                });
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\lab\lab\resources\views/admin/coupons/form.blade.php ENDPATH**/ ?>