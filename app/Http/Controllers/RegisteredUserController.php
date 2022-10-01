<?php

namespace App\Http\Controllers;

use App\Traits\DataTrait;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\Http\Request;

class RegisteredUserController extends Controller
{
    use DataTrait;

    public function index()
    {
        return view('account.login', ['data' => $this->loadCoursesData()]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'cedula' => ['required', 'numeric', 'digits_between:7,8'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'cedula' => $request->cedula,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        Auth::Login($user);
    }
}
