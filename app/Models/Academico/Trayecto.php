<?php

namespace App\Models\Academico;

use App\Models\Materia\Materia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trayecto extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $tables = 'trayectos';

    protected $fillable = ['num_trayecto'];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'trayecto_id');
    }

    public function materias()
    {
        return $this->hasMany(Materia::class, 'trayecto_id');
    }
}