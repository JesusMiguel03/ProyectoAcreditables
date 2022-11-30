@extends('adminlte::page')

@section('title', 'Acreditables | Mi cuenta')

@section('content_header')
    <div class="row">
        <div class="col-6">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
                <li class="breadcrumb-item active"><a href="" class="text-primary">Mi cuenta</a></li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row mt-3">

        {{-- Perfil de usuario --}}
        <div class="col-6">
            <div class="card">
                <header class="card-header bg-primary">
                    <h5>Información de perfil</h5>
                </header>

                <main class="card-body">
                    <form action="{{ route('user-profile-information.update') }}" method="post">
                        @csrf
                        {{ method_field('PUT') }}

                        {{-- Nombre --}}
                        <div class="input-group mb-3">

                            <div class="col-6 px-2">
                                <label>Nombre</label>
                                <input type="text" name="nombre" class="form-control"
                                    value="{{ Auth::user()->nombre }}">
                            </div>

                            <div class="col-6 px-2">
                                <label>Apellido</label>
                                <input type="text" name="apellido" class="form-control"
                                    value="{{ Auth::user()->apellido }}">
                            </div>

                        </div>

                        {{-- Correo --}}
                        <div class="form-group mb-3 px-2">
                            <label>Correo</label>
                            <input type="text" name="email" class="form-control" value="{{ Auth::user()->email }}">
                        </div>

                        {{-- Botones --}}
                        <div class="row px-2">
                            <div class="col-12">
                                <button type="submit" class="btn btn-block btn-outline-primary">
                                    {{ __('Actualizar perfil ') }}
                                </button>
                            </div>
                        </div>

                    </form>
                </main>
            </div>
        </div>

        {{-- Perfil academico --}}
        @can('preinscribir')
            @if (empty(Auth::user()->estudiante))
                <div class="col-6">
                    <div class="card">
                        <header class="card-header bg-primary">
                            <h5>Perfil académico</h5>
                        </header>
                        <main class="card-body">
                            <form action="{{ route('estudiante.store') }}" method="post">
                                @csrf

                                <input type="text" name="usuario" value="{{ Auth::user()->id }}" class="d-hide" hidden>

                                {{-- Trayecto --}}
                                <div class="form-group mb-3 px-2">
                                    <label>Trayecto</label>
                                    <select name="trayecto" class="form-control">
                                        <option>Seleccione uno</option>
                                        @foreach ($trayectos as $trayecto)
                                            <option value="{{ $trayecto->id }}"
                                                {{ !empty($usuario->estudiante) && $usuario->estudiante->trayecto_id === $trayecto->id ? 'selected' : '' }}>
                                                {{ $trayecto->num_trayecto }}</option>
                                        @endforeach
                                    </select>

                                    @error('trayecto')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- Pnf --}}
                                <div class="form-group mb-3 px-2">
                                    <label>PNF</label>
                                    <select name="pnf" class="form-control">
                                        <option>Seleccione uno</option>
                                        @foreach ($pnfs as $pnf)
                                            <option value="{{ $pnf->id }}"
                                                {{ !empty($usuario->estudiante) && $usuario->estudiante->pnf_id === $pnf->id ? 'selected' : '' }}>
                                                {{ $pnf->nom_pnf }}</option>
                                        @endforeach
                                    </select>

                                    @error('pnf')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- Botones --}}
                                <div class="row px-2">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-block btn-outline-primary">
                                            {{ __('Actualizar perfil ') }}
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </main>
                    </div>
                </div>
            @else
                <div class="col-6">
                    <div class="card">
                        <header class="card-header bg-primary">
                            <h5>Perfil académico</h5>
                        </header>

                        <main class="card-body" style="min-height: 15.625rem">

                            {{-- Trayecto --}}
                            <div class="form-group mb-3 px-2">
                                <label>Trayecto</label>
                                <input type="text" class="form-control"
                                    placeholder="{{ Auth::user()->estudiante->trayecto_id }}" disabled>
                            </div>

                            {{-- Pnf --}}
                            <div class="form-group mb-3 px-2">
                                <label>PNF</label>
                                <input type="text" class="form-control"
                                    placeholder="{{ Auth::user()->estudiante->pnf->nom_pnf }}" disabled>
                            </div>

                        </main>
                    </div>
                </div>
            @endif
        @endcan

        {{-- Preinscripcion --}}
        @if (!empty(Auth::user()->estudiante->preinscrito) && !empty(Auth::user()->estudiante->preinscrito->profesor))
            <section class="col-4 p-2">
                <a href="{{ route('comprobante') }}">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="far fa-file-pdf"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text text-primary">Descargar comprobante</span>
                        </div>
                    </div>
                </a>
            </section>
        @endif
    </div>

@stop
