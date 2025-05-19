<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;

new class extends Component {

    public function layout(): string
    {
        return 'layouts.admin'; // ⬅️ Tambahan ini penting!
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
        return $this->temperature() > 29 || $this->gas() > 400;
    }

    #[Computed]
    function roomStatus() {
        return $this->shouldActivateFan() ? 'Surchauffe' : 'Température normale';
    }

    #[Computed]
    function roomStatusColor() {
        return $this->shouldActivateFan() ? 'text-red-600' : 'text-green-600';
    }

    #[Computed]
    function roomStatusBg() {
        return $this->shouldActivateFan() ? 'bg-red-200' : 'bg-green-200';
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
        return $this->gas() > 400 ? 'text-red-600' : 'text-green-600';
    }

    #[Computed]
    function gasBackground() {
        return $this->gas() > 400 ? 'bg-red-200' : 'bg-green-200';
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
        return $this->shouldActivateFan() ? 'ON' : 'OFF (Standby)';
    }
};
?>

<div wire:poll.300ms>
    <div class="w-full text-center my-0.5">
        <h1 class="text-2xl font-bold font-sans">Salut, Administrateur.</h1>
    </div>

    <x-card>
        <x-slot name="title">
            <span class="text-2xl font-bold font-sans">Bienvenue à bord de Los Wemos Arduinos !</span>
        </x-slot>
        <p class="text-base text-gray-600 font-sans">
            Pour consulter les relevés de température et d’humidité, veuillez sélectionner le menu «Suivi en temps réel» et pour visualiser les graphiques, veuillez sélectionner le menu «Graphique».
        </p>
    </x-card>

    <br>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="p-4 rounded-lg {{ $this->gasBackground() }}">
            <x-stat
                title="Détection de gaz"
                :value="$this->gas() > 400 ? 'Gaz détecté !' : 'Aucun gaz'"
                icon="o-rss"
                :color="$this->gasColor()" />
        </div>

        <div class="p-4 rounded-lg {{ $this->roomStatusBg() }}">
            <x-stat
                title="Statut de la pièce"
                :value="$this->roomStatus()"
                icon="lucide.sun"
                :color="$this->roomStatusColor()" />
        </div>

        <div>
            <x-stat
                title="Température"
                description="Actuelle"
                :value="$this->temperature() . '°C'"
                icon="lucide.thermometer"
                :color="$this->tempColor()" />
        </div>

        <div>
            <x-stat
                title="Humidité"
                description="Actuelle"
                :value="$this->humidity() . '%'"
                icon="lucide.droplet"
                :color="$this->humidColor()" />
        </div>

        <div class="p-4 rounded-lg {{ $this->smoke() > 200 ? 'bg-red-200' : 'bg-green-200' }}">
            <x-stat
                title="Détection de fumée"
                :value="$this->smoke() > 200 ? 'Fumée détectée !' : 'Aucune fumée'"
                icon="o-cloud"
                :color="$this->smoke() > 200 ? 'text-red-600' : 'text-green-600'" />
        </div>

        <div class="p-4 rounded-lg {{ $this->fanBackground() }}">
            <x-stat
                title="État du ventilateur"
                :value="$this->fanStatusValue()"
                icon="lucide.fan"
                :color="$this->fanStatusColor()" />
        </div>
    </div>
</div>
