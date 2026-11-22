<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    public function definition(): array
    {
        $pricing = fake()->randomElement([
            [
                'pricing_type' => 'per_kg',
                'unit' => 'kg',
                'price' => 35,
            ],
            [
                'pricing_type' => 'per_piece',
                'unit' => 'piece',
                'price' => 100,
            ],
            [
                'pricing_type' => 'per_pair',
                'unit' => 'pair',
                'price' => 150,
            ],
            [
                'pricing_type' => 'fixed',
                'unit' => 'service',
                'price' => 50,
            ],
        ]);

        return [
            'service_name' => fake()->unique()->words(2, true),
            'description' => fake()->sentence(),
          
        ];
    }
}
