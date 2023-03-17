<?php

namespace App\Http\Controllers\Academico;

use App\Http\Controllers\Controller;
use App\Models\Academico\Horario;
use App\Models\Informacion\Bitacora;
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

        $periodo = periodo('modelo');
        $inicio = $periodo->inicio ?? null;
        $fin = $periodo->fin ?? null;

        $horarios = Horario::all();

        $materias = Materia::whereDoesntHave('horario')->get();

        return view('academico.horarios.index', compact('horarios', 'materias'));
    }

    public function store(Request $request)
    {
        // Valida si tiene el permiso
        permiso('horarios');

        $espacio = "{$request['espacio']} {$request['aula']} " . diaSemana($request['dia']) . ' - ' . \Carbon\Carbon::parse($request['hora'])->format('g:i A');

        // Valida los campos
        $validar = Validator::make($request->all(), [
            'espacio' => [
                'required', 'string', 'regex: /[a-zA-Z\s]+/', 'max:' . config('variables.horarios.espacio'),
                Rule::unique('horarios')->where(function ($query) use ($request) {
                    return $query->where('espacio', $request['espacio'])->where('aula', $request['aula'])->where('campo', $request['campo'])->where('deleted_at');
                })
            ],
            'aula' => ['nullable', 'numeric', 'max:' . config('variables.horarios.aula')],
            'materia_id' => ['required', 'not_in:0']
        ], [
            'espacio.unique' => "El espacio ($espacio) ya ha sido registrado",
            'hora.date_format' => 'La hora no coincide con el formato 00:00 AM',
            'materia_id.not_in' => 'Debe escoger al menos 1 materia de la lista.',
        ]);
        validacion($validar, 'error', 'Horario');

        $materia = Materia::find($request['materia_id']);
        $hora = Carbon::parse($request['hora'])->format('Y-m-d H:i:s');

        Horario::create([
            'periodo_id' => periodo('modelo')->id ?? null,
            'materia_id' => $request['materia_id'],
            'espacio' => $request['espacio'],
            'aula' => $request['aula'],
            'dia' => $request['dia'],
            'hora' => $hora,
            'campo' => $request['campo']
        ]);

        Bitacora::create([
            'usuario' => "Horario {$materia->nom_materia} {$hora}",
            'accion' => 'Se ha registrado exitosamente',
            'estado' => 'success'
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
            $horario = Horario::find($id);

            if ($request['actualizar'] === 'sinHora') {

                $espacio = "{$request['espacio']} {$request['aula']} " . diaSemana($horario['dia']) . ' - ' . \Carbon\Carbon::parse($horario['hora'])->format('g:i A');

                $validar = Validator::make($request->all(), [
                    'espacio' => [
                        'required', 'string', 'regex: /[a-zA-Z\s]+/', 'max:' . config('variables.horarios.espacio'),
                        Rule::unique('horarios')->where(function ($query) use ($request, $horario) {
                            return $query->where('espacio', $request['espacio'])->where('aula', $request['aula'])->where('campo', $horario['campo']);
                        })
                    ],
                    'aula' => ['numeric', 'max:' . config('variables.horarios.aula')],
                ], [
                    'espacio.unique' => "El espacio ($espacio) ya ha sido registrado",
                    'espacio.required' => 'El nombre del espacio es necesario.',
                    'espacio.string' => 'El nombre del espacio debe ser una oración.',
                    'espacio.regex' => 'El nombre del espacio solo debe contener letras.',
                    'espacio.max' => 'El nombre del espacio no debe tener más de :max carácteres.',
                    'aula.numeric' => 'El aula debe ser un número.',
                    'aula.max' => 'El aula no debe ser mayor a :max.',
                ]);
                validacion($validar, 'error', 'Horario');

                $horario->update([
                    'espacio' => $request['espacio'],
                    'aula' => $request['aula'],
                ]);

            } else if ($request['actualizar'] === 'conHora') {

                $horario->update([
                    'dia' => $request['diaActualizar'],
                    'hora' => Carbon::parse($request['horaActualizar'])->format('Y-m-d H:i:s'),
                    'campo' => $request['campoActualizar'],
                ]);
            }

            $materia = Materia::find($horario->materia_id);

            Bitacora::create([
                'usuario' => "Horario - ({$materia->nom_materia})",
                'accion' => 'Se ha actualizado exitosamente',
                'estado' => 'success'
            ]);

        } else {
            return redirect()->back();
        }

        return redirect('horarios')->with('actualizado', 'actualizado');
    }

    public function delete($id)
    {
        // Valida si tiene el permiso
        permiso('horarios');

        $horario = Horario::find($id);
        $materia = Materia::find($horario->materia_id);

        $horario->delete();

        Bitacora::create([
            'usuario' => "Horario de {$materia->nom_materia}",
            'accion' => 'Ha sido borrado',
            'estado' => 'warning'
        ]);

        return redirect(route('horarios.index'))->with('borrado', 'borrado');
    }

    public function pdf()
    {
        $horarios = Horario::all();

        $pdf = FacadePdf::loadView('academico.pdf.horario', ['horarios' => $horarios])->setPaper('a4', 'landscape');

        return $pdf->stream('Horario.pdf');
    }

    public function vaciar()
    {
        $horarios = Horario::all();

        foreach ($horarios as $horario) {
            $horario->delete();
        }

        Bitacora::create([
            'usuario' => "Horario general",
            'accion' => 'Ha sido vaciado',
            'estado' => 'warning'
        ]);

        return redirect()->back();
    }
}
