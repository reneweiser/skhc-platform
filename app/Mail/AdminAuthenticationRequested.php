<?php

namespace App\Mail;

use App\Models\AdminAuthentication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminAuthenticationRequested extends Mailable
{
    use Queueable, SerializesModels;

    public string $link;

    public function __construct(AdminAuthentication $adminAuthentication)
    {
        $this->link = route('admin-auth.login', $adminAuthentication);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Admin Stuff angefordert',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admins.admin-auth-requested',
        );
    }
}
