@section('description', 'Registro, Coordinación de Acreditables.')
@section('title', 'Registrar Usuario')

@section('content')
    <p class="login-box-msg">Registrarse como nuevo usuario</p>

    <form action="{{ route('register') }}" method="post">
        @csrf
        <div class="input-group">
            <input type="number" class="form-control" placeholder="Cédula" name="cedula" value="{{ old('cedula') }}">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-user"></span>
                </div>
            </div>
        </div>
        <div class="mb-3">
            @error('cedula')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="input-group">
            <input type="email" class="form-control" placeholder="Correo Electrónico" name="email"
                value="{{ old('email') }}">
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
        <div class="input-group">
            <input type="password" class="form-control" placeholder="Contraseña" name="password">
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
        <div class="input-group">
            <input type="password" class="form-control" placeholder="Confirmar Contraseña" name="password_confirmation">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
        </div>
        <div class="mb-3">
            @error('password_confirmation')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="row">
            <div class="col-7">
                <div class="icheck-primary">
                    <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                    <label for="agreeTerms">
                        Acepto los <a href="#">términos y condiciones</a>
                    </label>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-5">
                <button type="submit" class="btn btn-primary btn-block">Registrarme</button>
            </div>
            <!-- /.col -->
        </div>
    </form>

    <a href="{{ route('login') }}" class="text-center">Ya estoy registrado</a>
    </div>
    <!-- /.form-box -->
    </div><!-- /.card -->
    </div>
    <!-- /.register-box -->
@endsection()
<x-account.app />
