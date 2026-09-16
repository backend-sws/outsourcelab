<!-- Patient Reviews & Testimonials Section -->
<section id="reviews" class="container mx-auto px-4 py-12 scroll-mt-24">
    <!-- Success / Error Alert -->
    <?php if(session('review_success')): ?>
        <div id="reviewSuccessAlert" class="mb-8 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-sm animate-fade-in">
            <div class="flex items-center space-x-3">
                <i class="fas fa-check-circle text-emerald-500 text-xl"></i>
                <span class="text-sm font-medium"><?php echo e(session('review_success')); ?></span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
    <?php endif; ?>

    <!-- Section Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-amber-100 text-amber-800 border border-amber-200">
                    <i class="fas fa-star mr-1 text-amber-500"></i> Verified Patient Reviews
                </span>
            </div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-brand-dark tracking-tight">What Our Patients Say</h2>
            <p class="text-sm text-gray-500 mt-1 max-w-xl">Real feedback from patients who trusted Av Wellcare for accurate diagnostic tests and home sample collection.</p>
        </div>
        <div class="flex items-center space-x-3 self-end md:self-auto">
            <!-- Slide Navigation Buttons (< and >) -->
            <div class="flex items-center space-x-2">
                <button type="button" onclick="document.getElementById('reviews-slider').scrollBy({left: -380, behavior: 'smooth'})" class="w-9 h-9 rounded-full border border-gray-300 bg-white flex items-center justify-center text-gray-600 hover:text-brand-dark hover:border-brand-dark transition shadow-sm active:scale-95" title="Previous Reviews">
                    <i class="fas fa-chevron-left text-xs"></i>
                </button>
                <button type="button" onclick="document.getElementById('reviews-slider').scrollBy({left: 380, behavior: 'smooth'})" class="w-9 h-9 rounded-full bg-brand-dark text-white flex items-center justify-center hover:bg-brand-secondary transition shadow-sm active:scale-95" title="Next Reviews">
                    <i class="fas fa-chevron-right text-xs"></i>
                </button>
            </div>
            <button onclick="openReviewModal()" class="px-5 py-2.5 rounded-full bg-brand-secondary hover:bg-yellow-500 text-brand-dark font-extrabold text-sm shadow-md hover:shadow-lg transition-all flex items-center gap-2 group">
                <i class="fas fa-pen-to-square text-sm group-hover:scale-110 transition-transform"></i>
                <span>Write a Review</span>
            </button>
        </div>
    </div>

    <!-- Reviews Slider Container -->
    <div id="reviews-slider" class="flex space-x-6 overflow-x-auto pb-6 pt-2 hide-scroll-bar snap-x snap-mandatory scroll-smooth">
        <?php $__empty_1 = true; $__currentLoopData = $approvedReviews ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="w-[300px] sm:w-[350px] md:w-[380px] flex-shrink-0 snap-start bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-all flex flex-col justify-between group">
                <div>
                    <!-- Star Rating & Date -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex text-amber-400 text-sm gap-0.5">
                            <?php for($i = 1; $i <= 5; $i++): ?>
                                <i class="fas fa-star <?php echo e($i <= $review->rating ? 'text-amber-400' : 'text-gray-200'); ?>"></i>
                            <?php endfor; ?>
                        </div>
                        <span class="text-xs text-gray-400 font-medium">
                            <?php echo e($review->created_at->diffForHumans()); ?>

                        </span>
                    </div>

                    <!-- Comment -->
                    <p class="text-sm text-gray-700 leading-relaxed italic mb-6">
                        "<?php echo e($review->comment); ?>"
                    </p>
                </div>

                <!-- Author Info -->
                <div class="flex items-center space-x-3 pt-4 border-t border-gray-50">
                    <div class="w-10 h-10 rounded-full bg-brand-light/30 border border-brand-secondary/30 flex items-center justify-center font-bold text-brand-dark text-sm">
                        <?php echo e(strtoupper(substr($review->author_name, 0, 1))); ?>

                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm leading-tight"><?php echo e($review->author_name); ?></h4>
                        <span class="text-[11px] text-emerald-600 font-semibold flex items-center gap-1">
                            <i class="fas fa-circle-check text-[10px]"></i> Verified Patient
                        </span>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="w-full bg-white rounded-2xl p-8 border border-gray-100 text-center shadow-sm">
                <i class="fas fa-comment-dots text-4xl text-gray-300 mb-3"></i>
                <h4 class="font-bold text-gray-700 text-base">No reviews displayed yet</h4>
                <p class="text-xs text-gray-400 max-w-md mx-auto mt-1 mb-4">Be the first patient to share your experience with our testing and diagnostic services!</p>
                <button onclick="openReviewModal()" class="px-4 py-2 rounded-full bg-brand-primary text-white text-xs font-bold">
                    Share Your Feedback
                </button>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Interactive Review Modal -->
<div id="reviewModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm hidden transition-opacity opacity-0">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 m-4 shadow-2xl relative border border-gray-100 transform scale-95 transition-transform duration-300" id="reviewModalContent">
        <!-- Close Button -->
        <button onclick="closeReviewModal()" class="absolute top-5 right-5 text-gray-400 hover:text-gray-700 w-8 h-8 rounded-full flex items-center justify-center hover:bg-gray-100 transition-colors">
            <i class="fas fa-times text-base"></i>
        </button>

        <div class="text-center mb-6">
            <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center mx-auto mb-3 text-xl shadow-inner">
                <i class="fas fa-star"></i>
            </div>
            <h3 class="text-xl font-extrabold text-brand-dark">Rate Your Experience</h3>
            <p class="text-xs text-gray-500 mt-1">Your honest feedback helps us improve our diagnostic standards and patient care.</p>
        </div>

        <form id="reviewForm" action="<?php echo e(route('reviews.store')); ?>" method="POST" class="space-y-5">
            <?php echo csrf_field(); ?>

            <!-- Interactive Star Selector -->
            <div class="text-center pb-2">
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Select Your Rating</label>
                <div class="flex items-center justify-center gap-2" id="starRatingContainer">
                    <input type="hidden" name="rating" id="selectedRating" value="5" required>
                    <?php for($star = 1; $star <= 5; $star++): ?>
                        <button type="button" class="star-btn text-2xl sm:text-3xl text-amber-400 hover:scale-125 transition-transform focus:outline-none" data-rating="<?php echo e($star); ?>" onclick="setRating(<?php echo e($star); ?>)">
                            <i class="fas fa-star"></i>
                        </button>
                    <?php endfor; ?>
                </div>
                <div id="ratingLabel" class="text-xs font-semibold text-amber-600 mt-2">
                    ⭐⭐⭐⭐⭐ Excellent (5 Stars)
                </div>
            </div>

            <!-- Author Name -->
            <?php
                $patientName = session('patient_id') ? (\App\Models\Patient::find(session('patient_id'))->name ?? '') : '';
            ?>
            <div>
                <label for="author_name" class="block text-xs font-semibold text-gray-700 mb-1.5">Your Full Name <span class="text-red-500">*</span></label>
                <div class="relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"><i class="fas fa-user"></i></span>
                    <input type="text" name="author_name" id="author_name" value="<?php echo e($patientName); ?>" class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 focus:ring-2 focus:ring-brand-secondary focus:border-brand-secondary transition" placeholder="e.g. Rajesh Kumar" required>
                </div>
            </div>

            <!-- Comment / Feedback -->
            <div>
                <label for="comment" class="block text-xs font-semibold text-gray-700 mb-1.5">Your Review / Feedback <span class="text-red-500">*</span></label>
                <textarea name="comment" id="comment" rows="4" class="w-full p-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 focus:ring-2 focus:ring-brand-secondary focus:border-brand-secondary transition" placeholder="Tell us about the home sample collection, report delivery time, staff professionalism, or report clarity..." required minlength="5" maxlength="1000"></textarea>
                <span class="text-[11px] text-gray-400 block text-right mt-1">Min 5 characters</span>
            </div>

            <!-- Status message container for AJAX response -->
            <div id="reviewResponseMsg" class="hidden text-xs font-medium p-3 rounded-xl"></div>

            <!-- Submit Button -->
            <button type="submit" id="reviewSubmitBtn" class="w-full py-3 px-4 rounded-xl bg-brand-primary hover:bg-teal-700 text-white font-bold text-sm shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                <span>Submit Patient Review</span>
                <i class="fas fa-paper-plane text-xs"></i>
            </button>
            <p class="text-[11px] text-center text-gray-400">
                <i class="fas fa-shield-alt mr-1"></i> Reviews are verified by our team before appearing publicly.
            </p>
        </form>
    </div>
</div>

<script>
    function openReviewModal() {
        const modal = document.getElementById('reviewModal');
        const content = document.getElementById('reviewModalContent');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            content.classList.remove('scale-95');
            content.classList.add('scale-100');
        }, 10);
    }

    function closeReviewModal() {
        const modal = document.getElementById('reviewModal');
        const content = document.getElementById('reviewModalContent');
        modal.classList.add('opacity-0');
        content.classList.remove('scale-100');
        content.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }

    const ratingLabels = {
        1: '⭐ Poor (1 Star)',
        2: '⭐⭐ Fair (2 Stars)',
        3: '⭐⭐⭐ Good (3 Stars)',
        4: '⭐⭐⭐⭐ Very Good (4 Stars)',
        5: '⭐⭐⭐⭐⭐ Excellent (5 Stars)'
    };

    function setRating(rating) {
        document.getElementById('selectedRating').value = rating;
        const starBtns = document.querySelectorAll('.star-btn');
        starBtns.forEach(btn => {
            const starVal = parseInt(btn.getAttribute('data-rating'));
            if (starVal <= rating) {
                btn.classList.add('text-amber-400');
                btn.classList.remove('text-gray-200');
            } else {
                btn.classList.remove('text-amber-400');
                btn.classList.add('text-gray-200');
            }
        });
        document.getElementById('ratingLabel').textContent = ratingLabels[rating] || (rating + ' Stars');
    }

    // Handle AJAX submission
    document.getElementById('reviewForm').addEventListener('submit', function(e) {
        const form = this;
        const submitBtn = document.getElementById('reviewSubmitBtn');
        const responseMsg = document.getElementById('reviewResponseMsg');

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Submitting...';

        // Submit via fetch
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
            submitBtn.innerHTML = '<span>Submit Patient Review</span> <i class="fas fa-paper-plane text-xs"></i>';

            if (data.success) {
                responseMsg.className = 'text-xs font-medium p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 block';
                responseMsg.innerHTML = '<i class="fas fa-check-circle mr-1 text-emerald-500"></i> ' + data.message;

                // Immediately prepend the new review to the slider so it shows at the very front
                if (data.review) {
                    const slider = document.getElementById('reviews-slider');
                    if (slider) {
                        // Remove empty state message if present
                        const emptyPlaceholder = slider.querySelector('.w-full.bg-white.rounded-2xl');
                        if (emptyPlaceholder) emptyPlaceholder.remove();

                        let starsHtml = '';
                        for (let s = 1; s <= 5; s++) {
                            starsHtml += '<i class="fas fa-star ' + (s <= data.review.rating ? 'text-amber-400' : 'text-gray-200') + '"></i>';
                        }
                        const initial = (data.review.author_name || 'P').charAt(0).toUpperCase();

                        const newCard = document.createElement('div');
                        newCard.className = 'w-[300px] sm:w-[350px] md:w-[380px] flex-shrink-0 snap-start bg-white rounded-2xl p-6 border-2 border-emerald-300 shadow-md hover:shadow-lg transition-all flex flex-col justify-between group';
                        newCard.innerHTML = `
                            <div>
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex text-amber-400 text-sm gap-0.5">
                                        ${starsHtml}
                                    </div>
                                    <span class="text-xs text-emerald-600 font-bold bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200">
                                        Just now
                                    </span>
                                </div>
                                <p class="text-sm text-gray-700 leading-relaxed italic mb-6">
                                    "${data.review.comment}"
                                </p>
                            </div>
                            <div class="flex items-center space-x-3 pt-4 border-t border-gray-50">
                                <div class="w-10 h-10 rounded-full bg-brand-light/30 border border-brand-secondary/30 flex items-center justify-center font-bold text-brand-dark text-sm">
                                    ${initial}
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800 text-sm leading-tight">${data.review.author_name}</h4>
                                    <span class="text-[11px] text-emerald-600 font-semibold flex items-center gap-1">
                                        <i class="fas fa-circle-check text-[10px]"></i> Verified Patient
                                    </span>
                                </div>
                            </div>
                        `;
                        slider.prepend(newCard);
                        slider.scrollTo({ left: 0, behavior: 'smooth' });
                    }
                }

                form.reset();
                setRating(5);
                setTimeout(() => {
                    closeReviewModal();
                }, 1600);
            } else {
                responseMsg.className = 'text-xs font-medium p-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 block';
                responseMsg.innerHTML = '<i class="fas fa-exclamation-circle mr-1 text-rose-500"></i> ' + (data.message || 'Validation error');
            }
        })
        .catch(err => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<span>Submit Patient Review</span> <i class="fas fa-paper-plane text-xs"></i>';
            form.submit(); // fallback to normal submit if fetch fails
        });

        e.preventDefault();
    });
</script>
<?php /**PATH D:\laravel\outsourcelab\resources\views/partials/reviews-section.blade.php ENDPATH**/ ?>