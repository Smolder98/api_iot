<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReadingResource;
use App\Mail\SendAlertMailable;
use App\Models\Device;
use App\Models\Patient;
use App\Models\Reading;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Stmt\TryCatch;

class ReadingController extends Controller
{
    public function index()
    {


        $readings = Reading::with('patient')->get();
        return response()->json(new ReadingResource($readings), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'temperature' => 'required|numeric',
            'frequencyCardiac' => 'required|numeric',
            'pressureSistolic' => 'required|numeric',
            'pressureDiastolic' => 'required|numeric',
            'oxygenSaturation' => 'required|numeric',
            'code' => 'required|string',
        ]);

        $device = Device::where('code', $request->code)->first();

        if (!$device) {
            return response()->json([
                'message' => 'Device not found',
            ], 404);
        }

        $patient = Patient::where('device_code', $device->code)->first();

        if (!$patient) {
            return response()->json([
                'message' => 'Patient not found',
            ], 404);
        }

        $reading = new Reading([
            'temperature' => $request->temperature,
            'frequency_cardiac' => $request->frequencyCardiac,
            'pressure_diastolic' => $request->pressureDiastolic,
            'pressure_sistolic' => $request->pressureSistolic,
            'oxygen_saturation' => $request->oxygenSaturation,
            'device_id' => $device->id,
            'patient_id' => $patient->id,
        ]);

        $reading->save();

        try {
            if ($reading->temperature > 39) {
                Mail::to('alicoescobar@gmail.com')->send(new SendAlertMailable(
                    $patient,
                    $reading,
                ));
            } else if ($reading->oxygen_saturation < 90) {
                Mail::to('alicoescobar@gmail.com')->send(new SendAlertMailable(
                    $patient,
                    $reading,
                ));
            } else if ($reading->frequency_cardiac < 60) {
                Mail::to('alicoescobar@gmail.com')->send(new SendAlertMailable(
                    $patient,
                    $reading,
                ));
            } else if ($reading->pressure_diastolic > 90) {
                Mail::to('alicoescobar@gmail.com')->send(new SendAlertMailable(
                    $patient,
                    $reading,
                ));
            } else if ($reading->pressure_sistolic > 140) {
                Mail::to('alicoescobar@gmail.com')->send(new SendAlertMailable(
                    $patient,
                    $reading,
                ));
            }
        } catch (\Throwable $th) {
            //throw $th;
        }

        return response()->json(new ReadingResource($reading), 201);
    }

    public function findByPatient(Request $request, $id)
    {
        $readings = Reading::where('patient_id', $id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        return response()->json(new ReadingResource($readings), 200);
    }
}
