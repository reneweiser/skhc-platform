<?php

namespace App\Mail;

use App\Models\Volunteer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VolunteerUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public Volunteer $volunteer;

    public function __construct(Volunteer $volunteer)
    {
        $this->volunteer = $volunteer;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Du hast deine Daten erfolgreich geändert',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.volunteers.updated',
        );
    }
}
