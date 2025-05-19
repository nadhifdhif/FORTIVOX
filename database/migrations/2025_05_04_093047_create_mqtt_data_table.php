<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mqtt_data', function (Blueprint $table) {
            $table->id();
            $table->float('temperature'); // Suhu
            $table->float('humidity');    // Kelembapan
            $table->boolean('alert');     // 0 = aman, 1 = gas terdeteksi
            $table->boolean('overheat');  // 0 = suhu normal, 1 = panas
            $table->boolean('fan');       // 0 = kipas mati, 1 = nyala
            $table->boolean('smoke');     // 0 = tidak ada asap, 1 = ada asap
            $table->timestamps();         // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mqtt_data');
    }
};
