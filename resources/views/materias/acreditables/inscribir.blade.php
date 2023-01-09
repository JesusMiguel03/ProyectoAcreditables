@extends('adminlte::page')

@section('title', 'Acreditables | Inscribir')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('materias.index') }}" class="link-muted">Materias</a></li>
    <li class="breadcrumb-item active"><a href="">Inscribir</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Inscripción</x-tipografia.titulo>
@stop

@section('content')
    <div class="col-md-6 col-sm-12 mx-auto">
        <div class="card">
            <header class="card-header bg-primary">
                <h5>Inscribir estudiantes</h5>
            </header>

            <main class="card-body">
                <form action="{{ route('inscripcion.store') }}" method="post">
                    @csrf

                    <input type="text" class="d-none" name="validador" value="coord" hidden>

                    <div class="form-group text-justify" style="margin-bottom: -10px">
                        <strong class="text-info">Nota:</strong>
                        <p class="pl-2">
                            [Ctrl + clic] <span class="text-muted">Selección 1 a 1.</span>
                        </p>
                        <p class="pl-2" style="margin-top: -1rem">
                            [Shift + clic] <span class="text-muted">Selección múltiple..</span>
                        </p>
                    </div>

                    <div class="form-group required mb-3">
                        <label for="usuario_id" class="control-label">Estudiante</label>
                        <select name="estudiantes[]" class="js-example-basic-single form-control" multiple="multiple">
                            @if (empty($no_inscritos))
                                <option value="0" readonly>No hay estudiantes disponibles</option>
                            @else
                                @foreach ($no_inscritos as $no_inscrito)
                                    <option value="{{ $no_inscrito->id }}">
                                        {{ parsearCedula(usuario($no_inscrito->usuario, 'cedula')) }} - 
                                        {{ usuario($no_inscrito->usuario, 'nombreCompleto') }}
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

                    <x-modal.mensaje-obligatorio />

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
                                {{ empty($no_inscritos) ? 'disabled' : '' }}>
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
                confirmButtonColor: '#28a745',
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
                confirmButtonColor: '#28a745',
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
                confirmButtonColor: '#dc3545',
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
                confirmButtonColor: '#dc3545',
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
                confirmButtonColor: '#dc3545',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('registrado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Se ha inscrito exitosamente!',
                html: 'Ahora el estudiante pertenece a una materia.',
                confirmButtonColor: '#28a745',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @endif
    </script>
@stop
