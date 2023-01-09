<?php

namespace App\Http\Controllers\Academico;

use App\Models\Academico\PNF;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PNFController extends Controller
{
    public function __construct()
    {
        // Valida la autenticación
        $this->middleware('auth');
        $this->middleware('prevent-back-history');
    }

    public function index()
    {
        // Valida si tiene el permiso
        permiso('academico');

        // Lista todos los pnf
        $pnfs = PNF::all();
        $periodo = periodoActual();

        return view('academico.pnf.index', compact('pnfs', 'periodo'));
    }

    public function store(Request $request)
    {
        // Valida si tiene el permiso
        permiso('academico');

        // Valida los campos
        $validador = Validator::make($request->all(), [
            'nom_pnf' => ['required', 'string', 'max:' . config('variables.pnfs.nombre')],
            'cod_pnf' => ['max:' . config('variables.pnfs.codigo')],
        ], [
            'nom_pnf.required' => 'El campo nombre es necesario.',
            'nom_pnf.string' => 'El campo nombre debe ser una oración.',
            'nom_pnf.max' => 'El campo nombre no puede contener mas de :max carácteres.',
            'cod_pnf.max' => 'El campo código no puede contener mas de :max carácteres.'
        ]);
        validacion($validador);

        // Evita duplicidad
        duplicado(
            PNF::where('nom_pnf', '=', $request->get('nom_pnf'))
        );

        // Guarda el pnf
        PNF::create([
            'nom_pnf' => $request->get('nom_pnf'),
            'cod_pnf' => $request->get('cod_pnf') === null ? '?' : $request->get('cod_pnf')
        ]);

        return redirect('pnfs')->with('creado', 'creado');
    }

    public function edit($id)
    {
        // Valida si tiene el permiso
        permiso('academico');

        // Trea el pnf correspondiente
        $pnf = PNF::find($id);
        $periodo = periodoActual();

        // Valida que exista
        existe($pnf);

        return view('academico.pnf.edit', compact('pnf', 'periodo'));
    }

    public function update(Request $request, $id)
    {
        // Valida si tiene el permiso
        permiso('academico');
        
        // Valida los campos
        $validador = Validator::make($request->all(), [
            'nom_pnf' => ['required', 'string', 'max:' . config('variables.pnfs.nombre')],
            'cod_pnf' => ['max:' . config('variables.pnfs.codigo')],
        ], [
            'nom_pnf.required' => 'El campo nombre es necesario.',
            'nom_pnf.string' => 'El campo nombre debe ser una oración.',
            'nom_pnf.max' => 'El campo nombre no puede contener mas de :max carácteres.',
            'cod_pnf.max' => 'El campo código no puede contener mas de :max carácteres.'
        ]);
        validacion($validador);

        // Evita duplicidad
        duplicado(
            PNF::where('nom_pnf', '=', $request->get('nom_pnf'))
        );

        // Busca y actualiza
        PNF::updateOrCreate(
            ['id' => $id],
            [
                'nom_pnf' => $request->get('nom_pnf'), 
                'cod_pnf' => $request->get('cod_pnf') === null ? null : $request->get('cod_pnf')
            ]
        );

        return redirect('pnfs')->with('actualizado', 'actualizado');
    }

    public function delete($id)
    {
        // Valida si tiene el permiso
        permiso('academico');

        PNF::find($id)->delete();
        return redirect()->back()->with('borrado', 'borrado');
    }
}
