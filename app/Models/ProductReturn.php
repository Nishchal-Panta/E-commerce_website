<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReturn extends Model
{
    use HasFactory;
    
    protected $table = 'returns';

    protected $fillable = [
        'order_id',
        'order_item_id',
        'user_id',
        'return_reason_id',
        'custom_reason',
        'status',
        'requested_at',
        'approved_at',
        'rejected_at',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'requested_at' => 'datetime',
            'approved_at' => 'datetime',
            'rejected_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function returnReason()
    {
        return $this->belongsTo(ReturnReason::class);
    }

    // Helper methods
    public function getStatusBadgeClass(): string
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'approved' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
            'completed' => 'bg-blue-100 text-blue-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function canBeReturned(): bool
    {
        // Order must be delivered or completed
        return in_array($this->order->status, ['delivered', 'completed']);
    }
}
