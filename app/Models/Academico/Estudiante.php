<?php

namespace App\Models\Academico;

use App\Models\Materia\Asistencia;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estudiante extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'estudiantes';

    protected $fillable = [
        'pnf_id', 'trayecto_id', 'usuario_id'
    ];

    /**
     *  Funciones personalizadas
     */
    public function nombreEstudiante()
    {
        return $this->usuario->nombreCompleto() ?? null;
    }

    public function soloNombreEstudiante()
    {
        return $this->usuario->nombre;
    }

    public function soloApellidoEstudiante()
    {
        return $this->usuario->apellido;
    }

    public function estudianteCI()
    {
        $nacionalidad = $this->usuario->nacionalidad;
        $CI = number_format($this->usuario->cedula, 0, '', '.');
        return "{$nacionalidad}-{$CI}";
    }

    public function nombreMateria()
    {
        return $this->inscrito->materia->nom_materia ?? null;
    }

    public function nroAcreditable()
    {
        return $this->inscrito->materia->trayecto->num_trayecto ?? null;
    }

    public function nombrePNF()
    {
        return $this->pnf->nom_pnf ?? null;
    }

    /**
     *  Relaciones
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id', 'id');
    }

    public function pnf()
    {
        return $this->hasOne(PNF::class, 'id', 'pnf_id');
    }

    public function trayecto()
    {
        return $this->hasOne(Trayecto::class, 'id', 'trayecto_id');
    }

    public function inscrito()
    {
        return $this->hasMany(Estudiante_materia::class, 'estudiante_id', 'id');
    }

    public function asistencia()
    {
        return $this->belongsTo(Asistencia::class, 'id');
    }

    public function acreditables()
    {
        return $this->belongsToMany(Materia::class, 'estudiantes_materias', 'id', 'materia_id');
    }

    public function scopeCreadoEntre($query, array $fechas)
    {
        $inicio = ($fechas[0] instanceof Carbon) ? $fechas[0] : Carbon::parse($fechas[0])->startOfDay();
        $fin = ($fechas[1] instanceof Carbon) ? $fechas[1] : Carbon::parse($fechas[1])->endOfDay();

        return $query->whereBetween('created_at', [$inicio, $fin]);
    }
}
