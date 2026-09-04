<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PatientProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/patient/login', [PatientProfileController::class, 'login'])->name('patient.login');
Route::get('/patient/dashboard', [PatientProfileController::class, 'dashboard'])->name('patient.dashboard');
Route::get('/patient/profile/edit', [PatientProfileController::class, 'edit'])->name('patient.profile.edit');
Route::post('/patient/profile/edit', [PatientProfileController::class, 'store'])->name('patient.profile.store');
Route::get('/patient/logout', function () {
    session()->forget('patient_id');
    return redirect('/');
})->name('patient.logout');
