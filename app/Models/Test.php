<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = [
        'test_category_id', 'name', 'price', 'image', 'is_featured', 
        'is_active', 'home_collection_available', 'preparation_instructions', 
        'report_delivery_time'
    ];

    public function category()
    {
        return $this->belongsTo(TestCategory::class, 'test_category_id');
    }
}
