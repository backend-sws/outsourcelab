<?php $__env->startSection('content'); ?>
    <div style="text-align: center; margin-bottom: 24px;">
        <span class="badge badge-primary">New Booking Alert</span>
        <h2 style="margin: 12px 0 6px; color: #0f172a; font-size: 20px;">New Booking Placed</h2>
        <p style="margin: 0; color: #64748b; font-size: 14px;">
            A new booking #<?php echo e($booking->booking_reference); ?> has been submitted and awaits review.
        </p>
    </div>

    <div class="info-card">
        <table style="width: 100%; border-collapse: collapse;">
            <tr style="border-bottom: 1px dashed #e2e8f0;">
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Booking Reference</td>
                <td style="padding: 8px 0; color: #0d9488; font-weight: 700; font-size: 14px; text-align: right;">#<?php echo e($booking->booking_reference); ?></td>
            </tr>
            <tr style="border-bottom: 1px dashed #e2e8f0;">
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Customer Name</td>
                <td style="padding: 8px 0; color: #0f172a; font-weight: 600; font-size: 14px; text-align: right;"><?php echo e($booking->patient?->name ?? 'N/A'); ?></td>
            </tr>
            <tr style="border-bottom: 1px dashed #e2e8f0;">
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Contact Number</td>
                <td style="padding: 8px 0; color: #0f172a; font-weight: 600; font-size: 14px; text-align: right;"><?php echo e($booking->patient?->mobile ?? 'N/A'); ?></td>
            </tr>
            <tr style="border-bottom: 1px dashed #e2e8f0;">
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Date & Time</td>
                <td style="padding: 8px 0; color: #0f172a; font-weight: 600; font-size: 14px; text-align: right;">
                    <?php echo e($booking->booking_date ? \Carbon\Carbon::parse($booking->booking_date)->format('d M, Y') : 'N/A'); ?>

                    <?php if($booking->booking_time): ?> (<?php echo e($booking->booking_time); ?>) <?php endif; ?>
                </td>
            </tr>
            <tr style="border-bottom: 1px dashed #e2e8f0;">
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Payment Status</td>
                <td style="padding: 8px 0; text-align: right;">
                    <span class="badge <?php echo e($booking->payment_status === 'Paid' ? 'badge-success' : 'badge-warning'); ?>">
                        <?php echo e($booking->payment_status ?? 'Pending'); ?>

                    </span>
                </td>
            </tr>
            <tr>
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Amount</td>
                <td style="padding: 8px 0; color: #0f172a; font-weight: 700; font-size: 16px; text-align: right;">
                    ₹<?php echo e(number_format((float) $booking->amount, 2)); ?>

                </td>
            </tr>
        </table>
    </div>

    <div style="text-align: center; margin-top: 24px;">
        <a href="<?php echo e(url('/admin/bookings/' . $booking->id)); ?>" class="btn">View & Assign Phlebotomist</a>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('emails.layouts.base', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Employee\Desktop\outsourcelab\resources\views/emails/booking-placed-admin.blade.php ENDPATH**/ ?>