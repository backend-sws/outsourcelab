<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = [
        'lis_test_id', 'test_code', 'test_category_id', 'category_ids', 'name',
        'price', 'lis_price', 'original_price', 'sample_type', 'tat_hours',
        'fasting_required', 'lock_pricing', 'image', 'is_featured', 'is_active',
        'home_collection_available', 'preparation_instructions', 'report_delivery_time',
        'parameters', 'lis_synced_at',
    ];

    protected $casts = [
        'category_ids' => 'array',
        'parameters' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'home_collection_available' => 'boolean',
        'fasting_required' => 'boolean',
        'lock_pricing' => 'boolean',
        'price' => 'float',
        'lis_price' => 'float',
        'original_price' => 'float',
        'tat_hours' => 'integer',
        'lis_synced_at' => 'datetime',
    ];

    /**
     * Check if test has an active promotional discount compared to MRP.
     */
    public function hasDiscount(): bool
    {
        return $this->original_price && $this->original_price > $this->price;
    }

    /**
     * Calculate discount percentage from MRP and Selling Price.
     */
    public function getDiscountPercentageAttribute(): ?int
    {
        if ($this->hasDiscount()) {
            return (int) round((($this->original_price - $this->price) / $this->original_price) * 100);
        }

        return null;
    }

    /**
     * Get effective MRP for strike-through display.
     */
    public function getEffectiveMrpAttribute(): ?float
    {
        if ($this->hasDiscount()) {
            return (float) $this->original_price;
        }

        return null;
    }

    /**
     * Get human-readable turnaround time.
     */
    public function getDisplayTatAttribute(): string
    {
        if ($this->tat_hours) {
            return $this->tat_hours >= 24
                ? round($this->tat_hours / 24).' Day(s)'
                : "{$this->tat_hours} Hours";
        }

        return $this->report_delivery_time ?? 'Within 24 Hours';
    }

    public function category()
    {
        return $this->belongsTo(TestCategory::class, 'test_category_id');
    }

    public function allCategories()
    {
        $ids = is_array($this->category_ids) ? $this->category_ids : [];
        if ($this->test_category_id && ! in_array($this->test_category_id, $ids)) {
            $ids[] = $this->test_category_id;
        }

        return TestCategory::whereIn('id', $ids)->get();
    }

    /**
     * Determine if test requires fasting based on flag or instruction content.
     */
    public function getRequiresFastingAttribute(): bool
    {
        if ($this->fasting_required) {
            return true;
        }

        $text = strtolower($this->preparation_instructions ?? '');

        return str_contains($text, 'fasting') && ! str_contains($text, 'no fasting') && ! str_contains($text, 'non-fasting');
    }

    /**
     * Get a user-friendly label for fasting requirements.
     */
    public function getFastingLabelAttribute(): string
    {
        $text = strtolower($this->preparation_instructions ?? '');

        if ($this->fasting_required || (str_contains($text, 'fasting') && ! str_contains($text, 'no fasting') && ! str_contains($text, 'non-fasting'))) {
            if (preg_match('/(10[\s\-–to]+12|12[\s\-–to]+14|8[\s\-–to]+10|\d+\s*(?:hrs?|hours?))/i', $this->preparation_instructions ?? '', $matches)) {
                return "Overnight Fasting ({$matches[0]})";
            }

            return 'Overnight Fasting (8-10 Hrs)';
        }

        return 'No Fasting Req.';
    }

    /**
     * Parse preparation instructions into a clean array of bullet points.
     */
    public function getPreparationPointsAttribute(): array
    {
        if (empty($this->preparation_instructions)) {
            if ($this->requires_fasting) {
                return [
                    'Overnight fasting of 8 to 10 hours is required prior to sample collection.',
                    'Only plain drinking water is permitted during the fasting period.',
                    'Strictly avoid tea, coffee, milk, breakfast, smoking, and alcohol.',
                    'Morning sample collection between 7:00 AM and 10:00 AM is recommended.',
                ];
            }

            return [
                'No special fasting required. Can be done at any convenient time of the day.',
                'Maintain normal hydration and diet prior to sample collection.',
            ];
        }

        $raw = trim($this->preparation_instructions);
        $lines = preg_split('/[\r\n]+/', $raw);
        $points = [];

        foreach ($lines as $line) {
            $line = trim($line);
            // Strip leading bullet characters or numbers: •, -, *, 1., 1), etc.
            $cleaned = preg_replace('/^([•\-\*■►✔✓]|\d+[\.\)])\s*/u', '', $line);
            $cleaned = trim($cleaned);
            if (! empty($cleaned)) {
                $points[] = $cleaned;
            }
        }

        // If it was stored as a single unbroken paragraph with multiple sentences, split on punctuation
        if (count($points) === 1 && strlen($points[0]) > 40) {
            $parts = preg_split('/(?<=[.!?])\s+/', $points[0]);
            $splitPoints = [];
            foreach ($parts as $p) {
                $p = trim($p);
                if (! empty($p)) {
                    $splitPoints[] = $p;
                }
            }
            if (count($splitPoints) > 1) {
                return $splitPoints;
            }
        }

        return ! empty($points) ? $points : [
            'Standard diagnostic blood investigation verified by MD Pathologists according to certified laboratory protocols.',
        ];
    }
}
