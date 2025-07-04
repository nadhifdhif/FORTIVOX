<div class="p-4" wire:poll.5s>
    <x-card>

        <!-- Header -->
        <div class="text-center space-y-2 mb-6">
            <h1 class="text-4xl font-bold">{{ __('messages.smart_monitoring') }}</h1>
            <p class="text-gray-500">
                {{ __('messages.sensor_desc') }}
            </p>
        </div>

        <!-- Tombol Reset -->
        <div class="flex justify-end mb-4">
            <x-button 
                color="destructive" 
                icon="o-arrow-uturn-left" 
                wire:click="$set('showConfirmModal', true)"
            >
            {{ __('messages.reset_data') }}
            </x-button>
        </div>

        <!-- Tabel Data -->
        <div class="overflow-x-auto rounded-lg shadow">
            <table class="w-full text-sm text-gray-700">
                <thead class="bg-blue-100 text-blue-800">
                    <tr>
                        <th class="py-3 px-4 text-center">ID</th>
                        <th class="py-3 px-4 text-center">{{ __('messages.temperature_title') }} (°C)</th>
                        <th class="py-3 px-4 text-center">{{ __('messages.humidity_title') }} (%)</th>
                        <th class="py-3 px-4 text-center">Timestamp (UTC+7)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($rows as $row)
                        <tr class="even:bg-gray-50 hover:bg-gray-100">
                            <td class="py-3 px-4 text-center">{{ $row->id }}</td>
                            <td class="py-3 px-4 text-center">{{ $row->temperature }}</td>
                            <td class="py-3 px-4 text-center">{{ $row->humidity }}</td>
                            <td class="py-3 px-4 text-center">{{ $row->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $rows->links() }}
        </div>

    </x-card>

    <!-- Modal Konfirmasi Reset -->
    <x-modal wire:model.defer="showConfirmModal" blur>
        <div class="p-6">
            <h2 class="text-xl font-semibold mb-4">{{ __('messages.reset_confirmation_title') }}</h2>
            <p class="text-gray-600 mb-6">
                {{ __('messages.reset_confirmation_message') }}
            </p>
            <div class="flex justify-end gap-2">
                <x-button
                    flat
                    :label="__('messages.cancel')"
                    wire:click="$set('showConfirmModal', false)"
                />
                <x-button
                    color="destructive"
                    :label="__('messages.reset_now')"
                    wire:click="resetSensor"
                    spinner
                />
            </div>
        </div>
    </x-modal>
</div>
