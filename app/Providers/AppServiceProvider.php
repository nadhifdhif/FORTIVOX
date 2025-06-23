<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Tempat untuk binding service atau singleton kalau butuh
    }

    public function boot(): void
    {
        // ✅ Set locale berdasarkan session (jika ada), fallback ke app.locale dari .env
        $locale = session('locale', config('app.locale'));
        app()->setLocale($locale);
    }
}
