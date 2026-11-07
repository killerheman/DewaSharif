<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelBooking extends Model
{
    use HasFactory;

    protected $table = 'hotel_bookings';

    protected $fillable = [
        'booking_code',
        'booking_number',
        'hotel_id',
        'hotel_name',
        'room_name',
        'customer_name',
        'customer_phone',
        'alternate_phone',
        'customer_email',
        'customer_address',
        'id_type',
        'id_no',
        'check_in_date',
        'check_out_date',
        'check_in',
        'check_out',
        'guests',
        'persons',
        'rooms',
        'nights',
        'price_per_night',
        'total_price',
        'total_amount',
        'amount',
        'paid_amount',
        'pending_amount',
        'payment_status',
        'booking_status',
        'status',
        'hotel_status',
        'payment_id',
        'payment_mode',
        'utr_number',
        'amenities',
        // Financial & Settlement Split
        'admin_commission_pct',
        'admin_commission_amount',
        'hotel_payout_amount',
        'checkin_pin',
        'checkin_verified_at',
        // Cancellation & Refund
        'cancellation_fee_total',
        'cancellation_admin_share',
        'cancellation_hotel_share',
        'cancellation_customer_refund',
        'refund_status', // none, pending, refunded
        'refund_utr',
        'refund_processed_at',
        // Payout to Hotel
        'settlement_status', // pending, paid
        'settlement_id',
    ];

    protected $casts = [
        'total_amount' => 'float',
        'paid_amount' => 'float',
        'admin_commission_amount' => 'float',
        'hotel_payout_amount' => 'float',
        'cancellation_fee_total' => 'float',
        'cancellation_admin_share' => 'float',
        'cancellation_hotel_share' => 'float',
        'cancellation_customer_refund' => 'float',
        'checkin_verified_at' => 'datetime',
        'refund_processed_at' => 'datetime',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }

    public function settlement()
    {
        return $this->belongsTo(HotelSettlement::class, 'settlement_id');
    }
}
