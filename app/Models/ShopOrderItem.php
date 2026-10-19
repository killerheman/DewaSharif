<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopOrderItem extends Model
{
    use HasFactory;

    protected $table = 'shop_order_items';

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'price',
        'quantity',
        'total_price',
    ];

    public function order()
    {
        return $this->belongsTo(ShopOrder::class, 'order_id');
    }
}
