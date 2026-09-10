<?php $__env->startSection('title', 'Users Management'); ?>
<?php $__env->startSection('header', 'Users'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-black tracking-tight text-slate-900 dark:text-white flex items-center gap-2.5">
            <span class="w-9 h-9 rounded-xl bg-indigo-500/10 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-base">
                <i class="fas fa-users"></i>
            </span>
            Users Management
        </h1>
        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
            Data of all registered customers, logged-in accounts, profile information, and booking activity.
        </p>
    </div>
    <div class="flex items-center gap-2">
        <a href="<?php echo e(route('admin.users.index')); ?>" class="px-3.5 py-2 rounded-xl text-xs font-semibold bg-white dark:bg-white/[0.05] border border-slate-200 dark:border-white/[0.08] text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 transition-all flex items-center gap-2 shadow-sm">
            <i class="fas fa-rotate-right text-xs"></i>
            <span>Refresh</span>
        </a>
    </div>
</div>

<!-- Metric Overview Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <!-- Card 1: Total Users -->
    <div class="p-5 rounded-2xl bg-white dark:bg-[#12142d] border border-slate-200 dark:border-white/[0.06] shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-400 dark:text-slate-400 uppercase tracking-wider">Total Users</p>
            <h3 class="text-2xl font-black text-slate-900 dark:text-white mt-1.5"><?php echo e(number_format($totalUsers)); ?></h3>
            <span class="inline-flex items-center text-[11px] font-medium text-emerald-600 dark:text-emerald-400 mt-1">
                <i class="fas fa-arrow-up-right mr-1"></i> Registered accounts
            </span>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-indigo-500/10 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-xl shadow-inner">
            <i class="fas fa-user-group"></i>
        </div>
    </div>

    <!-- Card 2: Active / Logged In -->
    <div class="p-5 rounded-2xl bg-white dark:bg-[#12142d] border border-slate-200 dark:border-white/[0.06] shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-400 dark:text-slate-400 uppercase tracking-wider">Recently Active</p>
            <h3 class="text-2xl font-black text-slate-900 dark:text-white mt-1.5"><?php echo e(number_format($recentLogins)); ?></h3>
            <span class="inline-flex items-center text-[11px] font-medium text-emerald-600 dark:text-emerald-400 mt-1">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5 animate-pulse"></span> Logged in / active (7d)
            </span>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xl shadow-inner">
            <i class="fas fa-right-to-bracket"></i>
        </div>
    </div>

    <!-- Card 3: Users with Bookings -->
    <div class="p-5 rounded-2xl bg-white dark:bg-[#12142d] border border-slate-200 dark:border-white/[0.06] shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-400 dark:text-slate-400 uppercase tracking-wider">With Bookings</p>
            <h3 class="text-2xl font-black text-slate-900 dark:text-white mt-1.5"><?php echo e(number_format($usersWithBookings)); ?></h3>
            <span class="inline-flex items-center text-[11px] font-medium text-purple-600 dark:text-purple-400 mt-1">
                <i class="fas fa-calendar-check mr-1"></i> Diagnostic patients
            </span>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-purple-500/10 dark:bg-purple-500/20 text-purple-600 dark:text-purple-400 flex items-center justify-center text-xl shadow-inner">
            <i class="fas fa-file-medical"></i>
        </div>
    </div>

    <!-- Card 4: New This Month -->
    <div class="p-5 rounded-2xl bg-white dark:bg-[#12142d] border border-slate-200 dark:border-white/[0.06] shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-400 dark:text-slate-400 uppercase tracking-wider">New This Month</p>
            <h3 class="text-2xl font-black text-slate-900 dark:text-white mt-1.5"><?php echo e(number_format($newThisMonth)); ?></h3>
            <span class="inline-flex items-center text-[11px] font-medium text-amber-600 dark:text-amber-400 mt-1">
                <i class="fas fa-sparkles mr-1"></i> Fresh signups
            </span>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-amber-500/10 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400 flex items-center justify-center text-xl shadow-inner">
            <i class="fas fa-user-plus"></i>
        </div>
    </div>
</div>

<!-- Filters & Search Form -->
<div class="p-4 rounded-2xl bg-white dark:bg-[#12142d] border border-slate-200 dark:border-white/[0.06] shadow-sm">
    <form method="GET" action="<?php echo e(route('admin.users.index')); ?>" class="flex flex-col lg:flex-row gap-3 items-stretch lg:items-center justify-between">
        <div class="flex-1 flex flex-col sm:flex-row gap-3">
            <!-- Search Bar -->
            <div class="relative flex-1">
                <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search by name, email, or mobile..." 
                    class="w-full pl-9 pr-4 py-2.5 bg-slate-50 dark:bg-white/[0.04] border border-slate-200 dark:border-white/[0.08] rounded-xl text-xs text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/50">
            </div>

            <!-- Filter Status -->
            <div class="sm:w-48">
                <select name="filter" onchange="this.form.submit()" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-white/[0.04] border border-slate-200 dark:border-white/[0.08] rounded-xl text-xs text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/50">
                    <option value="">All Users</option>
                    <option value="recent_login" <?php echo e(request('filter') === 'recent_login' ? 'selected' : ''); ?>>Recently Logged In</option>
                    <option value="with_bookings" <?php echo e(request('filter') === 'with_bookings' ? 'selected' : ''); ?>>With Bookings</option>
                    <option value="without_bookings" <?php echo e(request('filter') === 'without_bookings' ? 'selected' : ''); ?>>Without Bookings</option>
                </select>
            </div>

            <!-- Sort By -->
            <div class="sm:w-48">
                <select name="sort" onchange="this.form.submit()" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-white/[0.04] border border-slate-200 dark:border-white/[0.08] rounded-xl text-xs text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/50">
                    <option value="latest_login" <?php echo e(request('sort', 'latest_login') === 'latest_login' ? 'selected' : ''); ?>>Sort: Recent Activity / Login</option>
                    <option value="newest" <?php echo e(request('sort') === 'newest' ? 'selected' : ''); ?>>Sort: Newest Registered</option>
                    <option value="most_bookings" <?php echo e(request('sort') === 'most_bookings' ? 'selected' : ''); ?>>Sort: Most Bookings</option>
                    <option value="name_asc" <?php echo e(request('sort') === 'name_asc' ? 'selected' : ''); ?>>Sort: Name (A-Z)</option>
                    <option value="oldest" <?php echo e(request('sort') === 'oldest' ? 'selected' : ''); ?>>Sort: Oldest Registered</option>
                </select>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <button type="submit" class="px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold shadow-sm transition-colors flex items-center justify-center gap-1.5">
                <i class="fas fa-filter text-xs"></i>
                <span>Filter</span>
            </button>
            <?php if(request()->hasAny(['search', 'filter', 'sort'])): ?>
                <a href="<?php echo e(route('admin.users.index')); ?>" class="px-3.5 py-2.5 rounded-xl bg-slate-100 dark:bg-white/[0.05] text-slate-600 dark:text-slate-300 hover:text-slate-900 text-xs font-semibold transition-colors">
                    Reset
                </a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Users Table Card -->
<div class="bg-white dark:bg-[#12142d] rounded-2xl shadow-sm border border-slate-200 dark:border-white/[0.06] overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/75 dark:bg-white/[0.02] border-b border-slate-200 dark:border-white/[0.06] text-slate-400 dark:text-slate-400 text-[11px] uppercase tracking-wider">
                    <th class="px-6 py-4 font-bold">User Details</th>
                    <th class="px-6 py-4 font-bold">Contact</th>
                    <th class="px-6 py-4 font-bold">Gender & Age</th>
                    <th class="px-6 py-4 font-bold text-center">Bookings</th>
                    <th class="px-6 py-4 font-bold">Last Login / Activity</th>
                    <th class="px-6 py-4 font-bold">Registered Date</th>
                    <th class="px-6 py-4 font-bold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-white/[0.04] text-xs">
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $displayName = $user->name ?: ($user->email ? explode('@', $user->email)[0] : 'User #' . $user->id);
                        $initials = strtoupper(substr($displayName, 0, 2));
                        $gradients = [
                            'from-indigo-500 to-purple-600',
                            'from-blue-500 to-cyan-500',
                            'from-emerald-500 to-teal-600',
                            'from-rose-500 to-pink-600',
                            'from-amber-500 to-orange-600',
                            'from-violet-500 to-indigo-600'
                        ];
                        $bgGradient = $gradients[$user->id % count($gradients)];
                        $lastActiveTime = $user->last_login_at ?? $user->updated_at ?? $user->created_at;
                    ?>
                    <tr class="hover:bg-slate-50/60 dark:hover:bg-white/[0.02] transition-colors group">
                        <!-- User Details -->
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br <?php echo e($bgGradient); ?> text-white font-bold flex items-center justify-center text-xs shadow-md shadow-indigo-500/10 flex-shrink-0">
                                    <?php echo e($initials); ?>

                                </div>
                                <div class="min-w-0">
                                    <div class="font-bold text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors truncate max-w-[200px]">
                                        <?php echo e($user->name ?: 'No name set'); ?>

                                    </div>
                                    <div class="text-[11px] text-slate-400 dark:text-slate-400 truncate max-w-[200px]">
                                        <?php echo e($user->email ?: 'No email registered'); ?>

                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Contact -->
                        <td class="px-6 py-4">
                            <?php if($user->mobile): ?>
                                <div class="font-medium text-slate-800 dark:text-slate-200 flex items-center gap-1.5">
                                    <i class="fas fa-phone text-[10px] text-slate-400"></i>
                                    <span><?php echo e($user->mobile); ?></span>
                                </div>
                            <?php else: ?>
                                <span class="text-slate-400 italic text-[11px]">No mobile</span>
                            <?php endif; ?>
                            <?php if($user->alt_mobile): ?>
                                <div class="text-[10px] text-slate-400 mt-0.5">
                                    Alt: <?php echo e($user->alt_mobile); ?>

                                </div>
                            <?php endif; ?>
                        </td>

                        <!-- Gender & Age -->
                        <td class="px-6 py-4">
                            <?php if($user->gender || $user->age): ?>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-semibold bg-slate-100 dark:bg-white/[0.05] text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-white/[0.06]">
                                    <?php echo e($user->gender ?: 'N/A'); ?> <?php echo e($user->age ? '• ' . $user->age . ' yrs' : ''); ?>

                                </span>
                            <?php else: ?>
                                <span class="text-slate-400 italic text-[11px]">Not provided</span>
                            <?php endif; ?>
                        </td>

                        <!-- Bookings -->
                        <td class="px-6 py-4 text-center">
                            <?php if($user->bookings_count > 0): ?>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 border border-indigo-200/50 dark:border-indigo-500/20">
                                    <i class="fas fa-calendar-check mr-1.5 text-[10px]"></i>
                                    <?php echo e($user->bookings_count); ?> <?php echo e(Str::plural('Booking', $user->bookings_count)); ?>

                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-slate-100 dark:bg-white/[0.04] text-slate-400">
                                    0 bookings
                                </span>
                            <?php endif; ?>
                        </td>

                        <!-- Last Login / Activity -->
                        <td class="px-6 py-4">
                            <?php if($user->last_login_at): ?>
                                <div class="flex items-center gap-1.5 font-medium text-slate-800 dark:text-slate-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    <span><?php echo e($user->last_login_at->diffForHumans()); ?></span>
                                </div>
                                <div class="text-[10px] text-slate-400 mt-0.5">
                                    <?php echo e($user->last_login_at->format('d M, Y h:i A')); ?>

                                </div>
                            <?php elseif($user->updated_at): ?>
                                <div class="flex items-center gap-1.5 font-medium text-slate-600 dark:text-slate-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-300 dark:bg-slate-600"></span>
                                    <span>Active <?php echo e($user->updated_at->diffForHumans()); ?></span>
                                </div>
                                <div class="text-[10px] text-slate-400 mt-0.5">
                                    <?php echo e($user->updated_at->format('d M, Y')); ?>

                                </div>
                            <?php else: ?>
                                <span class="text-slate-400 italic text-[11px]">—</span>
                            <?php endif; ?>
                        </td>

                        <!-- Registered Date -->
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-800 dark:text-slate-200">
                                <?php echo e($user->created_at ? $user->created_at->format('d M, Y') : '—'); ?>

                            </div>
                            <div class="text-[10px] text-slate-400 mt-0.5">
                                <?php echo e($user->created_at ? $user->created_at->format('h:i A') : ''); ?>

                            </div>
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 text-right space-x-1">
                            <!-- View User Profile -->
                            <a href="<?php echo e(route('admin.users.show', $user->id)); ?>" 
                               title="View Full Profile & Bookings"
                               class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-500/10 hover:bg-indigo-100 dark:hover:bg-indigo-500/20 font-medium transition-colors">
                                <i class="fas fa-eye text-xs mr-1"></i>
                                <span>Details</span>
                            </a>

                            <!-- Delete User -->
                            <form action="<?php echo e(route('admin.users.destroy', $user->id)); ?>" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this user account? All associated bookings, addresses, and family records will also be removed.');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" title="Delete User" class="inline-flex items-center p-1.5 rounded-lg text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-500/10 hover:bg-rose-100 dark:hover:bg-rose-500/20 transition-colors">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="w-16 h-16 rounded-2xl bg-indigo-50 dark:bg-indigo-500/10 text-indigo-500 flex items-center justify-center mx-auto mb-3 text-2xl">
                                <i class="fas fa-user-slash"></i>
                            </div>
                            <h4 class="text-base font-bold text-slate-800 dark:text-white">No Users Found</h4>
                            <p class="text-xs text-slate-400 max-w-sm mx-auto mt-1">
                                No registered user records match your search or filter criteria.
                            </p>
                            <?php if(request()->hasAny(['search', 'filter', 'sort'])): ?>
                                <a href="<?php echo e(route('admin.users.index')); ?>" class="mt-4 inline-flex items-center px-3.5 py-2 rounded-xl bg-indigo-600 text-white text-xs font-semibold hover:bg-indigo-700 transition">
                                    Clear Filters
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if($users->hasPages()): ?>
        <div class="p-4 border-t border-slate-200 dark:border-white/[0.06] bg-slate-50/50 dark:bg-white/[0.01]">
            <?php echo e($users->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\lab\lab\resources\views/admin/users/index.blade.php ENDPATH**/ ?>