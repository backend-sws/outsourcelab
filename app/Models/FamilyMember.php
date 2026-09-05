<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    protected $fillable = [
        'patient_id', 'name', 'gender', 'age', 'relation'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
