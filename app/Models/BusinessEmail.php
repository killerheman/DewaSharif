<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessEmail extends Model
{
    protected $guarded = [];

    protected $casts = [
        'registration_date' => 'date',
        'expiry_date' => 'date',
        'provider_response' => 'array',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
