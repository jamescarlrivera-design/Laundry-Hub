<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LaundryRequest;

class LaundryRequestSeeder extends Seeder
{
    public function run(): void
    {
        LaundryRequest::factory(4)->create([
             'customer_id' => 4,
        ]);
        
    }
}