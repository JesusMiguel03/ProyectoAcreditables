<section class="card-body">
    <x-perfil.card-titulo>
        Información de perfil
    </x-perfil.card-titulo>

    <main class="row">
        <x-perfil.card-mensaje>
            Actualice su información de usuario, nombre, apellido o correo en
            este formulario.
        </x-perfil.card-mensaje>

        <div class="col-md-7 col-sm-12">
            <form action="{{ route('user-profile-information.update') }}" method="post">
                @csrf
                {{ method_field('PUT') }}

                <div class="input-group mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label>Nombre</label>
                            <div class="input-group">
                                <input type="text" name="nombre" class="form-control"
                                    value="{{ atributo($attributes, 'nombre') }}">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <label>Apellido</label>
                            <div class="input-group">
                                <input type="text" name="apellido" class="form-control"
                                    value="{{ atributo($attributes, 'apellido') }}">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label>Correo</label>
                    <div class="input-group">
                        <input type="text" name="email" class="form-control"
                            value="{{ atributo($attributes, 'correo') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <x-botones.actualizar />
            </form>
        </div>
    </main>
</section>
