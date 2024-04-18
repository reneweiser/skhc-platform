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

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        ShiftTime::create($request->validate([
            'shift_id' => 'exists:shifts,id',
            'label' => 'required|string',
            'volunteers_needed' => 'required|numeric',
            'start' => 'required|date',
            'end' => 'date'
        ]));

        return to_route('shift-times.index');
    }

    public function destroy(ShiftTime $shift_time): \Illuminate\Http\RedirectResponse
    {
        $shift_time->delete();

        return to_route('shift-times.index');
    }

    public function update(Request $request, Shift $shift, ShiftTime $shift_time): \Illuminate\Http\RedirectResponse
    {
        $shift_time->update($request->validate([
            'label' => 'required|string',
            'volunteers_needed' => 'required|numeric',
            'start' => 'required|date',
            'end' => 'date|nullable',
            'shift_id' => 'exists:shifts,id'
        ]));

        return to_route('shift-times.index', $shift);
    }
}
