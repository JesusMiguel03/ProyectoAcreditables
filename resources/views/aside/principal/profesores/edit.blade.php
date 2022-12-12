@extends('adminlte::page')

@section('title', 'Acreditables | Profesores')

@section('content_header')
    <x-tipografia.titulo>Listado de profesores</x-tipografia.titulo>

    <div class="row">
        <div class="col-6">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('profesores.index') }}" class="link-muted">Profesores</a></li>
                <li class="breadcrumb-item active"><a href="">{{ $profesor->usuario->nombre }}
                        {{ $profesor->usuario->apellido }}</a></li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="col-md-6 col-sm-12 mx-auto">
        <div class="card">
            <header class="card-header bg-primary">
                <h5>Editar perfil de profesor</h5>
            </header>
            <main class="card-body">
                <form action="{{ route('profesores.update', $profesor->id) }}" method="post">
                    @csrf
                    {{ method_field('PUT') }}

                    {{-- Nombre y apellido --}}
                    <div class="form-group required mb-3">
                        <label for="usuarios">Nombre y apellido</label>
                        <input type="text" name="usuarios" id="usuarios"
                            class="form-control @error('usuarios') is-invalid @enderror"
                            value="{{ __($profesor->usuario->nombre . ' ' . $profesor->usuario->apellido) . ' - CI:' . number_format($profesor->usuario->cedula, 0, ',', '.') }}"
                            autofocus readonly disabled>

                        @error('usuarios')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- Conocimiento y estado --}}
                    <div class="form-group required mb-3">
                        <div class="row">

                            {{-- Área de conocimiento --}}
                            <div class="col-6">
                                <label for="conocimiento" class="control-label">Área de conocimiento</label>
                                <select name="conocimiento" class="form-control @error('conocimiento') is-invalid @enderror">
                                    <option value="0" disabled>Seleccione uno</option>
                                    @foreach ($conocimientos as $conocimiento)
                                        <option value="{{ $conocimiento->id }}"
                                            {{ $profesor->conocimiento->nom_especialidad === $conocimiento->nom_especialidad ? 'selected' : '' }}>
                                            {{ $conocimiento->nom_especialidad }}</option>
                                    @endforeach
                                </select>
        
                                @error('conocimiento')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Estado del profesor --}}
                            <div class="col-6">
                                <label for="estado_profesor" class="control-label">¿Se encuentra activo?</label>
                                <div class="input-control">
                                    <select name="estado_profesor" class="form-control">
                                        <option>Seleccione una</option>
                                        <option value=1 {{ $profesor->estado_profesor === 1 ? 'selected' : '' }}>Activo
                                        </option>
                                        <option value=0 {{ $profesor->estado_profesor === 0 ? 'selected' : '' }}>Inactivo
                                        </option>
                                    </select>
        
                                </div>
        
                                @error('estado_profesor')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Residencia --}}
                    <div class="form-group required required mb-3">
                        <label class="control-label">Residencia</label>
                        <div class="form-row">
                            <div class="form-group col-6">
                                <input type="text" name="estado" id="estado"
                                    class="form-control @error('estado') is-invalid @enderror"
                                    value="{{ $profesor->estado }}" placeholder="{{ __('Estado') }}" autofocus required>

                                @error('estado')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-6">
                                <input type="text" name="ciudad" id="ciudad"
                                    class="form-control @error('ciudad') is-invalid @enderror"
                                    value="{{ $profesor->ciudad }}" placeholder="{{ __('Ciudad') }}" autofocus required>

                                @error('ciudad')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Urb, calle, casa --}}
                        <div class="form-row">
                            <div class="form-group col-4">
                                <input type="text" name="urb" id="urb"
                                    class="form-control @error('urb') is-invalid @enderror" value="{{ $profesor->urb }}"
                                    placeholder="{{ __('Urbanización') }}" autofocus required>

                                @error('urb')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-4">
                                <input type="text" name="calle" id="calle"
                                    class="form-control @error('calle') is-invalid @enderror"
                                    value="{{ $profesor->calle }}" placeholder="{{ __('Calle') }}" autofocus required>

                                @error('calle')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-4">
                                <input type="text" name="casa" id="casa"
                                    class="form-control @error('casa') is-invalid @enderror" value="{{ $profesor->casa }}"
                                    placeholder="{{ __('Casa nro') }}" autofocus required>

                                @error('casa')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Telefono --}}
                    <div class="form-group required" style="margin-top: -10px">
                        <label for="telefono" class="control-label">Número de contacto</label>
                        <div class="row">

                            {{-- Codigo --}}
                            <div class="col-3">
                                <select name="codigo" class="form-control">
                                    <option value="0" disabled>Seleccione uno</option>
                                    <option value="0412"
                                        {{ substr($profesor->telefono, 0, 4) === '0412' ? 'selected' : '' }}>0412</option>
                                    <option value="0414"
                                        {{ substr($profesor->telefono, 0, 4) === '0414' ? 'selected' : '' }}>0414</option>
                                    <option value="0416"
                                        {{ substr($profesor->telefono, 0, 4) === '0416' ? 'selected' : '' }}>0416</option>
                                    <option value="0424"
                                        {{ substr($profesor->telefono, 0, 4) === '0424' ? 'selected' : '' }}>0424</option>
                                    <option value="0426"
                                        {{ substr($profesor->telefono, 0, 4) === '0426' ? 'selected' : '' }}>0426</option>
                                </select>
                            </div>

                            {{-- Numero --}}
                            <div class="col-9">
                                <input type="tel" name="telefono"
                                    class="form-control @error('telefono') is-invalid @enderror"
                                    value="{{ substr($profesor->telefono, 4) }}" placeholder="{{ __('0193451') }}"
                                    autofocus required>
                            </div>
                        </div>

                        @error('telefono')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- Fechas --}}
                    <div class="form-group mb-3">
                        <div class="row">

                            {{-- Nacimiento --}}
                            <div class="col-6 ">
                                <label for="fecha_de_nacimiento" class="control-label">Fecha de nacimiento</label>
                                <div class="input-group date" id="fecha_nacimiento" data-target-input="nearest">
                                    <input type="text" name="fecha_de_nacimiento"
                                        class="form-control datetimepicker-input" data-target="#fecha_nacimiento"
                                        value="{{ __($profesor->fecha_de_nacimiento) }}" required>
                                    <div class="input-group-append" data-target="#fecha_nacimiento"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>

                            {{-- Ingreso a la institución --}}
                            <div class="col-6">
                                <label for="fecha_ingreso_institucion" class="control-label">Fecha ingreso a
                                    institución</label>
                                <div class="input-group date" id="fecha_ingreso" data-target-input="nearest">
                                    <input type="text" name="fecha_ingreso_institucion"
                                        class="form-control datetimepicker-input" data-target="#fecha_ingreso"
                                        value="{{ __($profesor->fecha_ingreso_institucion) }}" required>
                                    <div class="input-group-append" data-target="#fecha_ingreso"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: -10px">
                        <p class="pl-2 text-danger"><strong>Nota:</strong> (*) Indica los campos que
                            son obligatorios.
                        </p>
                    </div>

                    {{-- Botón de registrar --}}
                    <div class="row">
                        <div class="col-6">
                            <a href="{{ route('profesores.index') }}" class="btn btn-block btn-secondary">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Volver
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
    <link rel="stylesheet" href="{{ asset('vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/required.css') }}">
@stop

@section('js')
    <script src="{{ asset('vendor/moment/moment.js') }}"></script>
    <script src="{{ asset('vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
@stop
