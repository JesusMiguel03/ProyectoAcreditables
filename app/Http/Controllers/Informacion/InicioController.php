<?php

namespace App\Http\Controllers\Informacion;

use App\Http\Controllers\Controller;
use App\Models\Informacion\Noticia;

class InicioController extends Controller
{
    public function __construct()
    {
        // Valida la autenticación
        $this->middleware('auth');
        $this->middleware('prevent-back-history');
    }

    public function index()
    {
        // Valida si tiene el permiso
        permiso('inicio');

        // Lista todas las noticias
        $noticias = Noticia::where('activo', '=', 1)->get();

        return view('welcome', compact('noticias'));
    }
}
