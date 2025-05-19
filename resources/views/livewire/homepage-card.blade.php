<div wire:poll.2s>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">

        {{-- 🔥 Gas --}}
        <x-card class="{{ $data['alert'] ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
            <x-slot name="title">Détection de gaz</x-slot>
            <p class="text-xl font-bold">
                {{ $data['alert'] ? 'Gaz détecté !' : 'Aucun gaz détecté' }}
            </p>
        </x-card>

        {{-- ☀️ Overheat --}}
        <x-card class="{{ $data['overheat'] ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
            <x-slot name="title">Surchauffe</x-slot>
            <p class="text-xl font-bold">
                {{ $data['overheat'] ? 'Température élevée !' : 'Température normale' }}
            </p>
        </x-card>

        {{-- 🌡️ Suhu --}}
        <x-card class="text-gray-800">
            <x-slot name="title">Température</x-slot>
            <p class="text-3xl font-bold">{{ $data['temperature'] ?? '-' }}°C</p>
            <p class="text-sm text-gray-500">Actuelle</p>
        </x-card>

        {{-- 💧 Kelembapan --}}
        <x-card class="text-gray-800">
            <x-slot name="title">Humidité</x-slot>
            <p class="text-3xl font-bold">{{ $data['humidity'] ?? '-' }}%</p>
            <p class="text-sm text-gray-500">Actuelle</p>
        </x-card>

        {{-- ☁️ Smoke --}}
        <x-card class="{{ $data['smoke'] ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
            <x-slot name="title">Détection de fumée</x-slot>
            <p class="text-xl font-bold">
                {{ $data['smoke'] ? 'Fumée détectée !' : 'Aucune fumée détectée' }}
            </p>
        </x-card>

        {{-- 🌀 Fan --}}
        <x-card class="{{ $data['fan'] ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
            <x-slot name="title">État du ventilateur</x-slot>
            <p class="text-xl font-bold">
                {{ $data['fan'] ? 'ON' : 'OFF' }}
            </p>
        </x-card>

    </div>
</div>
