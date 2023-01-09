@extends('adminlte::page')

@section('title', 'Acreditables | Recuperar')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item active"><a href="">Recuperar elementos</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Recuperar elementos borrados</x-tipografia.titulo>
@stop

@section('content')
    <div class="card table-responsive-sm p-3 mb-3">
        <table id='tabla' class="table table-striped">
            <thead>
                <tr class="bg-secondary">
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($conocimientos as $nombre => $id)
                    <tr>
                        <td>{{ $nombre }}</td>
                        <td>Área de conocimiento</td>
                        <td>
                            <div class="btn-group mx-1" role="group" aria-label="Acciones">
                                <form action="{{ route('soporte.recuperar', [$id, 'AreaConocimiento']) }}"
                                    method="get">
                                    @csrf

                                    <button class="btn btn-success">
                                        <i class="fas fa-trash-restore"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach

                @foreach ($pnfs as $nombre => $id)
                    <tr>
                        <td>{{ $nombre }}</td>
                        <td>PNF</td>
                        <td>
                            <div class="btn-group mx-1" role="group" aria-label="Acciones">
                                <form action="{{ route('soporte.recuperar', [$id, 'PNF']) }}"
                                    method="get">
                                    @csrf

                                    <button class="btn btn-success">
                                        <i class="fas fa-trash-restore"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach

                @foreach ($trayectos as $nombre => $id)
                    <tr>
                        <td>{{ $nombre }}</td>
                        <td>Trayecto</td>
                        <td>
                            <div class="btn-group mx-1" role="group" aria-label="Acciones">
                                <form action="{{ route('soporte.recuperar', [$id, 'Trayecto']) }}"
                                    method="get">
                                    @csrf

                                    <button class="btn btn-success">
                                        <i class="fas fa-trash-restore"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach

                @foreach ($noticias as $nombre => $id)
                    <tr>
                        <td>{{ $nombre }}</td>
                        <td>Noticia</td>
                        <td>
                            <div class="btn-group mx-1" role="group" aria-label="Acciones">
                                <form action="{{ route('soporte.recuperar', [$id, 'Noticia']) }}"
                                    method="get">
                                    @csrf

                                    <button class="btn btn-success">
                                        <i class="fas fa-trash-restore"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach

                @foreach ($preguntas as $nombre => $id)
                    <tr>
                        <td>{{ $nombre }}</td>
                        <td>Preguntas frecuentes</td>
                        <td>
                            <div class="btn-group mx-1" role="group" aria-label="Acciones">
                                <form action="{{ route('soporte.recuperar', [$id, 'Pregunta']) }}"
                                    method="get">
                                    @csrf

                                    <button class="btn btn-success">
                                        <i class="fas fa-trash-restore"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach

                @foreach ($categorias as $nombre => $id)
                    <tr>
                        <td>{{ $nombre }}</td>
                        <td>Categorías</td>
                        <td>
                            <div class="btn-group mx-1" role="group" aria-label="Acciones">
                                <form action="{{ route('soporte.recuperar', [$id, 'Categoria']) }}"
                                    method="get">
                                    @csrf

                                    <button class="btn btn-success">
                                        <i class="fas fa-trash-restore"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach

                @foreach ($materias as $nombre => $id)
                    <tr>
                        <td>{{ $nombre }}</td>
                        <td>Materias</td>
                        <td>
                            <div class="btn-group mx-1" role="group" aria-label="Acciones">
                                <form action="{{ route('soporte.recuperar', [$id, 'Materia']) }}"
                                    method="get">
                                    @csrf

                                    <button class="btn btn-success">
                                        <i class="fas fa-trash-restore"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach

                @foreach ($horarios as $nombre => $id)
                    <tr>
                        <td>{{ $nombre }}</td>
                        <td>Horarios</td>
                        <td>
                            <div class="btn-group mx-1" role="group" aria-label="Acciones">
                                <form action="{{ route('soporte.recuperar', [$id, 'Horario']) }}"
                                    method="get">
                                    @csrf

                                    <button class="btn btn-success">
                                        <i class="fas fa-trash-restore"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/DataTables/datatables.min.css') }}">
@stop

@section('js')
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('/vendor/DataTables/datatables.min.js') }}"></script>

    {{-- Personalizados --}}
    <script src="{{ asset('js/tablas.js') }}"></script>

    {{-- Mensajes --}}
    <script>
        @if ($message = session('recuperado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Elemento recuperado!',
                html: 'Ahora puede volver a ser utilizado.',
                confirmButtonColor: '#28a745',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @endif
    </script>
@stop
