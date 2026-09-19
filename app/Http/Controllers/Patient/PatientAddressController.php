<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Patient;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PatientAddressController extends Controller
{
    /**
     * Display patient address book.
     */
    public function index(): View|RedirectResponse
    {
        $patientId = session('patient_id');
        if (! $patientId) {
            return redirect('/');
        }

        $profile = Patient::with('addresses')->find($patientId);
        if (! $profile) {
            return redirect('/');
        }

        return view('patient.pages.address-book', compact('profile'));
    }

    /**
     * Store a new delivery address.
     */
    public function store(Request $request): JsonResponse
    {
        $patientId = session('patient_id');
        if (! $patientId) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'title' => 'nullable|string|max:255',
            'address' => 'required|string|max:1000',
            'pincode' => 'required|string|max:20',
        ]);

        $title = trim((string) $request->input('title'));
        if ($title === '') {
            $title = 'Home';
        }

        $address = Address::create([
            'patient_id' => $patientId,
            'title' => $title,
            'full_address' => trim((string) $request->input('address')),
            'pincode' => trim((string) $request->input('pincode')),
        ]);

        return response()->json(['success' => true, 'address' => $address]);
    }

    /**
     * Update an existing address.
     */
    public function update(int $id, Request $request): JsonResponse
    {
        $patientId = session('patient_id');
        if (! $patientId) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $address = Address::where('id', $id)->where('patient_id', $patientId)->first();
        if (! $address) {
            return response()->json(['success' => false, 'message' => 'Address not found.'], 404);
        }

        $request->validate([
            'title' => 'nullable|string|max:255',
            'address' => 'required|string|max:1000',
            'pincode' => 'required|string|max:20',
        ]);

        $title = trim((string) $request->input('title'));
        if ($title === '') {
            $title = 'Home';
        }

        $address->update([
            'title' => $title,
            'full_address' => trim((string) $request->input('address')),
            'pincode' => trim((string) $request->input('pincode')),
        ]);

        return response()->json(['success' => true, 'address' => $address]);
    }

    /**
     * Remove an address.
     */
    public function destroy(int $id): JsonResponse
    {
        $patientId = session('patient_id');
        if (! $patientId) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $address = Address::where('id', $id)->where('patient_id', $patientId)->first();
        if (! $address) {
            return response()->json(['success' => false, 'message' => 'Address not found.'], 404);
        }

        $address->delete();

        return response()->json(['success' => true, 'message' => 'Address removed successfully.']);
    }
}
