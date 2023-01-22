@extends('adminlte::page')

@section('title', 'Acreditables | Profesor')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('profesores.index') }}" class="link-muted">Profesores</a></li>
    <li class="breadcrumb-item active">
        <a href="">{{ datosUsuario($profesor, 'Profesor', 'nombreCompleto') }}</a>
    </li>
@stop

@section('content_header')
    <x-tipografia.titulo>Listado de profesores</x-tipografia.titulo>
@stop

@section('content')
    <div class="row">
        <div class="col-md-3 col-sm-12">

            {{-- Avatar, nombre, estado --}}
            <div class="card">
                <header
                    class="card-header {{ datosUsuario($profesor, 'Profesor', 'activo') === 1 ? 'bg-primary' : 'bg-secondary' }} text-center">
                    <h6>
                        Se encuentra {{ datosUsuario($profesor, 'Profesor', 'activo') === 1 ? 'Activo' : 'Inactivo' }}
                    </h6>
                </header>

                <main class="card-body box-profile" style="height: 11rem;">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle"
                            src="{{ !empty(datosUsuario($profesor, 'Profesor', 'avatar'))
                                ? asset('vendor/img/avatares/' . datosUsuario($profesor, 'Profesor', 'avatar') . '.webp')
                                : asset('vendor/img/defecto/usuario.webp') }}"
                            alt="Avatar del profesor">
                    </div>

                    <h3 class="profile-username text-center">
                        <strong>{{ datosUsuario($profesor, 'Profesor', 'nombreCompleto') }}</strong>
                    </h3>
                </main>
            </div>
        </div>

        {{-- Informacion de interes --}}
        <div class="col-md-9 col-sm-12">
            <div class="card">
                <header class="card-header bg-primary">
                    <h5>Información de interés</h5>
                </header>
                <main class="card-body" style="height: 10.7rem">
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
                                {{ datosUsuario($profesor, 'Profesor', 'correo') }}
                            </p>
                            <p class="text-muted">
                                {{ datosUsuario($profesor, 'Profesor', 'tlf') }}
                            </p>
                            <p class="text-muted">
                                {{ datosUsuario($profesor, 'Profesor', 'residencia') }}
                            </p>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        {{-- Informacion academica --}}
        <div class="col-12">
            <div class="card">
                <header class="card-header bg-primary">
                    <h5>Información del educador</h5>
                </header>

                <main class="card-body">
                    <div class="row">

                        @php
                            $temp = [];
                            $campos = ['Área de conocimiento', 'Descripción', 'Fecha de ingreso al plantel', 'Pertenece al departamento'];
                            if (!empty($profesor->conocimiento)) {
                                array_push($temp, $profesor->conocimiento->nom_conocimiento, $profesor->conocimiento->desc_conocimiento);
                            } else {
                                array_push($temp, 'No asignado', '');
                            }
                            array_push($temp, $profesor->fecha_ingreso_institucion, $profesor->departamento->nom_pnf);
                        @endphp

                        @foreach ($temp as $index => $datos)
                            <div class="col-md-3 col-sm-12">
                                <p class="font-weight-bold border-right">
                                    {{ $campos[$index] }}
                                </p>
                            </div>
                            <div class="col-md-9 col-sm-12">
                                <p class="text-muted ml-4 ml-md-0">
                                    {{ $datos }}
                                </p>
                            </div>
                        @endforeach

                        <div class="col-md-3 col-sm-12">
                            <p class="font-weight-bold border-right">
                                Materias impartidas
                            </p>
                        </div>

                        <div class="col-md-9 col-sm-12">
                            <p class="text-muted ml-4 ml-md-0">
                                @if (!empty($materias))
                                    @foreach ($materias as $materia)
                                        <a href="{{ route('materias.show', $materia[1]) }}">
                                            {{ $materia[0] }}
                                        </a>
                                        {{ $loop->last ? '' : ', ' }}
                                    @endforeach
                                @else
                                    No se encuentra asignado
                                @endif
                            </p>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
@stop
