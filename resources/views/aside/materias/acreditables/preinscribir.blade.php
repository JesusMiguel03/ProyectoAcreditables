@extends('adminlte::page')

@section('title', 'Acreditables | Inscribir')

@section('content_header')
    <div class="row">
        <div class="col-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('materias.index') }}" class="link-muted">Materias</a></li>
                <li class="breadcrumb-item active"><a href="">Inscribir</a></li>
            </ol>
        </div>

        <x-tipografia.periodo fase="{{ !empty($periodo->fase) ? $periodo->fase : '' }}"
            fecha="{{ !empty($periodo->inicio) ? explode('-', explode(' ', $periodo->inicio)[0])[0] : 'Sin asignar' }}" />
    </div>

    <x-tipografia.titulo>Inscripción</x-tipografia.titulo>
@stop

@section('content')
    <div class="col-md-6 col-sm-12 mx-auto">
        <div class="card">
            <header class="card-header bg-primary">
                <h5>Inscribir estudiantes</h5>
            </header>

            <main class="card-body">
                <form action="{{ route('preinscripcion.store') }}" method="post">
                    @csrf

                    <input type="text" class="d-none" name="validador" value="coord" hidden>

                    <div class="form-group text-justify" style="margin-bottom: -10px">
                        <p class="pl-2 text-muted"><strong>Nota:</strong> 
                            Para seleccionar 1 a 1 presione la tecla Ctrl y clic en cada estudiante.
                        </p>
                        <p class="pl-2 text-muted" style="margin-top: -1rem">
                            Para seleccionar varios presione la tecla Shift y clic en el primer y último estudiante.
                        </p>
                    </div>

                    <div class="form-group required mb-3">
                        <label for="usuario_id" class="control-label">Estudiante</label>
                        <select name="estudiantes[]" class="js-example-basic-single form-control" multiple="multiple">
                            @if (empty($no_preinscritos))
                                <option value="0" readonly>No hay estudiantes disponibles</option>
                            @else
                                @foreach ($no_preinscritos as $no_preinscrito)
                                    <option value="{{ $no_preinscrito->id }}">{{ $no_preinscrito->usuarios->nombre }}
                                        {{ $no_preinscrito->usuarios->apellido }}
                                        [{{ 'V-' . number_format($no_preinscrito->usuarios->cedula, 0, ',', '.') }}]
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-group required mb-3">
                        <label for="materia_id" class="control-label">Materia</label>
                        <input type="text" class="d-hidden" name="materia_id" value="{{ $materia->id }}" hidden>
                        <input type="text" class="form-control" value="{{ $materia->nom_materia }}" disabled readonly>
                    </div>

                    <div class="form-group" style="margin-bottom: -10px">
                        <p class="pl-2 text-danger"><strong>Nota:</strong> (*) Indica los campos que
                            son obligatorios.
                        </p>
                    </div>

                    {{-- Botón de registrar --}}
                    <div class="row">
                        <div class="col-6">
                            <a href="{{ route('materias.index') }}" class="btn btn-block btn-secondary">
                                <i class="fas fa-arrow-left mr-2"></i>
                                {{ __('Volver') }}
                            </a>
                        </div>

                        <div class="col-6">
                            <button type="submit" class="btn btn-block btn-success"
                                {{ empty($no_preinscritos) ? 'disabled' : '' }}>
                                <i class="fas fa-save mr-2"></i>
                                {{ __('Guardar') }}
                            </button>
                        </div>
                    </div>
                </form>
            </main>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('/vendor/DataTables/datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/required.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/select2/select2.min.css') }}">
@stop

@section('js')
    <script src="{{ asset('js/tablas.js') }}"></script>
    <script src="{{ asset('/vendor/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
    </script>
    <script>
        @if ($message = session('actualizado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Cambio exitoso!',
                html: 'Materia editada correctamente.',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('creado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Materia añadida!',
                html: 'Materia registrada correctamente.',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('error'))
            let timerInterval
            Swal.fire({
                icon: 'error',
                title: '¡No se pudo registrar!',
                html: 'Uno de los campos no cumple los requisitos.',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('usuario-invalido'))
            let timerInterval
            Swal.fire({
                icon: 'error',
                title: '¡No se pudo registrar!',
                html: 'El usuario a preinscribir es inválido, por favor seleccione otro.',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('materia-invalida'))
            let timerInterval
            Swal.fire({
                icon: 'error',
                title: '¡No se pudo registrar!',
                html: 'La materia a preinscribir es inválida, por favor seleccione otra.',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('registrado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Se ha preinscrito exitosamente!',
                html: 'Ahora el estudiante pertenece a una materia.',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @endif
    </script>
@stop
