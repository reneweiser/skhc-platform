<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\Shift;
use App\Models\ShiftTime;
use App\Skhc\Shifts;
use Illuminate\Console\Command;

class ImportShifts extends Command
{
    protected $signature = 'skhc:import-shifts';

    protected $description = 'Command description';

    public function handle(): void
    {
        $shifts = Shifts::fromCsvFile(storage_path('app/public/shifts.csv'));

        foreach ($shifts as $shiftData) {
            $event = Event::firstOrCreate([
                'name' => $shiftData['event']
            ]);

            $shift = Shift::firstOrCreate(
                [
                    'event_id' => $event->id,
                    'name' => $shiftData['name']
                ],
                [
                    'meeting_place' => $shiftData['meeting_place'],
                    'description' => $shiftData['description'],
                ]
            );

            ShiftTime::firstOrCreate([
                'shift_id' => $shift->id,
                'label' => $shiftData['time'],
                'volunteers_needed' => $shiftData['volunteers_needed'],
            ]);
        }
    }
}
