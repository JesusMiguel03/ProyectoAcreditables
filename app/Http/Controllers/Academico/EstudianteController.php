<?php

namespace App\Http\Controllers\Academico;

use App\Http\Controllers\Controller;
use App\Models\Academico\Estudiante;
use App\Models\Academico\Estudiante_materia;
use App\Models\Academico\Periodo;
use App\Models\Academico\Pnf;
use App\Models\Materia\Materia;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class EstudianteController extends Controller
{
    public function __construct()
    {
        // Valida la autenticación
        $this->middleware('auth');
        $this->middleware('prevent-back-history');
    }

    public function store(Request $request)
    {
        // Valida si tiene el permiso
        permiso('estudiante');

        /**
         *  ! REVISAR
         */

        $pnfTrayectos = Pnf::find($request['pnf'])->trayectos;
        $pnfNombre = Pnf::find($request['pnf'])->nom_pnf;

        if ($request['trayecto'] > Pnf::find($request['pnf'])->trayectos) {
            return redirect()->back()->with('pnfLimite', "El PNF {$pnfNombre} cursa hasta trayecto {$pnfTrayectos}");
        }

        Estudiante::updateOrCreate(
            ['usuario_id' => $request['usuario']],
            [
                'trayecto_id' => $request['trayecto'],
                'pnf_id' => $request['pnf']
            ]
        );

        return redirect('perfil')->with('registrado', 'registrado');
    }

    public function comprobante($id)
    {
        // Busca al estudiante y carga sus datos
        $estudiante = Estudiante_materia::where('estudiante_id', '=', $id)->first();

        // Si el estudiante no tiene comprobante, redirecciona
        if (empty($estudiante)) {
            return redirect()->back();
        }

        if (empty($estudiante->materia->profesorEncargado())) {
            return redirect()->back();
        }

        if (rol('Estudiante') && auth()->user()->estudiante->id !== $estudiante->estudiante_id) {
            return redirect()->back();
        }

        $inicio = \Carbon\Carbon::parse($estudiante->created_at)->startOfDay();
        $fin = \Carbon\Carbon::parse($estudiante->created_at)->endOfDay();

        $periodo = Periodo::whereBetween('created_at', [$inicio, $fin])->first();

        $materia = Materia::find($estudiante->materia_id);
        $pdf = FacadePdf::loadView('academico.pdf.comprobante', ['estudiante' => $estudiante, 'materia' => $materia, 'periodo' => $periodo]);

        // En caso de que el coordinador desee revisar el comprobante
        if (rol('Coordinador')) {
            return $pdf->stream('Comprobante de inscripción.pdf');
        }

        // Si es profesor no puede ver el comprobante
        if (rol('Profesor')) {
            return redirect()->back();
        }

        // Flujo normal, al estudiante se le descarga directamente el pdf
        return $pdf->download('Comprobante de inscripcion.pdf');
    }
}
