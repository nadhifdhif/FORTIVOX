<?php

namespace App\Http\Controllers;

use App\Models\SensorData;
use Illuminate\Http\Request;

class SensorDataController extends Controller
{
    public function index()
    {
        $sensorData = SensorData::latest()->get();

        return view('sensor.index', compact('sensorData'));
    }
}
