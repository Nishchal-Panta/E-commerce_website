<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        $products = [
            ['name' => 'Wireless Bluetooth Headphones', 'description' => 'Premium quality wireless headphones with noise cancellation and 30-hour battery life.', 'price' => 89.99, 'brand' => 'SoundMax', 'color' => 'Black', 'category' => 'Electronics', 'inventory_quantity' => 50, 'is_trending' => true],
            ['name' => 'Smart Watch Pro', 'description' => 'Advanced fitness tracking smartwatch with heart rate monitor and GPS.', 'price' => 299.99, 'brand' => 'TechWear', 'color' => 'Silver', 'category' => 'Electronics', 'inventory_quantity' => 30, 'is_trending' => true],
            ['name' => 'Leather Laptop Backpack', 'description' => 'Professional leather backpack with padded laptop compartment.', 'price' => 79.99, 'brand' => 'UrbanPack', 'color' => 'Brown', 'category' => 'Bags', 'inventory_quantity' => 25, 'is_trending' => false],
            ['name' => 'Running Shoes Air Max', 'description' => 'Lightweight running shoes with air cushioning technology.', 'price' => 129.99, 'brand' => 'SportFlex', 'color' => 'Blue', 'size' => '10', 'category' => 'Footwear', 'inventory_quantity' => 40, 'is_trending' => true],
            ['name' => 'Cotton T-Shirt Pack', 'description' => 'Pack of 3 premium cotton t-shirts in assorted colors.', 'price' => 29.99, 'brand' => 'ComfortWear', 'color' => 'Multi', 'size' => 'M', 'category' => 'Clothing', 'inventory_quantity' => 100, 'is_trending' => false],
            ['name' => '4K Action Camera', 'description' => 'Waterproof action camera with 4K video recording.', 'price' => 199.99, 'brand' => 'ProCam', 'color' => 'Black', 'category' => 'Electronics', 'inventory_quantity' => 20, 'is_trending' => true],
            ['name' => 'Yoga Mat Premium', 'description' => 'Extra thick non-slip yoga mat with carrying strap.', 'price' => 39.99, 'brand' => 'ZenFit', 'color' => 'Purple', 'category' => 'Sports', 'inventory_quantity' => 60, 'is_trending' => false],
            ['name' => 'Gaming Mouse RGB', 'description' => 'High-precision gaming mouse with customizable RGB lighting.', 'price' => 49.99, 'brand' => 'GamePro', 'color' => 'Black', 'category' => 'Electronics', 'inventory_quantity' => 35, 'is_trending' => true],
            ['name' => 'Portable Phone Charger', 'description' => '20000mAh power bank with fast charging.', 'price' => 34.99, 'brand' => 'PowerUp', 'color' => 'Black', 'category' => 'Electronics', 'inventory_quantity' => 70, 'is_trending' => false],
            ['name' => 'Bluetooth Speaker Portable', 'description' => 'Waterproof portable Bluetooth speaker with 360° sound.', 'price' => 54.99, 'brand' => 'SoundWave', 'color' => 'Blue', 'category' => 'Electronics', 'inventory_quantity' => 38, 'is_trending' => true],
        ];

        foreach ($products as $productData) {
            Product::create([
                'seller_id' => $admin->id,
                'name' => $productData['name'],
                'description' => $productData['description'],
                'price' => $productData['price'],
                'brand' => $productData['brand'] ?? null,
                'color' => $productData['color'] ?? null,
                'size' => $productData['size'] ?? null,
                'category' => $productData['category'],
                'inventory_quantity' => $productData['inventory_quantity'],
                'low_stock_threshold' => 10,
                'is_trending' => $productData['is_trending'],
            ]);
        }
    }
}
