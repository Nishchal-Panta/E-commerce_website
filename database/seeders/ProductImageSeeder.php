<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProductImageSeeder extends Seeder
{
    public function run(): void
    {
        // Get all products
        $products = Product::all();
        
        // For each product, create placeholder images
        foreach ($products as $product) {
            // Create 1-3 images per product
            $imageCount = rand(1, 3);
            
            for ($i = 0; $i < $imageCount; $i++) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $this->createPlaceholderImage($product, $i),
                    'is_primary' => $i === 0, // First image is primary
                ]);
            }
        }
    }
    
    /**
     * Create a placeholder image using a placeholder service
     */
    private function createPlaceholderImage($product, $index): string
    {
        // Create products directory if it doesn't exist
        $directory = 'products';
        if (!Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->makeDirectory($directory);
        }
        
        // Use product ID and index to create unique placeholder
        $filename = "product_{$product->id}_image_{$index}.jpg";
        $filepath = "{$directory}/{$filename}";
        $fullPath = storage_path('app/public/' . $filepath);
        
        // Download placeholder image from placeholder service
        // Using picsum.photos for random placeholder images
        $imageUrl = "https://picsum.photos/800/800?random=" . ($product->id * 100 + $index);
        
        try {
            $imageContent = file_get_contents($imageUrl);
            if ($imageContent !== false) {
                file_put_contents($fullPath, $imageContent);
            } else {
                // Fallback: create empty file marker
                touch($fullPath);
            }
        } catch (\Exception $e) {
            // Fallback: create empty file marker
            touch($fullPath);
        }
        
        return $filepath;
    }
    
    /**
     * Convert HSL to RGB
     */
    private function hslToRgb($h, $s, $l): array
    {
        $h /= 360;
        $s /= 100;
        $l /= 100;
        
        if ($s == 0) {
            $r = $g = $b = $l;
        } else {
            $q = $l < 0.5 ? $l * (1 + $s) : $l + $s - $l * $s;
            $p = 2 * $l - $q;
            
            $r = $this->hueToRgb($p, $q, $h + 1/3);
            $g = $this->hueToRgb($p, $q, $h);
            $b = $this->hueToRgb($p, $q, $h - 1/3);
        }
        
        return [round($r * 255), round($g * 255), round($b * 255)];
    }
    
    private function hueToRgb($p, $q, $t): float
    {
        if ($t < 0) $t += 1;
        if ($t > 1) $t -= 1;
        if ($t < 1/6) return $p + ($q - $p) * 6 * $t;
        if ($t < 1/2) return $q;
        if ($t < 2/3) return $p + ($q - $p) * (2/3 - $t) * 6;
        return $p;
    }
}
