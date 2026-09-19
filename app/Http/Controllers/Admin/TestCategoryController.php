<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TestCategory;
use Illuminate\Http\Request;

class TestCategoryController extends Controller
{
    public function index()
    {
        $categories = TestCategory::latest()->get();

        return view('admin.pages.test_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.pages.test_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:test_categories',
            'parameters' => 'nullable|array',
            'parameters.*' => 'nullable|string|max:255',
        ]);

        // Filter out empty parameters
        $parameters = collect($request->parameters)->filter()->values()->toArray();

        TestCategory::create([
            'name' => $request->name,
            'parameters' => $parameters,
        ]);

        return redirect()->route('admin.departments.index')->with('success', 'Test parameter created successfully.');
    }

    public function edit(TestCategory $department)
    {
        return view('admin.pages.test_categories.edit', compact('department'));
    }

    public function update(Request $request, TestCategory $department)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:test_categories,name,'.$department->id,
            'parameters' => 'nullable|array',
            'parameters.*' => 'nullable|string|max:255',
        ]);

        // Filter out empty parameters
        $parameters = collect($request->parameters)->filter()->values()->toArray();

        $department->update([
            'name' => $request->name,
            'parameters' => $parameters,
        ]);

        return redirect()->route('admin.departments.index')->with('success', 'Test parameter updated successfully.');
    }

    public function destroy(TestCategory $department)
    {
        $department->delete();

        return redirect()->route('admin.departments.index')->with('success', 'Department deleted successfully.');
    }
}
