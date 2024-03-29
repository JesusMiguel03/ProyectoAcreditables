@extends('adminlte::page')

@section('title', 'Acreditables | Ver materia')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('materias.index') }}" class="link-muted">Materias</a></li>
    <li class="breadcrumb-item active"><a href="">
            {{ $materia->nom_materia }} {{ $materia->trayecto->num_trayecto }}({{ $materia->estado_materia }})
        </a></li>
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
                                        placeholder="{{ __('Nota, en escala del 1 al 100') }}" max="100" required>

                                    @error('nota')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <x-modal.mensaje-obligatorio />

                            <div class="row">
                                <div class="col-6">
                                    <button id="cancelar" type="button" class="btn btn-block btn-secondary"
                                        data-dismiss="modal">
                                        <i class="fas fa-arrow-left mr-2"></i>
                                        {{ __('Cancelar') }}
                                    </button>
                                </div>

                                <div class="col-6">
                                    <button id="formularioNotas" type="submit" class="btn btn-block btn-success">
                                        <i class="fas fa-save mr-2"></i>
                                        {{ __('Guardar') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </main>
                </div>
            </div>
        </div>
    @endif

    @if (rol('Coordinador'))
        <div class="modal fade" id="listadoNotas" tabindex="-1" role="dialog" aria-labelledby="campoPDF"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <header class="modal-header bg-primary">
                        <h5 class="modal-title" id="campoPDF">Listado de estudiantes - Notas (PDF)</h5>
                    </header>

                    <main class="modal-body">
                        <form id="formPDF" action="" method="post">
                            @csrf

                            <div class="form-row">
                                <div class="col-md-8 col-sm-12 offset-md-2">
                                    <div class="form-group required mb-3">
                                        <label for="periodo">Periodos</label>

                                        <div class="input-group">
                                            <select name="periodo" id="periodo" class="form-control">
                                                <option value="0" readonly>Seleccione uno...</option>

                                                @foreach ($periodos as $periodo)
                                                    <option value="{{ $periodo->id }}">{{ $periodo->formato() }}</option>
                                                @endforeach
                                            </select>

                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-calendar"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-8 col-sm-12 offset-md-2">
                                    <button id="enviar" class="btn btn-block btn-secondary" disabled>Buscar</button>
                                </div>
                            </div>

                        </form>
                    </main>
                </div>
            </div>
        </div>
    @endif

    @php
        $profesorID = auth()->user()->profesor->id ?? null;
        $materiaProfID = $materia->info->profesor_id ?? false;
        $validacion = $profesorID === $materiaProfID;
        
        $tipo = $materia->info->metodologia ?? 'Sin asignar';
        $categoria = $materia->infoCategoria()->nom_categoria ?? 'Sin asignar';
        $horario = !empty($materia->horario) ? $materia->horario->horarioEstructurado() : 'Sin asignar';
        $acreditable = $materia->infoAcreditable() ?? 'Sin asignar';
        $finalizada = $materia->estado_materia === 'Finalizado';
        
        $url = route('materias.edit', $materia->id);
        $horarioUrl = route('horarios.index');
        
        $profesorDictaAcreditable = null;
        if (!empty($materia->profesorEncargado())) {
            $profesorDictaAcreditable = $profesorID === $materia->profesorEncargado()->id;
        }
    @endphp

    <div class="row mt-2">

        <x-card.materia-perfil :materia="$materia" />

        <x-card.materia-desc :materia="$materia" />

        {{-- Tarjetas información materia --}}
        <section class="col-12 border-bottom">
            <div class="row">
                <x-elementos.mini-card nombre='Metodología' :contenido="$tipo" :url="$url" />
                <x-elementos.mini-card nombre='Categoría' :contenido="$categoria" :url="$url" />
                <x-elementos.mini-card nombre='Horario' :contenido="$horario" :url="$horarioUrl" />
                <x-elementos.mini-card nombre='Acreditable' :contenido="$acreditable" :url="$url" />
            </div>
        </section>

        {{-- Listado de estudiantes --}}
        <section class="col-12 my-3">

            @if (($validacion && !empty($inscritos)) || (rol('Coordinador') && !empty($inscritos)))
                @if (rol('Coordinador'))
                    {{-- PDF --}}
                    <button class="btn btn-danger float-right" {{ Popper::arrow()->pop('PDF Notas de la acreditable') }}
                        data-toggle="modal" data-target="#listadoNotas">
                        <i class="fas fa-file-pdf" style="width: 2rem"></i>
                    </button>
                @endif

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

                            @if (rol('Estudiante'))
                                <th>Nota</th>
                            @endif

                            @if (rol('Profesor'))
                                <th>Nota</th>
                                @if ($profesorDictaAcreditable)
                                    <th>Acciones</th>
                                @endif
                            @endif

                            @if (rol('Coordinador'))
                                <th>Validación</th>
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
                                $CI = $estudiante->inscritoCI();
                                $nombre = $estudiante->inscritoSoloNombre();
                                $apellido = $estudiante->inscritoSoloApellido();
                                $validado = $estudiante->validado;
                                $codigo = $estudiante->codigo;
                                $nota = $estudiante->nota;
                                $ruta = $validado ? 'invalidacion' : 'validacion';
                                $aprobado = $estudiante->aprobado;
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

                                @if (rol('Coordinador'))
                                    <td> {{ $codigo }} </td>
                                @endif

                                <td
                                    class="font-weight-bold text-{{ $nota >= 56 ? 'success' : 'danger' }} notaAsignadaEstudiante">
                                    {{ $nota }}
                                </td>

                                @if (rol('Coordinador') || (rol('Profesor') && !empty($profesorDictaAcreditable)))
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
                                                        {{ $validado ? Popper::arrow()->pop('Invalidar inscripción') : Popper::arrow()->pop('Validar inscripción') }}>
                                                        <i class="fas {{ $validado ? 'fa-x' : 'fa-check' }}"></i>
                                                    </button>
                                                </form>
                                            @endcan

                                            {{-- Asignar nota --}}
                                            @if ($materia->estado_materia === 'Finalizado')
                                                <button id="{{ $inscritoID }}"
                                                    class="btn btn-primary notas {{ $validado && $finalizada ? '' : 'disabled' }}"
                                                    @if ($validado && $finalizada) data-toggle="modal" data-target="#nota" data-CI="{{ $CI }}"
                                                data-estudiante="{{ $estudiante->inscritoNombre() }}" {{ Popper::arrow()->pop('Asignar nota') }}
                                                @else
                                                {{ Popper::arrow()->pop('Debe validar la inscripción') }} @endif>
                                                    <i class="fas fa-pen"></i>
                                                </button>
                                            @else
                                                <button class="btn btn-primary disabled"
                                                    {{ Popper::arrow()->pop('Acreditable no finalizada') }}>
                                                    <i class="fas fa-pen"></i>
                                                </button>
                                            @endif

                                            {{-- Asistencia --}}
                                            <a href="{{ route('asistencias.edit', $inscritoID) }}"
                                                class="btn btn-primary" {{ Popper::arrow()->pop('Marcar asistencia') }}>
                                                <i class="fas fa-calendar"></i>
                                            </a>

                                            {{-- Boton de aprobar --}}
                                            @if (rol('Coordinador'))
                                                @if ($materia->estado_materia === 'Finalizado')
                                                    <form action="{{ route('estudiantes.aprobar', $inscritoID) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')

                                                        <button type="submit"
                                                            class="btn btn-{{ $aprobado !== 1 ? 'primary' : 'secondary' }} rounded-right {{ $aprobado === 1 ? 'disabled' : '' }}"
                                                            {{ $aprobado === 1
                                                                ? Popper::arrow()->pop('Estudiante aprobado')
                                                                : Popper::arrow()->pop('Aprobación del estudiante') }}>
                                                            <i class="fas fa-user-check"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <button class="btn btn-secondary rounded-right disabled"
                                                        {{ Popper::arrow()->pop('Acreditable no finalizada') }}>
                                                        <i class="fas fa-user-check"></i>
                                                    </button>
                                                @endif
                                            @endif
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

    {{-- Personalizado --}}
    <link rel="stylesheet" href="{{ asset('css/decoracion.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilosVarios/cambiarAcreditables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilosVarios/mensaje.css') }}">
    <link rel="stylesheet" href="{{ asset('css/iconos/x.css') }}">
    <link rel="stylesheet" href="{{ asset('css/anchoTabla.css') }}">
@stop

@section('js')
    @if (rol('Coordinador') || (rol('Profesor') && !empty($profesorDictaAcreditable)))
        @include('popper::assets')

        <script>
            const botones = document.querySelectorAll(".notas")
            const form = document.getElementById("asignarNota")
            const estudianteSeleccionado = document.getElementById("estudianteSeleccionado")
            const notasEstudiantes = document.querySelectorAll(".notaAsignadaEstudiante")
            const botonEnviar = document.getElementById("formularioNotas")
            const inputNota = document.getElementById("campoNotaEstudiante")

            botones.forEach((boton, index) => {
                boton.addEventListener("click", (e) => {
                    let CI = e.currentTarget.getAttribute("data-CI")
                    let estudiante = e.currentTarget.getAttribute("data-estudiante")
                    let ID = e.currentTarget.id

                    inputNota.value = notasEstudiantes[index].innerText

                    estudianteSeleccionado.innerText = `CI: (${CI}) ${estudiante}`
                    form.action = `/estudiantes/${ID}/nota`
                })
            })

            botonEnviar.addEventListener("click", () => {
                form.submit()
            })
        </script>
        {{-- <script src="{{ asset('js/asignarNota.js') }}"></script> --}}
    @endif
    <script src="{{ asset('vendor/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>

    {{-- Personalizados --}}
    <script src="{{ asset('js/tablas.js') }}"></script>

    @if (rol('Estudiante'))
        <script src="{{ asset('js/cambiarAcreditable.js') }}"></script>
    @endif

    @if (rol('Coordinador'))
        <script>
            const inputPeriodo = document.getElementById('periodo')
            const boton = document.getElementById('enviar')
            const formPDF = document.getElementById('formPDF')

            // Busca el periodo seleccionado, si no hay alguno se coloca 0
            let periodo = inputPeriodo.options[inputPeriodo.selectedIndex].value || 0

            // Cada vez que se escoja un periodo
            inputPeriodo.addEventListener('change', (e) => {
                periodo = inputPeriodo.options[inputPeriodo.selectedIndex].value

                // Si es 0 inhabilita el boton
                periodo > 0 ?
                    boton.removeAttribute('disabled') :
                    boton.disabled = true
            })

            // Si es diferente de 0 entonces enviar el formulario
            boton.addEventListener('click', (e) => {
                e.preventDefault()

                let url = "{{ route('materias.pdf') }}"

                formPDF.action = `${url}/{{ $materia->id }}/${periodo}`
                formPDF.submit()
            })
        </script>
    @endif

    {{-- Mensajes --}}
    <script>
        @if ($message = session('registrado'))
            Swal.fire({
                width: '40rem',
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
                icon: 'warning',
                title: '¡Estudiante invalidado!',
                html: 'El estudiante no podrá cursar esta acreditable.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-warning px-5'
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
                width: '40rem',
                icon: 'warning',
                title: '¡No puede cursar!',
                html: 'Este estudiante no se encuentra validado, en caso de que haya traído su comprobante por favor valídelo en la lista, hasta entonces no podrá tener asistencia o lo que es igual, no contará la acreditable.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger px-5'
                },
            })
        @elseif ($message = session('noFinalizado'))
            Swal.fire({
                icon: 'info',
                title: '¡Materia no finalizada!',
                html: "{{ session('noFinalizado') }}",
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info px-5'
                },
            })
        @elseif ($message = session('aprobar'))
            Swal.fire({
                icon: "{{ $message['icono'] }}",
                title: "{{ $message['titulo'] }}",
                html: "{{ $message['html'] }}",
                buttonsStyling: false,
                customClass: {
                    confirmButton: "btn btn-{{ $message['color'] }} px-5"
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
        @elseif ($message = session('inactivo'))
            Swal.fire({
                icon: "info",
                title: "No se pudo encontrar",
                html: "{{ $message['inactivo'] }}",
                buttonsStyling: false,
                customClass: {
                    confirmButton: "btn btn-info px-5"
                },
            })
        @elseif ($message = session('solicitudInvalida'))
            Swal.fire({
                icon: "warning",
                title: "No se pudo encontrar",
                html: "{{ session('solicitudInvalida') }}",
                buttonsStyling: false,
                customClass: {
                    confirmButton: "btn btn-warning px-5"
                },
            })
            $('#listadoNotas').modal('show')
        @elseif ($message = session('noEstudiantes'))
            Swal.fire({
                icon: "info",
                title: "Estudiantes no encontrados",
                html: "{{ session('noEstudiantes') }}",
                buttonsStyling: false,
                customClass: {
                    confirmButton: "btn btn-info px-5"
                },
            })
        @elseif (session('asistencia'))
            Swal.fire({
                icon: 'success',
                title: '¡Asistencia actualizada!',
                html: "{{ session('asistencia') }}",
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @endif
    </script>
@stop
