<?php

namespace App\Http\Controllers;

use App\Http\Resources\PatientResource;
use App\Models\Device;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PatientController extends Controller
{

    public function index()
    {
        $patients = Patient::all();
        return response()->json(PatientResource::collection($patients), 200);
    }


    public function store(Request $request)
    {
        // validation
        $request->validate(
            [
                'firstName' => 'required|max:100|min:2|string|alpha',
                'lastName' => 'required|max:100|min:2|string|alpha',
                'dni' => 'required|numeric|digits:13|unique:patients',
                'birthdate' => 'required|date|before:today',
            ]
        );

        $patient = new Patient();
        $patient->first_name = $request->firstName;
        $patient->last_name = $request->lastName;
        $patient->dni = $request->dni;
        $patient->birthdate = $request->birthdate;
        $patient->save();

        return response()->json([
            'message' => 'Patient created successfully',
            'patient' => $patient
        ], 201);
    }

    public function show(string $id)
    {
        $patient = Patient::find($id);
        return response()->json(new PatientResource($patient), 200);
    }

    public function update(Request $request, string $id)
    {
        $request->validate(
            [
                'firstName' => 'required|max:100|min:2|string|alpha',
                'lastName' => 'required|max:100|min:2|string|alpha',
                'dni' => 'required|numeric|digits:13|unique:patients,dni,' . $id,
                'birthdate' => 'required|date|before:today',
            ]
        );

        $patient = Patient::find($id);
        $patient->first_name = $request->firstName;
        $patient->last_name = $request->lastName;
        $patient->dni = $request->dni;
        $patient->birthdate = $request->birthdate;
        $patient->save();

        return response()->json([
            'message' => 'Patient updated successfully',
            'patient' => $patient
        ], 200);
    }

    public function destroy(string $id)
    {
        $patient = Patient::find($id);
        $patient->delete();
        return response()->json([
            'message' => 'Patient deleted successfully',
            'patient' => $patient
        ], 200);
    }

    public function asingnDevice(Request $request)
    {
        $request->validate(
            [
                'patientId' => 'required|exists:patients,id',
                'deviceId' => 'required|exists:devices,id',
            ]
        );
        $patient = Patient::find($request->patientId);
        $device = Device::find($request->deviceId);

        $old_patient = Patient::where('device_code', $device->code)->first();
        if ($old_patient) {
            $old_patient->device_code = null;
            $old_patient->save();
        }

        $patient->device_code = $device->code;
        $patient->save();


        return response()->json([
            'message' => 'Patient updated successfully',
            'patient' => $patient
        ], 200);
    }
}
