<?php

namespace Database\Factories;
use App\Models\User;
use App\Models\LaundryRequest;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Branch;

/**
 * @extends Factory<LaundryRequest>
 */
class LaundryRequestFactory extends Factory
{

     protected $model = LaundryRequest::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    
    public function definition(): array
    {
        return [
            'customer_id' => User::factory()->create([
            'role' => 'customer',
        ])->id,


        'branch_id' => Branch::inRandomOrder()->first()?->id,

        'total_amount' => fake()->randomFloat(2, 100, 2000),

        'status' => fake()->randomElement([
            'pending',
            'approved',
            'processing',
            'completed',
            'cancelled',
        ]),

        'pickup_information_id' => null,
        'notes' => fake()->randomElement([
                'Please separate white clothes from colored clothes.',
                'Handle delicate clothes with care.',
                'Please do not use strong detergent.',
                'Call me before picking up the laundry.',
                'Please fold all clothes after washing.',
                'Remove stains carefully.',
                'No special instructions.',
                null,
            ]),
        ];
    }
}
