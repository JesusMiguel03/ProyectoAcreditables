@extends('adminlte::page')

@section('title', 'Acreditables | Listado de usuarios')

@section('content_header')
    <div class="row">
        <div class="col-6">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
                <li class="breadcrumb-item active"><a href="">Usuarios</a></li>
            </ol>
        </div>
    </div>
@stop

@section('content')

    {{-- <div class="row">
        <div class="col-md-3 col-sm-12">
                <div class="card">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#usuario">
                        <i class="fas fa-plus mr-2"></i>
                        {{ __('Agregar usuario') }}
                    </button>
                </div>
            </div>
    </div> --}}


    {{-- <div class="modal fade" id="usuario" tabindex="-1" role="dialog" aria-labelledby="campousuario"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="campousuario">Agregar usuario</h5>
                    </div>
                    <div class="modal-body">
                        <div class="label-group mb-3">
                            <form action="{{ route('register') }}" method="post">
                                @csrf

                                <div class="form-group mb-3">

                                    <label for="nombre">Nombre</label>
                                    <div class="input-group">
                                        <input type="text" name="nombre"
                                            class="form-control @error('nombre') is-invalid @enderror"
                                            value="{{ old('nombre') }}" placeholder="{{ __('Nombre') }}" autofocus>

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

                                <div class="form-group mb-3">
                                    <label for="apellido">Apellido</label>
                                    <div class="input-group">
                                        <input type="text" name="apellido"
                                            class="form-control @error('apellido') is-invalid @enderror"
                                            value="{{ old('apellido') }}" placeholder="{{ __('Apellido') }}" autofocus>

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

                                <div class="form-group mb-3">
                                    <label for="cedula">Cedula</label>
                                    <div class="input-group">
                                        <input type="text" name="cedula"
                                            class="form-control @error('cedula') is-invalid @enderror"
                                            value="{{ old('cedula') }}" placeholder="{{ __('Cedula') }}" autofocus>

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

                                <div class="form-group mb-3">
                                    <label for="email">Correo electrónico</label>
                                    <div class="input-group">
                                        <input type="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email') }}" placeholder="{{ __('Correo Electrónico') }}">

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

                                <div class="form-group mb-3">
                                    <label for="password">Contraseña</label>
                                    <div class="input-group">
                                        <input type="password" name="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="{{ __('Contraseña') }}">

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

                                <div class="form-group mb-3">
                                    <label for="password_confirmation">Confirmar contraseña</label>
                                    <div class="input-group">
                                        <input type="password" name="password_confirmation"
                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                            placeholder="{{ __('Confirmar contraseña') }}">

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

                                <div class="row">
                                    <div class="col-6 mx-auto">
                                        <button type="submit" class="btn btn-block btn-primary">
                                            {{ __('Registrar') }}
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

    <div class="col-12 card table-responsive-sm p-3 my-3">
        <table id='tabla' class="table table-striped">
            <thead>
                <tr class="bg-secondary">
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>PNF</th>
                    <th>Rol</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->nombre }}</td>
                        <td>{{ $usuario->apellido }}</td>
                        <td>{{ $usuario->email }}</td>
                        <td>{{ $usuario->getRoleNames()->first() }}</td>
                        <td>
                            <a href="{{ route('coordinador.usuarios.edit', $usuario) }}" class="btn btn-primary"
                                style="width: 7rem">
                                <i class="fas fa-edit mr-2"></i>
                                Editar
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
                title: '¡Cambio exitoso!',
                html: 'El rol ha sido actualizado correctamente.',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('actualizado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Datos actualizados!',
                html: 'El rol ha sido actualizado correctamente.',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('incorrecto'))
            let timerInterval
            Swal.fire({
                icon: 'warning',
                title: '¡Debes crear un perfil de profesor primero!',
                html: 'Antes de asignar las especialidades del educador primero debes registrar su perfil educativo.',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('error'))
            let timerInterval
            Swal.fire({
                icon: 'error',
                title: '¡Hubo un problema!',
                html: 'Parece que uno de los campos no cumple los requisitos.',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @endif
    </script>
@stop
