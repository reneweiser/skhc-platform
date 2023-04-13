<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVolunteerRequest;
use App\Http\Requests\UpdateVolunteerRequest;
use App\Http\Resources\ShiftResource;
use App\Http\Resources\VolunteerResource;
use App\Mail\VolunteerDeleted;
use App\Models\EditToken;
use App\Models\Shift;
use App\Models\ShirtSize;
use App\Models\Volunteer;
use App\Skhc\VolunteerFilters;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Inertia\Response;
use Inertia\ResponseFactory;

class VolunteerController extends Controller
{
    public function create(): Response|ResponseFactory
    {
        $shirtSizes = ShirtSize::all();

        $shifts = ShiftResource::collection(Shift::all());

        return inertia('Volunteers/Create', [
            'shirtSizes' => $shirtSizes,
            'shifts' => $shifts,
            'spots' => VolunteerFilters::spots(),
        ]);
    }

    public function store(StoreVolunteerRequest $request): RedirectResponse
    {
        $request->persist();

        return redirect()->route('volunteer.verification.notice')
            ->with('email', $request->email);
    }

    public function edit(EditToken $token): Response|ResponseFactory
    {
        return inertia('Volunteers/Edit', [
            'token' => $token->id,
            'volunteer' => VolunteerResource::make($token->volunteer),
            'shirtSizes' => ShirtSize::all(),
            'shifts' => ShiftResource::collection(Shift::all()),
            'spots' => VolunteerFilters::spots(),
        ]);
    }

    public function update(UpdateVolunteerRequest $request, EditToken $token): RedirectResponse
    {
        $request->persist($token->volunteer);

        return redirect()->route('volunteer.updated.notice')
            ->with('email', $token->volunteer->email);
    }

    public function destroy(EditToken $token): RedirectResponse
    {
        $email = $token->volunteer->email;

        $token->volunteer->delete();

        Mail::to($email)->send(new VolunteerDeleted());

        return redirect()->route('volunteer.deleted.notice')
            ->with('email', $email);
    }
}
