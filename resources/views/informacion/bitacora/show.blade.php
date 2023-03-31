@extends('adminlte::page')

@section('title', 'Acreditables | Bitacora')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('bitacora') }}" class="link-muted">Bitácora</a></li>
    <li class="breadcrumb-item active"><a href="">Periodo {{ $periodoSeleccionado->formato() }}</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Historial de registros</x-tipografia.titulo>
@stop

@section('content')
    <div class="col-12 card table-responsive-sm p-3 my-3">

        <div class="col-9 mb-4">
            <form id="form" action="" method="get">
                <div class="form-row">
                    <label for="periodo">Periodo</label>
                </div>

                <div class="form-row">
                    <div class="col">
                        <select id="periodo" name="perido" class="form-control">
                            <option value="0" readonly>Seleccione uno...</option>

                            @foreach ($periodos as $periodo)
                                <option value="{{ $periodo->id }}"
                                    {{ $periodoSeleccionado->id === $periodo->id ? 'selected' : '' }}>
                                    {{ $periodo->formato() }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col">
                        <button id="enviar" class="btn btn-block btn-primary" disabled>Buscar</button>
                    </div>

                    <div class="col">
                        <a href="{{ route('bitacora') }}" class="btn btn-block btn-primary">Mostrar todos</a>
                    </div>
                </div>

            </form>
        </div>

        @php
            $estados = [
                // 'success' => '✔',
                // 'warning' => '⚠',
                // 'danger' => '❌',
                // 'info' => '❔',
                'success' => 'Exitoso',
                'warning' => 'Alerta',
                'danger' => 'Error',
                'info' => 'Informativo',
            ];
        @endphp

        <table id='tabla' class="table table-striped">
            <thead>
                <tr class="bg-secondary">
                    <th>Estado</th>
                    <th>Usuario</th>
                    <th>Acción</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bitacoras as $bitacora)
                    <tr>
                        <td style="width: 5%" class="text-{{ $bitacora->estado }} font-weight-bold">
                            {{ $estados[$bitacora->estado] }}</td>
                        <td style="width: 20%">{{ $bitacora->usuario }}</td>
                        <td>{{ $bitacora->accion }}</td>
                        <td style="width: 25%">
                            {{ \Carbon\Carbon::parse($bitacora->created_at)->format('[d-m-Y] (H:i:s a)') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('/vendor/DataTables/datatables.min.css') }}">
@stop

@section('js')
    <script src="{{ asset('/vendor/DataTables/datatables.min.js') }}"></script>

    {{-- Personalizados --}}
    <script src="{{ asset('js/tablas.js') }}"></script>

    {{-- Validaciones --}}
    <script>
        const inputPeriodos = document.getElementById('periodo');
        const boton = document.getElementById('enviar')
        const form = document.getElementById('form')

        const url = "{{ route('bitacora.show') }}"

        let periodo = inputPeriodos.options[inputPeriodos.selectedIndex].value || 0;
        const periodoSeleccionado = inputPeriodos.options[inputPeriodos.selectedIndex].value

        // Cuando se selecciona un periodo x
        inputPeriodos.addEventListener('change', (e) => {
            periodo = e.currentTarget.options[inputPeriodos.selectedIndex].value;

            // Si es valido o mayor a 0 se puede buscar
            periodo > 0 && periodo !== periodoSeleccionado ?
                boton.removeAttribute('disabled') :
                boton.disabled = true
        });

        form.addEventListener('submit', (e) => {
            e.preventDefault()

            // Si el periodo es mayor a 0 busca el historial por periodo
            if (periodo > 0 && periodo !== periodoSeleccionado) {
                form.action = `${url}/${periodo}`
                form.submit()
            }
        })
    </script>
@stop
