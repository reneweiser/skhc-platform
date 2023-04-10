<?php

namespace App\Http\Controllers;

use App\Skhc\VolunteerFilters;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class VolunteersDownloadController extends Controller
{
    private string $newLine = "\n";
    public function __invoke(): Response|Application|ResponseFactory
    {
        $content = VolunteerFilters::volunteerInfo()
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
