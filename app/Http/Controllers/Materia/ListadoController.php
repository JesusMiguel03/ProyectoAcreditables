<?php

namespace App\Http\Controllers\Materia;

use App\Http\Controllers\Controller;
use App\Models\Academico\Periodo;
use App\Models\Materia\Materia;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class ListadoController extends Controller
{
    public function __construct()
    {
        // Valida la autenticación
        $this->middleware('auth');
        $this->middleware('prevent-back-history');
    }

    public function show($id)
    {
        // Valida si tiene el permiso
        permiso('registrar.usuario');

        // Lista a todos los estudiantes
        $materia = Materia::find($id);
        $estudiantes = $materia->estudiantes;

        // Carga la vista con el listado
        $pdf = FacadePdf::loadView('academico.pdf.estudiantes', ['materia' => $materia, 'estudiantes' => $estudiantes]);
        return $pdf->stream('Listado de estudiantes.pdf');
    }
}
