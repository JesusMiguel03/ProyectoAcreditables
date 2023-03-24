@extends('adminlte::page')

@section('title', 'Acreditables | Editar estudiante')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('estudiantes.index') }}" class="link-muted">Estudiantes</a></li>
    <li class="breadcrumb-item active"><a href="">{{ $usuario->nombre }} {{ $usuario->apellido }}</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Listado de estudiantes</x-tipografia.titulo>
@stop

@section('content')
    <div class="col-md-6 col-sm-12 mx-auto">
        <section class="card">
            <header class="card-header bg-primary">
                <h5>Editar credenciales</h5>
            </header>

            <main class="card-body">

                <x-formularios.editar-estudiante :usuario="$usuario" :trayectos="$trayectos" :pnfs="$pnfs" :pnfsNoDisponibles="$pnfsNoDisponibles" />
            </main>
        </section>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/estilosVarios/required.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
@stop

@section('js')
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>

    {{-- Validaciones --}}
    <script>
        const nombre = document.getElementById('nombre')
        const apellido = document.getElementById('apellido')
        const nacionalidad = document.getElementById('nacionalidad')
        const cedula = document.getElementById('cedula')
        const trayecto = document.getElementById('trayecto')
        const pnf = document.getElementById('pnf')
        const boton = document.getElementById('formularioEnviar')

        const nacionalidades = ['V', 'E', 'P']

        // Validaciones de cada campo
        let [
            validacionNombre, validacionApellido, validarNacionalidad, validacionCedula, validacionTrayecto, validacionPnf
        ] = [
            nombre.value.length > 3 && nombre.value.length < 21,
            apellido.value.length > 3 && apellido.value.length < 21,
            nacionalidades.includes(nacionalidad.options[nacionalidad.selectedIndex].value),
            cedula.value.toString().length > 6 && cedula.value.toString().length < 9,
            trayecto.options[trayecto.selectedIndex].value > 0,
            pnf.options[pnf.selectedIndex].value > 0,
        ]

        // Si algún campo es inválido desactiva el botón
        if (!(validacionNombre && validacionApellido && validarNacionalidad && validacionCedula && validacionTrayecto &&
                validacionPnf)) {
            boton.disabled = true
        }

        // Validacion de todo el formulario
        const formularioValidado = () => {
            if (validacionNombre && validacionApellido && validarNacionalidad && validacionCedula &&
                validacionTrayecto && validacionPnf) {
                boton.removeAttribute('disabled')
            } else {
                boton.disabled = true
            }
        }

        nombre.addEventListener('input', (e) => {
            // Evita cualquier caracter que no sea una letra o acento
            e.currentTarget.value = e.currentTarget.value.replace(/[^a-zA-ZÀ-ÿ]+$/, '')

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
            // Evita cualquier caracter que no sea una letra o acento
            e.currentTarget.value = e.currentTarget.value.replace(/[^a-zA-ZÀ-ÿ]+$/, '')

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
            // Valida que la nacionalidad sea V, E o P
            if (nacionalidades.includes(nacionalidad.options[nacionalidad.selectedIndex].value)) {
                validarNacionalidad = true
                nacionalidad.classList.remove('is-invalid')
            } else {
                validarNacionalidad = false
                nacionalidad.classList.add('is-invalid')
            }

            formularioValidado()
        })

        // Si la cédula es mayor a 8 dígitos elimina a apartir del 9
        cedula.addEventListener('input', (e) => {
            if (e.currentTarget.value.toString().length > 8) {
                e.currentTarget.value = e.currentTarget.value.toString().slice(0, 8)
            }

            // Si se intenta colocar la letra e la remueve
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

        trayecto.addEventListener('change', (e) => {
            // Si la opción es mayor a 0 lo da por válido
            if (e.currentTarget.options[e.currentTarget.selectedIndex].value > 0) {
                validacionTrayecto = true
                e.currentTarget.classList.remove('is-invalid')
            } else {
                validacionTrayecto = false
                e.currentTarget.classList.add('is-invalid')
            }

            formularioValidado()
        })

        pnf.addEventListener('change', (e) => {
            // Si la opción es mayor a 0 lo da por válido
            if (e.currentTarget.options[e.currentTarget.selectedIndex].value > 0) {
                validacionPnf = true
                e.currentTarget.classList.remove('is-invalid')
            } else {
                validacionPnf = false
                e.currentTarget.classList.add('is-invalid')
            }

            formularioValidado()
        })
    </script>

    <script>
        @if (session('pnfLimite'))
            Swal.fire({
                icon: 'info',
                title: '¡Hubo un problema!',
                html: "{{ session('pnfLimite') }}",
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info px-5'
                },
            })
        @elseif (session('error'))
            Swal.fire({
                icon: 'error',
                title: '¡Error al registrar!',
                html: 'Uno de los parámetros parece estar mal.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger px-5'
                },
            })
        @endif
    </script>
@stop
