<div class="p-6 space-y-6">

    <x-header 
        title="Suivi Graphique" 
        subtitle="Surveillez les données de température et d'humidité en temps réel. Les données sont mises à jour toutes les minutes." 
        align="center"
    />

    <x-card>
        <x-tabs>
            <x-tab-list>
                <x-tab>Température</x-tab>
                <x-tab>Humidité</x-tab>
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
