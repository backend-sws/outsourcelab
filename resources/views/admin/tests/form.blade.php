@extends('admin.layout.app')

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
            
            <!-- Category -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                <select name="test_category_id" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-2 border bg-gray-50">
                    <option value="">None</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('test_category_id', $test->test_category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('test_category_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            
            <!-- Price -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Price (₹) <span class="text-red-500">*</span></label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $test->price ?? '') }}" required class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-2 border bg-gray-50">
                @error('price')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            
            <!-- Delivery Time -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Report Delivery Time</label>
                <input type="text" name="report_delivery_time" placeholder="e.g., 24 hours" value="{{ old('report_delivery_time', $test->report_delivery_time ?? '') }}" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-2 border bg-gray-50">
            </div>
            
            <!-- Image -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Image</label>
                <input type="file" name="image" accept="image/*" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-1.5 border bg-gray-50 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                @if(isset($test) && $test->image)
                    <div class="mt-2">
                        <img src="{{ Storage::url($test->image) }}" class="h-20 rounded-md shadow-sm border border-gray-200">
                    </div>
                @endif
                @error('image')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            
            <!-- Preparation Instructions -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Preparation Instructions</label>
                <textarea name="preparation_instructions" rows="3" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-2 border bg-gray-50">{{ old('preparation_instructions', $test->preparation_instructions ?? '') }}</textarea>
            </div>
            
            <!-- Toggles -->
            <div class="md:col-span-2 bg-gray-50 rounded-xl p-4 border border-gray-200 grid grid-cols-1 sm:grid-cols-3 gap-4">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" class="sr-only peer" {{ old('is_active', isset($test) ? $test->is_active : true) ? 'checked' : '' }}>
                    <div class="relative w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                    <span class="ms-3 text-sm font-medium text-gray-700">Active (Visible)</span>
                </label>
                
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_featured" class="sr-only peer" {{ old('is_featured', $test->is_featured ?? false) ? 'checked' : '' }}>
                    <div class="relative w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-amber-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500"></div>
                    <span class="ms-3 text-sm font-medium text-gray-700">Featured Test</span>
                </label>
                
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="home_collection_available" class="sr-only peer" {{ old('home_collection_available', $test->home_collection_available ?? false) ? 'checked' : '' }}>
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
