<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PatientProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/checkout', function () {
    $patientId = session('patient_id');
    if (!$patientId) return redirect('/');
    $patient = \App\Models\Patient::find($patientId);
    return view('checkout.index', compact('patient'));
})->name('checkout.index');

Route::post('/patient/login', [PatientProfileController::class, 'login'])->name('patient.login');
Route::get('/patient/dashboard', [PatientProfileController::class, 'dashboard'])->name('patient.dashboard');
Route::get('/patient/profile/edit', [PatientProfileController::class, 'edit'])->name('patient.profile.edit');
Route::post('/patient/profile/edit', [PatientProfileController::class, 'store'])->name('patient.profile.store');

Route::get('/patient/family-members', [PatientProfileController::class, 'familyMembers'])->name('patient.family_members');
Route::post('/patient/family-members', [PatientProfileController::class, 'addFamilyMember'])->name('patient.add_family_member');

Route::get('/patient/prescriptions', [PatientProfileController::class, 'prescriptions'])->name('patient.prescriptions');
Route::post('/patient/prescriptions', [PatientProfileController::class, 'uploadPrescription'])->name('patient.upload_prescription');

Route::get('/patient/address-book', [PatientProfileController::class, 'addressBook'])->name('patient.address_book');
Route::post('/patient/address-book', [PatientProfileController::class, 'addAddress'])->name('patient.add_address');
Route::get('/patient/reports', [PatientProfileController::class, 'reports'])->name('patient.reports');
Route::get('/patient/bookings', [PatientProfileController::class, 'bookings'])->name('patient.bookings');
Route::post('/patient/bookings', [PatientProfileController::class, 'placeBooking'])->name('patient.place_booking');

Route::get('/patient/logout', function () {
    session()->forget('patient_id');
    return redirect('/');
})->name('patient.logout');
