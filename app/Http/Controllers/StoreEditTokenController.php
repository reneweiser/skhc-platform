<?php

namespace App\Http\Controllers;

use App\Mail\VolunteerRequestedEditLink;
use App\Models\EditToken;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Inertia\Response;

class StoreEditTokenController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $validatedData = $request->validate([
            'email' => ['required', 'email', 'exists:volunteers,email']
        ]);

        $volunteer = Volunteer::whereEmail($validatedData['email'])->first();

        $token = EditToken::create([
            'volunteer_id' => $volunteer->id,
            'email' => $volunteer->email,
        ]);

        Mail::to($volunteer->email)->send(new VolunteerRequestedEditLink($token));

        return Inertia::render('EditLinkNotice', ['email' => $volunteer->email]);
    }
}
