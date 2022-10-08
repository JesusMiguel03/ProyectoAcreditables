@section('description', 'Perfil de ' . $profile . ', Coordinación de Acreditables.')
@section('title', $profile . ' - Perfil')

@section('content')
    {{-- Page top --}}
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-8">
                        <h1 class="m-0">Coordinación de Acreditables | {{ $profile }}</h1>
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('perfiles.index') }}">Perfiles</a></li>
                            <li class="breadcrumb-item"><a href="">{{ $profile }}</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Page content --}}
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    @foreach ($data as $index => $professor)
                        @if ($professor['name'] === $profile)
                            <div class="col-sm-12 col-md-3">
                                <div class="card card-primary card-outline">
                                    <div class="card-body box-profile">
                                        <div class="text-center">
                                            <img class="profile-user-img img-fluid img-circle"
                                                src="{{ asset('/dist/img/user' . ($index + 1) . '-128x128.jpg') }}"
                                                alt="User profile picture">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-9">
                                <div class="card card-primary card-outline">
                                    <div class="card-body box-profile">
                                        <h3 class="profile-username">Cursos que imparto</h3>
                                        <a
                                            href="{{ route('cursos.show', $professor['courses']) }}">{{ $professor['courses'] }}</a>
                                    </div>
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
