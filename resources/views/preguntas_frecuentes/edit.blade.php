@extends('adminlte::page')

@section('title', 'Acreditables | Editar pregunta')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Coordinación de Acreditables</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}">Inicio</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('preguntas.index') }}">Preguntas frecuentes</a></li>
                <li class="breadcrumb-item active"><a href="">Editar pregunta</a></li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    {{-- Page content --}}
    <section class="content">
        <div class="container-fluid">

            <div class="card col-md-6 col-sm-12 mx-auto p-4">
                <h2 class="card-header">Cambiar datos</h2>

                <div class="card-body">
                    <form action="{{ route('preguntas.update', $pregunta->id) }}" method="post">
                        @csrf
                        {{ method_field('PATCH') }}

                        {{-- Campo de nombre --}}
                        <div class="input-group mb-3">
                            <input type="text" name="titulo" id="titulo"
                                class="form-control @error('titulo') is-invalid @enderror"
                                value="{{ $pregunta->titulo }}"
                                placeholder="{{ __('Titulo de la pregunta sin signos') }}" autofocus>

                            @error('titulo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Campo de nombre --}}
                        <div class="input-group mb-3">
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
                                    {{ __('Volver') }}
                                </a>
                            </div>
                            <div class="col-6">
                                <button type=submit class="btn btn-block btn-success">
                                    {{ __('Guardar cambio') }}
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </section>
@stop
