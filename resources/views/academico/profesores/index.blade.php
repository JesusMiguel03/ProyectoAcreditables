@extends('adminlte::page')

@section('title', 'Acreditables | Profesores')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item active"><a href="">Profesores</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Listado de profesores</x-tipografia.titulo>

    @can('registrar')
        {{-- Perfil de profesor --}}
        <div class="modal fade" id="modalProfesor" tabindex="-1" role="dialog" aria-labelledby="campoprofesor" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <header class="modal-header bg-primary">
                        <h5 class="modal-title" id="campoprofesor">Asignar profesor</h5>
                    </header>

                    <main class="modal-body">
                        <form action="{{ route('profesores.store') }}" method="post">
                            @csrf

                            <x-formularios.registrar-profesor :usuarios="$usuarios" :departamentos="$departamentos" :conocimientos="$conocimientos" />
                        </form>
                    </main>
                </div>
            </div>
        </div>

        {{-- Registrar usuario --}}
        <div class="modal fade" id="modalRegistrar" tabindex="-1" role="dialog" aria-labelledby="camporegistrar"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <header class="modal-header bg-primary">
                        <h5 class="modal-title" id="camporegistrar">Registrar usuario como profesor</h5>
                    </header>

                    <main class="modal-body">
                        <form action="{{ route('registrar.usuario', 'Profesor') }}" method="post">
                            @csrf

                            <x-formularios.usuario />
                        </form>
                    </main>
                </div>
            </div>
        </div>
    @endcan
@stop

@section('content')
    <div class="col-12 card table-responsive-sm p-3 mb-3">

        <div class="w-100 row mx-auto">
            <div class="col-md-2 col">
                <button class="btn btn-block btn-primary my-2" data-toggle="modal" data-target="#modalRegistrar"
                    {{ Popper::arrow()->pop('Nuevo usuario') }}>
                    <i class="fas fa-plus mr-2"></i>
                    {{ 'Usuario' }}
                </button>
            </div>

            <div class="col-md-2 col">
                <button class="btn btn-block btn-primary my-2" data-toggle="modal" data-target="#modalProfesor"
                    {{ Popper::arrow()->pop('Registrar usuario como profesor') }}>
                    <i class="fas fa-plus mr-2"></i>
                    {{ 'Profesor' }}
                </button>
            </div>
        </div>

        <table id='tabla' class="table table-striped">
            <thead>
                <tr class="bg-secondary">
                    <th {{ Popper::arrow()->pop('Cédula') }}>CI</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th {{ Popper::arrow()->pop('Área de conocimiento') }}>Conocimiento</th>
                    <th {{ Popper::arrow()->pop('Teléfono') }}>Tlf.</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($profesores as $profesor)
                    @php
                        $CI = $profesor->profesorCI();
                        $nombre = $profesor->usuario->nombre;
                        $apellido = $profesor->usuario->apellido;
                        $conocimiento = $profesor->conocimiento->nom_conocimiento;
                        
                        $tlf = $profesor->telefono;
                        $codigoTlf = Str::substr($tlf, 0, 4);
                        $numeroTlf = preg_replace('#(\d{3})(\d{2})(\d{2})#', '$1-$2-$3', Str::substr($tlf, 4));
                        $formatoTlf = "{$codigoTlf} {$numeroTlf}";
                        
                        $activo = $profesor->activo === 1 ? 'Activo' : 'Inactivo';
                    @endphp
                    <tr>
                        <td>{{ $CI }}</td>
                        <td>{{ $nombre }}</td>
                        <td>{{ $apellido }}</td>
                        <td>{{ $conocimiento }}</td>
                        <td>{{ $formatoTlf }}</td>
                        <td class="text-{{ $profesor->activo === 1 ? 'success' : 'danger' }}">{{ $activo }}</td>
                        <td>
                            <div class="btn-group mx-1" role="group" aria-label="Acciones">
                                <a href="{{ route('profesores.edit', $profesor) }}" class="btn btn-primary"
                                    {{ Popper::arrow()->pop('Editar') }}>
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('profesores.show', $profesor) }}" class="btn btn-primary"
                                    {{ Popper::arrow()->pop('Ver perfil') }}>
                                    <i class="fas fa-eye"></i>
                                </a>
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
    <link rel="stylesheet" href="{{ asset('vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilosVarios/required.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilosVarios/input.css') }}">
@stop

@section('js')
    @include('popper::assets')
    <script src="{{ asset('vendor/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('vendor/moment/moment.js') }}"></script>
    <script src="{{ asset('vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script>
        $(function() {
            $('#fecha_nacimiento').datetimepicker({
                locale: 'es',
                format: 'YYYY-MM-DD'
            });
        });
        $(function() {
            $('#fecha_ingreso').datetimepicker({
                locale: 'es',
                format: 'YYYY-MM-DD'
            });
        });
    </script>

    {{-- Personalizados --}}
    <script src="{{ asset('js/tablas.js') }}"></script>

    {{-- Validaciones --}}
    {{-- Registrar usuario --}}
    <script>
        const nombre = document.getElementById('nombre')
        const apellido = document.getElementById('apellido')
        const nacionalidad = document.getElementById('nacionalidad')
        const cedula = document.getElementById('cedula')
        const contrasena = document.getElementById('contrasena')
        const confirmarContrasena = document.getElementById('confirmarContrasena')
        const correo = document.getElementById('correo')
        const botonUsuario = document.getElementById('registrarUsuario')

        const validarCorreo =
            /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/

        // Validaciones de cada campo
        let [
            validacionNombre, validacionApellido, validacionNacionalidad, validacionCedula, validacionCorreo, validacionContrasena, validacionConfirmarContrasena
        ] = [
            nombre.value.length > 2 && nombre.value.length < 21,
            apellido.value.length > 2 && apellido.value.length < 21,
            nacionalidad.options[nacionalidad.selectedIndex].value > 0,
            cedula.value.toString().length > 6 && cedula.value.toString().length < 9,
            validarCorreo.test(correo.value),
            contrasena.value.length > 3 && contrasena.value.length < 9,
            confirmarContrasena.value.length > 3 && confirmarContrasena.value.length < 9 && confirmarContrasena.value === contrasena.value
        ]

        // Validacion de todo el formulario
        const formularioValidado = () => {
            if (validacionNombre && validacionApellido && validacionNacionalidad && validacionCedula && validacionCorreo &&
                validacionContrasena && validacionConfirmarContrasena) {
                botonUsuario.removeAttribute('disabled')
            } else {
                botonUsuario.disabled = true
            }
        }

        formularioValidado()

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
            if (nacionalidad.options[nacionalidad.selectedIndex].value > 0) {
                validacionNacionalidad = true
                nacionalidad.classList.remove('is-invalid')
            } else {
                validacionNacionalidad = false
                nacionalidad.classList.add('is-invalid')
            }

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
    </script>

    {{-- Registrar perfil profesor --}}
    <script>
        const usuario = document.getElementById('usuario')
        const departamento = document.getElementById('departamento')
        const conocimiento = document.getElementById('conocimiento')
        const estado = document.getElementById('estado')
        const ciudad = document.getElementById('ciudad')
        const urb = document.getElementById('urb')
        const calle = document.getElementById('calle')
        const casa = document.getElementById('casa')
        const codigo = document.getElementById('codigo')
        const tlf = document.getElementById('tlf')
        const nacimiento = document.getElementById('fecha_nacimiento')
        const ingreso = document.getElementById('fecha_ingreso')
        const botonProfesor = document.getElementById('formularioEnviar')

        botonProfesor.disabled = true

        let [
            validarUsuario, validarDepartamento, validarConocimiento, validarEstado, validarCiudad, validarUrb, validarCalle, validarCasa, validarCodigo, validarTlf, validarNacimiento, validarIngreso
        ] = [
            usuario.options[usuario.selectedIndex].value > 0,
            departamento.options[departamento.selectedIndex].value > 0,
            conocimiento.options[conocimiento.selectedIndex].value > 0,
            estado.value.length > 3 && estado.value.length < 17,
            ciudad.value.length > 5 && ciudad.value.length < 31,
            urb.value.length > 5 && urb.value.length < 21,
            calle.value.length > 5 && calle.value.length < 21,
            casa.value.length > 3 && casa.value.length < 11,
            codigo.options[codigo.selectedIndex].value > 0,
            tlf.value.length === 7,
            nacimiento.value.length !== 0,
            ingreso.value.length !== 0
        ]

        const validarFormulario = () => {
            if (validarUsuario && validarDepartamento && validarConocimiento && validarEstado && validarCiudad &&
                validarUrb && validarCalle && validarCasa && validarCodigo && validarTlf && validarNacimiento &&
                validarIngreso) {
                botonProfesor.removeAttribute('disabled')
            } else {
                botonProfesor.disabled = true
            }
        }

        usuario.addEventListener('change', (e) => {
            let usuarioSeleccionado = e.currentTarget.options[e.currentTarget.selectedIndex].value || 0

            if (usuarioSeleccionado > 0) {
                validarUsuario = true
                e.currentTarget.classList.remove('is-invalid')
            } else {
                validarUsuario = false
                e.currentTarget.classList.add('is-invalid')
            }

            validarFormulario()
        })

        departamento.addEventListener('change', (e) => {
            let departamentoSeleccionado = e.currentTarget.options[e.currentTarget.selectedIndex].value || 0

            if (departamentoSeleccionado > 0) {
                validarDepartamento = true
                e.currentTarget.classList.remove('is-invalid')
            } else {
                validarDepartamento = false
                e.currentTarget.classList.add('is-invalid')
            }

            validarFormulario()
        })

        conocimiento.addEventListener('change', (e) => {
            let conocimientoSeleccionado = e.currentTarget.options[e.currentTarget.selectedIndex].value || 0

            if (conocimientoSeleccionado > 0) {
                validarConocimiento = true
                e.currentTarget.classList.remove('is-invalid')
            } else {
                validarConocimiento = false
                e.currentTarget.classList.add('is-invalid')
            }

            validarFormulario()
        })

        codigo.addEventListener('change', (e) => {
            if (e.currentTarget.options[e.currentTarget.selectedIndex].value > 0) {
                validarCodigo = true
                e.currentTarget.classList.remove('is-invalid')
            } else {
                validarCodigo = false
                e.currentTarget.classList.add('is-invalid')
            }

            validarFormulario()
        })

        estado.addEventListener('input', (e) => {
            if (e.currentTarget.value.length > 16) {
                e.currentTarget.value = e.currentTarget.value.length.slice(0, 16)
            }

            if (e.currentTarget.value.length > 3 && e.currentTarget.value.length < 17) {
                validarEstado = true
                e.currentTarget.classList.remove('is-invalid')
            } else {
                validarEstado = false
                e.currentTarget.classList.add('is-invalid')
            }

            validarFormulario()
        })

        ciudad.addEventListener('input', (e) => {
            if (e.currentTarget.value.length > 30) {
                e.currentTarget.value = e.currentTarget.value.length.slice(0, 30)
            }

            if (e.currentTarget.value.length > 5 && e.currentTarget.value.length < 31) {
                validarCiudad = true
                e.currentTarget.classList.remove('is-invalid')
            } else {
                validarCiudad = false
                e.currentTarget.classList.add('is-invalid')
            }

            validarFormulario()
        })

        urb.addEventListener('input', (e) => {
            if (e.currentTarget.value.length > 20) {
                e.currentTarget.value = e.currentTarget.value.length.slice(0, 20)
            }

            if (e.currentTarget.value.length > 5 && e.currentTarget.value.length < 21) {
                validarUrb = true
                e.currentTarget.classList.remove('is-invalid')
            } else {
                validarUrb = false
                e.currentTarget.classList.add('is-invalid')
            }

            validarFormulario()
        })

        calle.addEventListener('input', (e) => {
            if (e.currentTarget.value.length > 20) {
                e.currentTarget.value = e.currentTarget.value.length.slice(0, 20)
            }

            if (e.currentTarget.value.length > 5 && e.currentTarget.value.length < 21) {
                validarCalle = true
                e.currentTarget.classList.remove('is-invalid')
            } else {
                validarCalle = false
                e.currentTarget.classList.add('is-invalid')
            }

            validarFormulario()
        })

        casa.addEventListener('input', (e) => {
            if (e.currentTarget.value.length > 10) {
                e.currentTarget.value = e.currentTarget.value.length.slice(0, 10)
            }

            if (e.currentTarget.value.length > 3 && e.currentTarget.value.length < 11) {
                validarCasa = true
                e.currentTarget.classList.remove('is-invalid')
            } else {
                validarCasa = false
                e.currentTarget.classList.add('is-invalid')
            }

            validarFormulario()
        })

        tlf.addEventListener('input', (e) => {
            e.currentTarget.value = e.currentTarget.value.replace(/[^0-9]/g, '')

            if (e.currentTarget.value.length > 7) {
                e.currentTarget.value = e.currentTarget.value.length.slice(0, 7)
            }

            if (e.currentTarget.value.length === 7) {
                validarTlf = true
                e.currentTarget.classList.remove('is-invalid')
            } else {
                validarTlf = false
                e.currentTarget.classList.add('is-invalid')
            }

            validarFormulario()
        })

        nacimiento.addEventListener('blur', (e) => {
            if (nacimiento.value.length !== 0) {
                validacionNacimiento = true
                nacimiento.classList.remove('is-invalid')
            } else {
                validacionNacimiento = false
                nacimiento.classList.add('is-invalid')
            }

            validarFormulario()
        })

        ingreso.addEventListener('blur', (e) => {
            if (ingreso.value.length !== 0) {
                validarIngreso = true
                ingreso.classList.remove('is-invalid')
            } else {
                validarIngreso = false
                ingreso.classList.add('is-invalid')
            }

            validarFormulario()
        })
    </script>

    {{-- Mensajes --}}
    <script>
        @if ($message = session('creado'))
            Swal.fire({
                icon: 'success',
                title: '¡Profesor registado!',
                html: 'Un nuevo perfil de profesor ha sido añadido.',
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
            $('#modalProfesor').modal('show')
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
            $('#modalRegistrar').modal('show')
        @elseif ($message = session('registrado'))
            Swal.fire({
                icon: 'info',
                title: '¡Ya registrado!',
                html: 'El profesor ya se encuentra registrado.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info px-5'
                },
            })
        @elseif ($message = session('usuarioRegistradoProfesor'))
            Swal.fire({
                icon: 'success',
                title: '¡Usuario registrado!',
                html: 'Un perfil de profesor ha sido registrado, para completar su perfil académico vaya al botón "Profesor".',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('actualizado'))
            Swal.fire({
                icon: 'success',
                title: '¡Datos actualizados!',
                html: 'Los datos del profesor han sido actualizados.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('registrado'))
            Swal.fire({
                icon: 'info',
                title: '¡Ya registrado!',
                html: 'El usuario ya se encuentra registrado.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info px-5'
                },
            })
            $('#registrar').modal('show')
        @elseif ($message = session('no encontrado'))
            Swal.fire({
                icon: 'error',
                title: '¡Usuario no encontrado!',
                html: 'El usuario que desea buscar no se encuentra disponible.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info px-5'
                },
            })
        @endif
    </script>
@stop
