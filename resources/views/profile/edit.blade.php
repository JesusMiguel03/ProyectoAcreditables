@extends('adminlte::page')

@section('title', 'Acreditables | Mi cuenta')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Coordinación de Acreditables</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="text-primary">Inicio</a></li>
                <li class="breadcrumb-item active"><a href="" class="text-primary">Mi cuenta</a></li>
            </ol>
        </div>
    </div>
@stop

@section('content')

    <div class="col-12">
        <div class="card p-4">

            <div class="row">

                @if (Auth::user()->getRoleNames()[0] === 'Estudiante')
                    <div class="d-none d-md-block col-6">
                        <h5 class="text-muted">Información académica</h5>
                    </div>
                @endif
            </div>

            <section class="row">

                @if (Auth::user()->getRoleNames()[0] === 'Estudiante')
                    <div class="col-md-6 col-sm-12 mt-3">

                        <hr class="d-md-none">

                        @if (Auth::user()->getRoleNames()[0] === 'Estudiante')
                            <div class="d-md-none p-0 col-sm-12">
                                <h5 class="text-muted">Información académica</h5>
                            </div>
                        @endif


                        <form action="{{ route('perfil.update', Auth::user()->id) }}" method="post">
                            @csrf
                            {{ method_field('PUT') }}

                            {{-- Nombre --}}
                            <div class="input-group mb-3">

                                <div class="col-12 p-0">
                                    <div class="form-group mb-3">
                                        <label for="trayecto">Trayecto</label>
                                        <select id="trayecto" class="form-control @error('trayecto') is-invalid @enderror"
                                            name="trayecto">
                                            <option>Seleccione su trayecto</option>
                                            @foreach ($trayectos as $trayecto)
                                                <option value="{{ $trayecto->id }}"
                                                    {{ $trayecto->id === $estudiante->trayecto_id ? 'selected' : '' }}>
                                                    {{ $trayecto->numero }}</option>
                                            @endforeach
                                        </select>

                                        @error('trayecto')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 p-0">
                                    <div class="form-group mb-3">
                                        <label for="pnf">Pnf</label>
                                        <select id="pnf" class="form-control @error('pnf') is-invalid @enderror"
                                            name="pnf">
                                            <option>Seleccione su pnf</option>
                                            @foreach ($pnfs as $pnf)
                                                <option value="{{ $pnf->id }}" {{ $pnf->id === $estudiante->pnf_id ? 'selected' : '' }}>
                                                    {{ $pnf->nombre }}</option>
                                            @endforeach
                                        </select>

                                        @error('trayecto')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            {{-- Botones --}}
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <button type="submit" class="btn btn-block btn-primary">
                                        {{ __('Actualizar perfil ') }}
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                @endif

            </section>


        </div>
    </div>
@stop
