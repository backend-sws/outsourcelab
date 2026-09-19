<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MembershipPlan;
use App\Models\PatientMembership;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MembershipController extends Controller
{
    /**
     * Display a listing of membership plans & subscription metrics.
     */
    public function index(Request $request): View
    {
        $query = MembershipPlan::withCount(['patientMemberships as active_subscribers_count' => function ($q) {
            $q->where('status', 'active')->where(function ($sq) {
                $sq->whereNull('expires_at')->orWhere('expires_at', '>', now());
            });
        }]);

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('tagline', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $plans = $query->latest()->paginate(10)->withQueryString();

        // High-level statistics
        $totalPlans = MembershipPlan::count();
        $activePlans = MembershipPlan::where('is_active', true)->count();
        $totalSubscribers = PatientMembership::where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })->count();
        $totalRevenue = PatientMembership::sum('price_paid');

        return view('admin.pages.memberships.index', compact(
            'plans',
            'totalPlans',
            'activePlans',
            'totalSubscribers',
            'totalRevenue'
        ));
    }

    /**
     * Show form for creating a new membership plan.
     */
    public function create(): View
    {
        return view('admin.pages.memberships.form');
    }

    /**
     * Store a newly created membership plan.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'duration_type' => 'required|in:months,years',
            'duration_value' => 'required|integer|min:1|max:120',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'discount_percentage' => 'required|integer|min:1|max:90',
            'family_coverage_limit' => 'required|integer|min:1|max:20',
            'theme_color' => 'required|in:gold,platinum,emerald,purple',
            'benefits_raw' => 'nullable|string',
            'free_home_collection' => 'nullable|boolean',
            'free_teleconsultation' => 'nullable|boolean',
            'priority_reports' => 'nullable|boolean',
            'is_popular' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        // Parse benefits textarea into JSON array
        $benefits = [];
        if (! empty($validated['benefits_raw'])) {
            $lines = explode("\n", str_replace("\r", '', $validated['benefits_raw']));
            foreach ($lines as $line) {
                $cleaned = trim($line);
                if (! empty($cleaned)) {
                    $benefits[] = ltrim($cleaned, '-*• ');
                }
            }
        }

        MembershipPlan::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'tagline' => $validated['tagline'] ?? null,
            'duration_type' => $validated['duration_type'],
            'duration_value' => $validated['duration_value'],
            'price' => $validated['price'],
            'original_price' => $validated['original_price'] ?? null,
            'discount_percentage' => $validated['discount_percentage'],
            'family_coverage_limit' => $validated['family_coverage_limit'],
            'theme_color' => $validated['theme_color'],
            'benefits' => $benefits,
            'free_home_collection' => $request->has('free_home_collection'),
            'free_teleconsultation' => $request->has('free_teleconsultation'),
            'priority_reports' => $request->has('priority_reports'),
            'is_popular' => $request->has('is_popular'),
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.memberships.index')
            ->with('success', 'VIP Membership Plan created successfully.');
    }

    /**
     * Show form for editing an existing membership plan.
     */
    public function edit(int $id): View
    {
        $plan = MembershipPlan::findOrFail($id);

        return view('admin.pages.memberships.form', compact('plan'));
    }

    /**
     * Update an existing membership plan.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $plan = MembershipPlan::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'duration_type' => 'required|in:months,years',
            'duration_value' => 'required|integer|min:1|max:120',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'discount_percentage' => 'required|integer|min:1|max:90',
            'family_coverage_limit' => 'required|integer|min:1|max:20',
            'theme_color' => 'required|in:gold,platinum,emerald,purple',
            'benefits_raw' => 'nullable|string',
        ]);

        $benefits = [];
        if (! empty($validated['benefits_raw'])) {
            $lines = explode("\n", str_replace("\r", '', $validated['benefits_raw']));
            foreach ($lines as $line) {
                $cleaned = trim($line);
                if (! empty($cleaned)) {
                    $benefits[] = ltrim($cleaned, '-*• ');
                }
            }
        }

        $plan->update([
            'name' => $validated['name'],
            'tagline' => $validated['tagline'] ?? null,
            'duration_type' => $validated['duration_type'],
            'duration_value' => $validated['duration_value'],
            'price' => $validated['price'],
            'original_price' => $validated['original_price'] ?? null,
            'discount_percentage' => $validated['discount_percentage'],
            'family_coverage_limit' => $validated['family_coverage_limit'],
            'theme_color' => $validated['theme_color'],
            'benefits' => $benefits,
            'free_home_collection' => $request->has('free_home_collection'),
            'free_teleconsultation' => $request->has('free_teleconsultation'),
            'priority_reports' => $request->has('priority_reports'),
            'is_popular' => $request->has('is_popular'),
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.memberships.index')
            ->with('success', 'VIP Membership Plan updated successfully.');
    }

    /**
     * Remove a membership plan.
     */
    public function destroy(int $id): RedirectResponse
    {
        $plan = MembershipPlan::findOrFail($id);
        $plan->delete();

        return redirect()->route('admin.memberships.index')
            ->with('success', 'Membership plan removed successfully.');
    }

    /**
     * Toggle membership plan active status.
     */
    public function toggle(int $id): JsonResponse|RedirectResponse
    {
        $plan = MembershipPlan::findOrFail($id);
        $plan->update(['is_active' => ! $plan->is_active]);

        if (request()->wantsJson()) {
            return response()->json(['success' => true, 'is_active' => $plan->is_active]);
        }

        return back()->with('success', 'Plan status updated.');
    }

    /**
     * Display enrolled patient subscribers.
     */
    public function subscribers(Request $request): View
    {
        $query = PatientMembership::with(['patient', 'plan', 'booking']);

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('plan_id')) {
            $query->where('membership_plan_id', $request->plan_id);
        }

        $subscribers = $query->latest('id')->paginate(15)->withQueryString();
        $plans = MembershipPlan::all();

        return view('admin.pages.memberships.subscribers', compact('subscribers', 'plans'));
    }
}
