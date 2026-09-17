<?php $__env->startSection('content'); ?>
<div class="px-6 py-6 sm:px-8 max-w-4xl mx-auto">
    <!-- Header Section -->
    <div class="flex items-center space-x-4 mb-8">
        <a href="<?php echo e(route('admin.departments.index')); ?>" class="p-2 rounded-xl bg-slate-800/50 text-slate-400 hover:text-white hover:bg-slate-700/50 transition-all border border-slate-700/50">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-white tracking-tight">Edit Department</h1>
            <p class="text-slate-400 text-sm mt-1">Update health test service department details.</p>
        </div>
    </div>

    <!-- Form Section -->
    <div class="bg-slate-800/50 backdrop-blur-xl rounded-2xl border border-slate-700/50 shadow-xl overflow-hidden relative">
        <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-slate-600 to-transparent opacity-50"></div>
        
        <form action="<?php echo e(route('admin.departments.update', $department->id)); ?>" method="POST" class="p-8">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <!-- Name Field -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-slate-300 mb-2">Department Name</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-brand-primary transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <input type="text" name="name" id="name" value="<?php echo e(old('name', $department->name)); ?>" required
                        class="w-full pl-11 pr-4 py-3 bg-slate-900/50 border border-slate-700/50 rounded-xl text-slate-200 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-brand-primary/50 focus:border-brand-primary transition-all duration-200"
                        placeholder="e.g. Blood Test, CT Scan">
                </div>
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-2 text-sm text-red-400"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Parameters Field (Dynamic) -->
            <div class="mb-6">
                <div class="flex justify-between items-center mb-2">
                    <label class="block text-sm font-medium text-slate-300">Test Parameters (e.g. Sugar, Blood Group, etc.)</label>
                    <button type="button" id="addParameterBtn" class="text-xs font-semibold text-brand-primary hover:text-brand-primary/80 transition-colors flex items-center">
                        <i class="fas fa-plus mr-1"></i> Add More
                    </button>
                </div>
                
                <div id="parametersContainer" class="space-y-3">
                    <?php
                        $parameters = is_array($department->parameters) ? $department->parameters : [];
                    ?>

                    <?php $__empty_1 = true; $__currentLoopData = $parameters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $param): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="relative group parameter-row">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-brand-primary transition-colors">
                            <i class="fas fa-vial w-5 h-5 flex items-center justify-center"></i>
                        </div>
                        <input type="text" name="parameters[]" value="<?php echo e($param); ?>" required
                            class="w-full pl-11 pr-10 py-3 bg-slate-900/50 border border-slate-700/50 rounded-xl text-slate-200 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-brand-primary/50 focus:border-brand-primary transition-all duration-200"
                            placeholder="Enter parameter name">
                        <button type="button" class="remove-parameter absolute inset-y-0 right-0 pr-4 flex items-center text-slate-500 hover:text-red-400 transition-colors" style="<?php echo e(count($parameters) > 1 ? 'display: flex;' : 'display: none;'); ?>">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="relative group parameter-row">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-brand-primary transition-colors">
                            <i class="fas fa-vial w-5 h-5 flex items-center justify-center"></i>
                        </div>
                        <input type="text" name="parameters[]" required
                            class="w-full pl-11 pr-10 py-3 bg-slate-900/50 border border-slate-700/50 rounded-xl text-slate-200 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-brand-primary/50 focus:border-brand-primary transition-all duration-200"
                            placeholder="Enter parameter name">
                        <button type="button" class="remove-parameter absolute inset-y-0 right-0 pr-4 flex items-center text-slate-500 hover:text-red-400 transition-colors" style="display: none;">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <?php endif; ?>
                </div>
                <?php $__errorArgs = ['parameters'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-2 text-sm text-red-400"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <?php $__errorArgs = ['parameters.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-2 text-sm text-red-400"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 flex justify-end">
                <a href="<?php echo e(route('admin.departments.index')); ?>" class="px-6 py-3 mr-3 font-medium text-slate-300 transition-colors hover:text-white">
                    Cancel
                </a>
                <button type="submit" class="group relative inline-flex items-center justify-center px-8 py-3 font-semibold text-white transition-all duration-200 bg-brand-primary border border-transparent rounded-xl hover:bg-brand-primary/90 hover:shadow-lg hover:shadow-brand-primary/30 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-primary focus:ring-offset-slate-900 active:scale-95">
                    Update Test
                    <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('parametersContainer');
    const addBtn = document.getElementById('addParameterBtn');
    
    function updateRemoveButtons() {
        const rows = container.querySelectorAll('.parameter-row');
        rows.forEach((row, index) => {
            const btn = row.querySelector('.remove-parameter');
            if (rows.length > 1) {
                btn.style.display = 'flex';
            } else {
                btn.style.display = 'none';
            }
        });
    }

    addBtn.addEventListener('click', function() {
        const firstRow = container.querySelector('.parameter-row');
        const newRow = firstRow.cloneNode(true);
        newRow.querySelector('input').value = ''; // clear value
        
        container.appendChild(newRow);
        updateRemoveButtons();
    });

    container.addEventListener('click', function(e) {
        if (e.target.closest('.remove-parameter')) {
            const row = e.target.closest('.parameter-row');
            if (container.querySelectorAll('.parameter-row').length > 1) {
                row.remove();
                updateRemoveButtons();
            }
        }
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\outsourcelab\resources\views/admin/test_categories/edit.blade.php ENDPATH**/ ?>