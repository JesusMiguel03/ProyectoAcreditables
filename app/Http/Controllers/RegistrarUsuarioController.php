<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Informacion\Bitacora;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Rules\Password;
use Illuminate\Support\Facades\Validator;

class RegistrarUsuarioController extends Controller
{
    public function __construct()
    {
        // Valida la autenticación
        $this->middleware('auth');
        $this->middleware('prevent-back-history');
    }

    public function store(Request $request, $rol)
    {
        // Valida si tiene el permiso
        permiso('registrar.usuario');

        // Valida los campos
        $validar = Validator::make($request->all(), [
            'nombre' => ['required', 'string', 'regex: [A-zÀ-ÿ]+', 'max:' . config('variables.usuarios.nombre')],
            'apellido' => ['required', 'string', 'regex: [A-zÀ-ÿ]+', 'max:' . config('variables.usuarios.apellido')],
            'nacionalidad' => ['required', 'string'],
            'cedula' => ['required', 'numeric', 'digits_between:' . config('variables.usuarios.cedula')[0] . ',' . config('variables.usuarios.cedula')[1], 'unique:users'],
            'email' => ['required', 'email', 'max:' . config('variables.usuarios.correo'), 'unique:users'],
            'password' => ['required', new Password, 'confirmed'],
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
            'cedula.unique' => 'La cédula debe ser única.',
            'cedula.digits_between' => 'La cedula debe estar entre los ' . config('variables.usuarios.cedula')[0] . ' y ' . config('variables.usuarios.cedula')[1] . ' dígitos.',
            'email.required' => 'El correo es necesario.',
            'email.email' => 'El correo no es válido.',
            'email.max' => 'El correo no debe tener más de :max caracteres.',
            'email.unique' => 'El correo debe ser único.',
            'password.required' => 'La contraseña es necesaria.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
        ]);
        validacion($validar, 'mostrarModalUsuario', 'Registrar usuario');

        // Guarda al usuario con rol de profesor
        User::create([
            'nombre' => $request->get('nombre'),
            'apellido' => $request->get('apellido'),
            'nacionalidad' => $request->get('nacionalidad'),
            'cedula' => $request->get('cedula'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ])->assignRole($rol);

        Bitacora::create([
            'usuario' => "Usuario - ({$request['nombre']} {$request['apellido']}) {$rol}",
            'accion' => 'Se ha registrado exitosamente',
            'estado' => 'success'
        ]);

        return redirect()->back()->with('usuarioRegistrado' . $rol, 'registrar');
    }
}
