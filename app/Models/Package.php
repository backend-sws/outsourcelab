<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'lis_package_id',
        'package_code',
        'name',
        'type',
        'display_sections',
        'category_ids',
        'subcategory',
        'price',
        'lis_price',
        'original_price',
        'discount_percentage',
        'sample_type',
        'tat_hours',
        'lock_pricing',
        'total_parameters',
        'image',
        'is_featured',
        'is_active',
        'description',
        'parameters',
        'lis_synced_at',
    ];

    protected $casts = [
        'parameters' => 'array',
        'display_sections' => 'array',
        'category_ids' => 'array',
        'total_parameters' => 'integer',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'lock_pricing' => 'boolean',
        'price' => 'float',
        'lis_price' => 'float',
        'original_price' => 'float',
        'discount_percentage' => 'integer',
        'tat_hours' => 'integer',
        'lis_synced_at' => 'datetime',
    ];

    /**
     * Check if package has an active promotional discount compared to MRP.
     */
    public function hasDiscount(): bool
    {
        return ($this->original_price && $this->original_price > $this->price)
            || ($this->discount_percentage && $this->discount_percentage > 0);
    }

    /**
     * Get computed discount percentage.
     */
    public function getEffectiveDiscountPercentageAttribute(): int
    {
        if ($this->discount_percentage && $this->discount_percentage > 0) {
            return (int) $this->discount_percentage;
        }

        if ($this->original_price && $this->original_price > $this->price) {
            return (int) round((($this->original_price - $this->price) / $this->original_price) * 100);
        }

        return 0;
    }

    /**
     * Get effective MRP (Market Retail Price) for strike-through display.
     */
    public function getEffectiveMrpAttribute(): ?float
    {
        if ($this->original_price && $this->original_price > $this->price) {
            return (float) $this->original_price;
        }

        if ($this->discount_percentage && $this->discount_percentage > 0 && $this->discount_percentage < 100 && $this->price > 0) {
            return (float) round($this->price / (1 - ($this->discount_percentage / 100)));
        }

        return null;
    }

    /**
     * Check if package is assigned to a specific display section
     */
    public function inSection(string $section): bool
    {
        $sections = $this->display_sections ?? [];
        if (in_array($section, $sections)) {
            return true;
        }

        // Fallback to legacy type
        return $this->type === $section;
    }

    /**
     * Check if package is assigned to a category
     */
    public function inCategory(int $categoryId): bool
    {
        $cats = $this->category_ids ?? [];

        return in_array($categoryId, $cats);
    }

    /**
     * Get organized parameter breakdown grouped by included Test name.
     *
     * LIS sync stores parameters as: ["CBC: Hemoglobin", "CBC: RBC Count", "Lipid Profile: Total Cholesterol"]
     * This method groups them into: ['CBC' => ['Hemoglobin', 'RBC Count'], 'Lipid Profile' => ['Total Cholesterol']]
     *
     * If an entry has no colon (single-marker test), it goes under its own name as a group.
     */
    public function getGroupedParameters(): array
    {
        $rawParams = is_array($this->parameters) ? $this->parameters : [];
        if (empty($rawParams)) {
            return [];
        }

        $grouped = [];

        foreach ($rawParams as $item) {
            $item = trim((string) $item);
            if (empty($item)) {
                continue;
            }

            // Format: "TestName: ParamName" — split on first colon
            if (str_contains($item, ':')) {
                [$testName, $paramName] = array_map('trim', explode(':', $item, 2));
                if (empty($testName) || empty($paramName)) {
                    continue;
                }
                if (! isset($grouped[$testName])) {
                    $grouped[$testName] = [];
                }
                $grouped[$testName][] = $paramName;
            } else {
                // If item has no colon, check if a Test model exists with sub-parameters
                static $testLookup = null;
                if ($testLookup === null) {
                    $testLookup = Test::whereNotNull('parameters')->get()->keyBy(function ($t) {
                        return strtolower(trim($t->name));
                    });
                }
                $lowerItem = strtolower($item);
                $foundTest = $testLookup[$lowerItem] ?? null;
                if (! $foundTest) {
                    // Try partial match without brackets
                    $clean = trim(preg_replace('/\(.*?\)/', '', $lowerItem));
                    if (strlen($clean) > 3) {
                        foreach ($testLookup as $key => $cand) {
                            if (str_contains($key, $clean) || str_contains($clean, $key)) {
                                $foundTest = $cand;
                                break;
                            }
                        }
                    }
                }

                if ($foundTest && ! empty($foundTest->parameters) && is_array($foundTest->parameters)) {
                    if (! isset($grouped[$foundTest->name])) {
                        $grouped[$foundTest->name] = [];
                    }
                    foreach ($foundTest->parameters as $p) {
                        $grouped[$foundTest->name][] = $p;
                    }
                } else {
                    if (! isset($grouped[$item])) {
                        $grouped[$item] = [$item];
                    }
                }
            }
        }

        return $grouped;
    }

    /**
     * Get number of distinct medical tests included in this health package.
     */
    public function getIncludedTestsCountAttribute(): int
    {
        $grouped = $this->getGroupedParameters();

        return count($grouped);
    }

    /**
     * Get total true clinical parameter count across all included tests/departments.
     */
    public function getTotalParametersCountAttribute(): int
    {
        if ($this->total_parameters !== null && $this->total_parameters > 0) {
            return (int) $this->total_parameters;
        }

        $grouped = $this->getGroupedParameters();
        if (empty($grouped)) {
            return is_array($this->parameters) ? count($this->parameters) : 0;
        }

        $total = 0;
        foreach ($grouped as $dept => $params) {
            $total += count($params);
        }

        return $total > 0 ? $total : (is_array($this->parameters) ? count($this->parameters) : 0);
    }
}
