<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVolunteerRequest;
use App\Models\Shift;
use App\Models\ShirtSize;
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
}
