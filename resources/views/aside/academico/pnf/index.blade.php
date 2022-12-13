@extends('adminlte::page')

@section('title', 'Acreditables | PNF')

@section('content_header')
    <div class="row">
        <div class="col-6">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
                <li class="breadcrumb-item active"><a href="">PNF</a></li>
            </ol>
        </div>
        <div class="col-6">
            <div class="card float-right">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pnf">
                    <i class="fas fa-plus mr-2"></i>
                    {{ __('Añadir PNF') }}
                </button>
            </div>

            {{-- Modal para crear --}}
            <div class="modal fade" id="pnf" tabindex="-1" role="dialog" aria-labelledby="campopnf"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <header class="modal-header bg-primary">
                            <h5 class="modal-title" id="campopnf">Agregar PNF</h5>
                        </header>
                        <main class="modal-body">
                            <form action="{{ route('pnf.store') }}" method="post">
                                @csrf

                                {{-- Nombre --}}
                                <div class="form-group required mb-3">
                                    <label for="nom_pnf" class="control-label">Nombre</label>
                                    <input type="text" name="nom_pnf" id="nom_pnf"
                                        class="form-control @error('nom_pnf') is-invalid @enderror"
                                        value="{{ old('nom_pnf') }}" placeholder="{{ __('Nombre del PNF') }}" autofocus
                                        required>

                                    @error('nom_pnf')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- Código --}}
                                <div class="form-group mb-3">
                                    <label for="cod_pnf">Código</label>
                                    <input type="text" name="cod_pnf" id="cod_pnf"
                                        class="form-control @error('cod_pnf') is-invalid @enderror"
                                        value="{{ old('cod_pnf') }}" placeholder="{{ __('Código del PNF') }}" autofocus>

                                    @error('cod_pnf')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group" style="margin-bottom: -10px">
                                    <p class="pl-2 text-danger"><strong>Nota:</strong> (*) Indica los campos que
                                        son obligatorios.
                                    </p>
                                </div>

                                {{-- Botón de registrar --}}
                                <div class="row">
                                    <x-botones.cancelar />

                                    <x-botones.guardar />
                                </div>

                            </form>
                        </main>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-tipografia.titulo>PNF</x-tipografia.titulo>
@stop

@section('content')
    <div class="col-12 mb-3">
        <div class="card table-responsive-sm p-3 mb-4">
            <table id='tabla' class="table table-striped">
                <thead>
                    <tr class="bg-secondary">
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($pnfs as $pnf)
                        <tr>
                            @if ($pnf->cod_pnf === 'No ve')
                                <td>{{ 'No cursa acreditable' }}</td>
                            @else
                                <td>{{ $pnf->cod_pnf === '?' ? 'Sin asignar' : $pnf->cod_pnf }}</td>
                            @endif
                            <td>{{ $pnf->nom_pnf }}</td>
                            <td><a href="{{ route('pnf.edit', $pnf->id) }}" class="btn btn-primary"
                                    {{ Popper::arrow()->pop('Editar') }}>
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('/vendor/DataTables/datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/required.css') }}">
@stop

@section('js')
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('vendor/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('/js/tablas.js') }}"></script>
    <script>
        @if ($message = session('creado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡PNF registrado!',
                html: 'Un nuevo PNF ha sido añadido.',
                confirmButtonColor: '#28a745',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('error'))
            let timerInterval
            Swal.fire({
                icon: 'error',
                title: 'Error al registrar',
                html: 'Uno de los parámetros parece estar mal.',
                confirmButtonColor: '#dc3545',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
            $('#pnf').modal('show')
        @elseif ($message = session('registrado'))
            let timerInterval
            Swal.fire({
                icon: 'info',
                title: 'Ya fue registrado',
                html: 'El PNF ya se encuentra registrado.',
                confirmButtonColor: '#17a2b8',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('actualizado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Datos actualizados!',
                html: 'El PNF ha sido actualizado.',
                confirmButtonColor: '#28a745',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @endif
    </script>
@stop
