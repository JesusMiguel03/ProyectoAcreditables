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

                {{-- Nombre y apellido --}}
                <div class="input-group mb-3">
                    <div class="row">
                        {{-- Nombre --}}
                        <div class="col-6">
                            <label>Nombre</label>

                            <div class="input-group">
                                <input type="text" id="nombre" name="nombre"
                                    class="form-control @error('nombre') is-invalid @enderror"
                                    value="{{ $usuario->nombre }}" title="Debe estar entre 3 y 20 letras.">

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

                        {{-- Apellido --}}
                        <div class="col-6">
                            <label>Apellido</label>

                            <div class="input-group">
                                <input type="text" id="apellido" name="apellido"
                                    class="form-control @error('apellido') is-invalid @enderror"
                                    value="{{ $usuario->apellido }}" title="Debe estar entre 3 y 20 letras.">

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

                {{-- Nacionalidad y cédula --}}
                <div class="form-group mb-n2">
                    <div class="form-row">
                        <div class="form-group col-4">
                            <label for="nacionalidad">Nacionalidad</label>

                            <select id="nacionalidad" name="nacionalidad"
                                class="form-control @error('nacionalidad') is-invalid @enderror" title="Debe seleccionar una opción de la lista.">

                                <option value="0" readonly> Seleccione una...</option>
                                <option value="1" {{ $usuario->nacionalidad === 'V' ? 'selected' : '' }}>V</option>
                                <option value="2" {{ $usuario->nacionalidad === 'E' ? 'selected' : '' }}>E</option>
                                <option value="3" {{ $usuario->nacionalidad === 'P' ? 'selected' : '' }}>P</option>
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
                                    value="{{ $usuario->cedula }}" title="Debe estar entre 7 y 8 dígitos.">

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
                        <input type="email" id="correo" name="email"
                            class="form-control @error('email') is-invalid @enderror" value="{{ $usuario->email }}" title="Debe ser un correo válido.">

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

                <div class="row">
                    <div class="col-12">
                        <button type="submit" id="actualizarInformacion" class="btn btn-block btn-outline-primary">
                            {{ __('Actualizar perfil ') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </main>
</section>
