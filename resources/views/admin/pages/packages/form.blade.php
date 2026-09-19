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
            
            <!-- Price -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Price (₹) <span class="text-red-500">*</span></label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $package->price ?? '') }}" required class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-2 border bg-gray-50">
                @error('price')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
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

            <!-- Parameters -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Package Parameters / Tests Included</label>
                <div id="parameters-container" class="space-y-3">
                    @php
                        $parameters = old('parameters', $package->parameters ?? []);
                    @endphp
                    
                    @if(!empty($parameters) && count($parameters) > 0)
                        @foreach($parameters as $index => $parameter)
                            <div class="flex items-center gap-2 parameter-row">
                                <select name="parameters[]" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-2 border bg-gray-50">
                                    <option value="">Select a Test Parameter</option>
                                    @foreach($testParameters as $tp)
                                        <option value="{{ $tp->name }}" {{ $parameter == $tp->name ? 'selected' : '' }}>{{ $tp->name }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="remove-parameter text-red-500 hover:text-red-700 p-2"><i class="fas fa-trash"></i></button>
                            </div>
                        @endforeach
                    @else
                        <div class="flex items-center gap-2 parameter-row">
                            <select name="parameters[]" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-2 border bg-gray-50">
                                <option value="">Select a Test Parameter</option>
                                @foreach($testParameters as $tp)
                                    <option value="{{ $tp->name }}">{{ $tp->name }}</option>
                                @endforeach
                            </select>
                            <button type="button" class="remove-parameter text-red-500 hover:text-red-700 p-2"><i class="fas fa-trash"></i></button>
                        </div>
                    @endif
                </div>
                <button type="button" id="add-parameter" class="mt-3 text-sm text-indigo-600 hover:text-indigo-800 font-medium flex items-center gap-1">
                    <i class="fas fa-plus-circle"></i> Add Another Parameter
                </button>
            </div>
            
            <!-- Toggles -->
            <div class="md:col-span-2 bg-gray-50 rounded-xl p-4 border border-gray-200 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" class="sr-only peer" {{ old('is_active', isset($package) ? $package->is_active : true) ? 'checked' : '' }}>
                    <div class="relative w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                    <span class="ms-3 text-sm font-medium text-gray-700">Active (Visible)</span>
                </label>
                
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_featured" class="sr-only peer" {{ old('is_featured', $package->is_featured ?? false) ? 'checked' : '' }}>
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

        // --- Parameters Logic ---
        const container = document.getElementById('parameters-container');
        const addButton = document.getElementById('add-parameter');

        // Add new parameter row
        addButton.addEventListener('click', function() {
            const firstRow = container.querySelector('.parameter-row');
            const newRow = firstRow.cloneNode(true);
            newRow.querySelector('select').value = '';
            container.appendChild(newRow);
        });

        // Remove parameter row
        container.addEventListener('click', function(e) {
            if (e.target.closest('.remove-parameter')) {
                const rows = container.querySelectorAll('.parameter-row');
                if (rows.length > 1) {
                    e.target.closest('.parameter-row').remove();
                } else {
                    // Clear the value if it's the last row instead of removing
                    e.target.closest('.parameter-row').querySelector('select').value = '';
                }
            }
        });
    });
</script>
@endsection
