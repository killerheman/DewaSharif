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

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
                $setting = \App\Models\Setting::firstOrCreate(['id' => 1]);
                \Illuminate\Support\Facades\View::share('setting', $setting);
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\View::share('setting', new \App\Models\Setting());
        }

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
