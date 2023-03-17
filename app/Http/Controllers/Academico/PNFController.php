<?php

namespace App\Http\Controllers\Academico;

use App\Models\Academico\PNF;
use App\Http\Controllers\Controller;
use App\Models\Informacion\Bitacora;
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

        $pnfBorrado = PNF::withTrashed()->where('nom_pnf', '=', $request['nom_pnf'])->first() ?? null;

        if ($pnfBorrado) {
            return redirect()->back()->with('elementoBorrado', 'El PNF que intenta registrar se encuentra como elemento borrado, si lo requiere proceda a recuperarlo');
        }

        // Valida los campos
        $validador = Validator::make($request->all(), [
            'nom_pnf' => ['required', 'string', 'regex: ' . config('variables.regex.alfaespacio'), 'max:' . config('variables.pnfs.nombre'), 'unique:pnfs,nom_pnf,' . $request['nom_pnf']],
            'cod_pnf' => ['sometimes', 'nullable', 'regex: ' . config('variables.regex.alfanumerico'), 'max:' . config('variables.pnfs.codigo'), 'unique:pnfs,cod_pnf,' . $request['cod_pnf']],
            'trayectos' => ['required', 'integer'],
        ], [
            'nom_pnf.required' => 'El nombre es necesario.',
            'nom_pnf.string' => 'El nombre debe ser una oración.',
            'nom_pnf.unique' => 'El PNF (' . $request['nom_pnf'] . ') ya ha sido registrado.',
            'nom_pnf.max' => 'El nombre no puede contener mas de :max caracteres.',
            'nom_pnf.regex' => 'El nombre solo puede contener letras.',
            'cod_pnf.max' => 'El código no puede contener mas de :max caracteres.',
            'cod_pnf.regex' => 'El código solo puede contener números y letras.',
            'cod_pnf.unique' => 'El código ' . $request['cod_pnf'] . ' ya ha sido registrado.',
            'trayectos.required' => 'La cantidad de veces que ve acreditables es necesaria.',
            'trayectos.integer' => 'La cantidad de veces que ve acreditables debe ser un número.'
        ]);
        validacion($validador, 'error', 'PNF');

        // Guarda el pnf
        PNF::create([
            'nom_pnf' => $request['nom_pnf'],
            'cod_pnf' => $request['cod_pnf'] === null ? null : $request['cod_pnf'],
            'trayectos' => $request['trayectos']
        ]);

        Bitacora::create([
            'usuario' => "PNF - ({$request['nom_pnf']})",
            'accion' => 'Se ha registrado exitosamente',
            'estado' => 'success'
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

        // Valida los campos
        $validador = Validator::make($request->all(), [
            'nom_pnf' => ['required', 'string', 'regex: ' . config('variables.regex.alfaespacio'), 'max:' . config('variables.pnfs.nombre'), 'unique:pnfs,nom_pnf,' . $id],
            'cod_pnf' => ['sometimes', 'nullable', 'regex: ' . config('variables.regex.alfanumerico'), 'max:' . config('variables.pnfs.codigo'), 'unique:pnfs,cod_pnf,' . $request['cod_pnf']],
            'trayectos' => ['required', 'integer'],
        ], [
            'nom_pnf.required' => 'El nombre es necesario.',
            'nom_pnf.string' => 'El nombre debe ser una oración.',
            'nom_pnf.unique' => 'El PNF ' . $request['nom_pnf'] . ' ya ha sido registrado.',
            'nom_pnf.max' => 'El nombre no puede contener mas de :max caracteres.',
            'cod_pnf.max' => 'El código no puede contener mas de :max caracteres.',
            'cod_pnf.regex' => 'El código solo puede contener números y letras.',
            'cod_pnf.unique' => 'El código ' . $request['cod_pnf'] . ' ya ha sido registrado.',
            'trayectos.required' => 'La cantidad de veces que ve acreditables es necesaria.',
            'trayectos.integer' => 'La cantidad de veces que ve acreditables debe ser un número.'
        ]);
        validacion($validador, 'error', 'PNF');

        PNF::find($id)->update([
            'nom_pnf' => $request['nom_pnf'],
            'cod_pnf' => $request['cod_pnf'] === null ? '?' : $request['cod_pnf'],
            'trayectos' => $request['trayectos']
        ]);

        Bitacora::create([
            'usuario' => "PNF - ({$request['nom_pnf']})",
            'accion' => 'Se ha actualizado exitosamente',
            'estado' => 'info'
        ]);

        return redirect('pnfs')->with('actualizado', 'actualizado');
    }

    public function delete($id)
    {
        // Valida si tiene el permiso
        permiso('academico');

        $pnf = PNF::find($id);
        $pnf->delete();

        Bitacora::create([
            'usuario' => "PNF - ({$pnf->nom_pnf})",
            'accion' => 'Ha sido borrado',
            'estado' => 'warning'
        ]);
        return redirect()->back()->with('borrado', 'borrado');
    }
}
