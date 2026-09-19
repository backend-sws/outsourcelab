<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ContactEnquiry;
use App\Models\Package;
use App\Models\Test;
use App\Models\TestCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExploreController extends Controller
{
    /**
     * Display the Category & Subcategory Exploration page.
     */
    public function category(Request $request, int $id): View
    {
        $category = Category::where('is_active', true)->findOrFail($id);
        $allCategories = Category::where('is_active', true)->get();

        $selectedSubcategory = $request->query('subcategory');

        // Fetch packages matching this category
        $packagesQuery = Package::where('is_active', true)
            ->where(function ($q) use ($id) {
                $q->whereJsonContains('category_ids', $id)
                    ->orWhereJsonContains('category_ids', (string) $id);
            });

        if ($selectedSubcategory) {
            $packagesQuery->where('subcategory', $selectedSubcategory);
        }

        $packages = $packagesQuery->latest()->get();

        // If subcategory filter yielded no packages, fall back to all category packages
        if ($packages->isEmpty() && $selectedSubcategory) {
            $packages = Package::where('is_active', true)
                ->where(function ($q) use ($id) {
                    $q->whereJsonContains('category_ids', $id)
                        ->orWhereJsonContains('category_ids', (string) $id);
                })->latest()->get();
        }

        // Fetch related single tests
        $singleTests = Test::where('is_active', true)
            ->with('category')
            ->latest()
            ->take(12)
            ->get();

        $departments = TestCategory::all();

        return view('frontend.pages.category', compact(
            'category',
            'allCategories',
            'packages',
            'singleTests',
            'departments',
            'selectedSubcategory'
        ));
    }

    /**
     * Display a standalone, SEO-rich Health Package Details page.
     */
    public function package(int $id): View
    {
        $package = Package::where('is_active', true)->findOrFail($id);

        $groupedParameters = $package->getGroupedParameters();
        $relatedPackages = Package::where('is_active', true)
            ->where('id', '!=', $package->id)
            ->take(3)
            ->get();

        // Comparison tiers (Basic, Advanced, Platinum)
        $comparisonPackages = Package::where('is_active', true)
            ->where(function ($q) {
                $q->where('name', 'like', '%Basic%')
                    ->orWhere('name', 'like', '%Fit India%')
                    ->orWhere('name', 'like', '%Platinum%');
            })
            ->take(3)
            ->get();

        if ($comparisonPackages->isEmpty()) {
            $comparisonPackages = Package::where('is_active', true)->take(3)->get();
        }

        return view('frontend.pages.package-details', compact(
            'package',
            'groupedParameters',
            'relatedPackages',
            'comparisonPackages'
        ));
    }

    /**
     * Display a standalone Single Lab Test Details page.
     */
    public function test(int $id): View
    {
        $test = Test::where('is_active', true)->with('category')->findOrFail($id);

        $testDepartments = $test->allCategories();

        // Find packages that include tests from this department or test name
        $includingPackages = Package::where('is_active', true)
            ->where(function ($q) use ($test, $testDepartments) {
                $deptNames = $testDepartments->pluck('name')->toArray();
                foreach ($deptNames as $name) {
                    $q->orWhereJsonContains('parameters', $name);
                }
                $q->orWhereJsonContains('parameters', $test->name);
            })
            ->take(3)
            ->get();

        if ($includingPackages->isEmpty()) {
            $includingPackages = Package::where('is_active', true)->take(3)->get();
        }

        $otherTests = Test::where('is_active', true)
            ->where('id', '!=', $test->id)
            ->take(4)
            ->get();

        return view('frontend.pages.test-details', compact(
            'test',
            'testDepartments',
            'includingPackages',
            'otherTests'
        ));
    }

    /**
     * Live search autocomplete endpoint for Header Search Input.
     */
    public function search(Request $request): JsonResponse
    {
        $q = trim((string) $request->query('q', ''));

        if (strlen($q) < 2) {
            return response()->json([
                'packages' => [],
                'tests' => [],
            ]);
        }

        $packages = Package::where('is_active', true)
            ->where(function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%")
                    ->orWhere('subcategory', 'like', "%{$q}%");
            })
            ->take(5)
            ->get(['id', 'name', 'price', 'total_parameters', 'subcategory'])
            ->map(function ($pkg) {
                return [
                    'id' => $pkg->id,
                    'name' => $pkg->name,
                    'price' => $pkg->price,
                    'total_params' => $pkg->total_parameters_count,
                    'parameters_count' => $pkg->total_parameters_count,
                    'subcategory' => $pkg->subcategory ?: 'Full Body Checkup',
                    'url' => route('package.show', $pkg->id),
                    'type' => 'package',
                ];
            });

        $tests = Test::where('is_active', true)
            ->where(function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                    ->orWhere('preparation_instructions', 'like', "%{$q}%");
            })
            ->with('category')
            ->take(6)
            ->get()
            ->map(function ($t) {
                return [
                    'id' => $t->id,
                    'name' => $t->name,
                    'price' => $t->price,
                    'department' => $t->category ? $t->category->name : 'Pathology Test',
                    'tat' => $t->report_delivery_time ?? 'Within 6 Hours',
                    'url' => route('test.show', $t->id),
                    'type' => 'test',
                ];
            });

        return response()->json([
            'packages' => $packages,
            'tests' => $tests,
        ]);
    }

    /**
     * Handle quick prescription upload & callback request.
     */
    public function uploadPrescription(Request $request): RedirectResponse
    {
        $request->validate([
            'patient_name' => 'required|string|max:100',
            'mobile_number' => 'required|string|min:10|max:15',
            'prescription_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'notes' => 'nullable|string|max:500',
        ]);

        $filePath = $request->file('prescription_file')->store('prescriptions', 'public');

        ContactEnquiry::create([
            'name' => $request->patient_name,
            'email' => 'phone:'.$request->mobile_number,
            'subject' => 'Doctor Prescription Upload - Urgent Callback',
            'message' => "Patient Mobile: {$request->mobile_number}\nPrescription Document: /storage/{$filePath}\nNotes: ".($request->notes ?? 'Patient requested phone consultation and test booking from uploaded doctor slip.'),
            'status' => 'Unread',
        ]);

        return back()->with('prescription_success', 'Prescription received successfully! Our senior medical team will call you at '.$request->mobile_number.' within 15 minutes to confirm required tests and time slot.');
    }
}
