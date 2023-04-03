<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShiftFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'description' => fake()->text,
            'meeting_place' => fake()->text,
        ];
    }
}
