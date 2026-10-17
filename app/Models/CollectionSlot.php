<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionSlot extends Model
{
    use HasFactory;

    protected $table = 'collection_slots';

    protected $fillable = [
        'title',
        'period',
        'start_time',
        'end_time',
        'max_bookings',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'max_bookings' => 'integer',
        'sort_order' => 'integer',
    ];

    /**
     * Scope for active slots.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for slots in sort order.
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('id', 'asc');
    }

    /**
     * Scope for a specific period (morning, afternoon, evening).
     */
    public function scopeByPeriod(Builder $query, string $period): Builder
    {
        return $query->where('period', strtolower($period));
    }

    /**
     * Get human-readable period title.
     */
    public function getPeriodLabelAttribute(): string
    {
        return match ($this->period) {
            'morning' => 'Morning',
            'afternoon' => 'Afternoon',
            'evening' => 'Evening',
            default => ucfirst($this->period ?? 'Morning'),
        };
    }

    /**
     * Get icon class for the slot period.
     */
    public function getPeriodIconAttribute(): string
    {
        return match ($this->period) {
            'morning' => 'fas fa-cloud-sun',
            'afternoon' => 'fas fa-sun',
            'evening' => 'fas fa-moon',
            default => 'fas fa-clock',
        };
    }

    /**
     * Get badge color styling for admin table.
     */
    public function getPeriodBadgeClassesAttribute(): string
    {
        return match ($this->period) {
            'morning' => 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-900/20 dark:text-amber-400 dark:border-amber-800/40',
            'afternoon' => 'bg-orange-50 text-orange-700 border-orange-200 dark:bg-orange-900/20 dark:text-orange-400 dark:border-orange-800/40',
            'evening' => 'bg-indigo-50 text-indigo-700 border-indigo-200 dark:bg-indigo-900/20 dark:text-indigo-400 dark:border-indigo-800/40',
            default => 'bg-slate-50 text-slate-700 border-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-700',
        };
    }
}
