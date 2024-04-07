<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Shift;
use App\Models\Visibility;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShiftController extends Controller
{
    public function index(): \Inertia\Response
    {
        return Inertia::render('Shifts/Index', [
            'shifts' => Shift::with(['event', 'visibility'])->get(),
            'events' => Event::all(),
            'visibilities' => Visibility::all(),
        ]);
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        Shift::create($request->validate([
            'event_id' => 'exists:events,id',
            'visibility_id' => 'exists:visibilities,id',
            'name' => 'string|required',
            'meeting_place' => 'string',
            'description' => 'string',
        ]));

        return to_route('shifts.index');
    }

    public function update(Request $request, Shift $shift): \Illuminate\Http\RedirectResponse
    {
        $shift->update($request->validate([
            'event_id' => 'exists:events,id',
            'name' => 'string|required',
            'visibility_id' => 'exists:visibilities,id',
            'meeting_place' => 'string',
            'description' => 'string',
        ]));

        return to_route('shifts.index');
    }

    public function destroy(Shift $shift): \Illuminate\Http\RedirectResponse
    {
        $shift->delete();

        return to_route('shifts.index');
    }
}
