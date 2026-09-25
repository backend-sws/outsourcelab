@extends('admin.layouts.app')

@section('title', 'Edit Department')
@section('header', 'Edit Department')

@section('content')
<div class="max-w-xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center space-x-4">
        <a href="{{ route('admin.departments.index') }}" class="p-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-white/[0.05] dark:hover:bg-white/[0.1] text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-white/[0.08] transition">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">Edit Department</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Update the department name. Test parameters are managed inside each individual Test.</p>
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
                    Department Name <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                        <i class="fas fa-microscope text-sm"></i>
                    </div>
                    <input type="text" name="name" id="name" value="{{ old('name', $department->name) }}" required
                        class="w-full pl-11 pr-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                        placeholder="e.g. Biochemistry, Haematology, Serology & Immunology">
                </div>
                @error('name')
                    <p class="mt-2 text-xs text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Info note -->
            <div class="p-3.5 rounded-xl bg-blue-50 dark:bg-blue-950/30 border border-blue-200 dark:border-blue-800/40 text-xs text-blue-700 dark:text-blue-300 flex items-start gap-2">
                <i class="fas fa-lightbulb mt-0.5 flex-shrink-0 text-blue-500"></i>
                <span>
                    <strong>Note:</strong> Parameters like "Hemoglobin", "RBC Count", "Total Cholesterol" belong to individual <strong>Tests</strong>, not to Departments.
                    Go to <a href="{{ route('admin.tests.index') }}" class="underline font-semibold">Tests</a> to set parameters for each test.
                </span>
            </div>

            <!-- Submit Buttons -->
            <div class="pt-4 border-t border-slate-200 dark:border-white/[0.08] flex items-center justify-end gap-3">
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
@endsection
