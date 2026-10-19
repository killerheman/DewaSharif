<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DomainOrder extends Model
{
    protected $guarded = [];

    protected $casts = [
        'payment_response' => 'array',
        'provider_response' => 'array',
        'registered_at' => 'date',
        'expires_at' => 'date',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
