<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        
        $products = [
            [
                'name' => 'Premium Wireless Headphones',
                'description' => 'High-quality wireless headphones with active noise cancellation, 30-hour battery life, and premium sound quality.',
                'price' => 199.99,
                'brand' => 'AudioTech',
                'color' => 'Black',
                'category' => 'Electronics',
                'inventory_quantity' => 50,
                'is_trending' => true,
            ],
            [
                'name' => 'Smart Watch Pro',
                'description' => 'Advanced fitness tracking, heart rate monitor, GPS, and smartphone notifications. Water-resistant up to 50 meters.',
                'price' => 299.99,
                'brand' => 'TechWear',
                'color' => 'Silver',
                'category' => 'Electronics',
                'inventory_quantity' => 35,
                'is_trending' => true,
            ],
            [
                'name' => 'Designer Leather Backpack',
                'description' => 'Stylish and functional leather backpack with laptop compartment. Perfect for work or travel.',
                'price' => 129.99,
                'brand' => 'UrbanStyle',
                'color' => 'Brown',
                'category' => 'Fashion',
                'inventory_quantity' => 25,
                'is_trending' => true,
            ],
            [
                'name' => 'Professional Camera Lens',
                'description' => '50mm f/1.8 prime lens for stunning portraits and low-light photography.',
                'price' => 449.99,
                'brand' => 'PhotoPro',
                'category' => 'Electronics',
                'inventory_quantity' => 15,
                'is_trending' => false,
            ],
            [
                'name' => 'Organic Cotton T-Shirt',
                'description' => '100% organic cotton, eco-friendly, comfortable fit. Available in multiple colors.',
                'price' => 29.99,
                'brand' => 'EcoWear',
                'color' => 'White',
                'size' => 'M',
                'category' => 'Fashion',
                'inventory_quantity' => 100,
                'is_trending' => false,
            ],
            [
                'name' => 'Portable Bluetooth Speaker',
                'description' => 'Waterproof portable speaker with 12-hour battery life and powerful bass.',
                'price' => 79.99,
                'brand' => 'SoundWave',
                'color' => 'Blue',
                'category' => 'Electronics',
                'inventory_quantity' => 60,
                'is_trending' => true,
            ],
            [
                'name' => 'Yoga Mat Premium',
                'description' => 'Extra thick, non-slip yoga mat perfect for all types of exercise. Eco-friendly material.',
                'price' => 49.99,
                'brand' => 'FitLife',
                'color' => 'Purple',
                'category' => 'Sports',
                'inventory_quantity' => 45,
                'is_trending' => true,
            ],
            [
                'name' => 'Stainless Steel Water Bottle',
                'description' => 'Insulated water bottle keeps drinks cold for 24 hours or hot for 12 hours. BPA-free.',
                'price' => 34.99,
                'brand' => 'HydroMax',
                'color' => 'Silver',
                'category' => 'Sports',
                'inventory_quantity' => 80,
                'is_trending' => false,
            ],
            [
                'name' => 'Gaming Mouse RGB',
                'description' => 'High-precision gaming mouse with customizable RGB lighting and programmable buttons.',
                'price' => 59.99,
                'brand' => 'GameGear',
                'color' => 'Black',
                'category' => 'Electronics',
                'inventory_quantity' => 40,
                'is_trending' => true,
            ],
            [
                'name' => 'Kitchen Knife Set',
                'description' => 'Professional 8-piece knife set with block. German stainless steel blades.',
                'price' => 149.99,
                'brand' => 'ChefMaster',
                'category' => 'Home & Kitchen',
                'inventory_quantity' => 20,
                'is_trending' => false,
            ],
            [
                'name' => 'Running Shoes Pro',
                'description' => 'Lightweight running shoes with advanced cushioning and breathable mesh upper.',
                'price' => 119.99,
                'brand' => 'SportFit',
                'color' => 'Black',
                'size' => '10',
                'category' => 'Sports',
                'inventory_quantity' => 55,
                'is_trending' => true,
            ],
            [
                'name' => 'Electric Toothbrush',
                'description' => 'Rechargeable electric toothbrush with multiple cleaning modes and timer.',
                'price' => 89.99,
                'brand' => 'DentalCare',
                'color' => 'White',
                'category' => 'Health & Beauty',
                'inventory_quantity' => 30,
                'is_trending' => false,
            ],
            [
                'name' => 'Desk Lamp LED',
                'description' => 'Adjustable LED desk lamp with touch control and USB charging port.',
                'price' => 44.99,
                'brand' => 'BrightLight',
                'color' => 'Black',
                'category' => 'Home & Kitchen',
                'inventory_quantity' => 65,
                'is_trending' => false,
            ],
            [
                'name' => 'Wireless Keyboard & Mouse Combo',
                'description' => 'Ergonomic wireless keyboard and mouse set with long battery life.',
                'price' => 69.99,
                'brand' => 'TechPro',
                'color' => 'Gray',
                'category' => 'Electronics',
                'inventory_quantity' => 50,
                'is_trending' => false,
            ],
            [
                'name' => 'Sunglasses Polarized',
                'description' => 'UV400 protection polarized sunglasses with durable frame.',
                'price' => 79.99,
                'brand' => 'SunStyle',
                'color' => 'Black',
                'category' => 'Fashion',
                'inventory_quantity' => 40,
                'is_trending' => false,
            ],
        ];
        
        foreach ($products as $productData) {
            $product = Product::create(array_merge($productData, [
                'seller_id' => $admin->id,
            ]));
            
            // Note: In production, you would add actual product images
            // For demo purposes, you can manually add images after setup
        }
    }
}
