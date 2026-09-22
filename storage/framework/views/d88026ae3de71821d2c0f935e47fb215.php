<?php $__env->startSection('content'); ?>
    <div style="text-align: center; margin-bottom: 24px;">
        <span class="badge badge-primary">Phlebotomist Assigned</span>
        <h2 style="margin: 12px 0 6px; color: #0f172a; font-size: 20px;">Phlebotomist Assigned</h2>
        <p style="margin: 0; color: #64748b; font-size: 14px;">
            Hello <strong><?php echo e($booking->patient?->name ?? 'Valued Customer'); ?></strong>, our phlebotomist has been assigned for your test sample collection.
        </p>
    </div>

    <div class="info-card">
        <h4 style="margin: 0 0 12px; font-size: 13px; color: #64748b; text-transform: uppercase;">Phlebotomist Details</h4>
        <table style="width: 100%; border-collapse: collapse;">
            <tr style="border-bottom: 1px dashed #e2e8f0;">
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Name</td>
                <td style="padding: 8px 0; color: #0f172a; font-weight: 700; font-size: 14px; text-align: right;"><?php echo e($booking->agent?->name ?? 'Assigned Agent'); ?></td>
            </tr>
            <?php if($booking->agent?->phone): ?>
            <tr style="border-bottom: 1px dashed #e2e8f0;">
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Phone Number</td>
                <td style="padding: 8px 0; color: #0d9488; font-weight: 600; font-size: 14px; text-align: right;">
                    <a href="tel:<?php echo e($booking->agent->phone); ?>" style="color: #0d9488; text-decoration: none;"><?php echo e($booking->agent->phone); ?></a>
                </td>
            </tr>
            <?php endif; ?>
            <?php if($booking->agent?->vehicle_number): ?>
            <tr style="border-bottom: 1px dashed #e2e8f0;">
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Vehicle Number</td>
                <td style="padding: 8px 0; color: #0f172a; font-weight: 600; font-size: 14px; text-align: right;"><?php echo e($booking->agent->vehicle_number); ?></td>
            </tr>
            <?php endif; ?>
            <tr>
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Booking Reference</td>
                <td style="padding: 8px 0; color: #0f172a; font-weight: 600; font-size: 14px; text-align: right;">#<?php echo e($booking->booking_reference); ?></td>
            </tr>
        </table>
    </div>

    <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 14px 18px; margin-bottom: 20px;">
        <p style="margin: 0; font-size: 13px; color: #166534;">
            💡 <strong>Pre-collection tip:</strong> Please ensure you follow any required fasting guidelines before the phlebotomist arrives.
        </p>
    </div>

    <div style="text-align: center; margin-top: 24px;">
        <a href="<?php echo e(url('/patient/bookings')); ?>" class="btn">Track Booking Status</a>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('emails.layouts.base', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Employee\Desktop\outsourcelab\resources\views/emails/agent-assigned-customer.blade.php ENDPATH**/ ?>