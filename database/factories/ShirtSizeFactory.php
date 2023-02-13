<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ShirtSizeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement([
                'sm',
                'm',
                'l',
                'xl',
                'xxl',
                'xxxl',
            ])
        ];
    }
}
