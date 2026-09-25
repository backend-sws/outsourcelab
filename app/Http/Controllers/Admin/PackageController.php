<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Package;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::latest()->paginate(15);

        return view('admin.pages.packages.index', compact('packages'));
    }

    public function create()
    {
        // Tests with their parameters for the package builder
        $tests = Test::where('is_active', true)->with('category')->orderBy('name')->get();
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('admin.pages.packages.form', compact('tests', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|in:general,habit,femcliffe',
            'subcategory' => 'nullable|string|max:255',
            'display_sections' => 'nullable|array',
            'display_sections.*' => 'string|in:top_booked,habit,femcliffe',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'integer|exists:categories,id',
            'price' => 'required|numeric|min:0|max:99999999',
            'original_price' => 'nullable|numeric|min:0|max:99999999',
            'discount_percentage' => 'nullable|integer|min:0|max:100',
            'package_code' => 'nullable|string|max:50',
            'sample_type' => 'nullable|string|max:100',
            'tat_hours' => 'nullable|integer|min:1',
            'total_parameters' => 'nullable|integer|min:1',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'parameters' => 'nullable|array',
            'parameters.*' => 'nullable|string',
        ]);

        if (isset($validated['parameters'])) {
            $validated['parameters'] = array_values(array_filter($validated['parameters']));
        }

        // Set default type if not provided
        $validated['type'] = $validated['type'] ?? 'general';
        $validated['display_sections'] = $request->input('display_sections', ['top_booked']);
        $validated['category_ids'] = $request->input('category_ids', []);

        $package = new Package($validated);
        $package->is_featured = $request->has('is_featured');
        $package->is_active = $request->has('is_active');
        $package->lock_pricing = $request->has('lock_pricing');

        if ($request->hasFile('image')) {
            $package->image = $request->file('image')->store('packages', 'public');
        }

        $package->save();

        return redirect()->route('admin.packages.index')->with('success', 'Package created successfully.');
    }

    public function edit(Package $package)
    {
        $tests = Test::where('is_active', true)->with('category')->orderBy('name')->get();
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('admin.pages.packages.form', compact('package', 'tests', 'categories'));
    }

    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|in:general,habit,femcliffe',
            'subcategory' => 'nullable|string|max:255',
            'display_sections' => 'nullable|array',
            'display_sections.*' => 'string|in:top_booked,habit,femcliffe',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'integer|exists:categories,id',
            'price' => 'required|numeric|min:0|max:99999999',
            'original_price' => 'nullable|numeric|min:0|max:99999999',
            'discount_percentage' => 'nullable|integer|min:0|max:100',
            'package_code' => 'nullable|string|max:50',
            'sample_type' => 'nullable|string|max:100',
            'tat_hours' => 'nullable|integer|min:1',
            'total_parameters' => 'nullable|integer|min:1',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'parameters' => 'nullable|array',
            'parameters.*' => 'nullable|string',
        ]);

        if (isset($validated['parameters'])) {
            $validated['parameters'] = array_values(array_filter($validated['parameters']));
        }

        $validated['display_sections'] = $request->input('display_sections', []);
        $validated['category_ids'] = $request->input('category_ids', []);

        $package->fill($validated);
        $package->is_featured = $request->has('is_featured');
        $package->is_active = $request->has('is_active');
        $package->lock_pricing = $request->has('lock_pricing');

        if ($request->hasFile('image')) {
            if ($package->image) {
                Storage::disk('public')->delete($package->image);
            }
            $package->image = $request->file('image')->store('packages', 'public');
        }

        $package->save();

        return redirect()->route('admin.packages.index')->with('success', 'Package updated successfully.');
    }

    public function destroy(Package $package)
    {
        if ($package->image) {
            Storage::disk('public')->delete($package->image);
        }
        $package->delete();

        return redirect()->route('admin.packages.index')->with('success', 'Package deleted successfully.');
    }
}
