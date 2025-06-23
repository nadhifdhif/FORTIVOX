<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;

new class extends Component {

    public function layout(): string
    {
        return 'layouts.admin';
    }

    #[Computed]
    function lastSensorData() {
        return DB::table('mqtt_data')->orderBy('id', 'desc')->first() ?? (object)[];
    }

    #[Computed] function gas()        { return $this->lastSensorData()->gas ?? 0; }
    #[Computed] function temperature(){ return $this->lastSensorData()->temperature ?? 0; }
    #[Computed] function humidity()   { return $this->lastSensorData()->humidity ?? 0; }
    #[Computed] function smoke()      { return $this->lastSensorData()->smoke ?? 0; }

    #[Computed]
    function shouldActivateFan() {
    return $this->temperature() > 29 || $this->gas() > 0 || $this->smoke() > 0;
    }


    #[Computed]
    function roomStatus() {
    return $this->temperature() > 29
        ? __('messages.room_hot')
        : __('messages.room_normal');
    }


    #[Computed]
    function roomStatusColor() {
    return $this->temperature() > 29 ? 'text-red-600' : 'text-green-600';
    }

    #[Computed]
    function roomStatusBg() {
    return $this->temperature() > 29 ? 'bg-red-200' : 'bg-green-200';
    }


    #[Computed]
    function tempColor() {
        $t = $this->temperature();
        return $t <= 25 ? 'text-green-500'
            : ($t <= 28 ? 'text-yellow-500'
            : ($t <= 30 ? 'text-orange-500'
            : 'text-red-600'));
    }

    #[Computed]
    function humidColor() {
        $h = $this->humidity();
        return $h <= 75 ? 'text-blue-500'
            : ($h <= 80 ? 'text-green-500'
            : ($h <= 85 ? 'text-yellow-500'
            : ($h <= 90 ? 'text-orange-500'
            : 'text-red-600')));
    }

    #[Computed]
    function gasColor() {
        return $this->gas() > 0 ? 'text-red-600' : 'text-green-600';
    }

    #[Computed]
    function gasBackground() {
        return $this->gas() > 0 ? 'bg-red-200' : 'bg-green-200';
    }

    #[Computed]
    function fanStatusColor() {
        return $this->shouldActivateFan() ? 'text-blue-600' : 'text-green-600';
    }

    #[Computed]
    function fanBackground() {
        return $this->shouldActivateFan() ? 'bg-blue-200' : 'bg-green-200';
    }

    #[Computed]
    function fanStatusValue() {
        return $this->shouldActivateFan()
            ? __('messages.fan_on')
            : __('messages.fan_off');
    }
};
?>

<div>

    <div wire:poll.300ms>
        <div class="w-full text-center my-0.5">
            <h1 class="text-2xl font-bold font-sans">{{ __('messages.greeting') }}</h1>
        </div>

        <x-card>
            <x-slot name="title">
                <span class="text-2xl font-bold font-sans">{{ __('messages.welcome_title') }}</span>
            </x-slot>
            <p class="text-base text-gray-600 font-sans">
                {{ __('messages.welcome_desc') }}
            </p>
        </x-card>

        <br>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="p-4 rounded-lg {{ $this->gasBackground() }}">
                <x-stat
                    :title="__('messages.gas_title')"
                    :value="$this->gas() > 0 ? __('messages.gas_detected') : __('messages.no_gas')"
                    icon="o-rss"
                    :color="$this->gasColor()" />
            </div>

            <div class="p-4 rounded-lg {{ $this->roomStatusBg() }}">
                <x-stat
                    :title="__('messages.room_status_title')"
                    :value="$this->roomStatus()"
                    icon="lucide.sun"
                    :color="$this->roomStatusColor()" />
            </div>

            <div>
                <x-stat
                    :title="__('messages.temperature_title')"
                    :description="__('messages.temperature_desc')"
                    :value="$this->temperature() . '°C'"
                    icon="lucide.thermometer"
                    :color="$this->tempColor()" />
            </div>

            <div>
                <x-stat
                    :title="__('messages.humidity_title')"
                    :description="__('messages.humidity_desc')"
                    :value="$this->humidity() . '%'"
                    icon="lucide.droplet"
                    :color="$this->humidColor()" />
            </div>

            <div class="p-4 rounded-lg {{ $this->smoke() > 0 ? 'bg-red-200' : 'bg-green-200' }}">
                <x-stat
                    :title="__('messages.smoke_title')"
                    :value="$this->smoke() > 0 ? __('messages.smoke_detected') : __('messages.no_smoke')"
                    icon="o-cloud"
                    :color="$this->smoke() > 0 ? 'text-red-600' : 'text-green-600'" />
            </div>

            <div class="p-4 rounded-lg {{ $this->fanBackground() }}">
                <x-stat
                    :title="__('messages.fan_title')"
                    :value="$this->fanStatusValue()"
                    icon="lucide.fan"
                    :color="$this->fanStatusColor()" />
            </div>
        </div>
    </div>
</div>
