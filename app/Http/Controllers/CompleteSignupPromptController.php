<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CompleteSignupPromptController extends Controller
{
    public function __invoke(Request $request): Response|RedirectResponse
    {
        if (!session()->has('email'))
            return redirect()->route('home');

        return Inertia::render('CompleteSignup', ['email' => session('email')]);
    }
}
