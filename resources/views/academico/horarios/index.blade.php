@extends('adminlte::page')

@section('title', 'Acreditables | Horarios')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item active"><a href="">Horarios</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Horarios</x-tipografia.titulo>

    @can('academico')
        {{-- Horario dinamico --}}
        <div class="modal fade" id="horario" tabindex="-1" role="dialog" aria-labelledby="campohora" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <header class="modal-header bg-primary">
                        <h5 class="modal-title" id="campohora">Agregar hora</h5>
                    </header>

                    <main class="modal-body">
                        <form action="{{ route('horarios.store') }}" method="post">
                            @csrf

                            <label for="horaSeleccionada">Día y hora</label>
                            <input type="text" id="horaSeleccionada" name="horaSeleccionada" class="form-control mb-3"
                                value="{{ old('horaSeleccionada') }}" readonly>

                            <section class="form-group required">

                                <input type="number" id="dia" name="dia" hidden>
                                <input type="text" id="hora" name="hora" hidden>
                                <input type="text" id="campo" name="campo" hidden>

                                <article class="form-row">
                                    <div class="form-group col-6">
                                        <label class="control-label">Espacio</label>

                                        <input type="text" name="espacio" id="espacio"
                                            class="form-control @error('espacio') is-invalid @enderror"
                                            value="{{ $espacio ?? old('espacio') }}"
                                            placeholder="{{ __('Espacio a ocupar, Ej: (Edificio B) o solo (B)') }}"
                                            maxlength="{{ config('variables.horarios.espacio') }}" pattern="[A-zÀ-ÿ0-9\s]+" title="Debe contener letras, espacios y/o números." 
                                            autofocus required>

                                        @error('espacio')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="aula">Número del aula</label>

                                        <div class="input-group">

                                            <input type="number" name="aula" id="aula"
                                                class="form-control @error('aula') is-invalid @enderror"
                                                value="{{ $aula ?? old('aula') }}" placeholder="{{ __('Ej: 7') }}"
                                                max="{{ config('variables.horarios.aula') }}" title="No debe ser mayor a {{ config('variables.horarios.aula') }}">


                                            @error('aula')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </article>

                                <article class="form-group required">
                                    <label for="materia_id" class="control-label">Materia</label>

                                    <select id="materia_id" class="form-control @error('materia_id') is-invalid @enderror"
                                        name="materia_id" required>

                                        <option value="" readonly>Seleccione...</option>

                                        @foreach ($materias as $materia)
                                            <option value="{{ $materia->id }}">{{ $materia->nom_materia }}</option>
                                        @endforeach
                                    </select>

                                    @error('materia_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </article>
                            </section>

                            <x-modal.footer-aceptar />
                        </form>
                    </main>
                </div>
            </div>
        </div>

        <section>
            <form id="form" action="" method="get">
                @csrf
            </form>

            <form id="actualizar" action="" method="post">
                @csrf
                {{ @method_field('PUT') }}

                <input type="text" name="actualizar" value="conHora" hidden>
                <input type="number" id="diaActualizar" name="diaActualizar" hidden>
                <input type="text" id="horaActualizar" name="horaActualizar" hidden>
                <input type="text" id="campoActualizar" name="campoActualizar" hidden>
            </form>
        </section>
    @endcan
@stop

@section('content')
    @php
        $horas = [['7:30', '8:15'], ['8:15', '9:00'], ['9:00', '9:50'], ['9:50', '10:35'], ['10:35', '11:25'], ['11:25', '12:10'], ['12:10', '1:00']];
    @endphp

    <section class="card p-3">

        <article class="row mx-auto my-2 px-2">
            <strong>Nota:</strong>
            <div class="row">
                <div class="col-11">
                    <p class="pl-2 text-muted">
                        Para añadir un nuevo horario haga clic en cualquier celda en la tabla a continuación.
                    </p>
                </div>
                <div class="col-11">
                    <p class="pl-2 mt-n3 text-muted">
                        Para editar un horario existente haga clic en la etiqueta correspondiente.
                    </p>
                </div>
                <div class="col-10 mt-n3">
                    <span class="pl-2 text-muted">Cada color representa un espacio</span>
                    <p class="badge badge-primary">Edificio A</p>
                    <p class="badge badge-success">Edificio B</p>
                    <p class="badge badge-info">Edificio C</p>
                    <p class="badge badge-dark">Laboratorios</p>
                    <p class="badge badge-secondary">Otros</p>
                </div>
            </div>

            <section class="col-12">
                <div class="row float-right">
                    <a href="{{ route('horarios.pdf') }}" class="btn btn-primary"
                        {{ Popper::arrow()->pop('Descargar horario') }}>
                        <i class="fas fa-download" style="width: 2rem"></i>
                    </a>

                    <form id="form-borrar" action="{{ route('horarios.vaciar') }}" method="POST">
                        @csrf

                        <button id="borrar" class="btn btn-danger ml-2" {{ Popper::arrow()->pop('Vaciar horario') }}>
                            <i class="fas fa-trash" style="width: 2rem"></i>
                        </button>
                    </form>
                </div>
            </section>
        </article>

        <table class="table table-striped table-bordered">
            <thead>
                <tr class="table-active">
                    <th class="hora align-middle">Hora</th>
                    <th class="align-middle">Lunes</th>
                    <th class="align-middle">Martes</th>
                    <th class="align-middle">Miércoles</th>
                    <th class="align-middle">Jueves</th>
                    <th class="align-middle">Viernes</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($horas as $index => $hora)
                    @php
                        $color = ['A' => 'primary', 'B' => 'success', 'C' => 'info', 'Laboratorio' => 'dark'];
                    @endphp

                    <tr data-numero="{{ $index }}">
                        <td>
                            <div class="text-center">
                                <p class="mb-n2">{{ $hora[0] }}</p>
                                <p class="mb-n1">a</p>
                                <p>{{ $hora[1] }}</p>
                            </div>
                        </td>
                        <td class="seleccionable" data-index={{ $loop->index }} data-dia="lunes" data-toggle="modal"
                            data-target="#horario">
                            @foreach ($horarios as $horario)
                                @if (!empty($horario) && $horario->campo === "lu${index}")
                                    <span id="{{ $horario->id }}"
                                        class="materia badge badge-{{ $color[$horario->espacio] ?? 'secondary' }}"
                                        draggable="true">{{ $horario->materia->nom_materia }}
                                        ({{ "$horario->espacio $horario->aula" }})
                                    </span>
                                @endif
                            @endforeach
                        </td>
                        <td class="seleccionable" data-index={{ $loop->index }} data-dia="martes" data-toggle="modal"
                            data-target="#horario">
                            @foreach ($horarios as $horario)
                                @if (!empty($horario) && $horario->campo === "ma${index}")
                                    <span id="{{ $horario->id }}"
                                        class="materia badge badge-{{ $color[$horario->espacio] ?? 'secondary' }}"
                                        draggable="true">{{ $horario->materia->nom_materia }}
                                        ({{ "$horario->espacio $horario->aula" }})
                                    </span>
                                @endif
                            @endforeach
                        </td>
                        <td class="seleccionable" data-index={{ $loop->index }} data-dia="miercoles"
                            data-toggle="modal" data-target="#horario">
                            @foreach ($horarios as $horario)
                                @if (!empty($horario) && $horario->campo === "mi${index}")
                                    <span id="{{ $horario->id }}"
                                        class="materia badge badge-{{ $color[$horario->espacio] ?? 'secondary' }}"
                                        draggable="true">{{ $horario->materia->nom_materia }}
                                        ({{ "$horario->espacio $horario->aula" }})
                                    </span>
                                @endif
                            @endforeach
                        </td>
                        <td class="seleccionable" data-index={{ $loop->index }} data-dia="jueves" data-toggle="modal"
                            data-target="#horario">
                            @foreach ($horarios as $horario)
                                @if (!empty($horario) && $horario->campo === "ju${index}")
                                    <span id="{{ $horario->id }}"
                                        class="materia badge badge-{{ $color[$horario->espacio] ?? 'secondary' }}"
                                        draggable="true">{{ $horario->materia->nom_materia }}
                                        ({{ "$horario->espacio $horario->aula" }})
                                    </span>
                                @endif
                            @endforeach
                        </td>
                        <td class="seleccionable" data-index={{ $loop->index }} data-dia="viernes" data-toggle="modal"
                            data-target="#horario">
                            @foreach ($horarios as $horario)
                                @if (!empty($horario) && $horario->campo === "vi${index}")
                                    <span id="{{ $horario->id }}"
                                        class="materia badge badge-{{ $color[$horario->espacio] ?? 'secondary' }}"
                                        draggable="true">{{ $horario->materia->nom_materia }}
                                        ({{ "$horario->espacio $horario->aula" }})
                                    </span>
                                @endif
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">

    {{-- Personalizados --}}
    <link rel="stylesheet" href="{{ asset('css/estilosVarios/required.css') }}">
    <link rel="stylesheet" href="{{ asset('css/horarios.css') }}">
@stop

@section('js')
    @include('popper::assets')
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('vendor/DataTables/datatables.min.js') }}"></script>

    {{-- Personalizados --}}
    <script src="{{ asset('js/tablas.js') }}"></script>

    <script>
        const form = document.getElementById('form-borrar')
        const boton = document.getElementById('borrar')

        boton.addEventListener('click', (e) => {
            e.preventDefault()

            Swal.fire({
                title: "¿Está seguro?",
                html: 'Se borrarán todas las horas',
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Confirmar",
                cancelButtonText: "Cancelar",
                buttonsStyling: false,
                customClass: {
                    confirmButton: "btn btn-danger px-5 mr-2",
                    cancelButton: "btn btn-secondary px-5 ml-2",
                },

            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit()
                }
            })
        })
    </script>

    {{-- Horario dinamico --}}
    <script>
        const horaSeleccionada = document.getElementById('horaSeleccionada')
        const casillas = document.querySelectorAll('.seleccionable')

        const materiasEnHorario = document.querySelectorAll('.materia')

        const celdaHora = document.querySelectorAll('[data-numero]')

        const horas = [
            ['7:30 AM', '8:15 AM'],
            ['8:15 AM', '9:00 AM'],
            ['9:00 AM', '9:50 AM'],
            ['9:50 AM', '10:35 AM'],
            ['10:35 AM', '11:25 AM'],
            ['11:25 AM', '12:10 PM'],
            ['12:10 PM', '1:00 PM']
        ];

        let [inputDia, inputHora, inputCampo] = ['', '', '']

        const cargarInformacion = (e, actualizar = '') => {
            let dia = e.getAttribute('data-dia')
            let hora = e.getAttribute('data-index')

            if (actualizar !== 'actualizar') {
                [inputDia, inputHora, inputCampo] = [
                    document.getElementById('dia'),
                    document.getElementById('hora'),
                    document.getElementById('campo'),
                ]
            } else {
                [inputDia, inputHora, inputCampo] = [
                    document.getElementById('diaActualizar'),
                    document.getElementById('horaActualizar'),
                    document.getElementById('campoActualizar'),
                ]
            }

            const dias = {
                lunes: `Lunes - ${horas[hora][0]} a ${horas[hora][1]}.`,
                martes: `Martes - ${horas[hora][0]} a ${horas[hora][1]}.`,
                miercoles: `Miércoles - ${horas[hora][0]} a ${horas[hora][1]}.`,
                jueves: `Jueves - ${horas[hora][0]} a ${horas[hora][1]}.`,
                viernes: `Viernes - ${horas[hora][0]} a ${horas[hora][1]}.`,
            }

            const diasNumero = {
                lunes: 0,
                martes: 1,
                miercoles: 2,
                jueves: 3,
                viernes: 4
            }

            horaSeleccionada.value = dias[dia]
            inputDia.value = diasNumero[dia]
            inputHora.value = horas[hora][0]
            inputCampo.value = `${dia.slice(0, 2)}${e.parentNode.getAttribute('data-numero')}`
        }

        materiasEnHorario.forEach(materia => {
            materia.addEventListener('click', (e) => {
                e.stopPropagation()

                let [form, id] = [document.getElementById('form'), e.currentTarget.id]

                form.action = `${this.location.href}/${id}/edit`
                form.submit()
            })

            materia.addEventListener('dragstart', (e) => {
                e.dataTransfer.setData('test', e.target.id)
                e.dataTransfer.effectAllowed = 'move'
            })

            materia.addEventListener('dragend', (e) => {
                cargarInformacion(e.currentTarget.parentNode, 'actualizar')

                let [form, id] = [document.getElementById('actualizar'), e.currentTarget.id]

                form.action = `${this.location.href}/${id}/update`
                form.submit()
            })

            casillas.forEach(casilla => {
                casilla.addEventListener('dragover', (e) => {
                    e.preventDefault()
                    e.dataTransfer.dropEffect = 'move'
                })

                casilla.addEventListener('drop', (e) => {
                    e.preventDefault()

                    const data = e.dataTransfer.getData('test')
                    let element = document.getElementById(data)

                    e.target.appendChild(element)
                })
            })
        })

        casillas.forEach(casilla => {
            casilla.addEventListener('click', (e) => {
                cargarInformacion(e.currentTarget)
            })
        })
    </script>

    {{-- Mensajes --}}
    <script>
        @if ($message = session('creado'))
            Swal.fire({
                icon: 'success',
                title: '¡Hora registrada!',
                html: 'Una nueva hora ha sido añadida.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('error'))
            Swal.fire({
                icon: 'error',
                title: '¡Error al registrar!',
                html: 'Uno de los parámetros parece estar mal.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger px-5'
                },
            })
            $('#formulario').toggleClass('d-none')
            $('#opciones').toggleClass('d-none')
            $('#horario').modal('show')
        @elseif ($message = session('actualizado'))
            Swal.fire({
                icon: 'success',
                title: '¡Datos actualizados!',
                html: 'El horario ha sido actualizado.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('borrado'))
            Swal.fire({
                icon: 'success',
                title: '¡Hora borrada!',
                html: 'La hora ha sido borrada exitosamente.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('registrado'))
            Swal.fire({
                icon: 'info',
                title: '¡Ya registrada!',
                html: 'La hora se encuentra registrada.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info px-5'
                },
            })
            $('#registrar').modal('show')
        @elseif ($message = session('no encontrado'))
            Swal.fire({
                icon: 'error',
                title: '¡Hora no encontrada!',
                html: 'La hora que desea buscar no se encuentra disponible.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info px-5'
                },
            })
        @endif
    </script>
@stop
