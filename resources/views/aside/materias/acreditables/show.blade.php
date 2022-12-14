@extends('adminlte::page')

@section('title', 'Acreditables | Ver materia')

@section('content_header')
    <div class="row">
        <div class="col-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('materias.index') }}" class="link-muted">Materias</a></li>
                <li class="breadcrumb-item active"><a href="">{{ $materia->nom_materia }}</a></li>
            </ol>
        </div>

        <x-tipografia.periodo fase="{{ !empty($periodo->fase) ? $periodo->fase : '' }}"
            fecha="{{ !empty($periodo->inicio) ? explode('-', explode(' ', $periodo->inicio)[0])[0] : 'Sin asignar' }}" />
    </div>

    <x-tipografia.titulo>Materias</x-tipografia.titulo>
@stop

@section('content')
    <div class="row mt-2">
        <div class="col-sm-12 col-md-3">
            <div class="card">
                <main class="card-body box-profile" @if (empty($materia->info->profesor)) style="height: 13.512rem" @endif
                    @if (Auth::user()->getRoleNames()[0] !== 'Coordinador') style="height: 13.512rem" @endif>
                    @if (!empty($materia->info->profesor))
                        <div class="text-center @if (Auth::user()->getRoleNames()[0] !== 'Coordinador') mt-4 @endif">
                            <img class="profile-user-img img-fluid img-circle"
                                src="{{ asset('/vendor/img/profs/user0.jpg') }}" alt="User profile picture">
                        </div>
                        <h4 class="profile-username text-center">{{ $materia->info->profesor->usuario->nombre }}
                            {{ $materia->info->profesor->usuario->apellido }}</h4>
                    @else
                        <div class="text-center mt-4">
                            <img class="profile-user-img img-fluid img-circle"
                                src="{{ asset('/vendor/img/profs/user.webp') }}" alt="User profile picture">
                        </div>
                        <h4 class="profile-username text-center">Sin asignar</h4>
                    @endif
                </main>
                <footer class="card-footer" style="margin-top: -1.512rem">
                    @can('materias.gestion')
                        @if (!empty($materia->info->profesor))
                            <a href="{{ route('profesores.show', $materia->info->profesor->id) }}"
                                class="btn btn-primary d-block">
                                <i class="fas fa-eye mr-2"></i>
                                Ver perfil
                            </a>
                        @endif
                    @endcan
                </footer>
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

                    @can('preinscribir')
                        @if (Auth::user()->getRoleNames()[0] === 'Estudiante')
                            <div class="text-center pt-5">
                                <form action="{{ route('preinscripcion.store') }}" method="post">
                                    @csrf

                                    <input type="number" name="estudiantes[]" class="d-none" hidden
                                        value="{{ Auth::user()->estudiante->id }}">
                                    <input type="number" name="materia_id" class="d-none" hidden value="{{ $materia->id }}">

                                    @if (!empty(Auth::user()->estudiante->preinscrito)
                                        ? Auth::user()->estudiante->preinscrito->materia_id === $materia->id
                                        : '')
                                        <button class="btn btn-secondary disabled">Se encuentra inscrito en esta
                                            acreditable</button>
                                    @else
                                        <button type="submit"
                                            class="btn btn-{{ $materia->cupos_disponibles === 0 ? 'secondary' : 'primary' }}"
                                            {{ !empty(Auth::user()->estudiante->preinscrito) || $materia->cupos_disponibles === 0 ? 'disabled' : '' }}>{{ !empty(Auth::user()->estudiante->preinscrito) ? 'Ya estás inscrito en una acreditable' : 'Inscribir' }}</button>
                                    @endif

                                </form>
                            </div>
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
        <section class="col-12 my-3">
            @if (auth()->user()->getRoleNames()[0] !== 'Estudiante')
                <a href="{{ route('listadoEstudiantes', $materia->id) }}" class="btn btn-primary float-right"
                    {{ Popper::arrow()->pop('Descargar listado de estudiantes') }}>
                    <i class="fas fa-download" style="width: 2rem"></i>
                </a>
            @endif
            <div class="card col-12 table-responsive-sm p-3">
                <table id='tabla' class="table table-striped">
                    <thead>
                        <tr class="bg-secondary">
                            @if (Auth::user()->getRoleNames()[0] !== 'Estudiante')
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Cédula</th>
                                <th>Estado</th>
                                <th>Código de Validación</th>
                                <th>Acciones</th>
                            @else
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Estado</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($preinscritos))
                            @foreach ($preinscritos as $estudiante)
                                <tr>
                                    @if (Auth::user()->getRoleNames()[0] !== 'Estudiante')
                                        <td>{{ $estudiante->usuarios->nombre }}</td>
                                        <td>{{ $estudiante->usuarios->apellido }}</td>
                                        <td>V-{{ number_format($estudiante->usuarios->cedula, 0, ',', '.') }}</td>
                                        <td>{{ $estudiante->preinscrito->validacion_estudiante === 0 ? 'No validado' : 'Validado' }}
                                        </td>
                                        <td>{{ $estudiante->preinscrito->codigo }}</td>
                                        <td>
                                            <div class="row">
                                                @can('materias.gestion')
                                                    <a href="{{ route('comprobante', $estudiante->id) }}"
                                                        class="btn btn-danger mr-2"
                                                        {{ Popper::arrow()->pop('Comprobante de inscripción') }}>
                                                        <i class="fas fa-file-pdf" style="width: 15px"></i>
                                                    </a>

                                                    @if ($estudiante->preinscrito->validacion_estudiante === 0)
                                                        <form action="{{ route('validacion') }}" method="POST">
                                                            @csrf
                                                            <input type="number" name="id" value="{{ $estudiante->id }}"
                                                                class="d-none" hidden>

                                                            <button type="submit" class="btn btn-primary mr-2"
                                                                {{ Popper::arrow()->pop('Validar inscripción') }}>
                                                                <i class="fas fa-user-check" style="width: 15px"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form action="{{ route('invalidacion') }}" method="POST">
                                                            @csrf
                                                            <input type="number" name="id" value="{{ $estudiante->id }}"
                                                                class="d-none" hidden>

                                                            <button type="submit" class="btn btn-secondary mr-2"
                                                                {{ Popper::arrow()->pop('Invalidar inscripción') }}>
                                                                <i class="fas fa-eraser" style="width: 15px"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endcan
                                                <a href="{{ route('asistencia-ver', $estudiante->id) }}"
                                                    class="btn btn-primary"
                                                    {{ Popper::arrow()->pop('Marcar asistencia') }}>
                                                    <i class="fas fa-calendar" style="width: 15px"></i>
                                                </a>
                                            </div>
                                        </td>
                                    @else
                                        <th>{{ $estudiante->usuarios->nombre }}</th>
                                        <th>{{ $estudiante->usuarios->apellido }}</th>
                                        <th>{{ $estudiante->preinscrito->validacion_estudiante === 0 ? 'No validado' : 'Validado' }}
                                        </th>
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
                html: 'Ya se encuentra preinscrito en la materia, a continuación lleve el comprobante ubicado en su pefil a la Coordinación de Acreditables para finalizar su inscripción. <br>[<strong>Nota</strong>] <span class="text-muted">El comprobante se encuentra en su perfil (avatar al lado de su nombre).<span>',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
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
        @elseif ($message = session('invalidado'))
            let timerInterval
            Swal.fire({
                icon: 'info',
                title: '¡Estudiante invalidado!',
                html: 'El estudiante no podrá cursar esta acreditable.',
                confirmButtonColor: '#17a2b8',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('validado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Estudiante validado!',
                html: 'El estudiante ya puede cursar su acreditable.',
                confirmButtonColor: '#28a745',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @endif
    </script>
@stop
