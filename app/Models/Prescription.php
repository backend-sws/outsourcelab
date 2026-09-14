<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    protected $fillable = [
        'patient_id', 'family_member_id', 'file_path', 'original_name'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class);
    }
}
