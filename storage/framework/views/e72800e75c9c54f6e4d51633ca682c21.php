<?php $__env->startSection('content'); ?>
<div class="px-6 py-6 sm:px-8 max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="flex justify-between items-end mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2 tracking-tight">Departments</h1>
            <p class="text-slate-400 text-sm font-medium">Manage health test departments and service categories.</p>
        </div>
        <a href="<?php echo e(route('admin.departments.create')); ?>" class="group relative inline-flex items-center justify-center px-6 py-3 font-semibold text-white transition-all duration-200 bg-brand-primary border border-transparent rounded-xl hover:bg-brand-primary/90 hover:shadow-lg hover:shadow-brand-primary/30 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-primary focus:ring-offset-slate-900 active:scale-95">
            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Department
        </a>
    </div>

    <!-- Alert Messages -->
    <?php if(session('success')): ?>
        <div class="mb-6 p-4 rounded-xl bg-green-500/10 border border-green-500/20 text-green-400 flex items-start">
            <svg class="w-5 h-5 mr-3 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <!-- Data Table -->
    <div class="bg-slate-800/50 backdrop-blur-xl rounded-2xl border border-slate-700/50 shadow-xl overflow-hidden relative">
        <!-- Table Header Gradient -->
        <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-slate-600 to-transparent opacity-50"></div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-700/50 bg-slate-900/40">
                        <th class="px-6 py-4 text-xs font-semibold text-slate-300 uppercase tracking-wider w-16">ID</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-300 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-300 uppercase tracking-wider">Created At</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-300 uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/50">
                    <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-700/30 transition-colors duration-200 group">
                        <td class="px-6 py-4 text-sm font-medium text-slate-400">
                            #<?php echo e($category->id); ?>

                        </td>
                        <td class="px-6 py-4 text-sm text-slate-200 font-medium">
                            <?php echo e($category->name); ?>

                        </td>
                        <td class="px-6 py-4 text-sm text-slate-400">
                            <?php echo e($category->created_at->format('M d, Y')); ?>

                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end space-x-3 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                <!-- Edit Button -->
                                <a href="<?php echo e(route('admin.departments.edit', $category->id)); ?>" class="p-2 text-slate-400 hover:text-brand-primary hover:bg-brand-primary/10 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>

                                <!-- Delete Button -->
                                <form action="<?php echo e(route('admin.departments.destroy', $category->id)); ?>" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this department?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="p-2 text-slate-400 hover:text-red-400 hover:bg-red-400/10 rounded-lg transition-colors" title="Delete">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 mb-4 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                <span class="text-sm font-medium">No departments found</span>
                                <p class="text-xs text-slate-500 mt-1">Get started by creating a new department.</p>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\outsourcelab\resources\views/admin/test_categories/index.blade.php ENDPATH**/ ?>