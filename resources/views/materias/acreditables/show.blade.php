@extends('adminlte::page')

@section('title', 'Acreditables | Ver materia')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('materias.index') }}" class="link-muted">Materias</a></li>
    <li class="breadcrumb-item active"><a href="">{{ $materia->nom_materia }}</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Materias</x-tipografia.titulo>
@stop

@section('content')
    <div class="row mt-2">

        <x-card.materia-perfil :materia="$materia" />

        <x-card.materia-desc :materia="$materia" />

        {{-- Tarjetas información materia --}}
        <section class="col-12 border-bottom">
            <div class="row">
                <x-elementos.mini-card :datos="['Tipo', materiaRelacion($materia, 'Tipo')]" />
                <x-elementos.mini-card :datos="['Categoría', materiaRelacion($materia, 'Categoria')]" />
                <x-elementos.mini-card :datos="['Horario', materiaRelacion($materia, 'Horario')]" />
                <x-elementos.mini-card :datos="['Acreditable', materiaRelacion($materia, 'Acreditable')]" />
            </div>
        </section>

        {{-- Listado de estudiantes --}}
        <section class="col-12 my-3">
            @if (!rol('Estudiante'))
                <a href="{{ route('listadoEstudiantes', $materia->id) }}" class="btn btn-primary float-right"
                    {{ Popper::arrow()->pop('Descargar listado de estudiantes') }}>
                    <i class="fas fa-download" style="width: 2rem"></i>
                </a>
            @endif

            <div class="card col-12 table-responsive-sm p-3">
                <table id='tabla' class="table table-striped">
                    <thead>
                        <tr class="bg-secondary">
                            @if (!rol('Estudiante'))
                                <th>Cédula</th>
                            @endif

                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Estado</th>

                            @if (!rol('Estudiante'))
                                <th>Código de Validación</th>
                                <th>Acciones</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($inscritos as $estudiante)
                            <tr>
                                @if (!rol('Estudiante'))
                                    <td>{{ datosUsuario($estudiante, 'EstudianteInscrito', 'CI') }}</td>
                                @endif

                                <td>{{ datosUsuario($estudiante, 'EstudianteInscrito', 'nombre') }}</td>
                                <td>{{ datosUsuario($estudiante, 'EstudianteInscrito', 'apellido') }}</td>
                                <td
                                    class="{{ datosUsuario($estudiante, 'EstudianteInscrito', 'validado') ? 'text-success' : 'text-danger' }}">
                                    {{ datosUsuario($estudiante, 'EstudianteInscrito', 'validado') ? 'Validado' : 'No validado' }}
                                </td>

                                @if (!rol('Estudiante'))
                                    <td>{{ datosUsuario($estudiante, 'EstudianteInscrito', 'codigo') }}</td>
                                    <td>
                                        <div class="btn-group mx-1" role="group" aria-label="Acciones">
                                            @can('materias.modificar')
                                                <a href="{{ route('comprobante', $estudiante->esEstudiante->id) }}"
                                                    class="btn btn-danger mr-2"
                                                    {{ Popper::arrow()->pop('Comprobante de inscripción') }}>
                                                    <i class="fas fa-file-pdf" style="width: 15px"></i>
                                                </a>

                                                @php
                                                    $ruta = datosUsuario($estudiante, 'EstudianteInscrito', 'validado') ? 'invalidacion' : 'validacion';
                                                @endphp

                                                <form action="{{ route($ruta, $estudiante->id) }}" method="POST">
                                                    @csrf

                                                    <button type="submit"
                                                        class="btn btn-{{ datosUsuario($estudiante, 'EstudianteInscrito', 'validado') ? 'secondary' : 'primary' }} mr-2"
                                                        {{ Popper::arrow()->pop('Validar inscripción') }}>
                                                        <i class="fas {{ datosUsuario($estudiante, 'EstudianteInscrito', 'validado') ? 'fa-eraser' : 'fa-user-check' }}"
                                                            style="width: 15px"></i>
                                                    </button>
                                                </form>
                                            @endcan

                                            <a href="{{ route('asistencias.edit', $estudiante->esEstudiante->id) }}"
                                                class="btn btn-primary" {{ Popper::arrow()->pop('Marcar asistencia') }}>
                                                <i class="fas fa-calendar" style="width: 15px"></i>
                                            </a>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/decoracion.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cambiarAcreditable.css') }}">
@stop

@section('js')
    @include('popper::assets')
    <script src="{{ asset('vendor/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>

    {{-- Personalizados --}}
    <script src="{{ asset('js/tablas.js') }}"></script>
    <script src="{{ asset('js/cambiarAcreditable.js') }}"></script>

    {{-- Mensajes --}}
    <script>
        @if ($message = session('registrado'))
            Swal.fire({
                icon: 'success',
                title: '¡Inscripción exitosa!',
                html: 'Ya se encuentra inscrito en la materia, a continuación lleve el comprobante ubicado en su pefil a la Coordinación de Acreditables para finalizar su inscripción. <br>[<strong>Nota</strong>] <span class="text-muted"><a href="{{ route('profile.show') }}">Haga clic aquí</a> o vaya a su perfil (avatar al lado de su nombre) para descargar el comprobante.<span>',
                    buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('actualizado'))
            Swal.fire({
                icon: 'success',
                title: '¡Asistencia actualizada!',
                html: 'El registro de asistencia fue actualizado.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('invalidado'))
            Swal.fire({
                icon: 'info',
                title: '¡Estudiante invalidado!',
                html: 'El estudiante no podrá cursar esta acreditable.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger px-5'
                },
            })
        @elseif ($message = session('validado'))
            Swal.fire({
                icon: 'success',
                title: '¡Estudiante validado!',
                html: 'El estudiante ya puede cursar su acreditable.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('cambioExitoso'))
            Swal.fire({
                icon: 'success',
                title: '¡Acreditable cambiada!',
                html: 'Se ha cambiado de acreditable exitosamente.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('no puede participar'))
            Swal.fire({
                icon: 'warning',
                title: '¡No puede cursar!',
                html: 'Este estudiante no se encuentra validado, en caso de que haya traído su comprobante por favor valídelo en la lista, hasta entonces no podrá tener asistencia o lo que es igual, no contará la acreditable.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger px-5'
                },
            })
        @endif
    </script>
@stop
