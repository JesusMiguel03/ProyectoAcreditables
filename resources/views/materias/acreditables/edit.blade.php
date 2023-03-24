@extends('adminlte::page')

@section('title', 'Acreditables | Editar materia')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('materias.index') }}" class="link-muted">Cursos</a></li>
    <li class="breadcrumb-item active"><a href="">Editar</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Materias</x-tipografia.titulo>
@stop

@section('content')
    <div class="col-md-6 col-sm-12 mx-auto">

        <div class="card">

            <header class="card-header bg-primary">
                <h5>Editar materia - {{ $materia->nom_materia }}</h5>
            </header>

            <main class="card-body">
                <form action="{{ route('materias.update', $materia->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{ method_field('PUT') }}

                    <x-formularios.acreditables :materia="$materia" :categorias="$categorias" :profesores="$profesores" :trayectos="$trayectos" />
                </form>
            </main>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">

    {{-- Personalizados --}}
    <link rel="stylesheet" href="{{ asset('css/buscar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilosVarios/required.css') }}">
    <link rel="stylesheet" href="{{ asset('css/descripcion.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilosVarios/input.css') }}">
@stop

@section('js')
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>

    {{-- Personalizados --}}
    <script src="{{ asset('js/previsualizacion.js') }}"></script>

    {{-- Validaciones --}}
    <script>
        const nombre = document.getElementById('nombre')
        const cupos = document.getElementById('cupos')
        const trayecto = document.getElementById('trayecto')
        const descripcion = document.getElementById('descripcion')
        const estado = document.getElementById('estado')
        const categoria = document.getElementById('categoria')
        const metodologia = document.getElementById('metodologia')
        const profesor = document.getElementById('profesor')
        const boton = document.getElementById('formularioEnviar')

        const estados = ['Inactivo', 'Activo', 'En progreso', 'Finalizado', 'Descontinuado']
        const metodologias = ['Teórico', 'Práctico', 'Teórico-Práctico']

        let validarNombre = /^(?=\S)(?:(?!\s{2})[a-zA-ZÀ-ÿ\s]){3,}$/g
        let validarDescripcion = /^(?=\S)(?:(?!\s{2})[a-zA-ZÀ-ÿ\s]){10,}$/g

        let [
            validacionNombre, validacionCupos, validacionTrayecto, validacionDescripcion, validacionEstado,
            validacionCategoria, validacionMetodologia, validacionProfesor
        ] = [
            validarNombre.test(nombre.value) && nombre.value.length > 5 && nombre.value.length < 26,
            cupos.value > 1 && cupos.value < 51,
            trayecto.options[trayecto.selectedIndex].value > 0,
            validarDescripcion.test(descripcion.value) && descripcion.value.length > 15 && descripcion.value.length < 256,
            estados.includes(estado.options[estado.selectedIndex].value),
            categoria.options[categoria.selectedIndex].value > 0,
            metodologias.includes(metodologia.options[metodologia.selectedIndex].value),
            profesor.options[profesor.selectedIndex].value > 0
        ]

        if (!(validacionNombre && validacionCupos && validacionTrayecto && validacionDescripcion && validacionEstado &&
                validacionCategoria && validacionMetodologia && validacionProfesor)) {
            boton.disabled = true
        } else {
            boton.removeAttribute('disabled')
        }

        const enviarFormulario = () => {
            if (validacionNombre && validacionCupos && validacionTrayecto && validacionDescripcion &&
                validacionEstado && validacionCategoria && validacionMetodologia && validacionProfesor) {
                boton.removeAttribute('disabled')
            } else {
                boton.disabled = true
            }
        }

        nombre.addEventListener('input', (e) => {
            nombre.value = nombre.value.replace(/[^a-zA-ZÀ-ÿ\s]+$/, '')



            if (nombre.value.length > 25) {
                nombre.value = nombre.value.slice(0, 25)
            }

            if (/^(?=\S)(?:(?!\s{2})[a-zA-ZÀ-ÿ\s]){3,}$/g.test(nombre.value) && nombre.value.length > 4 && nombre.value.length < 26) {
                nombre.classList.remove('is-invalid')
                validacionNombre = true
            } else {
                nombre.classList.add('is-invalid')
                validacionNombre = false
            }

            enviarFormulario()
        })

        cupos.addEventListener('input', (e) => {
            if (cupos.value > 50) {
                cupos.value = 50
            }

            if (cupos.value > 1 && cupos.value < 51) {
                cupos.classList.remove('is-invalid')
                validacionCupos = true
            } else {
                cupos.classList.add('is-invalid')
                validacionCupos = false
            }

            enviarFormulario()
        })

        trayecto.addEventListener('change', (e) => {
            if (trayecto.options[trayecto.selectedIndex].value > 0) {
                trayecto.classList.remove('is-invalid')
                validacionTrayecto = true
            } else {
                trayecto.classList.add('is-invalid')
                validacionTrayecto = false
            }

            enviarFormulario()
        })

        descripcion.addEventListener('input', (e) => {
            descripcion.value = descripcion.value.replace(/[^a-zA-ZÀ-ÿ\s]+$/, '')

            if (descripcion.value.length > 255) {
                descripcion.value = descripcion.value.slice(0, 255)
            }

            if (/^(?=\S)(?:(?!\s{2})[a-zA-ZÀ-ÿ\s]){10,}$/g.test(descripcion.value) && descripcion.value.length > 15 && descripcion.value.length < 256) {
                descripcion.classList.remove('is-invalid')
                validacionDescripcion = true
            } else {
                descripcion.classList.add('is-invalid')
                validacionDescripcion = false
            }

            enviarFormulario()
        })

        estado.addEventListener('change', (e) => {
            if (estados.includes(estado.options[estado.selectedIndex].value)) {
                estado.classList.remove('is-invalid')
                validacionEstado = true
            } else {
                estado.classList.add('is-invalid')
                validacionEstado = false
            }

            enviarFormulario()
        })

        categoria.addEventListener('change', (e) => {
            if (categoria.options[categoria.selectedIndex].value > 0) {
                categoria.classList.remove('is-invalid')
                validacionCategoria = true
            } else {
                categoria.classList.add('is-invalid')
                validacionCategoria = false
            }

            enviarFormulario()
        })

        metodologia.addEventListener('change', (e) => {
            if (metodologias.includes(metodologia.options[metodologia.selectedIndex].value)) {
                metodologia.classList.remove('is-invalid')
                validacionMetodologia = true
            } else {
                metodologia.classList.add('is-invalid')
                validacionMetodologia = false
            }

            enviarFormulario()
        })

        profesor.addEventListener('change', (e) => {
            if (profesor.options[profesor.selectedIndex].value > 0) {
                profesor.classList.remove('is-invalid')
                validacionProfesor = true
            } else {
                profesor.classList.add('is-invalid')
                validacionProfesor = false
            }

            enviarFormulario()
        })
    </script>

    {{-- Mensajes --}}
    <script>
        @if ($message = session('error'))
            Swal.fire({
                icon: 'error',
                title: '¡No se pudo registrar!',
                html: 'Uno de los campos no cumple los requisitos.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger px-5'
                },
            })
        @endif
    </script>
@stop
