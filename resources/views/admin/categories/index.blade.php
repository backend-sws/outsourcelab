@extends('admin.layout.app')

@section('title', 'Manage Categories')
@section('header', 'Categories')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Categories</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Manage health test categories by gender and age group.</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center space-x-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl shadow-lg shadow-indigo-500/30 transition-colors">
            <i class="fas fa-plus"></i>
            <span>Add Category</span>
        </a>
    </div>

    <!-- Categories Table -->
    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                <thead class="text-xs uppercase bg-slate-50 dark:bg-white/[0.02] text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-white/[0.06]">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Name</th>
                        <th class="px-6 py-4 font-semibold">Sub Category</th>
                        <th class="px-6 py-4 font-semibold text-center">Status</th>
                        <th class="px-6 py-4 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-white/[0.06]">
                    @forelse($categories as $category)
                    <tr class="border-b border-slate-100 dark:border-white/[0.06] hover:bg-slate-50 dark:hover:bg-white/[0.02] transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-medium text-slate-900 dark:text-white">{{ $category->name ?? 'Unnamed' }}</span>
                        </td>
                        <td class="px-6 py-4 text-slate-500 dark:text-slate-400">
                            @if(is_array($category->sub_category) && count($category->sub_category) > 0)
                                <div class="flex flex-wrap gap-2">
                                    @foreach($category->sub_category as $sub)
                                        @php
                                            $isObj = is_array($sub);
                                            $name = $isObj ? ($sub['name'] ?? '') : $sub;
                                            $image = $isObj ? ($sub['image'] ?? null) : null;
                                        @endphp
                                        <div class="inline-flex items-center space-x-2 px-2 py-1 rounded-lg bg-slate-50 border border-slate-100 dark:bg-white/[0.02] dark:border-white/[0.05]">
                                            @if($image)
                                                <img src="{{ Storage::url($image) }}" alt="{{ $name }}" class="w-6 h-6 rounded-md object-cover">
                                            @endif
                                            <span class="text-xs font-medium text-slate-600 dark:text-slate-300">
                                                {{ $name }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-sm text-slate-400">None</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($category->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-500/10 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20">
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800 dark:bg-white/5 dark:text-slate-400 border border-slate-200 dark:border-white/10">
                                    Inactive
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="p-2 rounded-xl text-slate-400 hover:text-indigo-500 hover:bg-indigo-50 dark:hover:bg-indigo-500/10 transition-colors" title="Edit Category">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-xl text-slate-400 hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-500/10 transition-colors" title="Delete Category">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 dark:bg-white/[0.05] mb-4">
                                <i class="fas fa-tags text-2xl text-slate-400"></i>
                            </div>
                            <h3 class="text-sm font-medium text-slate-900 dark:text-white">No Categories Found</h3>
                            <p class="text-sm text-slate-500 mt-1 mb-4">You haven't created any test categories yet.</p>
                            <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center space-x-2 px-4 py-2 bg-indigo-600/10 hover:bg-indigo-600/20 text-indigo-600 dark:text-indigo-400 text-sm font-medium rounded-xl transition-colors">
                                <i class="fas fa-plus"></i>
                                <span>Create Your First Category</span>
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($categories->hasPages())
        <div class="p-4 border-t border-slate-200 dark:border-white/[0.06]">
            {{ $categories->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
