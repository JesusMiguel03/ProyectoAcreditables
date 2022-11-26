@extends('adminlte::page')

@section('title', 'Acreditables | Editar especialidad')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Especialidad</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}">Inicio</a></li>
                <li class="breadcrumb-item active"><a href="">Especialidad</a></li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    {{-- Page content --}}
    <div class="container-fluid">

        <div class="card col-6 mx-auto p-4">
            <h2 class="card-header">Editar especialidad</h2>

            <div class="card-body">
                <form action="{{ route('especialidad.update', $especialidad) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{ method_field('PATCH') }}

                    {{-- Campo de nombre --}}
                    <div class="form-group mb-3">
                        <label for="nom_especialidad">Nombre</label>
                        <input type="text" name="nom_especialidad" class="form-control @error('nom_especialidad') is-invalid @enderror"
                            value="{{ $especialidad->nom_especialidad }}"
                            placeholder="{{ __('Nombre de la especialidad') }}" autofocus>

                        @error('nom_especialidad')
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
            </div>
        </div>

    </div>
@stop
