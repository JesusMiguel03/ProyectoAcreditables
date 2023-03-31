<?php

namespace App\Models\Academico;

use App\Models\Materia\Materia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Horario extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['periodo_id', 'materia_id', 'espacio', 'aula', 'dia', 'hora', 'campo'];

    public function nombreMateria()
    {
        return $this->materia->nom_materia;
    }

    public function materia()
    {
        return $this->hasOne(Materia::class, 'id', 'materia_id');
    }

    public function periodo()
    {
        return $this->belongsTo(Periodo::class, 'id', 'periodo_id');
    }

    public function horarioEstructurado()
    {
        $diaSemana = [
            0 => 'Lunes',
            1 => 'Martes',
            2 => 'Miércoles',
            3 => 'Jueves',
            4 => 'Viernes'
        ];

        $dia = $diaSemana[$this->dia];
        $hora = \Carbon\Carbon::parse($this->hora)->format('g:i A');
        $ubicacion = "$this->espacio $this->aula";

        if (empty($dia)) {
            return null;
        }

        return "{$dia} - {$hora} ({$ubicacion})";
    }

    public function scopeCreadoEntre($query, array $fechas)
    {
        $inicio = ($fechas[0] instanceof Carbon) ? $fechas[0] : Carbon::parse($fechas[0])->startOfDay();
        $fin = ($fechas[1] instanceof Carbon) ? $fechas[1] : Carbon::parse($fechas[1])->endOfDay();

        return $query->whereBetween('created_at', [$inicio, $fin]);
    }
}
