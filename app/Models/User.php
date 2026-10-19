<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasRoles {
        hasRole as traitHasRole;
    }

    protected $guarded = [];

    public function getNameAttribute($value)
    {
        if ($this->first_name || $this->last_name) {
            return trim($this->first_name . ' ' . $this->last_name);
        }
        return $value;
    }

    public function getRoleAttribute($value)
    {
        if (!empty($value)) {
            return $value;
        }
        if (in_array(strtolower($this->email ?? ''), ['admin@dewa.com', 'admin@dewasharif.com'])) {
            return 'admin';
        }
        return 'customer';
    }

    public function hasRole($roles, string $guard = null): bool
    {
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('roles')) {
                return $this->traitHasRole($roles, $guard);
            }
        } catch (\Throwable $e) {}

        if (is_string($roles) && strtolower($roles) === 'admin') {
            return in_array(strtolower($this->email ?? ''), ['admin@dewa.com', 'admin@dewasharif.com']);
        }
        return false;
    }

    public function getFormattedIdAttribute(): string
    {
        return sprintf('%05d', $this->id);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}