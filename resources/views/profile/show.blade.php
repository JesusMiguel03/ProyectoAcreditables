@extends('adminlte::page')

@section('title', 'Acreditables | Mi cuenta')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item active"><a href="" class="text-primary">Perfil</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Mi cuenta</x-tipografia.titulo>
@stop

@section('content')
    <div class="modal fade" id="avatar" tabindex="-1" role="dialog" aria-labelledby="campoCategoria" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded-top">
                <header class="modal-header bg-primary">
                    <h5 class="modal-title text-center" id="campoAvatar">Avatares disponibles</h5>
                </header>
                <main class="modal-body">
                    <form action="{{ route('perfil.avatar', auth()->user()->id) }}" method="post">
                        @csrf
                        {{ method_field('PUT') }}

                        <input type="number" id="avatarID" name="avatarID" class="d-none" hidden>

                        <section class="card">
                            <div class="row mx-auto p-4">
                                @for ($i = 1; $i <= 9; $i++)
                                    <div class="col-4">
                                        <div class="border mx-auto my-2 rounded-circle avatar-contenedor"
                                            {{ Popper::arrow()->pop('Avatar ' . $i) }}>
                                            <img src="{{ asset('vendor/img/avatares/avatar' . $i . '.webp') }}"
                                                alt="Avatar " . {{ $i }} id="{{ $i }}"
                                                class="p-2 avatar">
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </section>

                        <section id="avatarSeleccionado" class="d-none card">
                            <header class="p-2 rounded-top border-bottom card-head bg-secondary text-center">
                                <h5>Avatar seleccionado</h5>
                            </header>
                            <main class="card-body text-center">
                                <img alt="Avatar seleccionado" id="seleccion"
                                    class="p-3 border border-primary rounded-circle avatar-seleccionado">
                            </main>
                        </section>

                        <x-modal.footer-aceptar />
                    </form>
                </main>
            </div>
        </div>
    </div>

    <div class="col-md-8 col-sm-12 mx-auto">
        <div class="card">

            <x-perfil.usuario.avatar />

            <x-perfil.usuario.informacion :nombre="auth()->user()->nombre" :apellido="auth()->user()->apellido" :correo="auth()->user()->email" />

            <x-perfil.usuario.seguridad :id="auth()->user()->id" />

            @can('inscribir')
                <x-perfil.usuario.perfil-academico />

                <x-perfil.usuario.comprobante />
            @endcan
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/avatarPerfil.css') }}">
@stop

@section('js')
    @include('popper::assets')
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>

    {{-- Personalizados --}}
    <script src="{{ asset('js/seleccionarAvatar.js') }}"></script>

    {{-- Mensajes --}}
    <script>
        @if ($message = session('actualizado'))
            Swal.fire({
                icon: 'success',
                title: '¡Contraseña actualizada!',
                html: 'Ahora podrá ingresar con su nueva contraseña.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('avatar'))
            Swal.fire({
                icon: 'success',
                title: '¡Avatar actualizado!',
                html: 'Felicidades por personalizar su perfil con ese increíble avatar.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('perfil-actualizado'))
            Swal.fire({
                icon: 'success',
                title: '¡Perfil actualizado!',
                html: 'Sus credenciales han sido actualizadas correctamente.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('errorHash'))
            Swal.fire({
                icon: 'error',
                title: '¡Error al actualizar!',
                html: 'El campo de <b>Contraseña actual</b> no coincide con la registrada.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger px-5'
                },
            })
        @elseif ($message = session('errorConfirmacion'))
            Swal.fire({
                icon: 'error',
                title: '¡Error al actualizar!',
                html: 'El campo de <b>Nueva contraseña</b> y <b>Confirmar contraseña</b> no coinciden.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger px-5'
                },
            })
        @endif
    </script>
@stop
