<div class="p-6 space-y-6">

    <x-header 
        title="Graph Monitoring" 
        subtitle="View temperature and humidity logs in real time. Updated every 1 minute." 
        align="center"
    />

    <x-card>
        <x-tabs>
            <x-tab-list>
                <x-tab>Temperature</x-tab>
                <x-tab>Humidity</x-tab>
                <x-tab>Mixte</x-tab>
            </x-tab-list>

            <x-tab-panels>
                <x-tab-panel>
                    <x-chart :options="$chartTemperature" class="h-[400px]" />
                </x-tab-panel>

                <x-tab-panel>
                    <x-chart :options="$chartHumidity" class="h-[400px]" />
                </x-tab-panel>

                <x-tab-panel>
                    <x-chart :options="$chartRemix" class="h-[400px]" />
                </x-tab-panel>
            </x-tab-panels>
        </x-tabs>
    </x-card>

</div>
