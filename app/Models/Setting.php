<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Setting extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static ?array $cachedSettings = null;

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'key_capabilities_items' => 'array',
        ];
    }

    public static function loadSettingsMap(): array
    {
        if (static::$cachedSettings === null) {
            try {
                if (Schema::hasTable('settings')) {
                    static::$cachedSettings = DB::table('settings')->pluck('value', 'key')->all();
                } else {
                    static::$cachedSettings = [];
                }
            } catch (\Throwable $e) {
                static::$cachedSettings = [];
            }
        }
        return static::$cachedSettings;
    }

    public static function getVal($key, $default = null)
    {
        $map = static::loadSettingsMap();
        return $map[$key] ?? $default;
    }

    public static function setVal($key, $value, $group = 'general')
    {
        if (is_array($value)) {
            $value = json_encode($value);
        }
        try {
            DB::table('settings')->updateOrInsert(
                ['key' => $key],
                [
                    'value' => $value,
                    'group' => $group,
                    'updated_at' => now(),
                ]
            );
        } catch (\Throwable $e) {}

        if (static::$cachedSettings !== null) {
            static::$cachedSettings[$key] = $value;
        }
    }

    public function getAttribute($key)
    {
        // 1. Native table column on the current record (id, created_at, updated_at)
        if (in_array($key, ['id', 'created_at', 'updated_at'])) {
            return parent::getAttribute($key);
        }

        // 2. Look up in settings key-value map
        $map = static::loadSettingsMap();
        if (array_key_exists($key, $map) && $map[$key] !== null && $map[$key] !== '') {
            $val = $map[$key];
            if ($key === 'key_capabilities_items') {
                $decoded = json_decode($val, true);
                return is_array($decoded) ? $decoded : [];
            }
            if ($key === 'is_active' || $key === 'promo_bar_enabled') {
                return (bool) $val;
            }
            return $val;
        }

        // 3. Aliases & Fallbacks
        if ($key === 'website_phone') {
            return $map['phone'] ?? ($map['support_phone'] ?? null);
        }
        if ($key === 'phone') {
            return $map['website_phone'] ?? ($map['support_phone'] ?? null);
        }
        if ($key === 'whatsapp') {
            return $map['whatsapp_number'] ?? ($map['website_phone'] ?? ($map['phone'] ?? null));
        }
        if ($key === 'website_email') {
            return $map['support_email'] ?? ($map['company_email'] ?? null);
        }
        if ($key === 'company_email') {
            return $map['website_email'] ?? ($map['support_email'] ?? null);
        }

        // Mail / SMTP Fallbacks
        if ($key === 'mail_mailer') {
            return $map['mail_mailer'] ?? env('MAIL_MAILER', 'smtp');
        }
        if ($key === 'mail_host') {
            return $map['mail_host'] ?? env('MAIL_HOST', 'smtp.gmail.com');
        }
        if ($key === 'mail_port') {
            return $map['mail_port'] ?? env('MAIL_PORT', 587);
        }
        if ($key === 'mail_username') {
            return $map['mail_username'] ?? env('MAIL_USERNAME');
        }
        if ($key === 'mail_password') {
            return $map['mail_password'] ?? env('MAIL_PASSWORD');
        }
        if ($key === 'mail_encryption') {
            return $map['mail_encryption'] ?? env('MAIL_ENCRYPTION', 'tls');
        }
        if ($key === 'mail_from_address') {
            return $map['mail_from_address'] ?? env('MAIL_FROM_ADDRESS');
        }
        if ($key === 'mail_from_name') {
            return $map['mail_from_name'] ?? env('MAIL_FROM_NAME', 'DEWASHARIF');
        }

        // WhatsApp Cloud API Fallbacks
        if ($key === 'whatsapp_token') {
            return $map['whatsapp_token'] ?? env('WHATSAPP_TOKEN');
        }
        if ($key === 'whatsapp_phone_number_id') {
            return $map['whatsapp_phone_number_id'] ?? env('WHATSAPP_PHONE_NUMBER_ID');
        }
        if ($key === 'whatsapp_business_account_id') {
            return $map['whatsapp_business_account_id'] ?? env('WHATSAPP_BUSINESS_ACCOUNT_ID');
        }

        return parent::getAttribute($key);
    }

    public function setAttribute($key, $value)
    {
        if (in_array($key, ['id', 'created_at', 'updated_at', 'key', 'value', 'group'])) {
            return parent::setAttribute($key, $value);
        }

        static::setVal($key, $value);
        return $this;
    }

    public function update(array $attributes = [], array $options = [])
    {
        foreach ($attributes as $k => $v) {
            if (in_array($k, ['_token', '_method', 'id'])) {
                continue;
            }
            static::setVal($k, $v);
        }

        // Keep DataStore in sync as well
        try {
            $ds = \App\Helpers\DataStore::get();
            $dsSettings = $ds['settings'] ?? [];
            foreach ($attributes as $k => $v) {
                if (!in_array($k, ['_token', '_method', 'id'])) {
                    $dsSettings[$k] = $v;
                }
            }
            $ds['settings'] = $dsSettings;
            \App\Helpers\DataStore::save($ds);
        } catch (\Throwable $e) {}

        static::$cachedSettings = null;
        return true;
    }
}