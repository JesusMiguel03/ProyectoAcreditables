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
    @php
        $mensajes = [['comando' => 'Ctrl + clic', 'accion' => 'Selección 1 a 1.'], ['comando' => 'Shift + clic', 'accion' => 'Selección múltiple.'], ['comando' => 'Clic y arrastrar', 'accion' => 'Selección múltiple.'], ['comando' => 'Clic y Ctrl + a', 'accion' => 'Selecciona a todos.']];
    @endphp
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

                        @foreach ($mensajes as $index => $mensaje)
                            <p class="pl-2{{ $index > 0 ? ' mt-n3' : '' }}">
                                [{{ $mensaje['comando'] }}] <span class="text-muted">{{ $mensaje['accion'] }}</span>
                            </p>
                        @endforeach
                    </div>

                    <div class="form-group required mb-3">
                        <label for="estudiantes" class="control-label">Estudiante</label>

                        @if (empty($no_inscritos))
                            <x-elementos.vacio :modelo="'estudiantes'" />
                        @else
                            <select name="estudiantes[]" class="js-example-basic-single form-control" multiple="multiple">
                                @foreach ($no_inscritos as $estudiante)
                                    <option value="{{ $estudiante->id }}">
                                        {{ $estudiante->estudianteCI() . ' - ' . $estudiante->nombreEstudiante() }}
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

                    <x-modal.footer-editar sinEstudiantes="{{ !count($no_inscritos) > 0 }}"
                        ruta="{{ route('materias.index') }}" />
                </form>
            </main>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('vendor/DataTables/datatables.min.css') : asset('vendor/DataTables/datatables.min.css') }}" />
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('vendor/sweetalert2/bootstrap-4.min.css') : asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('vendor/select2/select2.min.css') : asset('vendor/select2/select2.min.css') }}">
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('css/estilosVarios/required.css') : asset('css/estilosVarios/required.css') }}">
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('css/estilosVarios/input.css') : asset('css/estilosVarios/input.css') }}">
@stop

@section('js')
    <script src="{{ request()->secure() ? secure_asset('js/tablas.js') : asset('js/tablas.js') }}"></script>
    <script
        src="{{ request()->secure() ? secure_asset('vendor/DataTables/datatables.min.js') : asset('vendor/DataTables/datatables.min.js') }}">
    </script>
    <script
        src="{{ request()->secure() ? secure_asset('vendor/sweetalert2/sweetalert2.min.js') : asset('vendor/sweetalert2/sweetalert2.min.js') }}">
    </script>
    <script
        src="{{ request()->secure() ? secure_asset('vendor/select2/select2.min.js') : asset('vendor/select2/select2.min.js') }}">
    </script>

    {{-- Multi select --}}
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
    </script>

    {{-- Mensajes --}}
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
        @elseif ($message = session('periodoFinalizado'))
            Swal.fire({
                icon: "info",
                title: "Actualice el periodo",
                html: "{{ $message['periodoFinalizado'] }}",
                buttonsStyling: false,
                customClass: {
                    confirmButton: "btn btn-info px-5"
                },
            })
        @endif
    </script>
@stop
