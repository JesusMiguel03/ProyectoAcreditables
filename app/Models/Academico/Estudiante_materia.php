<?php

namespace App\Models\Academico;

use App\Models\Materia\Asistencia;
use App\Models\Materia\Materia;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estudiante_materia extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'estudiantes_materias';

    protected $fillable = [
        'periodo_id', 'estudiante_id', 'nota', 'codigo', 'validado', 'materia_id', 'asistencia_id', 'aprobado'
    ];

    /**
     *  Funciones personalizadas
     */
    public function inscritoNombre()
    {
        return $this->esEstudiante->usuario->nombreCompleto() ?? null;
    }

    public function inscritoSoloNombre()
    {
        return $this->esEstudiante->usuario->nombre ?? null;
    }

    public function inscritoSoloApellido()
    {
        return $this->esEstudiante->usuario->apellido ?? null;
    }

    public function inscritoCI()
    {
        return $this->esEstudiante->estudianteCI() ?? null;
    }

    public function inscritoPNF()
    {
        return $this->esEstudiante->pnf ?? null;
    }

    public function inscritoPNFNombre()
    {
        return $this->esEstudiante->pnf->nom_pnf ?? null;
    }

    public function inscritoTrayecto()
    {
        return $this->esEstudiante->trayecto ?? null;
    }

    public function inscritoTrayectoNumero()
    {
        return $this->esEstudiante->trayecto->num_trayecto ?? null;
    }

    public function inscritoProfesor()
    {
        return $this->materia->profesorEncargado() ?? null;
    }

    public function tieneProfesor()
    {
        return $this->materia->info->profesor->id ?? null;
    }

    public function inscritoNombreMateria()
    {
        return $this->materia->nom_materia ?? null;
    }

    public function inscritoAcreditable($info)
    {
        if ($info === 'nro') $info = 'trayecto_id';
        if ($info === 'nombre') $info = 'nom_materia';

        return $this->materia->$info ?? null;
    }

    public function aprobado()
    {
        $inscripcion = $this->aprobo();
        $nota = $inscripcion[0];
        $asistencia = $inscripcion[1];

        return $nota > 55 && $asistencia > 74;
    }

    public function aprobo()
    {
        $nota = $this->nota;
        $asistencias = 0;

        $asistencia = $this->asistencia;

        for ($i = 1; $i <= 12; $i++) {
            $sem = 'sem' . $i;
            $asistencia[$sem] === 1 ? $asistencias++ : '';
        }

        $asistencias = ($asistencias * 833) / 100;

        return [$nota, round($asistencias, 0, PHP_ROUND_HALF_UP)];
    }

    public function estaAprobado()
    {
        $informacion = $this->aprobo();
        $nota = $informacion[0];
        $asistencia = $informacion[1];

        return $nota >= 56 && $asistencia >= 75;
    }

    public function inscribirSiguienteAcreditable()
    {
        $periodo = Periodo::whereRaw('? between inicio and fin', Carbon::parse($this->created_at)->format('Y-m-d'))->first() ?? false;
        
        $periodoActualFecha = explode('-', periodo())[1];

        return $periodo
            ? $periodo->fase >= 1 && $periodoActualFecha >= Carbon::parse($periodo->inicio)->format('Y')
            : false;
    }

    public function repiteAcreditable()
    {
        $periodo = Periodo::whereRaw('? between inicio and fin', Carbon::parse($this->created_at)->format('Y-m-d'))->first() ?? false;

        return $periodo->formato() !== periodo();
    }

    public function periodoInscripcion()
    {
        return Periodo::whereRaw('? between inicio and fin', Carbon::parse($this->created_at)->format('Y-m-d'))->first() ?? null;
    }

    /**
     *  Relaciones
     */
    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id', 'id');
    }

    public function esEstudiante()
    {
        return $this->hasOne(Estudiante::class, 'id', 'estudiante_id');
    }

    public function asistencia()
    {
        return $this->hasOne(Asistencia::class, 'id', 'asistencia_id');
    }

    public function periodo()
    {
        return $this->belongsTo(Periodo::class, 'periodo_id', 'id');
    }

    public function scopeCreadoEntre($query, array $fechas)
    {
        $inicio = ($fechas[0] instanceof Carbon) ? $fechas[0] : Carbon::parse($fechas[0])->startOfDay();
        $fin = ($fechas[1] instanceof Carbon) ? $fechas[1] : Carbon::parse($fechas[1])->endOfDay();

        return $this->whereBetween('created_at', [$inicio, $fin]);
    }
}
