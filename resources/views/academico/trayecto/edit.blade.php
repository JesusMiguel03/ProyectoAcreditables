@extends('adminlte::page')

@section('title', 'Acreditables | Editar trayecto')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('trayectos.index') }}" class="link-muted">Trayectos</a></li>
    <li class="breadcrumb-item active"><a href="">Editar</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Trayectos</x-tipografia.titulo>
@stop

@section('content')
    <div class="col-md-6 col-sm-12 mx-auto">
        <div class="card">
            <header class="card-header bg-primary">
                <h5>Editar trayecto</h5>
            </header>

            <main class="card-body">
                <form action="{{ route('trayectos.update', $trayecto) }}" method="post">
                    @csrf
                    {{ method_field('PUT') }}

                    {{-- Campo de número --}}
                    <div class="form-group required mb-3">
                        <label for="num_trayecto" class="control-label">Trayecto Nro</label>
                        <div class="input-group">
                            <input type="number" name="num_trayecto" id="num_trayecto"
                                class="form-control @error('num_trayecto') is-invalid @enderror"
                                value="{{ __($trayecto->num_trayecto) }}" placeholder="{{ __('Número del trayecto') }}"
                                autofocus required>

                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-sort-numeric-down"></span>
                                </div>
                            </div>

                            @error('num_trayecto')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <x-modal.mensaje-obligatorio />

                    <x-modal.footer-editar ruta="{{ route('trayectos.index') }}" />
                </form>
            </main>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/required.css') }}">
@stop
