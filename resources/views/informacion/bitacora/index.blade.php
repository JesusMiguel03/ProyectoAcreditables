@extends('adminlte::page')

@section('title', 'Acreditables | Bitacora')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item active"><a href="">Bitácora</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Historial de registros</x-tipografia.titulo>
@stop

@section('content')
    <div class="col-12 card table-responsive-sm p-3 my-3">

        @php
            $estados = [
                'success' => 'Exitoso',
                'warning' => 'Alerta',
                'danger' => 'Error',
                'info' => 'Informativo',
            ];
        @endphp

        <table id='tabla' class="table table-striped">
            <thead>
                <tr class="bg-secondary">
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Usuario</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bitacoras as $bitacora)
                    <tr>
                        <td style="width: 25%">
                            {{ \Carbon\Carbon::parse($bitacora->created_at)->format('[d-m-Y] (H:i:s a)') }}</td>
                        <td class="text-{{ $bitacora->estado }} font-weight-bold">{{ $estados[$bitacora->estado] }}</td>
                        <td>{{ $bitacora->usuario }}</td>
                        <td>{{ $bitacora->accion }}</td>
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
@stop
