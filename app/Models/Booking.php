<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'booking_reference', 'patient_id', 'family_member_id', 'address_id', 'agent_id',
        'test_details', 'collection_type', 'amount', 'coupon_code', 'discount_amount',
        'payment_method', 'payment_status', 'status', 'sample_status', 'sample_collected_at',
        'sample_notes', 'money_collected_at', 'money_collected_by', 'money_payment_mode',
        'report_file_path', 'booking_date'
    ];

    protected $casts = [
        'test_details' => 'array',
        'booking_date' => 'datetime',
        'sample_collected_at' => 'datetime',
        'money_collected_at' => 'datetime',
        'amount' => 'float',
        'discount_amount' => 'float',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
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
