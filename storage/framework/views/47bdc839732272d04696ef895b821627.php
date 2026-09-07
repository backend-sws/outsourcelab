<?php $__env->startSection('title', 'Enquiry Details'); ?>
<?php $__env->startSection('header'); ?>
<div class="flex items-center">
    <a href="<?php echo e(route('admin.enquiries.index')); ?>" class="text-indigo-600 hover:text-indigo-800 mr-4">
        <i class="fas fa-arrow-left"></i>
    </a>
    Enquiry Details
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 pb-6 border-b border-gray-100">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-1"><?php echo e($enquiry->subject); ?></h2>
                <p class="text-sm text-gray-500">Received on <?php echo e($enquiry->created_at->format('F d, Y h:i A')); ?></p>
            </div>
            <div class="mt-4 md:mt-0">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                    <?php echo e($enquiry->status); ?>

                </span>
            </div>
        </div>
        
        <div class="bg-gray-50 rounded-xl p-4 mb-6 flex items-center">
            <div class="w-12 h-12 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xl font-bold mr-4">
                <?php echo e(substr($enquiry->name, 0, 1)); ?>

            </div>
            <div>
                <p class="font-bold text-gray-800"><?php echo e($enquiry->name); ?></p>
                <p class="text-sm text-gray-600"><a href="mailto:<?php echo e($enquiry->email); ?>" class="text-indigo-600 hover:underline"><?php echo e($enquiry->email); ?></a></p>
            </div>
        </div>
        
        <div class="prose max-w-none text-gray-700">
            <p class="whitespace-pre-line"><?php echo e($enquiry->message); ?></p>
        </div>
        
        <div class="mt-10 pt-6 border-t border-gray-100 flex gap-4">
            <a href="mailto:<?php echo e($enquiry->email); ?>" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-bold transition-colors shadow-sm inline-flex items-center">
                <i class="fas fa-reply mr-2"></i> Reply via Email
            </a>
            <a href="<?php echo e(route('admin.enquiries.index')); ?>" class="px-6 py-2.5 border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                Back to List
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\lab\lab\resources\views/admin/enquiries/show.blade.php ENDPATH**/ ?>