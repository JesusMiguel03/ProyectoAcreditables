<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class LoginUserController extends Controller
{
    public function index()
    {
        return view('account.login');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'cedula' => ['required', 'numeric', 'digits_between:7,8'],
                'password' => ['required', Rules\Password::defaults()],
            ],
            ['password.required' => 'El campo contraseña es necesario']
        );


        $cedula = $request->cedula;
        $password = $request->password;

        if ($cedula === '25976987' && $password = '123123123') {
            return redirect('/admin');
        } else  if ($cedula === '30255192' && $password = '123123123') {
            return redirect('/professor');
        } else {
            return redirect('/');
        }
    }
}
