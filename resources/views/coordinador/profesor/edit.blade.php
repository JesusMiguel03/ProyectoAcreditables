@extends('adminlte::page')

@section('title', 'Acreditables | Listado de profesores')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Coordinación de Acreditables</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}">Inicio</a></li>
                <li class="breadcrumb-item active"><a href="">Listado de Profesores</a></li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <section class="content">
        <div class="container-fluid">

            <div class="col-6 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h5>Editar perfil de profesor</h5>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('profesores.update', $profesor->id) }}" method="post">
                            @csrf
                            {{ method_field('PATCH') }}

                            {{-- Usuario --}}
                            <div class="input-group mb-3">
                                <input type="text" name="usuarios" id="usuarios"
                                    class="form-control @error('usuarios') is-invalid @enderror"
                                    value="{{ __($usuario->nombre . ' ' . $usuario->apellido) }}" autofocus readonly>

                                @error('usuarios')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Titulo --}}
                            <div class="input-group mb-3">
                                <input type="text" name="titulo" id="titulo"
                                    class="form-control @error('titulo') is-invalid @enderror"
                                    value="{{ __($profesor->titulo) }}"
                                    placeholder="{{ __('Ingrese el titulo del profesor(a)') }}" autofocus>

                                @error('titulo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Genero --}}
                            <select class="form-control mb-3" name="genero">
                                <option value="Femenino" {{ $profesor->genero === 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                <option value="Masculino" {{ $profesor->genero === 'Masculino' ? 'selected' : '' }}>Masculino</option>
                            </select>

                            {{-- Residencia --}}
                            <div class="form-group">
                                <label>Residencia</label>

                                <div class="input-group mb-3">
                                    <input type="text" name="direccion" id="direccion"
                                        class="form-control @error('direccion') is-invalid @enderror"
                                        value="{{ __($profesor->direccion) }}" placeholder="{{ __('Direccion') }}" autofocus>

                                    @error('direccion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <input type="text" name="ciudad" id="ciudad"
                                        class="form-control @error('ciudad') is-invalid @enderror"
                                        value="{{ __($profesor->ciudad) }}" placeholder="{{ __('Ciudad') }}" autofocus>

                                    @error('ciudad')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <input type="text" name="estado" id="estado"
                                        class="form-control @error('estado') is-invalid @enderror"
                                        value="{{ __($profesor->estado) }}" placeholder="{{ __('Estado') }}" autofocus>

                                    @error('estado')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Fecha de nacimiento --}}
                            <div class="form-group mb-3">
                                <label>Fecha de nacimiento</label>
                                <div class="input-group date" id="fecha_nacimiento" data-target-input="nearest">
                                    <input type="text" name="fecha_de_nacimiento" class="form-control datetimepicker-input" data-target="#fecha_nacimiento" value="{{ __($profesor->fecha_de_nacimiento) }}"/>
                                    <div class="input-group-append" data-target="#fecha_nacimiento" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>

                            {{-- Fecha de ingreso --}}
                            <div class="form-group mb-3">
                                <label>Fecha de ingreso al plantel</label>
                                <div class="input-group date" id="fecha_ingreso" data-target-input="nearest">
                                    <input type="text" name="fecha_ingreso_plantel" class="form-control datetimepicker-input" data-target="#fecha_ingreso" value="{{ __($profesor->fecha_ingreso_plantel) }}"/>
                                    <div class="input-group-append" data-target="#fecha_ingreso" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>


                            {{-- Botón de registrar --}}
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ route('profesores.index') }}" class="btn btn-block btn-secondary">{{ __('Cancelar') }}</a>
                                </div>
                                <div class="col-6">
                                    <button type="submit" class="btn btn-block btn-primary">
                                        {{ __('Guardar') }}
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </section>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@stop

@section('js')
    <script src="{{ asset('vendor/moment/moment.js') }}"></script>
    <script src="{{ asset('vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
@stop