<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8 bg-gray-50/50">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar -->
        <?php echo $__env->make('patient.layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Main Content -->
        <div class="w-full md:w-2/3 lg:w-3/4 space-y-6">

            <!-- Top Header Bar -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-black text-brand-dark flex items-center gap-2.5">
                        <i class="far fa-calendar-check text-brand-primary"></i>
                        <span>My Test Bookings</span>
                    </h2>
                    <p class="text-xs text-gray-500 font-medium mt-1">Live diagnostic tracking, assigned phlebotomist details, and test reports in real-time.</p>
                </div>
                <div class="flex items-center gap-2 flex-wrap">
                    <a href="<?php echo e(route('patient.prescriptions')); ?>" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-white border border-gray-200 text-gray-700 hover:text-brand-dark hover:border-teal-300 font-extrabold text-xs transition shadow-2xs">
                        <i class="fas fa-file-medical text-brand-primary"></i>
                        <span>Upload Rx</span>
                    </a>
                    <a href="/" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-brand-dark hover:bg-teal-800 text-white font-extrabold text-xs transition shadow-sm">
                        <i class="fas fa-plus"></i>
                        <span>Book New Test</span>
                    </a>
                </div>
            </div>

            <?php
                $allBookings = $profile->bookings->sortByDesc('created_at');
                $totalCount = $allBookings->count();
                $inProgressCount = $allBookings->filter(function($b) {
                    return !in_array($b->status, ['Report Ready', 'Completed', 'Cancelled']);
                })->count();
                $completedCount = $allBookings->filter(function($b) {
                    return in_array($b->status, ['Report Ready', 'Completed']) || !empty($b->report_file_path);
                })->count();
            ?>

            <!-- Summary Stats Bar -->
            <div class="grid grid-cols-3 gap-3 md:gap-4">
                <div class="bg-white rounded-2xl border border-gray-200 p-4 shadow-sm flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-teal-50 border border-teal-200 text-teal-800 flex items-center justify-center font-bold text-base flex-shrink-0">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div>
                        <span class="text-[11px] font-extrabold text-gray-400 uppercase tracking-wider block">Total</span>
                        <span class="text-xl font-black text-brand-dark"><?php echo e($totalCount); ?></span>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-200 p-4 shadow-sm flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 border border-amber-200 text-amber-700 flex items-center justify-center font-bold text-base flex-shrink-0">
                        <i class="fas fa-running"></i>
                    </div>
                    <div>
                        <span class="text-[11px] font-extrabold text-gray-400 uppercase tracking-wider block">In Progress</span>
                        <span class="text-xl font-black text-amber-600"><?php echo e($inProgressCount); ?></span>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-200 p-4 shadow-sm flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center justify-center font-bold text-base flex-shrink-0">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <span class="text-[11px] font-extrabold text-gray-400 uppercase tracking-wider block">Completed</span>
                        <span class="text-xl font-black text-emerald-600"><?php echo e($completedCount); ?></span>
                    </div>
                </div>
            </div>

            <?php if($allBookings->isEmpty()): ?>
                <!-- Premium High-Trust Empty State -->
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8 md:p-12 text-center">
                    <div class="w-20 h-20 mx-auto bg-gradient-to-tr from-teal-50 to-emerald-100 rounded-3xl flex items-center justify-center mb-5 border border-teal-200 shadow-inner">
                        <i class="fas fa-calendar-plus text-3xl text-brand-primary"></i>
                    </div>
                    <h3 class="font-black text-gray-900 text-xl mb-2">No Diagnostic Bookings Found</h3>
                    <p class="text-gray-500 font-medium text-xs md:text-sm max-w-lg mx-auto mb-8">
                        You haven't scheduled any pathology tests or preventive health packages yet. Start your wellness journey with certified home sample collection.
                    </p>

                    <!-- Quick Discovery Action Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-left max-w-3xl mx-auto mb-8">
                        <a href="/checkups/1" class="group bg-gradient-to-br from-teal-50/70 to-white p-4 rounded-2xl border border-teal-200 hover:border-brand-primary hover:shadow-md transition">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-9 h-9 rounded-xl bg-brand-dark text-white flex items-center justify-center text-sm shadow-xs">
                                    <i class="fas fa-heartbeat"></i>
                                </div>
                                <span class="text-[10px] font-black uppercase tracking-wider px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800">POPULAR</span>
                            </div>
                            <h4 class="font-extrabold text-sm text-gray-900 group-hover:text-brand-primary transition">Full Body Packages</h4>
                            <p class="text-[11px] text-gray-500 font-medium mt-1">Liver, Kidney, Lipid, Sugar & 60+ parameters with free home collection.</p>
                            <span class="inline-flex items-center gap-1 text-xs font-black text-brand-primary mt-3 group-hover:translate-x-0.5 transition-transform">
                                Explore Packages &rarr;
                            </span>
                        </a>

                        <a href="/#single-health-checkup" class="group bg-gradient-to-br from-blue-50/70 to-white p-4 rounded-2xl border border-blue-200 hover:border-blue-500 hover:shadow-md transition">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-9 h-9 rounded-xl bg-blue-600 text-white flex items-center justify-center text-sm shadow-xs">
                                    <i class="fas fa-vial"></i>
                                </div>
                                <span class="text-[10px] font-black uppercase tracking-wider px-2 py-0.5 rounded-full bg-blue-100 text-blue-800">ROUTINE</span>
                            </div>
                            <h4 class="font-extrabold text-sm text-gray-900 group-hover:text-blue-600 transition">Individual Tests</h4>
                            <p class="text-[11px] text-gray-500 font-medium mt-1">HbA1c, Thyroid Profile, CBC, Vitamin D3, Vitamin B12 and single scans.</p>
                            <span class="inline-flex items-center gap-1 text-xs font-black text-blue-600 mt-3 group-hover:translate-x-0.5 transition-transform">
                                Search Tests &rarr;
                            </span>
                        </a>

                        <a href="<?php echo e(route('patient.prescriptions')); ?>" class="group bg-gradient-to-br from-amber-50/70 to-white p-4 rounded-2xl border border-amber-200 hover:border-amber-500 hover:shadow-md transition">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-9 h-9 rounded-xl bg-amber-500 text-white flex items-center justify-center text-sm shadow-xs">
                                    <i class="fas fa-file-medical"></i>
                                </div>
                                <span class="text-[10px] font-black uppercase tracking-wider px-2 py-0.5 rounded-full bg-amber-100 text-amber-800">EASY RX</span>
                            </div>
                            <h4 class="font-extrabold text-sm text-gray-900 group-hover:text-amber-700 transition">Upload Prescription</h4>
                            <p class="text-[11px] text-gray-500 font-medium mt-1">Have a doctor's slip? Upload photo and our lab team will schedule tests for you.</p>
                            <span class="inline-flex items-center gap-1 text-xs font-black text-amber-700 mt-3 group-hover:translate-x-0.5 transition-transform">
                                Upload Photo &rarr;
                            </span>
                        </a>
                    </div>

                    <a href="/" class="inline-flex items-center gap-2 bg-brand-dark hover:bg-teal-800 text-white font-extrabold px-8 py-3.5 rounded-xl transition shadow-sm hover:shadow-md text-xs md:text-sm">
                        <i class="fas fa-flask"></i>
                        <span>Browse Diagnostic Catalogue</span>
                    </a>
                </div>
            <?php else: ?>
                <!-- Filter Tabs -->
                <div class="flex items-center gap-2 border-b border-gray-200 pb-2 overflow-x-auto">
                    <button type="button" onclick="filterBookings('all')" id="btn-tab-all" class="booking-tab active px-4 py-2 rounded-xl text-xs font-black bg-brand-dark text-white transition shadow-2xs">
                        All Bookings (<?php echo e($totalCount); ?>)
                    </button>
                    <button type="button" onclick="filterBookings('active')" id="btn-tab-active" class="booking-tab px-4 py-2 rounded-xl text-xs font-black bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 transition">
                        In Progress (<?php echo e($inProgressCount); ?>)
                    </button>
                    <button type="button" onclick="filterBookings('completed')" id="btn-tab-completed" class="booking-tab px-4 py-2 rounded-xl text-xs font-black bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 transition">
                        Completed & Reports (<?php echo e($completedCount); ?>)
                    </button>
                </div>

                <!-- Bookings Cards Container -->
                <div class="space-y-5" id="bookingsListContainer">
                    <?php $__currentLoopData = $allBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $statusMap = [
                                'Booked'                      => ['label' => 'Booked',           'badge' => 'bg-indigo-50 text-indigo-700 border-indigo-200',   'icon' => 'fa-calendar-check', 'activeStep' => 1],
                                'Pending'                     => ['label' => 'Pending',          'badge' => 'bg-amber-50 text-amber-700 border-amber-200',     'icon' => 'fa-clock',          'activeStep' => 1],
                                'Confirmed'                   => ['label' => 'Confirmed',        'badge' => 'bg-blue-50 text-blue-700 border-blue-200',       'icon' => 'fa-check',          'activeStep' => 1],
                                'Assigned'                    => ['label' => 'Agent Assigned',   'badge' => 'bg-teal-50 text-teal-700 border-teal-200',       'icon' => 'fa-motorcycle',     'activeStep' => 2],
                                'Sample Collection Scheduled' => ['label' => 'Scheduled',        'badge' => 'bg-teal-50 text-teal-700 border-teal-200',       'icon' => 'fa-calendar-alt',   'activeStep' => 2],
                                'Out for Collection'          => ['label' => 'Agent On The Way', 'badge' => 'bg-amber-50 text-amber-700 border-amber-200',    'icon' => 'fa-biking',         'activeStep' => 2],
                                'Sample Collected'            => ['label' => 'Sample Collected', 'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'icon' => 'fa-vial',       'activeStep' => 2],
                                'In Process'                  => ['label' => 'Processing',       'badge' => 'bg-yellow-50 text-yellow-700 border-yellow-200',   'icon' => 'fa-microscope',   'activeStep' => 3],
                                'Processing'                  => ['label' => 'Processing',       'badge' => 'bg-yellow-50 text-yellow-700 border-yellow-200',   'icon' => 'fa-microscope',   'activeStep' => 3],
                                'Report Ready'                => ['label' => 'Report Ready',     'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'icon' => 'fa-file-medical-alt', 'activeStep' => 4],
                                'Completed'                   => ['label' => 'Completed',        'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'icon' => 'fa-check-double',     'activeStep' => 4],
                                'Cancelled'                   => ['label' => 'Cancelled',        'badge' => 'bg-rose-50 text-rose-700 border-rose-200',       'icon' => 'fa-times-circle',   'activeStep' => 0],
                            ];
                            $lookupKey = !empty($booking->sample_status) && $booking->sample_status !== 'Pending' ? $booking->sample_status : $booking->status;
                            $info = $statusMap[$lookupKey] ?? [
                                'label' => $booking->status ?: 'Booked',
                                'badge' => 'bg-gray-50 text-gray-700 border-gray-200',
                                'icon'  => 'fa-info-circle',
                                'activeStep' => ($booking->agent ? 2 : 1)
                            ];
                            $isCompleted = in_array($booking->status, ['Report Ready', 'Completed']) || $booking->sample_status === 'Delivered to Lab' || !empty($booking->report_file_path);
                            $filterGroup = $isCompleted ? 'completed' : 'active';
                            $steps = ['Booked', 'Sample Collection', 'Processing', 'Report Ready'];
                            $forName = $booking->familyMember ? $booking->familyMember->name : ($profile->name ?? 'Patient (Self)');
                            $relation = $booking->familyMember ? $booking->familyMember->relation : 'Self';
                            $testDetails = is_array($booking->test_details) ? $booking->test_details : (json_decode($booking->test_details, true) ?: []);
                        ?>

                        <div class="booking-item-card bg-white rounded-2xl border border-gray-200 hover:border-teal-300 shadow-sm transition overflow-hidden" data-status-group="<?php echo e($filterGroup); ?>">
                            
                            <!-- Card Header Bar -->
                            <div class="bg-gradient-to-r from-gray-50/80 via-white to-gray-50/80 border-b border-gray-200 px-6 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div class="flex items-center gap-3 flex-wrap">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-gray-100 text-gray-800 font-mono font-bold text-xs border border-gray-200">
                                        <i class="fas fa-barcode text-gray-400"></i>
                                        <span>#<?php echo e($booking->booking_reference); ?></span>
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl border text-xs font-black <?php echo e($info['badge']); ?>">
                                        <i class="fas <?php echo e($info['icon']); ?>"></i>
                                        <span><?php echo e($info['label']); ?></span>
                                    </span>
                                    <span class="text-xs font-bold text-gray-600 flex items-center gap-1">
                                        <i class="far fa-user text-gray-400"></i>
                                        <span>For: <strong class="text-gray-900"><?php echo e($forName); ?></strong> (<?php echo e($relation); ?>)</span>
                                    </span>
                                </div>
                                <div class="text-right flex flex-col items-start sm:items-end">
                                    <p class="text-xs font-black text-gray-900 flex items-center gap-1.5">
                                        <i class="far fa-calendar-alt text-teal-600"></i>
                                        <span><?php echo e($booking->booking_date ? $booking->booking_date->format('d M Y') : $booking->created_at->format('d M Y')); ?></span>
                                    </p>
                                    <span class="inline-flex items-center gap-1 text-[11px] font-black text-amber-900 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded-md mt-1 shadow-2xs">
                                        <i class="far fa-clock text-[10px] text-amber-700"></i>
                                        <span><?php echo e($booking->display_slot); ?></span>
                                    </span>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="p-6 space-y-5">
                                
                                <!-- Tests List & Pricing Row -->
                                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5">
                                    <div class="space-y-2 flex-1">
                                        <span class="text-[11px] font-extrabold uppercase tracking-wider text-gray-400">Diagnostic Tests & Packages</span>
                                        
                                        <?php if(!empty($testDetails)): ?>
                                            <div class="space-y-1.5">
                                                <?php $__currentLoopData = $testDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $test): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        $tName = is_array($test) ? ($test['name'] ?? 'Diagnostic Test') : $test;
                                                        $tPrice = is_array($test) ? ($test['price'] ?? ($test['selling_price'] ?? 0)) : 0;
                                                        $tType = is_array($test) ? ($test['type'] ?? null) : null;
                                                    ?>
                                                    <div class="flex items-center justify-between gap-3 bg-gray-50/80 rounded-xl px-3.5 py-2 border border-gray-100">
                                                        <div class="flex items-center gap-2.5 min-w-0">
                                                            <div class="w-7 h-7 rounded-lg bg-teal-100/60 text-brand-dark flex items-center justify-center text-xs flex-shrink-0">
                                                                <i class="fas fa-flask"></i>
                                                            </div>
                                                            <span class="font-extrabold text-xs text-gray-900 truncate"><?php echo e($tName); ?></span>
                                                            <?php if($tType): ?>
                                                                <span class="text-[10px] px-2 py-0.5 rounded-full font-bold <?php echo e($tType === 'package' ? 'bg-amber-100 text-amber-800' : 'bg-blue-100 text-blue-800'); ?>">
                                                                    <?php echo e(ucfirst($tType)); ?>

                                                                </span>
                                                            <?php endif; ?>
                                                        </div>
                                                        <?php if($tPrice > 0): ?>
                                                            <span class="font-black text-xs text-brand-dark flex-shrink-0">
                                                                ₹<?php echo e(number_format($tPrice, 0)); ?>

                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        <?php else: ?>
                                            <p class="text-xs font-bold text-gray-700">General Diagnostic Health Checkup</p>
                                        <?php endif; ?>

                                        <?php if(($booking->coins_redeemed ?? 0) > 0 || ($booking->coins_earned ?? 0) > 0): ?>
                                            <div class="flex items-center gap-2 pt-1 flex-wrap">
                                                <?php if(($booking->coins_redeemed ?? 0) > 0): ?>
                                                    <span class="inline-flex items-center gap-1 text-[11px] font-bold text-amber-900 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded-md">
                                                        <span>🪙</span> Redeemed <?php echo e($booking->coins_redeemed); ?> Coins (-₹<?php echo e(number_format($booking->coins_discount, 0)); ?>)
                                                    </span>
                                                <?php endif; ?>
                                                <?php if(($booking->coins_earned ?? 0) > 0): ?>
                                                    <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-900 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-md">
                                                        <span>🪙</span> Earned +<?php echo e($booking->coins_earned); ?> Coins
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Price & Payment Summary Card -->
                                    <div class="lg:text-right lg:border-l lg:border-gray-100 lg:pl-6 flex-shrink-0">
                                        <span class="text-[11px] font-extrabold uppercase tracking-wider text-gray-400 block">Total Amount</span>
                                        <span class="text-2xl font-black text-brand-dark block mt-0.5">₹<?php echo e(number_format($booking->amount, 0)); ?></span>
                                        <div class="mt-1 flex items-center lg:justify-end gap-1.5">
                                            <span class="inline-flex items-center gap-1 text-[11px] font-extrabold px-2 py-0.5 rounded-full <?php echo e($booking->payment_status === 'Paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800'); ?>">
                                                <i class="fas <?php echo e($booking->payment_status === 'Paid' ? 'fa-check-circle' : 'fa-hourglass-half'); ?> text-[10px]"></i>
                                                <span><?php echo e($booking->payment_status === 'Paid' ? 'Paid Online' : 'Cash on Collection'); ?></span>
                                            </span>
                                        </div>
                                        <span class="text-[11px] text-gray-500 font-semibold block mt-1">
                                            <i class="fas fa-map-pin text-[10px] mr-1 text-teal-600"></i> <?php echo e($booking->collection_type ?: 'Home Collection'); ?>

                                        </span>
                                    </div>
                                </div>

                                <!-- Assigned Phlebotomist Card -->
                                <?php if($booking->agent): ?>
                                    <div class="p-3.5 rounded-xl bg-teal-50/60 border border-teal-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-teal-600 text-white flex items-center justify-center font-bold text-sm shadow-sm flex-shrink-0">
                                                <i class="fas fa-motorcycle"></i>
                                            </div>
                                            <div>
                                                <div class="flex items-center gap-2">
                                                    <span class="text-[10px] uppercase font-black tracking-wider text-teal-800">Assigned Phlebotomist</span>
                                                    <span class="text-[10px] bg-teal-200 text-teal-900 font-bold px-2 py-0.2 rounded-full"><?php echo e($booking->sample_status ?: 'Assigned'); ?></span>
                                                </div>
                                                <h4 class="font-black text-teal-950 text-sm"><?php echo e($booking->agent->name); ?></h4>
                                                <?php if($booking->agent->vehicle_number): ?>
                                                    <p class="text-[11px] text-teal-700 font-medium">Vehicle: <?php echo e($booking->agent->vehicle_number); ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <?php if($booking->agent->phone): ?>
                                            <a href="tel:<?php echo e($booking->agent->phone); ?>" class="inline-flex items-center justify-center gap-1.5 px-4 py-2 rounded-xl bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold transition shadow-sm w-fit">
                                                <i class="fas fa-phone-alt text-[10px]"></i>
                                                <span>Call Phlebotomist: <?php echo e($booking->agent->phone); ?></span>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>

                                <!-- 4-Step Diagnostic Progress Tracker -->
                                <div class="relative pt-6 pb-2">
                                    
                                    <div class="absolute top-10 left-8 right-8 h-1 bg-gray-200 rounded-full z-0"></div>
                                    
                                    <?php 
                                        $stepIdx = max(1, min(4, $info['activeStep']));
                                        $fillPct = ($stepIdx - 1) / 3 * 100; 
                                    ?>
                                    <div class="absolute top-10 left-8 h-1 bg-brand-primary rounded-full z-0 transition-all duration-500" style="width: <?php echo e((int)$fillPct); ?>%;"></div>

                                    <div class="flex justify-between relative z-10">
                                        <?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $stepTitle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $sNum = $i + 1;
                                                $done = $sNum < $info['activeStep'] || $isCompleted;
                                                $current = ($sNum === $info['activeStep']) && !$isCompleted;
                                            ?>
                                            <div class="text-center w-24 sm:w-28">
                                                <div class="w-9 h-9 sm:w-10 sm:h-10 mx-auto rounded-full flex items-center justify-center font-bold text-sm mb-2 shadow-sm border-4 border-white transition-all
                                                    <?php echo e($done ? 'bg-brand-primary text-white' : ($current ? 'bg-amber-500 text-white animate-pulse' : 'bg-gray-200 text-gray-400')); ?>">
                                                    <?php if($done): ?>
                                                        <i class="fas fa-check text-xs"></i>
                                                    <?php elseif($current): ?>
                                                        <i class="fas fa-spinner fa-spin text-xs"></i>
                                                    <?php else: ?>
                                                        <?php echo e($sNum); ?>

                                                    <?php endif; ?>
                                                </div>
                                                <p class="text-[11px] sm:text-xs font-<?php echo e($done || $current ? 'extrabold text-brand-dark' : 'semibold text-gray-400'); ?>">
                                                    <?php echo e($stepTitle); ?>

                                                </p>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>

                                <!-- Card Footer Actions -->
                                <div class="pt-4 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                    <div class="flex items-center gap-2">
                                        <?php if($booking->report_file_path): ?>
                                            <a href="<?php echo e(asset('storage/' . $booking->report_file_path)); ?>" target="_blank" download class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-extrabold shadow-sm transition">
                                                <i class="fas fa-file-pdf"></i>
                                                <span>Download PDF Report</span>
                                            </a>
                                        <?php elseif($isCompleted): ?>
                                            <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-800 bg-emerald-50 border border-emerald-200 px-3 py-1.5 rounded-xl">
                                                <i class="fas fa-check-circle text-emerald-600"></i>
                                                <span>Report Generated • Available on Reports tab</span>
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-500 bg-gray-50 border border-gray-200 px-3 py-1.5 rounded-xl">
                                                <i class="fas fa-shield-alt text-teal-600"></i>
                                                <span>Under NABL Protocol & Tracking</span>
                                            </span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="flex items-center gap-3">
                                        <a href="<?php echo e(route('patient.reports')); ?>" class="text-xs font-bold text-teal-700 hover:text-brand-dark transition flex items-center gap-1">
                                            <span>All Reports</span>
                                            <i class="fas fa-chevron-right text-[10px]"></i>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<script>
    function filterBookings(type) {
        // 1. Update button states
        document.querySelectorAll('.booking-tab').forEach(btn => {
            btn.classList.remove('bg-brand-dark', 'text-white', 'shadow-2xs');
            btn.classList.add('bg-white', 'border', 'border-gray-200', 'text-gray-700');
        });
        const activeBtn = document.getElementById('btn-tab-' + type);
        if (activeBtn) {
            activeBtn.classList.remove('bg-white', 'border', 'border-gray-200', 'text-gray-700');
            activeBtn.classList.add('bg-brand-dark', 'text-white', 'shadow-2xs');
        }

        // 2. Filter booking cards
        const cards = document.querySelectorAll('.booking-item-card');
        cards.forEach(card => {
            const group = card.getAttribute('data-status-group');
            if (type === 'all') {
                card.style.display = 'block';
            } else if (type === group) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Employee\Desktop\outsourcelab\resources\views/patient/pages/bookings.blade.php ENDPATH**/ ?>