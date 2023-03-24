@php
    $usuario = auth()->user();
@endphp

<section class="card-body">
    <x-perfil.card-titulo titulo="Información de perfil" />

    <main class="row">
        <x-perfil.card-mensaje>
            Actualice su información de usuario en este formulario.
        </x-perfil.card-mensaje>

        <div class="col-md-7 col-sm-12">
            <form action="{{ route('perfil.informacion') }}" method="post">
                @csrf
                {{ method_field('PUT') }}

                <div class="input-group mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label>Nombre</label>
                            <div class="input-group">
                                <input type="text" name="nombre"
                                    class="form-control @error('nombre') is-invalid @enderror"
                                    value="{{ $usuario->nombre }}">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                                @error('nombre')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>

                        <div class="col-6">
                            <label>Apellido</label>
                            <div class="input-group">
                                <input type="text" name="apellido"
                                    class="form-control @error('apellido') is-invalid @enderror"
                                    value="{{ $usuario->apellido }}">

                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>

                                @error('apellido')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>

                <div class="form-group mb-n2">
                    <div class="form-row">
                        <div class="form-group col-4">
                            <label for="nacionalidad">Nacionalidad</label>
                            <select name="nacionalidad"
                                class="form-control @error('nacionalidad') is-invalid @enderror">
                                <option value="V" {{ $usuario->nacionalidad === 'V' ? 'selected' : '' }}>V</option>
                                <option value="E" {{ $usuario->nacionalidad === 'E' ? 'selected' : '' }}>E</option>
                                <option value="P" {{ $usuario->nacionalidad === 'P' ? 'selected' : '' }}>P</option>
                            </select>
                        </div>

                        @error('nacionalidad')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <div class="form-group col-8">
                            <label for="cedula">Cédula</label>
                            <div class="input-group">
                                <input type="number" id="cedula" name="cedula"
                                    class="form-control @error('cedula') is-invalid @enderror"
                                    value="{{ $usuario->cedula }}">

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
                            </div>
                        </div>

                    </div>
                </div>

                <div class="form-group mb-3">
                    <label>Correo</label>
                    <div class="input-group">
                        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ $usuario->email }}">

                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>
                </div>

                <x-botones.actualizar />
            </form>
        </div>
    </main>
</section>
