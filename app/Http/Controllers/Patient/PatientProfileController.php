<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\NotificationLog;
use App\Models\Patient;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PatientProfileController extends Controller
{
    /**
     * Display patient profile overview.
     */
    public function dashboard(): View|RedirectResponse
    {
        $patientId = session('patient_id');
        if (! $patientId) {
            return redirect('/');
        }

        $profile = Patient::with([
            'bookings' => fn ($q) => $q->with('agent')->latest(),
            'familyMembers',
            'prescriptions',
            'addresses',
        ])->find($patientId);

        if (! $profile) {
            return redirect('/');
        }

        // Active / ongoing booking
        $activeBooking = $profile->bookings
            ->whereNotIn('status', ['Completed', 'Cancelled'])
            ->first();

        // Recent bookings
        $recentBookings = $profile->bookings->take(5);

        // Ready test reports
        $readyReports = $profile->bookings
            ->filter(fn ($b) => in_array($b->status, ['Report Ready', 'Completed']) || ! empty($b->report_file_path))
            ->take(6);

        // Notifications
        $notifications = NotificationLog::where('notifiable_type', Patient::class)
            ->where('notifiable_id', $patientId)
            ->latest()
            ->take(10)
            ->get();

        $unreadNotificationsCount = NotificationLog::where('notifiable_type', Patient::class)
            ->where('notifiable_id', $patientId)
            ->whereNull('read_at')
            ->count();

        return view('patient.pages.dashboard', compact(
            'profile',
            'activeBooking',
            'recentBookings',
            'readyReports',
            'notifications',
            'unreadNotificationsCount'
        ));
    }

    /**
     * Display edit profile form (redirects to unified dashboard view).
     */
    public function edit(): View|RedirectResponse
    {
        $patientId = session('patient_id');
        if (! $patientId) {
            return redirect('/');
        }

        return redirect()->route('patient.dashboard');
    }

    /**
     * Update patient profile information.
     */
    public function store(Request $request): RedirectResponse
    {
        $patientId = session('patient_id');
        if (! $patientId) {
            return redirect('/');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:patients,email,'.$patientId,
            'age' => 'nullable|integer|min:1|max:120',
            'gender' => 'nullable|string|in:Male,Female,Other,male,female,other',
            'dob' => 'nullable|date',
            'relation' => 'nullable|string|max:50',
            'alt_mobile' => 'nullable|string|max:20',
        ]);

        $patient = Patient::find($patientId);
        if ($patient) {
            $gender = $request->filled('gender') ? ucfirst(strtolower((string) $request->input('gender'))) : null;

            $patient->update([
                'name' => $request->input('name'),
                'gender' => $gender,
                'age' => $request->input('age'),
                'dob' => $request->input('dob'),
                'relation' => $request->input('relation'),
                'alt_mobile' => $request->input('alt_mobile'),
                'email' => $request->input('email'),
            ]);
        }

        return redirect()->route('patient.dashboard')->with('success', 'Profile updated successfully.');
    }

    /**
     * Display patient medical reports.
     */
    public function reports(): View|RedirectResponse
    {
        $patientId = session('patient_id');
        if (! $patientId) {
            return redirect('/');
        }

        $profile = Patient::with(['bookings.agent', 'bookings.familyMember', 'bookings.address'])->find($patientId);
        if (! $profile) {
            return redirect('/');
        }

        $reportBookings = $profile->bookings->filter(function ($b) {
            return ! empty($b->report_file_path) || in_array($b->status, ['Report Ready', 'Completed']);
        })->sortByDesc('booking_date');

        return view('patient.pages.reports', compact('profile', 'reportBookings'));
    }
}
