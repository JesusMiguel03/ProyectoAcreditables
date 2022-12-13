@extends('adminlte::page')

@section('title', 'Acreditables | Periodo')

@section('content_header')
    <div class="row">
        <div class="col-6">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('periodo') }}" class="link-muted">Periodos</a></li>
                <li class="breadcrumb-item active"><a href="">Editar</a></li>
            </ol>
        </div>
    </div>

    <x-tipografia.titulo>Periodo</x-tipografia.titulo>
@stop

@section('content')
    <div class="col-md-6 col-sm-12 mx-auto">
        <div class="card">
            <header class="card-header bg-primary">
                <h5>Editar periodo</h5>
            </header>

            <main class="card-body">
                <form action="{{ route('periodo.update') }}" method="post">
                    @csrf
                    {{ method_field('PUT') }}

                    <input type="numeric" class="d-none" name="id" value="{{ $periodo->id }}" hidden>

                    {{-- Fase --}}
                    <div class="form-group required mb-3">
                        <label for="fase" class="control-label">Fase</label>
                        <div class="input-group">
                            <input type="number" name="fase" class="form-control @error('fase') is-invalid @enderror"
                                value="{{ $periodo->fase }}" placeholder="{{ __('Ej: 1, 2 o 3') }}" autofocus required>

                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                </div>
                            </div>

                            @error('fase')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- Fecha de inicio --}}
                    <div class="form-group required mb-3">
                        <label for="inicio" class="control-label">Fecha inicio</label>
                        <div class="input-group date" id="inicio" data-target-input="nearest">
                            <input type="text" name="inicio"
                                class="form-control datetimepicker-input @error('inicio') is-invalid @enderror"
                                data-target="#inicio" value="{{ explode(' ', $periodo->inicio)[0] }}" placeholder="{{ __('2015-01-01') }}"
                                required>
                            <div class="input-group-append" data-target="#inicio" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>

                            @error('inicio')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- Fecha de fin --}}
                    <div class="form-group required mb-3">
                        <label for="fin" class="control-label">Fecha fin</label>
                        <div class="input-group date" id="fin" data-target-input="nearest">
                            <input type="text" name="fin"
                                class="form-control datetimepicker-input @error('fin') is-invalid @enderror"
                                data-target="#fin" value="{{ explode(' ', $periodo->fin)[0] }}" placeholder="{{ __('2015-01-01') }}"
                                required>
                            <div class="input-group-append" data-target="#fin" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>

                            @error('fin')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
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
                            <a href="{{ route('periodo') }}" class="btn btn-block btn-secondary">
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
    <script type="text/javascript">
        $(function() {
            $('#inicio').datetimepicker({
                format: 'YYYY-MM-DD'
            });
        });
        $(function() {
            $('#fin').datetimepicker({
                format: 'YYYY-MM-DD'
            });
        });
        // $("#inicio").on("change.datetimepicker", function(e) {
        //     $('#fin').datetimepicker('minDate', e.date);
        // });
        $("#fin").on("change.datetimepicker", function(e) {
            $('#inicio').datetimepicker('maxDate', e.date);
        });
    </script>
@stop
