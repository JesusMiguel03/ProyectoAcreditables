@extends('adminlte::page')

@section('title', 'Acreditables | Mi cuenta')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item active"><a href="" class="text-primary">Perfil</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Mi cuenta</x-tipografia.titulo>
@stop

@section('content')
    <x-perfil.usuario.cambiar-avatar />

    <div class="col-md-8 col-sm-12 mx-auto">
        <div class="card">

            <x-perfil.usuario.avatar />

            <x-perfil.usuario.informacion />

            <x-perfil.usuario.seguridad />

            @can('inscribir')
                <x-perfil.usuario.perfil-academico />

                <x-perfil.usuario.informacion-academica />

                <x-perfil.usuario.comprobante />
            @endcan
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilosVarios/avatar.css') }}">
@stop

@section('js')
    @include('popper::assets')
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>

    {{-- Personalizados --}}
    <script src="{{ asset('js/seleccionarAvatar.js') }}"></script>
    <script src="{{ asset('js/descargarComprobante.js') }}"></script>

    {{-- Mensajes --}}
    <script>
        @if ($message = session('actualizado'))
            Swal.fire({
                icon: 'success',
                title: '¡Contraseña actualizada!',
                html: 'Ahora podrá ingresar con su nueva contraseña.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('avatar'))
            Swal.fire({
                icon: 'success',
                title: '¡Avatar actualizado!',
                html: 'Felicidades por personalizar su perfil con ese increíble avatar.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('perfil-actualizado'))
            Swal.fire({
                icon: 'success',
                title: '¡Perfil actualizado!',
                html: 'Sus credenciales han sido actualizadas correctamente.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('errorHash'))
            Swal.fire({
                icon: 'error',
                title: '¡Error al actualizar!',
                html: 'El campo de <b>Contraseña actual</b> no coincide con la registrada.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger px-5'
                },
            })
        @elseif ($message = session('errorConfirmacion'))
            Swal.fire({
                icon: 'error',
                title: '¡Error al actualizar!',
                html: 'El campo de <b>Nueva contraseña</b> y <b>Confirmar contraseña</b> no coinciden.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger px-5'
                },
            })
        @elseif ($message = session('comprobanteError'))
            Swal.fire({
                icon: 'error',
                title: '¡Comprobante no encontrado!',
                html: "{{ session('comprobanteError') }}",
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger px-5'
                },
            })
        @endif
    </script>
@stop
