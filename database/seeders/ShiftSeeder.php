<?php

namespace Database\Seeders;

use App\Models\Shift;
use App\Models\Venue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShiftSeeder extends Seeder
{
    public function run()
    {
        $raceVenue = Venue::where('name', 'Seifenkistenrennen')->first();
        $partyVenue = Venue::where('name', 'Jubelfeier')->first();

        $shifts = [
            [ 'name' => 'Aufbau', 'venue_id' => $raceVenue->id, ],
            [ 'name' => 'Abbau', 'venue_id' => $raceVenue->id, ],
            [ 'name' => 'Anmeldung', 'venue_id' => $raceVenue->id, ],
            [ 'name' => 'TÜV', 'venue_id' => $raceVenue->id, ],
            [ 'name' => 'Kisteneinweisung', 'venue_id' => $raceVenue->id, ],
            [ 'name' => 'Zeitmessung', 'venue_id' => $raceVenue->id, ],
            [ 'name' => 'Bar', 'venue_id' => $raceVenue->id, ],
            [ 'name' => 'Kuchenbar', 'venue_id' => $raceVenue->id, ],
            [ 'name' => 'Merchandise', 'venue_id' => $raceVenue->id, ],
            [ 'name' => 'Runner', 'venue_id' => $raceVenue->id, ],
            [ 'name' => 'Kinder basteln', 'venue_id' => $raceVenue->id, ],
            [ 'name' => 'Fotografen', 'venue_id' => $raceVenue->id, ],
            [ 'name' => 'Aufbau', 'venue_id' => $partyVenue->id, ],
            [ 'name' => 'Abbau', 'venue_id' => $partyVenue->id, ],
            [ 'name' => 'Bar', 'venue_id' => $partyVenue->id, ],
            [ 'name' => 'Runner', 'venue_id' => $partyVenue->id, ],
            [ 'name' => 'Einlass', 'venue_id' => $partyVenue->id, ],
            [ 'name' => 'Garderobe', 'venue_id' => $partyVenue->id, ],
            [ 'name' => 'Fotografen', 'venue_id' => $partyVenue->id, ],
        ];

        foreach ($shifts as $shift)
            Shift::create($shift);
    }
}
