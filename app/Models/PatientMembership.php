<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PatientMembership extends Model
{
    protected $fillable = [
        'patient_id',
        'membership_plan_id',
        'plan_name_snapshot',
        'discount_percentage',
        'price_paid',
        'started_at',
        'expires_at',
        'status',
        'booking_id',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'expires_at' => 'datetime',
            'discount_percentage' => 'integer',
            'price_paid' => 'decimal:2',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(MembershipPlan::class, 'membership_plan_id');
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function paymentTransactions()
    {
        return $this->hasMany(PaymentTransaction::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            });
    }

    public function getIsValidAttribute(): bool
    {
        return $this->status === 'active' && ($this->expires_at === null || $this->expires_at->isFuture());
    }

    public function getDaysRemainingAttribute(): int
    {
        if (! $this->expires_at || $this->expires_at->isPast()) {
            return 0;
        }

        return (int) now()->diffInDays($this->expires_at);
    }
}
