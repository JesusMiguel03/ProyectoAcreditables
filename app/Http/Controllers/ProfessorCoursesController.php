<?php

namespace App\Http\Controllers;

use App\Traits\DataTrait;
use Illuminate\Http\Request;

class ProfessorCoursesController extends Controller
{
    use DataTrait;
    
    public function index()
    {
        return view('professor.courses.index', ['courses' => $this->loadCoursesData()]);
    }
    public function show($course)
    {
        return view('professor.courses.show', ['course' => $course, 'courses' => $this->loadCoursesData(), 'professors' => $this->loadProfessorsData(), 'students' => $this->loadStudentsData()]);
    }
}
