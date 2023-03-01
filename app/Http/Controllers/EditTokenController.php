<?php

namespace App\Http\Controllers;

use App\Mail\VolunteerEditRequested;
use App\Models\EditToken;
use App\Models\Volunteer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Response;
use Inertia\ResponseFactory;

class EditTokenController extends Controller
{
    public function create(): Response|ResponseFactory
    {
        return inertia('EditTokens/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'email' => ['required', 'email', 'exists:volunteers,email']
        ]);

        $volunteer = Volunteer::whereEmail($validatedData['email'])->first();

        $token = EditToken::create([
            'volunteer_id' => $volunteer->id,
            'email' => $volunteer->email,
        ]);

        Mail::to($volunteer->email)->send(new VolunteerEditRequested($token));

        return redirect()->route('edit-token.created.notice')
            ->with('email', $volunteer->email);
    }
}
