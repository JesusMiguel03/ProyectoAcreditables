@extends('adminlte::page')

@section('title', 'Acreditables | Editar hora')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('horarios.index') }}" class="link-muted">Horarios</a></li>
    <li class="breadcrumb-item active"><a href="">Editar hora</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Horarios</x-tipografia.titulo>
@stop

@section('content')
    <div class="col-md-6 col-sm-12 mx-auto mt-3">
        <div class="card">
            <header class="card-header bg-primary">
                <h5>Editar hora</h5>
            </header>

            <main class="card-body">
                <form action="{{ route('horarios.update', $horario->id) }}" method="post">
                    @csrf
                    {{ method_field('PUT') }}

                    {{-- Espacio --}}
                    <div class="form-group required">
                        <label for="espacio" class="control-label">Espacio</label>
                        <div class="input-group">
                            <input type="text" name="espacio" id="espacio"
                                class="form-control @error('espacio') is-invalid @enderror"
                                value="{{ $horario->espacio }}"
                                placeholder="{{ __('Espacio a ocupar, Ej: Edificio B o B') }}" autofocus required>

                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-search-location"></span>
                                </div>
                            </div>

                            @error('espacio')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label for="edificio_numero" class="control-label">Edificio Nro</label>
                                <input type="number" name="edificio_numero" id="edificio_numero"
                                    class="form-control @error('edificio_numero') is-invalid @enderror"
                                    value="{{ $horario->edificio_numero }}" placeholder="{{ __('Ej: 12') }}">

                                @error('edificio_numero')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Dia --}}
                            <div class="form-group required col-6">
                                <label for="dia" class="control-label">Dia</label>
                                <div class="input-group">
                                    <select name="dia" class="form-control" required>
                                        <option value="0" disabled>Seleccione uno</option>
                                        <option value="1" {{ $horario->dia === 1 ? 'selected' : '' }}>Lunes</option>
                                        <option value="2" {{ $horario->dia === 2 ? 'selected' : '' }}>Martes</option>
                                        <option value="3" {{ $horario->dia === 3 ? 'selected' : '' }}>Miércoles
                                        </option>
                                        <option value="4" {{ $horario->dia === 4 ? 'selected' : '' }}>Jueves</option>
                                        <option value="5" {{ $horario->dia === 5 ? 'selected' : '' }}>Viernes</option>
                                    </select>

                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-calendar-day"></span>
                                        </div>
                                    </div>

                                    @error('dia')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Hora --}}
                    <div class="form-group required mb-3" style="margin-top: -10px">
                        <label for="hora" class="control-label">Hora</label>
                        <div class="input-group date" id="hora" data-target-input="nearest">
                            <input type="text" name="hora"
                                class="form-control datetimepicker-input @error('hora') is-invalid @enderror"
                                data-target="#hora" value="{{ \Carbon\Carbon::parse($horario->hora)->format('g:i A') }}"
                                placeholder="{{ __('Ej: 10:45') }}" required>
                            <div class="input-group-append" data-target="#hora" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                            @error('hora')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <x-modal.mensaje-obligatorio />

                    <x-modal.footer-editar ruta="{{ route('conocimientos.index') }}" />
                </form>
            </main>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/required.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@stop

@section('js')
    <script src="{{ asset('vendor/moment/moment.js') }}"></script>
    <script src="{{ asset('vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $('#hora').datetimepicker({
                format: 'h:mm a'
            });
        });
    </script>
@endsection
