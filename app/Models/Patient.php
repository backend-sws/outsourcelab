<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'mobile', 'name', 'gender', 'age', 'dob', 'relation', 'alt_mobile', 'email', 'password', 'otp', 'otp_expires_at', 'last_login_at', 'cart', 'reward_coins',
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
            'otp_expires_at' => 'datetime',
            'cart' => 'array',
            'reward_coins' => 'integer',
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

    public function memberships()
    {
        return $this->hasMany(PatientMembership::class);
    }

    public function activeMembership(): ?PatientMembership
    {
        return $this->memberships()
            ->active()
            ->latest('id')
            ->first();
    }

    public function isVipMember(): bool
    {
        return $this->activeMembership() !== null;
    }

    public function rewardTransactions()
    {
        return $this->hasMany(RewardTransaction::class);
    }

    /**
     * Credit coins to patient balance and log transaction.
     */
    public function creditCoins(int $coins, string $description, ?int $bookingId = null, float $amountEquivalent = 0): RewardTransaction
    {
        $newBalance = max(0, (int) $this->reward_coins + $coins);
        $this->update(['reward_coins' => $newBalance]);

        return $this->rewardTransactions()->create([
            'booking_id' => $bookingId,
            'type' => 'credit',
            'coins' => $coins,
            'amount_equivalent' => $amountEquivalent,
            'description' => $description,
            'balance_after' => $newBalance,
        ]);
    }

    /**
     * Debit coins from patient balance and log transaction.
     */
    public function debitCoins(int $coins, string $description, ?int $bookingId = null, float $amountEquivalent = 0): ?RewardTransaction
    {
        $coins = abs($coins);
        if ($coins > (int) $this->reward_coins) {
            $coins = (int) $this->reward_coins;
        }

        if ($coins <= 0) {
            return null;
        }

        $newBalance = max(0, (int) $this->reward_coins - $coins);
        $this->update(['reward_coins' => $newBalance]);

        return $this->rewardTransactions()->create([
            'booking_id' => $bookingId,
            'type' => 'debit',
            'coins' => -$coins,
            'amount_equivalent' => $amountEquivalent,
            'description' => $description,
            'balance_after' => $newBalance,
        ]);
    }
}
