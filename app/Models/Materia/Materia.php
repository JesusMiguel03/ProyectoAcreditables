<?php

namespace App\Models\Materia;

use App\Models\Academico\Estudiante_materia;
use App\Models\Academico\Profesor;
use App\Models\Academico\Trayecto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Materia extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'materias';

    protected $fillable = ['informacion_id', 'trayecto_id', 'nom_materia', 'cupos', 'cupos_disponibles', 'desc_materia', 'imagen_materia', 'estado_materia'];

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
}
