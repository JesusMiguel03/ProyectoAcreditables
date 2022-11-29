@extends('adminlte::page')

@section('title', 'Acreditables | Listado de profesores')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Perfil de profesor(a)</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}">Inicio</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('profesores.index') }}">Profesores</a></li>
                <li class="breadcrumb-item active"><a href="">Profesor</a></li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-3 col-sm-12">

                <div class="card">
                    <div class="card-body box-profile" style="height: 13.938rem;">

                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle mt-4"
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
                    <div class="card-header">
                        <div class="row">
                            <h4>Información de interés</h4>

                            <a href="{{ route('profesores.index') }}" class="btn btn-outline-secondary ml-auto"
                                style="width: 10rem">Volver al listado</a>
                        </div>
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
                                    {{ $profesor->telefono }}
                                </p>
                                <p class="text-muted">
                                    {{ $profesor->direccion }} - {{ $profesor->ciudad }} - {{ $profesor->estado }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- @dd($profesor->especialidades) --}}
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
                                        Especialidades
                                    </p>
                                @endif
                            </div>
                            <div class="col-9">
                                <p class="text-muted">
                                    {{ $profesor->titulo }}
                                </p>
                                <p class="text-muted">
                                    {{ $profesor->fecha_ingreso_plantel }}
                                </p>
                                @if (!empty($profesor->especialidades))
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

    </div>
@stop
