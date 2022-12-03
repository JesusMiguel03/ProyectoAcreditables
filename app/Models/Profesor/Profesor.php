<?php

namespace App\Models\Profesor;

use App\Models\DatosAcademicos\Pnf;
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
        'conocimiento_id',
        'casa',
        'calle',
        'urb',
        'ciudad',
        'estado',
        'fecha_de_nacimiento',
        'fecha_ingreso_institucion',
        'departamento_id',
        'estado_profesor'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id', 'id');
    }

    public function conocimiento()
    {
        return $this->belongsTo(Especialidad::class, 'conocimiento_id', 'id');
    }

    public function departamento()
    {
        return $this->belongsTo(Pnf::class, 'departamento_id', 'id');
    }
}
