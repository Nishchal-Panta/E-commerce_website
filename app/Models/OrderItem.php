<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductReturn;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price_at_purchase',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'price_at_purchase' => 'decimal:2',
        ];
    }

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function returns()
    {
        return $this->hasMany(ProductReturn::class);
    }

    // Helper methods
    public function getSubtotal(): float
    {
        return $this->quantity * $this->price_at_purchase;
    }
}
