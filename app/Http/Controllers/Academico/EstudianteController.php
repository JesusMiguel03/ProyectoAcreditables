<?php

namespace App\Http\Controllers\Academico;

use App\Http\Controllers\Controller;
use App\Models\Academico\Estudiante;
use App\Models\Academico\Estudiante_materia;
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

        Estudiante::updateOrCreate(
            ['usuario_id' => $request['usuario']],
            [
                'trayecto_id' => $request['trayecto'],
                'pnf_id' => $request['pnf']
            ]
        );

        return redirect('perfil')->with('registrado', 'Curso creado exitosamente');
    }

    public function comprobante($id)
    {
        // Busca al estudiante y carga sus datos
        $estudiante = Estudiante_materia::where('estudiante_id', '=', $id)->first();
        
        // Si el estudiante no tiene comprobante, redirecciona
        if (empty($estudiante)) {
            return redirect()->back();
        }
        
        if (rol('Estudiante') && auth()->user()->estudiante->id !== $estudiante->estudiante_id) {
        // if (empty(auth()->user()->estudiante) || auth()->user()->estudiante->id !== $estudiante->estudiante_id) {
            return redirect()->back();
        }

        $materia = Materia::find($estudiante->materia_id);
        $pdf = FacadePdf::loadView('academico.pdf.comprobante', ['estudiante' => $estudiante, 'materia' => $materia]);
        
        // Si es profesor no puede ver el comprobante
        if (rol('Profesor')) {
            return redirect()->back();
        }
        
        // En caso de que el coordinador desee revisar el comprobante
        if (rol('Coordinador')) {
            return $pdf->stream('Comprobante de inscripción.pdf');
        }
        
        // Flujo normal, al estudiante se le descarga directamente el pdf
        return $pdf->download('Comprobante de inscripcion.pdf');
    }
}
