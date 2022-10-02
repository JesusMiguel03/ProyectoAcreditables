<?php

namespace App\Http\Controllers;

use App\Traits\DataTrait;
use Illuminate\Http\Request;

class CoordinatorCoursesController extends Controller
{
    use DataTrait;
    
    public function index()
    {
        return view('coordinator.coursesAdmin.index', ['courses' => $this->loadCoursesData()]);
    }
    public function show($course)
    {
        return view('coordinator.coursesAdmin.show', ['course' => $course, 'courses' => $this->loadCoursesData(), 'professors' => $this->loadProfessorsData(), 'students' => $this->loadStudentsData()]);
    }
}
