<?php

namespace App\Http\Controllers;

use App\Mail\VerificationSuccessful;
use App\Models\VolunteerVerificationToken;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class VolunteerVerificationController extends Controller
{
    public function __invoke(VolunteerVerificationToken $token): RedirectResponse
    {
        $token->volunteer->verify();
        $email = $token->volunteer->email;

        Mail::to($email)->send(new VerificationSuccessful($token->volunteer));

        $token->delete();

        return redirect()
            ->route('volunteer.successful.notice')
            ->with('email', $email);
    }
}
