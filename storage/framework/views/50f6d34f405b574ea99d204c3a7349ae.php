<?php $__env->startSection('title', $test->name . ' - Cost, Fasting, Normal Range & Home Collection | Wellcare'); ?>

<?php $__env->startSection('content'); ?>
<!-- Ambient Background Elements -->
<div class="fixed inset-0 z-[-1] pointer-events-none overflow-hidden bg-slate-50/50">
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-teal-200/30 rounded-full blur-3xl"></div>
    <div class="absolute top-96 -right-32 w-96 h-96 bg-indigo-200/20 rounded-full blur-3xl"></div>
</div>

<div class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-xs font-semibold text-gray-500 mb-6" aria-label="Breadcrumb">
        <a href="<?php echo e(route('home')); ?>" class="hover:text-teal-700 transition flex items-center gap-1.5">
            <i class="fas fa-home text-gray-400"></i>
            <span>Home</span>
        </a>
        <i class="fas fa-chevron-right text-[9px] text-gray-300"></i>
        <a href="<?php echo e(route('home')); ?>#single-health-checkup" class="hover:text-teal-700 transition">
            Single Tests
        </a>
        <i class="fas fa-chevron-right text-[9px] text-gray-300"></i>
        <span class="text-teal-800 font-bold truncate max-w-xs"><?php echo e($test->name); ?></span>
    </nav>

    <!-- Main Test Overview & Sticky Booking Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-14">
        
        <!-- Left 8 Columns: Test Info, Clinical Relevance & FAQs -->
        <div class="lg:col-span-8 space-y-8">
            <div class="bg-white rounded-3xl p-8 border border-gray-200 shadow-sm">
                <!-- Badges -->
                <div class="flex flex-wrap items-center gap-2 mb-4">
                    <?php $__currentLoopData = $testDepartments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span class="px-3 py-1 rounded-full bg-teal-50 text-teal-800 text-xs font-bold uppercase tracking-wider border border-teal-200/60">
                        <i class="fas fa-layer-group text-teal-600 mr-1"></i> <?php echo e($dept->name); ?>

                    </span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 text-xs font-bold uppercase tracking-wider border border-emerald-200/60 flex items-center gap-1">
                        <i class="fas fa-check-circle text-emerald-600 text-[10px]"></i> Verified Diagnostic Lab
                    </span>
                    <?php if($test->home_collection_available): ?>
                    <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-800 text-xs font-bold uppercase tracking-wider border border-blue-200/60 flex items-center gap-1">
                        <i class="fas fa-house-medical text-blue-600 text-[10px]"></i> Home Sample Pickup
                    </span>
                    <?php endif; ?>
                </div>

                <!-- Test Title -->
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-gray-900 tracking-tight leading-tight mb-4">
                    <?php echo e($test->name); ?>

                </h1>

                <p class="text-sm text-gray-600 leading-relaxed mb-6 font-medium">
                    <?php echo e($test->preparation_points[0] ?? 'Standard diagnostic blood investigation verified by MD Pathologists according to certified laboratory protocols.'); ?>

                </p>

                <!-- Clinical Specs Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 bg-slate-50 rounded-2xl p-4 border border-slate-200/80">
                    <div class="text-center p-2">
                        <span class="text-[10px] text-gray-400 uppercase font-bold tracking-wider block">Turnaround</span>
                        <span class="text-xs font-bold text-gray-800 mt-1 flex items-center justify-center gap-1">
                            <i class="fas fa-clock text-amber-500"></i> <?php echo e($test->display_tat); ?>

                        </span>
                    </div>
                    <div class="text-center p-2 border-l border-slate-200">
                        <span class="text-[10px] text-gray-400 uppercase font-bold tracking-wider block">Fasting Needed</span>
                        <span class="text-xs font-bold <?php echo e($test->requires_fasting ? 'text-amber-700' : 'text-emerald-700'); ?> mt-1 flex items-center justify-center gap-1">
                            <i class="fas <?php echo e($test->requires_fasting ? 'fa-moon text-amber-500' : 'fa-circle-check text-emerald-500'); ?>"></i>
                            <?php echo e($test->fasting_label); ?>

                        </span>
                    </div>
                    <div class="text-center p-2 border-l border-slate-200">
                        <span class="text-[10px] text-gray-400 uppercase font-bold tracking-wider block">Specimen</span>
                        <span class="text-xs font-bold text-gray-800 mt-1 flex items-center justify-center gap-1">
                            <i class="fas fa-vial text-indigo-600"></i> Blood (Serum/EDTA)
                        </span>
                    </div>
                    <div class="text-center p-2 border-l border-slate-200">
                        <span class="text-[10px] text-gray-400 uppercase font-bold tracking-wider block">Collection</span>
                        <span class="text-xs font-bold text-emerald-700 mt-1 flex items-center justify-center gap-1">
                            <i class="fas fa-house-medical"></i> <?php echo e($test->home_collection_available ? 'At Your Home' : 'Lab Visit'); ?>

                        </span>
                    </div>
                </div>
            </div>

            <!-- Serviceable Pincode Checker Widget -->
            <div class="bg-gradient-to-r from-teal-50 to-indigo-50 rounded-2xl p-6 border border-teal-100/80 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 shadow-sm">
                <div>
                    <h3 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-location-dot text-teal-700"></i>
                        <span>Check Phlebotomist Availability in Your Area</span>
                    </h3>
                    <p class="text-xs text-gray-500 mt-0.5">Enter your 6-digit pincode to check early morning fasting slots.</p>
                </div>
                <div class="w-full sm:w-auto">
                    <label for="checkPincodeInput" class="block text-[11px] font-bold text-teal-950 uppercase tracking-wider mb-1">
                        Area Pincode
                    </label>
                    <div class="flex items-center gap-2">
                        <input type="text" id="checkPincodeInput" maxlength="6" placeholder="Enter Pincode (e.g. 110001)" class="px-4 py-2 text-xs rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-teal-500 bg-white font-mono">
                        <button type="button" onclick="verifyPincodeSlot()" class="px-4 py-2 bg-teal-800 text-white text-xs font-bold rounded-xl hover:bg-teal-900 transition whitespace-nowrap">
                            Check Slot
                        </button>
                    </div>
                </div>
            </div>
            <div id="pincodeResult" class="hidden text-xs font-semibold px-4 py-2 rounded-xl"></div>

            <!-- Pre-Test Preparation & Clinical Information -->
            <div class="bg-white rounded-3xl p-8 border border-gray-200 shadow-sm space-y-6">
                <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2.5">
                    <i class="fas fa-notes-medical text-teal-700"></i>
                    <span>Test Overview & Pre-Test Instructions</span>
                </h2>

                <?php
                    $testParams = is_array($test->parameters) ? array_filter($test->parameters) : [];
                ?>
                <?php if(count($testParams) > 0): ?>
                <div class="bg-teal-50/60 rounded-2xl p-5 border border-teal-200/60">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-bold text-teal-900 flex items-center gap-2">
                            <i class="fas fa-list-ul text-teal-700"></i>
                            Parameters Included in This Test
                        </h3>
                        <span class="text-xs font-bold text-teal-700 bg-white px-2.5 py-1 rounded-full border border-teal-200">
                            <?php echo e(count($testParams)); ?> <?php echo e(count($testParams) === 1 ? 'Parameter' : 'Parameters'); ?>

                        </span>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <?php $__currentLoopData = $testParams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $param): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-white text-teal-800 border border-teal-200 shadow-xs">
                            <i class="fas fa-check-circle text-teal-500 text-[10px]"></i>
                            <?php echo e($param); ?>

                        </span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <?php endif; ?>


                <!-- Pre-Test Preparation & Fasting Guidelines (Clear View with Bullet Points) -->
                <div class="rounded-3xl p-6 sm:p-7 <?php echo e($test->requires_fasting ? 'bg-gradient-to-br from-amber-50/90 via-orange-50/40 to-amber-50/70 border border-amber-200/90' : 'bg-gradient-to-br from-teal-50/70 via-emerald-50/30 to-teal-50/50 border border-teal-200/80'); ?> shadow-sm space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b <?php echo e($test->requires_fasting ? 'border-amber-200/70' : 'border-teal-200/60'); ?> pb-3.5">
                        <div class="flex items-center gap-3">
                            <span class="w-10 h-10 rounded-2xl <?php echo e($test->requires_fasting ? 'bg-amber-500/15 text-amber-700' : 'bg-teal-500/15 text-teal-700'); ?> flex items-center justify-center text-lg flex-shrink-0">
                                <i class="fas <?php echo e($test->requires_fasting ? 'fa-utensils' : 'fa-circle-check'); ?>"></i>
                            </span>
                            <div>
                                <h3 class="text-base sm:text-lg font-black text-gray-900 flex items-center gap-2">
                                    <span>Patient Preparation & Fasting Guidelines</span>
                                </h3>
                                <p class="text-xs text-gray-500 mt-0.5">
                                    Please follow these clinical protocols carefully for verified diagnostic accuracy.
                                </p>
                            </div>
                        </div>

                        <!-- Fasting Badge -->
                        <div>
                            <?php if($test->requires_fasting): ?>
                            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-black bg-amber-500 text-white shadow-xs">
                                <i class="fas fa-moon text-[11px]"></i>
                                <span><?php echo e($test->fasting_label); ?></span>
                            </span>
                            <?php else: ?>
                            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-black bg-emerald-600 text-white shadow-xs">
                                <i class="fas fa-sun text-[11px]"></i>
                                <span>No Fasting Required (Random Sample)</span>
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Bullet Points Grid -->
                    <?php
                        $prepPoints = $test->preparation_points;
                    ?>
                    <div class="grid grid-cols-1 <?php echo e(count($prepPoints) > 1 ? 'sm:grid-cols-2' : ''); ?> gap-3 pt-1">
                        <?php $__currentLoopData = $prepPoints; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $point): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-start gap-3 p-3.5 rounded-2xl bg-white/95 border <?php echo e($test->requires_fasting ? 'border-amber-200/70' : 'border-teal-200/70'); ?> shadow-xs hover:shadow-sm transition">
                            <span class="w-6 h-6 rounded-full <?php echo e($test->requires_fasting ? 'bg-amber-100 text-amber-700' : 'bg-emerald-100 text-emerald-700'); ?> flex items-center justify-center text-[10px] font-bold flex-shrink-0 mt-0.5">
                                <i class="fas fa-check"></i>
                            </span>
                            <span class="text-xs sm:text-sm font-semibold text-gray-800 leading-relaxed"><?php echo e($point); ?></span>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <!-- Fasting Quick Advisory Bar -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 pt-2 text-[11px] font-semibold text-gray-600 border-t <?php echo e($test->requires_fasting ? 'border-amber-200/60' : 'border-teal-200/50'); ?>">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-droplet text-cyan-600 text-xs"></i>
                            <span>Drinking regular water is allowed</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-pills text-indigo-600 text-xs"></i>
                            <span>Continue daily meds unless doctor advises</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-clock text-amber-600 text-xs"></i>
                            <span>Early morning sample collection advised</span>
                        </div>
                    </div>
                </div>

                <!-- Sample Safety & Report Delivery Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-5 rounded-2xl bg-teal-50/70 border border-teal-200/70 flex items-start gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-teal-100 text-teal-800 flex items-center justify-center text-sm font-bold flex-shrink-0">
                            <i class="fas fa-temperature-low"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-teal-950 uppercase tracking-wider mb-1">Cold Chain Sample Safety</h4>
                            <p class="text-xs text-teal-900 leading-relaxed">
                                Collected using sterile vacuum evacuated tubes (BD Vacutainer) and transported under strict 2°C–8°C temperature-controlled cool bags.
                            </p>
                        </div>
                    </div>

                    <div class="p-5 rounded-2xl bg-indigo-50/70 border border-indigo-200/70 flex items-start gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-800 flex items-center justify-center text-sm font-bold flex-shrink-0">
                            <i class="fas fa-file-shield"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-indigo-950 uppercase tracking-wider mb-1">Fast & Verified Report Delivery</h4>
                            <p class="text-xs text-indigo-900 leading-relaxed">
                                Digitally signed smart report delivered directly via WhatsApp and PDF download within <?php echo e($test->display_tat); ?>.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="space-y-4 pt-4 border-t border-gray-100 text-sm text-gray-600 leading-relaxed">
                    <h3 class="font-bold text-gray-900 text-base">Why is <?php echo e($test->name); ?> prescribed?</h3>
                    <p>
                        This diagnostic investigation is commonly advised by general physicians, cardiologists, and endocrinologists to evaluate organ function, screen for latent metabolic dysfunctions, assess treatment response, or investigate non-specific symptoms such as fatigue, unexplained weight changes, or digestive distress.
                    </p>
                    <div class="bg-gray-50 rounded-2xl p-5 border border-gray-200">
                        <h4 class="font-bold text-gray-800 text-xs uppercase tracking-wider mb-2">Key Quality Safeguards</h4>
                        <ul class="space-y-2 text-xs text-gray-600">
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check text-emerald-600 text-[11px]"></i>
                                <span>Automated multi-point calibration on Beckman Coulter & Roche automated analyzers.</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check text-emerald-600 text-[11px]"></i>
                                <span>Double validation by certified senior biochemists and MD pathologists before report dispatch.</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check text-emerald-600 text-[11px]"></i>
                                <span>Free consultation assistance if critical biomarker alerts are detected.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Package Upsell Card (Tata 1mg style) -->
            <?php if($includingPackages->isNotEmpty()): ?>
            <div class="bg-gradient-to-br from-indigo-900 via-teal-900 to-slate-900 text-white rounded-3xl p-8 shadow-xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-80 h-80 bg-teal-400/10 rounded-full blur-2xl"></div>
                <div class="relative z-10">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-400/20 text-amber-300 text-xs font-bold uppercase tracking-wider border border-amber-400/30 mb-4">
                        <i class="fas fa-coins"></i> Smart Health Recommendation
                    </div>
                    <h2 class="text-xl sm:text-2xl font-black mb-2">
                        Get <?php echo e($test->name); ?> Included in a Complete Health Checkup
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-300 mb-6 max-w-2xl leading-relaxed">
                        Rather than checking a single parameter, opt for a comprehensive health package covering liver, kidney, sugar, vitamins, and cardiac risk for maximum preventative protection.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <?php $__currentLoopData = $includingPackages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pkg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/15 flex flex-col justify-between hover:bg-white/15 transition-all">
                            <div>
                                <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded bg-teal-400 text-teal-950 font-mono">
                                    <?php echo e($pkg->included_tests_count); ?> TESTS (<?php echo e($pkg->total_parameters_count); ?> PARAMS)
                                </span>
                                <h4 class="font-bold text-white text-sm mt-3 mb-1 line-clamp-1"><?php echo e($pkg->name); ?></h4>
                                <p class="text-xs text-slate-300 mb-3 line-clamp-2">Includes <?php echo e($test->name); ?> + comprehensive screening.</p>
                            </div>
                            <div class="pt-3 border-t border-white/10 flex items-center justify-between">
                                <div>
                                    <span class="text-lg font-black text-amber-300">₹<?php echo e(number_format($pkg->price)); ?></span>
                                </div>
                                <a href="<?php echo e(route('package.show', $pkg->id)); ?>" class="px-3 py-1.5 rounded-lg bg-white text-teal-950 font-bold text-xs hover:bg-teal-50 transition">
                                    View Package <i class="fas fa-arrow-right text-[10px] ml-1"></i>
                                </a>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- FAQs -->
            <div class="bg-white rounded-3xl p-8 border border-gray-200 shadow-sm space-y-4">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-circle-question text-teal-700"></i>
                    <span>Frequently Asked Questions</span>
                </h3>

                <div class="border border-gray-200 rounded-2xl p-4">
                    <h4 class="font-bold text-xs sm:text-sm text-gray-800 mb-1">How will the sample be collected?</h4>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        A certified and vaccinated phlebotomist will arrive at your home address in your chosen 30-minute time slot with fresh, single-use vacuum needles and tubes.
                    </p>
                </div>

                <div class="border border-gray-200 rounded-2xl p-4">
                    <h4 class="font-bold text-xs sm:text-sm text-gray-800 mb-1">When and how do I receive my test results?</h4>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Reports are released within <?php echo e($test->report_delivery_time ?? 'same day'); ?>. You will receive a notification on your registered mobile number along with an interactive link to view or download your password-protected PDF.
                    </p>
                </div>

                <div class="border border-gray-200 rounded-2xl p-4">
                    <h4 class="font-bold text-xs sm:text-sm text-gray-800 mb-1">Can I reschedule or cancel the booking?</h4>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Yes, you can easily reschedule or cancel anytime up to 2 hours before your scheduled appointment slot via your dashboard or customer helpline.
                    </p>
                </div>
            </div>
        </div>

        <!-- Right 4 Columns: Sticky Price & Booking Card -->
        <div class="lg:col-span-4">
            <div class="sticky top-24 space-y-6">
                <div class="bg-white rounded-3xl p-6 border border-gray-200 shadow-lg relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-teal-700 to-indigo-700"></div>

                    <!-- Price Block -->
                    <div class="mb-6">
                        <?php if($test->hasDiscount()): ?>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-sm text-gray-400 line-through">₹<?php echo e(number_format($test->effective_mrp)); ?></span>
                            <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 text-xs font-black">
                                <?php echo e($test->discount_percentage); ?>% OFF
                            </span>
                        </div>
                        <?php endif; ?>
                        <div class="flex items-baseline gap-2">
                            <span class="text-4xl font-black text-gray-900 tracking-tight">₹<?php echo e(number_format($test->price)); ?></span>
                            <span class="text-xs font-semibold text-gray-500">per patient</span>
                        </div>
                        <p class="text-[11px] text-emerald-700 font-semibold mt-1 flex items-center gap-1">
                            <i class="fas fa-badge-percent"></i> Inclusive of all diagnostic processing taxes
                        </p>
                    </div>

                    <!-- Key Inclusions Checklist -->
                    <div class="space-y-3 py-4 border-y border-gray-100 text-xs text-gray-700 mb-6">
                        <div class="flex items-center gap-2.5">
                            <i class="fas fa-check-circle text-teal-600 text-sm"></i>
                            <span>Certified quality standard diagnostic testing</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i class="fas fa-check-circle text-teal-600 text-sm"></i>
                            <span>Free home sample collection available</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i class="fas fa-check-circle text-teal-600 text-sm"></i>
                            <span>Verified digital report in <?php echo e($test->report_delivery_time ?? 'Same Day'); ?></span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i class="fas fa-check-circle text-teal-600 text-sm"></i>
                            <span>Doctor consultation assistance on abnormal values</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        <button onclick="addToCart(this)" 
                            data-id="<?php echo e($test->id); ?>"
                            data-type="test"
                            data-name="<?php echo e($test->name); ?>"
                            data-price="<?php echo e($test->price); ?>" 
                            data-mrp="<?php echo e($test->effective_mrp ?? $test->price); ?>" 
                            data-params="<?php echo e($test->preparation_instructions ?? 'Single Diagnostic Test'); ?>"
                            class="w-full bg-gradient-to-r from-teal-700 to-teal-800 hover:from-teal-800 hover:to-teal-900 text-white font-bold py-3.5 px-6 rounded-2xl shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2 text-sm group cursor-pointer">
                            <i class="fas fa-cart-plus group-hover:scale-110 transition-transform"></i>
                            <span>Book Now & Add to Cart</span>
                        </button>

                        <?php
                            $waPhone = \App\Models\Setting::get('whatsapp_number', '8988988787');
                            $waClean = preg_replace('/[^0-9]/', '', $waPhone);
                            if (strlen($waClean) === 10) {
                                $waClean = '91' . $waClean;
                            }
                            $waMessage = urlencode("Hello, I want to book the {$test->name} test (₹{$test->price}). Please share available slots.");
                        ?>
                        <a href="https://wa.me/<?php echo e($waClean); ?>?text=<?php echo e($waMessage); ?>" target="_blank"
                            class="w-full bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-300 font-bold py-3 px-6 rounded-2xl transition flex items-center justify-center gap-2 text-xs">
                            <i class="fab fa-whatsapp text-emerald-600 text-base"></i>
                            <span>Book via WhatsApp</span>
                        </a>
                    </div>

                    <!-- Trust Strip -->
                    <div class="mt-6 pt-4 border-t border-gray-100 grid grid-cols-3 gap-2 text-center text-[10px] text-gray-500 font-semibold">
                        <div>
                            <i class="fas fa-shield-halved text-teal-700 text-base mb-1 block"></i>
                            <span>100% Sterile</span>
                        </div>
                        <div>
                            <i class="fas fa-qrcode text-indigo-700 text-base mb-1 block"></i>
                            <span>Barcoded Tubes</span>
                        </div>
                        <div>
                            <i class="fas fa-award text-amber-600 text-base mb-1 block"></i>
                            <span>MD Pathologist Verified</span>
                        </div>
                    </div>
                </div>

                <!-- Prescription Upload Quick Help -->
                <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-3xl p-6 border border-amber-200 text-amber-950">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 rounded-full bg-amber-200/60 flex items-center justify-center text-amber-800 text-xs font-bold">
                            <i class="fas fa-file-prescription"></i>
                        </div>
                        <h4 class="font-bold text-xs uppercase tracking-wider">Have a Doctor's Prescription?</h4>
                    </div>
                    <p class="text-xs text-amber-900 leading-relaxed mb-4">
                        Upload your doctor's slip. Our medical team will select this test and any other prescribed tests for you.
                    </p>
                    <button type="button" onclick="window.openPrescriptionModal()" class="w-full py-2.5 px-4 bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold rounded-xl transition shadow-sm">
                        Upload Prescription Slip
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Other Popular Single Tests Section -->
    <?php if($otherTests->isNotEmpty()): ?>
    <div class="mt-12 pt-12 border-t border-gray-200">
        <div class="flex justify-between items-end mb-6">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Other Frequently Booked Tests</h3>
                <p class="text-xs text-gray-500 mt-0.5">Complementary blood and urine diagnostics</p>
            </div>
            <a href="<?php echo e(route('home')); ?>#single-health-checkup" class="text-xs font-bold text-teal-700 hover:underline">
                View All Single Tests <i class="fas fa-arrow-right text-[10px] ml-1"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            <?php $__currentLoopData = $otherTests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $otMrp = round($ot->price * 1.35);
            ?>
            <div class="bg-white rounded-2xl p-5 border border-gray-200 hover:shadow-lg transition-all flex flex-col justify-between">
                <div>
                    <span class="text-[9px] font-bold uppercase text-teal-700 bg-teal-50 px-2 py-0.5 rounded border border-teal-100">
                        <?php echo e($ot->report_delivery_time ?? 'Same Day'); ?>

                    </span>
                    <h4 class="font-bold text-gray-900 text-sm mt-2 mb-2 line-clamp-2">
                        <a href="<?php echo e(route('test.show', $ot->id)); ?>" class="hover:text-teal-700 transition">
                            <?php echo e($ot->name); ?>

                        </a>
                    </h4>
                    <p class="text-[11px] text-gray-500 line-clamp-2 mb-4">
                        <?php echo e($ot->preparation_instructions ?? 'Standard Blood Sample • Verified Lab'); ?>

                    </p>
                </div>
                <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                    <div>
                        <span class="text-xs text-gray-400 line-through">₹<?php echo e($otMrp); ?></span>
                        <span class="text-base font-black text-gray-900 ml-1">₹<?php echo e(number_format($ot->price)); ?></span>
                    </div>
                    <a href="<?php echo e(route('test.show', $ot->id)); ?>" class="p-2 rounded-xl bg-teal-50 hover:bg-teal-100 text-teal-800 text-xs font-bold transition">
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
    function verifyPincodeSlot() {
        const input = document.getElementById('checkPincodeInput');
        const res = document.getElementById('pincodeResult');
        const val = input.value.trim();

        if (!val || val.length !== 6 || isNaN(val)) {
            res.className = 'text-xs font-semibold px-4 py-2 rounded-xl bg-red-50 text-red-700 border border-red-200 block';
            res.innerHTML = '<i class="fas fa-circle-exclamation mr-1"></i> Please enter a valid 6-digit postal pincode.';
            return;
        }

        res.className = 'text-xs font-semibold px-4 py-2 rounded-xl bg-emerald-50 text-emerald-800 border border-emerald-200 block';
        res.innerHTML = '<i class="fas fa-circle-check text-emerald-600 mr-1.5"></i> <strong>Pincode ' + val + ' is fully serviceable!</strong> Free home sample collection slots available tomorrow 06:30 AM – 10:30 AM.';
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\lab\lab\resources\views/frontend/pages/test-details.blade.php ENDPATH**/ ?>