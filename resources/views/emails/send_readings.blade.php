@extends('layouts.app')

@section('title', 'Readings')

@section('content')

    <div class="container mt-5 border rounded">
        <div class="row">
            <h1 class="text-center">Informacion del paciente</h1>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="ms-3">Primer Nombre</label>
                    <input type="text" class="form-control" value="{{ $patient->first_name }}" disabled>
                </div>
                <div class="col-md-6">
                    <label class="ms-3">Primer Apellido</label>
                    <input type="text" class="form-control" value="{{ $patient->last_name }}" disabled>
                </div>

                <div class="col-md-12 mt-2">
                    <label class="ms-3">DNI</label>
                    <input type="text" class="form-control" value="{{ $patient->dni }}" disabled>
                </div>
            </div>

            <div class="row">

                <div class="col-md-3 ">
                    <!-- card -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Temperatura Maxima</h5>
                            <p class="card-text"> {{ $temperature_max }} °C</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 ">
                    <!-- card -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Frecuencia cardiaca maxima</h5>
                            <p class="card-text"> {{ $frequency_cardiac_max }} ppm</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 ">
                    <!-- card -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Presion arterial</h5>
                            <p class="card-text"> {{ $pressure_arterial_max }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 ">
                    <!-- card -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Spo2 minima</h5>
                            <p class="card-text">{{ $oxygen_min }} %</p>
                        </div>
                    </div>
                </div>
            </div>


            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Temp.</th>
                            <th scope="col">F. Cardíaca</th>
                            <th scope="col">P. sanguinea</th>
                            <th scope="col">Oxigeno</th>
                            <th scope="col">Fecha</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($readings as $reading)
                            <tr>
                                <td>{{ $reading->temperature }} °C</td>
                                <td>{{ $reading->frequency_cardiac }} ppm</td>
                                <td>{{ $reading->pressure_sistolic }} / {{ $reading->pressure_diastolic }}</td>
                                <td>{{ $reading->oxygen_saturation }} %</td>
                                <td>{{ $reading->created_at }}</td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No hay datos</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>


            </div>

            @if ($url_download)
                <a href="{{ $url_download }}" download=""> Descargar</a>
            @endif

        </div>

    </div>
@endsection
