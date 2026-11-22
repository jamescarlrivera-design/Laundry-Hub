<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'service_name' => 'Wash-Dry and Fold',
                'description' => 'Washing, drying, and folding clothes.',
                'pricing_type' => 'per_kg',
                'unit' => 'kg',
                'price' => 35,
                'status' => 'active',
            ],
            [
                'service_name' => 'Wash-Only',
                'description' => 'Professional cleaning service.',
                'pricing_type' => 'per_kg',
                'unit' => 'kg',
                'price' => 25,
                'status' => 'active',
            ],
            [
                'service_name' => 'Shoe Cleaning',
                'description' => 'Cleaning and refreshing footwear.',
                'pricing_type' => 'per_pair',
                'unit' => 'pair',
                'price' => 150,
                'status' => 'active',
            ],
         
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['service_name' => $service['service_name']],
                $service
            );
        }
    }
}
