<?php $__env->startSection('content'); ?>
    <div style="text-align: center; margin-bottom: 24px;">
        <span class="badge badge-success">Payment Received</span>
        <h2 style="margin: 12px 0 6px; color: #0f172a; font-size: 20px;">Payment Successful</h2>
        <p style="margin: 0; color: #64748b; font-size: 14px;">
            Hello <strong><?php echo e($booking->patient?->name ?? 'Valued Customer'); ?></strong>, thank you for your payment.
        </p>
    </div>

    <div class="info-card">
        <table style="width: 100%; border-collapse: collapse;">
            <tr style="border-bottom: 1px dashed #e2e8f0;">
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Booking Reference</td>
                <td style="padding: 8px 0; color: #0d9488; font-weight: 700; font-size: 14px; text-align: right;">#<?php echo e($booking->booking_reference); ?></td>
            </tr>
            <?php if($booking->razorpay_payment_id): ?>
            <tr style="border-bottom: 1px dashed #e2e8f0;">
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Transaction ID</td>
                <td style="padding: 8px 0; color: #0f172a; font-family: monospace; font-size: 13px; text-align: right;"><?php echo e($booking->razorpay_payment_id); ?></td>
            </tr>
            <?php endif; ?>
            <tr style="border-bottom: 1px dashed #e2e8f0;">
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Payment Method</td>
                <td style="padding: 8px 0; color: #0f172a; font-weight: 600; font-size: 14px; text-align: right;"><?php echo e($booking->payment_method ?? 'Online / Razorpay'); ?></td>
            </tr>
            <tr>
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Amount Paid</td>
                <td style="padding: 8px 0; color: #15803d; font-weight: 700; font-size: 18px; text-align: right;">
                    ₹<?php echo e(number_format((float) $booking->amount, 2)); ?>

                </td>
            </tr>
        </table>
    </div>

    <div style="text-align: center; margin-top: 24px;">
        <a href="<?php echo e(url('/patient/bookings')); ?>" class="btn">View Booking & Receipt</a>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('emails.layouts.base', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Employee\Desktop\outsourcelab\resources\views/emails/payment-success-customer.blade.php ENDPATH**/ ?>