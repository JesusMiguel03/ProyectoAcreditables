<?php

namespace App\Http\Controllers\Materia;

use App\Http\Controllers\Controller;
use App\Models\Academico\Periodo;
use App\Models\Materia\Materia;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class ListadoController extends Controller
{
    public function show($id)
    {
        // Lista a todos los estudiantes
        $periodo = Periodo::orderBy('inicio', 'desc')->first();
        $estudiantes = Materia::find($id)->estudiantes;

        // Busca el último periodo
        $periodo = Periodo::orderBy('inicio', 'desc')->first();

        // Carga la vista con el listado
        $pdf = FacadePdf::loadView('aside.academico.pdf.estudiantes', ['estudiantes' => $estudiantes, 'periodo' => $periodo]);
        return $pdf->stream('Listado de estudiantes.pdf');
    }
}
