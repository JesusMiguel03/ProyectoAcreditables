@extends('adminlte::page')

@section('title', 'Acreditables | Editar categoria')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Coordinación de Acreditables</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}">Inicio</a></li>
                <li class="breadcrumb-item active"><a href="">Categoria</a></li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    {{-- Page content --}}
    <div class="container-fluid">

        <div class="card col-6 mx-auto p-4">
            <h2 class="card-header">Editar categoria</h2>

            <div class="card-body">
                <form action="{{ route('categoria.update', $categoria) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{ method_field('PATCH') }}

                    {{-- Campo de nombre --}}
                    <div class="input-group mb-3">
                        <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                            value="{{ $categoria->nom_categoria }}"
                            placeholder="{{ __('Nombre de la categoria de curso') }}" autofocus>

                        @error('nombre')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
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
            </div>
        </div>

    </div>
@stop
