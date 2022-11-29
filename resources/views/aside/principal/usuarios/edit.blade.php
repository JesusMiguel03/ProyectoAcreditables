@extends('adminlte::page')

@section('title', 'Acreditables | Editar usuario')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Editar usuario</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('coordinador.usuarios.index') }}" class="link-muted">
                        Usuarios</a>
                </li>
                <li class="breadcrumb-item active"><a href="">usuario</a></li>
            </ol>
        </div>
    </div>
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
                    <input type="text" class="form-control" placeholder="{{ $usuario->cedula }}" disabled></input>
                </div>
    
    
                <form action="{{ route('coordinador.usuarios.update', $usuario) }}" method="post">
                    @csrf
                    {{ method_field('PUT') }}
    
                    <div class="form-group mb-3">
                        <label for="roles[]">Rol de usuario</label>
                        <select class="form-control mb-3" name="roles[]">
                            <option>Seleccione un rol</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}"
                                    {{ $usuario->roles->contains($role->id) ? 'selected' : '' }}>
                                    {{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
    
    
                    @if ($usuario->roles[0]->name === 'Profesor')
                        <div class="form-group mb-3">
                            <label>Especialidades</label>
                            <div class="row">
                                @foreach ($especialidades as $especialidad)
                                    <div class="col-6">
                                        <div class="icheck-primary">
                                            <input type="checkbox" name="especialidades[]" id="{{ $especialidad->id }}"
                                                value="{{ $especialidad->id }}"
                                                {{ in_array($especialidad->id, $relacion) ? 'checked' : '' }}>
    
                                            <label for="{{ $especialidad->id }}">
                                                {{ __($especialidad->nom_especialidad) }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
    
                    @if ($usuario->roles[0]->name === 'Estudiante')
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
                                    <option value="{{ $pnf->id }}"
                                        {{ !empty($usuario->estudiante) && $usuario->estudiante->pnf_id === $pnf->id ? 'selected' : '' }}>
                                        {{ $pnf->nom_pnf }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
    
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
