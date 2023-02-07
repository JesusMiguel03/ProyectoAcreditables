<?php

namespace App\Http\Controllers\Academico;

use App\Http\Controllers\Controller;
use App\Models\Academico\Horario;
use App\Models\Materia\Materia;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

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
        $materias = Materia::whereDoesntHave('horario')->get();
        // Materia::where('estado_materia', '!=', 'Inactivo')->get();
        
        return view('academico.horarios.index', compact('horarios', 'materias'));
    }

    public function store(Request $request)
    {
        // Valida si tiene el permiso
        permiso('horarios');

        $espacio = "{$request['espacio']} {$request['edificio']} " . diaSemana($request['dia']) . ' - ' . \Carbon\Carbon::parse($request['hora'])->format('g:i A');

        // Valida los campos
        $validar = Validator::make($request->all(), [
            'espacio' => ['required', 'string', 'regex: /[a-zA-Z\s]+/', 'max:' . config('variables.horarios.espacio'),
                Rule::unique('horarios')->where(function ($query) use ($request) {
                    return $query->where('espacio', $request['espacio'])->where('edificio', $request['edificio'])->where('hora', $request['hora']);
                })
            ],
            'edificio' => ['nullable', 'numeric', 'max:' . config('variables.horarios.edificio')],
            'materia_id' => ['required', 'not_in:0']
        ], [
            'espacio.unique' => "El espacio ($espacio) ya ha sido registrado",
            'hora.date_format' => 'La hora no coincide con el formato 00:00 AM',
            'materia_id.not_in' => 'Debe escoger al menos 1 materia de la lista.',
        ]);
        validacion($validar, 'error');

        Horario::create([
            'materia_id' => $request['materia_id'],
            'espacio' => $request['espacio'],
            'edificio' => $request['edificio'],
            'dia' => $request['dia'],
            'hora' => Carbon::parse($request['hora'])->format('Y-m-d H:i:s'),
            'campo' => $request['campo']
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

        if (!empty($request['actualizar'])) {
            if ($request['actualizar'] === 'sinHora') {
                $validar = Validator::make($request->all(), [
                    'espacio' => ['required', 'string', 'regex: /[a-zA-Z\s]+/', 'max:' . config('variables.horarios.espacio')],
                    'edificio' => ['numeric', 'max:' . config('variables.horarios.edificio')],
                ], [
                    'espacio.required' => 'El nombre del espacio es necesario.',
                    'espacio.string' => 'El nombre del espacio debe ser una oración.',
                    'espacio.regex' => 'El nombre del espacio solo debe contener letras.',
                    'espacio.max' => 'El nombre del espacio no debe tener más de :max carácteres.',
                    'edificio.numeric' => 'El aula debe ser un número.',
                    'edificio.max' => 'El aula no debe ser mayor a :max.',
                ]);
                validacion($validar, 'error');
    
                Horario::find($id)->update([
                    'espacio' => $request['espacio'],
                    'edificio' => $request['edificio'],
                ]);
            } else if ($request['actualizar'] === 'conHora') {
                Horario::find($id)->update([
                    'dia' => $request['diaActualizar'],
                    'hora' => Carbon::parse($request['horaActualizar'])->format('Y-m-d H:i:s'),
                    'campo' => $request['campoActualizar'],
                ]);
            }
        } else {
            return redirect()->back();
        }

        return redirect('horarios')->with('actualizado', 'actualizado');
    }

    public function delete($id)
    {
        // Valida si tiene el permiso
        permiso('horarios');

        Horario::find($id)->delete();

        return redirect()->back()->with('borrado', 'borrado');
    }

    public function pdf() {
        $horarios = Horario::all();

        // return view('academico.pdf.horario', ['horarios' => $horarios]);
        $pdf = FacadePdf::loadView('academico.pdf.horario', ['horarios' => $horarios])->setPaper('a4', 'landscape');

        return $pdf->stream('Horario.pdf');
    }
}
