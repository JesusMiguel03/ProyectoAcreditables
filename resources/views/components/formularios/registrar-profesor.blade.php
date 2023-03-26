@php
    $usuarios = atributo($attributes, 'usuarios');
    $profesor = atributo($attributes, 'profesor');
    $departamentos = atributo($attributes, 'departamentos');
    $conocimientos = atributo($attributes, 'conocimientos');
    
    $activo = null;
    $codigoTlf = null;
    $tlf = null;
    if ($profesor) {
        $activo = $profesor->activo;
        $codigoTlf = substr($profesor->telefono, 0, 4);
        $tlf = substr($profesor->telefono, 4);
    }
@endphp

{{-- Usuario --}}
<div class="form-group required mb-3">
    @if (Route::is('profesores.index'))
        <label for="usuarios" class="control-label">Usuario</label>
    @endif
    <div class="input-group">


        @if (Route::is('profesores.index'))
            <select id="usuario" name="usuarios" class="form-control @error('usuarios') is-invalid @enderror" required>
                <option value='0' readonly>Seleccione un usuario...</option>

                @foreach ($usuarios as $usuario)
                    @if (empty($usuario->profesor))
                        <option value="{{ $usuario->id }}">
                            @php
                                $cedula = 'CI: ' . $usuario->nacionalidad . '-' . number_format($usuario->cedula, 0, '', '.');
                            @endphp
                            {{ $usuario->nombreCompleto() . " ({$cedula})" }}
                        </option>
                    @endif
                @endforeach

            </select>

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
        @else
            {{-- Nombre --}}
            <div class="form-row" style="margin-bottom: -0.75rem">
                <div class="form-group {{ Route::is('register') ? 'col-12' : 'col-6' }} required">
                    <label for="nombre" class="control-label">Nombre</label>

                    <div class="input-group">
                        <input type="text" id="nombre" name="nombre"
                            class="form-control @error('nombre') is-invalid @enderror"
                            value="{{ old('nombre') ?? $profesor->nombreSoloProfesor() }}"
                            placeholder="{{ __('Nombre, ej: José') }}" minlength="3"
                            maxlength="{{ config('variables.usuarios.nombre') }}" pattern="[A-zÀ-ÿ\s]+"
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
                <div class="form-group {{ Route::is('register') ? 'col-12' : 'col-6' }} required">
                    <label for="apellido" class="control-label">Apellido</label>

                    <div class="input-group mb-3">
                        <input type="text" id="apellido" name="apellido"
                            class="form-control @error('apellido') is-invalid @enderror"
                            value="{{ old('apellido') ?? $profesor->apellidoSoloProfesor() }}"
                            placeholder="{{ __('Apellido, ej: Gómez') }}" minlength="3"
                            maxlength="{{ config('variables.usuarios.apellido') }}" pattern="[A-zÀ-ÿ\s]+"
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
            <div class="form-group required" style="margin-bottom:-1px">

                <div class="form-row">
                    <div class="form-group col-4">
                        <label for="nacionalidad" class="control-label">Nacionalidad</label>

                        <select name="nacionalidad" id="nacionalidad"
                            class="form-control @error('nacionalidad') is-invalid @enderror" required>
                            <option value="0" readonly>Seleccione uno...</option>
                            <option value="V"
                                {{ $profesor->nacionalidadSoloProfesor() === 'V' ? 'selected' : '' }}>V
                            </option>
                            <option value="E"
                                {{ $profesor->nacionalidadSoloProfesor() === 'E' ? 'selected' : '' }}>E
                            </option>
                            <option value="P"
                                {{ $profesor->nacionalidadSoloProfesor() === 'P' ? 'selected' : '' }}>P
                            </option>
                        </select>

                        @error('nacionalidad')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group col-8">
                        <label for="cedula" class="control-label">Cédula</label>

                        <div class="input-group">
                            <input type="number" id="cedula" name="cedula"
                                class="form-control @error('cedula') is-invalid @enderror"
                                value="{{ old('cedula') ?? $profesor->cedulaSoloProfesor() }}"
                                placeholder="{{ __('Cédula, ej: 1021536') }}" required>

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
        @endif
    </div>
</div>

{{-- Departamento --}}
<div class="form-group required mt-n2 mb-3">
    <label for="departamento" class="control-label">Adjunto al departamento</label>

    <div class="input-group">
        <select id="departamento" name="departamento" class="form-control" required>
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

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-thumbtack"></span>
            </div>
        </div>

        @error('departamento')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
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
                    <select id="conocimiento" name="conocimiento"
                        class="form-control @error('conocimiento') is-invalid @enderror" required>

                        <option value="" readonly> Seleccione... </option>

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
                    <select id="estadoProfesor" name="activo"
                        class="form-control @error('activo') is-invalid @enderror" required>

                        <option value=""> Seleccione... </option>

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
</div>

{{-- Residencia --}}
<div class="form-group required mt-n2 mb-3" {{ $conocimientos->isEmpty() ? 'style="margin-top: -1rem"' : '' }}>
    <label class="control-label">Residencia</label>

    <div class="form-row mb-3">

        {{-- Estado --}}
        <div class="input-group col-6">
            <input id="estado" type="text" name="estado"
                class="form-control @error('estado') is-invalid @enderror"
                value="{{ $profesor->estado ?? old('estado') }}" placeholder="{{ __('Estado, ej: Aragua') }}"
                maxlength="{{ config('variables.profesores.estado') }}" pattern="[A-zÀ-ÿ0-9\s]+"
                title="Debe contener letras, espacios y/o números." required>

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-map-marker"></span>
                </div>
            </div>

            @error('estado')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Ciudad --}}
        <div class="input-group col-6">
            <input id="ciudad" type="text" name="ciudad"
                class="form-control @error('ciudad') is-invalid @enderror"
                value="{{ $profesor->ciudad ?? old('ciudad') }}" placeholder="{{ __('Ciudad, ej: La Victoria') }}"
                maxlength="{{ config('variables.profesores.ciudad') }}" pattern="[A-zÀ-ÿ0-9\s]+"
                title="Debe contener letras, espacios y/o números." required>

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-map-marker"></span>
                </div>
            </div>

            @error('ciudad')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    {{-- Urbanizacion --}}
    <div class="form-row">
        <div class="input-group col-4">
            <input id="urb" type="text" name="urb"
                class="form-control @error('urb') is-invalid @enderror" value="{{ $profesor->urb ?? old('urb') }}"
                placeholder="{{ __('Urbanización, ej: Carmelitas') }}"
                maxlength="{{ config('variables.profesores.urb') }}" pattern="[A-zÀ-ÿ0-9\s]+"
                title="Debe contener letras, espacios y/o números." required>

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-map-marker"></span>
                </div>
            </div>

            @error('urb')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Calle --}}
        <div class="input-group col-4">
            <input id="calle" type="text" name="calle"
                class="form-control @error('calle') is-invalid @enderror"
                value="{{ $profesor->calle ?? old('calle') }}" placeholder="{{ __('Calle, ej: 12 de julio') }}"
                maxlength="{{ config('variables.profesores.calle') }}" pattern="[A-zÀ-ÿ0-9\s]+"
                title="Debe contener letras, espacios y/o números." required>

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-map-marker"></span>
                </div>
            </div>

            @error('calle')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Casa --}}
        <div class="input-group col-4">
            <input id="casa" type="text" name="casa"
                class="form-control @error('casa') is-invalid @enderror"
                value="{{ $profesor->casa ?? old('casa') }}" placeholder="{{ __('Casa, ej: 5') }}"
                maxlength="{{ config('variables.profesores.casa') }}" pattern="[A-zÀ-ÿ0-9\s]+"
                title="Debe contener letras, espacios y/o números." required>

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-map-marker"></span>
                </div>
            </div>

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
            <select id="codigo" name="codigo" class="form-control @error('codigo') is-invalid @enderror"
                required>
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
                <input id="tlf" type="tel" name="telefono"
                    class="form-control @error('telefono') is-invalid @enderror @error('codigoTelefono') is-invalid @enderror"
                    value="{{ $tlf ?? old('telefono') }}" placeholder="{{ __('0193451') }}" pattern="[0-9]+"
                    maxlength="{{ config('variables.profesores.telefono') - 4 }}" required>

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
    <div class="row">
        <div class="col-6">
            <a href="{{ route('profesores.index') }}" class="btn btn-block btn-secondary">
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
@else
    <div class="row">
        <div class="col-6">
            <button id='cancelar' type="button" class="btn btn-block btn-secondary" data-dismiss="modal">
                <i class="fas fa-arrow-left mr-2"></i>
                {{ __('Cancelar') }}
            </button>
        </div>

        <div class="col-6">
            <button id='formularioEnviar' type="submit" class="btn btn-block btn-success">
                <i class="fas fa-save mr-2"></i>
                {{ __('Guardar') }}
            </button>
        </div>
    </div>
@endif
