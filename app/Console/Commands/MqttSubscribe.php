<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpMqtt\Client\MqttClient;
use App\Models\SensorData;

class MqttSubscribe extends Command
{
    protected $signature = 'mqtt:subscribe';
    protected $description = 'Subscribe ke MQTT dan simpan data ke database';

    public function handle()
    {
        $mqtt = new MqttClient('test.mosquitto.org', 1883, 'laravel-subscriber-' . uniqid());

        $mqtt->connect();

        $mqtt->subscribe('nadhif/LOS_WEMOS_ARDUINOS/data', function ($topic, $message) {
            $data = json_decode($message, true);

            SensorData::create([
                'temperature' => $data['temperature'] ?? null,
                'humidity' => $data['humidity'] ?? null,
                'alert' => $data['alert'] ?? 0,
                'fan' => $data['fan'] ?? 0,
                'smoke' => $data['smoke'] ?? 0,
                'gas' => $data['gas'] ?? 0,
                'created_at' => now(),
            ]);
        }, 0);

        $mqtt->loop(true);
        $mqtt->disconnect();
    }
}
