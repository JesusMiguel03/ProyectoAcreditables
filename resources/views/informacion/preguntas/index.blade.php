@extends('adminlte::page')

@section('title', 'Acreditables | ¿Sabías que?')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item active"><a href="">Preguntas frecuentes</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Preguntas frecuentes</x-tipografia.titulo>

    @can('preguntas.modificar')
        <div class="modal fade" id="registrar" tabindex="-1" role="dialog" aria-labelledby="campopregunta" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <header class="modal-header bg-primary">
                        <h5 class="modal-title" id="campopregunta">Nueva pregunta</h5>
                    </header>

                    <main class="modal-body">
                        <div class="label-group mb-3">
                            <form action="{{ route('preguntas.store') }}" method="post">
                                @csrf

                                <x-formularios.preguntas />
                            </form>
                        </div>
                    </main>
                </div>
            </div>
        </div>

        <x-formularios.borrar />
    @endcan
@stop

@section('content')
    {{-- Preguntas --}}
    @if (rol('Coordinador'))
        <div class="card table-responsive-sm p-3 mt-1 mb-3 col-12">
            <section class="w-100 row mx-auto">
                <div class="col-md-2 col">
                    <button class="btn btn-block btn-primary my-2" data-toggle="modal" data-target="#registrar"
                        {{ Popper::arrow()->pop('Nueva pregunta') }}>
                        <i class="fas fa-plus mr-2"></i>
                        {{ 'Añadir' }}
                    </button>
                </div>
            </section>

            <table id='tabla' class="table table-striped">
                <thead>
                    <tr class="bg-secondary">
                        <th>Pregunta</th>
                        <th>Respuesta</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($preguntas as $pregunta)
                        <tr>
                            <td>{{ $pregunta->titulo }}</td>
                            <td>{{ $pregunta->explicacion }}</td>
                            <td>
                                <div class="btn-group mx-1" role="group" aria-label="Acciones">
                                    <a href="{{ route('preguntas.edit', $pregunta->id) }}" class="btn btn-primary"
                                        {{ Popper::arrow()->pop('Editar') }}>
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <button id="{{ $pregunta->id }}" class="btn btn-danger borrar"
                                        {{ Popper::arrow()->pop('Borrar') }} data-type="Pregunta"
                                        data-name="{{ $pregunta->titulo }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="card col-12 table-responsive-sm p-3 mt-1 mb-3">
            <div class="card-body box-profile">
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="list-group" id="list-tab" role="tablist">
                            @foreach ($preguntas as $pregunta)
                                <a class="list-group-item list-group-item-action {{ $loop->first ? 'active' : '' }}"
                                    id="list-{{ $pregunta->id }}-list" data-toggle="list" href="#list-{{ $pregunta->id }}"
                                    role="tab" aria-controls="{{ $pregunta->id }}">¿{{ $pregunta->titulo }}?</a>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-8">
                        <div class="tab-content text-justify" id="nav-tabContent">
                            @foreach ($preguntas as $pregunta)
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                    id="list-{{ $pregunta->id }}" role="tabpanel"
                                    aria-labelledby="list-{{ $pregunta->id }}-list">
                                    {{ $pregunta->explicacion }}.
                                    @if ($pregunta->titulo === 'Cuáles son las opciones')
                                        <a href="{{ route('materias.index') }}">Ver acreditables</a>.
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">

    {{-- Personalizados --}}
    <link rel="stylesheet" href="{{ asset('css/estilosVarios/required.css') }}">
    <link rel="stylesheet" href="{{ asset('css/descripcion.css') }}">
    <link rel="stylesheet" href="{{ asset('css/iconos/lapiz.css') }}">
@stop

@section('js')
    @include('popper::assets')
    <script src="{{ asset('vendor/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>

    {{-- Personalizados --}}
    <script src="{{ asset('js/tablas.js') }}"></script>
    <script src="{{ asset('js/borrar.js') }}"></script>

    {{-- Mensajes --}}
    <script>
        @if ($message = session('creado'))
            Swal.fire({
                icon: 'success',
                title: 'Pregunta registrada!',
                html: 'Una nueva pregunta ha sido añadido.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error al registrar',
                html: 'Uno de los parámetros parece estar mal.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger px-5'
                },
            })
            $('#registrar').modal('show')
        @elseif ($message = session('registrado'))
            Swal.fire({
                icon: 'info',
                title: 'Ya registrada',
                html: 'La pregunta ya se encuentra registrada.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info px-5'
                },
            })
        @elseif ($message = session('actualizado'))
            Swal.fire({
                icon: 'success',
                title: '¡Datos actualizados!',
                html: 'La pregunta ha sido actualizada.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('borrado'))
            Swal.fire({
                icon: 'success',
                title: '¡Pregunta borrada exitosamente!',
                html: 'La pregunta ha sido borrada.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('no encontrado'))
            Swal.fire({
                icon: 'error',
                title: '¡Pregunta no encontrada!',
                html: 'La pregunta que desea buscar no se encuentra disponible.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info px-5'
                },
            })
        @endif
    </script>
@stop
