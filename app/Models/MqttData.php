<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MqttData extends Model
{
    protected $table = 'mqtt_data';

    protected $fillable = [
        'temperature',
        'humidity',
        'alert',
        'overheat',
        'fan',
        'smoke',
        'gas', // ← INI WAJIB DITAMBAH!
    ];

    public $timestamps = true;
}
