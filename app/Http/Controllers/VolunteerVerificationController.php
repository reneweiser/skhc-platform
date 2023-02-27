<?php

namespace App\Http\Controllers;

use App\Mail\VolunteerVerified;
use App\Models\VolunteerVerificationToken;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Inertia\Response;

class VolunteerVerificationController extends Controller
{
    public function __invoke(VolunteerVerificationToken $token): Response
    {
        $token->volunteer->verify();
        $email = $token->volunteer->email;
        Mail::to($email)->send(new VolunteerVerified($token->volunteer));
        $token->delete();

        return Inertia::render('VerificationSuccessfulNotice', ['email' => $email]);
    }
}
