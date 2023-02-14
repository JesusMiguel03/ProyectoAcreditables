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
    <div class="row">
        <section class="col-md-6 col-sm-12 mx-auto">

            <div class="form-group mb-3 card p-3">
                <div class="row">

                    {{-- Activo --}}
                    <main class="col-12">
                        <label for="periodo" class="control-label">Periodos</label>
                        <div class="input-group">

                            <select id="periodo" class="form-control @error('periodo') is-invalid @enderror"
                                name="periodo">
                                <option value="0" readonly>Seleccione...</option>

                                @foreach ($periodos as $periodo)
                                    <option value="{{ $periodo->id }}"
                                        {{ $periodo->id === $periodoActual->id ? 'selected' : '' }}>
                                        {{ $conversor[$periodo->fase] . '-' . \Carbon\Carbon::parse($periodo->inicio)->format('Y') }}
                                    </option>
                                @endforeach
                            </select>

                            @error('periodo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <p class="mt-3 text-center font-weight-bold">{{ $periodoFormateado }}</p>
                    </main>

                    <footer class="mt-3 mx-auto col-md-4 col-sm-12">
                        <a id="btnPeriodo" class="btn btn-block btn-success">
                            <i class="fas fa-search mr-2"></i>
                            {{ __('Buscar') }}
                        </a>
                    </footer>

                </div>
            </div>
        </section>
    </div>

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
@stop

@section('js')
    <script src="{{ asset('vendor/chartjs/chart.js') }}"></script>

    {{-- Personalizados --}}
    <script>
        const inputPeriodo = document.getElementById('periodo')
        const form = document.getElementById('form')
        const btn = document.getElementById('btnPeriodo')

        let periodo = 0

        inputPeriodo.addEventListener('change', (e) => {
            periodo = e.currentTarget.options[e.currentTarget.selectedIndex].value

            if (periodo == 0) {
                btn.classList.add('disabled')
            } else {
                btn.classList.remove('disabled')
            }
        })

        btn.addEventListener('click', (e) => {
            e.currentTarget.href = `${"{{ route('estadisticas.show') }}"}/${periodo}`
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
@stop
