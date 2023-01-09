@extends('adminlte::page')

@section('title', 'Acreditables | Área de conocimiento')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item active"><a href="">Áreas de conocimiento</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Áreas de conocimiento</x-tipografia.titulo>

    <div class="modal fade" id="registrar" tabindex="-1" role="dialog" aria-labelledby="campoconocimiento" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <header class="modal-header bg-primary">
                    <h5 class="modal-title" id="campoconocimiento">Agregar área de conocimiento</h5>
                </header>

                <main class="modal-body">
                    <form action="{{ route('conocimientos.store') }}" method="POST">
                        @csrf

                        {{-- Nombre --}}
                        <div class="form-group required mb-3">
                            <label for="nom_conocimiento" class="control-label">Nombre</label>
                            <div class="input-group">
                                <input type="text" name="nom_conocimiento" id="nom_conocimiento"
                                    class="form-control @error('nom_conocimiento') is-invalid @enderror"
                                    value="{{ old('nom_conocimiento') }}" placeholder="{{ __('Nombre del área') }}"
                                    autofocus required>

                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-font"></span>
                                    </div>
                                </div>

                                @error('nom_conocimiento')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Campo de descripción --}}
                        <div class="form-group required mb-3">
                            <label for="desc_conocimiento" class="control-label">Descripción</label>
                            <div class="input-group">
                                <textarea name="desc_conocimiento" class="form-control @error('desc_conocimiento') is-invalid @enderror descripcion"
                                    placeholder="{{ __('Descripción') }}" required>{{ old('desc_conocimiento') }}</textarea>

                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-comment"></span>
                                    </div>
                                </div>

                                @error('desc_conocimiento')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <x-modal.mensaje-obligatorio />

                        <x-modal.footer-aceptar />
                    </form>
                </main>
            </div>
        </div>
    </div>

    <x-formularios.borrar />
@stop

@section('content')
    <div class="card table-responsive-sm p-3 mb-3">

        <div class="w-100 row mx-auto">
            <div class="col-md-2 col">
                <button class="btn btn-block btn-primary my-2" data-toggle="modal" data-target="#registrar"
                    {{ Popper::arrow()->pop('Nueva área de conocimiento') }}>
                    <i class="fas fa-plus mr-2"></i>
                    {{ 'Añadir' }}
                </button>
            </div>
        </div>

        <table id='tabla' class="table table-striped">
            <thead>
                <tr class="bg-secondary">
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($conocimientos as $conocimiento)
                    <tr>
                        <td>{{ $conocimiento->nom_conocimiento }}</td>
                        <td>{{ $conocimiento->desc_conocimiento }}</td>
                        <td>
                            <div class="btn-group mx-1" role="group" aria-label="Acciones">
                                <a href="{{ route('conocimientos.edit', $conocimiento->id) }}" class="btn btn-primary"
                                    {{ Popper::arrow()->pop('Editar') }}>
                                    <i class="fas fa-edit"></i>
                                </a>

                                <button id="{{ $conocimiento->id }}" class="btn btn-danger borrar"
                                    {{ Popper::arrow()->pop('Borrar') }} data-type="Área de conocimiento"
                                    data-name="{{ $conocimiento->nom_conocimiento }}">
                                    <i class="fas fa-trash"></i>
                                </button>
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
    <link rel="stylesheet" href="{{ asset('css/descripcion.css') }}">
@stop

@section('js')
    @include('popper::assets')
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('/vendor/DataTables/datatables.min.js') }}"></script>

    {{-- Personalizados --}}
    <script src="{{ asset('js/tablas.js') }}"></script>
    <script src="{{ asset('js/borrar.js') }}"></script>

    {{-- Mensajes --}}
    <script>
        @if ($message = session('creado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: 'Área de conocimiento registrado!',
                html: 'Un nuevo área de conocimiento ha sido añadida.',
                confirmButtonColor: '#28a745',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('error'))
            let timerInterval
            Swal.fire({
                icon: 'error',
                title: 'Error al registrar',
                html: 'Uno de los parámetros parece estar mal.',
                confirmButtonColor: '#dc3545',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
            $('#registrar').modal('show')
        @elseif ($message = session('registrado'))
            let timerInterval
            Swal.fire({
                icon: 'info',
                title: 'Ya fue registrado',
                html: 'El área de conocimiento ya se encuentra registrada.',
                confirmButtonColor: '#17a2b8',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('actualizado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Datos actualizados!',
                html: 'El área de conocimiento ha sido actualizada.',
                confirmButtonColor: '#28a745',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('borrado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Área de conocimento borrada exitosamente!',
                html: 'El área de conocimiento ha sido borrada.',
                confirmButtonColor: '#28a745',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('no encontrado'))
            let timerInterval
            Swal.fire({
                icon: 'error',
                title: '¡Área de conocimiento no encontrada!',
                html: 'El área de conocimiento que desea buscar o editar no se encuentra disponible.',
                confirmButtonColor: '#dc3545',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @endif
    </script>
@stop
