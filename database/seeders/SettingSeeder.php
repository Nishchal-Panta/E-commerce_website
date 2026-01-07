<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::create([
            'phone_number' => '+1 (555) 123-4567',
            'admin_email' => 'support@ecommerce.com',
            'location' => '123 E-Commerce Street, Shopping District, New York, NY 10001',
            'about_us' => 'Welcome to E-Shop, your trusted online shopping destination. We offer a wide range of quality products at competitive prices with excellent customer service.',
        ]);
    }
}
