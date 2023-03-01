<?php

namespace App\Mail;

use App\Models\Volunteer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerificationSuccessful extends Mailable
{
    use Queueable, SerializesModels;

    public Volunteer $volunteer;
    public string $createEditTokenRoute;

    public function __construct(Volunteer $volunteer)
    {
        $this->volunteer = $volunteer;
        $this->createEditTokenRoute = route('edit-token.create');
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'Du hast dich erfolgreich fürs SKHC angemeldet',
        );
    }

    public function content()
    {
        return new Content(
            view: 'emails.verification.successful',
        );
    }
}
