<?php $__env->startSection('content'); ?>
    <div style="text-align: center; margin-bottom: 24px;">
        <span class="badge badge-success">Booking Confirmed</span>
        <h2 style="margin: 12px 0 6px; color: #0f172a; font-size: 20px;">Thank you for your booking!</h2>
        <p style="margin: 0; color: #64748b; font-size: 14px;">
            Hello <strong><?php echo e($booking->patient?->name ?? 'Valued Customer'); ?></strong>, we have received your test booking.
        </p>
    </div>

    <div class="info-card">
        <table style="width: 100%; border-collapse: collapse;">
            <tr style="border-bottom: 1px dashed #e2e8f0;">
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Booking Reference</td>
                <td style="padding: 8px 0; color: #0d9488; font-weight: 700; font-size: 14px; text-align: right;">#<?php echo e($booking->booking_reference); ?></td>
            </tr>
            <tr style="border-bottom: 1px dashed #e2e8f0;">
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Scheduled Date</td>
                <td style="padding: 8px 0; color: #0f172a; font-weight: 600; font-size: 14px; text-align: right;">
                    <?php echo e($booking->booking_date ? \Carbon\Carbon::parse($booking->booking_date)->format('d M, Y') : 'Scheduled'); ?>

                </td>
            </tr>
            <?php if($booking->booking_time): ?>
            <tr style="border-bottom: 1px dashed #e2e8f0;">
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Time Slot</td>
                <td style="padding: 8px 0; color: #0f172a; font-weight: 600; font-size: 14px; text-align: right;"><?php echo e($booking->booking_time); ?></td>
            </tr>
            <?php endif; ?>
            <tr style="border-bottom: 1px dashed #e2e8f0;">
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Payment Status</td>
                <td style="padding: 8px 0; text-align: right;">
                    <span class="badge <?php echo e($booking->payment_status === 'Paid' ? 'badge-success' : 'badge-warning'); ?>">
                        <?php echo e($booking->payment_status ?? 'Pending'); ?>

                    </span>
                </td>
            </tr>
            <tr>
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Total Amount</td>
                <td style="padding: 8px 0; color: #0f172a; font-weight: 700; font-size: 16px; text-align: right;">
                    ₹<?php echo e(number_format((float) $booking->amount, 2)); ?>

                </td>
            </tr>
        </table>
    </div>

    <?php if($booking->address): ?>
    <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px 18px; margin-bottom: 20px;">
        <h4 style="margin: 0 0 6px; font-size: 13px; color: #64748b; text-transform: uppercase;">Sample Collection Address</h4>
        <p style="margin: 0; font-size: 14px; color: #334155;">
            <?php echo e($booking->address->address_line1); ?>

            <?php if($booking->address->address_line2): ?>, <?php echo e($booking->address->address_line2); ?><?php endif; ?>
            <?php if($booking->address->city): ?>, <?php echo e($booking->address->city); ?><?php endif; ?>
            <?php if($booking->address->pincode): ?> - <?php echo e($booking->address->pincode); ?><?php endif; ?>
        </p>
    </div>
    <?php endif; ?>

    <div style="text-align: center; margin-top: 24px;">
        <a href="<?php echo e(url('/patient/bookings')); ?>" class="btn">View Booking Details</a>
    </div>

    <p style="margin-top: 24px; font-size: 13px; color: #64748b; text-align: center;">
        Our team is assigning a phlebotomist for your scheduled time. You will receive an update once assigned.
    </p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('emails.layouts.base', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Employee\Desktop\outsourcelab\resources\views/emails/booking-placed-customer.blade.php ENDPATH**/ ?>