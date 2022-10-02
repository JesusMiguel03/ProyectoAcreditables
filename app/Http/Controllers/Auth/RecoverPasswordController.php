<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LoginUserController;
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
        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'password_confirmation' => ['required', Rules\Password::defaults()],
        ]);

        return redirect('/login');
    }
}
