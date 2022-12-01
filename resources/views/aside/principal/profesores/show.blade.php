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
                            src="{{ empty($profesor->usuario->avatar) ? asset('/vendor/img/profs/user.webp') : asset('vendor/img/profs/' . $profesor->usuario->avatar) }}" alt="Avatar del profesor">
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
                                Estado: {{ $profesor->estado }} - Ciudad: {{ $profesor->ciudad }} - Urbanización:
                                {{ $profesor->urb }} -
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
                                Área de conocimiento
                            </p>
                            <p class="font-weight-bold">
                                Fecha de ingreso al plantel
                            </p>
                            <p class="font-weight-bold">
                                Pertenece al departamento
                            </p>
                        </div>
                        <div class="col-9">
                            @if (empty($profesor->conocimiento))
                                <p class="text-muted">
                                    No se han establecido.
                                </p>
                            @else
                                <p class="text-muted">
                                    [{{ $profesor->conocimiento->nom_especialidad }}]. {{ $profesor->conocimiento->desc_especialidad }}
                                </p>
                            @endif
                            <p class="text-muted">
                                {{ $profesor->fecha_ingreso_institucion }}.
                            </p>
                            <p class="text-muted">
                                {{ $profesor->departamento->nom_pnf }}.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
