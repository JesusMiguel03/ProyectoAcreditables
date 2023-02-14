<form id="recuperar" action="{{ route('soporte.recuperarContrasena') }}" method="post">
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
                    <label for="usuario">Correo del usuario a restaurar</label>
                    <div class="input-group">
                        <input type="text" id="correo" name="usuario" class="form-control"
                            placeholder="correo@gmail.com" required autofocus>

                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="col-12">
                <button class="p-n5 btn btn-primary btn-block" disabled>
                    Recuperar
                </button>
            </footer>
        </main>
    </article>
</form>
