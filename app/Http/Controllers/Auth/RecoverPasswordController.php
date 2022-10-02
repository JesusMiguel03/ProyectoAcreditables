<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;

class RecoverPasswordController extends Controller
{
    public function index()
    {
        return view('account.recover-password');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'password_confirmation' => ['required', Rules\Password::defaults()],
            ],
            ['password.required' => 'El campo contraseña es necesario'],
            ['password_confirmation.required' => 'El campo confirmar contraseña es necesario']
        );

        return redirect('/login');
    }
}
