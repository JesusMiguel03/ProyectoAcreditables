<?php

namespace App\Models\Profesor;

use App\Models\Materia\Area_conocimiento;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    use HasFactory;

    public $table = 'profesores';

    protected $fillable = [
        'usuario_id',
        'telefono',
        'titulo',
        'casa',
        'calle',
        'urb',
        'ciudad',
        'estado',
        'fecha_de_nacimiento',
        'fecha_ingreso_institucion',
        'estado_profesor'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id', 'id');
    }

    public function especialidades()
    {
        return $this->belongsToMany(Especialidad::class, 'profesor_especialidad', 'profesor_id', 'especialidad_id');
    }

    public function areas_conocimiento()
    {
        return $this->belongsToMany(Area_conocimiento::class, 'profesor_especialidad', 'profesor_id', 'area_conocimiento_id');
    }
}
