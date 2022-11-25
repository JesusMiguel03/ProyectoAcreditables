<?php

namespace App\Http\Controllers\Informacion;

use App\Http\Controllers\Controller;
use App\Models\Informacion\Noticia;
use Illuminate\Http\Request;

class InicioController extends Controller
{
    /*
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $noticias = Noticia::all();
        return view('welcome', compact('noticias'));
    }
}
