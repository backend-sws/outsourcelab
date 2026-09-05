<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'mobile', 'name', 'gender', 'age', 'dob', 'relation', 'alt_mobile', 'email'
    ];

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
}
