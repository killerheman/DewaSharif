<?php

namespace Database\Seeders;

use App\Models\PaymentSetting;
use Illuminate\Database\Seeder;

class PaymentSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentSetting::updateOrCreate(
            ['gateway' => 'Razorpay'],
            [
                'display_name'   => 'Razorpay',
                'key_id'         => 'rzp_test_TLc5br8H5K6aTI',
                'key_secret'     => 'bk4ouCAFTKhsDqIsq131fKTn',
                'client_id'      => 'Eum dolores qui ut q',
                'client_secret'  => 'Quos officia archite',
                'merchant_id'    => 'Qui praesentium quae',
                'webhook_secret' => 'Non et totam nobis l',
                'sandbox_mode'   => true,
                'currency'       => 'INR',
                'is_active'      => true,
            ]
        );
    }
}
