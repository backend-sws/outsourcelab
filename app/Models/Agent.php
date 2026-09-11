<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'city',
        'address',
        'vehicle_number',
        'status',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'last_login_at' => 'datetime',
        ];
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function activeBookings()
    {
        return $this->hasMany(Booking::class)->whereNotIn('sample_status', ['Delivered to Lab', 'Cancelled']);
    }

    public function completedBookings()
    {
        return $this->hasMany(Booking::class)->where('sample_status', 'Delivered to Lab');
    }
}
