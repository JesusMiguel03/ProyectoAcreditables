@extends('adminlte::page')

@section('title', 'Acreditables | Noticias')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item active"><a href="">Noticias</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Noticias</x-tipografia.titulo>

    <div class="modal fade" id="registrar" tabindex="-1" role="dialog" aria-labelledby="camponoticia" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <header class="modal-header bg-primary">
                    <h5 class="modal-title" id="camponoticia">Nueva noticia</h5>
                </header>

                <main class="modal-body">
                    <div class="label-group mb-3">
                        <form action="{{ route('noticias.store') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            {{-- Encabezado --}}
                            <div class="form-group required mb-3">
                                <label for="encabezado" class="control-label">Encabezado</label>
                                <div class="input-group">
                                    <input type="text" name="encabezado" id="encabezado"
                                        class="form-control @error('encabezado') is-invalid @enderror"
                                        value="{{ old('encabezado') }}" placeholder="{{ __('Nombre de la noticia') }}"
                                        autofocus required>

                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-heading"></span>
                                        </div>
                                    </div>

                                    @error('encabezado')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Descripcion --}}
                            <div class="form-group required mb-3">
                                <label for="desc_noticia" class="control-label">Descripción</label>
                                <div class="input-group">
                                    <textarea name="desc_noticia" class="form-control @error('desc_noticia') is-invalid @enderror descripcion"
                                        placeholder="{{ __('Descripción') }}" required>{{ old('desc_noticia') }}</textarea>
    
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-comment"></span>
                                        </div>
                                    </div>
    
                                    @error('desc_noticia')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Mostrar noticia --}}
                            <div class="form-group required mb-3">
                                <label for="mostrar" class="control-label">¿Mostrar noticia?</label>
                                <div class="input-group">
                                    <select name="mostrar" class="form-control @error('mostrar') is-invalid @enderror">
                                        <option disabled>¿Desea mostrar la noticia?</option>
                                        <option value="1">Si</option>
                                        <option value="0">No</option>
                                    </select>

                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-eye"></span>
                                        </div>
                                    </div>
    
                                    @error('mostrar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Imagen (opcional) --}}
                            <div class="form-group mb-3">
                                <label for="imagen_noticia">Imagen</label>
                                <div class="input-group">
                                    <input type="file"
                                        class="custom-file-input @error('imagen_noticia') is-invalid @enderror"
                                        id="imagen" name="imagen_noticia" accept="image/jpeg">
                                    <label class="custom-file-label text-muted" for="imagen_noticia" id="campoImagen">
                                        Seleccione una imagen
                                    </label>
                                    <small id="ayudaImagen" class="form-text text-muted">
                                        La imagen debe pesar menos de 1 MB.
                                    </small>
                                </div>

                                @error('imagen_noticia')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Previsualizar imagen --}}
                            <div class="card" style="max-width: 540px">
                                <img src="" alt="" id="previsualizar" class="rounded">
                            </div>

                            <x-modal.mensaje-obligatorio />

                            <x-modal.footer-aceptar />
                        </form>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <x-formularios.borrar />
@stop

@section('content')
    <div class="card table-responsive-sm p-3 mt-1 mb-3 col-12">

        <div class="w-100 row mx-auto my-2">
            <p class="px-5 text-muted">
                <strong>Nota:</strong>
                El carrusel solo mostrará las primeras {{ config('variables.carrusel') }} noticias activas para no
                sobrecargar la vista del usuario, el resto de noticias estarán disponibles en la tabla pero no visibles.
            </p>
        </div>

        <div class="w-100 row mx-auto">
            <div class="col-md-2 col">
                <button class="btn btn-block btn-primary my-2" data-toggle="modal" data-target="#registrar"
                    {{ Popper::arrow()->pop('Nueva noticia') }}>
                    <i class="fas fa-plus mr-2"></i>
                    {{ 'Añadir' }}
                </button>
            </div>
        </div>

        <table id='tabla' class="table table-striped">
            <thead>
                <tr class="bg-secondary">
                    <th>Encabezado</th>
                    <th>Descripcion</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($noticias as $noticia)
                    <tr>
                        <td>{{ $noticia->encabezado }}</td>
                        <td style="max-width: 20vw">{{ $noticia->desc_noticia }}</td>
                        <td>{{ $noticia->mostrar === 0 ? 'Inactivo' : 'Activo' }}</td>
                        <td>
                            <div class="btn-group mx-1" role="group" aria-label="Acciones">
                                <a href="{{ route('noticias.edit', $noticia->id) }}" class="btn btn-primary"
                                    {{ Popper::arrow()->pop('Editar') }}>
                                    <i class="fas fa-edit"></i>
                                </a>

                                <button id="{{ $noticia->id }}" class="btn btn-danger borrar"
                                    {{ Popper::arrow()->pop('Borrar') }} data-type="Noticia"
                                    data-name="{{ $noticia->encabezado }}">
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
    <link rel="stylesheet" href="{{ asset('css/buscar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/descripcion.css') }}">
@stop

@section('js')
    @include('popper::assets')
    <script src="{{ asset('/vendor/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>

    {{-- Personalizados --}}
    <script src="{{ asset('js/tablas.js') }}"></script>
    <script src="{{ asset('js/previsualizacion.js') }}" defer></script>
    <script src="{{ asset('js/borrar.js') }}"></script>

    {{-- Mensajes --}}
    <script>
        @if ($message = session('creado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: 'Noticia registrado!',
                html: 'Una nueva noticia ha sido añadida.',
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
                html: 'La noticia ya se encuentra registrada.',
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
                html: 'La noticia ha sido actualizada.',
                confirmButtonColor: '#28a745',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('borrado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Noticia borrada exitosamente!',
                html: 'La noticia ha sido borrada.',
                confirmButtonColor: '#28a745',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('no encontrado'))
            let timerInterval
            Swal.fire({
                icon: 'error',
                title: '¡Noticia no encontrada!',
                html: 'La noticia que desea buscar o editar no se encuentra disponible.',
                confirmButtonColor: '#dc3545',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @endif
    </script>
@stop
