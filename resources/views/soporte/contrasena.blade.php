@extends('adminlte::page')

@section('title', 'Acreditables | Recuperar')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item active"><a href="">Restaurar contraseña</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Soporte al usuario</x-tipografia.titulo>
@stop

@section('content')
    <div class="card mx-auto col-md-6 col-sm-12">
        <form id="recuperar" action="{{ route('soporte.recuperarContrasena') }}" method="post">
            @csrf
            {{ method_field('PUT') }}

            <section class="card-body">
                <x-perfil.card-titulo>
                    Correo de recuperación
                </x-perfil.card-titulo>

                <main class="row">
                    <x-perfil.card-mensaje>
                        Para restaurar la contraseña escriba el correo del usuario en cuestión.
                    </x-perfil.card-mensaje>

                    <div class="col-md-7 col-sm-12">
                        <div class="form-group mb-3">
                            <label for="usuario">Correo del usuario a restaurar</label>
                            <div class="input-group">
                                <input type="text" id="correo" name="usuario" class="form-control"
                                    placeholder="correo@gmail.com" required>

                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-primary btn-block">
                        Recuperar
                    </button>
                </main>
            </section>
        </form>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
@stop

@section('js')
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>

    {{-- Personalizados --}}
    <script src="{{ asset('js/validarCorreo.js') }}"></script>

    {{-- Mensajes --}}
    <script>
        @if ($message = session('contrasena'))
            Swal.fire({
                icon: 'success',
                title: '¡Contraseña restablecida!',
                html: `Su nueva contrasena es: <strong>{{ session('contrasena') }}</strong>.`,
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('error'))
            Swal.fire({
                icon: 'error',
                title: '¡Correo inválido!',
                html: `El correo suministrado es inválido o no se encuentra registrado.`,
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger px-5'
                },
            })
        @endif
    </script>
@stop
