<?php

namespace App\Http\Controllers;

use App\Http\Resources\VolunteerResource;
use App\Models\EditToken;
use App\Models\Shift;
use App\Models\ShirtSize;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VolunteerAuthController extends Controller
{
    public function __invoke(EditToken $token)
    {
        $volunteer = $token->volunteer->with('assignments')->first();

        return Inertia::render('Volunteers/Edit', [
            'volunteer' => VolunteerResource::make($volunteer),
            'shirtSizes' => ShirtSize::all(),
            'shifts' => Shift::all()
        ]);
    }
}
