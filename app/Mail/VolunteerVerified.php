<?php

namespace App\Mail;

use App\Models\Volunteer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VolunteerVerified extends Mailable
{
    use Queueable, SerializesModels;

    public Volunteer $volunteer;

    public function __construct(Volunteer $volunteer)
    {
        $this->volunteer = $volunteer;
    }

    public function envelope()
    {
        return new Envelope(
            from: new Address('signup@skhc.de'),
            subject: 'Du hast dich erfolgreich fürs SKHC angemeldet',
        );
    }

    public function content()
    {
        return new Content(
            view: 'emails.signups.success',
        );
    }
}
