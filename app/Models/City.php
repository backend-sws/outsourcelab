<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class City extends Model
{
    use HasFactory;

    protected $table = 'cities';

    protected $fillable = [
        'name',
        'slug',
        'state',
        'pincodes',
        'is_default',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($city) {
            if (empty($city->slug) && !empty($city->name)) {
                $city->slug = Str::slug($city->name);
            }
        });
    }

    /**
     * Scope for active cities.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordered cities.
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('name', 'asc');
    }

    /**
     * Parse pincodes into an array of clean string values.
     */
    public function getPincodeListAttribute(): array
    {
        if (empty($this->pincodes)) {
            return [];
        }

        $parts = preg_split('/[,\r\n]+/', (string) $this->pincodes);
        $clean = array_values(array_unique(array_filter(array_map('trim', $parts))));

        return $clean;
    }

    /**
     * Count of serviceable pincodes.
     */
    public function getPincodesCountAttribute(): int
    {
        return count($this->pincode_list);
    }

    /**
     * Format pincodes as comma separated string.
     */
    public function getFormattedPincodesAttribute(): string
    {
        return implode(', ', $this->pincode_list);
    }

    /**
     * Check if city services a specific pincode.
     */
    public function hasPincode(string $pincode): bool
    {
        return in_array(trim($pincode), $this->pincode_list, true);
    }

    /**
     * Get default active city.
     */
    public static function getDefaultCity(): ?self
    {
        return self::where('is_active', true)
            ->where('is_default', true)
            ->first() ?? self::active()->ordered()->first();
    }

    /**
     * Get all active pincodes across all active cities.
     */
    public static function getAllActivePincodes(): array
    {
        $allCities = self::active()->get();
        $pincodes = [];

        foreach ($allCities as $city) {
            $pincodes = array_merge($pincodes, $city->pincode_list);
        }

        // Also merge with legacy Setting if exists
        $legacySetting = Setting::get('serviceable_pincodes', '');
        if (!empty($legacySetting)) {
            $legacyParts = preg_split('/[,\r\n]+/', $legacySetting);
            $pincodes = array_merge($pincodes, array_filter(array_map('trim', $legacyParts)));
        }

        return array_values(array_unique(array_filter($pincodes)));
    }
}
