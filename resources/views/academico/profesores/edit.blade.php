@extends('adminlte::page')

@section('title', 'Acreditables | Profesores')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('profesores.index') }}" class="link-muted">Profesores</a></li>
    <li class="breadcrumb-item active">
        <a href="">
            {{ $profesor->nombreProfesor() }}
        </a>
    </li>
@stop

@section('content_header')
    <x-tipografia.titulo>Listado de profesores</x-tipografia.titulo>
@stop

@section('content')
    <div class="col-md-6 col-sm-12 mx-auto">
        <div class="card">
            <header class="card-header bg-primary">
                <h5>Editar perfil de profesor</h5>
            </header>

            <main class="card-body">
                <form action="{{ route('profesores.update', $profesor->id) }}" method="post">
                    @csrf
                    {{ method_field('PUT') }}

                    <x-formularios.registrar-profesor :profesor="$profesor" :departamentos="$departamentos" :conocimientos="$conocimientos" />

                </form>
            </main>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') : asset('vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('css/estilosVarios/required.css') : asset('css/estilosVarios/required.css') }}">
@stop

@section('js')
    <script src="{{ request()->secure() ? secure_asset('vendor/moment/moment.js') : asset('vendor/moment/moment.js') }}">
    </script>
    <script
        src="{{ request()->secure() ? secure_asset('vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') : asset('vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}">
    </script>

    {{-- Validaciones --}}
    <script>
        const nombre = document.getElementById('nombre')
        const apellido = document.getElementById('apellido')
        const nacionalidad = document.getElementById('nacionalidad')
        const cedula = document.getElementById('cedula')
        const departamento = document.getElementById('departamento')
        const conocimiento = document.getElementById('conocimiento')
        const estado = document.getElementById('estado')
        const ciudad = document.getElementById('ciudad')
        const urb = document.getElementById('urb')
        const calle = document.getElementById('calle')
        const casa = document.getElementById('casa')
        const codigo = document.getElementById('codigo')
        const tlf = document.getElementById('tlf')
        const nacimiento = document.getElementById('fecha_nacimiento')
        const ingreso = document.getElementById('fecha_ingreso')
        const estadoProfesor = document.getElementById('estadoProfesor')
        const botonProfesor = document.getElementById('formularioEnviar')

        const nacionalidades = ['V', 'E', 'P']

        let [
            validacionNombre, validacionApellido, validacionNacionalidad, validacionCedula,
            validarEstadoProfesor, validarDepartamento, validarConocimiento, validarEstado, validarCiudad, validarUrb,
            validarCalle, validarCasa, validarCodigo, validarTlf, validarNacimiento, validarIngreso
        ] = [
            nombre.value.length > 2 && nombre.value.length < 21,
            apellido.value.length > 2 && apellido.value.length < 21,
            nacionalidades.includes(nacionalidad.options[nacionalidad.selectedIndex].value),
            cedula.value.toString().length > 6 && cedula.value.toString().length < 9,
            estadoProfesor.options[estadoProfesor.selectedIndex].value > 0,
            departamento.options[departamento.selectedIndex].value > 0,
            conocimiento.options[conocimiento.selectedIndex].value > 0,
            estado.value.length > 3 && estado.value.length < 17,
            ciudad.value.length > 5 && ciudad.value.length < 31,
            urb.value.length > 5 && urb.value.length < 21,
            calle.value.length > 5 && calle.value.length < 21,
            casa.value.length > 3 && casa.value.length < 11,
            codigo.options[codigo.selectedIndex].value > 0,
            tlf.value.length === 7,
            nacimiento.value.length !== 0,
            ingreso.value.length !== 0
        ]

        const validarFormulario = () => {
            if (validacionNombre && validacionApellido && validacionNacionalidad && validacionCedula &&
                validarEstadoProfesor && validarDepartamento && validarConocimiento && validarEstado && validarCiudad &&
                validarUrb && validarCalle && validarCasa && validarCodigo && validarTlf && validarNacimiento &&
                validarIngreso) {
                botonProfesor.removeAttribute('disabled')
            } else {
                botonProfesor.disabled = true
            }
        }

        validarFormulario()

        estadoProfesor.addEventListener('change', (e) => {
            if (estadoProfesor.options[estadoProfesor.selectedIndex].value > 0) {
                validarEstadoProfesor = true
                estadoProfesor.classList.remove('is-invalid')
            } else {
                validarEstadoProfesor = false
                estadoProfesor.classList.add('is-invalid')
            }

            validarFormulario()
        })

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

            validarFormulario()
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

            validarFormulario()
        })

        nacionalidad.addEventListener('change', (e) => {
            if (nacionalidades.includes(nacionalidad.options[nacionalidad.selectedIndex].value)) {
                validacionNacionalidad = true
                nacionalidad.classList.remove('is-invalid')
            } else {
                validacionNacionalidad = false
                nacionalidad.classList.add('is-invalid')
            }

            validarFormulario()
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

            validarFormulario()
        })

        departamento.addEventListener('change', (e) => {
            if (departamento.options[departamento.selectedIndex].value > 0) {
                validarDepartamento = true
                departamento.classList.remove('is-invalid')
            } else {
                validarDepartamento = false
                departamento.classList.add('is-invalid')
            }

            validarFormulario()
        })

        conocimiento.addEventListener('change', (e) => {
            if (conocimiento.options[conocimiento.selectedIndex].value > 0) {
                validarConocimiento = true
                conocimiento.classList.remove('is-invalid')
            } else {
                validarConocimiento = false
                conocimiento.classList.add('is-invalid')
            }

            validarFormulario()
        })

        codigo.addEventListener('change', (e) => {
            if (codigo.options[codigo.selectedIndex].value > 0) {
                validarCodigo = true
                codigo.classList.remove('is-invalid')
            } else {
                validarCodigo = false
                codigo.classList.add('is-invalid')
            }

            validarFormulario()
        })

        estado.addEventListener('input', (e) => {
            if (e.currentTarget.value.length > 16) {
                e.currentTarget.value = e.currentTarget.value.length.slice(0, 16)
            }

            if (e.currentTarget.value.length > 3 && e.currentTarget.value.length < 17) {
                validarEstado = true
                e.currentTarget.classList.remove('is-invalid')
            } else {
                validarEstado = false
                e.currentTarget.classList.add('is-invalid')
            }

            validarFormulario()
        })

        ciudad.addEventListener('input', (e) => {
            if (e.currentTarget.value.length > 30) {
                e.currentTarget.value = e.currentTarget.value.length.slice(0, 30)
            }

            if (e.currentTarget.value.length > 5 && e.currentTarget.value.length < 31) {
                validarCiudad = true
                e.currentTarget.classList.remove('is-invalid')
            } else {
                validarCiudad = false
                e.currentTarget.classList.add('is-invalid')
            }

            validarFormulario()
        })

        urb.addEventListener('input', (e) => {
            if (e.currentTarget.value.length > 20) {
                e.currentTarget.value = e.currentTarget.value.length.slice(0, 20)
            }

            if (e.currentTarget.value.length > 5 && e.currentTarget.value.length < 21) {
                validarUrb = true
                e.currentTarget.classList.remove('is-invalid')
            } else {
                validarUrb = false
                e.currentTarget.classList.add('is-invalid')
            }

            validarFormulario()
        })

        calle.addEventListener('input', (e) => {
            if (e.currentTarget.value.length > 20) {
                e.currentTarget.value = e.currentTarget.value.length.slice(0, 20)
            }

            if (e.currentTarget.value.length > 5 && e.currentTarget.value.length < 21) {
                validarCalle = true
                e.currentTarget.classList.remove('is-invalid')
            } else {
                validarCalle = false
                e.currentTarget.classList.add('is-invalid')
            }

            validarFormulario()
        })

        casa.addEventListener('input', (e) => {
            if (e.currentTarget.value.length > 10) {
                e.currentTarget.value = e.currentTarget.value.length.slice(0, 10)
            }

            if (e.currentTarget.value.length > 3 && e.currentTarget.value.length < 11) {
                validarCasa = true
                e.currentTarget.classList.remove('is-invalid')
            } else {
                validarCasa = false
                e.currentTarget.classList.add('is-invalid')
            }

            validarFormulario()
        })

        tlf.addEventListener('input', (e) => {
            e.currentTarget.value = e.currentTarget.value.replace(/[^0-9]/g, '')

            if (e.currentTarget.value.length > 7) {
                e.currentTarget.value = e.currentTarget.value.length.slice(0, 7)
            }

            if (e.currentTarget.value.length === 7) {
                validarTlf = true
                e.currentTarget.classList.remove('is-invalid')
            } else {
                validarTlf = false
                e.currentTarget.classList.add('is-invalid')
            }

            validarFormulario()
        })

        nacimiento.addEventListener('blur', (e) => {
            if (nacimiento.value.length !== 0) {
                validacionNacimiento = true
                nacimiento.classList.remove('is-invalid')
            } else {
                validacionNacimiento = false
                nacimiento.classList.add('is-invalid')
            }

            validarFormulario()
        })

        ingreso.addEventListener('blur', (e) => {
            if (ingreso.value.length !== 0) {
                validarIngreso = true
                ingreso.classList.remove('is-invalid')
            } else {
                validarIngreso = false
                ingreso.classList.add('is-invalid')
            }

            validarFormulario()
        })
    </script>
@stop
