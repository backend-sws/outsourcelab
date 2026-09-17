<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sub_category_name' => 'nullable|array',
            'sub_category_name.*' => 'nullable|string',
            'sub_category_image' => 'nullable|array',
            'sub_category_image.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'boolean',
        ]);

        $subCategories = [];
        $names = $request->input('sub_category_name', []);
        
        foreach ($names as $index => $name) {
            if (empty(trim($name))) continue;
            
            $imagePath = null;
            if ($request->hasFile("sub_category_image.$index")) {
                $imagePath = $request->file("sub_category_image.$index")->store('categories/sub', 'public');
            }
            
            $subCategories[] = [
                'name' => $name,
                'image' => $imagePath
            ];
        }

        Category::create([
            'name' => $validated['name'],
            'sub_category' => $subCategories,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sub_category_name' => 'nullable|array',
            'sub_category_name.*' => 'nullable|string',
            'sub_category_image' => 'nullable|array',
            'sub_category_image.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'sub_category_old_image' => 'nullable|array',
            'is_active' => 'boolean',
        ]);

        $subCategories = [];
        $names = $request->input('sub_category_name', []);
        $oldImages = $request->input('sub_category_old_image', []);
        
        foreach ($names as $index => $name) {
            if (empty(trim($name))) continue;
            
            $imagePath = $oldImages[$index] ?? null;
            
            if ($request->hasFile("sub_category_image.$index")) {
                // Delete old image if exists
                if ($imagePath) {
                    Storage::disk('public')->delete($imagePath);
                }
                $imagePath = $request->file("sub_category_image.$index")->store('categories/sub', 'public');
            }
            
            $subCategories[] = [
                'name' => $name,
                'image' => $imagePath
            ];
        }

        // Clean up deleted sub categories images
        $existingImages = is_array($category->sub_category) ? array_column($category->sub_category, 'image') : [];
        $keptImages = array_filter(array_column($subCategories, 'image'));
        
        $deletedImages = array_diff($existingImages, $keptImages);
        foreach ($deletedImages as $deletedImage) {
            if ($deletedImage) {
                Storage::disk('public')->delete($deletedImage);
            }
        }

        $category->update([
            'name' => $validated['name'],
            'sub_category' => $subCategories,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}
