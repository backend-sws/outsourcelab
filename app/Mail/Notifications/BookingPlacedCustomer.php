<?php

namespace App\Mail\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingPlacedCustomer extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Booking $booking
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Booking Confirmed #{$this->booking->booking_reference} - AV Wellcare Diagnostics",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.booking-placed-customer',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
