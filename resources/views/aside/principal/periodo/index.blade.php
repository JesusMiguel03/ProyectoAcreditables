@extends('adminlte::page')

@section('title', 'Acreditables | Periodo')

@section('content_header')
    <div class="row">
        <div class="col-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
                <li class="breadcrumb-item active"><a href="">Periodo</a></li>
            </ol>
        </div>

        <x-tipografia.periodo fase="{{ !empty($periodo->fase) ? $periodo->fase : '' }}"
            fecha="{{ !empty($periodo->inicio) ? explode('-', explode(' ', $periodo->inicio)[0])[0] : 'Sin asignar' }}" />
            
        <div class="col-4">
            <div class="card float-right mr-2">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#registrar">
                    <i class="fas fa-plus mr-2"></i>
                    {{ __('Registrar periodo') }}
                </button>
            </div>
        </div>

        {{-- Registrar usuario --}}
        <div class="modal fade" id="registrar" tabindex="-1" role="dialog" aria-labelledby="camporegistrar"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <header class="modal-header bg-primary">
                        <h5 class="modal-title" id="camporegistrar">Registrar periodo</h5>
                    </header>

                    <main class="modal-body">
                        <form action="{{ route('periodo.store') }}" method="post">
                            @csrf

                            {{-- Fase --}}
                            <div class="form-row" style="margin-bottom: -0.75rem">
                                <div class="form-group required col-4">
                                    <label for="fase" class="control-label">Fase</label>
                                    <div class="input-group">
                                        <input type="number" name="fase"
                                            class="form-control @error('fase') is-invalid @enderror"
                                            value="{{ old('fase') }}" placeholder="{{ __('Ej: 1, 2 o 3') }}" autofocus
                                            required>

                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span
                                                    class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
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
                                <div class="form-group required col-4">
                                    <label for="inicio" class="control-label">Fecha inicio</label>
                                    <div class="input-group date" id="inicio" data-target-input="nearest">
                                        <input type="text" name="inicio"
                                            class="form-control datetimepicker-input @error('inicio') is-invalid @enderror"
                                            data-target="#inicio" value="{{ old('inicio') }}"
                                            placeholder="{{ __('2015-01-01') }}" required>
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
                                <div class="form-group required col-4">
                                    <label for="fin" class="control-label">Fecha fin</label>
                                    <div class="input-group date" id="fin" data-target-input="nearest">
                                        <input type="text" name="fin"
                                            class="form-control datetimepicker-input @error('fin') is-invalid @enderror"
                                            data-target="#fin" value="{{ old('fin') }}"
                                            placeholder="{{ __('2015-04-09') }}" required>
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
                            </div>

                            <div class="form-group" style="margin-bottom: -10px">
                                <p class="pl-2 text-danger"><strong>Nota:</strong> (*) Indica los campos que
                                    son obligatorios.
                                </p>
                            </div>

                            {{-- Botón de registrar --}}
                            <div class="row">
                                <x-botones.cancelar />

                                <x-botones.guardar />
                            </div>
                        </form>
                    </main>
                </div>
            </div>
        </div>
    </div>

    <x-tipografia.titulo>Periodo</x-tipografia.titulo>
@stop

@section('content')
    <div class="col-12 card table-responsive-sm p-3 my-3">
        <table id='tabla' class="table table-striped">
            <thead>
                <tr class="bg-secondary">
                    <th>Fase</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($periodos as $periodo)
                    <tr>
                        <td>{{ $periodo->fase }}</td>
                        <td>{{ explode(' ', $periodo->inicio)[0] }}</td>
                        <td>{{ explode(' ', $periodo->fin)[0] }}</td>
                        <td>
                            <a href="{{ route('periodo.edit', $periodo->id) }}" class="btn btn-primary"
                                {{ Popper::arrow()->pop('Editar') }}>
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('/vendor/DataTables/datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/required.css') }}">
@stop

@section('js')
    <script src="{{ asset('/vendor/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('vendor/moment/moment.js') }}"></script>
    <script src="{{ asset('vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('js/tablas.js') }}"></script>
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
        $("#inicio").on("change.datetimepicker", function(e) {
            $('#fin').datetimepicker('minDate', e.date);
        });
        $("#fin").on("change.datetimepicker", function(e) {
            $('#inicio').datetimepicker('maxDate', e.date);
        });
    </script>
    <script>
        @if ($message = session('creado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: 'Periodo registrado!',
                html: 'Un nuevo periodo ha sido añadido.',
                confirmButtonColor: '#28a745',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('error'))
            let timerInterval
            Swal.fire({
                icon: 'error',
                title: 'Error al registrar',
                html: 'Uno de los parámetros parece estar mal.',
                confirmButtonColor: '#dc3545',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
            $('#registrar').modal('show')
        @elseif ($message = session('repetido'))
            let timerInterval
            Swal.fire({
                icon: 'info',
                title: 'Ya fue registrado',
                html: 'El periodo ya se encuentra registrado.',
                confirmButtonColor: '#17a2b8',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('actualizado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Datos actualizados!',
                html: 'Los datos del periodo han sido actualizados.',
                confirmButtonColor: '#28a745',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @endif
    </script>
@stop
