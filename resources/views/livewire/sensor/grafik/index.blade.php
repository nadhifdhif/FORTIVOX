<div class="p-6 space-y-6">

    <!-- Header -->
    <x-card class="text-center animate-fade-in">
        <x-header
            :title="__('messages.graph_monitoring')"
            align="center"
        />
    </x-card>

    <!-- Tabs -->
    <x-tabs class="w-full animate-fade-in" wire:ignore>
        <x-tab :label="__('messages.temperature_title')" active>
            <div class="w-full h-96">
                <canvas id="chartTemperature" width="400" height="300"></canvas>
            </div>
        </x-tab>

        <x-tab :label="__('messages.humidity_title')">
            <div class="w-full h-96">
                <canvas id="chartHumidity" width="400" height="300"></canvas>
            </div>
        </x-tab>

        <x-tab :label="__('messages.graph_click')">
            <div class="w-full h-96">
                <canvas id="chartCombined" width="400" height="300"></canvas>
            </div>
        </x-tab>
    </x-tabs>

</div>

<!-- Import Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    let chartTemperature = null;
    let chartHumidity = null;
    let chartCombined = null;

    const sensorJsonUrl = "{{ route('sensor.json') }}";

    document.addEventListener('DOMContentLoaded', () => fetchCharts());
    document.addEventListener('livewire:navigated', () => fetchCharts());

    function fetchCharts() {
        fetch(sensorJsonUrl)
            .then(res => res.json())
            .then(data => {
                const labels = data.map(item => {
                    const date = new Date(item.created_at);
                    return date.toLocaleTimeString('{{ app()->getLocale() }}', {
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit',
                        timeZone: 'Asia/Jakarta'
                    });
                }).reverse();

                const temperatures = data.map(i => i.temperature).reverse();
                const humidities = data.map(i => i.humidity).reverse();

                chartTemperature?.destroy();
                chartHumidity?.destroy();
                chartCombined?.destroy();

                const commonOpts = {
                    responsive: true,
                    maintainAspectRatio: false,
                    tension: 0.4,
                    borderWidth: 2,
                    fill: true
                };

                chartTemperature = new Chart(
                    document.getElementById('chartTemperature').getContext('2d'),
                    {
                        type: 'line',
                        data: {
                            labels,
                            datasets: [{
                                label: '{{ __("messages.temperature_title") }} (°C)',
                                data: temperatures,
                                backgroundColor: 'rgba(59, 130, 246, 0.2)',
                                borderColor: 'rgba(59, 130, 246, 1)',
                                ...commonOpts
                            }]
                        },
                        options: commonOpts
                    }
                );

                chartHumidity = new Chart(
                    document.getElementById('chartHumidity').getContext('2d'),
                    {
                        type: 'line',
                        data: {
                            labels,
                            datasets: [{
                                label: '{{ __("messages.humidity_title") }} (%)',
                                data: humidities,
                                backgroundColor: 'rgba(16, 185, 129, 0.2)',
                                borderColor: 'rgba(16, 185, 129, 1)',
                                ...commonOpts
                            }]
                        },
                        options: commonOpts
                    }
                );

                chartCombined = new Chart(
                    document.getElementById('chartCombined').getContext('2d'),
                    {
                        type: 'line',
                        data: {
                            labels,
                            datasets: [
                                {
                                    label: '{{ __("messages.temperature_title") }} (°C)',
                                    data: temperatures,
                                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                                    borderColor: 'rgba(59, 130, 246, 1)',
                                    ...commonOpts
                                },
                                {
                                    label: '{{ __("messages.humidity_title") }} (%)',
                                    data: humidities,
                                    backgroundColor: 'rgba(16, 185, 129, 0.2)',
                                    borderColor: 'rgba(16, 185, 129, 1)',
                                    ...commonOpts
                                }
                            ]
                        },
                        options: commonOpts
                    }
                );
            })
            .catch(e => console.error("Error while fetching sensor data:", e));
    }

    // Auto-refresh setiap 1 menit
    setInterval(fetchCharts, 60000);
</script>
