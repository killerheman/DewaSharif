<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ShopSetting
{
    private static $cache = null;

    /**
     * Get all shop settings as key => value associative array
     */
    public static function all()
    {
        if (self::$cache !== null) {
            return self::$cache;
        }

        $settings = [
            'express_2_4h_fee' => '35.00',
            'local_24h_fee' => '20.00',
            'standard_courier_fee' => '40.00',
            'default_handling_fee' => '10.00',
            'default_packaging_fee' => '20.00',
            'cod_extra_fee' => '30.00',
            'free_delivery_threshold' => '999.00',
            'is_express_enabled' => '1',
            'is_local_24h_enabled' => '1',
            'is_standard_courier_enabled' => '1'
        ];

        try {
            if (Schema::hasTable('shop_settings')) {
                $dbSettings = DB::table('shop_settings')->pluck('value', 'key')->toArray();
                $settings = array_merge($settings, $dbSettings);
            }
        } catch (\Throwable $e) {}

        self::$cache = $settings;
        return self::$cache;
    }

    /**
     * Get a specific setting value
     */
    public static function get($key, $default = null)
    {
        $all = self::all();
        return $all[$key] ?? $default;
    }

    /**
     * Set / Update a single setting
     */
    public static function set($key, $value, $description = null)
    {
        try {
            if (Schema::hasTable('shop_settings')) {
                $exists = DB::table('shop_settings')->where('key', $key)->exists();
                if ($exists) {
                    $update = ['value' => (string)$value, 'updated_at' => now()];
                    if ($description !== null) {
                        $update['description'] = $description;
                    }
                    DB::table('shop_settings')->where('key', $key)->update($update);
                } else {
                    DB::table('shop_settings')->insert([
                        'key' => $key,
                        'value' => (string)$value,
                        'description' => $description,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
                self::$cache = null; // Clear static cache
                return true;
            }
        } catch (\Throwable $e) {}

        return false;
    }

    /**
     * Update multiple settings at once
     */
    public static function updateMany(array $data)
    {
        foreach ($data as $k => $v) {
            self::set($k, $v);
        }
        self::$cache = null;
    }
}
