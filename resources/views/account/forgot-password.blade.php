@section('description', 'Olvidé mi contraseña, Coordinación de Acreditables.')
@section('title', 'Olvidé mi contraseña')

@section('content')
    <p class="login-box-msg">¿Olvidaste tu contraseña? Solicita una clave temporal.</p>

    <form action="{{ route('forgotPassword') }}" method="post">
        @csrf
        <div class="input-group">
            <input type="email" class="form-control" placeholder="Correo Electrónico" name="email">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
        </div>
        <div class="mb-3">
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="row">
            <div class="col-12">
                <button type="submit" class="btn btn-primary btn-block">Solicitar clave temporal</button>
            </div>
        </div>
    </form>

    <p class="mt-3 mb-1">
        <a href="{{ route('login') }}">Iniciar Sesión</a>
    </p>
    <p class="mb-0">
        <a href="{{ route('register') }}" class="text-center">Registrarme</a>
    </p>
    </div>
    </div>
    </div>
@endsection()
<x-account.app />
