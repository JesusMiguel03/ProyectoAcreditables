@section('description', 'Página de preguntas frecuentes, Coordinación de Acreditables.')
@section('title', '¿Sabias que?')
@section('content')
    {{-- Page Top --}}
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Coordinación de Acreditables</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="">Preguntas Frecuentes</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        {{-- Page Content --}}
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    {{-- Welcome Logo --}}
                    <div class="col-sm-12 col-md-3">
                        <div class="card card-secondary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <h4 class="text-secondary">¡Bienvenido!</h4>
                                    <img class="profile-user-img img-fluid img-circle"
                                        src="{{ asset('/assets/dist/img/avatar.png') }}" alt="User profile picture">
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Questions --}}
                    <div class="col-12">
                        <div class="card card-secondary card-outline">
                            <div class="card-body box-profile">
                                <div class="row">
                                    <div class="col-sm-12 col-md-4">
                                        <div class="list-group" id="list-tab" role="tablist">
                                            <a class="list-group-item list-group-item-action active" id="list-home-list"
                                                data-toggle="list" href="#list-home" role="tab"
                                                aria-controls="home">¿Qué son?</a>
                                            <a class="list-group-item list-group-item-action" id="list-how-work-list"
                                                data-toggle="list" href="#list-how-work" role="tab"
                                                aria-controls="how-work">¿Cómo funcionan?</a>
                                            <a class="list-group-item list-group-item-action" id="list-study-list"
                                                data-toggle="list" href="#list-study" role="tab"
                                                aria-controls="study">¿Cómo me afectan?</a>
                                            <a class="list-group-item list-group-item-action" id="list-options-list"
                                                data-toggle="list" href="#list-options" role="tab"
                                                aria-controls="options">¿Cuales son las opciones?</a>
                                            <a class="list-group-item list-group-item-action" id="list-note-list"
                                                data-toggle="list" href="#list-note" role="tab"
                                                aria-controls="note">¿Cómo puedo ver mi nota?</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-8">
                                        <div class="tab-content text-justify" id="nav-tabContent">
                                            <div class="tab-pane fade show active" id="list-home" role="tabpanel"
                                                aria-labelledby="list-home-list">
                                                <span class="font-weight-bold">Acreditable</span> es según el Ministerio
                                                popular para la Educación universitaria como una formación con enfoque
                                                curricular asumido por los diferentes programas nacionales de formación a
                                                ser impartidos en las instituciones de educación universitaria, comprende el
                                                acercamiento de sus participantes a todas las manifestaciones artísticas y
                                                culturales, así como su riqueza.
                                            </div>
                                            <div class="tab-pane fade" id="list-study" role="tabpanel"
                                                aria-labelledby="list-study-list">
                                                Para optar por tu título de TSU debes cursar (2) acreditables en cualquiera
                                                de los
                                                (3) trimestres que componen el año académico y otras (2) acreditables para
                                                culminar
                                                la carrera.
                                            </div>
                                            <div class="tab-pane fade" id="list-options" role="tabpanel"
                                                aria-labelledby="list-options-list">
                                                Las acreditables se aperturan al inicio de cada trimestre y tienen una
                                                duración de
                                                (3) meses. Las opciones varían por trayecto.
                                                <div class="row justify-content-center">
                                                    @foreach ($data as $course)
                                                        <a href="{{ route('cursos.show', $course['name']) }}"
                                                            class="col-sm-12 col-md-3 border border-outline rounded p-2 m-1">{{ $course['name'] }}</a>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="list-how-work" role="tabpanel"
                                                aria-labelledby="list-how-work-list">
                                                Estas se consideran como cualquier otra unidad curricular, pueden ser tanto
                                                prácticas, teóricas o ambas, en base a la metodología que desee emplear el
                                                profesor encargado.
                                            </div>
                                            <div class="tab-pane fade" id="list-note" role="tabpanel"
                                                aria-labelledby="list-note-list">
                                                Para consultar tu nota, accede a la pestaña de <strong><a href="{{ route("cursos.index") }}">Cursos</a></strong> una vez finalizado el trimestre y podrás visualizar tu nota, si tienes algún inconveniente, comunícate con el profesor para solventarlo. Una vez publicadas las notas <strong>tienen 1 semana para corroborarlas</strong>, transcurrida la semana se cargaran oficialmente a DACE <strong>y no podrán ser editadas nuevamente</strong>.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
<x-layouts.app />
