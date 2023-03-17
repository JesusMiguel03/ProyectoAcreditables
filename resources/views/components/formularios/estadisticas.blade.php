@php
    $periodos = atributo($attributes, 'periodos');
    $materias = atributo($attributes, 'materias');
    $profesor = atributo($attributes, 'profesor');
    $periodoFormateado = atributo($attributes, 'periodo');
    $periodoActual = atributo($attributes, 'periodoActual');
    $materiaActual = atributo($attributes, 'materiaActual')->id ?? null;
    
    empty($profesor) ? ($profesor = 'Sin asignar') : '';
    
    $conversor = [1 => 'I', 2 => 'II', 3 => 'III'];
@endphp

<div class="row">
    <section class="col-md-6 col-sm-12 mx-auto">
        <div class="card">

            <header class="card-header bg-gradient-primary">
                <h6 class="mb-n1 py-1 text-center">
                    <span class="font-weight-bold">Periodo seleccionado: </span>
                    {{ $periodoFormateado }}
                </h6>
            </header>

            <main class="mt-n2 mb-n4 card-body">
                <div class="form-group form-row">
                    <div class="col-md-6 col-sm-12">
                        <label for="periodo" class="control-label">Periodos</label>

                        <div class="input-group">
                            <select name="periodo" class="form-control @error('periodo') is-invalid @enderror" required>
                                <option value="" readonly>Seleccione...</option>

                                @foreach ($periodos as $periodo)
                                    <option value="{{ $periodo->id }}"
                                        {{ $periodo->id === $periodoActual->id ? 'selected' : '' }}>
                                        {{ $conversor[$periodo->fase] . '-' . \Carbon\Carbon::parse($periodo->inicio)->format('Y') }}
                                    </option>
                                @endforeach
                            </select>

                            @error('periodo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <label for="materias" class="control-label">Materias</label>

                        <div class="input-group">
                            <select name="materias" class="form-control @error('materias') is-invalid @enderror"
                                required>
                                <option value="" readonly>Seleccione...</option>

                                @foreach ($materias as $materia)
                                    <option value="{{ $materia->id }}"
                                        {{ $materia->id === $materiaActual ? 'selected' : '' }}>
                                        {{ 'A' . $materia->infoAcreditable() . ' - ' . $materia->nom_materia }}
                                    </option>
                                @endforeach
                            </select>

                            @error('materias')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    @if (Route::is('estadisticas.materia'))
                        <section class="mt-3 mx-auto">
                            <p>
                                <span class="font-weight-bold">
                                    Profesor encargado:
                                </span>
                                {{ $profesor }}
                            </p>
                        </section>
                    @endif
                </div>
            </main>

            <footer class="card-footer row">
                <div class="col-md-6 col-sm-12">
                    <a id="btnPeriodo" class="btn btn-block btn-success">
                        <i class="fas fa-search mr-2"></i>
                        {{ __('Periodo') }}
                    </a>
                </div>

                <div class="col-md-6 col-sm-12">
                    <a id="btnMateria"
                        class="btn btn-block btn-secondary {{ empty($materiaActual) ? 'disabled' : '' }}">
                        <i class="fas fa-search mr-2"></i>
                        {{ __('Materia') }}
                    </a>
                </div>
            </footer>
        </div>
    </section>
</div>
