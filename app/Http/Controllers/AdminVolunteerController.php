<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVolunteerRequest;
use App\Http\Requests\UpdateVolunteerRequest;
use App\Http\Resources\ShiftResource;
use App\Http\Resources\VolunteerResource;
use App\Models\Shift;
use App\Models\ShiftTime;
use App\Models\ShirtSize;
use App\Models\Volunteer;
use App\Skhc\VolunteerFilters;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AdminVolunteerController extends Controller
{
    public function index(): \Inertia\Response
    {
        return Inertia::render('AdminVolunteers/Index', [
            'volunteers' => VolunteerResource::collection(Volunteer::with('assignments')->get()),
            'shift_times' => ShiftTime::with('shift.event')->get(),
            'shirt_sizes' => ShirtSize::all()
        ]);
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validate = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|unique:volunteers,email',
            'mobile' => 'required|string',
            'shirt_size_id' => 'exists:shirt_sizes,id',
            'shift_time_ids' => 'array|min:1',
            'shift_time_ids.*' => 'exists:shift_times,id',
        ]);

        DB::transaction(function () use ($validate) {
            $volunteer = Volunteer::create(Arr::except($validate, ['shift_time_ids']));
            $volunteer->assign($validate['shift_time_ids']);
        });

        return to_route('volunteers.index');
    }

    public function update(Request $request, Volunteer $volunteer): \Illuminate\Http\RedirectResponse
    {
        $validate = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|unique:volunteers,email,'.$volunteer->id,
            'mobile' => 'required|string',
            'shirt_size_id' => 'exists:shirt_sizes,id',
            'shift_time_ids' => 'array|min:1',
            'shift_time_ids.*' => 'exists:shift_times,id',
        ]);

        DB::transaction(function () use ($volunteer, $validate) {
            $volunteer->update(Arr::except($validate, ['shift_time_ids']));
            $volunteer->assign($validate['shift_time_ids']);
        });

        return to_route('volunteers.index');
    }
}
