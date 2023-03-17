<?php

namespace App\Http\Controllers;

use App\Models\Informacion\Bitacora;
use Illuminate\Http\Request;

class BitacoraController extends Controller
{
    public function __construct()
    {
        // Valida la autenticación.
        $this->middleware('auth');
        $this->middleware('prevent-back-history');
    }

    public function index()
    {
        permiso('soporte');
        
        $bitacoras = Bitacora::all();
        return view('informacion.bitacora.index', compact('bitacoras'));
    }
}
