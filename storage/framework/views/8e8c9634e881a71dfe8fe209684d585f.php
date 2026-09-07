<?php $__env->startSection('title', 'Reviews Management'); ?>
<?php $__env->startSection('header', 'Reviews Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 text-gray-500 text-xs uppercase tracking-wider">
                    <th class="px-6 py-4 font-semibold">Date</th>
                    <th class="px-6 py-4 font-semibold">Author</th>
                    <th class="px-6 py-4 font-semibold">Rating</th>
                    <th class="px-6 py-4 font-semibold w-1/3">Comment</th>
                    <th class="px-6 py-4 font-semibold text-center">Status</th>
                    <th class="px-6 py-4 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                <?php $__empty_1 = true; $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 text-gray-600"><?php echo e($review->created_at->format('M d, Y')); ?></td>
                    <td class="px-6 py-4 font-medium text-gray-800"><?php echo e($review->author_name); ?></td>
                    <td class="px-6 py-4">
                        <div class="flex text-amber-400 text-xs">
                            <?php for($i=1; $i<=5; $i++): ?>
                                <i class="fas fa-star <?php echo e($i <= $review->rating ? 'text-amber-400' : 'text-gray-300'); ?>"></i>
                            <?php endfor; ?>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-600 italic">"<?php echo e(Str::limit($review->comment, 60)); ?>"</td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            <?php echo e($review->status == 'Approved' ? 'bg-green-100 text-green-800' : 
                              ($review->status == 'Rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800')); ?>">
                            <?php echo e($review->status); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <?php if($review->status == 'Pending'): ?>
                        <form action="<?php echo e(route('admin.reviews.approve', $review->id)); ?>" method="POST" class="inline-block">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="text-green-600 hover:text-green-900 bg-green-50 hover:bg-green-100 px-3 py-1.5 rounded-md transition-colors inline-flex items-center" title="Approve">
                                <i class="fas fa-check"></i>
                            </button>
                        </form>
                        <form action="<?php echo e(route('admin.reviews.reject', $review->id)); ?>" method="POST" class="inline-block">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-md transition-colors inline-flex items-center" title="Reject">
                                <i class="fas fa-times"></i>
                            </button>
                        </form>
                        <?php else: ?>
                            <span class="text-gray-400 text-xs uppercase">Processed</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">No reviews found.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <?php if($reviews->hasPages()): ?>
    <div class="p-4 border-t border-gray-100 bg-gray-50/50">
        <?php echo e($reviews->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\lab\lab\resources\views/admin/reviews/index.blade.php ENDPATH**/ ?>