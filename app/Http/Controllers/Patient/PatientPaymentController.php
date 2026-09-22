<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\PaymentTransaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PatientPaymentController extends Controller
{
    /**
     * Display the authenticated patient's complete payment history.
     */
    public function index(): View|RedirectResponse
    {
        $patientId = session('patient_id');
        if (! $patientId) {
            return redirect('/');
        }

        $profile = Patient::find($patientId);
        if (! $profile) {
            return redirect('/');
        }

        $transactions = PaymentTransaction::with(['booking', 'membership'])
            ->where('patient_id', $patientId)
            ->latest('id')
            ->paginate(12);

        $totalSpent = (float) PaymentTransaction::where('patient_id', $patientId)
            ->where('status', 'captured')
            ->sum('amount');

        $paidCount = PaymentTransaction::where('patient_id', $patientId)
            ->where('status', 'captured')
            ->count();

        return view('patient.pages.transactions', compact('profile', 'transactions', 'totalSpent', 'paidCount'));
    }

    /**
     * Render an individual tax receipt / transaction invoice view.
     */
    public function receipt(int $id): View|RedirectResponse
    {
        $patientId = session('patient_id');
        if (! $patientId) {
            return redirect('/');
        }

        $transaction = PaymentTransaction::with(['patient', 'booking.address', 'membership'])
            ->where('patient_id', $patientId)
            ->findOrFail($id);

        return view('patient.pages.receipt', compact('transaction'));
    }
}
