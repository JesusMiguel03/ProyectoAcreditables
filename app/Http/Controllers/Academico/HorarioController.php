<?php

namespace App\Http\Controllers\Academico;

use App\Http\Controllers\Controller;
use App\Models\Academico\Horario;
use App\Models\Materia\Materia;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class HorarioController extends Controller
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
        permiso('horarios');

        $horarios = Horario::all();
        $materias = Materia::where('estado_materia', '!=', 'Inactivo')->get();

        return view('academico.horarios.index', compact('horarios', 'materias'));
    }

    public function store(Request $request)
    {
        // Valida si tiene el permiso
        permiso('horarios');

        $hora = "{$request['espacio']} {$request['edificio']} " . diaSemana($request['dia']) . ' - ' . \Carbon\Carbon::parse($request['hora'])->format('g:i A');

        // Valida los campos
        $validar = Validator::make($request->all(), [
            'espacio' => ['required', 'string', 'regex: /[a-zA-Z\s]+/', 'max:' . config('variables.horarios.espacio'),
                Rule::unique('horarios')->where(function ($query) use ($request) {
                    return $query->where('espacio', $request['espacio'])->where('edificio', $request['edificio'])->where('dia', $request['dia'])->where('hora', $request['hora']);
                })
            ],
            'edificio' => ['nullable', 'numeric', 'max:' . config('variables.horarios.edificio')],
            'dia' => ['required', 'numeric', 'digits_between:1,5'],
            'hora' => ['required', 'date_format:g:i a'],
        ], [
            'espacio.unique' => "La hora ($hora) ya ha sido registrada",
            'hora.date_format' => 'La hora no coincide con el formato 00:00 AM',
            'nom_conocimiento.required' => 'El nombre es necesario.',
            'nom_conocimiento.string' => 'El nombre debe ser una oración.',
            'nom_conocimiento.regex' => 'El nombre solo puede contener letras y espacios.',
            'nom_conocimiento.max' => 'El nombre no debe tener más de :max caracteres.',
            'desc_conocimiento.required' => 'La descripción es necesario.',
            'desc_conocimiento.string' => 'La descripción debe ser una oración.',
            'desc_conocimiento.regex' => 'La descripción solo puede contener letras y espacios.',
            'desc_conocimiento.max' => 'La descripción no debe tener más de :max caracteres.',
        ]);
        validacion($validar, 'error');

        Horario::create([
            'espacio' => $request['espacio'],
            'edificio' => $request['edificio'],
            'dia' => $request['dia'],
            'hora' => Carbon::parse($request['hora'])->format('Y-m-d H:i:s'),
        ]);
        return redirect()->back()->with('creado', 'creado');
    }

    public function edit($id)
    {
        // Valida si tiene el permiso
        permiso('horarios');

        $horario = Horario::find($id);

        // Valida que exista
        existe($horario);
        return view('academico.horarios.edit', compact('horario'));
    }

    public function update(Request $request, $id)
    {
        // Valida si tiene el permiso
        permiso('horarios');

        // Valida los campos
        $validar = Validator::make($request->all(), [
            'espacio' => ['required', 'string', 'regex: /[a-zA-Z\s]+/', 'max:' . config('variables.horarios.espacio')],
            'edificio' => ['numeric', 'max:' . config('variables.horarios.edificio')],
            'dia' => ['required', 'numeric', 'digits_between:1,5'],
            'hora' => ['required', 'date_format:g:i a'],
        ], [
            'hora.date_format' => 'La hora no coincide con el formato 00:00 AM',
            'nom_conocimiento.required' => 'El nombre es necesario.',
            'nom_conocimiento.string' => 'El nombre debe ser una oración.',
            'nom_conocimiento.regex' => 'El nombre solo puede contener letras y espacios.',
            'nom_conocimiento.max' => 'El nombre no debe tener más de :max caracteres.',
            'desc_conocimiento.required' => 'La descripción es necesario.',
            'desc_conocimiento.string' => 'La descripción debe ser una oración.',
            'desc_conocimiento.regex' => 'La descripción solo puede contener letras y espacios.',
            'desc_conocimiento.max' => 'La descripción no debe tener más de :max caracteres.',
        ]);
        validacion($validar, 'error');

        Horario::find($id)->update([
            'espacio' => $request['espacio'],
            'edificio' => $request['edificio'],
            'dia' => $request['dia'],
            'hora' => Carbon::parse($request['hora'])->format('Y-m-d H:i:s'),
        ]);

        return redirect('horarios')->with('actualizado', 'actualizado');
    }

    public function delete($id)
    {
        // Valida si tiene el permiso
        permiso('horarios');

        Horario::find($id)->delete();

        return redirect()->back()->with('borrado', 'borrado');
    }
}
