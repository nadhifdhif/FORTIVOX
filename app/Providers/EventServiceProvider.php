<?php

namespace App\Providers;

use Illuminate\Auth\Events\Login;
use App\Listeners\LogLastLogin;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Event to listener mapping.
     */
    protected $listen = [
        Login::class => [
            LogLastLogin::class,
        ],
    ];
}
