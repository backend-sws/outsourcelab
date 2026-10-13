<?php $__env->startSection('title', 'Tests Management'); ?>
<?php $__env->startSection('header', 'Tests Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex flex-col sm:flex-row sm:items-center justify-between w-full mb-6 gap-3">
    <div>
        <h2 class="text-xl font-bold text-gray-800 dark:text-white">Tests Management</h2>
        <p class="text-xs text-gray-500 mt-0.5">Manage commercial pricing, offers<?php echo e(config('pathology.enabled', false) ? ', and synchronize tests with Pathology LIS' : ''); ?>.</p>
    </div>
    <div class="flex items-center gap-2.5">
        <?php if(config('pathology.enabled', false)): ?>
        <button type="button" id="testSyncBtn" onclick="syncWithLis(this)" class="bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold py-2.5 px-4 rounded-xl transition-all shadow-sm flex items-center gap-2">
            <i class="fas fa-rotate text-xs"></i> <span>Sync from LIS</span>
        </button>
        <?php endif; ?>
        <a href="<?php echo e(route('admin.tests.create')); ?>" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold py-2.5 px-4 rounded-xl transition-all shadow-sm flex items-center gap-1.5">
            <i class="fas fa-plus text-xs"></i> <span>Add New Test</span>
        </a>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 text-gray-500 text-xs uppercase tracking-wider">
                    <th class="px-6 py-4 font-semibold">Name & Code</th>
                    <th class="px-6 py-4 font-semibold">Department</th>
                    <th class="px-6 py-4 font-semibold">Parameters</th>
                    <th class="px-6 py-4 font-semibold">Pricing & Offer</th>
                    <th class="px-6 py-4 font-semibold text-center">Status</th>
                    <th class="px-6 py-4 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                <?php $__empty_1 = true; $__currentLoopData = $tests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $test): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 font-medium text-gray-800">
                        <div class="flex items-center gap-2">
                            <span><?php echo e($test->name); ?></span>
                            <?php if($test->test_code): ?>
                                <span class="bg-slate-100 text-slate-700 font-mono text-[10px] px-1.5 py-0.5 rounded border"><?php echo e($test->test_code); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="flex items-center gap-1.5 mt-1">
                            <?php if($test->is_featured): ?>
                            <span class="bg-amber-100 text-amber-700 text-[10px] px-2 py-0.5 rounded-full font-bold">FEATURED</span>
                            <?php endif; ?>
                            <?php if(config('pathology.enabled', false) && $test->lock_pricing): ?>
                            <span class="bg-purple-100 text-purple-700 text-[10px] px-2 py-0.5 rounded-full font-bold" title="Price protected from LIS overwrites">PRICE LOCKED</span>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-600 text-xs"><?php echo e($test->category->name ?? 'Uncategorized'); ?></td>
                    <td class="px-6 py-4">
                        <?php
                            $params = is_array($test->parameters) ? array_filter($test->parameters) : [];
                        ?>
                        <?php if(count($params) > 0): ?>
                            <div class="flex flex-wrap gap-1 max-w-xs">
                                <?php $__currentLoopData = array_slice($params, 0, 3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="bg-teal-50 text-teal-700 border border-teal-200 text-[10px] px-1.5 py-0.5 rounded font-medium"><?php echo e($p); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php if(count($params) > 3): ?>
                                    <span class="text-[10px] text-slate-400 font-semibold">+<?php echo e(count($params) - 3); ?> more</span>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <span class="text-xs text-slate-400 italic">No parameters</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900">₹<?php echo e(number_format($test->price, 2)); ?></div>
                        <?php if($test->original_price && $test->original_price > $test->price): ?>
                            <div class="text-[11px] text-gray-400 line-through">MRP: ₹<?php echo e(number_format($test->original_price, 2)); ?></div>
                        <?php endif; ?>
                        <?php if(config('pathology.enabled', false) && $test->lis_price): ?>
                            <div class="text-[10px] text-teal-600 font-semibold">LIS Cost: ₹<?php echo e(number_format($test->lis_price, 2)); ?></div>
                        <?php endif; ?>
                    </td>
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

<script>
    async function syncWithLis(btn) {
        if (!confirm('Fetch latest tests and laboratory specifications from Pathology LIS?')) {
            return;
        }

        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-circle-notch fa-spin text-xs"></i> <span>Syncing...</span>';

        try {
            const res = await fetch('<?php echo e(route("admin.pathology.sync")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                },
                body: JSON.stringify({ overwrite_pricing: false })
            });

            const data = await res.json();
            if (data.success) {
                alert('🎉 ' + data.message);
                window.location.reload();
            } else {
                alert('❌ ' + (data.message || 'Sync failed.'));
            }
        } catch (err) {
            alert('❌ Network connection error while syncing with LIS.');
        } finally {
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    }
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\lab\lab\resources\views/admin/pages/tests/index.blade.php ENDPATH**/ ?>