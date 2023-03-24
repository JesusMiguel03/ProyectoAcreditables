@extends('adminlte::page')

@section('title', 'Acreditables | PNF')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item active"><a href="">PNF</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>PNF</x-tipografia.titulo>

    @can('academico')
        {{-- Modal para crear --}}
        <div class="modal fade" id="registrar" tabindex="-1" role="dialog" aria-labelledby="campopnf" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <header class="modal-header bg-primary">
                        <h5 class="modal-title" id="campopnf">Agregar PNF</h5>
                    </header>

                    <main class="modal-body">
                        <form action="{{ route('pnfs.store') }}" method="post">
                            @csrf

                            <x-formularios.pnfs />
                        </form>
                    </main>
                </div>
            </div>
        </div>

        <x-formularios.borrar />
    @endcan
@stop

@section('content')
    <div class="col-12 mb-3">
        <div class="card table-responsive-sm p-3 mb-4">
            <p>
                <strong>Nota: </strong>
                <span class="text-muted">Los PNF que no tengan código no serán mostrados en las estadísticas.</span>
            </p>

            <div class="w-100 row mx-auto">
                <div class="col-md-2 col">
                    <button class="btn btn-block btn-primary my-2" data-toggle="modal" data-target="#registrar"
                        {{ Popper::arrow()->pop('Nuevo PNF') }}>
                        <i class="fas fa-plus mr-2"></i>
                        {{ 'Añadir' }}
                    </button>
                </div>
            </div>

            <table id='tabla' class="table table-striped">
                <thead>
                    <tr class="bg-secondary">
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Trayectos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($pnfs as $pnf)
                        @php
                            $codigo = $pnf->cod_pnf ?? 'No cursa acreditable';
                            $nombre = $pnf->nom_pnf;
                            $trayectos = $pnf->trayectos === 0 ? '' : $pnf->trayectos;
                        @endphp
                        <tr>
                            <td>{{ $codigo }}</td>
                            <td>{{ $nombre }}</td>
                            <td>{{ $trayectos }}</td>
                            <td>
                                <div class="btn-group mx-1" role="group" aria-label="Acciones">
                                    <a href="{{ route('pnfs.edit', $pnf->id) }}" class="btn btn-primary"
                                        {{ Popper::arrow()->pop('Editar') }}>
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <button id="{{ $pnf->id }}" class="btn btn-danger borrar"
                                        {{ Popper::arrow()->pop('Borrar') }} data-type="PNF"
                                        data-name="{{ $nombre }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">

    {{-- Personalizados --}}
    <link rel="stylesheet" href="{{ asset('css/estilosVarios/required.css') }}">
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
        const codigo = document.getElementById('codigo')
        const trayectos = document.getElementById('trayectos')
        const boton = document.getElementById('formularioEnviar')

        boton.disabled = true

        let [validacionNombre, validacionCodigo, validacionTrayectos] = [false, true, false]

        const validarFormulario = () => {
            if (validacionNombre && validacionCodigo && validacionTrayectos) {
                boton.removeAttribute('disabled')
            } else {
                boton.disabled = true
            }
        }

        nombre.addEventListener('input', (e) => {
            e.currentTarget.value = e.currentTarget.value.replace(/[^a-zA-ZÀ-ÿ\s]+$/, '')

            if (e.currentTarget.value.length > 30) {
                e.currentTarget.value = e.currentTarget.value.length.slice(0, 30)
            }

            if (e.currentTarget.value.length > 5 && e.currentTarget.value.length < 31) {
                e.currentTarget.classList.remove('is-invalid')
                validacionNombre = true
            } else {
                e.currentTarget.classList.add('is-invalid')
                validacionNombre = false
            }

            validarFormulario()
        })

        codigo.addEventListener('input', (e) => {
            e.currentTarget.value = e.currentTarget.value.replace(/[^a-zA-Z0-9]+/, '')

            if (e.currentTarget.value.length > 6) {
                e.currentTarget.value = e.currentTarget.value.length.slice(0, 30)
            }

            if (e.currentTarget.value.length === 0 || e.currentTarget.value.length > 3) {
                e.currentTarget.classList.remove('is-invalid')
                validacionCodigo = true
            } else {
                e.currentTarget.classList.add('is-invalid')
                validacionCodigo = false
            }

            validarFormulario()
        })

        trayectos.addEventListener('input', (e) => {
            if (e.currentTarget.value > 10) {
                e.currentTarget.value = 10
            }

            if (e.currentTarget.value < 1) {
                e.currentTarget.value = 1
            }

            if (e.currentTarget.value > 0 && e.currentTarget.value < 11) {
                e.currentTarget.classList.remove('is-invalid')
                validacionTrayectos = true
            } else {
                e.currentTarget.classList.add('is-invalid')
                validacionTrayectos = false
            }

            validarFormulario()
        })
    </script>

    {{-- Mensajes --}}
    <script>
        @if ($message = session('creado'))
            Swal.fire({
                icon: 'success',
                title: '¡PNF registrado!',
                html: 'Un nuevo PNF ha sido añadido.',
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
                title: '¡Ya registrado!',
                html: 'El PNF se encuentra registrado.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info px-5'
                },
            })
        @elseif ($message = session('actualizado'))
            Swal.fire({
                icon: 'success',
                title: '¡Datos actualizados!',
                html: 'El PNF ha sido actualizado.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('borrado'))
            Swal.fire({
                icon: 'success',
                title: '¡PNF borrado!',
                html: 'El PNF ha sido borrado exitosamente.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('no encontrado'))
            Swal.fire({
                icon: 'error',
                title: '¡PNF no encontrado!',
                html: 'El PNF que desea buscar o editar no se encuentra disponible.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info px-5'
                },
            })
        @elseif ($message = session('elementoBorrado'))
            Swal.fire({
                icon: 'error',
                title: '¡PNF ya creado!',
                html: "{{ session('elementoBorrado') }}",
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger px-5'
                },
            })
        @endif
    </script>
@stop
