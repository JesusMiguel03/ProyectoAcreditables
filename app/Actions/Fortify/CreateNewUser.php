<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Rules\Password;
class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        $validar = Validator::make($input, [
            'nombre' => ['required', 'string', 'regex: /[A-zÀ-ÿ]+/', 'max:' . config('variables.usuarios.nombre')],
            'apellido' => ['required', 'string', 'regex: /[A-zÀ-ÿ]+/', 'max:' . config('variables.usuarios.apellido')],
            'nacionalidad' => ['required', 'string'],
            'cedula' => ['required', 'numeric', 'digits_between:' . config('variables.usuarios.cedula')[0] . ',' . config('variables.usuarios.cedula')[1], 'unique:users'],
            'email' => ['required', 'email', 'max:' . config('variables.usuarios.correo'), 'unique:users'],
            'password' => ['required', new Password, 'max: 8', 'confirmed'],
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
            'password.max' => 'La contraseña no debe tener más de :max caracteres.',
            'password.required' => 'La contraseña es necesaria.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
        ]);
        validacion($validar, 'usuarioInvalido', 'Registrar usuario');

        return User::create([
            'nombre' => $input['nombre'],
            'apellido' => $input['apellido'],
            'nacionalidad' => $input['nacionalidad'],
            'cedula' => $input['cedula'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ])->assignRole('Estudiante');
    }
}
