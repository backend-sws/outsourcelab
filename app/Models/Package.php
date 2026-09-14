<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'name', 'type', 'subcategory', 'price', 'image', 'is_featured', 'is_active', 'description', 'parameters'
    ];

    protected $casts = [
        'parameters' => 'array',
    ];
}
