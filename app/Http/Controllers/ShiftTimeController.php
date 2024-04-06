<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Shift;
use App\Models\ShiftTime;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShiftTimeController extends Controller
{
    public function index(): \Inertia\Response
    {
        return Inertia::render('ShiftTimes/Index', [
            'shiftTimes' => ShiftTime::with('shift')->get(),
            'events' => Event::with('shifts')->get(),
        ]);
    }

    public function store(Shift $shift): \Illuminate\Http\RedirectResponse
    {
        $shift->shiftTimes()->create([
            'label' => 'Neuer timeslot',
            'volunteers_needed' => 1,
            'start' => now(),
            'end' => now()->addHour()
        ]);

        return to_route('shifts.edit', $shift);
    }

    public function destroy(Shift $shift, ShiftTime $shift_time): \Illuminate\Http\RedirectResponse
    {
        $shift_time->delete();

        return to_route('shifts.edit', $shift);
    }

    public function update(Request $request, Shift $shift, ShiftTime $shift_time): \Illuminate\Http\RedirectResponse
    {
        $shift_time->update($request->validate([
            'label' => 'string',
            'volunteers_needed' => 'numeric',
            'start' => 'date',
            'end' => 'date'
        ]));

        return to_route('shift-times.index', $shift);
    }
}
