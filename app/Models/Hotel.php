<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $table = 'hotels';

    protected $fillable = [
        'partner_id',
        'name',
        'phone',
        'category',
        'category_name',
        'room_type',
        'ac_type',
        'bed_type',
        'max_adults',
        'max_children',
        'bath_type',
        'amenities',
        'location',
        'distance',
        'price',
        'price_per_night',
        'mrp',
        'available_rooms',
        'image',
        'image_main',
        'image_reception',
        'image_room',
        'image_bathroom',
        'image_extra',
        'image_6',
        'description',
        'status',
    ];

    public function bookings()
    {
        return $this->hasMany(HotelBooking::class, 'hotel_id');
    }

    public function partner()
    {
        return $this->belongsTo(HotelPartner::class, 'partner_id');
    }

    public function settlements()
    {
        return $this->hasMany(HotelSettlement::class, 'hotel_id')->orderBy('created_at', 'desc');
    }
}
