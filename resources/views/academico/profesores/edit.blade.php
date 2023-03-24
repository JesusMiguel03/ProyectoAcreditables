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
    <link rel="stylesheet" href="{{ asset('vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilosVarios/required.css') }}">
@stop

@section('js')
    <script src="{{ asset('vendor/moment/moment.js') }}"></script>
    <script src="{{ asset('vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    {{-- Validaciones --}}
    <script>
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

        botonProfesor.disabled = true

        let [
            validarEstadoProfesor, validarDepartamento, validarConocimiento, validarEstado, validarCiudad, validarUrb, validarCalle, validarCasa, validarCodigo, validarTlf, validarNacimiento, validarIngreso
        ] = [
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
            nacimiento.value.length > 0,
            ingreso.value.length > 0
        ]

        const validarFormulario = () => {
            if (validarEstadoProfesor && validarDepartamento && validarConocimiento && validarEstado && validarCiudad &&
                validarUrb && validarCalle && validarCasa && validarCodigo && validarTlf && validarNacimiento &&
                validarIngreso) {
                botonProfesor.removeAttribute('disabled')
            } else {
                botonProfesor.disabled = true
            }

            console.log(validarEstadoProfesor, validarDepartamento, validarConocimiento, validarEstado, validarCiudad, validarUrb, validarCalle, validarCasa, validarCodigo, validarTlf, validarNacimiento, validarIngreso)
        }

        estadoProfesor.addEventListener('change', (e) => {
            let estadoProfesorSeleccionado = e.currentTarget.options[e.currentTarget.selectedIndex].value || 0

            if (estadoProfesorSeleccionado > 0) {
                validarEstadoProfesor = true
                e.currentTarget.classList.remove('is-invalid')
            } else {
                validarEstadoProfesor = false
                e.currentTarget.classList.add('is-invalid')
            }

            validarFormulario()
        })

        departamento.addEventListener('change', (e) => {
            let departamentoSeleccionado = e.currentTarget.options[e.currentTarget.selectedIndex].value || 0

            if (departamentoSeleccionado > 0) {
                validarDepartamento = true
                e.currentTarget.classList.remove('is-invalid')
            } else {
                validarDepartamento = false
                e.currentTarget.classList.add('is-invalid')
            }

            validarFormulario()
        })

        conocimiento.addEventListener('change', (e) => {
            let conocimientoSeleccionado = e.currentTarget.options[e.currentTarget.selectedIndex].value || 0

            if (conocimientoSeleccionado > 0) {
                validarConocimiento = true
                e.currentTarget.classList.remove('is-invalid')
            } else {
                validarConocimiento = false
                e.currentTarget.classList.add('is-invalid')
            }

            validarFormulario()
        })

        codigo.addEventListener('change', (e) => {
            if (e.currentTarget.options[e.currentTarget.selectedIndex].value > 0) {
                validarCodigo = true
                e.currentTarget.classList.remove('is-invalid')
            } else {
                validarCodigo = false
                e.currentTarget.classList.add('is-invalid')
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
            validarNacimiento = true

            validarFormulario()
        })

        ingreso.addEventListener('blur', (e) => {
            validarIngreso = true

            validarFormulario()
        })
    </script>
@stop
