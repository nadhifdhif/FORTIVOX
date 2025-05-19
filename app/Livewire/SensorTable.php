<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\MqttData; // 🛠 Ganti ke model baru
use Mary\Traits\Toast;
use Carbon\Carbon;

class SensorTable extends Component
{
    use WithPagination, Toast;

    public bool $showConfirmModal = false;

    public function resetSensor()
    {
        MqttData::truncate(); // 🛠 Ganti juga di sini
        $this->showConfirmModal = false;
        $this->toast('Data sensor berhasil direset ✅', 'success');
    }

    public function render()
    {
        $rows = MqttData::orderBy('id', 'desc')->paginate(10); // 🛠 Ganti ke model baru

        $rows->getCollection()->transform(function ($item) {
            $item->created_at = Carbon::parse($item->created_at)
                ->timezone('Asia/Jakarta')
                ->format('Y-m-d H:i:s') . ' UTC+7';
            return $item;
        });

        return view('livewire.sensor-table', [
            'rows' => $rows,
        ]);
    }
}
