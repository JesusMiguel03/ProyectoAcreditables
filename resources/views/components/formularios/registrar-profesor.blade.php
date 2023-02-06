@php
    $usuarios = atributo($attributes, 'usuarios');
    $profesor = atributo($attributes, 'profesor');
    $departamentos = atributo($attributes, 'departamentos');
    $conocimientos = atributo($attributes, 'conocimientos');
    $activo = atributo($attributes, 'activo');
    $codigoTlf = !empty($profesor) ? substr($profesor->telefono, 0, 4) : null;
    $tlf = !empty($profesor) ? substr($profesor->telefono, 4) : null;
@endphp

{{-- Usuario --}}
<div class="form-group required mb-3">
    <label for="usuarios" class="control-label">Usuario</label>
    <div class="input-group">

        @if (Route::is('profesores.index'))
            <select class="form-control @error('usuarios') is-invalid @enderror" name="usuarios" required>
                <option value='0' readonly>Seleccione un usuario...</option>

                @foreach ($usuarios as $usuario)
                    @if (empty($usuario->profesor))
                        <option value="{{ $usuario->id }}">
                            {{ datosUsuario($usuario, 'Usuario', 'nombreCompleto') . ' | ' . datosUsuario($usuario, 'Usuario', 'CI') }}
                        </option>
                    @endif
                @endforeach

            </select>
        @else
            <input type="text" name="usuarios" id="usuarios"
                class="form-control @error('usuarios') is-invalid @enderror"
                value="{{ datosUsuario($profesor, 'Profesor', 'nombreCompleto') . '- CI: ' . datosUsuario($profesor, 'Profesor', 'CI') }}"
                readonly disabled>
        @endif

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-user"></span>
            </div>
        </div>

        @error('usuarios')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

{{-- Departamento --}}
<div class="form-group required mb-3">
    <label for="departamento" class="control-label">Adjunto al departamento</label>
    <div class="input-group">
        <div class="input-group">
            <select name="departamento" class="form-control" required>
                <option value="0" readonly>Seleccione...</option>

                @foreach ($departamentos as $departamento)
                    @if (!empty($profesor))
                        <option value="{{ $departamento->id }}"
                            {{ $departamento->id === $profesor->departamento->id ? 'selected' : '' }}>
                            {{ $departamento->nom_pnf }}
                        </option>
                    @else
                        <option value="{{ $departamento->id }}">
                            {{ $departamento->nom_pnf }}
                        </option>
                    @endif
                @endforeach

            </select>

            @error('departamento')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">

        {{-- Conocimiento --}}
        <div class="form-group required {{ Route::is('profesores.index') ? 'col-12' : 'col-6' }}">
            <label for="conocimiento" class="control-label">Área de conocimiento</label>

            <div class="input-group">

                @if ($conocimientos->isEmpty())
                    <x-elementos.vacio :modelo="'áreas de conocimiento'" />
                @else
                    <select name="conocimiento" class="form-control @error('conocimiento') is-invalid @enderror"
                        required>

                        <option value=0 readonly> Seleccione... </option>

                        @foreach ($conocimientos as $conocimiento)
                            @if (!empty($profesor))
                                <option value="{{ $conocimiento->id }}"
                                    {{ $conocimiento->id === $profesor->conocimiento->id ? 'selected' : '' }}>
                                    {{ $conocimiento->nom_conocimiento }}
                                </option>
                            @else
                                <option value="{{ $conocimiento->id }}">
                                    {{ $conocimiento->nom_conocimiento }}
                                </option>
                            @endif
                        @endforeach

                    </select>

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user-graduate"></span>
                        </div>
                    </div>

                    @error('conocimiento')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                @endif

            </div>
        </div>

        {{-- Estado del profesor --}}
        @if (Route::is('profesores.edit'))
            <div class="form-group required col-6">
                <label for="activo" class="control-label">¿Se encuentra activo?</label>
                <div class="input-group">
                    <select name="activo" class="form-control @error('activo') is-invalid @enderror" required>

                        <option> Seleccione... </option>

                        <option value=1 {{ $activo === 1 ? 'selected' : '' }}>
                            Activo
                        </option>
                        <option value=0 {{ $activo === 0 ? 'selected' : '' }}>
                            Inactivo
                        </option>
                    </select>

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-eye"></span>
                        </div>
                    </div>

                    @error('activo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        @endif
    </div>

    {{-- Residencia --}}
    <div class="form-group required mb-3" {{ $conocimientos->isEmpty() ? 'style="margin-top: -1rem"' : '' }}>
        <label class="control-label">Residencia</label>
        <div class="form-row">

            {{-- Estado --}}
            <div class="form-group col-6">
                <input type="text" name="estado" id="estado"
                    class="form-control @error('estado') is-invalid @enderror"
                    value="{{ $profesor->estado ?? old('estado') }}" placeholder="{{ __('Estado') }}"
                    maxlength="{{ config('variables.profesores.estado') }}" data-nombre="caracteres" required>

                @error('estado')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            {{-- Ciudad --}}
            <div class="form-group col-6">
                <input type="text" name="ciudad" id="ciudad"
                    class="form-control @error('ciudad') is-invalid @enderror"
                    value="{{ $profesor->ciudad ?? old('ciudad') }}" placeholder="{{ __('Ciudad') }}"
                    maxlength="{{ config('variables.profesores.ciudad') }}" data-nombre="caracteres" required>

                @error('ciudad')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        {{-- Urbanizacion --}}
        <div class="form-row">
            <div class="form-group col-4">
                <input type="text" name="urb" id="urb"
                    class="form-control @error('urb') is-invalid @enderror" value="{{ $profesor->urb ?? old('urb') }}"
                    placeholder="{{ __('Urbanización') }}" maxlength="{{ config('variables.profesores.urb') }}"
                    data-nombre="caracteres" required>

                @error('urb')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            {{-- Calle --}}
            <div class="form-group col-4">
                <input type="text" name="calle" id="calle"
                    class="form-control @error('calle') is-invalid @enderror"
                    value="{{ $profesor->calle ?? old('calle') }}" placeholder="{{ __('Calle') }}"
                    maxlength="{{ config('variables.profesores.calle') }}" data-nombre="caracteres" required>

                @error('calle')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            {{-- Casa --}}
            <div class="form-group col-4">
                <input type="text" name="casa" id="casa"
                    class="form-control @error('casa') is-invalid @enderror"
                    value="{{ $profesor->casa ?? old('casa') }}" placeholder="{{ __('Casa') }}"
                    maxlength="{{ config('variables.profesores.casa') }}" data-nombre="caracteres" required>

                @error('casa')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    </div>

    {{-- Telefono --}}
    <div class="form-group required" style="margin-top: -10px">
        <label for="telefono" class="control-label">Número de contacto</label>
        <div class="row">
            <div class="col-4">
                <select name="codigo" class="form-control @error('codigo') is-invalid @enderror" required>
                    <option value="0" readonly>Seleccione...</option>

                    <option value="0412" {{ $codigoTlf === '0412' ? 'selected' : '' }}>0412</option>
                    <option value="0414" {{ $codigoTlf === '0414' ? 'selected' : '' }}>0414</option>
                    <option value="0416" {{ $codigoTlf === '0416' ? 'selected' : '' }}>0416</option>
                    <option value="0424" {{ $codigoTlf === '0424' ? 'selected' : '' }}>0424</option>
                    <option value="0426" {{ $codigoTlf === '0426' ? 'selected' : '' }}>0426</option>
                </select>

                @error('codigo')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-8">
                <div class="input-group">
                    <input type="tel" name="telefono"
                        class="form-control @error('telefono') is-invalid @enderror @error('codigoTelefono') is-invalid @enderror"
                        value="{{ $tlf ?? old('telefono') }}" placeholder="{{ __('0193451') }}"
                        maxlength="{{ config('variables.profesores.telefono') - 4 }}" data-nombre="dígitos" required>

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-phone"></span>
                        </div>
                    </div>

                    @error('codigoTelefono')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    @error('telefono')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    {{-- Fechas --}}
    <div class="form-group required mb-3">
        <div class="form-row">

            {{-- Fecha de nacimiento --}}
            <div class="form-group  {{ Route::is('profesores.edit') ? 'col-12' : 'col-6' }}">
                <label for="fecha_de_nacimiento" class="control-label">
                    Fecha de nacimiento
                </label>
                <div class="input-group date" data-target-input="nearest">
                    <input type="text" id="fecha_nacimiento" name="fecha_de_nacimiento"
                        class="form-control datetimepicker-input @error('fecha_de_nacimiento') is-invalid @enderror"
                        data-target="#fecha_nacimiento" data-toggle="datetimepicker"
                        value="{{ $profesor->fecha_de_nacimiento ?? old('fecha_de_nacimiento') }}"
                        placeholder="{{ __('Ej: 1983-09-06') }}" required>

                    <div class="input-group-append" data-target="#fecha_nacimiento" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>

                    @error('fecha_de_nacimiento')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            {{-- Fecha de ingreso a la institución --}}
            <div class="form-group {{ Route::is('profesores.edit') ? 'col-12' : 'col-6' }}">
                <label for="fecha_ingreso_institucion" class="control-label">
                    Fecha de ingreso a la institución
                </label>

                <div class="input-group date" data-target-input="nearest">
                    <input type="text" id="fecha_ingreso" name="fecha_ingreso_institucion"
                        class="form-control datetimepicker-input @error('fecha_ingreso_institucion') is-invalid @enderror"
                        data-target="#fecha_ingreso" data-toggle="datetimepicker"
                        value="{{ $profesor->fecha_ingreso_institucion ?? old('fecha_ingreso_institucion') }}"
                        placeholder="{{ __('Ej: 2013-03-19') }}" required>

                    <div class="input-group-append" data-target="#fecha_ingreso" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>

                    @error('fecha_ingreso_institucion')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <x-modal.mensaje-obligatorio />
        </div>
    </div>

    @if (Route::is('profesores.edit'))
        <x-modal.footer-editar ruta="{{ route('profesores.index') }}" />
    @else
        <x-modal.footer-aceptar />
    @endif
