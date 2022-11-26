@extends('adminlte::page')

@section('title', 'Acreditables | Editar pnf')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">PNF</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}">Inicio</a></li>
                <li class="breadcrumb-item active"><a href="">Editar PNF</a></li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    {{-- Page content --}}
        <div class="container-fluid">

            <div class="card col-6 mx-auto p-4">
                <h2 class="card-header">Editar PNF</h2>

                <div class="card-body">
                    <form action="{{ route('pnf.update', $pnf) }}" method="post">
                        @csrf
                        {{ method_field('PUT') }}

                        {{-- Campo de nombre --}}
                        <div class="form-group mb-3">
                            <label for="nom_pnf">Nombre del PNF</label>
                            <input type="text" name="nom_pnf" id="nom_pnf"
                                class="form-control @error('nom_pnf') is-invalid @enderror"
                                value="{{ __($pnf->nom_pnf) }}" placeholder="{{ __('Nombre del pnf') }}" autofocus>

                            @error('nom_pnf')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
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
                </div>
            </div>

        </div>
@stop
