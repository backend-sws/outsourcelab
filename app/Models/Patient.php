<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'mobile', 'name', 'gender', 'age', 'dob', 'relation', 'alt_mobile', 'email'
    ];
}
