<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactEnquiry extends Model
{
    protected $fillable = [
        'name', 'phone', 'email', 'subject', 'message', 'status',
    ];
}
