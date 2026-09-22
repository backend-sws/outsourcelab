<?php $__env->startSection('content'); ?>
    <div style="text-align: center; margin-bottom: 24px;">
        <span class="badge badge-success">Sample Collected</span>
        <h2 style="margin: 12px 0 6px; color: #0f172a; font-size: 20px;">Sample Successfully Collected</h2>
        <p style="margin: 0; color: #64748b; font-size: 14px;">
            Hello <strong><?php echo e($booking->patient?->name ?? 'Valued Customer'); ?></strong>, your diagnostic sample for booking <strong>#<?php echo e($booking->booking_reference); ?></strong> has been collected.
        </p>
    </div>

    <div class="info-card">
        <p style="margin: 0 0 10px; font-size: 14px; color: #334155;">
            Your sample is being safely transported to our certified diagnostic laboratory in temperature-controlled conditions.
        </p>
        <p style="margin: 0; font-size: 14px; color: #334155;">
            Once testing is complete, our pathologists will verify the results and you will be notified immediately when your report is available online.
        </p>
    </div>

    <div style="text-align: center; margin-top: 24px;">
        <a href="<?php echo e(url('/patient/bookings')); ?>" class="btn">View Live Status</a>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('emails.layouts.base', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Employee\Desktop\outsourcelab\resources\views/emails/sample-collected-customer.blade.php ENDPATH**/ ?>