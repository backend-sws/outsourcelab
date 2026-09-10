<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class PatientProfileController extends Controller
{
    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        if (!$email || !$password) {
            return response()->json(['success' => false, 'message' => 'Email and password required.']);
        }

        // Check if Admin
        if (\Illuminate\Support\Facades\Auth::attempt(['email' => $email, 'password' => $password])) {
            $request->session()->regenerate();
            return response()->json(['success' => true, 'redirect' => route('admin.dashboard')]);
        }

        // Check if Patient
        $patient = Patient::where('email', $email)->first();

        if ($patient) {
            if (Hash::check($password, $patient->password)) {
                $patient->update(['last_login_at' => now()]);
                session(['patient_id' => $patient->id]);
                $this->assignWelcomeCoupons($patient->id);
                return response()->json(['success' => true, 'redirect' => route('patient.dashboard')]);
            } else {
                return response()->json(['success' => false, 'message' => 'Invalid password.']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Account not found. Please register.']);
        }
    }

    public function register(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        
        if (!$email || !$password) {
            return response()->json(['success' => false, 'message' => 'Email and password required.']);
        }
        
        if (Patient::where('email', $email)->exists()) {
            return response()->json(['success' => false, 'message' => 'Email already registered. Please login.']);
        }
        
        $patient = Patient::create([
            'email' => $email,
            'password' => Hash::make($password),
            'last_login_at' => now(),
        ]);
        
        session(['patient_id' => $patient->id]);
        $this->assignWelcomeCoupons($patient->id);
        return response()->json(['success' => true, 'redirect' => route('patient.profile.edit')]);
    }

    public function forgotPassword(Request $request)
    {
        $email = $request->input('email');
        $patient = Patient::where('email', $email)->first();

        if (!$patient) {
            return response()->json(['success' => false, 'message' => 'Email not found.']);
        }

        $otp = rand(1000, 9999);
        $patient->otp = $otp;
        $patient->save();

        // Simulate sending email by logging it
        Log::info("OTP for password reset for {$email} is: {$otp}");

        return response()->json([
            'success' => true, 
            'message' => 'OTP sent to email.',
            'debug_otp' => $otp // Keeping this for testing as discussed
        ]);
    }

    public function resetPassword(Request $request)
    {
        $email = $request->input('email');
        $otp = $request->input('otp');
        $newPassword = $request->input('password');

        $patient = Patient::where('email', $email)->where('otp', $otp)->first();

        if (!$patient) {
            return response()->json(['success' => false, 'message' => 'Invalid OTP or email.']);
        }

        $patient->password = Hash::make($newPassword);
        $patient->otp = null;
        $patient->last_login_at = now();
        $patient->save();

        session(['patient_id' => $patient->id]);
        return response()->json(['success' => true, 'redirect' => route('patient.dashboard')]);
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

    public function familyMembers()
    {
        $patientId = session('patient_id');
        if (!$patientId) return redirect('/');
        $profile = Patient::with('familyMembers')->find($patientId);
        return view('patient.family-members', compact('profile'));
    }

    public function addFamilyMember(Request $request)
    {
        $patientId = session('patient_id');
        if (!$patientId) return response()->json(['success' => false], 401);

        $member = \App\Models\FamilyMember::create([
            'patient_id' => $patientId,
            'name' => $request->input('name'),
            'gender' => $request->input('gender'),
            'age' => $request->input('age'),
            'relation' => $request->input('relation'),
        ]);

        return response()->json(['success' => true, 'member' => $member]);
    }

    public function prescriptions()
    {
        $patientId = session('patient_id');
        if (!$patientId) return redirect('/');
        $profile = Patient::with(['familyMembers', 'prescriptions'])->find($patientId);
        return view('patient.prescriptions', compact('profile'));
    }

    public function uploadPrescription(Request $request)
    {
        $patientId = session('patient_id');
        if (!$patientId) return response()->json(['success' => false], 401);

        // Basic mock response for now
        return response()->json(['success' => true]);
    }

    public function addressBook()
    {
        $patientId = session('patient_id');
        if (!$patientId) return redirect('/');
        $profile = Patient::with('addresses')->find($patientId);
        return view('patient.address-book', compact('profile'));
    }

    public function addAddress(Request $request)
    {
        $patientId = session('patient_id');
        if (!$patientId) return response()->json(['success' => false], 401);

        $address = \App\Models\Address::create([
            'patient_id' => $patientId,
            'title' => $request->input('title'),
            'full_address' => $request->input('address'),
            'pincode' => $request->input('pincode'),
        ]);

        return response()->json(['success' => true, 'address' => $address]);
    }

    public function reports()
    {
        $patientId = session('patient_id');
        if (!$patientId) return redirect('/');
        $profile = Patient::find($patientId);
        return view('patient.reports', compact('profile'));
    }

    public function bookings()
    {
        $patientId = session('patient_id');
        if (!$patientId) return redirect('/');
        $profile = Patient::with('bookings')->find($patientId);
        return view('patient.bookings', compact('profile'));
    }

    public function coupons()
    {
        $patientId = session('patient_id');
        if (!$patientId) return redirect('/');

        $profile = Patient::find($patientId);
        if (!$profile) return redirect('/');

        $this->assignWelcomeCoupons($patientId);

        $myCoupons = \App\Models\PatientCoupon::with('coupon')
            ->where('patient_id', $patientId)
            ->latest()
            ->get();

        $publicCoupons = \App\Models\Coupon::where('is_active', true)
            ->where('coupon_type', '!=', 'welcome')
            ->latest()
            ->get();

        return view('patient.coupons', compact('profile', 'myCoupons', 'publicCoupons'));
    }

    public function assignWelcomeCoupons(int $patientId): void
    {
        $welcomeCoupons = \App\Models\Coupon::where('coupon_type', 'welcome')
            ->where('is_active', true)
            ->get();

        foreach ($welcomeCoupons as $coupon) {
            \App\Models\PatientCoupon::firstOrCreate([
                'patient_id' => $patientId,
                'coupon_id' => $coupon->id,
            ]);
        }
    }

    public function applyCoupon(Request $request)
    {
        $code = strtoupper(trim($request->input('code', '')));
        $cartTotal = (float)$request->input('cart_total', 0);
        $patientId = session('patient_id');

        if (!$code) {
            return response()->json(['success' => false, 'message' => 'Please enter a coupon code.']);
        }

        if ($cartTotal <= 0) {
            return response()->json(['success' => false, 'message' => 'Please add tests or packages to your cart first.']);
        }

        $coupon = \App\Models\Coupon::where('code', $code)->first();

        if (!$coupon || !$coupon->is_active) {
            return response()->json(['success' => false, 'message' => 'Invalid or inactive coupon code.']);
        }

        // Validity dates check
        if ($coupon->valid_from && now()->startOfDay()->lt($coupon->valid_from)) {
            return response()->json(['success' => false, 'message' => 'This coupon offer has not started yet.']);
        }
        if ($coupon->valid_until && now()->endOfDay()->gt($coupon->valid_until->endOfDay())) {
            return response()->json(['success' => false, 'message' => 'This coupon offer has expired.']);
        }

        // Welcome coupon check: user must be logged in and coupon must not have been already used
        if ($coupon->coupon_type === 'welcome') {
            if (!$patientId) {
                return response()->json(['success' => false, 'message' => 'Please login to use your welcome coupon.']);
            }
            $userCoupon = \App\Models\PatientCoupon::where('patient_id', $patientId)
                ->where('coupon_id', $coupon->id)
                ->first();

            if ($userCoupon && $userCoupon->is_used) {
                return response()->json(['success' => false, 'message' => 'You have already redeemed your welcome coupon on a previous booking.']);
            }
        }

        // Minimum order spend check (for banner/threshold coupons)
        if ($coupon->min_order_amount > 0 && $cartTotal < $coupon->min_order_amount) {
            $diff = $coupon->min_order_amount - $cartTotal;
            return response()->json([
                'success' => false,
                'message' => "This coupon requires a minimum cart amount of ₹" . number_format($coupon->min_order_amount, 2) . ". Add ₹" . number_format($diff, 2) . " more worth of tests to apply."
            ]);
        }

        // Calculate discount
        $discount = $coupon->calculateDiscount($cartTotal);
        $finalTotal = max(0, $cartTotal - $discount);

        $discountText = $coupon->discount_type === 'percentage' 
            ? "{$coupon->discount_value}% OFF (-₹" . number_format($discount, 2) . ")"
            : "₹" . number_format($discount, 2) . " Flat OFF";

        return response()->json([
            'success' => true,
            'coupon_code' => $coupon->code,
            'coupon_title' => $coupon->title,
            'discount_type' => $coupon->discount_type,
            'discount_value' => $coupon->discount_value,
            'discount_amount' => $discount,
            'final_total' => $finalTotal,
            'message' => "Success! Coupon '{$coupon->code}' applied: {$discountText} deducted."
        ]);
    }

    public function placeBooking(Request $request)
    {
        $patientId = session('patient_id');
        if (!$patientId) return response()->json(['success' => false, 'message' => 'Not logged in'], 401);

        $cartItems    = $request->input('cart', []);
        $paymentMethod = $request->input('payment_method', 'Cash');
        $collectionType = $request->input('collection_type', 'Home Collection');
        $bookingDate  = $request->input('booking_date', now()->toDateTimeString());
        $addressId    = $request->input('address_id', null);
        $familyMemberId = $request->input('family_member_id', null);
        $couponCode   = $request->input('coupon_code', null);
        $discountAmount = (float)$request->input('discount_amount', 0);

        if (empty($cartItems)) {
            return response()->json(['success' => false, 'message' => 'Cart is empty'], 400);
        }

        // Calculate total amount
        $subtotal = array_sum(array_map(fn($item) => (float)($item['price'] ?? 0), $cartItems));
        $finalAmount = max(0, $subtotal - $discountAmount);

        // Generate unique booking reference
        $ref = 'BK-' . strtoupper(substr(uniqid(), -6));

        $booking = \App\Models\Booking::create([
            'booking_reference' => $ref,
            'patient_id'        => $patientId,
            'family_member_id'  => $familyMemberId,
            'address_id'        => $addressId,
            'test_details'      => $cartItems,
            'collection_type'   => $collectionType,
            'amount'            => $finalAmount,
            'coupon_code'       => $couponCode,
            'discount_amount'   => $discountAmount,
            'payment_method'    => $paymentMethod,
            'payment_status'    => $paymentMethod === 'Cash' ? 'Pending' : 'Paid',
            'status'            => 'Booked',
            'booking_date'      => $bookingDate,
        ]);

        // If a coupon was applied, mark it as used for this patient
        if ($couponCode) {
            $coupon = \App\Models\Coupon::where('code', $couponCode)->first();
            if ($coupon) {
                $userCoupon = \App\Models\PatientCoupon::firstOrCreate([
                    'patient_id' => $patientId,
                    'coupon_id' => $coupon->id,
                ]);
                $userCoupon->update([
                    'is_used' => true,
                    'used_at' => now(),
                    'booking_id' => $booking->id,
                ]);
            }
        }

        return response()->json([
            'success'   => true,
            'booking_id' => $booking->id,
            'booking_reference' => $booking->booking_reference,
        ]);
    }
}
