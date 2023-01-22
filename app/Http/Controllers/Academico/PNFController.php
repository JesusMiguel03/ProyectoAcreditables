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

        return view('academico.pnf.index', compact('pnfs'));
    }

    public function store(Request $request)
    {
        // Valida si tiene el permiso
        permiso('academico');

        // Valida los campos
        $validador = Validator::make($request->all(), [
            'nom_pnf' => ['required', 'string', 'max:' . config('variables.pnfs.nombre'), 'unique:pnfs,nom_pnf,' . $request['nom_pnf']],
            'cod_pnf' => ['max:' . config('variables.pnfs.codigo')],
        ], [
            'nom_pnf.required' => 'El nombre es necesario.',
            'nom_pnf.string' => 'El nombre debe ser una oración.',
            'nom_pnf.unique' => 'El PNF ' . $request['nom_pnf'] . ' ya ha sido registrado.',
            'nom_pnf.max' => 'El nombre no puede contener mas de :max caracteres.',
            'cod_pnf.max' => 'El código no puede contener mas de :max caracteres.'
        ]);
        validacion($validador, 'error');

        // Guarda el pnf
        PNF::create([
            'nom_pnf' => $request['nom_pnf'],
            'cod_pnf' => $request['cod_pnf'] === null ? '?' : $request['cod_pnf']
        ]);

        return redirect('pnfs')->with('creado', 'creado');
    }

    public function edit($id)
    {
        // Valida si tiene el permiso
        permiso('academico');

        // Trea el pnf correspondiente
        $pnf = PNF::find($id);

        // Valida que exista
        existe($pnf);

        return view('academico.pnf.edit', compact('pnf'));
    }

    public function update(Request $request, $id)
    {
        // Valida si tiene el permiso
        permiso('academico');

        /**
         * TODO [Cod_pnf] falta validar que sea unico
         */
        // Valida los campos
        $validador = Validator::make($request->all(), [
            'nom_pnf' => ['required', 'string', 'max:' . config('variables.pnfs.nombre'), 'unique:pnfs,nom_pnf,' . $id],
            'cod_pnf' => ['max:' . config('variables.pnfs.codigo')],
        ], [
            'nom_pnf.required' => 'El nombre es necesario.',
            'nom_pnf.string' => 'El nombre debe ser una oración.',
            'nom_pnf.unique' => 'El PNF ' . $request['nom_pnf'] . ' ya ha sido registrado.',
            'nom_pnf.max' => 'El nombre no puede contener mas de :max caracteres.',
            'cod_pnf.max' => 'El código no puede contener mas de :max caracteres.'
        ]);
        validacion($validador, 'error');

        PNF::find($id)->update([
            'nom_pnf' => $request['nom_pnf'],
            'cod_pnf' => $request['cod_pnf'] === null ? null : $request['cod_pnf']
        ]);

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
