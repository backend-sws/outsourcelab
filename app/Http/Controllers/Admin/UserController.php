<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::withCount(['bookings', 'familyMembers', 'addresses', 'prescriptions']);

        // Search
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%")
                    ->orWhere('alt_mobile', 'like', "%{$search}%");
            });
        }

        // Filter
        if ($request->filled('filter')) {
            if ($request->filter === 'with_bookings') {
                $query->has('bookings');
            } elseif ($request->filter === 'without_bookings') {
                $query->doesntHave('bookings');
            } elseif ($request->filter === 'recent_login') {
                $query->whereNotNull('last_login_at');
            }
        }

        // Sort
        $sort = $request->get('sort', 'latest_login');
        if ($sort === 'latest_login') {
            $query->orderByRaw('COALESCE(last_login_at, updated_at, created_at) DESC');
        } elseif ($sort === 'newest') {
            $query->latest('created_at');
        } elseif ($sort === 'oldest') {
            $query->oldest('created_at');
        } elseif ($sort === 'most_bookings') {
            $query->orderBy('bookings_count', 'desc');
        } elseif ($sort === 'name_asc') {
            $query->orderBy('name', 'asc');
        } else {
            $query->latest();
        }

        $users = $query->paginate(15)->withQueryString();

        // Top Stats
        $totalUsers = Patient::count();
        $recentLogins = Patient::where(function ($q) {
            $q->where('last_login_at', '>=', now()->subDays(7))
                ->orWhere(function ($sub) {
                    $sub->whereNull('last_login_at')
                        ->where('updated_at', '>=', now()->subDays(7));
                });
        })->count();
        $usersWithBookings = Patient::has('bookings')->count();
        $newThisMonth = Patient::where('created_at', '>=', now()->startOfMonth())->count();

        return view('admin.pages.users.index', compact('users', 'totalUsers', 'recentLogins', 'usersWithBookings', 'newThisMonth'));
    }

    public function show(Request $request, $id)
    {
        $user = Patient::with([
            'bookings' => function ($q) {
                $q->latest();
            },
            'familyMembers',
            'addresses',
            'prescriptions' => function ($q) {
                $q->latest();
            },
        ])->withCount(['bookings', 'familyMembers', 'addresses', 'prescriptions'])->findOrFail($id);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'user' => $user,
            ]);
        }

        return view('admin.pages.users.show', compact('user'));
    }

    public function destroy($id)
    {
        $user = Patient::findOrFail($id);
        $name = $user->name ?: $user->email ?: 'User #'.$user->id;
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', "User '{$name}' deleted successfully.");
    }

    /**
     * Impersonate patient/user and enter their dashboard with full administrator access.
     */
    public function impersonate($id)
    {
        $user = Patient::findOrFail($id);

        session([
            'patient_id' => $user->id,
            'impersonated_by_admin' => true,
            'impersonator_admin_id' => Auth::id(),
            'impersonator_admin_name' => Auth::user()?->name ?? 'Admin',
            'impersonated_patient_name' => $user->name ?: ($user->email ?: 'User #'.$user->id),
        ]);

        return redirect()->route('patient.dashboard')
            ->with('success', "Logged into {$user->name}'s dashboard. You have full administrator access to view, update, and manage this account.");
    }

    /**
     * Exit patient impersonation session and return to Admin Users panel.
     */
    public function leaveImpersonate()
    {
        $patientName = session('impersonated_patient_name', 'Patient');

        session()->forget([
            'patient_id',
            'impersonated_by_admin',
            'impersonator_admin_id',
            'impersonator_admin_name',
            'impersonated_patient_name',
        ]);

        if (Auth::check()) {
            return redirect()->route('admin.users.index')
                ->with('success', "Exited dashboard of {$patientName}. Successfully returned to Admin Panel.");
        }

        return redirect('/')->with('info', 'Exited patient dashboard.');
    }
}
