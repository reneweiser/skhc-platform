<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class VolunteerUpdatedController extends Controller
{
    public function __invoke(Request $request): Response|ResponseFactory|RedirectResponse
    {
        if (!session()->has('email'))
            return redirect()->route('process.expired');

        return inertia('Notices/VolunteerUpdatedNotice', ['email' => session('email')]);
    }
}
