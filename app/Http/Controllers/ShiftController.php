<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Shift;
use App\Models\ShiftTime;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Inertia\ResponseFactory;

class ShiftController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        return inertia('Shifts/Index', [
            'shifts' => ShiftTime::orderByDesc('updated_at')->with('shift.event')->get()
        ]);
    }

    public function create(): Response|ResponseFactory
    {
        return inertia('Shifts/Create', [
            'events' => Event::select(['name', 'id'])->get()
        ]);
    }

    public function store(): RedirectResponse
    {
        $validated = request()->validate([
            'event' => 'exists:events,id',
            'name' => 'string|required',
            'meeting_place' => 'string',
            'description' => 'string',
            'shift_times' => 'array',
            'shift_times.*' => 'array',
            'shift_times.*.label' => 'string',
            'shift_times.*.volunteers_needed' => 'numeric',
        ]);

        $shift = new Shift();
        $shift->event_id = (int)$validated['event'];
        $shift->name = $validated['name'];
        $shift->meeting_place = $validated['meeting_place'];
        $shift->description = $validated['description'];
        $shift->save();

        $shift = $shift->refresh();

        foreach($validated['shift_times'] as $shift_time) {
            $shiftTime = new ShiftTime();
            $shiftTime->shift_id = $shift->id;
            $shiftTime->label = $shift_time['label'];
            $shiftTime->volunteers_needed = $shift_time['volunteers_needed'];
            $shiftTime->save();
        }

        return redirect()->route('shifts.index');
    }

    public function edit(Shift $shift)
    {
        return inertia('Shifts/Edit', [
            'events' => Event::select(['name', 'id'])->get(),
            'shift' => Shift::with('shiftTimes')->where('id', $shift->id)->first(),
        ]);
    }

    public function update(Shift $shift)
    {
        $validated = request()->validate([
            'event' => 'exists:events,id',
            'name' => 'string|required',
            'meeting_place' => 'string',
            'description' => 'string',
            'shift_times' => 'array',
            'shift_times.*' => 'array',
            'shift_times.*.id' => 'numeric',
            'shift_times.*.label' => 'string',
            'shift_times.*.volunteers_needed' => 'numeric',
        ]);

        $shift->event_id = (int)$validated['event'];
        $shift->name = $validated['name'];
        $shift->meeting_place = $validated['meeting_place'];
        $shift->description = $validated['description'];
        $shift->save();

        foreach($validated['shift_times'] as $shift_time) {
            $id = array_key_exists('id', $shift_time) ? $shift_time['id'] : 0;
            $shift_time['shift_id'] = $shift->id;
            ShiftTime::updateOrCreate(['id' => $id], $shift_time);
        }

        return redirect()->route('shifts.index');
    }

    public function destroy(Shift $shift): RedirectResponse
    {
        $shift->delete();

        return redirect()->route('shifts.index');
    }
}
