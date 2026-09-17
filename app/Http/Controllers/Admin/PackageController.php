<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Package;
use Illuminate\Support\Facades\Storage;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::latest()->paginate(15);
        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        $testParameters = \App\Models\TestCategory::orderBy('name')->get();
        return view('admin.packages.form', compact('testParameters'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:general,habit,femcliffe',
            'subcategory' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0|max:99999999',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'parameters' => 'nullable|array',
            'parameters.*' => 'nullable|string',
        ]);

        if (isset($validated['parameters'])) {
            $validated['parameters'] = array_values(array_filter($validated['parameters']));
        }

        $package = new Package($validated);
        $package->is_featured = $request->has('is_featured');
        $package->is_active = $request->has('is_active');

        if ($request->hasFile('image')) {
            $package->image = $request->file('image')->store('packages', 'public');
        }

        $package->save();

        return redirect()->route('admin.packages.index')->with('success', 'Package created successfully.');
    }

    public function edit(Package $package)
    {
        $testParameters = \App\Models\TestCategory::orderBy('name')->get();
        return view('admin.packages.form', compact('package', 'testParameters'));
    }

    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:general,habit,femcliffe',
            'subcategory' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0|max:99999999',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'parameters' => 'nullable|array',
            'parameters.*' => 'nullable|string',
        ]);

        if (isset($validated['parameters'])) {
            $validated['parameters'] = array_values(array_filter($validated['parameters']));
        }

        $package->fill($validated);
        $package->is_featured = $request->has('is_featured');
        $package->is_active = $request->has('is_active');

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
