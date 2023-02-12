<?php

namespace App\Http\Controllers;

use App\Models\VolunteerVerificationToken;

class VolunteerVerificationTokenController extends Controller
{
    public function show(VolunteerVerificationToken $token)
    {
        $token->volunteer->verify();
        $token->delete();

        return redirect()->route('home');
    }
}
