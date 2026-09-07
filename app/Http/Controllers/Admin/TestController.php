<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Test;
use App\Models\TestCategory;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function index()
    {
        $tests = Test::with('category')->latest()->paginate(15);
        return view('admin.tests.index', compact('tests'));
    }

    public function create()
    {
        $categories = TestCategory::all();
        return view('admin.tests.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'test_category_id' => 'nullable|exists:test_categories,id',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'preparation_instructions' => 'nullable|string',
            'report_delivery_time' => 'nullable|string',
        ]);

        $test = new Test($validated);
        $test->is_featured = $request->has('is_featured');
        $test->is_active = $request->has('is_active');
        $test->home_collection_available = $request->has('home_collection_available');

        if ($request->hasFile('image')) {
            $test->image = $request->file('image')->store('tests', 'public');
        }

        $test->save();

        return redirect()->route('admin.tests.index')->with('success', 'Test created successfully.');
    }

    public function edit(Test $test)
    {
        $categories = TestCategory::all();
        return view('admin.tests.form', compact('test', 'categories'));
    }

    public function update(Request $request, Test $test)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'test_category_id' => 'nullable|exists:test_categories,id',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'preparation_instructions' => 'nullable|string',
            'report_delivery_time' => 'nullable|string',
        ]);

        $test->fill($validated);
        $test->is_featured = $request->has('is_featured');
        $test->is_active = $request->has('is_active');
        $test->home_collection_available = $request->has('home_collection_available');

        if ($request->hasFile('image')) {
            if ($test->image) {
                Storage::disk('public')->delete($test->image);
            }
            $test->image = $request->file('image')->store('tests', 'public');
        }

        $test->save();

        return redirect()->route('admin.tests.index')->with('success', 'Test updated successfully.');
    }

    public function destroy(Test $test)
    {
        if ($test->image) {
            Storage::disk('public')->delete($test->image);
        }
        $test->delete();

        return redirect()->route('admin.tests.index')->with('success', 'Test deleted successfully.');
    }
}
