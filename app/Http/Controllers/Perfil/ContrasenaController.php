<?php

namespace App\Http\Controllers\Perfil;

use App\Http\Controllers\Controller;
use App\Models\Informacion\Bitacora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ContrasenaController extends Controller
{
    public function __construct()
    {
        // Valida la autenticación
        $this->middleware('auth');
        $this->middleware('prevent-back-history');
    }

    public function update(Request $request)
    {
        // Valida si tiene el permiso
        permiso('inicio');

        // Busca al usuario y los campos de contraseñas
        $usuario = auth()->user();

        $contrasena_actual = $request['current_password'];
        $contrasena = $request['password'];
        $confirmar_contrasena = $request['password_confirmation'];

        // Si no coincide la contraseña actual con la encriptada.
        if (!Hash::check($contrasena_actual, $usuario->password)) {

            Bitacora::create([
                'usuario' => "{$usuario->nombre} {$usuario->apellido}",
                'accion' => 'La contraseña no coincidió con los registros',
                'estado' => 'danger'
            ]);

            return redirect()->back()->with('errorHash', 'error');
        }

        // Si la nueva contraseña y la confirmación no coinciden
        if ($contrasena !== $confirmar_contrasena) {

            Bitacora::create([
                'usuario' => "{$usuario->nombre} {$usuario->apellido}",
                'accion' => 'La nueva contraseña y la confirmación no coincidieron',
                'estado' => 'danger'
            ]);

            return redirect()->back()->with('errorConfirmacion', 'error');
        }

        // Valida que la contrasena en la base de datos y la suministrada sean iguales, e igualmente con la nueva contraseña y la confirmacion.
        if (Hash::check($contrasena_actual, $usuario->password) && $contrasena === $confirmar_contrasena) {

            // Actualiza la contraseña.
            $usuario->forceFill([
                'password' => Hash::make($contrasena),
            ])->save();

            Bitacora::create([
                'usuario' => "{$usuario->nombre} {$usuario->apellido}",
                'accion' => 'Se ha cambiado de contraseña exitosamente',
                'estado' => 'success'
            ]);

            return redirect()->back()->with('actualizado', 'actualizado');
        }
    }
}
