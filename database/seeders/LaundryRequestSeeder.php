<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LaundryRequest;
use App\Models\User;
use App\Models\Branch;
use App\Models\PickupInformation;

class LaundryRequestSeeder extends Seeder
{
    public function run(): void
    {
        $customers = User::where('role', 'customer')->get();

        $branches = Branch::where('status', 'active')->get();

        if ($branches->isEmpty()) {
            return;
        }

        foreach ($customers as $customer) {

            $pickupInformations = PickupInformation::where(
                'user_id',
                $customer->id
            )->get();

            // Randomly select pickup or walk-in
            $fulfillmentType = fake()->randomElement([
                'pickup',
                'walk_in'
            ]);

            // Pickup requires saved pickup information
            if ($fulfillmentType === 'pickup' && $pickupInformations->isEmpty()) {
                $fulfillmentType = 'walk_in';
            }

            $pickupInformation = $fulfillmentType === 'pickup'
                ? $pickupInformations->random()
                : null;

            $fulfillmentFee = $fulfillmentType === 'pickup' ? 50 : 0;

            // Sample service subtotal
            $subtotal = 200;

            LaundryRequest::create([
                'customer_id' => $customer->id,
                'branch_id' => $branches->random()->id,

                'pickup_information_id' => $pickupInformation?->id,

                'fulfillment_type' => $fulfillmentType,
                'fulfillment_fee' => $fulfillmentFee,

                'total_amount' => $subtotal + $fulfillmentFee,

                'status' => 'pending',
                'notes' => 'Sample laundry request.',
            ]);
        }
    }
}