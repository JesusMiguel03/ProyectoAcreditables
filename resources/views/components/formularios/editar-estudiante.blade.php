@php
    $usuario = atributo($attributes, 'usuario');
    $trayectos = atributo($attributes, 'trayectos');
    $pnfs = atributo($attributes, 'pnfs');
    $pnfsNoDisponibles = atributo($attributes, 'pnfsNoDisponibles');
    
    $trayectoID = $usuario->estudiante->trayecto->id ?? null;
    $pnfID = $usuario->estudiante->pnf->id ?? null;
@endphp


<form action="{{ route('estudiantes.update', $usuario->id) }}" method="post">
    @csrf
    {{ method_field('PUT') }}

    {{-- Nombre --}}
    <div class="form-row" style="margin-bottom: -0.75rem">
        <div class="form-group col-6 required">
            <label for="nombre" class="control-label">Nombre</label>

            <div class="input-group">
                <input type="text" id="nombre" name="nombre"
                    class="form-control @error('nombre') is-invalid @enderror"
                    value="{{ old('nombre') ?? $usuario->nombre }}" placeholder="{{ __('Nombre, ej: José') }}"
                    minlength="3" maxlength="{{ config('variables.usuarios.nombre') }}" pattern="[A-zÀ-ÿ]+"
                    title="Solo debe contener letras." autofocus required>

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
                <input type="text" id="apellido" name="apellido"
                    class="form-control @error('apellido') is-invalid @enderror"
                    value="{{ old('apellido') ?? $usuario->apellido }}" placeholder="{{ __('Apellido, ej: Gómez') }}"
                    minlength="3" maxlength="{{ config('variables.usuarios.apellido') }}" pattern="[A-zÀ-ÿ]+"
                    title="Solo debe contener letras." autofocus required>

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
    <div class="form-row mb-3">

        <div class="form-group required col-6">
            <label for="nacionalidad" class="control-label">Nacionalidad</label>

            <div class="input-group">
                <select name="nacionalidad" id="nacionalidad" class="form-control" required>
                    <option value="0" readonly>Seleccione uno...</option>

                    <option value="V" {{ $usuario->nacionalidad === 'V' ? 'selected' : '' }}>V</option>
                    <option value="E" {{ $usuario->nacionalidad === 'E' ? 'selected' : '' }}>E</option>
                    <option value="P" {{ $usuario->nacionalidad === 'P' ? 'selected' : '' }}>P</option>
                </select>

                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-id-card"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group required col-6">
            <label for="cedula" class="control-label">Cédula</label>

            <div class="input-group">
                <input type="number" id="cedula" name="cedula" class="form-control" value="{{ $usuario->cedula }}"
                    placeholder="{{ __('Cédula, ej: 1021536') }}" required>

                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-id-card"></span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Trayecto --}}
    <div class="form-group required mt-n2 mb-3">
        <label for="trayecto" class="control-label">Trayecto</label>

        <div class="input-group">
            <select id="trayecto" name="trayecto" class="form-control @error('trayecto') is-invalid @enderror" title="Debe seleccionar una opción de la lista."
                required>
                <option value="" readonly>Seleccione...</option>

                @foreach ($trayectos as $trayecto)
                    <option value="{{ $trayecto->id }}" {{ $trayectoID === $trayecto->id ? 'selected' : '' }}>
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

    {{-- PNF --}}
    <div class="form-group required mb-3">
        <label for="pnf" class="control-label">PNF</label>

        <div class="input-group">
            <select id="pnf" name="pnf" class="form-control @error('pnf') is-invalid @enderror" title="Debe seleccionar una opción de la lista." required>
                <option value="0" readonly>Seleccione...</option>

                @foreach ($pnfs as $pnf)
                    @if (!in_array($pnf->nom_pnf, $pnfsNoDisponibles))
                        <option value="{{ $pnf->id }}" {{ $pnfID === $pnf->id ? 'selected' : '' }}>
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

    <div class="row">
        <div class="col-6">
            <a href="{{ route('estudiantes.index') }}" class="btn btn-block btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i>
                {{ __('Volver') }}
            </a>
        </div>

        <div class="col-6">
            <button type="submit" id="formularioEnviar" class="btn btn-block btn-success">
                <i class="fas fa-save mr-2"></i>
                {{ __('Guardar') }}
            </button>
        </div>
    </div>
</form>
