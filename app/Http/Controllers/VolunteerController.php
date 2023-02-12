<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVolunteerRequest;
use App\Models\Duty;
use App\Models\ShirtSize;
use App\Models\Volunteer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Inertia\Response;
use Inertia\ResponseFactory;

class VolunteerController extends Controller
{
    public function create(): Response|ResponseFactory
    {
        $shirtSizes = ShirtSize::all();
        $duties = Duty::with('venue')->get();

        return inertia('Volunteers/Create', compact('shirtSizes', 'duties'));
    }

    public function store(StoreVolunteerRequest $request): RedirectResponse
    {
        $volunteer = Volunteer::create($request->safe()->except('selected_duties'));

        $volunteer->assign($request->safe()->only('selected_duties'));

        return back();
    }
}
