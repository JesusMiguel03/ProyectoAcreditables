@section('description', 'Recuperar contraseña, Coordinación de Acreditables.')
@section('title', 'Recuperar Contraseña')

@section('content')
    <p class="login-box-msg">Estás a un paso de cambiar tu contraseña.</p>

    <form action="{{ route('recoverPassword') }}" method="post">
        @csrf
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
            <div class="col-12">
                <button type="submit" class="btn btn-primary btn-block">Cambiar Contraseña</button>
            </div>
            <!-- /.col -->
        </div>
    </form>

    <p class="mt-3 mb-1">
        <a href="{{ route('login') }}">Iniciar Sesión</a>
    </p>
    </div>
    <!-- /.login-card-body -->
    </div>
    </div>
    <!-- /.login-box -->
@endsection()
<x-account.app />
