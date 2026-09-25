<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Test;
use App\Models\TestCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function index()
    {
        $tests = Test::with('category')->latest()->paginate(15);

        return view('admin.pages.tests.index', compact('tests'));
    }

    public function create()
    {
        $categories = TestCategory::all();

        return view('admin.pages.tests.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'test_category_id' => 'nullable|exists:test_categories,id',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'integer|exists:test_categories,id',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'test_code' => 'nullable|string|max:50',
            'sample_type' => 'nullable|string|max:100',
            'tat_hours' => 'nullable|integer|min:1',
            'preparation_instructions' => 'nullable|string',
            'report_delivery_time' => 'nullable|string',
            'parameters' => 'nullable|array',
            'parameters.*' => 'nullable|string|max:255',
        ]);

        // Filter out blank parameter entries
        $validated['parameters'] = array_values(array_filter($request->input('parameters', []), fn ($p) => trim($p) !== ''));

        $categoryIds = $request->input('category_ids', []);
        if (! empty($validated['test_category_id']) && ! in_array($validated['test_category_id'], $categoryIds)) {
            $categoryIds[] = (int) $validated['test_category_id'];
        }
        $validated['category_ids'] = $categoryIds;

        $test = new Test($validated);
        $test->is_featured = $request->has('is_featured');
        $test->is_active = $request->has('is_active');
        $test->home_collection_available = $request->has('home_collection_available');
        $test->fasting_required = $request->has('fasting_required');
        $test->lock_pricing = $request->has('lock_pricing');

        $test->save();

        return redirect()->route('admin.tests.index')->with('success', 'Test created successfully.');
    }

    public function edit(Test $test)
    {
        $categories = TestCategory::all();

        return view('admin.pages.tests.form', compact('test', 'categories'));
    }

    public function update(Request $request, Test $test)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'test_category_id' => 'nullable|exists:test_categories,id',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'integer|exists:test_categories,id',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'test_code' => 'nullable|string|max:50',
            'sample_type' => 'nullable|string|max:100',
            'tat_hours' => 'nullable|integer|min:1',
            'image' => 'nullable|image|max:2048',
            'preparation_instructions' => 'nullable|string',
            'report_delivery_time' => 'nullable|string',
            'parameters' => 'nullable|array',
            'parameters.*' => 'nullable|string|max:255',
        ]);

        // Filter out blank parameter entries
        $validated['parameters'] = array_values(array_filter($request->input('parameters', []), fn ($p) => trim($p) !== ''));

        $categoryIds = $request->input('category_ids', []);
        if (! empty($validated['test_category_id']) && ! in_array($validated['test_category_id'], $categoryIds)) {
            $categoryIds[] = (int) $validated['test_category_id'];
        }
        $validated['category_ids'] = $categoryIds;

        $test->fill($validated);
        $test->is_featured = $request->has('is_featured');
        $test->is_active = $request->has('is_active');
        $test->home_collection_available = $request->has('home_collection_available');
        $test->fasting_required = $request->has('fasting_required');
        $test->lock_pricing = $request->has('lock_pricing');

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
