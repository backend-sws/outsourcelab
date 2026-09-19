<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'name',
        'type',
        'display_sections',
        'category_ids',
        'subcategory',
        'price',
        'total_parameters',
        'image',
        'is_featured',
        'is_active',
        'description',
        'parameters',
    ];

    protected $casts = [
        'parameters' => 'array',
        'display_sections' => 'array',
        'category_ids' => 'array',
        'total_parameters' => 'integer',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

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
     * Get organized parameter breakdown by Department/Organ.
     * Returns an array like:
     * [
     *     'Complete Hemogram / CBC' => ['Hemoglobin', 'Total Leukocyte Count (WBC)', 'Platelet Count', ...],
     *     'Lipid Profile' => ['Total Cholesterol', 'HDL', 'LDL', ...],
     * ]
     */
    public function getGroupedParameters(): array
    {
        $rawParams = is_array($this->parameters) ? $this->parameters : [];
        if (empty($rawParams)) {
            return [];
        }

        static $allDepts = null;
        if ($allDepts === null) {
            $allDepts = TestCategory::all();
        }

        $grouped = [];
        $unassigned = [];

        foreach ($rawParams as $item) {
            $item = trim($item);
            if (empty($item)) {
                continue;
            }

            // Clean item string of "(X Tests)" or "(X Parameters)" if present
            $cleanedItem = trim(preg_replace('/\(\d+\s*(tests|parameters)?\)/i', '', $item));

            // Check direct match with Department name
            $matchedDept = $allDepts->first(function ($d) use ($cleanedItem, $item) {
                return strcasecmp($d->name, $item) === 0 || strcasecmp($d->name, $cleanedItem) === 0;
            });

            if ($matchedDept) {
                $deptParams = is_array($matchedDept->parameters) ? $matchedDept->parameters : [];
                if (! empty($deptParams)) {
                    $grouped[$matchedDept->name] = $deptParams;
                } else {
                    $grouped[$matchedDept->name] = [$matchedDept->name];
                }

                continue;
            }

            // Check if this parameter is an individual biomarker inside any department
            $foundDept = null;
            foreach ($allDepts as $dept) {
                if (is_array($dept->parameters)) {
                    foreach ($dept->parameters as $p) {
                        if (strcasecmp($p, $item) === 0 || strcasecmp($p, $cleanedItem) === 0) {
                            $foundDept = $dept->name;
                            break 2;
                        }
                    }
                }
            }

            if ($foundDept) {
                if (! isset($grouped[$foundDept])) {
                    $grouped[$foundDept] = [];
                }
                if (! in_array($item, $grouped[$foundDept])) {
                    $grouped[$foundDept][] = $item;
                }
            } else {
                $unassigned[] = $item;
            }
        }

        if (! empty($unassigned)) {
            $grouped['General Tests & Clinical Parameters'] = $unassigned;
        }

        return $grouped;
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
