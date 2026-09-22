<?php

namespace App\Mail\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingCancelledCustomer extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Booking $booking
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Booking Cancelled #{$this->booking->booking_reference} - AV Wellcare",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.booking-cancelled-customer',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
