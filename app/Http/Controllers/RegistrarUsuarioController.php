<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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

        $regex = "/^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/";

        // Valida los campos
        $validar = Validator::make($request->all(), [
            'nombre' => ['required', 'string', "regex: $regex", 'max:' . config('variables.usuarios.nombre')],
            'apellido' => ['required', 'string', "regex: $regex", 'max:' . config('variables.usuarios.apellido')],
            'nacionalidad' => ['required', 'string'],
            'cedula' => ['required', 'numeric', 'digits_between:' . config('variables.usuarios.cedula')[0] . ',' . config('variables.usuarios.cedula')[1], 'unique:users'],
            'email' => ['required', 'email', 'max:' . config('variables.usuarios.correo'), 'unique:users'],
            'password' => ['required', new Password, 'confirmed'],
        ], [
            'cedula.digits_between' => 'La cedula debe estar entre los ' . config('variables.usuarios.cedula')[0] . ' y ' . config('variables.usuarios.cedula')[1] . ' dígitos.',
            'nombre.regex' => 'El nombre solo debe contener letras.',
            'apellido.regex' => 'El apellido solo debe contener letras.',
        ]);
        validacion($validar, 'mostrarModalUsuario');

        // Guarda al usuario con rol de profesor
        User::create([
            'nombre' => $request->get('nombre'),
            'apellido' => $request->get('apellido'),
            'nacionalidad' => $request->get('nacionalidad'),
            'cedula' => $request->get('cedula'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ])->assignRole($rol);

        return redirect()->back()->with('usuarioRegistrado' . $rol, 'registrar');
    }
}
