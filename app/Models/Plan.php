<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'offer_percentage'=>'integer',
            'price'=>'decimal:2',
            'mrp'=>'decimal:2',
            'faqs'=>'array',
            'sort_order'=>'integer',
            'is_active'=>'boolean',
        ];
    }
}
