<?php

namespace App\Http\Controllers;

use App\Models\Academico\Periodo;
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

        $periodos = Periodo::all();
        $bitacoras = Bitacora::all();

        return view('informacion.bitacora.index', compact('bitacoras', 'periodos'));
    }

    public function show($id)
    {
        permiso('soporte');

        $periodoSeleccionado = Periodo::find($id);
        $periodos = Periodo::all();
        $bitacoras = $periodoSeleccionado->bitacoras;

        return view('informacion.bitacora.show', compact('periodoSeleccionado', 'bitacoras', 'periodos'));
    }
}
