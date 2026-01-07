<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'username' => 'admin',
            'email' => 'admin@ecommerce.com',
            'password' => Hash::make('Admin@123'),
            'role' => 'admin',
            'is_active' => true,
            'is_blocked' => false,
            'email_verified_at' => now(),
        ]);
        
        // Create a test buyer account
        User::create([
            'username' => 'testbuyer',
            'email' => 'buyer@example.com',
            'password' => Hash::make('Buyer@123'),
            'role' => 'buyer',
            'is_active' => true,
            'is_blocked' => false,
            'email_verified_at' => now(),
        ]);
    }
}
