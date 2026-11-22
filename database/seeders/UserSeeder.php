<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Branch;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

           $branch1 = Branch::findOrFail(2);
           $branch2 = Branch::findOrFail(3);


           User::create([
            'name' => 'Phanes',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('password123'),
        ]);


          // Staff account
        User::create([
            'name' => 'Nukvah',
            'email' => 'staff@gmail.com',
            'role' => 'staff',
            'password' => Hash::make('password123'),
            'branch_id' => $branch1->id,
        ]);

        // Customer account
        User::create([
            'name' => 'Traveler',
            'email' => 'customer@gmail.com',
            'role' => 'customer',
            'password' => Hash::make('password123'),
        ]);

        // Create 10 customer accounts
        User::factory(10)->create();
    }
}
