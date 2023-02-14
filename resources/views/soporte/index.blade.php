@extends('adminlte::page')

@section('title', 'Acreditables | Recuperar')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item active"><a href="">Restaurar datos del usuario</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Soporte al usuario</x-tipografia.titulo>
@stop

@section('content')
    <section class="mx-auto col-md-6 col-sm-12">
        <article class="card">
            <x-formularios.recuperar-contrasena />
        </article>

        <article class="card">
            <x-formularios.cambiar-cedula />
        </article>
    </section>
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
                html: `La nueva contraseña del usuario <strong>{{ session('usuario') }}</strong> es: <strong>{{ session('contrasena') }}</strong>.`,
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('cedula'))
            Swal.fire({
                icon: 'success',
                title: '¡Cédula actualizada!',
                html: `La cédula de <strong>{{ session('usuario') }}</strong> ha sido actualizada exitosamente por: <p><strong>{{ session('cedula') }}</strong></p>`,
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
