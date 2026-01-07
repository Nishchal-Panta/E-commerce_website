<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'review_id',
        'photo_path',
    ];

    // Relationships
    public function review()
    {
        return $this->belongsTo(Review::class);
    }

    public function getPhotoUrl(): string
    {
        return asset('storage/' . $this->photo_path);
    }
}
