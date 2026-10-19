<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Domain extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'register_price' => 'decimal:2',
            'renewal_price' => 'decimal:2',
            'transfer_price' => 'decimal:2',
            'bulk_transfer_price' => 'decimal:2',

            'min_year' => 'integer',
            'max_year' => 'integer',

            'is_premium' => 'boolean',
            'privacy_protection' => 'boolean',
            'dns_management' => 'boolean',
            'email_forwarding' => 'boolean',

            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }
}