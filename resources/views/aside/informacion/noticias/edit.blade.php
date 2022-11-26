@extends('adminlte::page')

@section('title', 'Acreditables | Editar noticia')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Noticias</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}">Inicio</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('noticias.index') }}">Noticias</a></li>
                <li class="breadcrumb-item active"><a href="">Editar noticia</a></li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    {{-- Page content --}}
    <div class="container-fluid">

        <div class="card col-md-6 col-sm-12 mx-auto p-4">
            <h2 class="card-header">Editar noticia</h2>

            <div class="card-body">
                <form action="{{ route('noticias.update', $noticia) }}" method="post">
                    @csrf
                    {{ method_field('PATCH') }}

                    {{-- Campo de nombre --}}
                    <div class="form-group mb-3">
                        <label for="encabezado">Encabezado</label>
                        <input type="text" name="encabezado" id="encabezado"
                            class="form-control @error('encabezado') is-invalid @enderror"
                            value="{{ $noticia->encabezado }}" placeholder="{{ __('Encabezado') }}" autofocus>

                        @error('encabezado')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- Campo de descripcion --}}
                    <div class="form-group mb-3">
                        <label for="desc_noticia">Descripción</label>
                        <textarea name="desc_noticia" class="form-control @error('desc_noticia') is-invalid @enderror"
                            placeholder="{{ __('Descripción') }}" autofocus spellcheck="false" style="min-height: 9rem; resize: none">{{ $noticia->desc_noticia }}</textarea>

                        @error('desc_noticia')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- Campo para mostrar o no la noticia --}}
                    <div class="form-group mb-3">
                        <label for="mostrar">¿Mostrar noticia?</label>
                        <select name="mostrar" class="form-control">
                            <option>¿Desea mostrar la noticia?</option>
                            <option value="1" {{ $noticia->mostrar === 1 ? 'selected' : '' }}>Si</option>
                            <option value="0" {{ $noticia->mostrar === 0 ? 'selected' : '' }}>No</option>
                        </select>

                        @error('mostrar')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- Botón de registrar --}}
                    <div class="row">
                        <div class="col-6">
                            <a href="{{ route('noticias.index') }}" class="btn btn-block btn-secondary">
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
