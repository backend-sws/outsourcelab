<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'mobile', 'name', 'gender', 'age', 'dob', 'relation', 'alt_mobile', 'email', 'password', 'otp', 'last_login_at'
    ];

    protected $hidden = [
        'password',
        'otp',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'last_login_at' => 'datetime',
        ];
    }

    public function familyMembers()
    {
        return $this->hasMany(FamilyMember::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function patientCoupons()
    {
        return $this->hasMany(PatientCoupon::class);
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'patient_coupons')
                    ->withPivot('is_used', 'used_at', 'booking_id')
                    ->withTimestamps();
    }
}
