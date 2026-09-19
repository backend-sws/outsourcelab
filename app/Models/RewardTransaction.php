<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RewardTransaction extends Model
{
    protected $fillable = [
        'patient_id',
        'booking_id',
        'type',
        'coins',
        'amount_equivalent',
        'description',
        'balance_after',
    ];

    protected function casts(): array
    {
        return [
            'coins' => 'integer',
            'amount_equivalent' => 'float',
            'balance_after' => 'integer',
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
}
