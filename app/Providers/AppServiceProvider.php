<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        $sharedSetting = null;
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
                $sharedSetting = \App\Models\Setting::firstOrCreate(['id' => 1]);
            }
        } catch (\Throwable $e) {}

        if (!$sharedSetting) {
            $sharedSetting = new \App\Models\Setting();
        }
        \Illuminate\Support\Facades\View::share('setting', $sharedSetting);

        // Dynamic SMTP / Outgoing Mail Configuration
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
                $mailMailer = \App\Models\Setting::getVal('mail_mailer', env('MAIL_MAILER', 'smtp'));
                $mailHost = \App\Models\Setting::getVal('mail_host', env('MAIL_HOST', 'smtp.gmail.com'));
                $mailPort = \App\Models\Setting::getVal('mail_port', env('MAIL_PORT', 587));
                $mailUsername = \App\Models\Setting::getVal('mail_username', env('MAIL_USERNAME'));
                $mailPassword = \App\Models\Setting::getVal('mail_password', env('MAIL_PASSWORD'));
                $mailEncryption = \App\Models\Setting::getVal('mail_encryption', env('MAIL_ENCRYPTION', 'tls'));
                $mailFromAddress = \App\Models\Setting::getVal('mail_from_address', env('MAIL_FROM_ADDRESS'));
                $mailFromName = \App\Models\Setting::getVal('mail_from_name', env('MAIL_FROM_NAME', 'DEWASHARIF'));

                if ($mailHost) {
                    config([
                        'mail.default' => $mailMailer ?: 'smtp',
                        'mail.mailers.smtp.transport' => 'smtp',
                        'mail.mailers.smtp.host' => $mailHost,
                        'mail.mailers.smtp.port' => (int) ($mailPort ?: 587),
                        'mail.mailers.smtp.encryption' => ($mailEncryption === 'none' || empty($mailEncryption)) ? null : $mailEncryption,
                        'mail.mailers.smtp.username' => $mailUsername,
                        'mail.mailers.smtp.password' => $mailPassword,
                        'mail.from.address' => $mailFromAddress ?: ($mailUsername ?: 'info@dewasharif.com'),
                        'mail.from.name' => trim((string)$mailFromName, '"'),
                    ]);
                }
            }
        } catch (\Throwable $e) {}

        // Auto-ensure User 4 (Imran Ahmed Peshimam) and his active cab booking exist in DB
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('users')) {
                $u4 = \Illuminate\Support\Facades\DB::table('users')->where('id', 4)->first();
                if (!$u4 || empty($u4->password) || empty($u4->first_name)) {
                    $uCols = \Illuminate\Support\Facades\Schema::getColumnListing('users');
                    $imranPayload = [
                        'name' => 'IMRAN AHMED PESHIMAM',
                        'first_name' => 'IMRAN',
                        'last_name' => 'AHMED PESHIMAM',
                        'phone' => '7899422676',
                        'email' => 'imran.peshimam@dewasharif.com',
                        'password' => \Illuminate\Support\Facades\Hash::make('123456'),
                        'address' => 'Hegde Nagar, Bangalore North, Karnataka - 560077',
                        'postal_code' => '560077',
                        'updated_at' => now(),
                    ];
                    $filtered = array_intersect_key($imranPayload, array_flip($uCols));
                    if ($u4) {
                        \Illuminate\Support\Facades\DB::table('users')->where('id', 4)->update($filtered);
                    } else {
                        $filtered['id'] = 4;
                        $filtered['created_at'] = now();
                        \Illuminate\Support\Facades\DB::table('users')->insert($filtered);
                    }
                }
            }

            if (\Illuminate\Support\Facades\Schema::hasTable('cab_bookings')) {
                try {
                    $cabCols = \Illuminate\Support\Facades\Schema::getColumnListing('cab_bookings');
                    $neededCols = [
                        'booking_code' => 'string',
                        'vehicle_type' => 'string',
                        'vehicle_name' => 'string',
                        'route' => 'string',
                        'fare' => 'decimal',
                        'total_fare' => 'decimal',
                        'night_surcharge' => 'decimal',
                        'id_type' => 'string',
                        'id_no' => 'string',
                        'driver' => 'string',
                        'driver_name' => 'string',
                        'driver_phone' => 'string',
                        'driver_vehicle_number' => 'string',
                        'customer_email' => 'string',
                        'customer_address' => 'text',
                        'alternate_phone' => 'string',
                        'status' => 'string',
                        'payment_id' => 'string',
                        'utr_number' => 'string',
                    ];
                    $missing = array_diff(array_keys($neededCols), $cabCols);
                    if (!empty($missing)) {
                        \Illuminate\Support\Facades\Schema::table('cab_bookings', function ($table) use ($missing, $neededCols) {
                            foreach ($missing as $col) {
                                $type = $neededCols[$col];
                                if ($type === 'string') $table->string($col)->nullable();
                                elseif ($type === 'text') $table->text($col)->nullable();
                                elseif ($type === 'decimal') $table->decimal($col, 10, 2)->default(0);
                            }
                        });
                        $cabCols = \Illuminate\Support\Facades\Schema::getColumnListing('cab_bookings');
                    }
                } catch (\Throwable $e) {}

                $hasCab = \Illuminate\Support\Facades\DB::table('cab_bookings')->where('booking_code', 'DWS-CAB-2026-4115')->orWhere('booking_id', 'DWS-CAB-2026-4115')->exists();
                if (!$hasCab) {
                    $cabCols = \Illuminate\Support\Facades\Schema::getColumnListing('cab_bookings');
                    $cabData = [
                        'booking_id' => 'DWS-CAB-2026-4115',
                        'booking_code' => 'DWS-CAB-2026-4115',
                        'vehicle_type' => 'Omni Van (Standard) (×2 Cabs)',
                        'vehicle_name' => 'Omni Van (Standard)',
                        'driver' => 'Assigned',
                        'driver_name' => 'Dewa Sharif Verified Driver',
                        'driver_phone' => '9648777223',
                        'driver_vehicle_number' => 'UP-32-AB-1234',
                        'user_id' => 4,
                        'customer_name' => 'IMRAN AHMED PESHIMAM',
                        'customer_phone' => '7899422676',
                        'customer_email' => 'imran.peshimam@dewasharif.com',
                        'customer_address' => 'Hegde Nagar, Bangalore North, Karnataka - 560077',
                        'id_type' => 'Aadhaar Card',
                        'id_no' => '8208 2148 6063',
                        'pickup_location' => 'Lucknow Railway Station',
                        'drop_location' => 'Dewa Sharif',
                        'route' => 'Lucknow Railway Station → Dewa Sharif',
                        'pickup_date' => '2026-10-20',
                        'pickup_time' => '08:30 PM',
                        'total_amount' => 3800.00,
                        'fare' => 3800.00,
                        'total_fare' => 3800.00,
                        'night_surcharge' => 0.00,
                        'paid_amount' => 3800.00,
                        'pending_amount' => 0.00,
                        'payment_mode' => 'WhatsApp / Online',
                        'payment_status' => 'paid',
                        'booking_status' => 'confirmed',
                        'status' => 'Active & Confirmed',
                        'created_at' => '2026-10-18 07:52:14',
                        'updated_at' => now(),
                    ];
                    \Illuminate\Support\Facades\DB::table('cab_bookings')->insert(array_intersect_key($cabData, array_flip($cabCols)));
                }
            }
        } catch (\Throwable $e) {}

        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            static $navHostings = null;
            static $navServers = null;
            static $cartCount = null;
            static $serviceHotelsStatus = null;
            static $serviceCabsStatus = null;
            static $serviceShopStatus = null;

            if ($navHostings === null) {
                try {
                    $navHostings = \Illuminate\Support\Facades\Schema::hasTable('hostings')
                        ? \App\Models\Hosting::where('is_active', true)->orderBy('sort_order')->get()
                        : collect();
                } catch (\Throwable $e) {
                    $navHostings = collect();
                }
            }
            $view->with('navHostings', $navHostings);

            if ($navServers === null) {
                try {
                    $navServers = \Illuminate\Support\Facades\Schema::hasTable('servers')
                        ? \App\Models\Server::where('is_active', true)
                            ->where('slug', 'not like', '%deleted%')
                            ->orderBy('sort_order')
                            ->get()
                        : collect();
                } catch (\Throwable $e) {
                    $navServers = collect();
                }
            }
            $view->with('navServers', $navServers);

            if ($cartCount === null) {
                $cartCount = 0;
                try {
                    if (auth()->check()) {
                        $userId = auth()->id();
                        $domainCount = (\Illuminate\Support\Facades\Schema::hasTable('domain_orders') && class_exists(\App\Models\DomainOrder::class)) 
                            ? \App\Models\DomainOrder::where('user_id', $userId)->where('status', 'pending')->count() 
                            : 0;
                        $hostingCount = (\Illuminate\Support\Facades\Schema::hasTable('hosting_orders') && class_exists(\App\Models\HostingOrder::class)) 
                            ? \App\Models\HostingOrder::where('user_id', $userId)->where('status', 'pending')->count() 
                            : 0;
                        $emailCount = (\Illuminate\Support\Facades\Schema::hasTable('email_orders') && class_exists(\App\Models\EmailOrder::class)) 
                            ? \App\Models\EmailOrder::where('user_id', $userId)->where('status', 'pending')->count() 
                            : 0;
                        $cartCount = $domainCount + $hostingCount + $emailCount;
                    }
                } catch (\Throwable $e) {
                    $cartCount = 0;
                }
            }
            $view->with('cartCount', $cartCount);

            // Public Services Master Status (active, coming_soon, whatsapp_only)
            if ($serviceHotelsStatus === null) {
                try {
                    $serviceHotelsStatus = \App\Models\Setting::getVal('service_hotels_status', 'active');
                    $serviceCabsStatus = \App\Models\Setting::getVal('service_cabs_status', 'active');
                    $serviceShopStatus = \App\Models\Setting::getVal('service_shop_status', 'whatsapp_only');
                } catch (\Throwable $e) {
                    $serviceHotelsStatus = 'active';
                    $serviceCabsStatus = 'active';
                    $serviceShopStatus = 'whatsapp_only';
                }
            }
            $view->with('serviceHotelsStatus', $serviceHotelsStatus);
            $view->with('serviceCabsStatus', $serviceCabsStatus);
            $view->with('serviceShopStatus', $serviceShopStatus);
            $view->with('shopDeghOnlyMode', filter_var(env('SHOP_DEGH_ONLY_MODE', true), FILTER_VALIDATE_BOOLEAN));
        });
    }
}
