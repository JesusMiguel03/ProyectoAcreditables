<section class="card-body">
    <x-perfil.card-titulo titulo="Avatar" />

    <main class="row">
        <x-perfil.card-mensaje>
            Personalice su perfil con un avatar de su preferencia, haga clic en la imagen para seleccionar uno.
        </x-perfil.card-mensaje>

        <div class="col-md-7 col-sm-12">
            <div class="mx-auto mt-2 border rounded-circle avatar-contenedor">
                <img src="{{ request()->secure() ? secure_asset('vendor/img/defecto/usuario.webp') : asset('vendor/img/defecto/usuario.webp') }}"
                    alt="Imagen del usuario" class="img-circle img-fluid avatar-usuario" data-toggle="modal"
                    data-target="#avatar">
            </div>
        </div>
    </main>
</section>
