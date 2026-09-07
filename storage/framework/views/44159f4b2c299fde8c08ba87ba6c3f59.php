<?php $__env->startSection('title', 'Contact Enquiries'); ?>
<?php $__env->startSection('header', 'Contact Enquiries'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 text-gray-500 text-xs uppercase tracking-wider">
                    <th class="px-6 py-4 font-semibold">Date</th>
                    <th class="px-6 py-4 font-semibold">Name</th>
                    <th class="px-6 py-4 font-semibold">Email</th>
                    <th class="px-6 py-4 font-semibold">Subject</th>
                    <th class="px-6 py-4 font-semibold text-center">Status</th>
                    <th class="px-6 py-4 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                <?php $__empty_1 = true; $__currentLoopData = $enquiries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enquiry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50/50 transition-colors <?php echo e($enquiry->status == 'Unread' ? 'bg-indigo-50/30' : ''); ?>">
                    <td class="px-6 py-4 text-gray-600"><?php echo e($enquiry->created_at->format('M d, Y')); ?></td>
                    <td class="px-6 py-4 font-medium <?php echo e($enquiry->status == 'Unread' ? 'text-gray-900 font-bold' : 'text-gray-800'); ?>"><?php echo e($enquiry->name); ?></td>
                    <td class="px-6 py-4 text-gray-600"><?php echo e($enquiry->email); ?></td>
                    <td class="px-6 py-4 text-gray-600 truncate max-w-xs"><?php echo e($enquiry->subject); ?></td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            <?php echo e($enquiry->status == 'Unread' ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-800'); ?>">
                            <?php echo e($enquiry->status); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="<?php echo e(route('admin.enquiries.show', $enquiry->id)); ?>" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-md transition-colors inline-flex items-center">
                            <i class="fas fa-eye mr-1.5"></i> View
                        </a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">No contact enquiries found.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <?php if($enquiries->hasPages()): ?>
    <div class="p-4 border-t border-gray-100 bg-gray-50/50">
        <?php echo e($enquiries->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\lab\lab\resources\views/admin/enquiries/index.blade.php ENDPATH**/ ?>