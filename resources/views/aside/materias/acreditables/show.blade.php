@extends('adminlte::page')

@section('title', 'Acreditables | Ver materia')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Acreditable | {{ $materia->nom_materia }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('materias.index') }}">Materias</a></li>
                <li class="breadcrumb-item active"><a href="">{{ $materia->nom_materia }}</a></li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    {{-- Page content --}}
    <div class="container-fluid">

        <x-botones.volver />

        <div class="row mt-4">
            <div class="col-sm-12 col-md-3">
                <div class="card" style="height: 13.52rem;">
                    @if (!empty($materia->info))
                        <div class="card-body box-profile">
                            <div class="text-center mt-4">
                                <img class="profile-user-img img-fluid img-circle"
                                    src="{{ asset('/vendor/img/profs/user0.jpg') }}" alt="User profile picture">
                            </div>
                            <h3 class="profile-username text-center">{{ $materia->info->profesor->usuario->nombre }}
                                {{ $materia->info->profesor->usuario->apellido }}</h3>

                            @can('gestionar.materias')
                                <a href="{{ route('profesores.show', $materia->profesor->id) }}"
                                    class="btn btn-primary d-block">Ver
                                    perfil</a>
                            @endcan
                        </div>
                    @else
                        <div class="card-body text-center">
                            <img class="profile-user-img img-fluid img-circle"
                                src="{{ asset('/vendor/img/profs/user.webp') }}" alt="User profile picture">
                        </div>
                        <div class="card-footer" style="min-height: 4.77rem">
                            <h6 class="text-muted text-justify">Actualmente no hay un profesor asignado.</h6>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-sm-12 col-md-9">
                <div class="card">
                    <div class="card-body" style="min-height: 13.52rem">

                        <h2 class="d-none d-md-block">Cupos disponibles
                            [ <span class="text-info">{{ $materia->cupos_disponibles }}</span> /
                            <span class="text-info">{{ $materia->cupos }}</span> ]
                        </h2>
                        <h2 class="d-md-none">Cupos disponibles</h2>
                        <h2 class="d-md-none">[ <span class="text-info">{{ $materia->cupos_disponibles }}</span> / <span
                                class="text-info">{{ $materia->cupos }}</span>]</h2>

                        <p class="text-justify text-muted">{{ $materia->desc_materia }}</p>
                        @can('gestionar.materias')
                            <div class="text-center">
                                <a href="{{ route('materias.index') }}" class="btn btn-secondary mr-4"
                                    style="width: 10rem">Volver</a>
                                <a href="{{ route('materias.edit', $materia->id) }}" class="btn btn-primary"
                                    style="width: 10rem">Editar</a>
                            </div>
                        @endcan

                        @can('preinscribir')
                            @if (Auth::user()->getRoleNames()[0] === 'Estudiante' &&
                                !Auth::user()->estudiante->preinscrito->materia_id === $materia->id)
                                <div class="text-center pt-5">
                                    <form action="{{ route('preinscripcion.store') }}" method="post">
                                        @csrf

                                        <input type="number" name="usuario_id" class="d-none" hidden
                                            value="{{ Auth::user()->estudiante->id }}">
                                        <input type="number" name="materia_id" class="d-none" hidden
                                            value="{{ $materia->id }}">

                                        <button type="submit" class="btn btn-outline-primary">Preinscribirme</button>
                                    </form>
                                </div>
                            @endif
                        @endcan
                    </div>

                </div>
            </div>

            <section class="col-12 border-bottom">
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="card border pt-2 text-center">
                            <strong>Tipo</strong>
                            <p class="text-muted">
                                {{ !empty($materia->info) ? '[ ' . $materia->info->metodologia_aprendizaje . ' ]' : '[ Sin asignar ]' }}
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="card border pt-2 text-center">
                            <strong>Categoria</strong>
                            <p class="text-muted">
                                {{ !empty($materia->info) ? '[ ' . $materia->info->categoria->nom_categoria . ' ]' : '[ Sin asignar ]' }}
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="card border pt-2 text-center">
                            <strong>Horario</strong>
                            <p class="text-muted">
                                [ Pendiente ]
                                {{-- {{ !empty($materia->info) ? $materia->info->horario->dia . ' - ' . $materia->info->horario->espacio . $materia->info->horario->aula . ' - ' . $materia->info->horario->hora . ' ' . $materia->info->horario->dia_noche : 'Sin asignar' }} --}}
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Students table --}}
            <div class="col-12 mt-4">
                <div class="card table-responsive-sm p-3 mb-4">
                    <table id='tabla' class="table table-striped">
                        <thead>
                            <tr class="bg-secondary">
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Validado</th>
                        </thead>
                        <tbody>
                            @if (!empty($preinscritos))
                                @foreach ($preinscritos as $estudiante)
                                    <tr>
                                        <th>{{ $estudiante->usuarios->nombre }}</th>
                                        <th>{{ $estudiante->usuarios->apellido }}</th>
                                        <th>
                                            <div class="row">
                                                <div class="col-4">
                                                    {{ $estudiante->preinscrito->validacion_estudiante === 0 ? 'No validado' : 'Validado' }}
                                                </div>
                                                <div class="col-6">
                                                    {{ $estudiante->preinscrito->codigo }}
                                                </div>
                                                <div class="col-2">
                                                    @if (Auth::user()->roles[0]->name === 'Coordinador')
                                                        @if ($estudiante->preinscrito->validacion_estudiante === 0)
                                                            <form action="{{ route('validacion') }}" method="POSt">
                                                                @csrf
                                                                <input type="number" name="id"
                                                                    value="{{ $estudiante->id }}" class="d-none" hidden>

                                                                <button type="submit"
                                                                    class="btn btn-primary">Validar</button>
                                                            </form>
                                                        @else
                                                            <form action="{{ route('invalidacion') }}" method="POSt">
                                                                @csrf
                                                                <input type="number" name="id"
                                                                    value="{{ $estudiante->id }}" class="d-none" hidden>

                                                                <button type="submit"
                                                                    class="btn btn-secondary">Invalidar</button>
                                                            </form>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </th>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>

@stop

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('/vendor/DataTables/datatables.min.css') }}" />
@stop

@section('js')
    <script src="{{ asset('/vendor/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/tablas.js') }}"></script>
@stop
