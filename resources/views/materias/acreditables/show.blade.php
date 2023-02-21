@extends('adminlte::page')

@section('title', 'Acreditables | Ver materia')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('materias.index') }}" class="link-muted">Materias</a></li>
    <li class="breadcrumb-item active"><a href="">{{ $materia->nom_materia }}</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Materias</x-tipografia.titulo>
@stop

@section('content')

    @if (!rol('Estudiante'))
        <div class="modal fade" id="nota" tabindex="-1" role="dialog" aria-labelledby="campoNota" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <header class="modal-header bg-primary">
                        <h5 class="modal-title" id="campoNota">Asignar nota</h5>
                    </header>

                    <main class="modal-body">

                        <h4 id="estudianteSeleccionado" class="border border-secondary p-3 rounded text-center"></h4>

                        <form id="asignarNota" action="{{ route('asignar.nota', 1) }}" method="post">
                            @csrf

                            <div class="form-group required mb-3">
                                <label for="campoNotaEstudiante" class="control-label">Nota del estudiante</label>
                                <div class="input-group">
                                    <input type="text" name="nota" id="campoNotaEstudiante"
                                        class="form-control @error('nota') is-invalid @enderror" value="{{ old('nota') }}"
                                        placeholder="{{ __('Nota: 1 - 100') }}" max="100" autofocus required>

                                    @error('nota')
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
    @endif

    @php
        $profesorID = auth()->user()->profesor->id ?? false;
        $materiaProfID = $materia->info->profesor_id ?? false;
        $validacion = $profesorID && $materiaProfID;
        
        $tipo = $materia->infoTipo() ?? null;
        $categoria = $materia->infoCategoria()->nom_categoria ?? null;
        $horario = !empty($materia->horario) ? $materia->horario->horarioEstructurado() : null;
        $acreditable = $materia->infoAcreditable() ?? null;
    @endphp

    <div class="row mt-2">

        <x-card.materia-perfil :materia="$materia" />

        <x-card.materia-desc :materia="$materia" />

        {{-- Tarjetas información materia --}}
        <section class="col-12 border-bottom">
            <div class="row">
                <x-elementos.mini-card nombre=Tipo :contenido="$tipo ?? 'Sin asignar'" />
                <x-elementos.mini-card nombre='Categoría' :contenido="$categoria ?? 'Sin asignar'" />
                <x-elementos.mini-card nombre='Horario' :contenido="$horario ?? 'Sin asignar'" />
                <x-elementos.mini-card nombre='Acreditable' :contenido="$acreditable ?? 'Sin asignar'" />
            </div>
        </section>

        {{-- Listado de estudiantes --}}
        <section class="col-12 my-3">
            @if ((rol('Coordinador') && !$inscritos->isEmpty()) || ($validacion && !$inscritos->isEmpty()))
                <a href="{{ route('listadoEstudiantes', $materia->id) }}" class="btn btn-primary float-right"
                    {{ Popper::arrow()->pop('Descargar listado de estudiantes') }}>
                    <i class="fas fa-download" style="width: 2rem"></i>
                </a>
            @endif

            <div class="card col-12 table-responsive-sm p-3">
                <table id='tabla' class="table table-striped">
                    <thead>
                        <tr class="bg-secondary">
                            @if (!rol('Estudiante'))
                                <th>Cédula</th>
                            @endif

                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Estado</th>

                            @if (!rol('Estudiante'))
                                <th>Código de Validación</th>
                                <th>Nota</th>
                                <th>Acciones</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($inscritos as $estudiante)
                            @php
                                $estudianteID = $estudiante->esEstudiante->id;
                                $inscritoID = $estudiante->id;
                                $inscritoID = $estudiante->id;
                                $CI = $estudiante->inscritoCI();
                                $nombre = $estudiante->inscritoSoloNombre();
                                $apellido = $estudiante->inscritoSoloApellido();
                                $validado = $estudiante->validado;
                                $codigo = $estudiante->codigo;
                                $nota = $estudiante->nota;
                                $ruta = $validado ? 'invalidacion' : 'validacion';
                            @endphp

                            <tr>
                                @if (!rol('Estudiante'))
                                    <td> {{ $CI }} </td>
                                @endif

                                <td> {{ $nombre }} </td>
                                <td> {{ $apellido }} </td>
                                <td class="font-weight-bold {{ $validado ? 'text-success' : 'text-danger' }}">
                                    {{ $validado ? 'Validado' : 'No validado' }}
                                </td>

                                @if (!rol('Estudiante'))
                                    <td> {{ $codigo }} </td>
                                    <td
                                        class="font-weight-bold text-{{ $nota >= 56 ? 'success' : 'danger' }} notaAsignadaEstudiante">
                                        {{ $nota }} </td>
                                    <td>
                                        <div class="btn-group mx-1" role="group" aria-label="Acciones">
                                            @can('materias.modificar')
                                            {{-- Comprobante / PDF --}}
                                                <a href="{{ route('comprobante', $estudianteID) }}" class="btn btn-danger"
                                                    {{ Popper::arrow()->pop('Comprobante de inscripción') }}>
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>

                                                {{-- Validar / invalidar --}}
                                                <form action="{{ route($ruta, $inscritoID) }}" method="POST">
                                                    @csrf

                                                    <button type="submit"
                                                        class="btn btn-{{ $validado ? 'secondary' : 'primary' }} rounded-0"
                                                        {{ Popper::arrow()->pop('Validar inscripción') }}>
                                                        <i class="fas {{ $validado ? 'fa-eraser' : 'fa-user-check' }}"></i>
                                                    </button>
                                                </form>
                                            @endcan

                                            {{-- Asignar nota --}}
                                            <button id="{{ $inscritoID }}" class="btn btn-primary notas"
                                                data-toggle="modal" data-target="#nota" data-CI="{{ $CI }}"
                                                data-estudiante="{{ $estudiante->inscritoNombre() }}"
                                                {{ Popper::arrow()->pop('Asignar nota') }} {{ !$validado ? 'disabled' : '' }}>
                                                <i class="fas fa-pen"></i>
                                            </button>

                                            {{-- Asistencia --}}
                                            <a href="{{ route('asistencias.edit', $inscritoID) }}"
                                                class="btn btn-primary" {{ Popper::arrow()->pop('Marcar asistencia') }}>
                                                <i class="fas fa-calendar"></i>
                                            </a>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/decoracion.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cambiarAcreditable.css') }}">
@stop

@section('js')
    @include('popper::assets')
    <script src="{{ asset('vendor/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>

    {{-- Personalizados --}}
    <script src="{{ asset('js/tablas.js') }}"></script>
    <script src="{{ asset('js/cambiarAcreditable.js') }}"></script>

    @if (!rol('Estudiante'))
        <script src="{{ asset('js/asignarNota.js') }}"></script>
    @endif

    {{-- Mensajes --}}
    <script>
        @if ($message = session('registrado'))
            Swal.fire({
                icon: 'success',
                title: '¡Inscripción exitosa!',
                html: 'Ya se encuentra inscrito en la materia, a continuación lleve el comprobante ubicado en su pefil a la Coordinación de Acreditables para finalizar su inscripción. <br>[<strong>Nota</strong>] <span class="text-muted"><a href="{{ route('profile.show') }}">Haga clic aquí</a> o vaya a su perfil (avatar al lado de su nombre) para descargar el comprobante.<span>',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('actualizado'))
            Swal.fire({
                icon: 'success',
                title: '¡Asistencia actualizada!',
                html: 'El registro de asistencia fue actualizado.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('finalizado'))
            Swal.fire({
                icon: 'info',
                title: '¡Fallo al inscribirse!',
                html: "{{ session('finalizado') }}",
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info px-5'
                },
            })
        @elseif ($message = session('invalidado'))
            Swal.fire({
                icon: 'info',
                title: '¡Estudiante invalidado!',
                html: 'El estudiante no podrá cursar esta acreditable.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger px-5'
                },
            })
        @elseif ($message = session('validado'))
            Swal.fire({
                icon: 'success',
                title: '¡Estudiante validado!',
                html: 'El estudiante ya puede cursar su acreditable.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('cambioExitoso'))
            Swal.fire({
                icon: 'success',
                title: '¡Acreditable cambiada!',
                html: 'Se ha cambiado de acreditable exitosamente.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('notaActualizada'))
            Swal.fire({
                icon: 'success',
                title: '¡Nota actualizada!',
                html: "La nota ha sido asignada al estudiante <strong>{{ session('notaActualizada') }}</strong> correctamente.",
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('no puede participar'))
            Swal.fire({
                icon: 'warning',
                title: '¡No puede cursar!',
                html: 'Este estudiante no se encuentra validado, en caso de que haya traído su comprobante por favor valídelo en la lista, hasta entonces no podrá tener asistencia o lo que es igual, no contará la acreditable.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger px-5'
                },
            })
        @endif
    </script>
@stop
