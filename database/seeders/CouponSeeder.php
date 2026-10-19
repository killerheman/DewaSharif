<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coupons = [
            [
                'code'        => 'HOSTLOK30',
                'type'        => 'percent',
                'value'       => 30.00,
                'is_active'   => true,
                'expiry_date' => now()->addYears(5)->toDateString(),
            ],
            [
                'code'        => 'HOSTLOKNEW',
                'type'        => 'percent',
                'value'       => 10.00,
                'is_active'   => true,
                'expiry_date' => now()->addYears(5)->toDateString(),
            ],
        ];

        foreach ($coupons as $c) {
            Coupon::updateOrCreate(
                ['code' => $c['code']],
                $c
            );
        }
    }
}
