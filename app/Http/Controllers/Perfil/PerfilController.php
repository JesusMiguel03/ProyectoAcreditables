<?php

namespace App\Http\Controllers\Perfil;

use App\Http\Controllers\Controller;
use App\Models\Academico\PNF;
use App\Models\Academico\Trayecto;
use App\Models\Informacion\Bitacora;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PerfilController extends Controller
{
    public function __construct()
    {
        // Valida la autenticación
        $this->middleware('auth');
        $this->middleware('prevent-back-history');
    }

    public function index()
    {
        // Valida si tiene el permiso.
        permiso('perfil');

        // Busca todos los trayectos y pnf's.
        $trayectos = Trayecto::all();
        $pnfs = PNF::all();

        return view('profile.show', compact('trayectos', 'pnfs'));
    }

    public function avatar(Request $request, $id)
    {
        // Valida si tiene el permiso.
        permiso('perfil');

        // Busca al usuario y le asigna el avatar seleccionado.
        $usuario = User::find($id);
        $avatar = 'avatar' . $request->avatarID;
        $usuario->avatar = $avatar;
        $usuario->save();

        Bitacora::create([
            'usuario' => "{$usuario->nombre} {$usuario->apellido}",
            'accion' => "Actualizó su avatar exitosamente",
            'estado' => 'success',
            'periodo_id' => periodo('modelo')->id ?? null
        ]);

        return redirect()->back()->with('avatar', 'avatar');
    }

    public function informacion(Request $request)
    {
        // Valida si tiene el permiso.
        permiso('perfil');

        $usuario = Auth::user();

        $nacionalidades = [1 => 'V', 2 => 'E', 3 => 'P'];

        $CImin = config('variables.usuarios.cedula')[0];
        $CImax = config('variables.usuarios.cedula')[1];

        $cambios = false;

        $validar = Validator::make($request->all(), [
            'nombre' => ['required', 'string', 'regex: /[A-zÀ-ÿ]+/', 'max:' . config('variables.usuarios.nombre')],
            'apellido' => ['required', 'string', 'regex: /[A-zÀ-ÿ]+/', 'max:' . config('variables.usuarios.apellido')],
            'nacionalidad' => ['required', 'not_in:0'],
            'cedula' => ['required', 'numeric', 'digits_between:' . $CImin . ',' . $CImax, Rule::unique('users')->ignore($usuario->id)],
            'email' => ['required', 'email', 'max:' . config('variables.usuarios.correo'), Rule::unique('users')->ignore($usuario->id)],
        ], [
            'nombre.required' => 'El nombre es necesario.',
            'nombre.string' => 'El nombre debe ser una oración.',
            'nombre.regex' => 'El nombre solo puede contener letras.',
            'nombre.max' => 'El nombre no debe tener más de :max caracteres.',
            'apellido.required' => 'El apellido es necesario.',
            'apellido.string' => 'El apellido debe ser una oración.',
            'apellido.regex' => 'El apellido solo puede contener letras.',
            'apellido.max' => 'El apellido no debe tener más de :max caracteres.',
            'nacionalidad.required' => 'La nacionalidad es necesaria.',
            'nacionalidad.string' => 'La nacionalidad debe ser una oración.',
            'cedula.required' => 'La cédula es necesaria.',
            'cedula.numeric' => 'La cédula debe ser un número.',
            'cedula.unique' => 'La cédula ya se encuentra registrada.',
            'cedula.digits_between' => 'La cedula debe estar entre los ' . $CImin . ' y ' . $CImax . ' dígitos.',
            'email.required' => 'El correo es necesario.',
            'email.email' => 'El correo no es válido.',
            'email.max' => 'El correo no debe tener más de :max caracteres.',
            'email.unique' => 'El correo debe ser único.',
        ]);
        validacion($validar, 'errorActualizarPerfil', 'Actualizar perfil usuario');

        if ($usuario->nombre !== $request['nombre']) {
            $cambios = true;
            $usuario->update(['nombre' => $request['nombre']]);
        }
        if ($usuario->apellido !== $request['apellido']) {
            $cambios = true;
            $usuario->update(['apellido' => $request['apellido']]);
        }
        if ($usuario->nacionalidad !== $request['nacionalidad']) {
            $cambios = true;
            $usuario->update(['nacionalidad' => $nacionalidades[$request['nacionalidad']]]);
        }
        if ($usuario->cedula !== intval($request['cedula'])) {
            $cambios = true;
            $usuario->update(['cedula' => intval($request['cedula'])]);
        }
        if ($usuario->email !== $request['email']) {
            $cambios = true;
            $usuario->update(['email' => $request['email']]);
        }

        if ($cambios) {

            Bitacora::create([
                'usuario' => "{$usuario->nombre} {$usuario->apellido}",
                'accion' => "Actualizó su perfil exitosamente",
                'estado' => 'success',
                'periodo_id' => periodo('modelo')->id ?? null
            ]);

            return redirect()->back()->with('perfilActualizado', 'exitoso');
        }
        return redirect()->back()->with('perfilNoActualizado', 'exitoso');
    }
}
