<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use App\Models\MqttData;

class MqttListener extends Command
{
    protected $signature = 'mqtt:listen';
    protected $description = 'Listen to MQTT topic and save sensor data from ESP32';

    public function handle()
    {
        $server   = 'test.mosquitto.org';
        $port     = 1883;
        $clientId = 'laravel_subscriber_' . rand(1000, 9999);

        $connectionSettings = (new ConnectionSettings)->setKeepAliveInterval(60);
        $mqtt = new MqttClient($server, $port, $clientId);
        $mqtt->connect($connectionSettings, true);

        $topic = 'nadhif/FORTIVOX/data';

        $this->info('🚀 Sedang mendengarkan topic MQTT: ' . $topic);

        $mqtt->subscribe($topic, function (string $topic, string $message) {
            $this->info("📩 Pesan Diterima: {$message}");

            $data = json_decode($message, true);

            // 🔍 Jika data dibungkus dalam key "data", ambil isinya
            if (isset($data['data']) && is_array($data['data'])) {
                $data = $data['data'];
            }

            if (json_last_error() === JSON_ERROR_NONE) {

                // Cek minimal field
                if (isset($data['temperature'], $data['humidity'])) {

                    // Set default value jika tidak dikirim
                    $data['alert']     = $data['alert']     ?? 0;
                    $data['overheat']  = $data['overheat']  ?? 0;
                    $data['smoke']     = $data['smoke']     ?? 0;
                    $data['gas']       = $data['gas']       ?? 0;

                    $shouldFanOn = $data['temperature'] > 30 || $data['gas'] > 0 || $data['smoke'] > 0;

                    try {
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

                    } catch (\Exception $e) {
                        $this->error("❌ Gagal simpan ke DB: " . $e->getMessage());
                    }

                } else {
                    $this->error("❌ Field minimal (temperature, humidity) tidak ditemukan.");
                }

            } else {
                $this->error("❌ Format JSON invalid!");
            }
        }, 0);

        $mqtt->loop(true);
    }
}
