<?php

namespace App\Livewire\Grafik;

use Livewire\Component;
use App\Models\MqttData;

class Stat extends Component
{
    public float $avgTemp = 0;
    public float $avgHumidity = 0;
    public int $totalAlert = 0;

    public function mount()
    {
        $this->avgTemp = round(MqttData::avg('temperature'), 2);
        $this->avgHumidity = round(MqttData::avg('humidity'), 2);
        $this->totalAlert = MqttData::where('alert', 1)->count();
    }

    public function render()
    {
        return view('livewire.grafik.stat');
    }
}
