<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Prioritaskan locale dari session, fallback ke config
        $locale = Session::get('locale', config('app.locale'));
        
        // 2. Validasi locale yang didukung
        $supportedLocales = ['en', 'id', 'ms', 'fr', 'pt', 'es', 'it', 'de', 'nl', 'zh', 'ja', 'ru', 'ko', 'ar'];
        
        if (!in_array($locale, $supportedLocales)) {
            // Jika locale tidak valid, gunakan fallback dan log warning
            $locale = config('app.fallback_locale', 'en');
            Log::warning("Locale tidak didukung: {$locale}", [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);
        }

        // 3. Set aplikasi locale
        App::setLocale($locale);
        
        // 4. Logging hanya di development (opsional)
        if (config('app.debug')) {
            Log::debug('🌐 Locale middleware dijalankan', [
                'session_locale' => Session::get('locale'),
                'app_locale' => App::getLocale(),
                'config_locale' => config('app.locale'),
                'fallback_locale' => config('app.fallback_locale'),
                'request_path' => $request->path()
            ]);
        }

        return $next($request);
    }
}