<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'website_name', 'value' => 'Dewa Sharif', 'group' => 'general'],
            ['key' => 'website_url', 'value' => 'https://dewasharif.com', 'group' => 'general'],
            ['key' => 'company_name', 'value' => 'Dewa Sharif Services', 'group' => 'general'],
            ['key' => 'support_email', 'value' => 'info@dewasharif.com', 'group' => 'general'],
            ['key' => 'support_phone', 'value' => '+91 9876543210', 'group' => 'general'],
            ['key' => 'address', 'value' => 'Dewa Sharif, Barabanki, Uttar Pradesh', 'group' => 'general'],
            ['key' => 'currency', 'value' => 'INR', 'group' => 'general'],
            ['key' => 'timezone', 'value' => 'Asia/Kolkata', 'group' => 'general'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value'], 'group' => $setting['group']]
            );
        }
    }
}
