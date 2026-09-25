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
}
