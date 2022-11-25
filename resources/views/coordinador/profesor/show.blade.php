@extends('adminlte::page')

@section('title', 'Acreditables | Listado de profesores')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Coordinación de Acreditables</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}">Inicio</a></li>
                <li class="breadcrumb-item active"><a href="">Listado de Profesores</a></li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-3 col-sm-12">

                    <div class="card">
                        <div class="card-body box-profile" style="height: 13.863rem;">

                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle"
                                    src="{{ asset('/vendor/img/profs/user0.jpg') }}" alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center">
                                {{ __($profesor->usuario->nombre . ' ' . $profesor->usuario->apellido) }}
                            </h3>

                        </div>
                    </div>

                </div>

                <div class="col-md-9 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Información de interés</h4>
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
                                </div>
                                <div class="col-9">
                                    <p class="text-muted">
                                        {{ $profesor->titulo }}
                                    </p>
                                    <p class="text-muted">
                                        {{ $profesor->fecha_ingreso_plantel }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>
@stop
