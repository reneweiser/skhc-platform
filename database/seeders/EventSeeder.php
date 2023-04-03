<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Shift;
use App\Models\ShiftTime;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run()
    {
        $race = Event::create(['name' => 'Seifenkistenrennen']);
        $party = Event::create(['name' => 'Jubelfeier']);

        $shifts = Shift::factory()
            ->count(5)
            ->state(new Sequence(
                ['event_id' => $race->id],
                ['event_id' => $party->id],
            ))
            ->create();

        $shifts->each(function (Shift $shift) {
            ShiftTime::factory()->count(5)->create(['shift_id' => $shift->id]);
        });
    }
}
