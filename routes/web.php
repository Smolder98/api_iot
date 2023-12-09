<?php

use App\Models\Patient;
use App\Models\Reading;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/mail', function () {

    $patient = Patient::find(1);
    $reading = Reading::where('patient_id', $patient->id)
        ->orderBy('created_at', 'desc')
        ->limit(1)
        ->first();

    // $reading_max_sistolic = $readings->sortByDesc('pressure_sistolic')->first();
    // $pressure_arterial_max = $reading_max_sistolic->pressure_sistolic . ' / ' . $reading_max_sistolic->pressure_diastolic;
    // $temperature_max = $readings->max('temperature');
    // $frequency_cardiac_max = $readings->max('frequency_cardiac');
    // $oxygen_min = $readings->min('oxygen_saturation');


    // return view('emails.send_readings', compact([
    //     'patient',
    //     'readings',
    //     'temperature_max',
    //     'frequency_cardiac_max',
    //     'pressure_arterial_max',
    //     'oxygen_min',
    // ]));

    return view('emails.alert', compact([
        'patient',
        'reading',
    ]));
});
