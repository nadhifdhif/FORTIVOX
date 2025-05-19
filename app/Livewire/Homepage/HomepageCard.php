<?php

namespace App\Livewire\Homepage;

use Livewire\Component;
use App\Models\MqttData;

class HomepageCard extends Component
{
    public ?array $latest = null;

    public function render()
    {
        $this->latest = MqttData::latest()->first()?->toArray() ?? [
            'temperature' => 0,
            'humidity' => 0,
            'alert' => 0,
            'overheat' => 0,
            'fan' => 0,
            'smoke' => 0,
        ];

        return view('livewire.homepage-card', [
            'data' => $this->latest,
        ]);
    }
}
