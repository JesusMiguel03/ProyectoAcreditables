<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

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
        Validator::make($input, [
            'nombre' => ['required', 'string', 'max:' . config('variables.usuarios.nombre')],
            'apellido' => ['required', 'string', 'max:' . config('variables.usuarios.apellido')],
            'nacionalidad' => ['required', 'string'],
            'cedula' => ['required', 'numeric', 'digits_between:' . config('variables.usuarios.cedula')[0] . ',' . config('variables.usuarios.cedula')[1] , 'unique:users'],
            'email' => ['required', 'email', 'max:' . config('variables.usuarios.correo'), 'unique:users'],
            'password' => $this->passwordRules(),
        ], [
            'cedula.digits_between' => 'La cedula debe estar entre los ' . config('variables.usuarios.cedula')[0] . ' y ' . config('variables.usuarios.cedula')[1] . 'dígitos.'
        ])->validate();

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
