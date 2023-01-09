{{-- Nombre --}}
<div class="form-row" style="margin-bottom: -0.75rem">
    <div class="form-group required col-6">
        <label for="nombre" class="control-label">Nombre</label>
        <div class="input-group">
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                value="{{ old('nombre') }}" placeholder="{{ __('Nombre') }}" autofocus required>

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
    <div class="form-group col-6 required">
        <label for="apellido" class="control-label">Apellido</label>
        <div class="input-group mb-3">
            <input type="text" name="apellido" class="form-control @error('apellido') is-invalid @enderror"
                value="{{ old('apellido') }}" placeholder="{{ __('Apellido') }}" autofocus required>

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
<div class="form-group required mb-3">
    <label for="cedula" class="control-label">Cédula</label>
    <div class="input-group">
        <input type="text" name="cedula" class="form-control @error('cedula') is-invalid @enderror"
            value="{{ old('cedula') }}" placeholder="{{ __('Cedula') }}" autofocus required>

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

{{-- Correo --}}
<div class="form-group required mb-3">
    <label for="email" class="control-label">Correo electrónico</label>
    <div class="input-group">
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email') }}" placeholder="{{ __('Correo Electrónico') }}" autofocus required>

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
    <div class="form-group col-6 required">
        <label for="password" class="control-label">Contraseña</label>
        <div class="input-group">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                placeholder="{{ __('Contraseña') }}" autofocus required>

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
    <div class="form-group col-6 required">
        <label for="password_confirmation" class="control-label">Confirmar contraseña</label>
        <div class="input-group">
            <input type="password" name="password_confirmation"
                class="form-control @error('password_confirmation') is-invalid @enderror"
                placeholder="{{ __('Confirmar contraseña') }}" autofocus required>

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

<x-modal.footer-aceptar />
