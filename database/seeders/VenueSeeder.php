<?php

namespace Database\Seeders;

use App\Models\Venue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VenueSeeder extends Seeder
{
    public function run()
    {
        Venue::create([
            'name' => 'Seifenkistenrennen'
        ]);

        Venue::create([
            'name' => 'Jubelfeier'
        ]);
    }
}
