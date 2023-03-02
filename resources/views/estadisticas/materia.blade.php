@php
    $conversor = [1 => 'I', 2 => 'II', 3 => 'III'];
@endphp

@extends('adminlte::page')

@section('title', 'Acreditables | Gráficos y estadísticas')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('estadisticas.index') }}" class="link-muted">Estadísticas</a></li>
    <li class="breadcrumb-item">
        <a href="{{ route('estadisticas.show', $periodoActual->id) }}" class="link-muted">
            {{ $conversor[$periodoActual->fase] . '-' . \Carbon\Carbon::parse($periodoActual->inicio)->format('Y') }}
        </a>
    </li>
    <li class="breadcrumb-item"><a href="">{{ $materiaActual->nom_materia }}</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Gráficos y estadísticas</x-tipografia.titulo>
@stop

@section('content')
    <x-formularios.estadisticas :periodos="$periodos" :materias="$materias" :profesor="$profesor" :periodoActual="$periodoActual" :periodo="$periodoFormateado"
        :materiaActual="$materiaActual" />

    <section class="row">
        <x-card.estadisticas-materia nombre="Estudiantes" color="info" :contenido="$datosEstudiantes" :cantidad="$totalEstudiantes" />
        <x-card.estadisticas-materia nombre="PNF" color="secondary" :contenido="$pnfs" />
    </section>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/iconos/x.css') }}">
@stop

@section('js')
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        const inputPeriodo = document.getElementById('periodo')
        const btnPeriodo = document.getElementById('btnPeriodo')

        const inputMateria = document.getElementById('materias')
        const btnMateria = document.getElementById('btnMateria')

        const activarBotones = () => {

            if (periodo == 0) {

                btnPeriodo.classList.add('disabled')
                btnMateria.classList.add('disabled')
                inputPeriodo.classList.add('is-invalid')

                if (!document.getElementById('mensajePeriodo')) {

                    let mensaje = document.createElement('span')
                    let strong = document.createElement('strong')

                    mensaje.classList.add('invalid-feedback')
                    mensaje.setAttribute('role', 'alert')
                    mensaje.setAttribute('id', 'mensajePeriodo')
                    strong.innerText = 'Seleccione un periodo de la lista'

                    mensaje.append(strong)
                    inputPeriodo.parentNode.append(mensaje)
                }

            } else {

                btnPeriodo.classList.remove('disabled')
                btnMateria.classList.remove('disabled')
                inputPeriodo.classList.remove('is-invalid')
            }

            if (materia == 0) {

                btnMateria.classList.add('disabled')
                inputMateria.classList.add('is-invalid')

                if (!document.getElementById('mensajeMateria')) {

                    let mensaje = document.createElement('span')
                    let strong = document.createElement('strong')

                    mensaje.classList.add('invalid-feedback')
                    mensaje.setAttribute('role', 'alert')
                    mensaje.setAttribute('id', 'mensajeMateria')
                    strong.innerText = 'Seleccione una materia de la lista'

                    mensaje.append(strong)
                    inputMateria.parentNode.append(mensaje)
                }

            } else if (materia != 0 && periodo != 0) {

                btnMateria.classList.remove('disabled')
                inputMateria.classList.remove('is-invalid')
            }
        }

        let [periodo, materia] = [
            inputPeriodo.options[inputPeriodo.selectedIndex].value || 0,
            inputMateria.options[inputMateria.selectedIndex].value || 0
        ]

        inputPeriodo.addEventListener('change', (e) => {
            periodo = e.currentTarget.options[e.currentTarget.selectedIndex].value

            activarBotones()
        })

        inputMateria.addEventListener('change', (e) => {
            materia = e.currentTarget.options[e.currentTarget.selectedIndex].value

            activarBotones()
        })

        btnPeriodo.addEventListener('click', (e) => {
            e.currentTarget.href = `${"{{ route('estadisticas.show') }}"}/${periodo}`
        })

        btnMateria.addEventListener('click', (e) => {
            e.currentTarget.href = `${"{{ route('estadisticas.materia') }}"}/${periodo}/${materia}`
        })
    </script>

    <script>
        @if ($message = session('sinDatos'))
            Swal.fire({
                icon: 'info',
                title: '¡No se encontraron datos!',
                html: "La acreditable <b>{{ session('sinDatos') }}</b> no pertenece al periodo <b>{{ session('periodo') }}</b>, por favor intente con otra.",
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                }
            })
        @endif
    </script>
@stop
