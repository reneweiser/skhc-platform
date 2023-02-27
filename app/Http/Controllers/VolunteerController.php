<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVolunteerRequest;
use App\Http\Requests\UpdateVolunteerRequest;
use App\Models\Shift;
use App\Models\ShirtSize;
use App\Models\Volunteer;
use Illuminate\Http\RedirectResponse;
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
        $request->persist();

        return redirect()
            ->route('volunteer.complete-signup-notice')
            ->with('email', $request->email);
    }

    public function update(UpdateVolunteerRequest $request, Volunteer $volunteer)
    {
        $request->persist($volunteer);

        return redirect()->route('home');
    }
}
