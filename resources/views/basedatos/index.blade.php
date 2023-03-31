@extends('adminlte::page')

@section('title', 'Acreditables | Base de Datos')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item"><a href="">Seguridad de base de datos</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Base de Datos</x-tipografia.titulo>
@stop

@section('content')
    <div class="col-12 card table-responsive-sm p-3 my-3">

        <div class="w-100 row mx-auto">
            <div class="col-md-3 col-sm-12">
                <a href="{{ route('guardar-base-de-datos') }}" class="btn btn-block btn-success my-2">
                    <i class="fas fa-save mr-2"></i>
                    {{ 'Copia de seguridad' }}
                </a>
            </div>
        </div>

        <table id='tabla' class="table table-striped">
            <thead>
                <tr class="bg-secondary">
                    <th>Nombre del archivo</th>
                    <th>Fecha de creación</th>
                    <th>Peso</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($respaldos as $respaldo)
                    <tr>
                        <td>[Respaldo {{ $respaldo['indice'] }}] - {{ $respaldo['nombre'] }}</td>
                        <td>{{ $respaldo['fecha'] }}</td>
                        <td>{{ $respaldo['peso'] }}</td>
                        <td>
                            <div class="btn-group mx-1" role="group" aria-label="Acciones">
                                <a href="{{ route('descargar-base-de-datos', $respaldo['nombre']) }}"
                                    class="btn btn-success descargar" {{ Popper::arrow()->pop('Descargar respaldo') }}>
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop

@section('css')
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('vendor/sweetalert2/bootstrap-4.min.css') : asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('vendor/DataTables/datatables.min.css') : asset('vendor/DataTables/datatables.min.css') }}">

    {{-- Personalizados --}}
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('css/estilosVarios/required.css') : asset('css/estilosVarios/required.css') }}">
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('css/iconos/buscar.css') : asset('css/iconos/buscar.css') }}">
@stop

@section('js')
    @include('popper::assets')
    <script
        src="{{ request()->secure() ? secure_asset('vendor/sweetalert2/sweetalert2.min.js') : asset('vendor/sweetalert2/sweetalert2.min.js') }}">
    </script>
    <script
        src="{{ request()->secure() ? secure_asset('vendor/DataTables/datatables.min.js') : asset('vendor/DataTables/datatables.min.js') }}">
    </script>

    {{-- Personalizados --}}
    <script src="{{ request()->secure() ? secure_asset('js/tablas.js') : asset('js/tablas.js') }}"></script>
    <script src="{{ request()->secure() ? secure_asset('js/descargarAlerta.js') : asset('js/descargarAlerta.js') }}">
    </script>

    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: '¡Operación exitosa!',
                html: "{{ session('success') }}",
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif (session('error'))
            Swal.fire({
                icon: 'error',
                title: '¡Parece que hubo un problema!',
                html: "{{ session('error') }}",
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info px-5'
                },
            })
        @elseif (session('noExiste'))
            Swal.fire({
                icon: 'error',
                title: '¡No se pudo descargar!',
                html: "{{ session('noExiste') }}",
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info px-5'
                },
            })
        @elseif (session('importado'))
            Swal.fire({
                icon: 'success',
                title: '¡Base de datos restaurada!',
                html: "{{ session('importado') }}",
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif (session('noImportado'))
            Swal.fire({
                icon: 'error',
                title: '¡Hubo un problema con la importación!',
                html: "{{ session('noImportado') }}",
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info px-5'
                },
            })
        @elseif (session('noArchivo'))
            Swal.fire({
                icon: 'error',
                title: '¡Archivo no encontrado!',
                html: "{{ session('noArchivo') }}",
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info px-5'
                },
            })
        @elseif (session('descargado'))
            Swal.fire({
                icon: 'success',
                title: '¡Archivo no encontrado!',
                html: "{{ session('descargado') }}",
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @endif
    </script>
@stop
