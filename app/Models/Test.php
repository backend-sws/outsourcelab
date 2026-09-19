<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = [
        'test_category_id', 'category_ids', 'name', 'price', 'image', 'is_featured',
        'is_active', 'home_collection_available', 'preparation_instructions',
        'report_delivery_time',
    ];

    protected $casts = [
        'category_ids' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'home_collection_available' => 'boolean',
    ];

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
