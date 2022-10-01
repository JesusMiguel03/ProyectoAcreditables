<?php

namespace App\Http\Controllers;

use App\Traits\DataTrait;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    use DataTrait;

    public function index()
    {
        return view('students.index', ['students' => $this->loadStudentsData(), 'courses' => $this->loadCoursesData()]);
    }
    public function show($orderBy)
    {
        return view('students.show', ['orderBy' => $orderBy, 'students' => $this->loadStudentsData(), 'courses' => $this->loadCoursesData()]);
    }
}
