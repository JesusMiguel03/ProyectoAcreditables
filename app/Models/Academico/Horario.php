<?php

namespace App\Models\Academico;

use App\Models\Materia\Materia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Horario extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['materia_id', 'espacio', 'aula', 'dia', 'hora', 'campo'];

    public function materia()
    {
        return $this->hasOne(Materia::class, 'id', 'materia_id');
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
}
