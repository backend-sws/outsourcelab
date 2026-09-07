<?php $__env->startSection('title', 'Bookings'); ?>
<?php $__env->startSection('header', 'Booking Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
        <h2 class="text-lg font-bold text-gray-800">All Bookings</h2>
        <!-- Future Search/Filter could go here -->
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 text-gray-500 text-xs uppercase tracking-wider">
                    <th class="px-6 py-4 font-semibold">Ref #</th>
                    <th class="px-6 py-4 font-semibold">Date</th>
                    <th class="px-6 py-4 font-semibold">Patient</th>
                    <th class="px-6 py-4 font-semibold">Amount</th>
                    <th class="px-6 py-4 font-semibold">Status</th>
                    <th class="px-6 py-4 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 font-medium text-gray-800"><?php echo e($booking->booking_reference); ?></td>
                    <td class="px-6 py-4 text-gray-600"><?php echo e($booking->booking_date->format('M d, Y h:i A')); ?></td>
                    <td class="px-6 py-4 text-gray-600"><?php echo e($booking->patient->name ?? 'N/A'); ?></td>
                    <td class="px-6 py-4 font-medium text-gray-700">₹<?php echo e($booking->amount); ?></td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            <?php echo e($booking->status == 'Completed' ? 'bg-green-100 text-green-800' : 
                              ($booking->status == 'Cancelled' ? 'bg-red-100 text-red-800' : 
                              ($booking->status == 'Pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800'))); ?>">
                            <?php echo e($booking->status); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="<?php echo e(route('admin.bookings.show', $booking->id)); ?>" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-md transition-colors inline-flex items-center">
                            <i class="fas fa-eye mr-1.5"></i> View
                        </a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">No bookings found.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <?php if($bookings->hasPages()): ?>
    <div class="p-4 border-t border-gray-100 bg-gray-50/50">
        <?php echo e($bookings->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\lab\lab\resources\views/admin/bookings/index.blade.php ENDPATH**/ ?>