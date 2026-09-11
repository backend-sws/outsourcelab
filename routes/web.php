<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PatientProfileController;
use App\Http\Controllers\PublicFeedbackController;

Route::get('/', function () {
    $approvedReviews = \App\Models\Review::where('status', 'Approved')->latest()->take(15)->get();
    $singleTests = \App\Models\Test::where('is_active', true)->with('category')->latest()->take(24)->get();
    $packages = \App\Models\Package::where('is_active', true)
        ->where(function($q) {
            $q->where('type', 'general')->orWhereNull('type');
        })->latest()->take(10)->get();
        
    $habitPackages = \App\Models\Package::where('is_active', true)->where('type', 'habit')->latest()->get();
    $femcliffePackages = \App\Models\Package::where('is_active', true)->where('type', 'femcliffe')->latest()->get();
    
    return view('welcome', compact('approvedReviews', 'singleTests', 'packages', 'habitPackages', 'femcliffePackages'));
})->name('home');

// Public Review and Enquiry Routes
Route::post('/reviews', [PublicFeedbackController::class, 'storeReview'])->name('reviews.store');
Route::post('/enquiries', [PublicFeedbackController::class, 'storeEnquiry'])->name('enquiries.store');

Route::get('/checkout', function () {
    $patientId = session('patient_id');
    if (!$patientId) return redirect('/');
    $patient = \App\Models\Patient::find($patientId);
    if (!$patient) return redirect('/');

    app(\App\Http\Controllers\PatientProfileController::class)->assignWelcomeCoupons($patientId);

    $myCoupons = \App\Models\PatientCoupon::with('coupon')
        ->where('patient_id', $patientId)
        ->where('is_used', false)
        ->get()
        ->filter(fn($pc) => $pc->coupon && $pc->coupon->is_active);

    $bannerCoupons = \App\Models\Coupon::where('is_active', true)
        ->where('coupon_type', 'banner')
        ->get();

    return view('checkout.index', compact('patient', 'myCoupons', 'bannerCoupons'));
})->name('checkout.index');

Route::post('/patient/login', [PatientProfileController::class, 'login'])->name('patient.login');
Route::post('/patient/register', [PatientProfileController::class, 'register'])->name('patient.register');
Route::post('/patient/forgot-password', [PatientProfileController::class, 'forgotPassword'])->name('patient.forgot_password');
Route::post('/patient/reset-password', [PatientProfileController::class, 'resetPassword'])->name('patient.reset_password');
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
Route::get('/patient/coupons', [PatientProfileController::class, 'coupons'])->name('patient.coupons');
Route::post('/patient/apply-coupon', [PatientProfileController::class, 'applyCoupon'])->name('patient.apply_coupon');
Route::get('/patient/bookings', [PatientProfileController::class, 'bookings'])->name('patient.bookings');
Route::post('/patient/bookings', [PatientProfileController::class, 'placeBooking'])->name('patient.place_booking');
Route::post('/patient/cart/sync', [PatientProfileController::class, 'syncCart'])->name('patient.cart.sync');

Route::get('/patient/logout', function () {
    session()->forget('patient_id');
    return redirect('/');
})->name('patient.logout');

Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

// Agent Portal Routes
Route::prefix('agent')->name('agent.')->group(function () {
    Route::post('/register', [\App\Http\Controllers\Agent\AgentPortalController::class, 'register'])->name('register');
    Route::post('/login', [\App\Http\Controllers\Agent\AgentPortalController::class, 'login'])->name('login');
    Route::get('/logout', [\App\Http\Controllers\Agent\AgentPortalController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', [\App\Http\Controllers\Agent\AgentPortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/progress', [\App\Http\Controllers\Agent\AgentPortalController::class, 'progress'])->name('progress');
    Route::post('/bookings/{id}/sample-status', [\App\Http\Controllers\Agent\AgentPortalController::class, 'updateSampleStatus'])->name('update_sample_status');
    Route::get('/collections', [\App\Http\Controllers\Agent\AgentPortalController::class, 'collections'])->name('collections');
    Route::post('/bookings/{id}/collect-money', [\App\Http\Controllers\Agent\AgentPortalController::class, 'collectMoney'])->name('collect_money');
});

// Super Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    
    // Auth Routes
    Route::get('/login', [\App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Admin\AuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        
        // Agents / Phlebotomists
        Route::get('/agents', [\App\Http\Controllers\Admin\AgentController::class, 'index'])->name('agents.index');
        Route::post('/agents', [\App\Http\Controllers\Admin\AgentController::class, 'store'])->name('agents.store');
        Route::post('/agents/{id}/toggle-status', [\App\Http\Controllers\Admin\AgentController::class, 'toggleStatus'])->name('agents.toggle_status');
        Route::delete('/agents/{id}', [\App\Http\Controllers\Admin\AgentController::class, 'destroy'])->name('agents.destroy');

        // Users (Registered & Logged-in Customers)
        Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
        Route::get('/users/{id}', [\App\Http\Controllers\Admin\UserController::class, 'show'])->name('users.show');
        Route::delete('/users/{id}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');

        // Bookings
        Route::get('/bookings', [\App\Http\Controllers\Admin\BookingController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/{id}', [\App\Http\Controllers\Admin\BookingController::class, 'show'])->name('bookings.show');
        Route::post('/bookings/{id}/status', [\App\Http\Controllers\Admin\BookingController::class, 'updateStatus'])->name('bookings.updateStatus');
        Route::post('/bookings/{id}/assign-agent', [\App\Http\Controllers\Admin\BookingController::class, 'assignAgent'])->name('bookings.assign_agent');
        Route::get('/bookings/{id}/print', [\App\Http\Controllers\Admin\BookingController::class, 'print'])->name('bookings.print');
        
        // Tests
        Route::resource('tests', \App\Http\Controllers\Admin\TestController::class);
        
        // Packages
        Route::resource('packages', \App\Http\Controllers\Admin\PackageController::class);
        
        // Reviews
        Route::get('/reviews', [\App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('reviews.index');
        Route::post('/reviews/{id}/approve', [\App\Http\Controllers\Admin\ReviewController::class, 'approve'])->name('reviews.approve');
        Route::post('/reviews/{id}/reject', [\App\Http\Controllers\Admin\ReviewController::class, 'reject'])->name('reviews.reject');
        
        // Enquiries
        Route::get('/enquiries', [\App\Http\Controllers\Admin\EnquiryController::class, 'index'])->name('enquiries.index');
        Route::get('/enquiries/{id}', [\App\Http\Controllers\Admin\EnquiryController::class, 'show'])->name('enquiries.show');

        // Coupons
        Route::resource('coupons', \App\Http\Controllers\Admin\CouponController::class);
        Route::post('coupons/{coupon}/toggle', [\App\Http\Controllers\Admin\CouponController::class, 'toggle'])->name('coupons.toggle');
    });
});
