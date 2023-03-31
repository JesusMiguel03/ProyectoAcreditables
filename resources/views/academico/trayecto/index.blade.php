@extends('adminlte::page')

@section('title', 'Acreditables | Trayectos')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item active"><a href="">Trayectos</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Trayectos</x-tipografia.titulo>

    {{-- Modal para crear --}}
    <div class="modal fade" id="registrar" tabindex="-1" role="dialog" aria-labelledby="campotrayecto" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <header class="modal-header bg-primary">
                    <h5 class="modal-title" id="campotrayecto">Agregar trayecto</h5>
                </header>

                <main class="modal-body">
                    <form action="{{ route('trayectos.store') }}" method="post">
                        @csrf

                        <x-formularios.trayectos />

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
                    {{ Popper::arrow()->pop('Nuevo trayecto') }}>
                    <i class="fas fa-plus mr-2"></i>
                    {{ 'Añadir' }}
                </button>
            </div>
        </div>

        <table id='tabla' class="table table-striped">
            <thead>
                <tr class="bg-secondary">
                    <th>Trayectos</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($trayectos as $trayecto)
                    <tr>
                        <td>{{ $trayecto->num_trayecto }}</td>
                        <td>
                            <div class="btn-group mx-1" role="group" aria-label="Acciones">
                                <a href="{{ route('trayectos.edit', $trayecto->id) }}" class="btn btn-primary"
                                    {{ Popper::arrow()->pop('Editar') }}>
                                    <i class="fas fa-edit"></i>
                                </a>

                                <button id="{{ $trayecto->id }}" class="btn btn-danger borrar"
                                    {{ Popper::arrow()->pop('Borrar') }} data-type="Trayecto"
                                    data-name="{{ $trayecto->num_trayecto }}">
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
        href="{{ request()->secure() ? secure_asset('vendor/DataTables/datatables.min.css') : asset('vendor/DataTables/datatables.min.css') }}">
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('vendor/sweetalert2/bootstrap-4.min.css') : asset('vendor/sweetalert2/bootstrap-4.min.css') }}">

    {{-- Personalizados --}}
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('css/estilosVarios/required.css') : asset('css/estilosVarios/required.css') }}">
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('css/anchoTabla.css') : asset('css/anchoTabla.css') }}">
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
        const trayecto = document.getElementById('trayecto')
        const boton = document.getElementById('formularioEnviar')

        let validacionTrayecto = trayecto.value > 0 && trayecto.value < 11

        const validarFormulario = () => {
            if (validacionTrayecto) {
                boton.removeAttribute('disabled')
            } else {
                boton.disabled = true
            }
        }

        validarFormulario()

        trayecto.addEventListener('input', (e) => {
            trayecto.value = trayecto.value.replace('e', '')

            if (trayecto.value < 1) {
                trayecto.value = 1
            }

            if (trayecto.value > 10) {
                trayecto.value = 10
            }

            if (trayecto.value > 0 && trayecto.value < 11) {
                trayecto.classList.remove('is-invalid')
                validacionTrayecto = true
            } else {
                trayecto.classList.add('is-invalid')
                validacionTrayecto = false
            }

            validarFormulario()
        })
    </script>

    {{-- Mensajes --}}
    <script>
        @if ($message = session('creado'))
            Swal.fire({
                icon: 'success',
                title: '¡Trayecto registrado!',
                html: 'Un nuevo trayecto ha sido añadido.',
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
        @elseif ($message = session('actualizado'))
            Swal.fire({
                icon: 'success',
                title: '¡Datos actualizados!',
                html: 'El trayecto ha sido actualizado.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('borrado'))
            Swal.fire({
                icon: 'success',
                title: '¡Trayecto borrado exitosamente!',
                html: 'El trayecto ha sido borrado.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('registrado'))
            Swal.fire({
                icon: 'info',
                title: '¡Ya registrado!',
                html: 'El trayecto ya se encuentra registrado.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info px-5'
                },
            })
            $('#registrar').modal('show')
        @elseif ($message = session('no encontrado'))
            Swal.fire({
                icon: 'error',
                title: '¡Trayecto no encontrado!',
                html: 'El trayecto que desea buscar o editar no se encuentra disponible.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info px-5'
                },
            })
        @elseif ($message = session('elementoBorrado'))
            Swal.fire({
                icon: 'error',
                title: '¡Trayecto ya creado!',
                html: "{{ session('elementoBorrado') }}",
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger px-5'
                },
            })
        @endif
    </script>
@stop
