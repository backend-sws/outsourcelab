@extends('admin.layouts.app')

@section('title', isset($test) ? 'Edit Test' : 'Add Test')
@section('header')
<div class="flex items-center">
    <a href="{{ route('admin.tests.index') }}" class="text-indigo-600 hover:text-indigo-800 mr-4">
        <i class="fas fa-arrow-left"></i>
    </a>
    {{ isset($test) ? 'Edit Test' : 'Add New Test' }}
</div>
@endsection

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-4xl mx-auto">
    <form action="{{ isset($test) ? route('admin.tests.update', $test->id) : route('admin.tests.store') }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8 space-y-6">
        @csrf
        @if(isset($test))
            @method('PUT')
        @endif
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Test Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $test->name ?? '') }}" required class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-2 border bg-gray-50">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            
            <!-- Primary Category & Multi-Category Tagging -->
            <div class="md:col-span-2 bg-slate-50 rounded-xl p-4 border border-gray-200">
                <div class="mb-3">
                    <label class="block text-sm font-bold text-gray-800 mb-1">Primary Department / Category</label>
                    <select name="test_category_id" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-2 border bg-white">
                        <option value="">Select Primary Department...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('test_category_id', $test->test_category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">
                        <i class="fas fa-tags text-indigo-600 mr-1"></i> Additional Categories (Show this test under multiple categories)
                    </label>
                    @php
                        $selectedCats = old('category_ids', $test->category_ids ?? []);
                    @endphp
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 max-h-40 overflow-y-auto mt-2 p-1">
                        @foreach($categories as $category)
                            <label class="flex items-center space-x-2 bg-white p-2 rounded-lg border border-gray-200 cursor-pointer hover:bg-indigo-50/20 transition">
                                <input type="checkbox" name="category_ids[]" value="{{ $category->id }}" {{ in_array($category->id, $selectedCats) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <span class="text-xs text-gray-700 truncate" title="{{ $category->name }}">{{ $category->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <!-- Commercial Pricing & Offers Box -->
            <div class="md:col-span-2 p-5 rounded-2xl bg-gradient-to-br from-indigo-50/60 to-purple-50/40 border border-indigo-100 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-indigo-200/50 pb-3">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-indigo-900 flex items-center gap-2">
                        <i class="fas fa-tag text-indigo-600"></i> Website Commercial & Offer Pricing
                    </h3>
                    @if(config('pathology.admin_sync_enabled', false) && isset($test) && $test->lis_price)
                        <span class="text-[11px] font-semibold text-slate-500 bg-white/80 px-2.5 py-1 rounded-md border border-slate-200">
                            LIS Base Cost: <strong class="text-slate-800">₹{{ number_format($test->lis_price, 2) }}</strong>
                        </span>
                    @endif
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Market MRP -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                            Market MRP (Strike-through ~₹~)
                        </label>
                        <input type="number" step="0.01" name="original_price" id="original_price_input" value="{{ old('original_price', $test->original_price ?? '') }}" placeholder="e.g., 600" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-2 border bg-white">
                        <p class="text-[11px] text-gray-400 mt-1">Shows as strike-through on frontend card (e.g. <span class="line-through">₹600</span>).</p>
                    </div>

                    <!-- Selling Price -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                            Website Selling Price (₹) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" step="0.01" name="price" id="selling_price_input" value="{{ old('price', $test->price ?? '') }}" required placeholder="e.g., 399" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-2 border bg-white font-bold text-indigo-700">
                        @error('price')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                @if(config('pathology.admin_sync_enabled', false))
                <!-- Price Lock Protection Toggle -->
                <div class="pt-2 flex items-center justify-between border-t border-indigo-200/40">
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="lock_pricing" value="1" {{ old('lock_pricing', $test->lock_pricing ?? false) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-xs font-bold text-indigo-950">Lock Custom Price (Protect from LIS auto-sync overwrites)</span>
                    </label>
                    <span id="discountBadgePreview" class="hidden text-xs font-bold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800"></span>
                </div>
                @else
                <div class="pt-2 flex items-center justify-end">
                    <span id="discountBadgePreview" class="hidden text-xs font-bold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800"></span>
                </div>
                @endif
            </div>

            <!-- Technical Specifications Box -->
            <div class="md:col-span-2 p-5 rounded-2xl bg-slate-50 border border-slate-200 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                        <i class="fas fa-microscope text-indigo-600"></i> Technical Specifications{{ config('pathology.admin_sync_enabled', false) ? ' & LIS Integration' : '' }}
                    </h3>
                    @if(config('pathology.admin_sync_enabled', false) && isset($test) && $test->lis_synced_at)
                        <span class="text-[10px] text-slate-400">Synced: {{ $test->lis_synced_at->format('d M Y, h:i A') }}</span>
                    @endif
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <!-- Test Code -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Test Code</label>
                        <input type="text" name="test_code" placeholder="e.g., CBC, FBS" value="{{ old('test_code', $test->test_code ?? '') }}" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-2 border bg-white font-mono uppercase">
                    </div>

                    <!-- Sample Type -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Sample Type</label>
                        <input type="text" name="sample_type" placeholder="e.g., EDTA Whole Blood, Serum" value="{{ old('sample_type', $test->sample_type ?? '') }}" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-2 border bg-white">
                    </div>

                    <!-- Turnaround Time Hours -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">TAT (Hours)</label>
                        <input type="number" name="tat_hours" placeholder="e.g., 6, 24" value="{{ old('tat_hours', $test->tat_hours ?? '') }}" min="1" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-2 border bg-white">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                    <!-- Delivery Time Text -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Display Delivery Time</label>
                        <input type="text" name="report_delivery_time" placeholder="e.g., Within 24 Hours, Same Day" value="{{ old('report_delivery_time', $test->report_delivery_time ?? '') }}" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-2 border bg-white">
                    </div>

                    <!-- Fasting Required Toggle -->
                    <div class="flex items-center pt-5">
                        <label class="inline-flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="fasting_required" value="1" {{ old('fasting_required', $test->fasting_required ?? false) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="text-xs font-bold text-slate-700">Requires Overnight Fasting (8 to 10 hrs)</span>
                        </label>
                    </div>
                </div>
            </div>
            

            <!-- Preparation Instructions -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Preparation Instructions</label>
                <textarea name="preparation_instructions" rows="3" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-2 border bg-gray-50">{{ old('preparation_instructions', $test->preparation_instructions ?? '') }}</textarea>
            </div>

            <!-- ══ Test Parameters (Sub-parameters included in this test) ══ -->
            <div class="md:col-span-2 p-5 rounded-2xl bg-teal-50/40 border border-teal-100 shadow-sm space-y-3">
                <div class="flex items-center justify-between border-b border-teal-200/50 pb-3">
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-teal-900 flex items-center gap-2">
                            <i class="fas fa-list-ul text-teal-600"></i> Test Parameters / Sub-Tests Included
                        </h3>
                        <p class="text-[11px] text-teal-700 mt-0.5">
                            Add each parameter that this test measures (e.g. CBC → Hemoglobin, RBC Count, WBC Count, Platelet Count).
                        </p>
                    </div>
                    <button type="button" id="addParamBtn"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-teal-600 hover:bg-teal-700 text-white text-xs font-semibold rounded-lg transition shadow-sm">
                        <i class="fas fa-plus text-[10px]"></i> Add Parameter
                    </button>
                </div>

                <div id="parametersContainer" class="space-y-2">
                    @php
                        $existingParams = old('parameters', $test->parameters ?? []);
                        if (empty($existingParams)) { $existingParams = ['']; }
                    @endphp
                    @foreach($existingParams as $param)
                    <div class="param-row flex items-center gap-2">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-teal-400">
                                <i class="fas fa-vial text-xs"></i>
                            </div>
                            <input type="text" name="parameters[]" value="{{ $param }}"
                                class="w-full pl-9 pr-4 py-2 rounded-xl bg-white border border-teal-200 focus:border-teal-500 focus:ring-teal-500 text-sm text-slate-900 shadow-sm transition"
                                placeholder="e.g. Hemoglobin, RBC Count, Total Cholesterol">
                        </div>
                        <button type="button"
                            class="remove-param p-2 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-lg transition {{ count($existingParams) <= 1 ? 'opacity-0 pointer-events-none' : '' }}"
                            title="Remove">
                            <i class="fas fa-times text-xs"></i>
                        </button>
                    </div>
                    @endforeach
                </div>
                <p class="text-[11px] text-teal-600">
                    <i class="fas fa-info-circle"></i>
                    Leave empty if this test has no sub-parameters (e.g. a single-marker test like Blood Sugar).
                </p>
            </div>

            
            <!-- Toggles -->
            <div class="md:col-span-2 bg-gray-50 rounded-xl p-4 border border-gray-200 grid grid-cols-1 sm:grid-cols-3 gap-4">
                <label class="relative inline-flex items-center cursor-pointer select-none">
                    <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', isset($test) ? $test->is_active : true) ? 'checked' : '' }}>
                    <div class="relative w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                    <span class="ms-3 text-sm font-medium text-gray-700">Active (Visible)</span>
                </label>
                
                <label class="relative inline-flex items-center cursor-pointer select-none">
                    <input type="checkbox" name="is_featured" value="1" class="sr-only peer" {{ old('is_featured', $test->is_featured ?? false) ? 'checked' : '' }}>
                    <div class="relative w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-amber-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500"></div>
                    <span class="ms-3 text-sm font-medium text-gray-700">Featured Test</span>
                </label>
                
                <label class="relative inline-flex items-center cursor-pointer select-none">
                    <input type="checkbox" name="home_collection_available" value="1" class="sr-only peer" {{ old('home_collection_available', $test->home_collection_available ?? false) ? 'checked' : '' }}>
                    <div class="relative w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-teal-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-teal-500"></div>
                    <span class="ms-3 text-sm font-medium text-gray-700">Home Collection</span>
                </label>
            </div>
        </div>
        
        <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
            <a href="{{ route('admin.tests.index') }}" class="px-6 py-2.5 border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">Cancel</a>
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-bold transition-colors shadow-sm">
                {{ isset($test) ? 'Update Test' : 'Save Test' }}
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('parametersContainer');
    const addBtn = document.getElementById('addParamBtn');

    function refreshRemoveButtons() {
        const rows = container.querySelectorAll('.param-row');
        rows.forEach(function (row) {
            const btn = row.querySelector('.remove-param');
            if (rows.length > 1) {
                btn.classList.remove('opacity-0', 'pointer-events-none');
            } else {
                btn.classList.add('opacity-0', 'pointer-events-none');
            }
        });
    }

    addBtn.addEventListener('click', function () {
        const template = container.querySelector('.param-row');
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
});
</script>
@endsection
