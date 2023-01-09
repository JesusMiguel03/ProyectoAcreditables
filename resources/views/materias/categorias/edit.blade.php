@extends('adminlte::page')

@section('title', 'Acreditables | Editar categoria')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('categorias.index') }}" class="link-muted">Categorias</a></li>
    <li class="breadcrumb-item active"><a href="">Editar</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Categorías</x-tipografia.titulo>
@stop

@section('content')
    <div class="col-md-6 col-sm-12 mx-auto">
        <div class="card">
            <header class="card-header bg-primary">
                <h5>Editar categoria</h5>
            </header>

            <main class="card-body">
                <form action="{{ route('categorias.update', $categoria) }}" method="post">
                    @csrf
                    {{ method_field('PUT') }}

                    {{-- Nombre --}}
                    <div class="form-group required mb-3">
                        <label for="nom_categoria" class="control-label">Nombre</label>
                        <div class="input-group">
                            <input type="text" name="nom_categoria"
                                class="form-control @error('nom_categoria') is-invalid @enderror"
                                value="{{ $categoria->nom_categoria }}"
                                placeholder="{{ __('Nombre de la categoria de curso') }}" autofocus required>

                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-font"></span>
                                </div>
                            </div>

                            @error('nom_categoria')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <x-modal.mensaje-obligatorio />

                    <x-modal.footer-editar ruta="{{ route('categorias.index') }}" />
                </form>
            </main>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/required.css') }}">
@stop