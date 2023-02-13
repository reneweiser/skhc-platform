<?php

namespace Database\Factories;

use App\Models\Venue;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShiftFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'description' => fake()->text,
            'venue_id' => Venue::factory()->create()
        ];
    }
}
