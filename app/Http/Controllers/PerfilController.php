<?php

namespace App\Http\Controllers;

use App\Models\DatosAcademicos\Pnf;
use App\Models\DatosAcademicos\Trayecto;
use App\Models\Estudiante;
use App\Models\User;
use Illuminate\Http\Request;

class PerfilController extends Controller
{
    /*
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $trayectos = Trayecto::all();
        $pnfs = Pnf::all();

        return view('profile.show', compact('trayectos', 'pnfs'));
    }
}
