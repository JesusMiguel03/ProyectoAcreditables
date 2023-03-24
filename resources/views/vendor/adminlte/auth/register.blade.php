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
    <link rel="stylesheet" href="{{ asset('css/estilosVarios/required.css') }}">
@stop

@section('js')
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

        const validarCorreo = /^[\w.-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/
        const nacionalidades = ['V', 'E', 'P']

        // Validaciones de cada campo
        let [validacionNombre, validacionApellido, validacionNacionalidad, validacionCedula, validacionCorreo, validacionContrasena,
            validacionConfirmarContrasena
        ] = [
            nombre.value.length > 3 && nombre.value.length < 21,
            apellido.value.length > 3 && apellido.value.length < 21,
            nacionalidades.includes(nacionalidad.options[nacionalidad.selectedIndex].value),
            cedula.value.toString().length > 6 && cedula.value.toString().length < 9,
            contrasena.value.length > 3 && contrasena.value.length < 9,
            confirmarContrasena.value.length > 3 && confirmarContrasena.value.length < 9,
            validarCorreo.test(correo.value)
        ]

        // Validacion de todo el formulario
        const formularioValidado = () => {
            if (validacionNombre && validacionApellido && validacionNacionalidad && validacionCedula && validacionCorreo &&
                validacionContrasena && validacionConfirmarContrasena) {
                boton.removeAttribute('disabled')
            } else {
                boton.disabled = true
            }
        }

        nombre.addEventListener('input', (e) => {
            // Si el nombre tiene entre 4 y 20 caracteres es válido
            if (e.currentTarget.value.length > 3 && e.currentTarget.value.length < 21) {
                e.currentTarget.classList.remove('is-invalid')
                validacionNombre = true
            } else {
                e.currentTarget.classList.add('is-invalid')
                validacionNombre = false
            }

            formularioValidado()
        })

        apellido.addEventListener('input', (e) => {
            // Si el apellido tiene entre 4 y 20 caracteres es válido
            if (e.currentTarget.value.length > 3 && e.currentTarget.value.length < 21) {
                e.currentTarget.classList.remove('is-invalid')
                validacionApellido = true
            } else {
                e.currentTarget.classList.add('is-invalid')
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

        // Si la cédula es mayor a 8 dígitos elimina a apartir del 9
        cedula.addEventListener('input', (e) => {
            if (e.currentTarget.value.toString().length > 8) {
                e.currentTarget.value = e.currentTarget.value.toString().slice(0, 8)
            }

            e.currentTarget.value = e.currentTarget.value.toString().replace('e', '')

            // Si la cédula tiene entre 7 y 8 digitos
            if (e.currentTarget.value.toString().length > 6 && e.currentTarget.value.toString().length < 9) {
                e.currentTarget.classList.remove('is-invalid')
                validacionCedula = true
            } else {
                e.currentTarget.classList.add('is-invalid')
                validacionCedula = false
            }

            formularioValidado()
        })

        contrasena.addEventListener('input', (e) => {
            // Si la contraseña es mayor a 8 caracteres elimina a apartir del 9
            if (e.currentTarget.value.length > 8) {
                e.currentTarget.value = e.currentTarget.value.slice(0, 8)
            }

            if (e.currentTarget.value.length > 3 && e.currentTarget.value.length < 9) {
                validacionContrasena = true
            } else {
                validacionContrasena = false
            }

            // Si es menor a 4 caracteres añade una clase como advertencia
            e.currentTarget.value.length < 4 ?
                e.currentTarget.classList.add('is-invalid') :
                e.currentTarget.classList.remove('is-invalid')

            /**
             * Si el valor del campo contraseña y la confirmacion son diferentes
             * añade una clase al campo confirmacion como advertencia
             */
            e.currentTarget.value !== confirmarContrasena.value ?
                confirmarContrasena.classList.add('is-invalid') :
                confirmarContrasena.classList.remove('is-invalid')

            formularioValidado()
        })

        confirmarContrasena.addEventListener('input', (e) => {
            // Si la confirmación de la nueva contraseña es mayor a 8 caracteres elimina a apartir del 9
            if (e.currentTarget.value.length > 8) {
                e.currentTarget.value = e.currentTarget.value.slice(0, 8)
            }

            if (e.currentTarget.value.length > 3 && e.currentTarget.value.length < 9) {
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
            e.currentTarget.value !== contrasena.value && contrasena.value.length > 4 ?
                e.currentTarget.classList.add('is-invalid') :
                e.currentTarget.classList.remove('is-invalid')

            formularioValidado()
        })

        correo.addEventListener('input', (e) => {
            // Si el correo es mayor a 40 caracteres elimina a partir del 9
            if (e.currentTarget.value.length > 40) {
                e.currentTarget.value = e.currentTarget.value.slice(0, 40)
            }

            // Si el correo es válido
            if (validarCorreo.test(e.currentTarget.value)) {
                e.currentTarget.classList.remove('is-invalid')
                validacionCorreo = true
            } else {
                e.currentTarget.classList.add('is-invalid')
                validacionCorreo = false
            }

            formularioValidado()
        })
    </script>
@stop
