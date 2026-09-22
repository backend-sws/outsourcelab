<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentTransaction extends Model
{
    protected $fillable = [
        'transaction_reference',
        'patient_id',
        'booking_id',
        'patient_membership_id',
        'type',
        'amount',
        'currency',
        'gateway',
        'razorpay_order_id',
        'razorpay_payment_id',
        'razorpay_signature',
        'payment_method',
        'bank',
        'wallet',
        'vpa',
        'status',
        'error_code',
        'error_description',
        'request_payload',
        'response_payload',
        'webhook_payload',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'request_payload' => 'array',
            'response_payload' => 'array',
            'webhook_payload' => 'array',
            'paid_at' => 'datetime',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function membership(): BelongsTo
    {
        return $this->belongsTo(PatientMembership::class, 'patient_membership_id');
    }

    public function scopeCaptured(Builder $query): Builder
    {
        return $query->where('status', 'captured');
    }

    public function scopeFailed(Builder $query): Builder
    {
        return $query->where('status', 'failed');
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->whereIn('status', ['created', 'authorized']);
    }

    public static function generateReference(): string
    {
        return 'TXN-'.date('Ymd').'-'.strtoupper(substr(uniqid(), -6));
    }

    public function getStatusBadgeAttribute(): array
    {
        return match (strtolower($this->status)) {
            'captured', 'paid', 'success' => [
                'label' => 'Success',
                'class' => 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/20',
                'icon' => 'fa-check-circle',
            ],
            'failed' => [
                'label' => 'Failed',
                'class' => 'bg-rose-50 text-rose-700 border-rose-200 dark:bg-rose-500/10 dark:text-rose-400 dark:border-rose-500/20',
                'icon' => 'fa-times-circle',
            ],
            'authorized' => [
                'label' => 'Authorized',
                'class' => 'bg-blue-50 text-blue-700 border-blue-200 dark:bg-blue-500/10 dark:text-blue-400 dark:border-blue-500/20',
                'icon' => 'fa-shield-halved',
            ],
            'refunded' => [
                'label' => 'Refunded',
                'class' => 'bg-purple-50 text-purple-700 border-purple-200 dark:bg-purple-500/10 dark:text-purple-400 dark:border-purple-500/20',
                'icon' => 'fa-rotate-left',
            ],
            default => [
                'label' => 'Pending',
                'class' => 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-500/10 dark:text-amber-400 dark:border-amber-500/20',
                'icon' => 'fa-clock',
            ],
        };
    }

    public function getMethodIconAttribute(): string
    {
        return match (strtolower($this->payment_method ?? '')) {
            'upi' => 'fa-mobile-screen-button text-purple-500',
            'card', 'credit_card', 'debit_card' => 'fa-credit-card text-blue-500',
            'netbanking' => 'fa-building-columns text-emerald-500',
            'wallet' => 'fa-wallet text-amber-500',
            'cash' => 'fa-money-bill-wave text-teal-500',
            default => 'fa-receipt text-indigo-500',
        };
    }
}
