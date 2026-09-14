<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientCoupon extends Model
{
    protected $fillable = [
        'patient_id',
        'coupon_id',
        'is_used',
        'used_at',
        'booking_id',
    ];

    protected $casts = [
        'is_used' => 'boolean',
        'used_at' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
