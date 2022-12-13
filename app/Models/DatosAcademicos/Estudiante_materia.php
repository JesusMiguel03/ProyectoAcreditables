<?php

namespace App\Models\DatosAcademicos;

use App\Models\Estudiante;
use App\Models\Materia\Materia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante_materia extends Model
{
    use HasFactory;

    public $table = 'estudiantes_materias';

    protected $fillable = [
        'estudiante_id', 'calificacion', 'codigo', 'validacion_estudiante','materia_id', 'asistencia_id'
    ];

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id', 'id');
    }

    public function estudiante()
    {
        return $this->hasMany(Estudiante::class, 'id', 'estudiante_id');
    }
}
