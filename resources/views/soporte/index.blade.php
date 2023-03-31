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
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('vendor/sweetalert2/bootstrap-4.min.css') : asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
@stop

@section('js')
    <script
        src="{{ request()->secure() ? secure_asset('vendor/sweetalert2/sweetalert2.min.js') : asset('vendor/sweetalert2/sweetalert2.min.js') }}">
    </script>

    {{-- Validaciones --}}
    {{-- Recuperar contraseña --}}
    <script>
        const correo = document.getElementById('correoContrasena')
        const boton = document.getElementById('botonCorreoContrasena')

        boton.disabled = true

        let validacionCorreo = false

        let regexCorreo =
            /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/

        correo.addEventListener('input', (e) => {
            if (e.currentTarget.value.length > 40) {
                e.currentTarget.value = e.currentTarget.value.slice(0, 40)
            }

            if (regexCorreo.test(e.currentTarget.value)) {
                e.currentTarget.classList.remove('is-invalid')
                validacionCorreo = true
            } else {
                e.currentTarget.classList.add('is-invalid')
                validacionCorreo = false
            }

            if (validacionCorreo) {
                boton.removeAttribute('disabled')
            } else {
                boton.disabled = true
            }
        })
    </script>

    {{-- Cambiar cedula --}}
    <script>
        const correoCedula = document.getElementById('correoCedula')
        const cedula = document.getElementById('cedula')
        const botonCedula = document.getElementById('botonCorreoCedula')

        botonCedula.disabled = true

        let [validacionCorreoCedula, validacionCedula] = [false, false]

        const validarFormulario = () => {
            if (validacionCorreoCedula && validacionCedula) {
                botonCedula.removeAttribute('disabled')
            } else {
                botonCedula.disabled = true
            }
        }

        cedula.addEventListener('input', (e) => {
            cedula.value = cedula.value.replace('e', '')

            if (cedula.value.toString().length > 8) {
                cedula.value = cedula.value.toString().slice(0, 8)
            }

            if (cedula.value.toString().length > 6 && cedula.value.toString().length < 9) {
                cedula.classList.remove('is-invalid')
                validacionCedula = true
            } else {
                cedula.classList.add('is-invalid')
                validacionCedula = false
            }

            validarFormulario()
        })

        correoCedula.addEventListener('input', (e) => {
            if (e.currentTarget.value.length > 40) {
                e.currentTarget.value = e.currentTarget.value.slice(0, 40)
            }

            if (regexCorreo.test(e.currentTarget.value)) {
                e.currentTarget.classList.remove('is-invalid')
                validacionCorreoCedula = true
            } else {
                e.currentTarget.classList.add('is-invalid')
                validacionCorreoCedula = false
            }

            validarFormulario()
        })
    </script>

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
