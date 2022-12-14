@extends('adminlte::page')

@section('title', 'Acreditables | Editar categoria')

@section('content_header')
    <div class="row">
        <div class="col-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('categoria.index') }}" class="link-muted">Categorias</a></li>
                <li class="breadcrumb-item active"><a href="">Editar</a></li>
            </ol>
        </div>

        <x-tipografia.periodo fase="{{ !empty($periodo->fase) ? $periodo->fase : '' }}"
            fecha="{{ !empty($periodo->inicio) ? explode('-', explode(' ', $periodo->inicio)[0])[0] : 'Sin asignar' }}" />
    </div>

    <x-tipografia.titulo>Categorías</x-tipografia.titulo>
@stop

@section('content')
    <div class="col-md-6 col-sm-12 mx-auto">
        <div class="card">
            <header class="card-header bg-primary">
                <h5>Editar categoria</h5>
            </header>

            <main class="card-body">
                <form action="{{ route('categoria.update', $categoria) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{ method_field('PUT') }}

                    {{-- Campo de nombre --}}
                    <div class="form-group required mb-3">
                        <label for="nom_categoria" class="control-label">Nombre</label>
                        <input type="text" name="nom_categoria"
                            class="form-control @error('nom_categoria') is-invalid @enderror"
                            value="{{ $categoria->nom_categoria }}"
                            placeholder="{{ __('Nombre de la categoria de curso') }}" autofocus required>

                        @error('nom_categoria')
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
                            <a href="{{ route('categoria.index') }}" class="btn btn-block btn-secondary">
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
