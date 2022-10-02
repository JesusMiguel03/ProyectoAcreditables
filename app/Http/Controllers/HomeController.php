<?php

namespace App\Http\Controllers;

use App\Traits\DataTrait;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use DataTrait;

    public function index()
    {
        return view('welcome', ['data' => $this->loadCoursesData()]);
    }

    public function store()
    {
        return view('welcome', ['data' => $this->loadCoursesData()]);
    }
}
