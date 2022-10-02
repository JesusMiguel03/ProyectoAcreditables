<?php

namespace App\Http\Controllers;

use App\Traits\DataTrait;
// use App\Http
// use App\Models\User;
// use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

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
            'password_confirmation' => ['required', Rules\Password::defaults()],
        ]);

        return redirect()->action([RegisteredUserController::class, 'destroy'], ['cedula' => $request->cedula], ['password' => $request->password]);
    }

    public function destroy(Request $request)
    {
        return view('account.login', ['request' => $request]);
        return redirect()->action([HomeController::class, 'store'], ['cedula' => $request->cedula], ['password' => $request->password]);
    }
}
