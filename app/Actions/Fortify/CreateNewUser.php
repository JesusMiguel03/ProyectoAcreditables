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
            'nombre' => ['required', 'string', 'max:20'],
            'apellido' => ['required', 'string', 'max:20'],
            'cedula' => ['required', 'numeric', 'digits_between:7,8', 'unique:users'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
        ], [
            'cedula.digits_between' => 'La cedula debe estar entre los 7 y 8 dígitos.'
        ])->validate();

        return $usuario = User::create([
            'nombre' => $input['nombre'],
            'apellido' => $input['apellido'],
            'cedula' => $input['cedula'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ])->assignRole('Estudiante');
    }
}
