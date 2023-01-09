<?php

namespace App\Http\Controllers\Academico;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Rules\Password;
use Illuminate\Support\Facades\Validator;

class RegistrarEstudianteController extends Controller
{
    public function __construct()
    {
        // Valida la autenticación
        $this->middleware('auth');
        $this->middleware('prevent-back-history');
    }

    public function store(Request $request)
    {
        // Valida si tiene el permiso
        permiso('registrar.usuario');

        // Valida los campos
        $validador = Validator::make($request->all(), [
            'nombre' => ['required', 'string', 'max:' . config('variables.usuarios.nombre')],
            'apellido' => ['required', 'string', 'max:' . config('variables.usuarios.apellido')],
            'cedula' => ['required', 'numeric', 'digits_between:' . config('variables.usuarios.cedula')[0] . ',' . config('variables.usuarios.cedula')[1], 'unique:users'],
            'email' => ['required', 'email', 'max:' . config('variables.usuarios.correo'), 'unique:users'],
            'password' => ['required', new Password, 'confirmed'],
        ], [
            'cedula.digits_between' => 'La cedula debe estar entre los ' . config('variables.usuarios.cedula')[0] . ' y ' . config('variables.usuarios.cedula')[1] . ' dígitos.'
        ]);
        validacion($validador);

        // Guarda al usuario como estudiante
        User::create([
            'nombre' => $request->get('nombre'),
            'apellido' => $request->get('apellido'),
            'cedula' => $request->get('cedula'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ])->assignRole('Estudiante');

        return redirect()->back()->with('creado', 'registrar');
    }
}
