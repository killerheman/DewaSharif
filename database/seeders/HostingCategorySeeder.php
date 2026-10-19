<?php

namespace Database\Seeders;

use App\Models\HostingCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class HostingCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Shared Web Hosting',
            'cPanel Hosting',
            'Plesk Hosting',
            'WordPress Hosting',
            'WooCommerce Hosting',
            'Cloud Hosting',
            'CRM Hosting',
        ];

        foreach ($categories as $index => $name) {
            HostingCategory::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name'       => $name,
                    'sort_order' => $index + 1,
                    'is_active'  => true,
                ]
            );
        }
    }
}
