<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Agent extends Model
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'city',
        'address',
        'serviceable_pincodes',
        'max_orders_per_slot',
        'weekly_offs',
        'lis_collector_id',
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
            'weekly_offs' => 'array',
            'max_orders_per_slot' => 'integer',
        ];
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function leaves()
    {
        return $this->hasMany(AgentLeave::class);
    }

    public function activeBookings()
    {
        return $this->hasMany(Booking::class)->whereNotIn('sample_status', ['Delivered to Lab', 'Cancelled']);
    }

    public function completedBookings()
    {
        return $this->hasMany(Booking::class)->where('sample_status', 'Delivered to Lab');
    }

    /**
     * Get clean array of serviceable pincodes.
     *
     * @return array<int, string>
     */
    public function getPincodeListAttribute(): array
    {
        if (empty($this->serviceable_pincodes)) {
            return [];
        }

        $parts = preg_split('/[,\s\r\n]+/', (string) $this->serviceable_pincodes);
        $clean = array_values(array_unique(array_filter(array_map('trim', $parts))));

        return $clean;
    }

    /**
     * Check if agent services a given pincode.
     */
    public function servesPincode(?string $pincode): bool
    {
        if (empty($pincode)) {
            return false;
        }

        $list = $this->pincode_list;
        if (empty($list)) {
            return false;
        }

        if (in_array('*', $list, true) || in_array('all', array_map('strtolower', $list), true)) {
            return true;
        }

        return in_array(trim($pincode), $list, true);
    }

    /**
     * Check if agent is on leave / off-duty on a given date and time slot.
     */
    public function isOnLeave(string $dateYmd, ?string $slotTitle = null): bool
    {
        // 1. Check weekly off days (e.g. Sunday)
        if (! empty($this->weekly_offs) && is_array($this->weekly_offs)) {
            $dayOfWeek = strtolower(date('l', strtotime($dateYmd)));
            $cleanOffs = array_map('strtolower', array_map('trim', $this->weekly_offs));
            if (in_array($dayOfWeek, $cleanOffs, true)) {
                return true;
            }
        }

        // 2. Check approved leaves in agent_leaves table
        $leaveQuery = $this->leaves()
            ->approved()
            ->whereDate('leave_date', $dateYmd);

        if (! empty($slotTitle)) {
            // Either full-day leave OR leave on this specific slot
            return $leaveQuery->where(function ($q) use ($slotTitle) {
                $q->whereNull('slot_title')
                    ->orWhere('slot_title', '')
                    ->orWhere('leave_type', 'full_day')
                    ->orWhere('slot_title', $slotTitle);
            })->exists();
        }

        return $leaveQuery->exists();
    }

    /**
     * Check if agent has capacity remaining for a date & slot.
     */
    public function hasRemainingCapacity(string $dateYmd, string $slotTitle): bool
    {
        $maxPerSlot = $this->max_orders_per_slot ?: 2;

        $bookedCount = $this->bookings()
            ->whereDate('booking_date', $dateYmd)
            ->where('collection_slot', $slotTitle)
            ->whereNotIn('sample_status', ['Cancelled'])
            ->count();

        return $bookedCount < $maxPerSlot;
    }

    public function routeNotificationForMail(): ?string
    {
        return $this->email;
    }

    public function routeNotificationForSms(): ?string
    {
        return $this->phone;
    }

    public function routeNotificationForWhatsapp(): ?string
    {
        return $this->phone;
    }
}
