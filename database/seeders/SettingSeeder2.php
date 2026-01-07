<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::create([
            'phone_number' => '+1-800-555-0123',
            'admin_email' => 'support@ecommerce.com',
            'location' => '123 Commerce Street, Tech City, TC 12345',
            'about_us' => 'We are a leading e-commerce platform providing quality products at competitive prices.',
        ]);
    }
}
