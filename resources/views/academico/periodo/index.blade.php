@extends('adminlte::page')

@section('title', 'Acreditables | Periodo')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item active"><a href="">Periodo</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Periodo</x-tipografia.titulo>

    {{-- Registrar --}}
    <div class="modal fade" id="registrar" tabindex="-1" role="dialog" aria-labelledby="camporegistrar" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <header class="modal-header bg-primary">
                    <h5 class="modal-title" id="camporegistrar">Registrar periodo</h5>
                </header>

                <main class="modal-body">
                    <form action="{{ route('periodos.store') }}" method="post">
                        @csrf

                        <x-formularios.periodo />
                    </form>
                </main>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="col-12 card table-responsive-sm p-3 my-3">

        <div class="w-100 row mx-auto">
            <div class="col-md-2 col">
                <button class="btn btn-block btn-primary my-2" data-toggle="modal" data-target="#registrar"
                    {{ Popper::arrow()->pop('Nuevo periodo') }}>
                    <i class="fas fa-plus mr-2"></i>
                    {{ 'Añadir' }}
                </button>
            </div>
        </div>

        <table id='tabla' class="table table-striped">
            <thead>
                <tr class="bg-secondary">
                    <th>Fase</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($periodos as $periodo)
                    <tr>
                        <td>{{ $periodo->fase }}</td>
                        <td>{{ $periodo->inicio }}</td>
                        <td>{{ $periodo->fin }}</td>
                        <td>
                            <div class="btn-group mx-1" role="group" aria-label="Acciones">
                                <a href="{{ route('periodos.edit', $periodo->id) }}" class="btn btn-primary"
                                    {{ Popper::arrow()->pop('Editar') }}>
                                    <i class="fas fa-edit"></i>
                                </a>
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
        href="{{ request()->secure() ? secure_asset('vendor/DataTables/datatables.min.css') : asset('/vendor/DataTables/datatables.min.css') }}">
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('vendor/sweetalert2/bootstrap-4.min.css') : asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') : asset('vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">

    {{-- Personalizados --}}
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('css/estilosVarios/required.css') : asset('css/estilosVarios/required.css') }}">
@stop

@section('js')
    @include('popper::assets')
    <script
        src="{{ request()->secure() ? secure_asset('vendor/DataTables/datatables.min.js') : asset('vendor/DataTables/datatables.min.js') }}">
    </script>
    <script
        src="{{ request()->secure() ? secure_asset('vendor/sweetalert2/sweetalert2.min.js') : asset('vendor/sweetalert2/sweetalert2.min.js') }}">
    </script>
    <script src="{{ request()->secure() ? secure_asset('vendor/moment/moment.js') : asset('vendor/moment/moment.js') }}">
    </script>
    <script
        src="{{ request()->secure() ? secure_asset('vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') : asset('vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}">
    </script>

    {{-- Tiempo --}}
    <script>
        $(function() {
            $('#inicio').datetimepicker({
                locale: 'es',
                format: 'YYYY-MM-DD'
            });
        });
        $(function() {
            $('#fin').datetimepicker({
                locale: 'es',
                format: 'YYYY-MM-DD',
            });
        });
    </script>

    {{-- Personalizados --}}
    <script src="{{ request()->secure() ? secure_asset('js/tablas.js') : asset('js/tablas.js') }}"></script>

    {{-- Validaciones --}}
    <script>
        const fase = document.getElementById('fase')
        const inicio = document.getElementById('inputInicio')
        const fin = document.getElementById('inputFin')
        const boton = document.getElementById('formularioEnviar')

        let [validacionFase, validacionInicio, validacionFin] = [
            fase.value > 0 && fase.value < 4,
            inicio.value.length !== 0,
            fin.value.length !== 0
        ]

        const validarFormulario = () => {
            if (validacionFase && validacionInicio && validacionFin) {
                boton.removeAttribute('disabled')
            } else {
                boton.disabled = true
            }
        }

        validarFormulario()

        fase.addEventListener('input', (e) => {
            fase.value = fase.value.replace('e', '')

            if (fase.value > 3) {
                fase.value = 3
            }

            if (fase.value < 1) {
                fase.value = 1
            }

            if (fase.value > 0 && fase.value < 4) {
                validacionFase = true
                fase.classList.remove('is-invalid')
            } else {
                validacionFase = false
                fase.classList.add('is-invalid')
            }

            validarFormulario()
        })

        inicio.addEventListener('blur', (e) => {
            if (inicio.value.length !== 0) {
                validacionInicio = true
                inicio.classList.remove('is-invalid')
            } else {
                validacionInicio = false
                inicio.classList.add('is-invalid')
            }

            validarFormulario()
        })

        fin.addEventListener('blur', (e) => {
            if (fin.value.length !== 0) {
                validacionFin = true
                fin.classList.remove('is-invalid')
            } else {
                validacionFin = false
                fin.classList.add('is-invalid')
            }

            validarFormulario()
        })
    </script>

    {{-- Mensajes --}}
    <script>
        @if ($message = session('creado'))
            Swal.fire({
                icon: 'success',
                title: '¡Periodo registrado!',
                html: 'Un nuevo periodo ha sido añadido.',
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
        @elseif ($message = session('repetido'))
            Swal.fire({
                icon: 'info',
                title: '¡Ya registrado!',
                html: 'El periodo se encuentra registrado.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info px-5'
                },
            })
        @elseif ($message = session('actualizado'))
            Swal.fire({
                icon: 'success',
                title: '¡Datos actualizados!',
                html: 'Los datos del periodo han sido actualizados.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('no encontrado'))
            Swal.fire({
                icon: 'error',
                title: '¡Periodo no encontrado!',
                html: 'El periodo que desea buscar o editar no se encuentra disponible.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info px-5'
                },
            })
        @endif
    </script>
@stop
