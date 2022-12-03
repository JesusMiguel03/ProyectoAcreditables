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
                                <input type="checkbox" name="sem1" id="sem1"
                                    {{ $estudiante->asistencia->sem1 === 1 ? 'checked' : '' }}>

                                <label for="sem1">
                                    {{ __('') }}
                                </label>
                            </div>
                        </td>
                        <td>
                            <div class="icheck-primary">
                                <input type="checkbox" name="sem2" id="sem2"
                                    {{ $estudiante->asistencia->sem2 === 1 ? 'checked' : '' }}>

                                <label for="sem2">
                                    {{ __('') }}
                                </label>
                            </div>
                        </td>
                        <td>
                            <div class="icheck-primary">
                                <input type="checkbox" name="sem3" id="sem3"
                                    {{ $estudiante->asistencia->sem3 === 1 ? 'checked' : '' }}>

                                <label for="sem3">
                                    {{ __('') }}
                                </label>
                            </div>
                        </td>
                        <td>
                            <div class="icheck-primary">
                                <input type="checkbox" name="sem4" id="sem4"
                                    {{ $estudiante->asistencia->sem4 === 1 ? 'checked' : '' }}>

                                <label for="sem4">
                                    {{ __('') }}
                                </label>
                            </div>
                        </td>
                        <td>
                            <div class="icheck-primary">
                                <input type="checkbox" name="sem5" id="sem5"
                                    {{ $estudiante->asistencia->sem5 === 1 ? 'checked' : '' }}>

                                <label for="sem5">
                                    {{ __('') }}
                                </label>
                            </div>
                        </td>
                        <td>
                            <div class="icheck-primary">
                                <input type="checkbox" name="sem6" id="sem6"
                                    {{ $estudiante->asistencia->sem6 === 1 ? 'checked' : '' }}>

                                <label for="sem6">
                                    {{ __('') }}
                                </label>
                            </div>
                        </td>
                        <td>
                            <div class="icheck-primary">
                                <input type="checkbox" name="sem7" id="sem7"
                                    {{ $estudiante->asistencia->sem7 === 1 ? 'checked' : '' }}>

                                <label for="sem7">
                                    {{ __('') }}
                                </label>
                            </div>
                        </td>
                        <td>
                            <div class="icheck-primary">
                                <input type="checkbox" name="sem8" id="sem8"
                                    {{ $estudiante->asistencia->sem8 === 1 ? 'checked' : '' }}>

                                <label for="sem8">
                                    {{ __('') }}
                                </label>
                            </div>
                        </td>
                        <td>
                            <div class="icheck-primary">
                                <input type="checkbox" name="sem9" id="sem9"
                                    {{ $estudiante->asistencia->sem9 === 1 ? 'checked' : '' }}>

                                <label for="sem9">
                                    {{ __('') }}
                                </label>
                            </div>
                        </td>
                        <td>
                            <div class="icheck-primary">
                                <input type="checkbox" name="sem10" id="sem10"
                                    {{ $estudiante->asistencia->sem10 === 1 ? 'checked' : '' }}>

                                <label for="sem10">
                                    {{ __('') }}
                                </label>
                            </div>
                        </td>
                        <td>
                            <div class="icheck-primary">
                                <input type="checkbox" name="sem11" id="sem11"
                                    {{ $estudiante->asistencia->sem11 === 1 ? 'checked' : '' }}>

                                <label for="sem11">
                                    {{ __('') }}
                                </label>
                            </div>
                        </td>
                        <td>
                            <div class="icheck-primary">
                                <input type="checkbox" name="sem12" id="sem12"
                                    {{ $estudiante->asistencia->sem12 === 1 ? 'checked' : '' }}>

                                <label for="sem12">
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
