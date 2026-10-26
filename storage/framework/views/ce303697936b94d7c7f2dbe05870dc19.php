<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking #<?php echo e($booking->booking_reference); ?></title>
    <?php echo $__env->make('partials.favicon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 20px; margin-bottom: 20px; }
        .logo { font-size: 24px; font-weight: bold; margin-bottom: 10px; }
        .title { font-size: 18px; text-transform: uppercase; letter-spacing: 2px; }
        .details-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px; }
        .box { border: 1px solid #ddd; padding: 15px; border-radius: 5px; }
        .box-title { font-weight: bold; border-bottom: 1px solid #ddd; padding-bottom: 5px; margin-bottom: 10px; margin-top: 0; }
        table { border-collapse: collapse; margin-bottom: 30px; width: 100%; }
        th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background-color: #f5f5f5; }
        .total-row td { font-weight: bold; font-size: 16px; border-top: 2px solid #333; }
        .footer { margin-top: 50px; text-align: center; font-size: 12px; color: #777; border-top: 1px solid #ddd; padding-top: 20px; }
        @media print {
            body { padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #333; color: white; border: none; cursor: pointer;">Print</button>
        <button onclick="window.close()" style="padding: 10px 20px; background: #ddd; color: #333; border: none; cursor: pointer;">Close</button>
    </div>

    <div class="header">
        <div class="logo">LAB SYSTEM</div>
        <div class="title">Booking Receipt</div>
    </div>

    <div class="details-grid">
        <div class="box">
            <h3 class="box-title">Booking Information</h3>
            <p><strong>Reference #:</strong> <?php echo e($booking->booking_reference); ?></p>
            <p><strong>Date:</strong> <?php echo e($booking->booking_date->format('d M, Y')); ?></p>
            <p><strong>Time Slot:</strong> <?php echo e($booking->display_slot); ?></p>
            <p><strong>Status:</strong> <?php echo e($booking->status); ?></p>
            <p><strong>Collection Type:</strong> <?php echo e($booking->collection_type); ?></p>
            <?php if($booking->agent): ?>
            <p><strong>Field Agent:</strong> <?php echo e($booking->agent->name); ?> (<?php echo e($booking->agent->phone); ?>)</p>
            <?php endif; ?>
        </div>
        <div class="box">
            <h3 class="box-title">Patient Information</h3>
            <p><strong>Patient Name:</strong> <?php echo e($booking->beneficiary_name); ?></p>
            <?php if($booking->familyMember): ?>
            <p><strong>Relationship:</strong> <?php echo e($booking->familyMember->relation); ?> of <?php echo e($booking->patient->name ?? 'Account Owner'); ?></p>
            <p><strong>Age / Gender:</strong> <?php echo e($booking->beneficiary_age ? $booking->beneficiary_age . ' Yrs' : 'N/A'); ?> / <?php echo e(ucfirst($booking->beneficiary_gender ?? 'N/A')); ?></p>
            <p><strong>Booked By:</strong> <?php echo e($booking->patient->name ?? 'N/A'); ?> (<?php echo e($booking->patient->mobile ?? ''); ?>)</p>
            <?php else: ?>
            <p><strong>Age / Gender:</strong> <?php echo e($booking->beneficiary_age ? $booking->beneficiary_age . ' Yrs' : 'N/A'); ?> / <?php echo e(ucfirst($booking->beneficiary_gender ?? 'N/A')); ?></p>
            <p><strong>Phone:</strong> <?php echo e($booking->patient->mobile ?? 'N/A'); ?></p>
            <?php endif; ?>
            <?php if($booking->address): ?>
            <p><strong>Address:</strong><br>
            <?php echo e($booking->address->full_address); ?>, <?php echo e($booking->address->city); ?></p>
            <?php endif; ?>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Item / Test Name</th>
                <th style="text-align: right;">Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $booking->test_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $test): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($test['name'] ?? 'Test'); ?></td>
                <td style="text-align: right;">₹<?php echo e(isset($test['price']) ? number_format($test['price'], 2) : '0.00'); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php if($booking->coins_discount > 0): ?>
            <tr>
                <td style="text-align: right; color: #b45309;">Health Coins Redeemed (<?php echo e($booking->coins_redeemed); ?> 🪙)</td>
                <td style="text-align: right; color: #b45309;">-₹<?php echo e(number_format($booking->coins_discount, 2)); ?></td>
            </tr>
            <?php endif; ?>
            <?php if($booking->discount_amount > ($booking->coins_discount ?? 0)): ?>
            <tr>
                <td style="text-align: right; color: #15803d;">Promo / VIP Discount</td>
                <td style="text-align: right; color: #15803d;">-₹<?php echo e(number_format($booking->discount_amount - ($booking->coins_discount ?? 0), 2)); ?></td>
            </tr>
            <?php endif; ?>
            <tr class="total-row">
                <td style="text-align: right;">Final Paid / Payable (<?php echo e($booking->payment_status); ?>)</td>
                <td style="text-align: right;">₹<?php echo e(number_format($booking->amount, 2)); ?></td>
            </tr>
        </tbody>
    </table>
    
    <div style="margin-top: 20px; display: flex; justify-content: space-between; align-items: center;">
        <p><strong>Payment Method:</strong> <?php echo e($booking->payment_method); ?></p>
        <?php if($booking->coins_earned > 0): ?>
        <p style="color: #b45309; font-weight: bold;">🪙 Health Coins Earned on this order: +<?php echo e($booking->coins_earned); ?> Coins</p>
        <?php endif; ?>
    </div>

    <div class="footer">
        <p>Thank you for choosing our lab services.</p>
        <p>This is a computer generated document and does not require signature.</p>
    </div>
</body>
</html>
<?php /**PATH C:\Users\Employee\Desktop\outsourcelab\resources\views/admin/pages/bookings/print.blade.php ENDPATH**/ ?>