<?php

namespace App\Http\Controllers\Coordinador;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Rules\Password;
use Illuminate\Support\Facades\Validator;

class RegistrarEstudianteController extends Controller
{
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'nombre' => ['required', 'string', 'max:20'],
            'apellido' => ['required', 'string', 'max:20'],
            'cedula' => ['required', 'numeric', 'digits_between:7,8', 'unique:users'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', new Password, 'confirmed'],
        ], [
            'cedula.digits_between' => 'La cedula debe estar entre los 7 y 8 dígitos.'
        ])->validate();

        $estudiante = User::create([
            'nombre' => $request->get('nombre'),
            'apellido' => $request->get('apellido'),
            'cedula' => $request->get('cedula'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ])->assignRole('Estudiante');

        return redirect()->back()->with('registrado', 'exito');
    }
}
