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
    <div class="modal fade" id="registrar" tabindex="-1" role="dialog" aria-labelledby="camponoticia" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <header class="modal-header bg-primary">
                    <h5 class="modal-title" id="camponoticia">Importar archivo SQL</h5>
                </header>

                <form action="{{ route('importar-base-de-datos') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <main class="modal-body">
                        <div class="label-group mb-3">

                            <div class="form-group required mb-3">
                                <label class="control-label" for="archivo">Archivo</label>

                                <div class="input-group">
                                    <input type="file" class="custom-file-input @error('archivo') is-invalid @enderror"
                                        id="archivo" name="archivo" accept=".sql" required>

                                    <label class="custom-file-label text-muted" for="archivo" id="campoArchivo">
                                        Seleccione el respaldo
                                    </label>
                                </div>

                                @error('archivo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <section class="row">
                            <div class="col-6">
                                <button type="submit" class="btn btn-block btn-primary">
                                    <i class="fas fa-upload mr-2"></i>
                                    Cargar
                                </button>
                            </div>

                            <div class="col-6">
                                <button type="button" class="btn btn-block btn-secondary" data-dismiss="modal">
                                    <i class="fas fa-arrow-left mr-2"></i>
                                    Cancelar
                                </button>
                            </div>
                        </section>
                    </main>
                </form>
            </div>
        </div>
    </div>

    <div class="col-12 card table-responsive-sm p-3 my-3">

        <div class="w-100 row mx-auto">
            <div class="col-md-3 col-sm-12">
                <a href="{{ route('guardar-base-de-datos') }}" class="btn btn-block btn-success my-2">
                    <i class="fas fa-save mr-2"></i>
                    {{ 'Copia de seguridad' }}
                </a>
            </div>

            <div class="col-md-3 col-sm-12">
                <button class="btn btn-block btn-info my-2" data-toggle="modal" data-target="#registrar">
                    <i class="fas fa-upload mr-2"></i>
                    {{ 'Importar respaldo' }}
                </button>
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
                                    class="btn btn-success" {{ Popper::arrow()->pop('Descargar respaldo') }}>
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
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/DataTables/datatables.min.css') }}">

    {{-- Personalizados --}}
    <link rel="stylesheet" href="{{ asset('css/required.css') }}">
    <link rel="stylesheet" href="{{ asset('css/etiquetaBuscar.css') }}">
@stop

@section('js')
    @include('popper::assets')
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('/vendor/DataTables/datatables.min.js') }}"></script>

    {{-- Personalizados --}}
    <script src="{{ asset('js/tablas.js') }}"></script>
    <script src="{{ asset('js/mostrarNombreArchivo.js') }}"></script>

    <script>
        @if ($message = session('success'))
            Swal.fire({
                icon: 'success',
                title: '¡Operación exitosa!',
                html: "{{ session('success') }}",
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('error'))
            Swal.fire({
                icon: 'error',
                title: '¡Parece que hubo un problema!',
                html: "{{ session('error') }}",
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info px-5'
                },
            })
        @elseif ($message = session('noExiste'))
            Swal.fire({
                icon: 'error',
                title: '¡No se pudo descargar!',
                html: "{{ session('noExiste') }}",
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info px-5'
                },
            })
        @elseif ($message = session('importado'))
            Swal.fire({
                icon: 'success',
                title: '¡Base de datos restaurada!',
                html: "{{ session('importado') }}",
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('noImportado'))
            Swal.fire({
                icon: 'error',
                title: '¡Hubo un problema con la importación!',
                html: "{{ session('noImportado') }}",
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info px-5'
                },
            })
        @elseif ($message = session('noArchivo'))
            Swal.fire({
                icon: 'error',
                title: '¡Archivo no encontrado!',
                html: "{{ session('noArchivo') }}",
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info px-5'
                },
            })
        @endif
    </script>
@stop
