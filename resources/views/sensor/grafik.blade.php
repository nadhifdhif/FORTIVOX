<div class="p-6 space-y-6">
    <x-header title="Monitoring Grafik" subtitle="Pantau suhu dan kelembapan dalam bentuk grafik realtime" />

    <x-card>
        <x-tabs :tabs="['Suhu', 'Kelembapan', 'Gabungan']">
            <x-tabs.content>
                <!-- Chart Suhu -->
                <x-chart :settings="$suhuChart" />
            </x-tabs.content>

            <x-tabs.content>
                <!-- Chart Kelembapan -->
                <x-chart :settings="$kelembapanChart" />
            </x-tabs.content>

            <x-tabs.content>
                <!-- Chart Gabungan -->
                <x-chart :settings="$gabunganChart" />
            </x-tabs.content>
        </x-tabs>
    </x-card>
</div>
