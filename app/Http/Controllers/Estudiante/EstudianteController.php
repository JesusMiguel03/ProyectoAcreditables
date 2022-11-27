<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class EstudianteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:preinscribir');
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

    public function comprobante()
    {
        $pdf = FacadePdf::loadView('aside.academico.pdf.pdf');
        return $pdf->download('Comprobante de preinscripcion.pdf');
    }
}
