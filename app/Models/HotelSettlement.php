<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelSettlement extends Model
{
    use HasFactory;

    protected $table = 'hotel_settlements';

    protected $fillable = [
        'settlement_code',
        'hotel_id',
        'hotel_partner_id',
        'amount_paid',
        'remaining_balance',
        'payment_mode',
        'transaction_ref',
        'admin_notes',
        'settled_by_admin_id',
        'settled_at',
    ];

    protected $casts = [
        'amount_paid' => 'float',
        'remaining_balance' => 'float',
        'settled_at' => 'datetime',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }

    public function partner()
    {
        return $this->belongsTo(HotelPartner::class, 'hotel_partner_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'settled_by_admin_id');
    }
}
