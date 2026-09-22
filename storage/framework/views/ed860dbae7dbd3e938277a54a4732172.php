<?php $__env->startSection('content'); ?>
    <div style="text-align: center; margin-bottom: 24px;">
        <span class="badge badge-warning">New Agent Registration</span>
        <h2 style="margin: 12px 0 6px; color: #0f172a; font-size: 20px;">New Phlebotomist Registered</h2>
        <p style="margin: 0; color: #64748b; font-size: 14px;">
            A new agent application has been submitted and is pending verification.
        </p>
    </div>

    <div class="info-card">
        <table style="width: 100%; border-collapse: collapse;">
            <tr style="border-bottom: 1px dashed #e2e8f0;">
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Full Name</td>
                <td style="padding: 8px 0; color: #0f172a; font-weight: 700; font-size: 14px; text-align: right;"><?php echo e($agent->name); ?></td>
            </tr>
            <tr style="border-bottom: 1px dashed #e2e8f0;">
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Email</td>
                <td style="padding: 8px 0; color: #0d9488; font-weight: 600; font-size: 14px; text-align: right;"><?php echo e($agent->email); ?></td>
            </tr>
            <tr style="border-bottom: 1px dashed #e2e8f0;">
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Phone</td>
                <td style="padding: 8px 0; color: #0f172a; font-weight: 600; font-size: 14px; text-align: right;"><?php echo e($agent->phone); ?></td>
            </tr>
            <?php if($agent->city): ?>
            <tr style="border-bottom: 1px dashed #e2e8f0;">
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">City</td>
                <td style="padding: 8px 0; color: #0f172a; font-weight: 600; font-size: 14px; text-align: right;"><?php echo e($agent->city); ?></td>
            </tr>
            <?php endif; ?>
            <tr>
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Status</td>
                <td style="padding: 8px 0; text-align: right;">
                    <span class="badge badge-warning"><?php echo e($agent->status ?? 'Pending'); ?></span>
                </td>
            </tr>
        </table>
    </div>

    <div style="text-align: center; margin-top: 24px;">
        <a href="<?php echo e(url('/admin/agents')); ?>" class="btn">Review Agent Application</a>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('emails.layouts.base', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Employee\Desktop\outsourcelab\resources\views/emails/agent-registered-admin.blade.php ENDPATH**/ ?>