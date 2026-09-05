<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'patient_id', 'title', 'full_address', 'pincode'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
