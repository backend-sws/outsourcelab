<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'title',
        'description',
        'coupon_type', // 'welcome', 'banner', 'general'
        'discount_type', // 'percentage', 'fixed'
        'discount_value',
        'min_order_amount',
        'max_discount_amount',
        'is_banner',
        'banner_text',
        'is_active',
        'valid_from',
        'valid_until',
        'usage_limit_per_user',
    ];

    protected $casts = [
        'discount_value' => 'float',
        'min_order_amount' => 'float',
        'max_discount_amount' => 'float',
        'is_banner' => 'boolean',
        'is_active' => 'boolean',
        'valid_from' => 'date',
        'valid_until' => 'date',
        'usage_limit_per_user' => 'integer',
    ];

    public function patientCoupons()
    {
        return $this->hasMany(PatientCoupon::class);
    }

    public function patients()
    {
        return $this->belongsToMany(Patient::class, 'patient_coupons')
                    ->withPivot('is_used', 'used_at', 'booking_id')
                    ->withTimestamps();
    }

    /**
     * Calculate discount amount for a given order total
     */
    public function calculateDiscount(float $orderTotal): float
    {
        if ($this->min_order_amount > 0 && $orderTotal < $this->min_order_amount) {
            return 0;
        }

        if ($this->discount_type === 'percentage') {
            $discount = ($orderTotal * $this->discount_value) / 100;
            if ($this->max_discount_amount && $discount > $this->max_discount_amount) {
                $discount = $this->max_discount_amount;
            }
            return round($discount, 2);
        }

        // Fixed discount
        return min($orderTotal, round($this->discount_value, 2));
    }
}
