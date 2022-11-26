@extends('adminlte::page')

@section('title', 'Acreditables | Listado de profesores')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Listado de profesores</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}">Inicio</a></li>
                <li class="breadcrumb-item active"><a href="">Profesores</a></li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-3 col-sm-12">
                <div class="card">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#profesor">
                        <i class="fas fa-plus mr-2"></i>
                        {{ __('Asignar profesor') }}
                    </button>
                </div>
            </div>

            <x-botones.volver />
        </div>

        <div class="modal fade" id="profesor" tabindex="-1" role="dialog" aria-labelledby="campoprofesor"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="campoprofesor">Asignar profesor</h5>
                    </div>

                    <div class="modal-body">
                        <div class="label-group mb-3">

                            <form action="{{ route('profesores.store') }}" method="post">
                                @csrf

                                {{-- Usuario --}}
                                <div class="form-group mb-3">
                                    <label for="usuarios">Usuario</label>
                                    <select class="form-control" name="usuarios">
                                        <option>Seleccione a un usuario</option>
                                        @foreach ($usuarios as $usuario)
                                            @if ($usuario->getRoleNames()[0] === 'Profesor')
                                                <option value="{{ $usuario->id }}"
                                                    {{ $usuario->usuarios === $usuario->id ? 'selected' : '' }}>
                                                    {{ $usuario->nombre }} {{ $usuario->apellido }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Titulo --}}
                                <div class="form-group mb-3">
                                    <label for="titulo">Profesión</label>
                                    <div class="input-group">
                                        <input type="text" name="titulo" id="titulo"
                                            class="form-control @error('titulo') is-invalid @enderror"
                                            value="{{ old('titulo') }}"
                                            placeholder="{{ __('Ingrese el titulo del profesor(a)') }}" autofocus>

                                        @error('titulo')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Residencia --}}
                                <div class="form-group">
                                    <label>Residencia</label>

                                    <div class="input-group mb-3">
                                        <input type="text" name="direccion" id="direccion"
                                            class="form-control @error('direccion') is-invalid @enderror"
                                            value="{{ old('direccion') }}" placeholder="{{ __('Direccion') }}" autofocus>

                                        @error('direccion')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <input type="text" name="ciudad" id="ciudad"
                                            class="form-control @error('ciudad') is-invalid @enderror"
                                            value="{{ old('ciudad') }}" placeholder="{{ __('Ciudad') }}" autofocus>

                                        @error('ciudad')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <input type="text" name="estado" id="estado"
                                            class="form-control @error('estado') is-invalid @enderror"
                                            value="{{ old('estado') }}" placeholder="{{ __('Estado') }}" autofocus>

                                        @error('estado')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Telefono --}}
                                <div class="form-group mb-3">
                                    <label>Número de contacto</label>
                                    <input type="tel" name="telefono"
                                        class="form-control @error('estado') is-invalid @enderror"
                                        placeholder="{{ __('Número de teléfono, ej: 04124395155') }}" autofocus>

                                    @error('telefono')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- Fecha de nacimiento --}}
                                <div class="form-group mb-3">
                                    <label>Fecha de nacimiento</label>
                                    <div class="input-group date" id="fecha_nacimiento" data-target-input="nearest">
                                        <input type="text" name="fecha_de_nacimiento"
                                            class="form-control datetimepicker-input" data-target="#fecha_nacimiento"
                                            placeholder="{{ __('Ej: 1983-09-06') }}" />
                                        <div class="input-group-append" data-target="#fecha_nacimiento"
                                            data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Fecha de ingreso --}}
                                <div class="form-group mb-3">
                                    <label>Fecha de ingreso al plantel</label>
                                    <div class="input-group date" id="fecha_ingreso" data-target-input="nearest">
                                        <input type="text" name="fecha_ingreso_plantel"
                                            class="form-control datetimepicker-input" data-target="#fecha_ingreso"
                                            placeholder="{{ __('Ej: 2013-03-19') }}" />
                                        <div class="input-group-append" data-target="#fecha_ingreso"
                                            data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>


                                {{-- Botón de registrar --}}
                                <div class="row">
                                    <x-botones.cancelar />

                                    <x-botones.guardar />
                                </div>

                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-12 card table-responsive-sm p-3 mb-4">

            <table id='tabla' class="table table-striped">
                <thead>
                    <tr class="bg-secondary">
                        <th>Nombre</th>
                        <th>Titulo</th>
                        <th>Direccion</th>
                        <th>Telfono</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($profesores as $profesor)
                        <tr>
                            <td>{{ $profesor->usuario->nombre }} {{ $profesor->usuario->apellido }}</td>
                            <td>{{ $profesor->titulo }}</td>
                            <td>{{ $profesor->direccion }}/{{ $profesor->ciudad }}/{{ $profesor->estado }}
                            <td>{{ $profesor->telefono }}</td>
                            <td>
                                <a href="{{ route('profesores.show', $profesor) }}" class="btn btn-primary"
                                    style="width: 5rem">Ver</a>
                                <a href="{{ route('profesores.edit', $profesor) }}" class="btn btn-primary"
                                    style="width: 5rem">Editar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('/vendor/DataTables/datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@stop

@section('js')
    <script src="{{ asset('/vendor/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('vendor/moment/moment.js') }}"></script>
    <script src="{{ asset('vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('js/tablas.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $('#fecha_nacimiento').datetimepicker({
                format: 'YYYY-MM-DD'
            });
        });
        $(function() {
            $('#fecha_ingreso').datetimepicker({
                format: 'YYYY-MM-DD'
            });
        });
    </script>
    <script>
        @if ($message = session('creado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Profesor disponible!',
                html: 'Un nuevo facilitador ahora puede dictar una acreditable.',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('existente'))
            let timerInterval
            Swal.fire({
                icon: 'error',
                title: '¡Perfil de profesor ya registrado!',
                html: 'El usuario al que intenta asignar ya es profesor.',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('actualizado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Perfil actualizado!',
                html: 'El perfil del profesor se encuentra al dia.',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @endif
    </script>
@stop
