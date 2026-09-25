<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TestCategory;
use Illuminate\Http\Request;

class TestCategoryController extends Controller
{
    public function index()
    {
        $categories = TestCategory::withCount('tests')->latest()->get();

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
        ]);

        TestCategory::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.departments.index')->with('success', 'Department created successfully.');
    }

    public function edit(TestCategory $department)
    {
        return view('admin.pages.test_categories.edit', compact('department'));
    }

    public function update(Request $request, TestCategory $department)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:test_categories,name,'.$department->id,
        ]);

        $department->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.departments.index')->with('success', 'Department updated successfully.');
    }

    public function destroy(TestCategory $department)
    {
        $department->delete();

        return redirect()->route('admin.departments.index')->with('success', 'Department deleted successfully.');
    }
}
