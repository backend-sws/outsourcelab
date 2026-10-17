<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CityController extends Controller
{
    /**
     * Display a listing of cities and their serviceable pincodes.
     */
    public function index(Request $request): View
    {
        $query = City::query();

        // Search by name, state, or pincode
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('state', 'like', "%{$search}%")
                    ->orWhere('pincodes', 'like', "%{$search}%");
            });
        }

        // Filter by Status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Filter by State
        if ($request->filled('state')) {
            $query->where('state', $request->state);
        }

        $cities = $query->ordered()->paginate(20)->withQueryString();

        // Header statistics
        $totalCities = City::count();
        $activeCities = City::where('is_active', true)->count();
        $inactiveCities = City::where('is_active', false)->count();
        $defaultCity = City::where('is_default', true)->first();

        // Calculate all unique pincodes covered
        $allActivePincodes = City::getAllActivePincodes();
        $totalPincodesCovered = count($allActivePincodes);

        // Distinct states list for filtering
        $statesList = City::whereNotNull('state')
            ->where('state', '!=', '')
            ->distinct()
            ->orderBy('state', 'asc')
            ->pluck('state')
            ->toArray();

        return view('admin.pages.cities.index', compact(
            'cities',
            'totalCities',
            'activeCities',
            'inactiveCities',
            'defaultCity',
            'totalPincodesCovered',
            'statesList'
        ));
    }

    /**
     * Store a newly created city.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'pincodes' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_default' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $isDefault = $request->boolean('is_default', false);

        // If this is set as default, reset other default cities
        if ($isDefault) {
            City::where('is_default', true)->update(['is_default' => false]);
        }

        // Normalize pincodes string
        $pincodesRaw = $request->input('pincodes', '');
        $pincodeParts = preg_split('/[,\r\n]+/', $pincodesRaw);
        $cleanPincodes = implode(', ', array_values(array_unique(array_filter(array_map('trim', $pincodeParts)))));

        $city = City::create([
            'name' => trim($request->name),
            'slug' => Str::slug($request->name),
            'state' => trim($request->input('state', '')) ?: null,
            'pincodes' => $cleanPincodes,
            'is_default' => $isDefault,
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => (int) ($request->sort_order ?? ((City::max('sort_order') ?? 0) + 1)),
        ]);

        return back()->with('success', "City '{$city->name}' with " . $city->pincodes_count . " pincode(s) created successfully.");
    }

    /**
     * Update the specified city.
     */
    public function update(Request $request, int|string $id): RedirectResponse
    {
        $city = City::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'pincodes' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_default' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $isDefault = $request->boolean('is_default', false);

        if ($isDefault && !$city->is_default) {
            City::where('is_default', true)->update(['is_default' => false]);
        }

        // Normalize pincodes
        $pincodesRaw = $request->input('pincodes', '');
        $pincodeParts = preg_split('/[,\r\n]+/', $pincodesRaw);
        $cleanPincodes = implode(', ', array_values(array_unique(array_filter(array_map('trim', $pincodeParts)))));

        $city->name = trim($request->name);
        $city->slug = Str::slug($request->name);
        $city->state = trim($request->input('state', '')) ?: null;
        $city->pincodes = $cleanPincodes;
        $city->is_default = $isDefault;
        $city->is_active = $request->boolean('is_active', true);
        if ($request->filled('sort_order')) {
            $city->sort_order = (int) $request->sort_order;
        }
        $city->save();

        return back()->with('success', "City '{$city->name}' updated successfully.");
    }

    /**
     * Toggle city active status.
     */
    public function toggle(Request $request, int|string $id): RedirectResponse|JsonResponse
    {
        $city = City::findOrFail($id);
        $city->is_active = !$city->is_active;
        $city->save();

        $statusStr = $city->is_active ? 'Activated' : 'Disabled';

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'is_active' => $city->is_active,
                'message' => "City '{$city->name}' is now {$statusStr}.",
            ]);
        }

        return back()->with('success', "City '{$city->name}' is now {$statusStr}.");
    }

    /**
     * Mark a city as default.
     */
    public function setDefault(int|string $id): RedirectResponse
    {
        City::where('is_default', true)->update(['is_default' => false]);

        $city = City::findOrFail($id);
        $city->is_default = true;
        $city->is_active = true; // Default city must be active
        $city->save();

        return back()->with('success', "City '{$city->name}' is now set as the default location.");
    }

    /**
     * Delete a city.
     */
    public function destroy(int|string $id): RedirectResponse
    {
        $city = City::findOrFail($id);
        $name = $city->name;
        $city->delete();

        return back()->with('success', "City '{$name}' deleted successfully.");
    }
}
