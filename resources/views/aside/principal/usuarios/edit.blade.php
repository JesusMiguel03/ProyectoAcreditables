@extends('adminlte::page')

@section('title', 'Acreditables | Editar estudiante')

@section('content_header')
    <div class="col-6">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('coordinador.usuarios.index') }}" class="link-muted">
                    Estudiantes</a>
            </li>
            <li class="breadcrumb-item active"><a href="">{{ $usuario->nombre }} {{ $usuario->apellido }}</a></li>
        </ol>
    </div>

    <x-tipografia.titulo>Listado de estudiantes</x-tipografia.titulo>
@stop

@section('content')
    <div class="col-6 mx-auto">
        <section class="card">
            <header class="card-header bg-primary">
                <h5>Editar credenciales</h5>
            </header>

            <main class="card-body">
                <div class="form-group mb-3">
                    <label>Nombre</label>
                    <input type="text" class="form-control" placeholder="{{ $usuario->nombre }} {{ $usuario->apellido }}"
                        disabled></input>
                </div>

                <div class="form-group mb-3">
                    <label>Cédula</label>
                    <input type="text" class="form-control"
                        placeholder="{{ 'V-' . number_format($usuario->cedula, 0, ',', '.') }}" disabled></input>
                </div>


                <form action="{{ route('coordinador.usuarios.update', $usuario->id) }}" method="post">
                    @csrf
                    {{ method_field('PUT') }}

                    <div class="form-group mb-3">
                        <label>Trayecto</label>
                        <select name="trayecto" class="form-control">
                            <option>Seleccione uno</option>
                            @foreach ($trayectos as $trayecto)
                                <option value="{{ $trayecto->id }}"
                                    {{ !empty($usuario->estudiante) && $usuario->estudiante->trayecto_id === $trayecto->id ? 'selected' : '' }}>
                                    {{ $trayecto->num_trayecto }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>PNF</label>
                        <select name="pnf" class="form-control">
                            <option>Seleccione uno</option>
                            @foreach ($pnfs as $pnf)
                                @if (!in_array($pnf->nom_pnf, $pnfsNoDisponibles))
                                    <option value="{{ $pnf->id }}"
                                        {{ !empty($usuario->estudiante) && $usuario->estudiante->pnf_id === $pnf->id ? 'selected' : '' }}>
                                        {{ $pnf->nom_pnf }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group" style="margin-bottom: -10px">
                        <p class="pl-2 text-danger"><strong>Nota:</strong> (*) Indica los campos que
                            son obligatorios.
                        </p>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <a href="{{ route('coordinador.usuarios.index') }}" class="btn btn-block btn-secondary">
                                <i class="fas fa-arrow-left mr-2"></i>
                                {{ __('Volver') }}
                            </a>
                        </div>

                        <x-botones.guardar />
                    </div>
                </form>
            </main>
        </section>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/required.css') }}">
@stop
