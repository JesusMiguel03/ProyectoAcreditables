<?php

namespace App\Http\Controllers;

use App\Traits\DataTrait;
use Illuminate\Http\Request;

class CoordinatorController extends Controller
{
    use DataTrait;

    public function index()
    {
        return view('auth.welcome-coordinator', ['data' => $this->loadCoursesData()]);
    }
}
