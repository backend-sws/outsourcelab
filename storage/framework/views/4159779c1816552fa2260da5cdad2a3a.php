<?php $__env->startSection('title', isset($package) ? 'Edit Package' : 'Add Package'); ?>
<?php $__env->startSection('header'); ?>
<div class="flex items-center">
    <a href="<?php echo e(route('admin.packages.index')); ?>" class="text-indigo-600 hover:text-indigo-800 mr-4">
        <i class="fas fa-arrow-left"></i>
    </a>
    <?php echo e(isset($package) ? 'Edit Package' : 'Add New Package'); ?>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-4xl mx-auto">
    <form action="<?php echo e(isset($package) ? route('admin.packages.update', $package->id) : route('admin.packages.store')); ?>" method="POST" enctype="multipart/form-data" class="p-6 md:p-8 space-y-6">
        <?php echo csrf_field(); ?>
        <?php if(isset($package)): ?>
            <?php echo method_field('PUT'); ?>
        <?php endif; ?>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Package Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="<?php echo e(old('name', $package->name ?? '')); ?>" required class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-2 border bg-gray-50">
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Type and Subcategory -->
            <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 rounded-xl p-4 border border-gray-200">
                <!-- Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Package Type <span class="text-red-500">*</span></label>
                    <select name="type" id="package_type" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-2 border bg-white">
                        <option value="general" <?php echo e(old('type', $package->type ?? 'general') == 'general' ? 'selected' : ''); ?>>Standard Package (General)</option>
                        <option value="habit" <?php echo e(old('type', $package->type ?? '') == 'habit' ? 'selected' : ''); ?>>Unhealthy Habit Package</option>
                        <option value="femcliffe" <?php echo e(old('type', $package->type ?? '') == 'femcliffe' ? 'selected' : ''); ?>>Femcliffe (Women's Health)</option>
                    </select>
                    <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <!-- Subcategory -->
                <div id="subcategory_container" class="<?php echo e(old('type', $package->type ?? 'general') == 'general' ? 'hidden' : ''); ?>">
                    <label class="block text-sm font-medium text-gray-700 mb-2" id="subcategory_label">Category</label>
                    <select name="subcategory" id="package_subcategory" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-2 border bg-white">
                        <option value="">Select Category...</option>
                    </select>
                    <?php $__errorArgs = ['subcategory'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    
                    <!-- Store the old value so we can set it via JS on load -->
                    <input type="hidden" id="old_subcategory" value="<?php echo e(old('subcategory', $package->subcategory ?? '')); ?>">
                </div>
            </div>
            
            <!-- Price -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Price (₹) <span class="text-red-500">*</span></label>
                <input type="number" step="0.01" name="price" value="<?php echo e(old('price', $package->price ?? '')); ?>" required class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-2 border bg-gray-50">
                <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            
            <!-- Image -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Image</label>
                <input type="file" name="image" accept="image/*" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-1.5 border bg-gray-50 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                <?php if(isset($package) && $package->image): ?>
                    <div class="mt-2">
                        <img src="<?php echo e(Storage::url($package->image)); ?>" class="h-20 rounded-md shadow-sm border border-gray-200">
                    </div>
                <?php endif; ?>
                <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Description -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" rows="3" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-2 border bg-gray-50" placeholder="Brief description about this package..."><?php echo e(old('description', $package->description ?? '')); ?></textarea>
                <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Parameters -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Package Parameters / Tests Included</label>
                <div id="parameters-container" class="space-y-3">
                    <?php
                        $parameters = old('parameters', $package->parameters ?? []);
                    ?>
                    
                    <?php if(!empty($parameters) && count($parameters) > 0): ?>
                        <?php $__currentLoopData = $parameters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $parameter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center gap-2 parameter-row">
                                <select name="parameters[]" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-2 border bg-gray-50">
                                    <option value="">Select a Test Parameter</option>
                                    <?php $__currentLoopData = $testParameters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($tp->name); ?>" <?php echo e($parameter == $tp->name ? 'selected' : ''); ?>><?php echo e($tp->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <button type="button" class="remove-parameter text-red-500 hover:text-red-700 p-2"><i class="fas fa-trash"></i></button>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <div class="flex items-center gap-2 parameter-row">
                            <select name="parameters[]" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-2 border bg-gray-50">
                                <option value="">Select a Test Parameter</option>
                                <?php $__currentLoopData = $testParameters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($tp->name); ?>"><?php echo e($tp->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <button type="button" class="remove-parameter text-red-500 hover:text-red-700 p-2"><i class="fas fa-trash"></i></button>
                        </div>
                    <?php endif; ?>
                </div>
                <button type="button" id="add-parameter" class="mt-3 text-sm text-indigo-600 hover:text-indigo-800 font-medium flex items-center gap-1">
                    <i class="fas fa-plus-circle"></i> Add Another Parameter
                </button>
            </div>
            
            <!-- Toggles -->
            <div class="md:col-span-2 bg-gray-50 rounded-xl p-4 border border-gray-200 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" class="sr-only peer" <?php echo e(old('is_active', isset($package) ? $package->is_active : true) ? 'checked' : ''); ?>>
                    <div class="relative w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                    <span class="ms-3 text-sm font-medium text-gray-700">Active (Visible)</span>
                </label>
                
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_featured" class="sr-only peer" <?php echo e(old('is_featured', $package->is_featured ?? false) ? 'checked' : ''); ?>>
                    <div class="relative w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-amber-300 rounded-full peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500"></div>
                    <span class="ms-3 text-sm font-medium text-gray-700">Featured Package</span>
                </label>
            </div>
        </div>
        
        <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
            <a href="<?php echo e(route('admin.packages.index')); ?>" class="px-6 py-2.5 border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">Cancel</a>
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-bold transition-colors shadow-sm">
                <?php echo e(isset($package) ? 'Update Package' : 'Save Package'); ?>

            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Package Type & Subcategory Logic ---
        const typeSelect = document.getElementById('package_type');
        const subcategoryContainer = document.getElementById('subcategory_container');
        const subcategoryLabel = document.getElementById('subcategory_label');
        const subcategorySelect = document.getElementById('package_subcategory');
        const oldSubcategory = document.getElementById('old_subcategory').value;

        const habitOptions = [
            'Junk Food', 'Sedentary Lifestyle', 'Smoking', 'Alcohol', 'Stress', 'Anger', 'Sleepless'
        ];
        
        const femcliffeOptions = [
            'Pregnancy', 'Wellness', 'PCOS/PCOD', 'Sexual Health', 'Menstrual Health', 'Cancer'
        ];

        function updateSubcategory() {
            const type = typeSelect.value;
            subcategorySelect.innerHTML = '<option value="">Select Category...</option>';
            
            if (type === 'general') {
                subcategoryContainer.classList.add('hidden');
                subcategorySelect.removeAttribute('required');
                return;
            }

            subcategoryContainer.classList.remove('hidden');
            subcategorySelect.setAttribute('required', 'required');

            let options = [];
            if (type === 'habit') {
                subcategoryLabel.textContent = 'Habit Category';
                options = habitOptions;
            } else if (type === 'femcliffe') {
                subcategoryLabel.textContent = 'Femcliffe Category';
                options = femcliffeOptions;
            }

            options.forEach(opt => {
                const optionElement = document.createElement('option');
                optionElement.value = opt;
                optionElement.textContent = opt;
                if (opt === oldSubcategory) {
                    optionElement.selected = true;
                }
                subcategorySelect.appendChild(optionElement);
            });
        }

        typeSelect.addEventListener('change', updateSubcategory);
        updateSubcategory(); // Initial load

        // --- Parameters Logic ---
        const container = document.getElementById('parameters-container');
        const addButton = document.getElementById('add-parameter');

        // Add new parameter row
        addButton.addEventListener('click', function() {
            const firstRow = container.querySelector('.parameter-row');
            const newRow = firstRow.cloneNode(true);
            newRow.querySelector('select').value = '';
            container.appendChild(newRow);
        });

        // Remove parameter row
        container.addEventListener('click', function(e) {
            if (e.target.closest('.remove-parameter')) {
                const rows = container.querySelectorAll('.parameter-row');
                if (rows.length > 1) {
                    e.target.closest('.parameter-row').remove();
                } else {
                    // Clear the value if it's the last row instead of removing
                    e.target.closest('.parameter-row').querySelector('select').value = '';
                }
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\outsourcelab\resources\views/admin/packages/form.blade.php ENDPATH**/ ?>