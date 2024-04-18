<?php

namespace Database\Seeders;

use App\Models\ShiftTime;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FakeShiftTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ShiftTime::all()->each(function (ShiftTime $shiftTime) {
            $s = fake()->dateTimeBetween('2024-04-30', '2024-05-03');

            $shiftTime->update([
                'start' => Carbon::parse($s),
                'end' => Carbon::parse($s)->addHours(4),
            ]);
        });
    }
}
