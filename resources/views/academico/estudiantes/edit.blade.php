@extends('adminlte::page')

@section('title', 'Acreditables | Editar estudiante')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('estudiantes.index') }}" class="link-muted">
            Estudiantes</a>
    </li>
    <li class="breadcrumb-item active"><a href="">{{ $usuario->nombre }} {{ $usuario->apellido }}</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Listado de estudiantes</x-tipografia.titulo>
@stop

@section('content')
    <div class="col-md-6 col-sm-12 mx-auto">
        <section class="card">
            <header class="card-header bg-primary">
                <h5>Editar credenciales</h5>
            </header>

            <main class="card-body">
                {{-- Nombre --}}
                <div class="form-group mb-3">
                    <label>Nombre</label>
                    <div class="input-group">
                        <input type="text" class="form-control"
                            placeholder="{{ $usuario->nombre }} {{ $usuario->apellido }}" disabled>

                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Cedula --}}
                <div class="form-group mb-3">
                    <label>Cédula</label>
                    <div class="input-group">
                        <input type="text" class="form-control"
                            placeholder="{{ 'V-' . number_format($usuario->cedula, 0, ',', '.') }}" disabled>

                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-id-card"></span>
                            </div>
                        </div>
                    </div>
                </div>


                <form action="{{ route('estudiantes.update', $usuario->id) }}" method="post">
                    @csrf
                    {{ method_field('PUT') }}

                    <div class="form-group mb-3">
                        <label>Trayecto</label>
                        <div class="input-group">
                            <select name="trayecto" class="form-control">
                                <option>Seleccione uno</option>
                                @foreach ($trayectos as $trayecto)
                                    <option value="{{ $trayecto->id }}"
                                        {{ !empty($usuario->estudiante) && $usuario->estudiante->trayecto_id === $trayecto->id ? 'selected' : '' }}>
                                        {{ $trayecto->num_trayecto }}</option>
                                @endforeach
                            </select>

                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-bookmark"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label>PNF</label>
                        <div class="input-group">
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

                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-book"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <x-modal.mensaje-obligatorio />

                    <x-modal.footer-editar ruta="{{ route('estudiantes.index') }}" />
                </form>
            </main>
        </section>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/required.css') }}">
@stop
