<?php

namespace App\Http\Controllers;

use App\Traits\DataTrait;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use DataTrait;

    public function index()
    {
        return view('account.login', ['data' => $this->loadUsersData()]);
    }
    public function create()
    {
        return view('account.register', ['data' => $this->loadUsersData()]);
    }
    public function edit()
    {
        return view('account.forgot-password', ['data' => $this->loadUsersData()]);
    }
    public function update()
    {
        return view('account.recover-password', ['data' => $this->loadUsersData()]);
    }
}
