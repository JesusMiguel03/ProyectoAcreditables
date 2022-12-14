@extends('adminlte::page')

@section('title', 'Acreditables | Mi cuenta')

@section('content_header')
<div class="row">
    <div class="col-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
            <li class="breadcrumb-item active"><a href="" class="text-primary">Cuenta</a></li>
        </ol>
    </div>

    <x-tipografia.periodo fase="{{ !empty($periodo->fase) ? $periodo->fase : '' }}"
        fecha="{{ !empty($periodo->inicio) ? explode('-', explode(' ', $periodo->inicio)[0])[0] : 'Sin asignar' }}" />
</div>

    <x-tipografia.titulo>Mi cuenta</x-tipografia.titulo>
@stop

@section('content')
    <div class="col-md-8 col-sm-12 mx-auto">
        <div class="card">

            {{-- Información de perfil --}}
            <section class="card-body">
                <x-tipografia.titulo-formulario-perfil>
                    Información de perfil
                </x-tipografia.titulo-formulario-perfil>

                <main class="row">
                    <x-tipografia.mensajePerfil>
                        Actualice su información de usuario, nombre, apellido o correo en
                        este formulario.
                    </x-tipografia.mensajePerfil>

                    <div class="col-md-7 col-sm-12">
                        <form action="{{ route('user-profile-information.update') }}" method="post">
                            @csrf
                            {{ method_field('PUT') }}

                            {{-- Nombre --}}
                            <div class="input-group mb-3">
                                <div class="row">
                                    <div class="col-6">
                                        <label>Nombre</label>
                                        <input type="text" name="nombre" class="form-control"
                                            value="{{ auth()->user()->nombre }}">
                                    </div>

                                    <div class="col-6">
                                        <label>Apellido</label>
                                        <input type="text" name="apellido" class="form-control"
                                            value="{{ auth()->user()->apellido }}">
                                    </div>
                                </div>
                            </div>

                            {{-- Correo --}}
                            <div class="form-group mb-3">
                                <label>Correo</label>
                                <input type="text" name="email" class="form-control"
                                    value="{{ auth()->user()->email }}">
                            </div>

                            {{-- Botones --}}
                            <x-botones.actualizar />
                        </form>
                    </div>
                </main>
            </section>

            {{-- Contraseña --}}
            <section class="card-body">
                <x-tipografia.titulo-formulario-perfil>
                    Seguridad de la cuenta
                </x-tipografia.titulo-formulario-perfil>

                <main class="row">
                    <x-tipografia.mensajePerfil>
                        Mantenga su cuenta segura con una robusta y confiable
                        contraseña, puede cambiarla aquí cuando desee.
                    </x-tipografia.mensajePerfil>

                    <div class="col-md-7 col-sm-12">
                        <form action="{{ route('actualizarContrasena') }}" method="post">
                            @csrf
                            {{ method_field('PUT') }}

                            <input type="number" class="d-none" name="usuario" value="{{ auth()->user()->id }}" hidden>

                            <div class="form-group mb-3">
                                <label for="current_password">Contraseña actual</label>
                                <input type="password" name="current_password"
                                    class="form-control @error('current_password') is-invalid @enderror" autofocus required>

                                @error('current_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="password">Nueva contraseña</label>
                                        <input type="password" name="password"
                                            class="form-control @error('password') is-invalid @enderror" autofocus required>

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-6">
                                        <label for="password_confirmation">Confirmar contraseña</label>
                                        <input type="password" name="password_confirmation"
                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                            autofocus required>

                                        @error('password_confirmation')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Botones --}}
                            <x-botones.actualizar />
                        </form>
                    </div>
                </main>
            </section>

            {{-- Perfil academico --}}
            @can('preinscribir')
                <section class="card-body">
                    <x-tipografia.titulo-formulario-perfil>
                        Perfil académico
                    </x-tipografia.titulo-formulario-perfil>

                    <main class="row">
                        <x-tipografia.mensajePerfil>
                            Esta información valida sus estudios al momento de inscribir una acreditable de su preferencia,
                            si no están asignados los campos comuníquese con el Coordinador de Acreditables para
                            actualizarlo.
                        </x-tipografia.mensajePerfil>

                        <div class="col-md-7 col-sm-12">
                            <div class="form-group mb-3">
                                <label>Trayecto</label>
                                <input type="text" class="form-control"
                                    value="{{ !empty(auth()->user()->estudiante) ? auth()->user()->estudiante->trayecto->num_trayecto : 'Sin asignar' }}"
                                    readonly disabled>
                            </div>
                            <div class="form-group mb-3">
                                <label>PNF</label>
                                <input type="text" class="form-control"
                                    value="{{ !empty(auth()->user()->estudiante) ? auth()->user()->estudiante->pnf->nom_pnf : 'Sin asignar' }}"
                                    readonly disabled>
                            </div>
                        </div>
                    </main>
                </section>
            @endcan

            {{-- Comprobante --}}
            @if (auth()->user()->getRoleNames()[0] === 'Estudiante')
                <section class="card-body">
                    <x-tipografia.titulo-formulario-perfil>
                        Comprobante de inscripción
                    </x-tipografia.titulo-formulario-perfil>

                    <main class="row">
                        @if (!empty(auth()->user()->estudiante->preinscrito) &&
                            !empty(auth()->user()->estudiante->preinscrito->materia->info->profesor))
                            <a href="{{ route('comprobante', auth()->user()->estudiante->id) }}" class="px-3">
                                <div class="info-box">
                                    <span class="info-box-icon bg-danger"><i class="far fa-file-pdf"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text text-primary">Descargar</span>
                                    </div>
                                </div>
                            </a>
                        @else
                            <p class="card-text text-muted text-justify p-4">
                                {{ empty(auth()->user()->estudiante->preinscrito->materia->info->profesor) ? 'Su comprobante no se encuentra finalizado, por favor, comuníquese con el Coordinador de Acreditables para que añada un profesor a la acreditable, hasta entonces su comprobante no estará disponible.' : 'Aún no se ha inscrito en una acreditable, cuando lo haga aparecerá un comprobante en esta sección' }}
                            </p>
                        @endif
                    </main>
                </section>
            @endif
        </div>
    </div>

    {{-- <div class="row mt-3">

        <div class="col-6">
            <div class="card">
                <header class="card-header bg-primary">
                    <h5>Información de perfil</h5>
                </header>

                <main class="card-body">
                    <form action="{{ route('user-profile-information.update') }}" method="post">
                        @csrf
                        {{ method_field('PUT') }}

                        <div class="input-group mb-3">
                            <div class="col-6 px-2">
                                <label>Nombre</label>
                                <input type="text" name="nombre" class="form-control"
                                    value="{{ auth()->user()->nombre }}">
                            </div>

                            <div class="col-6 px-2">
                                <label>Apellido</label>
                                <input type="text" name="apellido" class="form-control"
                                    value="{{ auth()->user()->apellido }}">
                            </div>
                        </div>

                        <div class="form-group mb-3 px-2">
                            <label>Correo</label>
                            <input type="text" name="email" class="form-control"
                                value="{{ auth()->user()->email }}">
                        </div>

                        <div class="row px-2">
                            <div class="col-12">
                                <button type="submit" class="btn btn-block btn-outline-primary">
                                    {{ __('Actualizar perfil ') }}
                                </button>
                            </div>
                        </div>

                    </form>
                </main>
            </div>
        </div>

        <div class="col-6">
            <div class="card">
                <header class="card-header bg-primary">
                    <h5>Seguridad de la cuenta</h5>
                </header>
                <main class="card-body" style="height: 15.625rem">
                    <form action="{{ route('actualizarContrasena') }}" method="post">
                        @csrf
                        {{ method_field('PUT') }}

                        <input type="number" class="d-none" name="usuario" value="{{ auth()->user()->id }}" hidden>

                        <div class="form-group mb-3">
                            <label for="current_password">Contraseña actual</label>
                            <input type="password" name="current_password"
                                class="form-control @error('current_password') is-invalid @enderror" autofocus required>

                            @error('current_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label for="password">Nueva contraseña</label>
                                    <input type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror" autofocus required>

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-6">
                                    <label for="password_confirmation">Confirmar contraseña</label>
                                    <input type="password" name="password_confirmation"
                                        class="form-control @error('password_confirmation') is-invalid @enderror" autofocus
                                        required>

                                    @error('password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <x-botones.actualizar />
                    </form>
                </main>
            </div>
        </div>

        @can('preinscribir')
            @if (empty(auth()->user()->estudiante))
                <div class="col-6">
                    <div class="card">
                        <header class="card-header bg-primary">
                            <h5>Perfil académico</h5>
                        </header>
                        <main class="card-body" style="height: 15.625rem">
                            <div class="form-group mb-3">
                                <label>Trayecto</label>
                                <input type="text" class="form-control"
                                    value="{{ !empty(auth()->user()->estudiante) ? auth()->user()->estudiante->pnf->num_trayecto : 'Sin asignar' }}"
                                    readonly disabled>
                            </div>
                            <div class="form-group mb-3">
                                <label>PNF</label>
                                <input type="text" class="form-control"
                                    value="{{ !empty(auth()->user()->estudiante) ? auth()->user()->estudiante->pnf->nom_pnf : 'Sin asignar' }}"
                                    readonly disabled>
                            </div>
                        </main>
                    </div>
                </div>
            @else
                <div class="col-6">
                    <div class="card">
                        <header class="card-header bg-primary">
                            <h5>Perfil académico</h5>
                        </header>

                        <main class="card-body" style="min-height: 15.625rem">
                            <div class="form-group mb-3 px-2">
                                <label>Trayecto</label>
                                <input type="text" class="form-control"
                                    placeholder="{{ auth()->user()->estudiante->trayecto_id }}" disabled>
                            </div>

                            <div class="form-group mb-3 px-2">
                                <label>PNF</label>
                                <input type="text" class="form-control"
                                    placeholder="{{ auth()->user()->estudiante->pnf->nom_pnf }}" disabled>
                            </div>
                        </main>
                    </div>
                </div>
            @endif
        @endcan

        @if (!empty(auth()->user()->estudiante->preinscrito) && !empty(auth()->user()->estudiante->preinscrito->materia->info->profesor))
            <section class="col-4 p-2">
                <a href="{{ route('comprobante', auth()->user()->estudiante->id) }}">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="far fa-file-pdf"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text text-primary">Descargar comprobante</span>
                        </div>
                    </div>
                </a>
            </section>
        @else
            <section class="col-6 p-2">
                <div class="card p-4">
                    <p class="card-text text-muted text-justify">
                        {{ !empty(auth()->user()->estudiante->preinscrito->materia->info->profesor) ? 'Su comprobante no se encuentra finalizado, por favor, comuníquese con el Coordinador de Acreditables para que añada un profesor a la acreditable, hasta entonces su comprobante no estará disponible.' : 'Aún no se ha inscrito en una acreditable, cuando lo haga aparecerá un comprobante en esta sección' }}
                    </p>
                </div>
            </section>
        @endif

    </div> --}}
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
@stop

@section('js')
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        @if ($message = session('actualizado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Contraseña actualizada!',
                html: 'Ahora podrá ingresar con su nueva contraseña.',
                confirmButtonColor: '#28a745',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('errorHash'))
            let timerInterval
            Swal.fire({
                icon: 'error',
                title: '¡Error al actualizar!',
                html: 'El campo de <b>Contraseña actual</b> no coincide con la registrada.',
                confirmButtonColor: '#dc3545',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('errorConfirmacion'))
            let timerInterval
            Swal.fire({
                icon: 'error',
                title: '¡Error al actualizar!',
                html: 'El campo de <b>Nueva contraseña</b> y <b>Confirmar contraseña</b> no coinciden.',
                confirmButtonColor: '#dc3545',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @endif
    </script>
@stop
