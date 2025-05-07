<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'license_plate', 'type', 'brand', 'color', 'is_stolen'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
