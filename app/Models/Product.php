<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'name',
        'description',
        'price',
        'brand',
        'color',
        'size',
        'category',
        'inventory_quantity',
        'low_stock_threshold',
        'is_trending',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'inventory_quantity' => 'integer',
            'low_stock_threshold' => 'integer',
            'is_trending' => 'boolean',
        ];
    }

    // Relationships
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    // Helper methods
    public function isLowStock(): bool
    {
        return $this->inventory_quantity <= $this->low_stock_threshold;
    }

    public function isOutOfStock(): bool
    {
        return $this->inventory_quantity <= 0;
    }

    public function isInStock(): bool
    {
        return $this->inventory_quantity > 0;
    }

    public function getPrimaryImage()
    {
        return $this->images()->where('is_primary', true)->first() 
            ?? $this->images()->first();
    }

    // Accessor for primary image
    public function getPrimaryImageAttribute()
    {
        return $this->getPrimaryImage();
    }

    public function getAverageRating(): float
    {
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }

    public function getReviewCount(): int
    {
        return $this->reviews()->count();
    }

    public function getTotalSold(): int
    {
        return $this->orderItems()->sum('quantity');
    }

    public function getRatingBreakdown(): array
    {
        $total = $this->getReviewCount();
        if ($total === 0) {
            return [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
        }

        $breakdown = [];
        for ($i = 1; $i <= 5; $i++) {
            $count = $this->reviews()->where('rating', $i)->count();
            $breakdown[$i] = round(($count / $total) * 100, 1);
        }
        return $breakdown;
    }

    public function decrementStock(int $quantity): void
    {
        $this->decrement('inventory_quantity', $quantity);
    }

    public function incrementStock(int $quantity): void
    {
        $this->increment('inventory_quantity', $quantity);
    }
}
