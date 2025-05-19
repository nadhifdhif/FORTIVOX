<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ConfirmAndClearSensorData extends Command
{
    protected $signature = 'sensor:clear';
    protected $description = 'Tanya user lalu hapus semua data sensor dan reset auto increment';

    public function handle()
    {
        if ($this->confirm('⚠️  Apakah kamu yakin mau HAPUS semua data sensor dan reset ID ke 1?', true)) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('sensor_data')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            $this->info('✅ Semua data sensor berhasil dihapus dan ID berhasil direset ke 1.');
        } else {
            $this->info('⛔ Aksi dibatalkan. Tidak ada data yang dihapus.');
        }
    }
}
