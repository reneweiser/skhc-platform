<?php

namespace App\Http\Controllers;

use App\Http\Resources\VolunteerResource;
use App\Models\EditToken;
use App\Models\Shift;
use App\Models\ShirtSize;
use Inertia\Inertia;
use Inertia\Response;

class VolunteerAuthController extends Controller
{
    public function __invoke(EditToken $token): Response
    {
        $volunteer = $token->volunteer->with('assignments')->first();

        return Inertia::render('Volunteers/Edit', [
            'volunteer' => VolunteerResource::make($volunteer),
            'shirtSizes' => ShirtSize::all(),
            'shifts' => Shift::all()
        ]);
    }
}