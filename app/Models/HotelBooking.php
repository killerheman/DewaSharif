<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelBooking extends Model
{
    use HasFactory;

    protected $table = 'hotel_bookings';

    protected $fillable = [
        'booking_number',
        'hotel_id',
        'hotel_name',
        'customer_name',
        'customer_phone',
        'customer_email',
        'check_in_date',
        'check_out_date',
        'guests',
        'rooms',
        'total_price',
        'payment_status',
        'booking_status',
        'payment_id',
        'address',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }
}
