<?php

namespace App\Mail;

use App\Models\VolunteerVerificationToken;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VolunteerCreated extends Mailable
{
    use Queueable, SerializesModels;

    public VolunteerVerificationToken $token;

    public function __construct(VolunteerVerificationToken $token)
    {
        $this->token = $token;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('signup@skhc.de'),
            subject: 'Bestätige deine Anmeldung',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.signups.verify',
        );
    }
}
