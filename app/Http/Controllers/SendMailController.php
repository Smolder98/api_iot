<?php

namespace App\Http\Controllers;

use App\Mail\SendReadingsMailable;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Reading;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;

class SendMailController extends Controller
{
    public function sendMailReading(Request $request, $id_patient, $id_doctor): JsonResponse
    {
        try {

            $patient = Patient::find($id_patient);
            $doctor = Doctor::find($id_doctor);

            $readings = Reading::where('patient_id', $patient->id)
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();


            if ($readings->count() == 0) {
                return response()->json(['message' => 'No readings found'], 400);
            }

            $reading_max_sistolic = $readings->sortByDesc('pressure_sistolic')->first();
            $pressure_arterial_max = $reading_max_sistolic->pressure_sistolic . ' / ' . $reading_max_sistolic->pressure_diastolic;
            $temperature_max = $readings->max('temperature');
            $frequency_cardiac_max = $readings->max('frequency_cardiac');
            $oxygen_min = $readings->min('oxygen_saturation');



            $pdf = PDF::loadView('emails.send_readings', [
                'patient' => $patient,
                'readings' => $readings,
                'pressure_arterial_max' => $pressure_arterial_max,
                'temperature_max' => $temperature_max,
                'frequency_cardiac_max' => $frequency_cardiac_max,
                'oxygen_min' => $oxygen_min,
                'url_download' => ''
            ]);
            $pdf->save(public_path() . '/pdf/' . $patient->first_name . '_' . $patient->last_name . '.pdf');
            $url_download = url('/pdf/' . $patient->first_name . '_' . $patient->last_name . '.pdf');

            Mail::to($doctor->email ?? 'alicoescobar@gmail.com')->send(new SendReadingsMailable(
                $patient,
                $readings,
                $pressure_arterial_max,
                $temperature_max,
                $frequency_cardiac_max,
                $oxygen_min,
                $url_download
            ));

            return response()->json(['message' => 'Email sent successfully', 'params' => ['id_patient' => $id_patient, 'id_doctor' => $id_doctor]]);
        } catch (\Throwable $th) {

            return response()->json([
                'message' => 'Error sending email',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    // public function sendMailReading(Request $request, $id_patient, $id_doctor): JsonResponse
    // {

    //     try {

    //         $pdf = PDF::loadView('emails.send_readings');
    //         $pdf->save(public_path() . '/pdf/my_stored_file.pdf');
    //         $url_download = url('/pdf/my_stored_file.pdf');

    //         return response()->json([
    //             'message' => 'Email sent successfully',
    //             'pdf' => $url_download
    //         ]);
    //     } catch (\Throwable $th) {

    //         return response()->json([
    //             'message' => 'Error sending email',
    //             'error' => $th->getMessage()
    //         ]);
    //     }
    // }
}
