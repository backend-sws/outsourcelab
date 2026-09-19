<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class MembershipPlan extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'tagline',
        'duration_type',
        'duration_value',
        'price',
        'original_price',
        'discount_percentage',
        'free_home_collection',
        'free_teleconsultation',
        'priority_reports',
        'family_coverage_limit',
        'benefits',
        'theme_color',
        'is_popular',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'benefits' => 'array',
            'free_home_collection' => 'boolean',
            'free_teleconsultation' => 'boolean',
            'priority_reports' => 'boolean',
            'is_popular' => 'boolean',
            'is_active' => 'boolean',
            'price' => 'decimal:2',
            'original_price' => 'decimal:2',
            'duration_value' => 'integer',
            'discount_percentage' => 'integer',
            'family_coverage_limit' => 'integer',
        ];
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($plan) {
            if (empty($plan->slug)) {
                $plan->slug = Str::slug($plan->name);
            }
        });
    }

    public function patientMemberships(): HasMany
    {
        return $this->hasMany(PatientMembership::class);
    }

    public function getFormattedDurationAttribute(): string
    {
        $val = $this->duration_value;
        $unit = $this->duration_type === 'years' ? Str::plural('Year', $val) : Str::plural('Month', $val);

        return "{$val} {$unit}";
    }

    public function getDurationInMonthsAttribute(): int
    {
        return $this->duration_type === 'years' ? ($this->duration_value * 12) : $this->duration_value;
    }

    public function getSavingsPercentageAttribute(): int
    {
        if ($this->original_price && $this->original_price > $this->price) {
            return (int) round((($this->original_price - $this->price) / $this->original_price) * 100);
        }

        return 0;
    }
}
