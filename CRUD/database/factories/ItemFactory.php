<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    public function definition(): array
    {
        $categories = ['Economy', 'Compact', 'SUV', 'Luxury', 'Electric', 'Van'];

        return [
            'product' => fake()->unique()->words(2, true),
            'category' => fake()->randomElement($categories),
            'quantity' => fake()->numberBetween(1, 20),
            'price' => fake()->numberBetween(30, 200),
        ];
    }
}
