@extends('adminlte::page')

@section('title', 'Acreditables | Editar noticia')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('noticias.index') }}" class="link-muted">Noticias</a></li>
    <li class="breadcrumb-item active"><a href="">Editar</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Noticias</x-tipografia.titulo>
@stop

@section('content')
    <div class="col-md-6 col-sm-12 mx-auto">
        <div class="card">
            <header class="card-header bg-primary">
                <h5>Editar noticia</h5>
            </header>

            <main class="card-body">
                <form action="{{ route('noticias.update', $noticia) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{ method_field('PUT') }}

                    {{-- Encabezado --}}
                    <div class="form-group required mb-3">
                        <label for="encabezado" class="control-label">Encabezado</label>
                        <div class="input-group">
                            <input type="text" name="encabezado"
                                class="form-control @error('encabezado') is-invalid @enderror"
                                value="{{ $noticia->encabezado }}" placeholder="{{ __('Encabezado') }}" autofocus required>

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
                            <textarea id="descripcion" name="desc_noticia"
                                class="form-control @error('desc_noticia') is-invalid @enderror descripcion" placeholder="{{ __('Descripción') }}"
                                spellcheck="false" required>{{ $noticia->desc_noticia }}</textarea>

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

                            <select name="mostrar" class="form-control">
                                <option disabled>¿Desea mostrar la noticia?</option>
                                <option value="1" {{ $noticia->mostrar === 1 ? 'selected' : '' }}>Si</option>
                                <option value="0" {{ $noticia->mostrar === 0 ? 'selected' : '' }}>No</option>
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

                    {{-- Campo de imagen (opcional) --}}
                    <div class="form-group mb-3">
                        <label for="imagen_noticia">Imágen</label>
                        <div class="input-group">
                            <input type="file" class="custom-file-input @error('imagen_noticia') is-invalid @enderror"
                                id="imagen" name="imagen_noticia" accept="image/jpeg">
                            <label class="custom-file-label text-muted" for="imagen_noticia"
                                id="campoImagen">Noticia.jpg</label>
                            <small id="imageHelp" class="form-text text-muted">
                                La imagen debe pesar menos de 1 MB.
                            </small>

                            @error('imagen_noticia')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- Previsualizacion de imagen --}}
                    <div class="mb-3 text-center">
                        @if ($noticia->imagen_noticia !== null)
                            <img src="{{ asset('storage/' . $noticia->imagen_noticia) }}" alt="" id="previsualizar"
                                class="rounded img-fluid">
                        @else
                            <img src="{{ asset('vendor/img/defecto/noticias.png') }}" alt="Imagen de materia por defecto"
                                id="previsualizar" class="rounded img-fluid">
                        @endif
                    </div>

                    <x-modal.mensaje-obligatorio />

                    <x-modal.footer-editar ruta="{{ route('noticias.index') }}" />
                </form>
            </main>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/required.css') }}">
    <link rel="stylesheet" href="{{ asset('css/buscar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/descripcion.css') }}">
@stop

@section('js')
    <script src="{{ asset('js/previsualizacion.js') }}"></script>
@stop
