<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Lang;

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
        // ✅ Tambahin namespace supaya sidebar.php langsung dikenali
        Lang::addNamespace('sidebar', resource_path('lang/' . app()->getLocale()));
    }
}
