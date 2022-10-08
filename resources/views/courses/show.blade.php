@section('description', 'Curso de ' . $course . ' , Coordinación de Acreditables.')
@section('title', $course . ' - Curso')

@section('content')
    {{-- Page top --}}
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-8">
                        <h1 class="m-0">Coordinación de Acreditables | {{ $course }}</h1>
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="../cursos">Cursos</a></li>
                            <li class="breadcrumb-item"><a href="">{{ $course }}</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        {{-- Page content --}}
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    @foreach ($professors as $index => $professor)
                        @if ($professor['courses'] === $course)
                        {{-- Course card --}}
                            <div class="col-sm-12 col-md-3">
                                <div class="card card-primary card-outline">
                                    <div class="card-body box-profile">
                                        <div class="text-center">
                                            <img class="profile-user-img img-fluid img-circle"
                                                src="{{ asset('/dist/img/user' . ($index + 1) . '-128x128.jpg') }}"
                                                alt="User profile picture">
                                        </div>
                                        <h3 class="profile-username text-center">{{ $professor['name'] }}</h3>
                                        <p class="text-muted text-center">{{ $professor['title'] }}</p>
                                        <a href="{{ route('perfiles.show', $professor['name']) }}"
                                            class="btn btn-primary d-block">{{ $professor['name'] }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-9">
                                @foreach ($courses as $courseInner)
                                    @if ($courseInner['name'] === $course)
                                        <h2>Cupos disponibles: <span class="text-info">{{ $courseInner['quotes'] }}</span>
                                        </h2>
                                        <p class="p-3 text-justify text-muted">{{ $courseInner['longDescription'] }}</p>
                                    @endif
                                @endforeach
                            </div>
                            {{-- Students table --}}
                            <div class="col-sm-12 col-md-12">
                                <div class="table-responsive-sm">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr class="bg-secondary">
                                                <th scope="col">#</th>
                                                <th scope="col">Nombre y Apellido</th>
                                                <th scope="col">Cédula</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($students as $index => $student)
                                                @if ($student['course'] === $course)
                                                    <tr>
                                                        <th scope="row">{{ $index }}</th>
                                                        <td>{{ $student['name'] }}</td>
                                                        <td>{{ $student['ide'] }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
    </div>
@endsection
<x-layouts.app />
