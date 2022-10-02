<?php

namespace App\Http\Controllers;

use App\Traits\DataTrait;
use Illuminate\Http\Request;

class ProfessorUserController extends Controller
{
    use DataTrait;

    public function index()
    {
        return view('auth.welcome-professor', ['data' => $this->loadCoursesData()]);
    }
}