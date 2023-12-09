<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ReadingController;
use App\Http\Controllers\SendMailController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Auth
Route::post('/login', [AuthController::class, 'login']);

// Route::middleware(['auth:sanctum'])->group(function () {
// Users
Route::get('/users', [UserController::class, 'index']);

// Pacientes
Route::apiResource('/patients', PatientController::class);
Route::post('/patients/asing/device', [PatientController::class, 'asingnDevice']);

// Doctores
Route::apiResource('/doctors', DoctorController::class);

// Devices
Route::apiResource('/devices', DeviceController::class);

//Reading 
Route::get('/readings', [ReadingController::class, 'index']);
Route::get('/readings/search/{id}', [ReadingController::class, 'findByPatient']);
// });

// Readings
Route::post('/readings', [ReadingController::class, 'store']);


// Mails 
Route::get('/mail/readings/{id_patient}/{id_doctor}', [SendMailController::class, 'sendMailReading']);
