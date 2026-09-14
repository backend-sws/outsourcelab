    <!-- Spreading Quality Healthcare -->
<div class="container mx-auto px-4 py-8 relative z-20 -mt-12 mb-4">
    <div class="bg-white rounded-2xl p-6 shadow-2xl border border-gray-100">
        <h3 class="text-center text-brand-dark font-bold mb-6 text-xl">Spreading Quality Healthcare Across India</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6" id="stats-section">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 rounded-xl overflow-hidden shadow-sm flex-shrink-0 border-[3px] border-orange-50">
                    <img src="https://images.unsplash.com/photo-1579684385127-1ef15d508118?w=100&h=100&fit=crop" class="w-full h-full object-cover">
                </div>
                <div>
                    <h4 class="font-bold text-gray-800 text-2xl leading-tight"><span class="count-up text-brand-dark" data-target="1">0</span> Crore+</h4>
                    <p class="text-[10px] text-gray-500 uppercase tracking-wide font-semibold mt-1">Lives Touched</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 rounded-xl overflow-hidden shadow-sm flex-shrink-0 border-[3px] border-pink-50">
                    <img src="https://images.unsplash.com/photo-1581594693702-fbdc51b2763b?w=100&h=100&fit=crop" class="w-full h-full object-cover">
                </div>
                <div>
                    <h4 class="font-bold text-gray-800 text-2xl leading-tight"><span class="count-up text-brand-dark" data-target="80">0</span>+</h4>
                    <p class="text-[10px] text-gray-500 uppercase tracking-wide font-semibold mt-1">Self-Owned Labs</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 rounded-xl overflow-hidden shadow-sm flex-shrink-0 border-[3px] border-blue-50">
                    <img src="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=100&h=100&fit=crop" class="w-full h-full object-cover">
                </div>
                <div>
                    <h4 class="font-bold text-gray-800 text-2xl leading-tight"><span class="count-up text-brand-dark" data-target="2000">0</span>+</h4>
                    <p class="text-[10px] text-gray-500 uppercase tracking-wide font-semibold mt-1">Collection Centres</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 rounded-xl overflow-hidden shadow-sm flex-shrink-0 border-[3px] border-purple-50">
                    <img src="https://images.unsplash.com/photo-1584036561566-baf8f5f1b144?w=100&h=100&fit=crop" class="w-full h-full object-cover">
                </div>
                <div>
                    <h4 class="font-bold text-gray-800 text-2xl leading-tight"><span class="count-up text-brand-dark" data-target="1500">0</span>+</h4>
                    <p class="text-[10px] text-gray-500 uppercase tracking-wide font-semibold mt-1">Trained Phlebotomists</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const counters = document.querySelectorAll('.count-up');
    
    const animateCounters = (entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const targetEl = entry.target;
                const target = parseInt(targetEl.getAttribute('data-target'), 10);
                
                // For very small numbers like 1, just set it immediately or count very fast
                if (target === 1) {
                    targetEl.innerText = target;
                    observer.unobserve(targetEl);
                    return;
                }
                
                const duration = 2500; // 2.5 seconds
                const stepTime = 30; 
                const steps = duration / stepTime;
                const inc = target / steps;
                
                let current = 0;
                
                const updateCount = setInterval(() => {
                    current += inc;
                    if (current >= target) {
                        targetEl.innerText = target.toLocaleString('en-IN');
                        clearInterval(updateCount);
                    } else {
                        targetEl.innerText = Math.ceil(current).toLocaleString('en-IN');
                    }
                }, stepTime);
                
                observer.unobserve(targetEl);
            }
        });
    };

    const observer = new IntersectionObserver(animateCounters, { threshold: 0.3 });
    
    counters.forEach(counter => {
        observer.observe(counter);
    });
});
</script>
