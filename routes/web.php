<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Livewire\SensorTable;
use App\Livewire\Sensor\Grafik\Index as GrafikIndex;
use App\Livewire\Grafik\Stat;
use App\Livewire\Settings\Language\Index as LanguageSettings;
use App\Livewire\Users\Index as UsersIndex; // ✅ Tambahan penting
use App\Models\MqttData;
use App\Http\Middleware\CheckRole;
use App\Http\Middleware\SetLocale;
use App\Http\Controllers\LanguageController;

//
// ============================
// ✅ PUBLIC ROUTES (Tanpa login)
// ============================
//
Volt::route('/login', 'login')->name('login');
Volt::route('/register', 'register')->name('register');
Route::get('/sensor-json', fn () => MqttData::latest()->get())->name('sensor.json');

//
// ============================
// ✅ SHARED ROUTES (USER + ADMIN)
// ============================
//
Route::middleware(['auth', SetLocale::class])->group(function () {
    // Dashboard user
    Volt::route('/user-dashboard', 'user.dashboard');

    // Monitoring
    Volt::route('/sensor', SensorTable::class);

    // Menu grafik & statistik
    Volt::route('/monitoring', GrafikIndex::class)->name('monitoring');
    Volt::route('/graph/stat', Stat::class)->name('graph.stat');
    Route::view('/grafik', 'sensor.grafik')->name('grafik');

    // Pengaturan bahasa
    Route::get('/settings/language', LanguageSettings::class)->name('language.settings');
});

//
// ============================
// ✅ ADMIN AREA (khusus role:admin)
// ============================
//
Route::middleware(['auth', CheckRole::class . ':admin', SetLocale::class])->group(function () {
    Volt::route('/', 'homepage.index');

    // Reset data sensor
    Route::post('/sensor/reset', function () {
        MqttData::truncate();
        return redirect('/sensor')->with('success', 'Data sensor berhasil direset!');
    })->name('sensor.reset');

    // Manajemen user
    Route::get('/users', UsersIndex::class); // ✅ Pakai komponen Livewire class
    Volt::route('/users/create', 'users.create');
    Volt::route('/users/{user}/edit', 'users.edit');
});

//
// ============================
// ✅ LOGOUT & GANTI BAHASA
// ============================
//
Route::middleware('auth')->post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

Route::get('/lang/{locale}', [LanguageController::class, 'switch'])->name('lang.switch');

//
// ============================
// ✅ TESTING / DEBUG ROUTE
// ============================
//
Route::middleware([CheckRole::class . ':admin'])->get('/coba-role', function () {
    return 'akses admin berhasil';
});
