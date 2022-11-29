@extends('adminlte::page')

@section('title', 'Acreditables | Editar trayecto')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Trayecto</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('trayecto.index') }}" class="link-muted">Trayectos</a></li>
                <li class="breadcrumb-item active"><a href="">Editar trayecto</a></li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="col-md-6 col-sm-12 mx-auto">
        <div class="card">
            <header class="card-header bg-primary">
                <h5>Editar trayecto</h5>
            </header>

            <main class="card-body">
                <form action="{{ route('trayecto.update', $trayecto) }}" method="post">
                    @csrf
                    {{ method_field('PUT') }}

                    {{-- Campo de número --}}
                    <div class="form-group mb-3">
                        <label for="num_trayecto">Trayecto Nro</label>
                        <input type="number" name="num_trayecto" id="num_trayecto"
                            class="form-control @error('num_trayecto') is-invalid @enderror"
                            value="{{ __($trayecto->num_trayecto) }}" placeholder="{{ __('Número del trayecto') }}"
                            autofocus>

                        @error('num_trayecto')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- Botón de registrar --}}
                    <div class="row">
                        <div class="col-6">
                            <a href="{{ route('trayecto.index') }}" class="btn btn-block btn-secondary">
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
