<?php

namespace App\Models\Academico;

use App\Models\Materia\Materia;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Trayecto extends Model
{
    use HasFactory, SoftDeletes;

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

    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class, 'trayecto_id');
    }

    public function scopeCreadoEntre($query, array $fechas)
    {
        $inicio = ($fechas[0] instanceof Carbon) ? $fechas[0] : Carbon::parse($fechas[0])->startOfDay();
        $fin = ($fechas[1] instanceof Carbon) ? $fechas[1] : Carbon::parse($fechas[1])->endOfDay();

        return $this->estudiantes()->whereBetween('created_at', [$inicio, $fin]);
    }
}
