<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RealTimeTestSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        User::updateOrCreate(
            ['email' => 'admin@apb.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => User::ROLE_ADMIN,
                'status' => 'approved',
                'teller_id' => 'A0001',
            ]
        );

        // Create Teller
        User::updateOrCreate(
            ['email' => 'teller@apb.com'],
            [
                'name' => 'Test Teller',
                'password' => Hash::make('password'),
                'role' => User::ROLE_TELLER,
                'status' => 'approved',
                'teller_id' => 'T1001',
                // Assuming branch/unit are optional or nullable, otherwise we might need to fetch one
                'profile_completed_at' => now(),
            ]
        );
    }
}
