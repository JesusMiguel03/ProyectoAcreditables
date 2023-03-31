@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('adminlte_css_pre')
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('vendor/plugins/icheck-bootstrap/icheck-bootstrap.min.css') : asset('vendor/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@stop

@php($login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login'))
@php($register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register'))
@php($password_reset_url = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url', 'password/reset'))

@if (config('adminlte.use_route_url', false))
    @php($login_url = $login_url ? route($login_url) : '')
    @php($register_url = $register_url ? route($register_url) : '')
    @php($password_reset_url = $password_reset_url ? route($password_reset_url) : '')
@else
    @php($login_url = $login_url ? url($login_url) : '')
    @php($register_url = $register_url ? url($register_url) : '')
    @php($password_reset_url = $password_reset_url ? url($password_reset_url) : '')
@endif

@section('title', 'Acreditables | Iniciar sesión')

@section('auth_header', __('Inicia sesión para acceder'))

@section('auth_body')
    <form action="{{ $login_url }}" method="post">
        @csrf

        {{-- Correo --}}
        <div class="form-group required">
            <label for="email" class="control-label">Correo</label>
            <div class="input-group mb-3">
                <input type="email" id="correo" name="email" class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}" placeholder="{{ __('Ej: micorreo@gmail.com') }}"
                    pattern="^[\w.-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" maxlength="40" title="Debe ser un correo válido."
                    autofocus required>

                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope {{ config('adminlte.classes_auth_icon', '') }}"></span>
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
        <div class="form-group required">
            <label for="password" class="control-label">Contraseña</label>
            <div class="input-group mb-3">
                <input type="password" id="contrasena" name="password"
                    class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('Contraseña') }}"
                    title="Debe contener entre 4 y 8 caracteres." required>

                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                    </div>
                </div>

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <x-modal.mensaje-obligatorio />

        <div class="row">
            <div class="col-6 text-center">
                <a href="{{ $register_url }}" class="btn text-primary">
                    {{ __('Registrarme') }}
                </a>
            </div>

            <div class="col-6">
                <button id="boton" type=submit class="btn btn-block btn-primary" disabled>
                    {{ __('Iniciar Sesión') }}
                </button>
            </div>

            <div class="col-12 mt-3 text-center">
                <a href="{{ route('manual.usuario') }}">¿No entiendes como funciona? Haz clic aquí</a>
            </div>
        </div>

    </form>
@stop

@section('css')
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('css/estilosVarios/required.css') : asset('css/estilosVarios/required.css') }}">
@stop

@section('js')
    <script>
        const boton = document.getElementById('boton')
        const contrasena = document.getElementById('contrasena')
        const correo = document.getElementById('correo')

        // Expresión regular para validar el formato del correo electrónico
        const validarCorreo =
            /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/

        correo.addEventListener('input', (e) => {
            // Validacion de correo y contraseña
            let validacionCorreo = validarCorreo.test(correo.value)
            let contrasenaValida = contrasena.value.length > 3 && contrasena.value.length < 9

            // Si el correo es mayor a 40 caracteres, se recorta a 40 caracteres
            if (correo.value.length > 40) {
                correo.value = correo.value.slice(0, 40)
            }

            correo.value = correo.value.replace(/[^@A-Za-z0-9._-]+/g, '')

            // Si el correo es válido, se quita la clase 'is-invalid' para indicar que no hay errores
            if (validacionCorreo) {
                correo.classList.remove('is-invalid')
            } else {
                e.currentTarget.classList.add('is-invalid')
            }

            // Si el correo y la contraseña son válidos, se habilita el botón
            validacionCorreo && contrasenaValida ?
                boton.removeAttribute('disabled') :
                boton.disabled = true
        })

        // Evento que se dispara cuando el usuario escribe en el campo de la contraseña
        contrasena.addEventListener('input', (e) => {
            // Validacion de correo y contraseña
            let validacionCorreo = validarCorreo.test(correo.value)
            let contrasenaValida = contrasena.value.length > 3 && contrasena.value.length < 9

            // Si la contraseña es mayor a 8 caracteres, se recorta a 8 caracteres
            if (contrasena.value.length > 8) {
                contrasena.value = contrasena.value.slice(0, 8)
                contrasenaValida = contrasena.value.length > 3 && contrasena.value.length < 9
            }

            // Si la contraseña es válida, se quita la clase 'is-invalid' para indicar que no hay errores
            if (contrasenaValida) {
                contrasena.classList.remove('is-invalid')
            }

            // Si el correo y la contraseña son válidos, se habilita el botón
            validacionCorreo && contrasenaValida ?
                boton.removeAttribute('disabled') :
                boton.disabled = true
        })
    </script>
@stop
