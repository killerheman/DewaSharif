<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'gst' => 'decimal:2',
            'vendor_amount' => 'decimal:2',
            'net_amount' => 'decimal:2',
            'invoice_date' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getBillingAddressAttribute($value)
    {
        $address = $value;

        if (!$address && $this->user) {
            $user = $this->user;
            $city = optional($user->city)->name ?? (is_string($user->city) ? $user->city : '');
            $state = optional($user->state)->name ?? (is_string($user->state) ? $user->state : '');
            $country = optional($user->country)->name ?? (is_string($user->country) ? $user->country : '');
            $address = implode(', ', array_filter(array_map('trim', [
                $user->address,
                $city,
                $state,
                $country,
                $user->zip_code
            ])));
        }

        if (!$address) return '-';

        // Convert stringified JSON objects (e.g. {"id":58138,"name":"Bara Banki"...}) to their name attribute
        $address = preg_replace_callback('/\{[^{}]*\}/', function ($match) {
            $json = json_decode($match[0], true);
            if (is_array($json) && isset($json['name'])) {
                return $json['name'];
            }
            return '';
        }, $address);

        // Clean double commas and trailing spaces/commas
        $address = preg_replace('/,\s*,+/', ',', $address);
        $address = trim($address, " \t\n\r\0\x0B,");

        return $address ?: '-';
    }
}