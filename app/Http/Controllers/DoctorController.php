<?php

namespace App\Http\Controllers;

use App\Http\Resources\DoctorResource;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Doctor::all();
        return response()->json(DoctorResource::collection($doctors), 200);
    }


    public function store(Request $request)
    {
        // validation
        $request->validate(
            [
                'firstName' => 'required|max:100|min:2|string|alpha',
                'lastName' => 'required|max:100|min:2|string|alpha',
                'dni' => 'required|numeric|digits:13|unique:doctors,dni',
                'birthdate' => 'required|date|before:today',
            ]
        );

        $doctor = new Doctor();
        $doctor->first_name = $request->firstName;
        $doctor->last_name = $request->lastName;
        $doctor->dni = $request->dni;
        $doctor->birthdate = $request->birthdate;
        $doctor->save();

        return response()->json([
            'message' => 'Doctor created successfully',
            'doctor' => $doctor
        ], 201);
    }

    public function show(string $id)
    {
        $doctor = Doctor::find($id);
        return response()->json(new DoctorResource($doctor), 200);
    }

    public function update(Request $request, string $id)
    {
        $request->validate(
            [
                'firstName' => 'required|max:100|min:2|string|alpha',
                'lastName' => 'required|max:100|min:2|string|alpha',
                'dni' => 'required|numeric|digits:13|unique:doctors,dni,' . $id,
                'birthdate' => 'required|date|before:today',
            ]
        );

        $doctor = Doctor::find($id);
        $doctor->first_name = $request->firstName;
        $doctor->last_name = $request->lastName;
        $doctor->dni = $request->dni;
        $doctor->birthdate = $request->birthdate;
        $doctor->save();

        return response()->json([
            'message' => 'Doctor updated successfully',
            'doctor' => $doctor
        ], 200);
    }

    public function destroy(string $id)
    {
        $doctor = Doctor::find($id);
        $doctor->delete();
        return response()->json([
            'message' => 'Doctor deleted successfully',
            'doctor' => $doctor
        ], 200);
    }
}
