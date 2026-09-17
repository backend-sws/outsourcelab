<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'sub_category',
        'is_active',
    ];

    protected $casts = [
        'sub_category' => 'array',
        'is_active' => 'boolean',
    ];
}
