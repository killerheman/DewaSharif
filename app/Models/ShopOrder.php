<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopOrder extends Model
{
    use HasFactory;

    protected $table = 'shop_orders';

    protected $fillable = [
        'order_number',
        'customer_name',
        'customer_phone',
        'customer_email',
        'country',
        'state',
        'city',
        'pincode',
        'street_address',
        'landmark',
        'address_type',
        'payment_method',
        'payment_status',
        'order_status',
        'subtotal',
        'delivery_fee',
        'grand_total',
        'payment_id',
    ];

    public function items()
    {
        return $this->hasMany(ShopOrderItem::class, 'order_id');
    }
}
