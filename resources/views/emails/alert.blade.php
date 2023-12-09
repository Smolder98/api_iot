@extends('layouts.app')

@section('title', 'Readings')

@section('content')
    <h1>Alerta de paciente</h1>
    <p class="lead">
        Alerta, lecturas del paciente {{ $patient->first_name }} {{ $patient->last_name }}
        con DNI {{ $patient->dni }} en la fecha {{ $reading->created_at }}, sobrepasan los valores
        establecidos en el sistema.
    </p>

    <table class="table">
        <thead>
            <tr>
                <th>Temperatura</th>
                <th>Presion arterial</th>
                <th>Spo2</th>
                <th>Frecuencia cardiaca</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $reading->temperature }}</td>
                <td>{{ $reading->pressure_sistolic }} / {{ $reading->pressure_diastolic }}</td>
                <td>{{ $reading->oxygen_saturation }}</td>
                <td>{{ $reading->frequency_cardiac }}</td>
            </tr>
        </tbody>
    </table>
@endsection