@extends('adminlte::page')

@section('title', 'Acreditables | Editar pregunta')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('preguntas.index') }}" class="link-muted">Preguntas frecuentes</a></li>
    <li class="breadcrumb-item active"><a href="">Editar</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Preguntas frecuentes</x-tipografia.titulo>
@stop

@section('content')
    <div class="col-md-6 col-sm-12 mx-auto">
        <div class="card">
            <header class="card-header bg-primary">
                <h5>Cambiar datos</h5>
            </header>

            <main class="card-body">
                <form action="{{ route('preguntas.update', $pregunta->id) }}" method="post">
                    @csrf
                    {{ method_field('PUT') }}

                    {{-- Pregunta --}}
                    <div class="form-group required mb-3">
                        <label for="titulo" class="control-label">Pregunta</label>
                        <div class="input-group">
                            <input type="text" name="titulo" id="titulo"
                                class="form-control @error('titulo') is-invalid @enderror" value="{{ $pregunta->titulo }}"
                                placeholder="{{ __('Titulo de la pregunta.') }}" autofocus required>

                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-question"></span>
                                </div>
                            </div>

                            @error('titulo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- Respuesta --}}
                    <div class="form-group required mb-3">
                        <label for="explicacion" class="control-label">Respuesta</label>
                        <div class="input-group">
                            <textarea name="explicacion" class="form-control @error('explicacion') is-invalid @enderror descripcion"
                                placeholder="{{ __('Explicacion de la pregunta.') }}" required>{{ $pregunta->explicacion }}</textarea>

                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-comment"></span>
                                </div>
                            </div>

                            @error('explicacion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <x-modal.mensaje-obligatorio />

                    <x-modal.footer-editar ruta="{{ route('preguntas.index') }}" />
                </form>
            </main>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/required.css') }}">
    <link rel="stylesheet" href="{{ asset('css/descripcion.css') }}">
@stop
