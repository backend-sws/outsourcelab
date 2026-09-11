<?php $__env->startSection('title', 'Assigned Visits & Tasks'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">

    <!-- Agent Welcome & Stats Bar -->
    <div class="bg-gradient-to-r from-slate-900 via-teal-950 to-slate-900 rounded-2xl p-5 text-white shadow-lg border border-teal-900/40">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-white/10 pb-4 mb-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-teal-400">Welcome Back</span>
                <h1 class="text-xl sm:text-2xl font-black text-white mt-0.5"><?php echo e($agent->name); ?></h1>
                <p class="text-xs text-slate-300 mt-0.5">
                    <i class="fas fa-map-marker-alt text-amber-400 mr-1"></i> <?php echo e($agent->city ?: 'Assigned Territory'); ?>

                    <?php if(!empty($agent->vehicle_number)): ?>
                        <span class="mx-1 text-slate-500">•</span>
                        <i class="fas fa-motorcycle text-teal-400 mr-1"></i> <?php echo e($agent->vehicle_number); ?>

                    <?php endif; ?>
                </p>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/40">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 mr-1.5 animate-ping"></span> On Duty / Ready
                </span>
            </div>
        </div>

        <!-- Metric KPI Cards -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            <div class="bg-white/5 backdrop-blur-sm rounded-xl p-3 border border-white/10">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Assigned Visits</span>
                <span class="text-2xl font-black text-white mt-1 block"><?php echo e($totalAssigned); ?></span>
            </div>
            <div class="bg-white/5 backdrop-blur-sm rounded-xl p-3 border border-white/10">
                <span class="text-[11px] font-bold text-amber-400 uppercase tracking-wider block">Pending Samples</span>
                <span class="text-2xl font-black text-amber-300 mt-1 block"><?php echo e($pendingCollection); ?></span>
            </div>
            <div class="bg-white/5 backdrop-blur-sm rounded-xl p-3 border border-white/10">
                <span class="text-[11px] font-bold text-emerald-400 uppercase tracking-wider block">Collected</span>
                <span class="text-2xl font-black text-emerald-300 mt-1 block"><?php echo e($samplesCollected); ?></span>
            </div>
            <div class="bg-white/5 backdrop-blur-sm rounded-xl p-3 border border-white/10">
                <span class="text-[11px] font-bold text-teal-400 uppercase tracking-wider block">Cash In-Hand</span>
                <span class="text-2xl font-black text-teal-300 mt-1 block">₹<?php echo e(number_format($cashCollected)); ?></span>
            </div>
        </div>
    </div>

    <!-- Assigned Visits Section -->
    <div class="space-y-4">
        <div class="flex justify-between items-center">
            <h2 class="text-base sm:text-lg font-black text-slate-800 flex items-center gap-2">
                <i class="fas fa-clipboard-list text-teal-600"></i>
                <span>Patients Assigned to You (<?php echo e($bookings->count()); ?>)</span>
            </h2>
            <div class="flex gap-2">
                <a href="<?php echo e(route('agent.progress')); ?>" class="text-xs font-bold text-teal-700 hover:text-teal-900 underline flex items-center gap-1">
                    <span>View Progress Timeline</span>
                    <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
            </div>
        </div>

        <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $patientPhone = $booking->patient->mobile ?: ($booking->patient->phone ?? '');
                $addressStr = $booking->address ? ($booking->address->full_address . ', ' . ($booking->address->landmark ? 'Near ' . $booking->address->landmark . ', ' : '') . $booking->address->city . ' ' . $booking->address->pincode) : 'Address not specified';
                $mapsQuery = urlencode($addressStr);
                $isOnlinePaid = ($booking->payment_status === 'Paid' && $booking->money_collected_by != $agent->id);
                $isCashPending = ($booking->payment_status !== 'Paid');
                $isCollectedByMe = ($booking->payment_status === 'Paid' && $booking->money_collected_by == $agent->id);
            ?>
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/80 hover:border-teal-500/40 transition-all space-y-4">
                
                <!-- Top Header of Card: Ref # and Badges -->
                <div class="flex flex-wrap justify-between items-center gap-2 border-b border-slate-100 pb-3">
                    <div class="flex items-center gap-2">
                        <span class="font-mono text-xs font-black bg-slate-900 text-teal-300 px-2.5 py-1 rounded-lg">
                            #<?php echo e($booking->booking_reference); ?>

                        </span>
                        <span class="text-xs font-semibold text-slate-500">
                            <i class="far fa-clock mr-1"></i> <?php echo e($booking->booking_date ? $booking->booking_date->format('M d, Y • h:i A') : 'Scheduled Today'); ?>

                        </span>
                    </div>

                    <!-- Status Badges -->
                    <div class="flex items-center gap-2">
                        <!-- Sample Status Badge -->
                        <?php if($booking->sample_status === 'Sample Collected'): ?>
                            <span class="inline-flex items-center gap-1 text-xs font-bold px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-300">
                                <i class="fas fa-check-circle"></i> Sample Collected
                            </span>
                        <?php elseif($booking->sample_status === 'Out for Collection'): ?>
                            <span class="inline-flex items-center gap-1 text-xs font-bold px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-800 border border-blue-300 animate-pulse">
                                <i class="fas fa-motorcycle"></i> En Route / Collecting
                            </span>
                        <?php elseif($booking->sample_status === 'Delivered to Lab'): ?>
                            <span class="inline-flex items-center gap-1 text-xs font-bold px-2.5 py-0.5 rounded-full bg-purple-100 text-purple-800 border border-purple-300">
                                <i class="fas fa-flask"></i> Handed to Lab
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center gap-1 text-xs font-bold px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800 border border-amber-300">
                                <i class="fas fa-hourglass-start"></i> Assigned (Pending)
                            </span>
                        <?php endif; ?>

                        <!-- Payment Badge -->
                        <?php if($isOnlinePaid): ?>
                            <span class="inline-flex items-center gap-1 text-xs font-black px-2.5 py-0.5 rounded-full bg-emerald-500 text-white shadow-sm shadow-emerald-500/30">
                                <i class="fas fa-shield-check"></i> PAID ONLINE
                            </span>
                        <?php elseif($isCollectedByMe): ?>
                            <span class="inline-flex items-center gap-1 text-xs font-black px-2.5 py-0.5 rounded-full bg-teal-100 text-teal-800 border border-teal-300">
                                <i class="fas fa-check-double"></i> Cash Collected (₹<?php echo e($booking->amount); ?>)
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center gap-1 text-xs font-black px-2.5 py-0.5 rounded-full bg-rose-100 text-rose-800 border border-rose-300">
                                <i class="fas fa-coins"></i> CASH DUE: ₹<?php echo e($booking->amount); ?>

                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Patient & Location Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Patient Info -->
                    <div class="space-y-1.5">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Patient Details</span>
                        <div class="flex items-center gap-2">
                            <span class="text-base font-extrabold text-slate-900"><?php echo e($booking->patient->name ?? 'Patient'); ?></span>
                            <?php if($booking->familyMember): ?>
                                <span class="text-xs bg-slate-100 text-slate-700 px-2 py-0.5 rounded-md font-bold">
                                    For: <?php echo e($booking->familyMember->name); ?> (<?php echo e($booking->familyMember->relation); ?>)
                                </span>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Click to call patient phone -->
                        <?php if($patientPhone): ?>
                            <div class="pt-1">
                                <a href="tel:<?php echo e($patientPhone); ?>" class="inline-flex items-center gap-2 px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200 rounded-xl text-xs font-extrabold transition">
                                    <i class="fas fa-phone-alt text-emerald-600"></i>
                                    <span>Call: <?php echo e($patientPhone); ?></span>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Destination & Maps Navigation -->
                    <div class="space-y-1.5">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Doorstep Collection Address</span>
                        <p class="text-xs text-slate-700 font-medium leading-relaxed bg-slate-50 p-2.5 rounded-xl border border-slate-200/60">
                            <i class="fas fa-home text-teal-600 mr-1.5"></i>
                            <?php echo e($addressStr); ?>

                        </p>
                        <?php if($booking->address): ?>
                            <div class="pt-0.5">
                                <a href="https://www.google.com/maps/search/?api=1&query=<?php echo e($mapsQuery); ?>" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-bold text-indigo-600 hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 px-2.5 py-1 rounded-lg border border-indigo-200 transition">
                                    <i class="fas fa-location-arrow text-indigo-500"></i>
                                    <span>Open in Google Maps</span>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Tests to Collect -->
                <div class="bg-teal-50/40 rounded-xl p-3 border border-teal-100">
                    <span class="text-[11px] font-bold text-teal-800 uppercase tracking-wider flex items-center gap-1.5 mb-2">
                        <i class="fas fa-vials text-teal-600"></i>
                        <span>Lab Tests to Collect Sample For:</span>
                    </span>
                    <div class="flex flex-wrap gap-2">
                        <?php if(!empty($booking->test_details) && is_array($booking->test_details)): ?>
                            <?php $__currentLoopData = $booking->test_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $test): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-white border border-teal-200 text-xs font-bold text-slate-800 shadow-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-teal-500"></span>
                                    <span><?php echo e($test['name'] ?? 'Diagnostic Test'); ?></span>
                                    <?php if(isset($test['params']) && $test['params']): ?>
                                        <span class="text-[10px] text-slate-500 font-normal">(<?php echo e($test['params']); ?>)</span>
                                    <?php endif; ?>
                                </span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <span class="text-xs text-slate-500">Diagnostic Checkup</span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Action Controls for Agent -->
                <div class="pt-3 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3">
                    <div class="flex flex-wrap items-center gap-2">
                        <!-- Progress Status Update Actions -->
                        <?php if($booking->sample_status === 'Pending' || $booking->sample_status === 'Assigned'): ?>
                            <form action="<?php echo e(route('agent.update_sample_status', $booking->id)); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="sample_status" value="Out for Collection">
                                <button type="submit" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-sm transition">
                                    <i class="fas fa-motorcycle"></i> Start Journey (On The Way)
                                </button>
                            </form>
                        <?php endif; ?>

                        <?php if($booking->sample_status === 'Out for Collection'): ?>
                            <form action="<?php echo e(route('agent.update_sample_status', $booking->id)); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="sample_status" value="Sample Collected">
                                <button type="submit" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-sm transition">
                                    <i class="fas fa-check-circle"></i> Mark Sample Collected
                                </button>
                            </form>
                        <?php endif; ?>

                        <?php if($booking->sample_status === 'Sample Collected'): ?>
                            <form action="<?php echo e(route('agent.update_sample_status', $booking->id)); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="sample_status" value="Delivered to Lab">
                                <button type="submit" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold shadow-sm transition">
                                    <i class="fas fa-flask"></i> Handed to Lab
                                </button>
                            </form>
                        <?php endif; ?>

                        <!-- Collect Cash Button if pending -->
                        <?php if($isCashPending): ?>
                            <form action="<?php echo e(route('agent.collect_money', $booking->id)); ?>" method="POST" class="inline" onsubmit="return confirm('Confirm that you have collected cash payment of ₹<?php echo e($booking->amount); ?> from the patient?');">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="payment_mode" value="Cash">
                                <button type="submit" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 text-xs font-black shadow-sm transition">
                                    <i class="fas fa-hand-holding-usd"></i> Collect Cash ₹<?php echo e($booking->amount); ?>

                                </button>
                            </form>
                        <?php endif; ?>
                    </div>

                    <div class="text-right text-xs text-slate-400">
                        Total Amount: <span class="font-black text-slate-900 text-sm">₹<?php echo e($booking->amount); ?></span>
                    </div>
                </div>

            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="bg-white rounded-2xl p-10 text-center border border-slate-200 shadow-sm">
                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-400 text-2xl">
                    <i class="fas fa-inbox"></i>
                </div>
                <h3 class="text-base font-bold text-slate-800">No Patient Visits Assigned Right Now</h3>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                    Admin has not assigned any pending sample collection bookings to your account yet. When assigned, patient details, address, and test requirements will appear here.
                </p>
            </div>
        <?php endif; ?>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('agent.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\lab\lab\resources\views/agent/dashboard.blade.php ENDPATH**/ ?>