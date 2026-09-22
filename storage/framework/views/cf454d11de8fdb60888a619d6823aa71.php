<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8 bg-gray-50/50">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar -->
        <?php echo $__env->make('patient.layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Main Content -->
        <div class="w-full md:w-2/3 lg:w-3/4 space-y-6">

            <!-- Success Alert -->
            <?php if(session('success')): ?>
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-sm animate-fade-in">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                        <i class="fas fa-check-circle text-lg"></i>
                    </div>
                    <div>
                        <p class="font-bold text-sm"><?php echo e(session('success')); ?></p>
                        <p class="text-xs text-emerald-600">Your profile details have been saved and updated across all reports.</p>
                    </div>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 text-lg font-bold p-1">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <?php endif; ?>

            <!-- Validation Errors Alert -->
            <?php if(isset($errors) && $errors->any()): ?>
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 shadow-sm">
                <div class="flex items-center gap-2 mb-2 font-bold text-sm">
                    <i class="fas fa-exclamation-triangle text-rose-500 text-base"></i>
                    <span>Please correct the errors below before saving:</span>
                </div>
                <ul class="list-disc list-inside text-xs space-y-1 font-medium text-rose-700 ml-2">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <?php endif; ?>

            <!-- Patient Hero Passport Card -->
            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm relative overflow-hidden">
                <div class="absolute -right-10 -bottom-10 w-48 h-48 rounded-full bg-teal-500/5 blur-2xl pointer-events-none"></div>

                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 pb-6 border-b border-gray-100 relative z-10">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-brand-dark to-teal-600 text-white flex items-center justify-center font-black text-2xl shadow-md flex-shrink-0">
                            <?php echo e(strtoupper(substr($profile->name ?: 'P', 0, 1))); ?>

                        </div>
                        <div>
                            <div class="flex items-center gap-2 flex-wrap">
                                <h2 class="text-2xl font-black text-brand-dark"><?php echo e($profile->name ?: 'Patient Profile'); ?></h2>
                                <span class="inline-flex items-center gap-1 bg-emerald-50 border border-emerald-200 text-emerald-700 text-[11px] font-extrabold px-2.5 py-0.5 rounded-full">
                                    <i class="fas fa-shield-alt text-[10px]"></i> Verified Patient
                                </span>
                                <span class="text-xs font-mono font-bold text-gray-500 bg-gray-100 px-2 py-0.5 rounded-md">
                                    #PAT-<?php echo e(str_pad($profile->id, 5, '0', STR_PAD_LEFT)); ?>

                                </span>
                            </div>

                            <p class="text-xs text-gray-500 font-medium mt-1 flex items-center gap-3 flex-wrap">
                                <span><i class="fas fa-phone-alt text-brand-primary mr-1"></i> +91 <?php echo e($profile->mobile); ?></span>
                                <span><i class="far fa-envelope text-gray-400 mr-1"></i> <?php echo e($profile->email !== '-' ? $profile->email : 'Email not updated'); ?></span>
                                <span><i class="far fa-calendar-check text-gray-400 mr-1"></i> Member since <?php echo e($profile->created_at ? $profile->created_at->format('M Y') : 'Recent'); ?></span>
                            </p>
                        </div>
                    </div>

                    <!-- Quick Action Buttons -->
                    <div class="flex items-center gap-2 flex-wrap sm:flex-nowrap">
                        <a href="/" class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 bg-brand-dark hover:bg-brand-primary text-white text-xs font-extrabold rounded-xl shadow-sm transition flex-shrink-0">
                            <i class="fas fa-plus"></i> Book Test
                        </a>
                        <a href="<?php echo e(route('patient.prescriptions')); ?>" class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 bg-white border border-gray-200 hover:border-teal-300 text-gray-700 text-xs font-extrabold rounded-xl shadow-2xs transition flex-shrink-0">
                            <i class="fas fa-file-medical text-teal-600"></i> Upload Rx
                        </a>
                    </div>
                </div>

                <!-- 4 Quick Metric Cards -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-5 relative z-10">
                    <!-- Bookings -->
                    <a href="<?php echo e(route('patient.bookings')); ?>" class="p-3.5 bg-gray-50/80 hover:bg-teal-50/60 rounded-xl border border-gray-100 hover:border-teal-200 transition group">
                        <span class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider group-hover:text-brand-dark">My Bookings</span>
                        <div class="flex items-center justify-between mt-1">
                            <span class="text-2xl font-black text-brand-dark"><?php echo e($profile->bookings->count()); ?></span>
                            <i class="fas fa-calendar-check text-gray-300 group-hover:text-brand-primary transition text-base"></i>
                        </div>
                        <span class="text-[10px] font-bold text-teal-600 mt-1 block">
                            <?php echo e($profile->bookings->whereNotIn('status', ['Completed', 'Cancelled'])->count()); ?> In Progress &rarr;
                        </span>
                    </a>

                    <!-- Lab Reports -->
                    <a href="<?php echo e(route('patient.reports')); ?>" class="p-3.5 bg-gray-50/80 hover:bg-teal-50/60 rounded-xl border border-gray-100 hover:border-teal-200 transition group">
                        <span class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider group-hover:text-brand-dark">Lab Reports</span>
                        <div class="flex items-center justify-between mt-1">
                            <span class="text-2xl font-black text-brand-dark"><?php echo e($profile->bookings->whereIn('status', ['Completed', 'Report Ready'])->count()); ?></span>
                            <i class="fas fa-file-medical-alt text-gray-300 group-hover:text-brand-primary transition text-base"></i>
                        </div>
                        <span class="text-[10px] font-bold text-emerald-600 mt-1 block">
                            <i class="fas fa-check-circle text-[9px]"></i> Certified Reports &rarr;
                        </span>
                    </a>

                    <!-- Health Coins -->
                    <a href="<?php echo e(route('patient.rewards')); ?>" class="p-3.5 bg-gray-50/80 hover:bg-teal-50/60 rounded-xl border border-gray-100 hover:border-teal-200 transition group">
                        <span class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider group-hover:text-brand-dark">Health Coins</span>
                        <div class="flex items-center justify-between mt-1">
                            <span class="text-2xl font-black text-amber-600"><?php echo e(number_format($profile->reward_coins ?? 0)); ?></span>
                            <i class="fas fa-coins text-amber-400 group-hover:scale-110 transition text-base"></i>
                        </div>
                        <span class="text-[10px] font-bold text-amber-700 mt-1 block">
                            Redeem on tests &rarr;
                        </span>
                    </a>

                    <!-- Family Members -->
                    <a href="<?php echo e(route('patient.family_members')); ?>" class="p-3.5 bg-gray-50/80 hover:bg-teal-50/60 rounded-xl border border-gray-100 hover:border-teal-200 transition group">
                        <span class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider group-hover:text-brand-dark">Family Members</span>
                        <div class="flex items-center justify-between mt-1">
                            <span class="text-2xl font-black text-brand-dark"><?php echo e($profile->familyMembers->count()); ?></span>
                            <i class="fas fa-users text-gray-300 group-hover:text-brand-primary transition text-base"></i>
                        </div>
                        <span class="text-[10px] font-bold text-gray-500 mt-1 block">
                            Manage family &rarr;
                        </span>
                    </a>
                </div>

                <!-- VIP Privilege Strip -->
                <?php if($profile->isVipMember()): ?>
                    <?php $activeVip = $profile->activeMembership(); ?>
                    <div class="mt-4 p-4 rounded-xl bg-gradient-to-r from-amber-500/15 via-amber-400/5 to-transparent border border-amber-300/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3 relative z-10">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-amber-500 text-white flex items-center justify-center font-bold text-base shadow-sm flex-shrink-0">
                                <i class="fas fa-crown"></i>
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h4 class="text-xs font-black text-brand-dark">Wellcare VIP Member: <span class="text-amber-800"><?php echo e($activeVip->plan_name_snapshot); ?></span></h4>
                                    <span class="text-[10px] font-bold bg-amber-200 text-amber-900 px-2 py-0.2 rounded-full">ACTIVE</span>
                                </div>
                                <p class="text-[11px] text-gray-600 font-medium mt-0.5">Flat <?php echo e($activeVip->discount_percentage); ?>% OFF on all pathology tests • Free home sample collection • Priority report release</p>
                            </div>
                        </div>
                        <a href="<?php echo e(route('patient.membership')); ?>" class="px-3.5 py-1.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-xs font-extrabold transition shadow-xs flex-shrink-0 self-start sm:self-auto">
                            View Card & Perks &rarr;
                        </a>
                    </div>
                <?php else: ?>
                    <div class="mt-4 p-4 rounded-xl bg-gradient-to-r from-teal-900/10 via-amber-500/5 to-transparent border border-teal-200/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3 relative z-10">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-amber-500 text-white flex items-center justify-center font-bold text-sm shadow-sm flex-shrink-0">
                                <i class="fas fa-crown"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-black text-brand-dark">Unlock Wellcare VIP Health Pass</h4>
                                <p class="text-[11px] text-gray-500 font-medium mt-0.5">Save up to 25% on every booking with free home collection for your entire family.</p>
                            </div>
                        </div>
                        <a href="<?php echo e(route('patient.membership')); ?>" class="px-3.5 py-1.5 rounded-xl bg-brand-dark hover:bg-brand-primary text-white text-xs font-extrabold transition shadow-xs flex-shrink-0 self-start sm:self-auto">
                            Explore VIP Plans &rarr;
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Dashboard Navigation Tabs -->
            <div class="bg-white rounded-2xl border border-gray-200 p-2 shadow-xs flex items-center gap-2 overflow-x-auto">
                <button type="button" onclick="switchDashboardTab('overview')" id="tabBtn-overview" class="tab-btn flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-xs font-black transition-all bg-brand-dark text-white shadow-xs">
                    <i class="fas fa-chart-pie text-xs"></i>
                    <span>Overview & Live Tracker</span>
                </button>

                <button type="button" onclick="switchDashboardTab('notifications')" id="tabBtn-notifications" class="tab-btn flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-xs font-black transition-all text-gray-600 hover:text-brand-dark hover:bg-gray-50">
                    <i class="fas fa-bell text-xs"></i>
                    <span>Notifications</span>
                    <?php if($unreadNotificationsCount > 0): ?>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-rose-500 text-white animate-pulse">
                            <?php echo e($unreadNotificationsCount); ?>

                        </span>
                    <?php endif; ?>
                </button>

                <button type="button" onclick="switchDashboardTab('profile')" id="tabBtn-profile" class="tab-btn flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-xs font-black transition-all text-gray-600 hover:text-brand-dark hover:bg-gray-50">
                    <i class="far fa-user-circle text-xs"></i>
                    <span>Personal Details & Form</span>
                </button>
            </div>

            <!-- ========================================================= -->
            <!-- TAB 1: OVERVIEW & ACTIVE TRACKER                          -->
            <!-- ========================================================= -->
            <div id="tabContent-overview" class="space-y-6">

                <!-- Active / Ongoing Booking Tracker -->
                <?php if($activeBooking): ?>
                    <?php
                        $statusMap = [
                            'Booked'                      => ['label' => 'Booked',           'badge' => 'bg-indigo-50 text-indigo-700 border-indigo-200',   'icon' => 'fa-calendar-check', 'step' => 1],
                            'Pending'                     => ['label' => 'Pending',          'badge' => 'bg-amber-50 text-amber-700 border-amber-200',     'icon' => 'fa-clock',          'step' => 1],
                            'Confirmed'                   => ['label' => 'Confirmed',        'badge' => 'bg-blue-50 text-blue-700 border-blue-200',       'icon' => 'fa-check',          'step' => 1],
                            'Assigned'                    => ['label' => 'Agent Assigned',   'badge' => 'bg-teal-50 text-teal-700 border-teal-200',       'icon' => 'fa-motorcycle',     'step' => 2],
                            'Sample Collection Scheduled' => ['label' => 'Scheduled',        'badge' => 'bg-teal-50 text-teal-700 border-teal-200',       'icon' => 'fa-calendar-alt',   'step' => 2],
                            'Out for Collection'          => ['label' => 'Agent On The Way', 'badge' => 'bg-amber-50 text-amber-700 border-amber-200',    'icon' => 'fa-biking',         'step' => 2],
                            'Sample Collected'            => ['label' => 'Sample Collected', 'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'icon' => 'fa-vial',       'step' => 2],
                            'In Process'                  => ['label' => 'Lab Processing',   'badge' => 'bg-yellow-50 text-yellow-700 border-yellow-200', 'icon' => 'fa-microscope',   'step' => 3],
                            'Processing'                  => ['label' => 'Lab Processing',   'badge' => 'bg-yellow-50 text-yellow-700 border-yellow-200', 'icon' => 'fa-microscope',   'step' => 3],
                            'Report Ready'                => ['label' => 'Report Ready',     'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'icon' => 'fa-file-medical-alt', 'step' => 4],
                        ];
                        $lookupKey = !empty($activeBooking->sample_status) && $activeBooking->sample_status !== 'Pending' ? $activeBooking->sample_status : $activeBooking->status;
                        $curInfo = $statusMap[$lookupKey] ?? [
                            'label' => $activeBooking->status ?: 'Booked',
                            'badge' => 'bg-gray-50 text-gray-700 border-gray-200',
                            'icon'  => 'fa-info-circle',
                            'step'  => ($activeBooking->agent ? 2 : 1)
                        ];
                        $activeFor = $activeBooking->familyMember ? $activeBooking->familyMember->name : ($profile->name ?? 'Self');
                        $activeRelation = $activeBooking->familyMember ? $activeBooking->familyMember->relation : 'Self';
                        $actTests = is_array($activeBooking->test_details) ? $activeBooking->test_details : (json_decode($activeBooking->test_details, true) ?: []);
                        $steps = ['Booked', 'Sample Collection', 'Lab Processing', 'Report Ready'];
                    ?>

                    <div class="bg-white rounded-2xl border-2 border-teal-500/40 shadow-sm overflow-hidden">
                        <!-- Card Header -->
                        <div class="bg-gradient-to-r from-teal-50/80 via-white to-teal-50/80 border-b border-teal-100 px-6 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div class="flex items-center gap-3 flex-wrap">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-teal-600 text-white font-mono font-bold text-xs shadow-xs">
                                    <i class="fas fa-barcode"></i>
                                    <span>#<?php echo e($activeBooking->booking_reference); ?></span>
                                </span>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl border text-xs font-black <?php echo e($curInfo['badge']); ?>">
                                    <i class="fas <?php echo e($curInfo['icon']); ?>"></i>
                                    <span><?php echo e($curInfo['label']); ?></span>
                                </span>
                                <span class="text-xs font-bold text-gray-700">
                                    For: <strong class="text-gray-900"><?php echo e($activeFor); ?></strong> (<?php echo e($activeRelation); ?>)
                                </span>
                            </div>

                            <div class="text-left sm:text-right">
                                <span class="inline-flex items-center gap-1 text-[11px] font-black text-teal-900 bg-teal-100/60 border border-teal-200 px-2.5 py-1 rounded-lg">
                                    <i class="far fa-clock text-teal-700"></i>
                                    <span>Slot: <?php echo e($activeBooking->display_slot); ?></span>
                                </span>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-6 space-y-6">
                            <!-- Stepper Pipeline -->
                            <div class="relative py-2">
                                <div class="absolute top-9 left-10 right-10 h-1 bg-gray-200 rounded-full z-0"></div>
                                <?php
                                    $curStep = max(1, min(4, $curInfo['step']));
                                    $stepPct = ($curStep - 1) / 3 * 100;
                                ?>
                                <div class="absolute top-9 left-10 h-1 bg-brand-primary rounded-full z-0 transition-all duration-500" style="width: <?php echo e((int)$stepPct); ?>%;"></div>

                                <div class="flex justify-between relative z-10">
                                    <?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sIdx => $stepLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $sNum = $sIdx + 1;
                                            $done = $sNum < $curStep;
                                            $isCurrent = $sNum === $curStep;
                                        ?>
                                        <div class="text-center w-24 sm:w-28">
                                            <div class="w-9 h-9 sm:w-10 sm:h-10 mx-auto rounded-full flex items-center justify-center font-bold text-xs mb-1.5 shadow-sm border-4 border-white transition-all
                                                <?php echo e($done ? 'bg-brand-primary text-white' : ($isCurrent ? 'bg-amber-500 text-white ring-4 ring-amber-100 animate-pulse' : 'bg-gray-200 text-gray-400')); ?>">
                                                <?php if($done): ?>
                                                    <i class="fas fa-check text-xs"></i>
                                                <?php elseif($isCurrent): ?>
                                                    <i class="fas fa-spinner fa-spin text-xs"></i>
                                                <?php else: ?>
                                                    <span><?php echo e($sNum); ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <span class="text-[11px] font-black block leading-tight <?php echo e($isCurrent ? 'text-brand-dark font-extrabold' : ($done ? 'text-teal-700' : 'text-gray-400')); ?>">
                                                <?php echo e($stepLabel); ?>

                                            </span>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>

                            <!-- Assigned Phlebotomist Card -->
                            <?php if($activeBooking->agent): ?>
                                <div class="p-4 rounded-xl bg-teal-50/70 border border-teal-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-11 h-11 rounded-xl bg-teal-600 text-white flex items-center justify-center font-bold text-base shadow-sm flex-shrink-0">
                                            <i class="fas fa-user-nurse"></i>
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="text-[10px] uppercase font-black tracking-wider text-teal-800">Assigned Phlebotomist</span>
                                                <span class="text-[10px] bg-teal-200 text-teal-900 font-bold px-2 py-0.2 rounded-full"><?php echo e($activeBooking->sample_status ?: 'Assigned'); ?></span>
                                            </div>
                                            <h4 class="font-black text-teal-950 text-sm"><?php echo e($activeBooking->agent->name); ?></h4>
                                            <?php if($activeBooking->agent->vehicle_number): ?>
                                                <p class="text-[11px] text-teal-700 font-medium">Vehicle: <?php echo e($activeBooking->agent->vehicle_number); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <?php if($activeBooking->agent->phone): ?>
                                        <a href="tel:<?php echo e($activeBooking->agent->phone); ?>" class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold transition shadow-sm w-fit">
                                            <i class="fas fa-phone-alt text-xs"></i>
                                            <span>Call: +91 <?php echo e($activeBooking->agent->phone); ?></span>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <!-- Tests & Actions Row -->
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-2 border-t border-gray-100">
                                <div>
                                    <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block mb-1">Diagnostic Tests:</span>
                                    <div class="flex flex-wrap gap-1.5">
                                        <?php $__currentLoopData = array_slice($actTests, 0, 3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $tTitle = is_array($t) ? ($t['name'] ?? 'Diagnostic Test') : $t; ?>
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-gray-50 border border-gray-200 text-xs font-semibold text-gray-700">
                                                <i class="fas fa-vial text-[10px] text-teal-600"></i>
                                                <span><?php echo e($tTitle); ?></span>
                                            </span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(count($actTests) > 3): ?>
                                            <span class="inline-flex items-center px-2 py-1 rounded-lg bg-gray-100 text-[11px] font-bold text-gray-600">
                                                +<?php echo e(count($actTests) - 3); ?> more
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2">
                                    <a href="<?php echo e(route('patient.bookings')); ?>" class="inline-flex items-center gap-1.5 px-4 py-2 bg-brand-dark hover:bg-teal-800 text-white font-extrabold text-xs rounded-xl shadow-xs transition">
                                        <span>Full Booking Details</span>
                                        <i class="fas fa-arrow-right text-[10px]"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- No Active Booking Card -->
                    <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-teal-50 border border-teal-200 text-teal-700 flex items-center justify-center text-xl flex-shrink-0">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div>
                                <h3 class="font-extrabold text-sm text-gray-900">No active test bookings in progress</h3>
                                <p class="text-xs text-gray-500 font-medium mt-0.5">Need a routine blood test or complete full body health checkup with home collection?</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <a href="/" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-brand-dark hover:bg-teal-800 text-white font-extrabold text-xs transition shadow-sm">
                                <i class="fas fa-flask"></i> Book Test Now
                            </a>
                            <a href="<?php echo e(route('patient.prescriptions')); ?>" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 font-extrabold text-xs hover:bg-amber-100 transition">
                                <i class="fas fa-file-medical text-amber-600"></i> Upload Rx
                            </a>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Ready Reports Quick Download Widget -->
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 via-white to-gray-50 border-b border-gray-200 flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs">
                                <i class="fas fa-file-medical-alt"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-black text-brand-dark">Latest Certified Medical Reports</h3>
                                <p class="text-[11px] text-gray-500 font-medium">100% NABL Accredited & Digitally Signed PDF Reports</p>
                            </div>
                        </div>
                        <a href="<?php echo e(route('patient.reports')); ?>" class="text-xs font-black text-teal-700 hover:underline flex items-center gap-1">
                            <span>View All</span>
                            <i class="fas fa-chevron-right text-[9px]"></i>
                        </a>
                    </div>

                    <?php if($readyReports->isNotEmpty()): ?>
                        <div class="divide-y divide-gray-100">
                            <?php $__currentLoopData = $readyReports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $repFor = $rep->familyMember ? $rep->familyMember->name : ($profile->name ?? 'Patient');
                                    $repRelation = $rep->familyMember ? $rep->familyMember->relation : 'Self';
                                    $repTests = is_array($rep->test_details) ? $rep->test_details : (json_decode($rep->test_details, true) ?: []);
                                    $repTitle = !empty($repTests) 
                                        ? (is_array($repTests[0]) ? ($repTests[0]['name'] ?? 'Diagnostic Test Report') : $repTests[0]) 
                                        : 'Diagnostic Health Report';
                                ?>
                                <div class="p-4 sm:px-6 hover:bg-gray-50/70 transition flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                    <div class="flex items-start gap-3.5">
                                        <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center justify-center text-lg flex-shrink-0">
                                            <i class="far fa-file-pdf"></i>
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2 flex-wrap mb-0.5">
                                                <span class="text-xs font-bold text-gray-900 font-mono">#<?php echo e($rep->booking_reference); ?></span>
                                                <span class="inline-flex items-center gap-1 text-[10px] font-black px-2 py-0.2 rounded-full bg-emerald-100 text-emerald-800">
                                                    <i class="fas fa-check-circle"></i> READY
                                                </span>
                                            </div>
                                            <h4 class="text-xs font-black text-gray-800"><?php echo e($repTitle); ?></h4>
                                            <p class="text-[11px] text-gray-500 font-medium">
                                                For: <strong class="text-gray-700"><?php echo e($repFor); ?></strong> (<?php echo e($repRelation); ?>) • 
                                                <span><?php echo e($rep->booking_date ? $rep->booking_date->format('d M Y') : $rep->created_at->format('d M Y')); ?></span>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-2 self-start sm:self-auto flex-shrink-0">
                                        <?php if($rep->report_file_path): ?>
                                            <a href="<?php echo e(asset('storage/' . $rep->report_file_path)); ?>" target="_blank" download class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-xs transition">
                                                <i class="fas fa-download text-[10px]"></i>
                                                <span>Download PDF</span>
                                            </a>
                                        <?php else: ?>
                                            <a href="<?php echo e(route('patient.reports')); ?>" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs rounded-xl transition">
                                                <i class="far fa-eye text-[10px]"></i>
                                                <span>View Report Status</span>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="p-8 text-center">
                            <div class="w-14 h-14 mx-auto rounded-2xl bg-teal-50 border border-teal-100 text-teal-600 flex items-center justify-center text-2xl mb-3">
                                <i class="fas fa-file-medical-alt"></i>
                            </div>
                            <h4 class="font-extrabold text-sm text-gray-800 mb-1">No Test Reports Ready Yet</h4>
                            <p class="text-xs text-gray-500 max-w-md mx-auto">
                                When our NABL certified pathologist validates your diagnostic samples, your digitally signed PDF reports will be available here for 1-click download.
                            </p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Recent Activity / Bookings Table -->
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 via-white to-gray-50 border-b border-gray-200 flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-black text-brand-dark">Recent Bookings & Tests</h3>
                            <p class="text-[11px] text-gray-500 font-medium">Quick history of your diagnostic orders</p>
                        </div>
                        <a href="<?php echo e(route('patient.bookings')); ?>" class="text-xs font-black text-teal-700 hover:underline flex items-center gap-1">
                            <span>View All Bookings</span>
                            <i class="fas fa-chevron-right text-[9px]"></i>
                        </a>
                    </div>

                    <?php if($recentBookings->isNotEmpty()): ?>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs text-gray-600">
                                <thead class="bg-gray-50/75 text-[10px] font-black uppercase tracking-wider text-gray-400 border-b border-gray-100">
                                    <tr>
                                        <th class="py-3 px-6">Booking Ref</th>
                                        <th class="py-3 px-6">Patient</th>
                                        <th class="py-3 px-6">Date & Slot</th>
                                        <th class="py-3 px-6">Amount</th>
                                        <th class="py-3 px-6">Status</th>
                                        <th class="py-3 px-6 text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 font-medium">
                                    <?php $__currentLoopData = $recentBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $bFor = $bk->familyMember ? $bk->familyMember->name : ($profile->name ?? 'Self');
                                            $bRel = $bk->familyMember ? $bk->familyMember->relation : 'Self';
                                        ?>
                                        <tr class="hover:bg-gray-50/50 transition">
                                            <td class="py-3.5 px-6 font-mono font-bold text-gray-900">
                                                #<?php echo e($bk->booking_reference); ?>

                                            </td>
                                            <td class="py-3.5 px-6">
                                                <span class="font-bold text-gray-800 block"><?php echo e($bFor); ?></span>
                                                <span class="text-[10px] text-gray-400"><?php echo e($bRel); ?></span>
                                            </td>
                                            <td class="py-3.5 px-6">
                                                <span class="block text-gray-800 font-semibold"><?php echo e($bk->booking_date ? $bk->booking_date->format('d M Y') : $bk->created_at->format('d M Y')); ?></span>
                                                <span class="text-[10px] text-teal-700 font-bold"><?php echo e($bk->display_slot); ?></span>
                                            </td>
                                            <td class="py-3.5 px-6 font-black text-gray-900">
                                                ₹<?php echo e(number_format($bk->amount, 0)); ?>

                                            </td>
                                            <td class="py-3.5 px-6">
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-black
                                                    <?php echo e(in_array($bk->status, ['Report Ready', 'Completed']) ? 'bg-emerald-100 text-emerald-800' : (in_array($bk->status, ['Cancelled']) ? 'bg-rose-100 text-rose-800' : 'bg-teal-100 text-teal-800')); ?>">
                                                    <?php echo e($bk->status ?: 'Booked'); ?>

                                                </span>
                                            </td>
                                            <td class="py-3.5 px-6 text-right">
                                                <a href="<?php echo e(route('patient.bookings')); ?>" class="inline-flex items-center gap-1 text-teal-600 hover:text-teal-800 font-bold hover:underline">
                                                    <span>View</span>
                                                    <i class="fas fa-chevron-right text-[9px]"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="p-6 text-center text-xs text-gray-400">
                            No booking records found.
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Preventive Health Advice Banner -->
                <div class="rounded-2xl bg-gradient-to-r from-teal-900 via-teal-950 to-slate-950 p-5 text-white shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-amber-400 text-slate-950 flex items-center justify-center text-base font-black flex-shrink-0">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-black text-white">Preventive Diagnostic Tip: Fasting Requirements</h4>
                            <p class="text-[11px] text-teal-200/90 font-medium">For accurate Lipid Profiles and Fasting Blood Sugar, maintain 10-12 hours overnight fasting before morning collection.</p>
                        </div>
                    </div>
                    <a href="/faqs" class="px-4 py-2 rounded-xl bg-teal-800/90 hover:bg-teal-700 text-teal-100 text-xs font-extrabold transition shadow-xs flex-shrink-0 self-start sm:self-auto">
                        Collection FAQs &rarr;
                    </a>
                </div>

            </div>

            <!-- ========================================================= -->
            <!-- TAB 2: NOTIFICATIONS FEED                                 -->
            <!-- ========================================================= -->
            <div id="tabContent-notifications" class="hidden space-y-4">
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                    <!-- Tab Header -->
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 via-white to-gray-50 border-b border-gray-200 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-bell text-brand-primary"></i>
                            <h3 class="text-sm font-black text-brand-dark">Recent In-App Notifications</h3>
                            <?php if($unreadNotificationsCount > 0): ?>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-rose-500 text-white animate-pulse">
                                    <?php echo e($unreadNotificationsCount); ?> New
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="button" onclick="markAllPatientNotifsRead()" class="text-xs font-bold text-teal-600 hover:underline">
                                Mark all as read
                            </button>
                            <span class="text-gray-300">•</span>
                            <a href="<?php echo e(route('patient.notifications')); ?>" class="text-xs font-bold text-teal-700 hover:underline">
                                Full History Center &rarr;
                            </a>
                        </div>
                    </div>

                    <!-- Notification List -->
                    <?php if($notifications->isNotEmpty()): ?>
                        <div class="divide-y divide-gray-100" id="dashNotifsList">
                            <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $isUnread = !$item->isRead();
                                    $iconClass = $item->eventIcon($item->event);
                                    $badgeClass = $item->eventBadgeClass($item->event);
                                ?>
                                <div class="p-4 sm:px-6 transition flex items-start justify-between gap-4 notif-row-<?php echo e($item->id); ?> <?php echo e($isUnread ? 'bg-teal-50/40' : 'hover:bg-gray-50/60'); ?>">
                                    <div class="flex items-start gap-3.5">
                                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-base flex-shrink-0 shadow-xs <?php echo e($badgeClass); ?>">
                                            <i class="<?php echo e($iconClass); ?>"></i>
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2 flex-wrap mb-0.5">
                                                <span class="text-xs font-black text-gray-900"><?php echo e($item->subject ?: 'Notification'); ?></span>
                                                <span class="text-[10px] font-extrabold uppercase tracking-wider px-2 py-0.2 rounded-full <?php echo e($badgeClass); ?>">
                                                    <?php echo e($item->eventLabel($item->event)); ?>

                                                </span>
                                                <?php if($isUnread): ?>
                                                    <span class="inline-block w-2 h-2 rounded-full bg-teal-500 animate-ping"></span>
                                                <?php endif; ?>
                                            </div>
                                            <p class="text-xs text-gray-600 font-medium leading-relaxed"><?php echo e($item->body); ?></p>
                                            <div class="flex items-center gap-3 mt-1.5 text-[11px] text-gray-400 font-semibold">
                                                <span><i class="far fa-clock mr-1"></i> <?php echo e($item->created_at ? $item->created_at->diffForHumans() : 'Recently'); ?></span>
                                                <?php if($item->action_url): ?>
                                                    <span>•</span>
                                                    <a href="<?php echo e($item->action_url); ?>" onclick="markNotifReadInline(<?php echo e($item->id); ?>)" class="text-teal-600 font-bold hover:underline flex items-center gap-1">
                                                        <span>View Details</span>
                                                        <i class="fas fa-arrow-right text-[9px]"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <?php if($isUnread): ?>
                                        <button type="button" onclick="markNotifReadInline(<?php echo e($item->id); ?>)" class="text-[11px] font-bold text-teal-600 hover:text-teal-800 bg-white border border-teal-200 px-2.5 py-1 rounded-lg transition shadow-2xs flex-shrink-0" title="Mark as Read">
                                            <i class="fas fa-check text-[9px] mr-1"></i> Mark read
                                        </button>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="p-10 text-center">
                            <div class="w-14 h-14 mx-auto rounded-2xl bg-gray-50 border border-gray-100 text-gray-400 flex items-center justify-center text-2xl mb-3">
                                <i class="far fa-bell-slash"></i>
                            </div>
                            <h4 class="font-extrabold text-sm text-gray-800 mb-1">No Notifications Yet</h4>
                            <p class="text-xs text-gray-500 max-w-sm mx-auto">
                                You will receive real-time notifications when your booking is placed, your phlebotomist is on the way, and your test report is released.
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- ========================================================= -->
            <!-- TAB 3: PERSONAL & HEALTH DETAILS (FORM)                   -->
            <!-- ========================================================= -->
            <div id="tabContent-profile" class="hidden">
                <div id="profile-form" class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                    <!-- Card Header -->
                    <div class="px-6 py-5 bg-gradient-to-r from-gray-50 via-white to-gray-50 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div>
                            <h3 class="text-lg font-black text-brand-dark flex items-center gap-2">
                                <i class="far fa-id-card text-brand-secondary"></i>
                                <span>Edit Personal & Health Details</span>
                            </h3>
                            <p class="text-xs text-gray-500 font-medium mt-0.5">Please provide accurate information for age-specific normal reference ranges on your lab test reports.</p>
                        </div>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-extrabold bg-teal-50 text-brand-dark border border-teal-200 w-fit">
                            <span class="w-1.5 h-1.5 rounded-full bg-brand-primary animate-pulse"></span>
                            Active Profile
                        </span>
                    </div>

                    <!-- Form Content -->
                    <form action="<?php echo e(route('patient.profile.store')); ?>" method="POST" class="p-6 md:p-8 space-y-6">
                        <?php echo csrf_field(); ?>

                        <!-- Full Name -->
                        <div>
                            <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">
                                Enter Full Name <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">
                                    <i class="far fa-user"></i>
                                </span>
                                <input 
                                    type="text" 
                                    name="name" 
                                    value="<?php echo e(old('name', $profile->name)); ?>" 
                                    placeholder="Enter Full Name" 
                                    class="w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-primary focus:border-brand-primary font-bold text-gray-800 text-sm outline-none transition placeholder-gray-300" 
                                    required
                                >
                            </div>
                        </div>

                        <!-- Gender Selection -->
                        <div>
                            <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">
                                Select Gender <span class="text-rose-500">*</span>
                            </label>
                            <?php
                                $selectedGender = strtolower(old('gender', $profile->gender ?? ''));
                            ?>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                <!-- Female -->
                                <label class="cursor-pointer">
                                    <input type="radio" name="gender" value="Female" <?php echo e($selectedGender === 'female' ? 'checked' : ''); ?> class="peer hidden">
                                    <div class="border-2 border-gray-200 bg-white rounded-xl py-3 px-4 text-center cursor-pointer font-bold text-gray-500 peer-checked:bg-brand-light/40 peer-checked:text-brand-dark peer-checked:border-brand-dark transition flex items-center justify-center gap-2 hover:border-gray-300 shadow-sm">
                                        <i class="fas fa-female text-lg text-pink-500"></i>
                                        <span>Female</span>
                                    </div>
                                </label>

                                <!-- Male -->
                                <label class="cursor-pointer">
                                    <input type="radio" name="gender" value="Male" <?php echo e($selectedGender === 'male' ? 'checked' : ''); ?> class="peer hidden">
                                    <div class="border-2 border-gray-200 bg-white rounded-xl py-3 px-4 text-center cursor-pointer font-bold text-gray-500 peer-checked:bg-brand-light/40 peer-checked:text-brand-dark peer-checked:border-brand-dark transition flex items-center justify-center gap-2 hover:border-gray-300 shadow-sm">
                                        <i class="fas fa-male text-lg text-blue-500"></i>
                                        <span>Male</span>
                                    </div>
                                </label>

                                <!-- Other -->
                                <label class="cursor-pointer col-span-2 sm:col-span-1">
                                    <input type="radio" name="gender" value="Other" <?php echo e($selectedGender === 'other' ? 'checked' : ''); ?> class="peer hidden">
                                    <div class="border-2 border-gray-200 bg-white rounded-xl py-3 px-4 text-center cursor-pointer font-bold text-gray-500 peer-checked:bg-brand-light/40 peer-checked:text-brand-dark peer-checked:border-brand-dark transition flex items-center justify-center gap-2 hover:border-gray-300 shadow-sm">
                                        <i class="fas fa-user-circle text-lg text-teal-600"></i>
                                        <span>Other</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Age & Date of Birth -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">
                                    Enter Age
                                </label>
                                <div class="relative">
                                    <input 
                                        type="number" 
                                        id="profile_age" 
                                        name="age" 
                                        value="<?php echo e(old('age', $profile->age !== '-' ? $profile->age : '')); ?>" 
                                        min="1" 
                                        max="120" 
                                        placeholder="Enter Age (e.g. 28)" 
                                        class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-primary focus:border-brand-primary font-bold text-gray-800 text-sm outline-none transition placeholder-gray-300"
                                    >
                                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-bold text-gray-400">Years</span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">
                                    Date Of Birth
                                </label>
                                <input 
                                    type="date" 
                                    id="profile_dob" 
                                    name="dob" 
                                    value="<?php echo e(old('dob', $profile->dob ? \Carbon\Carbon::parse($profile->dob)->format('Y-m-d') : '')); ?>" 
                                    class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-primary focus:border-brand-primary font-bold text-gray-800 text-sm outline-none transition text-gray-700"
                                >
                            </div>
                        </div>

                        <!-- Relation Selector -->
                        <div>
                            <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">
                                Select Relation
                            </label>
                            <?php
                                $currentRelation = strtolower(old('relation', $profile->relation ?: 'self'));
                                $relations = [
                                    'self' => 'Self',
                                    'spouse' => 'Spouse',
                                    'mother' => 'Mother',
                                    'father' => 'Father',
                                    'daughter' => 'Daughter',
                                    'son' => 'Son',
                                    'other' => 'Other',
                                ];
                            ?>
                            <div class="flex flex-wrap gap-2.5">
                                <?php $__currentLoopData = $relations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relKey => $relLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <label class="cursor-pointer">
                                        <input type="radio" name="relation" value="<?php echo e($relKey); ?>" <?php echo e($currentRelation === $relKey ? 'checked' : ''); ?> class="peer hidden">
                                        <div class="border border-gray-200 bg-gray-50 rounded-full px-5 py-2.5 cursor-pointer font-bold text-xs text-gray-500 peer-checked:bg-brand-dark peer-checked:text-white peer-checked:border-brand-dark transition shadow-sm hover:border-gray-300 hover:bg-gray-100">
                                            <?php echo e($relLabel); ?>

                                        </div>
                                    </label>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                        <!-- Contact Details Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                            <!-- Primary Mobile (Locked & Verified) -->
                            <div>
                                <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">
                                    Mobile Number (Primary)
                                </label>
                                <div class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 flex items-center justify-between">
                                    <div>
                                        <span class="block text-xs font-bold text-gray-400 mb-0.5">Verified Primary Number</span>
                                        <span class="font-black text-gray-800 text-base tracking-wide">+91 <?php echo e($profile->mobile); ?></span>
                                    </div>
                                    <span class="inline-flex items-center gap-1 bg-emerald-100 text-emerald-700 text-[11px] font-black px-2.5 py-1 rounded-full">
                                        <i class="fas fa-check-circle text-xs"></i> Verified
                                    </span>
                                </div>
                                <input type="hidden" name="mobile" value="<?php echo e($profile->mobile); ?>">
                            </div>

                            <!-- Alternate Mobile -->
                            <div>
                                <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">
                                    Alternate Number (Optional)
                                </label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-bold text-sm border-r pr-3 border-gray-200 flex items-center gap-1">
                                        <span>+91</span>
                                        <i class="fas fa-caret-down text-gray-400 text-xs"></i>
                                    </span>
                                    <input 
                                        type="tel" 
                                        name="alt_mobile" 
                                        value="<?php echo e(old('alt_mobile', $profile->alt_mobile)); ?>" 
                                        maxlength="10" 
                                        placeholder="Enter Alternate Number" 
                                        class="w-full pl-24 pr-4 py-3.5 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-primary focus:border-brand-primary font-bold text-gray-800 text-sm outline-none transition placeholder-gray-300"
                                    >
                                </div>
                            </div>
                        </div>

                        <!-- Email Address -->
                        <div>
                            <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">
                                Email Address (For Reports & Invoices) <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">
                                    <i class="far fa-envelope"></i>
                                </span>
                                <input 
                                    type="email" 
                                    name="email" 
                                    value="<?php echo e(old('email', $profile->email !== '-' ? $profile->email : '')); ?>" 
                                    placeholder="Enter Email Address (e.g. user@example.com)" 
                                    class="w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-primary focus:border-brand-primary font-bold text-gray-800 text-sm outline-none transition placeholder-gray-300" 
                                    required
                                >
                            </div>
                            <p class="text-[11px] text-gray-400 font-medium mt-1">Your digitally signed laboratory test reports and billing receipts will be sent to this email.</p>
                        </div>

                        <!-- Actions -->
                        <div class="flex flex-col-reverse sm:flex-row items-center gap-3 pt-6 border-t border-gray-100">
                            <button type="button" onclick="switchDashboardTab('overview')" class="w-full sm:w-1/3 text-center border-2 border-gray-200 hover:border-gray-300 text-gray-600 font-extrabold py-3.5 rounded-xl hover:bg-gray-50 transition text-sm">
                                Return to Overview
                            </button>
                            <button type="submit" class="w-full sm:w-2/3 bg-brand-dark hover:bg-opacity-95 text-white font-extrabold py-3.5 rounded-xl shadow-md hover:shadow-lg transition flex items-center justify-center gap-2 text-sm">
                                <i class="fas fa-save"></i> Save Profile Details
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // Tab switching system
    function switchDashboardTab(tabName) {
        const tabs = ['overview', 'notifications', 'profile'];
        tabs.forEach(t => {
            const btn = document.getElementById('tabBtn-' + t);
            const content = document.getElementById('tabContent-' + t);
            if (!btn || !content) return;

            if (t === tabName) {
                btn.className = 'tab-btn flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-xs font-black transition-all bg-brand-dark text-white shadow-xs';
                content.classList.remove('hidden');
            } else {
                btn.className = 'tab-btn flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-xs font-black transition-all text-gray-600 hover:text-brand-dark hover:bg-gray-50';
                content.classList.add('hidden');
            }
        });
    }

    // Mark single notification read inline
    function markNotifReadInline(notifId) {
        fetch('/patient/notifications/mark-read/' + notifId, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                const row = document.querySelector('.notif-row-' + notifId);
                if (row) {
                    row.classList.remove('bg-teal-50/40');
                    row.classList.add('hover:bg-gray-50/60');
                    const markBtn = row.querySelector('button');
                    if (markBtn) markBtn.remove();
                    const pingDot = row.querySelector('.animate-ping');
                    if (pingDot) pingDot.remove();
                }
                // Also trigger header refresh if available
                if (typeof fetchPatientNotifications === 'function') {
                    fetchPatientNotifications();
                }
            }
        })
        .catch(err => console.error('Mark read error:', err));
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Auto Age calculation from DOB
        const dobInput = document.getElementById('profile_dob');
        const ageInput = document.getElementById('profile_age');

        if (dobInput && ageInput) {
            dobInput.addEventListener('change', function() {
                if (this.value) {
                    const dob = new Date(this.value);
                    const today = new Date();
                    let age = today.getFullYear() - dob.getFullYear();
                    const monthDiff = today.getMonth() - dob.getMonth();
                    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                        age--;
                    }
                    if (age >= 0 && age <= 120) {
                        ageInput.value = age;
                    }
                }
            });
        }

        // Check URL hash on page load
        const hash = window.location.hash;
        if (hash === '#profile-form' || hash === '#profile') {
            switchDashboardTab('profile');
        } else if (hash === '#notifications') {
            switchDashboardTab('notifications');
        } else {
            switchDashboardTab('overview');
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Employee\Desktop\outsourcelab\resources\views/patient/pages/dashboard.blade.php ENDPATH**/ ?>