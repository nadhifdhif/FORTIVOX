<div class="p-4">
    <h2 class="text-2xl font-bold mb-6 text-center">Résumé des statistiques des capteurs</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <x-card>
            <div class="text-center">
                <h3 class="text-lg font-semibold mb-2">Température moyenne</h3>
                <p class="text-3xl font-bold">{{ $avgTemp }}°C</p>
            </div>
        </x-card>

        <x-card>
            <div class="text-center">
                <h3 class="text-lg font-semibold mb-2">Humidité moyenne</h3>
                <p class="text-3xl font-bold">{{ $avgHumidity }}%</p>
            </div>
        </x-card>

        <x-card>
            <div class="text-center">
                <h3 class="text-lg font-semibold mb-2">Total d'alertes actives</h3>
                <p class="text-3xl font-bold text-red-600">{{ $totalAlert }}</p>
            </div>
        </x-card>
    </div>

    <div x-data="{
        chart: null,
        init() {
            const ctx = $refs.chart.getContext('2d');
            this.chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Température', 'Humidité', 'Alertes'],
                    datasets: [{
                        label: 'Statistiques des capteurs',
                        data: [{{ $avgTemp }}, {{ $avgHumidity }}, {{ $totalAlert }}],
                        backgroundColor: ['#60a5fa', '#34d399', '#f87171'],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    }" class="bg-white rounded-lg p-4 shadow">
        <canvas x-ref="chart" height="120"></canvas>
    </div>
</div>
