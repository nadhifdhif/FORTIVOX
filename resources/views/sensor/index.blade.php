<x-mary::card>
    <div class="text-center space-y-2 mb-6">
        <h1 class="text-4xl font-bold">Monitoring Suhu & Kelembapan</h1>
        <p class="text-gray-500">Realtime Sensor Room Monitoring System</p>
    </div>

    <x-mary::table
        :headers="[
            ['key' => 'id', 'label' => 'ID'],
            ['key' => 'temperature', 'label' => 'Temperature (°C)'],
            ['key' => 'humidity', 'label' => 'Humidity (%)'],
            ['key' => 'created_at', 'label' => 'Time (Asia/Jakarta)'],
        ]"
        :rows="$sensorData"
        striped
    />
</x-mary::card>
