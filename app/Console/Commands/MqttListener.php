<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use App\Models\MqttData;

class MqttListener extends Command
{
    protected $signature = 'mqtt:listen';
    protected $description = 'Listen to MQTT topic and save sensor data from ESP8266';

    public function handle()
    {
        $server   = 'test.mosquitto.org';
        $port     = 1883;
        $clientId = 'laravel_subscriber_' . rand(1000, 9999);

        $connectionSettings = (new ConnectionSettings)->setKeepAliveInterval(60);
        $mqtt = new MqttClient($server, $port, $clientId);
        $mqtt->connect($connectionSettings, true);

        $topic = 'nadhif/LOS_WEMOS_ARDUINOS/data';

        $this->info('🚀 Sedang mendengarkan topic MQTT: ' . $topic);

        $mqtt->subscribe($topic, function (string $topic, string $message) {
            $this->info("📩 Pesan Diterima: {$message}");

            $data = json_decode($message, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                // Isi default untuk gas kalau tidak dikirim
                $data['gas'] = $data['gas'] ?? 0;

                if (
                    isset(
                        $data['temperature'],
                        $data['humidity'],
                        $data['alert'],
                        $data['overheat'],
                        $data['smoke']
                    )
                ) {
                    $shouldFanOn = $data['temperature'] > 30 || $data['gas'] > 400;

                    MqttData::create([
                        'temperature' => $data['temperature'],
                        'humidity'    => $data['humidity'],
                        'alert'       => $data['alert'],
                        'overheat'    => $data['overheat'],
                        'fan'         => $shouldFanOn ? 1 : 0,
                        'smoke'       => $data['smoke'],
                        'gas'         => $data['gas'],
                    ]);

                    $this->info("✅ Data berhasil disimpan ke database. Fan status: " . ($shouldFanOn ? 'ON' : 'OFF'));
                } else {
                    $this->error("❌ Field utama (temperature, humidity, dll) masih ada yang kurang.");
                }
            } else {
                $this->error("❌ Format JSON invalid!");
            }
        }, 0);

        $mqtt->loop(true);
    }
}
