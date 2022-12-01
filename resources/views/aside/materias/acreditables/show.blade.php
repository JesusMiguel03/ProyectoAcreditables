@extends('adminlte::page')

@section('title', 'Acreditables | Ver materia')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('materias.index') }}" class="link-muted">Materias</a></li>
                <li class="breadcrumb-item active"><a href="">{{ $materia->nom_materia }}</a></li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row mt-2">
        <div class="col-sm-12 col-md-3">
            <div class="card" style="height: 13.52rem;">
                @if (!empty($materia->info))
                    <div class="card-body box-profile">
                        @if (!empty($materia->info->profesor))
                            <div class="text-center mt-4">
                                <img class="profile-user-img img-fluid img-circle"
                                    src="{{ asset('/vendor/img/profs/user0.jpg') }}" alt="User profile picture">
                            </div>
                            <h3 class="profile-username text-center">{{ $materia->info->profesor->usuario->nombre }}
                                {{ $materia->info->profesor->usuario->apellido }}</h3>
                        @else
                            <div class="text-center mt-4">
                                <img class="profile-user-img img-fluid img-circle"
                                    src="{{ asset('/vendor/img/profs/user.webp') }}" alt="User profile picture">
                            </div>
                            <h3 class="profile-username text-center">Sin asignar</h3>
                        @endif

                        @can('gestionar.materias')
                            <a href="{{ route('profesores.show', $materia->profesor->id) }}" class="btn btn-primary d-block">Ver
                                perfil</a>
                        @endcan
                    </div>
                @else
                    <div class="card-body text-center">
                        <img class="profile-user-img img-fluid img-circle" src="{{ asset('/vendor/img/profs/user.webp') }}"
                            alt="User profile picture">
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
                        @if (Auth::user()->getRoleNames()[0] === 'Estudiante')
                            <div class="text-center pt-5">
                                <form action="{{ route('preinscripcion.store') }}" method="post">
                                    @csrf

                                    <input type="number" name="usuario_id" class="d-none" hidden
                                        value="{{ Auth::user()->estudiante->id }}">
                                    <input type="number" name="materia_id" class="d-none" hidden value="{{ $materia->id }}">

                                    <button type="submit"
                                        class="btn btn-{{ $materia->cupos_disponibles === 0 ? 'secondary' : 'outline-primary' }}"
                                        {{ !empty(Auth::user()->estudiante->preinscrito) || $materia->cupos_disponibles === 0 ? 'disabled' : '' }}>Preinscribirme</button>
                                </form>
                            </div>
                            {{-- @if (Auth::user()->getRoleNames()[0] === 'Estudiante' && !Auth::user()->estudiante->preinscrito->materia_id === $materia->id)
                            <div class="text-center pt-5">
                                <form action="{{ route('preinscripcion.store') }}" method="post">
                                    @csrf

                                    <input type="number" name="usuario_id" class="d-none" hidden
                                        value="{{ Auth::user()->estudiante->id }}">
                                    <input type="number" name="materia_id" class="d-none" hidden value="{{ $materia->id }}">

                                    <button type="submit" class="btn btn-outline-primary">Preinscribirme</button>
                                </form>
                            </div> --}}
                        @endif
                    @endcan
                </div>

            </div>
        </div>

        <section class="col-12 border-bottom">
            <div class="row">
                <div class="col-sm-12 col-md-3">
                    <div class="card border pt-2 text-center">
                        <strong>Tipo</strong>
                        <p class="text-muted">
                            {{ !empty($materia->info->metodologia_aprendizaje) ? '[ ' . $materia->info->metodologia_aprendizaje . ' ]' : '[ Sin asignar ]' }}
                        </p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-3">
                    <div class="card border pt-2 text-center">
                        <strong>Categoria</strong>
                        <p class="text-muted">
                            {{ !empty($materia->info->categoria) ? '[ ' . $materia->info->categoria->nom_categoria . ' ]' : '[ Sin asignar ]' }}
                        </p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-3">
                    <div class="card border pt-2 text-center">
                        <strong>Horario</strong>
                        <p class="text-muted">
                            [ Pendiente ]
                        </p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-3">
                    <div class="card border pt-2 text-center">
                        <strong>Acreditable</strong>
                        <p class="text-muted">
                            [ N{{ $materia->num_acreditable }} ]
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Listado de estudiantes --}}
        <section class="col-12">
            <div class="card col-12 table-responsive-sm p-3 my-3">
                <table id='tabla' class="table table-striped">
                    <thead>
                        <tr class="bg-secondary">
                            @if (Auth::user()->getRoleNames()[0] !== 'Estudiante')
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Cédula</th>
                                <th>Estado</th>
                                <th>Cod Validación</th>
                                <th>Acciones</th>
                            @else
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Estado</th>
                            @endif
                    </thead>
                    <tbody>
                        @if (!empty($preinscritos))
                            @foreach ($preinscritos as $estudiante)
                                <tr>
                                    @if (Auth::user()->getRoleNames()[0] !== 'Estudiante')
                                        <th>{{ $estudiante->usuarios->nombre }}</th>
                                        <th>{{ $estudiante->usuarios->apellido }}</th>
                                        <th>V-{{ number_format($estudiante->usuarios->cedula, 0, ',', '.') }}</th>
                                        <th>{{ $estudiante->preinscrito->validacion_estudiante === 0 ? 'No validado' : 'Validado' }}
                                        </th>
                                        <th>{{ $estudiante->preinscrito->codigo }}</th>
                                        <th>
                                            <div class="row">
                                                @if ($estudiante->preinscrito->validacion_estudiante === 0)
                                                    <form action="{{ route('validacion') }}" method="POSt">
                                                        @csrf
                                                        <input type="number" name="id" value="{{ $estudiante->id }}"
                                                            class="d-none" hidden>

                                                        <button type="submit" class="btn btn-primary mr-2">
                                                            <i class="fas fa-user-check" style="width: 15px"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('invalidacion') }}" method="POSt">
                                                        @csrf
                                                        <input type="number" name="id"
                                                            value="{{ $estudiante->id }}" class="d-none" hidden>

                                                        <button type="submit" class="btn btn-secondary mr-2">
                                                            <i class="fas fa-eraser" style="width: 15px"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#trayecto">
                                                    <i class="fas fa-calendar" style="width: 15px"></i>
                                                </button>
                                            </div>

                                            {{-- Modal para crear --}}
                                            <div class="modal fade" id="trayecto" tabindex="-1" role="dialog"
                                                aria-labelledby="campotrayecto" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <header class="modal-header bg-primary">
                                                            <h5 class="modal-title" id="campotrayecto">Marcar asistencia
                                                            </h5>
                                                        </header>
                                                        <main class="modal-body">
                                                            <form action="{{ route('asistencia') }}" method="post">
                                                                @csrf

                                                                <input type="text" class="d-none"
                                                                    value="{{ $estudiante->asistencia->id }}"
                                                                    name="id" hidden>

                                                                <div class="row">
                                                                    {{-- 1 --}}
                                                                    <div class="icheck-primary p-2">
                                                                        <input type="checkbox"
                                                                            name="sem1"
                                                                            id="sem1"
                                                                            {{ $estudiante->asistencia->Sem1 === 1 ? 'checked' : '' }}>

                                                                        <label for="sem1">
                                                                            {{ __('Semana 1') }}
                                                                        </label>
                                                                    </div>

                                                                    {{-- 2 --}}
                                                                    <div class="icheck-primary p-2">
                                                                        <input type="checkbox"
                                                                            name="sem2"
                                                                            id="sem2"
                                                                            {{ $estudiante->asistencia->Sem2 === 1 ? 'checked' : '' }}>

                                                                        <label for="sem2">
                                                                            {{ __('Semana 2') }}
                                                                        </label>
                                                                    </div>

                                                                    {{-- 3 --}}
                                                                    <div class="icheck-primary p-2">
                                                                        <input type="checkbox"
                                                                            name="sem3"
                                                                            id="sem3"
                                                                            {{ $estudiante->asistencia->Sem3 === 1 ? 'checked' : '' }}>

                                                                        <label for="sem3">
                                                                            {{ __('Semana 3') }}
                                                                        </label>
                                                                    </div>

                                                                    {{-- 4 --}}
                                                                    <div class="icheck-primary p-2">
                                                                        <input type="checkbox"
                                                                            name="sem4"
                                                                            id="sem4"
                                                                            {{ $estudiante->asistencia->Sem4 === 1 ? 'checked' : '' }}>

                                                                        <label for="sem4">
                                                                            {{ __('Semana 4') }}
                                                                        </label>
                                                                    </div>

                                                                    {{-- 5 --}}
                                                                    <div class="icheck-primary p-2">
                                                                        <input type="checkbox"
                                                                            name="sem5"
                                                                            id="sem5"
                                                                            {{ $estudiante->asistencia->Sem5 === 1 ? 'checked' : '' }}>

                                                                        <label for="sem5">
                                                                            {{ __('Semana 5') }}
                                                                        </label>
                                                                    </div>

                                                                    {{-- 6 --}}
                                                                    <div class="icheck-primary p-2">
                                                                        <input type="checkbox"
                                                                            name="sem6"
                                                                            id="sem6"
                                                                            {{ $estudiante->asistencia->Sem6 === 1 ? 'checked' : '' }}>

                                                                        <label for="sem6">
                                                                            {{ __('Semana 6') }}
                                                                        </label>
                                                                    </div>

                                                                    {{-- 7 --}}
                                                                    <div class="icheck-primary p-2">
                                                                        <input type="checkbox"
                                                                            name="sem7"
                                                                            id="sem7"
                                                                            {{ $estudiante->asistencia->Sem7 === 1 ? 'checked' : '' }}>

                                                                        <label for="sem7">
                                                                            {{ __('Semana 7') }}
                                                                        </label>
                                                                    </div>

                                                                    {{-- 8 --}}
                                                                    <div class="icheck-primary p-2">
                                                                        <input type="checkbox"
                                                                            name="sem8"
                                                                            id="sem8"
                                                                            {{ $estudiante->asistencia->Sem8 === 1 ? 'checked' : '' }}>

                                                                        <label for="sem8">
                                                                            {{ __('Semana 8') }}
                                                                        </label>
                                                                    </div>

                                                                    {{-- 9 --}}
                                                                    <div class="icheck-primary p-2">
                                                                        <input type="checkbox"
                                                                            name="sem9"
                                                                            id="sem9"
                                                                            {{ $estudiante->asistencia->Sem9 === 1 ? 'checked' : '' }}>

                                                                        <label for="sem9">
                                                                            {{ __('Semana 9') }}
                                                                        </label>
                                                                    </div>

                                                                    {{-- 10 --}}
                                                                    <div class="icheck-primary p-2">
                                                                        <input type="checkbox"
                                                                            name="sem10"
                                                                            id="sem10"
                                                                            {{ $estudiante->asistencia->Sem10 === 1 ? 'checked' : '' }}>

                                                                        <label for="sem10">
                                                                            {{ __('Semana 10') }}
                                                                        </label>
                                                                    </div>

                                                                    {{-- 11 --}}
                                                                    <div class="icheck-primary p-2">
                                                                        <input type="checkbox"
                                                                            name="sem11"
                                                                            id="sem11"
                                                                            {{ $estudiante->asistencia->Sem11 === 1 ? 'checked' : '' }}>

                                                                        <label for="sem11">
                                                                            {{ __('Semana 11') }}
                                                                        </label>
                                                                    </div>

                                                                    {{-- 12 --}}
                                                                    <div class="icheck-primary p-2">
                                                                        <input type="checkbox"
                                                                            name="sem12"
                                                                            id="sem12"
                                                                            {{ $estudiante->asistencia->Sem12 === 1 ? 'checked' : '' }}>

                                                                        <label for="sem12">
                                                                            {{ __('Semana 12') }}
                                                                        </label>
                                                                    </div>
                                                                </div>

                                                                {{-- Botón de registrar --}}
                                                                <div class="row mt-1">
                                                                    <x-botones.cancelar />

                                                                    <x-botones.guardar />
                                                                </div>

                                                            </form>
                                                        </main>
                                                    </div>
                                                </div>
                                            </div>
                                        </th>
                                    @else
                                        <th>{{ $estudiante->usuarios->nombre }}</th>
                                        <th>{{ $estudiante->usuarios->apellido }}</th>
                                    @endif
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@stop

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('/vendor/DataTables/datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
@stop

@section('js')
    <script src="{{ asset('/vendor/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/tablas.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        @if ($message = session('registrado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Preinscripción exitosa!',
                html: 'Ya te encuentras preinscrito en la materia, a continuación lleva el comprobante ubicado en tu pefil a la Coordinación de Acreditables para finalizar tu inscripción. <br>[<strong>Nota</strong>] <span class="text-muted">Al darle al botón Ok serás redirigido a tu perfil.<span>',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            }).then(function() {
                window.location = "/perfil"
            })
        @elseif ($message = session('actualizado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Asistencia actualizada!',
                html: 'El registro de asistencia fue actualizado.',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @endif
    </script>
@stop
