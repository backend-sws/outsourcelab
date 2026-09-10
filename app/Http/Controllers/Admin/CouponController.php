<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\PatientCoupon;
use App\Models\Patient;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        $query = Coupon::withCount(['patientCoupons', 'patientCoupons as used_count' => function ($q) {
            $q->where('is_used', true);
        }]);

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('coupon_type', $request->type);
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $coupons = $query->latest()->paginate(15)->withQueryString();

        // Top Stats
        $totalCoupons = Coupon::count();
        $welcomeCoupons = Coupon::where('coupon_type', 'welcome')->where('is_active', true)->count();
        $bannerCoupons = Coupon::where('is_banner', true)->where('is_active', true)->count();
        $totalUsedCoupons = PatientCoupon::where('is_used', true)->count();

        return view('admin.coupons.index', compact(
            'coupons',
            'totalCoupons',
            'welcomeCoupons',
            'bannerCoupons',
            'totalUsedCoupons'
        ));
    }

    public function create()
    {
        return view('admin.coupons.form');
    }

    public function store(Request $request)
    {
        $request->merge([
            'code' => strtoupper(trim($request->code)),
        ]);

        $validated = $request->validate([
            'code' => 'required|string|max:30|unique:coupons,code',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'coupon_type' => 'required|string|in:welcome,banner,general',
            'discount_type' => 'required|string|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0.01',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'banner_text' => 'nullable|string|max:255',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date|after_or_equal:valid_from',
        ]);

        $coupon = new Coupon($validated);
        $coupon->is_active = $request->has('is_active');
        $coupon->is_banner = $request->has('is_banner') || $request->coupon_type === 'banner';
        $coupon->min_order_amount = $request->input('min_order_amount', 0) ?: 0;
        $coupon->save();

        // If it's a welcome coupon, auto-assign to existing patients who don't have it
        if ($coupon->coupon_type === 'welcome' && $coupon->is_active) {
            $patients = Patient::whereDoesntHave('patientCoupons', function($q) use ($coupon) {
                $q->where('coupon_id', $coupon->id);
            })->get();
            foreach ($patients as $patient) {
                PatientCoupon::firstOrCreate([
                    'patient_id' => $patient->id,
                    'coupon_id' => $coupon->id,
                ]);
            }
        }

        return redirect()->route('admin.coupons.index')->with('success', "Coupon '{$coupon->code}' created successfully.");
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.form', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $request->merge([
            'code' => strtoupper(trim($request->code)),
        ]);

        $validated = $request->validate([
            'code' => 'required|string|max:30|unique:coupons,code,' . $coupon->id,
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'coupon_type' => 'required|string|in:welcome,banner,general',
            'discount_type' => 'required|string|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0.01',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'banner_text' => 'nullable|string|max:255',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date|after_or_equal:valid_from',
        ]);

        $coupon->fill($validated);
        $coupon->is_active = $request->has('is_active');
        $coupon->is_banner = $request->has('is_banner') || $request->coupon_type === 'banner';
        $coupon->min_order_amount = $request->input('min_order_amount', 0) ?: 0;
        $coupon->save();

        return redirect()->route('admin.coupons.index')->with('success', "Coupon '{$coupon->code}' updated successfully.");
    }

    public function destroy(Coupon $coupon)
    {
        $code = $coupon->code;
        $coupon->delete();

        return redirect()->route('admin.coupons.index')->with('success', "Coupon '{$code}' deleted successfully.");
    }

    public function toggle(Coupon $coupon)
    {
        $coupon->is_active = !$coupon->is_active;
        $coupon->save();

        $status = $coupon->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Coupon '{$coupon->code}' {$status} successfully.");
    }
}
