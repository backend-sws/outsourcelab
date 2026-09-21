<?php

use App\Http\Controllers\Admin\AgentController as AdminAgentController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EnquiryController as AdminEnquiryController;
use App\Http\Controllers\Admin\MembershipController as AdminMembershipController;
use App\Http\Controllers\Admin\PackageController as AdminPackageController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\RewardController as AdminRewardController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\TestCategoryController as AdminTestCategoryController;
use App\Http\Controllers\Admin\TestController as AdminTestController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Agent\AgentPortalController;
use App\Http\Controllers\Frontend\CalculatorController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\ExploreController;
use App\Http\Controllers\Frontend\FeedbackController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Patient\PatientAddressController;
use App\Http\Controllers\Patient\PatientAuthController;
use App\Http\Controllers\Patient\PatientBookingController;
use App\Http\Controllers\Patient\PatientCouponController;
use App\Http\Controllers\Patient\PatientFamilyController;
use App\Http\Controllers\Patient\PatientMembershipController;
use App\Http\Controllers\Patient\PatientPrescriptionController;
use App\Http\Controllers\Patient\PatientProfileController;
use App\Http\Controllers\Patient\PatientRewardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Scalable, enterprise-grade route architecture divided into clear domain groups:
| 1. Frontend: Public landing, checkout, report downloads, feedback, reviews
| 2. Patient: Authentication, medical records, family, prescriptions, bookings
| 3. Agent: Phlebotomist portal, sample collection, payment collection
| 4. Super Admin: Full administrative control panel and CMS settings
|--------------------------------------------------------------------------
*/

// =========================================================================
// 1. FRONTEND PUBLIC ROUTES (Zero Closures, Modular Controller Architecture)
// =========================================================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::get('/download-report', [PageController::class, 'downloadReport'])->name('download.report');
Route::get('/lis-login', [PageController::class, 'lisLogin'])->name('lis.login');
Route::get('/login', [PageController::class, 'loginRedirect'])->name('login');

// Corporate, Info, Legal & SEO Pages
Route::get('/about-us', [PageController::class, 'about'])->name('about');
Route::get('/our-labs', [PageController::class, 'labs'])->name('labs');
Route::get('/partner-with-us', [PageController::class, 'partner'])->name('partner');
Route::get('/franchise', [PageController::class, 'franchise'])->name('franchise');
Route::get('/faqs', [PageController::class, 'faqs'])->name('faqs');
Route::get('/careers', [PageController::class, 'careers'])->name('careers');
Route::get('/statutory-compliance', [PageController::class, 'compliance'])->name('compliance');
Route::get('/membership', [PageController::class, 'membership'])->name('membership');
Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/terms-and-conditions', [PageController::class, 'terms'])->name('terms');
Route::get('/sitemap', [PageController::class, 'sitemap'])->name('sitemap');
Route::get('/sitemap.xml', [PageController::class, 'sitemapXml'])->name('sitemap.xml');

// Product & Category Exploration Pages
Route::get('/checkups/{id}', [ExploreController::class, 'category'])->name('category.show');
Route::get('/package/{id}', [ExploreController::class, 'package'])->name('package.show');
Route::get('/test/{id}', [ExploreController::class, 'test'])->name('test.show');

// Live Autocomplete API & Quick Prescription Booking
Route::get('/api/search-catalogue', [ExploreController::class, 'search'])->name('api.search');
Route::post('/prescription-upload', [ExploreController::class, 'uploadPrescription'])->name('prescription.quick_upload');

Route::post('/reviews', [FeedbackController::class, 'storeReview'])->name('reviews.store');
Route::post('/enquiries', [FeedbackController::class, 'storeEnquiry'])->name('enquiries.store');

// Health Calculators & Self-Assessment Suite
Route::prefix('calculators')->name('calculators.')->group(function () {
    Route::get('/', [CalculatorController::class, 'index'])->name('index');
    Route::get('/bmi', [CalculatorController::class, 'bmi'])->name('bmi');
    Route::get('/cardiovascular-risk', [CalculatorController::class, 'cardiovascularRisk'])->name('cardiovascular');
    Route::get('/diabetes-risk', [CalculatorController::class, 'diabetesRisk'])->name('diabetes');
    Route::get('/vitamin-deficiency', [CalculatorController::class, 'vitaminDeficiency'])->name('vitamin');
});

// =========================================================================
// 2. PATIENT PORTAL ROUTES
// =========================================================================
Route::prefix('patient')->name('patient.')->group(function () {

    // Authentication & Password Recovery
    Route::post('/login', [PatientAuthController::class, 'login'])->name('login');
    Route::post('/register', [PatientAuthController::class, 'register'])->name('register');
    Route::post('/forgot-password', [PatientAuthController::class, 'forgotPassword'])->name('forgot_password');
    Route::post('/reset-password', [PatientAuthController::class, 'resetPassword'])->name('reset_password');
    Route::get('/logout', [PatientAuthController::class, 'logout'])->name('logout');

    // Profile & Medical Records
    Route::get('/dashboard', [PatientProfileController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile/edit', [PatientProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/edit', [PatientProfileController::class, 'store'])->name('profile.store');
    Route::get('/reports', [PatientProfileController::class, 'reports'])->name('reports');

    // Family Members
    Route::get('/family-members', [PatientFamilyController::class, 'index'])->name('family_members');
    Route::post('/family-members', [PatientFamilyController::class, 'store'])->name('add_family_member');
    Route::delete('/family-members/{id}', [PatientFamilyController::class, 'destroy'])->name('delete_family_member');

    // Prescriptions
    Route::get('/prescriptions', [PatientPrescriptionController::class, 'index'])->name('prescriptions');
    Route::post('/prescriptions', [PatientPrescriptionController::class, 'store'])->name('upload_prescription');
    Route::post('/prescriptions/upload', [PatientPrescriptionController::class, 'store'])->name('prescription.upload');

    // Saved Addresses
    Route::get('/address-book', [PatientAddressController::class, 'index'])->name('address_book');
    Route::post('/address-book', [PatientAddressController::class, 'store'])->name('add_address');
    Route::put('/address-book/{id}', [PatientAddressController::class, 'update'])->name('update_address');
    Route::delete('/address-book/{id}', [PatientAddressController::class, 'destroy'])->name('delete_address');

    // Coupons
    Route::get('/coupons', [PatientCouponController::class, 'index'])->name('coupons');
    Route::post('/apply-coupon', [PatientCouponController::class, 'applyCoupon'])->name('apply_coupon');

    // VIP Health Memberships
    Route::get('/membership', [PatientMembershipController::class, 'index'])->name('membership');
    Route::post('/membership/purchase', [PatientMembershipController::class, 'purchase'])->name('membership.purchase');

    // Health Coins & Loyalty Rewards
    Route::get('/rewards', [PatientRewardController::class, 'index'])->name('rewards');

    // Bookings & Cart Synchronization
    Route::get('/bookings', [PatientBookingController::class, 'index'])->name('bookings');
    Route::post('/bookings', [PatientBookingController::class, 'placeBooking'])->name('place_booking');
    Route::post('/cart/sync', [PatientBookingController::class, 'syncCart'])->name('cart.sync');
});

// =========================================================================
// 3. AGENT / PHLEBOTOMIST PORTAL ROUTES
// =========================================================================
Route::prefix('agent')->name('agent.')->group(function () {
    Route::get('/login', [AgentPortalController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AgentPortalController::class, 'login'])->name('login.submit');
    Route::post('/register', [AgentPortalController::class, 'register'])->name('register');
    Route::get('/logout', [AgentPortalController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [AgentPortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/progress', [AgentPortalController::class, 'progress'])->name('progress');
    Route::post('/bookings/{id}/sample-status', [AgentPortalController::class, 'updateSampleStatus'])->name('update_sample_status');
    Route::get('/collections', [AgentPortalController::class, 'collections'])->name('collections');
    Route::post('/bookings/{id}/collect-money', [AgentPortalController::class, 'collectMoney'])->name('collect_money');
});

// =========================================================================
// 4. SUPER ADMIN CONTROL PANEL ROUTES
// =========================================================================
Route::prefix('admin')->name('admin.')->group(function () {

    // Auth Routes
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::match(['get', 'post'], '/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Protected Admin Panel
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Agents / Phlebotomists
        Route::get('/agents', [AdminAgentController::class, 'index'])->name('agents.index');
        Route::post('/agents', [AdminAgentController::class, 'store'])->name('agents.store');
        Route::post('/agents/{id}/toggle-status', [AdminAgentController::class, 'toggleStatus'])->name('agents.toggle_status');
        Route::delete('/agents/{id}', [AdminAgentController::class, 'destroy'])->name('agents.destroy');

        // Registered Customers / Patients
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/{id}', [AdminUserController::class, 'show'])->name('users.show');
        Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');

        // Bookings
        Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/{id}', [AdminBookingController::class, 'show'])->name('bookings.show');
        Route::post('/bookings/{id}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.updateStatus');
        Route::post('/bookings/{id}/assign-agent', [AdminBookingController::class, 'assignAgent'])->name('bookings.assign_agent');
        Route::get('/bookings/{id}/print', [AdminBookingController::class, 'print'])->name('bookings.print');

        // Test Catalog
        Route::resource('tests', AdminTestController::class);

        // Package Catalog
        Route::resource('packages', AdminPackageController::class);

        // Customer Reviews Moderation
        Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
        Route::post('/reviews/{id}/approve', [AdminReviewController::class, 'approve'])->name('reviews.approve');
        Route::post('/reviews/{id}/reject', [AdminReviewController::class, 'reject'])->name('reviews.reject');

        // Health Checkup Categories
        Route::resource('categories', AdminCategoryController::class);

        // Departments (Test Categories)
        Route::resource('departments', AdminTestCategoryController::class)->parameters([
            'departments' => 'department',
        ]);

        // Contact Enquiries
        Route::get('/enquiries', [AdminEnquiryController::class, 'index'])->name('enquiries.index');
        Route::get('/enquiries/{id}', [AdminEnquiryController::class, 'show'])->name('enquiries.show');

        // Promo Coupons
        Route::resource('coupons', AdminCouponController::class);
        Route::post('coupons/{coupon}/toggle', [AdminCouponController::class, 'toggle'])->name('coupons.toggle');

        // VIP Memberships / Loyalty Plans
        Route::get('memberships/subscribers', [AdminMembershipController::class, 'subscribers'])->name('memberships.subscribers');
        Route::post('memberships/{membership}/toggle', [AdminMembershipController::class, 'toggle'])->name('memberships.toggle');
        Route::resource('memberships', AdminMembershipController::class);

        // Health Coins & Rewards System
        Route::get('/rewards', [AdminRewardController::class, 'index'])->name('rewards.index');
        Route::post('/rewards/settings', [AdminRewardController::class, 'updateSettings'])->name('rewards.update');
        Route::post('/rewards/adjust', [AdminRewardController::class, 'manualAdjustment'])->name('rewards.adjust');

        // Site Settings / CMS
        Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [AdminSettingController::class, 'update'])->name('settings.update');
    });
});
