<?php $__env->startSection('content'); ?>
    <div style="text-align: center; margin-bottom: 24px;">
        <span class="badge badge-success">Report Ready</span>
        <h2 style="margin: 12px 0 6px; color: #0f172a; font-size: 20px;">Your Test Report is Available!</h2>
        <p style="margin: 0; color: #64748b; font-size: 14px;">
            Hello <strong><?php echo e($booking->patient?->name ?? 'Valued Customer'); ?></strong>, your diagnostic test report for booking <strong>#<?php echo e($booking->booking_reference); ?></strong> has been verified and published.
        </p>
    </div>

    <div class="info-card">
        <table style="width: 100%; border-collapse: collapse;">
            <tr style="border-bottom: 1px dashed #e2e8f0;">
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Booking Reference</td>
                <td style="padding: 8px 0; color: #0d9488; font-weight: 700; font-size: 14px; text-align: right;">#<?php echo e($booking->booking_reference); ?></td>
            </tr>
            <tr style="border-bottom: 1px dashed #e2e8f0;">
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Report Date</td>
                <td style="padding: 8px 0; color: #0f172a; font-weight: 600; font-size: 14px; text-align: right;"><?php echo e(now()->format('d M, Y')); ?></td>
            </tr>
            <tr>
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Status</td>
                <td style="padding: 8px 0; color: #15803d; font-weight: 700; font-size: 14px; text-align: right;">Verified & Published</td>
            </tr>
        </table>
    </div>

    <div style="text-align: center; margin-top: 24px;">
        <?php if($booking->report_url): ?>
            <a href="<?php echo e($booking->report_url); ?>" target="_blank" class="btn">View / Download Report</a>
        <?php elseif($booking->report_file): ?>
            <a href="<?php echo e(asset('storage/' . $booking->report_file)); ?>" target="_blank" class="btn">Download Report PDF</a>
        <?php else: ?>
            <a href="<?php echo e(url('/patient/bookings')); ?>" class="btn">View Report in Portal</a>
        <?php endif; ?>
    </div>

    <p style="margin-top: 24px; font-size: 13px; color: #64748b; text-align: center;">
        You can also log in to your patient dashboard at any time to access your past reports and medical history.
    </p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('emails.layouts.base', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Employee\Desktop\outsourcelab\resources\views/emails/report-ready-customer.blade.php ENDPATH**/ ?>