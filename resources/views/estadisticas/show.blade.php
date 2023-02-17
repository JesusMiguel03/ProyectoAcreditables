@php
    $conversor = [1 => 'I', 2 => 'II', 3 => 'III'];
@endphp

@extends('adminlte::page')

@section('title', 'Acreditables | Gráficos y estadísticas')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('estadisticas.index') }}" class="link-muted">Estadísticas</a></li>
    <li class="breadcrumb-item">
        <a href="">
            {{ $conversor[$periodoActual->fase] . '-' . \Carbon\Carbon::parse($periodoActual->inicio)->format('Y') }}
        </a>
    </li>
@stop

@section('content_header')
    <x-tipografia.titulo>Gráficos y estadísticas</x-tipografia.titulo>
@stop

@section('content')
    <x-formularios.estadisticas :periodos="$periodos" :materias="$materias" :periodoActual="$periodoActual" :periodo="$periodoFormateado" />

    <section class="row">
        <x-card.estadisticas nombre="Materias" color="primary" :cantidad="count($materias)" icono="fa-th-large" />
        <x-card.estadisticas nombre="Estudiantes" color="info" :cantidad="count($estudiantesRegistrados)" :extra="count($inscritos)" icono="fa-users" />
        <x-card.estadisticas nombre="Profesores" color="secondary" :cantidad="count($profesores)" icono="fa-user-graduate" info=false />
    </section>

    <section class="card">
        <main class="row p-3">
            @if ($listadoMateriasDemandadasPNF)
                @foreach ($listadoMateriasDemandadasPNF as $index => $trayecto)
                    <x-card.estadisticas-demandadas :trayecto="$trayecto" :nroTrayecto="$index" />
                @endforeach
            @else
                <p class="mx-auto mb-n1 text-muted">
                    No hay datos disponibles para mostrar las acreditables más demandadas por pnf y trayecto.
                </p>
            @endif
        </main>
    </section>

    <section class="row">
        <x-graficos.histograma-materias />

        <x-graficos.torta-estudiantes />
    </section>
@stop

@section('css')
    {{-- <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
@stop

@section('js')
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('vendor/chartjs/chart.js') }}"></script>

    {{-- Personalizados --}}
    <script>
        const inputPeriodo = document.getElementById('periodo')
        const btnPeriodo = document.getElementById('btnPeriodo')

        const inputMateria = document.getElementById('materias')
        const btnMateria = document.getElementById('btnMateria')

        const activarBotones = () => {
            periodo == 0 ?
                btnPeriodo.classList.add('disabled') :
                btnPeriodo.classList.remove('disabled')

            materia == 0 ?
                btnMateria.classList.add('disabled') :
                btnMateria.classList.remove('disabled')
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
        const links = document.querySelectorAll('a[href^="#"]');
        links.forEach((enlace) => {
            enlace.addEventListener("click", (e) => {
                e.preventDefault();

                document
                    .querySelector(e.currentTarget.getAttribute("href"))
                    .scrollIntoView({
                        behavior: "smooth",
                    });
            });
        });

        const color = () => {
            let r = Math.floor(Math.random() * (255 - 1 + 1) + 1),
                g = Math.floor(Math.random() * (255 - 1 + 1) + 1),
                b = Math.floor(Math.random() * (255 - 1 + 1) + 1)
            return `rgb(${r}, ${g}, ${b}, 0.6)`
        }

        // Grafico materias
        const camposGraficoMaterias = {!! json_encode($nombreMaterias, JSON_HEX_TAG) !!}
        const infoGraficoMaterias = {!! json_encode($estudiantesMateria, JSON_HEX_TAG) !!}

        // Grafico pnf
        const camposGraficoPNF = {!! json_encode($nombrePNF, JSON_HEX_TAG) !!}
        const infoGraficoPNF = {!! json_encode($estudiantesPNF, JSON_HEX_TAG) !!}
        const infoGraficoAnteriorPNF = {!! json_encode($estudiantesAnteriorPNF, JSON_HEX_TAG) !!}

        // Grafico trayecto
        const camposGraficoTrayecto = {!! json_encode($numeroTrayecto, JSON_HEX_TAG) !!}
        const infoGraficoTrayecto = {!! json_encode($estudiantesTrayecto, JSON_HEX_TAG) !!}
    </script>

    <script src="{{ asset('js/graficoMaterias.js') }}"></script>
    <script src="{{ asset('js/graficoPNF.js') }}"></script>
    <script src="{{ asset('js/graficoTrayecto.js') }}"></script>

    <script>
        @if ($message = session('sinDatos'))
            icon: 'info',
            title: '¡No se encontraron datos!',
            html: "La acreditable <b>{{ session('sinDatos') }}</b> no pertenece al periodo <b>{{ session('periodo') }}</b>, por favor intente con otra.",
            buttonsStyling: false,
            customClass: {
                confirmButton: 'btn btn-success px-5'
            }
        @elseif ($message = session('noEncontrado'))
            Swal.fire({
                icon: 'error',
                title: '¡El periodo o acreditable no existen!',
                html: 'La estadística que desea visualizar no puede ser cargada si no selecciona un periodo o acreditable.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                }
            })
        @endif
    </script>
@stop
