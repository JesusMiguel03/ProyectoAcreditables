@extends('adminlte::page')

@section('title', 'Acreditables | Editar especialidad')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Especialidad</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('especialidad.index') }}" class="link-muted">Especialidades</a></li>
                <li class="breadcrumb-item active"><a href="">Especialidad</a></li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="col-md-6 col-sm-12 mx-auto mt-3">
        <div class="card">
            <header class="card-header bg-primary">
                <h5>Editar especialidad</h5>
            </header>

            <main class="card-body">
                <form action="{{ route('especialidad.update', $especialidad) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    {{ method_field('PUT') }}

                    {{-- Campo de nombre --}}
                    <div class="form-group mb-3">
                        <label for="nom_especialidad">Nombre</label>
                        <input type="text" name="nom_especialidad"
                            class="form-control @error('nom_especialidad') is-invalid @enderror"
                            value="{{ $especialidad->nom_especialidad }}"
                            placeholder="{{ __('Nombre de la especialidad') }}" autofocus>

                        @error('nom_especialidad')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- Campo de descripción --}}
                    <div class="form-group mb-3">
                        <label for="desc_especialidad">Nombre</label>
                        <textarea name="desc_especialidad" class="form-control @error('desc_especialidad') is-invalid @enderror"
                            placeholder="{{ __('Descripción') }}" autofocus style="min-height: 9rem; resize: none">{{ $especialidad->desc_especialidad }}</textarea>

                        @error('desc_especialidad')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- Botón de registrar --}}
                    <div class="row">
                        <div class="col-6">
                            <a href="{{ route('especialidad.index') }}" class="btn btn-block btn-secondary">
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
