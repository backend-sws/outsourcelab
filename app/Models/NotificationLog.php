<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class NotificationLog extends Model
{
    protected $fillable = [
        'notifiable_type',
        'notifiable_id',
        'channel',
        'event',
        'recipient_name',
        'recipient_contact',
        'subject',
        'body',
        'status',
        'error_message',
        'sent_at',
        'read_at',
        'action_url',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'read_at' => 'datetime',
    ];

    public function isRead(): bool
    {
        return $this->read_at !== null;
    }

    public function markAsRead(): void
    {
        if (! $this->isRead()) {
            $this->update(['read_at' => now()]);
        }
    }

    public function scopeUnread(Builder $query): Builder
    {
        return $query->whereNull('read_at');
    }

    public function scopeRead(Builder $query): Builder
    {
        return $query->whereNotNull('read_at');
    }

    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }

    /** Filter by channel: email, sms, whatsapp */
    public function scopeByChannel(Builder $query, string $channel): Builder
    {
        return $query->where('channel', $channel);
    }

    /** Filter by event key */
    public function scopeByEvent(Builder $query, string $event): Builder
    {
        return $query->where('event', $event);
    }

    /** Filter by status: sent, failed, skipped */
    public function scopeByStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    /**
     * Human-readable label for a notification event key.
     */
    public static function eventLabel(string $event): string
    {
        return match ($event) {
            'booking_placed' => 'Booking Placed',
            'booking_confirmed' => 'Booking Confirmed',
            'agent_assigned' => 'Agent Assigned',
            'sample_collected' => 'Sample Collected',
            'report_ready' => 'Report Ready',
            'booking_cancelled' => 'Booking Cancelled',
            'payment_success' => 'Payment Successful',
            'payment_failed' => 'Payment Failed',
            'agent_registration' => 'Agent Registration',
            default => ucwords(str_replace('_', ' ', $event)),
        };
    }

    /**
     * FontAwesome icon class for a notification event key.
     */
    public static function eventIcon(string $event): string
    {
        return match ($event) {
            'booking_placed' => 'fas fa-calendar-plus',
            'booking_confirmed' => 'fas fa-calendar-check',
            'agent_assigned' => 'fas fa-user-nurse',
            'sample_collected' => 'fas fa-vial-circle-check',
            'report_ready' => 'fas fa-file-medical-alt',
            'booking_cancelled' => 'fas fa-calendar-xmark',
            'payment_success' => 'fas fa-circle-check',
            'payment_failed' => 'fas fa-circle-xmark',
            'agent_registration' => 'fas fa-id-card',
            default => 'fas fa-bell',
        };
    }

    /**
     * Color classes for the notification icon badge.
     */
    public static function eventBadgeClass(string $event): string
    {
        return match ($event) {
            'report_ready' => 'bg-emerald-500/15 text-emerald-600 dark:text-emerald-400 border border-emerald-500/30',
            'payment_success' => 'bg-teal-500/15 text-teal-600 dark:text-teal-400 border border-teal-500/30',
            'agent_assigned', 'sample_collected' => 'bg-sky-500/15 text-sky-600 dark:text-sky-400 border border-sky-500/30',
            'booking_placed', 'booking_confirmed' => 'bg-indigo-500/15 text-indigo-600 dark:text-indigo-400 border border-indigo-500/30',
            'booking_cancelled', 'payment_failed' => 'bg-rose-500/15 text-rose-600 dark:text-rose-400 border border-rose-500/30',
            default => 'bg-slate-500/15 text-slate-600 dark:text-slate-400 border border-slate-500/30',
        };
    }
}
