@extends('adminlte::page')

@section('title', 'Acreditables | Editar área de conocimiento')

@section('content_header')
    <div class="row">
        <div class="col-6">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('conocimiento.index') }}" class="link-muted">Áreas de
                        conocimiento</a></li>
                <li class="breadcrumb-item active"><a href="">Editar área</a></li>
            </ol>
        </div>
    </div>

    <x-tipografia.titulo>Áreas de conocimiento</x-tipografia.titulo>
@stop

@section('content')
    <div class="col-md-6 col-sm-12 mx-auto mt-3">
        <div class="card">
            <header class="card-header bg-primary">
                <h5>Editar área de conocimiento</h5>
            </header>

            <main class="card-body">
                <form action="{{ route('conocimiento.update', $especialidad) }}" method="post">
                    @csrf
                    {{ method_field('PUT') }}

                    {{-- Campo de nombre --}}
                    <div class="form-group required mb-3">
                        <label for="nom_especialidad" class="control-label">Nombre</label>
                        <input type="text" name="nom_especialidad"
                            class="form-control @error('nom_especialidad') is-invalid @enderror"
                            value="{{ $especialidad->nom_especialidad }}"
                            placeholder="{{ __('Nombre de la especialidad') }}" autofocus required>

                        @error('nom_especialidad')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- Campo de descripción --}}
                    <div class="form-group required mb-3">
                        <label for="desc_especialidad" class="control-label">Descripción</label>
                        <textarea name="desc_especialidad" class="form-control @error('desc_especialidad') is-invalid @enderror"
                            placeholder="{{ __('Descripción') }}" autofocus style="min-height: 9rem; resize: none" required>{{ $especialidad->desc_especialidad }}</textarea>

                        @error('desc_especialidad')
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
                            <a href="{{ route('conocimiento.index') }}" class="btn btn-block btn-secondary">
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
    <link rel="stylesheet" href="{{ asset('css/required.css') }}">
@stop
