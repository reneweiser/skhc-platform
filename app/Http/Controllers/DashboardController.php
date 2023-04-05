<?php

namespace App\Http\Controllers;

use App\Models\Volunteer;
use App\Skhc\VolunteerFilters;
use Illuminate\Support\Facades\DB;
use Inertia\Response;
use Inertia\ResponseFactory;

class DashboardController extends Controller
{
    public function __invoke(): Response|ResponseFactory
    {
        $count = DB::table('volunteers')->count();

        return inertia('Dashboard', [
            'count' => $count,
            'shoppingList' => VolunteerFilters::shirtShoppingList()
        ]);
    }
}
