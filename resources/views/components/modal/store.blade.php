<div class="row">
    <div class="col-3">
        <div class="card">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#{{ $nombre }}">
                <i class="fas fa-plus mr-2"></i>
                {{ __('Añadir ' . $nombre) }}
            </button>
        </div>
    </div>
</div>

{{-- Modal para crear --}}
<div class="modal fade" id="{{ $nombre }}" tabindex="-1" role="dialog" aria-labelledby="campo{{ $nombre }}"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="campo{{ $nombre }}">Agregar {{ $nombre }}</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route($ruta . '.store') }}" method="post">
                    @csrf

                    {{-- Campo de número --}}
                    @if ($numero === "true")
                        <div class="form-group mb-3">
                            <input type="number" name="numero" id="numero"
                                class="form-control @error('numero') is-invalid @enderror" value="{{ old('numero') }}"
                                placeholder="{{ __('Número del ' . $nombre) }}" autofocus>
                            <small class="form-text text-muted">Solo hay 12 aulas disponibles por edificio.</small>

                            @error('numero')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    @endif

                    @if ($texto === "true")
                        {{-- Campo de edificio --}}
                        <div class="form-group mb-3">
                            <input type="text" name="edificio" id="edificio"
                                class="form-control @error('edificio') is-invalid @enderror"
                                value="{{ old('edificio') }}" placeholder="{{ __('Edificio a usar') }}" autofocus>
                            <small class="form-text text-muted">Los edificios disponibles son: A, B o C.</small>

                            @error('edificio')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    @endif

                    {{-- Botón de registrar --}}
                    <div class="row">
                        <div class="col-6">
                            <button type="button" class="btn btn-block btn-secondary"
                                data-dismiss="modal">{{ __('Cancelar') }}</button>
                        </div>
                        <div class="col-6">
                            <button id="actualizar" class="btn btn-block btn-primary">
                                {{ __('Añadir ' . $nombre) }}
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
