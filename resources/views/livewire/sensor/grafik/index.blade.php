<div class="p-6 space-y-6">

    <!-- Header -->
    <x-card class="text-center animate-fade-in">
        <x-header
            title="Suivi Graphique"
            subtitle="Visualisez les relevés de température et d’humidité en temps réel. Mise à jour toutes les 1 minute."
            align="center"
        />
    </x-card>

    <!-- Onglets -->
    <x-tabs class="w-full animate-fade-in" wire:ignore>
        <x-tab label="Température" active>
            <div class="w-full h-96">
                <canvas id="chartTemperature" width="400" height="300"></canvas>
            </div>
        </x-tab>

        <x-tab label="Humidité">
            <div class="w-full h-96">
                <canvas id="chartHumidity" width="400" height="300"></canvas>
            </div>
        </x-tab>

        <x-tab label="Mixte">
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
                    return date.toLocaleTimeString('fr-FR', {
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit',
                        timeZone: 'Asia/Jakarta'
                    });
                }).reverse();

                const temperatures = data.map(i => i.temperature).reverse();
                const humidities = data.map(i => i.humidity).reverse();

                // Clear chart sebelum redraw
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
                                label: 'Température (°C)',
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
                                label: 'Humidité (%)',
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
                                    label: 'Température (°C)',
                                    data: temperatures,
                                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                                    borderColor: 'rgba(59, 130, 246, 1)',
                                    ...commonOpts
                                },
                                {
                                    label: 'Humidité (%)',
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
            .catch(e => console.error("Erreur lors de la récupération des données:", e));
    }

    // Auto-refresh setiap 1 menit
    setInterval(fetchCharts, 60000);
</script>
