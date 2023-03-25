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
                @if (!empty(auth()->user()->estudiante))
                    <x-perfil.usuario.perfil-academico />

                    <x-perfil.usuario.informacion-academica />

                    <x-perfil.usuario.comprobante />
                @endif
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
    {{-- Información --}}
    <script>
        const nombre = document.getElementById('nombre')
        const apellido = document.getElementById('apellido')
        const nacionalidad = document.getElementById('nacionalidad')
        const cedula = document.getElementById('cedula')
        const correo = document.getElementById('correo')
        const boton = document.getElementById('actualizarInformacion')

        const validarCorreo =
            /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/

        // Validaciones de cada campo
        let [
            validacionNombre, validacionApellido, validacionNacionalidad, validacionCedula, validacionCorreo
        ] = [
            nombre.value.length > 3 && nombre.value.length < 21,
            apellido.value.length > 3 && apellido.value.length < 21,
            nacionalidad.options[nacionalidad.selectedIndex].value > 0,
            cedula.value.toString().length > 6 && cedula.value.toString().length < 9,
            validarCorreo.test(correo.value)
        ]

        if (!(validacionNombre && validacionApellido && validacionNacionalidad && validacionCedula && validacionCorreo)) {
            boton.disabled = true
        } else {
            boton.removeAttribute('disabled')
        }

        // Validacion de todo el formulario
        const formularioValidado = () => {
            if (validacionNombre && validacionApellido && validacionNacionalidad && validacionCedula &&
                validacionCorreo) {
                boton.removeAttribute('disabled')
            } else {
                boton.disabled = true
            }
        }

        nombre.addEventListener('input', (e) => {
            nombre.value = nombre.value.replace(/[^A-zÀ-ÿ\s]+/g, '')
            nombre.value = nombre.value.replace(/ {2,}/g, '')

            if (nombre.value.length > 20) {
                nombre.value = nombre.value.slice(0, 20)
            }

            if (/^\p{L}+(?:\s+\p{L}+)*$/u.test(nombre.value)) {
                if (nombre.value.length > 3 && nombre.value.length < 21) {
                    nombre.classList.remove('is-invalid')
                    validacionNombre = true
                } else {
                    nombre.classList.add('is-invalid')
                    validacionNombre = false
                }
            } else {
                nombre.classList.add('is-invalid')
                validacionNombre = false
            }

            formularioValidado()
        })

        apellido.addEventListener('input', (e) => {
            apellido.value = apellido.value.replace(/[^A-zÀ-ÿ\s]+/g, '')
            apellido.value = apellido.value.replace(/ {2,}/g, '')

            if (apellido.value.length > 20) {
                apellido.value = apellido.value.slice(0, 20)
            }

            if (/^\p{L}+(?:\s+\p{L}+)*$/u.test(apellido.value)) {
                if (apellido.value.length > 3 && apellido.value.length < 21) {
                    apellido.classList.remove('is-invalid')
                    validacionApellido = true
                } else {
                    apellido.classList.add('is-invalid')
                    validacionApellido = false
                }
            } else {
                apellido.classList.add('is-invalid')
                validacionApellido = false
            }

            formularioValidado()
        })

        nacionalidad.addEventListener('change', (e) => {
            if (nacionalidad.options[nacionalidad.selectedIndex].value > 0) {
                validacionNacionalidad = true
                nacionalidad.classList.remove('is-invalid')
            } else {
                validacionNacionalidad = false
                nacionalidad.classList.add('is-invalid')
            }

            formularioValidado()
        })

        // Si la cédula es mayor a 8 dígitos elimina a apartir del 9
        cedula.addEventListener('input', (e) => {
            if (cedula.value.toString().length > 8) {
                cedula.value = cedula.value.toString().slice(0, 8)
            }

            cedula.value = cedula.value.toString().replace('e', '')

            // Si la cédula tiene entre 7 y 8 digitos
            if (cedula.value.toString().length > 6 && cedula.value.toString().length < 9) {
                cedula.classList.remove('is-invalid')
                validacionCedula = true
            } else {
                cedula.classList.add('is-invalid')
                validacionCedula = false
            }

            formularioValidado()
        })

        correo.addEventListener('input', (e) => {
            // Si el correo es mayor a 40 caracteres elimina a partir del 9
            if (correo.value.length > 40) {
                correo.value = correo.value.slice(0, 40)
            }

            correo.value = correo.value.replace(/[^@A-Za-z0-9._-]+/g, '')

            // Si el correo es válido
            if (validarCorreo.test(correo.value)) {
                correo.classList.remove('is-invalid')
                validacionCorreo = true
            } else {
                correo.classList.add('is-invalid')
                validacionCorreo = false
            }

            formularioValidado()
        })
    </script>

    {{-- Seguridad --}}
    <script>
        const contrasena = document.getElementById('contrasena')
        const nuevaContrasena = document.getElementById('nuevaContrasena')
        const validarContrasena = document.getElementById('validarContrasena')
        const botonSeguridad = document.getElementById('actualizarSeguridad')

        let [validacionContrasena, validacionNuevaContrasena, validacionContrasenaValidada] = [
            contrasena.value.length > 3 && contrasena.value.length < 9,
            nuevaContrasena.value.length > 3 && nuevaContrasena.value.length < 9,
            validarContrasena.value.length > 3 && validarContrasena.value.length < 9,
        ]

        const validarFormularioSeguridad = () => {
            if (validacionContrasena && validacionNuevaContrasena && validacionContrasenaValidada) {
                botonSeguridad.removeAttribute('disabled')
            } else {
                botonSeguridad.disabled = true
            }
        }

        // Si la contraseña actual es mayor a 8 caracteres elimina a apartir del 9
        contrasena.addEventListener('input', (e) => {
            if (e.currentTarget.value.length > 8) {
                e.currentTarget.value = e.currentTarget.value.slice(0, 8)
            }

            // Si es menor a 4 y mayor a 8 invalida
            if (contrasena.value.length > 3 && contrasena.value.length < 9) {
                validacionContrasena = true
                contrasena.classList.remove('is-invalid')
            } else {
                validacionContrasena = false
                contrasena.classList.add('is-invalid')
            }

            validarFormularioSeguridad()
        })

        nuevaContrasena.addEventListener('input', (e) => {
            // Si la nueva contraseña es mayor a 8 caracteres elimina a apartir del 9
            if (nuevaContrasena.value.length > 8) {
                nuevaContrasena.value = nuevaContrasena.value.slice(0, 8)
            }

            // Si es menor a 4 y mayor a 8 invalida
            if (nuevaContrasena.value.length > 3 && nuevaContrasena.value.length < 9) {
                validacionNuevaContrasena = true
                nuevaContrasena.classList.remove('is-invalid')
            } else {
                validacionNuevaContrasena = false
                nuevaContrasena.classList.add('is-invalid')
            }

            /**
             * Si el valor del campo nueva contraseña y la confirmacion son diferentes
             * añade una clase al campo confirmacion como advertencia
             */
            nuevaContrasena.value !== validarContrasena.value ?
                validarContrasena.classList.add('is-invalid') :
                validarContrasena.classList.remove('is-invalid')

            validarFormularioSeguridad()
        })

        validarContrasena.addEventListener('input', (e) => {
            // Si la confirmación de la nueva contraseña es mayor a 8 caracteres elimina a apartir del 9
            if (validarContrasena.value.length > 8) {
                validarContrasena.value = validarContrasena.value.slice(0, 8)
            }

            /**
             * Si no se coloca una nueva contraseña pero si la confirmacion
             * añade una clase al campo confirmacion como advertencia
             */
            if (nuevaContrasena.value.length === 0) {
                nuevaContrasena.classList.add('is-invalid')
            }

            // Si es menor a 4 y mayor a 8 invalida
            if (validarContrasena.value.length > 3 && validarContrasena.value.length < 9) {
                validacionContrasenaValidada = true
                validarContrasena.classList.remove('is-invalid')
            } else {
                validacionContrasenaValidada = false
                validarContrasena.classList.add('is-invalid')
            }

            /**
             * Si:
             * 1. Campo confirmar nueva contraseña y nueva contraseña son diferentes
             * añade una clase de advertencia al campo nueva contraseña.
             * 2. Además de, el campo nueva contraseña tener más de 4 caracteres
             */
            validarContrasena.value !== nuevaContrasena.value ?
                validarContrasena.classList.add('is-invalid') :
                validarContrasena.classList.remove('is-invalid')

            validarFormularioSeguridad()
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
