<?php

namespace App\Models\Materia;

use App\Models\Academico\Estudiante_materia;
use App\Models\Academico\Horario;
use App\Models\Academico\Periodo;
use App\Models\Academico\Profesor;
use App\Models\Academico\Trayecto;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Materia extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'materias';

    protected $fillable = ['informacion_id', 'trayecto_id', 'nom_materia', 'cupos', 'cupos_disponibles', 'desc_materia', 'imagen_materia', 'estado_materia'];

    /**
     *  Funciones personalizadas
     */
    public function infoCategoria()
    {
        return $this->info->categoria ?? null;
    }

    public function infoTipo()
    {
        $metodologia = $this->info->metodologia ?? null;

        $metodologias = [0 => 'Teórico', 1 => 'Práctico', 2 => 'Teórico-Práctico', null => 'Sin asignar'];

        return $metodologias[$metodologia];
    }

    public function infoAcreditable()
    {
        return $this->trayecto->num_trayecto ?? null;
    }

    public function profesorEncargado()
    {
        return $this->info->profesor ?? null;
    }

    public function nombreProfesorEncargado()
    {
        return !empty($this->info->profesor) ? $this->info->profesor->nombreProfesor() : null;
    }

    public function estudiantesPeriodo($id)
    {
        $periodo = Periodo::find($id);
        $estudiantes = $this->estudiantes;

        $estudiantesPeriodo = [];

        foreach ($estudiantes as $estudiante) {
            if ($estudiante->periodo_id === $periodo->id) {
                array_push($estudiantesPeriodo, $estudiante);
            }
        }

        return $estudiantesPeriodo;
    }

    public function estudiantesPeriodoActual()
    {
        $periodo = periodo('modelo')->id ?? null;
        $estudiantes = $this->estudiantes;

        $inscritos = [];

        foreach ($estudiantes as $estudiante) {
            if ($estudiante->periodo_id === $periodo) {
                array_push($inscritos, $estudiante);
            }
        }

        return $inscritos;
    }

    public function actualizarCupos()
    {
        $this->update([
            'cupos_disponibles' => $this->cupos - count($this->estudiantesPeriodoActual())
        ]);
    }

    /**
     *  Relaciones
     */
    public function info()
    {
        return $this->hasOne(Informacion_materia::class, 'id', 'informacion_id');
    }

    public function estudiantes()
    {
        return $this->hasMany(Estudiante_materia::class, 'materia_id', 'id');
    }

    public function profesor()
    {
        return $this->hasOne(Profesor::class, 'id', 'profesor_id');
    }

    public function trayecto()
    {
        return $this->hasOne(Trayecto::class, 'id', 'trayecto_id');
    }

    public function horario()
    {
        return $this->belongsTo(Horario::class, 'id', 'materia_id');
    }

    public function scopeCreadoEntre($query, array $fechas)
    {
        $inicio = ($fechas[0] instanceof Carbon) ? $fechas[0] : Carbon::parse($fechas[0])->startOfDay();
        $fin = ($fechas[1] instanceof Carbon) ? $fechas[1] : Carbon::parse($fechas[1])->endOfDay();

        return $query->whereBetween('created_at', [$inicio, $fin]);
    }
}
