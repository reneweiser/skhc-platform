<?php

namespace App\Skhc;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class Shifts
{
    public static function fromCsvFile(string $filePath): Collection
    {
        $file = fopen($filePath, 'r');

        fgetcsv($file);

        $shifts = [];
        while ($row = fgetcsv($file, null, ';')) {
            $shifts[] = $row;
        }

        fclose($file);

        return Shifts::parse($shifts);
    }

    private static function parse(array $shifts): Collection
    {
        return collect($shifts)->map(function(array $shift) {
            return [
                'event' => $shift[0],
                'meeting_place' => $shift[1],
                'name' => $shift[2],
                'time' => $shift[3],
                'volunteers_needed' => (int)$shift[4],
                'description' => $shift[5],
            ];
        });
    }
}
