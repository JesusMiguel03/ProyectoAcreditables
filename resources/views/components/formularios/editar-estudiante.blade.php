@php
    $usuario = atributo($attributes, 'usuario');
    $trayectos = atributo($attributes, 'trayectos');
    $pnfs = atributo($attributes, 'pnfs');
    $pnfsNoDisponibles = atributo($attributes, 'pnfsNoDisponibles');
@endphp

{{-- Nombre --}}
<div class="form-group mb-3">
    <label>Nombre</label>
    <div class="input-group">
        <input type="text" class="form-control"
            placeholder="{{ datosUsuario($usuario, 'Usuario', 'nombreCompleto') }}" disabled>

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-user"></span>
            </div>
        </div>
    </div>
</div>

{{-- Cedula --}}
<div class="form-group mb-3">
    <label>Cédula</label>
    <div class="input-group">
        <input type="text" class="form-control"
            placeholder="{{ datosUsuario($usuario, 'Usuario', 'CI') }}" disabled>

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-id-card"></span>
            </div>
        </div>
    </div>
</div>

<form action="{{ route('estudiantes.update', $usuario->id) }}" method="post">
    @csrf
    {{ method_field('PUT') }}

    <div class="form-group required mb-3">
        <label for="trayecto" class="control-label">Trayecto</label>
        <div class="input-group">
            <select name="trayecto" class="form-control @error('trayecto') is-invalid @enderror" required>
                <option value="0" readonly>Seleccione...</option>

                @foreach ($trayectos as $trayecto)
                    <option value="{{ $trayecto->id }}"
                        {{ datosUsuario($usuario, 'Usuario', 'trayecto_id') === $trayecto->id ? 'selected' : '' }}>
                        {{ $trayecto->num_trayecto }}
                    </option>
                @endforeach
            </select>

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-bookmark"></span>
                </div>
            </div>

            @error('trayecto')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group required mb-3">
        <label for="pnf" class="control-label">PNF</label>
        <div class="input-group">
            <select name="pnf" class="form-control @error('pnf') is-invalid @enderror" required>
                <option value="0" readonly>Seleccione...</option>

                @foreach ($pnfs as $pnf)
                    @if (!in_array($pnf->nom_pnf, $pnfsNoDisponibles))
                        <option value="{{ $pnf->id }}"
                            {{ datosUsuario($usuario, 'Usuario', 'PNF_id') === $pnf->id ? 'selected' : '' }}>
                            {{ $pnf->nom_pnf }}
                        </option>
                    @endif
                @endforeach
            </select>

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-book"></span>
                </div>
            </div>

            @error('pnf')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <x-modal.mensaje-obligatorio />

    <x-modal.footer-editar ruta="{{ route('estudiantes.index') }}" />
</form>