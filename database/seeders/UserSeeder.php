<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::create([
            'username' => 'admin',
            'email' => 'admin@ecommerce.com',
            'password' => Hash::make('Admin@123'),
            'role' => 'admin',
            'is_active' => true,
            'is_blocked' => false,
            'email_verified_at' => now(),
        ]);

        // Create Sample Buyer Users
        User::create([
            'username' => 'john_doe',
            'email' => 'john@example.com',
            'password' => Hash::make('Password@123'),
            'role' => 'buyer',
            'is_active' => true,
            'is_blocked' => false,
            'email_verified_at' => now(),
        ]);

        User::create([
            'username' => 'jane_smith',
            'email' => 'jane@example.com',
            'password' => Hash::make('Password@123'),
            'role' => 'buyer',
            'is_active' => true,
            'is_blocked' => false,
            'email_verified_at' => now(),
        ]);
    }
}
