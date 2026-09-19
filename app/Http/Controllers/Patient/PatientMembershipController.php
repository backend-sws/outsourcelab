<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\MembershipPlan;
use App\Models\Patient;
use App\Models\PatientMembership;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PatientMembershipController extends Controller
{
    /**
     * Display the VIP membership overview and available plans.
     */
    public function index(): View|RedirectResponse
    {
        $patientId = session('patient_id');
        if (! $patientId) {
            return redirect('/');
        }

        $profile = Patient::with(['memberships.plan'])->find($patientId);
        if (! $profile) {
            return redirect('/');
        }

        $activeMembership = $profile->activeMembership();
        $plans = MembershipPlan::where('is_active', true)->get();
        $membershipHistory = $profile->memberships()->with('plan')->latest('id')->get();

        return view('patient.pages.membership', compact(
            'profile',
            'activeMembership',
            'plans',
            'membershipHistory'
        ));
    }

    /**
     * Purchase / Activate a VIP Membership plan for the patient.
     */
    public function purchase(Request $request): RedirectResponse
    {
        $patientId = session('patient_id');
        if (! $patientId) {
            return redirect('/');
        }

        $request->validate([
            'plan_id' => 'required|exists:membership_plans,id',
        ]);

        $plan = MembershipPlan::findOrFail($request->input('plan_id'));
        $durationMonths = $plan->duration_in_months;

        // Create active membership record
        PatientMembership::create([
            'patient_id' => $patientId,
            'membership_plan_id' => $plan->id,
            'plan_name_snapshot' => $plan->name,
            'discount_percentage' => $plan->discount_percentage,
            'price_paid' => $plan->price,
            'started_at' => now(),
            'expires_at' => now()->addMonths($durationMonths),
            'status' => 'active',
        ]);

        return redirect()->route('patient.membership')
            ->with('success', "🎉 Welcome to the Club! Your {$plan->name} is now active. Enjoy flat {$plan->discount_percentage}% OFF and free home pickups!");
    }
}
