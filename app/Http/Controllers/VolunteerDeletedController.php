<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class VolunteerDeletedController extends Controller
{
    public function __invoke(Request $request): Response|ResponseFactory
    {
        return inertia('Notices/VolunteerDeletedNotice');
    }
}
