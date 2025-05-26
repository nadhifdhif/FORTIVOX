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
            $table->float('temperature')->nullable();
            $table->float('humidity')->nullable();
            $table->float('gas')->default(0);
            $table->integer('alert')->default(0);
            $table->integer('overheat')->default(0);
            $table->integer('fan')->default(0);
            $table->integer('smoke')->default(0);

            $table->timestamps();
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
