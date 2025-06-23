<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\MqttListener::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        // Jadwal tugas artisan (kosong untuk sekarang)
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        // ✅ Tambahkan command Volt secara manual
        if (class_exists(\Livewire\Volt\Console\MakeCommand::class)) {
            $this->commands([
                \Livewire\Volt\Console\MakeCommand::class,
            ]);
        }

        require base_path('routes/console.php');
    }
}
