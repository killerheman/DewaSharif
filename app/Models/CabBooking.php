<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CabBooking extends Model
{
    use HasFactory;

    protected $table = 'cab_bookings';

    protected $fillable = [
        'booking_number',
        'cab_name',
        'route_name',
        'pickup_location',
        'drop_location',
        'travel_date',
        'travel_time',
        'customer_name',
        'customer_phone',
        'customer_email',
        'total_amount',
        'payment_status',
        'booking_status',
        'payment_id',
    ];
}
