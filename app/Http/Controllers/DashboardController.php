<?php

namespace App\Http\Controllers;

use App\Models\Volunteer;
use App\Skhc\VolunteerFilters;
use Inertia\Response;
use Inertia\ResponseFactory;

class DashboardController extends Controller
{
    public function __invoke(): Response|ResponseFactory
    {
        return inertia('Dashboard', [
            'count' => Volunteer::count(),
            'shoppingList' => VolunteerFilters::shirtShoppingList(),
            'spotsFilled' => VolunteerFilters::openSpots()
                ->sortByDesc(fn($spot) => $spot->remaining)
                ->filter(fn($spot) => $spot->remaining > 0)
                ->values()
        ]);
    }
}
