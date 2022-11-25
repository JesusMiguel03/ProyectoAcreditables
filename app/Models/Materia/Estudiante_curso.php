<?php

namespace App\Models\Materia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante_curso extends Model
{
    use HasFactory;

    public $table = 'estudiantes_en_curso';

    public function informacion_curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id');
    }
}
