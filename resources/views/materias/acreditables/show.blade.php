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

        <x-card.materia-perfil :profID="materia($materia, 'profID')" :profNombre="materia($materia, 'profesor')" :profAvatar="materia($materia, 'profAvatar')" />

        <x-card.materia-desc :cupos-disponibles="$materia->cupos_disponibles" :cupos="$materia->cupos" :contenido="$materia->desc_materia" :avatar="materia($materia, 'profAvatar')" :nombre-profesor="materia($materia, 'profesor')" :perfil-prof="materia($materia, 'profID')" :materiaID="$materia->id" />


        {{-- Tarjetas información materia --}}
        <section class="col-12 border-bottom">
            <div class="row">
                <x-elementos.mini-card :nombre="'Tipo'" :contenido='materiaRelacion($materia, "Tipo")' />
                <x-elementos.mini-card :nombre="'Categoría'" :contenido='materiaRelacion($materia, "Categoria")' />
                <x-elementos.mini-card :nombre="'Horario'" :contenido='materiaRelacion($materia, "Horario")' />
                <x-elementos.mini-card :nombre="'Acreditable'" :contenido='materiaRelacion($materia, "Acreditable")' />
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
                                    <td>{{ parsearCedula(estudiante_materia($estudiante, 'cedula')) }}</td>
                                @endif

                                <td>{{ estudiante_materia($estudiante, 'nombre') }}</td>
                                <td>{{ estudiante_materia($estudiante, 'apellido') }}</td>
                                <td
                                    class="{{ estudiante_materia($estudiante, 'estaValidado') ? 'text-success' : 'text-danger' }}">
                                    {{ estudiante_materia($estudiante, 'estaValidado') ? 'Validado' : 'No validado' }}
                                </td>

                                @if (!rol('Estudiante'))
                                    <td>{{ estudiante_materia($estudiante, 'codigo') }}</td>
                                    <td>
                                        <div class="btn-group mx-1" role="group" aria-label="Acciones">
                                            @can('materias.modificar')
                                                <a href="{{ route('comprobante', $estudiante->id) }}"
                                                    class="btn btn-danger mr-2"
                                                    {{ Popper::arrow()->pop('Comprobante de inscripción') }}>
                                                    <i class="fas fa-file-pdf" style="width: 15px"></i>
                                                </a>

                                                @php
                                                    $ruta = estudiante_materia($estudiante, 'estaValidado') ? 'invalidacion' : 'validacion';
                                                @endphp

                                                <form action="{{ route($ruta, $estudiante->id) }}" method="POST">
                                                    @csrf

                                                    <button type="submit"
                                                        class="btn btn-{{ estudiante_materia($estudiante, 'estaValidado') ? 'secondary' : 'primary' }} mr-2"
                                                        {{ Popper::arrow()->pop('Validar inscripción') }}>
                                                        <i class="fas {{ estudiante_materia($estudiante, 'estaValidado') ? 'fa-eraser' : 'fa-user-check' }}"
                                                            style="width: 15px"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                            <a href="{{ route('asistencias.edit', $estudiante->id) }}"
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
    <link rel="stylesheet" href="{{ asset('/vendor/DataTables/datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
@stop

@section('js')
    @include('popper::assets')
    <script src="{{ asset('/vendor/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>

    {{-- Personalizados --}}
    <script src="{{ asset('js/tablas.js') }}"></script>

    {{-- Mensajes --}}
    <script>
        @if ($message = session('registrado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Inscripción exitosa!',
                html: 'Ya se encuentra inscrito en la materia, a continuación lleve el comprobante ubicado en su pefil a la Coordinación de Acreditables para finalizar su inscripción. <br>[<strong>Nota</strong>] <span class="text-muted"><a href="{{ route('profile.show') }}">Haga clic aquí</a> o vaya a su perfil (avatar al lado de su nombre) para descargar el comprobante.<span>',
                confirmButtonColor: '#28a745',
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
                confirmButtonColor: '#28a745',
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
                confirmButtonColor: '#DC3545',
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
        @elseif ($message = session('no puede participar'))
            let timerInterval
            Swal.fire({
                icon: 'warning',
                title: '¡No puede cursar!',
                html: 'Este estudiante no se encuentra validado, en caso de que haya traído su comprobante por favor valídelo en la lista, hasta entonces no podrá tener asistencia o lo que es igual, no contará la acreditable.',
                confirmButtonColor: '#DC3545',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @endif
    </script>
@stop
