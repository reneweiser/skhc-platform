<?php

namespace App\Http\Controllers;

use App\Mail\AdminAuthenticationRequested;
use App\Models\AdminAuthentication;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminAuthenticationController extends Controller
{
    public function store(): RedirectResponse
    {
        if (auth()->user())
            return redirect()->route('dashboard');

        $user = User::where('email', 'skhc@kulturtragwerk.de')->first();

        $authToken = AdminAuthentication::create([
            'user_id' => $user->id
        ]);

        Mail::to($user->email)->send(new AdminAuthenticationRequested($authToken));

        return redirect()->route('admin-auth.notice');
    }

    public function destroy(AdminAuthentication $adminAuthentication): RedirectResponse
    {
        if (!auth()->user()) {
            $user = $adminAuthentication->user;
            Auth::login($user);
            $adminAuthentication->delete();
        }

        return redirect()->route('dashboard');
    }

    public function notice(): Response|ResponseFactory
    {
        return inertia('Notices/LoginRequested');
    }
}
