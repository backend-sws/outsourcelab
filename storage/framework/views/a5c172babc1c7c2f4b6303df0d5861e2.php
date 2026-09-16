<!-- Contact & Quick Medical Enquiry Section -->
<section id="contact-enquiry" class="container mx-auto px-4 py-12 scroll-mt-24">
    <!-- Success Alert -->
    <?php if(session('enquiry_success')): ?>
        <div id="enquirySuccessAlert" class="mb-8 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-sm animate-fade-in">
            <div class="flex items-center space-x-3">
                <i class="fas fa-check-circle text-emerald-500 text-xl"></i>
                <span class="text-sm font-medium"><?php echo e(session('enquiry_success')); ?></span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
    <?php endif; ?>

    <div class="bg-gradient-to-br from-brand-dark via-slate-900 to-teal-950 rounded-3xl p-6 sm:p-10 lg:p-12 text-white shadow-2xl relative overflow-hidden">
        <!-- Subtle Ambient Glows -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-brand-primary/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-brand-secondary/15 rounded-full blur-3xl pointer-events-none"></div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 relative z-10 items-center">
            
            <!-- Left 5 Cols: Diagnostic Help & Contact Info -->
            <div class="lg:col-span-5 space-y-6">
                <div>
                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-teal-500/20 text-teal-300 border border-teal-500/30 inline-block mb-3">
                        <i class="fas fa-headset mr-1"></i> Patient Care Support
                    </span>
                    <h2 class="text-2xl sm:text-4xl font-extrabold tracking-tight text-white leading-tight">
                        Have a Question or Special Diagnostic Request?
                    </h2>
                    <p class="text-gray-300 text-sm mt-3 leading-relaxed">
                        Need advice on which blood test to choose, home sample collection timing, or bulk corporate health screenings? Send us an enquiry and our chief diagnostic officers will connect with you.
                    </p>
                </div>

                <!-- Contact Tiles -->
                <div class="space-y-3 pt-2">
                    <div class="flex items-center space-x-4 p-3 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm">
                        <div class="w-10 h-10 rounded-xl bg-teal-500/20 text-teal-300 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div>
                            <div class="text-[11px] text-gray-400 font-semibold uppercase">24/7 Helpline</div>
                            <a href="tel:8988988787" class="text-sm font-bold text-white hover:text-brand-secondary transition">898 898 8787 / +91 0000000000</a>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4 p-3 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm">
                        <div class="w-10 h-10 rounded-xl bg-brand-secondary/20 text-brand-secondary flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <div class="text-[11px] text-gray-400 font-semibold uppercase">Official Support Email</div>
                            <a href="mailto:care@avwellcarediagnostics.com" class="text-sm font-bold text-white hover:text-brand-secondary transition">care@avwellcarediagnostics.com</a>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4 p-3 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm">
                        <div class="w-10 h-10 rounded-xl bg-purple-500/20 text-purple-300 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-house-medical"></i>
                        </div>
                        <div>
                            <div class="text-[11px] text-gray-400 font-semibold uppercase">Home Sample Collection</div>
                            <div class="text-xs font-bold text-white">Daily 6:00 AM – 9:00 PM (Trained Phlebotomists)</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right 7 Cols: Interactive Enquiry Form -->
            <div class="lg:col-span-7">
                <div class="bg-white rounded-3xl p-6 sm:p-8 text-gray-800 shadow-xl border border-gray-100">
                    <div class="flex items-center justify-between pb-4 mb-6 border-b border-gray-100">
                        <div>
                            <h3 class="text-lg font-bold text-brand-dark">Send Quick Medical Enquiry</h3>
                            <p class="text-xs text-gray-500">We usually respond within 15 to 30 minutes during working hours</p>
                        </div>
                        <span class="hidden sm:inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-brand-light/30 text-brand-primary border border-brand-primary/20">
                            <i class="fas fa-bolt mr-1 text-amber-500"></i> Fast Response
                        </span>
                    </div>

                    <form id="enquiryForm" action="<?php echo e(route('enquiries.store')); ?>" method="POST" class="space-y-4">
                        <?php echo csrf_field(); ?>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Name -->
                            <div>
                                <label for="enquiry_name" class="block text-xs font-semibold text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                                <input type="text" name="name" id="enquiry_name" value="<?php echo e(session('patient_id') ? (\App\Models\Patient::find(session('patient_id'))->name ?? '') : ''); ?>" class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 focus:ring-2 focus:ring-brand-primary focus:border-brand-primary transition" placeholder="e.g. Amit Verma" required>
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="enquiry_email" class="block text-xs font-semibold text-gray-700 mb-1">Email Address <span class="text-red-500">*</span></label>
                                <input type="email" name="email" id="enquiry_email" value="<?php echo e(session('patient_id') ? (\App\Models\Patient::find(session('patient_id'))->email ?? '') : ''); ?>" class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 focus:ring-2 focus:ring-brand-primary focus:border-brand-primary transition" placeholder="e.g. amit@example.com" required>
                            </div>
                        </div>

                        <!-- Subject -->
                        <div>
                            <label for="enquiry_subject" class="block text-xs font-semibold text-gray-700 mb-1">Enquiry Subject / Category <span class="text-red-500">*</span></label>
                            <select name="subject" id="enquiry_subject" class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 focus:ring-2 focus:ring-brand-primary focus:border-brand-primary transition" required>
                                <option value="" disabled selected>Select Enquiry Topic...</option>
                                <option value="Home Sample Collection Booking">Home Sample Collection Request</option>
                                <option value="Package & Test Pricing Query">Health Package & Test Pricing</option>
                                <option value="Report Delivery & WhatsApp Assistance">Report Delivery & WhatsApp Assistance</option>
                                <option value="Doctor or Corporate Tie-Up">Corporate / Doctor Partnership</option>
                                <option value="Prescription Review / Test Guidance">Upload Prescription for Guidance</option>
                                <option value="General Diagnostic Query">General Medical Enquiry</option>
                            </select>
                        </div>

                        <!-- Message -->
                        <div>
                            <label for="enquiry_message" class="block text-xs font-semibold text-gray-700 mb-1">Your Message / Query <span class="text-red-500">*</span></label>
                            <textarea name="message" id="enquiry_message" rows="3" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 focus:ring-2 focus:ring-brand-primary focus:border-brand-primary transition" placeholder="Describe your query, test requirement, or preferred home visit timing..." required minlength="5" maxlength="2000"></textarea>
                        </div>

                        <!-- Status Message Container for AJAX -->
                        <div id="enquiryResponseMsg" class="hidden text-xs font-medium p-3 rounded-xl"></div>

                        <!-- Submit Button -->
                        <button type="submit" id="enquirySubmitBtn" class="w-full py-3 px-4 rounded-xl bg-brand-secondary hover:bg-yellow-500 text-brand-dark font-extrabold text-sm shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                            <span>Submit Medical Enquiry</span>
                            <i class="fas fa-paper-plane text-xs"></i>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
    document.getElementById('enquiryForm').addEventListener('submit', function(e) {
        const form = this;
        const submitBtn = document.getElementById('enquirySubmitBtn');
        const responseMsg = document.getElementById('enquiryResponseMsg');

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Sending Enquiry...';

        fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<span>Submit Medical Enquiry</span> <i class="fas fa-paper-plane text-xs"></i>';

            if (data.success) {
                responseMsg.className = 'text-xs font-medium p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 block';
                responseMsg.innerHTML = '<i class="fas fa-check-circle mr-1 text-emerald-500"></i> ' + data.message;
                form.reset();
            } else {
                responseMsg.className = 'text-xs font-medium p-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 block';
                responseMsg.innerHTML = '<i class="fas fa-exclamation-circle mr-1 text-rose-500"></i> ' + (data.message || 'Validation error');
            }
        })
        .catch(err => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<span>Submit Medical Enquiry</span> <i class="fas fa-paper-plane text-xs"></i>';
            form.submit(); // fallback to normal submit
        });

        e.preventDefault();
    });
</script>
<?php /**PATH D:\laravel\outsourcelab\resources\views/partials/enquiry-section.blade.php ENDPATH**/ ?>