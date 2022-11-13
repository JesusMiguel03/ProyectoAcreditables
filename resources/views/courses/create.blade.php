@extends('adminlte::page')

@section('title', 'Acreditables | Cursos')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Coordinación de Acreditables</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item active"><a href="">Crear curso</a></li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    {{-- Page content --}}
    <section class="content">
        <div class="container-fluid">
            <div class="card col-6 mx-auto p-4">
                <h2 class="card-header">Nuevo curso</h2>

                <div class="card-body">
                    <form action="{{ url('/Cursos')}}" method="post" enctype="multipart/form-data">
                        @csrf

                        {{-- Name field --}}
                        <div class="input-group mb-3">
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" placeholder="{{ __('Nombre del curso') }}" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Professor field --}}
                        {{-- <div class="input-group mb-3">
                            <div class="col-md-12 p-0">
                                <input type="text" name="professor"
                                    class="form-control @error('professor') is-invalid @enderror"
                                    value="{{ old('professor') }}" placeholder="{{ __('Profesor encargado') }}" autofocus>

                                <small id="professorHelp" class="form-text text-muted">Si no hay profesor disponible colocar
                                    "Sin asignar".</small>
                            </div>

                            @error('professor')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div> --}}

                        {{-- Quotas field --}}
                        <div class="input-group mb-3">
                            {{-- <div class="col-md-12 p-0"> --}}
                                <input type="number" name="quotas"
                                    class="form-control @error('quotas') is-invalid @enderror" id="quotas"
                                    value="{{ old('quotas') }}" placeholder="{{ __('Cupos disponibles, límite: '.$limit) }}" autofocus>
                                {{-- <small id="quotasHelp" class="form-text text-muted">Los cupos no deben superar los
                                    {{ $limit }}.</small> --}}

                                @error('quotas')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            {{-- </div> --}}
                        </div>

                        {{-- Description field --}}
                        <div class="input-group mb-3">
                            <input type="text" name="description"
                                class="form-control @error('description') is-invalid @enderror"
                                value="{{ old('description') }}" placeholder="{{ __('Descripción') }}" autofocus>

                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Image field --}}
                        <div class="input-group mb-3">
                            <input type="file" class="custom-file-input @error('image') is-invalid @enderror"
                                id="image" name="image" accept="image/jpeg">
                            <label class="custom-file-label text-muted" for="image" id="imageLabel">Escoge una
                                imagen</label>
                            <small id="imageHelp" class="form-text text-muted">La imagen debe pesar menos de 1
                                MB.</small>

                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Image preview --}}
                        <div class="card" style="max-width: 540px">
                            <img src="" alt="" id="preview" class="rounded">
                        </div>

                        {{-- Login field --}}
                        <div class="row">
                            <div class="col-6">
                                <a href="{{ route('Cursos.index') }}" class="btn btn-block btn-secondary">
                                    {{ __('Volver') }}
                                </a>
                            </div>
                            <div class="col-6">
                                <button type=submit class="btn btn-block btn-primary">
                                    {{ __('Crear curso') }}
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
@stop

@section('footer')

@section('css')
    <style>
        .custom-file-label::after {
            content: "Buscar";
        }
    </style>
@stop

@section('js')
    <script>
        document.querySelectorAll('p').forEach(item => {
            item.innerText === 'Cursos' ?
                item.parentNode.classList.add('active') : ""
        })
    </script>
    <script>
        const file = document.getElementById('image')
        const preview = document.getElementById('preview')
        const imageLabel = document.getElementById('imageLabel')

        file.addEventListener('change', e => {
            if (e.target.files.length === 1) {
                const reader = new FileReader()
                const files = e.target.files[0]
                reader.readAsDataURL(files)
                reader.onload = function() {
                    temp = reader.result
                }
                preview.src = URL.createObjectURL(files)
                imageLabel.innerHTML = e.target.files[0].name
            } else {
                preview.src = ""
                imageLabel.innerHTML = ""
            }
        })
    </script>
@stop
