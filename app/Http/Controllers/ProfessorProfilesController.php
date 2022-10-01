<?php

namespace App\Http\Controllers;

use App\Traits\DataTrait;
use Illuminate\Http\Request;

class ProfessorProfilesController extends Controller
{
    use DataTrait;
    public function index()
    {
        return view('profiles.index', ['professors' => $this->loadProfessorsData()]);
    }
    public function show($profile)
    {
        return view('profiles.show', ['profile' => $profile, 'data' => $this->loadProfessorsData()]);
    }
}