<?php

namespace App\Http\Controllers;

use App\Models\EditToken;
use App\Models\Volunteer;
use Illuminate\Http\Request;

class StoreEditTokenController extends Controller
{
    public function __invoke(Request $request)
    {
        $validatedData = $request->validate([
            'email' => ['required', 'email', 'exists:volunteers,email']
        ]);

        $volunteer = Volunteer::whereEmail($validatedData['email'])->first();

        EditToken::create([
            'volunteer_id' => $volunteer->id,
            'email' => $volunteer->email,
        ]);

        return redirect()->route('dashboard');
    }
}
