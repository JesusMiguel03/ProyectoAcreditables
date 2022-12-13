<?php

namespace App\Models\Materia;

use App\Models\DatosAcademicos\Estudiante_materia;
use App\Models\Profesor\Profesor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;

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
}
