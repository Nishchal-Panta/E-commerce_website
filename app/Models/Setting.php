<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone_number',
        'admin_email',
        'location',
        'latitude',
        'longitude',
        'about_us',
    ];

    // Helper method to get single settings record
    public static function getSiteSettings()
    {
        return self::first() ?? self::create([
            'phone_number' => '',
            'admin_email' => '',
            'location' => '',
            'about_us' => '',
        ]);
    }
}
