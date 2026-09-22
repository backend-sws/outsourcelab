{{-- ====================================================================
     Stats Section — Hidden (commented out)
     To re-enable: remove the opening {{-- and closing --}} below
     ==================================================================== --}}
{{--
<div class="container mx-auto px-4 py-6 relative z-10 my-4">
    <div class="bg-white rounded-2xl p-6 shadow-2xl border border-gray-100">
        <h3 class="text-center text-brand-dark font-bold mb-6 text-xl">Spreading Quality Healthcare Across India</h3>
        @php
            $livesVal = \App\Models\Setting::get('stat_lives_touched_val', '1');
            $livesSuffix = \App\Models\Setting::get('stat_lives_touched_suffix', 'Crore+');
            $livesLabel = \App\Models\Setting::get('stat_lives_touched_label', 'Lives Touched');

            $labsVal = \App\Models\Setting::get('stat_labs_val', '80');
            $labsSuffix = \App\Models\Setting::get('stat_labs_suffix', '+');
            $labsLabel = \App\Models\Setting::get('stat_labs_label', 'Self-Owned Labs');

            $centresVal = \App\Models\Setting::get('stat_centres_val', '2000');
            $centresSuffix = \App\Models\Setting::get('stat_centres_suffix', '+');
            $centresLabel = \App\Models\Setting::get('stat_centres_label', 'Collection Centres');

            $phlebosVal = \App\Models\Setting::get('stat_phlebos_val', '1500');
            $phlebosSuffix = \App\Models\Setting::get('stat_phlebos_suffix', '+');
            $phlebosLabel = \App\Models\Setting::get('stat_phlebos_label', 'Trained Phlebotomists');
        @endphp
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6" id="stats-section">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 rounded-xl overflow-hidden shadow-sm flex-shrink-0 border-[3px] border-orange-50">
                    <img src="https://images.unsplash.com/photo-1579684385127-1ef15d508118?w=100&h=100&fit=crop" class="w-full h-full object-cover">
                </div>
                <div>
                    <h4 class="font-bold text-gray-800 text-2xl leading-tight"><span class="count-up text-brand-dark" data-target="{{ (int)$livesVal }}">{{ (int)$livesVal }}</span> {{ $livesSuffix }}</h4>
                    <p class="text-[10px] text-gray-500 uppercase tracking-wide font-semibold mt-1">{{ $livesLabel }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 rounded-xl overflow-hidden shadow-sm flex-shrink-0 border-[3px] border-pink-50">
                    <img src="https://images.unsplash.com/photo-1581594693702-fbdc51b2763b?w=100&h=100&fit=crop" class="w-full h-full object-cover">
                </div>
                <div>
                    <h4 class="font-bold text-gray-800 text-2xl leading-tight"><span class="count-up text-brand-dark" data-target="{{ (int)$labsVal }}">0</span>{{ $labsSuffix }}</h4>
                    <p class="text-[10px] text-gray-500 uppercase tracking-wide font-semibold mt-1">{{ $labsLabel }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 rounded-xl overflow-hidden shadow-sm flex-shrink-0 border-[3px] border-blue-50">
                    <img src="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=100&h=100&fit=crop" class="w-full h-full object-cover">
                </div>
                <div>
                    <h4 class="font-bold text-gray-800 text-2xl leading-tight"><span class="count-up text-brand-dark" data-target="{{ (int)$centresVal }}">0</span>{{ $centresSuffix }}</h4>
                    <p class="text-[10px] text-gray-500 uppercase tracking-wide font-semibold mt-1">{{ $centresLabel }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 rounded-xl overflow-hidden shadow-sm flex-shrink-0 border-[3px] border-purple-50">
                    <img src="https://images.unsplash.com/photo-1584036561566-baf8f5f1b144?w=100&h=100&fit=crop" class="w-full h-full object-cover">
                </div>
                <div>
                    <h4 class="font-bold text-gray-800 text-2xl leading-tight"><span class="count-up text-brand-dark" data-target="{{ (int)$phlebosVal }}">0</span>{{ $phlebosSuffix }}</h4>
                    <p class="text-[10px] text-gray-500 uppercase tracking-wide font-semibold mt-1">{{ $phlebosLabel }}</p>
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

                if (target === 1) {
                    targetEl.innerText = target;
                    observer.unobserve(targetEl);
                    return;
                }

                const duration = 2500;
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
--}}
