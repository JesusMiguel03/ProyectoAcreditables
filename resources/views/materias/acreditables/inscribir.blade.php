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

                    <div class="form-group text-justify" style="margin-bottom: -10px">
                        <strong class="text-info">Nota:</strong>
                        <p class="pl-2">
                            [Ctrl + clic] <span class="text-muted">Selección 1 a 1.</span>
                        </p>
                        <p class="pl-2" style="margin-top: -1rem">
                            [Shift + clic] <span class="text-muted">Selección múltiple..</span>
                        </p>
                        <p class="pl-2" style="margin-top: -1rem">
                            [Clic y arrastrar] <span class="text-muted">Selección múltiple..</span>
                        </p>
                    </div>

                    <div class="form-group required mb-3">
                        <label for="estudiantes" class="control-label">Estudiante</label>

                        @if (empty($no_inscritos))
                            <x-elementos.vacio :modelo="'estudiantes'" />
                        @else
                            <select name="estudiantes[]" class="js-example-basic-single form-control" multiple="multiple">
                                @foreach ($no_inscritos as $no_inscrito)
                                    <option value="{{ $no_inscrito->id }}">
                                        {{ datosUsuario($no_inscrito, 'Estudiante', 'CI') . ' - ' . datosUsuario($no_inscrito, 'Estudiante', 'nombreCompleto') }}
                                    </option>
                                @endforeach
                            </select>
                        @endif
                    </div>

                    <div class="form-group required mb-3">
                        <label for="materia_id" class="control-label">Materia</label>
                        <input type="text" class="form-control" value="{{ $materia->nom_materia }}" disabled readonly>
                        <input type="text" class="d-hidden" name="materia_id" value="{{ $materia->id }}" hidden>
                    </div>

                    <x-modal.mensaje-obligatorio />

                    <x-modal.footer-editar ruta="{{ route('materias.index') }}" />
                </form>
            </main>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/DataTables/datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/required.css') }}">
    <link rel="stylesheet" href="{{ asset('css/input.css') }}">
@stop

@section('js')
    <script src="{{ asset('js/tablas.js') }}"></script>
    <script src="{{ asset('vendor/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
    </script>
    <script>
        @if ($message = session('actualizado'))
            Swal.fire({
                icon: 'success',
                title: '¡Materia actualizada!',
                html: 'Los cambios en la materia han sido guardados exitosamente.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('creado'))
            Swal.fire({
                icon: 'success',
                title: '¡Materia añadida!',
                html: 'Materia registrada exitosamente.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('error'))
            Swal.fire({
                icon: 'error',
                title: '¡No se pudo registrar!',
                html: 'Uno de los campos no cumple los requisitos.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger px-5'
                },
            })
        @elseif ($message = session('usuario-invalido'))
            Swal.fire({
                icon: 'error',
                title: '¡No se pudo registrar!',
                html: 'El usuario a inscribir es inválido, por favor seleccione otro.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger px-5'
                },
            })
        @elseif ($message = session('materia-invalida'))
            Swal.fire({
                icon: 'error',
                title: '¡No se pudo registrar!',
                html: 'La materia a inscribir es inválida, por favor seleccione otra.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger px-5'
                },
            })
        @elseif ($message = session('registrado'))
            Swal.fire({
                icon: 'success',
                title: '¡Se ha inscrito exitosamente!',
                html: 'Ahora el estudiante pertenece a una materia.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @endif
    </script>
@stop
