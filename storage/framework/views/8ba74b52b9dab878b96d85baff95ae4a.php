<?php $__env->startSection('title', 'Tests Management'); ?>
<?php $__env->startSection('header', 'Tests Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex justify-between items-center w-full mb-6">
    <h2 class="text-xl font-bold text-gray-800 dark:text-white">Tests Management</h2>
    <a href="<?php echo e(route('admin.tests.create')); ?>" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold py-2 px-4 rounded-lg transition-colors shadow-sm">
        <i class="fas fa-plus mr-1.5"></i> Add New Test
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 text-gray-500 text-xs uppercase tracking-wider">
                    <th class="px-6 py-4 font-semibold">Image</th>
                    <th class="px-6 py-4 font-semibold">Name</th>
                    <th class="px-6 py-4 font-semibold">Category</th>
                    <th class="px-6 py-4 font-semibold">Price</th>
                    <th class="px-6 py-4 font-semibold text-center">Status</th>
                    <th class="px-6 py-4 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                <?php $__empty_1 = true; $__currentLoopData = $tests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $test): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <?php if($test->image): ?>
                        <img src="<?php echo e(Storage::url($test->image)); ?>" class="w-10 h-10 rounded-lg object-cover border border-gray-200">
                        <?php else: ?>
                        <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400">
                            <i class="fas fa-image"></i>
                        </div>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-800">
                        <?php echo e($test->name); ?>

                        <?php if($test->is_featured): ?>
                        <span class="ml-2 bg-amber-100 text-amber-700 text-[10px] px-2 py-0.5 rounded-full font-bold">FEATURED</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-gray-600"><?php echo e($test->category->name ?? 'Uncategorized'); ?></td>
                    <td class="px-6 py-4 font-medium text-gray-700">₹<?php echo e(number_format($test->price, 2)); ?></td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($test->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'); ?>">
                            <?php echo e($test->is_active ? 'Active' : 'Disabled'); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="<?php echo e(route('admin.tests.edit', $test->id)); ?>" class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-md transition-colors inline-flex items-center">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="<?php echo e(route('admin.tests.destroy', $test->id)); ?>" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this test?');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-md transition-colors inline-flex items-center">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">No tests found. Add some tests to get started.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <?php if($tests->hasPages()): ?>
    <div class="p-4 border-t border-gray-100 bg-gray-50/50">
        <?php echo e($tests->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\lab\lab\resources\views/admin/tests/index.blade.php ENDPATH**/ ?>