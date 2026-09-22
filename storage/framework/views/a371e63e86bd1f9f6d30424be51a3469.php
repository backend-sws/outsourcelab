<?php $__env->startSection('content'); ?>
    <div style="text-align: center; margin-bottom: 24px;">
        <span class="badge badge-primary">Sample Collected</span>
        <h2 style="margin: 12px 0 6px; color: #0f172a; font-size: 20px;">Sample Collected by Phlebotomist</h2>
        <p style="margin: 0; color: #64748b; font-size: 14px;">
            Sample collection for booking #<?php echo e($booking->booking_reference); ?> has been completed.
        </p>
    </div>

    <div class="info-card">
        <table style="width: 100%; border-collapse: collapse;">
            <tr style="border-bottom: 1px dashed #e2e8f0;">
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Booking Reference</td>
                <td style="padding: 8px 0; color: #0d9488; font-weight: 700; font-size: 14px; text-align: right;">#<?php echo e($booking->booking_reference); ?></td>
            </tr>
            <tr style="border-bottom: 1px dashed #e2e8f0;">
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Patient Name</td>
                <td style="padding: 8px 0; color: #0f172a; font-weight: 600; font-size: 14px; text-align: right;"><?php echo e($booking->patient?->name ?? 'N/A'); ?></td>
            </tr>
            <tr style="border-bottom: 1px dashed #e2e8f0;">
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Phlebotomist</td>
                <td style="padding: 8px 0; color: #0f172a; font-weight: 600; font-size: 14px; text-align: right;"><?php echo e($booking->agent?->name ?? 'N/A'); ?></td>
            </tr>
            <tr>
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Collection Time</td>
                <td style="padding: 8px 0; color: #0f172a; font-weight: 600; font-size: 14px; text-align: right;"><?php echo e(now()->format('d M, Y h:i A')); ?></td>
            </tr>
        </table>
    </div>

    <div style="text-align: center; margin-top: 24px;">
        <a href="<?php echo e(url('/admin/bookings/' . $booking->id)); ?>" class="btn">View in Admin Panel</a>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('emails.layouts.base', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Employee\Desktop\outsourcelab\resources\views/emails/sample-collected-admin.blade.php ENDPATH**/ ?>