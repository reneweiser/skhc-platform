<?php

namespace App\Console\Commands;

use App\Models\Shift;
use App\Models\Visibility;
use Illuminate\Console\Command;

class SetupVisibility extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'skhc:setup-visibility';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets up visibility for the first time after adding the column to shifts.';

    public function handle(): int
    {
        Visibility::create(['label' => 'private']);
        Visibility::create(['label' => 'public']);
        Shift::select()->update(['visibility_id' => 2]);

        return Command::SUCCESS;
    }
}
