<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $table = 'hotels';

    protected $fillable = [
        'name',
        'phone',
        'category',
        'category_name',
        'distance',
        'price',
        'mrp',
        'available_rooms',
        'image',
        'description',
        'status',
    ];

    public function bookings()
    {
        return $this->hasMany(HotelBooking::class, 'hotel_id');
    }
}
