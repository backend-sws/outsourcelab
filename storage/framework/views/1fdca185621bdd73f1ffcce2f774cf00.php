<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8 bg-gray-50/50">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar -->
        <?php echo $__env->make('patient.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Main Content -->
        <div class="w-full md:w-2/3 lg:w-3/4">
            <h2 class="text-2xl font-extrabold text-brand-dark mb-6">My Profile</h2>
            
            <div class="bg-white rounded-xl border border-gray-200 p-8 shadow-sm max-w-2xl">
                <div class="grid grid-cols-2 gap-y-6 gap-x-4 mb-8">
                    <div>
                        <p class="text-xs text-brand-dark font-extrabold mb-1">Name</p>
                        <p class="text-sm font-medium text-gray-800"><?php echo e($profile['name']); ?></p>
                    </div>
                    <div></div>
                    
                    <div>
                        <p class="text-xs text-brand-dark font-extrabold mb-1">Gender</p>
                        <p class="text-sm font-medium text-gray-800"><?php echo e($profile['gender']); ?></p>
                    </div>
                    <div>
                        <p class="text-xs text-brand-dark font-extrabold mb-1">Age</p>
                        <p class="text-sm font-medium text-gray-800"><?php echo e($profile['age']); ?></p>
                    </div>
                    
                    <div>
                        <p class="text-xs text-brand-dark font-extrabold mb-1">Mobile number</p>
                        <p class="text-sm font-bold text-brand-secondary"><?php echo e($profile['mobile']); ?></p>
                    </div>
                    <div></div>

                    <div class="col-span-2">
                        <p class="text-xs text-brand-dark font-extrabold mb-1">Email Id</p>
                        <p class="text-sm font-medium text-gray-800"><?php echo e($profile['email']); ?></p>
                    </div>
                </div>

                <a href="<?php echo e(route('patient.profile.edit')); ?>" class="w-full block text-center border-2 border-brand-dark text-brand-dark font-extrabold py-3 rounded-xl hover:bg-brand-dark hover:text-white transition shadow-sm">
                    <i class="far fa-edit mr-2"></i> Edit Profile
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\lab\lab\resources\views/patient/dashboard.blade.php ENDPATH**/ ?>