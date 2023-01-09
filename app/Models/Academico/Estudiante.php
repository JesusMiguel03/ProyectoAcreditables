<?php

namespace App\Models\Academico;

use App\Models\Materia\Asistencia;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estudiante extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'estudiantes';

    protected $fillable = [
        'pnf_id', 'trayecto_id', 'usuario_id'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id', 'id');
    }

    public function pnf()
    {
        return $this->hasOne(PNF::class, 'id', 'pnf_id');
    }

    public function trayecto()
    {
        return $this->hasOne(Trayecto::class, 'id', 'trayecto_id');
    }

    public function inscrito()
    {
        return $this->hasOne(Estudiante_materia::class, 'estudiante_id', 'id');
    }

    public function asistencia()
    {
        return $this->belongsTo(Asistencia::class, 'id');
    }
}
