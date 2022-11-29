@extends('adminlte::page')

@section('title', 'Acreditables | Editar pregunta')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Preguntas frecuentes</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('preguntas.index') }}" class="link-muted">Preguntas
                        frecuentes</a></li>
                <li class="breadcrumb-item active"><a href="">Editar pregunta</a></li>
            </ol>
        </div>
    </div>
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
    
                    {{-- Campo de nombre --}}
                    <div class="form-group mb-3">
                        <label for="titulo">Pregunta</label>
                        <input type="text" name="titulo" id="titulo"
                            class="form-control @error('titulo') is-invalid @enderror" value="{{ $pregunta->titulo }}"
                            placeholder="{{ __('Titulo de la pregunta sin signos') }}" autofocus>
    
                        @error('titulo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
    
                    {{-- Campo de descripcion --}}
                    <div class="form-group mb-3">
                        <label for="explicacion">Respuesta</label>
                        <textarea name="explicacion" class="form-control @error('explicacion') is-invalid @enderror"
                            placeholder="{{ __('Explicacion de la pregunta') }}" autofocus style="min-height: 9rem; resize: none">{{ $pregunta->explicacion }}</textarea>
    
                        @error('explicacion')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
    
                    {{-- Botón de registrar --}}
                    <div class="row">
                        <div class="col-6">
                            <a href="{{ route('preguntas.index') }}" class="btn btn-block btn-secondary">
                                <i class="fas fa-arrow-left mr-2"></i>
                                {{ __('Volver') }}
                            </a>
                        </div>
    
                        <x-botones.guardar />
                    </div>
    
                </form>
            </main>
        </div>
    </div>
@stop
