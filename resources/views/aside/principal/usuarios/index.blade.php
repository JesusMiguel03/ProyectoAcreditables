@extends('adminlte::page')

@section('title', 'Acreditables | Estudiantes')

@section('content_header')
    <div class="row">
        <div class="col-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
                <li class="breadcrumb-item active"><a href="">Estudiantes</a></li>
            </ol>
        </div>

        <x-tipografia.periodo fase="{{ !empty($periodo->fase) ? $periodo->fase : '' }}"
            fecha="{{ !empty($periodo->inicio) ? explode('-', explode(' ', $periodo->inicio)[0])[0] : 'Sin asignar' }}" />

        <div class="col-4">
            <div class="card float-right mr-2">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#registrar">
                    <i class="fas fa-plus mr-2"></i>
                    {{ __('Registrar usuario') }}
                </button>
            </div>
        </div>
        {{-- Registrar usuario --}}
        <div class="modal fade" id="registrar" tabindex="-1" role="dialog" aria-labelledby="camporegistrar"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <header class="modal-header bg-primary">
                        <h5 class="modal-title" id="camporegistrar">Registrar usuario como estudiante</h5>
                    </header>

                    <main class="modal-body">
                        <form action="{{ route('registrar-estudiante') }}" method="post">
                            @csrf

                            {{-- Nombre --}}
                            <div class="form-row" style="margin-bottom: -0.75rem">
                                <div class="form-group required col-6">
                                    <label for="nombre" class="control-label">Nombre</label>
                                    <div class="input-group">
                                        <input type="text" name="nombre"
                                            class="form-control @error('nombre') is-invalid @enderror"
                                            value="{{ old('nombre') }}" placeholder="{{ __('Nombre') }}" autofocus
                                            required>

                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span
                                                    class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                            </div>
                                        </div>

                                        @error('nombre')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Apellido --}}
                                <div class="form-group col-6 required">
                                    <label for="apellido" class="control-label">Apellido</label>
                                    <div class="input-group mb-3">
                                        <input type="text" name="apellido"
                                            class="form-control @error('apellido') is-invalid @enderror"
                                            value="{{ old('apellido') }}" placeholder="{{ __('Apellido') }}" autofocus
                                            required>

                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span
                                                    class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                            </div>
                                        </div>

                                        @error('apellido')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Cedula --}}
                            <div class="form-group required mb-3">
                                <label for="cedula" class="control-label">Cédula</label>
                                <div class="input-group">
                                    <input type="text" name="cedula"
                                        class="form-control @error('cedula') is-invalid @enderror"
                                        value="{{ old('cedula') }}" placeholder="{{ __('Cedula') }}" autofocus required>

                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span
                                                class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                        </div>
                                    </div>

                                    @error('cedula')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Correo --}}
                            <div class="form-group required mb-3">
                                <label for="email" class="control-label">Correo electrónico</label>
                                <div class="input-group">
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}" placeholder="{{ __('Correo Electrónico') }}" autofocus
                                        required>

                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span
                                                class="fas fa-envelope {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                        </div>
                                    </div>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Contraseña --}}
                            <div class="form-row">
                                <div class="form-group col-6 required">
                                    <label for="password" class="control-label">Contraseña</label>
                                    <div class="input-group">
                                        <input type="password" name="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="{{ __('Contraseña') }}" autofocus required>

                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span
                                                    class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                            </div>
                                        </div>

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Confirmar contraseña --}}
                                <div class="form-group col-6 required">
                                    <label for="password_confirmation" class="control-label">Confirmar contraseña</label>
                                    <div class="input-group">
                                        <input type="password" name="password_confirmation"
                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                            placeholder="{{ __('Confirmar contraseña') }}" autofocus required>

                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span
                                                    class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                            </div>
                                        </div>

                                        @error('password_confirmation')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group" style="margin-bottom: -10px">
                                <p class="pl-2 text-danger"><strong>Nota:</strong> (*) Indica los campos que
                                    son obligatorios.
                                </p>
                            </div>

                            {{-- Botón de registrar --}}
                            <div class="row">
                                <x-botones.cancelar />

                                <x-botones.guardar />
                            </div>
                        </form>
                    </main>
                </div>
            </div>
        </div>
    </div>

    <x-tipografia.titulo>Listado de estudiantes</x-tipografia.titulo>
@stop

@section('content')
    <div class="col-12 card table-responsive-sm p-3 my-3">
        <table id='tabla' class="table table-striped">
            <thead>
                <tr class="bg-secondary">
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>PNF</th>
                    <th>Trayecto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($estudiantes as $estudiante)
                    <tr>
                        <td>{{ 'V-' . number_format($estudiante->cedula, 0, ',', '.') }}</td>
                        <td>{{ $estudiante->nombre }}</td>
                        <td>{{ $estudiante->apellido }}</td>
                        <td>
                            @if (empty($estudiante->estudiante))
                                <b>Sin asignar</b>
                            @else
                                {{ $estudiante->estudiante->pnf->nom_pnf }}
                            @endif
                        </td>
                        <td>
                            @if (empty($estudiante->estudiante))
                                <b>Sin asignar</b>
                            @else
                                {{ $estudiante->estudiante->trayecto->num_trayecto }}
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('coordinador.usuarios.edit', $estudiante) }}" class="btn btn-primary"
                                {{ Popper::arrow()->pop('Editar perfil') }}>
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('/vendor/DataTables/datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/required.css') }}">
@stop

@section('js')
    <script src="{{ asset('/vendor/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('js/tablas.js') }}"></script>
    <script>
        @if ($message = session('creado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Estudiante registrado!',
                html: 'Un nuevo estudiante ha sido añadido.',
                confirmButtonColor: '#28a745',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('error'))
            let timerInterval
            Swal.fire({
                icon: 'error',
                title: 'Error al registrar',
                html: 'Uno de los parámetros parece estar mal.',
                confirmButtonColor: '#dc3545',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
            $('#registrar').modal('show')
        @elseif ($message = session('registrado'))
            let timerInterval
            Swal.fire({
                icon: 'info',
                title: 'Ya fue registrado',
                html: 'El estudiante ya se encuentra registrado.',
                confirmButtonColor: '#17a2b8',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('actualizado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Datos actualizados!',
                html: 'Los datos del estudiante han sido actualizados.',
                confirmButtonColor: '#28a745',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @endif
    </script>
@stop
