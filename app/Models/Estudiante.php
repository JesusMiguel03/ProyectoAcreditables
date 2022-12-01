<?php

namespace App\Models;

use App\Models\DatosAcademicos\Estudiante_materia;
use App\Models\DatosAcademicos\Pnf;
use App\Models\DatosAcademicos\Trayecto;
use App\Models\Materia\Asistencia;
use App\Models\Materia\Materia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;

    public $table = 'estudiantes';

    protected $fillable = [
        'pnf_id', 'trayecto_id', 'usuario_id'
    ];

    public function usuarios()
    {
        return $this->belongsTo(User::class, 'usuario_id', 'id');
    }

    public function pnf()
    {
        return $this->hasOne(Pnf::class, 'id', 'pnf_id');
    }

    public function trayecto()
    {
        return $this->hasOne(Trayecto::class, 'id', 'trayecto_id');
    }

    public function preinscrito()
    {
        return $this->hasOne(Estudiante_materia::class, 'estudiante_id', 'id');
    }

    public function asistencia()
    {
        return $this->belongsTo(Asistencia::class, 'id');
    }
}
