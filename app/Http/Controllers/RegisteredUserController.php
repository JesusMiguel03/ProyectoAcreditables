<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    public function index()
    {
        return view('account.register');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'cedula' => ['required', 'numeric', 'digits_between:7,8'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'password_confirmation' => ['required', Rules\Password::defaults()],
            ],
            ['email.required' => 'El campo correo electrónico es necesario'],
            ['password.required' => 'El campo contraseña es necesario'],
            ['password_confirmation.required' => 'El campo confirmar contraseña es necesario']
        );

        return redirect('/login');
    }
}
