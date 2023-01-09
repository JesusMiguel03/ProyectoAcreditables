@extends('adminlte::page')

@section('title', 'Acreditables | Editar pnf')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('pnfs.index') }}" class="link-muted">PNF</a></li>
    <li class="breadcrumb-item active"><a href="">Editar</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>PNF</x-tipografia.titulo>
@stop

@section('content')
    <div class="col-md-6 col-sm-12 mx-auto">
        <div class="card">
            <header class="card-header bg-primary">
                <h5>Editar PNF</h5>
            </header>

            <main class="card-body">
                <form action="{{ route('pnfs.update', $pnf) }}" method="post">
                    @csrf
                    {{ method_field('PUT') }}

                    {{-- Nombre --}}
                    <div class="form-group required mb-3">
                        <label for="nom_pnf" class="control-label">Nombre</label>
                        <div class="input-group">
                            <input type="text" name="nom_pnf" id="nom_pnf"
                                class="form-control @error('nom_pnf') is-invalid @enderror"
                                value="{{ $pnf->nom_pnf }}" placeholder="{{ __('Nombre del pnf') }}" autofocus required>

                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-font"></span>
                                </div>
                            </div>

                            @error('nom_pnf')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- Código --}}
                    <div class="form-group mb-3">
                        <label for="cod_pnf">Código</label>
                        <div class="input-group">
                            <input type="text" name="cod_pnf" id="cod_pnf"
                                class="form-control @error('cod_pnf') is-invalid @enderror"
                                value="{{ $pnf->cod_pnf }}" placeholder="{{ __('Código del PNF') }}" autofocus>

                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-hashtag"></span>
                                </div>
                            </div>

                            @error('cod_pnf')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <x-modal.mensaje-obligatorio />

                    <x-modal.footer-editar ruta="{{ route('pnfs.index') }}" />
                </form>
            </main>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/required.css') }}">
@stop