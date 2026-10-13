<?php $__env->startSection('title', isset($test) ? 'Edit Test' : 'Add Test'); ?>
<?php $__env->startSection('header'); ?>
<div class="flex items-center">
    <a href="<?php echo e(route('admin.tests.index')); ?>" class="text-teal-600 hover:text-teal-700 dark:text-teal-400 mr-4">
        <i class="fas fa-arrow-left"></i>
    </a>
    <span class="text-slate-900 dark:text-white font-black"><?php echo e(isset($test) ? 'Edit Test' : 'Add New Test'); ?></span>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white dark:bg-[#071a18] rounded-2xl shadow-sm border border-slate-200/80 dark:border-teal-900/40 overflow-hidden max-w-4xl mx-auto transition-colors">
    <form action="<?php echo e(isset($test) ? route('admin.tests.update', $test->id) : route('admin.tests.store')); ?>" method="POST" enctype="multipart/form-data" class="p-6 md:p-8 space-y-6">
        <?php echo csrf_field(); ?>
        <?php if(isset($test)): ?>
            <?php echo method_field('PUT'); ?>
        <?php endif; ?>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name -->
            <div class="md:col-span-2">
                <label class="block text-sm font-bold text-slate-800 dark:text-slate-200 mb-2">Test Name <span class="text-rose-500">*</span></label>
                <input type="text" name="name" value="<?php echo e(old('name', $test->name ?? '')); ?>" required placeholder="e.g. Complete Blood Count (CBC)" class="w-full rounded-xl border border-slate-300 dark:border-teal-900/50 focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 shadow-xs px-4 py-2.5 bg-white dark:bg-[#041412] text-slate-900 dark:text-white font-semibold text-sm transition">
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-rose-500 text-xs mt-1 font-bold"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            
            <!-- Primary Category & Multi-Category Tagging -->
            <div class="md:col-span-2 bg-slate-50 dark:bg-[#0b2220]/60 rounded-2xl p-4 sm:p-5 border border-slate-200 dark:border-teal-900/40 space-y-4">
                <div>
                    <label class="block text-sm font-bold text-slate-800 dark:text-slate-200 mb-1">Primary Department / Category</label>
                    <select name="test_category_id" class="w-full rounded-xl border border-slate-300 dark:border-teal-900/50 focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 shadow-xs px-4 py-2.5 bg-white dark:bg-[#041412] text-slate-900 dark:text-white font-medium text-sm transition">
                        <option value="">Select Primary Department...</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category->id); ?>" <?php echo e(old('test_category_id', $test->test_category_id ?? '') == $category->id ? 'selected' : ''); ?>><?php echo e($category->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-1 flex items-center gap-1.5">
                        <i class="fas fa-tags text-teal-600 dark:text-teal-400"></i> Additional Categories (Show this test under multiple categories)
                    </label>
                    <?php
                        $selectedCats = old('category_ids', $test->category_ids ?? []);
                    ?>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5 max-h-40 overflow-y-auto mt-2 p-1">
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="flex items-center space-x-2.5 bg-white dark:bg-[#071a18] p-2.5 rounded-xl border border-slate-200 dark:border-teal-900/40 cursor-pointer hover:border-teal-500 dark:hover:border-teal-400/50 transition">
                                <input type="checkbox" name="category_ids[]" value="<?php echo e($category->id); ?>" <?php echo e(in_array($category->id, $selectedCats) ? 'checked' : ''); ?> class="rounded border-slate-300 dark:border-teal-900/60 text-teal-600 focus:ring-teal-500">
                                <span class="text-xs text-slate-700 dark:text-slate-300 truncate font-semibold" title="<?php echo e($category->name); ?>"><?php echo e($category->name); ?></span>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
            
            <!-- Commercial Pricing & Offers Box (High Contrast for Light & Dark Mode) -->
            <div class="md:col-span-2 p-5 sm:p-6 rounded-2xl bg-gradient-to-br from-teal-50/80 via-emerald-50/40 to-teal-50/60 dark:from-[#0a2623] dark:to-[#081e1c] border border-teal-200 dark:border-teal-500/35 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-teal-200/60 dark:border-teal-500/20 pb-3">
                    <h3 class="text-xs font-black uppercase tracking-wider text-teal-950 dark:text-teal-300 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-teal-500/10 dark:bg-teal-400/10 text-teal-600 dark:text-teal-400 flex items-center justify-center text-xs">
                            <i class="fas fa-tag"></i>
                        </span>
                        <span>Website Commercial & Offer Pricing</span>
                    </h3>
                    <?php if(config('pathology.enabled', false) && isset($test) && $test->lis_price): ?>
                        <span class="text-[11px] font-bold text-slate-700 dark:text-slate-300 bg-white dark:bg-[#041412] px-2.5 py-1 rounded-lg border border-slate-200 dark:border-teal-900/50">
                            LIS Base Cost: <strong class="text-slate-900 dark:text-white">₹<?php echo e(number_format($test->lis_price, 2)); ?></strong>
                        </span>
                    <?php endif; ?>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Market MRP -->
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 dark:text-slate-200 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                            <span>Market MRP (Strike-through ~₹~)</span>
                            <span class="text-[10px] text-slate-400 font-normal lowercase">Frontend crossed price</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500 font-bold text-sm">₹</span>
                            <input type="number" step="0.01" name="original_price" id="original_price_input" value="<?php echo e(old('original_price', $test->original_price ?? '')); ?>" placeholder="e.g. 600" class="w-full rounded-xl pl-8 pr-4 py-2.5 border border-slate-300 dark:border-teal-500/30 focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 shadow-xs bg-white dark:bg-[#041412] text-slate-900 dark:text-white font-bold placeholder:text-slate-400 dark:placeholder:text-slate-500 text-sm transition">
                        </div>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1.5 font-medium">Shows as strike-through on frontend card (e.g. <span class="line-through font-semibold text-slate-600 dark:text-slate-300">₹600</span>).</p>
                    </div>

                    <!-- Selling Price -->
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 dark:text-slate-200 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                            <span class="flex items-center gap-1">Website Selling Price (₹) <span class="text-rose-500 font-black">*</span></span>
                            <span id="discountBadgePreview" class="hidden text-[10px] font-black px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-700"></span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-teal-600 dark:text-teal-400 font-black text-sm">₹</span>
                            <input type="number" step="0.01" name="price" id="selling_price_input" value="<?php echo e(old('price', $test->price ?? '')); ?>" required placeholder="e.g. 399" class="w-full rounded-xl pl-8 pr-4 py-2.5 border border-teal-300 dark:border-teal-500/50 focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 shadow-xs bg-white dark:bg-[#041412] font-black text-teal-700 dark:text-teal-300 text-base placeholder:text-slate-400 dark:placeholder:text-slate-500 transition">
                        </div>
                        <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-rose-500 text-xs mt-1.5 font-bold"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <?php if(config('pathology.enabled', false)): ?>
                <!-- Price Lock Protection Toggle -->
                <div class="pt-2 flex items-center justify-between border-t border-teal-200/40 dark:border-teal-500/20">
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="lock_pricing" value="1" <?php echo e(old('lock_pricing', $test->lock_pricing ?? false) ? 'checked' : ''); ?> class="rounded border-slate-300 dark:border-teal-900/60 text-teal-600 focus:ring-teal-500">
                        <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Lock Custom Price (Protect from LIS auto-sync overwrites)</span>
                    </label>
                </div>
                <?php endif; ?>
            </div>

            <!-- Technical Specifications Box -->
            <div class="md:col-span-2 p-5 sm:p-6 rounded-2xl bg-slate-50 dark:bg-[#0b2220]/60 border border-slate-200 dark:border-teal-900/40 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-200 dark:border-teal-900/40 pb-3">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-slate-200 flex items-center gap-2">
                        <i class="fas fa-microscope text-teal-600 dark:text-teal-400"></i> Technical Specifications<?php echo e(config('pathology.enabled', false) ? ' & LIS Integration' : ''); ?>

                    </h3>
                    <?php if(config('pathology.enabled', false) && isset($test) && $test->lis_synced_at): ?>
                        <span class="text-[10px] text-slate-400">Synced: <?php echo e($test->lis_synced_at->format('d M Y, h:i A')); ?></span>
                    <?php endif; ?>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <!-- Test Code -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Test Code</label>
                        <input type="text" name="test_code" placeholder="e.g. CBC, FBS" value="<?php echo e(old('test_code', $test->test_code ?? '')); ?>" class="w-full rounded-xl border border-slate-300 dark:border-teal-900/50 focus:border-teal-500 focus:ring-teal-500 shadow-xs px-4 py-2 bg-white dark:bg-[#041412] text-slate-900 dark:text-white font-mono uppercase text-sm">
                    </div>

                    <!-- Sample Type -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Sample Type</label>
                        <input type="text" name="sample_type" placeholder="e.g. EDTA Whole Blood, Serum" value="<?php echo e(old('sample_type', $test->sample_type ?? '')); ?>" class="w-full rounded-xl border border-slate-300 dark:border-teal-900/50 focus:border-teal-500 focus:ring-teal-500 shadow-xs px-4 py-2 bg-white dark:bg-[#041412] text-slate-900 dark:text-white text-sm font-medium">
                    </div>

                    <!-- Turnaround Time Hours -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">TAT (Hours)</label>
                        <input type="number" name="tat_hours" placeholder="e.g. 6, 24" value="<?php echo e(old('tat_hours', $test->tat_hours ?? '')); ?>" min="1" class="w-full rounded-xl border border-slate-300 dark:border-teal-900/50 focus:border-teal-500 focus:ring-teal-500 shadow-xs px-4 py-2 bg-white dark:bg-[#041412] text-slate-900 dark:text-white text-sm font-medium">
                    </div>
                    <!-- Display Delivery Time -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Display Delivery Time</label>
                        <input type="text" name="report_delivery_time" placeholder="e.g. Within 24 Hours, Same Day" value="<?php echo e(old('report_delivery_time', $test->report_delivery_time ?? '')); ?>" class="w-full rounded-xl border border-slate-300 dark:border-teal-900/50 focus:border-teal-500 focus:ring-teal-500 shadow-xs px-4 py-2 bg-white dark:bg-[#041412] text-slate-900 dark:text-white text-sm font-medium">
                    </div>
                </div>
            </div>

            <!-- Patient Fasting & Preparation Protocol (High-Contrast, Bullet-Point Builder & Live Preview) -->
            <div class="md:col-span-2 p-5 sm:p-6 rounded-2xl bg-gradient-to-br from-amber-50/70 via-orange-50/30 to-amber-50/60 dark:from-[#171408] dark:to-[#100d04] border border-amber-300/80 dark:border-amber-500/40 shadow-sm space-y-5">
                
                <!-- Section Header -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-amber-200/80 dark:border-amber-500/25 pb-3.5">
                    <div>
                        <h3 class="text-xs font-black uppercase tracking-wider text-amber-950 dark:text-amber-300 flex items-center gap-2">
                            <span class="w-6 h-6 rounded-lg bg-amber-500/20 text-amber-700 dark:text-amber-400 flex items-center justify-center text-xs">
                                <i class="fas fa-utensils"></i>
                            </span>
                            <span>Patient Fasting & Preparation Protocol</span>
                        </h3>
                        <p class="text-[11px] text-amber-900/80 dark:text-amber-400/80 mt-0.5">
                            Configure overnight fasting requirement and patient guidelines. Each line will display as a clear bullet point on the website.
                        </p>
                    </div>
                    
                    <!-- Fasting Status Pill -->
                    <div id="fastingStatusBadge" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold transition shadow-xs">
                        <i class="fas fa-moon text-[11px]"></i>
                        <span id="fastingStatusText">Overnight Fasting Required</span>
                    </div>
                </div>

                <!-- Fasting Requirement Mode Selector -->
                <div>
                    <label class="block text-xs font-extrabold text-slate-800 dark:text-slate-200 uppercase tracking-wider mb-2">
                        Fasting Requirement Mode
                    </label>
                    
                    <!-- Hidden Checkbox for Controller Compatibility -->
                    <input type="checkbox" name="fasting_required" id="fasting_required_checkbox" value="1" <?php echo e(old('fasting_required', $test->fasting_required ?? false) ? 'checked' : ''); ?> class="sr-only">

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3" id="fastingModeSelector">
                        <!-- Option 1: Overnight Fasting 8-10 Hours -->
                        <button type="button" class="fasting-mode-btn p-3.5 rounded-xl border text-left transition flex items-start gap-3 cursor-pointer" data-mode="overnight_8_10" data-required="true">
                            <span class="mode-radio-dot w-4 h-4 rounded-full border-2 mt-0.5 flex items-center justify-center flex-shrink-0 transition">
                                <span class="dot-inner w-2 h-2 rounded-full bg-amber-500 hidden"></span>
                            </span>
                            <div>
                                <div class="text-xs font-bold text-slate-800 dark:text-slate-200 flex items-center gap-1.5">
                                    <i class="fas fa-moon text-amber-500"></i>
                                    <span>Overnight Fasting (8 - 10 Hrs)</span>
                                </div>
                                <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-0.5">Standard fasting for Lipid Profile, Fasting Glucose, etc.</p>
                            </div>
                        </button>

                        <!-- Option 2: Strict Fasting 10-12 Hours -->
                        <button type="button" class="fasting-mode-btn p-3.5 rounded-xl border text-left transition flex items-start gap-3 cursor-pointer" data-mode="strict_10_12" data-required="true">
                            <span class="mode-radio-dot w-4 h-4 rounded-full border-2 mt-0.5 flex items-center justify-center flex-shrink-0 transition">
                                <span class="dot-inner w-2 h-2 rounded-full bg-amber-500 hidden"></span>
                            </span>
                            <div>
                                <div class="text-xs font-bold text-slate-800 dark:text-slate-200 flex items-center gap-1.5">
                                    <i class="fas fa-hourglass-half text-orange-500"></i>
                                    <span>Strict Fasting (10 - 12 Hrs)</span>
                                </div>
                                <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-0.5">Specialized metabolic tests, Iron studies, etc.</p>
                            </div>
                        </button>

                        <!-- Option 3: No Fasting Required -->
                        <button type="button" class="fasting-mode-btn p-3.5 rounded-xl border text-left transition flex items-start gap-3 cursor-pointer" data-mode="no_fasting" data-required="false">
                            <span class="mode-radio-dot w-4 h-4 rounded-full border-2 mt-0.5 flex items-center justify-center flex-shrink-0 transition">
                                <span class="dot-inner w-2 h-2 rounded-full bg-emerald-500 hidden"></span>
                            </span>
                            <div>
                                <div class="text-xs font-bold text-slate-800 dark:text-slate-200 flex items-center gap-1.5">
                                    <i class="fas fa-sun text-emerald-500"></i>
                                    <span>No Fasting Required</span>
                                </div>
                                <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-0.5">Random sample anytime (CBC, HbA1c, Thyroid, etc.)</p>
                            </div>
                        </button>
                    </div>
                </div>

                <!-- Quick-Insert Standard Bullet Points (Chips) -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="text-xs font-extrabold text-slate-800 dark:text-slate-200 uppercase tracking-wider flex items-center gap-1.5">
                            <i class="fas fa-wand-magic-sparkles text-amber-500"></i>
                            <span>Quick-Insert Standard Bullet Points (Click to Add)</span>
                        </label>
                        <span class="text-[10px] text-slate-500 dark:text-slate-400 font-medium">Click any chip to add bullet point</span>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <button type="button" class="insert-bullet-chip px-3 py-1.5 rounded-xl text-xs font-bold bg-white dark:bg-[#071a18] border border-amber-300 dark:border-amber-700/60 hover:border-amber-500 dark:hover:border-amber-400 text-slate-800 dark:text-slate-200 transition flex items-center gap-1.5 cursor-pointer shadow-2xs hover:scale-102" data-text="Only plain drinking water is permitted during the fasting period.">
                            <span>💧 Water Permitted</span>
                            <i class="fas fa-plus text-[10px] text-amber-600 dark:text-amber-400"></i>
                        </button>
                        <button type="button" class="insert-bullet-chip px-3 py-1.5 rounded-xl text-xs font-bold bg-white dark:bg-[#071a18] border border-amber-300 dark:border-amber-700/60 hover:border-amber-500 dark:hover:border-amber-400 text-slate-800 dark:text-slate-200 transition flex items-center gap-1.5 cursor-pointer shadow-2xs hover:scale-102" data-text="Avoid tea, coffee, milk, juices, or breakfast before sample collection.">
                            <span>☕ No Tea / Coffee / Milk</span>
                            <i class="fas fa-plus text-[10px] text-amber-600 dark:text-amber-400"></i>
                        </button>
                        <button type="button" class="insert-bullet-chip px-3 py-1.5 rounded-xl text-xs font-bold bg-white dark:bg-[#071a18] border border-amber-300 dark:border-amber-700/60 hover:border-amber-500 dark:hover:border-amber-400 text-slate-800 dark:text-slate-200 transition flex items-center gap-1.5 cursor-pointer shadow-2xs hover:scale-102" data-text="Strictly avoid smoking, chewing tobacco, and alcohol for 12 hours prior to the test.">
                            <span>🚭 No Smoking / Alcohol</span>
                            <i class="fas fa-plus text-[10px] text-amber-600 dark:text-amber-400"></i>
                        </button>
                        <button type="button" class="insert-bullet-chip px-3 py-1.5 rounded-xl text-xs font-bold bg-white dark:bg-[#071a18] border border-amber-300 dark:border-amber-700/60 hover:border-amber-500 dark:hover:border-amber-400 text-slate-800 dark:text-slate-200 transition flex items-center gap-1.5 cursor-pointer shadow-2xs hover:scale-102" data-text="Take regular daily prescription medicines unless specifically advised otherwise by your doctor.">
                            <span>💊 Morning Medicines Allowed</span>
                            <i class="fas fa-plus text-[10px] text-amber-600 dark:text-amber-400"></i>
                        </button>
                        <button type="button" class="insert-bullet-chip px-3 py-1.5 rounded-xl text-xs font-bold bg-white dark:bg-[#071a18] border border-amber-300 dark:border-amber-700/60 hover:border-amber-500 dark:hover:border-amber-400 text-slate-800 dark:text-slate-200 transition flex items-center gap-1.5 cursor-pointer shadow-2xs hover:scale-102" data-text="Blood sample should preferably be given in the early morning between 7:00 AM - 10:00 AM.">
                            <span>⏰ Morning Draw (7am - 10am)</span>
                            <i class="fas fa-plus text-[10px] text-amber-600 dark:text-amber-400"></i>
                        </button>
                        <button type="button" class="insert-bullet-chip px-3 py-1.5 rounded-xl text-xs font-bold bg-white dark:bg-[#071a18] border border-amber-300 dark:border-amber-700/60 hover:border-amber-500 dark:hover:border-amber-400 text-slate-800 dark:text-slate-200 transition flex items-center gap-1.5 cursor-pointer shadow-2xs hover:scale-102" data-text="Consume a light, non-greasy dinner on the night prior to sample collection.">
                            <span>🍽️ Light Dinner Night Prior</span>
                            <i class="fas fa-plus text-[10px] text-amber-600 dark:text-amber-400"></i>
                        </button>
                        <button type="button" class="insert-bullet-chip px-3 py-1.5 rounded-xl text-xs font-bold bg-white dark:bg-[#071a18] border border-amber-300 dark:border-amber-700/60 hover:border-amber-500 dark:hover:border-amber-400 text-slate-800 dark:text-slate-200 transition flex items-center gap-1.5 cursor-pointer shadow-2xs hover:scale-102" data-text="Rest seated for 10-15 minutes before the phlebotomist draws blood.">
                            <span>🧘 Rest 10-15 Mins Before</span>
                            <i class="fas fa-plus text-[10px] text-amber-600 dark:text-amber-400"></i>
                        </button>
                    </div>
                </div>

                <!-- Bullet Points Instructions Editor -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-xs font-extrabold text-slate-800 dark:text-slate-200 uppercase tracking-wider">
                            Patient Instructions (1 Bullet Point Per Line)
                        </label>
                        <div class="flex items-center gap-3">
                            <button type="button" id="formatBulletsBtn" class="text-xs font-bold text-amber-700 dark:text-amber-400 hover:underline cursor-pointer flex items-center gap-1">
                                <i class="fas fa-list-check text-[11px]"></i> Format As Bullets
                            </button>
                            <span class="text-slate-300 dark:text-slate-600">•</span>
                            <button type="button" id="clearInstructionsBtn" class="text-xs font-bold text-slate-400 hover:text-rose-500 transition cursor-pointer">
                                Clear
                            </button>
                        </div>
                    </div>

                    <textarea name="preparation_instructions" id="preparation_instructions_input" rows="4" 
                        placeholder="• Overnight fasting of 8 to 10 hours is required prior to sample collection.&#10;• Only plain drinking water is permitted during the fasting period.&#10;• Avoid tea, coffee, milk, juices, or breakfast before sample collection.&#10;• Morning sample collection between 7:00 AM - 10:00 AM recommended."
                        class="w-full rounded-xl border border-amber-300 dark:border-amber-700/60 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 shadow-xs px-4 py-3 bg-white dark:bg-[#041412] text-slate-900 dark:text-white font-medium text-sm leading-relaxed transition"><?php echo e(old('preparation_instructions', $test->preparation_instructions ?? '')); ?></textarea>
                    
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">
                        💡 <strong>Automatic Bullet Rendering:</strong> Har line live website par stylish bullet point ban kar display hogi. Aap direct new line me likhein ya <code>•</code> use karein.
                    </p>
                </div>

                <!-- Live Website Preview Box ("Clear View") -->
                <div class="rounded-xl p-4 sm:p-5 bg-white dark:bg-[#061917] border border-amber-200/90 dark:border-teal-900/50 shadow-xs space-y-3">
                    <div class="flex items-center justify-between border-b border-slate-200/70 dark:border-teal-900/40 pb-2.5">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span class="text-xs font-black uppercase tracking-wider text-slate-800 dark:text-slate-200 flex items-center gap-1.5">
                                <i class="fas fa-eye text-teal-600 dark:text-teal-400"></i>
                                <span>Website Live Preview (Patients Will See This View)</span>
                            </span>
                        </div>
                        <span id="previewPointsCount" class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">0 Points</span>
                    </div>

                    <div id="previewContainer" class="space-y-2">
                        <!-- Populated live via JS -->
                    </div>
                </div>
            </div>

            <!-- Test Parameters Box -->
            <div class="md:col-span-2 p-5 sm:p-6 rounded-2xl bg-teal-50/40 dark:bg-[#081e1c]/70 border border-teal-200/60 dark:border-teal-900/40 shadow-sm space-y-3">
                <div class="flex items-center justify-between border-b border-teal-200/50 dark:border-teal-900/40 pb-3">
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-teal-900 dark:text-teal-300 flex items-center gap-2">
                            <i class="fas fa-list-ul text-teal-600 dark:text-teal-400"></i> Test Parameters / Sub-Tests Included
                        </h3>
                        <p class="text-[11px] text-teal-700 dark:text-teal-400 mt-0.5">
                            Add each parameter that this test measures (e.g. CBC → Hemoglobin, RBC Count, WBC Count, Platelet Count).
                        </p>
                    </div>
                    <button type="button" id="addParamBtn"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-teal-600 hover:bg-teal-700 text-white text-xs font-semibold rounded-lg transition shadow-xs cursor-pointer">
                        <i class="fas fa-plus text-[10px]"></i> Add Parameter
                    </button>
                </div>

                <div id="parametersContainer" class="space-y-2">
                    <?php
                        $existingParams = old('parameters', $test->parameters ?? []);
                        if (empty($existingParams)) { $existingParams = ['']; }
                    ?>
                    <?php $__currentLoopData = $existingParams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $param): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="param-row flex items-center gap-2">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-teal-500">
                                <i class="fas fa-vial text-xs"></i>
                            </div>
                            <input type="text" name="parameters[]" value="<?php echo e($param); ?>"
                                class="w-full pl-9 pr-4 py-2 rounded-xl bg-white dark:bg-[#041412] border border-teal-200 dark:border-teal-900/50 focus:border-teal-500 focus:ring-teal-500 text-sm text-slate-900 dark:text-white shadow-xs transition"
                                placeholder="e.g. Hemoglobin, RBC Count, Total Cholesterol">
                        </div>
                        <button type="button"
                            class="remove-param p-2 text-slate-400 hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/30 rounded-lg transition cursor-pointer <?php echo e(count($existingParams) <= 1 ? 'opacity-0 pointer-events-none' : ''); ?>"
                            title="Remove">
                            <i class="fas fa-times text-xs"></i>
                        </button>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <p class="text-[11px] text-teal-700 dark:text-teal-400">
                    <i class="fas fa-info-circle"></i>
                    Leave empty if this test has no sub-parameters (e.g. a single-marker test like Blood Sugar).
                </p>
            </div>
            
            <!-- Toggles -->
            <div class="md:col-span-2 bg-slate-50 dark:bg-[#0b2220]/60 rounded-2xl p-4 sm:p-5 border border-slate-200 dark:border-teal-900/40 grid grid-cols-1 sm:grid-cols-3 gap-4">
                <label class="relative inline-flex items-center cursor-pointer select-none">
                    <input type="checkbox" name="is_active" value="1" class="sr-only peer" <?php echo e(old('is_active', isset($test) ? $test->is_active : true) ? 'checked' : ''); ?>>
                    <div class="relative w-11 h-6 bg-slate-300 dark:bg-slate-700 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-teal-500/20 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-teal-600"></div>
                    <span class="ms-3 text-sm font-bold text-slate-700 dark:text-slate-200">Active (Visible)</span>
                </label>
                
                <label class="relative inline-flex items-center cursor-pointer select-none">
                    <input type="checkbox" name="is_featured" value="1" class="sr-only peer" <?php echo e(old('is_featured', $test->is_featured ?? false) ? 'checked' : ''); ?>>
                    <div class="relative w-11 h-6 bg-slate-300 dark:bg-slate-700 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-amber-500/20 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500"></div>
                    <span class="ms-3 text-sm font-bold text-slate-700 dark:text-slate-200">Featured Test</span>
                </label>
                
                <label class="relative inline-flex items-center cursor-pointer select-none">
                    <input type="checkbox" name="home_collection_available" value="1" class="sr-only peer" <?php echo e(old('home_collection_available', $test->home_collection_available ?? false) ? 'checked' : ''); ?>>
                    <div class="relative w-11 h-6 bg-slate-300 dark:bg-slate-700 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-teal-500/20 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-teal-600"></div>
                    <span class="ms-3 text-sm font-bold text-slate-700 dark:text-slate-200">Home Collection</span>
                </label>
            </div>
        </div>
        
        <div class="pt-4 border-t border-slate-200 dark:border-teal-900/40 flex justify-end gap-3">
            <a href="<?php echo e(route('admin.tests.index')); ?>" class="px-6 py-2.5 border border-slate-300 dark:border-teal-900/50 rounded-xl text-sm font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-teal-950/40 transition">Cancel</a>
            <button type="submit" class="px-6 py-2.5 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-sm font-black transition shadow-md hover:shadow-lg cursor-pointer">
                <?php echo e(isset($test) ? 'Update Test' : 'Save Test'); ?>

            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Parameters dynamic add/remove
    const container = document.getElementById('parametersContainer');
    const addBtn = document.getElementById('addParamBtn');

    function refreshRemoveButtons() {
        if (!container) return;
        const rows = container.querySelectorAll('.param-row');
        rows.forEach(function (row) {
            const btn = row.querySelector('.remove-param');
            if (!btn) return;
            if (rows.length > 1) {
                btn.classList.remove('opacity-0', 'pointer-events-none');
            } else {
                btn.classList.add('opacity-0', 'pointer-events-none');
            }
        });
    }

    if (addBtn && container) {
        addBtn.addEventListener('click', function () {
            const template = container.querySelector('.param-row');
            if (!template) return;
            const clone = template.cloneNode(true);
            clone.querySelector('input').value = '';
            container.appendChild(clone);
            refreshRemoveButtons();
            clone.querySelector('input').focus();
        });

        container.addEventListener('click', function (e) {
            const btn = e.target.closest('.remove-param');
            if (btn && container.querySelectorAll('.param-row').length > 1) {
                btn.closest('.param-row').remove();
                refreshRemoveButtons();
            }
        });
    }

    // Live Discount Badge calculation
    const mrpInput = document.getElementById('original_price_input');
    const sellingInput = document.getElementById('selling_price_input');
    const discountBadge = document.getElementById('discountBadgePreview');

    function updateDiscountBadge() {
        if (!mrpInput || !sellingInput || !discountBadge) return;
        const mrp = parseFloat(mrpInput.value) || 0;
        const selling = parseFloat(sellingInput.value) || 0;

        if (mrp > 0 && selling > 0 && mrp > selling) {
            const pct = Math.round(((mrp - selling) / mrp) * 100);
            discountBadge.textContent = `${pct}% OFF`;
            discountBadge.classList.remove('hidden');
        } else {
            discountBadge.classList.add('hidden');
        }
    }

    if (mrpInput && sellingInput) {
        mrpInput.addEventListener('input', updateDiscountBadge);
        sellingInput.addEventListener('input', updateDiscountBadge);
        updateDiscountBadge();
    }

    // ── Fasting Protocol & Bullet Points Preview ──
    const fastingCheckbox = document.getElementById('fasting_required_checkbox');
    const modeButtons = document.querySelectorAll('.fasting-mode-btn');
    const instructionsInput = document.getElementById('preparation_instructions_input');
    const previewContainer = document.getElementById('previewContainer');
    const previewCount = document.getElementById('previewPointsCount');
    const statusBadge = document.getElementById('fastingStatusBadge');
    const statusText = document.getElementById('fastingStatusText');
    const formatBulletsBtn = document.getElementById('formatBulletsBtn');
    const clearInstructionsBtn = document.getElementById('clearInstructionsBtn');
    const bulletChips = document.querySelectorAll('.insert-bullet-chip');

    let currentMode = 'no_fasting';

    function parseBulletPoints(text) {
        if (!text || !text.trim()) return [];
        const lines = text.split(/\r?\n/);
        const points = [];
        lines.forEach(line => {
            const trimmed = line.trim();
            if (!trimmed) return;
            const cleaned = trimmed.replace(/^([•\-\*■►✔✓]|\d+[\.\)])\s*/u, '').trim();
            if (cleaned) points.push(cleaned);
        });
        return points;
    }

    function escapeHtml(str) {
        const div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    function updateLivePreview() {
        if (!previewContainer) return;
        const text = instructionsInput ? instructionsInput.value.trim() : '';
        let points = parseBulletPoints(text);

        // Fallback default points if empty
        let isDefaultFallback = false;
        if (points.length === 0) {
            isDefaultFallback = true;
            if (currentMode === 'overnight_8_10') {
                points = [
                    'Overnight fasting of 8 to 10 hours is required prior to sample collection.',
                    'Only plain drinking water is permitted during fasting.',
                    'Strictly avoid morning tea, coffee, milk, or breakfast.',
                    'Morning sample collection between 7:00 AM - 10:00 AM recommended.'
                ];
            } else if (currentMode === 'strict_10_12') {
                points = [
                    'Strict overnight fasting of 10 to 12 hours is mandatory.',
                    'Only plain drinking water allowed; do not consume calories or juices.',
                    'Strictly avoid morning tea, coffee, smoking, and alcohol.'
                ];
            } else {
                points = [
                    'No special fasting required. Can be done at any convenient time.',
                    'Maintain normal diet and hydration prior to sample collection.'
                ];
            }
        }

        if (previewCount) {
            previewCount.textContent = isDefaultFallback ? `${points.length} Points (Default)` : `${points.length} Points`;
        }

        previewContainer.innerHTML = points.map(pt => `
            <div class="flex items-start gap-2.5 p-2.5 rounded-xl bg-slate-50 dark:bg-[#041412] border border-slate-200/70 dark:border-teal-900/40 text-xs font-semibold text-slate-800 dark:text-slate-200 shadow-2xs">
                <span class="w-4 h-4 rounded-full bg-teal-100 dark:bg-teal-950/80 text-teal-600 dark:text-teal-400 flex items-center justify-center text-[9px] flex-shrink-0 mt-0.5">
                    <i class="fas fa-check"></i>
                </span>
                <span class="leading-relaxed">${escapeHtml(pt)}</span>
            </div>
        `).join('');

        // Update Status Badge
        if (statusBadge && statusText) {
            if (currentMode === 'overnight_8_10') {
                statusBadge.className = 'inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold transition shadow-xs bg-amber-100 text-amber-900 dark:bg-amber-950 dark:text-amber-300 border border-amber-300 dark:border-amber-700';
                statusBadge.querySelector('i').className = 'fas fa-moon text-[11px] text-amber-600 dark:text-amber-400';
                statusText.textContent = 'Overnight Fasting (8 - 10 Hrs)';
            } else if (currentMode === 'strict_10_12') {
                statusBadge.className = 'inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold transition shadow-xs bg-orange-100 text-orange-900 dark:bg-orange-950 dark:text-orange-300 border border-orange-300 dark:border-orange-700';
                statusBadge.querySelector('i').className = 'fas fa-hourglass-half text-[11px] text-orange-600 dark:text-orange-400';
                statusText.textContent = 'Strict Fasting (10 - 12 Hrs)';
            } else {
                statusBadge.className = 'inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold transition shadow-xs bg-emerald-100 text-emerald-900 dark:bg-emerald-950 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-700';
                statusBadge.querySelector('i').className = 'fas fa-sun text-[11px] text-emerald-600 dark:text-emerald-400';
                statusText.textContent = 'No Fasting Required';
            }
        }
    }

    function setActiveMode(mode, userInitiated = false) {
        currentMode = mode;
        const isFasting = mode !== 'no_fasting';

        if (fastingCheckbox) {
            fastingCheckbox.checked = isFasting;
        }

        modeButtons.forEach(btn => {
            const btnMode = btn.dataset.mode;
            const dot = btn.querySelector('.mode-radio-dot');
            const innerDot = btn.querySelector('.dot-inner');

            if (btnMode === mode) {
                btn.classList.add('border-amber-500', 'bg-amber-50/80', 'dark:bg-amber-950/40', 'dark:border-amber-500', 'shadow-xs', 'ring-1', 'ring-amber-500/30');
                btn.classList.remove('border-slate-200', 'dark:border-teal-900/40', 'bg-white', 'dark:bg-[#071a18]');
                if (dot) dot.classList.add('border-amber-500', 'dark:border-amber-400');
                if (innerDot) innerDot.classList.remove('hidden');
            } else {
                btn.classList.remove('border-amber-500', 'bg-amber-50/80', 'dark:bg-amber-950/40', 'dark:border-amber-500', 'shadow-xs', 'ring-1', 'ring-amber-500/30');
                btn.classList.add('border-slate-200', 'dark:border-teal-900/40', 'bg-white', 'dark:bg-[#071a18]');
                if (dot) dot.classList.remove('border-amber-500', 'dark:border-amber-400');
                if (innerDot) innerDot.classList.add('hidden');
            }
        });

        // If user actively clicked a mode and the textarea is empty, prefill recommended points
        if (userInitiated && instructionsInput && instructionsInput.value.trim() === '') {
            if (mode === 'overnight_8_10') {
                instructionsInput.value = "• Overnight fasting of 8 to 10 hours is required prior to sample collection.\n• Only plain drinking water is permitted during the fasting period.\n• Avoid tea, coffee, milk, juices, or breakfast before sample collection.\n• Morning sample collection between 7:00 AM - 10:00 AM recommended.";
            } else if (mode === 'strict_10_12') {
                instructionsInput.value = "• Strict overnight fasting of 10 to 12 hours is mandatory.\n• Only plain drinking water is permitted; do not consume juices or food.\n• Avoid morning tea, coffee, milk, smoking, and alcohol.";
            } else if (mode === 'no_fasting') {
                instructionsInput.value = "• No special fasting required. Can be done at any convenient time.\n• Maintain normal hydration and diet prior to sample collection.";
            }
        }

        updateLivePreview();
    }

    // Initialize mode on load
    const initialChecked = fastingCheckbox ? fastingCheckbox.checked : false;
    const initialText = instructionsInput ? instructionsInput.value.toLowerCase() : '';

    if (initialChecked || (initialText.includes('fasting') && !initialText.includes('no fasting') && !initialText.includes('non-fasting'))) {
        if (initialText.includes('10-12') || initialText.includes('10 to 12') || initialText.includes('12-14')) {
            setActiveMode('strict_10_12');
        } else {
            setActiveMode('overnight_8_10');
        }
    } else {
        setActiveMode('no_fasting');
    }

    // Attach mode button click listeners
    modeButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            setActiveMode(this.dataset.mode, true);
        });
    });

    // Preset chip button listeners
    bulletChips.forEach(chip => {
        chip.addEventListener('click', function () {
            const textToAdd = this.dataset.text;
            if (!instructionsInput || !textToAdd) return;
            const current = instructionsInput.value.trim();
            const formatted = `• ${textToAdd}`;

            if (!current) {
                instructionsInput.value = formatted;
            } else {
                instructionsInput.value = current + '\n' + formatted;
            }

            // Auto-enable fasting if adding a fasting-related bullet point
            if (currentMode === 'no_fasting' && (textToAdd.includes('fasting') || textToAdd.includes('water is permitted') || textToAdd.includes('Avoid tea'))) {
                setActiveMode('overnight_8_10', false);
            } else {
                updateLivePreview();
            }
            instructionsInput.focus();
        });
    });

    // Format Bullets button
    if (formatBulletsBtn && instructionsInput) {
        formatBulletsBtn.addEventListener('click', function () {
            const points = parseBulletPoints(instructionsInput.value);
            if (points.length > 0) {
                instructionsInput.value = points.map(p => `• ${p}`).join('\n');
                updateLivePreview();
            }
        });
    }

    // Clear Instructions button
    if (clearInstructionsBtn && instructionsInput) {
        clearInstructionsBtn.addEventListener('click', function () {
            instructionsInput.value = '';
            updateLivePreview();
            instructionsInput.focus();
        });
    }

    // Live typing listener
    if (instructionsInput) {
        instructionsInput.addEventListener('input', updateLivePreview);
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\lab\lab\resources\views/admin/pages/tests/form.blade.php ENDPATH**/ ?>