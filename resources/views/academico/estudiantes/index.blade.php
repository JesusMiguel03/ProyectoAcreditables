@extends('adminlte::page')

@section('title', 'Acreditables | Estudiantes')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item active"><a href="">Estudiantes</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Listado de estudiantes</x-tipografia.titulo>

    {{-- Registrar usuario --}}
    <div class="modal fade" id="registrar" tabindex="-1" role="dialog" aria-labelledby="camporegistrar" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <header class="modal-header bg-primary">
                    <h5 class="modal-title" id="camporegistrar">Registrar usuario como estudiante</h5>
                </header>

                <main class="modal-body">
                    <form action="{{ route('registrar.usuario', 'Estudiante') }}" method="post">
                        @csrf

                        <x-formularios.usuario />
                    </form>
                </main>
            </div>
        </div>
    </div>

    {{-- Comprobantes --}}
    <div class="modal fade" id="comprobantes" tabindex="-1" role="dialog" aria-labelledby="campoComprobantes"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <header class="modal-header bg-primary">
                    <h5 class="modal-title" id="campoComprobantes">Comprobantes del estudiante</h5>
                </header>

                <main class="modal-body">
                    <section id="seccionComprobantes" class="row"></section>
                </main>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="col-12 card table-responsive-sm p-3 my-3">

        <div class="w-100 row mx-auto">
            <div class="col-md-2 col">
                <button class="btn btn-block btn-primary my-2" data-toggle="modal" data-target="#registrar"
                    {{ Popper::arrow()->pop('Nueva estudiante') }}>
                    <i class="fas fa-plus mr-2"></i>
                    {{ 'Añadir' }}
                </button>
            </div>
        </div>

        <table id='tabla' class="table table-striped">
            <thead>
                <tr class="bg-secondary">
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>PNF</th>
                    <th>Trayecto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $usuario)

                @php
                    $CI = $usuario->nacionalidad . '-' . number_format($usuario->cedula, 0, '', '.');
                    $nombre = $usuario->nombre;
                    $apellido = $usuario->apellido;
                    $pnf = $usuario->estudiante->pnf->nom_pnf ?? 'Sin asignar';
                    $trayecto = $usuario->estudiante->trayecto->num_trayecto ?? 'Sin asignar';
                    $inscrito = $usuario->estudiante->inscrito ?? null;
                    $estudianteID = $usuario->estudiante->id ?? null;
                @endphp
                    <tr>
                        <td>{{ $CI }}</td>
                        <td>{{ $nombre }}</td>
                        <td>{{ $apellido }}</td>
                        <td>{{ $pnf }}</td>
                        <td>{{ $trayecto }}</td>
                        <td>
                            <div class="btn-group mx-1" role="group" aria-label="Acciones">
                                <a href="{{ route('estudiantes.edit', $usuario) }}" class="btn btn-primary"
                                    {{ Popper::arrow()->pop('Editar perfil') }}>
                                    <i class="fas fa-edit"></i>
                                </a>

                                @if ($inscrito && !$inscrito->isEmpty())
                                    @if (count($inscrito) === 1)
                                        <a href="{{ route('comprobante', $estudianteID) }}"
                                            class="btn btn-danger mr-2"
                                            {{ Popper::arrow()->pop('Comprobante de inscripción') }}>
                                            <i class="fas fa-file-pdf" style="width: 15px"></i>
                                        </a>
                                    @else
                                        <button class="btn btn-danger mr-2" data-listarComprobantes="true"
                                            data-estudiante="{{ $estudianteID }}"
                                            data-comprobantes="{{ count($inscrito) }}"
                                            data-toggle="modal" data-target="#comprobantes"
                                            {{ Popper::arrow()->pop('Comprobante de inscripción') }}>
                                            <i class="fas fa-file-pdf" style="width: 15px"></i>
                                        </button>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/DataTables/datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">

    {{-- Personalizados --}}
    <link rel="stylesheet" href="{{ asset('css/estilosVarios/required.css') }}">
@stop

@section('js')
    @include('popper::assets')
    <script src="{{ asset('vendor/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>

    {{-- Personalizados --}}
    <script src="{{ asset('js/tablas.js') }}"></script>
    <script src="{{ asset('js/listadoComprobantes.js') }}"></script>

    {{-- Validaciones --}}
    <script>
        const nombre = document.getElementById('nombre')
        const apellido = document.getElementById('apellido')
        const nacionalidad = document.getElementById('nacionalidad')
        const cedula = document.getElementById('cedula')
        const contrasena = document.getElementById('contrasena')
        const confirmarContrasena = document.getElementById('confirmarContrasena')
        const correo = document.getElementById('correo')
        const boton = document.getElementById('registrarUsuario')

        const validarCorreo =
            /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/
        const nacionalidades = ['V', 'E', 'P']

        // Validaciones de cada campo
        let [
            validacionNombre, validacionApellido, validacionNacionalidad, validacionCedula, validacionCorreo,
            validacionContrasena, validacionConfirmarContrasena
        ] = [
            nombre.value.length > 3 && nombre.value.length < 21,
            apellido.value.length > 3 && apellido.value.length < 21,
            nacionalidad.options[nacionalidad.selectedIndex].value > 0,
            cedula.value.toString().length > 6 && cedula.value.toString().length < 9,
            validarCorreo.test(correo.value),
            contrasena.value.length > 3 && contrasena.value.length < 9,
            confirmarContrasena.value.length > 3 && confirmarContrasena.value.length < 9
        ]

        // Validacion de todo el formulario
        const formularioValidado = () => {
            if (validacionNombre && validacionApellido && validacionNacionalidad && validacionCedula &&
                validacionCorreo &&
                validacionContrasena && validacionConfirmarContrasena) {
                boton.removeAttribute('disabled')
            } else {
                boton.disabled = true
            }
        }

        nombre.addEventListener('input', (e) => {
            nombre.value = nombre.value.replace(/[^A-zÀ-ÿ\s]+/g, '')
            nombre.value = nombre.value.replace(/ {2,}/g, '')

            if (nombre.value.length > 20) {
                nombre.value = nombre.value.slice(0, 20)
            }

            if (/^\p{L}+(?:\s+\p{L}+)*$/u.test(nombre.value)) {
                if (nombre.value.length > 2 && nombre.value.length < 21) {
                    nombre.classList.remove('is-invalid')
                    validacionNombre = true
                } else {
                    nombre.classList.add('is-invalid')
                    validacionNombre = false
                }
            } else {
                nombre.classList.add('is-invalid')
                validacionNombre = false
            }

            formularioValidado()
        })

        apellido.addEventListener('input', (e) => {
            apellido.value = apellido.value.replace(/[^A-zÀ-ÿ\s]+/g, '')
            apellido.value = apellido.value.replace(/ {2,}/g, '')

            if (apellido.value.length > 20) {
                apellido.value = apellido.value.slice(0, 20)
            }

            if (/^\p{L}+(?:\s+\p{L}+)*$/u.test(apellido.value)) {
                if (apellido.value.length > 2 && apellido.value.length < 21) {
                    apellido.classList.remove('is-invalid')
                    validacionApellido = true
                } else {
                    apellido.classList.add('is-invalid')
                    validacionApellido = false
                }
            } else {
                apellido.classList.add('is-invalid')
                validacionApellido = false
            }

            formularioValidado()
        })

        nacionalidad.addEventListener('change', (e) => {
            if (nacionalidades.includes(nacionalidad.options[nacionalidad.selectedIndex].value)) {
                validacionNacionalidad = true
                nacionalidad.classList.remove('is-invalid')
            } else {
                validacionNacionalidad = false
                nacionalidad.classList.add('is-invalid')
            }

            formularioValidado()
        })

        cedula.addEventListener('input', (e) => {
            if (cedula.value.toString().length > 8) {
                cedula.value = cedula.value.toString().slice(0, 8)
            }

            cedula.value = cedula.value.toString().replace('e', '')

            // Si la cédula tiene entre 7 y 8 digitos
            if (cedula.value.toString().length > 6 && cedula.value.toString().length < 9) {
                cedula.classList.remove('is-invalid')
                validacionCedula = true
            } else {
                cedula.classList.add('is-invalid')
                validacionCedula = false
            }

            formularioValidado()
        })

        contrasena.addEventListener('input', (e) => {
            // Si la contraseña es mayor a 8 caracteres elimina a apartir del 9
            if (contrasena.value.length > 8) {
                contrasena.value = contrasena.value.slice(0, 8)
            }

            if (contrasena.value.length > 3 && contrasena.value.length < 9) {
                validacionContrasena = true
            } else {
                validacionContrasena = false
            }

            // Si es menor a 4 caracteres añade una clase como advertencia
            contrasena.value.length < 4 ?
                contrasena.classList.add('is-invalid') :
                contrasena.classList.remove('is-invalid')

            /**
             * Si el valor del campo contraseña y la confirmacion son diferentes
             * añade una clase al campo confirmacion como advertencia
             */
            contrasena.value !== confirmarContrasena.value ?
                confirmarContrasena.classList.add('is-invalid') :
                confirmarContrasena.classList.remove('is-invalid')

            formularioValidado()
        })

        confirmarContrasena.addEventListener('input', (e) => {
            // Si la confirmación de la nueva contraseña es mayor a 8 caracteres elimina a apartir del 9
            if (confirmarContrasena.value.length > 8) {
                confirmarContrasena.value = confirmarContrasena.value.slice(0, 8)
            }

            if (confirmarContrasena.value.length > 3 && confirmarContrasena.value.length < 9) {
                validacionConfirmarContrasena = true
            } else {
                validacionConfirmarContrasena = false
            }

            /**
             * Si no se coloca una contraseña pero si la confirmacion
             * añade una clase al campo confirmacion como advertencia
             */
            if (contrasena.value.length === 0) {
                contrasena.classList.add('is-invalid')
            }

            /**
             * Si:
             * 1. Campo confirmar nueva contraseña y contraseña son diferentes
             * añade una clase de advertencia al campo contraseña.
             * 2. Además de, el campo contraseña tener más de 4 caracteres
             */
            confirmarContrasena.value !== contrasena.value && contrasena.value.length > 4 ?
                confirmarContrasena.classList.add('is-invalid') :
                confirmarContrasena.classList.remove('is-invalid')

            formularioValidado()
        })

        correo.addEventListener('input', (e) => {
            // Si el correo es mayor a 40 caracteres elimina a partir del 9
            if (correo.value.length > 40) {
                correo.value = correo.value.slice(0, 40)
            }

            correo.value = correo.value.replace(/[^@A-Za-z0-9._-]+/g, '')

            // Si el correo es válido
            if (validarCorreo.test(correo.value)) {
                correo.classList.remove('is-invalid')
                validacionCorreo = true
            } else {
                correo.classList.add('is-invalid')
                validacionCorreo = false
            }

            formularioValidado()
        })
    </script>

    {{-- Mensajes --}}
    <script>
        @if ($message = session('usuarioRegistradoEstudiante'))
            Swal.fire({
                icon: 'success',
                title: '¡Estudiante registrado!',
                html: 'Un nuevo estudiante ha sido añadido, a continuación vaya a la acción editar para asignarle su perfil académico para cursar una acreditable.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('mostrarModalUsuario'))
            Swal.fire({
                icon: 'error',
                title: '¡Error al registrar!',
                html: 'Uno de los parámetros parece estar mal.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger px-5'
                },
            })
            $('#registrar').modal('show')
        @elseif ($message = session('registrado'))
            Swal.fire({
                icon: 'info',
                title: '¡Ya registrado!',
                html: 'El estudiante se encuentra registrado.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info px-5'
                },
            })
        @elseif ($message = session('academico'))
            Swal.fire({
                icon: 'success',
                title: '¡Datos actualizados!',
                html: 'Los datos del estudiante han sido actualizados.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @endif
    </script>
@stop
