@extends('adminlte::page')

@section('title', 'Acreditables | Categoria')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item active"><a href="">Categorias</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Categorías</x-tipografia.titulo>

    {{-- Modal para crear --}}
    <div class="modal fade" id="registrar" tabindex="-1" role="dialog" aria-labelledby="campoCategoria" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <header class="modal-header bg-primary">
                    <h5 class="modal-title" id="campoCategoria">Agregar categoria</h5>
                </header>

                <main class="modal-body">
                    <form action="{{ route('categorias.store') }}" method="post">
                        @csrf

                        <x-formularios.categorias />
                    </form>
                </main>
            </div>
        </div>
    </div>

    <x-formularios.borrar />
@stop

@section('content')
    <div class="card col-12 table-responsive-sm p-3 mt-1 mb-3">

        <div class="w-100 row mx-auto">
            <div class="col-md-2 col">
                <button class="btn btn-block btn-primary my-2" data-toggle="modal" data-target="#registrar"
                    {{ Popper::arrow()->pop('Nueva categoría') }}>
                    <i class="fas fa-plus mr-2"></i>
                    {{ 'Añadir' }}
                </button>
            </div>
        </div>

        <table id='tabla' class="table table-striped">
            <thead>
                <tr class="bg-secondary">
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($categorias as $categoria)
                    <tr>
                        <td>{{ $categoria->nom_categoria }}</td>
                        <td>
                            <a href="{{ route('categorias.edit', $categoria->id) }}" class="btn btn-primary"
                                {{ Popper::arrow()->pop('Editar') }}>
                                <i class="fas fa-edit"></i>
                            </a>

                            <button id="{{ $categoria->id }}" class="btn btn-danger borrar"
                                {{ Popper::arrow()->pop('Borrar') }} data-type="Categoría"
                                data-name="{{ $categoria->nom_categoria }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop

@section('css')
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('vendor/DataTables/datatables.min.css') : asset('vendor/DataTables/datatables.min.css') }}" />
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('vendor/sweetalert2/bootstrap-4.min.css') : asset('vendor/sweetalert2/bootstrap-4.min.css') }}">

    {{-- Personalizados --}}
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('css/estilosVarios/required.css') : asset('css/estilosVarios/required.css') }}">
@stop

@section('js')
    @include('popper::assets')
    <script
        src="{{ request()->secure() ? secure_asset('vendor/sweetalert2/sweetalert2.min.js') : asset('vendor/sweetalert2/sweetalert2.min.js') }}">
    </script>
    <script
        src="{{ request()->secure() ? secure_asset('vendor/DataTables/datatables.min.js') : asset('vendor/DataTables/datatables.min.js') }}">
    </script>

    {{-- Personalizados --}}
    <script src="{{ request()->secure() ? secure_asset('js/tablas.js') : asset('js/tablas.js') }}"></script>
    <script src="{{ request()->secure() ? secure_asset('js/borrar.js') : asset('js/borrar.js') }}"></script>

    {{-- Validaciones --}}
    <script>
        const nombre = document.getElementById('nombre')
        const boton = document.getElementById('formularioEnviar')

        let validacionNombre = nombre.value.length > 5 && nombre.value.length < 51

        const validarFormulario = () => {
            validacionNombre ? boton.removeAttribute('disabled') : boton.disabled = true
        }

        validarFormulario()

        nombre.addEventListener('input', (e) => {
            nombre.value = nombre.value.replace(/[^A-zÀ-ÿ\s]+/g, '')
            nombre.value = nombre.value.replace(/ {2,}/g, '')
            nombre.value = nombre.value.replace('_', '')

            if (nombre.value.length > 50) {
                nombre.value = nombre.value.slice(0, 50)
            }

            if (/^\p{L}+(?:\s+\p{L}+)*$/u.test(nombre.value)) {
                if (nombre.value.length > 5 && nombre.value.length < 51) {
                    nombre.classList.remove('is-invalid')
                    validacionNombre = true
                } else {
                    nombre.classList.add('is-invalid')
                    validacionNombre = false
                }
            } else {
                nombre.classList.add('is-invalid')
                validacionNombre = false
            }

            validarFormulario()
        })
    </script>

    {{-- Mensajes --}}
    <script>
        @if (session('creado'))
            Swal.fire({
                icon: 'success',
                title: '¡Categoria registrada!',
                html: 'Ahora la categoria se encuentra disponible.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif (session('actualizado'))
            Swal.fire({
                icon: 'success',
                title: '¡La categoria se ha actualizado!',
                html: 'La categoria se puede encontrar con el nuevo nombre.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif (session('error'))
            Swal.fire({
                icon: 'error',
                title: '¡Hubo un problema!',
                html: 'Parece que uno de los campos no cumple los requisitos.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger px-5'
                },
            })
            $('#registrar').modal('show')
        @elseif (session('borrado'))
            Swal.fire({
                icon: 'success',
                title: '¡Categoría borrada exitosamente!',
                html: 'La categoría ha sido borrada.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif (session('no encontrado'))
            Swal.fire({
                icon: 'error',
                title: '¡Categoría no encontrada!',
                html: 'La categoría que desea buscar o editar no se encuentra disponible.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info px-5'
                },
            })
        @elseif (session('elementoBorrado'))
            Swal.fire({
                icon: 'error',
                title: '¡Categoría no encontrada!',
                html: "{{ session('elementoBorrado') }}",
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger px-5'
                },
            })
        @endif
    </script>
@stop
