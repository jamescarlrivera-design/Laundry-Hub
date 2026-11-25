<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\LaundryRequest;
use App\Models\PickupInformation;
use App\Models\Branch;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LaundryRequest>
 */
class LaundryRequestFactory extends Factory
{
    protected $model = LaundryRequest::class;

    public function definition(): array
    {
        // Randomly choose pickup or walk-in
        $fulfillmentType = fake()->randomElement([
            'pickup',
            'walk_in',
        ]);

        // Set fee depending on fulfillment type
        $fulfillmentFee = $fulfillmentType === 'pickup' ? 50 : 0;

        // Create a customer
        $customer = User::factory()->create([
            'role' => 'customer',
        ]);

        return [
            'customer_id' => $customer->id,

            'branch_id' => Branch::inRandomOrder()->first()?->id,

            'pickup_information_id' => $fulfillmentType === 'pickup'
                ? PickupInformation::factory()
                : null,

            'fulfillment_type' => $fulfillmentType,

            'fulfillment_fee' => $fulfillmentFee,

            'total_amount' => fake()->randomFloat(2, 100, 2000)
                + $fulfillmentFee,

            'status' => fake()->randomElement([
                'pending',
                'approved',
                'processing',
                'completed',
                'cancelled',
            ]),

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