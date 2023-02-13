<?php

namespace App\Http\Controllers;

use App\Mail\VolunteerVerified;
use App\Models\VolunteerVerificationToken;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class VolunteerVerificationController extends Controller
{
    public function __invoke(VolunteerVerificationToken $token): RedirectResponse
    {
        $token->volunteer->verify();
        Mail::to($token->volunteer->email)->send(new VolunteerVerified($token->volunteer));
        $token->delete();

        return redirect()->route('home');
    }
}
