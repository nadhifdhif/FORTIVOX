<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switch($locale)
    {
        $supportedLocales = ['en', 'id', 'ms', 'fr', 'pt', 'es', 'it', 'de', 'nl', 'zh', 'ja', 'ru', 'ko', 'ar'];
        
        if (!in_array($locale, $supportedLocales)) {
            abort(400, 'Bahasa tidak didukung');
        }

        // Simpan pilihan bahasa ke session
        Session::put('locale', $locale);
        
        return redirect()->back();
    }
}