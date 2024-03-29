@php
    $usuarioID = auth()->user()->id;
@endphp

<section class="card-body">
    <x-perfil.card-titulo titulo="Seguridad de la cuenta" />

    <main class="row">
        <x-perfil.card-mensaje>
            Mantenga su cuenta segura con una robusta y confiable
            contraseña, puede cambiarla aquí cuando desee.
        </x-perfil.card-mensaje>

        <div class="col-md-7 col-sm-12">
            <form action="{{ route('actualizarContrasena', $usuarioID) }}" method="post">
                @csrf
                {{ method_field('PUT') }}

                <div class="form-group mb-3">
                    <label for="current_password">Contraseña actual</label>
                    <div class="input-group">
                        <input type="password" id="contrasena" name="current_password"
                            class="form-control @error('current_password') is-invalid @enderror"
                            pattern="^[a-zA-Z0-9]{4,8}$" title="Debe estar entre 4 y 8 caracteres." required>

                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>

                        @error('current_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        </div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label for="password">Contraseña nueva</label>

                            <div class="input-group">
                                <input type="password" id="nuevaContrasena" name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    pattern="^[a-zA-Z0-9]{4,8}$" title="Debe estar entre 4 y 8 caracteres."
                                    required>

                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                    </div>
                                </div>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-6">
                            <label for="password_confirmation">Confirmar contraseña</label>

                            <div class="input-group">
                                <input type="password" id="validarContrasena" name="password_confirmation"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    pattern="^[a-zA-Z0-9]{4,8}$" title="Debe estar entre 4 y 8 caracteres."
                                    required>

                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                    </div>
                                </div>

                                @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button type="submit" id="actualizarSeguridad" class="btn btn-block btn-outline-primary">
                            {{ __('Actualizar perfil ') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </main>
</section>
