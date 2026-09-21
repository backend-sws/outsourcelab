<!-- Hero Section -->
<div class="relative py-20 lg:py-28 px-4 z-30">
    <!-- Background Image Slider -->
    <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
        <img src="/hero_banner_dna.jpg" class="hero-bg-slider absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 ease-in-out opacity-100" style="image-rendering: high-quality; filter: contrast(1.05) saturate(1.1); transform: translateZ(0);" alt="Background 1">
        <img src="/banner.jpg" class="hero-bg-slider absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 ease-in-out opacity-0" style="image-rendering: high-quality; filter: contrast(1.05) saturate(1.1); transform: translateZ(0);" alt="Background 2">
        <img src="/biochemistry.jpg" class="hero-bg-slider absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 ease-in-out opacity-0" style="image-rendering: high-quality; filter: contrast(1.05) saturate(1.1); transform: translateZ(0);" alt="Background 3">
        <img src="/flask.jpg" class="hero-bg-slider absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 ease-in-out opacity-0" style="image-rendering: high-quality; filter: contrast(1.05) saturate(1.1); transform: translateZ(0);" alt="Background 4">
        <img src="/two-asian.jpg" class="hero-bg-slider absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 ease-in-out opacity-0" style="image-rendering: high-quality; filter: contrast(1.05) saturate(1.1); transform: translateZ(0);" alt="Background 5">
    </div>

    <!-- Live Electricity Animations -->
    <div class="absolute inset-0 pointer-events-none z-10 overflow-hidden">
        <div class="electricity-line" style="left: 60%; animation-duration: 2.5s; animation-delay: 0s;"></div>
        <div class="electricity-line" style="left: 75%; animation-duration: 3s; animation-delay: 1s; height: 350px;"></div>
        <div class="electricity-line" style="left: 85%; animation-duration: 2s; animation-delay: 0.5s; height: 200px;"></div>
        <div class="electricity-line" style="left: 95%; animation-duration: 4s; animation-delay: 2s;"></div>
        <div class="electricity-line" style="left: 70%; animation-duration: 1.5s; animation-delay: 1.5s; height: 100px;"></div>
    </div>

    <div class="container mx-auto flex flex-col md:flex-row items-center justify-between relative z-30">
        <div class="md:w-3/5 space-y-6">
            <!-- Added a subtle text-shadow to make it readable against different backgrounds since overlay is removed -->
            <h1 id="typewriter-text" class="text-3xl md:text-4xl font-extrabold text-brand-dark mb-4 min-h-[40px] md:min-h-[48px]" style="text-shadow: 2px 2px 4px rgba(255,255,255,0.8), -2px -2px 4px rgba(255,255,255,0.8), 0px 0px 10px rgba(255,255,255,1);"></h1>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const text = "Fast, Reliable Diagnostics.";
                    let i = 0;
                    const speed = 70; // typing speed in milliseconds
                    const element = document.getElementById("typewriter-text");

                    function typeWriter() {
                        if (i < text.length) {
                            element.innerHTML = text.substring(0, i + 1) + '<span class="animate-pulse text-brand-secondary">|</span>';
                            i++;
                            setTimeout(typeWriter, speed);
                        } else {
                            element.innerHTML = text + '<span class="animate-pulse text-transparent">|</span>'; // Hide cursor after typing
                        }
                    }

                    setTimeout(typeWriter, 300); // Start after small delay

                    // Background slider logic
                    const bgImages = document.querySelectorAll('.hero-bg-slider');
                    let currentBgIndex = 0;
                    
                    if(bgImages.length > 0) {
                        setInterval(() => {
                            bgImages[currentBgIndex].classList.remove('opacity-100');
                            bgImages[currentBgIndex].classList.add('opacity-0');
                            
                            currentBgIndex = (currentBgIndex + 1) % bgImages.length;
                            
                            bgImages[currentBgIndex].classList.remove('opacity-0');
                            bgImages[currentBgIndex].classList.add('opacity-100');
                        }, 5000); // 5 seconds
                    }
                });
            </script>

            <!-- Live Search Bar with Instant Suggestions Dropdown -->
            <div class="relative max-w-xl mb-4 z-50" id="heroSearchContainer">
                <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 z-10"></i>
                <input type="text" 
                    id="heroLiveSearchInput" 
                    placeholder="Search 80+ blood tests, organ profiles & full body packages..." 
                    autocomplete="off"
                    class="w-full pl-12 pr-12 py-4 rounded-2xl shadow-xl focus:outline-none focus:ring-2 focus:ring-teal-600 text-sm md:text-base border-0 bg-white/95 backdrop-blur-md placeholder-gray-400 text-gray-800 font-medium">
                
                <div class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 flex items-center z-10">
                    <button type="button" id="clearHeroSearchBtn" class="hidden text-gray-400 hover:text-gray-600 p-1" onclick="clearLiveSearch()">
                        <i class="fas fa-times-circle"></i>
                    </button>
                </div>

                <!-- Live Results Dropdown Container -->
                <div id="heroSearchResultsDropdown" class="absolute left-0 right-0 top-full mt-2 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden hidden max-h-[440px] overflow-y-auto z-[99999]">
                    <div id="searchResultsContent" class="p-2 space-y-1 divide-y divide-gray-100">
                        <!-- Populated dynamically via JS -->
                    </div>
                </div>
            </div>

            <!-- Quick Search Tags -->
            <div class="flex flex-wrap items-center gap-2 text-xs text-gray-700 max-w-xl mb-6">
                <span class="font-bold text-gray-500 text-[11px] uppercase tracking-wider flex items-center gap-1">
                    <i class="fas fa-fire-flame-curved text-amber-500"></i> Popular:
                </span>
                <button type="button" onclick="triggerSearch('Full Body')" class="px-2.5 py-1 rounded-full bg-white/80 hover:bg-white text-gray-700 hover:text-teal-800 border border-gray-200/80 shadow-xs transition font-semibold">
                    Full Body
                </button>
                <button type="button" onclick="triggerSearch('Thyroid')" class="px-2.5 py-1 rounded-full bg-white/80 hover:bg-white text-gray-700 hover:text-teal-800 border border-gray-200/80 shadow-xs transition font-semibold">
                    Thyroid (TSH)
                </button>
                <button type="button" onclick="triggerSearch('HbA1c')" class="px-2.5 py-1 rounded-full bg-white/80 hover:bg-white text-gray-700 hover:text-teal-800 border border-gray-200/80 shadow-xs transition font-semibold">
                    Diabetes (HbA1c)
                </button>
                <button type="button" onclick="triggerSearch('Vitamin')" class="px-2.5 py-1 rounded-full bg-white/80 hover:bg-white text-gray-700 hover:text-teal-800 border border-gray-200/80 shadow-xs transition font-semibold">
                    Vitamin D & B12
                </button>
                <button type="button" onclick="triggerSearch('Lipid')" class="px-2.5 py-1 rounded-full bg-white/80 hover:bg-white text-gray-700 hover:text-teal-800 border border-gray-200/80 shadow-xs transition font-semibold">
                    Lipid / Cholesterol
                </button>
            </div>

            <!-- Quick CTA Buttons: Browse Packages & Upload Prescription -->
            <div class="flex flex-col sm:flex-row gap-3 max-w-xl">
                <a href="#single-health-checkup" class="flex-1 bg-white/95 hover:bg-white px-5 py-3.5 rounded-2xl shadow-md flex items-center justify-center font-bold text-gray-800 transition border border-gray-100 hover:shadow-lg text-xs sm:text-sm group">
                    <div class="w-9 h-9 rounded-xl bg-teal-50 flex items-center justify-center text-teal-700 mr-3 group-hover:scale-110 transition-transform">
                        <i class="fas fa-flask"></i>
                    </div>
                    <span>Explore Single Tests</span>
                </a>

                <button type="button" onclick="window.openPrescriptionModal()" class="flex-1 bg-gradient-to-r from-teal-800 to-indigo-900 hover:from-teal-900 hover:to-indigo-950 text-white px-5 py-3.5 rounded-2xl shadow-md hover:shadow-lg flex items-center justify-center font-bold transition text-xs sm:text-sm group">
                    <div class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center text-amber-300 mr-3 group-hover:scale-110 transition-transform">
                        <i class="fas fa-file-prescription"></i>
                    </div>
                    <span>Upload Prescription</span>
                </button>
            </div>
        </div>

        <div class="md:w-2/5 hidden md:block">
            <!-- Right side hero card / Trust badge banner -->
            <div class="bg-white/80 backdrop-blur-xl p-6 rounded-3xl border border-white/60 shadow-2xl space-y-4 max-w-sm ml-auto">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-teal-100 text-teal-800 flex items-center justify-center text-xl">
                        <i class="fas fa-shield-virus"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm">Quality Standards</h4>
                        <p class="text-xs text-gray-500">NABL & ICMR Certified Protocols</p>
                    </div>
                </div>
                <div class="space-y-2 text-xs text-gray-600">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-circle-check text-teal-600 text-xs"></i>
                        <span>Automated Beckman & Roche Analyzers</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-circle-check text-teal-600 text-xs"></i>
                        <span>Zero-contamination BD Vacutainer tubes</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-circle-check text-teal-600 text-xs"></i>
                        <span>Free home pickup across 500+ pincodes</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Autocomplete Live Search Script -->
<script>
    let searchDebounceTimer = null;

    function triggerSearch(keyword) {
        const input = document.getElementById('heroLiveSearchInput');
        if (input) {
            input.value = keyword;
            input.focus();
            fetchSearchResults(keyword);
        }
    }

    function clearLiveSearch() {
        const input = document.getElementById('heroLiveSearchInput');
        const dropdown = document.getElementById('heroSearchResultsDropdown');
        const clearBtn = document.getElementById('clearHeroSearchBtn');
        if (input) input.value = '';
        if (dropdown) dropdown.classList.add('hidden');
        if (clearBtn) clearBtn.classList.add('hidden');
    }

    function fetchSearchResults(query) {
        const dropdown = document.getElementById('heroSearchResultsDropdown');
        const container = document.getElementById('searchResultsContent');
        const clearBtn = document.getElementById('clearHeroSearchBtn');

        if (!query || query.trim().length < 2) {
            if (dropdown) dropdown.classList.add('hidden');
            if (clearBtn) clearBtn.classList.add('hidden');
            return;
        }

        if (clearBtn) clearBtn.classList.remove('hidden');

        fetch(`/api/search-catalogue?q=${encodeURIComponent(query)}`)
            .then(res => res.json())
            .then(data => {
                const packages = data.packages || [];
                const tests = data.tests || [];

                if (packages.length === 0 && tests.length === 0) {
                    container.innerHTML = `
                        <div class="p-6 text-center text-gray-500">
                            <i class="fas fa-magnifying-glass text-2xl text-gray-300 mb-2"></i>
                            <p class="text-xs font-semibold">No tests or packages found matching "${query}"</p>
                            <p class="text-[11px] text-gray-400 mt-1">Upload your doctor's prescription and our team will book it for you.</p>
                            <button type="button" onclick="window.openPrescriptionModal()" class="mt-3 px-3 py-1.5 bg-teal-800 text-white rounded-xl text-xs font-bold">
                                Upload Prescription
                            </button>
                        </div>
                    `;
                    dropdown.classList.remove('hidden');
                    return;
                }

                let html = '';

                if (packages.length > 0) {
                    html += `<div class="px-3 py-1.5 bg-gray-50 text-[10px] font-extrabold uppercase tracking-wider text-gray-500 rounded-lg">Popular Health Packages (${packages.length})</div>`;
                    packages.forEach(pkg => {
                        const safeName = (pkg.name || '').replace(/"/g, '&quot;');
                        html += `
                            <div class="flex items-center justify-between p-3 rounded-xl hover:bg-teal-50/50 transition group cursor-pointer" onclick="window.location.href='${pkg.url}'">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-teal-100 text-teal-800 flex items-center justify-center text-xs font-bold flex-shrink-0">
                                        <i class="fas fa-box-open"></i>
                                    </div>
                                    <div>
                                        <h5 class="text-xs font-bold text-gray-900 group-hover:text-teal-800 transition">${pkg.name}</h5>
                                        <p class="text-[10px] text-gray-500">${pkg.parameters_count || pkg.total_params || 0} Tests Included • ${pkg.subcategory || 'Full Body'}</p>
                                    </div>
                                </div>
                                <div class="text-right flex items-center gap-2.5 flex-shrink-0 ml-2">
                                    <div>
                                        <span class="text-xs font-extrabold text-teal-900 block">₹${Number(pkg.price).toLocaleString('en-IN')}</span>
                                        <span class="text-[10px] text-teal-600 block font-bold">Details <i class="fas fa-chevron-right text-[8px]"></i></span>
                                    </div>
                                    <button type="button" 
                                        onclick="event.stopPropagation(); addToCart(this)" 
                                        data-id="${pkg.id}"
                                        data-type="package"
                                        data-name="${safeName}" 
                                        data-price="${pkg.price}" 
                                        data-mrp="${pkg.price}" 
                                        data-params="Includes ${pkg.parameters_count || pkg.total_params || 0} Parameters"
                                        class="px-3 py-1.5 bg-brand-secondary hover:bg-brand-dark text-white rounded-xl text-xs font-bold transition flex items-center gap-1 shadow-sm active:scale-95 cursor-pointer">
                                        <i class="fas fa-cart-plus text-[10px]"></i>
                                        <span>Add</span>
                                    </button>
                                </div>
                            </div>
                        `;
                    });
                }

                if (tests.length > 0) {
                    html += `<div class="px-3 py-1.5 bg-gray-50 text-[10px] font-extrabold uppercase tracking-wider text-gray-500 rounded-lg mt-2">Individual Lab Tests (${tests.length})</div>`;
                    tests.forEach(t => {
                        const safeName = (t.name || '').replace(/"/g, '&quot;');
                        const safeDept = (t.department || 'Single Diagnostic Test').replace(/"/g, '&quot;');
                        const mrp = Math.round(t.price * 1.35);
                        html += `
                            <div class="flex items-center justify-between p-3 rounded-xl hover:bg-indigo-50/50 transition group cursor-pointer" onclick="window.location.href='${t.url}'">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-800 flex items-center justify-center text-xs font-bold flex-shrink-0">
                                        <i class="fas fa-vial"></i>
                                    </div>
                                    <div>
                                        <h5 class="text-xs font-bold text-gray-900 group-hover:text-indigo-800 transition">${t.name}</h5>
                                        <p class="text-[10px] text-gray-500">${t.department} • TAT: ${t.tat}</p>
                                    </div>
                                </div>
                                <div class="text-right flex items-center gap-2.5 flex-shrink-0 ml-2">
                                    <div>
                                        <span class="text-xs font-extrabold text-indigo-950 block">₹${Number(t.price).toLocaleString('en-IN')}</span>
                                        <span class="text-[10px] text-indigo-600 block font-bold">Details <i class="fas fa-chevron-right text-[8px]"></i></span>
                                    </div>
                                    <button type="button" 
                                        onclick="event.stopPropagation(); addToCart(this)" 
                                        data-id="${t.id}"
                                        data-type="test"
                                        data-name="${safeName}" 
                                        data-price="${t.price}" 
                                        data-mrp="${mrp}" 
                                        data-params="${safeDept}"
                                        class="px-3 py-1.5 bg-brand-secondary hover:bg-brand-dark text-white rounded-xl text-xs font-bold transition flex items-center gap-1 shadow-sm active:scale-95 cursor-pointer">
                                        <i class="fas fa-cart-plus text-[10px]"></i>
                                        <span>Add</span>
                                    </button>
                                </div>
                            </div>
                        `;
                    });
                }

                container.innerHTML = html;
                dropdown.classList.remove('hidden');
            })
            .catch(err => {
                console.error('Search error:', err);
            });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('heroLiveSearchInput');
        const dropdown = document.getElementById('heroSearchResultsDropdown');

        if (input) {
            input.addEventListener('input', function(e) {
                clearTimeout(searchDebounceTimer);
                const val = e.target.value;
                searchDebounceTimer = setTimeout(() => {
                    fetchSearchResults(val);
                }, 250);
            });

            // Close when clicking outside
            document.addEventListener('click', function(e) {
                if (!input.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.classList.add('hidden');
                }
            });

            // Re-open if input has content and is focused
            input.addEventListener('focus', function() {
                if (input.value.trim().length >= 2) {
                    dropdown.classList.remove('hidden');
                }
            });
        }
    });
</script>
<?php /**PATH C:\Users\Employee\Desktop\outsourcelab\resources\views/frontend/partials/hero.blade.php ENDPATH**/ ?>