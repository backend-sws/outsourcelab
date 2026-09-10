<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'booking_reference', 'patient_id', 'family_member_id', 'address_id', 
        'test_details', 'collection_type', 'amount', 'coupon_code', 'discount_amount',
        'payment_method', 'payment_status', 'status', 'report_file_path', 'booking_date'
    ];

    protected $casts = [
        'test_details' => 'array',
        'booking_date' => 'datetime',
        'amount' => 'float',
        'discount_amount' => 'float',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
