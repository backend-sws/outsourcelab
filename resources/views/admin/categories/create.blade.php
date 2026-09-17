@extends('admin.layout.app')

@section('title', 'Create Category')
@section('header', 'Create Category')

@section('content')
<div class="space-y-6 max-w-4xl">
    <div class="flex items-center space-x-3">
        <a href="{{ route('admin.categories.index') }}" class="w-8 h-8 flex items-center justify-center rounded-xl bg-slate-100 dark:bg-white/[0.05] text-slate-500 hover:text-slate-900 dark:hover:text-white transition-colors">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Add New Category</h1>
    </div>

    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="glass-card rounded-2xl p-6 sm:p-8">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Category Name *</label>
                <input type="text" name="name" required value="{{ old('name') }}" class="w-full bg-slate-50 dark:bg-[#0a0b1c]/50 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50" placeholder="e.g. Standard Health Checkup">
                @error('name') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Sub Categories (Dynamic Text Inputs) -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Sub Categories</label>
                
                <div id="subCategoriesContainer" class="space-y-4">
                    @php
                        $oldNames = old('sub_category_name', ['']);
                    @endphp

                    @foreach($oldNames as $index => $name)
                    <div class="flex items-start space-x-3 sub-category-row bg-slate-50/50 dark:bg-white/[0.02] p-4 rounded-xl border border-slate-100 dark:border-white/[0.05]">
                        <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs text-slate-500 mb-1">Name</label>
                                <input type="text" name="sub_category_name[{{ $index }}]" value="{{ $name }}" 
                                       class="w-full bg-white dark:bg-[#0a0b1c]/50 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50" 
                                       placeholder="e.g. Men Under 19">
                            </div>
                            <div>
                                <label class="block text-xs text-slate-500 mb-1">Image</label>
                                <input type="file" name="sub_category_image[{{ $index }}]" accept="image/*" 
                                       class="block w-full text-sm text-slate-500 dark:text-slate-400
                                       file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0
                                       file:text-xs file:font-semibold
                                       file:bg-indigo-50 file:text-indigo-700 dark:file:bg-indigo-500/10 dark:file:text-indigo-400
                                       hover:file:bg-indigo-100 dark:hover:file:bg-indigo-500/20 transition-all">
                            </div>
                        </div>
                        <button type="button" class="remove-btn mt-5 w-10 h-10 flex-shrink-0 flex items-center justify-center rounded-xl bg-rose-50 text-rose-500 hover:bg-rose-100 dark:bg-rose-500/10 dark:text-rose-400 dark:hover:bg-rose-500/20 transition-colors {{ count($oldNames) === 1 ? 'hidden' : '' }}">
                            <i class="fas fa-trash-alt text-sm"></i>
                        </button>
                    </div>
                    @endforeach
                </div>
                
                <button type="button" id="addMoreBtn" class="mt-4 inline-flex items-center px-4 py-2 rounded-xl text-sm font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 dark:text-indigo-400 dark:bg-indigo-500/10 dark:hover:bg-indigo-500/20 transition-colors">
                    <i class="fas fa-plus mr-2"></i> Add More Sub Category
                </button>

                @error('sub_category_name.*') <span class="text-xs text-rose-500 mt-2 block">{{ $message }}</span> @enderror
            </div>

            <!-- Status -->
            <div class="md:col-span-2 flex items-center mt-2">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', true) ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-[#0a0b1c]/50 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-white/10 peer-checked:bg-indigo-500"></div>
                    <span class="ml-3 text-sm font-medium text-slate-700 dark:text-slate-300">Active Status</span>
                </label>
            </div>
        </div>

        <div class="mt-8 flex justify-end space-x-3 pt-6 border-t border-slate-100 dark:border-white/[0.06]">
            <a href="{{ route('admin.categories.index') }}" class="px-5 py-2.5 rounded-xl text-sm font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/[0.05] transition-colors">
                Cancel
            </a>
            <button type="submit" class="px-5 py-2.5 rounded-xl text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-500/30 transition-all">
                Save Category
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('subCategoriesContainer');
        const addBtn = document.getElementById('addMoreBtn');
        let subCatIndex = {{ max(array_keys($oldNames)) + 1 }};
        
        function updateRemoveButtons() {
            const rows = container.querySelectorAll('.sub-category-row');
            const removeBtns = container.querySelectorAll('.remove-btn');
            
            if (rows.length === 1) {
                removeBtns[0].classList.add('hidden');
            } else {
                removeBtns.forEach(btn => btn.classList.remove('hidden'));
            }
        }

        addBtn.addEventListener('click', function() {
            const newRow = document.createElement('div');
            newRow.className = 'flex items-start space-x-3 sub-category-row bg-slate-50/50 dark:bg-white/[0.02] p-4 rounded-xl border border-slate-100 dark:border-white/[0.05]';
            newRow.innerHTML = `
                <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs text-slate-500 mb-1">Name</label>
                        <input type="text" name="sub_category_name[${subCatIndex}]" 
                               class="w-full bg-white dark:bg-[#0a0b1c]/50 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50" 
                               placeholder="e.g. Men Under 19">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-500 mb-1">Image</label>
                        <input type="file" name="sub_category_image[${subCatIndex}]" accept="image/*" 
                               class="block w-full text-sm text-slate-500 dark:text-slate-400
                               file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0
                               file:text-xs file:font-semibold
                               file:bg-indigo-50 file:text-indigo-700 dark:file:bg-indigo-500/10 dark:file:text-indigo-400
                               hover:file:bg-indigo-100 dark:hover:file:bg-indigo-500/20 transition-all">
                    </div>
                </div>
                <button type="button" class="remove-btn mt-5 w-10 h-10 flex-shrink-0 flex items-center justify-center rounded-xl bg-rose-50 text-rose-500 hover:bg-rose-100 dark:bg-rose-500/10 dark:text-rose-400 dark:hover:bg-rose-500/20 transition-colors">
                    <i class="fas fa-trash-alt text-sm"></i>
                </button>
            `;
            container.appendChild(newRow);
            
            // Add event listener to the new remove button
            const removeBtn = newRow.querySelector('.remove-btn');
            removeBtn.addEventListener('click', function() {
                newRow.remove();
                updateRemoveButtons();
            });
            
            subCatIndex++;
            updateRemoveButtons();
        });

        // Add event listeners to existing remove buttons
        const existingRemoveBtns = container.querySelectorAll('.remove-btn');
        existingRemoveBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                this.closest('.sub-category-row').remove();
                updateRemoveButtons();
            });
        });
    });
</script>
@endsection
