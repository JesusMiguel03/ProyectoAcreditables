{{-- Nombre --}}
<div class="form-row" style="margin-bottom: -0.75rem">
    <div class="form-group {{ Route::is('register') ? 'col-12' : 'col-6' }} required">
        <label for="nombre" class="control-label">Nombre</label>

        <div class="input-group">
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                value="{{ old('nombre') }}" placeholder="{{ __('Nombre, ej: José') }}" maxlength="{{ config('variables.usuarios.nombre') }}"
                pattern="[A-zÀ-ÿ]+" title="Solo debe contener letras." autofocus required>

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
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
    <div class="form-group {{ Route::is('register') ? 'col-12' : 'col-6' }} required">
        <label for="apellido" class="control-label">Apellido</label>

        <div class="input-group mb-3">
            <input type="text" name="apellido" class="form-control @error('apellido') is-invalid @enderror"
                value="{{ old('apellido') }}" placeholder="{{ __('Apellido, ej: Gómez') }}" maxlength="{{ config('variables.usuarios.apellido') }}" pattern="[A-zÀ-ÿ]+" title="Solo debe contener letras." autofocus required>

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-user }}"></span>
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

{{-- Cedula --}}
<div class="form-group required" style="margin-bottom:-1px">
    <label for="nacionalidad" class="control-label">Nacionalidad y cédula</label>

    <div class="form-row">
        <div class="form-group col-4">
            <select name="nacionalidad" id="nacionalidad"
                class="form-control @error('nacionalidad') is-invalid @enderror" required>
                <option value="V">V</option>
                <option value="E">E</option>
            </select>

            @error('nacionalidad')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group col-8">
            <div class="input-group">
                <input type="string" name="cedula" class="form-control @error('cedula') is-invalid @enderror"
                    value="{{ old('cedula') }}" placeholder="{{ __('Cédula, ej: 1021536') }}" 
                    pattern="^\d{7,8}$" title="Debe contener entre 7 y 8 dígitos." required>

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

{{-- Correo --}}
<div class="form-group required mb-3">
    <label for="email" class="control-label">Correo electrónico</label>

    <div class="input-group">
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email') }}" placeholder="{{ __('Correo Electrónico, ej: micorreo@gmail.com') }}" maxlength="{{ config('variables.usuarios.correo') }}" required>

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

{{-- Contraseña --}}
<div class="form-row">
    <div class="form-group {{ Route::is('register') ? 'col-12' : 'col-6' }} required">
        <label for="password" class="control-label">Contraseña</label>
        
        <div class="input-group">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                placeholder="{{ __('Contraseña') }}" pattern="^[a-zA-Z0-9]{8,}$" title="Debe tener 8 carácteres por lo menos." required>

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    {{-- Confirmar contraseña --}}
    <div class="form-group {{ Route::is('register') ? 'col-12' : 'col-6' }} required">
        <label for="password_confirmation" class="control-label">Confirmar contraseña</label>

        <div class="input-group">
            <input type="password" name="password_confirmation"
                class="form-control @error('password_confirmation') is-invalid @enderror"
                placeholder="{{ __('Confirmar contraseña') }}" pattern="^[a-zA-Z0-9]{8,}$" title="Debe tener 8 carácteres por lo menos." required>

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
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

<x-modal.mensaje-obligatorio />

@if (Route::is('register'))
    <div class="row">
        <div class="col-6 text-center">
            <a href="{{ route('login') }}" class="btn text-primary">
                Iniciar sesión
            </a>
        </div>
        {{-- <div class="col-7">
            <p class="my-0">
                <a href="{{ route('login') }}">
                    {{ __('Iniciar sesión') }}
                </a>
            </p>
        </div> --}}

        <div class="col-6">
            <button type="submit" class="btn btn-block btn-primary">
                {{ __('Registrarme') }}
            </button>
        </div>
    </div>
@else

    <x-modal.footer-aceptar />
@endif
