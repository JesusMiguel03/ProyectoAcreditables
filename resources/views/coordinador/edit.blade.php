@extends('adminlte::page')

@section('title', 'Acreditables | Editar usuario')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Coordinación de Acreditables</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}">Inicio</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('coordinador.usuarios.index') }}">Listado de Usuarios</a>
                </li>
                <li class="breadcrumb-item active"><a href="">Editar usuario</a></li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6 mx-auto">
                    <div class="card p-4">
                        <h5>Nombre:</h5>
                        <p class="form-control">{{ $usuario->nombre }} {{ $usuario->apellido }}</p>

                        <h5>Listado de roles:</h5>
                        <form action="{{ route('coordinador.usuarios.update', $usuario) }}" method="post">
                            @csrf
                            {{ method_field('PUT') }}

                            <select class="form-control mb-3" name="roles[]">
                                <option>Seleccione un rol</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}"
                                        {{ $usuario->roles->contains($role->id) ? 'selected' : '' }}>
                                        {{ $role->name }}</option>
                                @endforeach
                            </select>

                            @if ($usuario->roles[0]->name === 'Profesor')
                                @foreach ($especialidades as $especialidad)
                                    <div class="icheck-primary">
                                        <input type="checkbox" name="especialidades[]" id="{{ $especialidad->id }}"
                                            value="{{ $especialidad->id }}" {{ in_array($especialidad->id, $relacion) ? 'checked' : '' }}>

                                        <label for="{{ $especialidad->id }}">
                                            {{ __($especialidad->nombre) }}
                                        </label>
                                    </div>
                                @endforeach
                            @endif


                            <button type="submit" class="btn btn-primary mt-2">Asignar rol</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
@stop

@section('js')
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        @if ($message = session('success'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Cambio exitoso!',
                html: 'Los roles han sido actualizados.',
                timer: 3000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                    timerInterval = setInterval(() => {}, 100)
                },
                willClose: () => {
                    clearInterval(timerInterval)
                }
            })
        @endif
    </script>
@stop
