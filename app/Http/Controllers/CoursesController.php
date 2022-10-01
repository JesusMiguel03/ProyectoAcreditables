<?php

namespace App\Http\Controllers;

use App\Traits\DataTrait;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    use DataTrait;
    
    public function index()
    {
        return view('courses.index', ['courses' => $this->loadCoursesData()]);
    }
    public function show($course)
    {
        return view('courses.show', ['course' => $course, 'courses' => $this->loadCoursesData(), 'professors' => $this->loadProfessorsData(), 'students' => $this->loadStudentsData()]);
    }
}
