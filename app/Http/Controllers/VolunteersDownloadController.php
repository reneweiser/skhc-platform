<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class VolunteersDownloadController extends Controller
{
    private string $newLine = "\n";
    public function __invoke(): Response|Application|ResponseFactory
    {
        $content = DB::table('volunteers')
            ->join('assignments', 'volunteers.id', '=', 'assignments.volunteer_id')
            ->join('shift_times', 'shift_times.id', '=', 'assignments.shift_time_id')
            ->join('shirt_sizes', 'shirt_sizes.id', '=', 'volunteers.shirt_size_id')
            ->join('shifts', 'shifts.id', '=', 'shift_times.shift_id')
            ->select([
                'volunteers.first_name',
                'volunteers.last_name',
                'volunteers.email',
                'volunteers.mobile',
                'volunteers.verified',
                'shirt_sizes.name as shirt_size',
                'shifts.name as shift_name',
                'shifts.meeting_place',
                'shift_times.label',
            ])
            ->get()
            ->map(fn ($item) => (array)$item)
            ->reduce(function (string $acc, $curr) {
                $acc .= implode(';', $curr);
                $acc .= $this->newLine;
                return $acc;
            }, 'vorname;nachname;email;mobile;verifiziert;t_shirt_groesse;schicht;treffpunkt;schicht_zeit'.$this->newLine);

        return response($content, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="helfer.csv";'
        ]);
    }
}
