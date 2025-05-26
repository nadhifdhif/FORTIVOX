<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Livewire\SensorTable;
use App\Livewire\Sensor\Grafik\Index as GrafikIndex;
use App\Livewire\Grafik\Stat;
use App\Livewire\Settings\Language\Index as LanguageSettings;
use App\Models\MqttData;
use App\Http\Middleware\CheckRole;

// ✅ Route login & register (public)
Volt::route('/login', 'login')->name('login');
Volt::route('/register', 'register')->name('register');

// ✅ Route publik untuk grafik ambil data via JS (MQTT)
Route::get('/sensor-json', fn () => MqttData::latest()->get())->name('sensor.json');

// ✅ ADMIN AREA (middleware: auth + role:admin)
Route::middleware(['auth', CheckRole::class . ':admin'])->group(function () {
    Volt::route('/', 'homepage.index');
    Volt::route('/sensor', SensorTable::class);
    Volt::route('/grafik-monitoring', GrafikIndex::class)->name('grafik.monitoring');
    Volt::route('/grafik/stat', Stat::class)->name('grafik.stat');
    Route::view('/grafik', 'sensor.grafik')->name('grafik');

    // ✅ Reset data sensor
    Route::post('/sensor/reset', function () {
        MqttData::truncate();
        return redirect('/sensor')->with('success', 'Data sensor berhasil direset!');
    })->name('sensor.reset');

    // ✅ Manajemen user
    Volt::route('/users', 'users.index');
    Volt::route('/users/create', 'users.create');
    Volt::route('/users/{user}/edit', 'users.edit');

    // ✅ Halaman pengaturan bahasa
    Volt::route('/settings/language', 'settings.language.index')->name('language.settings');
});

// ✅ USER AREA (middleware: auth + role:user)
Route::middleware(['auth', CheckRole::class . ':user'])->group(function () {
    Volt::route('/user-dashboard', 'user.dashboard');
});

// ✅ LOGOUT (via POST, aman dari page expired)
Route::middleware('auth')->post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

// ✅ ROUTE GANTI BAHASA (aktif langsung, 14 bahasa)
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id', 'ms', 'fr', 'pt', 'es', 'it', 'de', 'nl', 'zh', 'ja', 'ru', 'ko', 'ar'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return redirect()->back();
})->name('lang.switch');

// ✅ TESTING: akses khusus admin
Route::middleware([CheckRole::class . ':admin'])->get('/coba-role', function () {
    return 'akses admin berhasil';
});
