<?php

namespace App\Http\Controllers\DatosAcademicos;

use App\Models\DatosAcademicos\Pnf;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PnfController extends Controller
{
    public function __construct()
    {
        // Validación de autenticación y permiso
        $this->middleware('auth');
        $this->middleware('can:pnf');
    }

    public function index()
    {
        // Lista todos los pnf
        $pnfs = Pnf::all();
        return view('aside.academico.pnf.index', compact('pnfs'));
    }

    public function store(Request $request)
    {
        // Valida los campos
        $validador = Validator::make($request->all(), [
            'nom_pnf' => ['required', 'string', 'max:40'],
            'cod_pnf' => ['max:6'],
        ], [
            'nom_pnf.required' => 'El campo nombre es necesario.',
            'nom_pnf.string' => 'El campo nombre debe ser una oración.',
            'cod_pnf.max' => 'El campo códogp no puede contener mas de :max carácteres.'
        ]);

        if ($validador->fails()) {
            return redirect()->back()->with('error', $validador->errors()->getMessages())->withErrors($validador)->withInput();
        }

        // Evita duplicidad
        if (Pnf::where('nom_pnf', '=', $request->get('nom_pnf'))->first()) {
            return redirect('pnf')->with('registrado', 'registrado');
        }

        // Guarda el pnf
        Pnf::create([
            'nom_pnf' => $request->get('nom_pnf'),
            'cod_pnf' => $request->get('cod_pnf') === null ? '?' : $request->get('cod_pnf')
        ]);

        return redirect('pnf')->with('creado', 'creado');
    }

    public function edit($id)
    {
        // Trea el pnf correspondiente
        $pnf = Pnf::find($id);
        return view('aside.academico.pnf.edit', compact('pnf'));
    }

    public function update(Request $request, $id)
    {
        // Valida los campos
        $validador = Validator::make($request->all(), [
            'nom_pnf' => ['required', 'string', 'max:40'],
            'cod_pnf' => ['max:6'],
        ], [
            'nom_pnf.required' => 'El campo nombre es necesario.',
            'nom_pnf.string' => 'El campo nombre debe ser una oración.',
            'cod_pnf.max' => 'El campo códogp no puede contener mas de :max carácteres.'
        ]);

        if ($validador->fails()) {
            return redirect()->back()->with('error', $validador->errors()->getMessages())->withErrors($validador)->withInput();
        }

        // Busca y actualiza
        Pnf::find($id)->update([
            'nom_pnf' => $request->get('nom_pnf'), 
            'cod_pnf' => $request->get('cod_pnf') === null ? '?' : $request->get('cod_pnf')
        ]);

        return redirect('pnf')->with('actualizado', 'actualizado');
    }
}
