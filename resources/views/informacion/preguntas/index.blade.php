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
                        <th style="width: 60%">Respuesta</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($preguntas as $pregunta)
                        <tr>
                            <td>{{ $pregunta->titulo }}</td>
                            <td>
                                {{ $pregunta->explicacion }}
                                @if ($pregunta->titulo === 'Cómo funciona mi rol')
                                    <a href="{{ route('manual.rol') }}">Manual de usuario</a>
                                @endif
                            </td>
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
                                    @elseif ($pregunta->titulo === 'Cómo funciona mi rol')
                                        <a href="{{ route('manual.rol') }}">Manual de usuario</a>
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
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('vendor/DataTables/datatables.min.css') : asset('vendor/DataTables/datatables.min.css') }}">
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('vendor/sweetalert2/bootstrap-4.min.css') : asset('vendor/sweetalert2/bootstrap-4.min.css') }}">

    {{-- Personalizados --}}
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('css/estilosVarios/required.css') : asset('css/estilosVarios/required.css') }}">
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('css/descripcion.css') : asset('css/descripcion.css') }}">
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('css/iconos/lapiz.css') : asset('css/iconos/lapiz.css') }}">
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('css/anchoTabla.css') : asset('css/anchoTabla.css') }}">
@stop

@section('js')
    @include('popper::assets')
    <script
        src="{{ request()->secure() ? secure_asset('vendor/DataTables/datatables.min.js') : asset('vendor/DataTables/datatables.min.js') }}">
    </script>
    <script
        src="{{ request()->secure() ? secure_asset('vendor/sweetalert2/sweetalert2.min.js') : asset('vendor/sweetalert2/sweetalert2.min.js') }}">
    </script>

    {{-- Personalizados --}}
    <script src="{{ request()->secure() ? secure_asset('js/tablas.js') : asset('js/tablas.js') }}"></script>
    <script src="{{ request()->secure() ? secure_asset('js/borrar.js') : asset('js/borrar.js') }}"></script>

    {{-- Validaciones --}}
    <script>
        const pregunta = document.getElementById('pregunta')
        const respuesta = document.getElementById('respuesta')
        const boton = document.getElementById('formularioEnviar')

        let [validacionPregunta, validacionRespuesta] = [
            pregunta.value.length > 6 && pregunta.value.length < 31,
            respuesta.value.length > 20 && respuesta.value.length < 255
        ]

        const valiadarFormulario = () => {
            if (validacionPregunta && validacionRespuesta) {
                boton.removeAttribute('disabled')
            } else {
                boton.disabled = true
            }
        }

        valiadarFormulario()

        pregunta.addEventListener('input', (e) => {
            pregunta.value = pregunta.value.replace(/[^A-zÀ-ÿ\s]+/g, '')
            pregunta.value = pregunta.value.replace(/ {2,}/g, '')

            if (pregunta.value.length > 30) {
                pregunta.value = pregunta.value.slice(0, 30)
            }

            if (/^[\p{L}\s]+(?:[\p{L}\s]+)*$/u.test(pregunta.value)) {
                if (pregunta.value.length > 5 && pregunta.value.length < 31) {
                    pregunta.classList.remove('is-invalid')
                    validacionPregunta = true
                } else {
                    pregunta.classList.add('is-invalid')
                    validacionPregunta = false
                }
            } else {
                pregunta.classList.add('is-invalid')
                validacionPregunta = false
            }

            valiadarFormulario()
        })

        respuesta.addEventListener('input', (e) => {
            respuesta.value = respuesta.value.replace(/[^A-zÀ-ÿ0-9(),."\s]+/g, '')
            respuesta.value = respuesta.value.replace(/ {2,}/g, '')
            respuesta.value = respuesta.value.replace('_', '')

            if (respuesta.value.length > 255) {
                respuesta.value = respuesta.value.slice(0, 255)
            }

            if (/^[\p{L}\s(),"\d,.]+(?:[\p{L}()\s",.\d]+)*$/u.test(respuesta.value)) {
                if (respuesta.value.length > 19 && respuesta.value.length < 256) {
                    respuesta.classList.remove('is-invalid')
                    validacionRespuesta = true
                } else {
                    respuesta.classList.add('is-invalid')
                    validacionRespuesta = false
                }
            } else {
                respuesta.classList.add('is-invalid')
                validacionRespuesta = false
            }

            valiadarFormulario()
        })
    </script>

    {{-- Mensajes --}}
    <script>
        @if (session('creado'))
            Swal.fire({
                icon: 'success',
                title: 'Pregunta registrada!',
                html: 'Una nueva pregunta ha sido añadido.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif (session('error'))
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
        @elseif (session('registrado'))
            Swal.fire({
                icon: 'info',
                title: 'Ya registrada',
                html: 'La pregunta ya se encuentra registrada.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info px-5'
                },
            })
        @elseif (session('actualizado'))
            Swal.fire({
                icon: 'success',
                title: '¡Datos actualizados!',
                html: 'La pregunta ha sido actualizada.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif (session('borrado'))
            Swal.fire({
                icon: 'success',
                title: '¡Pregunta borrada exitosamente!',
                html: 'La pregunta ha sido borrada.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif (session('no encontrado'))
            Swal.fire({
                icon: 'error',
                title: '¡Pregunta no encontrada!',
                html: 'La pregunta que desea buscar no se encuentra disponible.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info px-5'
                },
            })
        @elseif (session('elementoBorrado'))
            Swal.fire({
                icon: 'error',
                title: '¡Pregunta frecuente ya creada!',
                html: "{{ session('elementoBorrado') }}",
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger px-5'
                },
            })
        @endif
    </script>
@stop
