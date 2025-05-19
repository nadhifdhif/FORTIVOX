<?php

namespace App\Livewire\Sensor\Grafik;

use Livewire\Component;
use App\Models\SensorData;
use Illuminate\Support\Collection;

class GrafikChart extends Component
{
    public function render()
    {
        $data = SensorData::orderBy('created_at', 'asc')->take(20)->get(); // ambil 20 data terakhir

        $temperatureLabels = $data->pluck('created_at')->map(function ($timestamp) {
            return \Carbon\Carbon::parse($timestamp)->timezone('Asia/Jakarta')->format('H:i');
        });

        $temperatureDatasets = [
            [
                'label' => 'Suhu (°C)',
                'data' => $data->pluck('temperature'),
                'borderColor' => 'rgba(59,130,246,1)', // biru
                'backgroundColor' => 'rgba(59,130,246,0.5)', // biru transparan
                'fill' => true,
                'tension' => 0.4,
            ],
        ];

        $humidityLabels = $data->pluck('created_at')->map(function ($timestamp) {
            return \Carbon\Carbon::parse($timestamp)->timezone('Asia/Jakarta')->format('H:i');
        });

        $humidityDatasets = [
            [
                'label' => 'Kelembapan (%)',
                'data' => $data->pluck('humidity'),
                'borderColor' => 'rgba(16,185,129,1)', // hijau
                'backgroundColor' => 'rgba(16,185,129,0.5)',
                'fill' => true,
                'tension' => 0.4,
            ],
        ];

        $remixLabels = $temperatureLabels;

        $remixDatasets = [
            [
                'label' => 'Suhu (°C)',
                'data' => $data->pluck('temperature'),
                'borderColor' => 'rgba(59,130,246,1)',
                'backgroundColor' => 'rgba(59,130,246,0.2)',
                'fill' => false,
                'tension' => 0.4,
            ],
            [
                'label' => 'Kelembapan (%)',
                'data' => $data->pluck('humidity'),
                'borderColor' => 'rgba(16,185,129,1)',
                'backgroundColor' => 'rgba(16,185,129,0.2)',
                'fill' => false,
                'tension' => 0.4,
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
