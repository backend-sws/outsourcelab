<!-- Comprehensive Package Parameters & Clinical Tests Modal (Dr Lal / 1mg Style) -->
<div id="packageDetailsModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm hidden transition-opacity duration-300">
    <div class="relative w-full max-w-2xl bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden flex flex-col max-h-[90vh] animate-in fade-in zoom-in duration-200">
        
        <!-- Modal Header -->
        <div class="p-6 bg-gradient-to-r from-teal-900 via-teal-800 to-indigo-900 text-white relative flex items-start justify-between">
            <div class="pr-8">
                <div class="inline-flex items-center gap-2 px-2.5 py-0.5 rounded-full bg-white/10 text-teal-200 text-xs font-semibold mb-2 backdrop-blur-md border border-white/15">
                    <i class="fas fa-shield-halved text-[11px]"></i>
                    <span id="modalPackageParamsCount">78 Clinical Parameters</span>
                </div>
                <h3 id="modalPackageName" class="text-xl font-extrabold tracking-tight leading-snug">Package Name</h3>
                <p id="modalPackageDesc" class="text-xs text-teal-100/80 mt-1 line-clamp-2">Brief package description</p>
            </div>
            <button type="button" onclick="closePackageDetails()" class="text-white/70 hover:text-white bg-white/10 hover:bg-white/20 p-2 rounded-xl transition">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <!-- Preparation & Sample Banner -->
        <div class="bg-teal-50/80 px-6 py-2.5 border-b border-teal-100/80 flex items-center justify-between text-xs text-teal-900 font-medium">
            <div class="flex items-center gap-2">
                <i class="fas fa-clock text-amber-500"></i>
                <span>Reports in 10-12 Hours</span>
            </div>
            <div class="flex items-center gap-2">
                <i class="fas fa-house-medical text-teal-600"></i>
                <span>Free Home Sample Collection</span>
            </div>
        </div>

        <!-- Tests & Departments Accordion / List Body -->
        <div class="p-6 overflow-y-auto space-y-4 flex-1 text-sm bg-slate-50/50" id="modalDepartmentsContainer">
            <!-- Dynamic Departments Injected by JS -->
        </div>

        <!-- Modal Footer with Price & Add to Cart -->
        <div class="p-5 bg-white border-t border-gray-100 flex items-center justify-between shadow-lg">
            <div>
                <span class="text-[11px] text-gray-400 uppercase font-bold tracking-wider block">Special Offer Price</span>
                <span id="modalPackagePrice" class="text-2xl font-black text-gray-900">₹1,299</span>
            </div>
            <button id="modalAddToCartBtn" type="button" class="px-6 py-3 bg-gradient-to-r from-teal-600 to-indigo-600 hover:from-teal-700 hover:to-indigo-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-teal-600/25 transition-all flex items-center gap-2">
                <i class="fas fa-cart-plus"></i>
                <span>Book Package Now</span>
            </button>
        </div>
    </div>
</div>

<script>
    let currentModalPkg = null;

    function openPackageDetails(packageId) {
        if (!window.PACKAGE_DETAILS_DATA || !window.PACKAGE_DETAILS_DATA[packageId]) {
            return;
        }

        const pkg = window.PACKAGE_DETAILS_DATA[packageId];
        currentModalPkg = pkg;

        document.getElementById('modalPackageName').textContent = pkg.name;
        document.getElementById('modalPackageDesc').textContent = pkg.description || 'Comprehensive pathology health checkup covering essential vital organs.';
        document.getElementById('modalPackageParamsCount').textContent = `${pkg.total_parameters} Clinical Parameters Included`;
        document.getElementById('modalPackagePrice').textContent = `₹${Number(pkg.price).toLocaleString('en-IN')}`;

        const container = document.getElementById('modalDepartmentsContainer');
        container.innerHTML = '';

        const grouped = pkg.grouped || {};
        const deptNames = Object.keys(grouped);

        if (deptNames.length === 0) {
            container.innerHTML = '<div class="text-center py-6 text-gray-500 text-xs">Complete details available during sample collection.</div>';
        } else {
            deptNames.forEach((dept, index) => {
                const params = grouped[dept];
                const deptCard = document.createElement('div');
                deptCard.className = 'bg-white rounded-2xl border border-gray-200/80 p-4 shadow-sm';
                
                let paramsPills = params.map(p => 
                    `<span class="inline-flex items-center px-2 py-1 rounded-md text-[11px] font-medium bg-slate-50 text-slate-700 border border-slate-200/60">
                        <i class="fas fa-check text-teal-500 mr-1 text-[9px]"></i>${p}
                    </span>`
                ).join(' ');

                deptCard.innerHTML = `
                    <div class="flex items-center justify-between mb-2.5">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-teal-50 text-teal-700 flex items-center justify-center text-xs font-bold">
                                <i class="fas fa-flask"></i>
                            </div>
                            <span class="font-bold text-gray-900 text-sm">${dept}</span>
                        </div>
                        <span class="px-2 py-0.5 rounded-full bg-gray-100 text-gray-600 text-[10px] font-bold">
                            ${params.length} Tests
                        </span>
                    </div>
                    <div class="flex flex-wrap gap-1.5 pt-1">
                        ${paramsPills}
                    </div>
                `;
                container.appendChild(deptCard);
            });
        }

        const modal = document.getElementById('packageDetailsModal');
        modal.classList.remove('hidden');

        // Setup add to cart button
        const addBtn = document.getElementById('modalAddToCartBtn');
        addBtn.onclick = function() {
            if (typeof addToCart === 'function') {
                addToCart({
                    id: pkg.id,
                    type: 'package',
                    dataset: {
                        id: pkg.id,
                        type: 'package',
                        name: pkg.name,
                        price: pkg.price,
                        mrp: pkg.price,
                        params: `Includes ${pkg.total_parameters} Parameters`
                    }
                });
            }
            closePackageDetails();
        };
    }

    function closePackageDetails() {
        const modal = document.getElementById('packageDetailsModal');
        modal.classList.add('hidden');
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closePackageDetails();
        }
    });

    document.getElementById('packageDetailsModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closePackageDetails();
        }
    });
</script>
