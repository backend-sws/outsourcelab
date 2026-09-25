@extends('admin.layouts.app')

@section('title', isset($package) ? 'Edit Package' : 'Add Package')
@section('header')
<div class="flex items-center">
    <a href="{{ route('admin.packages.index') }}" class="text-indigo-600 hover:text-indigo-800 mr-4">
        <i class="fas fa-arrow-left"></i>
    </a>
    {{ isset($package) ? 'Edit Package' : 'Add New Package' }}
</div>
@endsection

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-4xl mx-auto">
    <form action="{{ isset($package) ? route('admin.packages.update', $package->id) : route('admin.packages.store') }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8 space-y-6">
        @csrf
        @if(isset($package))
            @method('PUT')
        @endif
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Package Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $package->name ?? '') }}" required class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-2 border bg-gray-50">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Multi-Section Display (Show in multiple homepage sections) -->
            <div class="md:col-span-2 bg-indigo-50/50 rounded-xl p-4 border border-indigo-100">
                <label class="block text-sm font-bold text-indigo-900 mb-1">
                    <i class="fas fa-layer-group text-indigo-600 mr-1"></i> Display in Homepage Sections (Multi-Select)
                </label>
                <p class="text-xs text-indigo-600/80 mb-3">Choose one or more sections where this package should appear on the website:</p>
                
                @php
                    $selectedSections = old('display_sections', $package->display_sections ?? [($package->type ?? 'top_booked')]);
                    if (empty($selectedSections)) $selectedSections = ['top_booked'];
                @endphp
                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <label class="flex items-center space-x-2 bg-white p-3 rounded-lg border border-indigo-200 cursor-pointer hover:bg-indigo-50/30 transition">
                        <input type="checkbox" name="display_sections[]" value="top_booked" {{ in_array('top_booked', $selectedSections) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-xs font-semibold text-gray-800">Top Booked Packages</span>
                    </label>
                    <label class="flex items-center space-x-2 bg-white p-3 rounded-lg border border-indigo-200 cursor-pointer hover:bg-indigo-50/30 transition">
                        <input type="checkbox" name="display_sections[]" value="habit" id="section_habit_check" {{ in_array('habit', $selectedSections) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-xs font-semibold text-gray-800">Unhealthy Habits</span>
                    </label>
                    <label class="flex items-center space-x-2 bg-white p-3 rounded-lg border border-indigo-200 cursor-pointer hover:bg-indigo-50/30 transition">
                        <input type="checkbox" name="display_sections[]" value="femcliffe" {{ in_array('femcliffe', $selectedSections) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-xs font-semibold text-gray-800">Femcliffe (Women's Health)</span>
                    </label>
                </div>
            </div>

            <!-- Associated Categories (Routine Checkups) -->
            <div class="md:col-span-2 bg-slate-50 rounded-xl p-4 border border-gray-200">
                <label class="block text-sm font-bold text-gray-800 mb-1">
                    <i class="fas fa-tags text-indigo-600 mr-1"></i> Associated Checkup Categories (Multi-Select)
                </label>
                <p class="text-xs text-gray-500 mb-3">Tag this package under multiple checkup categories:</p>

                @php
                    $selectedCats = old('category_ids', $package->category_ids ?? []);
                @endphp

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 max-h-48 overflow-y-auto p-1">
                    @forelse($categories ?? [] as $cat)
                        <label class="flex items-center space-x-2 bg-white p-2 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-50 transition">
                            <input type="checkbox" name="category_ids[]" value="{{ $cat->id }}" {{ in_array($cat->id, $selectedCats) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="text-xs text-gray-700 truncate" title="{{ $cat->name }}">{{ $cat->name }}</span>
                        </label>
                    @empty
                        <span class="text-xs text-gray-400 col-span-4">No categories created yet.</span>
                    @endforelse
                </div>
            </div>

            <!-- Legacy Type and Subcategory -->
            <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 rounded-xl p-4 border border-gray-200">
                <!-- Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Primary Classification</label>
                    <select name="type" id="package_type" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-2 border bg-white">
                        <option value="general" {{ old('type', $package->type ?? 'general') == 'general' ? 'selected' : '' }}>Standard Package (General)</option>
                        <option value="habit" {{ old('type', $package->type ?? '') == 'habit' ? 'selected' : '' }}>Unhealthy Habit Package</option>
                        <option value="femcliffe" {{ old('type', $package->type ?? '') == 'femcliffe' ? 'selected' : '' }}>Femcliffe (Women's Health)</option>
                    </select>
                    @error('type')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                
                <!-- Subcategory -->
                <div id="subcategory_container" class="{{ old('type', $package->type ?? 'general') == 'general' ? 'hidden' : '' }}">
                    <label class="block text-sm font-medium text-gray-700 mb-2" id="subcategory_label">Habit / Sub Category</label>
                    <select name="subcategory" id="package_subcategory" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-2 border bg-white">
                        <option value="">Select Category...</option>
                    </select>
                    @error('subcategory')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    
                    <!-- Store the old value so we can set it via JS on load -->
                    <input type="hidden" id="old_subcategory" value="{{ old('subcategory', $package->subcategory ?? '') }}">
                </div>
            </div>
            
            <!-- Commercial Pricing & Offers Box -->
            <div class="md:col-span-2 p-5 rounded-2xl bg-gradient-to-br from-indigo-50/60 to-purple-50/40 border border-indigo-100 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-indigo-200/50 pb-3">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-indigo-900 flex items-center gap-2">
                        <i class="fas fa-tag text-indigo-600"></i> Website Commercial & Offer Pricing
                    </h3>
                    @if(config('pathology.admin_sync_enabled', false) && isset($package) && $package->lis_price)
                        <span class="text-[11px] font-semibold text-slate-500 bg-white/80 px-2.5 py-1 rounded-md border border-slate-200">
                            LIS Base Cost: <strong class="text-slate-800">₹{{ number_format($package->lis_price, 2) }}</strong>
                        </span>
                    @endif
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <!-- Market MRP -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                            Market MRP (Strike-through ~₹~)
                        </label>
                        <input type="number" step="0.01" name="original_price" id="pkg_original_price" value="{{ old('original_price', $package->original_price ?? '') }}" placeholder="e.g., 2999" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-2 border bg-white">
                        <p class="text-[11px] text-gray-400 mt-1">Crossed-out price on website card.</p>
                    </div>

                    <!-- Selling Price -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                            Website Selling Price (₹) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" step="0.01" name="price" id="pkg_selling_price" value="{{ old('price', $package->price ?? '') }}" required placeholder="e.g., 1499" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-2 border bg-white font-bold text-indigo-700">
                        @error('price')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Discount Percentage Badge -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                            Offer Badge / Discount %
                        </label>
                        <input type="number" name="discount_percentage" id="pkg_discount_percentage" value="{{ old('discount_percentage', $package->discount_percentage ?? '') }}" placeholder="e.g., 50" min="0" max="100" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-2 border bg-white">
                        <p class="text-[11px] text-gray-400 mt-1">Leave empty to auto-calculate from MRP & Selling Price.</p>
                    </div>
                </div>

                @if(config('pathology.admin_sync_enabled', false))
                <!-- Price Lock Protection Toggle -->
                <div class="pt-2 flex items-center justify-between border-t border-indigo-200/40">
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="lock_pricing" value="1" {{ old('lock_pricing', $package->lock_pricing ?? false) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-xs font-bold text-indigo-950">Lock Custom Price (Protect from LIS auto-sync overwrites)</span>
                    </label>
                </div>
                @endif
            </div>

            <!-- Package Specifications Box -->
            <div class="md:col-span-2 p-5 rounded-2xl bg-slate-50 border border-slate-200 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                        <i class="fas fa-microscope text-indigo-600"></i> {{ config('pathology.admin_sync_enabled', false) ? 'LIS Specifications & Sample Info' : 'Sample & Package Specifications' }}
                    </h3>
                    @if(config('pathology.admin_sync_enabled', false) && isset($package) && $package->lis_synced_at)
                        <span class="text-[10px] text-slate-400">Synced: {{ $package->lis_synced_at->format('d M Y, h:i A') }}</span>
                    @endif
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <!-- Package Code -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">{{ config('pathology.admin_sync_enabled', false) ? 'LIS Package Code' : 'Package Code' }}</label>
                        <input type="text" name="package_code" placeholder="e.g., EXEC-FULL" value="{{ old('package_code', $package->package_code ?? '') }}" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-2 border bg-white font-mono uppercase">
                    </div>

                    <!-- Sample Type -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Sample Type</label>
                        <input type="text" name="sample_type" placeholder="e.g., Blood & Urine" value="{{ old('sample_type', $package->sample_type ?? '') }}" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-2 border bg-white">
                    </div>

                    <!-- Turnaround Time Hours -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">TAT (Hours)</label>
                        <input type="number" name="tat_hours" placeholder="e.g., 24" value="{{ old('tat_hours', $package->tat_hours ?? '') }}" min="1" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-2 border bg-white">
                    </div>
                </div>
            </div>

            <!-- Total Parameters Count -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Total Clinical Parameters (e.g. 78, 85, 95)</label>
                <input type="number" name="total_parameters" value="{{ old('total_parameters', $package->total_parameters ?? $package->total_parameters_count ?? '') }}" placeholder="e.g. 78 (Leave blank to auto-calculate)" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-2 border bg-gray-50">
                <p class="text-[11px] text-gray-400 mt-1">Leave empty to auto-sum all biomarkers from selected departments.</p>
                @error('total_parameters')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            
            <!-- Image -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Image</label>
                <input type="file" name="image" accept="image/*" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-1.5 border bg-gray-50 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                @if(isset($package) && $package->image)
                    <div class="mt-2">
                        <img src="{{ Storage::url($package->image) }}" class="h-20 rounded-md shadow-sm border border-gray-200">
                    </div>
                @endif
                @error('image')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Description -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" rows="3" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-2 border bg-gray-50" placeholder="Brief description about this package...">{{ old('description', $package->description ?? '') }}</textarea>
                @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- ══ Package Tests Builder ══ -->
            <div class="md:col-span-2 p-5 rounded-2xl bg-teal-50/40 border border-teal-100 shadow-sm space-y-4">
                <div class="flex items-start justify-between border-b border-teal-200/50 pb-3 flex-wrap gap-2">
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-teal-900 flex items-center gap-2">
                            <i class="fas fa-boxes-stacked text-teal-600"></i> Tests Included in this Package
                        </h3>
                        <p class="text-[11px] text-teal-700 mt-0.5">
                            Select which tests are part of this package. Their parameters (Hemoglobin, Cholesterol etc.) will auto-populate for customers.
                        </p>
                    </div>
                    <span id="selectedTestCount" class="text-xs font-bold text-teal-700 bg-white px-2.5 py-1 rounded-full border border-teal-200">
                        0 Tests Selected
                    </span>
                </div>

                @php
                    // Existing package parameters are "TestName: ParamName" or "TestName"
                    // Extract selected test names from the stored parameters
                    $existingParams = old('parameters', $package->parameters ?? []);
                    $preSelectedTests = [];
                    foreach ($existingParams as $entry) {
                        if (str_contains($entry, ':')) {
                            $testName = trim(explode(':', $entry, 2)[0]);
                        } else {
                            $testName = trim($entry);
                        }
                        if (!empty($testName)) {
                            $preSelectedTests[$testName] = true;
                        }
                    }
                @endphp

                <!-- Hidden inputs will be generated by JS on form submit -->
                <div id="packageParamsHiddenContainer"></div>

                <!-- Search filter -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i class="fas fa-search text-xs"></i>
                    </div>
                    <input type="text" id="testSearchInput" placeholder="Search tests by name or code..."
                        class="w-full pl-9 pr-4 py-2 text-sm rounded-xl bg-white border border-teal-200 focus:outline-none focus:ring-2 focus:ring-teal-400 transition">
                </div>

                <!-- Tests list -->
                <div class="max-h-72 overflow-y-auto space-y-1.5 pr-1" id="testCheckboxList">
                    @foreach($tests as $t)
                    @php
                        $testParamNames = is_array($t->parameters) ? array_filter($t->parameters) : [];
                        $isSelected = isset($preSelectedTests[$t->name]);
                    @endphp
                    <label
                        class="test-checkbox-row flex items-start gap-3 p-3 rounded-xl cursor-pointer border transition-all {{ $isSelected ? 'bg-teal-50 border-teal-300' : 'bg-white border-gray-200 hover:bg-teal-50/50 hover:border-teal-200' }}"
                        data-test-name="{{ $t->name }}"
                        data-test-code="{{ $t->test_code ?? '' }}"
                        data-test-dept="{{ $t->category->name ?? 'Uncategorized' }}"
                        data-test-params="{{ implode('|', $testParamNames) }}"
                    >
                        <input type="checkbox" class="test-include-check mt-0.5 rounded border-gray-300 text-teal-600 focus:ring-teal-500"
                            value="{{ $t->name }}"
                            {{ $isSelected ? 'checked' : '' }}>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="text-sm font-semibold text-gray-800 truncate">{{ $t->name }}</span>
                                @if($t->test_code)
                                    <span class="font-mono text-[10px] bg-slate-100 text-slate-600 px-1.5 py-0.5 rounded border">{{ $t->test_code }}</span>
                                @endif
                                <span class="text-[10px] text-gray-400">{{ $t->category->name ?? 'Uncategorized' }}</span>
                            </div>
                            @if(count($testParamNames) > 0)
                                <p class="text-[10px] text-teal-700 mt-0.5">
                                    {{ count($testParamNames) }} param{{ count($testParamNames) > 1 ? 's' : '' }}:
                                    {{ implode(', ', array_slice($testParamNames, 0, 4)) }}{{ count($testParamNames) > 4 ? '...' : '' }}
                                </p>
                            @else
                                <p class="text-[10px] text-gray-400 mt-0.5">Single-marker test</p>
                            @endif
                        </div>
                    </label>
                    @endforeach
                </div>

                <p class="text-[11px] text-teal-600">
                    <i class="fas fa-info-circle"></i>
                    Parameters are automatically built from each selected test's biomarker list{{ config('pathology.admin_sync_enabled', false) ? ' (synced from LIS)' : '' }}.
                </p>
            </div>

            
            <!-- Toggles -->
            <div class="md:col-span-2 bg-gray-50 rounded-xl p-4 border border-gray-200 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <label class="relative inline-flex items-center cursor-pointer select-none">
                    <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', isset($package) ? $package->is_active : true) ? 'checked' : '' }}>
                    <div class="relative w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                    <span class="ms-3 text-sm font-medium text-gray-700">Active (Visible)</span>
                </label>
                
                <label class="relative inline-flex items-center cursor-pointer select-none">
                    <input type="checkbox" name="is_featured" value="1" class="sr-only peer" {{ old('is_featured', $package->is_featured ?? false) ? 'checked' : '' }}>
                    <div class="relative w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-amber-300 rounded-full peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500"></div>
                    <span class="ms-3 text-sm font-medium text-gray-700">Featured Package</span>
                </label>
            </div>
        </div>
        
        <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
            <a href="{{ route('admin.packages.index') }}" class="px-6 py-2.5 border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">Cancel</a>
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-bold transition-colors shadow-sm">
                {{ isset($package) ? 'Update Package' : 'Save Package' }}
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Package Type & Subcategory Logic ---
        const typeSelect = document.getElementById('package_type');
        const subcategoryContainer = document.getElementById('subcategory_container');
        const subcategoryLabel = document.getElementById('subcategory_label');
        const subcategorySelect = document.getElementById('package_subcategory');
        const oldSubcategory = document.getElementById('old_subcategory').value;

        const habitOptions = [
            'Junk Food', 'Sedentary Lifestyle', 'Smoking', 'Alcohol', 'Stress', 'Anger', 'Sleepless'
        ];
        
        const femcliffeOptions = [
            'Pregnancy', 'Wellness', 'PCOS/PCOD', 'Sexual Health', 'Menstrual Health', 'Cancer'
        ];

        function updateSubcategory() {
            const type = typeSelect.value;
            subcategorySelect.innerHTML = '<option value="">Select Category...</option>';
            
            if (type === 'general') {
                subcategoryContainer.classList.add('hidden');
                subcategorySelect.removeAttribute('required');
                return;
            }

            subcategoryContainer.classList.remove('hidden');
            subcategorySelect.setAttribute('required', 'required');

            let options = [];
            if (type === 'habit') {
                subcategoryLabel.textContent = 'Habit Category';
                options = habitOptions;
            } else if (type === 'femcliffe') {
                subcategoryLabel.textContent = 'Femcliffe Category';
                options = femcliffeOptions;
            }

            options.forEach(opt => {
                const optionElement = document.createElement('option');
                optionElement.value = opt;
                optionElement.textContent = opt;
                if (opt === oldSubcategory) {
                    optionElement.selected = true;
                }
                subcategorySelect.appendChild(optionElement);
            });
        }

        typeSelect.addEventListener('change', updateSubcategory);
        updateSubcategory(); // Initial load

        // --- Package Tests Checkbox Builder ---
        const testList = document.getElementById('testCheckboxList');
        const hiddenContainer = document.getElementById('packageParamsHiddenContainer');
        const countBadge = document.getElementById('selectedTestCount');
        const searchInput = document.getElementById('testSearchInput');

        function updateSelectedCount() {
            const checked = testList.querySelectorAll('.test-include-check:checked').length;
            countBadge.textContent = checked + ' Test' + (checked !== 1 ? 's' : '') + ' Selected';
        }

        function buildHiddenInputs() {
            hiddenContainer.innerHTML = '';
            testList.querySelectorAll('.test-include-check:checked').forEach(function(cb) {
                const row = cb.closest('.test-checkbox-row');
                const testName = row.dataset.testName;
                const rawParams = row.dataset.testParams; // pipe-separated param names

                if (rawParams && rawParams.trim().length > 0) {
                    rawParams.split('|').forEach(function(paramName) {
                        paramName = paramName.trim();
                        if (paramName.length > 0) {
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'parameters[]';
                            input.value = testName + ': ' + paramName;
                            hiddenContainer.appendChild(input);
                        }
                    });
                } else {
                    // Single-marker test: just store test name
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'parameters[]';
                    input.value = testName;
                    hiddenContainer.appendChild(input);
                }
            });
        }

        testList.addEventListener('change', function(e) {
            const cb = e.target.closest('.test-include-check');
            if (!cb) return;
            const row = cb.closest('.test-checkbox-row');
            if (cb.checked) {
                row.classList.remove('bg-white', 'border-gray-200');
                row.classList.add('bg-teal-50', 'border-teal-300');
            } else {
                row.classList.remove('bg-teal-50', 'border-teal-300');
                row.classList.add('bg-white', 'border-gray-200');
            }
            updateSelectedCount();
        });

        // Build hidden inputs on form submit
        document.querySelector('form').addEventListener('submit', function () {
            buildHiddenInputs();
        });

        // Search filter
        searchInput.addEventListener('input', function () {
            const q = this.value.toLowerCase();
            testList.querySelectorAll('.test-checkbox-row').forEach(function (row) {
                const name = (row.dataset.testName + ' ' + row.dataset.testCode + ' ' + row.dataset.testDept).toLowerCase();
                row.style.display = name.includes(q) ? '' : 'none';
            });
        });

        updateSelectedCount();
    });
</script>
@endsection
