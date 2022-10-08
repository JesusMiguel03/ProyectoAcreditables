@section('description', 'Login, Coordinación de Acreditables.')
@section('title', 'Iniciar Sesión')

@section('content')
    <p class="login-box-msg">Inicia sesión para acceder</p>

    <form action="{{ route('login') }}" method="post">
        @csrf
        <div class="input-group">
            <input type="number" class="form-control" placeholder="Cédula" name="cedula"
                value="{{ isset($request->cedula) ? $request->cedula : old('cedula') }}">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
        </div>
        <div class="mb-3">
            @error('cedula')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="input-group">
            <input type="password" class="form-control" placeholder="Contraseña" name="password"
                value="{{ isset($request->cedula) ? $request->password : '' }}">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
        </div>
        <div class="mb-3">
            @error('password')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="row">
            <div class="col-7">
                <div class="icheck-primary">
                    <input type="checkbox" id="remember">
                    <label for="remember">
                        Recuérdame
                    </label>
                </div>
            </div>
            <div class="col-5">
                <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
            </div>
        </div>
    </form>

    <p class="mb-1">
        <a href="{{ route('forgotPassword') }}">Olvidé mi contraseña</a>
    </p>
    <p class="mb-0">
        <a href="{{ route('register') }}" class="text-center">Registrarme</a>
    </p>
    </div>
    </div>
    </div>
@endsection()
<x-account.app />
