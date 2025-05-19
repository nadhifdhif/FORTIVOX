<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Redirect;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Custom redirect setelah login
        $this->app['router']->get('/redirect-after-login', function () {
            $role = auth()->user()->role ?? null;

            return match ($role) {
                'admin' => Redirect::to('/'), // el atmin
                'user'  => Redirect::to('/user-dashboard'), // pengguna biasa
                default => abort(403, 'Role tidak dikenali.'),
            };
        })->middleware('auth');
    }
}
