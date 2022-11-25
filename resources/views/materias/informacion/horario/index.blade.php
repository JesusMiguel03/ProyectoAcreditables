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

            <div id="agenda" class="mb-4"></div>

            <!-- Modal -->
            <div class="modal fade" id="evento" tabindex="-1" role="dialog" aria-labelledby="eventoLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="eventoLabel">Evento</h5>
                        </div>

                        <div class="modal-body">

                            <form action="{{ route('horario.store') }}" method="post" id="horario">
                                {{-- {!! csrf_field() !!} --}}
                                @csrf

                                {{-- <div class="form-group mb-3">

                                    <label for="id" class="form-label">ID</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control @error('id') is-invalid @enderror"
                                            name="id" id="id" aria-describedby="helpId">
                                    </div>

                                    @error('id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div> --}}

                                {{-- <div class="form-group mb-3">
                                    <label for="title" class="form-label">Título</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            name="title" id="title" aria-describedby="helpId"
                                            placeholder="{{ 'Titulo' }}">
                                    </div>

                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div> --}}

                                {{-- Materia --}}
                                <div class="form-group mb-3">
                                    <label for="title" class="form-label">Materia</label>
                                    <select name="materia_id"
                                        class="form-control @error('materia_id') is-invalid @enderror">
                                        <option>Seleccione la materia</option>
                                        @foreach ($materias as $materia)
                                            <option value="{{ $materia->id }}">{{ $materia->nom_materia }}</option>
                                        @endforeach
                                    </select>

                                    @error('materia_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- Descripcion --}}
                                <div class="form-group mb-3">
                                    <label for="description">Descripción</label>
                                    <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @enderror"
                                        placeholder="{{ __('Descripción') }}" autofocus spellcheck="false" style="min-height: 9rem; resize: none">{{ old('descripcion') }}</textarea>

                                    @error('descripcion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- Aula --}}
                                <div class="form-group mb-3">
                                    <label for="aula" class="form-label">Aula</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control @error('aula') is-invalid @enderror"
                                            name="aula" id="aula" aria-describedby="helpId"
                                            placeholder="{{ 'Aula' }}" value="{{ old('aula') }}">
                                    </div>

                                    @error('aula')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- Espacio --}}
                                <div class="form-group mb-3">
                                    <label for="espacio" class="form-label">Espacio</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control @error('espacio') is-invalid @enderror"
                                            name="espacio" id="espacio" aria-describedby="helpId"
                                            placeholder="{{ 'Espacio' }}" value="{{ old('espacio') }}">
                                    </div>

                                    @error('espacio')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- Inicio --}}
                                <div class="form-group mb-3">
                                    <label for="start" class="form-label">Inicio</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control @error('start') is-invalid @enderror"
                                            name="start" id="start" aria-describedby="helpId"
                                            placeholder="{{ 'Fecha de inicio' }}" value="{{ old('start') }}">
                                    </div>

                                    @error('start')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- Fin --}}
                                <div class="form-group mb-3">
                                    <label for="end" class="form-label">Fin</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control @error('end') is-invalid @enderror"
                                            name="end" id="end" aria-describedby="helpId"
                                            placeholder="{{ 'Fecha de fin' }}" value="{{ old('end') }}">
                                    </div>

                                    @error('end')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-success" id="btnGuardar">Guardar</button>
                                <button type="button" class="btn btn-warning" id="btnModificar">Modificar</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="row">
                <div class="col-3">
                    <div class="card">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#horario">
                            <i class="fas fa-plus mr-2"></i>
                            {{ __('Añadir hora') }}
                        </button>
                    </div>
                </div>
            </div> --}}

            {{-- <div class="modal fade" id="horario" tabindex="-1" role="dialog" aria-labelledby="campoHorario"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="campoHorario">Asignar hora disponible</h5>
                        </div>
                        <div class="modal-body" style="min-height: 15rem">
                            <div id="agenda"></div> --}}
            {{-- <div class="label-group mb-3"> --}}
            {{-- <form action="{{ route('horario.store') }}" method="post">
                                    @csrf

                                    <section>
                                        <table class="table table-striped">
                                            <thead>
                                                <tr class="bg-secondary">
                                                    <th>Hora</th>
                                                    <th>Lunes</th>
                                                    <th>Martes</th>
                                                    <th>Miércoles</th>
                                                    <th>Jueves</th>
                                                    <th>Viernes</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <div class="icheck-primary">
                                                    <tr>
                                                        <th>
                                                            7:30 - 8:15
                                                        </th>
                                                        <th>
                                                            <input type="checkbox" name="dia[]" id="">
                                                        </th>
                                                        <th>
                                                            <input type="checkbox" name="dia[]" id="">
                                                        </th>
                                                        <th>
                                                            <input type="checkbox" name="dia[]" id="">
                                                        </th>
                                                        <th>
                                                            <input type="checkbox" name="dia[]" id="">
                                                        </th>
                                                        <th>
                                                            <input type="checkbox" name="dia[]" id="">
                                                        </th>
                                                    </tr>
                                                </div>
                                            </tbody>
                                        </table>
                                    </section>

                                    <div class="row">

                                        <div class="col-6">
                                            <select name="dia" id="" class="form-control">
                                                <option value="Lunes">Lunes</option>
                                                <option value="Martes">Martes</option>
                                                <option value="Miercoles">Miercoles</option>
                                                <option value="Jueves">Jueves</option>
                                                <option value="Viernes">Viernes</option>
                                            </select>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <div class="input-group date" id="datetimepicker3"
                                                    data-target-input="nearest">
                                                    <input type="text" name="hora"
                                                        class="form-control datetimepicker-input"
                                                        data-target="#datetimepicker3" />
                                                    <div class="input-group-append" data-target="#datetimepicker3"
                                                        data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fas fa-clock"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

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

                                </form> --}}
            {{-- </div> --}}
            {{-- </div>
                    </div>
                </div>
            </div> --}}

            {{-- <div class="row mt-3">

                @if ($horarios->isEmpty())
                    <div class="col-12">
                        <div class="card p-4 text-center">
                            <h2 class="text-muted">No hay datos guardados</h2>
                            <h5>Para ver información pruebe a agregar uno en el botón de "Añadir hora"</h5>
                        </div>
                    </div>
                @else
                    <div class="col-12 mt-4">
                        <div class="card table-responsive-sm p-3 mb-4">
                            <table id='tabla' class="table table-striped">
                                <thead>
                                    <tr class="bg-secondary">
                                        <th>ID</th>
                                        <th>Dia</th>
                                        <th>Hora</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($horarios as $horario)
                                        <tr>
                                            <th>{{ $horario->id }}</th>
                                            <th>{{ $horario->dia }}</th>
                                            <th>
                                                {{ $horario->hora }}
                                                @if ($horario->dia_noche === 0)
                                                    AM
                                                @else
                                                    PM
                                                @endif
                                            </th>
                                            <th><a href="{{ route('horario.edit', $horario->id) }}"
                                                    class="btn btn-primary">Editar</a></th>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

            </div> --}}

        </div>
    </section>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/Calendar/main.min.css') }}">
@stop

@section('js')
    <script src="{{ asset('vendor/moment/moment.js') }}"></script>
    <script src="{{ asset('vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $('#datetimepicker3').datetimepicker({
                format: 'LT'
            });
        });
    </script>
    <script src="{{ asset('vendor/Calendar/main.min.js') }}" defer></script>
    <script src="{{ asset('vendor/Calendar/locales-all.min.js') }}" defer></script>
    <script src="{{ asset('js/calendario.js') }}"></script>
@stop
