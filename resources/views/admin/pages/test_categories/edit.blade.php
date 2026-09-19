@extends('admin.layouts.app')

@section('title', 'Edit Department & Parameters')
@section('header', 'Edit Department')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header Section -->
    <div class="flex items-center space-x-4">
        <a href="{{ route('admin.departments.index') }}" class="p-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-white/[0.05] dark:hover:bg-white/[0.1] text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-white/[0.08] transition">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">Edit Department</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Update diagnostic department details and clinical test parameters.</p>
        </div>
    </div>

    <!-- Form Container -->
    <div class="bg-white dark:bg-[#12142d] rounded-2xl border border-slate-200 dark:border-white/[0.08] shadow-sm p-6 sm:p-8">
        <form action="{{ route('admin.departments.update', $department->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Name Field -->
            <div>
                <label for="name" class="block text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2">
                    Department / Category Name <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                        <i class="fas fa-microscope text-sm"></i>
                    </div>
                    <input type="text" name="name" id="name" value="{{ old('name', $department->name) }}" required
                        class="w-full pl-11 pr-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                        placeholder="e.g. Hematology & Blood Tests, Cardiology, Biochemistry">
                </div>
                @error('name')
                    <p class="mt-2 text-xs text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Parameters Field (Dynamic) -->
            <div>
                <div class="flex justify-between items-center mb-2">
                    <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">
                        Clinical Test Parameters (e.g. Hemoglobin, RBC, Fasting Blood Sugar)
                    </label>
                    <button type="button" id="addParameterBtn" class="inline-flex items-center gap-1 px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 dark:bg-indigo-500/10 dark:hover:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 text-xs font-semibold rounded-lg transition">
                        <i class="fas fa-plus text-[10px]"></i>
                        <span>Add Parameter</span>
                    </button>
                </div>
                
                <div id="parametersContainer" class="space-y-3">
                    @php
                        $parameters = is_array($department->parameters) ? $department->parameters : [];
                    @endphp

                    @forelse($parameters as $param)
                    <div class="relative parameter-row flex items-center gap-2">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <i class="fas fa-vial text-xs"></i>
                            </div>
                            <input type="text" name="parameters[]" value="{{ $param }}" required
                                class="w-full pl-11 pr-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                                placeholder="Enter parameter name">
                        </div>
                        <button type="button" class="remove-parameter p-2.5 text-slate-400 hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-500/10 rounded-xl transition" style="{{ count($parameters) > 1 ? 'display: inline-flex;' : 'display: none;' }}" title="Remove Parameter">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    @empty
                    <div class="relative parameter-row flex items-center gap-2">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <i class="fas fa-vial text-xs"></i>
                            </div>
                            <input type="text" name="parameters[]" required
                                class="w-full pl-11 pr-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                                placeholder="Enter parameter name">
                        </div>
                        <button type="button" class="remove-parameter p-2.5 text-slate-400 hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-500/10 rounded-xl transition" style="display: none;" title="Remove Parameter">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    @endforelse
                </div>
                @error('parameters')
                    <p class="mt-2 text-xs text-rose-500">{{ $message }}</p>
                @enderror
                @error('parameters.*')
                    <p class="mt-2 text-xs text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="pt-6 border-t border-slate-200 dark:border-white/[0.08] flex items-center justify-end gap-3">
                <a href="{{ route('admin.departments.index') }}" class="px-5 py-2.5 text-sm font-semibold text-slate-600 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white transition">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center space-x-2 px-6 py-2.5 font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-lg shadow-indigo-500/25 transition">
                    <i class="fas fa-save mr-1"></i>
                    <span>Update Department</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('parametersContainer');
    const addBtn = document.getElementById('addParameterBtn');
    
    function updateRemoveButtons() {
        const rows = container.querySelectorAll('.parameter-row');
        rows.forEach((row) => {
            const btn = row.querySelector('.remove-parameter');
            if (rows.length > 1) {
                btn.style.display = 'inline-flex';
            } else {
                btn.style.display = 'none';
            }
        });
    }

    addBtn.addEventListener('click', function() {
        const firstRow = container.querySelector('.parameter-row');
        const newRow = firstRow.cloneNode(true);
        newRow.querySelector('input').value = '';
        container.appendChild(newRow);
        updateRemoveButtons();
    });

    container.addEventListener('click', function(e) {
        const btn = e.target.closest('.remove-parameter');
        if (btn) {
            const row = btn.closest('.parameter-row');
            if (container.querySelectorAll('.parameter-row').length > 1) {
                row.remove();
                updateRemoveButtons();
            }
        }
    });
});
</script>
@endsection
