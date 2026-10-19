<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'code',
        'type',
        'value',
        'expiry_date',
        'is_active',
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Check if the coupon is expired.
     */
    public function getIsExpiredAttribute(): bool
    {
        if (!$this->expiry_date) {
            return false;
        }
        return \Carbon\Carbon::parse($this->expiry_date)->endOfDay()->isPast();
    }

    /**
     * Check if the coupon is valid (active and not expired).
     */
    public function getIsValidAttribute(): bool
    {
        return $this->is_active && !$this->is_expired;
    }
}
