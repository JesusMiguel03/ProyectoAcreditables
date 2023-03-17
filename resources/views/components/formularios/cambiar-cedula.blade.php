<form action="{{ route('soporte.cambiarCedula') }}" method="post" class="recuperar">
    @csrf
    {{ method_field('PUT') }}

    <article class="card-body">
        <x-perfil.card-titulo titulo="Cambiar cédula" />

        <main class="row">
            <x-perfil.card-mensaje>
                Para cambiar la cédula de un usuario, indique el correo correspondiente y la nueva cédula.
            </x-perfil.card-mensaje>

            <section class="col-md-7 col-sm-12">
                <article class="form-group mb-3">
                    <label for="usuario">Correo del usuario a restaurar</label>

                    <main class="input-group">
                        <input type="text" name="correo" class="form-control @error('correo') is-invalid @enderror"
                            value="{{ old('correo') }}" placeholder="correo@gmail.com"
                            pattern="/[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/"
                            title="Debe ser un correo válido." required autofocus>

                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>

                        @error('correo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </main>
                </article>

                <article class="form-group mb-3">
                    <label for="usuario">Cédula</label>

                    <main class="input-group">
                        <input type="text" name="cedula" class="form-control @error('cedula') is-invalid @enderror"
                            value="{{ old('cedula') }}" placeholder="15360120" pattern="^\d{7,8}$"
                            title="Debe contener entre 7 y 8 dígitos." required>

                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-id-card"></span>
                            </div>
                        </div>

                        @error('cedula')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </main>
                </article>
            </section>

            <footer class="col-12">
                <button class="p-n5 btn btn-primary btn-block">
                    Recuperar
                </button>
            </footer>
        </main>
    </article>
</form>
