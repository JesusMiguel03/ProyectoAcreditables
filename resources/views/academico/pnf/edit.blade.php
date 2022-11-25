@extends('adminlte::page')

@section('title', 'Acreditables | Editar pnf')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Coordinación de Acreditables</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}">Inicio</a></li>
                <li class="breadcrumb-item active"><a href="">Editar pnf</a></li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    {{-- Page content --}}
    <section class="content">
        <div class="container-fluid">

            <div class="card col-6 mx-auto p-4">
                <h2 class="card-header">Editar pnf</h2>

                <div class="card-body">
                    <form action="{{ route('pnf.update', $pnf) }}" method="post">
                        @csrf
                        {{ method_field('PATCH') }}

                        {{-- Campo de nombre --}}
                        <div class="form-group mb-3">
                            <input type="text" name="nombre" id="nombre"
                                class="form-control @error('nombre') is-invalid @enderror"
                                value="{{ __($pnf->nombre) }}" placeholder="{{ __('Número del pnf') }}" autofocus>

                            @error('nombre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Botón de registrar --}}
                        <div class="row">
                            <div class="col-6">
                                <a href="{{ route('pnf.index') }}" class="btn btn-block btn-secondary">
                                    {{ __('Volver') }}
                                </a>
                            </div>
                            <div class="col-6">
                                <button type=submit class="btn btn-block btn-primary">
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
