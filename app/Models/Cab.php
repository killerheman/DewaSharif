<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cab extends Model
{
    use HasFactory;

    protected $table = 'cabs';

    protected $fillable = [
        'name',
        'type',
        'seats',
        'ac',
        'luggage',
        'image',
        'price_per_km',
        'status',
    ];
}
