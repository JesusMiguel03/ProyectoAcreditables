<?php

namespace App\Http\Controllers;

use App\Traits\DataTrait;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    use DataTrait;

    public function index()
    {
        return view('auth.welcome-coordinator', ['data' => $this->loadCoursesData()]);
    }
}
