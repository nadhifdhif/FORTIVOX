<?php

namespace App\Livewire\Sensor\Grafik;

use Livewire\Component;
use App\Models\SensorData;

class Index extends Component
{
    public function render()
    {
        $sensorData = SensorData::latest()->take(20)->get()->reverse(); // Ambil 20 data terakhir dan balik urutannya biar lama ke baru

        $temperatureLabels = $sensorData->pluck('created_at')->map(function ($time) {
            return \Carbon\Carbon::parse($time)->format('H:i');
        });

        $temperatureDatasets = [
            [
                'label' => 'Temperature (°C)',
                'data' => $sensorData->pluck('temperature'),
                'borderColor' => 'rgb(59, 130, 246)', // biru
                'backgroundColor' => 'rgba(59, 130, 246, 0.5)',
            ],
        ];

        $humidityLabels = $sensorData->pluck('created_at')->map(function ($time) {
            return \Carbon\Carbon::parse($time)->format('H:i');
        });

        $humidityDatasets = [
            [
                'label' => 'Humidity (%)',
                'data' => $sensorData->pluck('humidity'),
                'borderColor' => 'rgb(34, 197, 94)', // hijau
                'backgroundColor' => 'rgba(34, 197, 94, 0.5)',
            ],
        ];

        $remixLabels = $sensorData->pluck('created_at')->map(function ($time) {
            return \Carbon\Carbon::parse($time)->format('H:i');
        });

        $remixDatasets = [
            [
                'label' => 'Temperature (°C)',
                'data' => $sensorData->pluck('temperature'),
                'borderColor' => 'rgb(59, 130, 246)',
                'backgroundColor' => 'rgba(59, 130, 246, 0.5)',
            ],
            [
                'label' => 'Humidity (%)',
                'data' => $sensorData->pluck('humidity'),
                'borderColor' => 'rgb(34, 197, 94)',
                'backgroundColor' => 'rgba(34, 197, 94, 0.5)',
            ],
        ];

        return view('livewire.sensor.grafik.index', [
            'temperatureLabels' => $temperatureLabels,
            'temperatureDatasets' => $temperatureDatasets,
            'humidityLabels' => $humidityLabels,
            'humidityDatasets' => $humidityDatasets,
            'remixLabels' => $remixLabels,
            'remixDatasets' => $remixDatasets,
        ]);
    }
}
