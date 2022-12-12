@extends('adminlte::page')

@section('title', 'Acreditables | Editar trayecto')

@section('content_header')
    <x-tipografia.titulo>Trayectos</x-tipografia.titulo>

    <div class="col-6">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('trayecto.index') }}" class="link-muted">Trayectos</a></li>
            <li class="breadcrumb-item active"><a href="">Editar</a></li>
        </ol>
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
                    <div class="form-group required mb-3">
                        <label for="num_trayecto" class="control-label">Trayecto Nro</label>
                        <input type="number" name="num_trayecto" id="num_trayecto"
                            class="form-control @error('num_trayecto') is-invalid @enderror"
                            value="{{ __($trayecto->num_trayecto) }}" placeholder="{{ __('Número del trayecto') }}"
                            autofocus required>

                        @error('num_trayecto')
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
