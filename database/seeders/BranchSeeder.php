<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        $branches = [
            [
                'name' => 'Mondstadt Branch',
                'branch_code' => 'BR-001',
                'address' => 'mondstadt',
                'phone' => '09123456789',
                'email' => 'Mondstadt@laundryhub.com',
                'status' => 'active',
            ],
            [
                'name' => 'Inazuma Branch',
                'branch_code' => 'BR-002',
                'address' => 'Inazuma',
                'phone' => '09234567890',
                'email' => 'Inazuma@laundryhub.com',
                'status' => 'active',
            ],
            [
                'name' => 'Nod-Krai Branch',
                'branch_code' => 'BR-003',
                'address' => 'Nod-Krai',
                'phone' => '09345678901',
                'email' => 'NodKrai@laundryhub.com',
                'status' => 'active',
            ],
            [
                'name' => 'Fontaine Branch',
                'branch_code' => 'BR-004',
                'address' => 'Fontaine',
                'phone' => '09456789012',
                'email' => 'Fontaine@laundryhub.com',
                'status' => 'active',
            ],
        ];

        foreach ($branches as $branch) {
            Branch::updateOrCreate(
                ['branch_code' => $branch['branch_code']],
                $branch
            );
        }
    }
}
