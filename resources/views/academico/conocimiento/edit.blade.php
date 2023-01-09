@extends('adminlte::page')

@section('title', 'Acreditables | Editar área de conocimiento')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('conocimientos.index') }}" class="link-muted">Áreas de
            conocimiento</a></li>
    <li class="breadcrumb-item active"><a href="">Editar área de conocimiento</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Áreas de conocimiento</x-tipografia.titulo>
@stop

@section('content')
    <div class="col-md-6 col-sm-12 mx-auto mt-3">
        <div class="card">
            <header class="card-header bg-primary">
                <h5>Editar área de conocimiento</h5>
            </header>

            <main class="card-body">
                <form action="{{ route('conocimientos.update', $conocimiento) }}" method="post">
                    @csrf
                    {{ method_field('PUT') }}

                    {{-- Nombre --}}
                    <div class="form-group required mb-3">
                        <label for="nom_conocimiento" class="control-label">Nombre</label>
                        <div class="input-group">
                            <input type="text" name="nom_conocimiento"
                                class="form-control @error('nom_conocimiento') is-invalid @enderror"
                                value="{{ $conocimiento->nom_conocimiento }}"
                                placeholder="{{ __('Nombre de la conocimiento') }}" autofocus required>

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

                    {{-- Descripcion --}}
                    <div class="form-group required mb-3">
                        <label for="desc_conocimiento" class="control-label">Descripción</label>
                        <div class="input-group">
                            <textarea name="desc_conocimiento" class="form-control @error('desc_conocimiento') is-invalid @enderror descripcion"
                                placeholder="{{ __('Descripción') }}" required>{{ $conocimiento->desc_conocimiento }}</textarea>

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

                    <x-modal.footer-editar ruta="{{ route('conocimientos.index') }}" />
                </form>
            </main>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/required.css') }}">
    <link rel="stylesheet" href="{{ asset('css/descripcion.css') }}">
@stop
