<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'booking_reference', 'lis_booking_reference', 'lis_bill_number', 'lis_status',
        'patient_id', 'family_member_id', 'address_id', 'agent_id',
        'test_details', 'collection_type', 'collection_slot', 'amount', 'coupon_code', 'discount_amount',
        'coins_redeemed', 'coins_discount', 'coins_earned',
        'payment_method', 'payment_status', 'razorpay_order_id', 'razorpay_payment_id', 'razorpay_signature',
        'status', 'sample_status', 'sample_collected_at',
        'sample_notes', 'money_collected_at', 'money_collected_by', 'money_payment_mode',
        'report_file_path', 'booking_date', 'lis_synced_at',
    ];

    protected $casts = [
        'test_details' => 'array',
        'booking_date' => 'datetime',
        'sample_collected_at' => 'datetime',
        'money_collected_at' => 'datetime',
        'lis_synced_at' => 'datetime',
        'amount' => 'float',
        'discount_amount' => 'float',
        'coins_redeemed' => 'integer',
        'coins_discount' => 'float',
        'coins_earned' => 'integer',
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

    public function rewardTransactions()
    {
        return $this->hasMany(RewardTransaction::class);
    }

    public function paymentTransactions()
    {
        return $this->hasMany(PaymentTransaction::class);
    }

    public function latestPaymentTransaction()
    {
        return $this->hasOne(PaymentTransaction::class)->latestOfMany();
    }

    public function getDisplaySlotAttribute(): string
    {
        if (! empty($this->collection_slot)) {
            return $this->collection_slot;
        }
        if ($this->booking_date) {
            return $this->booking_date->format('h:i A');
        }

        return '07:00 AM - 08:00 AM';
    }

    /**
     * Check if a collection slot has already expired/passed for a given date.
     * If the date is in the past, or if the date is today and the slot's start time has passed, returns true.
     */
    public static function isSlotExpiredForDate(?string $dateStr, ?string $slotStr): bool
    {
        if (empty($dateStr) || empty($slotStr)) {
            return false;
        }

        try {
            $parsedDate = \Carbon\Carbon::parse($dateStr)->format('Y-m-d');
            $todayDate = now()->format('Y-m-d');

            if ($parsedDate < $todayDate) {
                return true;
            }

            if ($parsedDate > $todayDate) {
                return false;
            }

            // Target date is today! Parse slot start time (e.g. "07:00 AM - 08:00 AM" or "07:00 AM")
            $parts = explode('-', $slotStr);
            $startTimeStr = trim($parts[0]);

            $slotDateTime = \Carbon\Carbon::parse($todayDate . ' ' . $startTimeStr);

            return $slotDateTime->lessThanOrEqualTo(now());
        } catch (\Throwable $e) {
            return false;
        }
    }
}
