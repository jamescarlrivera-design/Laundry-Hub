<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\PickupInformation;
use Illuminate\Database\Seeder;

class PickupInformationSeeder extends Seeder
{
    public function run(): void
    {
        $customer = User::where('role', 'customer')->get();

        PickupInformation::factory()->create([
            'user_id' => $customer->id= 4,
            'contact_number' => '09345678901',
            'address' => 'Inazuma',
            'landmark' => 'Near the Grand Narukami Shrine',
            'additional_instructions' => 'Please call before pickup.',
        ]);

        PickupInformation::factory()->create([
            'user_id' => $customer->id = 4,
            'contact_number' => '09234567891',
            'address' => 'Mondstadt',
            'landmark' => 'Near the Adventurers Guild',
            'additional_instructions' => 'Leave the laundry at the reception.',
        ]);

        PickupInformation::factory()->create([
            'user_id' => $customer->id = 4,
            'contact_number' => '09123456789',
            'address' => 'Liyue Harbor',
            'landmark' => 'Near the Wangsheng Funeral Parlor',
            'additional_instructions' => 'Please text me upon arrival.',
        ]);
    }
}