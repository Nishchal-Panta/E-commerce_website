<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'profile_photo',
        'role',
        'is_active',
        'is_blocked',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'is_blocked' => 'boolean',
        ];
    }

    // Relationships
    public function products()
    {
        return $this->hasMany(Product::class, 'seller_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'buyer_id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'buyer_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'buyer_id');
    }

    public function bugReports()
    {
        return $this->hasMany(BugReport::class);
    }

    // Helper methods
    public function isAdmin(): bool
    {
        // Check if user's role is admin
        if ($this->role === 'admin') {
            return true;
        }
        
        // Check if user's email is in the ACL authorized list
        $authorizedEmails = config('acl.authorized_admin_emails', []);
        return in_array($this->email, $authorizedEmails);
    }
    
    public function isSuperAdmin(): bool
    {
        $superAdminEmails = config('acl.super_admin_emails', []);
        return in_array($this->email, $superAdminEmails);
    }

    public function isBuyer(): bool
    {
        return $this->role === 'buyer';
    }

    public function isBlocked(): bool
    {
        return $this->is_blocked;
    }

    public function getCartItemCount(): int
    {
        return $this->carts()->sum('quantity');
    }

    public function hasPurchased($productId): bool
    {
        return $this->orders()
            ->whereHas('orderItems', function ($query) use ($productId) {
                $query->where('product_id', $productId);
            })
            ->where(function ($query) {
                $query->where('payment_status', 'completed')
                      ->orWhere('status', 'delivered');
            })
            ->exists();
    }
}
