<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HostingOrder extends Model
{
    protected $guarded = [];

    protected $casts = [
        'payment_response' => 'array',
        'starts_at'        => 'datetime',
        'expires_at'       => 'datetime',
        'price'            => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hosting()
    {
        return $this->belongsTo(Hosting::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
