@extends('admin.layouts.app')

@section('title', 'Departments')
@section('header', 'Departments')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">Departments</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                Manage diagnostic departments that group your tests (e.g. Haematology, Biochemistry, Serology).
                <strong class="text-slate-700 dark:text-slate-200">Individual test parameters (Hemoglobin, RBC, etc.) are set inside each Test.</strong>
            </p>
        </div>
        <div>
            <a href="{{ route('admin.departments.create') }}" class="inline-flex items-center space-x-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-indigo-500/25 transition-all">
                <i class="fas fa-plus"></i>
                <span>Add Department</span>
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-700 dark:text-emerald-400 flex items-center gap-3">
            <i class="fas fa-check-circle text-lg flex-shrink-0"></i>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Info Banner: concept clarification -->
    <div class="p-4 rounded-xl bg-blue-50 dark:bg-blue-950/30 border border-blue-200 dark:border-blue-800/40 flex items-start gap-3 text-sm text-blue-800 dark:text-blue-300">
        <i class="fas fa-info-circle mt-0.5 text-blue-500 flex-shrink-0"></i>
        <div>
            <strong>How it works:</strong>
            <span class="font-normal">
                Departments are simple grouping labels. Each <strong>Test</strong> (like CBC, Lipid Profile) belongs to a Department and has its own
                parameters (Hemoglobin, RBC Count, etc.) which you can set when creating or editing a Test.
            </span>
        </div>
    </div>

    <!-- Data Table Container -->
    <div class="bg-white dark:bg-[#12142d] rounded-2xl border border-slate-200 dark:border-white/[0.08] shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-white/[0.03] text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-wider border-b border-slate-200 dark:border-white/[0.08]">
                        <th class="px-6 py-4 w-20">ID</th>
                        <th class="px-6 py-4">Department Name</th>
                        <th class="px-6 py-4 text-center">Tests Count</th>
                        <th class="px-6 py-4">Created At</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-white/[0.05] text-sm">
                    @forelse($categories as $category)
                    <tr class="hover:bg-slate-50/80 dark:hover:bg-white/[0.02] transition-colors">
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-mono font-bold bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-500/20">
                                #{{ $category->id }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-white/[0.05] text-slate-600 dark:text-slate-300 flex items-center justify-center font-bold text-sm">
                                    <i class="fas fa-flask"></i>
                                </div>
                                <span class="font-semibold text-slate-900 dark:text-white">
                                    {{ $category->name }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold {{ $category->tests_count > 0 ? 'bg-teal-50 text-teal-700 border border-teal-200 dark:bg-teal-500/10 dark:text-teal-400 dark:border-teal-500/20' : 'bg-slate-100 text-slate-500 border border-slate-200 dark:bg-white/[0.04] dark:text-slate-500 dark:border-white/[0.06]' }}">
                                <i class="fas fa-vial text-[10px]"></i>
                                {{ $category->tests_count }} {{ Str::plural('Test', $category->tests_count) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-500 dark:text-slate-400">
                            {{ $category->created_at ? $category->created_at->format('M d, Y') : 'N/A' }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('admin.departments.edit', $category->id) }}"
                                   class="p-2 text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300 bg-indigo-50 hover:bg-indigo-100 dark:bg-indigo-500/10 dark:hover:bg-indigo-500/20 rounded-lg transition-colors"
                                   title="Edit Department">
                                    <i class="fas fa-pencil-alt text-xs"></i>
                                </a>

                                <form action="{{ route('admin.departments.destroy', $category->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this department? Tests in this department will be unlinked.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="p-2 text-rose-600 hover:text-rose-700 dark:text-rose-400 dark:hover:text-rose-300 bg-rose-50 hover:bg-rose-100 dark:bg-rose-500/10 dark:hover:bg-rose-500/20 rounded-lg transition-colors"
                                            title="Delete Department">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-white/[0.04] text-slate-400 flex items-center justify-center text-xl mb-3">
                                    <i class="fas fa-microscope"></i>
                                </div>
                                <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">No departments found</span>
                                <p class="text-xs text-slate-400 mt-1">Get started by creating a diagnostic department.</p>
                                <a href="{{ route('admin.departments.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl transition">
                                    <i class="fas fa-plus mr-1.5"></i> Add First Department
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
