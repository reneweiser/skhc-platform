<?php

namespace App\Skhc;

use Illuminate\Support\Facades\DB;

class VolunteerFilters
{
    public static function shirtShoppingList() {
        return DB::table('volunteers')
            ->join('shirt_sizes', 'volunteers.shirt_size_id', '=', 'shirt_sizes.id')
            ->select('shirt_sizes.name', DB::raw('count(*) as total'))
            ->groupBy('shirt_size_id')
            ->get();
    }
}
