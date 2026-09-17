<?php $__env->startSection('title', 'Coupons & Offers'); ?>
<?php $__env->startSection('header', 'Coupons'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-black tracking-tight text-slate-900 dark:text-white flex items-center gap-2.5">
            <span class="w-9 h-9 rounded-xl bg-indigo-500/10 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-base">
                <i class="fas fa-ticket-alt"></i>
            </span>
            Coupons & Promotional Offers
        </h1>
        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
            Manage first-time login welcome discounts, minimum spend banner coupons, and promotional campaigns.
        </p>
    </div>
    <div class="flex items-center gap-2">
        <a href="<?php echo e(route('admin.coupons.create')); ?>" class="px-4 py-2.5 rounded-xl text-xs font-bold bg-indigo-600 hover:bg-indigo-700 text-white transition-all flex items-center gap-2 shadow-sm shadow-indigo-500/20">
            <i class="fas fa-plus text-xs"></i>
            <span>Create New Coupon</span>
        </a>
    </div>
</div>

<!-- Metric Overview Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <!-- Total Coupons -->
    <div class="p-5 rounded-2xl bg-white dark:bg-[#12142d] border border-slate-200 dark:border-white/[0.06] shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Coupons</p>
            <h3 class="text-2xl font-black text-slate-900 dark:text-white mt-1.5"><?php echo e(number_format($totalCoupons)); ?></h3>
            <span class="inline-flex items-center text-[11px] font-medium text-slate-500 mt-1">
                Campaign vouchers
            </span>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-indigo-500/10 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-xl shadow-inner">
            <i class="fas fa-tags"></i>
        </div>
    </div>

    <!-- First Login Welcome Coupons -->
    <div class="p-5 rounded-2xl bg-white dark:bg-[#12142d] border border-slate-200 dark:border-white/[0.06] shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Welcome Offer</p>
            <h3 class="text-2xl font-black text-slate-900 dark:text-white mt-1.5"><?php echo e(number_format($welcomeCoupons)); ?> Active</h3>
            <span class="inline-flex items-center text-[11px] font-medium text-purple-600 dark:text-purple-400 mt-1">
                <i class="fas fa-gift mr-1"></i> Auto-assigned on 1st login
            </span>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-purple-500/10 dark:bg-purple-500/20 text-purple-600 dark:text-purple-400 flex items-center justify-center text-xl shadow-inner">
            <i class="fas fa-user-plus"></i>
        </div>
    </div>

    <!-- Banner Offers -->
    <div class="p-5 rounded-2xl bg-white dark:bg-[#12142d] border border-slate-200 dark:border-white/[0.06] shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Banner Coupons</p>
            <h3 class="text-2xl font-black text-slate-900 dark:text-white mt-1.5"><?php echo e(number_format($bannerCoupons)); ?> Live</h3>
            <span class="inline-flex items-center text-[11px] font-medium text-emerald-600 dark:text-emerald-400 mt-1">
                <i class="fas fa-bullhorn mr-1"></i> Min order spend offers
            </span>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xl shadow-inner">
            <i class="fas fa-rectangle-ad"></i>
        </div>
    </div>

    <!-- Total Redemptions -->
    <div class="p-5 rounded-2xl bg-white dark:bg-[#12142d] border border-slate-200 dark:border-white/[0.06] shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Redeemed</p>
            <h3 class="text-2xl font-black text-slate-900 dark:text-white mt-1.5"><?php echo e(number_format($totalUsedCoupons)); ?></h3>
            <span class="inline-flex items-center text-[11px] font-medium text-amber-600 dark:text-amber-400 mt-1">
                <i class="fas fa-check-circle mr-1"></i> Discount bookings placed
            </span>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-amber-500/10 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400 flex items-center justify-center text-xl shadow-inner">
            <i class="fas fa-receipt"></i>
        </div>
    </div>
</div>

<!-- Search & Filters -->
<div class="p-4 rounded-2xl bg-white dark:bg-[#12142d] border border-slate-200 dark:border-white/[0.06] shadow-sm">
    <form method="GET" action="<?php echo e(route('admin.coupons.index')); ?>" class="flex flex-col lg:flex-row gap-3 items-stretch lg:items-center justify-between">
        <div class="flex-1 flex flex-col sm:flex-row gap-3">
            <!-- Search -->
            <div class="relative flex-1">
                <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search by coupon code or title..." 
                    class="w-full pl-9 pr-4 py-2.5 bg-slate-50 dark:bg-white/[0.04] border border-slate-200 dark:border-white/[0.08] rounded-xl text-xs text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/50">
            </div>

            <!-- Type Filter -->
            <div class="sm:w-52">
                <select name="type" onchange="this.form.submit()" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-white/[0.04] border border-slate-200 dark:border-white/[0.08] rounded-xl text-xs text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/50">
                    <option value="">All Types</option>
                    <option value="welcome" <?php echo e(request('type') === 'welcome' ? 'selected' : ''); ?>>First Login Welcome</option>
                    <option value="banner" <?php echo e(request('type') === 'banner' ? 'selected' : ''); ?>>Banner (Min Order Amount)</option>
                    <option value="general" <?php echo e(request('type') === 'general' ? 'selected' : ''); ?>>General Promotional</option>
                </select>
            </div>

            <!-- Status Filter -->
            <div class="sm:w-44">
                <select name="status" onchange="this.form.submit()" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-white/[0.04] border border-slate-200 dark:border-white/[0.08] rounded-xl text-xs text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/50">
                    <option value="">All Statuses</option>
                    <option value="active" <?php echo e(request('status') === 'active' ? 'selected' : ''); ?>>Active Only</option>
                    <option value="inactive" <?php echo e(request('status') === 'inactive' ? 'selected' : ''); ?>>Inactive Only</option>
                </select>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <button type="submit" class="px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold shadow-sm transition-colors flex items-center justify-center gap-1.5">
                <i class="fas fa-filter text-xs"></i>
                <span>Filter</span>
            </button>
            <?php if(request()->hasAny(['search', 'type', 'status'])): ?>
                <a href="<?php echo e(route('admin.coupons.index')); ?>" class="px-3.5 py-2.5 rounded-xl bg-slate-100 dark:bg-white/[0.05] text-slate-600 dark:text-slate-300 hover:text-slate-900 text-xs font-semibold transition-colors">
                    Reset
                </a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Coupons Table Card -->
<div class="bg-white dark:bg-[#12142d] rounded-2xl shadow-sm border border-slate-200 dark:border-white/[0.06] overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/75 dark:bg-white/[0.02] border-b border-slate-200 dark:border-white/[0.06] text-slate-400 dark:text-slate-400 text-[11px] uppercase tracking-wider">
                    <th class="px-6 py-4 font-bold">Coupon Code</th>
                    <th class="px-6 py-4 font-bold">Title & Type</th>
                    <th class="px-6 py-4 font-bold">Discount Value</th>
                    <th class="px-6 py-4 font-bold">Min Order Amount</th>
                    <th class="px-6 py-4 font-bold text-center">Banner Promo</th>
                    <th class="px-6 py-4 font-bold text-center">Usage</th>
                    <th class="px-6 py-4 font-bold text-center">Status</th>
                    <th class="px-6 py-4 font-bold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-white/[0.04] text-xs">
                <?php $__empty_1 = true; $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coupon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50/60 dark:hover:bg-white/[0.02] transition-colors group">
                        <!-- Code -->
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="font-mono font-black text-sm px-2.5 py-1 rounded-lg bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 border border-indigo-200/60 dark:border-indigo-500/20 tracking-wider">
                                    <?php echo e($coupon->code); ?>

                                </span>
                            </div>
                        </td>

                        <!-- Title & Type -->
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                <?php echo e($coupon->title); ?>

                            </div>
                            <div class="mt-1 flex items-center gap-1.5 flex-wrap">
                                <?php if($coupon->coupon_type === 'welcome'): ?>
                                    <span class="inline-flex items-center text-[10px] font-bold px-2 py-0.5 rounded bg-purple-100 text-purple-700 dark:bg-purple-500/20 dark:text-purple-300 border border-purple-200 dark:border-purple-500/30">
                                        <i class="fas fa-gift mr-1 text-[9px]"></i> 1st Time Login Welcome
                                    </span>
                                <?php elseif($coupon->coupon_type === 'banner'): ?>
                                    <span class="inline-flex items-center text-[10px] font-bold px-2 py-0.5 rounded bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-500/30">
                                        <i class="fas fa-bullhorn mr-1 text-[9px]"></i> Banner Offer (Spend > ₹<?php echo e(number_format($coupon->min_order_amount)); ?>)
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center text-[10px] font-bold px-2 py-0.5 rounded bg-slate-100 text-slate-600 dark:bg-white/[0.06] dark:text-slate-300">
                                        Standard Coupon
                                    </span>
                                <?php endif; ?>
                            </div>
                        </td>

                        <!-- Discount Value -->
                        <td class="px-6 py-4">
                            <div class="font-black text-base text-slate-800 dark:text-slate-200">
                                <?php if($coupon->discount_type === 'percentage'): ?>
                                    <?php echo e($coupon->discount_value); ?>% OFF
                                    <?php if($coupon->max_discount_amount): ?>
                                        <span class="text-[10px] text-slate-400 font-normal block">Up to ₹<?php echo e(number_format($coupon->max_discount_amount)); ?></span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    ₹<?php echo e(number_format($coupon->discount_value, 2)); ?> FLAT OFF
                                <?php endif; ?>
                            </div>
                        </td>

                        <!-- Min Order Amount -->
                        <td class="px-6 py-4">
                            <?php if($coupon->min_order_amount > 0): ?>
                                <div class="font-bold text-slate-800 dark:text-slate-200">
                                    ₹<?php echo e(number_format($coupon->min_order_amount, 2)); ?>

                                </div>
                                <span class="text-[10px] text-slate-400">Order threshold</span>
                            <?php else: ?>
                                <span class="text-slate-400 italic text-[11px]">No Minimum</span>
                            <?php endif; ?>
                        </td>

                        <!-- Banner Promo -->
                        <td class="px-6 py-4 text-center">
                            <?php if($coupon->is_banner): ?>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 dark:bg-amber-500/20 dark:text-amber-300 border border-amber-200 dark:border-amber-500/30" title="<?php echo e($coupon->banner_text ?: 'Live on website header'); ?>">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1 animate-pulse"></span> Header Banner
                                </span>
                            <?php else: ?>
                                <span class="text-slate-400 text-[11px]">—</span>
                            <?php endif; ?>
                        </td>

                        <!-- Usage -->
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-100 dark:bg-white/[0.04] text-slate-700 dark:text-slate-300">
                                <?php echo e($coupon->used_count ?? 0); ?> used
                            </span>
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-4 text-center">
                            <form action="<?php echo e(route('admin.coupons.toggle', $coupon->id)); ?>" method="POST" class="inline-block">
                                <?php echo csrf_field(); ?>
                                <button type="submit" title="Click to toggle status" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold transition-transform active:scale-95 <?php echo e($coupon->is_active ? 'bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-300' : 'bg-gray-100 text-gray-600 dark:bg-white/[0.06] dark:text-slate-400'); ?>">
                                    <span class="w-1.5 h-1.5 rounded-full <?php echo e($coupon->is_active ? 'bg-green-500' : 'bg-gray-400'); ?> mr-1.5"></span>
                                    <?php echo e($coupon->is_active ? 'Active' : 'Disabled'); ?>

                                </button>
                            </form>
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 text-right space-x-1.5">
                            <a href="<?php echo e(route('admin.coupons.edit', $coupon->id)); ?>" class="inline-flex items-center p-2 rounded-lg text-blue-600 hover:text-blue-900 bg-blue-50 dark:bg-blue-500/10 hover:bg-blue-100 transition-colors">
                                <i class="fas fa-edit text-xs"></i>
                            </a>

                            <form action="<?php echo e(route('admin.coupons.destroy', $coupon->id)); ?>" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete coupon \'<?php echo e($coupon->code); ?>\'?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="inline-flex items-center p-2 rounded-lg text-rose-600 hover:text-rose-900 bg-rose-50 dark:bg-rose-500/10 hover:bg-rose-100 transition-colors">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="w-16 h-16 rounded-2xl bg-indigo-50 dark:bg-indigo-500/10 text-indigo-500 flex items-center justify-center mx-auto mb-3 text-2xl">
                                <i class="fas fa-ticket-alt"></i>
                            </div>
                            <h4 class="text-base font-bold text-slate-800 dark:text-white">No Coupons Found</h4>
                            <p class="text-xs text-slate-400 max-w-sm mx-auto mt-1">
                                Create your first welcome coupon or minimum order banner coupon to incentivize patient bookings.
                            </p>
                            <a href="<?php echo e(route('admin.coupons.create')); ?>" class="mt-4 inline-flex items-center px-4 py-2 rounded-xl bg-indigo-600 text-white text-xs font-semibold hover:bg-indigo-700 transition shadow-sm">
                                <i class="fas fa-plus mr-1.5"></i> Create Coupon
                            </a>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($coupons->hasPages()): ?>
        <div class="p-4 border-t border-slate-200 dark:border-white/[0.06] bg-slate-50/50 dark:bg-white/[0.01]">
            <?php echo e($coupons->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\outsourcelab\resources\views/admin/coupons/index.blade.php ENDPATH**/ ?>