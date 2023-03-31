@extends('adminlte::auth.auth-page', ['auth_type' => 'register'])

@php($login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login'))
@php($register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register'))

@if (config('adminlte.use_route_url', false))
    @php($login_url = $login_url ? route($login_url) : '')
    @php($register_url = $register_url ? route($register_url) : '')
@else
    @php($login_url = $login_url ? url($login_url) : '')
    @php($register_url = $register_url ? url($register_url) : '')
@endif

@section('title', 'Acreditables | Registrarme')

@section('auth_header', __('Registrarse como nuevo usuario'))

@section('auth_body')
    <form action="{{ $register_url }}" method="post">
        @csrf

        <x-formularios.usuario />

    </form>
@stop

@section('css')
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('vendor/sweetalert2/bootstrap-4.min.css') : asset('vendor/sweetalert2/bootstrap-4.min.css') }}">

    {{-- Personalizados --}}
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('css/estilosVarios/required.css') : asset('css/estilosVarios/required.css') }}">
@stop

@section('js')
    <script
        src="{{ request()->secure() ? secure_asset('vendor/sweetalert2/sweetalert2.min.js') : asset('vendor/sweetalert2/sweetalert2.min.js') }}">
    </script>

    {{-- Validaciones --}}
    <script>
        const nombre = document.getElementById('nombre')
        const apellido = document.getElementById('apellido')
        const nacionalidad = document.getElementById('nacionalidad')
        const cedula = document.getElementById('cedula')
        const contrasena = document.getElementById('contrasena')
        const confirmarContrasena = document.getElementById('confirmarContrasena')
        const correo = document.getElementById('correo')
        const boton = document.getElementById('boton')

        const validarCorreo =
            /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/
        const nacionalidades = ['V', 'E', 'P']

        // Validaciones de cada campo
        let [
            validacionNombre, validacionApellido, validacionNacionalidad, validacionCedula, validacionCorreo,
            validacionContrasena, validacionConfirmarContrasena
        ] = [
            nombre.value.length > 3 && nombre.value.length < 21,
            apellido.value.length > 3 && apellido.value.length < 21,
            nacionalidad.options[nacionalidad.selectedIndex].value > 0,
            cedula.value.toString().length > 6 && cedula.value.toString().length < 9,
            validarCorreo.test(correo.value),
            contrasena.value.length > 3 && contrasena.value.length < 9,
            confirmarContrasena.value.length > 3 && confirmarContrasena.value.length < 9
        ]

        // Validacion de todo el formulario
        const formularioValidado = () => {
            if (validacionNombre && validacionApellido && validacionNacionalidad && validacionCedula &&
                validacionCorreo &&
                validacionContrasena && validacionConfirmarContrasena) {
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
                if (nombre.value.length > 2 && nombre.value.length < 21) {
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
                if (apellido.value.length > 2 && apellido.value.length < 21) {
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
            if (nacionalidades.includes(nacionalidad.options[nacionalidad.selectedIndex].value)) {
                validacionNacionalidad = true
                nacionalidad.classList.remove('is-invalid')
            } else {
                validacionNacionalidad = false
                nacionalidad.classList.add('is-invalid')
            }

            formularioValidado()
        })

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

        contrasena.addEventListener('input', (e) => {
            // Si la contraseña es mayor a 8 caracteres elimina a apartir del 9
            if (contrasena.value.length > 8) {
                contrasena.value = contrasena.value.slice(0, 8)
            }

            if (contrasena.value.length > 3 && contrasena.value.length < 9) {
                validacionContrasena = true
            } else {
                validacionContrasena = false
            }

            // Si es menor a 4 caracteres añade una clase como advertencia
            contrasena.value.length < 4 ?
                contrasena.classList.add('is-invalid') :
                contrasena.classList.remove('is-invalid')

            /**
             * Si el valor del campo contraseña y la confirmacion son diferentes
             * añade una clase al campo confirmacion como advertencia
             */
            contrasena.value !== confirmarContrasena.value ?
                confirmarContrasena.classList.add('is-invalid') :
                confirmarContrasena.classList.remove('is-invalid')

            formularioValidado()
        })

        confirmarContrasena.addEventListener('input', (e) => {
            // Si la confirmación de la nueva contraseña es mayor a 8 caracteres elimina a apartir del 9
            if (confirmarContrasena.value.length > 8) {
                confirmarContrasena.value = confirmarContrasena.value.slice(0, 8)
            }

            if (confirmarContrasena.value.length > 3 && confirmarContrasena.value.length < 9) {
                validacionConfirmarContrasena = true
            } else {
                validacionConfirmarContrasena = false
            }

            /**
             * Si no se coloca una contraseña pero si la confirmacion
             * añade una clase al campo confirmacion como advertencia
             */
            if (contrasena.value.length === 0) {
                contrasena.classList.add('is-invalid')
            }

            /**
             * Si:
             * 1. Campo confirmar nueva contraseña y contraseña son diferentes
             * añade una clase de advertencia al campo contraseña.
             * 2. Además de, el campo contraseña tener más de 4 caracteres
             */
            confirmarContrasena.value !== contrasena.value && contrasena.value.length > 4 ?
                confirmarContrasena.classList.add('is-invalid') :
                confirmarContrasena.classList.remove('is-invalid')

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

    {{-- Mensajes --}}
    <script>
        @if ($message = session('usuarioInvalido'))
            Swal.fire({
                icon: 'error',
                title: '¡Error al registrar!',
                html: 'Uno de los campos parece estar mal.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger px-5'
                },
            })
        @endif
    </script>
@stop
