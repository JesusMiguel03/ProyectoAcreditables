@section('description', 'Página de estudiantes , Coordinación de Acreditables.')
@section('title', 'Listado de estudiantes | ' . $orderBy)

@section('content')
    {{-- Page top --}}
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-7">
                        <h1 class="m-0">Coordinación de Acreditables | Estudiantes de <span class="font-weight-bold">{{ $orderBy }}</span></h1>
                    </div>
                    <div class="col-sm-5">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('estudiantes.index') }}">Listado de
                                    estudiantes</a></li>
                            <li class="breadcrumb-item"><a href="">{{ $orderBy }}</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Page content --}}
        <section class="content">
            <div class="container-fluid">
                <div class="btn-group dropright my-2">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                        aria-expanded="false">
                        Mostrar Por
                    </button>
                    <div class="dropdown-menu px-2">
                        @foreach ($courses as $course)
                            <a href="{{ route('estudiantes.show', $course['name']) }}" class="btn btn-primary d-block my-2">
                                {{ $course['name'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
                <a href="{{ route('estudiantes.index') }}" class="btn btn-primary my-2">
                    Mostrar todo
                </a>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="table-responsive-sm">
                            <table class="table table-striped">
                                <thead>
                                    <tr class="bg-secondary">
                                        <th scope="col">#</th>
                                        <th scope="col">Nombre y Apellido</th>
                                        <th scope="col">Cédula</th>
                                        <th scope="col">Curso</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $index => $student)
                                        @if ($student['course'] === $orderBy)
                                            <tr>
                                                <th scope="row">{{ $index }}</th>
                                                <td>{{ $student['name'] }}</td>
                                                <td>{{ $student['ide'] }}</td>
                                                <td>{{ $student['course'] }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
<x-layouts.app />
