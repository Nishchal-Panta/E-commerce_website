<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Setting;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Force HTTPS when behind ngrok proxy
        if (request()->header('x-forwarded-proto') === 'https') {
            URL::forceScheme('https');
        }
        // Share settings with all views
        View::composer('*', function ($view) {
            $settings = cache()->remember('site_settings', 3600, function () {
                return Setting::getSiteSettings();
            });
            $view->with('siteSettings', $settings);
        });

        // Share cart count with all views for authenticated users
        View::composer('*', function ($view) {
            if (auth()->check() && auth()->user()->isBuyer()) {
                $cartCount = auth()->user()->getCartItemCount();
                $view->with('cartCount', $cartCount);
            } else {
                $view->with('cartCount', 0);
            }
        });
    }
}
