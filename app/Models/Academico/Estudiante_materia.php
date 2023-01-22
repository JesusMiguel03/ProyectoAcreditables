<?php

namespace App\Models\Academico;

use App\Models\Materia\Asistencia;
use App\Models\Materia\Materia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estudiante_materia extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'estudiantes_materias';

    protected $fillable = [
        'estudiante_id', 'nota', 'codigo', 'validado', 'materia_id', 'asistencia_id'
    ];

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
}
