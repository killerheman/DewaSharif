<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class HotelPartner extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'hotel_partners';

    protected $fillable = [
        'hotel_id',
        'name',
        'hotel_name',
        'email',
        'phone',
        'password',
        'status', // active, suspended, pending_approval
        'bank_name',
        'account_no',
        'account_holder',
        'ifsc_code',
        'upi_id',
        'commission_rate', // default 20.00
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'commission_rate' => 'float',
        ];
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }

    public function settlements()
    {
        return $this->hasMany(HotelSettlement::class, 'hotel_partner_id')->orderBy('created_at', 'desc');
    }

    public function bookings()
    {
        return $this->hasMany(HotelBooking::class, 'hotel_id', 'hotel_id');
    }
}
