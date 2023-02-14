<form id="recuperar" action="{{ route('soporte.cambiarCedula') }}" method="post">
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
                        <input type="text" id="correo" name="usuario" class="form-control"
                            placeholder="correo@gmail.com" required autofocus>

                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </main>
                </article>

                <article class="form-group mb-3">
                    <label for="usuario">Cédula</label>

                    <main class="input-group">
                        <input type="number" id="correo" name="cedula" class="form-control" placeholder="15360120"
                            min="1000000" max="100000000" required>

                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-id-card"></span>
                            </div>
                        </div>
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
