<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgentLeave extends Model
{
    use HasFactory;

    protected $table = 'agent_leaves';

    protected $fillable = [
        'agent_id',
        'leave_date',
        'slot_title',
        'leave_type',
        'reason',
        'status',
    ];

    protected $casts = [
        'leave_date' => 'date',
    ];

    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', 'approved');
    }

    public function scopeForDate(Builder $query, string $date): Builder
    {
        return $query->whereDate('leave_date', $date);
    }

    public function isFullDay(): bool
    {
        return empty($this->slot_title) || $this->leave_type === 'full_day';
    }
}
