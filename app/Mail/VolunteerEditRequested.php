<?php

namespace App\Mail;

use App\Models\EditToken;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VolunteerEditRequested extends Mailable
{
    use Queueable, SerializesModels;

    public string $link;

    public function __construct(EditToken $token)
    {
        $this->link = route('volunteer.edit', $token);
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'Du hast einen Änderungszugang angefordert',
        );
    }

    public function content()
    {
        return new Content(
            view: 'emails.volunteers.edit-requested',
        );
    }
}
