@extends('adminlte::page')

@section('title', 'Acreditables | Categoria')

@section('content_header')
    <div class="row mb-2">
        <div class="col-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
                <li class="breadcrumb-item active"><a href="">Categorias</a></li>
            </ol>
        </div>

        <x-tipografia.periodo fase="{{ !empty($periodo->fase) ? $periodo->fase : '' }}"
            fecha="{{ !empty($periodo->inicio) ? explode('-', explode(' ', $periodo->inicio)[0])[0] : 'Sin asignar' }}" />

        <div class="col-4">
            <div class="card float-right">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#categoria">
                    <i class="fas fa-plus mr-2"></i>
                    {{ __('Añadir categoria') }}
                </button>
            </div>

            {{-- Modal para crear --}}
            <div class="modal fade" id="categoria" tabindex="-1" role="dialog" aria-labelledby="campoCategoria"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <header class="modal-header bg-primary">
                            <h5 class="modal-title" id="campoCategoria">Agregar categoria</h5>
                        </header>
                        <main class="modal-body">
                            <form action="{{ route('categoria.store') }}" method="post">
                                @csrf

                                {{-- Campo de nombre --}}
                                <div class="form-group required mb-3">
                                    <label for="nom_categoria" class="control-label">Nombre</label>
                                    <input type="text" name="nom_categoria" id="nom_categoria"
                                        class="form-control @error('nom_categoria') is-invalid @enderror"
                                        value="{{ old('nom_categoria') }}" placeholder="{{ __('Nombre de la categoria') }}"
                                        autofocus required>

                                    @error('nom_categoria')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group" style="margin-bottom: -10px">
                                    <p class="pl-2 text-danger"><strong>Nota:</strong> (*) Indica los campos que
                                        son obligatorios.
                                    </p>
                                </div>

                                {{-- Botón de registrar --}}
                                <div class="row">
                                    <x-botones.cancelar />

                                    <x-botones.guardar />
                                </div>

                            </form>
                        </main>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-tipografia.titulo>Categorías</x-tipografia.titulo>
@stop

@section('content')
    <div class="card col-12 table-responsive-sm p-3 mt-1 mb-3">
        <table id='tabla' class="table table-striped">
            <thead>
                <tr class="bg-secondary">
                    <th>Nombre</th>
                    <th>Opciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($categorias as $categoria)
                    <tr>
                        <td>{{ $categoria->nom_categoria }}</td>
                        <td>
                            <a href="{{ route('categoria.edit', $categoria->id) }}" class="btn btn-primary"
                                {{ Popper::arrow()->pop('Editar') }}>
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('/vendor/DataTables/datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/required.css') }}">
@stop

@section('js')
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('vendor/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('/js/tablas.js') }}"></script>
    <script>
        @if ($message = session('creado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Categoria registrada!',
                html: 'Ahora la categoria se encuentra disponible.',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('existente'))
            let timerInterval
            Swal.fire({
                icon: 'error',
                title: '¡Categoria existente!',
                html: 'La categoria a añadir ya se encuentra registrada.',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('actualizado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡La categoria se ha actualizado!',
                html: 'La categoria se puede encontrar con el nuevo nombre.',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('error'))
            let timerInterval
            Swal.fire({
                icon: 'error',
                title: '¡Hubo un problema!',
                html: 'Parece que uno de los campos no cumple los requisitos.',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @endif
    </script>
@stop
