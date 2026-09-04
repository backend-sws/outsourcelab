<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;

class PatientProfileController extends Controller
{
    public function login(Request $request)
    {
        $mobile = $request->input('mobile');
        if (!$mobile) {
            return response()->json(['success' => false]);
        }

        $patient = Patient::where('mobile', $mobile)->first();

        if ($patient) {
            // Returning user
            session(['patient_id' => $patient->id]);
            return response()->json(['redirect' => route('patient.dashboard')]);
        } else {
            // New user shell
            $patient = Patient::create(['mobile' => $mobile]);
            session(['patient_id' => $patient->id]);
            return response()->json(['redirect' => route('patient.profile.edit')]);
        }
    }

    public function dashboard()
    {
        $patientId = session('patient_id');
        if (!$patientId) return redirect('/');

        $profile = Patient::find($patientId);
        if (!$profile) return redirect('/');

        return view('patient.dashboard', compact('profile'));
    }

    public function edit()
    {
        $patientId = session('patient_id');
        if (!$patientId) return redirect('/');

        $profile = Patient::find($patientId);
        if (!$profile) return redirect('/');

        return view('patient.edit-profile', compact('profile'));
    }

    public function store(Request $request)
    {
        $patientId = session('patient_id');
        if (!$patientId) return redirect('/');

        $patient = Patient::find($patientId);
        if ($patient) {
            $patient->update([
                'name' => $request->input('name'),
                'gender' => $request->input('gender'),
                'age' => $request->input('age'),
                'dob' => $request->input('dob'),
                'relation' => $request->input('relation'),
                'alt_mobile' => $request->input('alt_mobile'),
                'email' => $request->input('email')
            ]);
        }

        return redirect()->route('patient.dashboard');
    }
}
