<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\FamilyMember;
use App\Models\Patient;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PatientFamilyController extends Controller
{
    /**
     * Display family members associated with the patient.
     */
    public function index(): View|RedirectResponse
    {
        $patientId = session('patient_id');
        if (! $patientId) {
            return redirect('/');
        }

        $profile = Patient::with([
            'familyMembers.bookings.agent',
            'bookings.agent',
            'bookings.familyMember',
        ])->find($patientId);

        if (! $profile) {
            return redirect('/');
        }

        return view('patient.pages.family-members', compact('profile'));
    }

    /**
     * Add a new family member.
     */
    public function store(Request $request): JsonResponse
    {
        $patientId = session('patient_id');
        if (! $patientId) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|string|in:Male,Female,Other,male,female,other',
            'age' => 'required|integer|min:0|max:120',
            'relation' => 'required|string|max:50',
        ]);

        $gender = ucfirst(strtolower((string) $request->input('gender')));
        $relation = ucfirst(strtolower((string) $request->input('relation')));

        $member = FamilyMember::create([
            'patient_id' => $patientId,
            'name' => $request->input('name'),
            'gender' => $gender,
            'age' => $request->input('age'),
            'relation' => $relation,
        ]);

        return response()->json(['success' => true, 'member' => $member]);
    }

    /**
     * Remove a family member.
     */
    public function destroy(int $id): JsonResponse
    {
        $patientId = session('patient_id');
        if (! $patientId) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $member = FamilyMember::where('id', $id)->where('patient_id', $patientId)->first();
        if (! $member) {
            return response()->json(['success' => false, 'message' => 'Member not found.'], 404);
        }

        $member->delete();

        return response()->json(['success' => true, 'message' => 'Family member removed successfully.']);
    }
}
