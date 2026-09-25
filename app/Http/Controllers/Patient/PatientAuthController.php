<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Mail\PatientRegistrationOtpMail;
use App\Models\Agent;
use App\Models\Coupon;
use App\Models\Patient;
use App\Models\PatientCoupon;
use App\Models\Setting;
use App\Services\NotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PatientAuthController extends Controller
{
    /**
     * Handle multi-guard login attempt for Admin, Agent, or Patient.
     */
    public function login(Request $request): JsonResponse
    {
        $email = $request->input('email');
        $password = $request->input('password');

        if (! $email || ! $password) {
            return response()->json(['success' => false, 'message' => 'Email and password required.']);
        }

        // Check if Admin
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $request->session()->regenerate();

            return response()->json(['success' => true, 'redirect' => route('admin.dashboard')]);
        }

        // Check if Agent / Sample Collector
        $agent = Agent::where('email', $email)->first();
        if ($agent && Hash::check($password, $agent->password)) {
            if ($agent->status !== 'active') {
                return response()->json(['success' => false, 'message' => 'Your agent account is inactive. Please contact admin.']);
            }
            $agent->update(['last_login_at' => now()]);
            session(['agent_id' => $agent->id]);

            return response()->json([
                'success' => true,
                'redirect' => route('agent.dashboard'),
                'role' => 'agent',
            ]);
        }

        // Check if Patient
        $patient = Patient::where('email', $email)->first();

        if ($patient) {
            if (Hash::check($password, $patient->password)) {
                $patient->update(['last_login_at' => now()]);
                session(['patient_id' => $patient->id]);
                $this->assignWelcomeCoupons($patient->id);
                $redirectTo = $request->input('redirect_to');

                return response()->json([
                    'success' => true,
                    'redirect' => $redirectTo ?: route('patient.dashboard'),
                    'cart' => $patient->cart ?? [],
                ]);
            } else {
                return response()->json(['success' => false, 'message' => 'Invalid password.']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Account not found. Please register.']);
        }
    }

    /**
     * Register a new patient.
     * Supports configurable Email OTP verification toggled via Admin Settings.
     */
    public function register(Request $request): JsonResponse
    {
        $name = trim((string) $request->input('name'));
        $email = strtolower(trim((string) $request->input('email')));
        $mobile = trim((string) $request->input('mobile'));
        $password = $request->input('password');

        if (! $email || ! $password) {
            return response()->json(['success' => false, 'message' => 'Email and password are required.']);
        }

        if (empty($name)) {
            $name = explode('@', $email)[0];
        }

        if (Patient::where('email', $email)->exists()) {
            return response()->json(['success' => false, 'message' => 'This email address is already registered. Please login.']);
        }

        $otpEnabled = Setting::get('patient_email_otp_enabled', '0') == '1';

        if ($otpEnabled) {
            $otp = (string) rand(100000, 999999);

            session([
                'pending_patient_registration' => [
                    'name' => $name,
                    'email' => $email,
                    'mobile' => $mobile ?: null,
                    'password' => Hash::make($password),
                    'otp' => $otp,
                    'expires_at' => now()->addMinutes(15),
                    'redirect_to' => $request->input('redirect_to'),
                ],
            ]);

            NotificationService::applyMailConfig();
            try {
                Mail::to($email)->send(new PatientRegistrationOtpMail($name, $otp));
            } catch (\Throwable $e) {
                Log::error("Failed sending patient registration OTP to {$email}: ".$e->getMessage());
            }

            Log::info("Patient registration OTP for {$email}: {$otp}");

            $isDev = config('app.debug') || Setting::get('mail_mailer', 'smtp') === 'log';

            return response()->json([
                'success' => true,
                'requires_otp' => true,
                'email' => $email,
                'message' => 'A 6-digit verification code has been sent to your email. Please verify to activate your account.',
                'debug_otp' => $isDev ? $otp : null,
            ]);
        }

        // Direct registration without OTP
        $patient = Patient::create([
            'name' => $name,
            'email' => $email,
            'mobile' => $mobile ?: null,
            'password' => Hash::make($password),
            'last_login_at' => now(),
            'cart' => [],
        ]);

        session(['patient_id' => $patient->id]);
        $this->assignWelcomeCoupons($patient->id);
        $redirectTo = $request->input('redirect_to');

        return response()->json([
            'success' => true,
            'requires_otp' => false,
            'message' => 'Registration successful! Welcome to AV Wellcare Diagnostics.',
            'redirect' => $redirectTo ?: route('patient.dashboard'),
            'cart' => [],
        ]);
    }

    /**
     * Verify patient registration email OTP and activate account.
     */
    public function verifyRegisterOtp(Request $request): JsonResponse
    {
        $otp = trim((string) $request->input('otp'));
        $pending = session('pending_patient_registration');

        if (! $pending) {
            return response()->json([
                'success' => false,
                'message' => 'Registration session expired or not found. Please register again.',
            ]);
        }

        if (now()->gt($pending['expires_at'])) {
            session()->forget('pending_patient_registration');

            return response()->json([
                'success' => false,
                'message' => 'Verification code has expired. Please register again.',
            ]);
        }

        if ($otp !== (string) $pending['otp']) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid verification code. Please check your email and try again.',
            ]);
        }

        if (Patient::where('email', $pending['email'])->exists()) {
            session()->forget('pending_patient_registration');

            return response()->json([
                'success' => false,
                'message' => 'This email is already registered. Please login.',
            ]);
        }

        $patient = Patient::create([
            'name' => $pending['name'],
            'email' => $pending['email'],
            'mobile' => $pending['mobile'] ?? null,
            'password' => $pending['password'],
            'last_login_at' => now(),
            'cart' => [],
        ]);

        session()->forget('pending_patient_registration');
        session(['patient_id' => $patient->id]);
        $this->assignWelcomeCoupons($patient->id);

        $redirectTo = $pending['redirect_to'] ?? null;

        return response()->json([
            'success' => true,
            'message' => 'Email verified successfully! Welcome to AV Wellcare Diagnostics.',
            'redirect' => $redirectTo ?: route('patient.dashboard'),
            'cart' => [],
        ]);
    }

    /**
     * Resend verification code for pending patient registration.
     */
    public function resendRegisterOtp(Request $request): JsonResponse
    {
        $pending = session('pending_patient_registration');

        if (! $pending) {
            return response()->json([
                'success' => false,
                'message' => 'Registration session expired. Please register again.',
            ]);
        }

        $newOtp = (string) rand(100000, 999999);
        $pending['otp'] = $newOtp;
        $pending['expires_at'] = now()->addMinutes(15);
        session(['pending_patient_registration' => $pending]);

        NotificationService::applyMailConfig();
        try {
            Mail::to($pending['email'])->send(new PatientRegistrationOtpMail($pending['name'], $newOtp));
        } catch (\Throwable $e) {
            Log::error("Failed resending registration OTP to {$pending['email']}: ".$e->getMessage());
        }

        Log::info("Resent patient registration OTP for {$pending['email']}: {$newOtp}");

        $isDev = config('app.debug') || Setting::get('mail_mailer', 'smtp') === 'log';

        return response()->json([
            'success' => true,
            'message' => 'A new 6-digit verification code has been sent to your email.',
            'debug_otp' => $isDev ? $newOtp : null,
        ]);
    }

    /**
     * Quick Name Update for logged-in patient (e.g. from Checkout).
     */
    public function updateName(Request $request): JsonResponse
    {
        $patientId = session('patient_id');
        if (! $patientId) {
            return response()->json(['success' => false, 'message' => 'Please login.'], 401);
        }

        $name = trim((string) $request->input('name'));
        if (empty($name) || strtolower($name) === 'self') {
            return response()->json(['success' => false, 'message' => 'Please enter a valid patient name.'], 422);
        }

        $patient = Patient::find($patientId);
        if (! $patient) {
            return response()->json(['success' => false, 'message' => 'Patient not found.'], 404);
        }

        $patient->update(['name' => $name]);

        return response()->json([
            'success' => true,
            'name' => $name,
            'message' => 'Patient name saved successfully.',
        ]);
    }

    /**
     * Send OTP for password reset.
     */
    public function forgotPassword(Request $request): JsonResponse
    {
        $email = $request->input('email');
        $patient = Patient::where('email', $email)->first();

        if (! $patient) {
            return response()->json(['success' => false, 'message' => 'Email not found.']);
        }

        $otp = rand(100000, 999999);
        $patient->otp = (string) $otp;
        $patient->otp_expires_at = now()->addMinutes(15);
        $patient->save();

        Log::info("OTP for password reset for {$email} is: {$otp}");

        return response()->json([
            'success' => true,
            'message' => 'A 6-digit OTP has been sent to your email. It expires in 15 minutes.',
        ]);
    }

    /**
     * Reset patient password with OTP.
     */
    public function resetPassword(Request $request): JsonResponse
    {
        $email = $request->input('email');
        $otp = $request->input('otp');
        $newPassword = $request->input('password');

        $patient = Patient::where('email', $email)->where('otp', $otp)->first();

        if (! $patient) {
            return response()->json(['success' => false, 'message' => 'Invalid OTP or email.']);
        }

        if ($patient->otp_expires_at && now()->gt($patient->otp_expires_at)) {
            return response()->json(['success' => false, 'message' => 'OTP has expired. Please request a new one.']);
        }

        $patient->password = Hash::make($newPassword);
        $patient->otp = null;
        $patient->otp_expires_at = null;
        $patient->last_login_at = now();
        $patient->save();

        session(['patient_id' => $patient->id]);
        $redirectTo = $request->input('redirect_to');

        return response()->json([
            'success' => true,
            'redirect' => $redirectTo ?: route('patient.dashboard'),
            'cart' => $patient->cart ?? [],
        ]);
    }

    /**
     * Logout patient.
     */
    public function logout(): RedirectResponse
    {
        session()->forget('patient_id');

        return redirect('/');
    }

    /**
     * Auto-assign welcome coupons upon registration / login.
     */
    protected function assignWelcomeCoupons(int $patientId): void
    {
        $welcomeCoupons = Coupon::where('coupon_type', 'welcome')
            ->where('is_active', true)
            ->get();

        foreach ($welcomeCoupons as $coupon) {
            PatientCoupon::firstOrCreate([
                'patient_id' => $patientId,
                'coupon_id' => $coupon->id,
            ]);
        }
    }
}
