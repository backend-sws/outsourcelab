<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8 bg-gray-50/50">
    <div class="max-w-5xl mx-auto">
        <h2 class="text-2xl font-extrabold text-brand-dark mb-6">My Bookings</h2>
        
        <div class="space-y-6">
            <!-- Active Booking -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="bg-brand-light/10 border-b border-gray-200 px-6 py-4 flex justify-between items-center">
                        <div>
                            <span class="bg-green-100 text-green-700 text-xs font-extrabold px-3 py-1 rounded-full uppercase tracking-wide mr-3">In Progress</span>
                            <span class="text-sm font-bold text-gray-500">Booking ID: #BK-10293</span>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-gray-800">04 Sep 2026, 08:00 AM</p>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h3 class="font-extrabold text-gray-900 text-lg">Fit India Full Body Checkup</h3>
                                <p class="text-sm text-gray-500 font-semibold mt-1">For: <?php echo e($profile['name']); ?> • Home Collection</p>
                            </div>
                            <div class="text-right">
                                <p class="font-black text-brand-dark text-xl">₹1799</p>
                                <p class="text-xs text-gray-400 font-bold">To be paid via Cash</p>
                            </div>
                        </div>

                        <!-- Progress Tracker -->
                        <div class="relative pt-8 pb-4">
                            <!-- Line -->
                            <div class="absolute top-12 left-8 right-8 h-1 bg-gray-200 rounded-full z-0"></div>
                            <div class="absolute top-12 left-8 w-1/3 h-1 bg-brand-secondary rounded-full z-0"></div>

                            <div class="flex justify-between relative z-10">
                                <!-- Step 1 -->
                                <div class="text-center w-24">
                                    <div class="w-10 h-10 mx-auto bg-brand-secondary text-white rounded-full flex items-center justify-center font-bold text-lg mb-2 shadow-sm border-4 border-white">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <p class="text-xs font-extrabold text-brand-dark">Booked</p>
                                </div>
                                <!-- Step 2 -->
                                <div class="text-center w-24">
                                    <div class="w-10 h-10 mx-auto bg-brand-secondary text-white rounded-full flex items-center justify-center font-bold text-lg mb-2 shadow-sm border-4 border-white">
                                        <i class="fas fa-spinner fa-spin"></i>
                                    </div>
                                    <p class="text-xs font-extrabold text-brand-dark">Sample Collection</p>
                                </div>
                                <!-- Step 3 -->
                                <div class="text-center w-24">
                                    <div class="w-10 h-10 mx-auto bg-gray-200 text-gray-400 rounded-full flex items-center justify-center font-bold text-lg mb-2 shadow-sm border-4 border-white">
                                        3
                                    </div>
                                    <p class="text-xs font-bold text-gray-400">Processing</p>
                                </div>
                                <!-- Step 4 -->
                                <div class="text-center w-24">
                                    <div class="w-10 h-10 mx-auto bg-gray-200 text-gray-400 rounded-full flex items-center justify-center font-bold text-lg mb-2 shadow-sm border-4 border-white">
                                        4
                                    </div>
                                    <p class="text-xs font-bold text-gray-400">Report Ready</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Past Booking -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden opacity-75 hover:opacity-100 transition">
                    <div class="bg-gray-50 border-b border-gray-200 px-6 py-4 flex justify-between items-center">
                        <div>
                            <span class="bg-gray-200 text-gray-600 text-xs font-extrabold px-3 py-1 rounded-full uppercase tracking-wide mr-3">Completed</span>
                            <span class="text-sm font-bold text-gray-500">Booking ID: #BK-09211</span>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-gray-800">12 Jan 2026, 09:30 AM</p>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h3 class="font-extrabold text-gray-900 text-lg">Vitamin D Profile</h3>
                                <p class="text-sm text-gray-500 font-semibold mt-1">For: Anita Sharma • Lab Visit</p>
                            </div>
                            <div class="text-right">
                                <p class="font-black text-brand-dark text-xl">₹499</p>
                                <p class="text-xs text-gray-400 font-bold">Paid Online</p>
                            </div>
                        </div>

                        <!-- Progress Tracker -->
                        <div class="relative pt-8 pb-4">
                            <!-- Line -->
                            <div class="absolute top-12 left-8 right-8 h-1 bg-brand-secondary rounded-full z-0"></div>

                            <div class="flex justify-between relative z-10">
                                <!-- Step 1 -->
                                <div class="text-center w-24">
                                    <div class="w-10 h-10 mx-auto bg-brand-secondary text-white rounded-full flex items-center justify-center font-bold text-lg mb-2 shadow-sm border-4 border-white">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <p class="text-xs font-extrabold text-brand-dark">Booked</p>
                                </div>
                                <!-- Step 2 -->
                                <div class="text-center w-24">
                                    <div class="w-10 h-10 mx-auto bg-brand-secondary text-white rounded-full flex items-center justify-center font-bold text-lg mb-2 shadow-sm border-4 border-white">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <p class="text-xs font-extrabold text-brand-dark">Sample Collection</p>
                                </div>
                                <!-- Step 3 -->
                                <div class="text-center w-24">
                                    <div class="w-10 h-10 mx-auto bg-brand-secondary text-white rounded-full flex items-center justify-center font-bold text-lg mb-2 shadow-sm border-4 border-white">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <p class="text-xs font-extrabold text-brand-dark">Processing</p>
                                </div>
                                <!-- Step 4 -->
                                <div class="text-center w-28">
                                    <div class="w-10 h-10 mx-auto bg-brand-secondary text-white rounded-full flex items-center justify-center font-bold text-lg mb-2 shadow-sm border-4 border-white">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <p class="text-xs font-extrabold text-brand-dark mb-3">Report Ready</p>
                                    <button class="px-4 py-2 bg-brand-dark text-white font-bold text-xs rounded-lg hover:bg-brand-secondary transition shadow-sm w-full">
                                        <i class="fas fa-download mr-1"></i> Download
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\lab\lab\resources\views/patient/bookings.blade.php ENDPATH**/ ?>