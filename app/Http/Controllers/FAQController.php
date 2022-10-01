<?php

namespace App\Http\Controllers;

use App\Traits\DataTrait;
use Illuminate\Http\Request;

class FAQController extends Controller
{
    use DataTrait;

    public function index()
    {
        return view('faq', ['data' => $this->loadCoursesData()]);
    }
}
