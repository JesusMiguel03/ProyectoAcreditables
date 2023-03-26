@extends('adminlte::page')

@section('title', 'Acreditables | Área de conocimiento')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item active"><a href="">Áreas de conocimiento</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Áreas de conocimiento</x-tipografia.titulo>

    <div class="modal fade" id="registrar" tabindex="-1" role="dialog" aria-labelledby="campoconocimiento" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <header class="modal-header bg-primary">
                    <h5 class="modal-title" id="campoconocimiento">Agregar área de conocimiento</h5>
                </header>

                <main class="modal-body">
                    <form action="{{ route('conocimientos.store') }}" method="POST">
                        @csrf

                        <x-formularios.area-conocimiento />
                    </form>
                </main>
            </div>
        </div>
    </div>

    <x-formularios.borrar />
@stop

@section('content')
    <div class="card table-responsive-sm p-3 mb-3">

        <div class="w-100 row mx-auto">
            <div class="col-md-2 col">
                <button class="btn btn-block btn-primary my-2" data-toggle="modal" data-target="#registrar"
                    {{ Popper::arrow()->pop('Nueva área de conocimiento') }}>
                    <i class="fas fa-plus mr-2"></i>
                    {{ 'Añadir' }}
                </button>
            </div>
        </div>

        <table id='tabla' class="table table-striped">
            <thead>
                <tr class="bg-secondary">
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($conocimientos as $conocimiento)
                    <tr>
                        <td>{{ $conocimiento->nom_conocimiento }}</td>
                        <td>{{ $conocimiento->desc_conocimiento }}</td>
                        <td>
                            <div class="btn-group mx-1" role="group" aria-label="Acciones">
                                <a href="{{ route('conocimientos.edit', $conocimiento->id) }}" class="btn btn-primary"
                                    {{ Popper::arrow()->pop('Editar') }}>
                                    <i class="fas fa-edit"></i>
                                </a>

                                <button id="{{ $conocimiento->id }}" class="btn btn-danger borrar"
                                    {{ Popper::arrow()->pop('Borrar') }} data-type="Área de conocimiento"
                                    data-name="{{ $conocimiento->nom_conocimiento }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/DataTables/datatables.min.css') }}">

    {{-- Personalizados --}}
    <link rel="stylesheet" href="{{ asset('css/estilosVarios/required.css') }}">
    <link rel="stylesheet" href="{{ asset('css/iconos/lapiz.css') }}">
    <link rel="stylesheet" href="{{ asset('css/descripcion.css') }}">
    <link rel="stylesheet" href="{{ asset('css/anchoTabla.css') }}">
@stop

@section('js')
    @include('popper::assets')
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('vendor/DataTables/datatables.min.js') }}"></script>

    {{-- Personalizados --}}
    <script src="{{ asset('js/tablas.js') }}"></script>
    <script src="{{ asset('js/borrar.js') }}"></script>

    {{-- Validaciones --}}
    <script>
        const nombre = document.getElementById('nombre')
        const descripcion = document.getElementById('descripcion')
        const boton = document.getElementById('formularioEnviar')

        let [validarNombre, validarDescripcion] = [
            nombre.value.length > 4 && nombre.value.length < 51,
            descripcion.value.length > 10 && descripcion.value.length < 256
        ]

        boton.disabled = true

        const validarFormulario = () => {
            if (validarNombre && validarDescripcion) {
                boton.removeAttribute('disabled')
            } else {
                boton.disabled = true
            }
        }

        nombre.addEventListener('input', (e) => {
            nombre.value = nombre.value.replace(/[^A-zÀ-ÿ\s]+/g, '')
            nombre.value = nombre.value.replace(/ {2,}/g, '')

            if (nombre.value.length > 51) {
                nombre.value = nombre.value.slice(0, 51)
            }

            if (/^\p{L}+(?:\s+\p{L}+)*$/u.test(nombre.value)) {
                if (nombre.value.length > 4 && nombre.value.length < 51) {
                    nombre.classList.remove('is-invalid')
                    validarNombre = true
                } else {
                    nombre.classList.add('is-invalid')
                    validarNombre = false
                }
            } else {
                nombre.classList.add('is-invalid')
                validarNombre = false
            }

            validarFormulario()
        })

        descripcion.addEventListener('input', (e) => {
            descripcion.value = descripcion.value.replace(/[^A-zÀ-ÿ\s]+/g, '')
            descripcion.value = descripcion.value.replace(/ {2,}/g, '')

            if (descripcion.value.length > 256) {
                descripcion.value = descripcion.value.slice(0, 256)
            }

            if (/^\p{L}+(?:\s+\p{L}+)*$/u.test(descripcion.value)) {
                if (descripcion.value.length > 10 && descripcion.value.length < 256) {
                    descripcion.classList.remove('is-invalid')
                    validarDescripcion = true
                } else {
                    descripcion.classList.add('is-invalid')
                    validarDescripcion = false
                }
            } else {
                descripcion.classList.add('is-invalid')
                validarDescripcion = false
            }

            validarFormulario()
        })
    </script>

    {{-- Mensajes --}}
    <script>
        @if (session('creado'))
            Swal.fire({
                icon: 'success',
                title: '¡Área de conocimiento registrado!',
                html: 'Un nuevo área de conocimiento ha sido añadida.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif (session('error'))
            Swal.fire({
                icon: 'error',
                title: '¡Error al registrar!',
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
                title: '¡Ya registrado!',
                html: 'El área de conocimiento se encuentra registrada.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info px-5'
                },
            })
        @elseif (session('actualizado'))
            Swal.fire({
                icon: 'success',
                title: '¡Datos actualizados!',
                html: 'El área de conocimiento ha sido actualizada.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif (session('borrado'))
            Swal.fire({
                icon: 'success',
                title: '¡Área de conocimento borrada!',
                html: 'El área de conocimiento ha sido borrada exitosamente.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif (session('no encontrado'))
            Swal.fire({
                icon: 'error',
                title: '¡Área de conocimiento no encontrada!',
                html: 'El área de conocimiento que desea buscar no se encuentra disponible.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info px-5'
                },
            })
        @elseif (session('elementoBorrado'))
            Swal.fire({
                icon: 'error',
                title: '¡Área de conocimiento ya creada!',
                html: "{{ session('elementoBorrado') }}",
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger px-5'
                },
            })
        @endif
    </script>
@stop
