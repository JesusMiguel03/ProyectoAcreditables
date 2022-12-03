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
                        <main class="card-body" style="height: 15.625rem">
                            <div class="form-group mb-3">
                                <label>Trayecto</label>
                                <input type="text" class="form-control"
                                    value="{{ !empty(Auth::user()->estudiante) ? Auth::user()->estudiante->pnf->num_trayecto : 'Sin asignar' }}"
                                    readonly disabled>
                            </div>
                            <div class="form-group mb-3">
                                <label>PNF</label>
                                <input type="text" class="form-control"
                                    value="{{ !empty(Auth::user()->estudiante) ? Auth::user()->estudiante->pnf->nom_pnf : 'Sin asignar' }}"
                                    readonly disabled>
                            </div>
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
        @if (!empty(Auth::user()->estudiante->preinscrito))
            @if (!empty(Auth::user()->estudiante->preinscrito->materia->profesor))
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
            @else
                <div class="col-6">
                    <div class="card">
                        <main class="card-body">
                            <p class="text-justify text-muted">Aún no se ha asignado un profesor a la materia escogida,
                                comuníquese con el
                                coordinador para notificarle.</p>
                        </main>
                    </div>
                </div>
            @endif
        @else
            @can('preinscribir')
                <div class="col-6">
                    <div class="card">
                        <main class="card-body">
                            <p class="text-justify text-muted">No se encuentra registrado en ninguna materia.</p>
                            <a href="{{ route('materias.index') }}">Ver materias</a>
                        </main>
                    </div>
                </div>
            @endcan
        @endif
    </div>

@stop
