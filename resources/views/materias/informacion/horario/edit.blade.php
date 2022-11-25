@extends('adminlte::page')

@section('title', 'Acreditables | Horario')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Coordinación de Acreditables</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}">Inicio</a></li>
                <li class="breadcrumb-item active"><a href="">Horario</a></li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    {{-- Page content --}}
    <section class="content">
        <div class="container-fluid">

            <div class="col-6 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h5>Asignar hora disponible</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('horario.update', $horario) }}" method="post">
                            @csrf
                            {{ method_field('PUT') }}

                            {{-- Campo de nombre --}}
                            <div class="row">

                                <div class="col-6">
                                    <select name="dia" id="" class="form-control">
                                        <option value="Lunes" {{ $horario->dia === 'Lunes' ? 'checked' : '' }}>Lunes</option>
                                        <option value="Martes" {{ $horario->dia === 'Martes' ? 'checked' : '' }}>Martes</option>
                                        <option value="Miercoles" {{ $horario->dia === 'Miercoles' ? 'checked' : '' }}>Miercoles</option>
                                        <option value="Jueves" {{ $horario->dia === 'Jueves' ? 'checked' : '' }}>Jueves</option>
                                        <option value="Viernes" {{ $horario->dia === 'Viernes' ? 'checked' : '' }}>Viernes</option>
                                    </select>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <div class="input-group date" id="datetimepicker3" data-target-input="nearest">
                                            <input type="text" name="hora" class="form-control datetimepicker-input"
                                                data-target="#datetimepicker3" value="{{ $horario->hora }} {{ $horario->dia_noche }}" />
                                            <div class="input-group-append" data-target="#datetimepicker3"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fas fa-clock"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            {{-- Botón de registrar --}}
                            <div class="row">
                                <div class="col-6">
                                    <button type="button" class="btn btn-block btn-secondary"
                                        data-dismiss="modal">{{ __('Cancelar') }}</button>
                                </div>
                                <div class="col-6">
                                    <button id="actualizar" class="btn btn-block btn-primary">
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
    <<script type="text/javascript">
        $(function() {
            $('#datetimepicker3').datetimepicker({
                format: 'LT'
            });
        });
    </script>
@stop
