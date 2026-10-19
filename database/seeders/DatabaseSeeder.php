<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            LocationSeeder::class,
            RolePermissionSeeder::class,
            AdminSeeder::class,
            SettingSeeder::class,
            PaymentSettingSeeder::class,
            CouponSeeder::class,
            HostingCategorySeeder::class,
            ServerCategorySeeder::class,
            EmailServiceSeeder::class,
            SiteAccessSeeder::class,
        ]);
    }
}