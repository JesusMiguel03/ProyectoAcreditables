<?php

namespace App\Http\Controllers\Materia;

use App\Http\Controllers\Controller;
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
        permiso('listado.estudiantes');

        // Lista a todos los estudiantes
        $materia = Materia::find($id);
        $estudiantes = $materia->estudiantesPeriodoActual();

        // Carga la vista con el listado
        $pdf = FacadePdf::loadView('academico.pdf.estudiantes', ['materia' => $materia, 'estudiantes' => $estudiantes]);

        // Pie de página
        $canvas = $pdf->getCanvas();
        $x = $canvas->get_width() / 6;
        $y = $canvas->get_height() - 35;

        $canvas->page_text($x, $y, "Av. Universidad (al lado del Comando FAN-peaje) y Av. Ricaurte, Urb. Industrial SOCIO (frente MAVIPLANCA).", 'times-roman', 8, array(0, 0, 0));

        $canvas->page_text($x + 20, $y + 10, "Telefax (0244) 3217054 / 3222822 / 3211478. Apartado 109. Código Postal 2121 Rif: G-20009565-2", 'times-roman', 8, array(0, 0, 0));
        
        return $pdf->stream('Listado de estudiantes.pdf');
    }
}
