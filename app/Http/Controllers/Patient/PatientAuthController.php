<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Coupon;
use App\Models\Patient;
use App\Models\PatientCoupon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

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
     */
    public function register(Request $request): JsonResponse
    {
        $email = $request->input('email');
        $password = $request->input('password');

        if (! $email || ! $password) {
            return response()->json(['success' => false, 'message' => 'Email and password required.']);
        }

        if (Patient::where('email', $email)->exists()) {
            return response()->json(['success' => false, 'message' => 'Email already registered. Please login.']);
        }

        $patient = Patient::create([
            'email' => $email,
            'password' => Hash::make($password),
            'last_login_at' => now(),
            'cart' => [],
        ]);

        session(['patient_id' => $patient->id]);
        $this->assignWelcomeCoupons($patient->id);
        $redirectTo = $request->input('redirect_to');

        return response()->json([
            'success' => true,
            'redirect' => $redirectTo ?: route('patient.profile.edit'),
            'cart' => [],
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
