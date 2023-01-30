<?php

namespace App\Models\Academico;

use App\Models\Materia\Informacion_materia;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profesor extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'profesores';

    protected $fillable = [
        'usuario_id',
        'conocimiento_id',
        'departamento_id',
        'telefono',
        'casa',
        'calle',
        'urb',
        'ciudad',
        'estado',
        'fecha_de_nacimiento',
        'fecha_ingreso_institucion',
        'activo'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id', 'id');
    }

    public function conocimiento()
    {
        return $this->belongsTo(AreaConocimiento::class, 'conocimiento_id', 'id');
    }

    public function departamento()
    {
        return $this->belongsTo(Pnf::class, 'departamento_id', 'id');
    }

    public function imparteMateria()
    {
        return $this->hasMany(Informacion_materia::class, 'profesor_id', 'id');
    }
}
