<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Branch;
use App\Models\Service;

class BranchServiceSeeder extends Seeder
{
    public function run(): void
    {
        $branches = Branch::whereIn('branch_code', [
            'BR-001',
            'BR-002',
            'BR-003',
            'BR-004',
        ])->get();

        $services = Service::all();

        foreach ($branches as $branch) {

            $serviceData = [];

            foreach ($services as $service) {

                $serviceData[$service->id] = [
                    'pricing_type' => 'per_kg',
                    'unit' => 'kg',
                    'price' => 35,
                    'is_active' => true,
                ];
            }

            $branch->services()->sync($serviceData);
        }
    }
}
