@extends('adminlte::page')

@section('title', 'Acreditables | Horarios')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item active"><a href="">Horarios</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Horarios</x-tipografia.titulo>

    @can('academico')
        {{-- Modal para crear --}}
        <div class="modal fade" id="registrar" tabindex="-1" role="dialog" aria-labelledby="campohora" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <header class="modal-header bg-primary">
                        <h5 class="modal-title" id="campohora">Agregar hora</h5>
                    </header>

                    <main class="modal-body">
                        <form action="{{ route('horarios.store') }}" method="post">
                            @csrf

                            {{-- Espacio --}}
                            <div class="form-group required">
                                <label for="espacio" class="control-label">Espacio</label>
                                <div class="input-group">
                                    <input type="text" name="espacio" id="espacio"
                                        class="form-control @error('espacio') is-invalid @enderror" value="{{ old('espacio') }}"
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
                                    {{-- Numero --}}
                                    <div class="form-group col-6">
                                        <label for="edificio_numero" class="control-label">Edificio Nro</label>
                                        <div class="input-group">
                                            <input type="number" name="edificio_numero" id="edificio_numero"
                                                class="form-control @error('edificio_numero') is-invalid @enderror contador"
                                                value="{{ old('edificio_numero') }}" placeholder="{{ __('Ej: 12') }}">


                                            @error('edificio_numero')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Dia --}}
                                    <div class="form-group col-6">
                                        <label for="dia" class="control-label">Dia</label>
                                        <div class="input-group">
                                            <select name="dia" class="form-control" required>
                                                <option value="0" disabled>Seleccione uno</option>
                                                <option value="1">Lunes</option>
                                                <option value="2">Martes</option>
                                                <option value="3">Miércoles</option>
                                                <option value="4">Jueves</option>
                                                <option value="5">Viernes</option>
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
                                        data-target="#hora" value="{{ old('hora') }}" placeholder="{{ __('Ej: 10:45') }}"
                                        required>
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

                            <x-modal.footer-aceptar />

                        </form>
                    </main>
                </div>
            </div>
        </div>

        <x-formularios.borrar />
    @endcan
@stop

@section('content')
    <div class="card table-responsive-sm p-3 mb-3">

        <div class="w-100 row mx-auto">
            <div class="col-md-2 col">
                <button class="btn btn-block btn-primary my-2" data-toggle="modal" data-target="#registrar"
                    {{ Popper::arrow()->pop('Nuevo horario') }}>
                    <i class="fas fa-plus mr-2"></i>
                    {{ 'Añadir' }}
                </button>
            </div>
        </div>

        <table id='tabla' class="table table-striped">
            <thead>
                <tr class="bg-secondary">
                    <th>Espacio</th>
                    <th>Edificio número</th>
                    <th>Día</th>
                    <th>Hora</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($horarios as $horario)
                    <tr>
                        <td>{{ $horario->espacio }}</td>
                        <td>{{ $horario->edificio_numero }}</td>
                        <td>{{ diaSemana($horario->dia) }}</td>
                        <td>{{ \Carbon\Carbon::parse($horario->hora)->format('g:i A') }}</td>
                        <td>
                            <div class="btn-group mx-1" role="group" aria-label="Acciones">
                                <a href="{{ route('horarios.edit', $horario->id) }}" class="btn btn-primary"
                                    {{ Popper::arrow()->pop('Editar') }}>
                                    <i class="fas fa-edit"></i>
                                </a>

                                <button id="{{ $horario->id }}" class="btn btn-danger borrar"
                                    {{ Popper::arrow()->pop('Borrar') }} data-type="Horario"
                                    data-name="{{ $horario->espacio }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">

    {{-- Personalizados --}}
    <link rel="stylesheet" href="{{ asset('css/required.css') }}">
@stop

@section('js')
    @include('popper::assets')
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('vendor/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/moment/moment.js') }}"></script>
    <script src="{{ asset('vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $('#hora').datetimepicker({
                format: 'h:mm a'
            });
        });
    </script>

    {{-- Personalizados --}}
    <script src="{{ asset('js/tablas.js') }}"></script>
    <script src="{{ asset('js/borrar.js') }}"></script>

    {{-- Mensajes --}}
    <script>
        @if ($message = session('creado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: 'Hora registrada!',
                html: 'Una nueva hora ha sido añadida.',
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
        @elseif ($message = session('actualizado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Datos actualizados!',
                html: 'El horario ha sido actualizado.',
                confirmButtonColor: '#28a745',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('borrado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: 'Hora borrada exitosamente!',
                html: 'La hora ha sido borrada.',
                confirmButtonColor: '#28a745',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('registrado'))
            let timerInterval
            Swal.fire({
                icon: 'info',
                title: 'Ya fue registrada',
                html: 'La hora ya se encuentra registrada.',
                confirmButtonColor: '#17a2b8',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
            $('#registrar').modal('show')
        @elseif ($message = session('no encontrado'))
            let timerInterval
            Swal.fire({
                icon: 'error',
                title: '¡Hora no encontrada!',
                html: 'La hora que desea buscar o editar no se encuentra disponible.',
                confirmButtonColor: '#dc3545',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @endif
    </script>
@stop
