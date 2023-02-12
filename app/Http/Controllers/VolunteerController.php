<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVolunteerRequest;
use App\Mail\VolunteerVerificationMail;
use App\Models\Shift;
use App\Models\ShirtSize;
use App\Models\Volunteer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Inertia\Response;
use Inertia\ResponseFactory;

class VolunteerController extends Controller
{
    public function create(): Response|ResponseFactory
    {
        $shirtSizes = ShirtSize::all();
        $shifts = Shift::with('venue')->get();

        return inertia('Volunteers/Create', compact('shirtSizes', 'shifts'));
    }

    public function store(StoreVolunteerRequest $request): RedirectResponse
    {
        $volunteer = Volunteer::create($request->safe()->except('selected_shifts'));

        $volunteer->assign($request->safe()->only('selected_shifts'));

        Mail::to($request->safe(['email']))->send(new VolunteerVerificationMail($volunteer->verificationToken));

        return redirect()
            ->route('signup.create')
            ->with('email', $volunteer->email);
    }
}
