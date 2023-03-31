@extends('adminlte::page')

@section('title', 'Acreditables | Noticias')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item active"><a href="">Noticias</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Noticias</x-tipografia.titulo>

    <div class="modal fade" id="registrar" tabindex="-1" role="dialog" aria-labelledby="camponoticia" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <header class="modal-header bg-primary">
                    <h5 class="modal-title" id="camponoticia">Nueva noticia</h5>
                </header>

                <main class="modal-body">
                    <div class="label-group mb-3">
                        <form action="{{ route('noticias.store') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <x-formularios.noticias />
                        </form>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <x-formularios.borrar />
@stop

@section('content')
    <div class="card table-responsive-sm p-3 mt-1 mb-3 col-12">

        <div class="w-100 row mx-auto my-2">
            <p class="text-muted">
                <strong>Nota:</strong>
                El carrusel solo mostrará las primeras {{ config('variables.carrusel') }} noticias activas para no
                sobrecargar la vista del usuario, el resto de noticias estarán disponibles en la tabla pero no visibles.
            </p>
        </div>

        <div class="w-100 row mx-auto">
            <div class="col-md-2 col">
                <button class="btn btn-block btn-primary my-2" data-toggle="modal" data-target="#registrar"
                    {{ Popper::arrow()->pop('Nueva noticia') }}>
                    <i class="fas fa-plus mr-2"></i>
                    {{ 'Añadir' }}
                </button>
            </div>
        </div>

        <table id='tabla' class="table table-striped">
            <thead>
                <tr class="bg-secondary">
                    <th>Título</th>
                    <th>Descripcion</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($noticias as $noticia)
                    <tr>
                        <td>{{ $noticia->titulo }}</td>
                        <td style="max-width: 20vw">{{ $noticia->desc_noticia }}</td>
                        <td>{{ $noticia->activo === 0 ? 'Inactivo' : 'Activo' }}</td>
                        <td>
                            <div class="btn-group mx-1" role="group" aria-label="Acciones">
                                <a href="{{ route('noticias.edit', $noticia->id) }}" class="btn btn-primary"
                                    {{ Popper::arrow()->pop('Editar') }}>
                                    <i class="fas fa-edit"></i>
                                </a>

                                <button id="{{ $noticia->id }}" class="btn btn-danger borrar"
                                    {{ Popper::arrow()->pop('Borrar') }} data-type="Noticia"
                                    data-name="{{ $noticia->titulo }}">
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
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('vendor/sweetalert2/bootstrap-4.min.css') : asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('vendor/DataTables/datatables.min.css') : asset('vendor/DataTables/datatables.min.css') }}">

    {{-- Personalizados --}}
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('css/estilosVarios/required.css') : asset('css/estilosVarios/required.css') }}">
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('css/iconos/buscar.css') : asset('css/iconos/buscar.css') }}">
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('css/iconos/lapiz.css') : asset('css/iconos/lapiz.css') }}">
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('css/descripcion.css') : asset('css/descripcion.css') }}">
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
    <script src="{{ request()->secure() ? secure_asset('js/previsualizacion.js') : asset('js/previsualizacion.js') }}">
    </script>
    <script src="{{ request()->secure() ? secure_asset('js/borrar.js') : asset('js/borrar.js') }}"></script>

    {{-- Validaciones --}}
    <script>
        const titulo = document.getElementById('titulo')
        const descripcion = document.getElementById('descripcion')
        const activo = document.getElementById('mostrar')
        const boton = document.getElementById('formularioEnviar')

        const estados = ['0', '1']

        let [validacionTitulo, validacionDescripcion, validacionActivo] = [
            titulo.value.length > 5 && titulo.value.length < 30,
            descripcion.value.length > 15 && descripcion.value.length < 100,
            estados.includes(activo.options[activo.selectedIndex].value)
        ]

        const validarFormulario = () => {
            if (validacionTitulo && validacionDescripcion && validacionActivo) {
                boton.removeAttribute('disabled')
            } else {
                boton.disabled = true
            }
        }

        validarFormulario()

        titulo.addEventListener('input', (e) => {
            titulo.value = titulo.value.replace(/[^A-zÀ-ÿ0-9¡?¿!\s]+/g, '')
            titulo.value = titulo.value.replace(/ {2,}/g, '')

            if (titulo.value.length > 30) {
                titulo.value = titulo.value.slice(0, 30)
            }

            if (/^[\p{L}\p{N}\s¿?¡!]+(?:[\p{L}\p{N}\s¿?¡!]+)*$/u.test(titulo.value)) {
                if (titulo.value.length > 5 && titulo.value.length < 30) {
                    titulo.classList.remove('is-invalid')
                    validacionTitulo = true
                } else {
                    titulo.classList.add('is-invalid')
                    validacionTitulo = false
                }
            } else {
                titulo.classList.add('is-invalid')
                validacionTitulo = false
            }

            validarFormulario()
        })

        descripcion.addEventListener('input', (e) => {
            descripcion.value = descripcion.value.replace(/[^A-zÀ-ÿ0-9¡?¿!\s]+/g, '')
            descripcion.value = descripcion.value.replace(/ {2,}/g, '')

            if (descripcion.value.length > 100) {
                descripcion.value = descripcion.value.slice(0, 100)
            }

            if (/^[\p{L}\p{N}\s¿?¡!]+(?:[\p{L}\p{N}\s¿?¡!]+)*$/u.test(descripcion.value)) {
                if (descripcion.value.length > 15 && descripcion.value.length < 100) {
                    descripcion.classList.remove('is-invalid')
                    validacionDescripcion = true
                } else {
                    descripcion.classList.add('is-invalid')
                    validacionDescripcion = false
                }
            } else {
                descripcion.classList.add('is-invalid')
                validacionDescripcion = false
            }

            validarFormulario()
        })

        activo.addEventListener('change', (e) => {
            if (estados.includes(activo.options[activo.selectedIndex].value)) {
                activo.classList.remove('is-invalid')
                validacionActivo = true
            } else {
                activo.classList.add('is-invalid')
                validacionActivo = false
            }

            validarFormulario()
        })
    </script>

    {{-- Mensajes --}}
    <script>
        @if ($message = session('creado'))
            Swal.fire({
                icon: 'success',
                title: '¡Noticia registrada!',
                html: 'Una nueva noticia ha sido añadida.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('error'))
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
        @elseif ($message = session('registrado'))
            Swal.fire({
                icon: 'info',
                title: '¡Ya registrada!',
                html: 'La noticia ya se encuentra registrada.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info px-5'
                },
            })
        @elseif ($message = session('actualizado'))
            Swal.fire({
                icon: 'success',
                title: '¡Datos actualizados!',
                html: 'La noticia ha sido actualizada.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('borrado'))
            Swal.fire({
                icon: 'success',
                title: '¡Noticia borrada exitosamente!',
                html: 'La noticia ha sido borrada.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('no encontrado'))
            Swal.fire({
                icon: 'error',
                title: '¡Noticia no encontrada!',
                html: 'La noticia que desea buscar o editar no se encuentra disponible.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info px-5'
                },
            })
        @endif
    </script>
@stop
