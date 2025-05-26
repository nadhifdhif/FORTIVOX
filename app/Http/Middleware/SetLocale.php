<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        $locale = Session::get('locale', config('app.locale'));

        // ✅ Debug log buat cek session locale
        Log::info('🌍 Locale session:', ['locale' => $locale]);

        if (in_array($locale, [
            'en', // Inggris
            'id', // Indonesia
            'ms', // Melayu
            'fr', // Prancis
            'pt', // Portugis
            'es', // Spanyol
            'it', // Italia
            'de', // Jerman
            'nl', // Belanda
            'zh', // Mandarin
            'ja', // Jepang
            'ko', // Korea
            'ar', // Arab
            'ru', // Rusia
        ])) {
            App::setLocale($locale);
        }

        return $next($request);
    }
}
