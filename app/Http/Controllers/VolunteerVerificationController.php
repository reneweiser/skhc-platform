<?php

namespace App\Http\Controllers;

use App\Models\VolunteerVerificationToken;
use Illuminate\Http\RedirectResponse;

class VolunteerVerificationController extends Controller
{
    public function __invoke(VolunteerVerificationToken $token): RedirectResponse
    {
        $token->volunteer->verify();
        $token->delete();

        return redirect()->route('home');
    }
}
