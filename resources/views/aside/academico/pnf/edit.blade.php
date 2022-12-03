@extends('adminlte::page')

@section('title', 'Acreditables | Editar pnf')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
                <li class="breadcrumb-item"><a href="" class="link-muted">PNF</a></li>
                <li class="breadcrumb-item active"><a href="">Editar PNF</a></li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="col-md-6 col-sm-12 mx-auto">
        <div class="card">
            <header class="card-header bg-primary">
                <h5>Editar PNF</h5>
            </header>

            <main class="card-body">
                <form action="{{ route('pnf.update', $pnf) }}" method="post">
                    @csrf
                    {{ method_field('PUT') }}

                    {{-- Campo de nombre --}}
                    <div class="form-group required mb-3">
                        <label for="nom_pnf" class="control-label">Nombre</label>
                        <input type="text" name="nom_pnf" id="nom_pnf"
                            class="form-control @error('nom_pnf') is-invalid @enderror" value="{{ $pnf->nom_pnf }}"
                            placeholder="{{ __('Nombre del pnf') }}" autofocus required>

                        @error('nom_pnf')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- Código --}}
                    <div class="form-group mb-3">
                        <label for="cod_pnf">Código</label>
                        <input type="text" name="cod_pnf" id="cod_pnf"
                            class="form-control @error('cod_pnf') is-invalid @enderror"
                            value="{{ $pnf->cod_pnf }}" placeholder="{{ __('Código del PNF') }}"
                            autofocus>

                        @error('cod_pnf')
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
                            <a href="{{ route('pnf.index') }}" class="btn btn-block btn-secondary">
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
