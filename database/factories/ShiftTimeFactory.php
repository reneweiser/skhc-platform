<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShiftTime>
 */
class ShiftTimeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'label' => fake()->text,
            'volunteers_needed' => fake()->numberBetween(1, 10)
        ];
    }
}
