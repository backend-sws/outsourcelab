<?php

namespace App\Mail\Notifications;

use App\Models\Agent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AgentRegisteredAdmin extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Agent $agent
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "🆕 New Phlebotomist Registered: {$this->agent->name} - AV Wellcare",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.agent-registered-admin',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
