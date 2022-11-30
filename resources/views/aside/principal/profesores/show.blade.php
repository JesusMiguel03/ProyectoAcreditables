@extends('adminlte::page')

@section('title', 'Acreditables | Profesor')

@section('content_header')
    <div class="row">
        <div class="col-6">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('profesores.index') }}" class="link-muted">Profesores</a></li>
                <li class="breadcrumb-item active"><a href="">Profesor</a></li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-3 col-sm-12">
            <div class="card">
                <div class="card-body box-profile" style="height: 15.063rem;">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle mt-5"
                            src="{{ asset('/vendor/img/profs/user0.jpg') }}" alt="User profile picture">
                    </div>

                    <h3 class="profile-username text-center">
                        <strong>{{ __($profesor->usuario->nombre . ' ' . $profesor->usuario->apellido) }}</strong>
                    </h3>
                </div>
            </div>

        </div>

        <div class="col-md-9 col-sm-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <h5>Información de interés</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <p class="font-weight-bold">
                                Correo
                            </p>
                            <p class="font-weight-bold">
                                Teléfono
                            </p>
                            <p class="font-weight-bold">
                                Dirección
                            </p>
                        </div>
                        <div class="col-9">
                            <p class="text-muted">
                                {{ $profesor->usuario->email }}
                            </p>
                            <p class="text-muted">
                                {{ substr($profesor->telefono, 0, 4) . ' ' . substr($profesor->telefono, 4) }}
                            </p>
                            <p class="text-muted">
                                Estado: {{ $profesor->estado }} - Ciudad: {{ $profesor->ciudad }} - Urbanización: {{ $profesor->urb }} -
                                Calle: {{ $profesor->calle }} - Casa: {{ $profesor->casa }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <p class="font-weight-bold">
                                Área de conomiento
                            </p>
                            <p class="font-weight-bold">
                                Fecha de ingreso al plantel
                            </p>
                            @if (!empty($profesor->especialidades))
                                <p class="font-weight-bold">
                                    Áreas de conocimiento
                                </p>
                            @endif
                        </div>
                        <div class="col-9">
                            <p class="text-muted">
                                {{ !empty($profesor->titulo) ? $profesor->titulo : 'No asignado' }}.
                            </p>
                            <p class="text-muted">
                                {{ $profesor->fecha_ingreso_institucion }}.
                            </p>
                            @if (empty($profesor->especialidades))
                                <p class="text-muted">
                                    No se han establecido.
                                </p>
                            @else
                                <p class="text-muted">
                                    @foreach ($profesor->especialidades as $especialidad)
                                        {{ $especialidad->nom_especialidad }} |
                                    @endforeach
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
