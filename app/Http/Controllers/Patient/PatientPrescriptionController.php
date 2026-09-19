<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\FamilyMember;
use App\Models\Patient;
use App\Models\Prescription;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PatientPrescriptionController extends Controller
{
    /**
     * Display patient prescriptions.
     */
    public function index(): View|RedirectResponse
    {
        $patientId = session('patient_id');
        if (! $patientId) {
            return redirect('/');
        }

        $profile = Patient::with(['familyMembers', 'prescriptions'])->find($patientId);
        if (! $profile) {
            return redirect('/');
        }

        return view('patient.pages.prescriptions', compact('profile'));
    }

    /**
     * Upload a new prescription.
     */
    public function store(Request $request): JsonResponse
    {
        $patientId = session('patient_id');
        if (! $patientId) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'prescription_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'family_member_id' => 'nullable|integer',
        ]);

        $file = $request->file('prescription_file');
        $path = $file->store('prescriptions', 'public');

        $familyMemberId = $request->input('family_member_id');
        if ($familyMemberId && ! FamilyMember::where('id', $familyMemberId)->where('patient_id', $patientId)->exists()) {
            $familyMemberId = null;
        }

        $prescription = Prescription::create([
            'patient_id' => $patientId,
            'family_member_id' => $familyMemberId,
            'file_path' => $path,
            'original_name' => $file->getClientOriginalName(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Prescription uploaded successfully.',
            'prescription' => $prescription,
        ]);
    }
}
