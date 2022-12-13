@extends('adminlte::page')

@section('title', 'Acreditables | Editar pregunta')

@section('content_header')
    <div class="col-6">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('preguntas.index') }}" class="link-muted">Preguntas
                    frecuentes</a></li>
            <li class="breadcrumb-item active"><a href="">Editar</a></li>
        </ol>
    </div>

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

                    {{-- Campo de nombre --}}
                    <div class="form-group required mb-3">
                        <label for="titulo" class="control-label">Pregunta</label>
                        <input type="text" name="titulo" id="titulo"
                            class="form-control @error('titulo') is-invalid @enderror" value="{{ $pregunta->titulo }}"
                            placeholder="{{ __('Titulo de la pregunta sin signos') }}" autofocus required>

                        @error('titulo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- Campo de descripcion --}}
                    <div class="form-group required mb-3">
                        <label for="explicacion" class="control-label">Respuesta</label>
                        <textarea name="explicacion" class="form-control @error('explicacion') is-invalid @enderror"
                            placeholder="{{ __('Explicacion de la pregunta') }}" autofocus style="min-height: 9rem; resize: none" required>{{ $pregunta->explicacion }}</textarea>

                        @error('explicacion')
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

@section('css')
    <style>
        .form-group.required .control-label:after {
            color: #d00;
            content: "*";
            position: absolute;
            margin-left: 6px;
            margin-top: 3px;
        }
    </style>
@stop
