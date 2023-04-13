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

class AdminVolunteerController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        return inertia('AdminVolunteers/Index', [
            'volunteers' => VolunteerResource::collection(Volunteer::orderByDesc('updated_at')->get())
        ]);
    }

    public function create(): Response|ResponseFactory
    {
        return inertia('AdminVolunteers/Create', [
            'shirtSizes' => ShirtSize::all(),
            'shifts' => ShiftResource::collection(Shift::all()),
            'spots' => VolunteerFilters::spots(),
        ]);
    }


    public function store(StoreVolunteerRequest $request): RedirectResponse
    {
        $request->persist();

        return redirect()->route('admin.volunteer.index');
    }

    public function edit(Volunteer $volunteer): Response|ResponseFactory
    {
        return inertia('AdminVolunteers/Edit', [
            'volunteer' => VolunteerResource::make($volunteer),
            'shirtSizes' => ShirtSize::all(),
            'shifts' => ShiftResource::collection(Shift::all()),
            'spots' => VolunteerFilters::spots(),
        ]);
    }

    public function update(UpdateVolunteerRequest $request, Volunteer $volunteer): RedirectResponse
    {
        $request->persist($volunteer);

        return redirect()->route('admin.volunteer.index');
    }

    public function destroy(Volunteer $volunteer): RedirectResponse
    {
        $volunteer->delete();

        return redirect()->route('admin.volunteer.index');
    }

    public function destroyAll(): RedirectResponse
    {
        Volunteer::where('created_at', '!=', null)->delete();

        return redirect()->route('admin.volunteer.index');
    }
}
