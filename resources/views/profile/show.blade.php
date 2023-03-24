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

    {{-- Validaciones --}}
    <script>
        const cedula = document.getElementById('cedula');
        const contrasena = document.getElementById('contrasena')
        const nuevaContrasena = document.getElementById('nuevaContrasena')
        const validarContrasena = document.getElementById('validarContrasena')

        // Si la cédula es mayor a 8 dígitos elimina a apartir del 9
        cedula.addEventListener('input', (e) => {
            if (e.currentTarget.value.toString().length > 8) {
                e.currentTarget.value = e.currentTarget.value.toString().slice(0, 8)
            }
        });

        // Si la contraseña actual es mayor a 8 caracteres elimina a apartir del 9
        contrasena.addEventListener('input', (e) => {
            if (e.currentTarget.value.length > 8) {
                e.currentTarget.value = e.currentTarget.value.slice(0, 8)
            }
        })

        nuevaContrasena.addEventListener('input', (e) => {
            // Si la nueva contraseña es mayor a 8 caracteres elimina a apartir del 9
            if (e.currentTarget.value.length > 8) {
                e.currentTarget.value = e.currentTarget.value.slice(0, 8)
            }

            // Si es menor a 4 caracteres añade una clase como advertencia
            e.currentTarget.value.length < 4 ?
                e.currentTarget.classList.add('is-invalid') :
                e.currentTarget.classList.remove('is-invalid')

            /**
             * Si el valor del campo nueva contraseña y la confirmacion son diferentes
             * añade una clase al campo confirmacion como advertencia
             */
            e.currentTarget.value !== validarContrasena.value ?
                validarContrasena.classList.add('is-invalid') :
                validarContrasena.classList.remove('is-invalid')
        })

        validarContrasena.addEventListener('input', (e) => {
            // Si la confirmación de la nueva contraseña es mayor a 8 caracteres elimina a apartir del 9
            if (e.currentTarget.value.length > 8) {
                e.currentTarget.value = e.currentTarget.value.slice(0, 8)
            }

            /**
             * Si no se coloca una nueva contraseña pero si la confirmacion
             * añade una clase al campo confirmacion como advertencia
             */
            if (nuevaContrasena.value.length === 0) {
                nuevaContrasena.classList.add('is-invalid')
            }

            /**
             * Si:
             * 1. Campo confirmar nueva contraseña y nueva contraseña son diferentes
             * añade una clase de advertencia al campo nueva contraseña.
             * 2. Además de, el campo nueva contraseña tener más de 4 caracteres
             */
            e.currentTarget.value !== nuevaContrasena.value && nuevaContrasena.value.length > 4 ?
                e.currentTarget.classList.add('is-invalid') :
                e.currentTarget.classList.remove('is-invalid')
        })
    </script>

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
        @elseif ($message = session('perfilNoActualizado'))
            Swal.fire({
                icon: 'info',
                title: '¡Perfil no actualizado!',
                html: 'No se suministró nuevos datos para actualizar su perfil.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info px-5'
                },
            })
        @elseif ($message = session('perfilActualizado'))
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
        @elseif ($message = session('errorActualizarPerfil'))
            Swal.fire({
                icon: 'error',
                title: '¡Hubo un problema!',
                html: 'Parece que uno de los campos no cumple los requisitos.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger px-5'
                },
            })
        @endif
    </script>
@stop
