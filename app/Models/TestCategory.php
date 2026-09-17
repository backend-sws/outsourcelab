<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestCategory extends Model
{
    protected $fillable = ['name', 'parameters'];

    protected $casts = [
        'parameters' => 'array',
    ];
}
