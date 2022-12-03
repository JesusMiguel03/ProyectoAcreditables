@extends('adminlte::page')

@section('title', 'Acreditables | Asistencia')

@section('content_header')
    <div class="col-6">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('asistencia') }}" class="link-muted">Asistencia</a></li>
            <li class="breadcrumb-item active"><a href="">{{ $estudiante->usuarios->nombre }}
                    {{ $estudiante->usuarios->apellido }}</a></li>
        </ol>
    </div>
@stop

@section('content')
    <div class="card col-12 table-responsive-sm p-3 mt-1 mb-3">
        <form action="{{ route('asistencia-actualizar') }}" method="post">
            @csrf

            <input type="text" name="id" value="{{ $estudiante->id }}" class="d-none" hidden>

            <table id='tabla' class="table table-striped">
                <thead>
                    <tr class="bg-secondary">
                        <th>Semana</th>
                        @for ($i = 1; $i <= 12; $i++)
                            <th>{{ $i }}</th>
                        @endfor
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>Presente</td>
                        <td>
                            <div class="icheck-primary">
                                <input type="checkbox" name="Sem1" id="Sem1"
                                    {{ $estudiante->asistencia->Sem1 === 1 ? 'checked' : '' }}>

                                <label for="Sem1">
                                    {{ __('') }}
                                </label>
                            </div>
                        </td>
                        <td>
                            <div class="icheck-primary">
                                <input type="checkbox" name="Sem2" id="Sem2"
                                    {{ $estudiante->asistencia->Sem2 === 1 ? 'checked' : '' }}>

                                <label for="Sem2">
                                    {{ __('') }}
                                </label>
                            </div>
                        </td>
                        <td>
                            <div class="icheck-primary">
                                <input type="checkbox" name="Sem3" id="Sem3"
                                    {{ $estudiante->asistencia->Sem3 === 1 ? 'checked' : '' }}>

                                <label for="Sem3">
                                    {{ __('') }}
                                </label>
                            </div>
                        </td>
                        <td>
                            <div class="icheck-primary">
                                <input type="checkbox" name="Sem4" id="Sem4"
                                    {{ $estudiante->asistencia->Sem4 === 1 ? 'checked' : '' }}>

                                <label for="Sem4">
                                    {{ __('') }}
                                </label>
                            </div>
                        </td>
                        <td>
                            <div class="icheck-primary">
                                <input type="checkbox" name="Sem5" id="Sem5"
                                    {{ $estudiante->asistencia->Sem5 === 1 ? 'checked' : '' }}>

                                <label for="Sem5">
                                    {{ __('') }}
                                </label>
                            </div>
                        </td>
                        <td>
                            <div class="icheck-primary">
                                <input type="checkbox" name="Sem6" id="Sem6"
                                    {{ $estudiante->asistencia->Sem6 === 1 ? 'checked' : '' }}>

                                <label for="Sem6">
                                    {{ __('') }}
                                </label>
                            </div>
                        </td>
                        <td>
                            <div class="icheck-primary">
                                <input type="checkbox" name="Sem7" id="Sem7"
                                    {{ $estudiante->asistencia->Sem7 === 1 ? 'checked' : '' }}>

                                <label for="Sem7">
                                    {{ __('') }}
                                </label>
                            </div>
                        </td>
                        <td>
                            <div class="icheck-primary">
                                <input type="checkbox" name="Sem8" id="Sem8"
                                    {{ $estudiante->asistencia->Sem8 === 1 ? 'checked' : '' }}>

                                <label for="Sem8">
                                    {{ __('') }}
                                </label>
                            </div>
                        </td>
                        <td>
                            <div class="icheck-primary">
                                <input type="checkbox" name="Sem9" id="Sem9"
                                    {{ $estudiante->asistencia->Sem9 === 1 ? 'checked' : '' }}>

                                <label for="Sem9">
                                    {{ __('') }}
                                </label>
                            </div>
                        </td>
                        <td>
                            <div class="icheck-primary">
                                <input type="checkbox" name="Sem10" id="Sem10"
                                    {{ $estudiante->asistencia->Sem10 === 1 ? 'checked' : '' }}>

                                <label for="Sem10">
                                    {{ __('') }}
                                </label>
                            </div>
                        </td>
                        <td>
                            <div class="icheck-primary">
                                <input type="checkbox" name="Sem11" id="Sem11"
                                    {{ $estudiante->asistencia->Sem11 === 1 ? 'checked' : '' }}>

                                <label for="Sem11">
                                    {{ __('') }}
                                </label>
                            </div>
                        </td>
                        <td>
                            <div class="icheck-primary">
                                <input type="checkbox" name="Sem12" id="Sem12"
                                    {{ $estudiante->asistencia->Sem12 === 1 ? 'checked' : '' }}>

                                <label for="Sem12">
                                    {{ __('') }}
                                </label>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button type="submit" class="btn btn-success float-right px-5 ml-3" {{ Popper::arrow()->size('large')->pop('Si ha guardado debe hacer clic 2 veces en volver para ir a esa vista, caso contrario solo 1') }}>
                <i class="fas fa-save mr-2"></i>
                Guardar
            </button>
            <a onclick="history.back()" class="btn btn-secondary float-right px-5">
                <i class="fas fa-arrow-circle-left mr-2"></i>
                Volver
            </a>
        </form>
    </div>
@stop

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('/vendor/DataTables/datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
@stop

@section('js')
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        @if ($message = session('creado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Asistencia registrada!',
                html: 'La asistencia del estudiante ha sido actualizada.',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @endif
    </script>
@stop
