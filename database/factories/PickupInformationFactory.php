<?php

namespace Database\Factories;

use App\Models\PickupInformation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PickupInformation>
 */
class PickupInformationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            'user_id' => User::factory(),
            'address' => fake()->streetAddress() . ', ' . fake()->city(),
            'contact_number' => '09' . fake()->numerify('#########'),
            'landmark' => fake()->optional()->streetName(),
            'additional_instructions' => fake()->optional()->sentence(),
        ];
    }
}
