<?php

namespace App\Mail;

use App\Models\VolunteerVerificationToken;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerificationRequested extends Mailable
{
    use Queueable, SerializesModels;

    public string $link;

    public function __construct(VolunteerVerificationToken $token)
    {
        $this->link = route('volunteer.verify', $token);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bestätige deine Anmeldung',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.verification.requested',
        );
    }
}
