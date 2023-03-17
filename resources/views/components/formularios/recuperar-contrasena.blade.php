<form action="{{ route('soporte.recuperarContrasena') }}" method="post" class="recuperar">
    @csrf
    {{ method_field('PUT') }}

    <article class="card-body">
        <x-perfil.card-titulo titulo="Correo de recuperación" />

        <main class="row">
            <x-perfil.card-mensaje>
                Para restaurar la contraseña escriba el correo del usuario en cuestión.
            </x-perfil.card-mensaje>

            <div class="col-md-7 col-sm-12">
                <div class="form-group mb-3">
                    <label for="correo1">Correo del usuario a restaurar</label>

                    <div class="input-group">
                        <input type="email" name="correo1" class="form-control @error('correo1') is-invalid @enderror"
                            placeholder="correo@gmail.com" value="{{ old('correo1') }}"
                            pattern="/[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/"
                            title="Debe ser un correo válido." required autofocus>

                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>

                        @error('correo1')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <footer class="col-12">
                <button class="p-n5 btn btn-primary btn-block">
                    Recuperar
                </button>
            </footer>
        </main>
    </article>
</form>
