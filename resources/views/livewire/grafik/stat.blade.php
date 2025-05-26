<div class="p-4">
    <h2 class="text-2xl font-bold mb-6 text-center">{{ __('messages.summary_title') }}</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <x-card>
            <div class="text-center">
                <h3 class="text-lg font-semibold mb-2">{{ __('messages.avg_temp') }}</h3>
                <p class="text-3xl font-bold">{{ $avgTemp }}°C</p>
            </div>
        </x-card>

        <x-card>
            <div class="text-center">
                <h3 class="text-lg font-semibold mb-2">{{ __('messages.avg_humid') }}</h3>
                <p class="text-3xl font-bold">{{ $avgHumidity }}%</p>
            </div>
        </x-card>

        <x-card>
            <div class="text-center">
                <h3 class="text-lg font-semibold mb-2">{{ __('messages.total_alert') }}</h3>
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
                    labels: ['{{ __("messages.temperature_title") }}', '{{ __("messages.humidity_title") }}', '{{ __("messages.total_alert") }}'],
                    datasets: [{
                        label: '{{ __("messages.summary_title") }}',
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
