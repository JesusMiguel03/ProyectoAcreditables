<?php

namespace App\Http\Controllers\Academico;

use App\Http\Controllers\Controller;
use App\Models\Academico\Estudiante;
use App\Models\Academico\Estudiante_materia;
use App\Models\Academico\Periodo;
use App\Models\Academico\Pnf;
use App\Models\Informacion\Bitacora;
use App\Models\Materia\Materia;
use Illuminate\Http\Request;
use Carbon\Carbon;
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

        $estudiante = Estudiante::find($request['usuario']);

        Bitacora::create([
            'usuario' => "Perfil académico - ({$estudiante->nombreEstudiante()})",
            'accion' => 'Se ha registrado exitosamente',
            'estado' => 'success'
        ]);

        return redirect('perfil')->with('registrado', 'registrado');
    }

    public function comprobante($id)
    {
        // Si es profesor no puede ver el comprobante
        if (rol('Profesor')) return redirect()->back();

        // Busca al estudiante y carga sus datos
        $estudiante = Estudiante_materia::find($id);

        // Si el estudiante no tiene comprobante, redirecciona.
        if (empty($estudiante)) return redirect()->back();

        // Si el estudiante intenta acceder al comprobante de otro.
        if (rol('Estudiante') && auth()->user()->estudiante->id !== $estudiante->estudiante_id) return redirect()->back();

        $inicio = Carbon::parse($estudiante->created_at)->format('Y-m-d');

        // Busca el periodo que dentro de su rango (fecha inicio y fin) se encuentre la fecha de inscripcion del estudiante.
        $periodo = Periodo::whereRaw('? between inicio and fin', $inicio)->first();

        $materia = Materia::find($estudiante->materia_id);
        $pdf = FacadePdf::loadView('academico.pdf.comprobante', ['estudiante' => $estudiante, 'materia' => $materia, 'periodo' => $periodo]);

        // En caso de que el coordinador desee revisar el comprobante
        if (rol('Coordinador')) return $pdf->stream('Comprobante de inscripción.pdf');

        // Flujo normal, al estudiante se le descarga directamente el pdf
        return $pdf->download('Comprobante de inscripcion.pdf');
    }
}
