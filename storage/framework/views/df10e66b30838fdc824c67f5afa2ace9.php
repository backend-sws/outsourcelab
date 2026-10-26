<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tax Invoice #<?php echo e($booking->booking_reference); ?> - Av Wellcare Diagnostics</title>
    <?php echo $__env->make('partials.favicon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif'],
                        mono: ['JetBrains Mono', 'Courier New', 'monospace'],
                    }
                }
            }
        }
    </script>

    <!-- Google Fonts & FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        .font-mono {
            font-family: 'JetBrains Mono', monospace;
        }

        @page {
            size: A4 portrait;
            margin: 8mm 10mm 8mm 10mm;
        }

        @media print {
            html, body {
                background: #ffffff !important;
                color: #0f172a !important;
                margin: 0 !important;
                padding: 0 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                font-size: 10.5pt !important;
            }

            .no-print {
                display: none !important;
            }

            .invoice-wrapper {
                background: #ffffff !important;
                padding: 0 !important;
                margin: 0 !important;
                min-height: auto !important;
            }

            .invoice-sheet {
                box-shadow: none !important;
                border: none !important;
                border-radius: 0 !important;
                max-width: 100% !important;
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 text-xs selection:bg-teal-100 selection:text-teal-900">

<?php
    $testsList = is_array($booking->test_details) ? $booking->test_details : [];
    $subtotalCalculated = 0;
    foreach ($testsList as $t) {
        $subtotalCalculated += (float) (is_array($t) ? ($t['price'] ?? 0) : 0);
    }
    if ($subtotalCalculated <= 0) {
        $subtotalCalculated = (float) $booking->amount + (float) ($booking->discount_amount ?? 0) + (float) ($booking->coins_discount ?? 0);
    }

    $isPaid = in_array(strtolower((string)$booking->payment_status), ['paid', 'captured', 'completed', 'success']) || $booking->money_collected_at !== null;

    $amountInWords = 'Rupees ' . number_format($booking->amount, 0) . ' Only';
    if (class_exists('\NumberFormatter')) {
        try {
            $f = new \NumberFormatter('en_IN', \NumberFormatter::SPELLOUT);
            $amountInWords = ucwords($f->format(round($booking->amount))) . ' Rupees Only';
        } catch (\Throwable $e) {}
    }
?>

<!-- ══════════════════════════════════════════════════════════════════ -->
<!-- SCREEN ACTION BAR (STRICTLY HIDDEN IN PRINT & PDF EXPORT) -->
<!-- ══════════════════════════════════════════════════════════════════ -->
<aside class="no-print bg-slate-900 text-white border-b border-slate-800 sticky top-0 z-50 shadow-md">
    <div class="max-w-4xl mx-auto px-4 py-2.5 flex flex-wrap items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <button type="button" onclick="window.history.length > 1 ? window.history.back() : window.close()" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-bold transition cursor-pointer">
                <i class="fas fa-arrow-left text-[11px]"></i>
                <span>Back</span>
            </button>
            <div class="h-4 w-px bg-slate-700"></div>
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold text-slate-400">Invoice:</span>
                <span class="font-mono text-xs font-black text-teal-400">#<?php echo e($booking->booking_reference); ?></span>
                <?php if($isPaid): ?>
                    <span class="px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 text-[10px] font-black uppercase">
                        Paid
                    </span>
                <?php else: ?>
                    <span class="px-2 py-0.5 rounded-full bg-amber-500/20 text-amber-300 border border-amber-500/30 text-[10px] font-black uppercase">
                        <?php echo e($booking->payment_status ?: 'Payment Due'); ?>

                    </span>
                <?php endif; ?>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="button" onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-1.5 rounded-xl bg-teal-600 hover:bg-teal-500 text-white font-extrabold text-xs shadow-md transition active:scale-95 cursor-pointer">
                <i class="fas fa-print"></i>
                <span>Print / Save as PDF</span>
            </button>
        </div>
    </div>
</aside>

<!-- ══════════════════════════════════════════════════════════════════ -->
<!-- SINGLE-PAGE A4 TAX INVOICE -->
<!-- ══════════════════════════════════════════════════════════════════ -->
<div class="invoice-wrapper py-6 px-3 flex justify-center">
    <main class="invoice-sheet bg-white max-w-3xl w-full rounded-xl shadow-lg border border-slate-200 p-6 sm:p-7 text-slate-800 text-[11px] leading-relaxed">

        <!-- 1. Header (Clean White Letterhead) -->
        <header class="flex items-start justify-between pb-4 border-b border-slate-200">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-teal-700 text-white flex items-center justify-center font-bold text-lg shadow-sm flex-shrink-0">
                    <i class="fas fa-flask"></i>
                </div>
                <div>
                    <h1 class="text-lg font-black text-slate-900 tracking-tight leading-tight">Av Wellcare Diagnostics</h1>
                    <p class="text-[11px] text-slate-600 font-medium">Pathology & Preventive Health Diagnostic Center</p>
                    <p class="text-[10px] text-slate-400 mt-0.5">
                        Moradabad, Uttar Pradesh • Helpline: <?php echo e(\App\Models\Setting::get('helpline_primary', '9311229458')); ?> • support@avwellcarediagnostics.com
                    </p>
                </div>
            </div>

            <div class="text-right flex-shrink-0">
                <span class="inline-block px-2.5 py-0.5 rounded-md bg-teal-50 text-teal-800 border border-teal-200 font-black text-[10px] uppercase tracking-wider mb-1">
                    TAX INVOICE
                </span>
                <div class="font-mono text-sm font-black text-slate-900">
                    #<?php echo e($booking->booking_reference); ?>

                </div>
                <p class="text-[10px] text-slate-500 mt-0.5">
                    Date: <?php echo e($booking->booking_date ? $booking->booking_date->format('d M Y, h:i A') : $booking->created_at->format('d M Y, h:i A')); ?>

                </p>
                <div class="mt-1">
                    <?php if($isPaid): ?>
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[9px] font-black uppercase tracking-wider bg-emerald-100 text-emerald-800 border border-emerald-300">
                            <i class="fas fa-check-circle text-[8px]"></i> Paid Online
                        </span>
                    <?php else: ?>
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[9px] font-black uppercase tracking-wider bg-amber-100 text-amber-800 border border-amber-300">
                            <i class="fas fa-clock text-[8px]"></i> <?php echo e($booking->payment_status ?: 'Payment Due'); ?>

                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </header>

        <!-- 2. Patient, Beneficiary & Service Details Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 py-3 border-b border-slate-200 text-[11px]">
            <!-- Patient Info -->
            <div>
                <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 block mb-0.5">Patient Details</span>
                <p class="font-extrabold text-slate-900"><?php echo e($booking->beneficiary_name); ?></p>
                <p class="text-slate-600">
                    <?php if($booking->beneficiary_age): ?> <?php echo e($booking->beneficiary_age); ?> Yrs <?php endif; ?>
                    <?php if($booking->beneficiary_gender): ?> / <?php echo e(ucfirst($booking->beneficiary_gender)); ?> <?php endif; ?>
                    <?php if($booking->familyMember): ?> • <?php echo e($booking->familyMember->relation); ?> <?php endif; ?>
                </p>
                <p class="text-slate-600">Phone: <strong class="text-slate-800"><?php echo e($booking->patient->mobile ?? 'N/A'); ?></strong></p>
            </div>

            <!-- Appointment & Slot -->
            <div>
                <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 block mb-0.5">Appointment Details</span>
                <p class="font-bold text-slate-800">Date: <?php echo e($booking->booking_date ? $booking->booking_date->format('d M Y') : $booking->created_at->format('d M Y')); ?></p>
                <p class="font-bold text-teal-800">Time Slot: <?php echo e($booking->display_slot); ?></p>
                <p class="text-slate-600">Type: <span class="font-semibold"><?php echo e($booking->collection_type ?: 'Home Collection'); ?></span></p>
            </div>

            <!-- Collection Address & Staff -->
            <div class="col-span-2 sm:col-span-1">
                <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 block mb-0.5">Collection Location</span>
                <p class="text-slate-700 leading-snug">
                    <?php echo e($booking->address ? $booking->address->full_address . ', ' . $booking->address->city . ' ' . $booking->address->pincode : 'Central Diagnostic Lab'); ?>

                </p>
                <?php if($booking->agent): ?>
                    <p class="text-[10px] text-teal-800 mt-0.5 font-bold">
                        Phlebotomist: <?php echo e($booking->agent->name); ?> (<?php echo e($booking->agent->phone); ?>)
                    </p>
                <?php endif; ?>
            </div>
        </div>

        <!-- 3. Diagnostic Tests & Packages Table -->
        <div class="py-3 space-y-1.5">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-black uppercase tracking-wider text-slate-500">Investigations / Tests Included</span>
                <span class="text-[10px] font-bold text-slate-400"><?php echo e(count($testsList)); ?> Item(s)</span>
            </div>

            <div class="border border-slate-200 rounded-lg overflow-hidden">
                <table class="w-full text-left text-[11px] border-collapse">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase font-black tracking-wider text-[9px]">
                        <tr>
                            <th class="py-2 px-3 w-8 text-center">#</th>
                            <th class="py-2 px-3">Test / Package Description</th>
                            <th class="py-2 px-3 text-center">Type</th>
                            <th class="py-2 px-3 text-right">Price (₹)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-800">
                        <?php if(count($testsList) > 0): ?>
                            <?php $__currentLoopData = $testsList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $tName = is_array($item) ? ($item['name'] ?? ($item['title'] ?? 'Diagnostic Test')) : (string)$item;
                                    $tPrice = is_array($item) ? (float)($item['price'] ?? 0) : 0;
                                    $tType = is_array($item) ? ($item['type'] ?? 'test') : 'test';
                                ?>
                                <tr class="hover:bg-slate-50/50">
                                    <td class="py-2 px-3 text-center text-slate-400 font-mono"><?php echo e($idx + 1); ?></td>
                                    <td class="py-2 px-3">
                                        <span class="font-extrabold text-slate-900"><?php echo e($tName); ?></span>
                                        <?php if(is_array($item) && !empty($item['sample_type'])): ?>
                                            <span class="text-[9px] text-slate-400 ml-1">(<?php echo e($item['sample_type']); ?>)</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-2 px-3 text-center">
                                        <span class="px-1.5 py-0.2 rounded text-[9px] font-bold uppercase <?php echo e($tType === 'package' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-700'); ?>">
                                            <?php echo e(ucfirst($tType)); ?>

                                        </span>
                                    </td>
                                    <td class="py-2 px-3 text-right font-black font-mono text-slate-900">
                                        ₹<?php echo e(number_format($tPrice, 2)); ?>

                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <tr>
                                <td class="py-2 px-3 text-center text-slate-400 font-mono">1</td>
                                <td class="py-2 px-3 font-bold text-slate-900">General Diagnostic Health Investigations</td>
                                <td class="py-2 px-3 text-center"><span class="px-1.5 py-0.2 rounded text-[9px] font-bold uppercase bg-slate-100 text-slate-700">Test</span></td>
                                <td class="py-2 px-3 text-right font-black font-mono text-slate-900">₹<?php echo e(number_format($booking->amount, 2)); ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 4. Payment Settlement & Pricing Calculation -->
        <div class="grid grid-cols-2 gap-4 py-3 border-t border-slate-200 text-[11px]">
            <!-- Left Side: Payment Details & Amount in Words -->
            <div class="space-y-1.5">
                <p><span class="font-bold text-slate-500">Payment Mode:</span> <strong class="text-slate-800 uppercase"><?php echo e($booking->payment_method ?: 'Online'); ?></strong></p>
                <p><span class="font-bold text-slate-500">Payment Status:</span> <strong class="<?php echo e($isPaid ? 'text-emerald-700' : 'text-amber-700'); ?>"><?php echo e($isPaid ? 'Paid' : ($booking->payment_status ?: 'Pending')); ?></strong></p>
                <?php if($booking->razorpay_payment_id): ?>
                    <p class="font-mono text-[10px] text-slate-500">Ref: <?php echo e($booking->razorpay_payment_id); ?></p>
                <?php endif; ?>
                <div class="pt-1 text-[10px] text-slate-600">
                    <span class="font-bold text-slate-400 uppercase block text-[9px]">Amount in Words:</span>
                    <span class="italic font-bold text-slate-800"><?php echo e($amountInWords); ?></span>
                </div>
                <p class="text-[9px] text-slate-400 pt-1 leading-snug">
                    Healthcare diagnostic services are exempt from GST under Notification No. 12/2017.
                </p>
            </div>

            <!-- Right Side: Totals Block -->
            <div class="space-y-1 text-right">
                <div class="flex justify-between text-slate-600">
                    <span>Subtotal:</span>
                    <span class="font-mono font-bold">₹<?php echo e(number_format($subtotalCalculated, 2)); ?></span>
                </div>

                <?php if(str_contains(strtolower((string) $booking->collection_type), 'home')): ?>
                    <div class="flex justify-between text-slate-600">
                        <span>Collection Fee:</span>
                        <?php if(($booking->collection_fee ?? 0) > 0): ?>
                            <span class="font-mono font-bold text-slate-800">+ ₹<?php echo e(number_format($booking->collection_fee, 2)); ?></span>
                        <?php else: ?>
                            <span class="font-bold text-emerald-700">₹0.00 (Free)</span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if(($booking->discount_amount ?? 0) > 0): ?>
                    <div class="flex justify-between text-emerald-700 font-semibold">
                        <span>Discount <?php if($booking->coupon_code): ?> (<?php echo e($booking->coupon_code); ?>) <?php endif; ?>:</span>
                        <span class="font-mono font-bold">- ₹<?php echo e(number_format($booking->discount_amount, 2)); ?></span>
                    </div>
                <?php endif; ?>

                <?php if(($booking->coins_discount ?? 0) > 0): ?>
                    <div class="flex justify-between text-amber-800 font-semibold">
                        <span>Coins Discount:</span>
                        <span class="font-mono font-bold">- ₹<?php echo e(number_format($booking->coins_discount, 2)); ?></span>
                    </div>
                <?php endif; ?>

                <div class="flex justify-between items-center pt-2 mt-1 border-t-2 border-slate-900 text-xs sm:text-sm">
                    <span class="font-black text-slate-900 uppercase">Total Amount:</span>
                    <span class="font-mono font-black text-slate-900 text-base">₹<?php echo e(number_format($booking->amount, 2)); ?></span>
                </div>
            </div>
        </div>

        <!-- 5. Simple Footer & Signatory -->
        <footer class="pt-3 mt-3 border-t border-slate-200 flex items-center justify-between text-[10px] text-slate-400">
            <div>
                <p class="font-semibold text-slate-600">Av Wellcare Diagnostics</p>
                <p>Computer generated invoice, requires no physical signature.</p>
            </div>
            <div class="text-right">
                <div class="h-6"></div>
                <p class="font-bold text-slate-700 border-t border-slate-300 pt-0.5">Authorized Signatory</p>
            </div>
        </footer>

    </main>
</div>

<script>
    if (new URLSearchParams(window.location.search).get('print') === '1') {
        window.addEventListener('load', () => window.print());
    }
</script>

</body>
</html>
<?php /**PATH C:\Users\Employee\Desktop\outsourcelab\resources\views/patient/pages/invoice.blade.php ENDPATH**/ ?>