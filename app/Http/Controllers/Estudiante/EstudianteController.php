<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Models\Academico\Periodo;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class EstudianteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Estudiante::updateOrCreate(
            ['usuario_id' => $request->get('usuario')],
            [
                'trayecto_id' => $request->get('trayecto'),
                'pnf_id' => $request->get('pnf')
            ]
        );

        return redirect('perfil')->with('registrado', 'Curso creado exitosamente');
    }

    public function comprobante($id)
    {
        $periodo = Periodo::orderBy('inicio', 'desc')->first();

        // Busca al estudiante y carga sus datos
        $estudiante = Estudiante::find($id);
        $pdf = FacadePdf::loadView('aside.academico.pdf.pdf', ['estudiante' => $estudiante, 'periodo' => $periodo]);

        // El profesor no puede ver el comprobante (?)
        if (auth()->user()->getRoleNames()[0] === 'Profesor') {
            return redirect()->back();
        }

        // En caso de que el coordinador desee revisar el comprobante
        if (auth()->user()->getRoleNames()[0] === 'Coordinador') {
            return $pdf->stream('Comprobante de inscripción.pdf');
        }

        // Flujo normal, al estudiante se le descarga directamente el pdf
        return $pdf->download('Comprobante de inscripcion.pdf');
    }
}
