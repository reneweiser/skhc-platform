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
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Inertia\Response;
use Inertia\ResponseFactory;

class VolunteerController extends Controller
{
    public function create(): Response|ResponseFactory
    {
        $shirtSizes = ShirtSize::all();

        $shifts = ShiftResource::collection(Shift::all());

        $spots = DB::table('shift_times')
            ->join('assignments', 'assignments.shift_time_id', '=', 'shift_times.id')
            ->select('shift_times.id as shift_time_id', DB::raw('count(*) as signed_up'))
            ->groupBy('shift_time_id')
            ->get();

        return inertia('Volunteers/Create', compact('shirtSizes', 'shifts', 'spots'));
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
            'volunteer' => VolunteerResource::make($token->volunteer),
            'shirtSizes' => ShirtSize::all(),
            'shifts' => Shift::all()
        ]);
    }

    public function update(UpdateVolunteerRequest $request, Volunteer $volunteer): RedirectResponse
    {
        $request->persist($volunteer);

        return redirect()->route('volunteer.updated.notice')
            ->with('email', $volunteer->email);
    }

    public function destroy(Volunteer $volunteer): RedirectResponse
    {
        $email = $volunteer->email;

        $volunteer->delete();

        Mail::to($email)->send(new VolunteerDeleted());

        return redirect()->route('volunteer.deleted.notice')
            ->with('email', $email);
    }
}
